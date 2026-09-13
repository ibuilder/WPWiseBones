<?php
/**
 * Antivig child theme.
 *
 * Parent theme: WPWiseBones — a classic, Bootstrap 5.3 starter theme with no
 * hooks of its own. Everything below extends it through WordPress core hooks,
 * the parent's `theme_mod_wpwisebones_*` filters, and CSS layering. The
 * approach follows the PHX After Dark child theme, which is the only one of the
 * three existing WPWiseBones children that loads the parent's CSS correctly.
 *
 * @package Antivig
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

const ANTIVIG_THEME_VERSION = '0.4.1';

require_once get_stylesheet_directory() . '/inc/navigation.php';
require_once get_stylesheet_directory() . '/inc/pwa.php';

/**
 * Theme setup.
 *
 * Menu locations are additive. WPWiseBones already registers `primary`,
 * `footer`, `topbar` and `mobile`, and its header.php renders `primary`;
 * registering a second general-purpose menu would only give the owner two that
 * look interchangeable.
 *
 * @return void
 */
function antivig_setup(): void {
	load_theme_textdomain( 'antivig-child', get_stylesheet_directory() . '/languages' );

	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'html5', [ 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ] );

	add_editor_style( 'assets/css/antivig.css' );

	register_nav_menus(
		[
			'antivig-member' => __( 'Member navigation', 'antivig-child' ),
			'antivig-sports' => __( 'Sports', 'antivig-child' ),
			'antivig-legal'  => __( 'Legal footer', 'antivig-child' ),
		]
	);
}
add_action( 'after_setup_theme', 'antivig_setup', 20 );

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
 * style.css — the parent's base rules never loaded at all. Registering the
 * parent sheet separately is only half the fix there: enqueueing it later would
 * also print it later, and the parent would then override the child. Declaring
 * it as a dependency of the already-enqueued child handle pins the order to
 * parent → child no matter when each is enqueued.
 *
 * @return void
 */
