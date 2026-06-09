<?php
/**
 * Shortcode: [wpb_modal]
 *
 * Usage:
 *   [wpb_modal id="myModal" title="Hello" btn_text="Open Modal" btn_style="primary" size="lg"]
 *   Modal body content.
 *   [/wpb_modal]
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'wpb_modal', 'wpb_sc_modal' );

function wpb_sc_modal( array $atts, ?string $content = null ): string {
    static $count = 0;
    $count++;

    $a = shortcode_atts( [
        'id'         => '',
        'title'      => __( 'Modal Title', 'wisebones-shortcodes' ),
        'btn_text'   => __( 'Open', 'wisebones-shortcodes' ),
        'btn_style'  => 'primary',
        'size'       => '',   // sm | lg | xl
        'scrollable' => 'false',
        'centered'   => 'true',
        'class'      => '',
    ], $atts, 'wpb_modal' );

    $modal_id = $a['id'] ?: 'wpbModal' . $count;

    $dialog_cls = 'modal-dialog';
    if ( $a['size'] )              $dialog_cls .= ' modal-' . sanitize_html_class( $a['size'] );
    if ( 'true' === $a['centered'] )   $dialog_cls .= ' modal-dialog-centered';
    if ( 'true' === $a['scrollable'] ) $dialog_cls .= ' modal-dialog-scrollable';

    $html  = '<button type="button" class="btn btn-' . esc_attr( $a['btn_style'] ) . '" data-bs-toggle="modal" data-bs-target="#' . esc_attr( $modal_id ) . '">' . esc_html( $a['btn_text'] ) . '</button>';

    $html .= '<div class="modal fade ' . esc_attr( $a['class'] ) . '" id="' . esc_attr( $modal_id ) . '" tabindex="-1" aria-labelledby="' . esc_attr( $modal_id ) . 'Label" aria-hidden="true">';
    $html .= '<div class="' . esc_attr( $dialog_cls ) . '"><div class="modal-content">';
    $html .= '<div class="modal-header"><h5 class="modal-title" id="' . esc_attr( $modal_id ) . 'Label">' . esc_html( $a['title'] ) . '</h5>';
    $html .= '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="' . esc_attr__( 'Close', 'wisebones-shortcodes' ) . '"></button></div>';
    $html .= '<div class="modal-body">' . wp_kses_post( do_shortcode( $content ) ) . '</div>';
    $html .= '<div class="modal-footer"><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">' . esc_html__( 'Close', 'wisebones-shortcodes' ) . '</button></div>';
    $html .= '</div></div></div>';

    return $html;
}
