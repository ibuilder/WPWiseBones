<?php
/**
 * Theme Customizer settings.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'customize_register', 'wpwisebones_customize_register' );

function wpwisebones_customize_register( WP_Customize_Manager $wp_customize ) {

    /* â”€â”€ Panel: WPWiseBones â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_panel( 'wpwisebones_panel', [
        'title'    => __( 'WPWiseBones', 'wpwisebones' ),
        'priority' => 30,
    ] );

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Header
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_header', [
        'title'    => __( 'Header Settings', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 10,
    ] );

    // Sticky header
    $wp_customize->add_setting( 'wpwisebones_sticky_header', [
        'default'           => true,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_sticky_header', [
        'label'   => __( 'Sticky Header', 'wpwisebones' ),
        'section' => 'wpwisebones_header',
        'type'    => 'checkbox',
    ] );

    // Header style (light / dark)
    $wp_customize->add_setting( 'wpwisebones_header_style', [
        'default'           => 'light',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_header_style', [
        'label'   => __( 'Header Colour Scheme', 'wpwisebones' ),
        'section' => 'wpwisebones_header',
        'type'    => 'select',
        'choices' => [
            'light' => __( 'Light', 'wpwisebones' ),
            'dark'  => __( 'Dark',  'wpwisebones' ),
        ],
    ] );

    // Top bar
    $wp_customize->add_setting( 'wpwisebones_show_topbar', [
        'default'           => false,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_show_topbar', [
        'label'   => __( 'Show Top Bar', 'wpwisebones' ),
        'section' => 'wpwisebones_header',
        'type'    => 'checkbox',
    ] );

    $wp_customize->add_setting( 'wpwisebones_topbar_text', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_topbar_text', [
        'label'   => __( 'Top Bar Text / HTML', 'wpwisebones' ),
        'section' => 'wpwisebones_header',
        'type'    => 'textarea',
    ] );

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Layout
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_layout_section', [
        'title'    => __( 'Layout', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 20,
    ] );

    $wp_customize->add_setting( 'wpwisebones_layout', [
        'default'           => 'right-sidebar',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_layout', [
        'label'   => __( 'Default Layout', 'wpwisebones' ),
        'section' => 'wpwisebones_layout_section',
        'type'    => 'select',
        'choices' => [
            'right-sidebar' => __( 'Right Sidebar', 'wpwisebones' ),
            'left-sidebar'  => __( 'Left Sidebar',  'wpwisebones' ),
            'full-width'    => __( 'Full Width',     'wpwisebones' ),
        ],
    ] );

    $wp_customize->add_setting( 'wpwisebones_container_width', [
        'default'           => 'container',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_container_width', [
        'label'   => __( 'Container Width', 'wpwisebones' ),
        'section' => 'wpwisebones_layout_section',
        'type'    => 'select',
        'choices' => [
            'container'       => __( 'Fixed (1320px max)',  'wpwisebones' ),
            'container-fluid' => __( 'Fluid (full width)',  'wpwisebones' ),
            'container-xl'    => __( 'Extra Large (1140px)', 'wpwisebones' ),
            'container-lg'    => __( 'Large (960px)',        'wpwisebones' ),
        ],
    ] );

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Hero / Banner
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_hero_section', [
        'title'    => __( 'Hero / Banner', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 30,
    ] );

    $wp_customize->add_setting( 'wpwisebones_hero_heading', [
        'default'           => get_bloginfo( 'name' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'wpwisebones_hero_heading', [
        'label'   => __( 'Hero Heading', 'wpwisebones' ),
        'section' => 'wpwisebones_hero_section',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'wpwisebones_hero_subheading', [
        'default'           => get_bloginfo( 'description' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'wpwisebones_hero_subheading', [
        'label'   => __( 'Hero Sub-heading', 'wpwisebones' ),
        'section' => 'wpwisebones_hero_section',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'wpwisebones_hero_btn_text', [
        'default'           => __( 'Learn More', 'wpwisebones' ),
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'wpwisebones_hero_btn_text', [
        'label'   => __( 'Button Text', 'wpwisebones' ),
        'section' => 'wpwisebones_hero_section',
        'type'    => 'text',
    ] );

    $wp_customize->add_setting( 'wpwisebones_hero_btn_url', [
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'wpwisebones_hero_btn_url', [
        'label'   => __( 'Button URL', 'wpwisebones' ),
        'section' => 'wpwisebones_hero_section',
        'type'    => 'url',
    ] );

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Footer
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_footer_section', [
        'title'    => __( 'Footer Settings', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 40,
    ] );

    $wpwisebones_copyright_default = sprintf(
        '&copy; %1$d %2$s. %3$s',
        gmdate( 'Y' ),
        get_bloginfo( 'name' ),
        __( 'All rights reserved.', 'wpwisebones' )
    );
    $wp_customize->add_setting( 'wpwisebones_footer_copyright', [
        'default'           => $wpwisebones_copyright_default,
        'sanitize_callback' => 'wp_kses_post',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_footer_copyright', [
        'label'   => __( 'Copyright Text', 'wpwisebones' ),
        'section' => 'wpwisebones_footer_section',
        'type'    => 'textarea',
    ] );

    $wp_customize->add_setting( 'wpwisebones_footer_columns', [
        'default'           => '4',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_footer_columns', [
        'label'   => __( 'Footer Widget Columns', 'wpwisebones' ),
        'section' => 'wpwisebones_footer_section',
        'type'    => 'select',
        'choices' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4' ],
    ] );

    $wp_customize->add_setting( 'wpwisebones_back_to_top', [
        'default'           => true,
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_back_to_top', [
        'label'   => __( 'Show Back to Top Button', 'wpwisebones' ),
        'section' => 'wpwisebones_footer_section',
        'type'    => 'checkbox',
    ] );

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Colours
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_colors', [
        'title'    => __( 'Brand Colours', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 50,
    ] );

    $color_settings = [
        'wpwisebones_color_primary'   => [ __( 'Primary Colour', 'wpwisebones' ), '#0d6efd' ],
        'wpwisebones_color_secondary' => [ __( 'Secondary Colour', 'wpwisebones' ), '#6c757d' ],
        'wpwisebones_color_accent'    => [ __( 'Accent Colour', 'wpwisebones' ), '#6610f2' ],
        'wpwisebones_color_header_bg' => [ __( 'Header Background', 'wpwisebones' ), '#ffffff' ],
        'wpwisebones_color_footer_bg' => [ __( 'Footer Background', 'wpwisebones' ), '#1a1a2e' ],
    ];

    foreach ( $color_settings as $id => [ $label, $default ] ) {
        $wp_customize->add_setting( $id, [
            'default'           => $default,
            'sanitize_callback' => 'sanitize_hex_color',
            'transport'         => 'postMessage',
        ] );
        $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $id, [
            'label'   => $label,
            'section' => 'wpwisebones_colors',
        ] ) );
    }

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Typography
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_typography', [
        'title'    => __( 'Typography', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 55,
    ] );

    $google_fonts = [
        'system'           => __( 'System Font Stack', 'wpwisebones' ),
        'Roboto'           => 'Roboto',
        'Open+Sans'        => 'Open Sans',
        'Lato'             => 'Lato',
        'Poppins'          => 'Poppins',
        'Montserrat'       => 'Montserrat',
        'Nunito'           => 'Nunito',
        'Raleway'          => 'Raleway',
        'Playfair+Display' => 'Playfair Display',
        'Merriweather'     => 'Merriweather',
        'Inter'            => 'Inter',
    ];

    $wp_customize->add_setting( 'wpwisebones_body_font', [
        'default'           => 'system',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_body_font', [
        'label'   => __( 'Body Font', 'wpwisebones' ),
        'section' => 'wpwisebones_typography',
        'type'    => 'select',
        'choices' => $google_fonts,
    ] );

    $wp_customize->add_setting( 'wpwisebones_heading_font', [
        'default'           => 'system',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ] );
    $wp_customize->add_control( 'wpwisebones_heading_font', [
        'label'   => __( 'Heading Font', 'wpwisebones' ),
        'section' => 'wpwisebones_typography',
        'type'    => 'select',
        'choices' => $google_fonts,
    ] );

    $wp_customize->add_setting( 'wpwisebones_base_font_size', [
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ] );
    $wp_customize->add_control( 'wpwisebones_base_font_size', [
        'label'       => __( 'Base Font Size (px)', 'wpwisebones' ),
        'section'     => 'wpwisebones_typography',
        'type'        => 'number',
        'input_attrs' => [ 'min' => 12, 'max' => 24, 'step' => 1 ],
    ] );

    /* â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ *
     *  SECTION: Social Links
     * â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */
    $wp_customize->add_section( 'wpwisebones_social', [
        'title'    => __( 'Social Links', 'wpwisebones' ),
        'panel'    => 'wpwisebones_panel',
        'priority' => 60,
    ] );

    $socials = [
        'facebook'  => 'Facebook',
        'twitter'   => 'Twitter / X',
        'instagram' => 'Instagram',
        'linkedin'  => 'LinkedIn',
        'youtube'   => 'YouTube',
        'github'    => 'GitHub',
        'pinterest' => 'Pinterest',
        'tiktok'    => 'TikTok',
    ];

    foreach ( $socials as $key => $label ) {
        $wp_customize->add_setting( 'wpwisebones_social_' . $key, [
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
            'transport'         => 'refresh',
        ] );
        $wp_customize->add_control( 'wpwisebones_social_' . $key, [
            'label'   => $label . ' URL',
            'section' => 'wpwisebones_social',
            'type'    => 'url',
        ] );
    }

    /* -- Selective Refresh Partials -- */
    if ( isset( $wp_customize->selective_refresh ) ) {

        $wp_customize->selective_refresh->add_partial( 'blogname', [
            'selector'        => '.site-branding .site-title a, .navbar-brand',
            'render_callback' => function() { bloginfo( 'name' ); },
        ] );

        $wp_customize->selective_refresh->add_partial( 'blogdescription', [
            'selector'        => '.site-description',
            'render_callback' => function() { bloginfo( 'description' ); },
        ] );

        $wp_customize->selective_refresh->add_partial( 'custom_logo', [
            'selector'            => '.site-branding',
            'render_callback'     => 'wpwisebones_site_branding',
            'container_inclusive' => false,
        ] );

        $wp_customize->selective_refresh->add_partial( 'wpwisebones_hero_heading', [
            'selector'        => '.wpb-hero h1',
            'render_callback' => function() {
                echo esc_html( get_theme_mod( 'wpwisebones_hero_heading', get_bloginfo( 'name' ) ) );
            },
        ] );

        $wp_customize->selective_refresh->add_partial( 'wpwisebones_hero_subheading', [
            'selector'        => '.wpb-hero p.lead',
            'render_callback' => function() {
                echo esc_html( get_theme_mod( 'wpwisebones_hero_subheading', get_bloginfo( 'description' ) ) );
            },
        ] );

        $wp_customize->selective_refresh->add_partial( 'wpwisebones_footer_copyright', [
            'selector'        => '.site-footer .copyright',
            'render_callback' => function() {
                echo wp_kses_post( get_theme_mod( 'wpwisebones_footer_copyright', '' ) );
            },
        ] );
    }
}

