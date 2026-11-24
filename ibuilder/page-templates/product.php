<?php
/**
 * Template Name: iBuilder Product
 * Template Post Type: page
 *
 * A product page. The branded header — icon, price, buy and demo buttons — is
 * rendered from inc/products.php rather than written into the page content, so
 * a price change in the listing kit reaches every page by regenerating one
 * file instead of editing every page by hand.
 *
 * The page is matched to its product by the `_ibuilder_site_product` post
 * meta the site builder writes, not by its title. A page that has no such meta
 * falls through to an ordinary full-width page, so assigning this template by
 * hand cannot produce a broken header.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

get_header();

$ibs_p         = ibuilder_site_page_product();
$ibs_container = get_theme_mod( 'wpwisebones_container_width', 'container' );
?>

<?php if ( $ibs_p ) : ?>
	<?php
	$ibs_buy  = ibuilder_site_product_url( $ibs_p );
	$ibs_demo = ibuilder_site_demo_url( $ibs_p );
	$ibs_live = '' !== (string) $ibs_p['codester_url'];
	?>
	<header class="ibs-product-head">
		<div class="<?php echo esc_attr( $ibs_container ); ?>">
			<div class="row align-items-center g-4">
				<div class="col-lg-8">
					<div class="d-flex align-items-start gap-3">
						<span class="ibs-card__icon">
							<i class="bi bi-<?php echo esc_attr( $ibs_p['icon'] ); ?>" aria-hidden="true"></i>
						</span>
						<div>
							<h1><?php echo esc_html( $ibs_p['name'] ); ?></h1>
							<p class="lead mb-0 mt-2"><?php echo esc_html( $ibs_p['tagline'] ); ?></p>
						</div>
					</div>

					<ul class="ibs-meta">
						<li>
							<i class="bi bi-unlock" aria-hidden="true"></i>
							<?php esc_html_e( 'No license key or activation', 'ibuilder' ); ?>
						</li>
						<li>
							<i class="bi bi-file-earmark-code" aria-hidden="true"></i>
							<?php esc_html_e( 'Readable, editable source', 'ibuilder' ); ?>
						</li>
						<li>
							<i class="bi bi-book" aria-hidden="true"></i>
							<?php esc_html_e( 'Documentation in the zip', 'ibuilder' ); ?>
						</li>
						<li>
							<i class="bi bi-translate" aria-hidden="true"></i>
							<?php esc_html_e( 'Translation ready', 'ibuilder' ); ?>
						</li>
					</ul>
				</div>

				<div class="col-lg-4">
					<div class="ibs-card">
						<span class="ibs-price-tag">
							$<?php echo esc_html( $ibs_p['price'] ); ?>
							<small><?php esc_html_e( 'one-off', 'ibuilder' ); ?></small>
						</span>

						<p class="ibs-card__tagline mt-2 mb-3">
							<?php esc_html_e( 'Bought once, used on as many of your own sites as you like.', 'ibuilder' ); ?>
						</p>

						<?php
						/*
						 * The figure above is what we set on the listing. Codester adds its own
						 * buyer fee on top at checkout - the upload form calls it that - so a
						 * visitor who clicks Buy sees a higher number than the one they just
						 * read. The fee is a flat $5: measured across all seven live
						 * listings, from $29 to $79, every one came to exactly $5 more.
						 * That is enough to state the figure rather than hedge, which is
						 * what this said when only two listings were live and two points
						 * could not tell a flat fee from a percentage. See
						 * ibuilder_site_buyer_fee(), which is filterable - it is
						 * Codester's number and they can change it.
						 */
						?>
						<p class="ibs-fee-note">
							<?php
							printf(
								/* translators: 1: Codester's buyer fee. 2: total the buyer pays. */
								esc_html__( 'Codester adds a $%1$s buyer fee at checkout, so you pay $%2$s there.', 'ibuilder' ),
								esc_html( number_format_i18n( ibuilder_site_buyer_fee() ) ),
								esc_html( number_format_i18n( ibuilder_site_checkout_price( $ibs_p ) ) )
							);
							?>
						</p>

						<div class="ibs-card__actions">
							<a href="<?php echo esc_url( $ibs_buy ); ?>" class="btn btn-primary" rel="noopener">
								<i class="bi bi-box-arrow-up-right me-2" aria-hidden="true"></i>
								<?php
								// Be honest about where the button lands. Until a
								// listing is live the URL is the profile page, and
								// labelling that "Buy" would be a small lie the
								// visitor discovers one click later.
								echo $ibs_live
									? esc_html__( 'Buy on Codester', 'ibuilder' )
									: esc_html__( 'See it on Codester', 'ibuilder' );
								?>
							</a>

							<?php if ( '' !== $ibs_demo ) : ?>
								<a href="<?php echo esc_url( $ibs_demo ); ?>" class="btn btn-outline-primary">
									<i class="bi bi-play-circle me-2" aria-hidden="true"></i>
									<?php esc_html_e( 'Try the demo', 'ibuilder' ); ?>
								</a>
							<?php endif; ?>
						</div>

						<?php if ( ! $ibs_live ) : ?>
							<p class="mt-3 mb-0" style="font-size:.84rem;color:var(--ibs-slate-2)">
								<?php esc_html_e( 'This listing is not published yet — the button goes to the seller profile.', 'ibuilder' ); ?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</header>
