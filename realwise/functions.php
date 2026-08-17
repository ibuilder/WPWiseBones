<?php
/**
 * RealWise — child theme of WPWiseBones.
 *
 * Rebrands the base (blue/amber) and ships a one-click demo importer that
 * builds the full portfolio site + Easy Digital Downloads storefront.
 */

defined( 'ABSPATH' ) || exit;

define( 'REALWISE_VERSION', '1.3.2' );

/* Print the active theme version into the page <head> so you can confirm which
   build is live via "View Source" (search for "RealWise theme v"). */
add_action( 'wp_head', function () {
    echo "\n<!-- RealWise theme v" . esc_html( REALWISE_VERSION ) . " -->\n";
}, 1 );

/* ── Enqueue the brand stylesheet after the parent's CSS ──────────────── */
add_action( 'wp_enqueue_scripts', function () {
    // Brand webfont (Plus Jakarta Sans). External request — swap for a self-hosted
    // copy if you prefer zero third-party calls.
    wp_enqueue_style(
        'realwise-font',
        'https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap',
        [],
        null
    );

    // Version assets by file modification time so every edit auto-busts browser
    // and CDN caches (no more "I updated the CSS but still see the old colours").
    $ver = static function ( string $rel ): string {
        $path = get_stylesheet_directory() . $rel;
        return file_exists( $path ) ? (string) filemtime( $path ) : REALWISE_VERSION;
    };

    // Parent main stylesheet (handle registered by WPWiseBones is 'wpb-main';
    // fall back gracefully if the parent ever renames it).
    $deps = wp_style_is( 'wpb-main', 'registered' ) ? [ 'wpb-main', 'realwise-font' ] : [ 'realwise-font' ];
    wp_enqueue_style(
        'realwise-brand',
        get_stylesheet_directory_uri() . '/assets/css/realwise.css',
        $deps,
        $ver( '/assets/css/realwise.css' )
    );

    wp_enqueue_script(
        'realwise-ui',
        get_stylesheet_directory_uri() . '/assets/js/realwise.js',
        [],
        $ver( '/assets/js/realwise.js' ),
        true
    );
}, 20 );

/* Preconnect to the font host for faster first paint. */
add_filter( 'wp_resource_hints', function ( $hints, $relation ) {
    if ( 'preconnect' === $relation ) {
        $hints[] = 'https://fonts.gstatic.com';
    }
    return $hints;
}, 10, 2 );

/* ── Brand the block-editor colour palette (blue primary, amber CTA) ────── */
add_action( 'after_setup_theme', function () {
    add_theme_support( 'editor-color-palette', [
        [ 'name' => __( 'RealWise Blue',  'realwise' ), 'slug' => 'primary', 'color' => '#2563eb' ],
        [ 'name' => __( 'RealWise Sky',   'realwise' ), 'slug' => 'info',    'color' => '#38bdf8' ],
        [ 'name' => __( 'RealWise Amber', 'realwise' ), 'slug' => 'warning', 'color' => '#f59e0b' ],
        [ 'name' => __( 'Ink',            'realwise' ), 'slug' => 'dark',    'color' => '#0c2750' ],
        [ 'name' => __( 'Tint',           'realwise' ), 'slug' => 'light',   'color' => '#eef4ff' ],
        [ 'name' => __( 'White',          'realwise' ), 'slug' => 'white',   'color' => '#ffffff' ],
    ] );
}, 20 );

/* ── Hero defaults (used until the importer / customizer override them) ──── */
add_filter( 'theme_mod_wpb_hero_heading',    fn( $v ) => $v ?: 'The complete real-estate platform for WordPress' );
add_filter( 'theme_mod_wpb_hero_subheading', fn( $v ) => $v ?: 'Listings, investor analytics, CRM, property management and automated MLS imports — one platform, two plugins.' );
add_filter( 'theme_mod_wpb_hero_btn_text',   fn( $v ) => $v ?: 'See pricing' );
add_filter( 'theme_mod_wpb_hero_btn_url',    fn( $v ) => ( ! $v || '#' === $v ) ? home_url( '/pricing/' ) : $v );

/* ── Storefront helpers (used by front-page.php) ──────────────────────── */

/** Find an imported EDD download by its demo flag ('dl-free' | 'dl-mls'). */
function realwise_download_id( string $flag ): int {
    if ( ! post_type_exists( 'download' ) ) {
        return 0;
    }
    $q = get_posts( [
        'post_type'   => 'download',
        'post_status' => 'publish',
        'numberposts' => 1,
        'fields'      => 'ids',
        'meta_key'    => '_realwise_demo_slug',
        'meta_value'  => $flag,
    ] );
    return $q ? (int) $q[0] : 0;
}

/**
 * A buy button: a real EDD [purchase_link] when the storefront exists, else a
 * plain link — so the homepage works with or without EDD.
 */
function realwise_buy_button( string $flag, string $text, string $btn_class, string $fallback_url ): string {
    $id = realwise_download_id( $flag );
    if ( $id && shortcode_exists( 'purchase_link' ) ) {
        return do_shortcode( '[purchase_link id="' . $id . '" text="' . esc_attr( $text ) . '" style="button" class="' . esc_attr( $btn_class ) . '"]' );
    }
    return '<a href="' . esc_url( $fallback_url ) . '" class="' . esc_attr( $btn_class ) . '">' . esc_html( $text ) . '</a>';
}

/* ── Default social-share image on the front page (parent emits none there) ─ */
add_action( 'wp_head', function () {
    if ( ! is_front_page() ) {
        return;
    }
    $img = get_stylesheet_directory_uri() . '/assets/images/og-image.png';
    echo "\n" . '<meta property="og:image" content="' . esc_url( $img ) . '">' . "\n";
    echo '<meta property="og:image:width" content="1200">' . "\n";
    echo '<meta property="og:image:height" content="630">' . "\n";
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
    echo '<meta name="twitter:image" content="' . esc_url( $img ) . '">' . "\n";
}, 3 );

/* ── SEO structured data (Organization + SoftwareApplication + FAQPage) ── */
require_once get_stylesheet_directory() . '/inc/seo-schema.php';

/* ── Contact form (shortcode: [realwise_contact_form]) ────────────────── */
require_once get_stylesheet_directory() . '/inc/contact-form.php';

/* ── Demo importer (auto-runs on activation; Appearance → RealWise Demo) ── */
require_once get_stylesheet_directory() . '/inc/demo-content.php';
