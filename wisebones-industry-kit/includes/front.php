<?php
/**
 * Front-end output: a facts panel on single entries, archive filters for the
 * property search, and the kit's small stylesheet.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', 'wbik_enqueue' );

/**
 * The kit's stylesheet: facts panel and form styles, written against
 * Bootstrap classes so it looks native under WPWiseBones.
 */
function wbik_enqueue() {
	wp_enqueue_style( 'wisebones-industry-kit', WBIK_URI . 'assets/css/kit.css', array(), WBIK_VERSION );
}

add_filter( 'the_content', 'wbik_single_content', 20 );

/**
 * Put the facts panel above a single listing, project or team member, and a
 * request form below a listing.
 *
 * @param string $content Post content.
 */
function wbik_single_content( $content ) {
	if ( ! is_singular() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}
	$post_type = get_post_type();
	if ( ! in_array( $post_type, array( 'wbik_listing', 'wbik_project', 'wbik_team', 'wbik_service' ), true ) ) {
		return $content;
	}
	$type   = substr( $post_type, 5 );
	$facts  = wbik_facts_html( get_the_ID(), $type );
	$after  = '';
	if ( 'listing' === $type ) {
		$after = do_shortcode( '[wbik_lead_form type="showing" title="' . esc_attr__( 'Ask about this property', 'wisebones-industry-kit' ) . '"]' );
	} elseif ( 'service' === $type ) {
		$after = do_shortcode( '[wbik_lead_form]' );
	}
	return $facts . $content . $after;
}

/**
 * The facts list for one entry.
 *
 * @param int    $post_id Post ID.
 * @param string $type    Content type.
 */
function wbik_facts_html( int $post_id, string $type ): string {
	$rows = array();
	foreach ( wbik_fields( $type ) as $key => $field ) {
		if ( in_array( $key, array( 'icon', 'price_suffix', 'email', 'phone' ), true ) ) {
			continue;
		}
		$value = (string) get_post_meta( $post_id, '_wbik_' . $key, true );
		if ( '' === $value ) {
			continue;
		}
		if ( 'select' === $field['type'] && isset( $field['options'][ $value ] ) ) {
			$value = $field['options'][ $value ];
		}
		if ( 'price' === $key && is_numeric( $value ) ) {
			$value = wbik_money( (float) $value ) . (string) get_post_meta( $post_id, '_wbik_price_suffix', true );
		}
		if ( 'url' === $field['type'] ) {
			$rows[] = '<div><dt>' . esc_html( $field['label'] ) . '</dt><dd><a href="' . esc_url( $value ) . '" rel="noopener">' . esc_html__( 'Open', 'wisebones-industry-kit' ) . '</a></dd></div>';
			continue;
		}
		$rows[] = '<div><dt>' . esc_html( $field['label'] ) . '</dt><dd>' . esc_html( $value ) . '</dd></div>';
	}
	if ( 'team' === $type ) {
		$phone = (string) get_post_meta( $post_id, '_wbik_phone', true );
		$email = (string) get_post_meta( $post_id, '_wbik_email', true );
		if ( $phone ) {
			$rows[] = '<div><dt>' . esc_html__( 'Phone', 'wisebones-industry-kit' ) . '</dt><dd><a href="' . esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $phone ) ) . '">' . esc_html( $phone ) . '</a></dd></div>';
		}
		if ( $email ) {
			$rows[] = '<div><dt>' . esc_html__( 'Email', 'wisebones-industry-kit' ) . '</dt><dd><a href="' . esc_url( 'mailto:' . antispambot( $email ) ) . '">' . esc_html( antispambot( $email ) ) . '</a></dd></div>';
		}
	}
	return $rows ? '<dl class="wbik-facts">' . implode( '', $rows ) . '</dl>' : '';
}

/**
 * A price in the configured currency.
 *
 * @param float $amount Amount.
 */
function wbik_money( float $amount ): string {
	$currency = wbik_settings()['currency'];
	$symbols  = array(
		'USD' => '$',
		'CAD' => 'CA$',
		'AUD' => 'A$',
		'GBP' => '£',
		'EUR' => '€',
	);
	$symbol   = isset( $symbols[ $currency ] ) ? $symbols[ $currency ] : $currency . ' ';
	return $symbol . number_format_i18n( $amount );
}

add_action( 'pre_get_posts', 'wbik_filter_listing_archive' );

/**
 * Read the hero search panel's filters on the listings archive.
 *
 * Public, read-only GET filters on an archive, so there is no nonce: the same
 * as WordPress's own ?s= search.
 *
 * @param WP_Query $query Query.
 */
function wbik_filter_listing_archive( $query ) {
	if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'wbik_listing' ) ) {
		return;
	}
	// phpcs:disable WordPress.Security.NonceVerification.Recommended
	$meta = array();
	if ( ! empty( $_GET['status'] ) ) {
		$meta[] = array(
			'key'   => '_wbik_status',
			'value' => sanitize_key( wp_unslash( $_GET['status'] ) ),
		);
	}
	if ( ! empty( $_GET['max_price'] ) ) {
		$meta[] = array(
			'key'     => '_wbik_price',
			'value'   => absint( $_GET['max_price'] ),
			'compare' => '<=',
			'type'    => 'NUMERIC',
		);
	}
	if ( $meta ) {
		$query->set( 'meta_query', $meta ); // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- visitor-chosen filter on a small archive.
	}
	if ( ! empty( $_GET['listing_type'] ) && taxonomy_exists( 'wbik_listing_type' ) ) {
		$query->set(
			'tax_query', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- visitor-chosen filter.
			array(
				array(
					'taxonomy' => 'wbik_listing_type',
					'field'    => 'slug',
					'terms'    => sanitize_title( wp_unslash( $_GET['listing_type'] ) ),
				),
			)
		);
	}
	// phpcs:enable
}
