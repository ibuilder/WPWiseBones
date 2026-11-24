<?php
/**
 * WiseBones Trades — industry config, with one preset per trade.
 *
 * The trade is chosen in the Customizer (Theme Options → Trade, see
 * functions.php). Each preset swaps the label, schema.org type, brand colour,
 * hero copy, services and FAQ; the structure, sections and starter site are
 * shared. Read by the parent (wpwisebones/inc/industry.php) and by the
 * WiseBones Industry Kit. See child-themes/README.md.
 *
 * @package WiseBones_Trades
 */

defined( 'ABSPATH' ) || exit;

$wbtr_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbtr_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbtr_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

$wbtr_presets = array(
	'roofing'    => array(
		'label'    => __( 'Roofing Contractor', 'wisebones-trades' ),
		'schema'   => 'RoofingContractor',
		'primary'  => '#c62828',
		'trade'    => __( 'roofing', 'wisebones-trades' ),
		'heading'  => __( 'Roofs done right, the first time', 'wisebones-trades' ),
		'text'     => __( 'Repairs, replacements and storm-damage restoration from a licensed, insured local roofer — with a free, no-pressure inspection.', 'wisebones-trades' ),
		'urgent'   => __( 'Storm damage or an active leak? We tarp and secure roofs around the clock.', 'wisebones-trades' ),
		'services' => array(
			array( 'bi-house-fill', __( 'Roof replacement', 'wisebones-trades' ), __( 'Asphalt shingle, metal and tile roofs installed to manufacturer specification.', 'wisebones-trades' ) ),
			array( 'bi-tools', __( 'Roof repair', 'wisebones-trades' ), __( 'Leaks, missing shingles, flashing and vent boots fixed fast.', 'wisebones-trades' ) ),
			array( 'bi-cloud-lightning-rain', __( 'Storm damage', 'wisebones-trades' ), __( 'Emergency tarping, inspection reports and help with your insurance claim.', 'wisebones-trades' ) ),
			array( 'bi-search', __( 'Roof inspections', 'wisebones-trades' ), __( 'Photo-documented inspections for buyers, sellers and insurers.', 'wisebones-trades' ) ),
			array( 'bi-droplet-half', __( 'Gutters', 'wisebones-trades' ), __( 'Seamless gutters, guards and downspouts that move water away.', 'wisebones-trades' ) ),
			array( 'bi-building', __( 'Commercial roofing', 'wisebones-trades' ), __( 'Flat and low-slope systems, coatings and maintenance plans.', 'wisebones-trades' ) ),
		),
		'faq'      => array(
			array( __( 'Do you offer free roof inspections?', 'wisebones-trades' ), __( 'Yes. We inspect, photograph what we find and explain your options — repair or replace — with no obligation.', 'wisebones-trades' ) ),
			array( __( 'Will insurance cover my roof?', 'wisebones-trades' ), __( 'Storm and hail damage is often covered. We document the damage and can meet your adjuster on site.', 'wisebones-trades' ) ),
			array( __( 'How long does a roof replacement take?', 'wisebones-trades' ), __( 'Most homes are completed in one to three days, weather permitting.', 'wisebones-trades' ) ),
			array( __( 'What warranty do I get?', 'wisebones-trades' ), __( 'Manufacturer material warranties plus our own workmanship warranty. Ask for the details in writing.', 'wisebones-trades' ) ),
		),
	),
	'hvac'       => array(
		'label'    => __( 'HVAC Contractor', 'wisebones-trades' ),
		'schema'   => 'HVACBusiness',
		'primary'  => '#1565c0',
		'trade'    => __( 'heating and cooling', 'wisebones-trades' ),
		'heading'  => __( 'Comfort, restored today', 'wisebones-trades' ),
		'text'     => __( 'Heating and air-conditioning repair, replacement and maintenance from licensed technicians who show up on time and quote up front.', 'wisebones-trades' ),
		'urgent'   => __( 'No heat or no cooling? Call now for same-day emergency service.', 'wisebones-trades' ),
		'services' => array(
			array( 'bi-snow', __( 'AC repair', 'wisebones-trades' ), __( 'Fast diagnosis and repair for every major brand.', 'wisebones-trades' ) ),
			array( 'bi-fire', __( 'Furnace & heating', 'wisebones-trades' ), __( 'Furnaces, boilers and heat pumps repaired or replaced.', 'wisebones-trades' ) ),
			array( 'bi-thermometer-half', __( 'System replacement', 'wisebones-trades' ), __( 'Right-sized, high-efficiency systems with clear options and pricing.', 'wisebones-trades' ) ),
			array( 'bi-calendar-check', __( 'Maintenance plans', 'wisebones-trades' ), __( 'Seasonal tune-ups that prevent breakdowns and protect warranties.', 'wisebones-trades' ) ),
			array( 'bi-wind', __( 'Indoor air quality', 'wisebones-trades' ), __( 'Filtration, humidity control and duct cleaning.', 'wisebones-trades' ) ),
			array( 'bi-cpu', __( 'Smart thermostats', 'wisebones-trades' ), __( 'Installation and setup for connected thermostats and zoning.', 'wisebones-trades' ) ),
		),
		'faq'      => array(
			array( __( 'How often should my system be serviced?', 'wisebones-trades' ), __( 'Once before the cooling season and once before the heating season keeps most systems efficient and reliable.', 'wisebones-trades' ) ),
			array( __( 'Repair or replace?', 'wisebones-trades' ), __( 'We weigh age, repair cost and efficiency, and give you both options in writing.', 'wisebones-trades' ) ),
			array( __( 'Do you offer financing?', 'wisebones-trades' ), __( 'Financing may be available on new systems, subject to credit approval. Ask your technician.', 'wisebones-trades' ) ),
			array( __( 'Do you charge extra for nights and weekends?', 'wisebones-trades' ), __( 'Explain your after-hours rates here so customers know before they call.', 'wisebones-trades' ) ),
		),
	),
	'plumbing'   => array(
		'label'    => __( 'Plumbing Contractor', 'wisebones-trades' ),
		'schema'   => 'Plumber',
		'primary'  => '#00838f',
		'trade'    => __( 'plumbing', 'wisebones-trades' ),
		'heading'  => __( 'Fast, honest plumbing', 'wisebones-trades' ),
		'text'     => __( 'Leaks, drains, water heaters and repipes handled by licensed plumbers with upfront pricing and clean work areas.', 'wisebones-trades' ),
		'urgent'   => __( 'Burst pipe or backed-up drain? Our emergency plumbers are on call.', 'wisebones-trades' ),
		'services' => array(
			array( 'bi-droplet', __( 'Leak repair', 'wisebones-trades' ), __( 'Pinpoint leak detection and repair with minimal disruption.', 'wisebones-trades' ) ),
			array( 'bi-funnel', __( 'Drain cleaning', 'wisebones-trades' ), __( 'Clogs cleared and camera inspections to find the cause.', 'wisebones-trades' ) ),
			array( 'bi-thermometer-high', __( 'Water heaters', 'wisebones-trades' ), __( 'Tank and tankless water heaters repaired and installed.', 'wisebones-trades' ) ),
			array( 'bi-bezier2', __( 'Repiping', 'wisebones-trades' ), __( 'Whole-home repipes to replace aging or failing lines.', 'wisebones-trades' ) ),
			array( 'bi-water', __( 'Sewer lines', 'wisebones-trades' ), __( 'Sewer repair and trenchless replacement options.', 'wisebones-trades' ) ),
			array( 'bi-house-gear', __( 'Fixtures', 'wisebones-trades' ), __( 'Faucets, toilets, disposals and shower valves installed right.', 'wisebones-trades' ) ),
		),
		'faq'      => array(
			array( __( 'Do you charge for estimates?', 'wisebones-trades' ), __( 'Explain your trip and diagnostic fees here. Every repair is priced before work starts.', 'wisebones-trades' ) ),
			array( __( 'What should I do while waiting for an emergency plumber?', 'wisebones-trades' ), __( 'Shut off the main water valve and switch off the water heater if a supply line has burst.', 'wisebones-trades' ) ),
			array( __( 'Tank or tankless water heater?', 'wisebones-trades' ), __( 'Tankless saves space and energy; tanks cost less up front. We will size either to your household.', 'wisebones-trades' ) ),
			array( __( 'Are your plumbers licensed?', 'wisebones-trades' ), __( 'Yes. Add your license number on Settings → Industry Kit so it appears in your business details.', 'wisebones-trades' ) ),
		),
	),
	'electrical' => array(
		'label'    => __( 'Electrical Contractor', 'wisebones-trades' ),
		'schema'   => 'Electrician',
		'primary'  => '#e65100',
		'trade'    => __( 'electrical', 'wisebones-trades' ),
		'heading'  => __( 'Safe, code-compliant electrical work', 'wisebones-trades' ),
		'text'     => __( 'Panel upgrades, EV chargers, lighting and repairs from licensed electricians who pull the permits and pass the inspections.', 'wisebones-trades' ),
		'urgent'   => __( 'Sparking outlet or power out? Our electricians respond to emergencies around the clock.', 'wisebones-trades' ),
		'services' => array(
			array( 'bi-lightning-charge', __( 'Panel upgrades', 'wisebones-trades' ), __( 'Service upgrades for modern loads, additions and EVs.', 'wisebones-trades' ) ),
			array( 'bi-ev-station', __( 'EV chargers', 'wisebones-trades' ), __( 'Level 2 charger installation with load calculations and permits.', 'wisebones-trades' ) ),
			array( 'bi-lightbulb', __( 'Lighting', 'wisebones-trades' ), __( 'Recessed, landscape and smart lighting designed and installed.', 'wisebones-trades' ) ),
			array( 'bi-plug', __( 'Repairs & troubleshooting', 'wisebones-trades' ), __( 'Tripping breakers, dead outlets and flickering lights traced and fixed.', 'wisebones-trades' ) ),
			array( 'bi-battery-charging', __( 'Generators', 'wisebones-trades' ), __( 'Standby generators and transfer switches for backup power.', 'wisebones-trades' ) ),
			array( 'bi-shield-check', __( 'Safety inspections', 'wisebones-trades' ), __( 'Whole-home inspections for buyers, sellers and older homes.', 'wisebones-trades' ) ),
		),
		'faq'      => array(
			array( __( 'Do I need a permit for electrical work?', 'wisebones-trades' ), __( 'Most panel, circuit and charger work does. We pull the permit and schedule the inspection.', 'wisebones-trades' ) ),
			array( __( 'Can my panel handle an EV charger?', 'wisebones-trades' ), __( 'We run a load calculation first; many homes can add a charger without a full upgrade.', 'wisebones-trades' ) ),
			array( __( 'Why do my breakers keep tripping?', 'wisebones-trades' ), __( 'Usually an overloaded circuit or a fault. Stop resetting it and have it checked.', 'wisebones-trades' ) ),
			array( __( 'Are you licensed and insured?', 'wisebones-trades' ), __( 'Yes. Add your license number on Settings → Industry Kit so it appears in your business details.', 'wisebones-trades' ) ),
		),
	),
);

