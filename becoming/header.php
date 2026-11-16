<?php
/**
 * Header - Becoming.
 *
 * Overrides the parent's header.php. Three reasons, all of them structural
 * rather than cosmetic:
 *
 * 1. The flag hairline and the aurora need real elements; they cannot be
 *    attached to the parent's markup from a stylesheet.
 * 2. The colour-scheme control has to sit inside the header, and the parent
 *    exposes no hook anywhere in its templates (there is exactly one
 *    do_action in the whole theme, and it is wp_enqueue_scripts).
 * 3. The parent's burger is a Bootstrap background-image tinted for light
 *    navbars, which vanishes on the dark canvas. This draws it from
 *    currentColor instead.
 *
 * Everything else defers to the parent's own functions, so a change there
 * still flows through: wpwisebones_site_branding(), wpwisebones_primary_nav(),
 * its header-widgets sidebar and its container-width theme mod.
 *
 * @package Becoming
 */

defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="color-scheme" content="light dark">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$becoming_options = get_option( 'wpwisebones_options', array() );

if ( ! empty( $becoming_options['preloader'] ) ) :
	?>
<div id="wpb-preloader" role="status" aria-label="<?php esc_attr_e( 'Loading', 'becoming' ); ?>">
	<div class="spinner-border" role="status">
		<span class="visually-hidden"><?php esc_html_e( 'Loading...', 'becoming' ); ?></span>
	</div>
</div>
<?php endif; ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'becoming' ); ?></a>

<?php
// Top bar.
if ( get_theme_mod( 'wpwisebones_show_topbar', false ) ) :
	$becoming_topbar = get_theme_mod( 'wpwisebones_topbar_text', '' );

	if ( $becoming_topbar ) :
		?>
<div class="wpb-topbar">
	<div class="container text-center"><?php echo wp_kses_post( $becoming_topbar ); ?></div>
</div>
		<?php
	endif;
endif;

$becoming_container = get_theme_mod( 'wpwisebones_container_width', 'container' );
?>

<?php
/*
 * `navbar navbar-expand-lg` is load-bearing, not decoration. Bootstrap's
 * `.collapse:not(.show) { display: none }` keeps the menu hidden at every
 * width unless an ancestor carries navbar-expand-*, which is what supplies
 * the `display: flex !important` above the breakpoint. Dropping these classes
 * left the whole navigation behind the burger on a 1200px desktop.
 */
?>
<header id="masthead" class="site-header navbar navbar-expand-lg">
	<span class="bc-flagline" aria-hidden="true"></span>

	<div class="<?php echo esc_attr( $becoming_container ); ?> bc-header-inner">

		<div class="site-branding">
			<?php if ( ! has_custom_logo() ) : ?>
				<span class="bc-mark" aria-hidden="true"></span>
			<?php endif; ?>

			<div>
				<?php wpwisebones_site_branding(); ?>
				<?php if ( display_header_text() && get_bloginfo( 'description' ) ) : ?>
					<p class="site-description d-none d-lg-block"><?php bloginfo( 'description' ); ?></p>
				<?php endif; ?>
			</div>
		</div>

		<button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
				data-bs-target="#primaryNavbar" aria-controls="primaryNavbar"
				aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'becoming' ); ?>">
			<span class="bc-burger" aria-hidden="true"><span></span><span></span><span></span></span>
		</button>

		<div class="collapse navbar-collapse" id="primaryNavbar">
			<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Primary menu', 'becoming' ); ?>">
				<?php becoming_primary_nav(); ?>
			</nav>

			<?php if ( is_active_sidebar( 'header-widgets' ) ) : ?>
				<div class="header-widget-area d-flex align-items-center">
					<?php dynamic_sidebar( 'header-widgets' ); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php
		/*
		 * Rendered with both labels present and one hidden per theme in CSS,
		 * rather than picked in PHP. The server cannot know the visitor's
		 * system preference, and a cached page would otherwise serve the wrong
		 * label to half its readers.
		 */
		?>
		<button type="button" class="bc-theme-toggle" data-bc-theme-toggle
				aria-label="<?php esc_attr_e( 'Switch colour scheme', 'becoming' ); ?>">
			<svg class="bc-icon-sun" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<circle cx="12" cy="12" r="4.2"></circle>
				<path d="M12 2.6v2.2M12 19.2v2.2M2.6 12h2.2M19.2 12h2.2M5.4 5.4l1.6 1.6M17 17l1.6 1.6M18.6 5.4L17 7M7 17l-1.6 1.6"></path>
			</svg>
			<svg class="bc-icon-moon" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
				<path d="M20.5 14.3A8.6 8.6 0 1 1 9.7 3.5a6.9 6.9 0 0 0 10.8 10.8z"></path>
			</svg>
			<span><?php esc_html_e( 'Theme', 'becoming' ); ?></span>
		</button>
	</div>
</header><!-- #masthead -->

<div id="page" class="site">

<?php becoming_pagehead(); ?>
<?php becoming_section_nav(); ?>
