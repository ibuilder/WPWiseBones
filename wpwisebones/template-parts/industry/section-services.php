<?php
/**
 * Services grid. Published Services from the Industry Kit replace the
 * config's list as soon as there is at least one.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_items   = array();

foreach ( wpwisebones_industry_items( 'service', 9 ) as $wpwisebones_post ) {
	$wpwisebones_icon    = wpwisebones_industry_meta( $wpwisebones_post->ID, 'icon' );
	$wpwisebones_items[] = array(
		$wpwisebones_icon ? $wpwisebones_icon : 'bi-check2-square',
		get_the_title( $wpwisebones_post ),
		get_the_excerpt( $wpwisebones_post ),
		get_permalink( $wpwisebones_post ),
	);
}
if ( ! $wpwisebones_items && ! empty( $wpwisebones_section['items'] ) ) {
	$wpwisebones_items = (array) $wpwisebones_section['items'];
}
if ( ! $wpwisebones_items ) {
	return;
}
$wpwisebones_cols = count( $wpwisebones_items ) % 4 === 0 ? 'col-md-6 col-lg-3' : 'col-md-6 col-lg-4';
?>
<section class="wpb-ind-section wpb-ind-services" id="services">
	<div class="container">
		<?php wpwisebones_industry_heading( $wpwisebones_section ); ?>
		<div class="row g-4">
			<?php foreach ( $wpwisebones_items as $wpwisebones_item ) : ?>
				<div class="<?php echo esc_attr( $wpwisebones_cols ); ?>">
					<div class="wpb-ind-card wpb-ind-service">
						<span class="wpb-ind-icon"><i class="bi <?php echo esc_attr( $wpwisebones_item[0] ); ?>" aria-hidden="true"></i></span>
						<h3 class="wpb-ind-card__title">
							<?php if ( ! empty( $wpwisebones_item[3] ) ) : ?>
								<a class="stretched-link" href="<?php echo esc_url( wpwisebones_industry_url( (string) $wpwisebones_item[3] ) ); ?>"><?php echo esc_html( $wpwisebones_item[1] ); ?></a>
							<?php else : ?>
								<?php echo esc_html( $wpwisebones_item[1] ); ?>
							<?php endif; ?>
						</h3>
						<p><?php echo esc_html( $wpwisebones_item[2] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
		<?php if ( ! empty( $wpwisebones_section['button'] ) ) : ?>
			<p class="text-center mt-5 mb-0"><?php wpwisebones_industry_button( (array) $wpwisebones_section['button'], 'btn btn-outline-primary' ); ?></p>
		<?php endif; ?>
	</div>
</section>
