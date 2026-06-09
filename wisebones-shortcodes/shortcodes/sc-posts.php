<?php
/**
 * Shortcode: [wpb_posts]
 *
 * Renders a Bootstrap card grid of posts.
 *
 * Usage:
 *   [wpb_posts count="3" category="news" orderby="date" columns="3" show_excerpt="true" show_date="true"]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_posts', 'wpb_sc_posts' );

function wpb_sc_posts( array $atts ): string {
    $a = shortcode_atts( [
        'count'        => '3',
        'category'     => '',
        'tag'          => '',
        'orderby'      => 'date',
        'order'        => 'DESC',
        'columns'      => '3',
        'show_excerpt' => 'true',
        'show_date'    => 'true',
        'show_thumb'   => 'true',
        'show_author'  => 'false',
        'image_size'   => 'wpb-card',
        'btn_text'     => __( 'Read More', 'wisebones-shortcodes' ),
        'class'        => '',
    ], $atts, 'wpb_posts' );

    $query_args = [
        'post_type'      => 'post',
        'posts_per_page' => absint( $a['count'] ),
        'orderby'        => sanitize_key( $a['orderby'] ),
        'order'          => in_array( strtoupper( $a['order'] ), [ 'ASC', 'DESC' ], true ) ? $a['order'] : 'DESC',
        'no_found_rows'  => true,
    ];

    if ( $a['category'] ) {
        $query_args['category_name'] = sanitize_text_field( $a['category'] );
    }
    if ( $a['tag'] ) {
        $query_args['tag'] = sanitize_text_field( $a['tag'] );
    }

    $posts = new WP_Query( $query_args );

    if ( ! $posts->have_posts() ) {
        return '<p class="text-muted">' . esc_html__( 'No posts found.', 'wisebones-shortcodes' ) . '</p>';
    }

    $col_map = [ '1' => '12', '2' => '6', '3' => '4', '4' => '3', '6' => '2' ];
    $col_cls = 'col-md-' . ( $col_map[ $a['columns'] ] ?? '4' );

    $html = '<div class="row g-4 wpb-posts-shortcode ' . esc_attr( $a['class'] ) . '">';

    while ( $posts->have_posts() ) {
        $posts->the_post();

        $html .= '<div class="' . $col_cls . '">';
        $html .= '<div class="card h-100 post-card border-0 shadow-sm">';

        if ( 'true' === $a['show_thumb'] && has_post_thumbnail() ) {
            $html .= '<a href="' . esc_url( get_permalink() ) . '">';
            $html .= get_the_post_thumbnail( null, $a['image_size'], [ 'class' => 'card-img-top' ] );
            $html .= '</a>';
        }

        $html .= '<div class="card-body d-flex flex-column">';
        $html .= '<h5 class="card-title"><a href="' . esc_url( get_permalink() ) . '" class="text-dark text-decoration-none">' . esc_html( get_the_title() ) . '</a></h5>';

        if ( 'true' === $a['show_date'] || 'true' === $a['show_author'] ) {
            $html .= '<p class="card-text text-muted small mb-2">';
            if ( 'true' === $a['show_date'] )   $html .= '<i class="bi bi-calendar3 me-1"></i>' . esc_html( get_the_date() ) . ' ';
            if ( 'true' === $a['show_author'] ) $html .= '<i class="bi bi-person me-1"></i>' . esc_html( get_the_author() );
            $html .= '</p>';
        }

        if ( 'true' === $a['show_excerpt'] ) {
            $html .= '<p class="card-text flex-grow-1">' . esc_html( wp_trim_words( get_the_excerpt(), 20 ) ) . '</p>';
        }

        $html .= '<a href="' . esc_url( get_permalink() ) . '" class="btn btn-sm btn-outline-primary mt-auto">' . esc_html( $a['btn_text'] ) . '</a>';
        $html .= '</div></div></div>';
    }

    $html .= '</div>';
    wp_reset_postdata();

    return $html;
}
