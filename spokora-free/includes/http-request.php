<?php
/**
 * Request helpers (Plugin Check: one place for GET / REQUEST_URI reads).
 *
 * @package Spokora
 */

if ( ! defined( 'WPINC' ) ) {
	die( 'Access denied.' );
}

/**
 * Current request path from REQUEST_URI.
 *
 * @return string
 */
function spokora_request_path() {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized below.
		return '';
	}
	$uri  = sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
	$path = wp_parse_url( $uri, PHP_URL_PATH );
	return is_string( $path ) ? $path : '';
}

/**
 * Raw REQUEST_URI after unslash + text sanitize (path + query).
 *
 * @return string
 */
function spokora_request_uri() {
	if ( ! isset( $_SERVER['REQUEST_URI'] ) ) { // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Sanitized below.
		return '';
	}
	return sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) );
}

/**
 * Admin notice / redirect query arg. Display-only; not a form submission.
 *
 * @param string $key Query key.
 * @return string|null Unslashed string, or null if missing.
 */
function spokora_query_arg( $key ) {
	$key = (string) $key;
	if ( '' === $key || ! isset( $_GET[ $key ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Read-only query string after redirect.
		return null;
	}
	$val = wp_unslash( $_GET[ $key ] ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Same as above.
	if ( is_array( $val ) ) {
		return null;
	}
	return sanitize_text_field( (string) $val );
}

/**
 * Echo JSON-LD already encoded with JSON_HEX_TAG | JSON_HEX_AMP.
 *
 * @param string $json JSON string.
 */
function spokora_echo_ld_json_script( $json ) {
	if ( ! is_string( $json ) || '' === $json ) {
		return;
	}
	echo "\n" . '<script type="application/ld+json">' . $json . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Encoded with wp_json_encode JSON_HEX_TAG|JSON_HEX_AMP.
}
