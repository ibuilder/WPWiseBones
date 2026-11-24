<?php
/**
 * Settings → Industry Kit: business profile, content types, schema type and
 * lead routing. Plus list columns for Leads.
 *
 * @package WiseBones_Industry_Kit
 */

defined( 'ABSPATH' ) || exit;

add_action( 'admin_menu', 'wbik_settings_menu' );

/**
 * Settings → Industry Kit.
 */
function wbik_settings_menu() {
	add_options_page( __( 'Industry Kit', 'wisebones-industry-kit' ), __( 'Industry Kit', 'wisebones-industry-kit' ), 'manage_options', 'wbik-settings', 'wbik_settings_page' );
}

add_action( 'admin_init', 'wbik_register_settings' );

/**
 * One option, sanitized as a whole.
 */
function wbik_register_settings() {
	register_setting(
		'wbik_settings',
		'wbik_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'wbik_sanitize_settings',
			'default'           => array(),
		)
	);
}

/**
 * Sanitize the settings array.
 *
 * @param mixed $input Raw input.
 */
function wbik_sanitize_settings( $input ): array {
	$input = is_array( $input ) ? $input : array();
	$out   = array(
		'use_theme' => empty( $input['use_theme'] ) ? 0 : 1,
		'types'     => array_values( array_intersect( isset( $input['types'] ) ? (array) $input['types'] : array(), array_keys( wbik_all_types() ) ) ),
		'schema'    => isset( $input['schema'] ) && in_array( $input['schema'], wbik_schema_types(), true ) ? $input['schema'] : 'LocalBusiness',
		'lead_type' => isset( $input['lead_type'] ) && array_key_exists( $input['lead_type'], wbik_lead_types() ) ? $input['lead_type'] : 'contact',
		'currency'  => isset( $input['currency'] ) ? strtoupper( substr( preg_replace( '/[^A-Za-z]/', '', $input['currency'] ), 0, 3 ) ) : 'USD',
	);
	foreach ( array( 'business', 'phone', 'street', 'city', 'region', 'postal', 'country', 'license', 'price_from', 'consent' ) as $key ) {
		$out[ $key ] = isset( $input[ $key ] ) ? sanitize_text_field( $input[ $key ] ) : '';
	}
	foreach ( array( 'email', 'lead_email' ) as $key ) {
		$out[ $key ] = isset( $input[ $key ] ) ? sanitize_email( $input[ $key ] ) : '';
	}
	return $out;
}

/**
 * The settings screen.
 */
