<?php
/**
 * Shortcode: [wpb_badge]
 * Usage: [wpb_badge color="danger" pill="true"]New[/wpb_badge]
 */
defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_badge', 'wpbs_sc_badge' );
function wpbs_sc_badge( $atts, $content = null ) {
	$a   = shortcode_atts(
		array(
			'color' => 'primary',
			'pill'  => 'false',
			'class' => '',
		),
		$atts,
		'wpb_badge'
	);
	$cls = 'badge text-bg-' . sanitize_html_class( $a['color'] );
	if ( 'true' === $a['pill'] ) {
		$cls .= ' rounded-pill';
	}
	if ( $a['class'] ) {
		$cls .= ' ' . esc_attr( $a['class'] );
	}
	return '<span class="' . esc_attr( $cls ) . '">' . wp_kses_post( do_shortcode( $content ) ) . '</span>';
}
