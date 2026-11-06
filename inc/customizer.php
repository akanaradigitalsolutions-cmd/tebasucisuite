<?php
/**
 * Customizer: Appearance → Customize → Teba Suci Suite.
 *
 * Sections and fields are defined in inc/content.php.
 *
 * @package TebaSuci
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Sanitize an on/off value.
 *
 * @param mixed $value Raw value.
 * @return bool
 */
function tebasuci_sanitize_checkbox( $value ) {
	return (bool) $value;
}

/**
 * Sanitize a link: full URL, /path/, #anchor, mailto: or tel:.
 *
 * @param string $value Raw value.
 * @return string
 */
function tebasuci_sanitize_link( $value ) {
	return esc_url_raw( trim( (string) $value ) );
}

/**
 * Sanitize callback for a field type.
 *
 * @param string $type Field type.
 * @return callable
 */
function tebasuci_sanitize_callback( $type ) {
	switch ( $type ) {
		case 'textarea':
			return 'sanitize_textarea_field';
		case 'link':
			return 'tebasuci_sanitize_link';
		case 'email':
			return 'sanitize_email';
		case 'image':
			return 'absint';
		case 'checkbox':
			return 'tebasuci_sanitize_checkbox';
		default:
			return 'sanitize_text_field';
	}
}

/**
 * Register the panel, sections, settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function tebasuci_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'tebasuci_panel',
		array(
			'title'       => __( 'Teba Suci Suite', 'tebasuci' ),
			'description' => __( 'Homepage text, photos and links, plus booking and contact details. Changes show in the preview on the right and go live when you press Publish.', 'tebasuci' ),
			'priority'    => 20,
		)
	);

	$priority = 10;

	foreach ( tebasuci_fields() as $section_id => $section ) {
		$wp_customize->add_section(
			$section_id,
			array(
				'title'       => $section['title'],
				'description' => isset( $section['description'] ) ? $section['description'] : '',
				'panel'       => 'tebasuci_panel',
				'priority'    => $priority,
			)
		);
		$priority += 10;

		foreach ( $section['fields'] as $key => $field ) {
			$wp_customize->add_setting(
				$key,
				array(
					'default'           => $field['default'],
					'type'              => 'theme_mod',
					'capability'        => 'edit_theme_options',
					'sanitize_callback' => tebasuci_sanitize_callback( $field['type'] ),
					'transport'         => 'refresh',
				)
			);

			$control = array(
				'label'       => $field['label'],
				'description' => isset( $field['description'] ) ? $field['description'] : '',
				'section'     => $section_id,
			);

			if ( 'image' === $field['type'] ) {
				$control['mime_type'] = 'image';
				$wp_customize->add_control( new WP_Customize_Media_Control( $wp_customize, $key, $control ) );
				continue;
			}

			if ( 'link' === $field['type'] ) {
				$control['type']        = 'text';
				$control['input_attrs'] = array( 'placeholder' => 'https://…  /page/  #section' );
			} else {
				$control['type'] = $field['type'];
			}

			$wp_customize->add_control( $key, $control );
		}
	}
}
add_action( 'customize_register', 'tebasuci_customize_register' );
