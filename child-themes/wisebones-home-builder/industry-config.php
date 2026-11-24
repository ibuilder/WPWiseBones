<?php
/**
 * WiseBones Home Builder — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Listings are relabelled Homes (move-in ready and floor plans)
 * and projects are relabelled Communities. See child-themes/README.md.
 *
 * @package WiseBones_Home_Builder
 */

defined( 'ABSPATH' ) || exit;

$wbhb_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbhb_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbhb_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'home-builder',
	'family'        => 'real-estate',
	'label'         => __( 'Home Builder', 'wisebones-home-builder' ),
	'schema'        => 'HomeAndConstructionBusiness',
	'content_types' => array( 'listing', 'project', 'service', 'testimonial', 'team' ),
	'labels'        => array(
		'listing' => array( __( 'Homes', 'wisebones-home-builder' ), __( 'Home', 'wisebones-home-builder' ) ),
		'project' => array( __( 'Communities', 'wisebones-home-builder' ), __( 'Community', 'wisebones-home-builder' ) ),
	),
	'lead_type'     => 'showing',
	'colors'        => array(
		'primary'   => '#b3542d',
		'secondary' => '#6b5e56',
		'accent'    => '#6f8f6a',
		'header_bg' => '#ffffff',
		'footer_bg' => '#231a15',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Schedule a tour', 'wisebones-home-builder' ), '/contact/', 'bi-calendar-check' ),

	'hero'          => array(
		'style'     => 'gradient',
		'eyebrow'   => __( 'New homes · Now selling', 'wisebones-home-builder' ),
		'heading'   => __( 'New homes, built around how you live', 'wisebones-home-builder' ),
		'text'      => __( 'Move-in-ready homes and floor plans you can make your own, in communities designed for the way families actually live.', 'wisebones-home-builder' ),
		'primary'   => array( __( 'Browse homes', 'wisebones-home-builder' ), '/homes/' ),
		'secondary' => array( __( 'Explore communities', 'wisebones-home-builder' ), '/communities/' ),
		'badges'    => array( __( 'Structural warranty', 'wisebones-home-builder' ), __( 'Personal design studio session', 'wisebones-home-builder' ) ),
		'panel'     => 'search',
		'search'    => array(
			'title'       => __( 'Find your new home', 'wisebones-home-builder' ),
			'placeholder' => __( 'Community, city or ZIP', 'wisebones-home-builder' ),
			'tabs'        => array( array( 'move-in', __( 'Move-in ready', 'wisebones-home-builder' ) ), array( 'plan', __( 'Floor plans', 'wisebones-home-builder' ) ) ),
			'types'       => array(
				'single-story' => __( 'Single-story', 'wisebones-home-builder' ),
				'two-story'    => __( 'Two-story', 'wisebones-home-builder' ),
				'townhome'     => __( 'Townhome', 'wisebones-home-builder' ),
				'estate'       => __( 'Estate home', 'wisebones-home-builder' ),
			),
			'prices'      => array(
				'400000'  => '$400k',
				'500000'  => '$500k',
				'650000'  => '$650k',
				'800000'  => '$800k',
				'1000000' => '$1M',
			),
		),
	),

	'stats'         => array(
		array( __( 'Move-in', 'wisebones-home-builder' ), __( 'Ready homes available', 'wisebones-home-builder' ) ),
		array( __( 'Design', 'wisebones-home-builder' ), __( 'Studio included with every plan', 'wisebones-home-builder' ) ),
		array( __( 'Warranty', 'wisebones-home-builder' ), __( 'Backed by our builder warranty', 'wisebones-home-builder' ) ),
		array( __( 'Tours', 'wisebones-home-builder' ), __( 'Models open seven days', 'wisebones-home-builder' ) ),
	),

	'sections'      => array(
		'featured'     => array(
			'type'    => 'listing',
			'eyebrow' => __( 'Available homes', 'wisebones-home-builder' ),
			'heading' => __( 'Move-in ready and ready to build', 'wisebones-home-builder' ),
			'text'    => __( 'Quick move-in homes you can close on this season, and floor plans you can personalize from the ground up.', 'wisebones-home-builder' ),
			'samples' => array(
				array( 'title' => __( 'The Aspen — quick move-in', 'wisebones-home-builder' ), 'status' => 'move-in', 'price' => '529900', 'beds' => '4', 'baths' => '3', 'sqft' => '2410', 'address' => __( 'Lot 14', 'wisebones-home-builder' ), 'city' => __( 'Willow Creek', 'wisebones-home-builder' ), 'excerpt' => __( 'Open great room, covered patio and a three-car garage.', 'wisebones-home-builder' ) ),
				array( 'title' => __( 'The Juniper plan', 'wisebones-home-builder' ), 'status' => 'plan', 'price' => '459900', 'price_suffix' => __( ' from', 'wisebones-home-builder' ), 'beds' => '3', 'baths' => '2', 'sqft' => '1890', 'address' => __( 'Single-story plan', 'wisebones-home-builder' ), 'city' => __( 'Stonebridge', 'wisebones-home-builder' ), 'excerpt' => __( 'Single-level living with a flex room and walk-in pantry.', 'wisebones-home-builder' ) ),
				array( 'title' => __( 'The Sequoia plan', 'wisebones-home-builder' ), 'status' => 'plan', 'price' => '689900', 'price_suffix' => __( ' from', 'wisebones-home-builder' ), 'beds' => '5', 'baths' => '4', 'sqft' => '3320', 'address' => __( 'Two-story plan', 'wisebones-home-builder' ), 'city' => __( 'Ridge Pointe', 'wisebones-home-builder' ), 'excerpt' => __( 'Main-floor guest suite, loft and optional outdoor kitchen.', 'wisebones-home-builder' ) ),
			),
		),
		'services'     => array(
			'eyebrow' => __( 'Why build with us', 'wisebones-home-builder' ),
			'heading' => __( 'A better way to buy a new home', 'wisebones-home-builder' ),
			'text'    => __( 'From the first sketch to the final walkthrough, one team stays with you.', 'wisebones-home-builder' ),
			'items'   => array(
				array( 'bi-palette', __( 'Design studio', 'wisebones-home-builder' ), __( 'Choose finishes, fixtures and flooring with a dedicated design consultant.', 'wisebones-home-builder' ) ),
				array( 'bi-geo-alt', __( 'Build on your lot', 'wisebones-home-builder' ), __( 'Already own land? We will build one of our plans on it.', 'wisebones-home-builder' ) ),
				array( 'bi-shield-check', __( 'Builder warranty', 'wisebones-home-builder' ), __( 'Coverage for workmanship, systems and structure, with a responsive service team.', 'wisebones-home-builder' ) ),
				array( 'bi-lightning-charge', __( 'Energy efficiency', 'wisebones-home-builder' ), __( 'High-performance insulation, windows and HVAC to keep monthly bills down.', 'wisebones-home-builder' ) ),
				array( 'bi-house-gear', __( 'Smart-home ready', 'wisebones-home-builder' ), __( 'Pre-wired for connected thermostats, locks, lighting and security.', 'wisebones-home-builder' ) ),
				array( 'bi-cash-coin', __( 'Financing help', 'wisebones-home-builder' ), __( 'Work with a preferred lender on rate options and closing-cost incentives.', 'wisebones-home-builder' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Make it yours', 'wisebones-home-builder' ),
			'heading'   => __( 'Personalize every room before it is built', 'wisebones-home-builder' ),
			'text'      => __( 'Building new means you never pay to rip out someone else\'s choices. Pick your layout options and finishes, then watch it come together.', 'wisebones-home-builder' ),
			'points'    => array(
				array( __( 'Structural options', 'wisebones-home-builder' ), __( 'Add a bedroom, extend the patio or open up the kitchen.', 'wisebones-home-builder' ) ),
				array( __( 'Curated finish packages', 'wisebones-home-builder' ), __( 'Designer-coordinated selections at every price point.', 'wisebones-home-builder' ) ),
				array( __( 'Clear pricing', 'wisebones-home-builder' ), __( 'See the cost of every option before you commit.', 'wisebones-home-builder' ) ),
			),
			'button'    => array( __( 'Visit the design studio', 'wisebones-home-builder' ), '/design-studio/' ),
			'highlight' => array(
				'icon'  => 'bi-palette2',
				'title' => __( 'Your design studio session', 'wisebones-home-builder' ),
				'text'  => __( 'A one-on-one appointment with a design consultant, included with every new home.', 'wisebones-home-builder' ),
				'tags'  => array( __( 'Cabinets', 'wisebones-home-builder' ), __( 'Countertops', 'wisebones-home-builder' ), __( 'Flooring', 'wisebones-home-builder' ), __( 'Lighting', 'wisebones-home-builder' ), __( 'Exterior colors', 'wisebones-home-builder' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How it works', 'wisebones-home-builder' ),
			'heading' => __( 'From homesite to housewarming', 'wisebones-home-builder' ),
			'steps'   => array(
				array( __( 'Choose', 'wisebones-home-builder' ), __( 'Pick a community, homesite and floor plan — or a home that is ready now.', 'wisebones-home-builder' ) ),
				array( __( 'Design', 'wisebones-home-builder' ), __( 'Select your options and finishes in the design studio.', 'wisebones-home-builder' ) ),
				array( __( 'Build', 'wisebones-home-builder' ), __( 'Follow progress with scheduled walkthroughs at key milestones.', 'wisebones-home-builder' ) ),
				array( __( 'Move in', 'wisebones-home-builder' ), __( 'Final orientation, keys in hand, and warranty service from day one.', 'wisebones-home-builder' ) ),
			),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Homeowner stories', 'wisebones-home-builder' ),
			'heading' => __( 'What our homeowners say', 'wisebones-home-builder' ),
			'samples' => array(
				array( __( 'The design studio made choosing finishes fun instead of overwhelming.', 'wisebones-home-builder' ), __( 'Sample client', 'wisebones-home-builder' ), __( 'Homeowner', 'wisebones-home-builder' ) ),
				array( __( 'Every milestone walkthrough happened on schedule. No surprises at closing.', 'wisebones-home-builder' ), __( 'Sample client', 'wisebones-home-builder' ), __( 'Homeowner', 'wisebones-home-builder' ) ),
				array( __( 'A small warranty item was fixed within the week. That is rare.', 'wisebones-home-builder' ), __( 'Sample client', 'wisebones-home-builder' ), __( 'Homeowner', 'wisebones-home-builder' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Communities', 'wisebones-home-builder' ),
			'heading' => __( 'Where we are building', 'wisebones-home-builder' ),
			'text'    => __( 'Amenities, schools and available homesites for each community.', 'wisebones-home-builder' ),
			'items'   => array( __( 'Willow Creek', 'wisebones-home-builder' ), __( 'Stonebridge', 'wisebones-home-builder' ), __( 'Ridge Pointe', 'wisebones-home-builder' ), __( 'Cedar Hollow', 'wisebones-home-builder' ), __( 'Lakeshore Village', 'wisebones-home-builder' ), __( 'Prairie Run', 'wisebones-home-builder' ) ),
			'button'  => array( __( 'See all communities', 'wisebones-home-builder' ), '/communities/' ),
		),
		'faq'          => array(
			'eyebrow' => __( 'Questions', 'wisebones-home-builder' ),
			'heading' => __( 'Buying new, answered', 'wisebones-home-builder' ),
			'items'   => array(
				array( __( 'How long does it take to build a home?', 'wisebones-home-builder' ), __( 'Most homes take five to eight months from start of construction, depending on plan and options. Quick move-in homes can close in weeks.', 'wisebones-home-builder' ) ),
				array( __( 'Can I use my own real estate agent?', 'wisebones-home-builder' ), __( 'Yes. Bring your agent to your first visit and we will work with them throughout.', 'wisebones-home-builder' ) ),
				array( __( 'What does the warranty cover?', 'wisebones-home-builder' ), __( 'Workmanship, major systems and structure, each for a defined term. Ask for the warranty guide for full details.', 'wisebones-home-builder' ) ),
				array( __( 'Can you build on land I already own?', 'wisebones-home-builder' ), __( 'In many areas, yes. Our build-on-your-lot team will review the site, utilities and local requirements.', 'wisebones-home-builder' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Come see it in person', 'wisebones-home-builder' ),
			'text'    => __( 'Schedule a model home tour and a new-home specialist will meet you there.', 'wisebones-home-builder' ),
			'form'    => true,
			'button'  => array( __( 'Schedule a tour', 'wisebones-home-builder' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'featured', 'services', 'values', 'process', 'testimonials', 'areas', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'A local home builder creating thoughtfully designed homes and communities.', 'wisebones-home-builder' ),
		'note'    => __( 'Prices, plans and features are subject to change without notice. Square footage is approximate.', 'wisebones-home-builder' ),
		'columns' => array(
			__( 'Homes', 'wisebones-home-builder' )   => array(
				array( __( 'Available homes', 'wisebones-home-builder' ), '/homes/' ),
				array( __( 'Communities', 'wisebones-home-builder' ), '/communities/' ),
				array( __( 'Build on your lot', 'wisebones-home-builder' ), '/build-on-your-lot/' ),
			),
			__( 'Owners', 'wisebones-home-builder' )  => array(
				array( __( 'Design studio', 'wisebones-home-builder' ), '/design-studio/' ),
				array( __( 'Warranty', 'wisebones-home-builder' ), '/warranty/' ),
			),
			__( 'Company', 'wisebones-home-builder' ) => array(
				array( __( 'About', 'wisebones-home-builder' ), '/about/' ),
				array( __( 'Blog', 'wisebones-home-builder' ), '/blog/' ),
				array( __( 'Contact', 'wisebones-home-builder' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'              => array( 'title' => __( 'Home', 'wisebones-home-builder' ) ),
			'build-on-your-lot' => array(
				'title'   => __( 'Build on Your Lot', 'wisebones-home-builder' ),
				'content' => $wbhb_p( __( 'Own land already? Choose one of our floor plans and we will handle site review, permits and construction.', 'wisebones-home-builder' ) )
					. $wbhb_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'design-studio'     => array(
				'title'   => __( 'Design Studio', 'wisebones-home-builder' ),
				'content' => $wbhb_p( __( 'Describe your design studio: the appointment, the finish packages and how option pricing works.', 'wisebones-home-builder' ) ),
			),
			'warranty'          => array(
				'title'   => __( 'Warranty', 'wisebones-home-builder' ),
				'content' => $wbhb_p( __( 'Summarize your warranty coverage and explain how homeowners request service.', 'wisebones-home-builder' ) )
					. $wbhb_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'about'             => array(
				'title'   => __( 'About Us', 'wisebones-home-builder' ),
				'content' => $wbhb_p( __( 'Tell your story: how long you have been building, where, and what goes into every home.', 'wisebones-home-builder' ) ) . $wbhb_h( __( 'Our team', 'wisebones-home-builder' ) ) . $wbhb_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'           => array(
				'title'   => __( 'Contact', 'wisebones-home-builder' ),
				'content' => $wbhb_p( __( 'Schedule a model home tour or ask a new-home specialist a question.', 'wisebones-home-builder' ) ) . $wbhb_code( '[wbik_lead_form type="showing" title=""]' ),
			),
			'blog'              => array( 'title' => __( 'Blog', 'wisebones-home-builder' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-home-builder' ), '/' ),
			array( __( 'Homes', 'wisebones-home-builder' ), 'archive:listing' ),
			array( __( 'Communities', 'wisebones-home-builder' ), 'archive:project' ),
			array( __( 'Design Studio', 'wisebones-home-builder' ), 'page:design-studio' ),
			array( __( 'Build on Your Lot', 'wisebones-home-builder' ), 'page:build-on-your-lot' ),
			array( __( 'Warranty', 'wisebones-home-builder' ), 'page:warranty' ),
			array( __( 'About', 'wisebones-home-builder' ), 'page:about' ),
			array( __( 'Contact', 'wisebones-home-builder' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_listing_type' => array( __( 'Single-story', 'wisebones-home-builder' ), __( 'Two-story', 'wisebones-home-builder' ), __( 'Townhome', 'wisebones-home-builder' ), __( 'Estate home', 'wisebones-home-builder' ) ),
		),
	),
);
