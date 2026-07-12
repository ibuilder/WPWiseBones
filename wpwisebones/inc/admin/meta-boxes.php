<?php
/**
 * Custom meta boxes for posts / pages.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'add_meta_boxes', 'wpwisebones_register_meta_boxes' );

function wpwisebones_register_meta_boxes() {
    // Layout override
    add_meta_box(
        'wpwisebones_layout_meta',
        __( 'Page Layout', 'wpwisebones' ),
        'wpwisebones_meta_layout_callback',
        [ 'post', 'page' ],
        'side',
        'default'
    );

    // Page header options
    add_meta_box(
        'wpwisebones_page_header_meta',
        __( 'Page Header Options', 'wpwisebones' ),
        'wpwisebones_meta_page_header_callback',
        [ 'post', 'page' ],
        'normal',
        'low'
    );
}

/* â”€â”€ Layout override â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpwisebones_meta_layout_callback( WP_Post $post ) {
    wp_nonce_field( 'wpwisebones_layout_meta_nonce', 'wpwisebones_layout_nonce' );
    $layout = get_post_meta( $post->ID, '_wpwisebones_layout', true );
    ?>
    <label class="screen-reader-text" for="wpwisebones_layout_select"><?php esc_html_e( 'Layout', 'wpwisebones' ); ?></label>
    <select id="wpwisebones_layout_select" name="wpwisebones_layout" style="width:100%">
        <option value="" <?php selected( $layout, '' ); ?>><?php esc_html_e( 'â€” Default (from Customizer) â€”', 'wpwisebones' ); ?></option>
        <option value="right-sidebar" <?php selected( $layout, 'right-sidebar' ); ?>><?php esc_html_e( 'Right Sidebar', 'wpwisebones' ); ?></option>
        <option value="left-sidebar"  <?php selected( $layout, 'left-sidebar'  ); ?>><?php esc_html_e( 'Left Sidebar',  'wpwisebones' ); ?></option>
        <option value="full-width"    <?php selected( $layout, 'full-width'    ); ?>><?php esc_html_e( 'Full Width',    'wpwisebones' ); ?></option>
    </select>
    <?php
}

/* â”€â”€ Page header options â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

function wpwisebones_meta_page_header_callback( WP_Post $post ) {
    wp_nonce_field( 'wpwisebones_page_header_nonce', 'wpwisebones_ph_nonce' );

    $hide_title  = get_post_meta( $post->ID, '_wpwisebones_hide_title', true );
    $custom_hero = get_post_meta( $post->ID, '_wpwisebones_hero_text', true );
    $hero_image  = get_post_meta( $post->ID, '_wpwisebones_hero_image', true );
    ?>
    <table class="form-table" role="presentation">
        <tr>
            <th scope="row"><label for="wpwisebones_hide_title"><?php esc_html_e( 'Hide Page Title', 'wpwisebones' ); ?></label></th>
            <td><input type="checkbox" id="wpwisebones_hide_title" name="wpwisebones_hide_title" value="1" <?php checked( $hide_title, '1' ); ?>></td>
        </tr>
        <tr>
            <th scope="row"><label for="wpwisebones_hero_text"><?php esc_html_e( 'Hero Sub-text', 'wpwisebones' ); ?></label></th>
            <td><input type="text" id="wpwisebones_hero_text" name="wpwisebones_hero_text" value="<?php echo esc_attr( $custom_hero ); ?>" class="regular-text" placeholder="<?php esc_attr_e( 'Optional hero subtitle', 'wpwisebones' ); ?>"></td>
        </tr>
        <tr>
            <th scope="row"><label for="wpwisebones_hero_image"><?php esc_html_e( 'Hero Background Image URL', 'wpwisebones' ); ?></label></th>
            <td>
                <input type="url" id="wpwisebones_hero_image" name="wpwisebones_hero_image" value="<?php echo esc_attr( $hero_image ); ?>" class="regular-text">
                <button type="button" class="button wpb-media-upload" data-target="wpwisebones_hero_image"><?php esc_html_e( 'Upload', 'wpwisebones' ); ?></button>
            </td>
        </tr>
    </table>
    <?php
}

/* â”€â”€ Save meta boxes â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

add_action( 'save_post', 'wpwisebones_save_meta_boxes' );

function wpwisebones_save_meta_boxes( int $post_id ) {
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;

    // Layout
    if ( isset( $_POST['wpwisebones_layout_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpwisebones_layout_nonce'] ) ), 'wpwisebones_layout_meta_nonce' ) ) {
        $layout = sanitize_text_field( wp_unslash( $_POST['wpwisebones_layout'] ?? '' ) );
        if ( $layout ) {
            update_post_meta( $post_id, '_wpwisebones_layout', $layout );
        } else {
            delete_post_meta( $post_id, '_wpwisebones_layout' );
        }
    }

    // Page header
    if ( isset( $_POST['wpwisebones_ph_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpwisebones_ph_nonce'] ) ), 'wpwisebones_page_header_nonce' ) ) {
        update_post_meta( $post_id, '_wpwisebones_hide_title', ! empty( $_POST['wpwisebones_hide_title'] ) ? '1' : '' );
        update_post_meta( $post_id, '_wpwisebones_hero_text',  sanitize_text_field( wp_unslash( $_POST['wpwisebones_hero_text']  ?? '' ) ) );
        update_post_meta( $post_id, '_wpwisebones_hero_image', esc_url_raw( wp_unslash( $_POST['wpwisebones_hero_image'] ?? '' ) ) );
    }
}

/* â”€â”€ Media uploader for meta box â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€â”€ */

// Enqueue media library on post edit screens so wp.media is available
add_action( 'admin_enqueue_scripts', function( $hook ) {
    if ( in_array( $hook, [ 'post.php', 'post-new.php' ], true ) ) {
        wp_enqueue_media();
    }
} );

add_action( 'admin_footer-post.php',     'wpwisebones_meta_uploader_js' );
add_action( 'admin_footer-post-new.php', 'wpwisebones_meta_uploader_js' );

function wpwisebones_meta_uploader_js() {
    ?>
    <script>
    (function($){
        $(document).on('click', '.wpb-media-upload', function(e){
            e.preventDefault();
            var target = $(this).data('target');
            var frame = wp.media({ title: 'Select Image', multiple: false });
            frame.on('select', function(){
                var att = frame.state().get('selection').first().toJSON();
                $('#' + target).val(att.url);
            });
            frame.open();
        });
    })(jQuery);
    </script>
    <?php
}
