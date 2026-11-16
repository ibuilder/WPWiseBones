<?php
/**
 * Template Name: iBuilder Product
 * Template Post Type: page
 *
 * A product page. The branded header — icon, price, buy and demo buttons — is
 * rendered from inc/products.php rather than written into the page content, so
 * a price change in the listing kit reaches every page by regenerating one
 * file instead of editing eight pages.
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
							<?php esc_html_e( 'No licence key or activation', 'ibuilder' ); ?>
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

				<?php if ( $ibs_p ) : ?>
					<div class="ibs-nolicence mb-4">
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
							<?php esc_html_e( 'All eight plugins', 'ibuilder' ); ?>
						</a>
					</p>
				<?php endif; ?>
			</main>
		</div>
	</div>
</div>

<?php
get_footer();
