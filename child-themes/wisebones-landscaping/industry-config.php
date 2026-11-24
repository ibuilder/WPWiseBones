<?php
/**
 * WiseBones Landscaping — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Copy is a starting point: the hero, stats and closing call
 * to action are editable in the Customizer; projects, services, team and
 * testimonials come from the kit's screens. See child-themes/README.md.
 *
 * @package WiseBones_Landscaping
 */

defined( 'ABSPATH' ) || exit;

$wbl_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbl_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbl_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'landscaping',
	'family'        => 'construction',
	'label'         => __( 'Landscaping', 'wisebones-landscaping' ),
	'schema'        => 'HomeAndConstructionBusiness',
	'content_types' => array( 'project', 'service', 'testimonial', 'team' ),
	'labels'        => array(
		'project' => array( __( 'Gallery', 'wisebones-landscaping' ), __( 'Project', 'wisebones-landscaping' ) ),
	),
	'lead_type'     => 'quote',
	'colors'        => array(
		'primary'   => '#2f6b3a',
		'secondary' => '#5b6a5d',
		'accent'    => '#a7c957',
		'header_bg' => '#ffffff',
		'footer_bg' => '#142a18',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Free estimate', 'wisebones-landscaping' ), '/contact/', 'bi-flower1' ),

	'hero'          => array(
		'style'     => 'gradient',
		'eyebrow'   => __( 'Design · Build · Care', 'wisebones-landscaping' ),
		'heading'   => __( 'Outdoor spaces you will actually live in', 'wisebones-landscaping' ),
		'text'      => __( 'Patios, plantings, lighting and lawn care from one local crew — designed for your yard, built to last, and looked after every season.', 'wisebones-landscaping' ),
		'primary'   => array( __( 'Get a free estimate', 'wisebones-landscaping' ), '/contact/' ),
		'secondary' => array( __( 'See our work', 'wisebones-landscaping' ), '/gallery/' ),
		'badges'    => array( __( 'Licensed & insured', 'wisebones-landscaping' ), __( 'Design to maintenance', 'wisebones-landscaping' ) ),
		'panel'     => 'quote',
		'quote'     => array(
			'title'  => __( 'Request a free estimate', 'wisebones-landscaping' ),
			'text'   => __( 'Tell us about your yard and we will schedule a site visit.', 'wisebones-landscaping' ),
			'points' => array( __( 'On-site consultation', 'wisebones-landscaping' ), __( 'Written, itemized proposal', 'wisebones-landscaping' ), __( 'Design options for any budget', 'wisebones-landscaping' ) ),
			'button' => array( __( 'Book my visit', 'wisebones-landscaping' ), '/contact/' ),
		),
	),

	'stats'         => array(
		array( __( 'Local', 'wisebones-landscaping' ), __( 'Crews who know the soil and climate', 'wisebones-landscaping' ) ),
		array( __( 'Free', 'wisebones-landscaping' ), __( 'Estimates and site visits', 'wisebones-landscaping' ) ),
		array( __( 'Year-round', 'wisebones-landscaping' ), __( 'Seasonal care plans', 'wisebones-landscaping' ) ),
		array( __( 'Insured', 'wisebones-landscaping' ), __( 'Fully licensed and insured', 'wisebones-landscaping' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'Services', 'wisebones-landscaping' ),
			'heading' => __( 'Everything outside your door', 'wisebones-landscaping' ),
			'text'    => __( 'Start with one project or let us handle the whole property.', 'wisebones-landscaping' ),
			'items'   => array(
				array( 'bi-pencil-square', __( 'Landscape design', 'wisebones-landscaping' ), __( 'Site plans and 3D concepts that fit your yard, style and budget.', 'wisebones-landscaping' ) ),
				array( 'bi-bricks', __( 'Hardscape', 'wisebones-landscaping' ), __( 'Patios, walkways, retaining walls, fire features and outdoor kitchens.', 'wisebones-landscaping' ) ),
				array( 'bi-flower2', __( 'Planting', 'wisebones-landscaping' ), __( 'Trees, shrubs and perennial beds chosen to thrive in your conditions.', 'wisebones-landscaping' ) ),
				array( 'bi-droplet', __( 'Irrigation', 'wisebones-landscaping' ), __( 'Efficient drip and sprinkler systems, installation and repair.', 'wisebones-landscaping' ) ),
				array( 'bi-lightbulb', __( 'Outdoor lighting', 'wisebones-landscaping' ), __( 'Low-voltage path, accent and security lighting.', 'wisebones-landscaping' ) ),
				array( 'bi-calendar-check', __( 'Maintenance', 'wisebones-landscaping' ), __( 'Mowing, pruning, mulching and seasonal cleanups on a set schedule.', 'wisebones-landscaping' ) ),
			),
		),
		'featured'     => array(
			'type'    => 'project',
			'eyebrow' => __( 'Gallery', 'wisebones-landscaping' ),
			'heading' => __( 'Recent projects', 'wisebones-landscaping' ),
			'text'    => __( 'A few of the yards we have designed, built and cared for.', 'wisebones-landscaping' ),
			'samples' => array(
				array( 'title' => __( 'Bluestone patio and fire pit', 'wisebones-landscaping' ), 'sector' => __( 'Hardscape', 'wisebones-landscaping' ), 'location' => __( 'Lakeview', 'wisebones-landscaping' ), 'size' => __( '650 sf', 'wisebones-landscaping' ), 'year' => '2025', 'excerpt' => __( 'A sunken patio with seat walls and a gas fire pit.', 'wisebones-landscaping' ) ),
				array( 'title' => __( 'Pollinator front garden', 'wisebones-landscaping' ), 'sector' => __( 'Planting', 'wisebones-landscaping' ), 'location' => __( 'Old Town', 'wisebones-landscaping' ), 'size' => __( '1,200 sf', 'wisebones-landscaping' ), 'year' => '2024', 'excerpt' => __( 'Lawn replaced with native perennials and a gravel path.', 'wisebones-landscaping' ) ),
				array( 'title' => __( 'Terraced backyard', 'wisebones-landscaping' ), 'sector' => __( 'Design-build', 'wisebones-landscaping' ), 'location' => __( 'Hillcrest', 'wisebones-landscaping' ), 'size' => __( '0.4 acre', 'wisebones-landscaping' ), 'year' => '2025', 'excerpt' => __( 'Retaining walls, steps and lighting turn a slope into usable space.', 'wisebones-landscaping' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Maintenance plans', 'wisebones-landscaping' ),
			'heading'   => __( 'Keep it looking like the day we finished', 'wisebones-landscaping' ),
			'text'      => __( 'A seasonal plan means the same crew visits on a set schedule, so small problems never become big ones.', 'wisebones-landscaping' ),
			'points'    => array(
				array( __( 'One crew, every visit', 'wisebones-landscaping' ), __( 'People who know your property and your preferences.', 'wisebones-landscaping' ) ),
				array( __( 'Seasonal work included', 'wisebones-landscaping' ), __( 'Spring cleanup, mulching, pruning and fall leaf removal.', 'wisebones-landscaping' ) ),
				array( __( 'Irrigation checks', 'wisebones-landscaping' ), __( 'Start-up, adjustments and winterizing.', 'wisebones-landscaping' ) ),
			),
			'button'    => array( __( 'See maintenance plans', 'wisebones-landscaping' ), '/maintenance/' ),
			'highlight' => array(
				'icon'  => 'bi-calendar2-week',
				'title' => __( 'Seasonal care plans', 'wisebones-landscaping' ),
				'text'  => __( 'Weekly, bi-weekly or monthly visits, priced for your property after a walk-through.', 'wisebones-landscaping' ),
				'tags'  => array( __( 'Mowing', 'wisebones-landscaping' ), __( 'Pruning', 'wisebones-landscaping' ), __( 'Mulch', 'wisebones-landscaping' ), __( 'Cleanups', 'wisebones-landscaping' ), __( 'Irrigation', 'wisebones-landscaping' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How it works', 'wisebones-landscaping' ),
			'heading' => __( 'From first visit to finished yard', 'wisebones-landscaping' ),
			'steps'   => array(
				array( __( 'Site visit', 'wisebones-landscaping' ), __( 'We walk the property and talk through how you want to use it.', 'wisebones-landscaping' ) ),
				array( __( 'Design & proposal', 'wisebones-landscaping' ), __( 'A plan and an itemized, fixed-scope proposal.', 'wisebones-landscaping' ) ),
				array( __( 'Build', 'wisebones-landscaping' ), __( 'Our own crews install on schedule and clean up daily.', 'wisebones-landscaping' ) ),
				array( __( 'Care', 'wisebones-landscaping' ), __( 'Optional maintenance keeps it healthy year after year.', 'wisebones-landscaping' ) ),
			),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Reviews', 'wisebones-landscaping' ),
			'heading' => __( 'What homeowners say', 'wisebones-landscaping' ),
			'samples' => array(
				array( __( 'The patio is where we spend every summer evening now.', 'wisebones-landscaping' ), __( 'Sample client', 'wisebones-landscaping' ), __( 'Hardscape project', 'wisebones-landscaping' ) ),
				array( __( 'They showed up when they said they would, every single week.', 'wisebones-landscaping' ), __( 'Sample client', 'wisebones-landscaping' ), __( 'Maintenance plan', 'wisebones-landscaping' ) ),
				array( __( 'Our slope went from eyesore to the best part of the yard.', 'wisebones-landscaping' ), __( 'Sample client', 'wisebones-landscaping' ), __( 'Design-build', 'wisebones-landscaping' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Service area', 'wisebones-landscaping' ),
			'heading' => __( 'Where we work', 'wisebones-landscaping' ),
			'text'    => __( 'Design-build projects and maintenance routes across these communities.', 'wisebones-landscaping' ),
			'items'   => array( __( 'Downtown', 'wisebones-landscaping' ), __( 'Riverside', 'wisebones-landscaping' ), __( 'Hillcrest', 'wisebones-landscaping' ), __( 'Old Town', 'wisebones-landscaping' ), __( 'Lakeview', 'wisebones-landscaping' ), __( 'North Park', 'wisebones-landscaping' ), __( 'Westgate', 'wisebones-landscaping' ) ),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-landscaping' ),
			'heading' => __( 'Common questions', 'wisebones-landscaping' ),
			'items'   => array(
				array( __( 'Are estimates really free?', 'wisebones-landscaping' ), __( 'Yes. Site visits and written proposals are free with no obligation.', 'wisebones-landscaping' ) ),
				array( __( 'When is the best time to start a project?', 'wisebones-landscaping' ), __( 'Planting does best in spring and fall; hardscape can be built most of the year. Booking a design in winter gets you on the spring schedule.', 'wisebones-landscaping' ) ),
				array( __( 'Do you handle permits?', 'wisebones-landscaping' ), __( 'Where a permit is required — for taller retaining walls, for example — we prepare and file it as part of the project.', 'wisebones-landscaping' ) ),
				array( __( 'Do I need a maintenance contract?', 'wisebones-landscaping' ), __( 'No. Plans are optional and can be paused or cancelled.', 'wisebones-landscaping' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Let us see your yard', 'wisebones-landscaping' ),
			'text'    => __( 'Book a free site visit and get a written proposal.', 'wisebones-landscaping' ),
			'form'    => true,
			'button'  => array( __( 'Get a free estimate', 'wisebones-landscaping' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'featured', 'values', 'process', 'testimonials', 'areas', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'A local landscape design, build and maintenance company.', 'wisebones-landscaping' ),
		'note'    => __( 'Licensed and insured. Add your contractor license number in Settings → Industry Kit.', 'wisebones-landscaping' ),
		'columns' => array(
			__( 'Services', 'wisebones-landscaping' ) => array(
				array( __( 'Design & build', 'wisebones-landscaping' ), '/design-build/' ),
				array( __( 'Maintenance', 'wisebones-landscaping' ), '/maintenance/' ),
				array( __( 'Gallery', 'wisebones-landscaping' ), '/gallery/' ),
			),
			__( 'Company', 'wisebones-landscaping' )  => array(
				array( __( 'About', 'wisebones-landscaping' ), '/about/' ),
				array( __( 'Blog', 'wisebones-landscaping' ), '/blog/' ),
			),
			__( 'Contact', 'wisebones-landscaping' )  => array(
				array( __( 'Free estimate', 'wisebones-landscaping' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'         => array( 'title' => __( 'Home', 'wisebones-landscaping' ) ),
			'design-build' => array(
				'title'   => __( 'Design & Build', 'wisebones-landscaping' ),
				'content' => $wbl_p( __( 'From a single patio to a complete yard, we design and build with our own crews.', 'wisebones-landscaping' ) )
					. $wbl_code( '[wbik_services columns="3"]' )
					. $wbl_h( __( 'Recent projects', 'wisebones-landscaping' ) )
					. $wbl_code( '[wbik_projects count="6"]' ),
			),
			'maintenance'  => array(
				'title'   => __( 'Maintenance Plans', 'wisebones-landscaping' ),
				'content' => $wbl_p( __( 'Describe your plans here: visit frequency, what each visit includes, and the seasonal services that come with them.', 'wisebones-landscaping' ) ) . $wbl_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'about'        => array(
				'title'   => __( 'About Us', 'wisebones-landscaping' ),
				'content' => $wbl_p( __( 'Tell your story here: how the company started, your certifications, and the crews who do the work.', 'wisebones-landscaping' ) ) . $wbl_h( __( 'Our team', 'wisebones-landscaping' ) ) . $wbl_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'      => array(
				'title'   => __( 'Free Estimate', 'wisebones-landscaping' ),
				'content' => $wbl_p( __( 'Tell us about your yard and what you have in mind. We will call to schedule a free site visit.', 'wisebones-landscaping' ) ) . $wbl_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'blog'         => array( 'title' => __( 'Blog', 'wisebones-landscaping' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-landscaping' ), '/' ),
			array( __( 'Design & Build', 'wisebones-landscaping' ), 'page:design-build' ),
			array( __( 'Maintenance', 'wisebones-landscaping' ), 'page:maintenance' ),
			array( __( 'Gallery', 'wisebones-landscaping' ), 'archive:project' ),
			array( __( 'About', 'wisebones-landscaping' ), 'page:about' ),
			array( __( 'Blog', 'wisebones-landscaping' ), 'page:blog' ),
			array( __( 'Contact', 'wisebones-landscaping' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_project_sector' => array( __( 'Hardscape', 'wisebones-landscaping' ), __( 'Planting', 'wisebones-landscaping' ), __( 'Design-build', 'wisebones-landscaping' ), __( 'Lighting', 'wisebones-landscaping' ) ),
		),
	),
);