function antivig_enqueue(): void {
	// Present only on WPWiseBones 1.0.13+, where the parent orders the sheets
	// itself. Re-registering the parent sheet there would print it twice.
	$parent_orders_cascade = wp_style_is( 'wpwisebones-child-style', 'registered' );

	if ( ! $parent_orders_cascade ) {
		$parent_version = (string) wp_get_theme( get_template() )->get( 'Version' );

		wp_enqueue_style(
			'antivig-parent',
			get_template_directory_uri() . '/style.css',
			wp_style_is( 'bootstrap', 'registered' ) ? [ 'bootstrap' ] : [],
			$parent_version
		);

		$child_sheet = wp_styles()->query( 'wpwisebones-style' );

		if ( $child_sheet ) {
			if ( ! in_array( 'antivig-parent', $child_sheet->deps, true ) ) {
				$child_sheet->deps[] = 'antivig-parent';
			}

			/*
			 * On those parents that handle's URL is get_stylesheet_uri() — this
			 * theme's style.css — but the parent versions it with the *parent's*
			 * version. So every change to this file shipped under an unchanged
			 * URL, and browsers and proxies kept serving the copy they already
			 * had. It cost an hour of chasing a phantom contrast bug that had in
			 * fact been fixed three deploys earlier. The file is ours; the
			 * version has to be ours too.
			 */
			$child_sheet->ver = ANTIVIG_THEME_VERSION;
		}
	}

	// Declaring the parent and plugin stylesheets as dependencies where they
	// exist is what keeps the brand layer cascading after their own defaults.
	$deps = [];

	foreach ( [ 'antivig-parent', 'wpwisebones-style', 'wpwisebones-main', 'wpwisebones-child-style', 'antivig-membership', 'antivig-engine' ] as $handle ) {
		if ( wp_style_is( $handle, 'registered' ) ) {
			$deps[] = $handle;
		}
	}

	wp_enqueue_style(
		'antivig',
		get_stylesheet_directory_uri() . '/assets/css/antivig.css',
		$deps,
		ANTIVIG_THEME_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'antivig_enqueue', 20 );

/**
 * Drop core's emoji polyfill.
 *
 * It is eleven kilobytes of script and an inline settings blob on every page,
 * and it exists to draw emoji as images on browsers that cannot draw them as
 * text — which has not been a real browser since about 2016. Nothing on this
 * site publishes emoji, and the pages that matter are a board of numbers a
 * reader loads on a phone on the way somewhere. The character set still works
 * everywhere; only the polyfill goes.
 *
 * @return void
 */
function antivig_disable_emoji(): void {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

	add_filter(
		'wp_resource_hints',
		static function ( array $urls, string $relation ): array {
			if ( 'dns-prefetch' !== $relation ) {
				return $urls;
			}

			return array_values(
				array_filter(
					$urls,
					static fn ( $url ): bool => false === strpos( (string) $url, 's.w.org/images/core/emoji' )
				)
			);
		},
		10,
		2
	);
}
add_action( 'init', 'antivig_disable_emoji' );

/**
 * Follow the reader's system colour scheme in Bootstrap's own colour mode.
 *
 * Antivig is light first — daylight analytics, not a casino floor — but a
 * board of numbers read at night should not be a white rectangle. Bootstrap 5.3
 * switches on `data-bs-theme`, which has to be set before first paint, so this
 * is a deliberately tiny inline script rather than an enqueued file. It stores
 * nothing: the OS preference is the only signal.
 *
 * @return void
 */
function antivig_color_mode_script(): void {
	?>
	<script>
		( function () {
			try {
				if ( window.matchMedia( '(prefers-color-scheme: dark)' ).matches ) {
					document.documentElement.setAttribute( 'data-bs-theme', 'dark' );
				}
			} catch ( e ) {}
		}() );
	</script>
	<?php
}
add_action( 'wp_head', 'antivig_color_mode_script', 1 );

/**
 * Default the parent's navbar to its dark variant.
 *
 * A filter rather than a hard-coded value, so the Customizer still wins when the
 * owner picks something else. The "never set" case has to be read from
 * get_theme_mods(): WordPress runs `theme_mod_{$name}` over the caller's default
 * too, and WPWiseBones passes 'light', so an unsaved mod and a deliberate light
 * choice are indistinguishable from the filtered value alone.
 *
 * @param mixed $value Stored theme mod, or the caller's default.
 * @return mixed
 */
function antivig_header_style( $value ) {
	$mods = get_theme_mods();

	return isset( $mods['wpwisebones_header_style'] ) ? $value : 'dark';
}
add_filter( 'theme_mod_wpwisebones_header_style', 'antivig_header_style' );

/**
 * Brand defaults for the parent's colour options.
 *
 * The parent prints these into an inline stylesheet — `.site-header`,
 * `.site-footer`, `.btn-primary` and the hero gradient all read from them — so
 * setting them here is what makes the whole chrome brand-coloured, rather than
 * a Bootstrap-blue header sitting above a navy page. Overriding the printed CSS
 * from the child sheet instead would work on the front end and still leave the
 * Customizer preview showing the old colours.
 *
 * Each default only applies while the owner has never saved that option, read
 * from get_theme_mods() for the reason explained above.
 *
 * @return void
 */
function antivig_color_defaults(): void {
	$defaults = array(
		'wpwisebones_color_primary'   => '#0E1A2B',
		'wpwisebones_color_accent'    => '#F2A900',
		'wpwisebones_color_header_bg' => '#0E1A2B',
		'wpwisebones_color_footer_bg' => '#0E1A2B',

		/*
		 * The parent defaults to a blog sidebar. This site's pages are boards,
		 * pricing and a pick record — none of which wants a search box and a
		 * recent-posts list beside it, and the board in particular needs the
		 * width for its columns.
		 */
		'wpwisebones_layout'          => 'full-width',
	);

	foreach ( $defaults as $mod => $default ) {
		add_filter(
			'theme_mod_' . $mod,
			static function ( $value ) use ( $mod, $default ) {
				$mods = get_theme_mods();

				if ( isset( $mods[ $mod ] ) && '' !== $mods[ $mod ] ) {
					return $value;
				}

				return $default;
			}
		);
	}
}
add_action( 'after_setup_theme', 'antivig_color_defaults', 21 );

/**
 * A slim member bar above the parent's navbar.
 *
 * WPWiseBones exposes no action hooks inside header.php, so `wp_body_open` is
 * the only insertion point that does not mean copying the parent template
 * wholesale. Above the navbar is where a status strip belongs anyway.
 *
 * @return void
 */
function antivig_member_bar(): void {
	if ( is_admin() || is_customize_preview() ) {
		return;
	}

	printf(
		'<div class="av-memberbar"><div class="container d-flex align-items-center justify-content-between gap-3">' .
		'<span class="av-memberbar__tagline">%1$s</span>' .
		'<span class="av-memberbar__actions">%2$s</span>' .
		'</div></div>' . "\n",
		esc_html__( 'Fair prices, best lines, and every pick on the record', 'antivig-child' ),
		wp_kses_post( antivig_join_cta() )
	);
}
add_action( 'wp_body_open', 'antivig_member_bar' );

/**
 * The responsible-gambling strip, on every page.
 *
 * This is a launch requirement, not decoration, so it is printed by the theme
 * rather than left to a widget an owner could remove by accident. The helpline
 * and the "not a sportsbook" line appear wherever the site is read.
 *
 * @return void
 */
function antivig_responsible_gambling_strip(): void {
	if ( is_admin() ) {
		return;
	}

	printf(
		'<div class="av-rg"><div class="container av-rg__inner">' .
		'<span class="av-rg__age">%1$s</span>' .
		'<span>%2$s <a class="av-rg__line" href="tel:1-800-426-2537">%3$s</a></span>' .
		'<span>%4$s</span>' .
		'<span>%5$s</span>' .
		'</div></div>' . "\n",
		esc_html__( '21+', 'antivig-child' ),
		esc_html__( 'Gambling problem? Call', 'antivig-child' ),
		esc_html__( '1-800-GAMBLER', 'antivig-child' ),
		esc_html__( 'Antivig is not a sportsbook', 'antivig-child' ),
		esc_html__( "Past results don't guarantee future results", 'antivig-child' )
	);
}
add_action( 'wp_footer', 'antivig_responsible_gambling_strip', 5 );

/**
 * Add the SVG favicon when no site icon is set.
 *
 * @return void
 */
function antivig_favicon(): void {
	if ( has_site_icon() ) {
		return;
	}

	printf(
		'<link rel="icon" href="%s" type="image/svg+xml">' . "\n",
		esc_url( get_stylesheet_directory_uri() . '/assets/images/favicon.svg' )
	);
}
add_action( 'wp_head', 'antivig_favicon' );

/**
 * Register the theme's pattern category.
 *
 * @return void
 */
function antivig_pattern_category(): void {
	if ( ! function_exists( 'register_block_pattern_category' ) ) {
		return;
	}

	register_block_pattern_category(
		'antivig',
		[ 'label' => __( 'Antivig', 'antivig-child' ) ]
	);
}
add_action( 'init', 'antivig_pattern_category' );

/**
 * Body classes that let the stylesheet target member and public states.
 *
 * @param array<int,string> $classes Body classes.
 * @return array<int,string>
 */
function antivig_body_class( array $classes ): array {
	$classes[] = 'av-theme';

	if ( function_exists( 'antivig_user_can' ) && antivig_user_can( 'model_picks' ) ) {
		$classes[] = 'av-theme--member';
	}

	return $classes;
}
add_filter( 'body_class', 'antivig_body_class' );

/**
 * Brand the login screen.
 *
 * @return void
 */
function antivig_login_logo(): void {
	printf(
		'<style>
			#login h1 a {
				background-image: url(%s);
				background-size: contain;
				background-position: center;
				width: 100%%;
				height: 64px;
			}
			body.login { background: #F4F6F3; }
			body.login a { color: #8A5F00; }
			body.login #nav a, body.login #backtoblog a { color: #5A6B80; }

			/*
			 * The membership plugin puts what this site is, and the 21+ line,
			 * above the sign-up form. Core styles .message as a blue-bordered
			 * strip meant for one short sentence; this is several, and it is
			 * the only thing a person reads before committing to an account.
			 */
			body.login .av-register-notice {
				border-left: 4px solid #F2A900;
				background: #fff;
				padding: 14px 18px;
				margin-bottom: 20px;
				font-size: 13px;
				line-height: 1.6;
				color: #0E1A2B;
				box-shadow: 0 1px 1px rgba(14,26,43,.06);
			}
			body.login .av-register-notice p { margin: 0 0 .7em; }
			body.login .av-register-notice p:last-child { margin-bottom: 0; }
		</style>' . "\n",
		esc_url( get_stylesheet_directory_uri() . '/assets/images/antivig-logo.svg' )
	);
}
add_action( 'login_head', 'antivig_login_logo' );

/**
 * Point the login logo at the site rather than wordpress.org.
 *
 * @return string
 */
function antivig_login_url(): string {
	return home_url( '/' );
}
add_filter( 'login_headerurl', 'antivig_login_url' );

/**
 * Where one of the Antivig pages actually lives.
 *
 * Each plugin records the ID of the page it created, so it is the only thing
 * that knows for certain. The theme asks rather than assuming a slug: the
 * site-wide call to action assumed `/pricing/`, which has never existed, and
 * returned a 404 on every page until somebody thought to click it.
 *
 * @param string $key One of: membership, account, today, ledger.
 * @return string
 */
function antivig_url( string $key ): string {
	if ( in_array( $key, array( 'membership', 'account' ), true ) && function_exists( 'antivig_page_url' ) ) {
		return antivig_page_url( $key );
	}

	if ( in_array( $key, array( 'today', 'ledger' ), true ) && function_exists( 'antivig_engine_page_url' ) ) {
		return antivig_engine_page_url( $key );
	}

	return home_url( '/' . $key . '/' );
}

/**
 * A membership-aware call to action.
 *
 * Falls back to the join link whenever the membership plugin is inactive, so a
 * theme-only install still renders something sensible.
 *
 * Deliberately not a shortcode. It was one, and a shortcode that reads
 * membership state belongs to the membership plugin: content written with it
 * would render as literal square brackets the moment the theme changed, which
 * is a poor trade for a link the templates can call directly.
 *
 * @return string
 */
function antivig_join_cta(): string {
	$is_member = function_exists( 'antivig_user_can' ) && antivig_user_can( 'model_picks' );
	$key       = $is_member ? 'account' : 'membership';

	/*
	 * Ask the plugin where its own page is rather than hard-coding a path. This
	 * link is in the bar on every page of the site, and it spent its whole life
	 * pointing at /pricing/ while the page has always been /membership/ — a 404
	 * on the single call to action the business runs on, in the one place it is
	 * hardest to notice, because the front page's own button used a different
	 * variable and worked.
	 */
	$url = antivig_url( $key );

	if ( $is_member ) {
		return sprintf(
			'<a class="av-button av-button--ghost" href="%s">%s</a>',
			esc_url( $url ),
			esc_html__( 'Your account', 'antivig-child' )
		);
	}

	return sprintf(
		'<a class="av-button av-button--primary" href="%s">%s</a>',
		esc_url( $url ),
		esc_html__( 'See the plans', 'antivig-child' )
	);
}
