<?php
/**
 * Shortcodes: [wpb_tabs] / [bsk_tab]
 *
 * Usage:
 *   [wpb_tabs style="pills"]
 *     [wpb_tab title="Tab One" icon="bi-house" active="true"]Content 1[/wpb_tab]
 *     [wpb_tab title="Tab Two"]Content 2[/wpb_tab]
 *   [/wpb_tabs]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_tabs', 'wpb_sc_tabs' );
add_shortcode( 'wpb_tab',  'wpb_sc_tab' );

function wpb_sc_tabs( array $atts, ?string $content = null ): string {
    static $tabs_id = 0;
    $tabs_id++;

    $a = shortcode_atts( [
        'style' => 'tabs',   // tabs | pills | underline
        'fill'  => 'false',
        'class' => '',
    ], $atts, 'wpb_tabs' );

    // Buffer children so we can extract nav + pane content
    $GLOBALS['wpb_tabs_nav']   = [];
    $GLOBALS['wpb_tabs_panes'] = [];
    $GLOBALS['wpb_tabs_id']    = $tabs_id;

    do_shortcode( $content ); // children populate globals

    $nav_class = 'nav nav-' . esc_attr( $a['style'] );
    if ( 'true' === $a['fill'] ) $nav_class .= ' nav-fill';

    $html  = '<div class="wpb-tabs-shortcode ' . esc_attr( $a['class'] ) . '">';
    $html .= '<ul class="' . $nav_class . ' mb-3" id="wpbTabsNav' . $tabs_id . '" role="tablist">';
    foreach ( $GLOBALS['wpb_tabs_nav'] as $item ) {
        $html .= $item;
    }
    $html .= '</ul>';
    $html .= '<div class="tab-content" id="wpbTabsContent' . $tabs_id . '">';
    foreach ( $GLOBALS['wpb_tabs_panes'] as $pane ) {
        $html .= $pane;
    }
    $html .= '</div></div>';

    return $html;
}

function wpb_sc_tab( array $atts, ?string $content = null ): string {
    static $tab_id = 0;
    $tab_id++;

    $a = shortcode_atts( [
        'title'  => __( 'Tab', 'wpwisebones' ),
        'icon'   => '',
        'active' => 'false',
    ], $atts, 'wpb_tab' );

    $tabs_id = $GLOBALS['wpb_tabs_id'] ?? 0;
    $id      = 'wpbTab' . $tabs_id . '_' . $tab_id;
    $active  = 'true' === $a['active'];
    $icon    = $a['icon'] ? '<i class="bi ' . esc_attr( $a['icon'] ) . ' me-1"></i>' : '';

    // Nav item
    $nav  = '<li class="nav-item" role="presentation">';
    $nav .= '<button class="nav-link' . ( $active ? ' active' : '' ) . '" id="' . $id . '-tab" data-bs-toggle="tab" data-bs-target="#' . $id . '" type="button" role="tab" aria-controls="' . $id . '" aria-selected="' . ( $active ? 'true' : 'false' ) . '">';
    $nav .= $icon . esc_html( $a['title'] );
    $nav .= '</button></li>';

    // Pane
    $pane  = '<div class="tab-pane fade' . ( $active ? ' show active' : '' ) . '" id="' . $id . '" role="tabpanel" aria-labelledby="' . $id . '-tab">';
    $pane .= '<div class="pt-3">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';
    $pane .= '</div>';

    $GLOBALS['wpb_tabs_nav'][]   = $nav;
    $GLOBALS['wpb_tabs_panes'][] = $pane;

    return ''; // output handled by parent
}
