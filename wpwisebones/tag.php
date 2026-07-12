<?php
/**
 * Tag archive template.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$container = get_theme_mod( 'wpwisebones_container_width', 'container' );
$o         = get_option( 'wpwisebones_options', [] );
if ( ! empty( $o['breadcrumbs'] ) ) wpwisebones_breadcrumbs();
?>
<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row g-4">

            <?php if ( wpwisebones_has_sidebar() && 'left-sidebar' === wpwisebones_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
            <?php endif; ?>

            <main id="main" tabindex="-1" class="site-main <?php echo esc_attr( wpwisebones_content_class() ); ?>">
                <header class="page-header mb-4 pb-3 border-bottom">
                    <div class="d-flex align-items-center gap-3 flex-wrap">
                        <span class="badge bg-secondary fs-6"><i class="bi bi-tag me-1"></i><?php single_tag_title(); ?></span>
                    </div>
                    <?php if ( tag_description() ) : ?>
                        <div class="mt-2 text-muted"><?php echo wp_kses_post( tag_description() ); ?></div>
                    <?php endif; ?>
                </header>

                <?php if ( have_posts() ) : ?>
                    <div class="row g-4">
                    <?php while ( have_posts() ) : the_post(); ?>
                        <?php get_template_part( 'template-parts/content/content', get_post_type() ); ?>
                    <?php endwhile; ?>
                    </div>
                    <?php wpwisebones_pagination(); ?>
                <?php else : ?>
                    <?php get_template_part( 'template-parts/content/content', 'none' ); ?>
                <?php endif; ?>
            </main>

            <?php if ( wpwisebones_has_sidebar() && 'right-sidebar' === wpwisebones_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
