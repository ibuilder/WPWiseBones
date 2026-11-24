<?php
/**
 * RealWise SEO — JSON-LD structured data for the front page.
 *
 * Emits Organization + SoftwareApplication + FAQPage so Google can show the
 * brand panel, the app/offer details and FAQ rich snippets in search results.
 * The FAQ list is shared with front-page.php via realwise_faqs() so the
 * structured data always mirrors what visitors actually see (a requirement of
 * Google's FAQ rich-result policy).
 */

defined( 'ABSPATH' ) || exit;

/**
 * Canonical FAQ list for the homepage. Returned as [ question, answer ] pairs.
 *
 * @return array<int, array{0:string,1:string}>
 */
function realwise_faqs(): array {
	return [
		[ __( 'Is the free version actually full-featured, or crippled?', 'realwise' ), __( 'Fully featured. All six modules — listings, investor tools, CRM, agent portal, property management and tours — are in the free, GPL-licensed plugin. The only paid product is RealWise MLS, which automates importing listings from your MLS. If you add listings another way, you may never need it.', 'realwise' ) ],
		[ __( 'What if my MLS isn\'t supported?', 'realwise' ), __( 'RealWise MLS speaks the generic RESO Web API plus presets for Bridge, Trestle, MLS Grid, Paragon, FlexMLS/Spark, SimplyRETS, ATTOM, Crexi and legacy RETS — and a CSV/IDX file importer for anything else. Most North-American MLSs expose one of these. Ask us before buying and we\'ll confirm yours.', 'realwise' ) ],
		[ __( 'Do I need WordPress?', 'realwise' ), __( 'Yes — RealWise is a WordPress plugin, so it runs on any standard WordPress site (most hosts, $5–$15/mo). If you already have a WordPress site, you\'re ready.', 'realwise' ) ],
		[ __( 'Will it slow my site down?', 'realwise' ), __( 'No CDN or remote assets are loaded on your front end, queries are indexed and cached, and you only enable the modules you use. It\'s built to the same performance standards WordPress.org reviews for.', 'realwise' ) ],
		[ __( 'Is my data safe?', 'realwise' ), __( 'Your listings, leads and tenant data stay in your database — not ours. The code uses prepared SQL, output escaping and nonce-protected forms, and online rent runs through Stripe with verified webhooks.', 'realwise' ) ],
		[ __( 'Can I cancel the MLS license?', 'realwise' ), __( 'Anytime. Your license includes one year of automatic updates and support; if you don\'t renew, the plugin keeps importing — you simply stop receiving updates until you renew.', 'realwise' ) ],
		[ __( 'How long does setup take?', 'realwise' ), __( 'Activate the plugin, drop two shortcodes on a page, and you have a working search and listing site in minutes. Connect your MLS and Stripe when you\'re ready — there\'s a guided getting-started panel in the admin.', 'realwise' ) ],
	];
}

/**
 * Print the JSON-LD graph in the <head> on the front page only.
 */
add_action( 'wp_head', function () {
	if ( ! is_front_page() ) {
		return;
	}

	$home = home_url( '/' );
	$logo = get_stylesheet_directory_uri() . '/assets/images/realwise-logo.png';

	$organization = [
		'@type'  => 'Organization',
		'@id'    => $home . '#organization',
		'name'   => 'RealWise',
		'url'    => $home,
		'logo'   => $logo,
		'sameAs' => [ 'https://wprealwise.com' ],
	];

	$application = [
		'@type'               => 'SoftwareApplication',
		'name'                => 'RealWise',
		'applicationCategory' => 'BusinessApplication',
		'operatingSystem'     => 'WordPress',
		'description'         => __( 'Listings, investor analytics, CRM, agent portal, property management, tours and automated MLS imports — the complete real-estate platform for WordPress.', 'realwise' ),
		'url'                 => $home,
		'publisher'           => [ '@id' => $home . '#organization' ],
		'offers'              => [
			[
				'@type'         => 'Offer',
				'name'          => __( 'RealWise (free plugin)', 'realwise' ),
				'price'         => '0',
				'priceCurrency' => 'USD',
			],
			[
				'@type'         => 'Offer',
				'name'          => __( 'RealWise MLS (annual license)', 'realwise' ),
				'price'         => '149',
				'priceCurrency' => 'USD',
				'url'           => home_url( '/store/' ),
			],
		],
	];

	$faqpage = [
		'@type'      => 'FAQPage',
		'mainEntity' => array_map(
			static function ( array $f ): array {
				return [
					'@type'          => 'Question',
					'name'           => wp_strip_all_tags( $f[0] ),
					'acceptedAnswer' => [
						'@type' => 'Answer',
						'text'  => wp_strip_all_tags( $f[1] ),
					],
				];
			},
			realwise_faqs()
		),
	];

	$graph = [
		'@context' => 'https://schema.org',
		'@graph'   => [ $organization, $application, $faqpage ],
	];

	echo "\n" . '<script type="application/ld+json">' . wp_json_encode( $graph ) . '</script>' . "\n";
}, 5 );
