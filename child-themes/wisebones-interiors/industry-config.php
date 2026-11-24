<?php
/**
 * WiseBones Interiors — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Copy is a starting point: the hero, stats and closing call
 * to action are editable in the Customizer; portfolio spaces, services, team
 * and testimonials come from the kit's screens. See child-themes/README.md.
 *
 * @package WiseBones_Interiors
 */

defined( 'ABSPATH' ) || exit;

$wbi_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbi_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbi_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'interiors',
	'family'        => 'construction',
	'label'         => __( 'Interior Design & Staging', 'wisebones-interiors' ),
	'schema'        => 'ProfessionalService',
	'content_types' => array( 'project', 'service', 'testimonial', 'team' ),
	'labels'        => array(
		'project' => array( __( 'Portfolio', 'wisebones-interiors' ), __( 'Space', 'wisebones-interiors' ) ),
	),
	'lead_type'     => 'contact',
	'colors'        => array(
		'primary'   => '#3b3a3a',
		'secondary' => '#6f6763',
		'accent'    => '#b07d6b',
		'header_bg' => '#ffffff',
		'footer_bg' => '#2b2a2a',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Book a consultation', 'wisebones-interiors' ), '/contact/' ),

	'hero'          => array(
		'style'     => 'light',
		'eyebrow'   => __( 'Interior design · Home staging', 'wisebones-interiors' ),
		'heading'   => __( 'Rooms that feel like you — only better', 'wisebones-interiors' ),
		'text'      => __( 'Thoughtful interiors for homes you live in, and staging that helps the ones you are selling find their buyer.', 'wisebones-interiors' ),
		'primary'   => array( __( 'Book a consultation', 'wisebones-interiors' ), '/contact/' ),
		'secondary' => array( __( 'View the portfolio', 'wisebones-interiors' ), '/portfolio/' ),
		'panel'     => 'card',
		'card'      => array(
			'kicker' => __( 'Ways to work together', 'wisebones-interiors' ),
			'title'  => __( 'Design packages', 'wisebones-interiors' ),
			'rows'   => array(
				array( __( 'Consultation', 'wisebones-interiors' ), __( 'Hourly', 'wisebones-interiors' ), 'bi-chat-heart' ),
				array( __( 'Full-service design', 'wisebones-interiors' ), __( 'By project', 'wisebones-interiors' ), 'bi-palette' ),
				array( __( 'Home staging', 'wisebones-interiors' ), __( 'Per home', 'wisebones-interiors' ), 'bi-house-heart' ),
				array( __( 'E-design', 'wisebones-interiors' ), __( 'Per room', 'wisebones-interiors' ), 'bi-laptop' ),
			),
			'button' => array( __( 'Find the right fit', 'wisebones-interiors' ), '/services/' ),
		),
	),

	'stats'         => array(
		array( __( 'Residential', 'wisebones-interiors' ), __( 'Whole homes and single rooms', 'wisebones-interiors' ) ),
		array( __( 'Staging', 'wisebones-interiors' ), __( 'Vacant and occupied homes', 'wisebones-interiors' ) ),
		array( __( 'E-design', 'wisebones-interiors' ), __( 'Plans you can shop yourself', 'wisebones-interiors' ) ),
		array( __( 'Trade', 'wisebones-interiors' ), __( 'Access to trade-only sources', 'wisebones-interiors' ) ),
	),

	'sections'      => array(
		'featured'     => array(
			'type'    => 'project',
			'eyebrow' => __( 'Portfolio', 'wisebones-interiors' ),
			'heading' => __( 'Recent spaces', 'wisebones-interiors' ),
			'samples' => array(
				array( 'title' => __( 'Warm minimalist living room', 'wisebones-interiors' ), 'sector' => __( 'Living', 'wisebones-interiors' ), 'location' => __( 'Hillcrest', 'wisebones-interiors' ), 'year' => '2025', 'excerpt' => __( 'Limewash walls, oak and linen in a calm, layered palette.', 'wisebones-interiors' ) ),
				array( 'title' => __( 'Staged townhome for sale', 'wisebones-interiors' ), 'sector' => __( 'Staging', 'wisebones-interiors' ), 'location' => __( 'Downtown', 'wisebones-interiors' ), 'year' => '2025', 'excerpt' => __( 'A vacant three-bedroom furnished for listing photos.', 'wisebones-interiors' ) ),
				array( 'title' => __( 'Primary suite refresh', 'wisebones-interiors' ), 'sector' => __( 'Bedroom', 'wisebones-interiors' ), 'location' => __( 'Lakeview', 'wisebones-interiors' ), 'year' => '2024', 'excerpt' => __( 'New lighting, textiles and a custom headboard wall.', 'wisebones-interiors' ) ),
			),
		),
		'services'     => array(
			'eyebrow' => __( 'Services', 'wisebones-interiors' ),
			'heading' => __( 'Design help, at the level you need', 'wisebones-interiors' ),
			'items'   => array(
				array( 'bi-chat-heart', __( 'Design consultation', 'wisebones-interiors' ), __( 'An in-home session for layout, color and furnishing advice you can act on.', 'wisebones-interiors' ) ),
				array( 'bi-palette', __( 'Full-service design', 'wisebones-interiors' ), __( 'Concept to installation: sourcing, ordering, trades and styling handled for you.', 'wisebones-interiors' ) ),
				array( 'bi-house-heart', __( 'Home staging', 'wisebones-interiors' ), __( 'Vacant and occupied staging that photographs well and shows well.', 'wisebones-interiors' ) ),
				array( 'bi-laptop', __( 'E-design', 'wisebones-interiors' ), __( 'A room plan and shopping list delivered online, for you to put together.', 'wisebones-interiors' ) ),
				array( 'bi-lightbulb', __( 'Lighting & finishes', 'wisebones-interiors' ), __( 'Fixture plans, paint, tile and hardware selections for renovations.', 'wisebones-interiors' ) ),
				array( 'bi-box-seam', __( 'Move-in styling', 'wisebones-interiors' ), __( 'Unpack, arrange and style so a new house feels like home on day one.', 'wisebones-interiors' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Selling a home?', 'wisebones-interiors' ),
			'heading'   => __( 'Staging that helps buyers picture themselves there', 'wisebones-interiors' ),
			'text'      => __( 'Buyers decide online first. Staging gives every room a clear purpose and makes listing photos do their job.', 'wisebones-interiors' ),
			'points'    => array(
				array( __( 'Vacant or occupied', 'wisebones-interiors' ), __( 'Full furnishing, or a refresh using what you already own.', 'wisebones-interiors' ) ),
				array( __( 'Ready for photos', 'wisebones-interiors' ), __( 'Scheduled around your listing date and photographer.', 'wisebones-interiors' ) ),
				array( __( 'Agent friendly', 'wisebones-interiors' ), __( 'We coordinate directly with your listing agent.', 'wisebones-interiors' ) ),
			),
			'button'    => array( __( 'About staging', 'wisebones-interiors' ), '/staging/' ),
			'highlight' => array(
				'icon'  => 'bi-camera',
				'title' => __( 'Made for the listing photos', 'wisebones-interiors' ),
				'text'  => __( 'Layouts, light and styling planned for how each room will look on screen.', 'wisebones-interiors' ),
				'tags'  => array( __( 'Furniture', 'wisebones-interiors' ), __( 'Art', 'wisebones-interiors' ), __( 'Textiles', 'wisebones-interiors' ), __( 'Lighting', 'wisebones-interiors' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'Process', 'wisebones-interiors' ),
			'heading' => __( 'How we work together', 'wisebones-interiors' ),
			'steps'   => array(
				array( __( 'Consult', 'wisebones-interiors' ), __( 'We meet in your space to talk about how you live and what you love.', 'wisebones-interiors' ) ),
				array( __( 'Concept', 'wisebones-interiors' ), __( 'Mood boards, layouts and a budget for your approval.', 'wisebones-interiors' ) ),
				array( __( 'Source', 'wisebones-interiors' ), __( 'We order, track and receive every piece.', 'wisebones-interiors' ) ),
				array( __( 'Install', 'wisebones-interiors' ), __( 'Installation and styling day — you come home to a finished room.', 'wisebones-interiors' ) ),
			),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Kind words', 'wisebones-interiors' ),
			'heading' => __( 'From our clients', 'wisebones-interiors' ),
			'samples' => array(
				array( __( 'It finally feels like our home, not a collection of furniture.', 'wisebones-interiors' ), __( 'Sample client', 'wisebones-interiors' ), __( 'Full-service design', 'wisebones-interiors' ) ),
				array( __( 'The staging made the listing photos look like a magazine.', 'wisebones-interiors' ), __( 'Sample client', 'wisebones-interiors' ), __( 'Home staging', 'wisebones-interiors' ) ),
				array( __( 'One consultation answered questions we had for years.', 'wisebones-interiors' ), __( 'Sample client', 'wisebones-interiors' ), __( 'Consultation', 'wisebones-interiors' ) ),
			),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-interiors' ),
			'heading' => __( 'Good to know', 'wisebones-interiors' ),
			'items'   => array(
				array( __( 'How are your services priced?', 'wisebones-interiors' ), __( 'Consultations are billed hourly; full-service design and staging are quoted per project after we see the space.', 'wisebones-interiors' ) ),
				array( __( 'Can you work with furniture I already own?', 'wisebones-interiors' ), __( 'Yes. We often build a design around pieces you love.', 'wisebones-interiors' ) ),
				array( __( 'Do you work outside the area?', 'wisebones-interiors' ), __( 'E-design is available anywhere; in-person services cover our local area.', 'wisebones-interiors' ) ),
				array( __( 'How long does a full-service project take?', 'wisebones-interiors' ), __( 'It depends mostly on furniture lead times. We give you a timeline with the concept.', 'wisebones-interiors' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Let us start with your space', 'wisebones-interiors' ),
			'text'    => __( 'Tell us about the room, the home or the listing, and we will suggest the right place to begin.', 'wisebones-interiors' ),
			'form'    => true,
			'button'  => array( __( 'Book a consultation', 'wisebones-interiors' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'featured', 'services', 'values', 'process', 'testimonials', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'An interior design and home staging studio for homeowners, sellers and agents.', 'wisebones-interiors' ),
		'note'    => __( 'Portfolio images are the property of their respective owners.', 'wisebones-interiors' ),
		'columns' => array(
			__( 'Services', 'wisebones-interiors' ) => array(
				array( __( 'Design services', 'wisebones-interiors' ), '/services/' ),
				array( __( 'Home staging', 'wisebones-interiors' ), '/staging/' ),
				array( __( 'Portfolio', 'wisebones-interiors' ), '/portfolio/' ),
			),
			__( 'Studio', 'wisebones-interiors' )   => array(
				array( __( 'About', 'wisebones-interiors' ), '/about/' ),
				array( __( 'Journal', 'wisebones-interiors' ), '/journal/' ),
			),
			__( 'Contact', 'wisebones-interiors' )  => array(
				array( __( 'Book a consultation', 'wisebones-interiors' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'journal',
		'pages' => array(
			'home'     => array( 'title' => __( 'Home', 'wisebones-interiors' ) ),
			'services' => array(
				'title'   => __( 'Services', 'wisebones-interiors' ),
				'content' => $wbi_p( __( 'From a single consultation to a fully furnished home, choose the level of help that suits you.', 'wisebones-interiors' ) ) . $wbi_code( '[wbik_services columns="3"]' ),
			),
			'staging'  => array(
				'title'   => __( 'Home Staging', 'wisebones-interiors' ),
				'content' => $wbi_p( __( 'Staging for vacant and occupied homes, scheduled around your listing date. Agents: send us the address and photo date.', 'wisebones-interiors' ) )
					. $wbi_h( __( 'Staged homes', 'wisebones-interiors' ) )
					. $wbi_code( '[wbik_projects sector="staging" count="6"]' )
					. $wbi_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'about'    => array(
				'title'   => __( 'About', 'wisebones-interiors' ),
				'content' => $wbi_p( __( 'Tell your story here: your design point of view, your training, and the kinds of projects you love.', 'wisebones-interiors' ) ) . $wbi_h( __( 'The studio', 'wisebones-interiors' ) ) . $wbi_code( '[wbik_team count="4" columns="4"]' ),
			),
			'contact'  => array(
				'title'   => __( 'Contact', 'wisebones-interiors' ),
				'content' => $wbi_p( __( 'Tell us about your space and timeline. We reply within two business days.', 'wisebones-interiors' ) ) . $wbi_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'journal'  => array( 'title' => __( 'Journal', 'wisebones-interiors' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-interiors' ), '/' ),
			array( __( 'Portfolio', 'wisebones-interiors' ), 'archive:project' ),
			array( __( 'Services', 'wisebones-interiors' ), 'page:services' ),
			array( __( 'Staging', 'wisebones-interiors' ), 'page:staging' ),
			array( __( 'About', 'wisebones-interiors' ), 'page:about' ),
			array( __( 'Journal', 'wisebones-interiors' ), 'page:journal' ),
			array( __( 'Contact', 'wisebones-interiors' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_project_sector' => array( __( 'Living', 'wisebones-interiors' ), __( 'Kitchen', 'wisebones-interiors' ), __( 'Bedroom', 'wisebones-interiors' ), __( 'Staging', 'wisebones-interiors' ) ),
		),
	),
);
