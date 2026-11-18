<?php
/**
 * The products, generated - do not hand-edit.
 *
 * Source: C:\Server\codester\_listing-kits\<slug>\listing.md
 * Generator: C:\Server\codester\tools\make_site_products.py
 *
 * The site and the Codester listings sell the same things, so the name,
 * the one-line pitch and the price exist in two places. Typed twice they
 * drift, and the version a buyer reads on the site is the one that makes the
 * listing look wrong. So they are read from the kits instead. Re-run the
 * generator after editing a kit.
 *
 * The one field that is NOT generated is `codester_url`: nothing is submitted
 * yet, so there are no item URLs and each product points at the profile page.
 * Fill them in as listings go live - the generator preserves any value you
 * set - or override one at runtime with the `ibuilder_site_product_url`
 * filter.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

/**
 * The product table, in the order the site lists them: highest demand first,
 * matching the Codester upload order.
 *
 * @return array<int, array<string, mixed>>
 */
function ibuilder_site_products(): array {
	return array(
		array(
			'slug'         => 'ibuilder-realty',
			'key'          => 'realty',
			'name'         => 'iBuilder Realty - Real Estate & MLS for WordPress',
			'label'        => 'Realty',
			'tagline'      => 'Real estate for WordPress: listings, MLS/IDX import, investor proformas, a lead CRM, agent portal, property management and tours.',
			'price'        => '69',
			'icon'         => 'house-door',
			'codester_url' => '',
			'features'     => array(
				'Listings live in their own tables rather than wp_posts, so tens of thousands of them stay fast',
				'MLS / IDX import with fifteen feed adapters - RESO Web API, Bridge, SimplyRETS, legacy RETS, ATTOM, Crexi, CSV, and a demo feed to test the pipeline end to end',
				'A real investor proforma: net present value, internal rate of return, debt service, projected sale price and a year-by-year cash-flow table',
				'A 28-item renovation cost estimator',
			),
		),
		array(
			'slug'         => 'ibuilder-signage',
			'key'          => 'signage',
			'name'         => 'iBuilder Signage - 3D Configurator for WooCommerce',
			'label'        => 'Signage',
			'tagline'      => 'A 3D product configurator for WooCommerce with server-side pricing, production-ready artwork files and a fabrication job board.',
			'price'        => '59',
			'icon'         => 'badge-3d',
			'codester_url' => '',
			'features'     => array(
				'A 3D product configurator: text, material, size, finish, surface and options on an extruded plate the customer can orbit, zoom and reset',
				'An SVG fallback that configures and prices identically where WebGL is unavailable',
				'Pricing enforced on the server - every add-to-cart and every cart total is recalculated, never trusted from the browser',
				'Production-ready artwork stored per line item, so the shop floor can cut from the order instead of interpreting a note',
			),
		),
		array(
			'slug'         => 'ibuilder-social',
			'key'          => 'social',
			'name'         => 'iBuilder Social - LinkedIn Post Scheduler',
			'label'        => 'Social',
			'tagline'      => 'Auto-post WordPress content to a LinkedIn company page through a queue that retries properly and logs every attempt.',
			'price'        => '39',
			'icon'         => 'linkedin',
			'codester_url' => '',
			'features'     => array(
				'Auto-posts to LinkedIn company pages from a queue, rather than firing an HTTP request during the publish request and hoping',
				'Retries that back off sensibly - 5 minutes, 30 minutes, 2 hours, 12 hours - and honour a Retry-After header',
				'Three independent guards against posting the same thing twice, because a double post on a company page cannot be undone',
				'Client secret, access token and refresh token encrypted at rest with AES-256-GCM',
			),
		),
		array(
			'slug'         => 'ibuilder-ledger',
			'key'          => 'ledger',
			'name'         => 'iBuilder Ledger - Double-Entry Accounting',
			'label'        => 'Ledger',
			'tagline'      => 'Double-entry accounting inside WordPress: balanced journal entries, derived balances, the three statements as PDFs, REST API.',
			'price'        => '49',
			'icon'         => 'journal-text',
			'codester_url' => '',
			'features'     => array(
				'A real double-entry engine: it will not save an entry that does not balance, or that has fewer than two lines',
				'The three statements - Balance Sheet, Profit & Loss and Cash Flow - including current-year earnings not yet closed to Retained Earnings',
				'Several companies in one WordPress install, each with its own chart of accounts and entries',
				'A 24-account general-purpose chart seeded per company, and entirely yours to change',
			),
		),
		array(
			'slug'         => 'ibuilder-market',
			'key'          => 'market',
			'name'         => 'iBuilder Market - Multi-Vendor for WooCommerce',
			'label'        => 'Market',
			'tagline'      => 'Turn WooCommerce into a multi-vendor marketplace: digital downloads with license keys, tiered services, commissions, payouts.',
			'price'        => '79',
			'icon'         => 'shop',
			'codester_url' => '',
			'features'     => array(
				'A multi-vendor marketplace where vendors never touch wp-admin',
				'Front-end vendor applications, approved manually or automatically',
				'Digital downloads that issue a license key on purchase, with a per-license activation limit',
				'GitHub release sync: a vendor binds a listing to a repository and maps asset labels to filename globs',
			),
		),
		array(
			'slug'         => 'ibuilder-projects',
			'key'          => 'projects',
			'name'         => 'iBuilder Projects - Construction PM for WordPress',
			'label'        => 'Projects',
			'tagline'      => 'Construction project management in WordPress: RFIs, submittals, a role-gated change-order workflow, costs and G702/G703 pay apps.',
			'price'        => '79',
			'icon'         => 'kanban',
			'codester_url' => '',
			'features'     => array(
				'The change-order workflow is the product: the whole chain a change actually follows, not a list with a hard-hat icon',
				'Two role dimensions - a CRUD capability role and a project role - which is why the permission gates hold',
				'Over a hundred modules across fourteen sections, from preconstruction and procurement through to closeout',
				'A live budget vs committed vs actual, rolling up budget, commitments, change events, direct costs and invoices',
			),
		),
		array(
			'slug'         => 'ibuilder-procore',
			'key'          => 'procore',
			'name'         => 'iBuilder Connect - Procore Data on WordPress',
			'label'        => 'Connect for Procore',
			'tagline'      => 'Publish live Procore project data on your WordPress site with shortcodes and blocks - cached, rate-limit aware and read-only.',
			'price'        => '39',
			'icon'         => 'diagram-3',
			'codester_url' => '',
			'features'     => array(
				'Eighteen shortcodes and a block, reading live from the Procore API - project directories, teams, drawings and more',
				'Read-only: nothing this plugin does can change your project data in Procore',
				'Two authentication modes, including a Developer Managed Service Account',
				'Privacy handled rather than assumed - the contact details in a Procore directory are redacted by default',
			),
		),
		array(
			'slug'         => 'ibuilder-cmic',
			'key'          => 'cmic',
			'name'         => 'iBuilder Sync for CMiC - CMiC ERP to WordPress',
			'label'        => 'Sync for CMiC',
			'tagline'      => 'Read-only sync from the CMiC ERP into WordPress: operating companies, RFIs, submittals, change orders and cost codes.',
			'price'        => '29',
			'icon'         => 'arrow-repeat',
			'codester_url' => '',
			'features'     => array(
				'Keeps an iBuilder Projects dashboard populated from the CMiC construction ERP',
				'Read-only against CMiC: it fetches, and never writes back',
				'Built for CMiC\'s real limits - 5 concurrent requests, 15 per second per IP, and a cap on any single response - rather than for a happy path',
				'Operating companies discovered from CMiC rather than typed in, each with its own currency',
			),
		),
		array(
			'slug'         => 'ibuilder-kitchen',
			'key'          => 'kitchen',
			'name'         => 'iBuilder Kitchen Renovator - 3D NKBA Planner',
			'label'        => 'Kitchen Renovator',
			'tagline'      => 'Let visitors lay out a kitchen in 3D at real cabinet sizes, check NKBA clearances, and download a PDF spec sheet.',
			'price'        => '59',
			'icon'         => 'grid-3x3-gap',
			'codester_url' => '',
			'features'     => array(
				'The worktop is derived from the cabinets standing under it, not drawn: a base cabinet carries worktop, a tall cabinet ends the run, and a sink or hob set into a run splits it in two — so a 9-foot counter with a hob in the middle reads as two landing areas, not one',
				'Base cabinets in the widths they are actually sold in — the full 9" to 48" series in 3" increments, not four round numbers — plus wall, corner and tall cabinets and appliances at published trade sizes',
				'The work triangle measured properly: each leg 4\'–9\', the three no more than 26\', taken from the front of the counter because that is where you stand, with a leg that is too *short* failing too and anything standing in a leg reported',
				'Landing areas at the sink, cooking surface, refrigerator, oven and microwave, including Guideline 24 — where two landing areas adjoin, the worktop between them must be the longer requirement plus 12", because one stretch cannot do both jobs',
			),
		),
		array(
			'slug'         => 'ibuilder-bathroom',
			'key'          => 'bathroom',
			'name'         => 'iBuilder Bathroom Renovator - 3D Code Planner',
			'label'        => 'Bathroom Renovator',
			'tagline'      => 'Let visitors lay out a bathroom in 3D at real fixture sizes, check code clearances, and download a PDF spec sheet.',
			'price'        => '49',
			'icon'         => 'droplet',
			'codester_url' => '',
			'features'     => array(
				'A 3D bathroom a visitor lays out from one shortcode: toilets at real 12" rough-ins, vanities in the widths they are actually sold in, 54" alcove tubs for the bath that will not take a 60" one',
				'23 clearance rules checked on every move, reported fixture by fixture with the standard named, so the homeowner or their contractor can look it up',
				'An accessible profile that adds ICC A117.1 on top: the 16"–18" toilet centreline range, clear floor spaces, knee clearance under the basin, grab bar lengths and heights, and whether a 60" turning circle fits anywhere in the room',
				'A PDF specification sheet drawn at architectural scale, with the fixture schedule, every check with its standard, and a quantity takeoff with the tile waste allowance on its own line — generated in plain PHP, no library, no Composer dependency, no font to licence',
			),
		),
	);
}

