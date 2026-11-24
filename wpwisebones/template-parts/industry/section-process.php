<?php
/**
 * Numbered process steps.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
if ( empty( $wpwisebones_section['steps'] ) ) {
	return;
}
$wpwisebones_steps = (array) $wpwisebones_section['steps'];
$wpwisebones_cols  = 4 === count( $wpwisebones_steps ) ? 'col-md-6 col-lg-3' : 'col-md-4';
?>
<section class="wpb-ind-section wpb-ind-process" id="process">
	<div class="container">
		<?php wpwisebones_industry_heading( $wpwisebones_section ); ?>
		<ol class="row g-4 list-unstyled wpb-ind-steps">
			<?php foreach ( $wpwisebones_steps as $wpwisebones_i => $wpwisebones_step ) : ?>
				<li class="<?php echo esc_attr( $wpwisebones_cols ); ?>">
					<div class="wpb-ind-step">
						<span class="wpb-ind-step__num" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $wpwisebones_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<h3 class="wpb-ind-card__title"><?php echo esc_html( $wpwisebones_step[0] ); ?></h3>
						<p><?php echo esc_html( $wpwisebones_step[1] ); ?></p>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
