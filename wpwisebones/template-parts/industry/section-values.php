<?php
/**
 * "Why us" split: copy and a checklist on one side, a highlight panel on the
 * other.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
if ( empty( $wpwisebones_section['heading'] ) ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-values wpb-ind-section--alt" id="why">
	<div class="container">
		<div class="row g-5 align-items-center">
			<div class="col-lg-6">
				<?php wpwisebones_industry_heading( $wpwisebones_section, 'start' ); ?>
				<?php if ( ! empty( $wpwisebones_section['points'] ) ) : ?>
					<ul class="wpb-ind-checklist wpb-ind-checklist--lg">
						<?php foreach ( (array) $wpwisebones_section['points'] as $wpwisebones_point ) : ?>
							<li><i class="bi bi-check-lg" aria-hidden="true"></i><span><strong><?php echo esc_html( $wpwisebones_point[0] ); ?></strong><?php if ( ! empty( $wpwisebones_point[1] ) ) : ?> <?php echo esc_html( $wpwisebones_point[1] ); ?><?php endif; ?></span></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php
				if ( ! empty( $wpwisebones_section['button'] ) ) {
					wpwisebones_industry_button( (array) $wpwisebones_section['button'], 'btn btn-primary mt-2' );
				}
				?>
			</div>
			<?php if ( ! empty( $wpwisebones_section['highlight'] ) ) : ?>
				<?php $wpwisebones_hl = (array) $wpwisebones_section['highlight']; ?>
				<div class="col-lg-6">
					<div class="wpb-ind-highlight">
						<?php if ( ! empty( $wpwisebones_hl['icon'] ) ) : ?>
							<i class="bi <?php echo esc_attr( $wpwisebones_hl['icon'] ); ?> wpb-ind-highlight__icon" aria-hidden="true"></i>
						<?php endif; ?>
						<p class="wpb-ind-highlight__title"><?php echo esc_html( isset( $wpwisebones_hl['title'] ) ? $wpwisebones_hl['title'] : '' ); ?></p>
						<p class="wpb-ind-highlight__text"><?php echo esc_html( isset( $wpwisebones_hl['text'] ) ? $wpwisebones_hl['text'] : '' ); ?></p>
						<?php if ( ! empty( $wpwisebones_hl['tags'] ) ) : ?>
							<ul class="wpb-ind-chips">
								<?php foreach ( (array) $wpwisebones_hl['tags'] as $wpwisebones_tag ) : ?>
									<li><?php echo esc_html( $wpwisebones_tag ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
