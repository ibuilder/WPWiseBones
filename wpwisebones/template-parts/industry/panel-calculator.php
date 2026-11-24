<?php
/**
 * Hero panel: monthly payment estimate. Principal and interest only, worked
 * out in the browser by assets/js/industry.js; nothing is sent anywhere.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_hero = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_calc = wp_parse_args(
	isset( $wpwisebones_hero['calculator'] ) ? (array) $wpwisebones_hero['calculator'] : array(),
	array(
		'title'    => __( 'Estimate your payment', 'wpwisebones' ),
		'price'    => 400000,
		'down'     => 20,
		'rate'     => 6.5,
		'term'     => 30,
		'currency' => '$',
		'note'     => __( 'Principal and interest only. An estimate, not a loan offer — taxes, insurance and your actual rate will change it.', 'wpwisebones' ),
		'button'   => array(),
	)
);
?>
<form class="wpb-ind-panel wpb-ind-calc" data-wpb-calc data-currency="<?php echo esc_attr( $wpwisebones_calc['currency'] ); ?>" onsubmit="return false">
	<h2 class="wpb-ind-panel__title"><?php echo esc_html( $wpwisebones_calc['title'] ); ?></h2>
	<div class="row g-2">
		<div class="col-sm-6">
			<label class="form-label" for="wpb-calc-price"><?php esc_html_e( 'Home price', 'wpwisebones' ); ?></label>
			<input class="form-control" id="wpb-calc-price" name="price" type="number" min="0" step="1000" value="<?php echo esc_attr( $wpwisebones_calc['price'] ); ?>">
		</div>
		<div class="col-sm-6">
			<label class="form-label" for="wpb-calc-down"><?php esc_html_e( 'Down payment (%)', 'wpwisebones' ); ?></label>
			<input class="form-control" id="wpb-calc-down" name="down" type="number" min="0" max="100" step="0.5" value="<?php echo esc_attr( $wpwisebones_calc['down'] ); ?>">
		</div>
		<div class="col-sm-6">
			<label class="form-label" for="wpb-calc-rate"><?php esc_html_e( 'Interest rate (%)', 'wpwisebones' ); ?></label>
			<input class="form-control" id="wpb-calc-rate" name="rate" type="number" min="0" max="30" step="0.125" value="<?php echo esc_attr( $wpwisebones_calc['rate'] ); ?>">
		</div>
		<div class="col-sm-6">
			<label class="form-label" for="wpb-calc-term"><?php esc_html_e( 'Term (years)', 'wpwisebones' ); ?></label>
			<select class="form-select" id="wpb-calc-term" name="term">
				<?php foreach ( array( 30, 20, 15, 10 ) as $wpwisebones_years ) : ?>
					<option value="<?php echo esc_attr( $wpwisebones_years ); ?>" <?php selected( (int) $wpwisebones_calc['term'], $wpwisebones_years ); ?>><?php echo esc_html( $wpwisebones_years ); ?></option>
				<?php endforeach; ?>
			</select>
		</div>
	</div>
	<div class="wpb-ind-calc__result" aria-live="polite">
		<span><?php esc_html_e( 'Estimated monthly payment', 'wpwisebones' ); ?></span>
		<output name="payment" for="wpb-calc-price wpb-calc-down wpb-calc-rate wpb-calc-term">&mdash;</output>
	</div>
	<?php
	if ( ! empty( $wpwisebones_calc['button'] ) ) {
		wpwisebones_industry_button( (array) $wpwisebones_calc['button'], 'btn btn-primary w-100' );
	}
	?>
	<p class="wpb-ind-panel__note"><?php echo esc_html( $wpwisebones_calc['note'] ); ?></p>
</form>
