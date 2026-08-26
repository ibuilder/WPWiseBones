<?php
/**
 * AEC Forge footer — a solid, branded multi-column footer that replaces the
 * parent theme's widget-dependent one (which rendered only a thin bar when no
 * footer widgets were set).
 *
 * @package AEC_Forge
 */

defined( 'ABSPATH' ) || exit;

$af_shop      = function_exists( 'aec_forge_shop_url' ) ? aec_forge_shop_url() : home_url( '/shop/' );
$af_register  = function_exists( 'aec_forge_market_url' ) ? aec_forge_market_url( 'vendor_register_page', '/become-a-vendor/' ) : home_url( '/become-a-vendor/' );
$af_dashboard = function_exists( 'aec_forge_market_url' ) ? aec_forge_market_url( 'vendor_dashboard_page', '/vendor-dashboard/' ) : home_url( '/vendor-dashboard/' );

$af_cols = array(
	__( 'Marketplace', 'aec-forge' )  => array(
		array( __( 'Browse all', 'aec-forge' ), $af_shop ),
		array( __( 'Programs & Scripts', 'aec-forge' ), add_query_arg( 'listing_type', 'program', $af_shop ) ),
		array( __( 'Services', 'aec-forge' ), add_query_arg( 'listing_type', 'service', $af_shop ) ),
		array( __( 'Become a Vendor', 'aec-forge' ), $af_register ),
	),
	__( 'For builders', 'aec-forge' ) => array(
		array( __( 'How It Works', 'aec-forge' ), home_url( '/how-it-works/' ) ),
		array( __( 'The Concept', 'aec-forge' ), home_url( '/the-concept/' ) ),
		array( __( 'Vendor Dashboard', 'aec-forge' ), $af_dashboard ),
	),
	__( 'Open source', 'aec-forge' )  => array(
		array( __( 'AEC Market plugin', 'aec-forge' ), 'https://github.com/ibuilder/aec-market' ),
		array( __( 'Plugin docs', 'aec-forge' ), 'https://ibuilder.github.io/aec-market/' ),
		array( __( 'License (GPL)', 'aec-forge' ), 'https://www.gnu.org/licenses/gpl-2.0.html' ),
	),
);
?>
	<footer id="colophon" class="site-footer af-footer">
		<div class="container">
			<div class="row gy-4 py-5">
				<div class="col-lg-4 pe-lg-5">
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="af-footer__brand">
						<img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/img/mark.svg' ); ?>" alt="" width="42" height="42">
						<span>AEC Forge</span>
					</a>
					<p class="af-footer__tag"><?php esc_html_e( 'The marketplace where AEC/BIM specialists, Excel experts and AI tool authors sell licensed tools and tiered services — side by side.', 'aec-forge' ); ?></p>
					<a href="<?php echo esc_url( $af_register ); ?>" class="btn btn-primary btn-sm"><i class="bi bi-hammer me-1"></i><?php esc_html_e( 'Sell your tools', 'aec-forge' ); ?></a>
				</div>

				<?php foreach ( $af_cols as $af_heading => $af_links ) : ?>
					<div class="col-6 col-lg-2<?php echo $af_heading === array_key_first( $af_cols ) ? ' offset-lg-1' : ''; ?>">
						<h2 class="af-footer__h"><?php echo esc_html( $af_heading ); ?></h2>
						<ul class="af-footer__links">
							<?php foreach ( $af_links as $af_l ) : ?>
								<li><a href="<?php echo esc_url( $af_l[1] ); ?>"><?php echo esc_html( $af_l[0] ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>

			<div class="af-footer__bottom d-flex flex-wrap justify-content-between align-items-center gap-2 py-4">
				<div>
					<?php
					printf(
						/* translators: %d: current year. */
						esc_html__( '© %d AEC Forge · Built on WordPress + WooCommerce', 'aec-forge' ),
						(int) gmdate( 'Y' )
					);
					?>
				</div>
				<div class="af-footer__legal">
					<a href="https://github.com/ibuilder/aec-market">GitHub</a>
					<a href="https://ibuilder.github.io/aec-market/"><?php esc_html_e( 'Docs', 'aec-forge' ); ?></a>
					<a href="<?php echo esc_url( $af_register ); ?>"><?php esc_html_e( 'Become a Vendor', 'aec-forge' ); ?></a>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<button id="back-to-top" class="af-b2t" aria-label="<?php esc_attr_e( 'Back to top', 'aec-forge' ); ?>">
	<i class="bi bi-arrow-up"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>
