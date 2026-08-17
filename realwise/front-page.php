<?php
/**
 * RealWise marketing front page — conversion-focused sales page.
 *
 * Self-contained: Bootstrap 5 (from the parent) + the RealWise brand classes in
 * assets/css/realwise.css. Needs neither the importer nor the shortcodes plugin.
 * EDD buy buttons appear automatically once the storefront exists.
 */

defined( 'ABSPATH' ) || exit;

get_header();

$pricing_url  = home_url( '/pricing/' );
$features_url = home_url( '/features/' );

$features = [
    [ 'bi-house-door',     __( 'Listings & Search', 'realwise' ),    __( 'A fast, map-based search with Walk Score, crime & school data, a mortgage calculator, comparable sales and email alerts — the IDX experience buyers expect.', 'realwise' ) ],
    [ 'bi-graph-up-arrow', __( 'Investor Tools', 'realwise' ),       __( 'Underwrite any deal in seconds: NPV, IRR, DSCR, cash-on-cash, a 28-item renovation estimator and an automated deal score that ranks opportunities for you.', 'realwise' ) ],
    [ 'bi-people',         __( 'CRM & Leads', 'realwise' ),          __( 'Every inquiry, saved search and tour request becomes a scored lead — auto-assigned and nurtured with email drips. No more leads lost in an inbox.', 'realwise' ) ],
    [ 'bi-person-badge',   __( 'Agent Portal', 'realwise' ),         __( 'Give each agent a front-end dashboard for their own listings, leads and profile — without handing out wp-admin access.', 'realwise' ) ],
    [ 'bi-building',       __( 'Property Management', 'realwise' ),   __( 'Leases, a tenant portal, online rent via Stripe with automatic late fees, and maintenance requests — tenants self-serve, you stop chasing checks.', 'realwise' ) ],
    [ 'bi-calendar-check', __( 'Tours & Scheduling', 'realwise' ),   __( 'Request-a-tour booking with real availability, .ics calendar invites and reminders — and every booking drops straight into your CRM as a hot lead.', 'realwise' ) ],
];

/*
 * Illustrative workflow scenarios (NOT customer testimonials). These describe
 * how each role uses the platform; they are not quotes from real customers.
 * Replace with genuine, attributable customer quotes once you have consent.
 */
$testimonials = [
    [ __( 'Brokerage owner', 'realwise' ), __( 'Listings · CRM · tours', 'realwise' ),      __( 'Listings, leads and tour requests land on one timeline — agents stop copy-pasting between an IDX plugin, a separate CRM and a booking tool.', 'realwise' ) ],
    [ __( 'Active investor', 'realwise' ), __( 'Proforma · deal score', 'realwise' ),       __( 'A property becomes NPV, IRR, DSCR and a go/no-go deal score in about a minute — no separate underwriting spreadsheet to maintain.', 'realwise' ) ],
    [ __( 'Property manager', 'realwise' ), __( 'Leases · online rent', 'realwise' ),        __( 'Tenants pay rent and file maintenance requests themselves, and late fees apply automatically — no chasing checks at month-end.', 'realwise' ) ],
];

$pillars = [
    [ 'bi-gift',          __( 'Free & open (GPL)', 'realwise' ),     __( 'The full platform is free and GPL-licensed. No feature paywall on the core.', 'realwise' ) ],
    [ 'bi-hdd-network',   __( 'Self-hosted — your data', 'realwise' ), __( 'Everything lives in your own WordPress database. No third party owns your listings or leads.', 'realwise' ) ],
    [ 'bi-unlock',        __( 'No lock-in', 'realwise' ),            __( 'Standard WordPress data and shortcodes. Cancel the MLS license anytime — the plugin keeps working.', 'realwise' ) ],
    [ 'bi-shield-check',  __( 'Secure & standards-clean', 'realwise' ), __( 'Passes WordPress.org Plugin Check: prepared SQL, escaped output, nonce-protected forms.', 'realwise' ) ],
];

$faqs = realwise_faqs();
?>

