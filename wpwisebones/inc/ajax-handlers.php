<?php
/**
 * AJAX handlers.
 */

defined( 'ABSPATH' ) || exit;

/* â”€â”€ Load More posts â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_ajax_wpb_load_more',        'wpb_ajax_load_more' );
add_action( 'wp_ajax_nopriv_wpb_load_more', 'wpb_ajax_load_more' );

function wpb_ajax_load_more() {
    check_ajax_referer( 'wpb_nonce', 'nonce' );

    $page        = max( 1, absint( $_POST['page'] ?? 2 ) );
    $query_vars  = [];

    // Safely decode serialised query vars passed from JS data-query attribute
    $raw = sanitize_text_field( wp_unslash( $_POST['query'] ?? '' ) );
    if ( $raw ) {
        parse_str( $raw, $query_vars );
        $query_vars = array_map( 'sanitize_text_field', $query_vars );
    }

    $args = array_merge( [
        'post_type'      => 'post',
        'posts_per_page' => get_option( 'posts_per_page', 10 ),
        'post_status'    => 'publish',
    ], $query_vars, [
        'paged'         => $page,
        'no_found_rows' => false,
    ] );

    $query = new WP_Query( $args );

    if ( ! $query->have_posts() ) {
        wp_send_json_success( [ 'html' => '', 'has_more' => false ] );
    }

    ob_start();
    while ( $query->have_posts() ) {
        $query->the_post();
        get_template_part( 'template-parts/content/content', get_post_type() );
    }
    wp_reset_postdata();
    $html = ob_get_clean();

    wp_send_json_success( [
        'html'     => $html,
        'has_more' => $page < $query->max_num_pages,
    ] );
}

/* â”€â”€ Live search (optional) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_ajax_wpb_live_search',        'wpb_ajax_live_search' );
add_action( 'wp_ajax_nopriv_wpb_live_search', 'wpb_ajax_live_search' );

function wpb_ajax_live_search() {
    check_ajax_referer( 'wpb_nonce', 'nonce' );

    $term = sanitize_text_field( wp_unslash( $_POST['term'] ?? '' ) );
    if ( strlen( $term ) < 2 ) {
        wp_send_json_success( [] );
    }

    $results = new WP_Query( [
        's'              => $term,
        'posts_per_page' => 5,
        'no_found_rows'  => true,
        'post_status'    => 'publish',
    ] );

    $data = [];
    while ( $results->have_posts() ) {
        $results->the_post();
        $data[] = [
            'id'    => get_the_ID(),
            'title' => get_the_title(),
            'url'   => get_permalink(),
            'thumb' => get_the_post_thumbnail_url( null, 'thumbnail' ) ?: '',
            'date'  => get_the_date(),
        ];
    }
    wp_reset_postdata();

    wp_send_json_success( $data );
}
