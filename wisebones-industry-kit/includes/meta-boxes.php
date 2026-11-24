<?php
/**
 * Classic meta boxes for the kit's fields. The fields are also registered for
 * REST, so the block editor and the REST API can read and write them.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes', 'wbik_add_meta_boxes' );

/**
 * One "Details" box per enabled content type.
 */
function wbik_add_meta_boxes() {
	foreach ( array_keys( wbik_all_types() ) as $type ) {
		if ( ! wbik_type_enabled( $type ) || ! wbik_fields( $type ) ) {
			continue;
		}
		list( , $singular ) = wbik_type_labels( $type );
		add_meta_box(
			'wbik_details',
			/* translators: %s: singular content label. */
			sprintf( __( '%s details', 'wisebones-industry-kit' ), $singular ),
			'wbik_render_meta_box',
			'wbik_' . $type,
			'normal',
			'high',
			array( 'type' => $type )
		);
	}

	add_meta_box( 'wbik_lead_details', __( 'Lead details', 'wisebones-industry-kit' ), 'wbik_render_lead_box', 'wbik_lead', 'normal', 'high' );
}

/**
 * Render the fields as a two-column grid.
 *
 * @param WP_Post $post Post.
 * @param array   $box  Meta box args.
 */
function wbik_render_meta_box( $post, $box ) {
	$type = $box['args']['type'];
	wp_nonce_field( 'wbik_save_' . $type, 'wbik_nonce' );
	echo '<div class="wbik-fields" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px 16px">';
	foreach ( wbik_fields( $type ) as $key => $field ) {
		$id    = 'wbik_' . $key;
		$value = (string) get_post_meta( $post->ID, '_wbik_' . $key, true );
		echo '<p style="margin:0"><label for="' . esc_attr( $id ) . '" style="display:block;font-weight:600;margin-bottom:4px">' . esc_html( $field['label'] ) . '</label>';
		if ( 'select' === $field['type'] ) {
			echo '<select class="widefat" id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '">';
			if ( ! array_key_exists( '', $field['options'] ) ) {
				echo '<option value="">' . esc_html__( '—', 'wisebones-industry-kit' ) . '</option>';
			}
			foreach ( $field['options'] as $opt => $label ) {
				echo '<option value="' . esc_attr( $opt ) . '"' . selected( $value, (string) $opt, false ) . '>' . esc_html( $label ) . '</option>';
			}
			echo '</select>';
		} else {
			$input = in_array( $field['type'], array( 'url', 'email' ), true ) ? $field['type'] : 'text';
			echo '<input class="widefat" type="' . esc_attr( $input ) . '" id="' . esc_attr( $id ) . '" name="' . esc_attr( $id ) . '" value="' . esc_attr( $value ) . '"' . ( ! empty( $field['placeholder'] ) ? ' placeholder="' . esc_attr( $field['placeholder'] ) . '"' : '' ) . ( 'number' === $field['type'] ? ' inputmode="decimal"' : '' ) . '>';
		}
		echo '</p>';
	}
	echo '</div>';
}

add_action( 'save_post', 'wbik_save_meta_box', 10, 2 );

/**
 * Save the fields from the classic box.
 *
 * @param int     $post_id Post ID.
 * @param WP_Post $post    Post.
 */
function wbik_save_meta_box( $post_id, $post ) {
	if ( 0 !== strpos( $post->post_type, 'wbik_' ) || 'wbik_lead' === $post->post_type ) {
		return;
	}
	$type = substr( $post->post_type, 5 );
	if ( ! isset( $_POST['wbik_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wbik_nonce'] ) ), 'wbik_save_' . $type ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	foreach ( wbik_fields( $type ) as $key => $field ) {
		if ( ! isset( $_POST[ 'wbik_' . $key ] ) ) {
			continue;
		}
		$value = wbik_sanitize_field( wp_unslash( $_POST[ 'wbik_' . $key ] ), $field ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized by wbik_sanitize_field() per field type.
		if ( '' === $value ) {
			delete_post_meta( $post_id, '_wbik_' . $key );
		} else {
			update_post_meta( $post_id, '_wbik_' . $key, $value );
		}
	}
}

/**
 * Read-only view of a lead.
 *
 * @param WP_Post $post Lead.
 */
function wbik_render_lead_box( $post ) {
	$data = get_post_meta( $post->ID, '_wbik_lead', true );
	$data = is_array( $data ) ? $data : array();
	echo '<table class="widefat striped"><tbody>';
	foreach ( $data as $label => $value ) {
		echo '<tr><th style="width:30%">' . esc_html( $label ) . '</th><td>' . nl2br( esc_html( $value ) ) . '</td></tr>';
	}
	echo '</tbody></table>';
	$source = get_post_meta( $post->ID, '_wbik_source', true );
	if ( $source ) {
		/* translators: %s: page URL the lead was sent from. */
		echo '<p>' . wp_kses_post( sprintf( __( 'Sent from %s', 'wisebones-industry-kit' ), '<a href="' . esc_url( $source ) . '">' . esc_html( $source ) . '</a>' ) ) . '</p>';
	}
}
