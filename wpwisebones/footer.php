    <!-- ======================== SITE FOOTER ======================== -->
    <footer id="colophon" class="site-footer">
        <?php
        $footer_cols = absint( get_theme_mod( 'wpb_footer_columns', 4 ) );
        $col_class   = 'col-sm-6 col-md-' . ( 12 / $footer_cols );
        $has_widgets = false;
        for ( $i = 1; $i <= $footer_cols; $i++ ) {
            if ( is_active_sidebar( 'footer-' . $i ) ) { $has_widgets = true; break; }
        }

        if ( $has_widgets ) :
        ?>
        <div class="footer-widgets">
            <div class="container">
                <div class="row g-4">
                    <?php for ( $i = 1; $i <= $footer_cols; $i++ ) : ?>
                        <?php if ( is_active_sidebar( 'footer-' . $i ) ) : ?>
                            <div class="<?php echo esc_attr( $col_class ); ?>">
                                <?php dynamic_sidebar( 'footer-' . $i ); ?>
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
                    <?php echo wp_kses_post( get_theme_mod( 'wpb_footer_copyright', sprintf( '&copy; %d %s', gmdate( 'Y' ), get_bloginfo( 'name' ) ) ) ); ?>
                </div>
                <nav class="footer-nav" aria-label="<?php esc_attr_e( 'Footer menu', 'wpwisebones' ); ?>">
                    <?php wpb_footer_nav(); ?>
                </nav>
                <div class="footer-social d-flex gap-2">
                    <?php
                    $socials = [ 'facebook'=>'bi-facebook','twitter'=>'bi-twitter-x','instagram'=>'bi-instagram','linkedin'=>'bi-linkedin','youtube'=>'bi-youtube','github'=>'bi-github' ];
                    foreach ( $socials as $key => $icon ) :
                        $url = get_theme_mod( 'wpb_social_' . $key, '' );
                        if ( $url ) :
                    ?>
                        <a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( ucfirst( $key ) ); ?>">
                            <i class="bi <?php echo esc_attr( $icon ); ?>"></i>
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
$wpb_o   = get_option( 'wpb_options', [] );
$show_b2t = isset( $wpb_o['back_to_top'] ) ? (bool) $wpb_o['back_to_top'] : (bool) get_theme_mod( 'wpb_back_to_top', true );
if ( $show_b2t ) : ?>
<button id="back-to-top" class="btn btn-primary btn-sm rounded-circle shadow" aria-label="<?php esc_attr_e( 'Back to top', 'wpwisebones' ); ?>">
    <i class="bi bi-arrow-up"></i>
</button>
<?php endif; // back to top ?>

<?php wp_footer(); ?>
</body>
</html>
