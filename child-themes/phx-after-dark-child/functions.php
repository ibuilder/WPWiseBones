<?php
/**
 * PHX After Dark child theme.
 *
 * Parent theme: WPWiseBones (https://wprealwise.com/wpwisebones) — a classic,
 * Bootstrap 5 starter theme. This child supplies the brand, the night palette
 * and the member chrome; the PHX Events Membership plugin supplies the
 * catalogue, the membership gate and the event templates.
 *
 * @package PHXAfterDark
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

const PHX_AFTER_DARK_VERSION = '1.1.1';

/**
 * Theme setup.
 *
 * Navigation locations are deliberately additive. WPWiseBones already registers
 * `primary`, `footer`, `topbar` and `mobile`, and its header.php renders
 * `primary` — re-registering an equivalent here would only give the site owner
 * two menus that look interchangeable and behave differently.
 *
 * @return void
 */
function phx_after_dark_setup(): void {
	load_theme_textdomain( 'phx-after-dark', get_stylesheet_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

	// The parent adds its own editor stylesheet; this one is appended after it.
	add_editor_style( 'assets/css/phx-after-dark.css' );

	register_nav_menus(
		[
			'phx-member' => __( 'Member navigation', 'phx-after-dark' ),
			'phx-legal'  => __( 'Legal footer', 'phx-after-dark' ),
		]
	);
}
add_action( 'after_setup_theme', 'phx_after_dark_setup', 20 );

/**
 * Enqueue the brand layer after the parent's stylesheets, and fix the cascade
 * on parent themes that predate WPWiseBones 1.0.13.
 *
 * WPWiseBones 1.0.13 enqueues its own style.css as `wpwisebones-style`, then
 * `wpwisebones-main`, then the child's style.css as `wpwisebones-child-style`.
 * That is already the order this theme wants, so there is nothing to correct.
 *
 * Before 1.0.13 the parent enqueued `get_stylesheet_uri()` under
 * `wpwisebones-style`, which with a child theme active resolves to the child's
 * style.css — the parent's own base rules were never loaded at all. Registering
 * the parent sheet separately is only half the fix there: enqueueing it later
 * would also print it later, and the parent would end up overriding the child.
 * Declaring it as a dependency of the already-enqueued child handle is what
 * pins the cascade to parent → child regardless of enqueue order.
 *
 * @return void
 */
function phx_after_dark_enqueue(): void {
	// Present only on WPWiseBones 1.0.13+, where the parent orders the sheets
	// itself. Re-registering the parent sheet there would print it twice.
	$parent_orders_cascade = wp_style_is( 'wpwisebones-child-style', 'registered' );

	if ( ! $parent_orders_cascade ) {
		$parent_version = (string) wp_get_theme( get_template() )->get( 'Version' );

		wp_enqueue_style(
			'phx-after-dark-parent',
			get_template_directory_uri() . '/style.css',
			wp_style_is( 'bootstrap', 'registered' ) ? [ 'bootstrap' ] : [],
			$parent_version
		);

		$child_sheet = wp_styles()->query( 'wpwisebones-style' );

		if ( $child_sheet && ! in_array( 'phx-after-dark-parent', $child_sheet->deps, true ) ) {
			$child_sheet->deps[] = 'phx-after-dark-parent';
		}
	}

	// Declaring the parent and plugin stylesheets as dependencies where they
	// exist is what guarantees the brand tokens cascade after their defaults.
	$deps = [];

	foreach ( [ 'phx-after-dark-parent', 'wpwisebones-style', 'wpwisebones-main', 'wpwisebones-child-style', 'phx-events' ] as $handle ) {
		if ( wp_style_is( $handle, 'registered' ) ) {
			$deps[] = $handle;
		}
	}

	wp_enqueue_style(
		'phx-after-dark',
		get_stylesheet_directory_uri() . '/assets/css/phx-after-dark.css',
		$deps,
		PHX_AFTER_DARK_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'phx_after_dark_enqueue', 20 );

/**
 * Put Bootstrap 5.3 into dark mode.
 *
 * The brand is a night palette and the parent is a light Bootstrap theme.
 * Rather than fight every component with overrides, flip Bootstrap's own colour
 * mode; `[data-bs-theme="dark"]` in style.css then retints its variables.
 *
 * @param string $output Existing language attributes.
 * @return string
 */
function phx_after_dark_html_attributes( string $output ): string {
	if ( false !== strpos( $output, 'data-bs-theme' ) ) {
		return $output;
	}

	return $output . ' data-bs-theme="dark"';
}
add_filter( 'language_attributes', 'phx_after_dark_html_attributes' );

/**
 * Default the parent's navbar to its dark variant.
 *
 * A filter rather than a hard-coded value, so the Customizer still wins if the
 * site owner deliberately picks something else. The unset case has to be read
 * from get_theme_mods() rather than from the filtered value: WordPress runs
 * `theme_mod_{$name}` over the *caller's* default too, and WPWiseBones passes
 * 'light', so an unsaved mod and a deliberate light choice look identical here.
 *
 * @param mixed $value Stored theme mod, or the caller's default.
 * @return mixed
 */
function phx_after_dark_header_style( $value ) {
	$mods = get_theme_mods();

	return isset( $mods['wpwisebones_header_style'] ) ? $value : 'dark';
}
add_filter( 'theme_mod_wpwisebones_header_style', 'phx_after_dark_header_style' );

/**
 * Use the brand palette for the plugin's generated placeholder artwork.
 *
 * Without this the plugin falls back to its own defaults, which are close but
 * not identical; keeping them in one place means a rebrand is a one-file change.
 *
 * @param mixed  $value Setting value.
 * @param string $key   Setting key.
 * @return mixed
 */
function phx_after_dark_brand_placeholders( $value, string $key ) {
	$brand = [
		'placeholder_bg'     => '#0B0B12',
		'placeholder_accent' => '#12F7C0',
		'placeholder_ink'    => '#FFFFFF',
	];

	return $brand[ $key ] ?? $value;
}
add_filter( 'phx_events_setting', 'phx_after_dark_brand_placeholders', 10, 2 );

/**
 * A slim member bar above the parent's navbar.
 *
 * WPWiseBones exposes no action hooks of its own inside header.php, so
 * `wp_body_open` is the only supported insertion point that does not require
 * copying the parent template wholesale. That places the bar above the navbar,
 * which is where a status strip belongs anyway.
 *
 * @return void
 */
function phx_after_dark_member_bar(): void {
	if ( is_admin() || is_customize_preview() ) {
		return;
	}

	printf(
		'<div class="phx-memberbar"><div class="container d-flex align-items-center justify-content-between gap-3">' .
		'<span class="phx-memberbar__tagline">%1$s</span>' .
		'<span class="phx-memberbar__actions">%2$s</span>' .
		'</div></div>' . "\n",
		esc_html__( 'Curated after dark, for Phoenix metro members', 'phx-after-dark' ),
		wp_kses_post( phx_after_dark_join_cta() )
	);
}
add_action( 'wp_body_open', 'phx_after_dark_member_bar' );

/**
 * Add the SVG favicon when the site has no custom site icon set.
 *
 * @return void
 */
function phx_after_dark_favicon(): void {
	if ( has_site_icon() ) {
		return;
	}

	printf(
		'<link rel="icon" href="%s" type="image/svg+xml">' . "\n",
		esc_url( get_stylesheet_directory_uri() . '/assets/images/favicon.svg' )
	);
}
add_action( 'wp_head', 'phx_after_dark_favicon' );

/**
 * Register the theme's pattern category.
 *
 * @return void
 */
function phx_after_dark_pattern_category(): void {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'phx-after-dark',
		[ 'label' => __( 'PHX After Dark', 'phx-after-dark' ) ]
	);
}
add_action( 'init', 'phx_after_dark_pattern_category' );

/**
 * Body classes that let the stylesheet target member and public states.
 *
 * @param array<int,string> $classes Body classes.
 * @return array<int,string>
 */
function phx_after_dark_body_class( array $classes ): array {
	$classes[] = 'phx-theme';

	if ( function_exists( 'phx_events_user_is_member' ) && phx_events_user_is_member() ) {
		$classes[] = 'phx-theme--member';
	}

	return $classes;
}
add_filter( 'body_class', 'phx_after_dark_body_class' );

/**
 * Show the brand lockup in the login screen instead of the WordPress logo.
 *
 * @return void
 */
function phx_after_dark_login_logo(): void {
	printf(
		'<style>
			#login h1 a {
				background-image: url(%s);
				background-size: contain;
				width: 100%%;
				height: 64px;
			}
			body.login { background: #0b0b12; }
			body.login a { color: #12f7c0; }
			body.login #nav a, body.login #backtoblog a { color: #b9b9c6; }
		</style>' . "\n",
		esc_url( get_stylesheet_directory_uri() . '/assets/images/phx-logo.svg' )
	);
}
add_action( 'login_head', 'phx_after_dark_login_logo' );

/**
 * Point the login logo at the site rather than wordpress.org.
 *
 * @return string
 */
function phx_after_dark_login_url(): string {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'phx_after_dark_login_url' );

/**
 * A member-aware "join" call to action for use in navigation menus.
 *
 * Registered as a shortcode so it can be dropped into a menu item, a widget, or
 * a block without the theme needing its own template part for it.
 *
 * @return string
 */
function phx_after_dark_join_cta(): string {
	$is_member = function_exists( 'phx_events_user_is_member' ) && phx_events_user_is_member();

	if ( $is_member ) {
		return sprintf(
			'<a class="phx-button phx-button--ghost" href="%s">%s</a>',
			esc_url( home_url( '/account/' ) ),
			esc_html__( 'Your account', 'phx-after-dark' )
		);
	}

	return sprintf(
		'<a class="phx-button phx-button--primary" href="%s">%s</a>',
		esc_url( home_url( '/membership/' ) ),
		esc_html__( 'Join', 'phx-after-dark' )
	);
}
add_shortcode( 'phx_join_cta', 'phx_after_dark_join_cta' );
