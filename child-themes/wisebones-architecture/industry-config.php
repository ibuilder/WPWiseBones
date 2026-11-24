<?php
/**
 * WiseBones Architecture — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Copy is a starting point: the hero, stats and closing call
 * to action are editable in the Customizer; work, principals, services and
 * testimonials come from the kit's screens. See child-themes/README.md.
 *
 * @package WiseBones_Architecture
 */

defined( 'ABSPATH' ) || exit;

$wba_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wba_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wba_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'architecture',
	'family'        => 'construction',
	'label'         => __( 'Architecture Firm', 'wisebones-architecture' ),
	'schema'        => 'ProfessionalService',
	'content_types' => array( 'project', 'team', 'service', 'testimonial' ),
	'labels'        => array(
		'project' => array( __( 'Work', 'wisebones-architecture' ), __( 'Project', 'wisebones-architecture' ) ),
	),
	'lead_type'     => 'contact',
	'colors'        => array(
		'primary'   => '#111111',
		'secondary' => '#6b6b6b',
		'accent'    => '#e4572e',
		'header_bg' => '#ffffff',
		'footer_bg' => '#111111',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Start a project', 'wisebones-architecture' ), '/contact/' ),

	'hero'          => array(
		'style'     => 'light',
		'eyebrow'   => __( 'Architecture · Interiors · Planning', 'wisebones-architecture' ),
		'heading'   => __( 'Buildings shaped by place, light and the people who use them', 'wisebones-architecture' ),
		'text'      => __( 'An architecture studio working across civic, residential and workplace projects — from first sketch to the last site visit.', 'wisebones-architecture' ),
		'primary'   => array( __( 'See our work', 'wisebones-architecture' ), '/work/' ),
		'secondary' => array( __( 'About the studio', 'wisebones-architecture' ), '/studio/' ),
		'panel'     => 'none',
	),

	'stats'         => array(
		array( __( 'Architecture', 'wisebones-architecture' ), __( 'New build and adaptive reuse', 'wisebones-architecture' ) ),
		array( __( 'Interiors', 'wisebones-architecture' ), __( 'Workplace, hospitality, residential', 'wisebones-architecture' ) ),
		array( __( 'Planning', 'wisebones-architecture' ), __( 'Feasibility and master plans', 'wisebones-architecture' ) ),
		array( __( 'Preservation', 'wisebones-architecture' ), __( 'Historic structures, renewed', 'wisebones-architecture' ) ),
	),

	'sections'      => array(
		'featured'     => array(
			'type'    => 'project',
			'count'   => 6,
			'eyebrow' => __( 'Selected work', 'wisebones-architecture' ),
			'heading' => __( 'Recent projects', 'wisebones-architecture' ),
			'samples' => array(
				array( 'title' => __( 'Riverside Branch Library', 'wisebones-architecture' ), 'sector' => __( 'Civic', 'wisebones-architecture' ), 'location' => __( 'Riverside', 'wisebones-architecture' ), 'size' => __( '18,000 sf', 'wisebones-architecture' ), 'year' => '2024', 'excerpt' => __( 'A daylit reading room wrapped around a public garden.', 'wisebones-architecture' ) ),
				array( 'title' => __( 'Mill District Lofts', 'wisebones-architecture' ), 'sector' => __( 'Adaptive reuse', 'wisebones-architecture' ), 'location' => __( 'Old Town', 'wisebones-architecture' ), 'size' => __( '64 units', 'wisebones-architecture' ), 'year' => '2023', 'excerpt' => __( 'A 1910 textile mill converted to homes, keeping its timber frame.', 'wisebones-architecture' ) ),
				array( 'title' => __( 'Hillside House', 'wisebones-architecture' ), 'sector' => __( 'Residential', 'wisebones-architecture' ), 'location' => __( 'Hillcrest', 'wisebones-architecture' ), 'size' => __( '3,400 sf', 'wisebones-architecture' ), 'year' => '2025', 'excerpt' => __( 'A family home stepped into the slope to frame the valley view.', 'wisebones-architecture' ) ),
			),
		),
		'services'     => array(
			'eyebrow' => __( 'Disciplines', 'wisebones-architecture' ),
			'heading' => __( 'One studio, from site to interior', 'wisebones-architecture' ),
			'items'   => array(
				array( 'bi-building', __( 'Architecture', 'wisebones-architecture' ), __( 'New buildings and additions, from concept design through construction administration.', 'wisebones-architecture' ) ),
				array( 'bi-lamp', __( 'Interior architecture', 'wisebones-architecture' ), __( 'Workplace, hospitality and residential interiors designed with the building.', 'wisebones-architecture' ) ),
				array( 'bi-map', __( 'Planning & feasibility', 'wisebones-architecture' ), __( 'Site studies, zoning analysis and master plans that tell you what is possible.', 'wisebones-architecture' ) ),
				array( 'bi-bank', __( 'Preservation', 'wisebones-architecture' ), __( 'Assessment, restoration and sensitive reuse of historic structures.', 'wisebones-architecture' ) ),
				array( 'bi-tree', __( 'Sustainable design', 'wisebones-architecture' ), __( 'Passive strategies, energy modeling and certification support.', 'wisebones-architecture' ) ),
				array( 'bi-box', __( 'BIM & visualization', 'wisebones-architecture' ), __( 'Coordinated models and renderings that make decisions easier.', 'wisebones-architecture' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Approach', 'wisebones-architecture' ),
			'heading'   => __( 'Design that starts with listening', 'wisebones-architecture' ),
			'text'      => __( 'Every project begins with the site, the budget and the people who will use the building. The form follows from there.', 'wisebones-architecture' ),
			'points'    => array(
				array( __( 'Context first', 'wisebones-architecture' ), __( 'Climate, light, neighbors and history shape every scheme.', 'wisebones-architecture' ) ),
				array( __( 'Honest budgets', 'wisebones-architecture' ), __( 'Cost checks at each phase, not a surprise at bid.', 'wisebones-architecture' ) ),
				array( __( 'Built to last', 'wisebones-architecture' ), __( 'Durable materials and details that age well.', 'wisebones-architecture' ) ),
			),
			'button'    => array( __( 'About the studio', 'wisebones-architecture' ), '/studio/' ),
			'highlight' => array(
				'icon'  => 'bi-rulers',
				'title' => __( 'From sketch to site visit', 'wisebones-architecture' ),
				'text'  => __( 'The same team stays with your project through design, permits and construction.', 'wisebones-architecture' ),
				'tags'  => array( __( 'Civic', 'wisebones-architecture' ), __( 'Residential', 'wisebones-architecture' ), __( 'Workplace', 'wisebones-architecture' ), __( 'Adaptive reuse', 'wisebones-architecture' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'Process', 'wisebones-architecture' ),
			'heading' => __( 'How a project unfolds', 'wisebones-architecture' ),
			'steps'   => array(
				array( __( 'Discover', 'wisebones-architecture' ), __( 'Brief, site analysis, budget and program.', 'wisebones-architecture' ) ),
				array( __( 'Design', 'wisebones-architecture' ), __( 'Concept, schematic and design development.', 'wisebones-architecture' ) ),
				array( __( 'Document', 'wisebones-architecture' ), __( 'Permit and construction drawings, coordinated.', 'wisebones-architecture' ) ),
				array( __( 'Build', 'wisebones-architecture' ), __( 'Bidding support and construction administration.', 'wisebones-architecture' ) ),
			),
		),
		'team'         => array(
			'eyebrow' => __( 'Principals', 'wisebones-architecture' ),
			'heading' => __( 'The people behind the work', 'wisebones-architecture' ),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Clients', 'wisebones-architecture' ),
			'heading' => __( 'In their words', 'wisebones-architecture' ),
			'samples' => array(
				array( __( 'They listened before they drew, and the building shows it.', 'wisebones-architecture' ), __( 'Sample client', 'wisebones-architecture' ), __( 'Civic client', 'wisebones-architecture' ) ),
				array( __( 'Our home feels calm in a way we did not know to ask for.', 'wisebones-architecture' ), __( 'Sample client', 'wisebones-architecture' ), __( 'Residential client', 'wisebones-architecture' ) ),
				array( __( 'Clear drawings, steady budgets, no drama on site.', 'wisebones-architecture' ), __( 'Sample client', 'wisebones-architecture' ), __( 'Developer', 'wisebones-architecture' ) ),
			),
		),
		'posts'        => array(
			'eyebrow' => __( 'Journal', 'wisebones-architecture' ),
			'heading' => __( 'News from the studio', 'wisebones-architecture' ),
		),
		'cta'          => array(
			'heading' => __( 'Have a site or a brief?', 'wisebones-architecture' ),
			'text'    => __( 'Tell us about your project and we will arrange a first conversation.', 'wisebones-architecture' ),
			'form'    => true,
			'button'  => array( __( 'Start a project', 'wisebones-architecture' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'featured', 'services', 'values', 'process', 'team', 'testimonials', 'posts', 'cta' ),

	'footer'        => array(
		'about'   => __( 'An architecture and interiors studio designing civic, residential and workplace buildings.', 'wisebones-architecture' ),
		'note'    => __( 'Licensed architects. Project images are the property of their respective owners.', 'wisebones-architecture' ),
		'columns' => array(
			__( 'Work', 'wisebones-architecture' )   => array(
				array( __( 'All projects', 'wisebones-architecture' ), '/work/' ),
				array( __( 'Services', 'wisebones-architecture' ), '/services/' ),
			),
			__( 'Studio', 'wisebones-architecture' ) => array(
				array( __( 'About', 'wisebones-architecture' ), '/studio/' ),
				array( __( 'Careers', 'wisebones-architecture' ), '/careers/' ),
				array( __( 'Journal', 'wisebones-architecture' ), '/journal/' ),
			),
			__( 'Contact', 'wisebones-architecture' ) => array(
				array( __( 'Start a project', 'wisebones-architecture' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'journal',
		'pages' => array(
			'home'     => array( 'title' => __( 'Home', 'wisebones-architecture' ) ),
			'studio'   => array(
				'title'   => __( 'Studio', 'wisebones-architecture' ),
				'content' => $wba_p( __( 'Tell the studio\'s story here: when it was founded, the kind of work you seek out, and how you collaborate with clients and consultants.', 'wisebones-architecture' ) )
					. $wba_h( __( 'Principals', 'wisebones-architecture' ) )
					. $wba_code( '[wbik_team count="8" columns="4"]' ),
			),
			'services' => array(
				'title'   => __( 'Services', 'wisebones-architecture' ),
				'content' => $wba_p( __( 'From feasibility to construction administration, the studio offers full architectural services or any phase on its own.', 'wisebones-architecture' ) ) . $wba_code( '[wbik_services columns="3"]' ),
			),
			'careers'  => array(
				'title'   => __( 'Careers', 'wisebones-architecture' ),
				'content' => $wba_p( __( 'List open positions here, or invite portfolios from designers who would like to join the studio.', 'wisebones-architecture' ) ),
			),
			'contact'  => array(
				'title'   => __( 'Contact', 'wisebones-architecture' ),
				'content' => $wba_p( __( 'Tell us about your site, your brief and your timeline. A principal will reply within two business days.', 'wisebones-architecture' ) ) . $wba_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'journal'  => array( 'title' => __( 'Journal', 'wisebones-architecture' ) ),
		),
		'menu'  => array(
			array( __( 'Work', 'wisebones-architecture' ), 'archive:project' ),
			array( __( 'Studio', 'wisebones-architecture' ), 'page:studio' ),
			array( __( 'Services', 'wisebones-architecture' ), 'page:services' ),
			array( __( 'Journal', 'wisebones-architecture' ), 'page:journal' ),
			array( __( 'Careers', 'wisebones-architecture' ), 'page:careers' ),
			array( __( 'Contact', 'wisebones-architecture' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_project_sector' => array( __( 'Civic', 'wisebones-architecture' ), __( 'Residential', 'wisebones-architecture' ), __( 'Workplace', 'wisebones-architecture' ), __( 'Adaptive reuse', 'wisebones-architecture' ) ),
		),
	),
);
