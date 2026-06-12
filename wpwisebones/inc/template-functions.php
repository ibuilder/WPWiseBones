<?php
/**
 * Template functions â€“ layout helpers, breadcrumbs, pagination, etc.
 */

defined( 'ABSPATH' ) || exit;

/* â”€â”€ Layout: sidebar position â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_get_layout(): string {
    $layout = get_theme_mod( 'wpb_layout', 'right-sidebar' );

    // Per-post override via meta box
    if ( is_singular() ) {
        $meta = get_post_meta( get_the_ID(), '_wpb_layout', true );
        if ( $meta ) {
            $layout = $meta;
        }
    }

    return $layout;
}

function wpb_content_class(): string {
    $layout = wpb_get_layout();
    if ( 'full-width' === $layout ) {
        return 'col-12';
    }
    if ( 'left-sidebar' === $layout || 'right-sidebar' === $layout ) {
        return 'col-lg-8';
    }
    return 'col-12';
}

function wpb_has_sidebar(): bool {
    return in_array( wpb_get_layout(), [ 'left-sidebar', 'right-sidebar' ], true )
        && ( is_active_sidebar( 'sidebar-primary' ) || is_singular() || is_archive() );
}

/* â”€â”€ Breadcrumbs â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_breadcrumbs() {
    if ( is_front_page() ) return;

    $container = get_theme_mod( 'wpb_container_width', 'container' );
    $out = '<nav aria-label="' . esc_attr__( 'Breadcrumb', 'wpwisebones' ) . '" class="wpb-breadcrumbs">';
    $out .= '<div class="' . esc_attr( $container ) . '"><ol class="breadcrumb mb-0">';
    $out .= '<li class="breadcrumb-item"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'wpwisebones' ) . '</a></li>';

    if ( is_category() ) {
        $out .= '<li class="breadcrumb-item active">' . single_cat_title( '', false ) . '</li>';
    } elseif ( is_tag() ) {
        $out .= '<li class="breadcrumb-item active">' . single_tag_title( '', false ) . '</li>';
    } elseif ( is_author() ) {
        $out .= '<li class="breadcrumb-item active">' . get_the_author() . '</li>';
    } elseif ( is_date() ) {
        $out .= '<li class="breadcrumb-item active">' . get_the_date() . '</li>';
    } elseif ( is_singular() ) {
        if ( is_attachment() ) {
            $parent = get_post( get_post()->post_parent );
            if ( $parent ) {
                $out .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $parent ) ) . '">' . esc_html( get_the_title( $parent ) ) . '</a></li>';
            }
        } elseif ( is_single() ) {
            $cats = get_the_category();
            if ( $cats ) {
                $out .= '<li class="breadcrumb-item"><a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '">' . esc_html( $cats[0]->name ) . '</a></li>';
            }
        }
        $out .= '<li class="breadcrumb-item active">' . esc_html( get_the_title() ) . '</li>';
    } elseif ( is_page() ) {
        global $post;
        if ( $post->post_parent ) {
            $ancestors = array_reverse( get_post_ancestors( $post ) );
            foreach ( $ancestors as $ancestor_id ) {
                $out .= '<li class="breadcrumb-item"><a href="' . esc_url( get_permalink( $ancestor_id ) ) . '">' . esc_html( get_the_title( $ancestor_id ) ) . '</a></li>';
            }
        }
        $out .= '<li class="breadcrumb-item active">' . esc_html( get_the_title() ) . '</li>';
    } elseif ( is_search() ) {
        /* translators: %s: search query */
        $out .= '<li class="breadcrumb-item active">' . sprintf( esc_html__( 'Search: %s', 'wpwisebones' ), get_search_query() ) . '</li>';
    } elseif ( is_404() ) {
        $out .= '<li class="breadcrumb-item active">' . esc_html__( '404 Not Found', 'wpwisebones' ) . '</li>';
    }

    $out .= '</ol></div></nav>';
    echo $out; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}

