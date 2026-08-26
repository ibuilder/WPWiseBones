<?php
/**
 * AEC Forge — child theme of WPWiseBones.
 *
 * Rebrands the base (charcoal / molten orange) for aec-forge.com and ships a
 * one-click site builder that creates the marketplace promo site around the
 * AEC Market plugin.
 */

defined( 'ABSPATH' ) || exit;

define( 'AEC_FORGE_VERSION', '1.0.0' );

/* Print the active theme version into the page <head> so you can confirm which
   build is live via "View Source" (search for "AEC Forge theme v"). */
add_action( 'wp_head', function () {
	echo "\n<!-- AEC Forge theme v" . esc_html( AEC_FORGE_VERSION ) . " -->\n";
}, 1 );

/* ── Enqueue the brand stylesheet after the parent's CSS ────────────────── */
add_action( 'wp_enqueue_scripts', function () {
	// Brand webfont (Archivo). External request — swap for a self-hosted copy
	// if you prefer zero third-party calls.
	wp_enqueue_style(
		'aec-forge-font',
		'https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700;800&display=swap',
		[],
		null
	);

	// Version assets by file modification time so every edit auto-busts caches.
	$ver = static function ( string $rel ): string {
		$path = get_stylesheet_directory() . $rel;
		return file_exists( $path ) ? (string) filemtime( $path ) : AEC_FORGE_VERSION;
	};

	// Parent main stylesheet handle is 'wpwisebones-main'; fall back gracefully
	// if the parent ever renames it.
	$deps = wp_style_is( 'wpwisebones-main', 'registered' ) ? [ 'wpwisebones-main', 'aec-forge-font' ] : [ 'aec-forge-font' ];
	wp_enqueue_style(
		'aec-forge-brand',
		get_stylesheet_directory_uri() . '/assets/css/aec-forge.css',
		$deps,
		$ver( '/assets/css/aec-forge.css' )
	);
}, 20 );

/* Preconnect to the font host for faster first paint. */
add_filter( 'wp_resource_hints', function ( $hints, $relation ) {
	if ( 'preconnect' === $relation ) {
		$hints[] = 'https://fonts.gstatic.com';
	}
	return $hints;
}, 10, 2 );

/* ── Helpers used by templates and the site builder ─────────────────────── */

/**
 * URL of an AEC Market plugin page (vendor_register_page, vendor_dashboard_page,
 * vendor_store_page), with a sensible fallback when the plugin is inactive.
 */
function aec_forge_market_url( string $key, string $fallback ): string {
	if ( function_exists( 'wpaec_get_setting' ) ) {
		$id = absint( wpaec_get_setting( $key ) );
		if ( $id && get_post( $id ) ) {
			return (string) get_permalink( $id );
		}
	}
	return home_url( $fallback );
}

/** Shop URL (WooCommerce) with fallback. */
function aec_forge_shop_url(): string {
	if ( function_exists( 'wc_get_page_id' ) ) {
		$id = wc_get_page_id( 'shop' );
		if ( $id > 0 ) {
			return (string) get_permalink( $id );
		}
	}
	return home_url( '/shop/' );
}

/* ── Full-width by default (no sidebar) — a marketplace reads better edge to
      edge. Set once as a theme mod so the site owner can still override it in
      the Customizer or per page. ─────────────────────────────────────────── */
add_action( 'after_setup_theme', function () {
	if ( ! get_option( 'aec_forge_layout_set' ) ) {
		set_theme_mod( 'wpwisebones_layout', 'full-width' );
		update_option( 'aec_forge_layout_set', 1 );
	}
} );

/* ── Branded product placeholder — replace WooCommerce's grey box with the
      AEC Forge blueprint-cube graphic. We filter both the src (fallback path)
      and the full <img> HTML (used when a placeholder attachment is set, which
      otherwise bypasses the src filter). ────────────────────────────────── */
add_filter( 'woocommerce_placeholder_img_src', function () {
	return get_stylesheet_directory_uri() . '/assets/img/placeholder.svg';
} );

add_filter( 'woocommerce_placeholder_img', function ( $html, $size, $dimensions ) {
	$src = get_stylesheet_directory_uri() . '/assets/img/placeholder.svg';
	$w   = ( is_array( $dimensions ) && ! empty( $dimensions['width'] ) ) ? (int) $dimensions['width'] : 600;
	$h   = ( is_array( $dimensions ) && ! empty( $dimensions['height'] ) ) ? (int) $dimensions['height'] : 600;
	return sprintf(
		'<img src="%s" alt="" width="%d" height="%d" class="woocommerce-placeholder wp-post-image af-placeholder" loading="lazy" decoding="async" />',
		esc_url( $src ),
		$w,
		$h
	);
}, 10, 3 );

/* ── The parent's product-card template prints the price itself, so drop
      WooCommerce's duplicate loop-price hook (keeps the vendor "sold by"
      line, which lives on the same hook). ───────────────────────────────── */
add_action( 'after_setup_theme', function () {
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
}, 11 );

/* ── SVG favicon / site icon when the owner hasn't set one. ─────────────── */
add_action( 'wp_head', function () {
	if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
		return;
	}
	printf(
		"<link rel=\"icon\" href=\"%s\" type=\"image/svg+xml\">\n",
		esc_url( get_stylesheet_directory_uri() . '/assets/img/mark.svg' )
	);
}, 2 );

/* ── One-click promo-site builder ───────────────────────────────────────── */
require get_stylesheet_directory() . '/inc/site-builder.php';
