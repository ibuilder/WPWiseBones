<?php
/**
 * iBuilder front page — presents the eight plugins and sends buyers to Codester.
 *
 * Self-contained: Bootstrap 5 and Bootstrap Icons come from the parent, the
 * brand classes from assets/css/ibuilder.css. Every product fact on this page
 * is read from inc/products.php, which is generated from the Codester listing
 * kits — so the price and pitch here cannot disagree with the listing the
 * button links to.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ibs_products = ibuilder_site_products();
$ibs_demo     = ibuilder_site_demo_base();

// The hero figure shows the first four, which is as many as fits without
// scrolling on a laptop.
$ibs_featured = array_slice( $ibs_products, 0, 4 );

$ibs_total = 0;
foreach ( $ibs_products as $ibs_p ) {
	$ibs_total += (float) $ibs_p['price'];
}
?>

<!-- ───────── HERO ───────── -->
<section class="ibs-hero">
	<div class="container">
		<div class="row align-items-center g-5">
			<div class="col-lg-7">
				<span class="ibs-badge">
					<span class="dot"></span>
					<?php
					printf(
						/* translators: %d: number of plugins. */
						esc_html( _n( '%d WordPress plugin for property and construction', '%d WordPress plugins for property and construction', count( $ibs_products ), 'ibuilder' ) ),
						count( $ibs_products )
					);
					?>
				</span>

				<h1 class="mt-3 mb-3"><?php esc_html_e( 'Serious WordPress plugins, with the licensing left out', 'ibuilder' ); ?></h1>

				<p class="lead mb-4">
					<?php esc_html_e( 'Real estate, construction management, double-entry accounting, a 3D product configurator, a multi-vendor marketplace. Built for the work, not for a feature list — and every one of them runs on your own server with nothing to register and nothing phoning home.', 'ibuilder' ); ?>
				</p>

				<div class="d-flex gap-2 flex-wrap mb-2">
					<a href="#products" class="btn btn-primary btn-lg">
						<i class="bi bi-grid-3x3-gap me-2" aria-hidden="true"></i><?php esc_html_e( 'See the plugins', 'ibuilder' ); ?>
					</a>
					<?php if ( '' !== $ibs_demo ) : ?>
						<a href="<?php echo esc_url( $ibs_demo ); ?>" class="btn btn-outline-primary btn-lg">
							<i class="bi bi-play-circle me-2" aria-hidden="true"></i><?php esc_html_e( 'Open the live demo', 'ibuilder' ); ?>
						</a>
					<?php endif; ?>
				</div>

				<ul class="ibs-hero-points">
					<li>
						<i class="bi bi-shield-check" aria-hidden="true"></i>
						<span><?php esc_html_e( 'No licence key, no activation, no domain lock — nothing to register and no server of ours in the loop.', 'ibuilder' ); ?></span>
					</li>
					<li>
						<i class="bi bi-code-slash" aria-hidden="true"></i>
						<span><?php esc_html_e( 'Readable, editable PHP. Nothing encrypted, nothing obfuscated, every template overridable from your theme.', 'ibuilder' ); ?></span>
					</li>
					<li>
						<i class="bi bi-hdd-network" aria-hidden="true"></i>
						<span><?php esc_html_e( 'Third-party services are optional and take your own API keys. Leave them blank and the plugin still works.', 'ibuilder' ); ?></span>
					</li>
				</ul>
			</div>

			<div class="col-lg-5">
				<div class="ibs-stack" aria-hidden="true">
					<?php foreach ( $ibs_featured as $ibs_p ) : ?>
						<div class="ibs-stack-row">
							<i class="bi bi-<?php echo esc_attr( $ibs_p['icon'] ); ?>"></i>
							<span class="ibs-stack-name"><?php echo esc_html( $ibs_p['name'] ); ?></span>
							<span class="ibs-stack-price">$<?php echo esc_html( $ibs_p['price'] ); ?></span>
						</div>
					<?php endforeach; ?>
					<div class="ibs-stack-row" style="justify-content:center">
						<span class="ibs-stack-name" style="margin:0;color:var(--ibs-slate)">
							<?php
							printf(
								/* translators: %d: number of further plugins. */
								esc_html__( '+ %d more', 'ibuilder' ),
								max( 0, count( $ibs_products ) - count( $ibs_featured ) )
							);
							?>
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ───────── THE CLAIM THAT MATTERS ───────── -->
<section class="ibs-section ibs-section--tint" style="padding-block:2rem">
	<div class="container">
		<div class="ibs-nolicence">
			<i class="bi bi-unlock" aria-hidden="true"></i>
			<div>
				<strong><?php esc_html_e( 'Why there is no licence key', 'ibuilder' ); ?></strong>
				<p>
					<?php esc_html_e( 'A licence check is a thing that can break your site when a server you do not control goes down, and a reason you cannot move a site to a new domain on a Friday. None of these plugins has one. You buy the zip, you install it, it works — on as many of your own sites as you like, forever, with no key to paste and no call home to fail. Each readme states plainly which external services the plugin can talk to, and most of them talk to none.', 'ibuilder' ); ?>
				</p>
			</div>
		</div>
	</div>
</section>

