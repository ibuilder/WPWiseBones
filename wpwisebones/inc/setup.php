<?php
/**
 * Theme setup â€“ add_theme_support, image sizes, etc.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'after_setup_theme', 'wpb_setup' );

function wpb_setup() {
    load_theme_textdomain( 'wpwisebones', WPB_DIR . '/languages' );

    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'html5', [
        'search-form', 'comment-form', 'comment-list',
        'gallery', 'caption', 'style', 'script',
    ] );
    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'wp-block-styles' );
    add_theme_support( 'align-wide' );
    add_theme_support( 'responsive-embeds' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'assets/css/editor-style.css' );

    // Custom logo
    add_theme_support( 'custom-logo', [
        'height'      => 60,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
    ] );

    // Custom background
    add_theme_support( 'custom-background', [
        'default-color' => 'ffffff',
    ] );

    // Custom header
    add_theme_support( 'custom-header', [
        'default-image'      => '',
        'default-text-color' => '000000',
        'width'              => 1920,
        'height'             => 400,
        'flex-height'        => true,
    ] );

    // Image sizes
    add_image_size( 'wpb-card',    400, 250, true );
    add_image_size( 'wpb-hero',   1920, 600, true );
    add_image_size( 'wpb-square',  400, 400, true );
    add_image_size( 'wpb-wide',   1200, 400, true );

    // Nav menus
    register_nav_menus( [
        'primary'  => __( 'Primary Menu', 'wpwisebones' ),
        'footer'   => __( 'Footer Menu', 'wpwisebones' ),
        'topbar'   => __( 'Top Bar Menu', 'wpwisebones' ),
        'mobile'   => __( 'Mobile Menu', 'wpwisebones' ),
    ] );

    // Content width
    if ( ! isset( $content_width ) ) {
        $content_width = 1200;
    }
}

// Gutenberg colour palette
add_action( 'after_setup_theme', 'wpb_block_editor_settings' );
function wpb_block_editor_settings() {
    add_theme_support( 'editor-color-palette', [
        [ 'name' => __( 'Primary',   'wpwisebones' ), 'slug' => 'primary',   'color' => '#0d6efd' ],
        [ 'name' => __( 'Secondary', 'wpwisebones' ), 'slug' => 'secondary', 'color' => '#6c757d' ],
        [ 'name' => __( 'Success',   'wpwisebones' ), 'slug' => 'success',   'color' => '#198754' ],
        [ 'name' => __( 'Danger',    'wpwisebones' ), 'slug' => 'danger',    'color' => '#dc3545' ],
        [ 'name' => __( 'Warning',   'wpwisebones' ), 'slug' => 'warning',   'color' => '#ffc107' ],
        [ 'name' => __( 'Info',      'wpwisebones' ), 'slug' => 'info',      'color' => '#0dcaf0' ],
        [ 'name' => __( 'Dark',      'wpwisebones' ), 'slug' => 'dark',      'color' => '#212529' ],
        [ 'name' => __( 'White',     'wpwisebones' ), 'slug' => 'white',     'color' => '#ffffff' ],
    ] );
}

// Excerpt length â€“ reads from admin options, falls back to 25
add_filter( 'excerpt_length', function() {
    $o = get_option( 'wpb_options', [] );
    return isset( $o['excerpt_length'] ) && $o['excerpt_length'] > 0
        ? absint( $o['excerpt_length'] )
        : 25;
} );
add_filter( 'excerpt_more', fn() => '&hellip;' );

// Posts per page â€“ archive/blog only
add_action( 'pre_get_posts', function( WP_Query $q ) {
    if ( is_admin() || ! $q->is_main_query() ) return;
    if ( ! ( $q->is_home() || $q->is_archive() || $q->is_search() ) ) return;
    $o = get_option( 'wpb_options', [] );
    if ( ! empty( $o['posts_per_page'] ) ) {
        $q->set( 'posts_per_page', absint( $o['posts_per_page'] ) );
    }
} );

// Smooth scroll toggle â€” add/remove class on <html> via wp_head inline style
add_action( 'wp_head', function() {
    $o = get_option( 'wpb_options', [] );
    if ( empty( $o['smooth_scroll'] ) ) {
        echo "<style>html { scroll-behavior: auto; }</style>\n";
    }
}, 100 );


/* ── Block Styles ─────────────────────────────────────────── */
add_action( 'init', 'wpb_register_block_styles' );
function wpb_register_block_styles() {
    $styles = [
        [ 'core/button', 'wpb-outline',   __( 'Outline',        'wpwisebones' ) ],
        [ 'core/button', 'wpb-pill',      __( 'Pill',           'wpwisebones' ) ],
        [ 'core/image',  'wpb-rounded',   __( 'Rounded',        'wpwisebones' ) ],
        [ 'core/image',  'wpb-shadow',    __( 'Shadow',         'wpwisebones' ) ],
        [ 'core/quote',  'wpb-bordered',  __( 'Bordered',       'wpwisebones' ) ],
        [ 'core/group',  'wpb-card',      __( 'Card',           'wpwisebones' ) ],
        [ 'core/list',   'wpb-checkmark', __( 'Checkmarks',     'wpwisebones' ) ],
    ];

    foreach ( $styles as [ $block, $name, $label ] ) {
        register_block_style( $block, [ 'name' => $name, 'label' => $label ] );
    }
}

