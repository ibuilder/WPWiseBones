<?php
/**
 * Shortcode: [wpb_testimonial]
 *
 * Usage:
 *   [wpb_testimonial author="Jane Doe" role="CEO, Acme" avatar="https://â€¦" stars="5"]
 *   "This product changed my life!"
 *   [/wpb_testimonial]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_testimonial', 'wpb_sc_testimonial' );

function wpb_sc_testimonial( array $atts, ?string $content = null ): string {
    $a = shortcode_atts( [
        'author' => '',
        'role'   => '',
        'avatar' => '',
        'stars'  => '0',
        'class'  => '',
    ], $atts, 'wpb_testimonial' );

    $stars = min( 5, max( 0, (int) $a['stars'] ) );

    $html  = '<blockquote class="wpb-testimonial ' . esc_attr( $a['class'] ) . '">';

    if ( $stars > 0 ) {
        $html .= '<div class="stars text-warning mb-2">';
        for ( $i = 0; $i < $stars; $i++ ) {
            $html .= '<i class="bi bi-star-fill"></i>';
        }
        for ( $i = $stars; $i < 5; $i++ ) {
            $html .= '<i class="bi bi-star"></i>';
        }
        $html .= '</div>';
    }

    $html .= '<p class="mb-3 fst-italic">' . wp_kses_post( do_shortcode( $content ) ) . '</p>';

    $html .= '<footer class="d-flex align-items-center gap-3">';
    if ( $a['avatar'] ) {
        $html .= '<img src="' . esc_url( $a['avatar'] ) . '" alt="' . esc_attr( $a['author'] ) . '" class="rounded-circle" width="48" height="48" loading="lazy">';
    }
    $html .= '<div class="author">';
    if ( $a['author'] ) $html .= '<strong>' . esc_html( $a['author'] ) . '</strong>';
    if ( $a['role'] )   $html .= '<br><small class="text-muted">' . esc_html( $a['role'] ) . '</small>';
    $html .= '</div></footer></blockquote>';

    return $html;
}
