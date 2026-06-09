<?php
/**
 * Template part: no content found.
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="col-12">
    <section class="no-results not-found text-center py-5">
        <i class="bi bi-search display-3 text-muted d-block mb-3"></i>
        <h2><?php esc_html_e( 'Nothing Found', 'wpwisebones' ); ?></h2>
        <?php if ( is_search() ) : ?>
            <p class="text-muted"><?php esc_html_e( 'Try searching with different keywords.', 'wpwisebones' ); ?></p>
            <?php get_search_form(); ?>
        <?php else : ?>
            <p class="text-muted"><?php esc_html_e( "It seems we can't find what you're looking for. Perhaps searching can help.", 'wpwisebones' ); ?></p>
            <?php get_search_form(); ?>
        <?php endif; ?>
    </section>
</div>