function wbik_settings_page() {
	$s     = wbik_settings();
	$theme = wbik_theme_support();
	$text  = static function ( $key, $label, $type = 'text', $help = '' ) use ( $s ) {
		printf(
			'<tr><th scope="row"><label for="wbik-%1$s">%2$s</label></th><td><input class="regular-text" type="%3$s" id="wbik-%1$s" name="wbik_settings[%1$s]" value="%4$s">%5$s</td></tr>',
			esc_attr( $key ),
			esc_html( $label ),
			esc_attr( $type ),
			esc_attr( $s[ $key ] ),
			$help ? '<p class="description">' . esc_html( $help ) . '</p>' : ''
		);
	};
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Industry Kit', 'wisebones-industry-kit' ); ?></h1>
		<form method="post" action="options.php">
			<?php settings_fields( 'wbik_settings' ); ?>

			<h2><?php esc_html_e( 'Business profile', 'wisebones-industry-kit' ); ?></h2>
			<p><?php esc_html_e( 'Used in the schema markup search engines read, and in lead emails.', 'wisebones-industry-kit' ); ?></p>
			<table class="form-table" role="presentation">
				<?php
				$text( 'business', __( 'Business name', 'wisebones-industry-kit' ), 'text', __( 'Leave empty to use the site title.', 'wisebones-industry-kit' ) );
				$text( 'phone', __( 'Phone', 'wisebones-industry-kit' ), 'tel', __( 'Leave empty to use the phone set in the Customizer.', 'wisebones-industry-kit' ) );
				$text( 'email', __( 'Public email', 'wisebones-industry-kit' ), 'email' );
				$text( 'street', __( 'Street address', 'wisebones-industry-kit' ) );
				$text( 'city', __( 'City', 'wisebones-industry-kit' ) );
				$text( 'region', __( 'State / region', 'wisebones-industry-kit' ) );
				$text( 'postal', __( 'ZIP / postal code', 'wisebones-industry-kit' ) );
				$text( 'country', __( 'Country code', 'wisebones-industry-kit' ), 'text', __( 'Two letters, e.g. US.', 'wisebones-industry-kit' ) );
				$text( 'license', __( 'License number', 'wisebones-industry-kit' ), 'text', __( 'Brokerage, contractor or NMLS license, as you are required to display it.', 'wisebones-industry-kit' ) );
				$text( 'price_from', __( 'Price range', 'wisebones-industry-kit' ), 'text', __( 'Optional, e.g. $$ or "From $250".', 'wisebones-industry-kit' ) );
				$text( 'currency', __( 'Currency', 'wisebones-industry-kit' ), 'text', __( 'ISO code for listing prices, e.g. USD.', 'wisebones-industry-kit' ) );
				?>
			</table>

			<h2><?php esc_html_e( 'Leads', 'wisebones-industry-kit' ); ?></h2>
			<table class="form-table" role="presentation">
				<?php $text( 'lead_email', __( 'Send leads to', 'wisebones-industry-kit' ), 'email', __( 'Leave empty to use the site admin email. Every lead is also kept under Leads.', 'wisebones-industry-kit' ) ); ?>
				<?php $text( 'consent', __( 'Consent checkbox text', 'wisebones-industry-kit' ), 'text', __( 'Optional. When set, forms show a required checkbox with this text (e.g. for SMS or marketing consent).', 'wisebones-industry-kit' ) ); ?>
			</table>

			<h2><?php esc_html_e( 'Site type', 'wisebones-industry-kit' ); ?></h2>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><?php esc_html_e( 'Follow the theme', 'wisebones-industry-kit' ); ?></th>
					<td>
						<label><input type="checkbox" name="wbik_settings[use_theme]" value="1" <?php checked( ! empty( $s['use_theme'] ) ); ?>> <?php esc_html_e( 'Use the content types, schema type and lead form the active theme declares', 'wisebones-industry-kit' ); ?></label>
						<p class="description">
							<?php
							echo $theme
								/* translators: %s: theme name. */
								? esc_html( sprintf( __( '%s declares its own defaults.', 'wisebones-industry-kit' ), wp_get_theme()->get( 'Name' ) ) )
								: esc_html__( 'The active theme declares none, so the choices below apply.', 'wisebones-industry-kit' );
							?>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><?php esc_html_e( 'Content types', 'wisebones-industry-kit' ); ?></th>
					<td>
						<?php foreach ( wbik_all_types() as $type => $def ) : ?>
							<label style="display:block"><input type="checkbox" name="wbik_settings[types][]" value="<?php echo esc_attr( $type ); ?>" <?php checked( in_array( $type, $s['types'], true ) ); ?>> <?php echo esc_html( wbik_type_labels( $type )[0] ); ?></label>
						<?php endforeach; ?>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="wbik-schema"><?php esc_html_e( 'Business type (schema.org)', 'wisebones-industry-kit' ); ?></label></th>
					<td>
						<select id="wbik-schema" name="wbik_settings[schema]">
							<?php foreach ( wbik_schema_types() as $type ) : ?>
								<option value="<?php echo esc_attr( $type ); ?>" <?php selected( $s['schema'], $type ); ?>><?php echo esc_html( $type ); ?></option>
							<?php endforeach; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="wbik-lead-type"><?php esc_html_e( 'Default lead form', 'wisebones-industry-kit' ); ?></label></th>
					<td>
						<select id="wbik-lead-type" name="wbik_settings[lead_type]">
							<?php foreach ( wbik_lead_types() as $type => $def ) : ?>
								<option value="<?php echo esc_attr( $type ); ?>" <?php selected( $s['lead_type'], $type ); ?>><?php echo esc_html( $def[0] ); ?></option>
							<?php endforeach; ?>
						</select>
						<p class="description"><?php esc_html_e( 'Any form can be placed with [wbik_lead_form type="quote"] — types: contact, quote, showing, valuation, prequal, owner, order.', 'wisebones-industry-kit' ); ?></p>
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}

add_filter( 'manage_wbik_lead_posts_columns', 'wbik_lead_columns' );

/**
 * Leads list columns.
 *
 * @param array $columns Columns.
 */
function wbik_lead_columns( $columns ): array {
	return array(
		'cb'         => isset( $columns['cb'] ) ? $columns['cb'] : '',
		'title'      => __( 'Lead', 'wisebones-industry-kit' ),
		'wbik_email' => __( 'Email', 'wisebones-industry-kit' ),
		'wbik_phone' => __( 'Phone', 'wisebones-industry-kit' ),
		'date'       => __( 'Received', 'wisebones-industry-kit' ),
	);
}

add_action( 'manage_wbik_lead_posts_custom_column', 'wbik_lead_column', 10, 2 );

/**
 * Leads list cells.
 *
 * @param string $column  Column.
 * @param int    $post_id Lead ID.
 */
function wbik_lead_column( $column, $post_id ) {
	$data  = get_post_meta( $post_id, '_wbik_lead', true );
	$data  = is_array( $data ) ? $data : array();
	$email = isset( $data[ __( 'Email', 'wisebones-industry-kit' ) ] ) ? $data[ __( 'Email', 'wisebones-industry-kit' ) ] : '';
	$phone = isset( $data[ __( 'Phone', 'wisebones-industry-kit' ) ] ) ? $data[ __( 'Phone', 'wisebones-industry-kit' ) ] : '';
	if ( 'wbik_email' === $column && $email ) {
		echo '<a href="' . esc_url( 'mailto:' . $email ) . '">' . esc_html( $email ) . '</a>';
	} elseif ( 'wbik_phone' === $column ) {
		echo esc_html( $phone );
	}
}

add_filter( 'plugin_action_links_' . plugin_basename( WBIK_FILE ), 'wbik_action_links' );

/**
 * Settings link on the Plugins screen.
 *
 * @param array $links Links.
 */
function wbik_action_links( $links ): array {
	array_unshift( $links, '<a href="' . esc_url( admin_url( 'options-general.php?page=wbik-settings' ) ) . '">' . esc_html__( 'Settings', 'wisebones-industry-kit' ) . '</a>' );
	return $links;
}
