<?php
/**
 * Custom Widget: BSK Social Links.
 */

defined( 'ABSPATH' ) || exit;

class WPWISEBONES_Widget_Social_Links extends WP_Widget {

	private static array $networks = array(
		'facebook'  => array( 'Facebook', 'bi-facebook' ),
		'twitter'   => array( 'Twitter/X', 'bi-twitter-x' ),
		'instagram' => array( 'Instagram', 'bi-instagram' ),
		'linkedin'  => array( 'LinkedIn', 'bi-linkedin' ),
		'youtube'   => array( 'YouTube', 'bi-youtube' ),
		'github'    => array( 'GitHub', 'bi-github' ),
		'pinterest' => array( 'Pinterest', 'bi-pinterest' ),
		'tiktok'    => array( 'TikTok', 'bi-tiktok' ),
	);

	public function __construct() {
		parent::__construct(
			'wpwisebones_social_links',
			__( 'WPWiseBones: Social Links', 'wpwisebones' ),
			array( 'description' => __( 'Circular social media icon links.', 'wpwisebones' ) )
		);
	}

	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] ?? '' );

        echo $args['before_widget']; // phpcs:ignore
        if ( $title ) echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore

		echo '<div class="wpb-widget-social">';
		foreach ( self::$networks as $key => [ $label, $icon ] ) {
			$url = $instance[ 'url_' . $key ] ?? '';
			if ( $url ) {
				printf(
					'<a href="%s" target="_blank" rel="noopener noreferrer" title="%s"><i class="bi %s"></i></a>',
					esc_url( $url ),
					esc_attr( $label ),
					esc_attr( $icon )
				);
			}
		}
		echo '</div>';

        echo $args['after_widget']; // phpcs:ignore
	}

	public function form( $instance ) {
		$title = $instance['title'] ?? __( 'Follow Us', 'wpwisebones' );
		echo '<p><label>' . esc_html__( 'Title:', 'wpwisebones' ) . '<input class="widefat" name="' . esc_attr( $this->get_field_name( 'title' ) ) . '" type="text" value="' . esc_attr( $title ) . '"></label></p>';

		foreach ( self::$networks as $key => [ $label ] ) {
			$val = $instance[ 'url_' . $key ] ?? '';
			echo '<p><label>' . esc_html( $label ) . ' URL:<input class="widefat" name="' . esc_attr( $this->get_field_name( 'url_' . $key ) ) . '" type="url" value="' . esc_attr( $val ) . '"></label></p>';
		}
	}

	public function update( $new, $old ) {
		$data = array( 'title' => sanitize_text_field( $new['title'] ) );
		foreach ( self::$networks as $key => $_ ) {
			$data[ 'url_' . $key ] = esc_url_raw( $new[ 'url_' . $key ] ?? '' );
		}
		return $data;
	}
}