$wbtr_key    = (string) get_theme_mod( 'wisebones_trades_preset', 'roofing' );
$wbtr_preset = isset( $wbtr_presets[ $wbtr_key ] ) ? $wbtr_presets[ $wbtr_key ] : $wbtr_presets['roofing'];

return array(
	'id'            => 'trades',
	'family'        => 'construction',
	'label'         => $wbtr_preset['label'],
	'schema'        => $wbtr_preset['schema'],
	'content_types' => array( 'service', 'testimonial', 'team', 'project' ),
	'labels'        => array(
		'project' => array( __( 'Recent jobs', 'wisebones-trades' ), __( 'Job', 'wisebones-trades' ) ),
	),
	'lead_type'     => 'quote',
	'colors'        => array(
		'primary'   => $wbtr_preset['primary'],
		'secondary' => '#5c5c5c',
		'accent'    => '#ffb300',
		'header_bg' => '#ffffff',
		'footer_bg' => '#111111',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Free estimate', 'wisebones-trades' ), '/estimate/', 'bi-clipboard-check' ),

	'hero'          => array(
		'style'     => 'blueprint',
		'eyebrow'   => __( '24/7 emergency service', 'wisebones-trades' ),
		'heading'   => $wbtr_preset['heading'],
		'text'      => $wbtr_preset['text'],
		'primary'   => array( __( 'Get a free estimate', 'wisebones-trades' ), '/estimate/' ),
		'secondary' => array( __( 'Emergency service', 'wisebones-trades' ), '/emergency/' ),
		'badges'    => array( __( 'Licensed & insured', 'wisebones-trades' ), __( 'Upfront pricing', 'wisebones-trades' ), __( 'Workmanship warranty', 'wisebones-trades' ) ),
		'panel'     => 'quote',
		'quote'     => array(
			'title'  => __( 'Request a free estimate', 'wisebones-trades' ),
			'text'   => $wbtr_preset['urgent'],
			'points' => array( __( 'Fast response, day or night', 'wisebones-trades' ), __( 'Written price before work starts', 'wisebones-trades' ), __( 'Clean, respectful technicians', 'wisebones-trades' ) ),
			'button' => array( __( 'Get my estimate', 'wisebones-trades' ), '/estimate/' ),
		),
	),

	'stats'         => array(
		array( __( '24/7', 'wisebones-trades' ), __( 'Emergency response', 'wisebones-trades' ) ),
		array( __( 'Licensed', 'wisebones-trades' ), __( 'And fully insured', 'wisebones-trades' ) ),
		array( __( 'Upfront', 'wisebones-trades' ), __( 'Written pricing', 'wisebones-trades' ) ),
		array( __( 'Local', 'wisebones-trades' ), __( 'Crews who live nearby', 'wisebones-trades' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'Services', 'wisebones-trades' ),
			/* translators: %s: trade, e.g. "roofing". */
			'heading' => sprintf( __( 'Complete %s services', 'wisebones-trades' ), $wbtr_preset['trade'] ),
			'text'    => __( 'Residential and light commercial work, done to code and backed in writing.', 'wisebones-trades' ),
			'items'   => $wbtr_preset['services'],
			'button'  => array( __( 'All services', 'wisebones-trades' ), '/services/' ),
		),
		'values'       => array(
			'eyebrow'   => __( 'Our commitments', 'wisebones-trades' ),
			'heading'   => __( 'Work you never have to worry about', 'wisebones-trades' ),
			'text'      => __( 'The promises we make on every job, large or small.', 'wisebones-trades' ),
			'points'    => array(
				array( __( 'Licensed and insured', 'wisebones-trades' ), __( 'Proof of license and coverage on request, before we start.', 'wisebones-trades' ) ),
				array( __( 'Price before work', 'wisebones-trades' ), __( 'You approve a written estimate. No surprise charges.', 'wisebones-trades' ) ),
				array( __( 'Workmanship warranty', 'wisebones-trades' ), __( 'If something we did is not right, we come back and fix it.', 'wisebones-trades' ) ),
			),
			'button'    => array( __( 'Get a free estimate', 'wisebones-trades' ), '/estimate/' ),
			'highlight' => array(
				'icon'  => 'bi-patch-check',
				'title' => __( 'The right tech, the first time', 'wisebones-trades' ),
				'text'  => __( 'Background-checked technicians with fully stocked trucks, so most jobs finish in one visit.', 'wisebones-trades' ),
				'tags'  => array( __( 'Background-checked', 'wisebones-trades' ), __( 'Shoe covers & drop cloths', 'wisebones-trades' ), __( 'Photo reports', 'wisebones-trades' ), __( 'Permits handled', 'wisebones-trades' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How it works', 'wisebones-trades' ),
			'heading' => __( 'Simple from the first call', 'wisebones-trades' ),
			'steps'   => array(
				array( __( 'Call or request', 'wisebones-trades' ), __( 'Tell us what is going on, online or by phone.', 'wisebones-trades' ) ),
				array( __( 'Inspect & quote', 'wisebones-trades' ), __( 'A technician diagnoses the problem and gives a written price.', 'wisebones-trades' ) ),
				array( __( 'Fix it right', 'wisebones-trades' ), __( 'Work done to code, cleaned up, and walked through with you.', 'wisebones-trades' ) ),
			),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Reviews', 'wisebones-trades' ),
			'heading' => __( 'What our customers say', 'wisebones-trades' ),
			'samples' => array(
				array( __( 'They came out the same night and had everything secured before the rain hit again.', 'wisebones-trades' ), __( 'Sample client', 'wisebones-trades' ), __( 'Emergency call', 'wisebones-trades' ) ),
				array( __( 'The price on the estimate was the price on the invoice. Refreshing.', 'wisebones-trades' ), __( 'Sample client', 'wisebones-trades' ), __( 'Homeowner', 'wisebones-trades' ) ),
				array( __( 'Polite, tidy and explained every option without a hard sell.', 'wisebones-trades' ), __( 'Sample client', 'wisebones-trades' ), __( 'Homeowner', 'wisebones-trades' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Service area', 'wisebones-trades' ),
			'heading' => __( 'Proudly serving', 'wisebones-trades' ),
			'text'    => __( 'Fast response times across the area. Not sure if we cover you? Just ask.', 'wisebones-trades' ),
			'items'   => array( __( 'Downtown', 'wisebones-trades' ), __( 'North Side', 'wisebones-trades' ), __( 'South Side', 'wisebones-trades' ), __( 'Eastview', 'wisebones-trades' ), __( 'West Hills', 'wisebones-trades' ), __( 'Lakeside', 'wisebones-trades' ), __( 'Countryside', 'wisebones-trades' ) ),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-trades' ),
			'heading' => __( 'Common questions', 'wisebones-trades' ),
			'items'   => $wbtr_preset['faq'],
		),
		'cta'          => array(
			'heading' => __( 'Need help today?', 'wisebones-trades' ),
			'text'    => __( 'Request your free estimate and we will call you back fast — or call now for emergencies.', 'wisebones-trades' ),
			'form'    => true,
			'button'  => array( __( 'Get a free estimate', 'wisebones-trades' ), '/estimate/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'values', 'process', 'testimonials', 'areas', 'faq', 'cta' ),

	'footer'        => array(
		/* translators: %s: trade, e.g. "roofing". */
		'about'   => sprintf( __( 'Licensed, insured local %s contractor. Emergency service available around the clock.', 'wisebones-trades' ), $wbtr_preset['trade'] ),
		'note'    => __( 'Add your contractor license number here.', 'wisebones-trades' ),
		'columns' => array(
			__( 'Services', 'wisebones-trades' ) => array(
				array( __( 'All services', 'wisebones-trades' ), '/services/' ),
				array( __( 'Emergency service', 'wisebones-trades' ), '/emergency/' ),
				array( __( 'Free estimate', 'wisebones-trades' ), '/estimate/' ),
			),
			__( 'Company', 'wisebones-trades' )  => array(
				array( __( 'About', 'wisebones-trades' ), '/about/' ),
				array( __( 'Blog', 'wisebones-trades' ), '/blog/' ),
				array( __( 'Contact', 'wisebones-trades' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'      => array( 'title' => __( 'Home', 'wisebones-trades' ) ),
			'services'  => array(
				'title'   => __( 'Services', 'wisebones-trades' ),
				'content' => $wbtr_p( __( 'Everything we do, with starting prices where they help customers decide.', 'wisebones-trades' ) ) . $wbtr_code( '[wbik_services count="12"]' ),
			),
			'estimate'  => array(
				'title'   => __( 'Free Estimate', 'wisebones-trades' ),
				'content' => $wbtr_p( __( 'Tell us about the job and we will call you back to schedule a visit.', 'wisebones-trades' ) ) . $wbtr_code( '[wbik_lead_form type="quote" title=""]' ),
			),
			'emergency' => array(
				'title'   => __( 'Emergency Service', 'wisebones-trades' ),
				'content' => $wbtr_p( $wbtr_preset['urgent'] ) . $wbtr_p( __( 'For the fastest response, call us. Add your emergency phone number in the Customizer (Theme Options → Front Page Sections).', 'wisebones-trades' ) ) . $wbtr_code( '[wbik_lead_form type="quote" compact="1" title=""]' ),
			),
			'about'     => array(
				'title'   => __( 'About Us', 'wisebones-trades' ),
				'content' => $wbtr_p( __( 'Tell your story: how long you have served the area, your licensing, and what customers can expect.', 'wisebones-trades' ) ) . $wbtr_h( __( 'Our team', 'wisebones-trades' ) ) . $wbtr_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'   => array(
				'title'   => __( 'Contact', 'wisebones-trades' ),
				'content' => $wbtr_p( __( 'Questions, scheduling or billing — send a note and we will get back to you.', 'wisebones-trades' ) ) . $wbtr_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'blog'      => array( 'title' => __( 'Blog', 'wisebones-trades' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-trades' ), '/' ),
			array( __( 'Services', 'wisebones-trades' ), 'page:services' ),
			array( __( 'Emergency', 'wisebones-trades' ), 'page:emergency' ),
			array( __( 'Recent Jobs', 'wisebones-trades' ), 'archive:project' ),
			array( __( 'About', 'wisebones-trades' ), 'page:about' ),
			array( __( 'Blog', 'wisebones-trades' ), 'page:blog' ),
			array( __( 'Contact', 'wisebones-trades' ), 'page:contact' ),
		),
	),
);
