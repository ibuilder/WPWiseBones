<?php
/**
 * Product screenshots, generated - do not hand-edit.
 *
 * Source: C:\Server\codester\_listing-kits\<slug>\ASSETS.md and screenshots/
 * Generator: C:\Server\codester\tools\make_site_screenshots.py
 *
 * The captions are the ones written when the shots were taken, not
 * derived from filenames. The images live in assets/img/screens/<key>/
 * rather than the media library, so a rebuild replaces them and they
 * cost one file each instead of one plus WordPress's resized copies.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

/**
 * Screenshots for one product, in the order the kit lists them.
 *
 * @param string $key Product key, e.g. "realty".
 * @return array<int, array<string, mixed>> Empty when the product has none.
 */
function ibuilder_site_screenshots( string $key ): array {
	$all = array(
		'realty' => array(
			array( 'file' => '01-listings-search-map.png', 'w' => 1440, 'h' => 2600, 'caption' => 'Listings search with the map, filters and result cards', 'hero' => true ),
			array( 'file' => '02-listing-detail.png', 'w' => 1440, 'h' => 2600, 'caption' => 'Listing detail with scores, schools and the mortgage calculator' ),
			array( 'file' => '03-mls-feeds-and-log.png', 'w' => 1440, 'h' => 2156, 'caption' => 'MLS feeds, with the demo adapter and its import history' ),
			array( 'file' => '04-mls-import-log.png', 'w' => 1440, 'h' => 941, 'caption' => 'The import log, showing repeat runs against the same feed' ),
			array( 'file' => '05-investor-proforma.png', 'w' => 1440, 'h' => 2155, 'caption' => 'Investor proforma: NPV, IRR, DSCR and the annual cash flows' ),
			array( 'file' => '06-lead-pipeline.png', 'w' => 1440, 'h' => 941, 'caption' => 'Lead CRM pipeline, twelve leads across seven stages' ),
			array( 'file' => '07-agent-portal.png', 'w' => 1440, 'h' => 1440, 'caption' => 'Agent portal dashboard, signed in as the agent' ),
			array( 'file' => '08-rent-roll.png', 'w' => 1440, 'h' => 941, 'caption' => 'Property management rent roll' ),
			array( 'file' => '09-tours.png', 'w' => 1440, 'h' => 941, 'caption' => 'Tour requests across next week, at mixed statuses' ),
		),
		'signage' => array(
			array( 'file' => '01-builder-on-product.png', 'w' => 1440, 'h' => 2186, 'caption' => 'The 3D builder on a product page: live preview, live price, configuration tabs', 'hero' => true ),
			array( 'file' => '02-sign-catalog.png', 'w' => 1440, 'h' => 1325, 'caption' => 'The sign catalog, 72 configurable products' ),
			array( 'file' => '03-fabrication-board.png', 'w' => 1440, 'h' => 941, 'caption' => 'Fabrication board, tickets across every stage' ),
			array( 'file' => '04-dispatch-week.png', 'w' => 1440, 'h' => 941, 'caption' => 'The dispatch week with crews assigned' ),
			array( 'file' => '05-crew-roster.png', 'w' => 1440, 'h' => 947, 'caption' => 'Crew roster' ),
			array( 'file' => '06-pricing-simulator.png', 'w' => 1440, 'h' => 1042, 'caption' => 'Admin pricing simulator' ),
			array( 'file' => '07-order-with-configuration.png', 'w' => 1440, 'h' => 1156, 'caption' => 'Orders, each carrying its sign configuration and production files' ),
		),
		'social' => array(
			array( 'file' => '01-logs.png', 'w' => 1440, 'h' => 1257, 'caption' => 'Logs: successes with post URNs, a retried 429 and a parked 401', 'hero' => true ),
			array( 'file' => '02-settings-connected.png', 'w' => 1440, 'h' => 1777, 'caption' => 'Settings, connected, with the master switch off' ),
			array( 'file' => '03-post-panel-published.png', 'w' => 1440, 'h' => 941, 'caption' => 'The posts list, showing what was shared' ),
		),
		'ledger' => array(
			array( 'file' => '01-balance-sheet.png', 'w' => 1440, 'h' => 941, 'caption' => 'Statements: a Balance Sheet that balances', 'hero' => true ),
			array( 'file' => '02-cash-flow-statement.png', 'w' => 1440, 'h' => 941, 'caption' => 'Cash Flow Statement, reconciling, with investing and financing activity' ),
			array( 'file' => '03-income-statement.png', 'w' => 1440, 'h' => 941, 'caption' => 'Income Statement over the same period' ),
			array( 'file' => '04-trial-balance.png', 'w' => 1440, 'h' => 941, 'caption' => 'Trial balance: total debits equal total credits' ),
			array( 'file' => '05-new-journal-entry.png', 'w' => 1440, 'h' => 941, 'caption' => 'New journal entry, with the balancing constraint on screen' ),
			array( 'file' => '06-journal-ledger.png', 'w' => 1440, 'h' => 2600, 'caption' => 'Journal ledger: three and a half months of entries' ),
			array( 'file' => '07-chart-of-accounts.png', 'w' => 1440, 'h' => 1645, 'caption' => 'Chart of accounts, with the cash flags that make the cash flow work' ),
			array( 'file' => '08-recurring-entries.png', 'w' => 1440, 'h' => 994, 'caption' => 'Recurring entries' ),
			array( 'file' => '09-rest-api.png', 'w' => 1440, 'h' => 1301, 'caption' => 'The REST API, documented in the admin' ),
		),
		'market' => array(
			array( 'file' => '01-commissions.png', 'w' => 1440, 'h' => 941, 'caption' => 'Commissions: pending earnings across four vendors, and one voided by a refund', 'hero' => true ),
			array( 'file' => '02-vendor-dashboard.png', 'w' => 1440, 'h' => 1250, 'caption' => 'The vendor dashboard, signed in as a vendor' ),
			array( 'file' => '03-vendor-store.png', 'w' => 1440, 'h' => 2022, 'caption' => 'A public vendor store page' ),
			array( 'file' => '04-licenses.png', 'w' => 1440, 'h' => 941, 'caption' => 'Licences with activation counts and named instances' ),
			array( 'file' => '05-service-listing-tiers.png', 'w' => 1440, 'h' => 2142, 'caption' => 'A service listing with its three tiers priced' ),
			array( 'file' => '06-github-releases.png', 'w' => 1440, 'h' => 941, 'caption' => 'The GitHub release sync, with a bound repository' ),
			array( 'file' => '07-vendors-and-applications.png', 'w' => 1440, 'h' => 941, 'caption' => 'Vendors, with two applications awaiting approval' ),
		),
		'projects' => array(
			array( 'file' => '01-change-order-record.png', 'w' => 1440, 'h' => 2268, 'caption' => 'A complete change-order record with its activity timeline', 'hero' => true ),
			array( 'file' => '02-cost-summary.png', 'w' => 1440, 'h' => 2005, 'caption' => 'Cost summary: budget against committed, actual and forecast' ),
			array( 'file' => '03-schedule-of-values.png', 'w' => 1440, 'h' => 2105, 'caption' => 'Schedule of values, the G703 the pay application is built from' ),
			array( 'file' => '04-module-navigation.png', 'w' => 1440, 'h' => 2600, 'caption' => 'The module navigation, fourteen sections' ),
			array( 'file' => '05-rfi-log.png', 'w' => 1440, 'h' => 2600, 'caption' => 'The RFI log at mixed statuses' ),
			array( 'file' => '06-daily-report.png', 'w' => 1440, 'h' => 1905, 'caption' => 'Daily reports, including a weather delay with its notice' ),
			array( 'file' => '07-line-of-balance.png', 'w' => 1440, 'h' => 2600, 'caption' => 'Line of balance: six trades across five floors' ),
			array( 'file' => '08-eticket-signed.png', 'w' => 1440, 'h' => 2546, 'caption' => 'An eTicket with both signatures captured' ),
			array( 'file' => '09-section-access-matrix.png', 'w' => 1440, 'h' => 957, 'caption' => 'The section-access matrix — the dual-role model, in one screen' ),
		),
		'procore' => array(
			array( 'file' => '01-connection-diagnostic.png', 'w' => 1440, 'h' => 2032, 'caption' => 'The connection diagnostic and its per-endpoint permission probe', 'hero' => true ),
			array( 'file' => '02-rendered-tables.png', 'w' => 1440, 'h' => 2413, 'caption' => 'RFIs, submittals and the team, rendered on a WordPress page' ),
			array( 'file' => '03-projects-drawings-specs.png', 'w' => 1440, 'h' => 1787, 'caption' => 'Projects, drawings, specifications and daily logs' ),
			array( 'file' => '04-settings.png', 'w' => 1440, 'h' => 1144, 'caption' => 'Settings: auth mode, environment, cache lifetimes, privacy' ),
		),
		'cmic' => array(
			array( 'file' => '01-connections.png', 'w' => 1440, 'h' => 2600, 'caption' => 'Connections, with two named CMiC environments' ),
			array( 'file' => '02-project-binding.png', 'w' => 1440, 'h' => 1296, 'caption' => 'Project binding, with the pooling warning visible' ),
			array( 'file' => '03-field-map.png', 'w' => 1440, 'h' => 1775, 'caption' => 'A field map for one resource', 'hero' => true ),
			array( 'file' => '04-queue-settings.png', 'w' => 1440, 'h' => 2600, 'caption' => 'Queue settings: pace, page size, drain seconds, dry run' ),
		),
		'kitchen' => array(
			array( 'file' => '01-planner-and-findings.png', 'w' => 1500, 'h' => 942, 'caption' => 'The planner on recommended practice, with the work aisle failing and 13 checks passing', 'hero' => true ),
			array( 'file' => '02-accessible-profile.png', 'w' => 1500, 'h' => 1212, 'caption' => 'The same kitchen on the accessible profile, with the A117.1 failures' ),
			array( 'file' => '03-spec-sheet-plan.png', 'w' => 816, 'h' => 791, 'caption' => 'The specification sheet: summary band and the scaled plan' ),
			array( 'file' => '04-spec-sheet-checks.png', 'w' => 816, 'h' => 712, 'caption' => 'The specification sheet: every check, measured, with its standard' ),
			array( 'file' => '05-spec-sheet-materials.png', 'w' => 816, 'h' => 702, 'caption' => 'The specification sheet: materials, waste allowance, and "What this report is, and is not"' ),
			array( 'file' => '06-leads-screen.png', 'w' => 1316, 'h' => 368, 'caption' => 'The leads list in wp-admin' ),
		),
		'bathroom' => array(
			array( 'file' => '01-planner-and-findings.png', 'w' => 1350, 'h' => 912, 'caption' => 'The planner with the clearance findings beside it', 'hero' => true ),
			array( 'file' => '02-accessible-profile.png', 'w' => 1350, 'h' => 1292, 'caption' => 'The accessible profile, showing the ICC A117.1 failures' ),
			array( 'file' => '03-spec-sheet-plan.png', 'w' => 816, 'h' => 804, 'caption' => 'The specification sheet: summary band, scaled plan and the fixture schedule' ),
			array( 'file' => '04-spec-sheet-materials.png', 'w' => 816, 'h' => 732, 'caption' => 'The specification sheet: the checks, measured and cited, then the materials list' ),
			array( 'file' => '05-leads-screen.png', 'w' => 1568, 'h' => 425, 'caption' => 'The leads screen in wp-admin' ),
		),
	);

	return $all[ $key ] ?? array();
}
