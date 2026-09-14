<?php defined( 'ABSPATH' ) || exit; ?>
	<!-- ======================== SITE FOOTER ======================== -->
	<footer id="colophon" class="site-footer">
		<?php
		$wpwisebones_footer_cols = absint( get_theme_mod( 'wpwisebones_footer_columns', 4 ) );
		$wpwisebones_col_class   = 'col-sm-6 col-md-' . ( 12 / $wpwisebones_footer_cols );
		$wpwisebones_has_widgets = false;
		for ( $wpwisebones_i = 1; $wpwisebones_i <= $wpwisebones_footer_cols; $wpwisebones_i++ ) {
			if ( is_active_sidebar( 'footer-' . $wpwisebones_i ) ) {
				$wpwisebones_has_widgets = true;
				break; }
		}

		if ( $wpwisebones_has_widgets ) :
			?>
		<div class="footer-widgets">
			<div class="container">
				<div class="row g-4">
					<?php for ( $wpwisebones_i = 1; $wpwisebones_i <= $wpwisebones_footer_cols; $wpwisebones_i++ ) : ?>
						<?php if ( is_active_sidebar( 'footer-' . $wpwisebones_i ) ) : ?>
							<div class="<?php echo esc_attr( $wpwisebones_col_class ); ?>">
								<?php dynamic_sidebar( 'footer-' . $wpwisebones_i ); ?>
							</div>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
			</div>
		</div>
		<?php endif; ?>

		<div class="footer-bottom">
			<div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
				<div class="copyright">
					<?php echo wp_kses_post( get_theme_mod( 'wpwisebones_footer_copyright', sprintf( '&copy; %d %s', gmdate( 'Y' ), get_bloginfo( 'name' ) ) ) ); ?>
				</div>
				<nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer menu', 'wpwisebones' ); ?>">
					<?php wpwisebones_footer_nav(); ?>
				</nav>
				<div class="footer-social d-flex gap-2">
					<?php
					$wpwisebones_socials = array(
						'facebook'  => 'bi-facebook',
						'twitter'   => 'bi-twitter-x',
						'instagram' => 'bi-instagram',
						'linkedin'  => 'bi-linkedin',
						'youtube'   => 'bi-youtube',
						'github'    => 'bi-github',
					);
					foreach ( $wpwisebones_socials as $wpwisebones_key => $wpwisebones_icon ) :
						$wpwisebones_url = get_theme_mod( 'wpwisebones_social_' . $wpwisebones_key, '' );
						if ( $wpwisebones_url ) :
							?>
						<a href="<?php echo esc_url( $wpwisebones_url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $wpwisebones_key ) ); ?>">
							<i class="bi <?php echo esc_attr( $wpwisebones_icon ); ?>"></i>
						</a>
							<?php
						endif;
					endforeach;
					?>
				</div>
			</div>
		</div>
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php
// Back to top: admin options takes precedence; falls back to Customizer setting
$wpwisebones_o        = get_option( 'wpwisebones_options', array() );
$wpwisebones_show_b2t = isset( $wpwisebones_o['back_to_top'] ) ? (bool) $wpwisebones_o['back_to_top'] : (bool) get_theme_mod( 'wpwisebones_back_to_top', true );
if ( $wpwisebones_show_b2t ) :
	?>
<button id="back-to-top" class="btn btn-primary btn-sm rounded-circle shadow" aria-label="<?php esc_attr_e( 'Back to top', 'wpwisebones' ); ?>">
	<i class="bi bi-arrow-up"></i>
</button>
<?php endif; // back to top ?>

<?php wp_footer(); ?>
</body>
</html>
