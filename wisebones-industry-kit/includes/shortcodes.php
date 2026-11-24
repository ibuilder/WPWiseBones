<?php
/**
 * Grids for use in any page: [wbik_listings], [wbik_projects], [wbik_services],
 * [wbik_team], [wbik_testimonials], [wbik_areas].
 *
 * Under a WPWiseBones industry theme they reuse the theme's card templates, so
 * a grid on an inner page matches the front page exactly. Under any other
 * theme they fall back to simple Bootstrap cards.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'wbik_register_shortcodes' );

/**
 * Register the grid shortcodes.
 */
function wbik_register_shortcodes() {
	foreach ( array( 'listings' => 'listing', 'projects' => 'project', 'services' => 'service', 'team' => 'team', 'testimonials' => 'testimonial' ) as $tag => $type ) {
		add_shortcode(
			'wbik_' . $tag,
			static function ( $atts ) use ( $type ) {
				return wbik_grid( $type, (array) $atts );
			}
		);
	}
	add_shortcode( 'wbik_areas', 'wbik_areas_shortcode' );
}

/**
 * A grid of one content type.
 *
 * @param string $type Content type.
 * @param array  $atts count, columns, status (listings), sector (projects), area.
 */
function wbik_grid( string $type, array $atts ): string {
	if ( ! wbik_type_enabled( $type ) ) {
		return '';
	}
	$atts = shortcode_atts(
		array(
			'count'   => 6,
			'columns' => 3,
			'status'  => '',
			'sector'  => '',
			'area'    => '',
		),
		$atts
	);

	$args = array(
		'post_type'      => 'wbik_' . $type,
		'posts_per_page' => max( 1, min( 48, absint( $atts['count'] ) ) ),
		'no_found_rows'  => true,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
	);
	if ( 'listing' === $type && $atts['status'] ) {
		$args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- author-chosen filter.
			array(
				'key'     => '_wbik_status',
				'value'   => array_map( 'sanitize_key', explode( ',', $atts['status'] ) ),
				'compare' => 'IN',
			),
		);
	}
	$tax = array();
	if ( 'project' === $type && $atts['sector'] ) {
		$tax[] = array(
			'taxonomy' => 'wbik_project_sector',
			'field'    => 'slug',
			'terms'    => array_map( 'sanitize_title', explode( ',', $atts['sector'] ) ),
		);
	}
	if ( $atts['area'] && taxonomy_exists( 'wbik_area' ) ) {
		$tax[] = array(
			'taxonomy' => 'wbik_area',
			'field'    => 'slug',
			'terms'    => array_map( 'sanitize_title', explode( ',', $atts['area'] ) ),
		);
	}
	if ( $tax ) {
		$args['tax_query'] = $tax; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- author-chosen filter.
	}

	$posts = get_posts( $args );
	if ( ! $posts ) {
		return '';
	}

	$cols  = max( 1, min( 4, absint( $atts['columns'] ) ) );
	$class = array(
		1 => 'col-12',
		2 => 'col-md-6',
		3 => 'col-md-6 col-lg-4',
		4 => 'col-sm-6 col-lg-3',
	)[ $cols ];

	ob_start();
	echo '<div class="row g-4 wbik-grid wbik-grid--' . esc_attr( $type ) . '">';
	foreach ( $posts as $post ) {
		echo '<div class="' . esc_attr( $class ) . '">';
		wbik_render_card( $type, $post );
		echo '</div>';
	}
	echo '</div>';
	return (string) ob_get_clean();
}

/**
 * One card. Prefers the active theme's template-parts/industry/card-{type}.php.
 *
 * @param string  $type Content type.
 * @param WP_Post $post Post.
 */
function wbik_render_card( string $type, WP_Post $post ) {
	if ( in_array( $type, array( 'listing', 'project' ), true ) && locate_template( 'template-parts/industry/card-' . $type . '.php' ) ) {
		get_template_part(
			'template-parts/industry/card',
			$type,
			array(
				'card' => array(
					'id'     => $post->ID,
					'title'  => get_the_title( $post ),
					'url'    => get_permalink( $post ),
					'image'  => get_the_post_thumbnail( $post, 'medium_large', array( 'class' => 'wpb-ind-media__img' ) ),
					'sample' => false,
				),
			)
		);
		return;
	}

	$meta = static function ( $key ) use ( $post ) {
		return (string) get_post_meta( $post->ID, '_wbik_' . $key, true );
	};

	if ( 'testimonial' === $type ) {
		echo '<figure class="card h-100 wbik-card wbik-quote"><div class="card-body">';
		echo '<blockquote class="mb-3"><p>' . esc_html( wp_strip_all_tags( $post->post_content ) ) . '</p></blockquote>';
		echo '<figcaption><strong>' . esc_html( $meta( 'author_name' ) ? $meta( 'author_name' ) : get_the_title( $post ) ) . '</strong>';
		if ( $meta( 'author_role' ) ) {
			echo '<br><span class="text-muted small">' . esc_html( $meta( 'author_role' ) ) . '</span>';
		}
		echo '</figcaption></div></figure>';
		return;
	}

	echo '<article class="card h-100 wbik-card">';
	if ( has_post_thumbnail( $post ) ) {
		echo get_the_post_thumbnail( $post, 'medium_large', array( 'class' => 'card-img-top' ) );
	}
	echo '<div class="card-body">';
	if ( 'service' === $type && $meta( 'icon' ) ) {
		echo '<i class="bi ' . esc_attr( $meta( 'icon' ) ) . ' fs-2 d-block mb-2" aria-hidden="true"></i>';
	}
	echo '<h3 class="h5 card-title"><a class="stretched-link text-reset text-decoration-none" href="' . esc_url( get_permalink( $post ) ) . '">' . esc_html( get_the_title( $post ) ) . '</a></h3>';
	if ( 'team' === $type && $meta( 'role' ) ) {
		echo '<p class="mb-1 fw-semibold">' . esc_html( $meta( 'role' ) ) . '</p>';
	}
	if ( 'service' === $type && $meta( 'price_from' ) ) {
		echo '<p class="mb-1 fw-semibold">' . esc_html( $meta( 'price_from' ) ) . '</p>';
	}
	echo '<p class="card-text text-muted">' . esc_html( wp_trim_words( get_the_excerpt( $post ), 20 ) ) . '</p>';
	echo '</div></article>';
}

/**
 * [wbik_areas] — the service-area terms as a list of chips.
 */
function wbik_areas_shortcode(): string {
	if ( ! taxonomy_exists( 'wbik_area' ) ) {
		return '';
	}
	$terms = get_terms(
		array(
			'taxonomy'   => 'wbik_area',
			'hide_empty' => false,
		)
	);
	if ( ! $terms || is_wp_error( $terms ) ) {
		return '';
	}
	$out = '<ul class="wpb-ind-chips wbik-areas">';
	foreach ( $terms as $term ) {
		$link = get_term_link( $term );
		$out .= '<li><a href="' . esc_url( is_wp_error( $link ) ? '#' : $link ) . '"><i class="bi bi-geo-alt" aria-hidden="true"></i> ' . esc_html( $term->name ) . '</a></li>';
	}
	return $out . '</ul>';
}