<!-- ───────── THE PRODUCTS ───────── -->
<section class="ibs-section" id="products">
	<div class="container">
		<div class="row mb-4">
			<div class="col-lg-8">
				<span class="ibs-eyebrow"><?php esc_html_e( 'The catalogue', 'ibuilder' ); ?></span>
				<h2 class="mt-2 mb-2"><?php esc_html_e( 'Eight plugins, sold separately', 'ibuilder' ); ?></h2>
				<p class="lead mb-0">
					<?php
					printf(
						/* translators: 1: total price of every plugin. */
						esc_html__( 'Each one does a whole job rather than part of one. Buy the one you need; the lot comes to $%s.', 'ibuilder' ),
						esc_html( number_format_i18n( $ibs_total ) )
					);
					?>
				</p>
			</div>
		</div>

		<div class="ibs-grid">
			<?php
			foreach ( $ibs_products as $ibs_p ) :
				$ibs_page = get_page_by_path( $ibs_p['key'] );
				$ibs_href = $ibs_page ? get_permalink( $ibs_page ) : ibuilder_site_product_url( $ibs_p );
				$ibs_demo_href = ibuilder_site_demo_url( $ibs_p );
				?>
				<article class="ibs-card">
					<div class="ibs-card__head">
						<span class="ibs-card__icon">
							<i class="bi bi-<?php echo esc_attr( $ibs_p['icon'] ); ?>" aria-hidden="true"></i>
						</span>
						<h3 class="ibs-card__title">
							<a href="<?php echo esc_url( $ibs_href ); ?>"><?php echo esc_html( $ibs_p['name'] ); ?></a>
						</h3>
						<span class="ibs-card__price">$<?php echo esc_html( $ibs_p['price'] ); ?></span>
					</div>

					<p class="ibs-card__tagline"><?php echo esc_html( $ibs_p['tagline'] ); ?></p>

					<ul class="ibs-card__features">
						<?php foreach ( $ibs_p['features'] as $ibs_f ) : ?>
							<li><?php echo esc_html( $ibs_f ); ?></li>
						<?php endforeach; ?>
					</ul>

					<div class="ibs-card__actions">
						<a href="<?php echo esc_url( $ibs_href ); ?>" class="btn btn-primary btn-sm">
							<?php esc_html_e( 'Details', 'ibuilder' ); ?>
						</a>
						<?php if ( '' !== $ibs_demo_href ) : ?>
							<a href="<?php echo esc_url( $ibs_demo_href ); ?>" class="btn btn-outline-primary btn-sm">
								<?php esc_html_e( 'Try it', 'ibuilder' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ───────── WHAT YOU GET ───────── -->
<section class="ibs-section ibs-section--ink">
	<div class="container">
		<div class="row mb-4">
			<div class="col-lg-8">
				<span class="ibs-eyebrow"><?php esc_html_e( 'What every one of them ships with', 'ibuilder' ); ?></span>
				<h2 class="mt-2 mb-0"><?php esc_html_e( 'The things you only notice when they are missing', 'ibuilder' ); ?></h2>
			</div>
		</div>

		<ul class="ibs-trust">
			<li>
				<strong><?php esc_html_e( 'Documentation in the zip', 'ibuilder' ); ?></strong>
				<span><?php esc_html_e( 'Not a link to a wiki that may not be there next year. The docs ship with the code.', 'ibuilder' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Its own database tables', 'ibuilder' ); ?></strong>
				<span><?php esc_html_e( 'Where the data warrants it, rather than bending wp_posts until it stops being fast.', 'ibuilder' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'A clean uninstall', 'ibuilder' ); ?></strong>
				<span><?php esc_html_e( 'Delete the plugin and it takes its tables, options and scheduled events with it. Tested, not assumed.', 'ibuilder' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Overridable templates', 'ibuilder' ); ?></strong>
				<span><?php esc_html_e( 'Drop a copy into your theme and the plugin uses yours. The markup is yours to own.', 'ibuilder' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Capability checks that hold', 'ibuilder' ); ?></strong>
				<span><?php esc_html_e( 'Every REST route and AJAX handler is gated on a capability or scoped to its own user.', 'ibuilder' ); ?></span>
			</li>
			<li>
				<strong><?php esc_html_e( 'Translation ready', 'ibuilder' ); ?></strong>
				<span><?php esc_html_e( 'A .pot file in the zip and every string wrapped, so it can be translated without touching the code.', 'ibuilder' ); ?></span>
			</li>
		</ul>
	</div>
</section>

<!-- ───────── CLOSE ───────── -->
<section class="ibs-section ibs-section--tint">
	<div class="container text-center">
		<h2 class="mb-3"><?php esc_html_e( 'Have a look before you spend anything', 'ibuilder' ); ?></h2>
		<p class="lead mx-auto mb-4" style="max-width:40rem">
			<?php
			if ( '' !== $ibs_demo ) {
				esc_html_e( 'The demo is a real WordPress install with all eight plugins active and seeded with data. It resets every hour, so you can break whatever you like.', 'ibuilder' );
			} else {
				esc_html_e( 'Every listing carries the full description, the requirements and the readme, so you can see exactly what you are buying before you buy it.', 'ibuilder' );
			}
			?>
		</p>
		<div class="d-flex gap-2 justify-content-center flex-wrap">
			<?php if ( '' !== $ibs_demo ) : ?>
				<a href="<?php echo esc_url( $ibs_demo ); ?>" class="btn btn-primary btn-lg">
					<i class="bi bi-play-circle me-2" aria-hidden="true"></i><?php esc_html_e( 'Open the demo', 'ibuilder' ); ?>
				</a>
			<?php endif; ?>
			<a href="<?php echo esc_url( IBUILDER_SITE_PROFILE_URL ); ?>" class="btn btn-dark btn-lg" rel="noopener">
				<i class="bi bi-box-arrow-up-right me-2" aria-hidden="true"></i><?php esc_html_e( 'All listings on Codester', 'ibuilder' ); ?>
			</a>
		</div>
	</div>
</section>

<?php
get_footer();
