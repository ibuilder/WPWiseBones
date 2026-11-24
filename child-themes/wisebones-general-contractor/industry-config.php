<?php
/**
 * WiseBones General Contractor — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Projects, services, team and testimonials come from the kit's
 * screens; the hero, stats and closing call to action are editable in the
 * Customizer. See child-themes/README.md.
 *
 * @package WiseBones_General_Contractor
 */

defined( 'ABSPATH' ) || exit;

$wbgc_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbgc_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbgc_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'general-contractor',
	'family'        => 'construction',
	'label'         => __( 'General Contractor', 'wisebones-general-contractor' ),
	'schema'        => 'GeneralContractor',
	'content_types' => array( 'project', 'service', 'team', 'testimonial' ),
	'labels'        => array(
		'project' => array( __( 'Projects', 'wisebones-general-contractor' ), __( 'Project', 'wisebones-general-contractor' ) ),
	),
	'lead_type'     => 'quote',
	'colors'        => array(
		'primary'   => '#f28c1b',
		'secondary' => '#5b636b',
		'accent'    => '#4c7ea6',
		'header_bg' => '#12171c',
		'footer_bg' => '#0b0e11',
	),
	'header_style'  => 'dark',
	'header_cta'    => array( __( 'Request a bid', 'wisebones-general-contractor' ), '/contact/', 'bi-clipboard-check' ),

	'hero'          => array(
		'style'     => 'blueprint',
		'eyebrow'   => __( 'Commercial · Institutional · Industrial', 'wisebones-general-contractor' ),
		'heading'   => __( 'Built right. Built on schedule.', 'wisebones-general-contractor' ),
		'text'      => __( 'General contracting and construction management for owners who need a partner from preconstruction through closeout — with no surprises in between.', 'wisebones-general-contractor' ),
		'primary'   => array( __( 'Request a bid', 'wisebones-general-contractor' ), '/contact/' ),
		'secondary' => array( __( 'View projects', 'wisebones-general-contractor' ), '/projects/' ),
		'badges'    => array( __( 'Licensed, bonded & insured', 'wisebones-general-contractor' ), __( 'Safety-first job sites', 'wisebones-general-contractor' ) ),
		'panel'     => 'card',
		'card'      => array(
			'kicker' => __( 'Delivery methods', 'wisebones-general-contractor' ),
			'title'  => __( 'One team, the right contract', 'wisebones-general-contractor' ),
			'rows'   => array(
				array( __( 'General contracting', 'wisebones-general-contractor' ), __( 'Hard bid', 'wisebones-general-contractor' ), 'bi-hammer' ),
				array( __( 'CM at-risk', 'wisebones-general-contractor' ), __( 'GMP', 'wisebones-general-contractor' ), 'bi-clipboard-data' ),
				array( __( 'Design-build', 'wisebones-general-contractor' ), __( 'Single source', 'wisebones-general-contractor' ), 'bi-diagram-3' ),
				array( __( 'Preconstruction', 'wisebones-general-contractor' ), __( 'Budget & schedule', 'wisebones-general-contractor' ), 'bi-rulers' ),
			),
			'button' => array( __( 'Discuss your project', 'wisebones-general-contractor' ), '/contact/' ),
		),
	),

	'stats'         => array(
		array( __( 'Precon', 'wisebones-general-contractor' ), __( 'Budgets before drawings are final', 'wisebones-general-contractor' ) ),
		array( __( 'Self-perform', 'wisebones-general-contractor' ), __( 'Concrete and carpentry crews', 'wisebones-general-contractor' ) ),
		array( __( 'Bonded', 'wisebones-general-contractor' ), __( 'Public and private work', 'wisebones-general-contractor' ) ),
		array( __( 'Daily', 'wisebones-general-contractor' ), __( 'Logs and photo reports', 'wisebones-general-contractor' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'Capabilities', 'wisebones-general-contractor' ),
			'heading' => __( 'From first estimate to final punch list', 'wisebones-general-contractor' ),
			'text'    => __( 'We manage cost, schedule and risk across every phase of the build.', 'wisebones-general-contractor' ),
			'items'   => array(
				array( 'bi-rulers', __( 'Preconstruction', 'wisebones-general-contractor' ), __( 'Conceptual estimates, value engineering, constructability reviews and phasing plans.', 'wisebones-general-contractor' ) ),
				array( 'bi-building', __( 'General contracting', 'wisebones-general-contractor' ), __( 'Competitive hard-bid delivery with disciplined subcontractor management.', 'wisebones-general-contractor' ) ),
				array( 'bi-clipboard-data', __( 'Construction management', 'wisebones-general-contractor' ), __( 'CM at-risk with an open-book guaranteed maximum price.', 'wisebones-general-contractor' ) ),
				array( 'bi-diagram-3', __( 'Design-build', 'wisebones-general-contractor' ), __( 'One contract and one point of accountability for design and construction.', 'wisebones-general-contractor' ) ),
				array( 'bi-tools', __( 'Tenant improvements', 'wisebones-general-contractor' ), __( 'Fast-track interior build-outs in occupied buildings.', 'wisebones-general-contractor' ) ),
				array( 'bi-arrow-repeat', __( 'Renovation & adaptive reuse', 'wisebones-general-contractor' ), __( 'Structural upgrades and new life for existing buildings.', 'wisebones-general-contractor' ) ),
			),
		),
		'featured'     => array(
			'type'    => 'project',
			'eyebrow' => __( 'Recent work', 'wisebones-general-contractor' ),
			'heading' => __( 'Projects we are proud of', 'wisebones-general-contractor' ),
			'text'    => __( 'Healthcare, education, commercial and industrial — delivered on budget and on schedule.', 'wisebones-general-contractor' ),
			'samples' => array(
				array( 'title' => __( 'Riverside Medical Office Building', 'wisebones-general-contractor' ), 'sector' => __( 'Healthcare', 'wisebones-general-contractor' ), 'location' => __( 'Riverside', 'wisebones-general-contractor' ), 'size' => __( '48,000 sf', 'wisebones-general-contractor' ), 'year' => '2025', 'role' => __( 'CM at-risk', 'wisebones-general-contractor' ), 'value' => '$18.4M', 'excerpt' => __( 'Three-story medical office with imaging suite and ambulatory surgery.', 'wisebones-general-contractor' ) ),
				array( 'title' => __( 'Northgate Elementary Addition', 'wisebones-general-contractor' ), 'sector' => __( 'Education', 'wisebones-general-contractor' ), 'location' => __( 'Northgate', 'wisebones-general-contractor' ), 'size' => __( '22,000 sf', 'wisebones-general-contractor' ), 'year' => '2024', 'role' => __( 'General contractor', 'wisebones-general-contractor' ), 'value' => '$9.6M', 'excerpt' => __( 'Twelve-classroom wing built while the school stayed open.', 'wisebones-general-contractor' ) ),
				array( 'title' => __( 'Harbor Logistics Center', 'wisebones-general-contractor' ), 'sector' => __( 'Industrial', 'wisebones-general-contractor' ), 'location' => __( 'Port District', 'wisebones-general-contractor' ), 'size' => __( '210,000 sf', 'wisebones-general-contractor' ), 'year' => '2024', 'role' => __( 'Design-build', 'wisebones-general-contractor' ), 'value' => '$24M', 'excerpt' => __( 'Tilt-up distribution warehouse with 40 dock doors.', 'wisebones-general-contractor' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Safety & quality', 'wisebones-general-contractor' ),
			'heading'   => __( 'Everyone goes home safe. Every detail gets checked.', 'wisebones-general-contractor' ),
			'text'      => __( 'Safety and quality are planned into the schedule, not added at the end. Describe your own program and record here.', 'wisebones-general-contractor' ),
			'points'    => array(
				array( __( 'Site-specific safety plans', 'wisebones-general-contractor' ), __( 'Written for each project before mobilization.', 'wisebones-general-contractor' ) ),
				array( __( 'Quality control at every phase', 'wisebones-general-contractor' ), __( 'Pre-installation meetings, mock-ups and inspections.', 'wisebones-general-contractor' ) ),
				array( __( 'Transparent reporting', 'wisebones-general-contractor' ), __( 'Owners see daily logs, photos and schedule updates.', 'wisebones-general-contractor' ) ),
			),
			'button'    => array( __( 'Our safety program', 'wisebones-general-contractor' ), '/safety/' ),
			'highlight' => array(
				'icon'  => 'bi-cone-striped',
				'title' => __( 'Our job-site commitments', 'wisebones-general-contractor' ),
				'text'  => __( 'The standards we hold every crew and subcontractor to.', 'wisebones-general-contractor' ),
				'tags'  => array( __( 'OSHA 30-trained supervisors', 'wisebones-general-contractor' ), __( 'Daily logs', 'wisebones-general-contractor' ), __( 'Third-party inspections', 'wisebones-general-contractor' ), __( 'Weekly toolbox talks', 'wisebones-general-contractor' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How we work', 'wisebones-general-contractor' ),
			'heading' => __( 'A predictable path to occupancy', 'wisebones-general-contractor' ),
			'steps'   => array(
				array( __( 'Preconstruction', 'wisebones-general-contractor' ), __( 'Budget, schedule and constructability review while design is still flexible.', 'wisebones-general-contractor' ) ),
				array( __( 'Bid & buyout', 'wisebones-general-contractor' ), __( 'Qualified subcontractors, leveled bids and a locked price.', 'wisebones-general-contractor' ) ),
				array( __( 'Build', 'wisebones-general-contractor' ), __( 'Daily supervision, weekly owner meetings and a schedule you can trust.', 'wisebones-general-contractor' ) ),
				array( __( 'Closeout', 'wisebones-general-contractor' ), __( 'Punch list, commissioning, warranties and as-builts handed over complete.', 'wisebones-general-contractor' ) ),
			),
		),
		'team'         => array(
			'eyebrow' => __( 'Leadership', 'wisebones-general-contractor' ),
			'heading' => __( 'The people who run your job', 'wisebones-general-contractor' ),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Client feedback', 'wisebones-general-contractor' ),
			'heading' => __( 'What owners and architects say', 'wisebones-general-contractor' ),
			'samples' => array(
				array( __( 'They flagged a structural conflict in precon that would have cost us weeks in the field.', 'wisebones-general-contractor' ), __( 'Sample client', 'wisebones-general-contractor' ), __( 'Owner\'s representative', 'wisebones-general-contractor' ) ),
				array( __( 'Clean site, honest schedule updates and a punch list closed in days.', 'wisebones-general-contractor' ), __( 'Sample client', 'wisebones-general-contractor' ), __( 'Facilities director', 'wisebones-general-contractor' ) ),
				array( __( 'The most collaborative contractor we have worked with on a design-build job.', 'wisebones-general-contractor' ), __( 'Sample client', 'wisebones-general-contractor' ), __( 'Architect', 'wisebones-general-contractor' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Where we build', 'wisebones-general-contractor' ),
			'heading' => __( 'Regions we serve', 'wisebones-general-contractor' ),
			'text'    => __( 'Local crews and subcontractor relationships across the region.', 'wisebones-general-contractor' ),
			'items'   => array( __( 'Metro core', 'wisebones-general-contractor' ), __( 'North County', 'wisebones-general-contractor' ), __( 'South Valley', 'wisebones-general-contractor' ), __( 'Port District', 'wisebones-general-contractor' ), __( 'East Corridor', 'wisebones-general-contractor' ), __( 'Coastal region', 'wisebones-general-contractor' ) ),
		),
		'faq'          => array(
			'eyebrow' => __( 'Questions', 'wisebones-general-contractor' ),
			'heading' => __( 'Working with us', 'wisebones-general-contractor' ),
			'items'   => array(
				array( __( 'Which delivery method is right for my project?', 'wisebones-general-contractor' ), __( 'It depends on how fixed your design, budget and schedule are. We will walk through hard bid, CM at-risk and design-build with you in the first meeting.', 'wisebones-general-contractor' ) ),
				array( __( 'When should we bring a contractor on board?', 'wisebones-general-contractor' ), __( 'As early as schematic design. Preconstruction input is cheapest when the design can still change.', 'wisebones-general-contractor' ) ),
				array( __( 'Do you work on public projects?', 'wisebones-general-contractor' ), __( 'Yes. We are bonded for public work and familiar with prevailing-wage and procurement requirements.', 'wisebones-general-contractor' ) ),
				array( __( 'How do you keep owners informed?', 'wisebones-general-contractor' ), __( 'Weekly owner meetings, daily logs with photos, and a three-week look-ahead schedule.', 'wisebones-general-contractor' ) ),
			),
		),
		'posts'        => array(
			'eyebrow' => __( 'News', 'wisebones-general-contractor' ),
			'heading' => __( 'From the field', 'wisebones-general-contractor' ),
		),
		'cta'          => array(
			'heading' => __( 'Have a project on the boards?', 'wisebones-general-contractor' ),
			'text'    => __( 'Send us the basics and a preconstruction manager will follow up within two business days.', 'wisebones-general-contractor' ),
			'form'    => true,
			'button'  => array( __( 'Request a bid', 'wisebones-general-contractor' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'featured', 'values', 'process', 'team', 'testimonials', 'areas', 'faq', 'posts', 'cta' ),

	'footer'        => array(
		'about'   => __( 'General contractor and construction manager for commercial, institutional and industrial owners.', 'wisebones-general-contractor' ),
		'note'    => __( 'Licensed, bonded and insured. Add your contractor license number here.', 'wisebones-general-contractor' ),
		'columns' => array(
			__( 'Work', 'wisebones-general-contractor' )    => array(
				array( __( 'Projects', 'wisebones-general-contractor' ), '/projects/' ),
				array( __( 'Services', 'wisebones-general-contractor' ), '/services/' ),
				array( __( 'Safety', 'wisebones-general-contractor' ), '/safety/' ),
			),
			__( 'Company', 'wisebones-general-contractor' ) => array(
				array( __( 'About', 'wisebones-general-contractor' ), '/about/' ),
				array( __( 'Careers', 'wisebones-general-contractor' ), '/careers/' ),
				array( __( 'News', 'wisebones-general-contractor' ), '/news/' ),
			),
			__( 'Contact', 'wisebones-general-contractor' ) => array(
				array( __( 'Request a bid', 'wisebones-general-contractor' ), '/contact/' ),
				array( __( 'Subcontractors', 'wisebones-general-contractor' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'news',
		'pages' => array(
			'home'     => array( 'title' => __( 'Home', 'wisebones-general-contractor' ) ),
			'services' => array(
				'title'   => __( 'Services', 'wisebones-general-contractor' ),
				'content' => $wbgc_p( __( 'From preconstruction to closeout, choose the delivery method that fits your project.', 'wisebones-general-contractor' ) ) . $wbgc_code( '[wbik_services count="9"]' ),
			),
			'safety'   => array(
				'title'   => __( 'Safety', 'wisebones-general-contractor' ),
				'content' => $wbgc_p( __( 'Describe your safety program: training, site-specific plans, inspections and your recordable-incident history.', 'wisebones-general-contractor' ) ),
			),
			'careers'  => array(
				'title'   => __( 'Careers', 'wisebones-general-contractor' ),
				'content' => $wbgc_p( __( 'List open positions for project managers, superintendents, estimators and craft workers, and how to apply.', 'wisebones-general-contractor' ) )
					. $wbgc_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'about'    => array(
				'title'   => __( 'About Us', 'wisebones-general-contractor' ),
				'content' => $wbgc_p( __( 'Tell your story: when you were founded, the markets you serve and what owners can expect from your team.', 'wisebones-general-contractor' ) ) . $wbgc_h( __( 'Leadership', 'wisebones-general-contractor' ) ) . $wbgc_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'  => array(
				'title'   => __( 'Contact', 'wisebones-general-contractor' ),
				'content' => $wbgc_p( __( 'Owners and architects: send project details for a bid or a preconstruction meeting. Subcontractors: tell us your trade to join our bid list.', 'wisebones-general-contractor' ) ) . $wbgc_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'news'     => array( 'title' => __( 'News', 'wisebones-general-contractor' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-general-contractor' ), '/' ),
			array( __( 'Projects', 'wisebones-general-contractor' ), 'archive:project' ),
			array( __( 'Services', 'wisebones-general-contractor' ), 'page:services' ),
			array( __( 'Safety', 'wisebones-general-contractor' ), 'page:safety' ),
			array( __( 'About', 'wisebones-general-contractor' ), 'page:about' ),
			array( __( 'Careers', 'wisebones-general-contractor' ), 'page:careers' ),
			array( __( 'News', 'wisebones-general-contractor' ), 'page:news' ),
			array( __( 'Contact', 'wisebones-general-contractor' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_project_sector' => array( __( 'Healthcare', 'wisebones-general-contractor' ), __( 'Education', 'wisebones-general-contractor' ), __( 'Commercial', 'wisebones-general-contractor' ), __( 'Industrial', 'wisebones-general-contractor' ), __( 'Multifamily', 'wisebones-general-contractor' ), __( 'Public', 'wisebones-general-contractor' ) ),
		),
	),
);
