<?php
/**
 * Template part: post card for blog loop.
 */
defined( 'ABSPATH' ) || exit;
$o = get_option( 'wpb_options', [] );
?>
<div class="col-md-6 col-lg-4">
    <article id="post-<?php the_ID(); ?>" <?php post_class( 'card h-100 post-card border-0 shadow-sm' ); ?>>
        <?php if ( has_post_thumbnail() ) : ?>
            <a href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
                <?php the_post_thumbnail( 'wpb-card', [ 'class' => 'card-img-top' ] ); ?>
            </a>
        <?php endif; ?>

        <div class="card-body d-flex flex-column">
            <div class="entry-meta mb-2 text-muted small">
                <?php wpb_posted_on(); wpb_posted_by(); ?>
                <?php if ( ! empty( $o['reading_time'] ) ) : ?>
                    <span class="reading-time"><i class="bi bi-clock me-1"></i><?php echo esc_html( wpb_reading_time() ); ?></span>
                <?php endif; ?>
            </div>

            <h2 class="card-title h5">
                <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                    <?php the_title(); ?>
                </a>
            </h2>

            <div class="card-text text-muted flex-grow-1">
                <?php the_excerpt(); ?>
            </div>

            <a href="<?php the_permalink(); ?>" class="btn btn-sm btn-outline-primary mt-3 align-self-start">
                <?php esc_html_e( 'Read More', 'wpwisebones' ); ?> <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>

        <div class="card-footer bg-transparent border-top-0 small text-muted">
            <?php wpb_entry_footer(); ?>
        </div>
    </article>
</div>
