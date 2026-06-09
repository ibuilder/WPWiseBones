<?php
/**
 * Shortcode: [wpb_progress]
 *
 * Usage:
 *   [wpb_progress label="HTML" value="90" color="primary"]
 *   [wpb_progress label="CSS"  value="85" color="info" striped="true" animated="true"]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_progress', 'wpb_sc_progress' );

function wpb_sc_progress( array $atts ): string {
    $a = shortcode_atts( [
        'label'    => '',
        'value'    => '0',
        'color'    => 'primary',
        'striped'  => 'false',
        'animated' => 'false',
        'height'   => '20',
        'class'    => '',
    ], $atts, 'wpb_progress' );

    $val     = min( 100, max( 0, (int) $a['value'] ) );
    $bar_cls = [ 'progress-bar', 'bg-' . sanitize_html_class( $a['color'] ) ];
    if ( 'true' === $a['striped'] )  $bar_cls[] = 'progress-bar-striped';
    if ( 'true' === $a['animated'] ) $bar_cls[] = 'progress-bar-animated';

    $html  = '<div class="wpb-progress-wrap ' . esc_attr( $a['class'] ) . '">';
    if ( $a['label'] ) {
        $html .= '<label><span>' . esc_html( $a['label'] ) . '</span><span>' . $val . '%</span></label>';
    }
    $html .= '<div class="progress" style="height:' . absint( $a['height'] ) . 'px">';
    $html .= '<div class="' . esc_attr( implode( ' ', $bar_cls ) ) . '" role="progressbar" style="width:' . $val . '%" aria-valuenow="' . $val . '" aria-valuemin="0" aria-valuemax="100">';
    $html .= '</div></div></div>';

    return $html;
}
