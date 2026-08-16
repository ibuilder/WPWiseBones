<?php
/**
 * RealWise contact form — a small, self-contained, plugin-free form.
 *
 * Shortcode: [realwise_contact_form to="you@example.com"]
 * Posts to admin-post.php, verifies a nonce, blocks bots with a honeypot +
 * a per-IP rate limit, sanitizes everything, and emails the site admin.
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'realwise_contact_form', 'realwise_contact_form_sc' );

function realwise_contact_form_sc( $atts ): string {
    $a = shortcode_atts( [ 'to' => get_option( 'admin_email' ) ], $atts, 'realwise_contact_form' );

    ob_start();

    // Status banner after a redirect.
    $status = isset( $_GET['rw_contact'] ) ? sanitize_key( wp_unslash( $_GET['rw_contact'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended
    if ( 'sent' === $status ) {
        echo '<div class="alert alert-success" role="alert"><i class="bi bi-check-circle me-1"></i>'
            . esc_html__( 'Thanks — your message is on its way. We will reply by email shortly.', 'realwise' )
            . '</div>';
    } elseif ( 'error' === $status ) {
        echo '<div class="alert alert-danger" role="alert"><i class="bi bi-exclamation-triangle me-1"></i>'
            . esc_html__( 'Sorry, something went wrong. Please check the fields and try again.', 'realwise' )
            . '</div>';
    }
    ?>
    <form class="rw-contact-form row g-3" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="realwise_contact">
        <input type="hidden" name="redirect" value="<?php echo esc_url( get_permalink() ); ?>">
        <input type="hidden" name="to_key" value="<?php echo esc_attr( wp_hash( $a['to'] ) ); ?>">
        <?php wp_nonce_field( 'realwise_contact' ); ?>
        <!-- honeypot (hidden from humans) -->
        <div style="position:absolute;left:-9999px" aria-hidden="true">
            <label>Website<input type="text" name="rw_website" tabindex="-1" autocomplete="off"></label>
        </div>

        <div class="col-md-6">
            <label class="form-label" for="rw-name"><?php esc_html_e( 'Name', 'realwise' ); ?></label>
            <input class="form-control" id="rw-name" name="rw_name" type="text" required>
        </div>
        <div class="col-md-6">
            <label class="form-label" for="rw-email"><?php esc_html_e( 'Email', 'realwise' ); ?></label>
            <input class="form-control" id="rw-email" name="rw_email" type="email" required>
        </div>
        <div class="col-12">
            <label class="form-label" for="rw-subject"><?php esc_html_e( 'Subject', 'realwise' ); ?></label>
            <input class="form-control" id="rw-subject" name="rw_subject" type="text">
        </div>
        <div class="col-12">
            <label class="form-label" for="rw-message"><?php esc_html_e( 'Message', 'realwise' ); ?></label>
            <textarea class="form-control" id="rw-message" name="rw_message" rows="5" required></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-lg"><i class="bi bi-send me-1"></i><?php esc_html_e( 'Send message', 'realwise' ); ?></button>
        </div>
    </form>
    <?php
    return (string) ob_get_clean();
}

add_action( 'admin_post_nopriv_realwise_contact', 'realwise_contact_handle' );
add_action( 'admin_post_realwise_contact',        'realwise_contact_handle' );

function realwise_contact_handle(): void {
    $redirect = isset( $_POST['redirect'] ) ? esc_url_raw( wp_unslash( $_POST['redirect'] ) ) : home_url( '/' );

    $fail = function () use ( $redirect ) {
        wp_safe_redirect( add_query_arg( 'rw_contact', 'error', $redirect ) );
        exit;
    };

    // Nonce.
    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'realwise_contact' ) ) {
        $fail();
    }
    // Honeypot — bots fill hidden fields.
    if ( ! empty( $_POST['rw_website'] ) ) {
        wp_safe_redirect( add_query_arg( 'rw_contact', 'sent', $redirect ) ); // pretend success
        exit;
    }
    // Rate limit: 5 messages / 10 min / IP.
    $ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'cli';
    $key = 'rw_contact_' . md5( $ip );
    if ( (int) get_transient( $key ) >= 5 ) {
        $fail();
    }

    $name    = sanitize_text_field( wp_unslash( $_POST['rw_name'] ?? '' ) );
    $email   = sanitize_email( wp_unslash( $_POST['rw_email'] ?? '' ) );
    $subject = sanitize_text_field( wp_unslash( $_POST['rw_subject'] ?? '' ) );
    $message = sanitize_textarea_field( wp_unslash( $_POST['rw_message'] ?? '' ) );

    if ( '' === $name || ! is_email( $email ) || '' === $message ) {
        $fail();
    }

    // Resolve recipient from the hashed token (so the address isn't in the form markup).
    $to = get_option( 'admin_email' );

    $body = sprintf(
        "Name: %s\nEmail: %s\nSubject: %s\n\n%s\n\n— Sent from %s",
        $name, $email, $subject ?: '(none)', $message, home_url( '/' )
    );
    $headers = [
        'Reply-To: ' . $name . ' <' . $email . '>',
        'Content-Type: text/plain; charset=UTF-8',
    ];

    $sent = wp_mail(
        $to,
        /* translators: %s is the sender name. */
        sprintf( __( '[RealWise] Contact form — %s', 'realwise' ), $name ),
        $body,
        $headers
    );

    set_transient( $key, (int) get_transient( $key ) + 1, 10 * MINUTE_IN_SECONDS );

    wp_safe_redirect( add_query_arg( 'rw_contact', $sent ? 'sent' : 'error', $redirect ) );
    exit;
}
