<?php
/**
 * Shortcode: [wpb_countdown]
 *
 * Usage:
 *   [wpb_countdown date="2025-12-31 23:59:59" label="Launch Countdown"]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_countdown', 'wpb_sc_countdown' );

function wpb_sc_countdown( array $atts ): string {
    static $count = 0;
    $count++;

    $a = shortcode_atts( [
        'date'  => '',
        'label' => '',
        'class' => '',
    ], $atts, 'wpb_countdown' );

    $id = 'wpbCountdown' . $count;

    $html  = '<div class="wpb-countdown-wrap text-center ' . esc_attr( $a['class'] ) . '">';
    if ( $a['label'] ) {
        $html .= '<h4 class="mb-3">' . esc_html( $a['label'] ) . '</h4>';
    }
    $html .= '<div class="wpb-countdown" id="' . $id . '" data-date="' . esc_attr( $a['date'] ) . '">';
    $html .= '<div class="unit"><span class="num" id="' . $id . '_d">00</span><span class="label">' . esc_html__( 'Days', 'wpwisebones' ) . '</span></div>';
    $html .= '<div class="unit"><span class="num" id="' . $id . '_h">00</span><span class="label">' . esc_html__( 'Hours', 'wpwisebones' ) . '</span></div>';
    $html .= '<div class="unit"><span class="num" id="' . $id . '_m">00</span><span class="label">' . esc_html__( 'Minutes', 'wpwisebones' ) . '</span></div>';
    $html .= '<div class="unit"><span class="num" id="' . $id . '_s">00</span><span class="label">' . esc_html__( 'Seconds', 'wpwisebones' ) . '</span></div>';
    $html .= '</div></div>';

    return $html;
}
