<?php
/**
 * Post types and taxonomies.
 *
 * Post types are named wbik_{type}; the theme reads them by that name. Meta
 * keys are _wbik_{field} and are listed in wbik_fields().
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', 'wbik_register_content_types', 5 );

/**
 * Register the enabled post types, their taxonomies and their meta.
 */
function wbik_register_content_types() {
	foreach ( wbik_all_types() as $type => $def ) {
		if ( ! wbik_type_enabled( $type ) ) {
			continue;
		}
		list( $plural, $singular ) = wbik_type_labels( $type );
		$public                    = (bool) $def[4];

		register_post_type(
			'wbik_' . $type,
			array(
				'labels'             => array(
					'name'          => $plural,
					'singular_name' => $singular,
					/* translators: %s: singular content label. */
					'add_new_item'  => sprintf( __( 'Add new %s', 'wisebones-industry-kit' ), strtolower( $singular ) ),
					/* translators: %s: singular content label. */
					'edit_item'     => sprintf( __( 'Edit %s', 'wisebones-industry-kit' ), strtolower( $singular ) ),
					/* translators: %s: plural content label. */
					'search_items'  => sprintf( __( 'Search %s', 'wisebones-industry-kit' ), strtolower( $plural ) ),
					/* translators: %s: plural content label. */
					'not_found'     => sprintf( __( 'No %s found.', 'wisebones-industry-kit' ), strtolower( $plural ) ),
					'menu_name'     => $plural,
				),
				'public'             => $public,
				'publicly_queryable' => $public,
				'show_ui'            => true,
				'show_in_rest'       => true,
				'has_archive'        => $public ? sanitize_title( $plural ) : false,
				'rewrite'            => $public ? array(
					'slug'       => sanitize_title( $plural ),
					'with_front' => false,
				) : false,
				'menu_icon'          => $def[3],
				'menu_position'      => 21,
				'supports'           => 'testimonial' === $type
					? array( 'title', 'editor', 'page-attributes' )
					: array( 'title', 'editor', 'excerpt', 'thumbnail', 'page-attributes', 'revisions' ),
			)
		);

		foreach ( wbik_fields( $type ) as $key => $field ) {
			register_post_meta(
				'wbik_' . $type,
				'_wbik_' . $key,
				array(
					'type'              => 'string',
					'single'            => true,
					'show_in_rest'      => true,
					'sanitize_callback' => static function ( $value ) use ( $field ) {
						return wbik_sanitize_field( $value, $field );
					},
					'auth_callback'     => static function () {
						return current_user_can( 'edit_posts' );
					},
				)
			);
		}
	}

	if ( wbik_type_enabled( 'listing' ) ) {
		register_taxonomy(
			'wbik_listing_type',
			array( 'wbik_listing' ),
			array(
				'labels'            => array(
					'name'          => __( 'Property types', 'wisebones-industry-kit' ),
					'singular_name' => __( 'Property type', 'wisebones-industry-kit' ),
				),
				'hierarchical'      => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => 'property-type' ),
			)
		);
	}

	if ( wbik_type_enabled( 'project' ) ) {
		register_taxonomy(
			'wbik_project_sector',
			array( 'wbik_project' ),
			array(
				'labels'            => array(
					'name'          => __( 'Sectors', 'wisebones-industry-kit' ),
					'singular_name' => __( 'Sector', 'wisebones-industry-kit' ),
				),
				'hierarchical'      => true,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => 'sector' ),
			)
		);
	}

	$area_types = array();
	foreach ( array( 'listing', 'project', 'service', 'team' ) as $type ) {
		if ( wbik_type_enabled( $type ) ) {
			$area_types[] = 'wbik_' . $type;
		}
	}
	if ( $area_types ) {
		register_taxonomy(
			'wbik_area',
			$area_types,
			array(
				'labels'            => array(
					'name'          => __( 'Service areas', 'wisebones-industry-kit' ),
					'singular_name' => __( 'Service area', 'wisebones-industry-kit' ),
				),
				'hierarchical'      => false,
				'show_in_rest'      => true,
				'show_admin_column' => true,
				'rewrite'           => array( 'slug' => 'area' ),
			)
		);
	}

	// Leads are private records, never public.
	register_post_type(
		'wbik_lead',
		array(
			'labels'          => array(
				'name'          => __( 'Leads', 'wisebones-industry-kit' ),
				'singular_name' => __( 'Lead', 'wisebones-industry-kit' ),
				'menu_name'     => __( 'Leads', 'wisebones-industry-kit' ),
				'edit_item'     => __( 'Lead', 'wisebones-industry-kit' ),
				'not_found'     => __( 'No leads yet.', 'wisebones-industry-kit' ),
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'show_in_rest'    => false,
			'menu_icon'       => 'dashicons-email-alt',
			'menu_position'   => 22,
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
			'capabilities'    => array( 'create_posts' => 'do_not_allow' ),
			'map_meta_cap'    => true,
		)
	);

	// Re-flush once after the set of types changes (theme switch, settings).
	$signature = md5( wp_json_encode( array( wbik_settings()['types'], wbik_theme_support()['labels'] ?? array() ) ) );
	if ( get_option( 'wbik_rewrite_signature' ) !== $signature ) {
		update_option( 'wbik_rewrite_signature', $signature, false );
		add_action( 'wp_loaded', 'flush_rewrite_rules' );
	}
}

