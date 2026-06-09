<?php get_header(); ?>

<?php
$o         = get_option( 'wpb_options', [] );
$container = get_theme_mod( 'wpb_container_width', 'container' );

// Hero on front page
if ( is_front_page() && ! is_home() ) :
    get_template_part( 'template-parts/header/hero' );
endif;

// Breadcrumbs
if ( ! empty( $o['breadcrumbs'] ) && ! is_front_page() ) {
    wpb_breadcrumbs();
}
?>

<!-- Before content widget area -->
<?php if ( is_active_sidebar( 'before-content' ) ) : ?>
    <div class="before-content-widgets">
        <div class="<?php echo esc_attr( $container ); ?>">
            <?php dynamic_sidebar( 'before-content' ); ?>
        </div>
    </div>
<?php endif; ?>

<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row g-4">

            <?php if ( wpb_has_sidebar() && 'left-sidebar' === wpb_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'wpwisebones' ); ?>">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>

            <main id="primary" class="site-main <?php echo esc_attr( wpb_content_class() ); ?>">
                <?php if ( have_posts() ) : ?>

                    <?php if ( is_home() && ! is_front_page() ) : ?>
                        <header class="page-header mb-4">
                            <h1 class="page-title"><?php single_post_title(); ?></h1>
                        </header>
                    <?php endif; ?>

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
                <aside id="secondary" class="col-lg-4 widget-area" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'wpwisebones' ); ?>">
                    <?php get_sidebar(); ?>
                </aside>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- After content widget area -->
<?php if ( is_active_sidebar( 'after-content' ) ) : ?>
    <div class="after-content-widgets py-4 bg-light">
        <div class="<?php echo esc_attr( $container ); ?>">
            <?php dynamic_sidebar( 'after-content' ); ?>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>
