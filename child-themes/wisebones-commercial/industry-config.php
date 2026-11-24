<?php
/**
 * WiseBones Commercial — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Copy is a starting point: the hero, stats and closing call
 * to action are editable in the Customizer; properties, team and testimonials
 * come from the kit's screens. See child-themes/README.md.
 *
 * @package WiseBones_Commercial
 */

defined( 'ABSPATH' ) || exit;

$wbc_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbc_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbc_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'commercial',
	'family'        => 'real-estate',
	'label'         => __( 'Commercial Real Estate', 'wisebones-commercial' ),
	'schema'        => 'RealEstateAgent',
	'content_types' => array( 'listing', 'team', 'testimonial', 'service' ),
	'labels'        => array(
		'listing' => array( __( 'Properties', 'wisebones-commercial' ), __( 'Property', 'wisebones-commercial' ) ),
	),
	'lead_type'     => 'contact',
	'colors'        => array(
		'primary'   => '#0b3954',
		'secondary' => '#56677a',
		'accent'    => '#1fa79a',
		'header_bg' => '#071f30',
		'footer_bg' => '#051624',
	),
	'header_style'  => 'dark',
	'header_cta'    => array( __( 'Talk to a broker', 'wisebones-commercial' ), '/contact/', 'bi-briefcase' ),

	'hero'          => array(
		'style'     => 'blueprint',
		'eyebrow'   => __( 'Commercial real estate advisory', 'wisebones-commercial' ),
		'heading'   => __( 'Space and capital, matched to your strategy', 'wisebones-commercial' ),
		'text'      => __( 'Leasing, sales and investment advisory for office, industrial, retail and multifamily — from owners and occupiers who want straight answers.', 'wisebones-commercial' ),
		'primary'   => array( __( 'View properties', 'wisebones-commercial' ), '/properties/' ),
		'secondary' => array( __( 'List with us', 'wisebones-commercial' ), '/owners/' ),
		'badges'    => array( __( 'Tenant & landlord representation', 'wisebones-commercial' ), __( 'Investment sales', 'wisebones-commercial' ) ),
		'panel'     => 'card',
		'card'      => array(
			'kicker' => __( 'Capabilities', 'wisebones-commercial' ),
			'title'  => __( 'One team, every side of the deal', 'wisebones-commercial' ),
			'rows'   => array(
				array( __( 'Sales', 'wisebones-commercial' ), __( 'Dispositions & acquisitions', 'wisebones-commercial' ), 'bi-cash-coin' ),
				array( __( 'Leasing', 'wisebones-commercial' ), __( 'Tenant & landlord rep', 'wisebones-commercial' ), 'bi-key' ),
				array( __( 'Investment', 'wisebones-commercial' ), __( 'Underwriting & valuation', 'wisebones-commercial' ), 'bi-graph-up' ),
				array( __( 'Property types', 'wisebones-commercial' ), __( 'Office · Industrial · Retail · Multifamily', 'wisebones-commercial' ), 'bi-buildings' ),
			),
			'button' => array( __( 'Request a consultation', 'wisebones-commercial' ), '/contact/' ),
		),
	),

	'stats'         => array(
		array( __( 'Office', 'wisebones-commercial' ), __( 'Leasing and sales', 'wisebones-commercial' ) ),
		array( __( 'Industrial', 'wisebones-commercial' ), __( 'Warehouse and flex', 'wisebones-commercial' ) ),
		array( __( 'Retail', 'wisebones-commercial' ), __( 'Pads, centers and storefronts', 'wisebones-commercial' ) ),
		array( __( 'Multifamily', 'wisebones-commercial' ), __( 'Investment sales', 'wisebones-commercial' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'Services', 'wisebones-commercial' ),
			'heading' => __( 'Advisory for owners, occupiers and investors', 'wisebones-commercial' ),
			'text'    => __( 'Local market knowledge backed by disciplined underwriting.', 'wisebones-commercial' ),
			'items'   => array(
				array( 'bi-person-badge', __( 'Tenant representation', 'wisebones-commercial' ), __( 'Site selection, lease negotiation and renewals that protect your occupancy costs.', 'wisebones-commercial' ) ),
				array( 'bi-building', __( 'Landlord leasing', 'wisebones-commercial' ), __( 'Marketing plans, tenant outreach and deal structuring to fill space with the right tenants.', 'wisebones-commercial' ) ),
				array( 'bi-cash-coin', __( 'Investment sales', 'wisebones-commercial' ), __( 'Offering memoranda, buyer targeting and a competitive process to maximize value.', 'wisebones-commercial' ) ),
				array( 'bi-search', __( 'Acquisitions', 'wisebones-commercial' ), __( 'On- and off-market sourcing with underwriting you can take to your lender.', 'wisebones-commercial' ) ),
				array( 'bi-clipboard-data', __( 'Valuation & advisory', 'wisebones-commercial' ), __( 'Broker opinions of value, hold/sell analysis and portfolio strategy.', 'wisebones-commercial' ) ),
				array( 'bi-arrow-repeat', __( 'Sale-leasebacks & 1031s', 'wisebones-commercial' ), __( 'Unlock equity in owner-occupied real estate or defer gains on your next purchase.', 'wisebones-commercial' ) ),
			),
		),
		'featured'     => array(
			'type'    => 'listing',
			'eyebrow' => __( 'Available properties', 'wisebones-commercial' ),
			'heading' => __( 'Space for lease and for sale', 'wisebones-commercial' ),
			'text'    => __( 'A selection of current assignments. Contact us for full offering materials.', 'wisebones-commercial' ),
			'samples' => array(
				array( 'title' => __( 'Class A office suite with skyline views', 'wisebones-commercial' ), 'status' => 'for-lease', 'price' => '32', 'price_suffix' => '/sf/yr', 'sqft' => '8400', 'address' => '400 Commerce St, Floor 12', 'city' => __( 'Downtown', 'wisebones-commercial' ), 'excerpt' => __( 'Move-in ready, with on-site parking and fitness center.', 'wisebones-commercial' ) ),
				array( 'title' => __( 'Distribution building near the interstate', 'wisebones-commercial' ), 'status' => 'for-lease', 'price' => '9', 'price_suffix' => '/sf/yr', 'sqft' => '62000', 'address' => '1200 Logistics Pkwy', 'city' => __( 'Airport district', 'wisebones-commercial' ), 'excerpt' => __( '32-foot clear height, dock-high doors and a fenced truck court.', 'wisebones-commercial' ) ),
				array( 'title' => __( 'Garden-style apartment community', 'wisebones-commercial' ), 'status' => 'for-sale', 'price' => '14500000', 'units' => '96', 'address' => '55 Willow Bend Dr', 'city' => __( 'Northside', 'wisebones-commercial' ), 'excerpt' => __( 'Value-add opportunity with below-market rents.', 'wisebones-commercial' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'For property owners', 'wisebones-commercial' ),
			'heading'   => __( 'Know where your asset stands', 'wisebones-commercial' ),
			'text'      => __( 'Whether you are planning a sale, a refinance or a lease-up, start with an honest read of the market and your options.', 'wisebones-commercial' ),
			'points'    => array(
				array( __( 'Broker opinion of value', 'wisebones-commercial' ), __( 'Built from current comps, rent rolls and cap-rate trends.', 'wisebones-commercial' ) ),
				array( __( 'Hold / sell analysis', 'wisebones-commercial' ), __( 'Side-by-side returns so the decision is yours, with numbers behind it.', 'wisebones-commercial' ) ),
				array( __( 'Confidential', 'wisebones-commercial' ), __( 'Your information stays between you and your broker.', 'wisebones-commercial' ) ),
			),
			'button'    => array( __( 'Request a valuation', 'wisebones-commercial' ), '/owners/' ),
			'highlight' => array(
				'icon'  => 'bi-bar-chart-line',
				'title' => __( 'Market reports', 'wisebones-commercial' ),
				'text'  => __( 'Vacancy, absorption and rent trends for the submarkets we cover, published regularly.', 'wisebones-commercial' ),
				'tags'  => array( __( 'Vacancy', 'wisebones-commercial' ), __( 'Absorption', 'wisebones-commercial' ), __( 'Asking rents', 'wisebones-commercial' ), __( 'Cap rates', 'wisebones-commercial' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How we work', 'wisebones-commercial' ),
			'heading' => __( 'A clear process from brief to close', 'wisebones-commercial' ),
			'steps'   => array(
				array( __( 'Brief', 'wisebones-commercial' ), __( 'We learn your goals, timeline and constraints.', 'wisebones-commercial' ) ),
				array( __( 'Analysis', 'wisebones-commercial' ), __( 'Market survey, financial modeling and a recommended strategy.', 'wisebones-commercial' ) ),
				array( __( 'Execution', 'wisebones-commercial' ), __( 'Marketing, tours, negotiation and letters of intent.', 'wisebones-commercial' ) ),
				array( __( 'Close', 'wisebones-commercial' ), __( 'We coordinate diligence, documents and closing with your team.', 'wisebones-commercial' ) ),
			),
		),
		'team'         => array(
			'eyebrow' => __( 'Our brokers', 'wisebones-commercial' ),
			'heading' => __( 'Specialists by property type', 'wisebones-commercial' ),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Client perspectives', 'wisebones-commercial' ),
			'heading' => __( 'Trusted by owners and occupiers', 'wisebones-commercial' ),
			'samples' => array(
				array( __( 'They ran a disciplined process and delivered multiple qualified offers.', 'wisebones-commercial' ), __( 'Sample client', 'wisebones-commercial' ), __( 'Property owner', 'wisebones-commercial' ) ),
				array( __( 'Our renewal came in well under what we expected to pay.', 'wisebones-commercial' ), __( 'Sample client', 'wisebones-commercial' ), __( 'Office tenant', 'wisebones-commercial' ) ),
				array( __( 'The underwriting held up through our lender\'s review without changes.', 'wisebones-commercial' ), __( 'Sample client', 'wisebones-commercial' ), __( 'Investor', 'wisebones-commercial' ) ),
			),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-commercial' ),
			'heading' => __( 'Common questions', 'wisebones-commercial' ),
			'items'   => array(
				array( __( 'Who pays the broker in a lease?', 'wisebones-commercial' ), __( 'In most markets the landlord pays leasing commissions, so tenant representation typically costs the tenant nothing directly. We confirm the arrangement in writing up front.', 'wisebones-commercial' ) ),
				array( __( 'What does a broker opinion of value include?', 'wisebones-commercial' ), __( 'Comparable sales and leases, an income approach where relevant, and a recommended pricing range with the reasoning behind it.', 'wisebones-commercial' ) ),
				array( __( 'Do you handle off-market deals?', 'wisebones-commercial' ), __( 'Yes. Many owners prefer a quiet process; we can approach a targeted list of qualified buyers under confidentiality.', 'wisebones-commercial' ) ),
				array( __( 'Which areas do you cover?', 'wisebones-commercial' ), __( 'Add your markets and submarkets here.', 'wisebones-commercial' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Have a property or a requirement?', 'wisebones-commercial' ),
			'text'    => __( 'Tell us what you need and a broker will follow up within one business day.', 'wisebones-commercial' ),
			'form'    => true,
			'button'  => array( __( 'Contact a broker', 'wisebones-commercial' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'featured', 'values', 'process', 'team', 'testimonials', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'Commercial real estate advisory for owners, occupiers and investors.', 'wisebones-commercial' ),
		'note'    => __( 'Information is deemed reliable but not guaranteed. Add your brokerage license details here.', 'wisebones-commercial' ),
		'columns' => array(
			__( 'Properties', 'wisebones-commercial' ) => array(
				array( __( 'All properties', 'wisebones-commercial' ), '/properties/' ),
				array( __( 'For tenants', 'wisebones-commercial' ), '/tenants/' ),
				array( __( 'For owners', 'wisebones-commercial' ), '/owners/' ),
			),
			__( 'Advisory', 'wisebones-commercial' )   => array(
				array( __( 'Services', 'wisebones-commercial' ), '/services/' ),
				array( __( 'Market insights', 'wisebones-commercial' ), '/insights/' ),
			),
			__( 'Company', 'wisebones-commercial' )    => array(
				array( __( 'About', 'wisebones-commercial' ), '/about/' ),
				array( __( 'Brokers', 'wisebones-commercial' ), '/team/' ),
				array( __( 'Contact', 'wisebones-commercial' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'insights',
		'pages' => array(
			'home'     => array( 'title' => __( 'Home', 'wisebones-commercial' ) ),
			'services' => array(
				'title'   => __( 'Services', 'wisebones-commercial' ),
				'content' => $wbc_p( __( 'Leasing, sales, acquisitions and advisory across office, industrial, retail and multifamily.', 'wisebones-commercial' ) ) . $wbc_code( '[wbik_services count="9"]' ),
			),
			'tenants'  => array(
				'title'   => __( 'For Tenants', 'wisebones-commercial' ),
				'content' => $wbc_p( __( 'From a first office to a regional distribution hub, we help occupiers find the right space and negotiate terms that fit the business.', 'wisebones-commercial' ) )
					. $wbc_h( __( 'Space for lease', 'wisebones-commercial' ) )
					. $wbc_code( '[wbik_listings status="for-lease" count="6"]' )
					. $wbc_h( __( 'Tell us about your requirement', 'wisebones-commercial' ) )
					. $wbc_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'owners'   => array(
				'title'   => __( 'For Owners', 'wisebones-commercial' ),
				'content' => $wbc_p( __( 'Planning a sale, a lease-up or a refinance? Request a confidential broker opinion of value and a recommended strategy.', 'wisebones-commercial' ) )
					. $wbc_code( '[wbik_lead_form type="contact" title=""]' )
					. $wbc_h( __( 'Properties for sale', 'wisebones-commercial' ) )
					. $wbc_code( '[wbik_listings status="for-sale" count="3"]' ),
			),
			'about'    => array(
				'title'   => __( 'About Us', 'wisebones-commercial' ),
				'content' => $wbc_p( __( 'Tell your firm\'s story here: the markets you cover, your specialties and the designations your brokers hold.', 'wisebones-commercial' ) ) . $wbc_h( __( 'Our brokers', 'wisebones-commercial' ) ) . $wbc_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'  => array(
				'title'   => __( 'Contact', 'wisebones-commercial' ),
				'content' => $wbc_p( __( 'Questions about a property or a requirement? Send a note and a broker will reply within one business day.', 'wisebones-commercial' ) ) . $wbc_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'insights' => array( 'title' => __( 'Market Insights', 'wisebones-commercial' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-commercial' ), '/' ),
			array( __( 'Properties', 'wisebones-commercial' ), 'archive:listing' ),
			array( __( 'Services', 'wisebones-commercial' ), 'page:services' ),
			array( __( 'Tenants', 'wisebones-commercial' ), 'page:tenants' ),
			array( __( 'Owners', 'wisebones-commercial' ), 'page:owners' ),
			array( __( 'About', 'wisebones-commercial' ), 'page:about' ),
			array( __( 'Insights', 'wisebones-commercial' ), 'page:insights' ),
			array( __( 'Contact', 'wisebones-commercial' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_listing_type' => array( __( 'Office', 'wisebones-commercial' ), __( 'Industrial', 'wisebones-commercial' ), __( 'Retail', 'wisebones-commercial' ), __( 'Multifamily', 'wisebones-commercial' ), __( 'Land', 'wisebones-commercial' ) ),
		),
	),
);
