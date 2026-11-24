<?php
/**
 * A project card: photo, sector, title, location and the headline numbers.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_card = isset( $args['card'] ) ? (array) $args['card'] : array();
$wpwisebones_id   = isset( $wpwisebones_card['id'] ) ? (int) $wpwisebones_card['id'] : 0;
$wpwisebones_get  = static function ( $key ) use ( $wpwisebones_card, $wpwisebones_id ) {
	if ( $wpwisebones_id ) {
		return wpwisebones_industry_meta( $wpwisebones_id, $key );
	}
	return isset( $wpwisebones_card[ $key ] ) ? (string) $wpwisebones_card[ $key ] : '';
};

$wpwisebones_sector = $wpwisebones_get( 'sector' );
if ( $wpwisebones_id && '' === $wpwisebones_sector && taxonomy_exists( 'wbik_project_sector' ) ) {
	$wpwisebones_terms  = get_the_terms( $wpwisebones_id, 'wbik_project_sector' );
	$wpwisebones_sector = $wpwisebones_terms && ! is_wp_error( $wpwisebones_terms ) ? $wpwisebones_terms[0]->name : '';
}
$wpwisebones_facts = array_filter(
	array(
		'bi-geo-alt'       => $wpwisebones_get( 'location' ),
		'bi-rulers'        => $wpwisebones_get( 'size' ),
		'bi-calendar3'     => $wpwisebones_get( 'year' ),
		'bi-person-badge'  => $wpwisebones_get( 'role' ),
	)
);
?>
<article class="wpb-ind-card wpb-ind-project<?php echo ! empty( $wpwisebones_card['sample'] ) ? ' is-sample' : ''; ?>">
	<div class="wpb-ind-media">
		<?php if ( ! empty( $wpwisebones_card['image'] ) ) : ?>
			<?php echo wp_kses_post( $wpwisebones_card['image'] ); ?>
		<?php else : ?>
			<span class="wpb-ind-media__empty" aria-hidden="true"><i class="bi bi-buildings"></i></span>
		<?php endif; ?>
		<?php if ( $wpwisebones_sector ) : ?>
			<span class="wpb-ind-status"><?php echo esc_html( $wpwisebones_sector ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $wpwisebones_card['sample'] ) ) : ?>
			<span class="wpb-ind-sample"><?php esc_html_e( 'Sample', 'wpwisebones' ); ?></span>
		<?php endif; ?>
	</div>
	<div class="wpb-ind-card__body">
		<h3 class="wpb-ind-card__title">
			<?php if ( ! empty( $wpwisebones_card['url'] ) ) : ?>
				<a class="stretched-link" href="<?php echo esc_url( $wpwisebones_card['url'] ); ?>"><?php echo esc_html( $wpwisebones_card['title'] ); ?></a>
			<?php else : ?>
				<?php echo esc_html( isset( $wpwisebones_card['title'] ) ? $wpwisebones_card['title'] : '' ); ?>
			<?php endif; ?>
		</h3>
		<?php if ( $wpwisebones_get( 'value' ) ) : ?>
			<p class="wpb-ind-price wpb-ind-price--sm"><?php echo esc_html( $wpwisebones_get( 'value' ) ); ?></p>
		<?php endif; ?>
		<?php if ( $wpwisebones_facts ) : ?>
			<ul class="wpb-ind-facts">
				<?php foreach ( $wpwisebones_facts as $wpwisebones_icon => $wpwisebones_fact ) : ?>
					<li><i class="bi <?php echo esc_attr( $wpwisebones_icon ); ?>" aria-hidden="true"></i><?php echo esc_html( $wpwisebones_fact ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</article>
