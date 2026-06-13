<?php
/**
 * Enqueue scripts and styles.
 *
 * Bootstrap is served from local vendor/ by default (WP.org requires no remote
 * resources without user consent). To use the jsDelivr CDN instead, add this
 * to wp-config.php:
 *
 *   define( 'WPB_LOCAL_ASSETS', false );
 *
 * Local copies are in /assets/vendor/ — always safe under strict CSP headers.
 */

defined( 'ABSPATH' ) || exit;

/** Whether to serve Bootstrap/Icons from local vendor files (true) or CDN (false). */
if ( ! defined( 'WPB_LOCAL_ASSETS' ) ) {
    define( 'WPB_LOCAL_ASSETS', true );
}

add_action( 'wp_enqueue_scripts', 'wpb_enqueue_assets' );

function wpb_enqueue_assets() {
    $v      = WPB_VERSION;
    $local  = WPB_LOCAL_ASSETS;
    $vendor = WPB_URI . '/assets/vendor';

    /* â”€â”€ Bootstrap 5 CSS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ( $local ) {
        wp_enqueue_style(
            'bootstrap',
            $vendor . '/css/bootstrap.min.css',
            [],
            '5.3.3'
        );
    } else {
        wp_enqueue_style(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css',
            [],
            '5.3.3'
        );
    }

    /* â”€â”€ Bootstrap Icons â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ( $local ) {
        // Fix font path: the CSS references ./fonts/... which resolves correctly
        // because we placed fonts/ alongside the CSS file in assets/vendor/css/../fonts/
        // We need to inline-override the @font-face src to use the correct URL.
        wp_enqueue_style(
            'bootstrap-icons',
            $vendor . '/css/bootstrap-icons.min.css',
            [],
            '1.11.3'
        );
        // Override the @font-face paths that the CSS uses (relative to its own location)
        $font_url = $vendor . '/fonts/bootstrap-icons';
        $inline   = "@font-face { font-family: 'bootstrap-icons'; src: url('" . esc_url( $font_url . '.woff2' ) . "') format('woff2'), url('" . esc_url( $font_url . '.woff' ) . "') format('woff'); }";
        wp_add_inline_style( 'bootstrap-icons', $inline );
    } else {
        wp_enqueue_style(
            'bootstrap-icons',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css',
            [],
            '1.11.3'
        );
    }

    /* â”€â”€ Theme stylesheet (style.css) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    wp_enqueue_style( 'wpb-style', get_stylesheet_uri(), [ 'bootstrap' ], $v );

    /* â”€â”€ Custom theme CSS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    wp_enqueue_style( 'wpb-main', WPB_URI . '/assets/css/main.css', [ 'wpb-style' ], $v );

    /* â”€â”€ Bootstrap 5 JS bundle â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ( $local ) {
        wp_enqueue_script(
            'bootstrap',
            $vendor . '/js/bootstrap.bundle.min.js',
            [],
            '5.3.3',
            true
        );
    } else {
        wp_enqueue_script(
            'bootstrap',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js',
            [],
            '5.3.3',
            true
        );
    }

    /* â”€â”€ Theme main JS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    wp_enqueue_script( 'wpb-main', WPB_URI . '/assets/js/main.js', [ 'bootstrap' ], $v, true );

    /* â”€â”€ Pass data to JS â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    wp_localize_script( 'wpb-main', 'wpbData', [
        'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
        'nonce'    => wp_create_nonce( 'wpb_nonce' ),
        'siteUrl'  => home_url(),
        'themeUrl' => WPB_URI,
        'i18n'     => [
            'loading' => __( 'Loadingâ€¦', 'wpwisebones' ),
            'error'   => __( 'An error occurred.', 'wpwisebones' ),
        ],
    ] );

    /* â”€â”€ Comments reply script â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}

/* â”€â”€ Admin enqueue â€“ only on theme-related admin pages â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
add_action( 'admin_enqueue_scripts', 'wpb_admin_enqueue' );

function wpb_admin_enqueue( string $hook ) {
    $theme_hooks = [
        'appearance_page_wpb-theme-options',
        'post.php',
        'post-new.php',
        'widgets.php',
        'customize.php',
    ];
    if ( ! in_array( $hook, $theme_hooks, true ) ) {
        return;
    }

    wp_enqueue_style(  'wpb-admin', WPB_URI . '/assets/css/admin.css', [],          WPB_VERSION );
    wp_enqueue_script( 'wpb-admin', WPB_URI . '/assets/js/admin.js',  [ 'jquery' ], WPB_VERSION, true );
}

/* -- Customizer preview JS (postMessage live updates) -- */
add_action( 'customize_preview_init', 'wpb_customizer_preview_js' );

function wpb_customizer_preview_js() {
    wp_enqueue_script(
        'wpb-customizer',
        WPB_URI . '/assets/js/customizer.js',
        [ 'customize-preview', 'jquery' ],
        WPB_VERSION,
        true
    );
}