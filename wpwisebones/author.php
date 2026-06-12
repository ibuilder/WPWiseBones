<?php
/**
 * Author archive template.
 */
defined( 'ABSPATH' ) || exit;
get_header();
$container = get_theme_mod( 'wpb_container_width', 'container' );
$o         = get_option( 'wpb_options', [] );
if ( ! empty( $o['breadcrumbs'] ) ) wpb_breadcrumbs();
$author_id  = get_queried_object_id();
$author     = get_queried_object();
?>
<div id="content" class="site-content">
    <div class="<?php echo esc_attr( $container ); ?>">
        <div class="row g-4">

            <?php if ( wpb_has_sidebar() && 'left-sidebar' === wpb_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
            <?php endif; ?>

            <main id="primary" class="site-main <?php echo esc_attr( wpb_content_class() ); ?>">

                <!-- Author card -->
                <div class="card border-0 bg-light mb-5 p-4">
                    <div class="d-flex gap-4 align-items-center flex-wrap">
                        <?php echo get_avatar( $author_id, 96, '', '', [ 'class' => 'rounded-circle flex-shrink-0' ] ); ?>
                        <div>
                            <h1 class="h3 mb-1"><?php echo esc_html( $author->display_name ); ?></h1>
                            <?php if ( $author->description ) : ?>
                                <p class="text-muted mb-2"><?php echo esc_html( $author->description ); ?></p>
                            <?php endif; ?>
                            <div class="d-flex gap-2 flex-wrap small text-muted">
                                <?php if ( $author->user_url ) : ?>
                                    <a href="<?php echo esc_url( $author->user_url ); ?>" target="_blank" rel="noopener noreferrer">
                                        <i class="bi bi-globe me-1"></i><?php echo esc_html( $author->user_url ); ?>
                                    </a>
                                <?php endif; ?>
                                <span><i class="bi bi-file-post me-1"></i>
                                    <?php printf(
                                        /* translators: %d: number of posts */
                                        esc_html( _n( '%d post', '%d posts', (int) count_user_posts( $author_id ), 'wpwisebones' ) ),
                                        (int) count_user_posts( $author_id )
                                    ); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

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
