<?php
/**
 * Hero panel: request a quote. Uses the Industry Kit's lead form when the
 * plugin is active; otherwise a checklist card with a link to the contact page.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_hero  = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_quote = isset( $wpwisebones_hero['quote'] ) ? (array) $wpwisebones_hero['quote'] : array();
$wpwisebones_title = isset( $wpwisebones_quote['title'] ) ? $wpwisebones_quote['title'] : __( 'Request a free estimate', 'wpwisebones' );
?>
<div class="wpb-ind-panel wpb-ind-quote">
	<h2 class="wpb-ind-panel__title"><?php echo esc_html( $wpwisebones_title ); ?></h2>
	<?php if ( ! empty( $wpwisebones_quote['text'] ) ) : ?>
		<p class="wpb-ind-panel__text"><?php echo esc_html( $wpwisebones_quote['text'] ); ?></p>
	<?php endif; ?>
	<?php if ( shortcode_exists( 'wbik_lead_form' ) ) : ?>
		<?php echo do_shortcode( '[wbik_lead_form compact="1" title=""]' ); ?>
	<?php else : ?>
		<?php if ( ! empty( $wpwisebones_quote['points'] ) ) : ?>
			<ul class="wpb-ind-checklist">
				<?php foreach ( (array) $wpwisebones_quote['points'] as $wpwisebones_point ) : ?>
					<li><i class="bi bi-check-lg" aria-hidden="true"></i><?php echo esc_html( $wpwisebones_point ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<?php wpwisebones_industry_button( isset( $wpwisebones_quote['button'] ) ? (array) $wpwisebones_quote['button'] : array( __( 'Get my estimate', 'wpwisebones' ), '/contact/' ), 'btn btn-primary btn-lg w-100' ); ?>
	<?php endif; ?>
</div>
