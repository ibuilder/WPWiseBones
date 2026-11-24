<?php
/**
 * A listing card: photo, status, price, address and the key facts.
 *
 * $args['card'] carries either a real post's id (facts read from its meta)
 * or a sample's values directly.
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

$wpwisebones_price  = $wpwisebones_get( 'price' );
$wpwisebones_suffix = $wpwisebones_get( 'price_suffix' );
$wpwisebones_status = $wpwisebones_get( 'status' );
$wpwisebones_where  = trim( implode( ', ', array_filter( array( $wpwisebones_get( 'address' ), $wpwisebones_get( 'city' ) ) ) ) );
$wpwisebones_facts  = array_filter(
	array(
		'bi-door-open'   => $wpwisebones_get( 'beds' ) ? sprintf( /* translators: %s: bedroom count. */ __( '%s bd', 'wpwisebones' ), $wpwisebones_get( 'beds' ) ) : '',
		'bi-droplet'     => $wpwisebones_get( 'baths' ) ? sprintf( /* translators: %s: bathroom count. */ __( '%s ba', 'wpwisebones' ), $wpwisebones_get( 'baths' ) ) : '',
		'bi-arrows-move' => $wpwisebones_get( 'sqft' ) ? sprintf( /* translators: %s: floor area in square feet. */ __( '%s sq ft', 'wpwisebones' ), number_format_i18n( (float) str_replace( ',', '', $wpwisebones_get( 'sqft' ) ) ) ) : '',
		'bi-building'    => $wpwisebones_get( 'units' ) ? sprintf( /* translators: %s: unit count. */ __( '%s units', 'wpwisebones' ), $wpwisebones_get( 'units' ) ) : '',
	)
);
if ( is_numeric( $wpwisebones_price ) ) {
	$wpwisebones_price = '$' . number_format_i18n( (float) $wpwisebones_price );
}
$wpwisebones_status_labels = array(
	'for-sale'    => __( 'For sale', 'wpwisebones' ),
	'for-lease'   => __( 'For lease', 'wpwisebones' ),
	'for-rent'    => __( 'For rent', 'wpwisebones' ),
	'pending'     => __( 'Pending', 'wpwisebones' ),
	'sold'        => __( 'Sold', 'wpwisebones' ),
	'leased'      => __( 'Leased', 'wpwisebones' ),
	'coming-soon' => __( 'Coming soon', 'wpwisebones' ),
	'move-in'     => __( 'Move-in ready', 'wpwisebones' ),
	'plan'        => __( 'Floor plan', 'wpwisebones' ),
);
$wpwisebones_status_text = isset( $wpwisebones_status_labels[ $wpwisebones_status ] ) ? $wpwisebones_status_labels[ $wpwisebones_status ] : $wpwisebones_status;
?>
<article class="wpb-ind-card wpb-ind-listing<?php echo ! empty( $wpwisebones_card['sample'] ) ? ' is-sample' : ''; ?>">
	<div class="wpb-ind-media">
		<?php if ( ! empty( $wpwisebones_card['image'] ) ) : ?>
			<?php echo wp_kses_post( $wpwisebones_card['image'] ); ?>
		<?php else : ?>
			<span class="wpb-ind-media__empty" aria-hidden="true"><i class="bi bi-house-door"></i></span>
		<?php endif; ?>
		<?php if ( $wpwisebones_status_text ) : ?>
			<span class="wpb-ind-status wpb-ind-status--<?php echo esc_attr( sanitize_html_class( $wpwisebones_status ) ); ?>"><?php echo esc_html( $wpwisebones_status_text ); ?></span>
		<?php endif; ?>
		<?php if ( ! empty( $wpwisebones_card['sample'] ) ) : ?>
			<span class="wpb-ind-sample"><?php esc_html_e( 'Sample', 'wpwisebones' ); ?></span>
		<?php endif; ?>
	</div>
	<div class="wpb-ind-card__body">
		<?php if ( $wpwisebones_price ) : ?>
			<p class="wpb-ind-price"><?php echo esc_html( $wpwisebones_price ); ?><?php if ( $wpwisebones_suffix ) : ?><small><?php echo esc_html( $wpwisebones_suffix ); ?></small><?php endif; ?></p>
		<?php endif; ?>
		<h3 class="wpb-ind-card__title">
			<?php if ( ! empty( $wpwisebones_card['url'] ) ) : ?>
				<a class="stretched-link" href="<?php echo esc_url( $wpwisebones_card['url'] ); ?>"><?php echo esc_html( $wpwisebones_card['title'] ); ?></a>
			<?php else : ?>
				<?php echo esc_html( isset( $wpwisebones_card['title'] ) ? $wpwisebones_card['title'] : '' ); ?>
			<?php endif; ?>
		</h3>
		<?php if ( $wpwisebones_where ) : ?>
			<p class="wpb-ind-where"><i class="bi bi-geo-alt" aria-hidden="true"></i> <?php echo esc_html( $wpwisebones_where ); ?></p>
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
