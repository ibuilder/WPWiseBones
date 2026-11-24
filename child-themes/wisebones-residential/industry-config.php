<?php
/**
 * WiseBones Residential — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. Copy is a starting point: the hero, stats and closing call
 * to action are editable in the Customizer; listings, team, testimonials and
 * neighborhoods come from the kit's screens. See child-themes/README.md.
 *
 * @package WiseBones_Residential
 */

defined( 'ABSPATH' ) || exit;

$wbr_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbr_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbr_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'residential',
	'family'        => 'real-estate',
	'label'         => __( 'Residential Agent', 'wisebones-residential' ),
	'schema'        => 'RealEstateAgent',
	'content_types' => array( 'listing', 'team', 'testimonial', 'service' ),
	'lead_type'     => 'valuation',
	'colors'        => array(
		'primary'   => '#1f4d3a',
		'secondary' => '#5d6b64',
		'accent'    => '#c79a3b',
		'header_bg' => '#ffffff',
		'footer_bg' => '#14281f',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Home value', 'wisebones-residential' ), '/sell/', 'bi-graph-up-arrow' ),

	'hero'          => array(
		'style'     => 'gradient',
		'eyebrow'   => __( 'Local agents · Real results', 'wisebones-residential' ),
		'heading'   => __( 'Find the home that fits the life you want', 'wisebones-residential' ),
		'text'      => __( 'Search every listing in town, see what your home is worth, and work with agents who know these streets block by block.', 'wisebones-residential' ),
		'primary'   => array( __( 'Browse listings', 'wisebones-residential' ), '/listings/' ),
		'secondary' => array( __( 'What is my home worth?', 'wisebones-residential' ), '/sell/' ),
		'badges'    => array( __( 'Buyer & seller representation', 'wisebones-residential' ), __( 'Free market analysis', 'wisebones-residential' ) ),
		'panel'     => 'search',
		'search'    => array(
			'title'  => __( 'Search homes', 'wisebones-residential' ),
			'tabs'   => array( array( 'for-sale', __( 'Buy', 'wisebones-residential' ) ), array( 'for-rent', __( 'Rent', 'wisebones-residential' ) ), array( 'sold', __( 'Recently sold', 'wisebones-residential' ) ) ),
			'types'  => array(
				'single-family' => __( 'Single-family', 'wisebones-residential' ),
				'condo-townhome' => __( 'Condo / townhome', 'wisebones-residential' ),
				'multi-family'  => __( 'Multi-family', 'wisebones-residential' ),
				'land'          => __( 'Land', 'wisebones-residential' ),
			),
			'prices' => array(
				'300000'  => '$300k',
				'500000'  => '$500k',
				'750000'  => '$750k',
				'1000000' => '$1M',
				'2000000' => '$2M',
			),
		),
	),

	'stats'         => array(
		array( __( 'Local', 'wisebones-residential' ), __( 'Agents who live here', 'wisebones-residential' ) ),
		array( __( '24h', 'wisebones-residential' ), __( 'Response to every inquiry', 'wisebones-residential' ) ),
		array( __( 'Free', 'wisebones-residential' ), __( 'Comparative market analysis', 'wisebones-residential' ) ),
		array( __( '7 days', 'wisebones-residential' ), __( 'Showings, evenings included', 'wisebones-residential' ) ),
	),

	'sections'      => array(
		'featured'     => array(
			'type'    => 'listing',
			'eyebrow' => __( 'Featured listings', 'wisebones-residential' ),
			'heading' => __( 'New on the market', 'wisebones-residential' ),
			'text'    => __( 'Hand-picked homes our agents have walked through — updated as soon as they list.', 'wisebones-residential' ),
			'samples' => array(
				array( 'title' => __( 'Bright craftsman with a deep backyard', 'wisebones-residential' ), 'status' => 'for-sale', 'price' => '649000', 'beds' => '4', 'baths' => '2.5', 'sqft' => '2380', 'address' => '214 Maple Ave', 'city' => __( 'Riverside', 'wisebones-residential' ), 'excerpt' => __( 'Original millwork, updated kitchen and a detached studio.', 'wisebones-residential' ) ),
				array( 'title' => __( 'Corner-unit condo near the park', 'wisebones-residential' ), 'status' => 'pending', 'price' => '389000', 'beds' => '2', 'baths' => '2', 'sqft' => '1140', 'address' => '88 Elm St #4C', 'city' => __( 'Downtown', 'wisebones-residential' ), 'excerpt' => __( 'Floor-to-ceiling windows, garage parking and a rooftop deck.', 'wisebones-residential' ) ),
				array( 'title' => __( 'Mid-century ranch on a quiet cul-de-sac', 'wisebones-residential' ), 'status' => 'coming-soon', 'price' => '525000', 'beds' => '3', 'baths' => '2', 'sqft' => '1760', 'address' => '7 Juniper Ct', 'city' => __( 'Hillcrest', 'wisebones-residential' ), 'excerpt' => __( 'Single-level living with a renovated primary suite.', 'wisebones-residential' ) ),
			),
		),
		'services'     => array(
			'eyebrow' => __( 'How we help', 'wisebones-residential' ),
			'heading' => __( 'Buying, selling, or both at once', 'wisebones-residential' ),
			'text'    => __( 'One team for the whole move — from the first showing to the keys.', 'wisebones-residential' ),
			'items'   => array(
				array( 'bi-house-heart', __( 'Buy a home', 'wisebones-residential' ), __( 'Private showings, offer strategy and negotiation that protects your budget.', 'wisebones-residential' ) ),
				array( 'bi-graph-up-arrow', __( 'Sell your home', 'wisebones-residential' ), __( 'Pricing from real comps, professional photos and a launch plan that draws offers.', 'wisebones-residential' ) ),
				array( 'bi-arrow-left-right', __( 'Relocation', 'wisebones-residential' ), __( 'Virtual tours, school and commute research, and closing on your schedule.', 'wisebones-residential' ) ),
				array( 'bi-building-up', __( 'Investment property', 'wisebones-residential' ), __( 'Rental comps, cash-flow estimates and off-market opportunities.', 'wisebones-residential' ) ),
				array( 'bi-key', __( 'First-time buyers', 'wisebones-residential' ), __( 'Down-payment programs, lender introductions and plain-language guidance.', 'wisebones-residential' ) ),
				array( 'bi-stars', __( 'Luxury homes', 'wisebones-residential' ), __( 'Discreet marketing, targeted buyer outreach and white-glove service.', 'wisebones-residential' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Thinking of selling?', 'wisebones-residential' ),
			'heading'   => __( 'Know what your home is worth — today', 'wisebones-residential' ),
			'text'      => __( 'Automated estimates miss what makes your home yours. Our agents prepare a free comparative market analysis using recent nearby sales and the upgrades you have made.', 'wisebones-residential' ),
			'points'    => array(
				array( __( 'Priced from real comps', 'wisebones-residential' ), __( 'Recent sales within your neighborhood, not a county-wide average.', 'wisebones-residential' ) ),
				array( __( 'A plan, not just a number', 'wisebones-residential' ), __( 'What to fix, what to skip, and when to list.', 'wisebones-residential' ) ),
				array( __( 'No obligation', 'wisebones-residential' ), __( 'Keep the report whether or not you list with us.', 'wisebones-residential' ) ),
			),
			'button'    => array( __( 'Request my home value', 'wisebones-residential' ), '/sell/' ),
			'highlight' => array(
				'icon'  => 'bi-clipboard-data',
				'title' => __( 'Free market analysis', 'wisebones-residential' ),
				'text'  => __( 'Delivered within one business day, with the comparable sales behind every figure.', 'wisebones-residential' ),
				'tags'  => array( __( 'Recent sales', 'wisebones-residential' ), __( 'Active competition', 'wisebones-residential' ), __( 'Price per sq ft', 'wisebones-residential' ), __( 'Days on market', 'wisebones-residential' ) ),
			),
		),
		'team'         => array(
			'eyebrow' => __( 'Our agents', 'wisebones-residential' ),
			'heading' => __( 'Neighbors first, agents second', 'wisebones-residential' ),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Client stories', 'wisebones-residential' ),
			'heading' => __( 'What our clients say', 'wisebones-residential' ),
			'samples' => array(
				array( __( 'They priced our home right the first time and we had three offers by Sunday.', 'wisebones-residential' ), __( 'Sample client', 'wisebones-residential' ), __( 'Sellers', 'wisebones-residential' ) ),
				array( __( 'As first-time buyers we had a hundred questions. Every one got a straight answer.', 'wisebones-residential' ), __( 'Sample client', 'wisebones-residential' ), __( 'First-time buyers', 'wisebones-residential' ) ),
				array( __( 'We bought from out of state on video tours alone. Closing was painless.', 'wisebones-residential' ), __( 'Sample client', 'wisebones-residential' ), __( 'Relocation', 'wisebones-residential' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Neighborhoods', 'wisebones-residential' ),
			'heading' => __( 'Where we sell', 'wisebones-residential' ),
			'text'    => __( 'Market snapshots, schools and local favorites for every neighborhood we serve.', 'wisebones-residential' ),
			'items'   => array( __( 'Downtown', 'wisebones-residential' ), __( 'Riverside', 'wisebones-residential' ), __( 'Hillcrest', 'wisebones-residential' ), __( 'Old Town', 'wisebones-residential' ), __( 'Lakeview', 'wisebones-residential' ), __( 'North Park', 'wisebones-residential' ), __( 'Westgate', 'wisebones-residential' ), __( 'Meadowbrook', 'wisebones-residential' ) ),
			'button'  => array( __( 'Explore neighborhoods', 'wisebones-residential' ), '/neighborhoods/' ),
		),
		'posts'        => array(
			'eyebrow' => __( 'Market insights', 'wisebones-residential' ),
			'heading' => __( 'From the blog', 'wisebones-residential' ),
		),
		'cta'          => array(
			'heading' => __( 'Ready to make a move?', 'wisebones-residential' ),
			'text'    => __( 'Tell us where you are headed and an agent will reach out within one business day.', 'wisebones-residential' ),
			'form'    => true,
			'button'  => array( __( 'Talk to an agent', 'wisebones-residential' ), '/contact/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'featured', 'services', 'values', 'team', 'testimonials', 'areas', 'posts', 'cta' ),

	'footer'        => array(
		'about'   => __( 'A local, independent real estate team helping buyers and sellers since day one.', 'wisebones-residential' ),
		'note'    => __( 'Equal Housing Opportunity. Listing information is deemed reliable but not guaranteed.', 'wisebones-residential' ),
		'columns' => array(
			__( 'Buy', 'wisebones-residential' )     => array(
				array( __( 'All listings', 'wisebones-residential' ), '/listings/' ),
				array( __( 'Neighborhoods', 'wisebones-residential' ), '/neighborhoods/' ),
				array( __( 'Buyer guide', 'wisebones-residential' ), '/buy/' ),
			),
			__( 'Sell', 'wisebones-residential' )    => array(
				array( __( 'Home value', 'wisebones-residential' ), '/sell/' ),
				array( __( 'Seller guide', 'wisebones-residential' ), '/sell/' ),
			),
			__( 'Company', 'wisebones-residential' ) => array(
				array( __( 'About', 'wisebones-residential' ), '/about/' ),
				array( __( 'Agents', 'wisebones-residential' ), '/team/' ),
				array( __( 'Contact', 'wisebones-residential' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'          => array( 'title' => __( 'Home', 'wisebones-residential' ) ),
			'buy'           => array(
				'title'   => __( 'Buy a Home', 'wisebones-residential' ),
				'content' => $wbr_p( __( 'Buying a home is the biggest purchase most people make. We start with what matters to you — commute, schools, space, budget — and build a search around it.', 'wisebones-residential' ) )
					. $wbr_h( __( 'Homes for sale', 'wisebones-residential' ) )
					. $wbr_code( '[wbik_listings status="for-sale,coming-soon" count="6"]' )
					. $wbr_h( __( 'Schedule a showing', 'wisebones-residential' ) )
					. $wbr_code( '[wbik_lead_form type="showing" title=""]' ),
			),
			'sell'          => array(
				'title'   => __( 'Sell Your Home', 'wisebones-residential' ),
				'content' => $wbr_p( __( 'Request a free comparative market analysis. An agent reviews recent nearby sales and your home\'s features, then sends a price range and a plan within one business day.', 'wisebones-residential' ) )
					. $wbr_code( '[wbik_lead_form type="valuation" title=""]' )
					. $wbr_h( __( 'Recently sold', 'wisebones-residential' ) )
					. $wbr_code( '[wbik_listings status="sold" count="3"]' ),
			),
			'neighborhoods' => array(
				'title'   => __( 'Neighborhoods', 'wisebones-residential' ),
				'content' => $wbr_p( __( 'Choose a neighborhood to see its listings and market snapshot.', 'wisebones-residential' ) ) . $wbr_code( '[wbik_areas]' ),
			),
			'about'         => array(
				'title'   => __( 'About Us', 'wisebones-residential' ),
				'content' => $wbr_p( __( 'Tell your story here: how long you have served the area, what makes your team different, and the designations your agents hold.', 'wisebones-residential' ) ) . $wbr_h( __( 'Our agents', 'wisebones-residential' ) ) . $wbr_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'       => array(
				'title'   => __( 'Contact', 'wisebones-residential' ),
				'content' => $wbr_p( __( 'Questions about a listing, a neighborhood or your home\'s value? Send a note and an agent will reply within one business day.', 'wisebones-residential' ) ) . $wbr_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'blog'          => array( 'title' => __( 'Market Insights', 'wisebones-residential' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-residential' ), '/' ),
			array( __( 'Listings', 'wisebones-residential' ), 'archive:listing' ),
			array( __( 'Buy', 'wisebones-residential' ), 'page:buy' ),
			array( __( 'Sell', 'wisebones-residential' ), 'page:sell' ),
			array( __( 'Neighborhoods', 'wisebones-residential' ), 'page:neighborhoods' ),
			array( __( 'About', 'wisebones-residential' ), 'page:about' ),
			array( __( 'Insights', 'wisebones-residential' ), 'page:blog' ),
			array( __( 'Contact', 'wisebones-residential' ), 'page:contact' ),
		),
		'terms' => array(
			'wbik_listing_type' => array( __( 'Single-family', 'wisebones-residential' ), __( 'Condo / townhome', 'wisebones-residential' ), __( 'Multi-family', 'wisebones-residential' ), __( 'Land', 'wisebones-residential' ) ),
		),
	),
);
