<?php
/**
 * Shortcodes: [wpb_row] / [wpb_col]
 *
 * Usage:
 *   [wpb_row gutter="4" align="center"]
 *     [wpb_col size="4"]Left content[/wpb_col]
 *     [wpb_col size="8"]Right content[/wpb_col]
 *   [/wpb_row]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_row', 'wpbs_sc_row' );
add_shortcode( 'wpb_col', 'wpbs_sc_col' );

function wpbs_sc_row( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'gutter' => '4',
        'align'  => '',    // start|center|end
        'valign' => '',    // align-items-*
        'class'  => '',
    ], $atts, 'wpb_row' );

    $classes = [ 'row', 'wpb-columns', 'g-' . absint( $a['gutter'] ) ];
    if ( $a['align'] )  $classes[] = 'justify-content-' . sanitize_html_class( $a['align'] );
    if ( $a['valign'] ) $classes[] = 'align-items-' . sanitize_html_class( $a['valign'] );
    if ( $a['class'] )  $classes[] = esc_attr( $a['class'] );

    return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . do_shortcode( $content ) . '</div>';
}

function wpbs_sc_col( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'size'  => '',   // 1-12 or blank for auto
        'md'    => '',
        'lg'    => '',
        'sm'    => '',
        'xl'    => '',
        'class' => '',
        'align' => '',
    ], $atts, 'wpb_col' );

    $classes = [];
    if ( $a['size'] ) {
        $classes[] = 'col-' . absint( $a['size'] );
    } else {
        $classes[] = 'col';
    }
    if ( $a['sm'] )  $classes[] = 'col-sm-'  . absint( $a['sm'] );
    if ( $a['md'] )  $classes[] = 'col-md-'  . absint( $a['md'] );
    if ( $a['lg'] )  $classes[] = 'col-lg-'  . absint( $a['lg'] );
    if ( $a['xl'] )  $classes[] = 'col-xl-'  . absint( $a['xl'] );
    if ( $a['align'] ) $classes[] = 'text-' . sanitize_html_class( $a['align'] );
    if ( $a['class'] ) $classes[] = esc_attr( $a['class'] );

    return '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">' . do_shortcode( $content ) . '</div>';
}
