<?php
/**
 * WiseBones Property Management — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Listings are relabelled "Rentals", so their archive lives at
 * /rentals/. See child-themes/README.md.
 *
 * @package WiseBones_Property_Management
 */

defined( 'ABSPATH' ) || exit;

$wbpm_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbpm_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbpm_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};
$wbpm_list = static function ( array $items ) {
	$out = '<!-- wp:list --><ul class="wp-block-list">';
	foreach ( $items as $item ) {
		$out .= '<!-- wp:list-item --><li><a href="#">' . esc_html( $item ) . '</a></li><!-- /wp:list-item -->';
	}
	return $out . '</ul><!-- /wp:list -->';
};

return array(
	'id'            => 'property-management',
	'family'        => 'real-estate',
	'label'         => __( 'Property Management', 'wisebones-property-management' ),
	'schema'        => 'ProfessionalService',
	'content_types' => array( 'listing', 'service', 'testimonial', 'team' ),
	'labels'        => array(
		'listing' => array( __( 'Rentals', 'wisebones-property-management' ), __( 'Rental', 'wisebones-property-management' ) ),
	),
	'lead_type'     => 'owner',
	'colors'        => array(
		'primary'   => '#2d5b9a',
		'secondary' => '#5a6577',
		'accent'    => '#f0715a',
		'header_bg' => '#ffffff',
		'footer_bg' => '#13243d',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Owner proposal', 'wisebones-property-management' ), '/owners/', 'bi-house-gear' ),

	'hero'          => array(
		'style'     => 'gradient',
		'eyebrow'   => __( 'Full-service property management', 'wisebones-property-management' ),
		'heading'   => __( 'Rentals that run themselves — almost', 'wisebones-property-management' ),
		'text'      => __( 'We find great residents, keep homes in shape and send owners clear statements every month. Looking for a place to live? Start your search here.', 'wisebones-property-management' ),
		'primary'   => array( __( 'Get a management proposal', 'wisebones-property-management' ), '/owners/' ),
		'secondary' => array( __( 'Browse rentals', 'wisebones-property-management' ), '/rentals/' ),
		'badges'    => array( __( 'Online rent payments', 'wisebones-property-management' ), __( 'Maintenance requests anytime', 'wisebones-property-management' ) ),
		'panel'     => 'search',
		'search'    => array(
			'title'       => __( 'Find a rental', 'wisebones-property-management' ),
			'tabs'        => array( array( 'for-rent', __( 'For rent', 'wisebones-property-management' ) ) ),
			'placeholder' => __( 'City, neighborhood or ZIP', 'wisebones-property-management' ),
			'types'       => array(
				'house'          => __( 'House', 'wisebones-property-management' ),
				'apartment'      => __( 'Apartment', 'wisebones-property-management' ),
				'condo-townhome' => __( 'Condo / townhome', 'wisebones-property-management' ),
			),
			'prices'      => array(
				'1500' => '$1,500/mo',
				'2000' => '$2,000/mo',
				'2500' => '$2,500/mo',
				'3500' => '$3,500/mo',
			),
		),
	),

	'stats'         => array(
		array( __( 'Online', 'wisebones-property-management' ), __( 'Owner and resident portals', 'wisebones-property-management' ) ),
		array( __( '24/7', 'wisebones-property-management' ), __( 'Emergency maintenance line', 'wisebones-property-management' ) ),
		array( __( 'Monthly', 'wisebones-property-management' ), __( 'Owner statements', 'wisebones-property-management' ) ),
		array( __( 'Local', 'wisebones-property-management' ), __( 'Managers who know the area', 'wisebones-property-management' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'For owners', 'wisebones-property-management' ),
			'heading' => __( 'Everything it takes to run a rental', 'wisebones-property-management' ),
			'text'    => __( 'Choose full-service management or just the pieces you need.', 'wisebones-property-management' ),
			'items'   => array(
				array( 'bi-megaphone', __( 'Marketing & leasing', 'wisebones-property-management' ), __( 'Professional photos, listing syndication and showings to fill vacancies quickly.', 'wisebones-property-management' ) ),
				array( 'bi-person-check', __( 'Resident screening', 'wisebones-property-management' ), __( 'Consistent, fair-housing-compliant screening for credit, income and rental history.', 'wisebones-property-management' ) ),
				array( 'bi-cash-stack', __( 'Rent collection', 'wisebones-property-management' ), __( 'Online payments, late-fee enforcement and fast owner disbursements.', 'wisebones-property-management' ) ),
				array( 'bi-tools', __( 'Maintenance', 'wisebones-property-management' ), __( 'Vetted vendors, preventive care and a 24/7 line for emergencies.', 'wisebones-property-management' ) ),
				array( 'bi-clipboard-check', __( 'Inspections', 'wisebones-property-management' ), __( 'Move-in, periodic and move-out inspections with photo reports.', 'wisebones-property-management' ) ),
				array( 'bi-file-earmark-bar-graph', __( 'Accounting & reporting', 'wisebones-property-management' ), __( 'Monthly statements, year-end tax documents and an owner portal.', 'wisebones-property-management' ) ),
			),
		),
		'featured'     => array(
			'type'    => 'listing',
			'eyebrow' => __( 'Available now', 'wisebones-property-management' ),
			'heading' => __( 'Homes for rent', 'wisebones-property-management' ),
			'text'    => __( 'Well-kept homes and apartments, professionally managed.', 'wisebones-property-management' ),
			'samples' => array(
				array( 'title' => __( 'Sunny two-bedroom near the light rail', 'wisebones-property-management' ), 'status' => 'for-rent', 'price' => '1850', 'price_suffix' => '/mo', 'beds' => '2', 'baths' => '1', 'sqft' => '920', 'address' => '310 Grove St #2', 'city' => __( 'Midtown', 'wisebones-property-management' ), 'excerpt' => __( 'In-unit laundry, pets considered.', 'wisebones-property-management' ) ),
				array( 'title' => __( 'Three-bedroom house with fenced yard', 'wisebones-property-management' ), 'status' => 'for-rent', 'price' => '2450', 'price_suffix' => '/mo', 'beds' => '3', 'baths' => '2', 'sqft' => '1480', 'address' => '42 Birch Ln', 'city' => __( 'Eastside', 'wisebones-property-management' ), 'excerpt' => __( 'Attached garage and new appliances.', 'wisebones-property-management' ) ),
				array( 'title' => __( 'Modern townhome with rooftop deck', 'wisebones-property-management' ), 'status' => 'for-rent', 'price' => '2950', 'price_suffix' => '/mo', 'beds' => '3', 'baths' => '2.5', 'sqft' => '1720', 'address' => '19 Canal Row', 'city' => __( 'Waterfront', 'wisebones-property-management' ), 'excerpt' => __( 'Two-car garage, walk to shops and dining.', 'wisebones-property-management' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Why owners switch to us', 'wisebones-property-management' ),
			'heading'   => __( 'Protect your investment and your time', 'wisebones-property-management' ),
			'text'      => __( 'Good management shows up as fewer vacant days, fewer surprises and statements you can actually read.', 'wisebones-property-management' ),
			'points'    => array(
				array( __( 'Transparent pricing', 'wisebones-property-management' ), __( 'One management fee, with every other charge spelled out up front.', 'wisebones-property-management' ) ),
				array( __( 'Responsive maintenance', 'wisebones-property-management' ), __( 'Repairs handled quickly by vendors we hold accountable.', 'wisebones-property-management' ) ),
				array( __( 'Clear communication', 'wisebones-property-management' ), __( 'A dedicated manager and an owner portal with every document.', 'wisebones-property-management' ) ),
			),
			'button'    => array( __( 'Get a free rental analysis', 'wisebones-property-management' ), '/owners/' ),
			'highlight' => array(
				'icon'  => 'bi-house-check',
				'title' => __( 'Free rental analysis', 'wisebones-property-management' ),
				'text'  => __( 'Find out what your property should rent for and what management would look like.', 'wisebones-property-management' ),
				'tags'  => array( __( 'Single-family', 'wisebones-property-management' ), __( 'Condos', 'wisebones-property-management' ), __( 'Small multifamily', 'wisebones-property-management' ), __( 'HOAs', 'wisebones-property-management' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'Getting started', 'wisebones-property-management' ),
			'heading' => __( 'Switching managers is easier than you think', 'wisebones-property-management' ),
			'steps'   => array(
				array( __( 'Consultation', 'wisebones-property-management' ), __( 'We walk the property and review your goals.', 'wisebones-property-management' ) ),
				array( __( 'Proposal', 'wisebones-property-management' ), __( 'Rent estimate, services and fees in writing.', 'wisebones-property-management' ) ),
				array( __( 'Onboarding', 'wisebones-property-management' ), __( 'We transfer leases, deposits and residents smoothly.', 'wisebones-property-management' ) ),
				array( __( 'Ongoing care', 'wisebones-property-management' ), __( 'Monthly statements and a manager who answers the phone.', 'wisebones-property-management' ) ),
			),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Owner & resident stories', 'wisebones-property-management' ),
			'heading' => __( 'What people say about us', 'wisebones-property-management' ),
			'samples' => array(
				array( __( 'I finally stopped getting late-night calls about the water heater.', 'wisebones-property-management' ), __( 'Sample client', 'wisebones-property-management' ), __( 'Owner, two rentals', 'wisebones-property-management' ) ),
				array( __( 'Maintenance requests get answered the same day. Paying rent online is easy.', 'wisebones-property-management' ), __( 'Sample client', 'wisebones-property-management' ), __( 'Resident', 'wisebones-property-management' ) ),
				array( __( 'The monthly statements are clear and my tax documents arrive on time.', 'wisebones-property-management' ), __( 'Sample client', 'wisebones-property-management' ), __( 'Out-of-state owner', 'wisebones-property-management' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Service areas', 'wisebones-property-management' ),
			'heading' => __( 'Where we manage', 'wisebones-property-management' ),
			'text'    => __( 'Local managers and maintenance teams in every area we serve.', 'wisebones-property-management' ),
			'items'   => array( __( 'Midtown', 'wisebones-property-management' ), __( 'Eastside', 'wisebones-property-management' ), __( 'Waterfront', 'wisebones-property-management' ), __( 'University District', 'wisebones-property-management' ), __( 'Northgate', 'wisebones-property-management' ), __( 'Southpark', 'wisebones-property-management' ) ),
			'button'  => array( __( 'Talk to a manager', 'wisebones-property-management' ), '/contact/' ),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-property-management' ),
			'heading' => __( 'Owners and residents ask', 'wisebones-property-management' ),
			'items'   => array(
				array( __( 'What does management cost?', 'wisebones-property-management' ), __( 'Add your fee structure here — for example a percentage of collected rent plus a leasing fee — and list anything not included.', 'wisebones-property-management' ) ),
				array( __( 'How do you screen applicants?', 'wisebones-property-management' ), __( 'Every applicant is held to the same written criteria for income, credit and rental history, in line with fair housing law.', 'wisebones-property-management' ) ),
				array( __( 'How do I pay rent or request maintenance?', 'wisebones-property-management' ), __( 'Residents use the online portal for both, any time. Emergencies go to the 24/7 line.', 'wisebones-property-management' ) ),
				array( __( 'Can I switch from my current manager?', 'wisebones-property-management' ), __( 'Yes. We handle the transfer of leases, deposits and records and introduce ourselves to your residents.', 'wisebones-property-management' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Own a rental? Let\'s talk.', 'wisebones-property-management' ),
			'text'    => __( 'Request a free rental analysis and a management proposal for your property.', 'wisebones-property-management' ),
			'form'    => true,
			'button'  => array( __( 'Get a proposal', 'wisebones-property-management' ), '/owners/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'featured', 'values', 'process', 'testimonials', 'areas', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'Full-service residential property management for owners and the residents who call their homes home.', 'wisebones-property-management' ),
		'note'    => __( 'Equal Housing Opportunity. Add your brokerage or management license details here.', 'wisebones-property-management' ),
		'columns' => array(
			__( 'Owners', 'wisebones-property-management' )    => array(
				array( __( 'Management services', 'wisebones-property-management' ), '/owners/' ),
				array( __( 'Rental analysis', 'wisebones-property-management' ), '/owners/' ),
			),
			__( 'Residents', 'wisebones-property-management' ) => array(
				array( __( 'Available rentals', 'wisebones-property-management' ), '/rentals/' ),
				array( __( 'Resident center', 'wisebones-property-management' ), '/residents/' ),
			),
			__( 'Company', 'wisebones-property-management' )   => array(
				array( __( 'About', 'wisebones-property-management' ), '/about/' ),
				array( __( 'Blog', 'wisebones-property-management' ), '/blog/' ),
				array( __( 'Contact', 'wisebones-property-management' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'      => array( 'title' => __( 'Home', 'wisebones-property-management' ) ),
			'owners'    => array(
				'title'   => __( 'For Owners', 'wisebones-property-management' ),
				'content' => $wbpm_p( __( 'Full-service management for single-family homes, condos and small multifamily properties. Tell us about your property for a free rental analysis and proposal.', 'wisebones-property-management' ) )
					. $wbpm_code( '[wbik_services count="9"]' )
					. $wbpm_h( __( 'Request a management proposal', 'wisebones-property-management' ) )
					. $wbpm_code( '[wbik_lead_form type="owner" title=""]' ),
			),
			'residents' => array(
				'title'   => __( 'Resident Center', 'wisebones-property-management' ),
				'content' => $wbpm_p( __( 'Everything you need as a resident. Replace these links with your portal addresses.', 'wisebones-property-management' ) )
					. $wbpm_list( array( __( 'Pay rent online', 'wisebones-property-management' ), __( 'Submit a maintenance request', 'wisebones-property-management' ), __( 'Renters insurance', 'wisebones-property-management' ), __( 'Move-out checklist', 'wisebones-property-management' ) ) )
					. $wbpm_p( __( 'For emergencies such as flooding, no heat or a gas smell, call the 24/7 maintenance line.', 'wisebones-property-management' ) ),
			),
			'about'     => array(
				'title'   => __( 'About Us', 'wisebones-property-management' ),
				'content' => $wbpm_p( __( 'Tell your story here: how long you have managed in the area, the property types you specialize in and your licensing.', 'wisebones-property-management' ) ) . $wbpm_h( __( 'Our team', 'wisebones-property-management' ) ) . $wbpm_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'   => array(
				'title'   => __( 'Contact', 'wisebones-property-management' ),
				'content' => $wbpm_p( __( 'Questions about a rental or our services? Send a note and we will reply within one business day.', 'wisebones-property-management' ) ) . $wbpm_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'blog'      => array( 'title' => __( 'Blog', 'wisebones-property-management' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-property-management' ), '/' ),
			array( __( 'Rentals', 'wisebones-property-management' ), 'archive:listing' ),
			array( __( 'Owners', 'wisebones-property-management' ), 'page:owners' ),
			array( __( 'Residents', 'wisebones-property-management' ), 'page:residents' ),
			array( __( 'About', 'wisebones-property-management' ), 'page:about' ),
			array( __( 'Blog', 'wisebones-property-management' ), 'page:blog' ),
			array( __( 'Contact', 'wisebones-property-management' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_listing_type' => array( __( 'House', 'wisebones-property-management' ), __( 'Apartment', 'wisebones-property-management' ), __( 'Condo / townhome', 'wisebones-property-management' ) ),
		),
	),
);
