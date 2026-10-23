<?php
/**
 * Spokora Free row on Plugins → Installed Plugins.
 *
 * @package Spokora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Display name and description on Plugins → Installed Plugins.
 *
 * @param array<string, array<string, mixed>> $plugins Plugin list.
 * @return array<string, array<string, mixed>>
 */
function spokora_free_plugins_screen_all_plugins( $plugins ) {
	if ( ! is_array( $plugins ) ) {
		return $plugins;
	}
	$file = function_exists( 'spokora_free_plugin_basename' ) ? spokora_free_plugin_basename() : 'spokora-free/spokora-free.php';
	if ( ! isset( $plugins[ $file ] ) || ! is_array( $plugins[ $file ] ) ) {
		return $plugins;
	}
	$plugins[ $file ]['Name']        = __( 'Spokora Free', 'spokora-free' );
	$plugins[ $file ]['Title']       = $plugins[ $file ]['Name'];
	$plugins[ $file ]['Description'] = __( 'Free SEO, schema, sitemap, and redirects for WordPress websites. No account, no license key. Built by That One Firm.', 'spokora-free' );
	$plugins[ $file ]['slug']        = 'spokora-free';
	return $plugins;
}
add_filter( 'all_plugins', 'spokora_free_plugins_screen_all_plugins' );

/**
 * @param array<int, string> $links       Existing meta links.
 * @param string             $plugin_file Plugin basename.
 * @param array              $plugin_data Plugin data.
 * @param string             $status      Status.
 * @return array<int, string>
 */
function spokora_free_plugins_screen_row_meta( $links, $plugin_file, $plugin_data, $status ) {
	unset( $plugin_data, $status );
	$file = function_exists( 'spokora_free_plugin_basename' ) ? spokora_free_plugin_basename() : 'spokora-free/spokora-free.php';
	if ( $file !== $plugin_file ) {
		return $links;
	}
	$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=' . spokora_dashboard_page_slug() ) ) . '">' . esc_html__( 'Home', 'spokora-free' ) . '</a>';
	$wporg   = function_exists( 'spokora_wporg_support_url' ) ? spokora_wporg_support_url() : 'https://wordpress.org/support/plugin/spokora-free/';
	$links[] = '<a href="' . esc_url( $wporg ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support', 'spokora-free' ) . '</a>';
	return $links;
}
add_filter( 'plugin_row_meta', 'spokora_free_plugins_screen_row_meta', 10, 4 );
