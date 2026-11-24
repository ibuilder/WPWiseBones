<?php
/**
 * Hero panel: property search. Submits to the listings archive when the
 * Industry Kit is active (the kit reads the filters), otherwise to site search.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_hero    = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_search  = isset( $wpwisebones_hero['search'] ) ? (array) $wpwisebones_hero['search'] : array();
$wpwisebones_type    = wpwisebones_industry_post_type( 'listing' );
$wpwisebones_has_kit = post_type_exists( $wpwisebones_type );
$wpwisebones_action  = $wpwisebones_has_kit ? get_post_type_archive_link( $wpwisebones_type ) : home_url( '/' );
$wpwisebones_kinds   = isset( $wpwisebones_search['types'] ) ? (array) $wpwisebones_search['types'] : array();
$wpwisebones_prices  = isset( $wpwisebones_search['prices'] ) ? (array) $wpwisebones_search['prices'] : array();
?>
<form class="wpb-ind-panel wpb-ind-search" role="search" method="get" action="<?php echo esc_url( $wpwisebones_action ? $wpwisebones_action : home_url( '/' ) ); ?>">
	<h2 class="wpb-ind-panel__title"><?php echo esc_html( isset( $wpwisebones_search['title'] ) ? $wpwisebones_search['title'] : __( 'Find a property', 'wpwisebones' ) ); ?></h2>
	<?php if ( ! empty( $wpwisebones_search['tabs'] ) ) : ?>
		<div class="wpb-ind-search__tabs" role="radiogroup" aria-label="<?php esc_attr_e( 'Listing status', 'wpwisebones' ); ?>">
			<?php foreach ( (array) $wpwisebones_search['tabs'] as $wpwisebones_i => $wpwisebones_tab ) : ?>
				<label>
					<input type="radio" name="status" value="<?php echo esc_attr( $wpwisebones_tab[0] ); ?>" <?php checked( 0, $wpwisebones_i ); ?>>
					<span><?php echo esc_html( $wpwisebones_tab[1] ); ?></span>
				</label>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
	<div class="row g-2">
		<div class="col-12">
			<label class="form-label" for="wpb-ind-q"><?php esc_html_e( 'Location', 'wpwisebones' ); ?></label>
			<input class="form-control form-control-lg" id="wpb-ind-q" type="search" name="s" placeholder="<?php echo esc_attr( isset( $wpwisebones_search['placeholder'] ) ? $wpwisebones_search['placeholder'] : __( 'City, neighborhood or ZIP', 'wpwisebones' ) ); ?>">
		</div>
		<?php if ( $wpwisebones_kinds ) : ?>
			<div class="col-sm-6">
				<label class="form-label" for="wpb-ind-type"><?php esc_html_e( 'Type', 'wpwisebones' ); ?></label>
				<select class="form-select" id="wpb-ind-type" name="listing_type">
					<option value=""><?php esc_html_e( 'Any', 'wpwisebones' ); ?></option>
					<?php foreach ( $wpwisebones_kinds as $wpwisebones_slug => $wpwisebones_name ) : ?>
						<option value="<?php echo esc_attr( $wpwisebones_slug ); ?>"><?php echo esc_html( $wpwisebones_name ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>
		<?php if ( $wpwisebones_prices ) : ?>
			<div class="col-sm-6">
				<label class="form-label" for="wpb-ind-max"><?php esc_html_e( 'Max price', 'wpwisebones' ); ?></label>
				<select class="form-select" id="wpb-ind-max" name="max_price">
					<option value=""><?php esc_html_e( 'No max', 'wpwisebones' ); ?></option>
					<?php foreach ( $wpwisebones_prices as $wpwisebones_value => $wpwisebones_name ) : ?>
						<option value="<?php echo esc_attr( $wpwisebones_value ); ?>"><?php echo esc_html( $wpwisebones_name ); ?></option>
					<?php endforeach; ?>
				</select>
			</div>
		<?php endif; ?>
		<div class="col-12 mt-3">
			<?php if ( ! $wpwisebones_has_kit ) : ?>
				<input type="hidden" name="post_type" value="any">
			<?php endif; ?>
			<button class="btn btn-primary btn-lg w-100" type="submit"><i class="bi bi-search me-2" aria-hidden="true"></i><?php esc_html_e( 'Search', 'wpwisebones' ); ?></button>
		</div>
	</div>
	<?php if ( ! empty( $wpwisebones_search['note'] ) ) : ?>
		<p class="wpb-ind-panel__note"><?php echo esc_html( $wpwisebones_search['note'] ); ?></p>
	<?php endif; ?>
</form>
