<?php
/**
 * The dashboard widget's System Info panel must describe the theme truthfully.
 *
 * Regression cover for the WPWISEBONES_LOCAL_ASSETS bug fixed in 1.0.12: the
 * panel tested a constant the theme has never defined, so it always claimed
 * "Assets: CDN (jsDelivr)" and offered a "switch to local" link, reporting a
 * WP.org Guideline 8 violation the theme does not have.
 */

require_once __DIR__ . '/lib.php';
wpwisebones_test_bootstrap();

if ( ! function_exists( 'wpwisebones_dashboard_widget_render' ) ) {
	wpwisebones_test_fatal( 'wpwisebones_dashboard_widget_render() is not loaded' );
}

ob_start();
wpwisebones_dashboard_widget_render();
$html = ob_get_clean();

$php_v = phpversion();
$wp_v  = get_bloginfo( 'version' );

wpwisebones_test_group( 'System Info reports local assets' );
wpwisebones_test_check( "renders 'Local vendor'", false !== strpos( $html, 'Local vendor' ) );
wpwisebones_test_check( 'asset mode carries the green style', false !== strpos( $html, 'color:#198754;font-weight:600">Local vendor' ) );
wpwisebones_test_check( "'Assets:' label still present", false !== strpos( $html, 'Assets:' ) );

wpwisebones_test_group( 'The false CDN claim is gone' );
wpwisebones_test_check( "no 'CDN (jsDelivr)'", false === strpos( $html, 'CDN (jsDelivr)' ) );
wpwisebones_test_check( "no 'Switch to local' link text", false === strpos( $html, 'Switch to local' ) );
wpwisebones_test_check( 'no docs/local-assets link', false === strpos( $html, 'docs/local-assets' ) );
wpwisebones_test_check( 'no leftover blue CDN span', false === strpos( $html, 'color:#0d6efd">' ) );

wpwisebones_test_group( 'The phantom constant stays gone' );
wpwisebones_test_check( 'WPWISEBONES_LOCAL_ASSETS is undefined at runtime', ! defined( 'WPWISEBONES_LOCAL_ASSETS' ) );
wpwisebones_test_check( 'theme source contains no reference to it', 0 === (int) preg_match( '/WPWISEBONES_LOCAL_ASSETS/', file_get_contents( get_template_directory() . '/inc/dashboard-widget.php' ) ) );

wpwisebones_test_group( 'Rest of the widget still renders' );
wpwisebones_test_check( "reports the running PHP version ({$php_v})", false !== strpos( $html, $php_v ) );
wpwisebones_test_check( "reports the running WP version ({$wp_v})", false !== strpos( $html, $wp_v ) );
wpwisebones_test_check( 'footer shows the theme version', false !== strpos( $html, 'WPWiseBones v' . WPWISEBONES_VERSION ) );

wpwisebones_test_group( 'Output encoding' );
wpwisebones_test_check( 'output is valid UTF-8', (bool) preg_match( '//u', $html ) );
wpwisebones_test_check( 'separator is a real U+00B7, not mojibake', false === strpos( $html, "\xc3\x82\xc2\xb7" ) );

wpwisebones_test_finish();
