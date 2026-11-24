<?php
/**
 * Industry hero: copy on one side, a working panel on the other.
 *
 * Panels: search (property search), quote (request form or checklist),
 * calculator (mortgage payment estimate), card (key/value spec card),
 * none (copy only, wider).
 *
 * @package WPWiseBones
 */

defined( 'ABSPATH' ) || exit;

$wpwisebones_hero    = isset( $args['section'] ) ? (array) $args['section'] : array();
$wpwisebones_panel   = isset( $wpwisebones_hero['panel'] ) ? (string) $wpwisebones_hero['panel'] : 'none';
$wpwisebones_style   = isset( $wpwisebones_hero['style'] ) ? sanitize_html_class( $wpwisebones_hero['style'] ) : 'gradient';
$wpwisebones_eyebrow = (string) get_theme_mod( 'wpwisebones_ind_eyebrow', isset( $wpwisebones_hero['eyebrow'] ) ? $wpwisebones_hero['eyebrow'] : '' );
// Empty default so the config's copy (applied as a theme_mod filter) shows
// until the owner writes their own; the site name is the last resort.
$wpwisebones_heading = (string) get_theme_mod( 'wpwisebones_hero_heading', '' );
$wpwisebones_heading = '' !== $wpwisebones_heading ? $wpwisebones_heading : get_bloginfo( 'name' );
$wpwisebones_subhead = (string) get_theme_mod( 'wpwisebones_hero_subheading', '' );
$wpwisebones_subhead = '' !== $wpwisebones_subhead ? $wpwisebones_subhead : get_bloginfo( 'description' );
$wpwisebones_image   = get_theme_mod( 'wpwisebones_ind_hero_image', '' );
$wpwisebones_bg      = $wpwisebones_image ? ' style="--wpb-ind-hero-image:url(' . esc_url( $wpwisebones_image ) . ')"' : '';
?>
<section class="wpb-ind-hero wpb-ind-hero--<?php echo esc_attr( $wpwisebones_style ); ?><?php echo $wpwisebones_image ? ' has-image' : ''; ?>"<?php echo $wpwisebones_bg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- built from esc_url above. ?>>
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="<?php echo esc_attr( 'none' === $wpwisebones_panel ? 'col-lg-9' : 'col-lg-6' ); ?>">
				<?php if ( '' !== $wpwisebones_eyebrow ) : ?>
					<span class="wpb-ind-badge"><span class="dot" aria-hidden="true"></span><?php echo esc_html( $wpwisebones_eyebrow ); ?></span>
				<?php endif; ?>
				<h1 class="wpb-ind-hero__title"><?php echo esc_html( $wpwisebones_heading ); ?></h1>
				<p class="wpb-ind-hero__text"><?php echo esc_html( $wpwisebones_subhead ); ?></p>
				<div class="d-flex flex-wrap gap-2 mb-4">
					<?php
					if ( ! empty( $wpwisebones_hero['primary'] ) ) {
						$wpwisebones_btn = (array) $wpwisebones_hero['primary'];
						$wpwisebones_txt = get_theme_mod( 'wpwisebones_hero_btn_text', '' );
						$wpwisebones_url = get_theme_mod( 'wpwisebones_hero_btn_url', '' );
						if ( $wpwisebones_txt ) {
							$wpwisebones_btn[0] = $wpwisebones_txt;
						}
						if ( $wpwisebones_url && '#' !== $wpwisebones_url ) {
							$wpwisebones_btn[1] = $wpwisebones_url;
						}
						wpwisebones_industry_button( $wpwisebones_btn, 'btn btn-primary btn-lg px-4' );
					}
					if ( ! empty( $wpwisebones_hero['secondary'] ) ) {
						wpwisebones_industry_button( (array) $wpwisebones_hero['secondary'], 'btn btn-outline-light btn-lg px-4 wpb-ind-btn-ghost' );
					}
					?>
				</div>
				<?php if ( ! empty( $wpwisebones_hero['badges'] ) ) : ?>
					<ul class="wpb-ind-hero__badges list-unstyled d-flex flex-wrap gap-3 mb-0">
						<?php foreach ( (array) $wpwisebones_hero['badges'] as $wpwisebones_badge ) : ?>
							<li><i class="bi bi-check2-circle" aria-hidden="true"></i> <?php echo esc_html( $wpwisebones_badge ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>

			<?php if ( 'none' !== $wpwisebones_panel ) : ?>
				<div class="col-lg-6">
					<?php get_template_part( 'template-parts/industry/panel', $wpwisebones_panel, array( 'section' => $wpwisebones_hero ) ); ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
