<?php
/**
 * WooCommerce compatibility layer.
 *
 * Loaded only when WooCommerce is active â€” safe to include always
 * since all functions are gated on class_exists( 'WooCommerce' ).
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

/* â”€â”€ Declare theme support â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'after_setup_theme', 'wpwisebones_woocommerce_support' );
function wpwisebones_woocommerce_support() {
    add_theme_support( 'woocommerce', [
        'thumbnail_image_width' => 400,
        'single_image_width'    => 600,
        'product_grid'          => [
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 3,
            'min_columns'     => 1,
            'max_columns'     => 4,
        ],
    ] );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
}

/* â”€â”€ Remove default WC wrappers, add Bootstrap ones â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end', 10 );

add_action( 'woocommerce_before_main_content', 'wpwisebones_wc_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content',  'wpwisebones_wc_wrapper_end',   10 );

function wpwisebones_wc_wrapper_start() {
    $container  = get_theme_mod( 'wpwisebones_container_width', 'container' );
    $has_sidebar = is_active_sidebar( 'sidebar-shop' );
    $main_col    = $has_sidebar ? 'col-lg-9' : 'col-12';
    echo '<div class="' . esc_attr( $container ) . '"><div class="row g-4">';
    echo '<main id="main" tabindex="-1" class="site-main ' . $main_col . '">';
}

function wpwisebones_wc_wrapper_end() {
    echo '</main>';
}

/* â”€â”€ WC sidebar â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );
add_action( 'woocommerce_sidebar', 'wpwisebones_wc_sidebar' );

function wpwisebones_wc_sidebar() {
    if ( is_active_sidebar( 'sidebar-shop' ) ) {
        echo '<aside id="secondary" class="col-lg-3 widget-area">';
        dynamic_sidebar( 'sidebar-shop' );
        echo '</aside>';
    }
    echo '</div></div>'; // close row + container
}

/* â”€â”€ Bootstrap-style WC notices â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_filter( 'woocommerce_add_to_cart_fragments', '__return_array' );

add_filter( 'wc_add_to_cart_message_html', 'wpwisebones_wc_add_to_cart_message', 10, 2 );
function wpwisebones_wc_add_to_cart_message( string $message ): string {
    return '<div class="alert alert-success alert-dismissible fade show" role="alert">'
        . $message
        . '<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>';
}

/* â”€â”€ Style WC pagination with Bootstrap â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_filter( 'woocommerce_pagination_args', 'wpwisebones_wc_pagination_args' );
function wpwisebones_wc_pagination_args( array $args ): array {
    $args['prev_text'] = '<i class="bi bi-chevron-left"></i>';
    $args['next_text'] = '<i class="bi bi-chevron-right"></i>';
    return $args;
}

/* â”€â”€ Enqueue WC-specific overrides â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_enqueue_scripts', 'wpwisebones_wc_styles' );
function wpwisebones_wc_styles() {
    if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
        return;
    }
    wp_add_inline_style( 'wpwisebones-main', '
        .woocommerce a.button,
        .woocommerce button.button,
        .woocommerce input.button,
        .woocommerce #respond input#submit {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            padding: .375rem .75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: .375rem;
            background-color: var(--bs-primary, #0d6efd);
            border: 1px solid var(--bs-primary, #0d6efd);
            color: #fff;
            text-decoration: none;
        }
        .woocommerce a.button:hover,
        .woocommerce button.button:hover { opacity: .85; color: #fff; }
        .woocommerce a.button.alt,
        .woocommerce button.button.alt { background-color: var(--bs-secondary, #6c757d); border-color: var(--bs-secondary, #6c757d); }
        .woocommerce-message { background: #d1e7dd; border-left: 4px solid #198754; padding: 1rem; margin-bottom: 1rem; border-radius: .375rem; }
        .woocommerce-error   { background: #f8d7da; border-left: 4px solid #dc3545; padding: 1rem; margin-bottom: 1rem; border-radius: .375rem; }
        .woocommerce-info    { background: #cff4fc; border-left: 4px solid #0dcaf0; padding: 1rem; margin-bottom: 1rem; border-radius: .375rem; }
        .woocommerce .woocommerce-ordering select { border: 1px solid #dee2e6; border-radius: .375rem; padding: .375rem .75rem; }
        ul.products li.product .woocommerce-loop-product__title { font-size: 1rem; font-weight: 600; }
        .woocommerce ul.products li.product { border-radius: .5rem; overflow: hidden; }
        .woocommerce-cart table.cart td, .woocommerce-cart table.cart th { vertical-align: middle; }
        .woocommerce form .form-row input.input-text,
        .woocommerce form .form-row textarea { border: 1px solid #dee2e6; border-radius: .375rem; padding: .375rem .75rem; width: 100%; }
    ' );
}
