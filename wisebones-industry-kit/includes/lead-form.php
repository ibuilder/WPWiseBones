<?php
/**
 * Lead capture: [wbik_lead_form type="quote|showing|valuation|prequal|owner|order|contact"].
 *
 * Every submission is stored as a private Lead (Leads menu) and emailed to the
 * address on Settings → Industry Kit. Spam is turned away by a nonce, a hidden
 * honeypot field, a signed timestamp that rejects instant bot posts, and a
 * per-visitor rate limit; nothing is sent to a third-party service.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

/**
 * Form definitions.
 *
 * @return array<string,array> type => [ label, button, fields[ key => [ label, type, options?, required? ] ], compact keys ]
 */
function wbik_lead_types(): array {
	$timeline = array(
		''        => __( 'Select…', 'wisebones-industry-kit' ),
		'asap'    => __( 'As soon as possible', 'wisebones-industry-kit' ),
		'1-3'     => __( '1–3 months', 'wisebones-industry-kit' ),
		'3-6'     => __( '3–6 months', 'wisebones-industry-kit' ),
		'6+'      => __( '6+ months', 'wisebones-industry-kit' ),
		'unsure'  => __( 'Just exploring', 'wisebones-industry-kit' ),
	);

	$services = array( '' => __( 'Select…', 'wisebones-industry-kit' ) );
	if ( post_type_exists( 'wbik_service' ) ) {
		$posts = get_posts(
			array(
				'post_type'      => 'wbik_service',
				'posts_per_page' => 30,
				'orderby'        => 'menu_order title',
				'order'          => 'ASC',
			)
		);
		foreach ( $posts as $post ) {
			$services[ get_the_title( $post ) ] = get_the_title( $post );
		}
	}
	$services['other'] = __( 'Something else', 'wisebones-industry-kit' );

	$types = array(
		'contact'   => array(
			__( 'Contact', 'wisebones-industry-kit' ),
			__( 'Send message', 'wisebones-industry-kit' ),
			array(),
			array(),
		),
		'quote'     => array(
			__( 'Estimate request', 'wisebones-industry-kit' ),
			__( 'Request my estimate', 'wisebones-industry-kit' ),
			array(
				'service'  => array( __( 'What do you need?', 'wisebones-industry-kit' ), 'select', $services ),
				'location' => array( __( 'Project address or ZIP', 'wisebones-industry-kit' ), 'text' ),
				'budget'   => array(
					__( 'Budget', 'wisebones-industry-kit' ),
					'select',
					array(
						''         => __( 'Select…', 'wisebones-industry-kit' ),
						'<10k'     => __( 'Under $10k', 'wisebones-industry-kit' ),
						'10-50k'   => __( '$10k–$50k', 'wisebones-industry-kit' ),
						'50-250k'  => __( '$50k–$250k', 'wisebones-industry-kit' ),
						'250k-1m'  => __( '$250k–$1M', 'wisebones-industry-kit' ),
						'1m+'      => __( '$1M+', 'wisebones-industry-kit' ),
						'unsure'   => __( 'Not sure yet', 'wisebones-industry-kit' ),
					),
				),
				'timeline' => array( __( 'Timeline', 'wisebones-industry-kit' ), 'select', $timeline ),
			),
			array( 'service', 'location' ),
		),
		'showing'   => array(
			__( 'Showing / tour request', 'wisebones-industry-kit' ),
			__( 'Request a showing', 'wisebones-industry-kit' ),
			array(
				'property' => array( __( 'Property', 'wisebones-industry-kit' ), 'text' ),
				'date'     => array( __( 'Preferred date', 'wisebones-industry-kit' ), 'date' ),
				'time'     => array(
					__( 'Preferred time', 'wisebones-industry-kit' ),
					'select',
					array(
						''          => __( 'Any time', 'wisebones-industry-kit' ),
						'morning'   => __( 'Morning', 'wisebones-industry-kit' ),
						'afternoon' => __( 'Afternoon', 'wisebones-industry-kit' ),
						'evening'   => __( 'Evening', 'wisebones-industry-kit' ),
					),
				),
			),
			array( 'date' ),
		),
		'valuation' => array(
			__( 'Home valuation request', 'wisebones-industry-kit' ),
			__( 'Get my home value', 'wisebones-industry-kit' ),
			array(
				'address'  => array( __( 'Property address', 'wisebones-industry-kit' ), 'text', null, true ),
				'beds'     => array( __( 'Bedrooms', 'wisebones-industry-kit' ), 'text' ),
				'baths'    => array( __( 'Bathrooms', 'wisebones-industry-kit' ), 'text' ),
				'timeline' => array( __( 'When are you thinking of selling?', 'wisebones-industry-kit' ), 'select', $timeline ),
			),
			array( 'address' ),
		),
		'prequal'   => array(
			__( 'Pre-qualification request', 'wisebones-industry-kit' ),
			__( 'Start my pre-qualification', 'wisebones-industry-kit' ),
			array(
				'purpose' => array(
					__( 'Loan purpose', 'wisebones-industry-kit' ),
					'select',
					array(
						''         => __( 'Select…', 'wisebones-industry-kit' ),
						'purchase' => __( 'Buy a home', 'wisebones-industry-kit' ),
						'refi'     => __( 'Refinance', 'wisebones-industry-kit' ),
						'cashout'  => __( 'Cash-out refinance', 'wisebones-industry-kit' ),
						'heloc'    => __( 'Home equity line', 'wisebones-industry-kit' ),
						'invest'   => __( 'Investment property', 'wisebones-industry-kit' ),
					),
				),
				'price'   => array( __( 'Estimated price or loan amount', 'wisebones-industry-kit' ), 'text' ),
				'credit'  => array(
					__( 'Credit (estimate)', 'wisebones-industry-kit' ),
					'select',
					array(
						''          => __( 'Prefer not to say', 'wisebones-industry-kit' ),
						'740+'      => __( 'Excellent (740+)', 'wisebones-industry-kit' ),
						'680-739'   => __( 'Good (680–739)', 'wisebones-industry-kit' ),
						'620-679'   => __( 'Fair (620–679)', 'wisebones-industry-kit' ),
						'<620'      => __( 'Rebuilding (under 620)', 'wisebones-industry-kit' ),
					),
				),
				'timeline' => array( __( 'Timeline', 'wisebones-industry-kit' ), 'select', $timeline ),
			),
			array( 'purpose' ),
		),
		'owner'     => array(
			__( 'Owner inquiry', 'wisebones-industry-kit' ),
			__( 'Get a management proposal', 'wisebones-industry-kit' ),
			array(
				'address' => array( __( 'Property address', 'wisebones-industry-kit' ), 'text', null, true ),
				'kind'    => array(
					__( 'Property type', 'wisebones-industry-kit' ),
					'select',
					array(
						''       => __( 'Select…', 'wisebones-industry-kit' ),
						'sfr'    => __( 'Single-family home', 'wisebones-industry-kit' ),
						'condo'  => __( 'Condo / townhome', 'wisebones-industry-kit' ),
						'multi'  => __( 'Multifamily (2–20 units)', 'wisebones-industry-kit' ),
						'large'  => __( 'Apartment community (20+)', 'wisebones-industry-kit' ),
						'hoa'    => __( 'HOA / association', 'wisebones-industry-kit' ),
						'comm'   => __( 'Commercial', 'wisebones-industry-kit' ),
					),
				),
				'units'   => array( __( 'Number of units', 'wisebones-industry-kit' ), 'text' ),
			),
			array( 'address', 'kind' ),
		),
		'order'     => array(
			__( 'Title / escrow order', 'wisebones-industry-kit' ),
			__( 'Open an order', 'wisebones-industry-kit' ),
			array(
				'address' => array( __( 'Property address', 'wisebones-industry-kit' ), 'text', null, true ),
				'kind'    => array(
					__( 'Transaction', 'wisebones-industry-kit' ),
					'select',
					array(
						''         => __( 'Select…', 'wisebones-industry-kit' ),
						'purchase' => __( 'Purchase', 'wisebones-industry-kit' ),
						'refi'     => __( 'Refinance', 'wisebones-industry-kit' ),
						'cash'     => __( 'Cash sale', 'wisebones-industry-kit' ),
						'1031'     => __( '1031 exchange', 'wisebones-industry-kit' ),
						'comm'     => __( 'Commercial', 'wisebones-industry-kit' ),
					),
				),
				'role'    => array(
					__( 'You are the', 'wisebones-industry-kit' ),
					'select',
					array(
						''       => __( 'Select…', 'wisebones-industry-kit' ),
						'agent'  => __( 'Agent', 'wisebones-industry-kit' ),
						'lender' => __( 'Lender', 'wisebones-industry-kit' ),
						'buyer'  => __( 'Buyer', 'wisebones-industry-kit' ),
						'seller' => __( 'Seller', 'wisebones-industry-kit' ),
					),
				),
				'closing' => array( __( 'Target closing date', 'wisebones-industry-kit' ), 'date' ),
			),
			array( 'address', 'kind' ),
		),
	);

	/**
	 * Filters the lead form definitions. Add a type, or add fields to one.
	 *
	 * @param array $types Form definitions.
	 */
	return (array) apply_filters( 'wbik_lead_types', $types );
}

