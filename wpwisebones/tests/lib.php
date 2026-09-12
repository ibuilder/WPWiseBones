<?php
/**
 * Minimal assertion helpers for the theme's integration tests.
 *
 * No PHPUnit: the theme has no Composer dependency chain and these tests run
 * against a real WordPress bootstrap, so a few functions are enough.
 */

$GLOBALS['wpwisebones_test'] = array( 'pass' => 0, 'fail' => 0, 'notices' => array() );

/**
 * Record every PHP diagnostic raised while a test runs, so a notice is a
 * failure rather than something that scrolls past.
 */
function wpwisebones_test_capture_notices() {
	set_error_handler(
		function ( $no, $str, $file, $line ) {
			$GLOBALS['wpwisebones_test']['notices'][] = $str . '  (' . $file . ':' . $line . ')';
			return true;
		}
	);
}

function wpwisebones_test_group( $name ) {
	echo "\n  " . $name . "\n";
}

function wpwisebones_test_check( $label, $condition ) {
	if ( $condition ) {
		$GLOBALS['wpwisebones_test']['pass']++;
	} else {
		$GLOBALS['wpwisebones_test']['fail']++;
	}
	printf( "    [%s] %s\n", $condition ? 'PASS' : 'FAIL', $label );
	return (bool) $condition;
}

function wpwisebones_test_fatal( $message ) {
	fwrite( STDERR, "    FATAL: " . $message . "\n" );
	exit( 3 );
}

/**
 * Print the notice tally and exit non-zero if anything failed.
 */
function wpwisebones_test_finish() {
	$t = $GLOBALS['wpwisebones_test'];
	if ( $t['notices'] ) {
		wpwisebones_test_group( 'PHP diagnostics' );
		wpwisebones_test_check( 'no notices or warnings raised', false );
		foreach ( $t['notices'] as $n ) {
			echo "        ! " . $n . "\n";
		}
	} else {
		wpwisebones_test_group( 'PHP diagnostics' );
		wpwisebones_test_check( 'no notices or warnings raised', true );
	}
	$t = $GLOBALS['wpwisebones_test'];
	printf( "\n  %d passed, %d failed\n", $t['pass'], $t['fail'] );
	exit( $t['fail'] > 0 ? 1 : 0 );
}

/**
 * Bootstrap WordPress for a single test file. The theme must already be the
 * active theme - tests/run.php activates it before invoking each file.
 */
function wpwisebones_test_bootstrap() {
	$wp_root = getenv( 'WPWISEBONES_TEST_WP' );
	if ( ! $wp_root || ! file_exists( $wp_root . '/wp-load.php' ) ) {
		wpwisebones_test_fatal( 'WPWISEBONES_TEST_WP is not a WordPress root. Run tests via: php tests/run.php' );
	}
	wpwisebones_test_capture_notices();
	if ( ! defined( 'WP_USE_THEMES' ) ) {
		define( 'WP_USE_THEMES', false );
	}
	require_once $wp_root . '/wp-load.php';
	defined( 'ABSPATH' ) || wpwisebones_test_fatal( 'WordPress did not load' );
	if ( get_option( 'stylesheet' ) !== 'wpwisebones' ) {
		wpwisebones_test_fatal( 'wpwisebones is not the active theme (' . get_option( 'stylesheet' ) . ')' );
	}
}