/**
 * One product by its demo path / short slug ('realty', 'cmic', ...).
 *
 * @param string $key Short slug.
 * @return array<string, mixed>|null
 */
function ibuilder_site_product( string $key ): ?array {
	foreach ( ibuilder_site_products() as $p ) {
		if ( $p['key'] === $key ) {
			return $p;
		}
	}

	return null;
}

/**
 * Where "Buy on Codester" points for a product.
 *
 * Falls back to the profile page while a listing is still unsubmitted, so a
 * button is never dead - it just lands a level up.
 *
 * @param array<string, mixed> $product Product row.
 * @return string
 */
function ibuilder_site_product_url( array $product ): string {
	$url = (string) ( $product['codester_url'] ?? '' );

	if ( '' === $url ) {
		$url = IBUILDER_SITE_PROFILE_URL;
	}

	/**
	 * Filter a product's Codester URL.
	 *
	 * @param string               $url     Resolved URL.
	 * @param array<string, mixed> $product Product row.
	 */
	return (string) apply_filters( 'ibuilder_site_product_url', $url, $product );
}

/**
 * Deep link into the public demo for a product, or '' when no demo host is set.
 *
 * @param array<string, mixed> $product Product row.
 * @return string
 */
function ibuilder_site_demo_url( array $product ): string {
	$base = ibuilder_site_demo_base();

	if ( '' === $base ) {
		return '';
	}

	return trailingslashit( $base ) . trailingslashit( (string) $product['key'] );
}
