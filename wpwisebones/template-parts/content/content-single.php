<?php
/**
 * Template part: single post.
 */
defined( 'ABSPATH' ) || exit;
$o         = get_option( 'wpb_options', [] );
$hide_title = get_post_meta( get_the_ID(), '_wpb_hide_title', true );
$hero_img   = get_post_meta( get_the_ID(), '_wpb_hero_image', true );
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

    <?php if ( $hero_img ) : ?>
        <div class="entry-hero mb-4 rounded overflow-hidden" style="max-height:500px">
            <img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" class="w-100 object-fit-cover">
        </div>
    <?php elseif ( has_post_thumbnail() ) : ?>
        <div class="entry-hero mb-4 rounded overflow-hidden" style="max-height:500px">
            <?php the_post_thumbnail( 'wpb-hero', [ 'class' => 'w-100 object-fit-cover' ] ); ?>
        </div>
    <?php endif; ?>

    <header class="entry-header mb-4">
        <?php if ( ! $hide_title ) : ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
        <?php endif; ?>
        <div class="entry-meta text-muted small d-flex flex-wrap gap-2 mb-2">
            <?php wpb_posted_on(); wpb_posted_by(); ?>
            <?php if ( ! empty( $o['reading_time'] ) ) : ?>
                <span><i class="bi bi-clock me-1"></i><?php echo esc_html( wpb_reading_time() ); ?></span>
            <?php endif; ?>
            <?php
            $cats = get_the_category_list( ', ' );
            if ( $cats ) echo '<span><i class="bi bi-folder me-1"></i>' . $cats . '</span>'; // phpcs:ignore
            ?>
        </div>
    </header>

    <div class="entry-content">
        <?php
        the_content( __( 'Continue readingâ€¦', 'wpwisebones' ) );
        wp_link_pages( [
            'before' => '<div class="page-links">' . __( 'Pages:', 'wpwisebones' ),
            'after'  => '</div>',
        ] );
        ?>
    </div>

    <footer class="entry-footer mt-4 pt-3 border-top">
        <?php wpb_entry_footer(); ?>
        <?php if ( ! empty( $o['social_share'] ) ) wpb_social_share(); ?>
    </footer>
</article>
