<?php
/**
 * WiseBones Trades — functions.
 *
 * Adds the "Trade" Customizer control that switches industry-config.php
 * between its roofing, HVAC, plumbing and electrical presets. Everything else
 * (front page, sections, brand defaults) comes from the parent's industry
 * framework.
 *
 * @package WiseBones_Trades
 */

defined( 'ABSPATH' ) || exit;

/**
 * The presets the config knows.
 *
 * @return array<string,string> slug => label.
 */
function wisebones_trades_presets(): array {
	return array(
		'roofing'    => __( 'Roofing', 'wisebones-trades' ),
		'hvac'       => __( 'Heating & cooling (HVAC)', 'wisebones-trades' ),
		'plumbing'   => __( 'Plumbing', 'wisebones-trades' ),
		'electrical' => __( 'Electrical', 'wisebones-trades' ),
	);
}

/**
 * Keep only a known preset.
 *
 * @param string $value Submitted value.
 */
function wisebones_trades_sanitize_preset( $value ): string {
	return array_key_exists( $value, wisebones_trades_presets() ) ? (string) $value : 'roofing';
}

add_action( 'customize_register', 'wisebones_trades_customize_register', 20 );

/**
 * Appearance → Customize → Theme Options → Trade.
 *
 * @param WP_Customize_Manager $wp_customize Customizer.
 */
function wisebones_trades_customize_register( $wp_customize ) {
	$wp_customize->add_section(
		'wisebones_trades',
		array(
			'title'       => __( 'Trade', 'wisebones-trades' ),
			'description' => __( 'Pick your trade. It sets the front-page copy, the services list, the brand colour default and the schema.org business type. Publish and reload to see the change.', 'wisebones-trades' ),
			'panel'       => 'wpwisebones_panel',
			'priority'    => 4,
		)
	);
	$wp_customize->add_setting(
		'wisebones_trades_preset',
		array(
			'default'           => 'roofing',
			'transport'         => 'refresh',
			'sanitize_callback' => 'wisebones_trades_sanitize_preset',
		)
	);
	$wp_customize->add_control(
		'wisebones_trades_preset',
		array(
			'label'   => __( 'Your trade', 'wisebones-trades' ),
			'section' => 'wisebones_trades',
			'type'    => 'select',
			'choices' => wisebones_trades_presets(),
		)
	);
}
