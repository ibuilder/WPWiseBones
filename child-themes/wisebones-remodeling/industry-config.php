<?php
/**
 * WiseBones Remodeling — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Projects are relabelled "Our work". See child-themes/README.md.
 *
 * @package WiseBones_Remodeling
 */

defined( 'ABSPATH' ) || exit;

$wbrm_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbrm_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbrm_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'remodeling',
	'family'        => 'construction',
	'label'         => __( 'Remodeling & Design-Build', 'wisebones-remodeling' ),
	'schema'        => 'HomeAndConstructionBusiness',
	'content_types' => array( 'project', 'service', 'testimonial', 'team' ),
	'labels'        => array(
		'project' => array( __( 'Our work', 'wisebones-remodeling' ), __( 'Project', 'wisebones-remodeling' ) ),
	),
	'lead_type'     => 'quote',
	'colors'        => array(
		'primary'   => '#2f5d62',
		'secondary' => '#5d6a6c',
		'accent'    => '#c5883e',
		'header_bg' => '#ffffff',
		'footer_bg' => '#142624',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Free consultation', 'wisebones-remodeling' ), '/contact/', 'bi-calendar-check' ),

	'hero'          => array(
		'style'     => 'gradient',
		'eyebrow'   => __( 'Design-build remodeling', 'wisebones-remodeling' ),
		'heading'   => __( 'Love your home again', 'wisebones-remodeling' ),
		'text'      => __( 'Kitchens, baths, additions and whole-home renovations — designed and built by one team, with a fixed price before work begins.', 'wisebones-remodeling' ),
		'primary'   => array( __( 'Book a consultation', 'wisebones-remodeling' ), '/contact/' ),
		'secondary' => array( __( 'See our work', 'wisebones-remodeling' ), '/our-work/' ),
		'badges'    => array( __( 'Licensed & insured', 'wisebones-remodeling' ), __( 'Written workmanship warranty', 'wisebones-remodeling' ) ),
		'panel'     => 'quote',
		'quote'     => array(
			'title'  => __( 'Start with a free in-home consultation', 'wisebones-remodeling' ),
			'text'   => __( 'Tell us about the space and we will bring ideas, a rough budget range and a realistic timeline.', 'wisebones-remodeling' ),
			'points' => array( __( 'No-pressure, no-cost visit', 'wisebones-remodeling' ), __( 'Design and construction under one contract', 'wisebones-remodeling' ), __( 'Fixed price before demolition starts', 'wisebones-remodeling' ) ),
			'button' => array( __( 'Book my consultation', 'wisebones-remodeling' ), '/contact/' ),
		),
	),

	'stats'         => array(
		array( __( 'One', 'wisebones-remodeling' ), __( 'Team from design to done', 'wisebones-remodeling' ) ),
		array( __( 'Fixed', 'wisebones-remodeling' ), __( 'Price before work begins', 'wisebones-remodeling' ) ),
		array( __( 'Weekly', 'wisebones-remodeling' ), __( 'Progress updates', 'wisebones-remodeling' ) ),
		array( __( 'Warranty', 'wisebones-remodeling' ), __( 'On workmanship', 'wisebones-remodeling' ) ),
	),

	'sections'      => array(
		'featured'     => array(
			'type'    => 'project',
			'eyebrow' => __( 'Recent projects', 'wisebones-remodeling' ),
			'heading' => __( 'Before, after and everything between', 'wisebones-remodeling' ),
			'text'    => __( 'A look at homes we have transformed for our neighbors.', 'wisebones-remodeling' ),
			'samples' => array(
				array( 'title' => __( 'Open-plan kitchen with walnut island', 'wisebones-remodeling' ), 'sector' => __( 'Kitchen', 'wisebones-remodeling' ), 'location' => __( 'Hillcrest', 'wisebones-remodeling' ), 'size' => __( '320 sq ft', 'wisebones-remodeling' ), 'year' => '2025', 'excerpt' => __( 'Removed a load-bearing wall to join kitchen and dining.', 'wisebones-remodeling' ) ),
				array( 'title' => __( 'Spa-style primary bath', 'wisebones-remodeling' ), 'sector' => __( 'Bathroom', 'wisebones-remodeling' ), 'location' => __( 'Riverside', 'wisebones-remodeling' ), 'size' => __( '140 sq ft', 'wisebones-remodeling' ), 'year' => '2025', 'excerpt' => __( 'Curbless shower, heated floors and a floating double vanity.', 'wisebones-remodeling' ) ),
				array( 'title' => __( 'Two-story rear addition', 'wisebones-remodeling' ), 'sector' => __( 'Addition', 'wisebones-remodeling' ), 'location' => __( 'Old Town', 'wisebones-remodeling' ), 'size' => __( '650 sq ft', 'wisebones-remodeling' ), 'year' => '2024', 'excerpt' => __( 'Family room below, primary suite above, matched to the original house.', 'wisebones-remodeling' ) ),
			),
		),
		'services'     => array(
			'eyebrow' => __( 'What we do', 'wisebones-remodeling' ),
			'heading' => __( 'Remodeling for every room', 'wisebones-remodeling' ),
			'text'    => __( 'Small refresh or whole-house renovation, the same careful team does the work.', 'wisebones-remodeling' ),
			'items'   => array(
				array( 'bi-cup-hot', __( 'Kitchens', 'wisebones-remodeling' ), __( 'Layouts that work, cabinetry that lasts and lighting that makes it shine.', 'wisebones-remodeling' ) ),
				array( 'bi-droplet', __( 'Bathrooms', 'wisebones-remodeling' ), __( 'Primary suites, family baths and accessible aging-in-place upgrades.', 'wisebones-remodeling' ) ),
				array( 'bi-house-add', __( 'Additions', 'wisebones-remodeling' ), __( 'More room without moving — designed to look like it was always there.', 'wisebones-remodeling' ) ),
				array( 'bi-house-gear', __( 'Whole-home renovation', 'wisebones-remodeling' ), __( 'Open up floor plans and bring older homes up to date.', 'wisebones-remodeling' ) ),
				array( 'bi-stairs', __( 'Basements', 'wisebones-remodeling' ), __( 'Finished lower levels for living, guests or a home office.', 'wisebones-remodeling' ) ),
				array( 'bi-tree', __( 'Outdoor living', 'wisebones-remodeling' ), __( 'Decks, porches and covered patios built for real use.', 'wisebones-remodeling' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Design-build', 'wisebones-remodeling' ),
			'heading'   => __( 'One team, one contract, one price', 'wisebones-remodeling' ),
			'text'      => __( 'Designers and builders who work side by side catch problems on paper, not after the walls are open.', 'wisebones-remodeling' ),
			'points'    => array(
				array( __( 'Budget-first design', 'wisebones-remodeling' ), __( 'Every drawing is priced as it develops.', 'wisebones-remodeling' ) ),
				array( __( 'A dedicated project lead', 'wisebones-remodeling' ), __( 'One person to call from first sketch to final walkthrough.', 'wisebones-remodeling' ) ),
				array( __( 'Financing options', 'wisebones-remodeling' ), __( 'Spread the cost with plans offered through our lending partners.', 'wisebones-remodeling' ) ),
			),
			'button'    => array( __( 'Explore financing', 'wisebones-remodeling' ), '/financing/' ),
			'highlight' => array(
				'icon'  => 'bi-pencil-square',
				'title' => __( 'Plans and price, before demolition', 'wisebones-remodeling' ),
				'text'  => __( 'You approve the design, the selections and the contract price before any work begins.', 'wisebones-remodeling' ),
				'tags'  => array( __( '3D design', 'wisebones-remodeling' ), __( 'Selections showroom', 'wisebones-remodeling' ), __( 'Permits handled', 'wisebones-remodeling' ), __( 'Clean job sites', 'wisebones-remodeling' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'Our process', 'wisebones-remodeling' ),
			'heading' => __( 'Four steps to a finished room', 'wisebones-remodeling' ),
			'steps'   => array(
				array( __( 'Consult', 'wisebones-remodeling' ), __( 'We visit, listen and talk budget openly.', 'wisebones-remodeling' ) ),
				array( __( 'Design', 'wisebones-remodeling' ), __( 'Drawings, 3D views and selections, priced as we go.', 'wisebones-remodeling' ) ),
				array( __( 'Build', 'wisebones-remodeling' ), __( 'A protected, tidy site and weekly progress updates.', 'wisebones-remodeling' ) ),
				array( __( 'Enjoy', 'wisebones-remodeling' ), __( 'Final walkthrough, and a warranty that stands behind the work.', 'wisebones-remodeling' ) ),
			),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Homeowner reviews', 'wisebones-remodeling' ),
			'heading' => __( 'What our clients say', 'wisebones-remodeling' ),
			'samples' => array(
				array( __( 'The price they quoted is the price we paid. That alone made it worth it.', 'wisebones-remodeling' ), __( 'Sample client', 'wisebones-remodeling' ), __( 'Kitchen remodel', 'wisebones-remodeling' ) ),
				array( __( 'They protected our floors and cleaned up every single day.', 'wisebones-remodeling' ), __( 'Sample client', 'wisebones-remodeling' ), __( 'Bathroom remodel', 'wisebones-remodeling' ) ),
				array( __( 'Neighbors cannot tell where the old house ends and the addition begins.', 'wisebones-remodeling' ), __( 'Sample client', 'wisebones-remodeling' ), __( 'Home addition', 'wisebones-remodeling' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Service area', 'wisebones-remodeling' ),
			'heading' => __( 'Remodeling homes across the area', 'wisebones-remodeling' ),
			'text'    => __( 'We take on a limited number of projects in the neighborhoods we know best.', 'wisebones-remodeling' ),
			'items'   => array( __( 'Downtown', 'wisebones-remodeling' ), __( 'Riverside', 'wisebones-remodeling' ), __( 'Hillcrest', 'wisebones-remodeling' ), __( 'Old Town', 'wisebones-remodeling' ), __( 'Lakeview', 'wisebones-remodeling' ), __( 'Westgate', 'wisebones-remodeling' ) ),
		),
		'faq'          => array(
			'eyebrow' => __( 'Questions', 'wisebones-remodeling' ),
			'heading' => __( 'Before you remodel', 'wisebones-remodeling' ),
			'items'   => array(
				array( __( 'How much does a remodel cost?', 'wisebones-remodeling' ), __( 'It depends on size, structure and finishes. We give a budget range at the first visit and a fixed price once the design is approved.', 'wisebones-remodeling' ) ),
				array( __( 'How long will it take?', 'wisebones-remodeling' ), __( 'Bathrooms typically take a few weeks of construction, kitchens a little longer, and additions several months. Your schedule is set before work starts.', 'wisebones-remodeling' ) ),
				array( __( 'Can we live at home during the work?', 'wisebones-remodeling' ), __( 'Usually, yes. We seal off work areas, control dust and plan around your routines.', 'wisebones-remodeling' ) ),
				array( __( 'Do you handle permits?', 'wisebones-remodeling' ), __( 'Yes. We prepare drawings, pull permits and schedule every inspection.', 'wisebones-remodeling' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Let\'s talk about your home', 'wisebones-remodeling' ),
			'text'    => __( 'Tell us about your project and we will schedule a free in-home consultation.', 'wisebones-remodeling' ),
			'form'    => true,
			'button'  => array( __( 'Book a consultation', 'wisebones-remodeling' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'featured', 'services', 'values', 'process', 'testimonials', 'areas', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'A design-build remodeling company creating kitchens, baths and additions people love coming home to.', 'wisebones-remodeling' ),
		'note'    => __( 'Licensed and insured. Add your contractor license number here.', 'wisebones-remodeling' ),
		'columns' => array(
			__( 'Remodeling', 'wisebones-remodeling' ) => array(
				array( __( 'Kitchens', 'wisebones-remodeling' ), '/kitchens/' ),
				array( __( 'Bathrooms', 'wisebones-remodeling' ), '/bathrooms/' ),
				array( __( 'Additions', 'wisebones-remodeling' ), '/additions/' ),
			),
			__( 'Planning', 'wisebones-remodeling' )   => array(
				array( __( 'Our work', 'wisebones-remodeling' ), '/our-work/' ),
				array( __( 'Financing', 'wisebones-remodeling' ), '/financing/' ),
				array( __( 'Blog', 'wisebones-remodeling' ), '/blog/' ),
			),
			__( 'Company', 'wisebones-remodeling' )    => array(
				array( __( 'About', 'wisebones-remodeling' ), '/about/' ),
				array( __( 'Contact', 'wisebones-remodeling' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'      => array( 'title' => __( 'Home', 'wisebones-remodeling' ) ),
			'kitchens'  => array(
				'title'   => __( 'Kitchen Remodeling', 'wisebones-remodeling' ),
				'content' => $wbrm_p( __( 'Describe your kitchen remodeling approach: layout changes, cabinetry, countertops and typical budget ranges.', 'wisebones-remodeling' ) )
					. $wbrm_code( '[wbik_projects sector="kitchen" count="6"]' )
					. $wbrm_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'bathrooms' => array(
				'title'   => __( 'Bathroom Remodeling', 'wisebones-remodeling' ),
				'content' => $wbrm_p( __( 'Describe your bathroom work: primary suites, hall baths and accessible upgrades.', 'wisebones-remodeling' ) )
					. $wbrm_code( '[wbik_projects sector="bathroom" count="6"]' )
					. $wbrm_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'additions' => array(
				'title'   => __( 'Home Additions', 'wisebones-remodeling' ),
				'content' => $wbrm_p( __( 'Explain how you design additions to match the existing home, and how permits and timelines work.', 'wisebones-remodeling' ) )
					. $wbrm_code( '[wbik_projects sector="addition" count="6"]' )
					. $wbrm_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'financing' => array(
				'title'   => __( 'Financing', 'wisebones-remodeling' ),
				'content' => $wbrm_p( __( 'Describe the financing options you offer and link to your lending partners. Terms are set by the lender, subject to credit approval.', 'wisebones-remodeling' ) ),
			),
			'about'     => array(
				'title'   => __( 'About Us', 'wisebones-remodeling' ),
				'content' => $wbrm_p( __( 'Tell your story: who you are, how long you have been remodeling, and why homeowners choose you.', 'wisebones-remodeling' ) ) . $wbrm_h( __( 'Our team', 'wisebones-remodeling' ) ) . $wbrm_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'   => array(
				'title'   => __( 'Contact', 'wisebones-remodeling' ),
				'content' => $wbrm_p( __( 'Tell us about your project and we will schedule a free in-home consultation.', 'wisebones-remodeling' ) ) . $wbrm_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'blog'      => array( 'title' => __( 'Blog', 'wisebones-remodeling' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-remodeling' ), '/' ),
			array( __( 'Our Work', 'wisebones-remodeling' ), 'archive:project' ),
			array( __( 'Kitchens', 'wisebones-remodeling' ), 'page:kitchens' ),
			array( __( 'Bathrooms', 'wisebones-remodeling' ), 'page:bathrooms' ),
			array( __( 'Additions', 'wisebones-remodeling' ), 'page:additions' ),
			array( __( 'Financing', 'wisebones-remodeling' ), 'page:financing' ),
			array( __( 'About', 'wisebones-remodeling' ), 'page:about' ),
			array( __( 'Contact', 'wisebones-remodeling' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_project_sector' => array( __( 'Kitchen', 'wisebones-remodeling' ), __( 'Bathroom', 'wisebones-remodeling' ), __( 'Addition', 'wisebones-remodeling' ), __( 'Whole home', 'wisebones-remodeling' ), __( 'Basement', 'wisebones-remodeling' ), __( 'Outdoor', 'wisebones-remodeling' ) ),
		),
	),
);
