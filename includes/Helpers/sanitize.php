<?php

/**
 * Sanitize checkbox options
 *
 * @since 0.5
 */
function kirki_sanitize_checkbox( $value ) {
	return ( 'on' != $value ) ? false : $value;
}

/**
 * Sanitize number options
 *
 * @since 0.5
 */
function kirki_sanitize_number( $value ) {
	return ( is_int( $value ) || is_float( $value ) ) ? $value : intval( $value );
}

/**
 * Sanitize a value from a list of allowed values.
 *
 * @since 0.5
 *
 * @param  mixed    $input      The value to sanitize.
 * @param  mixed    $setting    The setting for which the sanitizing is occurring.
 */
function kirki_sanitize_choice( $input, $setting ) {

	global $wp_customize;
	$config = Kirki::config()->get_all();

	if ( '' != $config['option_name'] ) {
		return sanitize_key( $input );
	}

	$field = $wp_customize->get_control( $setting->id );

	return ( array_key_exists( $input, $field->choices ) ) ? $input : $setting->default;

}

/**
 * Sanitize background repeat values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_repeat( $value ) {
	$i18n = Kirki::i18n();
	$valid = array(
		'no-repeat' => $i18n['no-repeat'],
		'repeat'    => $i18n['repeat-all'],
		'repeat-x'  => $i18n['repeat-x'],
		'repeat-y'  => $i18n['repeat-y'],
		'inherit'   => $i18n['inherit'],
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background size values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_size( $value ) {
	$i18n = Kirki::i18n();
	$valid = array(
		'inherit' => $i18n['inherit'],
		'cover'   => $i18n['cover'],
		'contain' => $i18n['contain'],
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background attachment values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_attach( $value ) {
	$i18n = Kirki::i18n();
	$valid = array(
		'inherit' => $i18n['inherit'],
		'fixed'   => $i18n['fixed'],
		'scroll'  => $i18n['scroll'],
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'inherit';

}

/**
 * Sanitize background position values
 *
 * @since 0.5
 */
function kirki_sanitize_bg_position( $value ) {
	$i18n = Kirki::i18n();
	$valid = array(
		'left-top'      => $i18n['left-top'],
		'left-center'   => $i18n['left-center'],
		'left-bottom'   => $i18n['left-bottom'],
		'right-top'     => $i18n['right-top'],
		'right-center'  => $i18n['right-center'],
		'right-bottom'  => $i18n['right-bottom'],
		'center-top'    => $i18n['center-top'],
		'center-center' => $i18n['center-center'],
		'center-bottom' => $i18n['center-bottom'],
	);

	return ( array_key_exists( $value, $valid ) ) ? $value : 'center-center';

}

/**
 * Sanitize sortable controls
 *
 * @since 0.8.3
 */

function kirki_sanitize_sortable( $value ) {
	if ( is_serialized( $value ) ) {
		return $value;
	} else {
		return serialize( $value );
	}
}

/**
 * Sanitize RGBA colors
 *
 * @since 0.8.5
 */
function kirki_sanitize_rgba( $value ) {

	// If empty or an array return transparent
	if ( empty( $value ) || is_array( $value ) ) {
		return 'rgba(0,0,0,0)';
	}

	// If string does not start with 'rgba', then treat as hex
	// sanitize the hex color and finally convert hex to rgba
	if ( false === strpos( $value, 'rgba' ) ) {
		return Kirki_Color::get_rgba( Kirki_Color::sanitize_hex( $value ) );
	}

	// By now we know the string is formatted as an rgba color so we need to further sanitize it.
	$value = str_replace( array( 'rgba', '(', ')' ), '', $value );
	$colors = explode( ',', $value );

	$red     = ( isset( $colors[0] ) ) ? intval( $colors[0] ) : '0';
	$green   = ( isset( $colors[1] ) ) ? intval( $colors[1] ) : '0';
	$blue    = ( isset( $colors[2] ) ) ? intval( $colors[2] ) : '0';
	$opacity = ( isset( $colors[3] ) ) ? intval( $colors[3] ) : '0';

	return 'rgba(' . $red . ',' . $green . ',' . $blue . ',' . $opacity . ')';

}

/**
 * DOES NOT SANITIZE ANYTHING.
 *
 * @since 0.5
 */
function kirki_sanitize_unfiltered( $value ) {
	return $value;
}
