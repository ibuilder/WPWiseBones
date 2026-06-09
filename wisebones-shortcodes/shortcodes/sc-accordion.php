<?php
/**
 * Shortcodes: [wpb_accordion] / [wpb_accordion_item]
 *
 * Usage:
 *   [wpb_accordion flush="true"]
 *     [wpb_accordion_item title="Item 1" open="true"]Content A[/wpb_accordion_item]
 *     [wpb_accordion_item title="Item 2"]Content B[/wpb_accordion_item]
 *   [/wpb_accordion]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_accordion',      'wpb_sc_accordion' );
add_shortcode( 'wpb_accordion_item', 'wpb_sc_accordion_item' );

function wpb_sc_accordion( array $atts, ?string $content = null ): string {
    static $accordion_id = 0;
    $accordion_id++;

    $a = shortcode_atts( [
        'flush' => 'false',
        'class' => '',
    ], $atts, 'wpb_accordion' );

    $classes = [ 'accordion', 'wpb-accordion-shortcode' ];
    if ( 'true' === $a['flush'] ) $classes[] = 'accordion-flush';
    if ( $a['class'] ) $classes[] = esc_attr( $a['class'] );

    // Pass accordion ID to child shortcodes via global
    $GLOBALS['wpb_current_accordion'] = 'wpbAccordion' . $accordion_id;

    $html  = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" id="wpbAccordion' . $accordion_id . '">';
    $html .= do_shortcode( $content );
    $html .= '</div>';

    return $html;
}

function wpb_sc_accordion_item( array $atts, ?string $content = null ): string {
    static $item_id = 0;
    $item_id++;

    $a = shortcode_atts( [
        'title' => __( 'Item', 'wisebones-shortcodes' ),
        'open'  => 'false',
    ], $atts, 'wpb_accordion_item' );

    $parent  = $GLOBALS['wpb_current_accordion'] ?? 'wpbAccordion';
    $id      = 'wpbItem' . $item_id;
    $is_open = 'true' === $a['open'];

    $html  = '<div class="accordion-item">';
    $html .= '<h2 class="accordion-header" id="heading' . $id . '">';
    $html .= '<button class="accordion-button' . ( ! $is_open ? ' collapsed' : '' ) . '" type="button" data-bs-toggle="collapse" data-bs-target="#' . $id . '" aria-expanded="' . ( $is_open ? 'true' : 'false' ) . '" aria-controls="' . $id . '">';
    $html .= esc_html( $a['title'] );
    $html .= '</button></h2>';
    $html .= '<div id="' . $id . '" class="accordion-collapse collapse' . ( $is_open ? ' show' : '' ) . '" aria-labelledby="heading' . $id . '" data-bs-parent="#' . $parent . '">';
    $html .= '<div class="accordion-body">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';
    $html .= '</div></div>';

    return $html;
}
