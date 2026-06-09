<?php
/**
 * Shortcode: [wpb_divider]
 * Usage: [wpb_divider text="OR" style="dashed" spacing="4"]
 */
defined( 'ABSPATH' ) || exit;
add_shortcode( 'wpb_divider', function( $atts ) {
    $a = shortcode_atts( [ 'text' => '', 'style' => 'solid', 'spacing' => '4', 'color' => 'muted' ], $atts );
    $my = 'my-' . absint( $a['spacing'] );
    $border_style = in_array( $a['style'], [ 'dashed', 'dotted', 'solid' ], true ) ? $a['style'] : 'solid';
    if ( $a['text'] ) {
        return '<div class="d-flex align-items-center ' . $my . ' text-' . esc_attr( $a['color'] ) . '"><hr class="flex-grow-1" style="border-style:' . $border_style . '"><span class="px-3 small">' . esc_html( $a['text'] ) . '</span><hr class="flex-grow-1" style="border-style:' . $border_style . '"></div>';
    }
    return '<hr class="' . $my . '" style="border-style:' . $border_style . '">';
} );
