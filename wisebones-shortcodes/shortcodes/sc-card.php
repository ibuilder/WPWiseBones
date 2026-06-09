<?php
/**
 * Shortcode: [wpb_card]
 *
 * Usage:
 *   [wpb_card title="Card Title" image="https://â€¦" btn_text="Read More" btn_url="/page" footer="Card footer text"]
 *   Card body content here.
 *   [/wpb_card]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_card', 'wpb_sc_card' );

function wpb_sc_card( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'title'    => '',
        'subtitle' => '',
        'image'    => '',
        'btn_text' => '',
        'btn_url'  => '#',
        'btn_style'=> 'primary',
        'footer'   => '',
        'shadow'   => 'sm',
        'class'    => '',
        'border'   => '',
        'text'     => '',
    ], $atts, 'wpb_card' );

    $classes = [ 'card', 'wpb-card-shortcode', 'h-100' ];
    if ( $a['shadow'] )  $classes[] = 'shadow-' . sanitize_html_class( $a['shadow'] );
    if ( $a['border'] )  $classes[] = 'border-' . sanitize_html_class( $a['border'] );
    if ( $a['text'] )    $classes[] = 'text-' . sanitize_html_class( $a['text'] );
    if ( $a['class'] )   $classes[] = esc_attr( $a['class'] );

    $html = '<div class="' . esc_attr( implode( ' ', $classes ) ) . '">';

    if ( $a['image'] ) {
        $html .= '<img src="' . esc_url( $a['image'] ) . '" class="card-img-top" alt="' . esc_attr( $a['title'] ) . '" loading="lazy">';
    }

    $html .= '<div class="card-body">';
    if ( $a['title'] )    $html .= '<h5 class="card-title">' . esc_html( $a['title'] ) . '</h5>';
    if ( $a['subtitle'] ) $html .= '<h6 class="card-subtitle mb-2 text-muted">' . esc_html( $a['subtitle'] ) . '</h6>';
    if ( $content )       $html .= '<p class="card-text">' . wp_kses_post( do_shortcode( $content ) ) . '</p>';
    if ( $a['btn_text'] ) {
        $html .= '<a href="' . esc_url( $a['btn_url'] ) . '" class="btn btn-' . esc_attr( $a['btn_style'] ) . '">' . esc_html( $a['btn_text'] ) . '</a>';
    }
    $html .= '</div>';

    if ( $a['footer'] ) {
        $html .= '<div class="card-footer text-muted small">' . wp_kses_post( $a['footer'] ) . '</div>';
    }

    $html .= '</div>';
    return $html;
}
