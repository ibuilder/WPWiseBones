<?php
/**
 * Renders the real theme templates and shortcode callbacks to static HTML so
 * the documentation site can be screenshotted from actual project code.
 *
 * Usage: php render.php <out-dir> [all|shortcodes|themes]
 *
 * @package WPWiseBones\Tools
 */

require __DIR__ . '/wp-stub.php';
define( 'OBJECT', 'OBJECT' );
require __DIR__ . '/sample-data.php';

$repo    = dirname( __DIR__, 2 );
$out_dir = isset( $argv[1] ) ? rtrim( $argv[1], '/' ) : __DIR__ . '/build';
$target  = isset( $argv[2] ) ? $argv[2] : 'all';

@mkdir( $out_dir . '/img', 0777, true );
$ph = wpb_placeholders( $out_dir . '/img' );

if ( in_array( $target, array( 'all', 'themes' ), true ) ) {
	foreach ( array( 'wpwisebones', 'realwise', 'aec-forge' ) as $theme ) {
		$cmd = escapeshellarg( PHP_BINARY ) . ' ' . escapeshellarg( __DIR__ . '/render-theme.php' )
			. ' ' . escapeshellarg( $out_dir ) . ' ' . escapeshellarg( $theme );
		passthru( $cmd, $code );
		if ( 0 !== $code ) {
			fwrite( STDERR, "render-theme failed for $theme\n" );
			exit( 1 );
		}
	}
}

if ( in_array( $target, array( 'all', 'shortcodes' ), true ) ) {
	require __DIR__ . '/render-shortcodes.php';
}
