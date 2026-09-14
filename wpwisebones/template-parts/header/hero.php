<?php
/**
 * Hero banner for front page / static pages with hero meta set.
 */
defined( 'ABSPATH' ) || exit;

$wpwisebones_heading    = get_theme_mod( 'wpwisebones_hero_heading', get_bloginfo( 'name' ) );
$wpwisebones_subheading = get_theme_mod( 'wpwisebones_hero_subheading', get_bloginfo( 'description' ) );
$wpwisebones_btn_text   = get_theme_mod( 'wpwisebones_hero_btn_text', __( 'Learn More', 'wpwisebones' ) );
$wpwisebones_btn_url    = get_theme_mod( 'wpwisebones_hero_btn_url', '#' );
$wpwisebones_hero_image = get_post_meta( get_the_ID(), '_wpwisebones_hero_image', true );

$wpwisebones_style = $wpwisebones_hero_image ? 'background: url(' . esc_url( $wpwisebones_hero_image ) . ') center/cover no-repeat; color:#fff;' : '';
?>
<section class="wpb-hero text-center" <?php echo $wpwisebones_style ? 'style="' . esc_attr( $wpwisebones_style ) . '"' : ''; ?>>
	<div class="container py-2">
		<?php if ( $wpwisebones_heading ) : ?>
			<h1 class="display-4 fw-bold mb-3"><?php echo esc_html( $wpwisebones_heading ); ?></h1>
		<?php endif; ?>
		<?php if ( $wpwisebones_subheading ) : ?>
			<p class="lead mb-4 opacity-90"><?php echo esc_html( $wpwisebones_subheading ); ?></p>
		<?php endif; ?>
		<?php if ( $wpwisebones_btn_text ) : ?>
			<a href="<?php echo esc_url( $wpwisebones_btn_url ); ?>" class="btn btn-light btn-lg px-4">
				<?php echo esc_html( $wpwisebones_btn_text ); ?>
			</a>
		<?php endif; ?>
	</div>
</section>
