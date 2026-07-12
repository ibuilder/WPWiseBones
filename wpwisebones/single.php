<?php get_header(); ?>

<?php
$o         = get_option( 'wpwisebones_options', [] );
$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
if ( ! empty( $o['breadcrumbs'] ) ) wpwisebones_breadcrumbs();
?>

<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row g-4">

            <?php if ( wpwisebones_has_sidebar() && 'left-sidebar' === wpwisebones_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>

            <main id="main" tabindex="-1" class="site-main <?php echo esc_attr( wpwisebones_content_class() ); ?>">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part( 'template-parts/content/content', 'single' ); ?>

                    <?php
                    if ( ! empty( $o['author_box'] ) ) wpwisebones_author_box();
                    if ( ! empty( $o['related_posts'] ) ) wpwisebones_related_posts();
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

            <?php if ( wpwisebones_has_sidebar() && 'right-sidebar' === wpwisebones_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>
