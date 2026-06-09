<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php
$wpb_options = get_option( 'wpb_options', [] );
if ( ! empty( $wpb_options['preloader'] ) ) :
?>
<div id="wpb-preloader" role="status" aria-label="<?php esc_attr_e( 'Loading', 'wpwisebones' ); ?>">
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden"><?php esc_html_e( 'Loadingâ€¦', 'wpwisebones' ); ?></span>
    </div>
</div>

<?php endif; ?>

<a class="skip-link visually-hidden-focusable" href="#primary"><?php esc_html_e( 'Skip to content', 'wpwisebones' ); ?></a>

<?php
// Top bar
if ( get_theme_mod( 'wpb_show_topbar', false ) ) :
    $topbar_text = get_theme_mod( 'wpb_topbar_text', '' );
    if ( $topbar_text ) :
?>
<div class="wpb-topbar bg-dark text-white py-1 small text-center">
    <div class="container"><?php echo wp_kses_post( $topbar_text ); ?></div>
</div>
<?php
    endif;
endif;

$header_style = get_theme_mod( 'wpb_header_style', 'light' );
$container    = get_theme_mod( 'wpb_container_width', 'container' );
?>

<!-- ======================== SITE HEADER ======================== -->
<header id="masthead" class="site-header navbar navbar-expand-lg navbar-<?php echo esc_attr( $header_style ); ?>">
    <div class="<?php echo esc_attr( $container ); ?> d-flex align-items-center">

        <!-- Branding -->
        <div class="site-branding me-4">
            <?php wpb_site_branding(); ?>
            <?php if ( display_header_text() && get_bloginfo( 'description' ) ) : ?>
                <p class="site-description d-none d-lg-block"><?php bloginfo( 'description' ); ?></p>
            <?php endif; ?>
        </div>

        <!-- Mobile toggler -->
        <button class="navbar-toggler ms-auto me-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#primaryNavbar" aria-controls="primaryNavbar"
                aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'wpwisebones' ); ?>">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Nav -->
        <div class="collapse navbar-collapse" id="primaryNavbar">
            <nav id="site-navigation" class="main-navigation w-100" aria-label="<?php esc_attr_e( 'Primary menu', 'wpwisebones' ); ?>">
                <?php wpb_primary_nav(); ?>
            </nav>

            <!-- Header widgets (search, cart, etc.) -->
            <?php if ( is_active_sidebar( 'header-widgets' ) ) : ?>
                <div class="header-widget-area d-flex align-items-center">
                    <?php dynamic_sidebar( 'header-widgets' ); ?>
                </div>
            <?php else : ?>
                <?php get_search_form(); ?>
            <?php endif; ?>
        </div>
    </div>
</header><!-- #masthead -->

<!-- ======================== MAIN WRAP ======================== -->
<div id="page" class="site">
