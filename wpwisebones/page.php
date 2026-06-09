<?php get_header(); ?>

<?php
$o         = get_option( 'wpb_options', [] );
$container = get_theme_mod( 'wpb_container_width', 'container' );
if ( ! empty( $o['breadcrumbs'] ) && ! is_front_page() ) wpb_breadcrumbs();
?>

<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row g-4">

            <?php if ( wpb_has_sidebar() && 'left-sidebar' === wpb_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>

            <main id="primary" class="site-main <?php echo esc_attr( wpb_content_class() ); ?>">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content/content', 'page' ); ?>
                    <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
                <?php endwhile; ?>
            </main>

            <?php if ( wpb_has_sidebar() && 'right-sidebar' === wpb_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