/* ── Block Patterns ───────────────────────────────────────── */
add_action( 'init', 'wpb_register_block_patterns' );
function wpb_register_block_patterns() {

    register_block_pattern_category( 'wpwisebones', [ 'label' => __( 'WPWiseBones', 'wpwisebones' ) ] );

    // Hero section pattern
    register_block_pattern( 'wpwisebones/hero-section', [
        'title'       => __( 'Hero Section', 'wpwisebones' ),
        'description' => __( 'A full-width hero section with heading, text and button.', 'wpwisebones' ),
        'categories'  => [ 'wpwisebones', 'featured' ],
        'content'     => '<!-- wp:cover {"align":"full","style":{"color":{"background":"#0d6efd"}}} --><div class="wp-block-cover alignfull" style="background-color:#0d6efd"><div class="wp-block-cover__inner-container"><!-- wp:heading {"textAlign":"center","level":1,"style":{"color":{"text":"#ffffff"}}} --><h1 class="wp-block-heading has-text-align-center" style="color:#ffffff">Welcome to WPWiseBones</h1><!-- /wp:heading --><!-- wp:paragraph {"align":"center","style":{"color":{"text":"#ffffffcc"}}} --><p class="has-text-align-center" style="color:#ffffffcc">A beautiful, flexible Bootstrap 5 WordPress theme.</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button {"backgroundColor":"white","textColor":"primary"} --><div class="wp-block-button"><a class="wp-block-button__link has-primary-color has-white-background-color has-text-color has-background wp-element-button">Get Started</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div></div><!-- /wp:cover -->',
    ] );

    // Two-column feature pattern
    register_block_pattern( 'wpwisebones/two-column-features', [
        'title'       => __( 'Two-Column Features', 'wpwisebones' ),
        'description' => __( 'Two columns of feature content with headings.', 'wpwisebones' ),
        'categories'  => [ 'wpwisebones', 'columns' ],
        'content'     => '<!-- wp:columns {"align":"wide"} --><div class="wp-block-columns alignwide"><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Feature One</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Describe your first feature here. Keep it concise and benefit-focused.</p><!-- /wp:paragraph --></div><!-- /wp:column --><!-- wp:column --><div class="wp-block-column"><!-- wp:heading {"level":3} --><h3 class="wp-block-heading">Feature Two</h3><!-- /wp:heading --><!-- wp:paragraph --><p>Describe your second feature here. Keep it concise and benefit-focused.</p><!-- /wp:paragraph --></div><!-- /wp:column --></div><!-- /wp:columns -->',
    ] );

    // Call to action pattern
    register_block_pattern( 'wpwisebones/call-to-action', [
        'title'       => __( 'Call to Action', 'wpwisebones' ),
        'description' => __( 'Centered heading, text and a prominent button.', 'wpwisebones' ),
        'categories'  => [ 'wpwisebones' ],
        'content'     => '<!-- wp:group {"align":"full","style":{"color":{"background":"#f8f9fa"},"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}}} --><div class="wp-block-group alignfull" style="background-color:#f8f9fa;padding-top:4rem;padding-bottom:4rem"><!-- wp:heading {"textAlign":"center"} --><h2 class="wp-block-heading has-text-align-center">Ready to Get Started?</h2><!-- /wp:heading --><!-- wp:paragraph {"align":"center"} --><p class="has-text-align-center">Join thousands of users who trust WPWiseBones for their websites.</p><!-- /wp:paragraph --><!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} --><div class="wp-block-buttons"><!-- wp:button --><div class="wp-block-button"><a class="wp-block-button__link wp-element-button">Get Started Today</a></div><!-- /wp:button --></div><!-- /wp:buttons --></div><!-- /wp:group -->',
    ] );
}