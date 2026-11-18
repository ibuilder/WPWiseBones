<?php
/**
 * iBuilder — child theme of WPWiseBones.
 *
 * The vendor site for the iBuilder WordPress plugins sold on Codester.
 * Presents them, documents them, points at the public demo, and sends buyers
 * to the listing. It is deliberately NOT a storefront: see the note on
 * licensing below.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

define( 'IBUILDER_SITE_VERSION', '1.3.0' );

/** The Codester seller profile — where a product with no item URL yet lands. */
define( 'IBUILDER_SITE_PROFILE_URL', 'https://www.codester.com/ibuilder/' );

/*
 * No storefront, and no licensing, on purpose.
 *
 * The sibling RealWise theme ships an Easy Digital Downloads storefront with
 * license-enabled products. This theme ships none of that, for a reason worth
 * writing down so nobody "fixes" it later:
 *
 *   1. Selling happens on Codester. A second checkout is work with no revenue
 *      attached to it.
 *   2. Every readme advertises that the product contains no license key,
 *      no activation and no phone-home, and Codester rejects "activation
 *      systems, purchase-code checks, domain locks or remote license
 *      validation" outright. tools/audit_no_licensing.py in the codester
 *      project gates the plugins for exactly that. A license-issuing
 *      storefront on the vendor's own site would read, in public, as
 *      contradicting the pitch.
 *
 * So: no EDD, no WooCommerce dependency, no license API, and no outbound
 * request of any kind from this theme - see the font note in the enqueue
 * below.
 */

/** The product table, generated from the listing kits. */
require_once get_stylesheet_directory() . '/inc/products.php';
require_once get_stylesheet_directory() . '/inc/screenshots.php';

/* Print the live theme version into <head> so "View Source" can confirm which
   build is deployed - search for "iBuilder theme v". */
add_action(
	'wp_head',
	static function () {
		echo "\n<!-- iBuilder theme v" . esc_html( IBUILDER_SITE_VERSION ) . " -->\n";
	},
	1
);

/* ── The demo host ─────────────────────────────────────────────────────────
 *
 * The public demo lives on its own subdomain, on its own server, because it
 * resets hourly and hands visitors an administrator login. See SITE.md in the
 * codester project for why that cannot share a host with this site.
 *
 * Until it is live there is nothing to link to, so this returns '' and every
 * template hides its demo button rather than rendering a dead one. Set it in
 * wp-config.php:
 *
 *     define( 'IBUILDER_SITE_DEMO_URL', 'https://demo.ibuilder.me' );
 *
 * or from Appearance → iBuilder Setup, which writes the same value to an
 * option. The constant wins, so a staging site can point elsewhere without
 * touching the database.
 */

/**
 * Base URL of the public demo, or '' when none is configured.
 *
 * @return string
 */
function ibuilder_site_demo_base(): string {
	$url = defined( 'IBUILDER_SITE_DEMO_URL' ) ? (string) IBUILDER_SITE_DEMO_URL : '';

	if ( '' === $url ) {
		$url = (string) get_option( 'ibuilder_site_demo_url', '' );
	}

	$url = trim( $url );

	// A misconfigured value is worse than none: a button pointing at
	// "example.com" looks deliberate. Only an http(s) URL counts.
	if ( '' !== $url && ! preg_match( '#^https?://#i', $url ) ) {
		return '';
	}

	return '' === $url ? '' : untrailingslashit( esc_url_raw( $url ) );
}

/**
 * Asset version from file mtime, so an edit busts the cache without a bump.
 *
 * @param string $rel Path relative to the theme directory.
 * @return string
 */
function ibuilder_site_asset_version( string $rel ): string {
	$path = get_stylesheet_directory() . $rel;

	return file_exists( $path ) ? (string) filemtime( $path ) : IBUILDER_SITE_VERSION;
}

/* ── Styles ────────────────────────────────────────────────────────────────
 *
 * System fonts only. No Google Fonts, no CDN, nothing third-party - which is
 * a deliberate choice rather than a shortcut. Every product this site sells
 * advertises that it makes no outbound HTTP request of any kind; a site that
 * pulled a webfont from Google to say so would be making the opposite point
 * on page load. The sibling AEC Forge theme loads Archivo from Google and is
 * right to; this one cannot.
 */
