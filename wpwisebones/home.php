<?php
/**
 * Blog posts index template (used when a static front page is set and
 * a separate "Posts page" is assigned in Settings â†’ Reading).
 */
defined( 'ABSPATH' ) || exit;
get_header();
$container = get_theme_mod( 'wpb_container_width', 'container' );
$o         = get_option( 'wpb_options', [] );
if ( ! empty( $o['breadcrumbs'] ) ) wpb_breadcrumbs();
?>
<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row g-4">

            <?php if ( wpb_has_sidebar() && 'left-sidebar' === wpb_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
            <?php endif; ?>

            <main id="primary" class="site-main <?php echo esc_attr( wpb_content_class() ); ?>">
                <header class="page-header mb-4 pb-3 border-bottom">
                    <h1 class="page-title"><?php single_post_title(); ?></h1>
                </header>

                <?php if ( have_posts() ) : ?>
                    <div class="row g-4">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
                    <?php endwhile; ?>
                    </div>
                    <?php wpb_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content/content', 'none' ); ?>
                <?php endif; ?>
            </main>

            <?php if ( wpb_has_sidebar() && 'right-sidebar' === wpb_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
