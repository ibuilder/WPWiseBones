<?php
/**
 * Custom Widget: BSK CTA Banner.
 */

defined( 'ABSPATH' ) || exit;

class WPB_Widget_CTA_Banner extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'wpb_cta_banner',
            __( 'WPB: CTA Banner', 'wpwisebones' ),
            [ 'description' => __( 'A call-to-action banner with heading, text, and button.', 'wpwisebones' ) ]
        );
    }

    public function widget( $args, $instance ) {
        $title    = $instance['title']    ?? '';
        $text     = $instance['text']     ?? '';
        $btn_text = $instance['btn_text'] ?? '';
        $btn_url  = $instance['btn_url']  ?? '#';
        $bg_color = $instance['bg_color'] ?? 'primary';

        echo $args['before_widget']; // phpcs:ignore
        ?>
        <div class="p-4 rounded text-white" style="background: var(--bs-<?php echo esc_attr( $bg_color ); ?>)">
            <?php if ( $title ) : ?>
                <h4 class="fw-bold"><?php echo esc_html( $title ); ?></h4>
            <?php endif; ?>
            <?php if ( $text ) : ?>
                <p class="mb-3 opacity-75"><?php echo esc_html( $text ); ?></p>
            <?php endif; ?>
            <?php if ( $btn_text ) : ?>
                <a href="<?php echo esc_url( $btn_url ); ?>" class="btn btn-light btn-sm fw-semibold"><?php echo esc_html( $btn_text ); ?></a>
            <?php endif; ?>
        </div>
        <?php
        echo $args['after_widget']; // phpcs:ignore
    }

    public function form( $instance ) {
        $fields = [
            'title'    => [ __( 'Heading', 'wpwisebones' ),       __( 'Need Help?', 'wpwisebones' ) ],
            'text'     => [ __( 'Description', 'wpwisebones' ),   __( 'Contact us today.', 'wpwisebones' ) ],
            'btn_text' => [ __( 'Button Text', 'wpwisebones' ),   __( 'Get in Touch', 'wpwisebones' ) ],
            'btn_url'  => [ __( 'Button URL', 'wpwisebones' ),    '#' ],
            'bg_color' => [ __( 'BG Colour (BS name)', 'wpwisebones' ), 'primary' ],
        ];
        foreach ( $fields as $key => [ $label, $default ] ) {
            $val = $instance[ $key ] ?? $default;
            echo '<p><label>' . esc_html( $label ) . ': <input class="widefat" name="' . esc_attr( $this->get_field_name( $key ) ) . '" type="text" value="' . esc_attr( $val ) . '"></label></p>';
        }
    }

    public function update( $new, $old ) {
        return [
            'title'    => sanitize_text_field( $new['title'] ),
            'text'     => sanitize_text_field( $new['text'] ),
            'btn_text' => sanitize_text_field( $new['btn_text'] ),
            'btn_url'  => esc_url_raw( $new['btn_url'] ),
            'bg_color' => sanitize_text_field( $new['bg_color'] ),
        ];
    }
}