add_action(
	'wp_enqueue_scripts',
	static function () {
		// Depend on the parent's real handle when it is there, so the cascade
		// runs base → brand. Fall back gracefully if the parent renames it.
		$deps = array();
		foreach ( array( 'wpwisebones-main', 'bootstrap' ) as $handle ) {
			if ( wp_style_is( $handle, 'registered' ) || wp_style_is( $handle, 'enqueued' ) ) {
				$deps[] = $handle;
			}
		}

		wp_enqueue_style(
			'ibuilder-brand',
			get_stylesheet_directory_uri() . '/assets/css/ibuilder.css',
			$deps,
			ibuilder_site_asset_version( '/assets/css/ibuilder.css' )
		);
	},
	20
);

/* ── Full width by default ─────────────────────────────────────────────────
 * A product site reads better edge to edge. Set once as a theme mod so the
 * owner can still change it in the Customizer; the option guard stops this
 * from overriding that choice on every load.
 */
add_action(
	'after_setup_theme',
	static function () {
		if ( ! get_option( 'ibuilder_site_layout_set' ) ) {
			set_theme_mod( 'wpwisebones_layout', 'full-width' );
			update_option( 'ibuilder_site_layout_set', 1 );
		}
	}
);

/* ── Favicon ───────────────────────────────────────────────────────────────
 * Priority 4, after the Open Graph window below closes at 3, so
 * has_site_icon() is evaluated without the og:image filter in place. The
 * sibling AEC Forge theme hit this and the same ordering is used here.
 */
add_action(
	'wp_head',
	static function () {
		if ( function_exists( 'has_site_icon' ) && has_site_icon() ) {
			return;
		}

		printf(
			"<link rel=\"icon\" href=\"%s\" type=\"image/svg+xml\">\n",
			esc_url( get_stylesheet_directory_uri() . '/assets/img/mark.svg' )
		);
	},
	4
);

/* ── Social preview ────────────────────────────────────────────────────────
 *
 * The parent (wpwisebones/inc/seo.php) already prints a complete, plugin-aware
 * Open Graph / Twitter / schema set, but falls back to the site icon for
 * og:image. Rather than print a competing second set, feed the parent the
 * image it already looks for: a 1200×630 raster, since networks will not
 * render an SVG.
 *
 * has_site_icon() is implemented through get_site_icon_url(), so filtering
 * that globally would make WordPress treat this raster as the favicon too.
 * The filter is therefore scoped to the parent meta's wp_head window - added
 * at 1, removed at 3, parent runs at 2 - and the favicon block above sits at
 * 4. A real featured image still wins, since this only fills an empty URL.
 */
add_filter( 'jetpack_enable_open_graph', '__return_false' );

$ibuilder_site_og = static function ( $url ) {
	return '' === (string) $url
		? get_stylesheet_directory_uri() . '/assets/img/og-default.png'
		: $url;
};

add_action(
	'wp_head',
	static function () use ( $ibuilder_site_og ) {
		add_filter( 'get_site_icon_url', $ibuilder_site_og );
	},
	1
);

add_action(
	'wp_head',
	static function () use ( $ibuilder_site_og ) {
		remove_filter( 'get_site_icon_url', $ibuilder_site_og );
	},
	3
);

/* ── Product pages ────────────────────────────────────────────────────────
 * Each generated product page carries the product key in post meta, so a
 * template can find its row without matching on a title.
 */

/**
 * The product row for a page, or null when the page is not a product page.
 *
 * @param int|null $post_id Page ID, or null for the current post.
 * @return array<string, mixed>|null
 */
function ibuilder_site_page_product( ?int $post_id = null ): ?array {
	$post_id = $post_id ? $post_id : get_the_ID();

	if ( ! $post_id ) {
		return null;
	}

	$key = (string) get_post_meta( $post_id, '_ibuilder_site_product', true );

	return '' === $key ? null : ibuilder_site_product( $key );
}

/* ── The one-click site builder ───────────────────────────────────────────── */
require_once get_stylesheet_directory() . '/inc/site-builder.php';
