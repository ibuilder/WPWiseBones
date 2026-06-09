<?php
/**
 * Shortcode: [wpb_map]
 * Usage: [wpb_map src="https://maps.google.com/maps?q=...&output=embed" height="400"]
 *
 * @param src    Full embed URL for the map iframe
 * @param height Height in pixels (default 400)
 * @param class  Extra CSS classes on the wrapper div
 */
defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_map', function( $atts ) {
    $a = shortcode_atts( [ 'src' => '', 'height' => '400', 'class' => '' ], $atts, 'wpb_map' );
    if ( ! $a['src'] ) return '';

    $height = absint( $a['height'] );

    return sprintf(
        '<div class="wpb-map %s"><iframe src="%s" style="border:0;width:100%%;height:%dpx;display:block;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe></div>',
        esc_attr( $a['class'] ),
        esc_url( $a['src'] ),
        $height
    );
} );
