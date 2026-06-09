<?php
/**
 * Shortcode: [wpb_cta]
 *
 * Usage:
 *   [wpb_cta heading="Ready to start?" subtext="Join thousands of users." btn_text="Get Started" btn_url="/signup" btn_style="light"]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_cta', 'wpb_sc_cta' );

function wpb_sc_cta( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'heading'    => __( 'Ready to Get Started?', 'wisebones-shortcodes' ),
        'subtext'    => '',
        'btn_text'   => __( 'Learn More', 'wisebones-shortcodes' ),
        'btn_url'    => '#',
        'btn_style'  => 'light',
        'btn2_text'  => '',
        'btn2_url'   => '#',
        'btn2_style' => 'outline-light',
        'bg'         => 'gradient',   // gradient | primary | dark | image
        'image'      => '',
        'class'      => '',
    ], $atts, 'wpb_cta' );

    $classes = [ 'wpb-cta' ];
    if ( $a['class'] ) $classes[] = esc_attr( $a['class'] );

    $style = '';
    if ( 'image' === $a['bg'] && $a['image'] ) {
        $style = ' style="background: url(' . esc_url( $a['image'] ) . ') center/cover no-repeat; border-radius:1rem;"';
    }

    $html  = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '"' . $style . '>';
    $html .= '<h2 class="display-5 fw-bold mb-3">' . esc_html( $a['heading'] ) . '</h2>';
    if ( $a['subtext'] ) $html .= '<p class="lead mb-4 opacity-75">' . esc_html( $a['subtext'] ) . '</p>';
    if ( $content )      $html .= '<div class="mb-4">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';

    $html .= '<div class="d-flex gap-3 justify-content-center flex-wrap">';
    $html .= '<a href="' . esc_url( $a['btn_url'] ) . '" class="btn btn-' . esc_attr( $a['btn_style'] ) . ' btn-lg">' . esc_html( $a['btn_text'] ) . '</a>';
    if ( $a['btn2_text'] ) {
        $html .= '<a href="' . esc_url( $a['btn2_url'] ) . '" class="btn btn-' . esc_attr( $a['btn2_style'] ) . ' btn-lg">' . esc_html( $a['btn2_text'] ) . '</a>';
    }
    $html .= '</div></div>';

    return $html;
}
