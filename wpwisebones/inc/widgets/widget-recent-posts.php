<?php
/**
 * Custom Widget: BSK Recent Posts with thumbnails.
 */

defined( 'ABSPATH' ) || exit;

class WPB_Widget_Recent_Posts extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'wpb_recent_posts',
            __( 'WPB: Recent Posts', 'wpwisebones' ),
            [ 'description' => __( 'Recent posts with thumbnails, date, and read time.', 'wpwisebones' ) ]
        );
    }

    public function widget( $args, $instance ) {
        $title    = apply_filters( 'widget_title', $instance['title'] ?? '' );
        $count    = absint( $instance['count'] ?? 5 );
        $show_img = ! empty( $instance['show_img'] );
        $show_date= ! empty( $instance['show_date'] );

        echo $args['before_widget']; // phpcs:ignore
        if ( $title ) echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // phpcs:ignore

        $posts = new WP_Query( [
            'posts_per_page' => $count,
            'no_found_rows'  => true,
            'post_status'    => 'publish',
        ] );

        if ( $posts->have_posts() ) :
            echo '<ul class="list-unstyled wpb-widget-recent-posts">';
            while ( $posts->have_posts() ) :
                $posts->the_post();
                echo '<li class="rp-item">';
                if ( $show_img && has_post_thumbnail() ) {
                    echo '<a href="' . esc_url( get_permalink() ) . '">';
                    echo get_the_post_thumbnail( null, [ 60, 60 ], [ 'class' => 'rp-thumb' ] );
                    echo '</a>';
                }
                echo '<div>';
                echo '<a href="' . esc_url( get_permalink() ) . '" class="rp-title d-block text-dark text-decoration-none">' . esc_html( get_the_title() ) . '</a>';
                if ( $show_date ) echo '<span class="rp-date">' . esc_html( get_the_date() ) . '</span>';
                echo '</div></li>';
            endwhile;
            echo '</ul>';
            wp_reset_postdata();
        endif;

        echo $args['after_widget']; // phpcs:ignore
    }

    public function form( $instance ) {
        $title     = $instance['title']    ?? __( 'Recent Posts', 'wpwisebones' );
        $count     = $instance['count']    ?? 5;
        $show_img  = $instance['show_img'] ?? 1;
        $show_date = $instance['show_date'] ?? 1;
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title:', 'wpwisebones' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>"><?php esc_html_e( 'Number of posts:', 'wpwisebones' ); ?></label>
            <input class="tiny-text" id="<?php echo esc_attr( $this->get_field_id( 'count' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'count' ) ); ?>" type="number" step="1" min="1" value="<?php echo absint( $count ); ?>" size="3">
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_img' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_img' ) ); ?>" type="checkbox" value="1" <?php checked( $show_img, 1 ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_img' ) ); ?>"><?php esc_html_e( 'Show thumbnail', 'wpwisebones' ); ?></label>
        </p>
        <p>
            <input id="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_date' ) ); ?>" type="checkbox" value="1" <?php checked( $show_date, 1 ); ?>>
            <label for="<?php echo esc_attr( $this->get_field_id( 'show_date' ) ); ?>"><?php esc_html_e( 'Show date', 'wpwisebones' ); ?></label>
        </p>
        <?php
    }

    public function update( $new, $old ) {
        return [
            'title'     => sanitize_text_field( $new['title'] ),
            'count'     => absint( $new['count'] ),
            'show_img'  => ! empty( $new['show_img'] ) ? 1 : 0,
            'show_date' => ! empty( $new['show_date'] ) ? 1 : 0,
        ];
    }
}
