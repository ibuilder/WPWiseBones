<?php get_header(); ?>

<?php
$o         = get_option( 'wpb_options', [] );
$container = get_theme_mod( 'wpb_container_width', 'container' );
if ( ! empty( $o['breadcrumbs'] ) ) wpb_breadcrumbs();
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
                    <?php get_template_part( 'template-parts/content/content', 'single' ); ?>

                    <?php
                    if ( ! empty( $o['author_box'] ) ) wpb_author_box();
                    if ( ! empty( $o['related_posts'] ) ) wpb_related_posts();
                    ?>

                    <nav class="post-navigation d-flex justify-content-between my-4">
                        <div class="prev-post"><?php previous_post_link( '%link', '<i class="bi bi-arrow-left me-1"></i>%title' ); ?></div>
                        <div class="next-post"><?php next_post_link( '%link', '%title <i class="bi bi-arrow-right ms-1"></i>' ); ?></div>
                    </nav>

                    <?php if ( comments_open() || get_comments_number() ) : ?>
                        <?php comments_template(); ?>
                    <?php endif; ?>

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
