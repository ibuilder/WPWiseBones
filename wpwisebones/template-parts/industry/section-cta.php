<?php
/**
 * Closing call to action. Embeds the Industry Kit's lead form when the plugin
 * is active, otherwise links to the contact page.
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_section = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_heading = (string) get_theme_mod( 'wpwisebones_ind_cta_heading', isset( $wpwisebones_section['heading'] ) ? $wpwisebones_section['heading'] : '' );
$wpwisebones_text    = (string) get_theme_mod( 'wpwisebones_ind_cta_text', isset( $wpwisebones_section['text'] ) ? $wpwisebones_section['text'] : '' );
$wpwisebones_form    = ! empty( $wpwisebones_section['form'] ) && shortcode_exists( 'wbik_lead_form' );
$wpwisebones_phone   = (string) get_theme_mod( 'wpwisebones_ind_phone', '' );
?>
<section class="wpb-ind-section wpb-ind-cta-wrap" id="contact">
	<div class="container">
		<div class="wpb-ind-cta<?php echo $wpwisebones_form ? ' wpb-ind-cta--form' : ''; ?>">
			<div class="row g-4 align-items-center">
				<div class="<?php echo esc_attr( $wpwisebones_form ? 'col-lg-5' : 'col-lg-8' ); ?>">
					<h2 class="wpb-ind-cta__title"><?php echo esc_html( $wpwisebones_heading ); ?></h2>
					<p class="wpb-ind-cta__text"><?php echo esc_html( $wpwisebones_text ); ?></p>
					<?php if ( '' !== $wpwisebones_phone ) : ?>
						<p class="wpb-ind-cta__phone"><a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $wpwisebones_phone ) ); ?>"><i class="bi bi-telephone-fill" aria-hidden="true"></i> <?php echo esc_html( $wpwisebones_phone ); ?></a></p>
					<?php endif; ?>
				</div>
				<div class="<?php echo esc_attr( $wpwisebones_form ? 'col-lg-7' : 'col-lg-4 text-lg-end' ); ?>">
					<?php if ( $wpwisebones_form ) : ?>
						<div class="wpb-ind-cta__form"><?php echo do_shortcode( '[wbik_lead_form title=""]' ); ?></div>
					<?php else : ?>
						<?php wpwisebones_industry_button( isset( $wpwisebones_section['button'] ) ? (array) $wpwisebones_section['button'] : array( __( 'Contact us', 'wpwisebones' ), '/contact/' ), 'btn btn-light btn-lg px-4' ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
