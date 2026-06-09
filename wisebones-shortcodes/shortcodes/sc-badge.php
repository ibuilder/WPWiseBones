<?php
/**
 * Shortcode: [wpb_badge]
 * Usage: [wpb_badge color="danger" pill="true"]New[/wpb_badge]
 */
defined( 'ABSPATH' ) || exit;
add_shortcode( 'wpb_badge', function( $atts, $content = null ) {
    $a = shortcode_atts( [ 'color' => 'primary', 'pill' => 'false', 'class' => '' ], $atts );
    $cls = 'badge text-bg-' . sanitize_html_class( $a['color'] );
    if ( 'true' === $a['pill'] ) $cls .= ' rounded-pill';
    if ( $a['class'] ) $cls .= ' ' . esc_attr( $a['class'] );
    return '<span class="' . esc_attr( $cls ) . '">' . esc_html( do_shortcode( $content ) ) . '</span>';
} );