<!-- ───────── HERO ───────── -->
<section class="wpb-hero">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 text-center text-lg-start rw-reveal">
                <span class="rw-hero-badge"><span class="dot"></span> <?php esc_html_e( 'One platform · Replaces 5+ tools', 'realwise' ); ?></span>
                <h1 class="display-4 fw-bold mt-3 mb-3"><?php esc_html_e( 'Run your entire real-estate business on WordPress', 'realwise' ); ?></h1>
                <p class="lead mb-4"><?php esc_html_e( 'Listings, investor analytics, CRM, property management, tours and automated MLS imports — one platform that works together, instead of a dozen plugins that don\'t.', 'realwise' ); ?></p>
                <div class="d-flex gap-2 justify-content-center justify-content-lg-start flex-wrap mb-3">
                    <a href="<?php echo esc_url( $pricing_url ); ?>" class="btn btn-success btn-lg px-4"><i class="bi bi-rocket-takeoff me-2"></i><?php esc_html_e( 'Start free', 'realwise' ); ?></a>
                    <a href="<?php echo esc_url( $features_url ); ?>" class="btn btn-outline-primary btn-lg px-4"><?php esc_html_e( 'Explore features', 'realwise' ); ?></a>
                </div>
                <div class="rw-hero-trust d-flex align-items-center gap-2 justify-content-center justify-content-lg-start">
                    <span class="text-nowrap"><?php echo str_repeat( '<i class="bi bi-star-fill"></i>', 5 ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></span>
                    <span><?php esc_html_e( 'Loved by brokers, investors & property managers', 'realwise' ); ?></span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="rw-hero-visual rw-reveal">
                    <div class="rw-card rw-card--listing">
                        <div class="rw-card__photo">
                            <span class="rw-pill rw-pill--status"><?php esc_html_e( 'Active', 'realwise' ); ?></span>
                            <span class="rw-pill rw-pill--price">$524,900</span>
                        </div>
                        <div class="rw-card__body">
                            <div class="rw-card__addr">1428 Maple Ave, Austin TX</div>
                            <div class="rw-card__meta">
                                <span><i class="bi bi-door-open"></i> 3 bd</span>
                                <span><i class="bi bi-droplet-half"></i> 2 ba</span>
                                <span><i class="bi bi-rulers"></i> 1,840 sf</span>
                            </div>
                        </div>
                    </div>
                    <div class="rw-float rw-float--score">
                        <div class="rw-float__n"><span>92</span></div>
                        <div><div class="fw-bold" style="line-height:1"><?php esc_html_e( 'Deal score', 'realwise' ); ?></div><div class="rw-float__l"><?php esc_html_e( 'Strong buy', 'realwise' ); ?></div></div>
                    </div>
                    <div class="rw-float rw-float--lead"><i class="bi bi-person-check-fill me-1"></i><?php esc_html_e( 'New lead captured', 'realwise' ); ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───────── REPLACES STRIP ───────── -->
<section class="rw-replaces py-4">
    <div class="container text-center">
        <p class="rw-replaces__lead mb-2"><?php esc_html_e( 'One install replaces your', 'realwise' ); ?></p>
        <div class="rw-replaces__row">
            <span><i class="bi bi-search"></i> <?php esc_html_e( 'IDX plugin', 'realwise' ); ?></span>
            <span><i class="bi bi-people"></i> <?php esc_html_e( 'CRM', 'realwise' ); ?></span>
            <span><i class="bi bi-calendar-check"></i> <?php esc_html_e( 'Tour scheduler', 'realwise' ); ?></span>
            <span><i class="bi bi-building"></i> <?php esc_html_e( 'Property manager', 'realwise' ); ?></span>
            <span><i class="bi bi-graph-up-arrow"></i> <?php esc_html_e( 'Underwriting spreadsheet', 'realwise' ); ?></span>
        </div>
    </div>
</section>

<!-- ───────── PROBLEM ───────── -->
<section class="rw-section rw-section--mist">
    <div class="container">
        <div class="text-center mb-5 rw-reveal" style="max-width:760px;margin-inline:auto">
            <span class="rw-eyebrow"><?php esc_html_e( 'The problem', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'Most real-estate sites are held together with tape', 'realwise' ); ?></h2>
            <p class="text-muted mt-2"><?php esc_html_e( 'You bought a plugin for search, another for leads, a SaaS for tours, a spreadsheet for the numbers — and none of them talk to each other.', 'realwise' ); ?></p>
        </div>
        <div class="row g-4">
            <?php
            $problems = [
                [ 'bi-puzzle',          __( 'Plugin sprawl', 'realwise' ),  __( 'Five plugins from five vendors, five update cycles, and conflicts every time WordPress updates.', 'realwise' ) ],
                [ 'bi-diagram-3',       __( 'Data silos', 'realwise' ),     __( 'A lead in your CRM never knows about the tour they booked or the listing they saved. You reconcile it by hand.', 'realwise' ) ],
                [ 'bi-cash-stack',      __( 'Stacking SaaS bills', 'realwise' ), __( 'Each tool is "only" $30–$80/mo. Together they\'re a car payment — for software that half-works.', 'realwise' ) ],
            ];
            foreach ( $problems as $p ) :
                ?>
                <div class="col-md-4">
                    <div class="rw-prob h-100 rw-reveal">
                        <div class="rw-prob__icon"><i class="bi <?php echo esc_attr( $p[0] ); ?>"></i></div>
                        <h3 class="h5 fw-bold mt-2"><?php echo esc_html( $p[1] ); ?></h3>
                        <p class="text-muted mb-0"><?php echo esc_html( $p[2] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───────── FEATURES ───────── -->
<section class="rw-section">
    <div class="container">
        <div class="text-center mb-5 rw-reveal">
            <span class="rw-eyebrow"><?php esc_html_e( 'The solution', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'Six modules. One plugin. Built to work together.', 'realwise' ); ?></h2>
        </div>
        <div class="row g-4">
            <?php foreach ( $features as $f ) : ?>
                <div class="col-lg-4 col-md-6">
                    <div class="wpb-icon-box h-100 rw-reveal">
                        <div class="wpb-icon-box__icon"><i class="bi <?php echo esc_attr( $f[0] ); ?>"></i></div>
                        <h3 class="h5 fw-bold"><?php echo esc_html( $f[1] ); ?></h3>
                        <p class="text-muted mb-0"><?php echo esc_html( $f[2] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───────── COMPARISON ───────── -->
<section class="rw-section rw-section--mist">
    <div class="container">
        <div class="text-center mb-5 rw-reveal">
            <span class="rw-eyebrow"><?php esc_html_e( 'Why consolidate', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'A stack of point tools vs. one platform', 'realwise' ); ?></h2>
        </div>
        <div class="row g-4 justify-content-center rw-reveal">
            <div class="col-lg-5">
                <div class="rw-compare rw-compare--bad h-100">
                    <h3 class="h5 fw-bold mb-3"><?php esc_html_e( 'A typical plugin stack', 'realwise' ); ?></h3>
                    <ul class="rw-compare__list rw-compare__list--bad">
                        <li><?php esc_html_e( '5+ separate plugins & subscriptions', 'realwise' ); ?></li>
                        <li><?php esc_html_e( '$150–$400 / month, forever', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Multiple logins & dashboards', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Data scattered across vendors', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Conflicts on every WordPress update', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'You own none of it', 'realwise' ); ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="rw-compare rw-compare--good h-100">
                    <h3 class="h5 fw-bold mb-3"><?php esc_html_e( 'RealWise', 'realwise' ); ?></h3>
                    <ul class="rw-compare__list rw-compare__list--good">
                        <li><?php esc_html_e( 'One free plugin (+ optional MLS add-on)', 'realwise' ); ?></li>
                        <li><?php esc_html_e( '$0 to start · $149/yr for automated MLS', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'One admin, one login', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'One database — everything connected', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Modules designed to work together', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'GPL & self-hosted — you own it', 'realwise' ); ?></li>
                    </ul>
                    <?php echo realwise_buy_button( 'dl-free', __( 'Start free', 'realwise' ), 'btn btn-success w-100 mt-2', $pricing_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ───────── PRICING ───────── -->
<section class="rw-section">
    <div class="container">
        <div class="text-center mb-5 rw-reveal">
            <span class="rw-eyebrow"><?php esc_html_e( 'Simple pricing', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'Start free. Automate when you grow.', 'realwise' ); ?></h2>
        </div>
        <div class="row g-4 align-items-stretch justify-content-center">
            <div class="col-lg-5">
                <div class="rw-price h-100 rw-reveal">
                    <h3 class="fw-bold"><?php esc_html_e( 'RealWise', 'realwise' ); ?></h3>
                    <p class="text-muted"><?php esc_html_e( 'The complete platform · Free forever', 'realwise' ); ?></p>
                    <div class="rw-price__amt">$0</div>
                    <ul>
                        <li><?php esc_html_e( 'All six modules, no feature paywall', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Listings, search & maps', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Investor proformas & deal score', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'CRM, agent portal & tours', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Property management + online rent', 'realwise' ); ?></li>
                    </ul>
                    <?php echo realwise_buy_button( 'dl-free', __( 'Download free', 'realwise' ), 'btn btn-outline-primary btn-lg w-100', $pricing_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="rw-price rw-price--featured h-100 rw-reveal">
                    <h3 class="fw-bold"><?php esc_html_e( 'RealWise MLS', 'realwise' ); ?></h3>
                    <p class="text-muted"><?php esc_html_e( 'Automated MLS / IDX import', 'realwise' ); ?></p>
                    <div class="rw-price__amt">$149 <span class="rw-price__per"><?php esc_html_e( '/ year', 'realwise' ); ?></span></div>
                    <ul>
                        <li><?php esc_html_e( 'Everything in RealWise (free)', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'RESO Web API + all vendor presets', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Scheduled imports & field mapping', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'One year of updates', 'realwise' ); ?></li>
                        <li><?php esc_html_e( 'Priority email support', 'realwise' ); ?></li>
                    </ul>
                    <?php echo realwise_buy_button( 'dl-mls', __( 'Buy RealWise MLS', 'realwise' ), 'btn btn-success btn-lg w-100', $pricing_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                </div>
            </div>
        </div>
        <p class="text-center text-muted mt-3"><i class="bi bi-shield-check text-success me-1"></i><?php esc_html_e( 'No credit card to start · Cancel the MLS license anytime · The plugin keeps working', 'realwise' ); ?></p>
    </div>
</section>

<!-- ───────── TESTIMONIALS ───────── -->
<section class="rw-section rw-section--mist">
    <div class="container">
        <div class="text-center mb-5 rw-reveal">
            <span class="rw-eyebrow"><?php esc_html_e( 'Built for real workflows', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'One platform across every real-estate role', 'realwise' ); ?></h2>
            <p class="text-muted small mb-0"><?php esc_html_e( 'Illustrative scenarios showing how each role uses RealWise — not customer testimonials.', 'realwise' ); ?></p>
        </div>
        <div class="row g-4">
            <?php foreach ( $testimonials as $t ) : ?>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm h-100 rw-reveal">
                        <div class="card-body p-4">
                            <div class="rw-eyebrow mb-2"><i class="bi bi-diagram-3 me-1"></i><?php echo esc_html( $t[1] ); ?></div>
                            <p class="mb-3"><?php echo esc_html( $t[2] ); ?></p>
                            <p class="mb-0 fw-bold"><?php echo esc_html( $t[0] ); ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───────── RISK REVERSAL ───────── -->
<section class="rw-section">
    <div class="container">
        <div class="text-center mb-5 rw-reveal">
            <span class="rw-eyebrow"><?php esc_html_e( 'Buy with confidence', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'Yours to keep, on your terms', 'realwise' ); ?></h2>
        </div>
        <div class="row g-4">
            <?php foreach ( $pillars as $p ) : ?>
                <div class="col-md-6 col-lg-3">
                    <div class="rw-pillar h-100 rw-reveal">
                        <div class="rw-pillar__icon"><i class="bi <?php echo esc_attr( $p[0] ); ?>"></i></div>
                        <h3 class="h6 fw-bold mt-2"><?php echo esc_html( $p[1] ); ?></h3>
                        <p class="text-muted small mb-0"><?php echo esc_html( $p[2] ); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───────── FAQ ───────── -->
<section class="rw-section rw-section--mist">
    <div class="container" style="max-width:820px">
        <div class="text-center mb-5 rw-reveal">
            <span class="rw-eyebrow"><?php esc_html_e( 'Questions, answered', 'realwise' ); ?></span>
            <h2 class="mt-2"><?php esc_html_e( 'Everything you\'re wondering before you click buy', 'realwise' ); ?></h2>
        </div>
        <div class="accordion rw-faq rw-reveal" id="rwFaq">
            <?php foreach ( $faqs as $i => $faq ) : ?>
                <div class="accordion-item">
                    <h3 class="accordion-header">
                        <button class="accordion-button <?php echo 0 === $i ? '' : 'collapsed'; ?>" type="button" data-bs-toggle="collapse" data-bs-target="#rwq<?php echo (int) $i; ?>" aria-expanded="<?php echo 0 === $i ? 'true' : 'false'; ?>">
                            <?php echo esc_html( $faq[0] ); ?>
                        </button>
                    </h3>
                    <div id="rwq<?php echo (int) $i; ?>" class="accordion-collapse collapse <?php echo 0 === $i ? 'show' : ''; ?>" data-bs-parent="#rwFaq">
                        <div class="accordion-body text-muted"><?php echo esc_html( $faq[1] ); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ───────── FINAL CTA ───────── -->
<section class="rw-section">
    <div class="container">
        <div class="p-5 text-center rounded-4 rw-reveal" style="background:linear-gradient(135deg,#eef4ff,#f6faff);border:1px solid var(--rw-line);">
            <h2 class="fw-bold mb-2"><?php esc_html_e( 'Put your real-estate business on one platform — for free', 'realwise' ); ?></h2>
            <p class="lead mb-4 text-muted"><?php esc_html_e( 'Install RealWise today. Add automated MLS imports whenever you\'re ready. No credit card, no lock-in.', 'realwise' ); ?></p>
            <div class="d-flex gap-2 justify-content-center flex-wrap">
                <a href="<?php echo esc_url( $pricing_url ); ?>" class="btn btn-success btn-lg px-4"><i class="bi bi-rocket-takeoff me-2"></i><?php esc_html_e( 'Start free', 'realwise' ); ?></a>
                <a href="<?php echo esc_url( $features_url ); ?>" class="btn btn-outline-primary btn-lg px-4"><?php esc_html_e( 'See all features', 'realwise' ); ?></a>
            </div>
        </div>
    </div>
</section>

<?php
get_footer();
