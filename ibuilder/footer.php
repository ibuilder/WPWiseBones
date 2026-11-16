<?php
/**
 * iBuilder footer — a branded multi-column footer.
 *
 * Replaces the parent's, which renders only a thin bar when no footer widgets
 * are set, and a vendor site's footer is load-bearing: it is where a buyer
 * looks for the support link and for evidence that somebody is behind this.
 *
 * The product column is built from inc/products.php, so it cannot fall out of
 * step with the catalogue.
 *
 * Two things the parent's footer does that this one has to do as well, because
 * overriding a footer silently drops whatever it was carrying:
 *
 *   1. `header.php` opens `<div id="page" class="site">` and never closes it —
 *      measured: the parent's header leaves exactly one div open and its
 *      footer closes exactly one extra. Forget that and every page ships with
 *      unclosed markup.
 *   2. It renders the back-to-top button, honouring the admin option first and
 *      the Customizer setting second. Same logic is reproduced here rather
 *      than quietly removing the feature.
 *
 * @package iBuilder
 */

defined( 'ABSPATH' ) || exit;

$ibs_products = function_exists( 'ibuilder_site_products' ) ? ibuilder_site_products() : array();
$ibs_demo     = function_exists( 'ibuilder_site_demo_base' ) ? ibuilder_site_demo_base() : '';
$ibs_half     = (int) ceil( count( $ibs_products ) / 2 );
?>

<footer class="ibs-footer" role="contentinfo">
	<div class="container">
		<div class="row g-4">

			<div class="col-lg-4">
				<span class="ibs-footer__brand"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
				<p style="max-width:28rem">
					<?php esc_html_e( 'WordPress plugins for property, construction and the back office. No licence keys, no activation, no phone-home — and the source stays readable.', 'ibuilder' ); ?>
				</p>
				<p class="mt-3 mb-0">
					<a href="<?php echo esc_url( IBUILDER_SITE_PROFILE_URL ); ?>" rel="noopener">
						<i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>
						<?php esc_html_e( 'All listings on Codester', 'ibuilder' ); ?>
					</a>
				</p>
			</div>

			<?php if ( $ibs_products ) : ?>
				<div class="col-sm-6 col-lg-3">
					<h3><?php esc_html_e( 'Plugins', 'ibuilder' ); ?></h3>
					<ul>
						<?php foreach ( array_slice( $ibs_products, 0, $ibs_half ) as $ibs_p ) : ?>
							<?php
							$ibs_page = get_page_by_path( $ibs_p['key'] );
							$ibs_href = $ibs_page ? get_permalink( $ibs_page ) : ibuilder_site_product_url( $ibs_p );
							?>
							<li><a href="<?php echo esc_url( $ibs_href ); ?>"><?php echo esc_html( $ibs_p['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>

				<div class="col-sm-6 col-lg-3">
					<h3 class="d-none d-sm-block" aria-hidden="true">&nbsp;</h3>
					<ul>
						<?php foreach ( array_slice( $ibs_products, $ibs_half ) as $ibs_p ) : ?>
							<?php
							$ibs_page = get_page_by_path( $ibs_p['key'] );
							$ibs_href = $ibs_page ? get_permalink( $ibs_page ) : ibuilder_site_product_url( $ibs_p );
							?>
							<li><a href="<?php echo esc_url( $ibs_href ); ?>"><?php echo esc_html( $ibs_p['label'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<div class="col-sm-6 col-lg-2">
				<h3><?php esc_html_e( 'More', 'ibuilder' ); ?></h3>
				<ul>
					<?php if ( '' !== $ibs_demo ) : ?>
						<li><a href="<?php echo esc_url( $ibs_demo ); ?>"><?php esc_html_e( 'Live demo', 'ibuilder' ); ?></a></li>
					<?php endif; ?>
					<?php
					foreach ( array(
						'docs'    => __( 'Documentation', 'ibuilder' ),
						'support' => __( 'Support', 'ibuilder' ),
						'about'   => __( 'About', 'ibuilder' ),
					) as $ibs_slug => $ibs_label ) :
						$ibs_page = get_page_by_path( $ibs_slug );
						if ( ! $ibs_page ) {
							continue;
						}
						?>
						<li><a href="<?php echo esc_url( get_permalink( $ibs_page ) ); ?>"><?php echo esc_html( $ibs_label ); ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>

		<div class="ibs-footer__bottom">
			<span>
				<?php
				printf(
					/* translators: 1: year, 2: site name. */
					esc_html__( '© %1$s %2$s. All plugins GPL v2 or later.', 'ibuilder' ),
					esc_html( gmdate( 'Y' ) ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</span>
			<span>
				<?php esc_html_e( 'No trackers and no third-party requests on this site.', 'ibuilder' ); ?>
			</span>
		</div>
	</div>
</footer>

</div><!-- #page — opened in the parent's header.php -->

<?php
// Back to top, matching the parent's precedence: the admin option wins, then
// the Customizer setting, defaulting to on.
$ibs_opts = get_option( 'wpwisebones_options', array() );
$ibs_b2t  = isset( $ibs_opts['back_to_top'] )
	? (bool) $ibs_opts['back_to_top']
	: (bool) get_theme_mod( 'wpwisebones_back_to_top', true );

if ( $ibs_b2t ) :
	?>
	<button id="back-to-top" class="btn btn-primary btn-sm rounded-circle shadow" aria-label="<?php esc_attr_e( 'Back to top', 'ibuilder' ); ?>">
		<i class="bi bi-arrow-up" aria-hidden="true"></i>
	</button>
	<?php
endif;
?>

<?php wp_footer(); ?>
</body>
</html>
