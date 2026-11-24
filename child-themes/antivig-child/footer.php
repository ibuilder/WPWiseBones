<?php
/**
 * Site footer.
 *
 * Replaces the parent's four-column widget footer with a brand footer that
 * carries the things this site is obliged to carry: what it is not, the
 * helpline, and the legal links. Those are launch requirements, so they are
 * printed by the theme rather than left to widgets an owner could remove by
 * accident.
 *
 * Closes #page, which header.php opens.
 *
 * @package Antivig
 */

declare( strict_types = 1 );

defined( 'ABSPATH' ) || exit;

$antivig_year = gmdate( 'Y' );
?>

	<footer id="colophon" class="site-footer av-footer">
		<div class="container av-footer__inner">

			<div class="av-footer__brand">
				<a class="av-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
					<img
						src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/antivig-mark.svg' ); ?>"
						alt=""
						width="40"
						height="40"
						loading="lazy"
					>
					<span class="av-footer__name">ANTI<span>VIG</span></span>
				</a>

				<p class="av-footer__tagline">
					<?php esc_html_e( 'Fair prices, best lines, and every pick on the record.', 'antivig-child' ); ?>
				</p>
			</div>

			<nav class="av-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'antivig-child' ); ?>">
				<p class="av-label"><?php esc_html_e( 'The product', 'antivig-child' ); ?></p>
				<ul>
					<li><a href="<?php echo esc_url( antivig_url( 'today' ) ); ?>"><?php esc_html_e( "Today's board", 'antivig-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( antivig_url( 'ledger' ) ); ?>"><?php esc_html_e( 'The pick record', 'antivig-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( antivig_url( 'membership' ) ); ?>"><?php esc_html_e( 'Plans', 'antivig-child' ); ?></a></li>
					<li><a href="<?php echo esc_url( antivig_url( 'account' ) ); ?>"><?php esc_html_e( 'Your account', 'antivig-child' ); ?></a></li>
				</ul>
			</nav>

			<div class="av-footer__legal">
				<p class="av-label"><?php esc_html_e( 'Straight answers', 'antivig-child' ); ?></p>
				<ul>
					<li><?php esc_html_e( 'Antivig is not a sportsbook and takes no wagers.', 'antivig-child' ); ?></li>
					<li><?php esc_html_e( 'We hold no funds and pay no winnings.', 'antivig-child' ); ?></li>
					<li><?php esc_html_e( 'Analysis is not advice, and past results do not guarantee future results.', 'antivig-child' ); ?></li>
				</ul>

				<?php
				if ( has_nav_menu( 'antivig-legal' ) ) {
					wp_nav_menu(
						array(
							'theme_location' => 'antivig-legal',
							'container'      => false,
							'menu_class'     => 'av-footer__legal-links',
							'depth'          => 1,
							'fallback_cb'    => false,
						)
					);
				}
				?>
			</div>

		</div>

		<div class="av-footer__bottom">
			<div class="container av-footer__bottom-inner">
				<p>&copy; <?php echo esc_html( $antivig_year ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?></p>
				<p>
					<?php esc_html_e( 'Gambling problem?', 'antivig-child' ); ?>
					<a class="av-rg__line" href="tel:1-800-426-2537">1-800-GAMBLER</a>
					<span aria-hidden="true">·</span>
					<a href="https://www.ncpgambling.org/" rel="noopener noreferrer" target="_blank"><?php esc_html_e( 'ncpgambling.org', 'antivig-child' ); ?></a>
				</p>
			</div>
		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
