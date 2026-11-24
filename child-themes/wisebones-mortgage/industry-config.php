<?php
/**
 * WiseBones Mortgage — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. The hero calculator works out an estimate in the browser; no
 * rates are stated as fact anywhere in this config. Add your NMLS ID and
 * licensing disclosures before launch. See child-themes/README.md.
 *
 * @package WiseBones_Mortgage
 */

defined( 'ABSPATH' ) || exit;

$wbm_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbm_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbm_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'mortgage',
	'family'        => 'real-estate',
	'label'         => __( 'Mortgage Lender', 'wisebones-mortgage' ),
	'schema'        => 'FinancialService',
	'content_types' => array( 'service', 'team', 'testimonial' ),
	'labels'        => array(
		'team' => array( __( 'Loan officers', 'wisebones-mortgage' ), __( 'Loan officer', 'wisebones-mortgage' ) ),
	),
	'lead_type'     => 'prequal',
	'colors'        => array(
		'primary'   => '#4a3aa8',
		'secondary' => '#5f5b78',
		'accent'    => '#16b39b',
		'header_bg' => '#ffffff',
		'footer_bg' => '#17123d',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Get pre-qualified', 'wisebones-mortgage' ), '/apply/', 'bi-check2-circle' ),

	'hero'          => array(
		'style'      => 'glow',
		'eyebrow'    => __( 'Home loans, explained', 'wisebones-mortgage' ),
		'heading'    => __( 'The right mortgage starts with a clear answer', 'wisebones-mortgage' ),
		'text'       => __( 'Compare loan programs, estimate your payment and get pre-qualified with a loan officer who walks you through every number.', 'wisebones-mortgage' ),
		'primary'    => array( __( 'Get pre-qualified', 'wisebones-mortgage' ), '/apply/' ),
		'secondary'  => array( __( 'Explore loan programs', 'wisebones-mortgage' ), '/loan-programs/' ),
		'badges'     => array( __( 'Purchase & refinance', 'wisebones-mortgage' ), __( 'First-time buyer programs', 'wisebones-mortgage' ) ),
		'panel'      => 'calculator',
		'calculator' => array(
			'button' => array( __( 'Get pre-qualified', 'wisebones-mortgage' ), '/apply/' ),
		),
	),

	'stats'         => array(
		array( __( 'Purchase', 'wisebones-mortgage' ), __( 'Buy your next home', 'wisebones-mortgage' ) ),
		array( __( 'Refinance', 'wisebones-mortgage' ), __( 'Lower payment or cash out', 'wisebones-mortgage' ) ),
		array( __( 'Local', 'wisebones-mortgage' ), __( 'Loan officers you can meet', 'wisebones-mortgage' ) ),
		array( __( 'Online', 'wisebones-mortgage' ), __( 'Secure document upload', 'wisebones-mortgage' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'Loan programs', 'wisebones-mortgage' ),
			'heading' => __( 'A loan for every kind of buyer', 'wisebones-mortgage' ),
			'text'    => __( 'We compare programs side by side so you can choose with confidence.', 'wisebones-mortgage' ),
			'items'   => array(
				array( 'bi-house', __( 'Conventional', 'wisebones-mortgage' ), __( 'Fixed and adjustable options for buyers with solid credit and a down payment.', 'wisebones-mortgage' ) ),
				array( 'bi-key', __( 'FHA', 'wisebones-mortgage' ), __( 'Flexible credit guidelines and a lower down payment for many first-time buyers.', 'wisebones-mortgage' ) ),
				array( 'bi-shield-check', __( 'VA', 'wisebones-mortgage' ), __( 'For eligible veterans and service members, often with no down payment.', 'wisebones-mortgage' ) ),
				array( 'bi-tree', __( 'USDA', 'wisebones-mortgage' ), __( 'Financing for eligible homes in qualifying rural and suburban areas.', 'wisebones-mortgage' ) ),
				array( 'bi-gem', __( 'Jumbo', 'wisebones-mortgage' ), __( 'Loans above conforming limits for higher-priced homes.', 'wisebones-mortgage' ) ),
				array( 'bi-arrow-repeat', __( 'Refinance', 'wisebones-mortgage' ), __( 'Change your rate or term, or take cash out for other goals.', 'wisebones-mortgage' ) ),
				array( 'bi-bank', __( 'HELOC', 'wisebones-mortgage' ), __( 'A line of credit against your home equity for renovations or other needs.', 'wisebones-mortgage' ) ),
				array( 'bi-hammer', __( 'Renovation', 'wisebones-mortgage' ), __( 'Finance the purchase and the improvements in one loan.', 'wisebones-mortgage' ) ),
				array( 'bi-building', __( 'Investment property', 'wisebones-mortgage' ), __( 'Financing for rentals and second homes.', 'wisebones-mortgage' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Why borrowers choose us', 'wisebones-mortgage' ),
			'heading'   => __( 'Straight answers, start to close', 'wisebones-mortgage' ),
			'text'      => __( 'A mortgage is a long commitment. You deserve to understand every fee, every option and every step.', 'wisebones-mortgage' ),
			'points'    => array(
				array( __( 'Options side by side', 'wisebones-mortgage' ), __( 'We show you the trade-offs between programs, not just one quote.', 'wisebones-mortgage' ) ),
				array( __( 'Clear costs', 'wisebones-mortgage' ), __( 'Your Loan Estimate is walked through line by line.', 'wisebones-mortgage' ) ),
				array( __( 'Updates without asking', 'wisebones-mortgage' ), __( 'You, your agent and your title company hear from us at every milestone.', 'wisebones-mortgage' ) ),
			),
			'button'    => array( __( 'Start my pre-qualification', 'wisebones-mortgage' ), '/apply/' ),
			'highlight' => array(
				'icon'  => 'bi-file-earmark-check',
				'title' => __( 'Pre-qualified before you shop', 'wisebones-mortgage' ),
				'text'  => __( 'Know your budget and make offers sellers take seriously.', 'wisebones-mortgage' ),
				'tags'  => array( __( 'Budget', 'wisebones-mortgage' ), __( 'Programs', 'wisebones-mortgage' ), __( 'Closing costs', 'wisebones-mortgage' ), __( 'Next steps', 'wisebones-mortgage' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How it works', 'wisebones-mortgage' ),
			'heading' => __( 'From application to closing table', 'wisebones-mortgage' ),
			'steps'   => array(
				array( __( 'Apply', 'wisebones-mortgage' ), __( 'A short conversation or online form about your goals.', 'wisebones-mortgage' ) ),
				array( __( 'Documents', 'wisebones-mortgage' ), __( 'Upload income and asset documents securely.', 'wisebones-mortgage' ) ),
				array( __( 'Underwriting', 'wisebones-mortgage' ), __( 'We work through conditions and keep you posted.', 'wisebones-mortgage' ) ),
				array( __( 'Close', 'wisebones-mortgage' ), __( 'Sign, fund and get your keys.', 'wisebones-mortgage' ) ),
			),
		),
		'team'         => array(
			'eyebrow' => __( 'Loan officers', 'wisebones-mortgage' ),
			'heading' => __( 'Meet your lending team', 'wisebones-mortgage' ),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Borrower stories', 'wisebones-mortgage' ),
			'heading' => __( 'What borrowers say', 'wisebones-mortgage' ),
			'samples' => array(
				array( __( 'Our loan officer explained every option and we closed on time.', 'wisebones-mortgage' ), __( 'Sample client', 'wisebones-mortgage' ), __( 'First-time buyers', 'wisebones-mortgage' ) ),
				array( __( 'The refinance was simple and the communication was constant.', 'wisebones-mortgage' ), __( 'Sample client', 'wisebones-mortgage' ), __( 'Refinance', 'wisebones-mortgage' ) ),
				array( __( 'They made the VA process easy to understand.', 'wisebones-mortgage' ), __( 'Sample client', 'wisebones-mortgage' ), __( 'VA purchase', 'wisebones-mortgage' ) ),
			),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-mortgage' ),
			'heading' => __( 'Mortgage questions, answered', 'wisebones-mortgage' ),
			'items'   => array(
				array( __( 'What is the difference between pre-qualification and pre-approval?', 'wisebones-mortgage' ), __( 'Pre-qualification is an early estimate based on what you tell us. Pre-approval follows a review of your documents and credit, and carries more weight with sellers.', 'wisebones-mortgage' ) ),
				array( __( 'How much do I need for a down payment?', 'wisebones-mortgage' ), __( 'It depends on the program. Some options allow a small down payment or none for eligible borrowers; your loan officer will compare them for you.', 'wisebones-mortgage' ) ),
				array( __( 'Will checking my options affect my credit?', 'wisebones-mortgage' ), __( 'Explain your credit-check practice here, for example whether an initial conversation uses a soft inquiry.', 'wisebones-mortgage' ) ),
				array( __( 'Is the calculator a quote?', 'wisebones-mortgage' ), __( 'No. It estimates principal and interest only. Your actual rate, taxes, insurance and fees determine your real payment.', 'wisebones-mortgage' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Ready to see what you qualify for?', 'wisebones-mortgage' ),
			'text'    => __( 'Answer a few questions and a loan officer will follow up within one business day.', 'wisebones-mortgage' ),
			'form'    => true,
			'button'  => array( __( 'Get pre-qualified', 'wisebones-mortgage' ), '/apply/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'values', 'process', 'team', 'testimonials', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'Purchase and refinance loans with local loan officers and clear answers.', 'wisebones-mortgage' ),
		'note'    => __( 'Equal Housing Lender. Add your NMLS ID and licensing disclosures here. This site is not a commitment to lend.', 'wisebones-mortgage' ),
		'columns' => array(
			__( 'Loans', 'wisebones-mortgage' )   => array(
				array( __( 'Loan programs', 'wisebones-mortgage' ), '/loan-programs/' ),
				array( __( 'Get pre-qualified', 'wisebones-mortgage' ), '/apply/' ),
			),
			__( 'Learn', 'wisebones-mortgage' )   => array(
				array( __( 'Blog', 'wisebones-mortgage' ), '/blog/' ),
				array( __( 'Loan officers', 'wisebones-mortgage' ), '/loan-officers/' ),
			),
			__( 'Company', 'wisebones-mortgage' ) => array(
				array( __( 'About', 'wisebones-mortgage' ), '/about/' ),
				array( __( 'Licensing', 'wisebones-mortgage' ), '/about/' ),
				array( __( 'Contact', 'wisebones-mortgage' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'          => array( 'title' => __( 'Home', 'wisebones-mortgage' ) ),
			'loan-programs' => array(
				'title'   => __( 'Loan Programs', 'wisebones-mortgage' ),
				'content' => $wbm_p( __( 'Every borrower is different. Compare the programs below, then talk with a loan officer about which fits your goals.', 'wisebones-mortgage' ) ) . $wbm_code( '[wbik_services count="12"]' ),
			),
			'apply'         => array(
				'title'   => __( 'Get Pre-Qualified', 'wisebones-mortgage' ),
				'content' => $wbm_p( __( 'Tell us a little about your plans. A loan officer will review your options and follow up within one business day.', 'wisebones-mortgage' ) ) . $wbm_code( '[wbik_lead_form type="prequal" title=""]' ),
			),
			'about'         => array(
				'title'   => __( 'About Us', 'wisebones-mortgage' ),
				'content' => $wbm_p( __( 'Tell your story here, and add your company NMLS ID, state licenses and required disclosures.', 'wisebones-mortgage' ) ) . $wbm_h( __( 'Our loan officers', 'wisebones-mortgage' ) ) . $wbm_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'       => array(
				'title'   => __( 'Contact', 'wisebones-mortgage' ),
				'content' => $wbm_p( __( 'Questions about a loan program or an application in progress? Send a note and we will reply within one business day.', 'wisebones-mortgage' ) ) . $wbm_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'blog'          => array( 'title' => __( 'Blog', 'wisebones-mortgage' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-mortgage' ), '/' ),
			array( __( 'Loan programs', 'wisebones-mortgage' ), 'page:loan-programs' ),
			array( __( 'Loan officers', 'wisebones-mortgage' ), 'archive:team' ),
			array( __( 'About', 'wisebones-mortgage' ), 'page:about' ),
			array( __( 'Blog', 'wisebones-mortgage' ), 'page:blog' ),
			array( __( 'Contact', 'wisebones-mortgage' ), 'page:contact' ),
			array( __( 'Apply', 'wisebones-mortgage' ), 'page:apply' ),
		),
	),
);
