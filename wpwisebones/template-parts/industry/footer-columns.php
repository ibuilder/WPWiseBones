<?php
/**
 * Branded footer columns for industry themes, used when no footer widgets are
 * set: about blurb and contact, then link columns from the config.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_config = isset( $args['config'] ) ? (array) $args['config'] : array();
$wpwisebones_footer = isset( $wpwisebones_config['footer'] ) ? (array) $wpwisebones_config['footer'] : array();
$wpwisebones_phone  = (string) get_theme_mod( 'wpwisebones_ind_phone', '' );
$wpwisebones_cols   = isset( $wpwisebones_footer['columns'] ) ? (array) $wpwisebones_footer['columns'] : array();
?>
<div class="footer-widgets wpb-ind-footer">
	<div class="container">
		<div class="row g-4">
			<div class="col-lg-4 pe-lg-5">
				<p class="wpb-ind-footer__brand"><?php bloginfo( 'name' ); ?></p>
				<?php if ( ! empty( $wpwisebones_footer['about'] ) ) : ?>
					<p class="wpb-ind-footer__about"><?php echo esc_html( $wpwisebones_footer['about'] ); ?></p>
				<?php endif; ?>
				<?php if ( '' !== $wpwisebones_phone ) : ?>
					<p class="mb-1"><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $wpwisebones_phone ) ); ?>"><i class="bi bi-telephone me-2" aria-hidden="true"></i><?php echo esc_html( $wpwisebones_phone ); ?></a></p>
				<?php endif; ?>
				<?php if ( ! empty( $wpwisebones_footer['note'] ) ) : ?>
					<p class="wpb-ind-footer__note"><?php echo esc_html( $wpwisebones_footer['note'] ); ?></p>
				<?php endif; ?>
			</div>
			<?php foreach ( $wpwisebones_cols as $wpwisebones_heading => $wpwisebones_links ) : ?>
				<div class="col-6 col-lg-2<?php echo array_key_first( $wpwisebones_cols ) === $wpwisebones_heading ? ' offset-lg-2' : ''; ?>">
					<h2 class="widget-title"><?php echo esc_html( $wpwisebones_heading ); ?></h2>
					<ul class="list-unstyled wpb-ind-footer__links">
						<?php foreach ( (array) $wpwisebones_links as $wpwisebones_link ) : ?>
							<li><a href="<?php echo esc_url( wpwisebones_industry_url( (string) $wpwisebones_link[1] ) ); ?>"><?php echo esc_html( $wpwisebones_link[0] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</div>
