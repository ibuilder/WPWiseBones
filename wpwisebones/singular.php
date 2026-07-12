<?php
/**
 * Fallback singular template â€” used for any single post/page that doesn't
 * match a more specific template (single.php, page.php, etc.).
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
                <?php while ( have_posts() ) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                        <header class="entry-header mb-4">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <div class="entry-meta text-muted small">
                                <?php wpwisebones_posted_on(); wpwisebones_posted_by(); ?>
                            </div>
                        </header>
                        <?php if ( has_post_thumbnail() ) the_post_thumbnail( 'wpwisebones-hero', [ 'class' => 'img-fluid rounded mb-4' ] ); ?>
                        <div class="entry-content"><?php the_content(); ?></div>
                        <footer class="entry-footer mt-4 pt-3 border-top"><?php wpwisebones_entry_footer(); ?></footer>
                    </article>
                    <?php if ( comments_open() || get_comments_number() ) comments_template(); ?>
                <?php endwhile; ?>
            </main>

            <?php if ( wpwisebones_has_sidebar() && 'right-sidebar' === wpwisebones_get_layout() ) : ?>
                <aside id="secondary" class="col-lg-4 widget-area"><?php get_sidebar(); ?></aside>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php get_footer(); ?>
