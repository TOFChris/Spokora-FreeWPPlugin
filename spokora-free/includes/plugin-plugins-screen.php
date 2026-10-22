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
	$plugins[ $file ]['Name']        = __( 'Spokora Free', 'spokora' );
	$plugins[ $file ]['Title']       = $plugins[ $file ]['Name'];
	$plugins[ $file ]['Description'] = __( 'Free SEO, schema, sitemap, and redirects for WordPress websites. No account. Updates from spokora.com without registering the site. Built by That One Firm.', 'spokora' );
	$plugins[ $file ]['slug']        = 'spokora-free';
	return $plugins;
}
add_filter( 'all_plugins', 'spokora_free_plugins_screen_all_plugins' );

/**
 * @param string $plugin_file Plugin basename.
 */
function spokora_free_plugins_screen_enqueue( $plugin_file ) {
	$file = function_exists( 'spokora_free_plugin_basename' ) ? spokora_free_plugin_basename() : 'spokora-free/spokora-free.php';
	if ( $file !== $plugin_file ) {
		return;
	}
	wp_register_style( 'spokora-free-plugins-screen', false, array(), SPOKORA_VERSION );
	wp_enqueue_style( 'spokora-free-plugins-screen' );
	$css = '
		.spokora-plugins-panel { margin: 0; padding: 12px 16px 14px; background: linear-gradient(180deg, #fffbea 0%, #fff8d6 100%); border: 1px solid #e6c200; border-left: 4px solid #dba617; }
		.spokora-plugins-panel p { margin: 0 0 8px; max-width: 52rem; line-height: 1.5; }
		.spokora-plugins-panel p:last-child { margin-bottom: 0; }
		.spokora-plugins-panel__status { font-weight: 600; }
		.spokora-plugins-panel__status.is-ok { color: #1e4620; }
		.spokora-plugins-panel__status.is-warn { color: #996800; }
		.spokora-plugins-panel__version { margin-top: 4px; color: #50575e; }
		.spokora-plugins-panel__thanks { font-style: italic; color: #50575e; }
		.spokora-plugins-panel__tabs { display: flex; flex-wrap: wrap; gap: 8px; margin: 4px 0 10px; }
		.spokora-plugins-panel__tab { display: inline-block; padding: 6px 12px; border-radius: 6px; border: 1px solid #c3c4c7; background: #fff; color: #1d2327; text-decoration: none; font-size: 13px; font-weight: 500; }
		.spokora-plugins-panel__tab:hover, .spokora-plugins-panel__tab:focus { border-color: #2271b1; color: #135e96; }
		.spokora-plugins-panel__actions { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 10px; }
		.spokora-plugins-panel__actions .button { margin: 0; }
	';
	wp_add_inline_style( 'spokora-free-plugins-screen', $css );
}

/**
 * Extra panel under the Spokora Free plugin row.
 *
 * @param string $plugin_file Plugin basename.
 * @param array  $plugin_data Plugin header data.
 */
function spokora_free_render_plugins_screen_panel( $plugin_file, $plugin_data ) {
	unset( $plugin_data );
	$file = function_exists( 'spokora_free_plugin_basename' ) ? spokora_free_plugin_basename() : 'spokora-free/spokora-free.php';
	if ( $file !== $plugin_file || ( ! current_user_can( 'manage_options' ) && ! current_user_can( 'update_plugins' ) ) ) {
		return;
	}

	global $wp_list_table;
	$colspan = 4;
	if ( is_object( $wp_list_table ) && method_exists( $wp_list_table, 'get_column_count' ) ) {
		$colspan = (int) $wp_list_table->get_column_count();
	}
	if ( $colspan < 3 ) {
		$colspan = 4;
	}

	$host       = wp_parse_url( home_url(), PHP_URL_HOST );
	$dash       = admin_url( 'admin.php?page=' . spokora_dashboard_page_slug() );
	$setup      = admin_url( 'admin.php?page=spokora-setup&step=1' );
	$help       = admin_url( 'admin.php?page=spokora-help' );
	$forum      = function_exists( 'spokora_forum_url' ) ? spokora_forum_url() : 'https://forum.spokora.com/';
	$updates    = function_exists( 'spokora_updates_page_url' ) ? spokora_updates_page_url() : 'https://spokora.com/updates/';
	$signup     = function_exists( 'spokora_updates_signup_url' ) ? spokora_updates_signup_url() : 'https://spokora.com/updates/#signup';
	$pending    = function_exists( 'spokora_free_plugin_pending_update' ) ? spokora_free_plugin_pending_update() : null;
	$can_update = current_user_can( 'update_plugins' );
	$installed  = function_exists( 'spokora_free_plugin_installed_version' ) ? spokora_free_plugin_installed_version() : (string) SPOKORA_VERSION;
	$details    = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=spokora-free&TB_iframe=true&width=600&height=550' );

	echo '<tr class="active spokora-plugin-row-panel"><td colspan="' . esc_attr( (string) $colspan ) . '" class="colspanchange">';
	echo '<div class="spokora-plugins-panel">';
	if ( $pending ) {
		echo '<p class="spokora-plugins-panel__status is-warn">' . esc_html(
			sprintf(
				/* translators: %s: new version */
				__( 'Spokora Free %s is available — no registration required.', 'spokora' ),
				$pending['version']
			)
		) . '</p>';
		echo '<p>' . esc_html__( 'You never registered this site, and you do not need a key. Use Update now on this row, or Check for updates if the notice looks stuck. WordPress installs the zip from spokora.com.', 'spokora' ) . '</p>';
	} else {
		echo '<p class="spokora-plugins-panel__status is-ok">' . esc_html(
			sprintf(
				/* translators: %s: site hostname */
				__( 'No license — updates still come from spokora.com (%s).', 'spokora' ),
				$host ? $host : home_url()
			)
		) . '</p>';
		echo '<p>' . esc_html__( 'You do not register this site with us. Check for updates talks to spokora.com anyway. When a newer Free zip ships, WordPress can install it from this screen. After we list on WordPress.org, automatic updates work like any other .org plugin.', 'spokora' ) . '</p>';
		echo '<p class="spokora-plugins-panel__version">' . esc_html(
			sprintf(
				/* translators: %s: installed version */
				__( 'Installed version %s — you are current with spokora.com.', 'spokora' ),
				$installed
			)
		) . '</p>';
	}

	echo '<p class="spokora-plugins-panel__thanks">' . esc_html__( '— Chris, That One Firm', 'spokora' ) . '</p>';

	echo '<nav class="spokora-plugins-panel__tabs" aria-label="' . esc_attr__( 'Stay in touch', 'spokora' ) . '">';
	echo '<a class="spokora-plugins-panel__tab thickbox open-plugin-details-modal" href="' . esc_url( $details ) . '">' . esc_html__( 'View details', 'spokora' ) . '</a>';
	echo '<a class="spokora-plugins-panel__tab" href="' . esc_url( $forum ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support', 'spokora' ) . '</a>';
	echo '<a class="spokora-plugins-panel__tab" href="' . esc_url( $updates ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Updates', 'spokora' ) . '</a>';
	echo '<a class="spokora-plugins-panel__tab" href="' . esc_url( $signup ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Sign up for updates', 'spokora' ) . '</a>';
	echo '</nav>';

	echo '<div class="spokora-plugins-panel__actions">';
	echo '<a class="button button-primary" href="' . esc_url( $dash ) . '">' . esc_html__( 'Open Home', 'spokora' ) . '</a>';
	echo '<a class="button" href="' . esc_url( $setup ) . '">' . esc_html__( 'Quick setup', 'spokora' ) . '</a>';
	if ( $can_update && function_exists( 'spokora_free_plugin_check_updates_url' ) ) {
		echo '<a class="button" href="' . esc_url( spokora_free_plugin_check_updates_url() ) . '">' . esc_html__( 'Check for updates', 'spokora' ) . '</a>';
	}
	echo '<a class="button" href="' . esc_url( $help ) . '">' . esc_html__( 'Help & modules', 'spokora' ) . '</a>';
	echo '</div>';
	echo '</div></td></tr>';
}

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
	$details = self_admin_url( 'plugin-install.php?tab=plugin-information&plugin=spokora-free&TB_iframe=true&width=600&height=550' );
	$links[] = '<a href="' . esc_url( $details ) . '" class="thickbox open-plugin-details-modal">' . esc_html__( 'View details', 'spokora' ) . '</a>';
	$links[] = '<a href="' . esc_url( admin_url( 'admin.php?page=' . spokora_dashboard_page_slug() ) ) . '">' . esc_html__( 'Home', 'spokora' ) . '</a>';
	if ( current_user_can( 'update_plugins' ) && function_exists( 'spokora_free_plugin_check_updates_url' ) ) {
		$links[] = '<a href="' . esc_url( spokora_free_plugin_check_updates_url() ) . '">' . esc_html__( 'Check for updates', 'spokora' ) . '</a>';
	}
	$forum   = function_exists( 'spokora_forum_url' ) ? spokora_forum_url() : 'https://forum.spokora.com/';
	$updates = function_exists( 'spokora_updates_page_url' ) ? spokora_updates_page_url() : 'https://spokora.com/updates/';
	$links[] = '<a href="' . esc_url( $forum ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support', 'spokora' ) . '</a>';
	$links[] = '<a href="' . esc_url( $updates ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Updates', 'spokora' ) . '</a>';
	return $links;
}
add_filter( 'plugin_row_meta', 'spokora_free_plugins_screen_row_meta', 10, 4 );

/**
 * Bind after_plugin_row to the installed basename.
 */
function spokora_free_plugins_screen_bind_row() {
	$file = function_exists( 'spokora_free_plugin_basename' ) ? spokora_free_plugin_basename() : 'spokora-free/spokora-free.php';
	add_action( 'after_plugin_row_' . $file, 'spokora_free_plugins_screen_enqueue', 5, 1 );
	add_action( 'after_plugin_row_' . $file, 'spokora_free_render_plugins_screen_panel', 10, 2 );
	add_action( 'load-plugins.php', 'add_thickbox' );
}
add_action( 'plugins_loaded', 'spokora_free_plugins_screen_bind_row' );
