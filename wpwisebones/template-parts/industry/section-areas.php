<?php
/**
 * Service areas / neighborhoods. Uses the Industry Kit's Service Area terms
 * when any exist, otherwise the config's list.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_areas   = array();

if ( taxonomy_exists( 'wbik_area' ) ) {
	$wpwisebones_terms = get_terms(
		array(
			'taxonomy'   => 'wbik_area',
			'hide_empty' => false,
			'number'     => 24,
		)
	);
	if ( $wpwisebones_terms && ! is_wp_error( $wpwisebones_terms ) ) {
		foreach ( $wpwisebones_terms as $wpwisebones_term ) {
			$wpwisebones_link    = get_term_link( $wpwisebones_term );
			$wpwisebones_areas[] = array( $wpwisebones_term->name, is_wp_error( $wpwisebones_link ) ? '' : $wpwisebones_link );
		}
	}
}
if ( ! $wpwisebones_areas && ! empty( $wpwisebones_section['items'] ) ) {
	foreach ( (array) $wpwisebones_section['items'] as $wpwisebones_item ) {
		$wpwisebones_areas[] = array( $wpwisebones_item, '' );
	}
}
if ( ! $wpwisebones_areas ) {
	return;
}
?>
<section class="wpb-ind-section wpb-ind-areas" id="areas">
	<div class="container">
		<div class="row g-4 g-lg-5 align-items-center">
			<div class="col-lg-5">
				<?php wpwisebones_industry_heading( $wpwisebones_section, 'start' ); ?>
				<?php
				if ( ! empty( $wpwisebones_section['button'] ) ) {
					wpwisebones_industry_button( (array) $wpwisebones_section['button'], 'btn btn-outline-primary' );
				}
				?>
			</div>
			<div class="col-lg-7">
				<ul class="wpb-ind-chips wpb-ind-chips--lg">
					<?php foreach ( $wpwisebones_areas as $wpwisebones_area ) : ?>
						<li>
							<?php if ( $wpwisebones_area[1] ) : ?>
								<a href="<?php echo esc_url( $wpwisebones_area[1] ); ?>"><i class="bi bi-geo-alt" aria-hidden="true"></i> <?php echo esc_html( $wpwisebones_area[0] ); ?></a>
							<?php else : ?>
								<i class="bi bi-geo-alt" aria-hidden="true"></i> <?php echo esc_html( $wpwisebones_area[0] ); ?>
							<?php endif; ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
