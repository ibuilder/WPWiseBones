<?php
/**
 * WiseBones Title & Escrow — industry config.
 *
 * Read by the parent (wpwisebones/inc/industry.php) to build the front page,
 * and by the WiseBones Industry Kit to choose content types and build the
 * starter site. The default lead form opens a title / escrow order. See
 * child-themes/README.md.
 *
 * @package WiseBones_Title_Escrow
 */

defined( 'ABSPATH' ) || exit;

$wbte_p    = static function ( $text ) {
	return '<!-- wp:paragraph --><p>' . esc_html( $text ) . '</p><!-- /wp:paragraph -->';
};
$wbte_h    = static function ( $text ) {
	return '<!-- wp:heading --><h2 class="wp-block-heading">' . esc_html( $text ) . '</h2><!-- /wp:heading -->';
};
$wbte_code = static function ( $code ) {
	return '<!-- wp:shortcode -->' . $code . '<!-- /wp:shortcode -->';
};

return array(
	'id'            => 'title-escrow',
	'family'        => 'real-estate',
	'label'         => __( 'Title & Escrow', 'wisebones-title-escrow' ),
	'schema'        => 'ProfessionalService',
	'content_types' => array( 'service', 'team', 'testimonial' ),
	'lead_type'     => 'order',
	'colors'        => array(
		'primary'   => '#7b2440',
		'secondary' => '#6a5a60',
		'accent'    => '#c8a165',
		'header_bg' => '#ffffff',
		'footer_bg' => '#2a0c16',
	),
	'header_style'  => 'light',
	'header_cta'    => array( __( 'Open an order', 'wisebones-title-escrow' ), '/open-an-order/', 'bi-folder-plus' ),

	'hero'          => array(
		'style'     => 'gradient',
		'eyebrow'   => __( 'Title insurance · Escrow · Settlement', 'wisebones-title-escrow' ),
		'heading'   => __( 'Closings that stay on schedule', 'wisebones-title-escrow' ),
		'text'      => __( 'Title search, escrow and settlement for agents, lenders, buyers and sellers — with clear communication from order to recording.', 'wisebones-title-escrow' ),
		'primary'   => array( __( 'Open an order', 'wisebones-title-escrow' ), '/open-an-order/' ),
		'secondary' => array( __( 'Our services', 'wisebones-title-escrow' ), '/services/' ),
		'badges'    => array( __( 'Residential & commercial', 'wisebones-title-escrow' ), __( 'Secure wire verification', 'wisebones-title-escrow' ) ),
		'panel'     => 'card',
		'card'      => array(
			'kicker' => __( 'Your closing, step by step', 'wisebones-title-escrow' ),
			'title'  => __( 'Closing checklist', 'wisebones-title-escrow' ),
			'rows'   => array(
				array( __( 'Order opened', 'wisebones-title-escrow' ), __( 'Contract & earnest money', 'wisebones-title-escrow' ), 'bi-folder-check' ),
				array( __( 'Title search', 'wisebones-title-escrow' ), __( 'Commitment issued', 'wisebones-title-escrow' ), 'bi-search' ),
				array( __( 'Payoffs & approvals', 'wisebones-title-escrow' ), __( 'Lender & HOA', 'wisebones-title-escrow' ), 'bi-check2-square' ),
				array( __( 'Signing', 'wisebones-title-escrow' ), __( 'In office or mobile', 'wisebones-title-escrow' ), 'bi-pen' ),
				array( __( 'Funding & recording', 'wisebones-title-escrow' ), __( 'Keys handed over', 'wisebones-title-escrow' ), 'bi-key' ),
			),
			'button' => array( __( 'Open an order', 'wisebones-title-escrow' ), '/open-an-order/' ),
		),
	),

	'stats'         => array(
		array( __( 'Residential', 'wisebones-title-escrow' ), __( 'Purchases and refinances', 'wisebones-title-escrow' ) ),
		array( __( 'Commercial', 'wisebones-title-escrow' ), __( 'Complex and multi-party deals', 'wisebones-title-escrow' ) ),
		array( __( 'Mobile', 'wisebones-title-escrow' ), __( 'Signings where you are', 'wisebones-title-escrow' ) ),
		array( __( 'Secure', 'wisebones-title-escrow' ), __( 'Verified wire instructions', 'wisebones-title-escrow' ) ),
	),

	'sections'      => array(
		'services'     => array(
			'eyebrow' => __( 'Services', 'wisebones-title-escrow' ),
			'heading' => __( 'Built around everyone at the closing table', 'wisebones-title-escrow' ),
			'text'    => __( 'One coordinated team for every party in the transaction.', 'wisebones-title-escrow' ),
			'items'   => array(
				array( 'bi-person-badge', __( 'For real estate agents', 'wisebones-title-escrow' ), __( 'Fast commitments, proactive updates and closings your clients remember.', 'wisebones-title-escrow' ) ),
				array( 'bi-bank', __( 'For lenders', 'wisebones-title-escrow' ), __( 'Accurate closing disclosures and timely funding and recording.', 'wisebones-title-escrow' ) ),
				array( 'bi-house-heart', __( 'For buyers', 'wisebones-title-escrow' ), __( 'Owner\'s title insurance and a clear explanation of every document you sign.', 'wisebones-title-escrow' ) ),
				array( 'bi-signpost', __( 'For sellers', 'wisebones-title-escrow' ), __( 'Payoffs, lien releases and proceeds handled carefully and on time.', 'wisebones-title-escrow' ) ),
				array( 'bi-arrow-left-right', __( '1031 exchanges', 'wisebones-title-escrow' ), __( 'Coordination with your qualified intermediary on both sides of the exchange.', 'wisebones-title-escrow' ) ),
				array( 'bi-buildings', __( 'Commercial closings', 'wisebones-title-escrow' ), __( 'Multi-parcel, multi-party and construction transactions.', 'wisebones-title-escrow' ) ),
			),
		),
		'values'       => array(
			'eyebrow'   => __( 'Your money, protected', 'wisebones-title-escrow' ),
			'heading'   => __( 'We take wire fraud seriously', 'wisebones-title-escrow' ),
			'text'      => __( 'Criminals target real estate closings with fake wiring instructions. Our procedures are designed to stop them.', 'wisebones-title-escrow' ),
			'points'    => array(
				array( __( 'We never change wire instructions by email', 'wisebones-title-escrow' ), __( 'Any message saying otherwise is a red flag.', 'wisebones-title-escrow' ) ),
				array( __( 'Verify by phone', 'wisebones-title-escrow' ), __( 'Call us at a number you already know before sending funds.', 'wisebones-title-escrow' ) ),
				array( __( 'Secure document delivery', 'wisebones-title-escrow' ), __( 'Sensitive files are shared through an encrypted portal.', 'wisebones-title-escrow' ) ),
			),
			'button'    => array( __( 'Wire fraud guidance', 'wisebones-title-escrow' ), '/wire-fraud/' ),
			'highlight' => array(
				'icon'  => 'bi-shield-lock',
				'title' => __( 'Call before you wire', 'wisebones-title-escrow' ),
				'text'  => __( 'Always confirm wiring instructions by phone with your escrow officer, using a verified number.', 'wisebones-title-escrow' ),
				'tags'  => array( __( 'Verified callbacks', 'wisebones-title-escrow' ), __( 'Encrypted portal', 'wisebones-title-escrow' ), __( 'Staff training', 'wisebones-title-escrow' ) ),
			),
		),
		'process'      => array(
			'eyebrow' => __( 'How a closing works', 'wisebones-title-escrow' ),
			'heading' => __( 'From contract to recording', 'wisebones-title-escrow' ),
			'steps'   => array(
				array( __( 'Open the order', 'wisebones-title-escrow' ), __( 'Send the contract and we receipt the earnest money.', 'wisebones-title-escrow' ) ),
				array( __( 'Search & commit', 'wisebones-title-escrow' ), __( 'We examine title and issue the commitment.', 'wisebones-title-escrow' ) ),
				array( __( 'Clear & prepare', 'wisebones-title-escrow' ), __( 'Payoffs, requirements and settlement statements.', 'wisebones-title-escrow' ) ),
				array( __( 'Close & record', 'wisebones-title-escrow' ), __( 'Signing, funding, recording and policy issuance.', 'wisebones-title-escrow' ) ),
			),
		),
		'team'         => array(
			'eyebrow' => __( 'Our team', 'wisebones-title-escrow' ),
			'heading' => __( 'Escrow officers and title examiners', 'wisebones-title-escrow' ),
		),
		'testimonials' => array(
			'eyebrow' => __( 'Client feedback', 'wisebones-title-escrow' ),
			'heading' => __( 'Agents and lenders trust us', 'wisebones-title-escrow' ),
			'samples' => array(
				array( __( 'Every closing has been on time and my clients always feel informed.', 'wisebones-title-escrow' ), __( 'Sample client', 'wisebones-title-escrow' ), __( 'Real estate agent', 'wisebones-title-escrow' ) ),
				array( __( 'Clean closing disclosures and fast funding numbers.', 'wisebones-title-escrow' ), __( 'Sample client', 'wisebones-title-escrow' ), __( 'Loan officer', 'wisebones-title-escrow' ) ),
				array( __( 'They explained every page before we signed.', 'wisebones-title-escrow' ), __( 'Sample client', 'wisebones-title-escrow' ), __( 'Home buyer', 'wisebones-title-escrow' ) ),
			),
		),
		'areas'        => array(
			'eyebrow' => __( 'Offices & counties', 'wisebones-title-escrow' ),
			'heading' => __( 'Where we close', 'wisebones-title-escrow' ),
			'text'    => __( 'Office locations and the counties we serve. Mobile signings are available throughout.', 'wisebones-title-escrow' ),
			'items'   => array( __( 'Downtown office', 'wisebones-title-escrow' ), __( 'Northside office', 'wisebones-title-escrow' ), __( 'Central County', 'wisebones-title-escrow' ), __( 'Lake County', 'wisebones-title-escrow' ), __( 'River County', 'wisebones-title-escrow' ), __( 'Hill County', 'wisebones-title-escrow' ) ),
			'button'  => array( __( 'Contact an office', 'wisebones-title-escrow' ), '/contact/' ),
		),
		'faq'          => array(
			'eyebrow' => __( 'FAQ', 'wisebones-title-escrow' ),
			'heading' => __( 'Closing questions', 'wisebones-title-escrow' ),
			'items'   => array(
				array( __( 'What does title insurance cover?', 'wisebones-title-escrow' ), __( 'It protects against covered losses from defects in title that existed before you bought, such as undisclosed liens or recording errors. The policy itself sets out exactly what is covered.', 'wisebones-title-escrow' ) ),
				array( __( 'What should I bring to closing?', 'wisebones-title-escrow' ), __( 'Valid government-issued photo ID and any funds due, sent by verified wire or as instructed by your escrow officer.', 'wisebones-title-escrow' ) ),
				array( __( 'How long does a closing take?', 'wisebones-title-escrow' ), __( 'Add your typical timelines here for purchases and refinances.', 'wisebones-title-escrow' ) ),
				array( __( 'Can I sign remotely?', 'wisebones-title-escrow' ), __( 'Mobile signings are available. Describe any remote or electronic notarization options you offer here.', 'wisebones-title-escrow' ) ),
			),
		),
		'cta'          => array(
			'heading' => __( 'Ready to open an order?', 'wisebones-title-escrow' ),
			'text'    => __( 'Send us the details and an escrow officer will confirm receipt within one business day.', 'wisebones-title-escrow' ),
			'form'    => true,
			'button'  => array( __( 'Open an order', 'wisebones-title-escrow' ), '/open-an-order/' ),
		),
	),

	'order'         => array( 'hero', 'stats', 'services', 'values', 'process', 'team', 'testimonials', 'areas', 'faq', 'cta' ),

	'footer'        => array(
		'about'   => __( 'Title insurance, escrow and settlement services for residential and commercial transactions.', 'wisebones-title-escrow' ),
		'note'    => __( 'We will never ask you to change wiring instructions by email. Add your licensing and underwriter details here.', 'wisebones-title-escrow' ),
		'columns' => array(
			__( 'Services', 'wisebones-title-escrow' )  => array(
				array( __( 'All services', 'wisebones-title-escrow' ), '/services/' ),
				array( __( 'Open an order', 'wisebones-title-escrow' ), '/open-an-order/' ),
			),
			__( 'Resources', 'wisebones-title-escrow' ) => array(
				array( __( 'Wire fraud guidance', 'wisebones-title-escrow' ), '/wire-fraud/' ),
				array( __( 'Blog', 'wisebones-title-escrow' ), '/blog/' ),
			),
			__( 'Company', 'wisebones-title-escrow' )   => array(
				array( __( 'About', 'wisebones-title-escrow' ), '/about/' ),
				array( __( 'Team', 'wisebones-title-escrow' ), '/team/' ),
				array( __( 'Contact', 'wisebones-title-escrow' ), '/contact/' ),
			),
		),
	),

	'starter'       => array(
		'front' => 'home',
		'blog'  => 'blog',
		'pages' => array(
			'home'          => array( 'title' => __( 'Home', 'wisebones-title-escrow' ) ),
			'services'      => array(
				'title'   => __( 'Services', 'wisebones-title-escrow' ),
				'content' => $wbte_p( __( 'Title insurance, escrow and settlement for every kind of transaction.', 'wisebones-title-escrow' ) ) . $wbte_code( '[wbik_services count="9"]' ),
			),
			'open-an-order' => array(
				'title'   => __( 'Open an Order', 'wisebones-title-escrow' ),
				'content' => $wbte_p( __( 'Send the property and transaction details. An escrow officer will confirm receipt and next steps within one business day. Please do not send funds until you have verified wiring instructions by phone.', 'wisebones-title-escrow' ) ) . $wbte_code( '[wbik_lead_form type="order" title=""]' ),
			),
			'wire-fraud'    => array(
				'title'   => __( 'Wire Fraud Guidance', 'wisebones-title-escrow' ),
				'content' => $wbte_p( __( 'Wire fraud targets buyers, sellers and agents. We will never change wiring instructions by email.', 'wisebones-title-escrow' ) )
					. $wbte_h( __( 'Before you send funds', 'wisebones-title-escrow' ) )
					. $wbte_p( __( 'Call your escrow officer at a phone number you already know — not one from an email — and confirm the instructions verbally. If anything seems off, stop and call us.', 'wisebones-title-escrow' ) ),
			),
			'about'         => array(
				'title'   => __( 'About Us', 'wisebones-title-escrow' ),
				'content' => $wbte_p( __( 'Tell your story here: your history, the underwriters you represent and the areas you serve.', 'wisebones-title-escrow' ) ) . $wbte_h( __( 'Our team', 'wisebones-title-escrow' ) ) . $wbte_code( '[wbik_team count="8" columns="4"]' ),
			),
			'contact'       => array(
				'title'   => __( 'Contact', 'wisebones-title-escrow' ),
				'content' => $wbte_p( __( 'Questions about a file or our services? Send a note and we will reply within one business day.', 'wisebones-title-escrow' ) ) . $wbte_code( '[wbik_lead_form type="contact" title=""]' ),
			),
			'blog'          => array( 'title' => __( 'Blog', 'wisebones-title-escrow' ) ),
		),
		'menu'  => array(
			array( __( 'Home', 'wisebones-title-escrow' ), '/' ),
			array( __( 'Services', 'wisebones-title-escrow' ), 'page:services' ),
			array( __( 'Wire fraud', 'wisebones-title-escrow' ), 'page:wire-fraud' ),
			array( __( 'Team', 'wisebones-title-escrow' ), 'archive:team' ),
			array( __( 'About', 'wisebones-title-escrow' ), 'page:about' ),
			array( __( 'Blog', 'wisebones-title-escrow' ), 'page:blog' ),
			array( __( 'Contact', 'wisebones-title-escrow' ), 'page:contact' ),
			array( __( 'Open an order', 'wisebones-title-escrow' ), 'page:open-an-order' ),
		),
	),
);
