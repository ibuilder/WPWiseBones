<?php
/**
 * Shortcode: [wpb_contact_info]
 * Usage: [wpb_contact_info phone="+1 555 0100" email="hello@example.com" address="123 Main St" hours="Mon-Fri 9-5"]
 */
defined( 'ABSPATH' ) || exit;
add_shortcode( 'wpb_contact_info', function( $atts ) {
    $a = shortcode_atts( [ 'phone' => '', 'email' => '', 'address' => '', 'hours' => '', 'class' => '' ], $atts );
    $items = [];
    if ( $a['phone'] )   $items[] = '<li class="mb-2"><i class="bi bi-telephone me-2 text-primary"></i><a href="tel:' . esc_attr( preg_replace( '/\s+/', '', $a['phone'] ) ) . '">' . esc_html( $a['phone'] ) . '</a></li>';
    if ( $a['email'] )   $items[] = '<li class="mb-2"><i class="bi bi-envelope me-2 text-primary"></i><a href="mailto:' . esc_attr( $a['email'] ) . '">' . esc_html( $a['email'] ) . '</a></li>';
    if ( $a['address'] ) $items[] = '<li class="mb-2"><i class="bi bi-geo-alt me-2 text-primary"></i>' . esc_html( $a['address'] ) . '</li>';
    if ( $a['hours'] )   $items[] = '<li class="mb-2"><i class="bi bi-clock me-2 text-primary"></i>' . esc_html( $a['hours'] ) . '</li>';
    return '<ul class="list-unstyled wpb-contact-info ' . esc_attr( $a['class'] ) . '">' . implode( '', $items ) . '</ul>';
} );