/* â”€â”€ Output inline CSS from customizer â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

/* -- Google Fonts: enqueued via wp_enqueue_style for proper dependency handling -- */
add_action( 'wp_enqueue_scripts', 'wpwisebones_enqueue_google_fonts', 5 );
function wpwisebones_enqueue_google_fonts() {
    $body_font    = sanitize_text_field( get_theme_mod( 'wpwisebones_body_font',    'system' ) );
    $heading_font = sanitize_text_field( get_theme_mod( 'wpwisebones_heading_font', 'system' ) );

    $fonts_to_load = [];
    if ( 'system' !== $body_font )    $fonts_to_load[] = $body_font;
    if ( 'system' !== $heading_font ) $fonts_to_load[] = $heading_font;
    $fonts_to_load = array_unique( $fonts_to_load );

    if ( $fonts_to_load ) {
        $query = implode( '&family=', array_map( fn( $f ) => $f . ':ital,wght@0,400;0,600;0,700;1,400', $fonts_to_load ) );
        wp_enqueue_style(
            'wpb-google-fonts',
            'https://fonts.googleapis.com/css2?family=' . $query . '&display=swap',
            [],
            null
        );
    }
}

add_action( 'wp_head', 'wpwisebones_customizer_css', 99 );
function wpwisebones_customizer_css() {
    // Null-safe hex helper — falls back to default if empty/invalid
    $hex = function( string $val, string $fallback ): string {
        $clean = sanitize_hex_color( $val );
        return $clean ?: $fallback;
    };

    $primary    = $hex( get_theme_mod( 'wpwisebones_color_primary',   '' ), '#0d6efd' );
    $secondary  = $hex( get_theme_mod( 'wpwisebones_color_secondary', '' ), '#6c757d' );
    $accent     = $hex( get_theme_mod( 'wpwisebones_color_accent',    '' ), '#6610f2' );
    $header_bg  = $hex( get_theme_mod( 'wpwisebones_color_header_bg', '' ), '#ffffff' );
    $footer_bg  = $hex( get_theme_mod( 'wpwisebones_color_footer_bg', '' ), '#1a1a2e' );
    $font_size  = max( 12, min( 24, absint( get_theme_mod( 'wpwisebones_base_font_size', 16 ) ?: 16 ) ) );
    $sticky     = (bool) get_theme_mod( 'wpwisebones_sticky_header', true );

    $body_font    = sanitize_text_field( get_theme_mod( 'wpwisebones_body_font',    'system' ) );
    $heading_font = sanitize_text_field( get_theme_mod( 'wpwisebones_heading_font', 'system' ) );

    $body_font_css    = ( 'system' === $body_font || '' === $body_font )
        ? 'system-ui, -apple-system, sans-serif'
        : "'" . str_replace( '+', ' ', $body_font ) . "', sans-serif";
    $heading_font_css = ( 'system' === $heading_font || '' === $heading_font )
        ? 'inherit'
        : "'" . str_replace( '+', ' ', $heading_font ) . "', sans-serif";

    $css = '<style id="wpb-customizer-css">' . "\n";

    // CSS custom properties
    $css .= ':root {' . "\n";
    $css .= '  --bs-primary: '    . $primary   . ';' . "\n";
    $css .= '  --bs-secondary: '  . $secondary . ';' . "\n";
    $css .= '  --wpb-accent: '    . $accent    . ';' . "\n";
    $css .= '  --wpb-header-bg: ' . $header_bg . ';' . "\n";
    $css .= '  --wpb-footer-bg: ' . $footer_bg . ';' . "\n";
    $css .= '}' . "\n";

    // Typography
    $css .= 'body { font-size: ' . $font_size . 'px; font-family: ' . esc_html( $body_font_css ) . '; }' . "\n";
    $css .= 'h1,h2,h3,h4,h5,h6 { font-family: ' . esc_html( $heading_font_css ) . '; }' . "\n";

    // Header
    $css .= '.site-header { background-color: ' . $header_bg . '; }' . "\n";
    if ( ! $sticky ) {
        // Override the fixed positioning when sticky is disabled
        $css .= '.site-header { position: relative; }' . "\n";
        $css .= 'body { padding-top: 0 !important; }' . "\n";
    }

    // Footer
    $css .= '.site-footer { background-color: ' . $footer_bg . '; }' . "\n";

    // Primary colour overrides
    $css .= '.btn-primary { background-color: ' . $primary . '; border-color: ' . $primary . '; }' . "\n";
    $css .= '.btn-primary:hover { background-color: ' . $primary . 'cc; border-color: ' . $primary . 'cc; }' . "\n";
    $css .= '.wpb-hero { background: linear-gradient(135deg, ' . $primary . ' 0%, ' . $accent . ' 100%); }' . "\n";
    $css .= '.widget-title { border-color: ' . $primary . '; }' . "\n";
    $css .= 'a { color: ' . $primary . '; }' . "\n";
    $css .= '.pagination .page-item.active .page-link { background-color: ' . $primary . '; border-color: ' . $primary . '; }' . "\n";
    $css .= '.nav-link.active, .nav-link:hover { color: ' . $primary . ' !important; }' . "\n";

    $css .= '</style>' . "\n";

    echo $css; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
