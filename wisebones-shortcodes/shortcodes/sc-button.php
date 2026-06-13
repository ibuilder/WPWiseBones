<?php
/**
 * Shortcode: [wpb_button]
 *
 * Usage:
 *   [wpb_button url="/contact" style="primary" size="lg" icon="bi-envelope" target="_blank"]Contact Us[/wpb_button]
 *
 * @param url      href attribute
 * @param style    Bootstrap button variant: primary|secondary|success|danger|warning|info|light|dark|outline-primaryâ€¦
 * @param size     sm|md|lg
 * @param icon     Bootstrap Icon class prefix (e.g. bi-arrow-right)
 * @param icon_pos left|right
 * @param target   _self|_blank
 * @param class    Extra CSS classes
 * @param id       HTML id attribute
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_button', 'wpbs_sc_button' );

function wpbs_sc_button( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'url'      => '#',
        'style'    => 'primary',
        'size'     => '',
        'icon'     => '',
        'icon_pos' => 'left',
        'target'   => '_self',
        'rel'      => '',
        'class'    => '',
        'id'       => '',
        'disabled' => 'false',
    ], $atts, 'wpb_button' );

    $classes = [ 'btn', 'btn-' . sanitize_html_class( $a['style'] ), 'wpb-btn-shortcode' ];
    if ( $a['size'] ) $classes[] = 'btn-' . sanitize_html_class( $a['size'] );
    if ( $a['class'] ) $classes[] = esc_attr( $a['class'] );
    if ( 'true' === $a['disabled'] ) $classes[] = 'disabled';

    $icon_html = $a['icon'] ? '<i class="bi ' . esc_attr( $a['icon'] ) . '"></i> ' : '';
    $label     = wp_kses_post( do_shortcode( $content ) );

    $text = 'right' === $a['icon_pos']
        ? $label . ' ' . rtrim( $icon_html )
        : $icon_html . $label;

    $rel    = esc_attr( $a['rel'] ?: ( '_blank' === $a['target'] ? 'noopener noreferrer' : '' ) );
    $id_str = $a['id'] ? ' id="' . esc_attr( $a['id'] ) . '"' : '';

    return '<a href="' . esc_url( $a['url'] ) . '" class="' . esc_attr( implode( ' ', $classes ) ) . '" target="' . esc_attr( $a['target'] ) . '"' . ( $rel ? ' rel="' . $rel . '"' : '' ) . $id_str . '>' . $text . '</a>';
}