/* â”€â”€ Pagination â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_pagination() {
    global $wp_query;
    if ( $wp_query->max_num_pages <= 1 ) return;

    $links = paginate_links( [
        'type'               => 'list',
        'prev_text'          => '<i class="bi bi-chevron-left"></i>',
        'next_text'          => '<i class="bi bi-chevron-right"></i>',
        'before_page_number' => '<span class="visually-hidden">' . __( 'Page', 'wpwisebones' ) . ' </span>',
    ] );

    echo '<nav aria-label="' . esc_attr__( 'Posts navigation', 'wpwisebones' ) . '" class="mt-4">';
    echo wp_kses_post( $links );
    echo '</nav>';
}

/* â”€â”€ Post meta helpers â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_posted_on() {
    $time = '<time class="entry-date published" datetime="' . esc_attr( get_the_date( DATE_W3C ) ) . '">' . esc_html( get_the_date() ) . '</time>';
    echo '<span class="posted-on me-3"><i class="bi bi-calendar3 me-1"></i>' . $time . '</span>'; // phpcs:ignore
}

function wpb_posted_by() {
    echo '<span class="byline me-3"><i class="bi bi-person me-1"></i><a href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'; // phpcs:ignore
}

function wpb_entry_footer() {
    $cats = get_the_category_list( ', ' );
    $tags = get_the_tag_list( '', ', ' );
    $edit = get_edit_post_link();

    if ( $cats ) echo '<span class="cat-links me-3"><i class="bi bi-folder me-1"></i>' . $cats . '</span>'; // phpcs:ignore
    if ( $tags ) echo '<span class="tags-links me-3"><i class="bi bi-tags me-1"></i>' . $tags . '</span>';  // phpcs:ignore
    if ( $edit ) echo '<span class="edit-link"><a href="' . esc_url( $edit ) . '">' . esc_html__( 'Edit', 'wpwisebones' ) . '</a></span>'; // phpcs:ignore
}

/* â”€â”€ Reading time â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_reading_time(): string {
    $words   = str_word_count( wp_strip_all_tags( get_the_content() ) );
    $minutes = max( 1, (int) ceil( $words / 200 ) );
    /* translators: %d: estimated reading time in minutes */
    return sprintf( _n( '%d min read', '%d mins read', $minutes, 'wpwisebones' ), $minutes );
}

/* â”€â”€ Social share buttons â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpb_social_share() {
    $url   = rawurlencode( get_permalink() );
    $title = rawurlencode( get_the_title() );

    $networks = [
        'twitter'   => [ 'https://twitter.com/intent/tweet?url=%s&text=%s',     'Twitter / X',   'bi-twitter-x'   ],
        'facebook'  => [ 'https://www.facebook.com/sharer/sharer.php?u=%s',      'Facebook',      'bi-facebook'    ],
        'linkedin'  => [ 'https://www.linkedin.com/sharing/share-offsite/?url=%s', 'LinkedIn',    'bi-linkedin'    ],
        'whatsapp'  => [ 'https://api.whatsapp.com/send?text=%s%%20%s',          'WhatsApp',      'bi-whatsapp'    ],
    ];

    echo '<div class="wpb-share d-flex gap-2 flex-wrap mt-3">';
    echo '<span class="fw-bold me-1">' . esc_html__( 'Share:', 'wpwisebones' ) . '</span>';
    foreach ( $networks as $key => [ $pattern, $label, $icon ] ) {
        $href = sprintf( $pattern, $url, $title );
        printf(
            '<a href="%s" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-outline-secondary" aria-label="%s"><i class="bi %s"></i> %s</a>',
            esc_url( $href ),
            esc_attr( $label ),
            esc_attr( $icon ),
            esc_html( $label )
        );
    }
    echo '</div>';
}

/* â”€â”€ Conditional body classes â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_filter( 'body_class', 'wpb_body_classes' );
function wpb_body_classes( array $classes ): array {
    $classes[] = 'layout-' . wpb_get_layout();

    if ( is_singular() && ! is_attachment() && has_post_thumbnail() ) {
        $classes[] = 'has-post-thumbnail';
    }

    if ( get_theme_mod( 'wpb_sticky_header', true ) ) {
        $classes[] = 'sticky-header';
    }

    return $classes;
}
