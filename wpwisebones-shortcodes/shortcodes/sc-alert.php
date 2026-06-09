<?php
/**
 * Shortcode: [wpb_alert]
 *
 * Usage:
 *   [wpb_alert type="success" dismissible="true" icon="bi-check-circle"]
 *   This is a success message!
 *   [/wpb_alert]
 *
 * @param type        Bootstrap colour: primary|secondary|success|danger|warning|info|light|dark
 * @param dismissible Show close button (true/false)
 * @param icon        Bootstrap Icons class (optional)
 * @param heading     Bold heading text (optional)
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_alert', 'wpb_sc_alert' );

function wpb_sc_alert( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'type'        => 'primary',
        'dismissible' => 'false',
        'icon'        => '',
        'heading'     => '',
        'class'       => '',
    ], $atts, 'wpb_alert' );

    $allowed_types = [ 'primary', 'secondary', 'success', 'danger', 'warning', 'info', 'light', 'dark' ];
    $type = in_array( $a['type'], $allowed_types, true ) ? $a['type'] : 'primary';

    $classes = [ 'alert', 'alert-' . $type, 'wpb-alert-shortcode' ];
    if ( 'true' === $a['dismissible'] ) $classes[] = 'alert-dismissible fade show';
    if ( $a['class'] ) $classes[] = sanitize_html_class( $a['class'] );

    $html  = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '" role="alert">';
    if ( $a['icon'] ) $html .= '<i class="bi ' . esc_attr( $a['icon'] ) . ' me-2"></i>';
    if ( $a['heading'] ) $html .= '<strong>' . esc_html( $a['heading'] ) . '</strong> ';
    $html .= wp_kses_post( do_shortcode( $content ) );
    if ( 'true' === $a['dismissible'] ) {
        $html .= '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="' . esc_attr__( 'Close', 'wpwisebones' ) . '"></button>';
    }
    $html .= '</div>';

    return $html;
}
