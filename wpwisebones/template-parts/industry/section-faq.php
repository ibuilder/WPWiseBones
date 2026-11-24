<?php
/**
 * Frequently asked questions, as a Bootstrap accordion.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
if ( empty( $wpwisebones_section['items'] ) ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-faq" id="faq">
	<div class="container">
		<div class="row g-4 g-lg-5">
			<div class="col-lg-4">
				<?php wpwisebones_industry_heading( $wpwisebones_section, 'start' ); ?>
			</div>
			<div class="col-lg-8">
				<div class="accordion wpb-ind-accordion" id="wpb-ind-faq">
					<?php foreach ( (array) $wpwisebones_section['items'] as $wpwisebones_i => $wpwisebones_item ) : ?>
						<?php $wpwisebones_fid = 'wpb-ind-faq-' . $wpwisebones_i; ?>
						<div class="accordion-item">
							<h3 class="accordion-header">
								<button class="accordion-button<?php echo $wpwisebones_i ? ' collapsed' : ''; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#<?php echo esc_attr( $wpwisebones_fid ); ?>" aria-expanded="<?php echo $wpwisebones_i ? 'false' : 'true'; ?>" aria-controls="<?php echo esc_attr( $wpwisebones_fid ); ?>">
									<?php echo esc_html( $wpwisebones_item[0] ); ?>
								</button>
							</h3>
							<div id="<?php echo esc_attr( $wpwisebones_fid ); ?>" class="accordion-collapse collapse<?php echo $wpwisebones_i ? '' : ' show'; ?>" data-bs-parent="#wpb-ind-faq">
								<div class="accordion-body"><?php echo esc_html( $wpwisebones_item[1] ); ?></div>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
