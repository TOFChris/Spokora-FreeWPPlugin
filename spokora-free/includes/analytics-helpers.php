<?php
/**
 * GA4 helpers for Cookie consent (ID or full Google tag paste).
 *
 * @package Spokora
 */

if ( ! defined( 'WPINC' ) ) {
	die();
}

if ( ! function_exists( 'spokora_sanitize_ga_measurement_id' ) ) {
	/**
	 * @param string $id Raw.
	 * @return string Valid G- ID or empty.
	 */
	function spokora_sanitize_ga_measurement_id( $id ) {
		$id = strtoupper( sanitize_text_field( (string) $id ) );
		return preg_match( '/^G-[A-Z0-9]+$/', $id ) ? $id : '';
	}
}

if ( ! function_exists( 'spokora_extract_ga_measurement_id' ) ) {
	/**
	 * Accept a Measurement ID or Google’s full gtag/gtm.js paste.
	 *
	 * @param string $raw ID or HTML/JS snippet.
	 * @return string Valid G- ID or empty.
	 */
	function spokora_extract_ga_measurement_id( $raw ) {
		$raw = is_string( $raw ) ? $raw : '';
		$trim = trim( $raw );
		if ( '' === $trim ) {
			return '';
		}
		$as_id = spokora_sanitize_ga_measurement_id( $trim );
		if ( '' !== $as_id ) {
			return $as_id;
		}
		if ( preg_match( '/\b(G-[A-Z0-9]+)\b/i', $raw, $match ) ) {
			return spokora_sanitize_ga_measurement_id( $match[1] );
		}
		return '';
	}
}

if ( ! function_exists( 'spokora_analytics_measurement_id' ) ) {
	/**
	 * Precedence: wp-config → consent settings → filter.
	 *
	 * @return string
	 */
	function spokora_analytics_measurement_id() {
		if ( defined( 'SPOKORA_GA_MEASUREMENT_ID' ) && is_string( SPOKORA_GA_MEASUREMENT_ID ) && '' !== SPOKORA_GA_MEASUREMENT_ID ) {
			return spokora_sanitize_ga_measurement_id( SPOKORA_GA_MEASUREMENT_ID );
		}
		$consent = get_option( 'spokora_consent_settings', array() );
		if ( is_array( $consent ) && ! empty( $consent['ga_id'] ) ) {
			$from_consent = spokora_sanitize_ga_measurement_id( (string) $consent['ga_id'] );
			if ( '' !== $from_consent ) {
				return $from_consent;
			}
		}
		$filtered = apply_filters( 'spokora_ga_measurement_id', '' );
		return spokora_sanitize_ga_measurement_id( (string) $filtered );
	}
}

if ( ! function_exists( 'spokora_ga_measurement_config_args' ) ) {
	/**
	 * @return array<string, mixed>
	 */
	function spokora_ga_measurement_config_args() {
		$args = array(
			'anonymize_ip' => true,
		);
		if (
			isset( $_GET['spokora_ga_debug'] )
			&& function_exists( 'current_user_can' )
			&& current_user_can( 'manage_options' )
		) {
			$args['debug_mode'] = true;
		}
		return (array) apply_filters( 'spokora_ga_measurement_config_args', $args );
	}
}

if ( ! function_exists( 'spokora_print_ga4_gtag_loader' ) ) {
	/**
	 * @param string $measurement_id GA4 ID.
	 */
	function spokora_print_ga4_gtag_loader( $measurement_id ) {
		static $loader_printed = false;
		if ( $loader_printed ) {
			return;
		}
		$measurement_id = spokora_sanitize_ga_measurement_id( $measurement_id );
		if ( '' === $measurement_id ) {
			return;
		}
		$loader_printed = true;
		printf(
			"<script async src='https://www.googletagmanager.com/gtag/js?id=%s'></script>\n",
			esc_attr( $measurement_id )
		);
	}
}

if ( ! function_exists( 'spokora_print_ga4_inline_bootstrap' ) ) {
	/**
	 * @param string $measurement_id GA4 ID.
	 * @param bool   $analytics_granted Whether analytics_storage is granted.
	 */
	function spokora_print_ga4_inline_bootstrap( $measurement_id, $analytics_granted ) {
		static $bootstrap_printed = false;
		if ( $bootstrap_printed ) {
			return;
		}
		$measurement_id = spokora_sanitize_ga_measurement_id( $measurement_id );
		if ( '' === $measurement_id ) {
			return;
		}
		$bootstrap_printed = true;
		$config = wp_json_encode( spokora_ga_measurement_config_args() );
		if ( false === $config ) {
			$config = '{"anonymize_ip":true}';
		}
		$storage = $analytics_granted ? 'granted' : 'denied';
		$wait    = $analytics_granted ? '' : ",'wait_for_update':500";
		echo "<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag('consent','default',{'analytics_storage':'" . esc_js( $storage ) . "','ad_storage':'denied','ad_user_data':'denied','ad_personalization':'denied'" . $wait . '});gtag(\'js\',new Date());gtag(\'config\',\'' . esc_js( $measurement_id ) . '\',' . $config . ');</script>' . "\n";
	}
}

if ( ! function_exists( 'spokora_print_ga4_head_after_consent' ) ) {
	/**
	 * Print GA4 gtag for returning visitors (after accept).
	 */
	function spokora_print_ga4_head_after_consent() {
		if ( is_admin() || ! function_exists( 'spokora_has_analytics_consent' ) || ! spokora_has_analytics_consent() ) {
			return;
		}
		$id = spokora_analytics_measurement_id();
		if ( '' === $id ) {
			return;
		}
		spokora_print_ga4_gtag_loader( $id );
		spokora_print_ga4_inline_bootstrap( $id, true );
	}
}

if ( ! function_exists( 'spokora_print_ga4_consent_mode_defaults' ) ) {
	/**
	 * Consent Mode + Google tag before accept (storage denied until Accept).
	 */
	function spokora_print_ga4_consent_mode_defaults() {
		if ( is_admin() ) {
			return;
		}
		$id = spokora_analytics_measurement_id();
		if ( '' === $id ) {
			return;
		}
		if ( function_exists( 'spokora_has_analytics_consent' ) && spokora_has_analytics_consent() ) {
			return;
		}
		spokora_print_ga4_gtag_loader( $id );
		spokora_print_ga4_inline_bootstrap( $id, false );
	}
}
