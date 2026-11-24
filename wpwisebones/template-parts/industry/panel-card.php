<?php
/**
 * Hero panel: a spec card — a kicker, a title and key/value rows. Good for
 * capabilities, delivery methods or a closing checklist.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_hero = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_card = isset( $wpwisebones_hero['card'] ) ? (array) $wpwisebones_hero['card'] : array();
?>
<div class="wpb-ind-panel wpb-ind-card-panel">
	<?php if ( ! empty( $wpwisebones_card['kicker'] ) ) : ?>
		<span class="wpb-ind-panel__kicker"><?php echo esc_html( $wpwisebones_card['kicker'] ); ?></span>
	<?php endif; ?>
	<?php if ( ! empty( $wpwisebones_card['title'] ) ) : ?>
		<h2 class="wpb-ind-panel__title"><?php echo esc_html( $wpwisebones_card['title'] ); ?></h2>
	<?php endif; ?>
	<?php if ( ! empty( $wpwisebones_card['rows'] ) ) : ?>
		<dl class="wpb-ind-spec">
			<?php foreach ( (array) $wpwisebones_card['rows'] as $wpwisebones_row ) : ?>
				<div class="wpb-ind-spec__row">
					<dt><?php if ( ! empty( $wpwisebones_row[2] ) ) : ?><i class="bi <?php echo esc_attr( $wpwisebones_row[2] ); ?>" aria-hidden="true"></i><?php endif; ?><?php echo esc_html( $wpwisebones_row[0] ); ?></dt>
					<dd><?php echo esc_html( $wpwisebones_row[1] ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	<?php endif; ?>
	<?php
	if ( ! empty( $wpwisebones_card['button'] ) ) {
		wpwisebones_industry_button( (array) $wpwisebones_card['button'], 'btn btn-primary w-100 mt-2' );
	}
	?>
</div>
