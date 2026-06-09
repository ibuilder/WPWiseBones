<?php
/**
 * Custom template tags used in template files.
 */

defined( 'ABSPATH' ) || exit;

/* â”€â”€ Site logo / branding â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_site_branding() {
    if ( has_custom_logo() ) {
        the_custom_logo();
    } else {
        echo '<a class="navbar-brand fw-bold" href="' . esc_url( home_url( '/' ) ) . '">';
        echo esc_html( get_bloginfo( 'name' ) );
        echo '</a>';
    }
}

/* â”€â”€ Featured image with fallback â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_post_thumbnail( string $size = 'wpb-card', array $classes = [] ) {
    if ( ! has_post_thumbnail() ) return;
    $cls = array_merge( [ 'card-img-top', 'w-100' ], $classes );
    echo get_the_post_thumbnail( null, $size, [ 'class' => implode( ' ', $cls ) ] );
}

/* â”€â”€ Author box â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_author_box() {
    if ( ! is_single() ) return;
    $author_id  = get_the_author_meta( 'ID' );
    $avatar     = get_avatar( $author_id, 80, '', '', [ 'class' => 'rounded-circle' ] );
    $name       = get_the_author_meta( 'display_name' );
    $bio        = get_the_author_meta( 'description' );
    $author_url = get_author_posts_url( $author_id );
    ?>
    <div class="wpb-author-box card mt-5 mb-4">
        <div class="card-body d-flex gap-4 align-items-start">
            <div class="author-avatar flex-shrink-0">
                <?php echo $avatar; // phpcs:ignore ?>
            </div>
            <div>
                <h5 class="mb-1"><?php echo esc_html( $name ); ?></h5>
                <?php if ( $bio ) : ?>
                    <p class="mb-2 text-muted small"><?php echo esc_html( $bio ); ?></p>
                <?php endif; ?>
                <a href="<?php echo esc_url( $author_url ); ?>" class="btn btn-sm btn-outline-primary">
                    <?php esc_html_e( 'View all posts', 'wpwisebones' ); ?>
                </a>
            </div>
        </div>
    </div>
    <?php
}

/* â”€â”€ Related posts â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_related_posts( int $count = 3 ) {
    if ( ! is_single() ) return;

    $cats = wp_get_post_categories( get_the_ID() );
    if ( ! $cats ) return;

    $related = new WP_Query( [
        'category__in'   => $cats,
        'posts_per_page' => $count,
        'post__not_in'   => [ get_the_ID() ],
        'orderby'        => 'rand',
        'no_found_rows'  => true,
    ] );

    if ( ! $related->have_posts() ) return;

    echo '<section class="wpb-related mt-5"><h3 class="mb-4">' . esc_html__( 'Related Posts', 'wpwisebones' ) . '</h3>';
    echo '<div class="row g-4">';

    while ( $related->have_posts() ) {
        $related->the_post();
        ?>
        <div class="col-md-4">
            <div class="card h-100 post-card border-0 shadow-sm">
                <?php wpb_post_thumbnail( 'wpb-card' ); ?>
                <div class="card-body">
                    <h6 class="card-title">
                        <a href="<?php the_permalink(); ?>" class="text-dark text-decoration-none">
                            <?php the_title(); ?>
                        </a>
                    </h6>
                    <p class="card-text small text-muted"><?php the_excerpt(); ?></p>
                </div>
            </div>
        </div>
        <?php
    }

    echo '</div></section>';
    wp_reset_postdata();
}
