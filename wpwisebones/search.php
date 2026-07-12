<?php get_header(); ?>

<?php
$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
$o         = get_option( 'wpwisebones_options', [] );
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
                <header class="page-header mb-4">
                    <h1 class="page-title">
                        <?php
                        printf(
                            /* translators: %s search query */
                            esc_html__( 'Search Results for: %s', 'wpwisebones' ),
                            '<span class="text-primary">' . esc_html( get_search_query() ) . '</span>'
                        );
                        ?>
                    </h1>
                    <?php get_search_form(); ?>
                </header>

                <?php if ( have_posts() ) : ?>
                    <div class="row g-4">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content/content', 'search' ); ?>
                    <?php endwhile; ?>
                    </div>
                    <?php wpwisebones_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content/content', 'none' ); ?>
                <?php endif; ?>
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
