<?php
/**
 * The long per-product copy, generated - do not hand-edit.
 *
 * Source: C:\Server\codester\_listing-kits\<slug>\listing.md
 * Generator: C:\Server\codester\tools\make_site_products.py
 *
 * This is the same HTML that goes into Codester's description and requirements
 * editors, converted by the same function, so the page a buyer reads here and
 * the listing they read there say the same thing.
 *
 * Loaded ONLY by inc/site-builder.php, which writes it into page content once.
 * It is deliberately not required on every front-end request: ten full
 * descriptions is a lot of array to parse in order to render a menu. Once the
 * pages exist the copy lives in post_content, where it can be edited in the
 * block editor like any other page - and a rebuild will overwrite those edits,
 * which is the trade for having it generated.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

/**
 * Long copy keyed by short product slug.
 *
 * @return array<string, array{description: string, requirements: string}>
 */
function ibuilder_site_descriptions(): array {
	return array(
		'realty' => array(
			'description'  => '<p><strong>iBuilder Realty turns WordPress into a complete real-estate platform.</strong></p>
<p>Not a listings grid with a contact form. Seven integrated modules that cover the whole job: the listings themselves, getting them in from your MLS, qualifying the leads they produce, analysing the numbers on an investment, letting your agents work their own pipeline, managing the properties you already own, and booking the showings.</p>
<p><strong>No license key. No activation. No phone-home.</strong></p>
<p>There is nothing to register, no key to paste, no domain to authorise and no server of ours in the loop. Upload, activate, and it works — on as many sites as your licence allows, forever, including the ones you build for clients.</p>
<p><strong>What you get</strong></p>
<p><strong>1. Listings &amp; search.</strong> Listings live in their own tables, not in <code>wp_posts</code>, so a 50,000-record import does not slow your site to a crawl. Filter on price, beds, baths, square feet, city, ZIP, asset type and status. Sort by days on market, price, newest or size. An interactive map plots the current page from OpenStreetMap tiles — no mapping API key, no billing account, no quota. Listing pages carry a photo gallery, Walk Score, neighbourhood crime grade, nearby school ratings, a price-history chart, a mortgage calculator and a contact form that feeds the CRM.</p>
<p><strong>2. MLS / IDX import, built in.</strong> Fifteen feed adapters: generic RESO Web API, Bridge Interactive, Spark/FlexMLS, Trestle, MLS Grid, Paragon, Rapattoni, Constellation1, SimplyRETS, legacy RETS, ATTOM, Crexi, CSV, and a demo feed so you can test the whole pipeline before your credentials arrive. Per-feed field mapping with RESO defaults pre-filled. Scheduled imports, hourly to daily. A full import log with records fetched, inserted, updated and skipped on every run. Most plugins sell this as a separate paid add-on. Here it is a module.</p>
<p><strong>3. Investor tools.</strong> A real proforma: net present value, internal rate of return, debt service coverage ratio, cash-on-cash return, equity multiple, monthly principal and interest, projected sale price and a year-by-year cash-flow table. Plus a 28-item renovation cost estimator with unit costs you set to your own market, a fix-and-flip ARV analyzer that works back from comparable sales to a maximum allowable offer, and a configurable 0–100 deal score.</p>
<p><strong>4. Lead CRM.</strong> A drag-and-drop pipeline from new through contacted, qualified, showing, offer, closed and lost. Leads arrive automatically from listing enquiries, the lead form, saved-search sign-ups and tour requests, with the source recorded. Automatic scoring. Four assignment modes: round-robin, the listing\'s own agent, least-busy agent, or manual. Tasks with due dates, an email drip sequence that stops when a lead replies, and CSV export.</p>
<p><strong>5. Agent portal.</strong> A front-end dashboard your agents log into. Their listings, their leads, their profile — and only ever theirs. Capability-checked on every request, not just in the menu.</p>
<p><strong>6. Property management.</strong> Properties, units and leases. A tenant portal where tenants see their lease, pay rent through Stripe Checkout and file maintenance requests. Rent generated on schedule, configurable late fees, and a maintenance queue. Leave the Stripe keys blank and it works as a ledger you mark paid by hand.</p>
<p><strong>7. Tours &amp; scheduling.</strong> Weekly availability windows, slot lengths, minimum lead time and a booking horizon. A visitor picks a slot; it becomes a tour record and a CRM lead at once. Confirmation emails carry an .ics invite, reminders go out before the appointment, and staff accept or decline from the admin.</p>
<p><strong>Built to be worked on</strong></p>
<ul><li>Every template is overridable from your theme — drop a copy in <code>your-theme/ibuilder-realty/&lt;module&gt;/</code> and your version loads instead. Overrides survive updates.</li><li>Documented action and filter hooks that will not change inside the 1.x line, including <code>ibrwc_lead_created</code> for pushing leads to an outside CRM and <code>ibrwm_import_complete</code> for reacting to an import.</li><li>A read-only REST API under <code>ibuilder-realty/v1</code>, so a headless front end, a mobile app or a second site can consume your listings without touching the database.</li><li>Colours, radii and shadows are CSS custom properties on <code>:root</code>. Restyle it from your child theme\'s stylesheet.</li><li>Every class, function, constant, table, option, hook and CSS class carries a unique prefix. Nothing collides with your theme or your other plugins.</li><li>Deleting the plugin removes all 22 tables, every option, every scheduled event and both roles. No orphans.</li></ul>
<p><strong>Third-party services are optional and yours</strong></p>
<p>Walk Score, CrimeGrade, GreatSchools, ATTOM and FRED each take your own API key, and the plugin makes no request at all to a service whose key is blank. Your MLS feed is between you and your MLS. Everything is disclosed, with terms and privacy links, in the readme.</p>',
			'requirements' => '<p>WordPress 6.2 or newer, PHP 8.0 or newer, MySQL 5.7+ or MariaDB 10.3+. Multisite supported. Full documentation ships inside the zip.</p>',
		),
		'signage' => array(
			'description'  => '<p><strong>Sell made-to-order products with a 3D configurator — and run the job after the sale.</strong></p>
<p>Most configurators stop at the add-to-cart button. This one keeps going: the configured order becomes a job ticket, the ticket becomes a scheduled delivery, and the shop floor gets production files it can actually cut from.</p>
<p>Built for signage out of the box, and the engine is not sign-specific: any product priced by material, area, finish and options fits it — plaques, panels, windows and doors, laser-cut parts, awards, nameplates, safety and wayfinding.</p>
<p><strong>No license key. No activation. No network.</strong></p>
<p>Nothing to register, no key to paste, no domain to authorise. The plugin makes <strong>no outbound HTTP request of any kind</strong> — no license server, no telemetry, no third-party API, not even a CDN for the 3D library. It runs entirely on your own server, which also means nothing about your shop, your orders or your customers can leak through it.</p>
<p><strong>1. The configurator</strong></p>
<p>Customers choose text, material, size, finish, surface and options, and watch an extruded 3D plate update in a dark-theme viewport with the live artwork mapped onto its face — orbit, zoom and reset. The price moves with it. No WebGL on their device? They get the same product as a flat SVG preview, configured and priced identically.</p>
<p>Self-contained: its own styles, no jQuery, no dependency on your theme, and it loads only on configurable products, so it costs nothing on the rest of your site.</p>
<p><strong>2. Pricing you can trust</strong></p>
<p>The price in the browser is a display mirror. Every add-to-cart and every cart total is recomputed on the server from your stored catalog, and a price submitted by the client is never used for anything. You control per-material rates per square foot, minimum charges, finish and surface surcharges, flat and per-area option pricing, extra-line fees and per-template setup fees — all from admin screens, no code.</p>
<p>There is a pricing simulator in the admin that runs the exact same engine the cart runs, so you can sanity-check a configuration without placing an order.</p>
<p><strong>3. Production files, not just an order note</strong></p>
<p>Every configured line item stores:</p>
<ul><li>a <strong>print-ready SVG</strong> — layered, dimensioned, outlined text, 1 inch = 72 units, with bleed and safe-area guides;</li><li>a <strong>fabrication spec sheet</strong> in plain text — material, dimensions, thickness, finish, options and the full price breakdown;</li><li><strong>architectural shop drawings</strong> as a PDF set — a schedule cover sheet plus a dimensioned sheet per item.</li></ul>
<p>Files are written under <code>wp-content/uploads/</code> with unguessable names and are downloadable only by staff with the <code>manage_woocommerce</code> capability.</p>
<p><strong>4. Fabrication board</strong></p>
<p>Auto-numbered job tickets created from WooCommerce orders, moving through Design → Production → Delivery/Installation → Billing. Status changes email the customer, and a job-status page lets them look the job up themselves instead of phoning you. The stage list is a filter, so it can match your shop\'s own process.</p>
<p><strong>5. Dispatch</strong></p>
<p>A week schedule board with crew assignment from a roster, linked back to the order and the ticket. Print a daily run sheet, or hand each crew a per-crew iCal feed that lands the schedule in their phone\'s calendar.</p>
<p><strong>About 50 templates to start from</strong></p>
<p>Construction and jobsite signage formatted to ANSI Z535 and OSHA conventions, fire and life-safety, egress and exit (including photoluminescent), room ID, restroom, and parking and ADA. One click imports them as configurable WooCommerce products with thumbnails and categories, and the import is idempotent — run it again whenever you like.</p>
<p>Have your own range? Drop it in as a catalog pack and seed the lot in one click. If it already lives in a Shopify store, a bundled converter turns a <code>products.json</code> into a pack for you.</p>
<p><strong>Built to be worked on, and to be yours</strong></p>
<ul><li><strong>No branding of ours anywhere</strong> — no logo, no credit line, no link to remove. Your logo and site name come from WordPress and appear in the admin header and on every shop drawing.</li><li>Full unminified JavaScript source ships alongside the compiled bundles, with the exact build command in <code>package.json</code>. <code>npm install &amp;&amp; npm run build</code> and you own the front end.</li><li>Twelve documented filters and actions: the fabrication stages, the notification emails, the quote destination, the drawing logo, the REST rate limit, and more.</li><li>A REST API under <code>ibuilder-signage/v1</code> for price, preview, proof, save, logo and templates.</li><li>Every class, namespace, constant, option, hook and CSS class carries the product\'s prefix.</li><li>WooCommerce HPOS (custom order tables) and cart/checkout blocks both declared compatible.</li><li>English and Spanish interface translations, with a bilingual toggle on bilingual templates.</li></ul>',
			'requirements' => '<p>WordPress 6.5+, WooCommerce 8.0+, PHP 8.1+. Node.js is not needed to run the plugin — artwork ships pre-generated — only to regenerate artwork or rebuild the bundles. Full documentation ships inside the zip.</p>',
		),
		'social' => array(
			'description'  => '<p><strong>Auto-posting to LinkedIn that does not quietly fail.</strong></p>
<p>Most "share to social" plugins fire an HTTP request during the publish request and hope. When LinkedIn rate-limits you, or is briefly down, or your token has expired, the post is simply gone — no retry, no record, and nobody notices for a week.</p>
<p>This one treats publishing as a job. WordPress stays the scheduler of record: when a post goes live, the plugin queues a background job and calls the LinkedIn Posts API from there. Your editor never waits on LinkedIn, and LinkedIn being slow never delays publishing on your site.</p>
<p><strong>No license key. No activation. No phone-home.</strong></p>
<p>Nothing to register and no remote check of any kind. The only service contacted is LinkedIn, with your own LinkedIn app credentials. Nothing is sent to us, ever — there is no "us" in the request path at all.</p>
<p><strong>Retries that make sense</strong></p>
<p>Transient failures back off: 5 minutes, 30 minutes, 2 hours, 12 hours. A <code>Retry-After</code> header from LinkedIn is honoured when it asks for longer. Permanent failures — bad credentials, a rejected payload, a missing scope — are never retried on a timer, because repeating the same request until the attempt cap just wastes a day; those need an administrator, and the plugin says so instead of churning.</p>
<p><strong>It will not post twice</strong></p>
<p>A double post on a company page is embarrassing and cannot be undone, so there are three guards: a content hash so a repeated status transition cannot queue the same post twice, a short-lived per-post lock so two workers cannot overlap, and the stored LinkedIn post URN checked immediately before every send. On a site with a persistent object cache the lock is an atomic add; without one it is best effort, which is exactly why the stored URN is the real backstop rather than the lock.</p>
<p><strong>Credentials handled properly</strong></p>
<p>The client secret, access token and refresh token are encrypted at rest with AES-256-GCM, keyed from your site\'s own authentication salts. They are stored with autoloading off, never rendered back into HTML, and never written to a log. If you would rather they were not in the database at all, pin them in <code>wp-config.php</code> with two constants and the plugin uses those instead.</p>
<p>The OAuth <code>state</code> value is single-use, bound to the administrator who started the flow, and expires after 15 minutes.</p>
<p><strong>Every attempt is on the record</strong></p>
<p>A log table with the HTTP status, the detail LinkedIn returned, the retry count and the resulting post URN. Filter by post, status or message. Resend a row. Prune on a retention schedule you set. When something has not published, the status code names the problem in one glance instead of sending you to a server error log.</p>
<p><strong>Control where it belongs</strong></p>
<ul><li>Per-post: a share checkbox, custom commentary that overrides the template, live status with a link to the published post, and manual *Post now* / *Resend*.</li><li>Site-wide: eligible post types, share-by-default, commentary template with placeholders, default hashtags with a cap, attempt limit, logging level and log retention.</li><li>In code: ten documented filters, including <code>ibuilder_social_post_text</code> for the commentary, <code>ibuilder_social_share_url</code> for UTM parameters, <code>ibuilder_social_linkedin_payload</code> for the raw API payload and <code>ibuilder_social_retry_delay</code> for the backoff schedule.</li><li>From the shell: <code>wp ibuilder_social status</code> reports connection, token expiry, queue and cron health in one command; <code>wp ibuilder_social publish &lt;id&gt;</code> sends immediately.</li></ul>
<p><strong>Also</strong></p>
<ul><li>Uses Action Scheduler automatically when another plugin provides it, otherwise WP-Cron.</li><li>Multisite: each site keeps its own connection, settings and logs — one network, many pages.</li><li>Namespaced, autoloaded PHP with no bundled third-party code of any kind and nothing from a CDN.</li><li>Deleting the plugin removes the log table, every option and all stored credentials.</li></ul>
<p><strong>Before you buy, know this</strong></p>
<p>LinkedIn does not grant posting access by default. You need to create an app in the LinkedIn Developer Portal, add the Community Management API product, and complete LinkedIn\'s review before the <code>w_organization_social</code> scope is available to it. No plugin can bypass that, and this listing does not pretend otherwise. Budget for LinkedIn\'s review before you plan a launch around it.</p>
<p>Featured images are not uploaded in this version — LinkedIn requires images to be registered as separate assets first, which is a different API flow. Posts are shared as link posts with a title, description and permalink.</p>',
			'requirements' => '<p>WordPress 6.3+, PHP 7.4+ with OpenSSL, a LinkedIn app approved for the Community Management API, and a LinkedIn organization page you administer. Full documentation ships inside the zip.</p>',
		),
		'ledger' => array(
			'description'  => '<p><strong>A general ledger, not an invoice list.</strong></p>
<p>Most WordPress "accounting" plugins are a list of invoices with a total at the bottom. This one is a double-entry engine: every transaction has to balance, and the engine refuses to save one that does not. There is no override, because an override is how books stop meaning anything.</p>
<p><strong>No license key. No activation. No network.</strong></p>
<p>Nothing to register and no remote check of any kind. The plugin makes <strong>no outbound HTTP request at all</strong> — no license server, no telemetry, no cloud accounting API. Your books, your statements and your PDFs stay on your own server, in your own database. For a lot of buyers that is the whole reason to run accounting inside WordPress instead of a SaaS.</p>
<p><strong>What the engine will not let you do</strong></p>
<ul><li>Save an entry that does not balance, or that has fewer than two lines.</li><li>Overwrite a balance. Balances are always derived as <code>SUM(debit) − SUM(credit)</code>, never stored, so no balance can quietly drift away from the entries behind it.</li><li>Edit or delete a posted entry. Corrections are reversing entries, which is how double-entry bookkeeping works and what makes the history defensible six months later.</li><li>Break the accounting equation. Assets = Liabilities + Equity always holds.</li><li>Leave a half-posted entry behind. Entries are written in a transaction and rolled back as a unit.</li></ul>
<p>Money is <code>DECIMAL(18,2)</code> in the database and bcmath at scale 2 in PHP. No floating-point arithmetic touches an amount anywhere in the plugin.</p>
<p><strong>The three statements</strong></p>
<ul><li><strong>Balance Sheet</strong> — point in time, including current-year earnings not yet closed to Retained Earnings, with a <code>balanced</code> flag you can assert on.</li><li><strong>Income Statement</strong> — revenue, COGS, gross profit, operating expenses, operating income, other income and expense, net income, over any date range.</li><li><strong>Cash Flow Statement</strong> — indirect method, with operating, investing and financing sections and a <code>reconciles</code> flag checked against real movement in your cash accounts.</li></ul>
<p>All three read the same general ledger, so they cannot disagree with each other. Each downloads as a PDF, and a combined financial package renders all three into one document.</p>
<p><strong>Multiple companies</strong></p>
<p>One WordPress install, several entities, each with its own chart of accounts, entries and statements, never mixed. An agency can keep client books side by side; a group can keep each company separate without three installs.</p>
<p><strong>Chart of accounts you actually control</strong></p>
<p>A 24-account general-purpose chart is seeded for every new company — assets, liabilities, equity, revenue, expenses — and all of it is editable: codes, names, types, subtypes, the cash flag, active and inactive. Seeding your own country\'s or industry\'s chart instead is one filter.</p>
<p><strong>Recurring entries</strong></p>
<p>Rent, depreciation, standing accruals: a template and a frequency, posted on schedule, each one switchable without being deleted.</p>
<p><strong>QuickBooks export</strong></p>
<p>IIF for QuickBooks Desktop, General Journal CSV for QuickBooks Online. Files you download and import — no API connection and no credentials to store, which means the plugin never holds a token to your accounting system.</p>
<p><strong>WooCommerce integration</strong></p>
<p>Orders reaching Processing or Completed post a balanced entry: debit Cash, credit Sales Revenue, plus Tax Payable and Shipping where they apply. Refunds post a reversing entry. A one-click historical sync posts entries for past orders and is <strong>idempotent</strong> — an order already posted is skipped, so running it twice does not double your revenue, and a retried webhook cannot double-post.</p>
<p><strong>REST API, authenticated the boring way</strong></p>
<p>Namespace <code>ibuilder-ledger/v1</code>, authenticated with WordPress Application Passwords — built into core since 5.6, so there is no custom key system to manage or leak. Reports and journal entries are all reachable, plus four purpose-built integration routes for invoices, payments, vendor bills and project costs. Each integration route takes an <strong>idempotency key</strong>: send the same key twice and the second call is recognised rather than posted again.</p>
<p><strong>Built to be worked on</strong></p>
<ul><li>Two documented hooks: <code>ibuilder_ledger_entry_posted</code> fires after <code>COMMIT</code>, so a listener always sees a durable entry; <code>ibuilder_ledger_default_accounts</code> replaces the seeded chart.</li><li>Namespaced, autoloaded PHP. Five tables, all prefixed, all dropped on uninstall.</li><li>No branding of ours anywhere — no logo, no credit line, no link to remove.</li></ul>',
			'requirements' => '<p>WordPress 6.2+, PHP 8.0+ with the bcmath extension. WooCommerce is optional and only needed for the order integration. Dompdf ships inside the zip, so there is no Composer step on your server. Full documentation ships inside the zip.</p>
<p><strong>Two honest notes</strong></p>
<p>This is bookkeeping software, not a bookkeeper. It enforces the mechanics; it does not know your jurisdiction\'s tax rules and is not a substitute for an accountant signing off accounts.</p>
<p>There are no bank feeds and no tax filing. Both need licensed providers and per-jurisdiction rules, and a plugin that claimed them would be lying.</p>',
		),
		'market' => array(
			'description'  => '<p><strong>A marketplace that handles what happens after the sale.</strong></p>
<p>Plenty of multi-vendor plugins let several sellers list products. This one also issues license keys for the software they sell, keeps those keys in step with their GitHub releases, prices tiered services, records the commission on every line item, voids it when an order is refunded, and tracks what you owe each vendor.</p>
<p><strong>No license key for this plugin. No activation. No phone-home.</strong></p>
<p>Nothing to register and no remote check of any kind.</p>
<p>Worth being clear about, because it looks contradictory in a feature list: this plugin <strong>issues</strong> license keys. That is a feature your *vendors* use for the software they sell to *their* customers. There is no licence check, no activation and no domain lock on you.</p>
<p><strong>Vendors stay out of your admin</strong></p>
<p>A visitor applies through a front-end form. Approval is manual or automatic. On approval they get a deliberately narrow role that grants a front-end dashboard and nothing in <code>wp-admin</code> — listings, orders, earnings, store profile, payout details, all without ever seeing your admin. Each vendor gets a public store page with "Sold by" attribution across the shop.</p>
<p><strong>Digital downloads with real licensing</strong></p>
<p>A downloadable listing issues a license key on purchase with a per-license activation limit. The software being sold calls a REST API to activate, deactivate and validate:</p>
<p>``<code> POST /wp-json/ibuilder_market/v1/license/activate     body: license_key, instance POST /wp-json/ibuilder_market/v1/license/deactivate   body: license_key, instance GET  /wp-json/ibuilder_market/v1/license/validate?license_key=... </code>``</p>
<p><code>instance</code> is whatever identifies one installation, so the limit counts machines rather than downloads, and a customer moving to a new laptop releases the old seat instead of burning one.</p>
<p><strong>GitHub release sync — the part nobody else does</strong></p>
<p>A vendor binds a listing to a GitHub repository and maps asset labels to filename globs. The downloadable files, version and changelog then follow the latest published release, checked daily.</p>
<p>The detail that matters: downloads are addressed by a <strong>stable label</strong>, not by filename. An installer that carries its version in the name — <code>Tool_1.4.2_x64-setup.exe</code> — keeps the same WooCommerce download ID from release to release, so existing customers keep working download permissions. Re-uploading a zip by hand breaks them every time.</p>
<p><strong>Tiered services alongside products</strong></p>
<p>Basic, Standard and Premium packages per service listing, each with its own price, description and delivery time. Tier prices are recomputed on the server at add-to-cart and at checkout, so a price edited in the browser cannot take effect.</p>
<p><strong>Commissions that stay correct</strong></p>
<p>A global rate with per-vendor overrides, recorded per line item when an order completes and <strong>voided automatically on refunds and cancellations</strong> — so a refunded sale does not leave a payable behind for you to spot three weeks later. Vendors store a PayPal email or Stripe account ID; you review pending earnings and mark them paid.</p>
<p>The plugin does not move money, and that is deliberate. It records what is owed. Paying happens in PayPal or Stripe, by you. A plugin holding payout credentials and initiating transfers would be a far larger liability on your site than a ledger is.</p>
<p><strong>Bundled extra: a pay-per-use tools module</strong></p>
<p>Dormant until you give it an API key, and you can sell a marketplace without ever switching it on. It sells WooCommerce credit packs and spends credits per run, with six tools that produce clean <code>.docx</code> and <code>.xlsx</code>: RFI drafting, submittal-log review, G702/G703 pay-application assembly, cost-exposure reporting, meeting minutes and daily reports. They call the Anthropic API with <strong>your</strong> key.</p>
<p>One filter registers your own tools instead, so the credits mechanism is reusable for any pay-per-run service — this is the piece to look at if you want metered AI features on a site and do not want to build the billing.</p>
<p><strong>Built to be worked on</strong></p>
<ul><li>Every front-end template is overridable from your theme: drop a copy in <code>your-theme/ibuilder-market/</code> and your version loads instead. Overrides survive updates.</li><li>Thirteen documented actions and filters: vendor lifecycle, license issuance, commission rate and recording, release sync, template resolution, tool registration.</li><li>WooCommerce HPOS (custom order tables) declared compatible.</li><li>Translation-ready, with every class, option, hook and CSS class carrying the product\'s prefix.</li><li>No branding of ours anywhere — no logo, no credit line, no link to remove.</li><li>No bundled third-party code at all. Every PHP, JS and CSS file is original, and nothing loads from a CDN.</li></ul>',
			'requirements' => '<p>WordPress 6.2+, WooCommerce 8.0+, PHP 7.4+, pretty permalinks. Full documentation ships inside the zip.</p>
<p><strong>A policy note, not a feature note</strong></p>
<p>If the software your vendors sell is GPL, MPL or Apache licensed, a license key cannot restrict rights those licences have already granted. Price a tier on what the buyer *gains* — support scope, update window, priority — not on what is withheld from the software. The plugin gives you the mechanism; the policy is yours to get right.</p>',
		),
		'projects' => array(
			'description'  => '<p><strong>A construction project, run inside WordPress.</strong></p>
<p>Not a task list with a hard-hat icon. This connects the general contractor, the owner, the owner\'s rep, the design consultants and the subcontractors on one site and runs the actual day-to-day processes of a jobsite — from the first bid package through design coordination, field work, cost control, safety and final handover.</p>
<p><strong>No license key. No activation. No phone-home.</strong></p>
<p>Nothing to register and no remote check of any kind. All project data lives in custom tables in your own WordPress database. The only outbound call the plugin can make is a free weather lookup, server-side, and only when someone clicks "Fetch weather" on a daily report.</p>
<p><strong>The change-order workflow is the product</strong></p>
<p>Most "project management" plugins give you lists. This gives you the chain a change actually travels, with each step gated by the acting party\'s role:</p>
<p>``<code> PCO Request  →  NOC to owner  →  owner\'s direction  →  Directive to sub →  Proposal or eTicket  →  COR / Approval Letter  →  owner approval </code>``</p>
<p>Plus the parallel SSI → SSID path for consultant- and owner-originated scope. Every transition is <strong>enforced on the server</strong>, not hidden in the interface, and written to the record\'s activity timeline — the electronic replacement for a paper routing slip, and the thing that makes the audit hold up a year later when someone disputes who authorised what.</p>
<p>One-click record linking carries data forward along the chain, so a COR assembled from three subcontractor proposals does not need retyping.</p>
<p><strong>Two role dimensions, which is why the gates work</strong></p>
<p>Every user has a CRUD capability role (Administrator / Editor / Contributor / Viewer / Restricted) <strong>and</strong> a party role (GC / Owner / Owner\'s Rep / Consultant / Subcontractor). The capability role says what they may do; the party role says who they are on the job. An owner returning a Notification of Change is an owner action — an Editor with a Subcontractor party role cannot take it, whatever their permissions.</p>
<p>Section access is granted per section per role, so a subcontractor never sees the cost forecast.</p>
<p><strong>Over a hundred modules across fourteen sections</strong></p>
<p>Preconstruction and procurement, engineering and design, change management, field, quality, safety, sustainability, contracts, cost, BIM, resources, closeout, reports, settings.</p>
<p>Bidder prequalification, invitations to bid, bid levelling. RFIs, submittals, drawings, specs, design reviews, long-lead procurement. Daily reports with manpower, delivery and visitor logs, photos, punch lists, timesheets, installed quantities. Inspections, non-conformance reports, incidents, toolbox talks, observations — with signatures drawn on a tablet in the field. Commissioning, as-builts, owner training, completion certificates, asset register.</p>
<p><strong>The cost model, and pay applications</strong></p>
<p>Budget, commitments, change events, direct costs and invoices roll into a live <strong>budget vs committed vs actual vs forecast</strong> summary with a projected over/under. Payment applications are built in <strong>G702/G703 format</strong>: load the Schedule of Values, and the Application and Certificate for Payment builder produces the formatted PDF.</p>
<p>To be precise about that: it produces pay applications *in the G702/G703 format*. AIA® and G702®/G703® are trademarks of The American Institute of Architects, and this plugin does not include or distribute AIA\'s official documents.</p>
<p><strong>Scheduling that suits the work</strong></p>
<p>A Gantt chart, and a <strong>Line-of-Balance</strong> (location-based / takt) chart for repetitive floor-by-floor work — the Empire State Building method. Plus just-in-time site logistics and a long-lead procurement log.</p>
<p><strong>Add your own modules without writing PHP</strong></p>
<p>Every business process is one <code>module.json</code> file: fields, types, statuses, which columns show in the list. A shared engine renders the sortable list with CSV export, the validated form, and the record view with comments, electronic signature and PDF export. Install a module as a ZIP and its database table is created automatically.</p>
<p>Add a field to an existing module and the column is added; remove one and the column and its data stay put. Nothing is dropped behind your back.</p>
<p><strong>Also</strong></p>
<ul><li>Front-end login and registration — the project team never touches <code>wp-admin</code>.</li><li>Comments and PDF export on every record, CSV export on every list.</li><li>Reports module with statistics charts and PDF/CSV export.</li><li>eTicket builder with automatic labour, material and equipment totals from the project rate tables, signed by the superintendent then the GC.</li><li>IFC model records store and link the file; an optional in-browser 3D viewer is available for owners who self-host three.js and web-ifc. Off by default, and nothing loads from a CDN.</li><li>Bootstrap 5, Bootstrap Icons, Chart.js and jsPDF bundled locally, all MIT, all credited with versions in <code>LICENSE.txt</code>.</li><li>No branding of ours anywhere — no logo, no credit line, no link to remove.</li></ul>',
			'requirements' => '<p>WordPress 6.4+, PHP 8.0+. No external database, service or account. Shared hosting is fine to start; a project with tens of thousands of records wants real MySQL resources. Full documentation ships inside the zip.</p>',
		),
		'procore' => array(
			'description'  => '<p><strong>Put your Procore project data on your website.</strong></p>
<p>Eighteen shortcodes and a block, reading live from the Procore API: project directories, team members, drawings, specifications, RFIs, submittals, punch lists, observations, daily logs, change orders, schedule milestones, vendors and offices.</p>
<p><strong>Read-only. It never writes to Procore.</strong> Nothing this plugin does can change your project data — which is the first question anyone sensible asks about a plugin that holds ERP credentials.</p>
<p><strong>No license key. No activation. No phone-home.</strong></p>
<p>Nothing to register with us and no remote check. The only service contacted is Procore, with your own application credentials, which are encrypted at rest and never rendered back into a page.</p>
<p><strong>Built for the way Procore actually works</strong></p>
<ul><li><strong>Two authentication modes.</strong> A Developer Managed Service Account (OAuth 2.0 client credentials), which keeps working when staff change because it is not tied to a person; or the authorization code grant, acting on behalf of a signed-in Procore user so output respects their own permissions.</li><li><strong>Caching that respects the rate limit.</strong> Procore enforces an hourly quota *and* a ten-second spike limit. Every response is cached, with a per-endpoint lifetime you control and a site-wide floor that no single page can undercut — so one shortcode with an aggressive cache setting cannot take your whole app over the limit.</li><li><strong>It degrades, it doesn\'t break.</strong> If Procore is unreachable, the last good response is served instead of an error. Repeated failures trip a circuit breaker that pauses requests and resumes automatically.</li><li><strong>Real pagination.</strong> Result sets are assembled by following Procore\'s <code>Link</code> headers, not by guessing page numbers.</li><li><strong>Diagnostics that tell you something.</strong> The connection test reports each stage separately and probes every endpoint, so you see exactly which Procore tool permissions your credentials have — which is the cause of an empty shortcode nine times out of ten. <code>wp ibuilder-procore doctor</code> does the same from the shell.</li></ul>
<p><strong>Privacy is handled, not assumed</strong></p>
<p>Procore project directories contain real people\'s contact details. Email addresses are suppressed twice over: a global setting suppresses them, <strong>and</strong> each shortcode must separately opt in with <code>show_email="true"</code>. Both must allow it before an address renders. Turning that off is a deliberate decision, and the plugin makes you make it deliberately.</p>
<p>Procore\'s error messages routinely name accounts and permissions, so they are shown to administrators only. Visitors get a neutral message.</p>
<p><strong>Control over the output</strong></p>
<p>Every shortcode takes <code>company_id</code>, <code>project_id</code>, <code>id</code>, <code>limit</code>, <code>page</code>, <code>all</code>, <code>orderby</code>, <code>order</code>, <code>columns</code>, <code>fields</code>, <code>template</code>, <code>class</code>, <code>title</code>, <code>cache</code> and <code>empty_text</code>. Every one is sanitised, and <code>columns</code> and <code>fields</code> are checked against an allow-list — naming a field is not a free pass to read arbitrary Procore data.</p>
<p>``<code> [ibuilder_procore_rfis project_id="12345" limit="10" columns="number,subject,status,due_date" title="Open RFIs"] </code>``</p>
<p><strong>Also</strong></p>
<ul><li>A block with a variation per shortcode and a <strong>live server-rendered preview</strong> in the editor, so an editor sees the real data rather than a placeholder.</li><li>Five theme-overridable templates: copy into <code>your-theme/ibuilder-procore/</code> and your version loads instead. Overrides survive updates.</li><li>An optional read-only, allow-listed <strong>REST proxy</strong> so your own front-end code can read the same cached data without holding Procore credentials.</li><li>Six WP-CLI commands: <code>test</code>, <code>doctor</code>, <code>projects</code>, <code>cache_warm</code>, <code>cache_clear</code>, <code>reset_token</code>.</li><li>PSR-4 autoloaded, <code>declare(strict_types=1)</code> throughout, translation-ready. No bundled third-party code at all and nothing from a CDN.</li><li>No branding of ours anywhere.</li></ul>',
			'requirements' => '<p>WordPress 6.5+, PHP 7.4+ with OpenSSL. <strong>You need your own Procore account and your own application registered in the Procore Developer Portal.</strong> This plugin does not come with Procore access and cannot provide it. For the service-account mode, a Procore company administrator has to install your app before it can see anything — connecting is not the same as being installed.</p>
<p>Procore is a registered trademark of Procore Technologies, Inc. This plugin is an independent integration and is not affiliated with, endorsed by or sponsored by them.</p>
<p>Full documentation ships inside the zip.</p>',
		),
		'cmic' => array(
			'description'  => '<p><strong>Keeps a WordPress construction dashboard populated from CMiC.</strong></p>
<p>An add-on for <strong>iBuilder Projects</strong> that reads the CMiC construction ERP and keeps its modules filled: operating companies, business partners, RFIs, submittals, owner change orders, job cost codes, currencies and exchange rates, plus the CMiC project\'s own details.</p>
<p><strong>Read-only against CMiC.</strong> It fetches; it never writes back. Nothing it does can change a record in your ERP — which is the first thing anyone responsible for a CMiC environment will want to know.</p>
<p><strong>No license key. No activation. No phone-home.</strong></p>
<p>Nothing to register with us and no remote check. The only services contacted are your own CMiC environment and your own OAuth identity provider.</p>
<p><strong>Built for CMiC\'s real limits, not for a happy path</strong></p>
<p>CMiC Cloud allows 5 concurrent requests and 15 requests per second per IP, caps any single request at 1,000 records, terminates requests after 60 seconds, and returns HTTP 429 <strong>without</strong> a <code>Retry-After</code> header. Each of those shaped the design:</p>
<ul><li>Requests are issued <strong>strictly serially</strong> at a configurable pace — never concurrently.</li><li>Pages at 500 records by default.</li><li>Retries 429 and 5xx with exponential backoff <strong>and jitter</strong>, so retries from several sites do not synchronise into a thundering herd against the same environment.</li><li>Only the attributes actually mapped are requested, keeping responses small.</li><li>Work is <strong>queued</strong>, not run in one pass, so a large portfolio is worked through steadily across scheduled runs instead of being cut off at a time limit mid-sync.</li></ul>
<p><strong>Built for a group, not one company</strong></p>
<p>Operating companies are discovered from CMiC rather than typed in, each with its currency and country. Several CMiC environments can be configured as separate named connections. Every synced record is stamped with the operating company that owns it, and <strong>money is reported per currency</strong>, so a roll-up never adds GBP to USD.</p>
<p><strong>Idempotent, and it never touches the host plugin\'s schema</strong></p>
<p>iBuilder Projects\'s tables carry no column for a foreign system\'s key, and this plugin does not add one. The CMiC-to-host link lives in this plugin\'s own mapping table. So:</p>
<ul><li>re-running a sync updates rows rather than duplicating them;</li><li>an unchanged record costs no database write;</li><li><strong>uninstalling this plugin leaves every synced record in place.</strong> You lose the link to CMiC, not the data.</li></ul>
<p><strong>Authentication</strong></p>
<p>OAuth 2.0 client credentials through your own identity provider — Azure AD / Entra ID, Okta or Google — is recommended and is what you should set up. Basic authentication works, but <strong>CMiC retires it on 31 March 2027</strong> and the plugin warns you while it is in use.</p>
<p><strong>Optional inbound webhooks, treated as hostile</strong></p>
<p>CMiC can push changes instead of being polled. CMiC requires an *unauthenticated* receiver, so nothing in the message is trusted: a secret in the URL gates the route, only the record id is taken from the payload, the record is then re-read from CMiC over this site\'s own authenticated connection, and the payload\'s callback URL is never fetched.</p>
<p>A forged webhook can do nothing but trigger a legitimate re-read of a record you already sync. That is the whole threat surface, deliberately.</p>
<p><strong>Also</strong></p>
<ul><li>Dry-run mode: fetch and map, write nothing. Use it for the first run against production.</li><li>Configurable field mapping per resource.</li><li>A REST status endpoint reporting host availability, binding state, binding mode and whether a sync is running — so a silently stalled sync does not go unnoticed for a week.</li><li>A sync log with retention.</li><li>No bundled third-party code at all; nothing from a CDN. No branding of ours anywhere.</li></ul>',
			'requirements' => '<ul><li><strong>iBuilder Projects is required.</strong> This is an add-on and has nothing to write into without it. Sold separately.</li><li>WordPress 6.4+, PHP 8.0+.</li><li><strong>Your own CMiC environment and API credentials.</strong> This plugin does not come with CMiC access and cannot provide it.</li><li>Working WP-Cron, or better, a real cron job calling <code>wp-cron.php</code>.</li></ul>
<p>Without iBuilder Projects active, the plugin still lets you save and test connections and tells you plainly that nothing can be written — so you can get credentials working before the host plugin is set up.</p>
<p>CMiC is a trademark of Computer Methods International Corp. This plugin is an independent integration and is not affiliated with, endorsed by or sponsored by them.</p>
<p>Full documentation ships inside the zip.</p>',
		),
		'kitchen' => array(
			'description'  => '<p><strong>Most kitchen planners let somebody draw a counter wherever they like. This one works out where the counter actually is — from the cabinets standing under it — and then tells them what will not work, and why.</strong></p>
<p>Put one shortcode on a page and a visitor gets a 3D kitchen they can lay out: base cabinets in the widths they are actually sold in — the full 9" to 48" series in 3" increments, not four round numbers — wall cabinets at the heights that clear a worktop, corner cabinets that admit they are corner cabinets, and appliances at published trade sizes. Every time something moves, the layout is re-measured and reported with the standard named on each finding.</p>
<p><strong>The worktop is derived, not drawn</strong></p>
<p>This is the part that makes the rest mean anything. Nobody draws a counter: you place cabinets, as you would in life, and the worktop follows. A base cabinet or dishwasher carries worktop over it. A tall cabinet or refrigerator ends the run. A sink or hob set into a run splits it in two — so a 9-foot counter with a hob in the middle is correctly read as two landing areas, not one. A 22" sink in a 24" cabinet does not leave a 2" lip to be counted as usable worktop.</p>
<p><strong>What it checks</strong></p>
<ul><li>Landing area at the sink, cooking surface, refrigerator, oven and microwave — the guidance that actually shapes a kitchen</li><li>The work triangle: each leg 4\'–9\', the three no more than 26\', measured from the front of the counter because that is where you stand. A leg that is too <strong>short</strong> fails too, and anything standing in a leg is reported</li><li>Aisle width: 42" for a work aisle, 36" for a walkway, measured between facing fronts — and to the wall ahead, which the guideline does not do but a cook does</li><li>Total countertop: 158" of frontage, 24" deep, 15" clear above</li><li>Combining landing areas (Guideline 24): where two adjoin, the worktop between them must be the longer requirement plus 12" — one stretch cannot do both jobs</li><li>The primary prep area: a continuous 36" × 24" beside a sink — continuous being the point, since two 20" stretches either side of a sink are 40" of worktop and nowhere to work</li><li>Clearance above the cooking surface, extract over the hob, microwave height, dishwasher within reach of the sink, door swing and leaf width</li><li>An accessible profile that adds ICC A117.1: clear floor space at each appliance, door clear width, and whether a 60" turning circle fits</li></ul>
<p><strong>What the visitor gets out</strong></p>
<p>A <strong>PDF specification sheet</strong> — a plan drawn at a real architectural scale, the cabinet and appliance schedule with classification codes, every check with its standard, and the materials list with the tile waste allowance on its own line. It is the document a homeowner hands a contractor. Generated on your server in plain PHP: no PDF library, no Composer dependency, no font to licence.</p>
<p>And an <strong>IFC4 model</strong>, which no consumer kitchen planner produces. Full spatial hierarchy, real dimensions in metres, Uniclass classification codes — so the sketch opens directly in Revit, ArchiCAD, Solibri, Navisworks, BIMcollab or Bonsai. Priceable, not retyped.</p>
<p><strong>Optional lead capture</strong></p>
<p>If you fit kitchens for a living, ask visitors for their details before the specification sheet downloads. The lead that arrives already contains the layout, the materials list and the problems found. Leads land in wp-admin and in an email to you, with a CSV export and a Download PDF button on each one.</p>
<p>It is <strong>off by default</strong> and stays off until you turn it on, name the recipient and write the consent wording yourself. No IP addresses are stored. Leads are wired into WordPress\'s own privacy export and erasure tools.</p>
<p><strong>No external services, ever</strong></p>
<p>The plugin makes no outbound requests at all. The 3D library, the catalogue, the rules and the PDF generator all ship inside it. No API key, no account, no CDN, no phone-home. It works on a site behind a firewall.</p>
<p><strong>No licence key. No activation. No domain lock.</strong></p>
<p>There is nothing to register, no key to paste and no server of ours in the loop. Upload, activate, and it works — on as many sites as your licence allows, forever, including the ones you build for clients.</p>
<p><strong>Honest about what it is</strong></p>
<p>Most of what governs a kitchen is recommended practice from the NKBA, a trade association, rather than law. The plugin says so on every finding: it names the guideline it applied and links the source, and it separates the handful of real code requirements from the guidance. It is a design tool that catches the mistakes that make a kitchen unpleasant to cook in — not a code compliance certificate, and it does not pretend to be one.</p>
<p><strong>What you get</strong></p>
<ul><li>17 families, 106 catalogue types, all at real published dimensions</li><li>23 rules across a recommended-practice and an accessible profile</li><li>3D WebGL editor, one shortcode, works on a phone</li><li>PDF specification sheet and IFC4 export</li><li>Optional lead capture with CSV export</li><li>Full HTML documentation in the download</li><li>Clean, prefixed, escaped PHP — passes the official WordPress Plugin Check with zero errors and zero warnings in all five categories</li></ul>',
			'requirements' => '<ul><li>WordPress 6.5 or later (tested to 7.1)</li><li>PHP 7.4 or later (runs on 8.0–8.3)</li><li>A browser with WebGL 2 for the 3D view</li><li>No PHP extensions beyond a default build, no database tables added</li></ul>',
		),
		'bathroom' => array(
			'description'  => '<p><strong>Most room planners let somebody drop a pretty toilet six inches from a wall. This one tells them that will not pass, and why.</strong></p>
<p>Put one shortcode on a page and a visitor gets a 3D bathroom they can lay out: toilets at real 12" rough-ins, vanities in the widths they are actually sold in, 54" alcove tubs for the bath that will not take a 60" one. Every time they move something, the layout is measured against the dimensional minimums in the model codes, and the result is reported fixture by fixture with the standard named on it — so they, or their contractor, can look it up.</p>
<p><strong>What it checks</strong></p>
<ul><li>Clear floor space in front of the toilet, basin and tub</li><li>Toilet centreline to the nearest side wall or cabinet — the usual reason a vanity has to shrink</li><li>Minimum shower size, by both smallest dimension and floor area</li><li>Shower door clear opening and headroom over the drain</li><li>Whether the door swings into a fixture</li><li>Ventilation</li><li>An accessible mode that adds ICC A117.1 on top: the 16"–18" toilet centreline range, clear floor spaces, knee clearance under the basin, grab bar lengths and heights, and whether a 60" turning circle fits anywhere in the room</li></ul>
<p><strong>What the visitor gets out</strong></p>
<p>A <strong>PDF specification sheet</strong> — a plan drawn at a real architectural scale, the fixture schedule, every clearance check with its standard, and a quantity takeoff with the tile waste allowance on its own line. It is the document a homeowner hands a contractor. It is generated on your server in plain PHP: no PDF library, no Composer dependency, no font to licence.</p>
<p>And an <strong>IFC4 model</strong> — the part no consumer room planner does. Full spatial hierarchy, real dimensions in metres, Uniclass classification codes and the retailer SKU for each fixture, so the homeowner\'s sketch opens directly in Revit, ArchiCAD, Solibri, Navisworks, BIMcollab or Bonsai. Priceable, not retyped.</p>
<p><strong>Optional lead capture</strong></p>
<p>If you fit out bathrooms for a living, ask visitors for their details before the specification sheet downloads. The lead that arrives already contains the room they laid out, the materials list and the code problems found — not just a name and "quote me please". Leads land in wp-admin and in an email to you, with a CSV export and a Download PDF button on each one.</p>
<p>It is <strong>off by default</strong> and stays off until you turn it on, name the recipient and write the consent wording yourself. No IP addresses are stored. Leads are wired into WordPress\'s own privacy export and erasure tools.</p>
<p><strong>No external services, ever</strong></p>
<p>The plugin makes no outbound requests at all. The 3D library, the fixture catalogue, the clearance rules and the PDF generator all ship inside it. No API key, no account, no CDN, no phone-home. It works on a site behind a firewall.</p>
<p><strong>No licence key. No activation. No domain lock.</strong></p>
<p>There is nothing to register, no key to paste and no server of ours in the loop. Upload, activate, and it works — on as many sites as your licence allows, forever, including the ones you build for clients.</p>
<p><strong>What you get</strong></p>
<ul><li>16 fixture families, 83 catalogue types, all at real published dimensions</li><li>23 clearance rules across a residential and an accessible profile</li><li>3D WebGL editor, one shortcode, works on a phone</li><li>PDF specification sheet and IFC4 export</li><li>Optional lead capture with CSV export</li><li>Full HTML documentation in the download</li><li>Clean, prefixed, escaped PHP — passes the official WordPress Plugin Check with zero errors and zero warnings in all five categories</li></ul>',
			'requirements' => '<ul><li>WordPress 6.5 or later (tested to 7.1)</li><li>PHP 7.4 or later (runs on 8.0–8.3)</li><li>A browser with WebGL 2</li><li>No PHP extensions, no custom database tables, no external services</li></ul>',
		),
	);
}
