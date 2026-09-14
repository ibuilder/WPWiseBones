<?php
/**
 * Title: PHX After Dark membership call to action
 * Slug: phx-after-dark/membership-cta
 * Categories: phx-after-dark, call-to-action
 * Description: Value proposition strip with the plan chooser block underneath.
 *
 * @package PHXAfterDark
 */

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"tagName":"section","layout":{"type":"constrained"}} -->
<section class="wp-block-group">
	<!-- wp:heading {"level":2} -->
	<h2 class="wp-block-heading"><?php esc_html_e( 'What a membership actually gets you', 'phx-after-dark' ); ?></h2>
	<!-- /wp:heading -->

	<!-- wp:columns -->
	<div class="wp-block-columns">
		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'The whole catalogue', 'phx-after-dark' ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Every approved listing across the metro, not a sample — searchable by date, city, neighborhood, category, price, age, indoor or outdoor, accessibility, and distance from your ZIP.', 'phx-after-dark' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'Curation, not a firehose', 'phx-after-dark' ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Tonight, This Weekend, Date Night, Family and Free collections rebuilt every night, plus editor picks chosen by people who actually go to these things.', 'phx-after-dark' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->

		<!-- wp:column -->
		<div class="wp-block-column">
			<!-- wp:heading {"level":3,"fontSize":"large"} -->
			<h3 class="wp-block-heading has-large-font-size"><?php esc_html_e( 'It remembers for you', 'phx-after-dark' ); ?></h3>
			<!-- /wp:heading -->

			<!-- wp:paragraph -->
			<p><?php esc_html_e( 'Save anything and get a reminder the evening before — including when an organizer cancels or moves it. Opt in or out of every email individually.', 'phx-after-dark' ); ?></p>
			<!-- /wp:paragraph -->
		</div>
		<!-- /wp:column -->
	</div>
	<!-- /wp:columns -->

	<!-- wp:phx-events/membership-plans /-->

	<!-- wp:paragraph {"className":"phx-note"} -->
	<p class="phx-note"><?php esc_html_e( 'Your membership buys access to this guide. It is not a ticket: events are run by third parties, and their pricing, availability, age limits and cancellation policies are theirs.', 'phx-after-dark' ); ?></p>
	<!-- /wp:paragraph -->
</section>
<!-- /wp:group -->
