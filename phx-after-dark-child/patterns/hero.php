<?php
/**
 * Title: PHX After Dark hero
 * Slug: phx-after-dark/hero
 * Categories: phx-after-dark, banner
 * Description: Homepage hero with the value proposition and a membership call to action.
 *
 * @package PHXAfterDark
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","className":"phx-hero","layout":{"type":"constrained"}} -->
<section class="wp-block-group phx-hero">
	<!-- wp:paragraph {"className":"phx-eyebrow"} -->
	<p class="phx-eyebrow"><?php esc_html_e( 'Phoenix · Scottsdale · Tempe · Mesa · Chandler', 'phx-after-dark' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"className":"phx-hero__title"} -->
	<h1 class="wp-block-heading phx-hero__title"><?php echo wp_kses_post( __( 'Everything worth doing in the Valley, <em>after dark</em>.', 'phx-after-dark' ) ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"className":"phx-hero__lede"} -->
	<p class="phx-hero__lede"><?php esc_html_e( 'A curated, human-checked guide to Phoenix metro events — pulled from official calendars, organizer feeds and partner sources, normalized to one place, and filtered the way you actually plan a night out.', 'phx-after-dark' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons {"layout":{"type":"flex"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button -->
		<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="/membership/"><?php esc_html_e( 'See membership options', 'phx-after-dark' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/events/"><?php esc_html_e( 'Browse a few free listings', 'phx-after-dark' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:paragraph {"className":"phx-footer__disclosure"} -->
	<p class="phx-footer__disclosure"><?php esc_html_e( 'We aggregate and curate event information. We are not the organizer, and we do not sell tickets to third-party events.', 'phx-after-dark' ); ?></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
