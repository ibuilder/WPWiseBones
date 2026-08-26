<?php
/**
 * AEC Forge marketing front page — promotes the AEC Market concept.
 *
 * Self-contained: Bootstrap 5 (from the parent) + the brand classes in
 * assets/css/aec-forge.css. Buy/apply buttons resolve to the AEC Market
 * plugin's pages automatically when the plugin is active.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$af_shop      = aec_forge_shop_url();
$af_register  = aec_forge_market_url( 'vendor_register_page', '/become-a-vendor/' );
$af_how       = home_url( '/how-it-works/' );
$af_tools_url = home_url( '/forge-tools/' );

$af_tools = [
	[ 'bi-file-earmark-text',  __( 'RFI Draft Generator', 'aec-forge' ),     __( '1 credit', 'aec-forge' ) ],
	[ 'bi-list-check',         __( 'Submittals Log Analyzer', 'aec-forge' ), __( '2 credits', 'aec-forge' ) ],
	[ 'bi-receipt',            __( 'G702/G703 Pay-App', 'aec-forge' ),       __( '3 credits', 'aec-forge' ) ],
	[ 'bi-graph-up-arrow',     __( 'Cost-Exposure Report', 'aec-forge' ),    __( '3 credits', 'aec-forge' ) ],
];

$af_features = [
	[ 'bi-box-seam',        __( 'Programs & Scripts', 'aec-forge' ),   __( 'Revit add-ins, IFC/GIS scripts, Grasshopper definitions, Excel macros and AI tools — sold as instant digital downloads.', 'aec-forge' ) ],
	[ 'bi-key',             __( 'License keys built in', 'aec-forge' ), __( 'Every download can issue license keys with activation limits, and a REST API your shipped tools call to validate themselves.', 'aec-forge' ) ],
	[ 'bi-layers',          __( 'Tiered services', 'aec-forge' ),      __( 'BIM modeling, IFC cleanup and custom automation offered as Basic / Standard / Premium packages with clear delivery times.', 'aec-forge' ) ],
	[ 'bi-speedometer2',    __( 'Vendor dashboard', 'aec-forge' ),     __( 'Builders manage listings, orders, earnings and payout details from a clean front-end dashboard — no wp-admin needed.', 'aec-forge' ) ],
	[ 'bi-cash-stack',      __( 'Fair commissions', 'aec-forge' ),     __( 'A transparent platform fee recorded per sale, voided automatically on refunds, with a full payout ledger.', 'aec-forge' ) ],
	[ 'bi-people',          __( 'By builders, for builders', 'aec-forge' ), __( 'Made for the AEC community: architects, engineers, BIM managers and the tool-makers who serve them.', 'aec-forge' ) ],
];
?>

<!-- ───────── HERO ───────── -->
<section class="af-hero">
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="col-lg-6 text-center text-lg-start">
				<span class="af-hero-badge"><span class="dot"></span> <?php esc_html_e( 'The marketplace for AEC builders', 'aec-forge' ); ?></span>
				<h1 class="display-4 fw-bold mt-3 mb-3"><?php esc_html_e( 'Where AEC tools & expertise are forged — and sold', 'aec-forge' ); ?></h1>
				<p class="lead mb-4"><?php esc_html_e( 'AEC Forge is the marketplace where BIM specialists, Excel experts and AI tool authors sell licensed scripts, add-ins and templates — alongside the custom services to put them to work.', 'aec-forge' ); ?></p>
				<div class="d-flex gap-2 justify-content-center justify-content-lg-start flex-wrap mb-3">
					<a href="<?php echo esc_url( $af_shop ); ?>" class="btn btn-primary btn-lg px-4"><i class="bi bi-shop me-2"></i><?php esc_html_e( 'Browse the marketplace', 'aec-forge' ); ?></a>
					<a href="<?php echo esc_url( $af_register ); ?>" class="btn btn-outline-light btn-lg px-4"><?php esc_html_e( 'Sell your tools', 'aec-forge' ); ?></a>
				</div>
				<div class="af-hero-trust d-flex align-items-center gap-2 justify-content-center justify-content-lg-start">
					<i class="bi bi-shield-check"></i>
					<span><?php esc_html_e( 'Open-source platform · Licensed downloads · Vetted vendors', 'aec-forge' ); ?></span>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="af-hero-visual">
					<div class="af-mock af-mock--product">
						<div class="af-mock__kicker"><?php esc_html_e( 'Program · Revit add-in', 'aec-forge' ); ?></div>
						<div class="af-mock__title"><?php esc_html_e( 'Sheet Batch Renamer Pro', 'aec-forge' ); ?></div>
						<span class="af-mock__key">AF7K-92MD-QX41-BT88</span>
						<div class="af-mock__row mt-2"><span><?php esc_html_e( 'License · 3 seats', 'aec-forge' ); ?></span><span class="af-mock__price">$49</span></div>
					</div>
					<div class="af-mock af-mock--service">
						<div class="af-mock__kicker"><?php esc_html_e( 'Service · IFC cleanup', 'aec-forge' ); ?></div>
						<div class="af-mock__title"><?php esc_html_e( 'Model Audit — Premium', 'aec-forge' ); ?></div>
						<div class="af-mock__row"><span><?php esc_html_e( 'Delivery in 5 days', 'aec-forge' ); ?></span><span class="af-mock__price">$850</span></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ───────── STATS STRIP ───────── -->
<div class="af-stats">
	<div class="container">
		<div class="row">
			<div class="col-6 col-md-3 af-stat"><b><?php esc_html_e( '2-in-1', 'aec-forge' ); ?></b><span><?php esc_html_e( 'Products & services, one checkout', 'aec-forge' ); ?></span></div>
			<div class="col-6 col-md-3 af-stat"><b><?php esc_html_e( '10%', 'aec-forge' ); ?></b><span><?php esc_html_e( 'Flat platform commission', 'aec-forge' ); ?></span></div>
			<div class="col-6 col-md-3 af-stat"><b><?php esc_html_e( 'REST', 'aec-forge' ); ?></b><span><?php esc_html_e( 'License activation API', 'aec-forge' ); ?></span></div>
			<div class="col-6 col-md-3 af-stat"><b><?php esc_html_e( 'GPL', 'aec-forge' ); ?></b><span><?php esc_html_e( 'Open-source platform', 'aec-forge' ); ?></span></div>
		</div>
	</div>
</div>

<!-- ───────── FEATURES ───────── -->
<section class="af-section">
	<div class="container">
		<div class="text-center mb-5">
			<span class="af-eyebrow"><?php esc_html_e( 'The concept', 'aec-forge' ); ?></span>
			<h2 class="display-6 fw-bold mt-2"><?php esc_html_e( 'One marketplace. Tools and the people behind them.', 'aec-forge' ); ?></h2>
			<p class="text-muted mx-auto" style="max-width:42em"><?php esc_html_e( 'Envato-style catalog for AEC digital products, Fiverr-style packages for AEC services — from the same vetted builders, in the same cart.', 'aec-forge' ); ?></p>
		</div>
		<div class="row g-4">
			<?php foreach ( $af_features as $af_f ) : ?>
				<div class="col-md-6 col-lg-4">
					<div class="af-card">
						<i class="bi <?php echo esc_attr( $af_f[0] ); ?>"></i>
						<h3><?php echo esc_html( $af_f[1] ); ?></h3>
						<p><?php echo esc_html( $af_f[2] ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ───────── HOW IT WORKS ───────── -->
<section class="af-section af-section--alt">
	<div class="container">
		<div class="text-center mb-5">
			<span class="af-eyebrow"><?php esc_html_e( 'How it works', 'aec-forge' ); ?></span>
			<h2 class="display-6 fw-bold mt-2"><?php esc_html_e( 'From workbench to marketplace in three steps', 'aec-forge' ); ?></h2>
		</div>
		<div class="row g-4">
			<div class="col-md-4 af-step">
				<span class="af-step__num">1</span>
				<h3 class="h5 fw-bold"><?php esc_html_e( 'Apply & get vetted', 'aec-forge' ); ?></h3>
				<p class="text-muted"><?php esc_html_e( 'Builders apply with their store profile. Every vendor is reviewed before their first listing goes live.', 'aec-forge' ); ?></p>
			</div>
			<div class="col-md-4 af-step">
				<span class="af-step__num">2</span>
				<h3 class="h5 fw-bold"><?php esc_html_e( 'List programs or services', 'aec-forge' ); ?></h3>
				<p class="text-muted"><?php esc_html_e( 'Upload a script with license keys and activation limits — or publish Basic / Standard / Premium service packages.', 'aec-forge' ); ?></p>
			</div>
			<div class="col-md-4 af-step">
				<span class="af-step__num">3</span>
				<h3 class="h5 fw-bold"><?php esc_html_e( 'Sell & get paid', 'aec-forge' ); ?></h3>
				<p class="text-muted"><?php esc_html_e( 'Buyers check out once for tools and services. Earnings accrue per sale and pay out on a transparent ledger.', 'aec-forge' ); ?></p>
			</div>
		</div>
		<p class="text-center mt-4"><a class="btn btn-outline-primary" href="<?php echo esc_url( $af_how ); ?>"><?php esc_html_e( 'See the full walkthrough', 'aec-forge' ); ?></a></p>
	</div>
</section>

<!-- ───────── FORGE TOOLS (AI) ───────── -->
<section class="af-section af-tools-band">
	<div class="container">
		<div class="text-center mb-5">
			<span class="af-eyebrow af-eyebrow--on-dark"><?php esc_html_e( 'AEC Forge Tools', 'aec-forge' ); ?></span>
			<h2 class="display-6 fw-bold mt-2 text-white"><?php echo wp_kses_post( __( 'The tedious GC paperwork, <span class="af-molten">done in a click.</span>', 'aec-forge' ) ); ?></h2>
			<p class="af-tools-sub mx-auto" style="max-width:46em"><?php esc_html_e( 'First-party, pay-per-use AI tools that draft the busywork and hand you clean .docx / .xlsx. Buy credits once, then run any tool — RFIs, submittal-log reviews, G702/G703 pay-apps and cost-exposure reports.', 'aec-forge' ); ?></p>
		</div>
		<div class="row g-4 justify-content-center">
			<?php foreach ( $af_tools as $af_t ) : ?>
				<div class="col-6 col-lg-3">
					<a href="<?php echo esc_url( $af_tools_url ); ?>" class="af-toolcard">
						<i class="bi <?php echo esc_attr( $af_t[0] ); ?>"></i>
						<h3><?php echo esc_html( $af_t[1] ); ?></h3>
						<span class="af-toolcard__cost"><?php echo esc_html( $af_t[2] ); ?></span>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
		<p class="text-center mt-5 mb-0">
			<a class="btn btn-primary btn-lg px-4" href="<?php echo esc_url( $af_tools_url ); ?>"><i class="bi bi-lightning-charge-fill me-2"></i><?php esc_html_e( 'Open the tools', 'aec-forge' ); ?></a>
		</p>
	</div>
</section>

<!-- ───────── AUDIENCE SPLIT ───────── -->
<section class="af-section">
	<div class="container">
		<div class="row g-4">
			<div class="col-lg-6">
				<div class="af-panel af-panel--dark">
					<span class="af-eyebrow"><?php esc_html_e( 'For builders', 'aec-forge' ); ?></span>
					<h3 class="h4 fw-bold mt-2 mb-3"><?php esc_html_e( 'Turn your in-house tools into income', 'aec-forge' ); ?></h3>
					<ul>
						<li><?php esc_html_e( 'Sell the Dynamo graph, Revit add-in or Excel model you already built.', 'aec-forge' ); ?></li>
						<li><?php esc_html_e( 'License keys and activations handled for you — including a validation API.', 'aec-forge' ); ?></li>
						<li><?php esc_html_e( 'Offer consulting alongside your products with tiered packages.', 'aec-forge' ); ?></li>
					</ul>
					<a href="<?php echo esc_url( $af_register ); ?>" class="btn btn-primary"><?php esc_html_e( 'Apply to become a vendor', 'aec-forge' ); ?></a>
				</div>
			</div>
			<div class="col-lg-6">
				<div class="af-panel af-panel--ember">
					<span class="af-eyebrow"><?php esc_html_e( 'For firms & buyers', 'aec-forge' ); ?></span>
					<h3 class="h4 fw-bold mt-2 mb-3"><?php esc_html_e( 'Buy the tool — or the expert behind it', 'aec-forge' ); ?></h3>
					<ul>
						<li><?php esc_html_e( 'Instant downloads with license keys your IT team can track.', 'aec-forge' ); ?></li>
						<li><?php esc_html_e( 'Fixed-scope service packages with delivery times, no RFP required.', 'aec-forge' ); ?></li>
						<li><?php esc_html_e( 'One cart, one invoice — products and services together.', 'aec-forge' ); ?></li>
					</ul>
					<a href="<?php echo esc_url( $af_shop ); ?>" class="btn btn-outline-primary"><?php esc_html_e( 'Browse listings', 'aec-forge' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ───────── CTA ───────── -->
<section class="af-section pt-0">
	<div class="container">
		<div class="af-cta">
			<h2 class="display-6 fw-bold mb-3"><?php esc_html_e( 'Ready to forge something?', 'aec-forge' ); ?></h2>
			<p class="lead mb-4"><?php esc_html_e( 'Join the first marketplace built for the people who automate the built environment.', 'aec-forge' ); ?></p>
			<div class="d-flex gap-2 justify-content-center flex-wrap">
				<a href="<?php echo esc_url( $af_register ); ?>" class="btn btn-primary btn-lg px-4"><?php esc_html_e( 'Start selling', 'aec-forge' ); ?></a>
				<a href="<?php echo esc_url( $af_shop ); ?>" class="btn btn-outline-light btn-lg px-4"><?php esc_html_e( 'Start browsing', 'aec-forge' ); ?></a>
			</div>
		</div>
	</div>
</section>

<?php
get_footer();
