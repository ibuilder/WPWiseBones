<?php
/**
 * AJAX handlers.
 */

defined( 'ABSPATH' ) || exit;

/* â”€â”€ Load More posts â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_ajax_wpwisebones_load_more', 'wpwisebones_ajax_load_more' );
add_action( 'wp_ajax_nopriv_wpwisebones_load_more', 'wpwisebones_ajax_load_more' );

function wpwisebones_ajax_load_more() {
	check_ajax_referer( 'wpwisebones_nonce', 'nonce' );

	$page = max( 1, absint( $_POST['page'] ?? 2 ) );

	/*
	 * This handler answers logged-out visitors, and the nonce it checks is
	 * printed into every page for exactly that reason — so the nonce proves the
	 * request came from the site, never who sent it. The caller's query vars are
	 * therefore treated as hostile: only the keys below are honoured, and
	 * post_status, post_type and the paging are set here rather than by the
	 * caller. Merging the caller's vars *over* the defaults, which is what this
	 * did before, let anyone read drafts and private posts by asking for them.
	 */
	$allowed = array( 'cat', 'category_name', 'tag', 'tag_id', 'author', 'author_name', 's', 'orderby', 'order', 'post_type', 'posts_per_page' );

	$raw       = sanitize_text_field( wp_unslash( $_POST['query'] ?? '' ) );
	$requested = array();

	if ( $raw ) {
		parse_str( $raw, $requested );
	}

	$query_vars = array();

	foreach ( $allowed as $key ) {
		if ( isset( $requested[ $key ] ) && is_scalar( $requested[ $key ] ) ) {
			$query_vars[ $key ] = sanitize_text_field( (string) $requested[ $key ] );
		}
	}

	// A post type has to be one the public can already browse.
	$post_type = 'post';

	if ( ! empty( $query_vars['post_type'] ) ) {
		$public = get_post_types(
			array(
				'public'              => true,
				'exclude_from_search' => false,
			),
			'names'
		);

		if ( in_array( $query_vars['post_type'], $public, true ) ) {
			$post_type = $query_vars['post_type'];
		}
	}

	// And a page size has to stay a page size.
	$per_page = (int) get_option( 'posts_per_page', 10 );

	if ( isset( $query_vars['posts_per_page'] ) ) {
		$per_page = min( 24, max( 1, absint( $query_vars['posts_per_page'] ) ) );
	}

	$orderby_allowed = array( 'date', 'title', 'menu_order', 'rand', 'comment_count', 'modified' );
	$orderby         = isset( $query_vars['orderby'] ) && in_array( $query_vars['orderby'], $orderby_allowed, true )
		? $query_vars['orderby']
		: 'date';
	$order           = isset( $query_vars['order'] ) && 'ASC' === strtoupper( (string) $query_vars['order'] ) ? 'ASC' : 'DESC';

	unset( $query_vars['post_type'], $query_vars['posts_per_page'], $query_vars['orderby'], $query_vars['order'] );

	$args = array_merge(
		$query_vars,
		array(
			'post_type'           => $post_type,
			'post_status'         => 'publish',
			'posts_per_page'      => $per_page,
			'orderby'             => $orderby,
			'order'               => $order,
			'paged'               => $page,
			'ignore_sticky_posts' => true,
			'no_found_rows'       => false,
			'perm'                => 'readable',
		)
	);

	$query = new WP_Query( $args );

	if ( ! $query->have_posts() ) {
		wp_send_json_success(
			array(
				'html'     => '',
				'has_more' => false,
			)
		);
	}

	ob_start();
	while ( $query->have_posts() ) {
		$query->the_post();
		get_template_part( 'template-parts/content/content', get_post_type() );
	}
	wp_reset_postdata();
	$html = ob_get_clean();

	wp_send_json_success(
		array(
			'html'     => $html,
			'has_more' => $page < $query->max_num_pages,
		)
	);
}

/* â”€â”€ Live search (optional) â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'wp_ajax_wpwisebones_live_search', 'wpwisebones_ajax_live_search' );
add_action( 'wp_ajax_nopriv_wpwisebones_live_search', 'wpwisebones_ajax_live_search' );

function wpwisebones_ajax_live_search() {
	check_ajax_referer( 'wpwisebones_nonce', 'nonce' );

	$term = sanitize_text_field( wp_unslash( $_POST['term'] ?? '' ) );
	if ( strlen( $term ) < 2 ) {
		wp_send_json_success( array() );
	}

	$results = new WP_Query(
		array(
			's'              => $term,
			'posts_per_page' => 5,
			'no_found_rows'  => true,
			'post_status'    => 'publish',
		)
	);

	$data = array();
	while ( $results->have_posts() ) {
		$results->the_post();
		$data[] = array(
			'id'    => get_the_ID(),
			'title' => get_the_title(),
			'url'   => get_permalink(),
			'thumb' => get_the_post_thumbnail_url( null, 'thumbnail' ) ? get_the_post_thumbnail_url( null, 'thumbnail' ) : '',
			'date'  => get_the_date(),
		);
	}
	wp_reset_postdata();

	wp_send_json_success( $data );
}