<?php endif; ?>

<div id="content" class="site-content">
	<div class="<?php echo esc_attr( $ibs_container ); ?>">
		<div class="row g-4">
			<main id="main" tabindex="-1" class="site-main col-12">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<div class="entry-content py-4">
						<?php the_content(); ?>
					</div>
					<?php
				endwhile;
				?>

				<?php
				/*
				 * The screenshots. These are the same images the Codester
				 * listing carries, with the captions written when they were
				 * taken - see inc/screenshots.php, which is generated from the
				 * kits. They are clipped to a uniform window from the top,
				 * because the set mixes 1440x941 viewport shots with
				 * 1440x2600 full-page ones and a grid of both at natural
				 * height is unreadable. The full image is one click away.
				 */
				$ibs_shots = ( $ibs_p && function_exists( 'ibuilder_site_screenshots' ) )
					? ibuilder_site_screenshots( (string) $ibs_p['key'] )
					: array();

				if ( $ibs_shots ) :
					$ibs_shots_base = get_stylesheet_directory_uri() . '/assets/img/screens/'
						. rawurlencode( (string) $ibs_p['key'] ) . '/';
					?>
					<section class="ibs-shots" aria-labelledby="ibs-shots-heading">
						<h2 id="ibs-shots-heading" class="ibs-shots__title">
							<?php esc_html_e( 'What it looks like', 'ibuilder' ); ?>
						</h2>
						<p class="ibs-shots__note">
							<?php esc_html_e( 'Screens from a working install, not mock-ups. Open any one for the full image.', 'ibuilder' ); ?>
						</p>

						<ul class="ibs-shots__grid">
							<?php foreach ( $ibs_shots as $ibs_shot ) : ?>
								<?php $ibs_src = $ibs_shots_base . rawurlencode( (string) $ibs_shot['file'] ); ?>
								<li class="ibs-shots__item<?php echo empty( $ibs_shot['hero'] ) ? '' : ' is-hero'; ?>">
									<figure class="ibs-shots__figure">
										<a class="ibs-shots__frame" href="<?php echo esc_url( $ibs_src ); ?>">
											<img
												src="<?php echo esc_url( $ibs_src ); ?>"
												width="<?php echo (int) $ibs_shot['w']; ?>"
												height="<?php echo (int) $ibs_shot['h']; ?>"
												loading="lazy"
												decoding="async"
												alt="<?php echo esc_attr( $ibs_shot['caption'] ); ?>"
											>
										</a>
										<figcaption class="ibs-shots__caption">
											<?php echo esc_html( $ibs_shot['caption'] ); ?>
										</figcaption>
									</figure>
								</li>
							<?php endforeach; ?>
						</ul>
					</section>
				<?php endif; ?>

				<?php if ( $ibs_p ) : ?>
					<div class="ibs-nolicense mb-4">
						<i class="bi bi-hdd-network" aria-hidden="true"></i>
						<div>
							<strong><?php esc_html_e( 'What it talks to', 'ibuilder' ); ?></strong>
							<p>
								<?php esc_html_e( 'Every external service this plugin can contact is named in its readme.txt, under "External services", with what is sent and why. Where a service is optional it takes your own API key, and leaving the key blank leaves the feature off rather than breaking the plugin.', 'ibuilder' ); ?>
							</p>
						</div>
					</div>

					<p>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>#products" class="btn btn-outline-primary btn-sm">
							<i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
							<?php
							printf(
								/* translators: %d: number of products. */
								esc_html__( 'All %d plugins', 'ibuilder' ),
								count( ibuilder_site_products() )
							);
							?>
						</a>
					</p>
				<?php endif; ?>
			</main>
		</div>
	</div>
</div>

<?php
get_footer();
