<?php
/**
 * Template part: page.
 */
defined( 'ABSPATH' ) || exit;
$hide_title = get_post_meta( get_the_ID(), '_wpb_hide_title', true );
$hero_text  = get_post_meta( get_the_ID(), '_wpb_hero_image', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <header class="entry-header mb-4">
        <?php if ( ! $hide_title ) : ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php endif; ?>
    </header>
    <div class="entry-content">
        <?php
        the_content();
        wp_link_pages( [ 'before' => '<div class="page-links">', 'after' => '</div>' ] );
        ?>
    </div>
    <?php if ( get_edit_post_link() ) : ?>
        <footer class="entry-footer mt-3">
            <a href="<?php echo esc_url( get_edit_post_link() ); ?>" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-pencil me-1"></i><?php esc_html_e( 'Edit Page', 'wpwisebones' ); ?>
            </a>
        </footer>
    <?php endif; ?>
</article>
