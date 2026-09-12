<?php
/**
 * Integration test runner for the WPWiseBones theme.
 *
 * Installs this working copy of the theme into a WordPress install, activates
 * it, runs each tests/test-*.php file in its own PHP process, then restores
 * the original theme and removes the copy - including on fatal error.
 *
 * Usage:  php tests/run.php
 *         WPWISEBONES_TEST_WP=/path/to/wordpress php tests/run.php
 *
 * The host install is only borrowed: nothing is written to its database
 * except the active-theme option, which is put back afterwards.
 */

if ( PHP_SAPI !== 'cli' ) {
	fwrite( STDERR, "tests/run.php is a CLI script." . PHP_EOL );
	exit( 3 );
}

$theme_src  = dirname( __DIR__ );
$theme_slug = basename( $theme_src );

/* -- Locate WordPress -------------------------------------------------- */
$candidates = array_filter( array(
	getenv( 'WPWISEBONES_TEST_WP' ),
	'C:/Server/wplinkedin/.wp-sandbox',
	dirname( $theme_src, 3 ),   // wp-content/themes/<theme> -> WP root
) );

$wp_root = '';
foreach ( $candidates as $candidate ) {
	$candidate = rtrim( str_replace( DIRECTORY_SEPARATOR, '/', $candidate ), '/' );
	if ( $candidate && file_exists( $candidate . '/wp-load.php' ) ) {
		$wp_root = $candidate;
		break;
	}
}
if ( ! $wp_root ) {
	fwrite( STDERR, "No WordPress install found." . PHP_EOL
		. "Set WPWISEBONES_TEST_WP to a WordPress root and re-run." . PHP_EOL );
	exit( 3 );
}

$theme_dest      = $wp_root . '/wp-content/themes/' . $theme_slug;
$installed_by_us = false;
$original_theme  = '';

/* -- Helpers ------------------------------------------------------------ */
function wpwisebones_test_wp_eval( $wp_root, $code ) {
	$snippet = "define('WP_USE_THEMES',false); require "
		. var_export( $wp_root . '/wp-load.php', true ) . '; ' . $code;
	$cmd = escapeshellarg( PHP_BINARY ) . ' -r ' . escapeshellarg( $snippet ) . ' 2>&1';
	exec( $cmd, $out, $code_rc );
	return array( trim( (string) end( $out ) ), $code_rc, $out );
}

function wpwisebones_test_rcopy( $src, $dst ) {
	@mkdir( $dst, 0777, true );
	$iter = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $src, FilesystemIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::SELF_FIRST
	);
	foreach ( $iter as $item ) {
		$target = $dst . '/' . $iter->getSubPathName();
		if ( $item->isDir() ) {
			@mkdir( $target, 0777, true );
		} else {
			copy( $item->getPathname(), $target );
		}
	}
}

function wpwisebones_test_rdelete( $dir ) {
	if ( ! is_dir( $dir ) ) {
		return;
	}
	$iter = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::CHILD_FIRST
	);
	foreach ( $iter as $item ) {
		if ( $item->isDir() ) {
			@rmdir( $item->getPathname() );
		} else {
			@unlink( $item->getPathname() );
		}
	}
	@rmdir( $dir );
}

/**
 * Put the host install back as it was. Registered as a shutdown function so
 * an exit() or a fatal inside a test still restores it.
 */
function wpwisebones_test_restore() {
	global $wp_root, $theme_dest, $installed_by_us, $original_theme;
	if ( $original_theme ) {
		wpwisebones_test_wp_eval( $wp_root, 'switch_theme(' . var_export( $original_theme, true ) . ');' );
	}
	if ( $installed_by_us ) {
		wpwisebones_test_rdelete( $theme_dest );
	}
	if ( $original_theme ) {
		echo PHP_EOL . "  host restored: active theme '" . $original_theme . "'"
			. ( $installed_by_us ? ', test copy removed' : '' ) . PHP_EOL;
	}
}

/* -- Set up -------------------------------------------------------------- */
echo "WPWiseBones integration tests" . PHP_EOL;
echo "  WordPress: " . $wp_root . PHP_EOL;
echo "  Theme:     " . $theme_src . PHP_EOL;

list( $probe, $rc, $raw ) = wpwisebones_test_wp_eval(
	$wp_root,
	"echo get_option('stylesheet'), '|', get_bloginfo('version');"
);
if ( 0 !== $rc || '' === $probe ) {
	fwrite( STDERR, "Could not bootstrap WordPress:" . PHP_EOL . implode( PHP_EOL, (array) $raw ) . PHP_EOL );
	exit( 3 );
}
list( $original_theme, $wp_version ) = array_pad( explode( '|', $probe ), 2, '' );
echo "  WP version: " . $wp_version . PHP_EOL;
echo "  Theme active before run: " . $original_theme . PHP_EOL;

register_shutdown_function( 'wpwisebones_test_restore' );

if ( realpath( $theme_dest ) !== realpath( $theme_src ) ) {
	if ( is_dir( $theme_dest ) ) {
		$original_theme = '';   // nothing changed yet - suppress the restore
		fwrite( STDERR, "Refusing to overwrite an existing theme at " . $theme_dest . PHP_EOL );
		exit( 3 );
	}
	wpwisebones_test_rcopy( $theme_src, $theme_dest );
	$installed_by_us = true;
}

list( $now ) = wpwisebones_test_wp_eval(
	$wp_root,
	'switch_theme(' . var_export( $theme_slug, true ) . "); echo get_option('stylesheet');"
);
if ( $now !== $theme_slug ) {
	fwrite( STDERR, "Could not activate the theme (got '" . $now . "')" . PHP_EOL );
	exit( 3 );
}

/* -- Run ----------------------------------------------------------------- */
putenv( 'WPWISEBONES_TEST_WP=' . $wp_root );   // inherited by the child processes

$files  = glob( __DIR__ . '/test-*.php' );
sort( $files );
$failed = 0;

foreach ( $files as $file ) {
	$rule = str_repeat( '-', 62 );
	echo PHP_EOL . $rule . PHP_EOL . basename( $file ) . PHP_EOL . $rule . PHP_EOL;
	passthru( escapeshellarg( PHP_BINARY ) . ' ' . escapeshellarg( $file ), $code );
	if ( 0 !== $code ) {
		$failed++;
	}
}

echo PHP_EOL . str_repeat( '=', 62 ) . PHP_EOL;
printf( '%d file(s) run, %d failed' . PHP_EOL, count( $files ), $failed );
exit( $failed > 0 ? 1 : 0 );