add_shortcode( 'wbik_lead_form', 'wbik_lead_form_shortcode' );

/**
 * Render the form.
 *
 * @param array|string $atts Shortcode attributes.
 */
function wbik_lead_form_shortcode( $atts ): string {
	static $instance = 0;
	++$instance;

	$settings = wbik_settings();
	$atts     = shortcode_atts(
		array(
			'type'    => $settings['lead_type'],
			'title'   => null,
			'button'  => '',
			'compact' => '',
		),
		$atts,
		'wbik_lead_form'
	);

	$types = wbik_lead_types();
	$type  = isset( $types[ $atts['type'] ] ) ? $atts['type'] : 'contact';
	$def   = $types[ $type ];
	$title = null === $atts['title'] ? $def[0] : $atts['title'];
	$id    = 'wbik-lead-' . $instance;

	$fields = $def[2];
	if ( $atts['compact'] ) {
		$fields = array_intersect_key( $fields, array_flip( $def[3] ) );
	}

	// Prefill the property on a single listing.
	$property = '';
	if ( 'showing' === $type && is_singular( 'wbik_listing' ) ) {
		$property = get_the_title();
	}

	$status = isset( $_GET['wbik_lead'], $_GET['wbik_form'] ) && sanitize_key( wp_unslash( $_GET['wbik_form'] ) ) === $id ? sanitize_key( wp_unslash( $_GET['wbik_lead'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display-only status flag set by our own redirect.

	ob_start();
	?>
	<form class="wbik-lead<?php echo $atts['compact'] ? ' wbik-lead--compact' : ''; ?>" id="<?php echo esc_attr( $id ); ?>" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( '' !== (string) $title ) : ?>
			<h3 class="wbik-lead__title"><?php echo esc_html( $title ); ?></h3>
		<?php endif; ?>

		<?php if ( 'sent' === $status ) : ?>
			<div class="alert alert-success" role="status"><?php esc_html_e( 'Thanks — your request is in. We will be in touch shortly.', 'wisebones-industry-kit' ); ?></div>
		<?php elseif ( $status ) : ?>
			<div class="alert alert-warning" role="alert"><?php esc_html_e( 'Sorry, that did not go through. Please check the required fields and try again, or call us.', 'wisebones-industry-kit' ); ?></div>
		<?php endif; ?>

		<input type="hidden" name="action" value="wbik_lead">
		<input type="hidden" name="wbik_type" value="<?php echo esc_attr( $type ); ?>">
		<input type="hidden" name="wbik_form" value="<?php echo esc_attr( $id ); ?>">
		<input type="hidden" name="wbik_ts" value="<?php echo esc_attr( wbik_sign_time( time() ) ); ?>">
		<?php wp_nonce_field( 'wbik_lead', 'wbik_lead_nonce' ); ?>
		<div class="wbik-hp" aria-hidden="true">
			<label for="<?php echo esc_attr( $id ); ?>-website"><?php esc_html_e( 'Leave this field empty', 'wisebones-industry-kit' ); ?></label>
			<input type="text" id="<?php echo esc_attr( $id ); ?>-website" name="wbik_website" value="" tabindex="-1" autocomplete="off">
		</div>

		<div class="row g-3">
			<div class="col-md-6">
				<label class="form-label" for="<?php echo esc_attr( $id ); ?>-name"><?php esc_html_e( 'Name', 'wisebones-industry-kit' ); ?> <span aria-hidden="true">*</span></label>
				<input class="form-control" type="text" id="<?php echo esc_attr( $id ); ?>-name" name="wbik_name" required autocomplete="name">
			</div>
			<div class="col-md-6">
				<label class="form-label" for="<?php echo esc_attr( $id ); ?>-phone"><?php esc_html_e( 'Phone', 'wisebones-industry-kit' ); ?></label>
				<input class="form-control" type="tel" id="<?php echo esc_attr( $id ); ?>-phone" name="wbik_phone" autocomplete="tel">
			</div>
			<div class="col-12">
				<label class="form-label" for="<?php echo esc_attr( $id ); ?>-email"><?php esc_html_e( 'Email', 'wisebones-industry-kit' ); ?> <span aria-hidden="true">*</span></label>
				<input class="form-control" type="email" id="<?php echo esc_attr( $id ); ?>-email" name="wbik_email" required autocomplete="email">
			</div>

			<?php foreach ( $fields as $key => $field ) : ?>
				<?php
				$fid      = $id . '-' . $key;
				$required = ! empty( $field[3] );
				$wide     = 'text' === $field[1] && in_array( $key, array( 'address', 'location', 'property' ), true );
				?>
				<div class="<?php echo esc_attr( $wide || $atts['compact'] ? 'col-12' : 'col-md-6' ); ?>">
					<label class="form-label" for="<?php echo esc_attr( $fid ); ?>"><?php echo esc_html( $field[0] ); ?><?php echo $required ? ' <span aria-hidden="true">*</span>' : ''; ?></label>
					<?php if ( 'select' === $field[1] ) : ?>
						<select class="form-select" id="<?php echo esc_attr( $fid ); ?>" name="wbik_f[<?php echo esc_attr( $key ); ?>]"<?php echo $required ? ' required' : ''; ?>>
							<?php foreach ( (array) $field[2] as $value => $label ) : ?>
								<option value="<?php echo esc_attr( $value ); ?>"><?php echo esc_html( $label ); ?></option>
							<?php endforeach; ?>
						</select>
					<?php else : ?>
						<input class="form-control" type="<?php echo esc_attr( 'date' === $field[1] ? 'date' : 'text' ); ?>" id="<?php echo esc_attr( $fid ); ?>" name="wbik_f[<?php echo esc_attr( $key ); ?>]" value="<?php echo esc_attr( 'property' === $key ? $property : '' ); ?>"<?php echo $required ? ' required' : ''; ?>>
					<?php endif; ?>
				</div>
			<?php endforeach; ?>

			<?php if ( ! $atts['compact'] ) : ?>
				<div class="col-12">
					<label class="form-label" for="<?php echo esc_attr( $id ); ?>-message"><?php esc_html_e( 'Anything else we should know?', 'wisebones-industry-kit' ); ?></label>
					<textarea class="form-control" id="<?php echo esc_attr( $id ); ?>-message" name="wbik_message" rows="3"></textarea>
				</div>
			<?php endif; ?>

			<?php if ( '' !== $settings['consent'] ) : ?>
				<div class="col-12">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" id="<?php echo esc_attr( $id ); ?>-consent" name="wbik_consent" value="1" required>
						<label class="form-check-label small" for="<?php echo esc_attr( $id ); ?>-consent"><?php echo esc_html( $settings['consent'] ); ?></label>
					</div>
				</div>
			<?php endif; ?>

			<div class="col-12">
				<button class="btn btn-primary btn-lg w-100" type="submit"><?php echo esc_html( '' !== $atts['button'] ? $atts['button'] : $def[1] ); ?></button>
			</div>
		</div>
	</form>
	<?php
	return (string) ob_get_clean();
}

/**
 * A timestamp signed with the site's salt, so the handler can tell how long
 * the form was open without trusting the browser.
 *
 * @param int $time Unix time.
 */
function wbik_sign_time( int $time ): string {
	return $time . '.' . substr( hash_hmac( 'sha256', (string) $time, wp_salt( 'nonce' ) ), 0, 16 );
}

/**
 * Seconds since a signed timestamp, or -1 when the signature does not match.
 *
 * @param string $token Signed timestamp.
 */
function wbik_token_age( string $token ): int {
	$parts = explode( '.', $token );
	if ( 2 !== count( $parts ) || ! ctype_digit( $parts[0] ) ) {
		return -1;
	}
	return hash_equals( wbik_sign_time( (int) $parts[0] ), $token ) ? time() - (int) $parts[0] : -1;
}

add_action( 'admin_post_nopriv_wbik_lead', 'wbik_handle_lead' );
add_action( 'admin_post_wbik_lead', 'wbik_handle_lead' );

/**
 * Validate, store and email a submission, then send the visitor back.
 */
function wbik_handle_lead() {
	$back = wp_get_referer();
	$back = $back ? $back : home_url( '/' );
	$form = isset( $_POST['wbik_form'] ) ? sanitize_key( wp_unslash( $_POST['wbik_form'] ) ) : '';
	$done = static function ( $result ) use ( $back, $form ) {
		$url = add_query_arg(
			array(
				'wbik_lead' => $result,
				'wbik_form' => $form,
			),
			remove_query_arg( array( 'wbik_lead', 'wbik_form' ), $back )
		);
		wp_safe_redirect( $url . '#' . $form );
		exit;
	};

	if ( ! isset( $_POST['wbik_lead_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wbik_lead_nonce'] ) ), 'wbik_lead' ) ) {
		$done( 'expired' );
	}

	// Bots fill every field and post instantly. Pretend success so they move on.
	$age = wbik_token_age( isset( $_POST['wbik_ts'] ) ? sanitize_text_field( wp_unslash( $_POST['wbik_ts'] ) ) : '' );
	if ( ! empty( $_POST['wbik_website'] ) || $age < 3 || $age > DAY_IN_SECONDS ) {
		$done( 'sent' );
	}

	$ip_key = 'wbik_rl_' . md5( ( isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '' ) . wp_salt( 'nonce' ) );
	$count  = (int) get_transient( $ip_key );
	if ( $count >= 5 ) {
		$done( 'limit' );
	}

	$name  = isset( $_POST['wbik_name'] ) ? sanitize_text_field( wp_unslash( $_POST['wbik_name'] ) ) : '';
	$email = isset( $_POST['wbik_email'] ) ? sanitize_email( wp_unslash( $_POST['wbik_email'] ) ) : '';
	if ( '' === $name || ! is_email( $email ) ) {
		$done( 'invalid' );
	}

	$types = wbik_lead_types();
	$type  = isset( $_POST['wbik_type'] ) ? sanitize_key( wp_unslash( $_POST['wbik_type'] ) ) : 'contact';
	$type  = isset( $types[ $type ] ) ? $type : 'contact';
	$def   = $types[ $type ];

	$data = array(
		__( 'Name', 'wisebones-industry-kit' )  => $name,
		__( 'Email', 'wisebones-industry-kit' ) => $email,
		__( 'Phone', 'wisebones-industry-kit' ) => isset( $_POST['wbik_phone'] ) ? sanitize_text_field( wp_unslash( $_POST['wbik_phone'] ) ) : '',
	);

	$posted = isset( $_POST['wbik_f'] ) && is_array( $_POST['wbik_f'] ) ? map_deep( wp_unslash( $_POST['wbik_f'] ), 'sanitize_text_field' ) : array(); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized by map_deep().
	foreach ( $def[2] as $key => $field ) {
		$value = isset( $posted[ $key ] ) ? (string) $posted[ $key ] : '';
		if ( 'select' === $field[1] ) {
			$options = (array) $field[2];
			$value   = array_key_exists( $value, $options ) ? ( '' === $value ? '' : $options[ $value ] ) : '';
		}
		if ( ! empty( $field[3] ) && '' === $value ) {
			$done( 'invalid' );
		}
		if ( '' !== $value ) {
			$data[ $field[0] ] = $value;
		}
	}
	if ( ! empty( $_POST['wbik_message'] ) ) {
		$data[ __( 'Message', 'wisebones-industry-kit' ) ] = sanitize_textarea_field( wp_unslash( $_POST['wbik_message'] ) );
	}
	if ( ! empty( $_POST['wbik_consent'] ) ) {
		$data[ __( 'Consent', 'wisebones-industry-kit' ) ] = __( 'Yes', 'wisebones-industry-kit' );
	}
	$data = array_filter( $data, 'strlen' );

	set_transient( $ip_key, $count + 1, HOUR_IN_SECONDS );

	$lead_id = wp_insert_post(
		array(
			'post_type'   => 'wbik_lead',
			'post_status' => 'private',
			/* translators: 1: visitor name, 2: form type label. */
			'post_title'  => sprintf( __( '%1$s — %2$s', 'wisebones-industry-kit' ), $name, $def[0] ),
		),
		true
	);
	if ( ! is_wp_error( $lead_id ) ) {
		update_post_meta( $lead_id, '_wbik_lead', $data );
		update_post_meta( $lead_id, '_wbik_lead_type', $type );
		update_post_meta( $lead_id, '_wbik_source', esc_url_raw( $back ) );
	}

	$settings = wbik_settings();
	$to       = is_email( $settings['lead_email'] ) ? $settings['lead_email'] : get_option( 'admin_email' );
	$lines    = array();
	foreach ( $data as $label => $value ) {
		$lines[] = $label . ': ' . $value;
	}
	$lines[] = '';
	/* translators: %s: page URL. */
	$lines[] = sprintf( __( 'Sent from: %s', 'wisebones-industry-kit' ), $back );
	if ( ! is_wp_error( $lead_id ) ) {
		/* translators: %s: admin URL of the stored lead. */
		$lines[] = sprintf( __( 'Stored as: %s', 'wisebones-industry-kit' ), admin_url( 'post.php?post=' . (int) $lead_id . '&action=edit' ) );
	}
	$reply = str_replace( array( "\r", "\n", '"' ), '', $name );

	wp_mail(
		$to,
		/* translators: 1: site name, 2: form type label, 3: visitor name. */
		sprintf( __( '[%1$s] New %2$s from %3$s', 'wisebones-industry-kit' ), wp_specialchars_decode( get_bloginfo( 'name' ), ENT_QUOTES ), strtolower( $def[0] ), $reply ),
		implode( "\n", $lines ),
		array( 'Reply-To: "' . $reply . '" <' . $email . '>' )
	);

	/**
	 * Fires after a lead is stored and emailed — hook a CRM here.
	 *
	 * @param int|WP_Error $lead_id Lead post ID.
	 * @param array        $data    Label => value.
	 * @param string       $type    Form type.
	 */
	do_action( 'wbik_lead_received', $lead_id, $data, $type );

	$done( 'sent' );
}
