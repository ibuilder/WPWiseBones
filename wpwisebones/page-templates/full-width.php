<?php
/**
 * Template Name: Full Width
 * Template Post Type: page
 *
 * A full-width page with no sidebar.
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>

<div id="content" class="site-content">
    <div class="<?php echo esc_attr( get_theme_mod( 'wpb_container_width', 'container' ) ); ?>">
        <main id="primary" class="site-main col-12">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'template-parts/content/content', 'page' ); ?>
            <?php endwhile; ?>
        </main>
    </div>
</div>

<?php get_footer(); ?>
