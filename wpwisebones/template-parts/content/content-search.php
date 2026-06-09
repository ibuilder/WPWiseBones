<?php
/**
 * Template part: search result item.
 */
defined( 'ABSPATH' ) || exit;
?>
<div class="col-12">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card border-0 shadow-sm mb-0' ); ?>>
        <div class="card-body">
            <h3 class="card-title h5"><a href="<?php the_permalink(); ?>" class="text-decoration-none"><?php the_title(); ?></a></h3>
            <p class="text-muted small mb-1"><?php wpb_posted_on(); wpb_posted_by(); ?></p>
            <p class="card-text"><?php the_excerpt(); ?></p>
            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary"><?php esc_html_e( 'Read More', 'wpwisebones' ); ?></a>
        </div>
    </article>
</div>
