<?php
/**
 * Every asset the theme enqueues must come from the bundled local vendor
 * directory - WP.org Guideline 8 forbids remote CDN assets.
 *
 * This is what makes the dashboard widget's "Local vendor" label truthful
 * rather than merely hard-coded, so the two tests belong together.
 */

require_once __DIR__ . '/lib.php';
wpwisebones_test_bootstrap();

do_action( 'wp_enqueue_scripts' );

$home  = home_url();
$rows  = array();
$pairs = array( 'style' => wp_styles(), 'script' => wp_scripts() );
foreach ( $pairs as $kind => $reg ) {
	foreach ( $reg->queue as $handle ) {
		$src = isset( $reg->registered[ $handle ] ) ? $reg->registered[ $handle ]->src : '';
		if ( $src ) {
			$rows[] = array( $kind, $handle, $src );
		}
	}
}

echo "\n  Enqueued assets\n";
foreach ( $rows as $r ) {
	printf( "    %-7s %-20s %s\n", $r[0], $r[1], $r[2] );
}

wpwisebones_test_group( 'Nothing is loaded remotely' );
$external = array();
foreach ( $rows as $r ) {
	if ( preg_match( '#^(https?:)?//#', $r[2] ) && 0 !== strpos( $r[2], $home ) ) {
		$external[] = $r[1] . ' -> ' . $r[2];
	}
}
wpwisebones_test_check( 'no asset served from an external host', empty( $external ) );
foreach ( $external as $e ) {
	echo "        ! " . $e . "\n";
}

$cdn = 0;
foreach ( $rows as $r ) {
	if ( preg_match( '#jsdelivr|cdnjs|unpkg|bootstrapcdn|googleapis#i', $r[2] ) ) {
		$cdn++;
	}
}
wpwisebones_test_check( 'no known CDN host appears in any src', 0 === $cdn );

wpwisebones_test_group( 'Bootstrap comes from assets/vendor' );
$src_of = function ( $kind, $handle ) use ( $rows ) {
	foreach ( $rows as $r ) {
		if ( $r[0] === $kind && $r[1] === $handle ) {
			return $r[2];
		}
	}
	return '';
};
foreach ( array( 'bootstrap', 'bootstrap-icons' ) as $handle ) {
	$src = $src_of( 'style', $handle );
	wpwisebones_test_check( "style '{$handle}' from /assets/vendor", $src && false !== strpos( $src, '/assets/vendor' ) );
}
$js = $src_of( 'script', 'bootstrap' );
wpwisebones_test_check( 'Bootstrap JS bundle from /assets/vendor', $js && false !== strpos( $js, '/assets/vendor' ) );

wpwisebones_test_group( 'The vendored files actually exist' );
$dir = get_template_directory();
foreach ( array(
	'/assets/vendor/css/bootstrap.min.css',
	'/assets/vendor/css/bootstrap-icons.min.css',
	'/assets/vendor/js/bootstrap.bundle.min.js',
) as $rel ) {
	wpwisebones_test_check( 'on disk: ' . $rel, file_exists( $dir . $rel ) );
}

wpwisebones_test_finish();
