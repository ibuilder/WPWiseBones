<?php
/**
 * Register widget areas / sidebars.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'widgets_init', 'wpb_widgets_init' );

function wpb_widgets_init() {
    $defaults = [
        'before_widget' => '<div id="%1$s" class="widget %2$s mb-4">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ];

    // Primary sidebar
    register_sidebar( array_merge( $defaults, [
        'name'        => __( 'Primary Sidebar', 'wpwisebones' ),
        'id'          => 'sidebar-primary',
        'description' => __( 'Appears on posts and pages with a sidebar layout.', 'wpwisebones' ),
    ] ) );

    // Footer columns
    for ( $i = 1; $i <= 4; $i++ ) {
        register_sidebar( array_merge( $defaults, [
            /* translators: %d: footer column number (1â€“4) */
            'name'        => sprintf( __( 'Footer Column %d', 'wpwisebones' ), $i ),
            'id'          => 'footer-' . $i,
            /* translators: %d: footer column number (1â€“4) */
            'description' => sprintf( __( 'Footer widget area column %d.', 'wpwisebones' ), $i ),
        ] ) );
    }

    // WooCommerce shop sidebar (registers even without WC active, harmless)
    register_sidebar( array_merge( $defaults, [
        'name'        => __( 'Shop Sidebar', 'wpwisebones' ),
        'id'          => 'sidebar-shop',
        'description' => __( 'Appears on WooCommerce shop pages.', 'wpwisebones' ),
    ] ) );

    // Header widget area (e.g., search box, cart icon)
    register_sidebar( array_merge( $defaults, [
        'name'        => __( 'Header Widget Area', 'wpwisebones' ),
        'id'          => 'header-widgets',
        'description' => __( 'Appears in the site header (right side).', 'wpwisebones' ),
    ] ) );

    // Before content area
    register_sidebar( array_merge( $defaults, [
        'name'        => __( 'Before Content', 'wpwisebones' ),
        'id'          => 'before-content',
        'description' => __( 'Full-width area above the main content/sidebar row.', 'wpwisebones' ),
    ] ) );

    // After content area
    register_sidebar( array_merge( $defaults, [
        'name'        => __( 'After Content', 'wpwisebones' ),
        'id'          => 'after-content',
        'description' => __( 'Full-width area below the main content/sidebar row.', 'wpwisebones' ),
    ] ) );

    // Register custom widgets
    register_widget( 'WPB_Widget_Recent_Posts' );
    register_widget( 'WPB_Widget_Social_Links' );
    register_widget( 'WPB_Widget_CTA_Banner' );
}