/**
 * Meta fields per content type.
 *
 * @param string $type Content type.
 * @return array<string,array> key => [ label, type, options?, placeholder? ]
 */
function wbik_fields( string $type ): array {
	$fields = array(
		'listing'     => array(
			'status'       => array(
				'label'   => __( 'Status', 'wisebones-industry-kit' ),
				'type'    => 'select',
				'options' => array(
					'for-sale'    => __( 'For sale', 'wisebones-industry-kit' ),
					'for-rent'    => __( 'For rent', 'wisebones-industry-kit' ),
					'for-lease'   => __( 'For lease', 'wisebones-industry-kit' ),
					'coming-soon' => __( 'Coming soon', 'wisebones-industry-kit' ),
					'pending'     => __( 'Pending', 'wisebones-industry-kit' ),
					'sold'        => __( 'Sold', 'wisebones-industry-kit' ),
					'leased'      => __( 'Leased', 'wisebones-industry-kit' ),
					'move-in'     => __( 'Move-in ready', 'wisebones-industry-kit' ),
					'plan'        => __( 'Floor plan', 'wisebones-industry-kit' ),
				),
			),
			'price'        => array(
				'label' => __( 'Price', 'wisebones-industry-kit' ),
				'type'  => 'number',
			),
			'price_suffix' => array(
				'label'       => __( 'Price suffix', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( '/mo, /sf/yr, from…', 'wisebones-industry-kit' ),
			),
			'beds'         => array(
				'label' => __( 'Bedrooms', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'baths'        => array(
				'label' => __( 'Bathrooms', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'sqft'         => array(
				'label' => __( 'Floor area (sq ft)', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'units'        => array(
				'label' => __( 'Units (multifamily / commercial)', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'lot'          => array(
				'label' => __( 'Lot size', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'year_built'   => array(
				'label' => __( 'Year built', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'address'      => array(
				'label' => __( 'Street address', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'city'         => array(
				'label' => __( 'City', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'region'       => array(
				'label' => __( 'State / region', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'postal'       => array(
				'label' => __( 'ZIP / postal code', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'mls'          => array(
				'label' => __( 'MLS / reference #', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'tour'         => array(
				'label' => __( 'Virtual tour URL', 'wisebones-industry-kit' ),
				'type'  => 'url',
			),
		),
		'project'     => array(
			'client'   => array(
				'label' => __( 'Client', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'location' => array(
				'label' => __( 'Location', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'year'     => array(
				'label' => __( 'Year completed', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'value'    => array(
				'label'       => __( 'Contract value', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( '$4.2M', 'wisebones-industry-kit' ),
			),
			'size'     => array(
				'label'       => __( 'Size', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( '42,000 sf', 'wisebones-industry-kit' ),
			),
			'duration' => array(
				'label' => __( 'Duration', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'role'     => array(
				'label'       => __( 'Our role', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( 'General contractor, design-build…', 'wisebones-industry-kit' ),
			),
			'status'   => array(
				'label'   => __( 'Status', 'wisebones-industry-kit' ),
				'type'    => 'select',
				'options' => array(
					'completed'   => __( 'Completed', 'wisebones-industry-kit' ),
					'in-progress' => __( 'In progress', 'wisebones-industry-kit' ),
					'planning'    => __( 'Preconstruction', 'wisebones-industry-kit' ),
				),
			),
		),
		'service'     => array(
			'icon'       => array(
				'label'       => __( 'Icon (Bootstrap Icons class)', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => 'bi-house-gear',
			),
			'price_from' => array(
				'label'       => __( 'Starting price', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( 'From $450', 'wisebones-industry-kit' ),
			),
		),
		'team'        => array(
			'role'    => array(
				'label' => __( 'Role / title', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'license' => array(
				'label'       => __( 'License / NMLS #', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( 'DRE #01234567', 'wisebones-industry-kit' ),
			),
			'phone'   => array(
				'label' => __( 'Phone', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'email'   => array(
				'label' => __( 'Email', 'wisebones-industry-kit' ),
				'type'  => 'email',
			),
		),
		'testimonial' => array(
			'author_name' => array(
				'label' => __( 'Client name', 'wisebones-industry-kit' ),
				'type'  => 'text',
			),
			'author_role' => array(
				'label'       => __( 'Client detail', 'wisebones-industry-kit' ),
				'type'        => 'text',
				'placeholder' => __( 'Sold in Maplewood, 2025', 'wisebones-industry-kit' ),
			),
			'rating'      => array(
				'label'   => __( 'Rating', 'wisebones-industry-kit' ),
				'type'    => 'select',
				'options' => array(
					''  => __( 'No rating', 'wisebones-industry-kit' ),
					'5' => '5',
					'4' => '4',
					'3' => '3',
				),
			),
		),
	);
	return isset( $fields[ $type ] ) ? $fields[ $type ] : array();
}

/**
 * Sanitize one field value by its type.
 *
 * @param mixed $value Raw value.
 * @param array $field Field definition.
 */
function wbik_sanitize_field( $value, array $field ) {
	$value = is_scalar( $value ) ? (string) $value : '';
	switch ( $field['type'] ) {
		case 'number':
			// Stored as a plain digit string so an empty value stays empty.
			return (string) preg_replace( '/[^0-9.]/', '', $value );
		case 'url':
			return esc_url_raw( $value );
		case 'email':
			return sanitize_email( $value );
		case 'select':
			return array_key_exists( $value, $field['options'] ) ? $value : '';
		default:
			return sanitize_text_field( $value );
	}
}
