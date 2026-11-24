<?php
/**
 * Schema.org JSON-LD: the business on the front page (typed from settings —
 * RealEstateAgent, GeneralContractor, RoofingContractor…), and an offer on
 * each single listing.
 *
 * The WPWiseBones parent prints Article / WebSite schema and steps aside for
 * SEO plugins; this adds the local-business entity none of those cover by
 * default. Turn it off with add_filter( 'wbik_schema_enabled', '__return_false' ).
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_head', 'wbik_print_schema', 30 );

/**
 * Print the JSON-LD block for the current view.
 */
function wbik_print_schema() {
	if ( ! apply_filters( 'wbik_schema_enabled', true ) ) {
		return;
	}
	$graph = array();
	if ( is_front_page() ) {
		$graph[] = wbik_business_schema();
	}
	if ( is_singular( 'wbik_listing' ) ) {
		$graph[] = wbik_listing_schema( get_queried_object_id() );
	}
	$graph = array_filter( (array) apply_filters( 'wbik_schema_graph', $graph ) );
	if ( ! $graph ) {
		return;
	}
	echo "\n<script type=\"application/ld+json\">" . wp_json_encode(
		array(
			'@context' => 'https://schema.org',
			'@graph'   => array_values( $graph ),
		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG
	) . "</script>\n";
}

/**
 * The business entity.
 */
function wbik_business_schema(): array {
	$s    = wbik_settings();
	$node = array(
		'@type' => $s['schema'],
		'@id'   => home_url( '/#business' ),
		'name'  => wbik_business_name(),
		'url'   => home_url( '/' ),
	);
	if ( get_bloginfo( 'description' ) ) {
		$node['description'] = get_bloginfo( 'description' );
	}
	$phone = wbik_business_phone();
	if ( $phone ) {
		$node['telephone'] = $phone;
	}
	if ( is_email( $s['email'] ) ) {
		$node['email'] = $s['email'];
	}
	$logo = get_theme_mod( 'custom_logo' );
	if ( $logo ) {
		$src = wp_get_attachment_image_url( (int) $logo, 'full' );
		if ( $src ) {
			$node['logo']  = $src;
			$node['image'] = $src;
		}
	}
	if ( $s['street'] || $s['city'] ) {
		$node['address'] = array_filter(
			array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => $s['street'],
				'addressLocality' => $s['city'],
				'addressRegion'   => $s['region'],
				'postalCode'      => $s['postal'],
				'addressCountry'  => $s['country'],
			)
		);
	}
	if ( $s['price_from'] ) {
		$node['priceRange'] = $s['price_from'];
	}
	if ( taxonomy_exists( 'wbik_area' ) ) {
		$areas = get_terms(
			array(
				'taxonomy'   => 'wbik_area',
				'hide_empty' => false,
				'fields'     => 'names',
				'number'     => 30,
			)
		);
		if ( $areas && ! is_wp_error( $areas ) ) {
			$node['areaServed'] = array_values( $areas );
		}
	}
	$same = array();
	foreach ( array( 'facebook', 'twitter', 'instagram', 'linkedin', 'youtube', 'pinterest', 'tiktok' ) as $net ) {
		$url = get_theme_mod( 'wpwisebones_social_' . $net, '' );
		if ( $url ) {
			$same[] = esc_url_raw( $url );
		}
	}
	if ( $same ) {
		$node['sameAs'] = $same;
	}
	if ( $s['license'] ) {
		$node['hasCredential'] = array(
			'@type'              => 'EducationalOccupationalCredential',
			'credentialCategory' => 'license',
			'name'               => $s['license'],
		);
	}
	return (array) apply_filters( 'wbik_business_schema', $node );
}

/**
 * A single listing as a RealEstateListing with an Offer.
 *
 * @param int $post_id Listing ID.
 */
function wbik_listing_schema( int $post_id ): array {
	$meta = static function ( $key ) use ( $post_id ) {
		return (string) get_post_meta( $post_id, '_wbik_' . $key, true );
	};
	$node = array(
		'@type'       => 'RealEstateListing',
		'@id'         => get_permalink( $post_id ) . '#listing',
		'name'        => get_the_title( $post_id ),
		'url'         => get_permalink( $post_id ),
		'datePosted'  => get_the_date( 'c', $post_id ),
		'description' => wp_strip_all_tags( get_the_excerpt( $post_id ) ),
	);
	$image = get_the_post_thumbnail_url( $post_id, 'full' );
	if ( $image ) {
		$node['image'] = $image;
	}
	if ( is_numeric( $meta( 'price' ) ) ) {
		$node['offers'] = array(
			'@type'         => 'Offer',
			'price'         => (float) $meta( 'price' ),
			'priceCurrency' => wbik_settings()['currency'],
			'availability'  => in_array( $meta( 'status' ), array( 'sold', 'leased' ), true ) ? 'https://schema.org/SoldOut' : 'https://schema.org/InStock',
			'seller'        => array( '@id' => home_url( '/#business' ) ),
		);
	}
	if ( $meta( 'address' ) || $meta( 'city' ) ) {
		$node['contentLocation'] = array(
			'@type'   => 'Place',
			'address' => array_filter(
				array(
					'@type'           => 'PostalAddress',
					'streetAddress'   => $meta( 'address' ),
					'addressLocality' => $meta( 'city' ),
					'addressRegion'   => $meta( 'region' ),
					'postalCode'      => $meta( 'postal' ),
				)
			),
		);
	}
	return (array) apply_filters( 'wbik_listing_schema', $node, $post_id );
}
