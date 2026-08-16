<?php
/**
 * RealWise footer — a solid, branded multi-column footer that replaces the
 * parent's widget-dependent one.
 */

defined( 'ABSPATH' ) || exit;

$rw_cols = [
    __( 'Product', 'realwise' ) => [
        [ __( 'Features', 'realwise' ), home_url( '/features/' ) ],
        [ __( 'Pricing', 'realwise' ),  home_url( '/pricing/' ) ],
        [ __( 'Docs', 'realwise' ),     home_url( '/docs/' ) ],
        [ __( 'Store', 'realwise' ),    home_url( '/store/' ) ],
    ],
    __( 'Company', 'realwise' ) => [
        [ __( 'About', 'realwise' ),   home_url( '/about/' ) ],
        [ __( 'Blog', 'realwise' ),    home_url( '/blog/' ) ],
        [ __( 'Contact', 'realwise' ), home_url( '/contact/' ) ],
    ],
    __( 'Get the plugins', 'realwise' ) => [
        [ __( 'RealWise (free)', 'realwise' ), home_url( '/store/' ) ],
        [ __( 'RealWise MLS', 'realwise' ),    home_url( '/store/' ) ],
        [ __( 'Support', 'realwise' ),         'https://wprealwise.com/support' ],
        [ __( 'WPRealWise.com', 'realwise' ),  'https://wprealwise.com' ],
    ],
];
?>
    <footer id="colophon" class="site-footer rw-footer">
        <div class="container">
            <div class="row gy-4 py-5">
                <div class="col-lg-4 pe-lg-5">
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="rw-footer__brand">
                        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/realwise-mark.svg' ); ?>" alt="" width="40" height="40">
                        <span>RealWise</span>
                    </a>
                    <p class="rw-footer__tag"><?php esc_html_e( 'The complete real-estate platform for WordPress — listings, investor tools, CRM, property management, tours and automated MLS, in one plugin.', 'realwise' ); ?></p>
                    <a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>" class="btn btn-success btn-sm"><i class="bi bi-rocket-takeoff me-1"></i><?php esc_html_e( 'Start free', 'realwise' ); ?></a>
                </div>
                <?php foreach ( $rw_cols as $heading => $links ) : ?>
                    <div class="col-6 col-lg-2<?php echo $heading === array_key_first( $rw_cols ) ? ' offset-lg-1' : ''; ?>">
                        <h4 class="rw-footer__h"><?php echo esc_html( $heading ); ?></h4>
                        <ul class="rw-footer__links">
                            <?php foreach ( $links as $l ) : ?>
                                <li><a href="<?php echo esc_url( $l[1] ); ?>"><?php echo esc_html( $l[0] ); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="rw-footer__bottom d-flex flex-wrap justify-content-between align-items-center gap-2 py-4">
                <div>
                    <?php
                    printf(
                        /* translators: %d is the current year. */
                        esc_html__( '© %d WPRealWise.com · Built on WordPress', 'realwise' ),
                        (int) gmdate( 'Y' )
                    );
                    ?>
                </div>
                <div class="rw-footer__legal">
                    <a href="https://wprealwise.com/terms"><?php esc_html_e( 'Terms', 'realwise' ); ?></a>
                    <a href="https://wprealwise.com/privacy"><?php esc_html_e( 'Privacy', 'realwise' ); ?></a>
                    <a href="https://wprealwise.com/support"><?php esc_html_e( 'Support', 'realwise' ); ?></a>
                </div>
            </div>
        </div>
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php
$wpb_o    = get_option( 'wpb_options', [] );
$show_b2t = isset( $wpb_o['back_to_top'] ) ? (bool) $wpb_o['back_to_top'] : (bool) get_theme_mod( 'wpb_back_to_top', true );
if ( $show_b2t ) :
    ?>
<button id="back-to-top" class="btn btn-primary btn-sm rounded-circle shadow" aria-label="<?php esc_attr_e( 'Back to top', 'realwise' ); ?>">
    <i class="bi bi-arrow-up"></i>
</button>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>
