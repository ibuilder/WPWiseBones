<?php
/**
 * Shortcode: [wpb_icon_box]
 *
 * Usage:
 *   [wpb_icon_box icon="bi-rocket" title="Fast Performance" color="primary"]
 *   Description text here.
 *   [/wpb_icon_box]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_icon_box', 'wpbs_sc_icon_box' );

function wpbs_sc_icon_box( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'icon'    => 'bi-star',
        'title'   => '',
        'color'   => 'primary',
        'bg'      => '',
        'align'   => 'center',
        'class'   => '',
        'url'     => '',
    ], $atts, 'wpb_icon_box' );

    $classes = [ 'wpb-icon-box', 'text-' . sanitize_html_class( $a['align'] ) ];
    if ( $a['class'] ) $classes[] = esc_attr( $a['class'] );
    if ( $a['bg'] )    $classes[] = 'bg-' . sanitize_html_class( $a['bg'] ) . ' p-4 rounded';

    $icon_html = '<div class="icon text-' . esc_attr( $a['color'] ) . '"><i class="bi ' . esc_attr( $a['icon'] ) . '"></i></div>';

    $html  = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';
    $html .= $a['url'] ? '<a href="' . esc_url( $a['url'] ) . '" class="text-decoration-none">' : '';
    $html .= $icon_html;
    if ( $a['title'] ) $html .= '<h5 class="mt-2 mb-1">' . esc_html( $a['title'] ) . '</h5>';
    if ( $content )    $html .= '<p class="text-muted">' . wp_kses_post( do_shortcode( $content ) ) . '</p>';
    $html .= $a['url'] ? '</a>' : '';
    $html .= '</div>';

    return $html;
}
