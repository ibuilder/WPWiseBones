<?php
/**
 * Title: Board hero
 * Slug: antivig/board-hero
 * Categories: antivig
 * Description: Front-page opener — the promise, the two calls to action, and the honesty line.
 *
 * @package Antivig
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;
?>
<!-- wp:group {"align":"full","backgroundColor":"ink","textColor":"chalk","style":{"spacing":{"padding":{"top":"4rem","bottom":"4rem"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-chalk-color has-ink-background-color has-text-color has-background" style="padding-top:4rem;padding-bottom:4rem">

	<!-- wp:paragraph {"style":{"typography":{"textTransform":"uppercase","letterSpacing":"0.12em","fontSize":"0.75rem","fontWeight":"600"}},"textColor":"ember"} -->
	<p class="has-ember-color has-text-color" style="font-size:0.75rem;font-weight:600;letter-spacing:0.12em;text-transform:uppercase"><?php echo esc_html__( 'Pregame analysis · NBA · NFL · MLB · WNBA · Tennis', 'antivig-child' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:heading {"level":1,"fontSize":"xx-large"} -->
	<h1 class="wp-block-heading has-xx-large-font-size"><?php echo esc_html__( 'Know the fair price before you bet', 'antivig-child' ); ?></h1>
	<!-- /wp:heading -->

	<!-- wp:paragraph {"fontSize":"large"} -->
	<p class="has-large-font-size"><?php echo esc_html__( 'Every game, priced with the bookmaker\'s margin removed, next to the best number on the board and how it moved. Every pick we publish goes on a record that cannot be edited afterwards.', 'antivig-child' ); ?></p>
	<!-- /wp:paragraph -->

	<!-- wp:buttons -->
	<div class="wp-block-buttons">
		<!-- wp:button {"backgroundColor":"ember","textColor":"ink"} -->
		<div class="wp-block-button"><a class="wp-block-button__link has-ink-color has-ember-background-color has-text-color has-background wp-element-button" href="/today/"><?php echo esc_html__( 'See today\'s board', 'antivig-child' ); ?></a></div>
		<!-- /wp:button -->

		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="/ledger/"><?php echo esc_html__( 'Read the pick record', 'antivig-child' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

	<!-- wp:paragraph {"fontSize":"small","textColor":"steel"} -->
	<p class="has-steel-color has-text-color has-small-font-size"><?php echo esc_html__( '21+ · Antivig is not a sportsbook and takes no wagers · Past results don\'t guarantee future results', 'antivig-child' ); ?></p>
	<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
