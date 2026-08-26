<?php
/**
 * Enqueue scripts and styles.
 *
 * Bootstrap is served from local vendor/ (WP.org Guideline 8 — no remote CDN assets).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'wpwisebones_enqueue_assets' );

function wpwisebones_enqueue_assets() {
	$v      = WPWISEBONES_VERSION;
	$vendor = WPWISEBONES_URI . '/assets/vendor';

	/* â"€â"€ Bootstrap 5 CSS â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_enqueue_style(
		'bootstrap',
		$vendor . '/css/bootstrap.min.css',
		array(),
		'5.3.3'
	);

	/* â"€â"€ Bootstrap Icons â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_enqueue_style(
		'bootstrap-icons',
		$vendor . '/css/bootstrap-icons.min.css',
		array(),
		'1.11.3'
	);
	$font_url = $vendor . '/fonts/bootstrap-icons';
	$inline   = "@font-face { font-family: 'bootstrap-icons'; src: url('" . esc_url( $font_url . '.woff2' ) . "') format('woff2'), url('" . esc_url( $font_url . '.woff' ) . "') format('woff'); }";
	wp_add_inline_style( 'bootstrap-icons', $inline );

	/* â"€â"€ Theme stylesheet (style.css) â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_enqueue_style( 'wpwisebones-style', get_stylesheet_uri(), array( 'bootstrap' ), $v );

	/* â"€â"€ Custom theme CSS â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_enqueue_style( 'wpwisebones-main', WPWISEBONES_URI . '/assets/css/main.css', array( 'wpwisebones-style' ), $v );

	/* â"€â"€ Bootstrap 5 JS bundle â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_enqueue_script(
		'bootstrap',
		$vendor . '/js/bootstrap.bundle.min.js',
		array(),
		'5.3.3',
		true
	);

	/* â"€â"€ Theme main JS â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_enqueue_script( 'wpwisebones-main', WPWISEBONES_URI . '/assets/js/main.js', array( 'bootstrap' ), $v, true );

	/* â"€â"€ Pass data to JS â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	wp_localize_script(
		'wpwisebones-main',
		'wpwisebonesData',
		array(
			'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
			'nonce'    => wp_create_nonce( 'wpwisebones_nonce' ),
			'siteUrl'  => home_url(),
			'themeUrl' => WPWISEBONES_URI,
			'i18n'     => array(
				'loading' => __( 'Loadingâ€¦', 'wpwisebones' ),
				'error'   => __( 'An error occurred.', 'wpwisebones' ),
			),
		)
	);

	/* â"€â"€ Comments reply script â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

/* â"€â"€ Admin enqueue â€" only on theme-related admin pages â"€â"€â"€â"€â"€â"€â"€â"€â"€â"€ */
add_action( 'admin_enqueue_scripts', 'wpwisebones_admin_enqueue' );

function wpwisebones_admin_enqueue( string $hook ) {
	$theme_hooks = array(
		'appearance_page_wpwisebones-theme-options',
		'post.php',
		'post-new.php',
		'widgets.php',
		'customize.php',
	);
	if ( ! in_array( $hook, $theme_hooks, true ) ) {
		return;
	}

	wp_enqueue_style( 'wpwisebones-admin', WPWISEBONES_URI . '/assets/css/admin.css', array(), WPWISEBONES_VERSION );
	wp_enqueue_script( 'wpwisebones-admin', WPWISEBONES_URI . '/assets/js/admin.js', array( 'jquery' ), WPWISEBONES_VERSION, true );
}

/* -- Customizer preview JS (postMessage live updates) -- */
add_action( 'customize_preview_init', 'wpwisebones_customizer_preview_js' );

function wpwisebones_customizer_preview_js() {
	wp_enqueue_script(
		'wpwisebones-customizer',
		WPWISEBONES_URI . '/assets/js/customizer.js',
		array( 'customize-preview', 'jquery' ),
		WPWISEBONES_VERSION,
		true
	);
}
