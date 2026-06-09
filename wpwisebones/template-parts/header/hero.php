<?php
/**
 * Hero banner for front page / static pages with hero meta set.
 */
defined( 'ABSPATH' ) || exit;

$heading    = get_theme_mod( 'wpb_hero_heading',    get_bloginfo( 'name' ) );
$subheading = get_theme_mod( 'wpb_hero_subheading', get_bloginfo( 'description' ) );
$btn_text   = get_theme_mod( 'wpb_hero_btn_text',   __( 'Learn More', 'wpwisebones' ) );
$btn_url    = get_theme_mod( 'wpb_hero_btn_url',    '#' );
$hero_image = get_post_meta( get_the_ID(), '_wpb_hero_image', true );

$style = $hero_image ? 'background: url(' . esc_url( $hero_image ) . ') center/cover no-repeat; color:#fff;' : '';
?>
<section class="wpb-hero text-center" <?php echo $style ? 'style="' . $style . '"' : ''; ?>>
    <div class="container py-2">
        <?php if ( $heading ) : ?>
            <h1 class="display-4 fw-bold mb-3"><?php echo esc_html( $heading ); ?></h1>
        <?php endif; ?>
        <?php if ( $subheading ) : ?>
            <p class="lead mb-4 opacity-90"><?php echo esc_html( $subheading ); ?></p>
        <?php endif; ?>
        <?php if ( $btn_text ) : ?>
            <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-light btn-lg px-4">
                <?php echo esc_html( $btn_text ); ?>
            </a>
        <?php endif; ?>
    </div>
</section>
