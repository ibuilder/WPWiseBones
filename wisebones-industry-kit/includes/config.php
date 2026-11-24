<?php
/**
 * Which content types, labels, schema type and lead form the site uses.
 *
 * The active theme declares its defaults through
 * add_theme_support( 'wisebones-industry', array( ... ) ) — the WPWiseBones
 * industry child themes do this from their industry-config.php. The owner can
 * override every choice on Settings → Industry Kit.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Every content type the kit can register.
 *
 * @return array<string,array> type => [ plural, singular, slug, icon, public ]
 */
function wbik_all_types(): array {
	return array(
		'listing'     => array( __( 'Listings', 'wisebones-industry-kit' ), __( 'Listing', 'wisebones-industry-kit' ), 'listings', 'dashicons-admin-home', true ),
		'project'     => array( __( 'Projects', 'wisebones-industry-kit' ), __( 'Project', 'wisebones-industry-kit' ), 'projects', 'dashicons-building', true ),
		'service'     => array( __( 'Services', 'wisebones-industry-kit' ), __( 'Service', 'wisebones-industry-kit' ), 'services', 'dashicons-hammer', true ),
		'team'        => array( __( 'Team', 'wisebones-industry-kit' ), __( 'Team member', 'wisebones-industry-kit' ), 'team', 'dashicons-groups', true ),
		'testimonial' => array( __( 'Testimonials', 'wisebones-industry-kit' ), __( 'Testimonial', 'wisebones-industry-kit' ), 'testimonials', 'dashicons-format-quote', false ),
	);
}

/**
 * Schema.org business types offered in settings.
 *
 * @return string[]
 */
function wbik_schema_types(): array {
	return array(
		'LocalBusiness',
		'RealEstateAgent',
		'FinancialService',
		'ProfessionalService',
		'HomeAndConstructionBusiness',
		'GeneralContractor',
		'RoofingContractor',
		'HVACBusiness',
		'Plumber',
		'Electrician',
		'HousePainter',
	);
}

/**
 * The theme's declared defaults.
 */
function wbik_theme_support(): array {
	$support = get_theme_support( 'wisebones-industry' );
	return ( is_array( $support ) && isset( $support[0] ) && is_array( $support[0] ) ) ? $support[0] : array();
}

/**
 * Saved settings merged over the theme's defaults.
 */
function wbik_settings(): array {
	$theme = wbik_theme_support();
	$saved = get_option( 'wbik_settings', array() );
	$saved = is_array( $saved ) ? $saved : array();

	$defaults = array(
		'types'      => isset( $theme['content_types'] ) ? (array) $theme['content_types'] : array( 'service', 'testimonial' ),
		'schema'     => isset( $theme['schema'] ) ? (string) $theme['schema'] : 'LocalBusiness',
		'lead_type'  => isset( $theme['lead_type'] ) ? (string) $theme['lead_type'] : 'contact',
		'lead_email' => '',
		'business'   => '',
		'phone'      => '',
		'email'      => '',
		'street'     => '',
		'city'       => '',
		'region'     => '',
		'postal'     => '',
		'country'    => '',
		'license'    => '',
		'price_from' => '',
		'currency'   => 'USD',
		'consent'    => '',
		'use_theme'  => 1,
	);

	$settings = wp_parse_args( $saved, $defaults );

	// "Follow the theme" keeps types, schema and lead form in step with
	// whichever industry theme is active, so switching themes just works.
	if ( ! empty( $settings['use_theme'] ) && $theme ) {
		$settings['types']     = $defaults['types'];
		$settings['schema']    = $defaults['schema'];
		$settings['lead_type'] = $defaults['lead_type'];
	}

	$settings['types'] = array_values( array_intersect( (array) $settings['types'], array_keys( wbik_all_types() ) ) );
	if ( ! in_array( $settings['schema'], wbik_schema_types(), true ) ) {
		$settings['schema'] = 'LocalBusiness';
	}
	return $settings;
}

/**
 * Whether a content type is switched on.
 *
 * @param string $type Content type.
 */
function wbik_type_enabled( string $type ): bool {
	return in_array( $type, wbik_settings()['types'], true );
}

/**
 * Plural and singular labels, honouring the theme's relabelling.
 *
 * @param string $type Content type.
 * @return string[] [ plural, singular ]
 */
function wbik_type_labels( string $type ): array {
	$all   = wbik_all_types();
	$theme = wbik_theme_support();
	if ( ! empty( $theme['labels'][ $type ] ) ) {
		$pair = array_values( (array) $theme['labels'][ $type ] );
		return array( (string) $pair[0], (string) ( isset( $pair[1] ) ? $pair[1] : $pair[0] ) );
	}
	return array( $all[ $type ][0], $all[ $type ][1] );
}

/**
 * The business name for schema and emails.
 */
function wbik_business_name(): string {
	$name = wbik_settings()['business'];
	return '' !== $name ? $name : get_bloginfo( 'name' );
}

/**
 * The business phone: settings first, then the theme's Customizer field.
 */
function wbik_business_phone(): string {
	$phone = wbik_settings()['phone'];
	return '' !== $phone ? $phone : (string) get_theme_mod( 'wpwisebones_ind_phone', '' );
}
