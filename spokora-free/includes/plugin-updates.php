<?php
/**
 * Keyless updates from spokora.com (no site registration).
 *
 * @package Spokora
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return string
 */
function spokora_free_plugin_basename() {
	return plugin_basename( SPOKORA_PLUGIN_FILE );
}

/**
 * @return string
 */
function spokora_free_plugin_installed_version() {
	static $version = null;
	if ( ! empty( $GLOBALS['spokora_free_plugin_installed_version_bust'] ) ) {
		$version = null;
		unset( $GLOBALS['spokora_free_plugin_installed_version_bust'] );
	}
	if ( null !== $version ) {
		return $version;
	}
	if ( ! function_exists( 'get_plugin_data' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}
	$file = defined( 'SPOKORA_PLUGIN_FILE' ) ? SPOKORA_PLUGIN_FILE : WP_PLUGIN_DIR . '/spokora-free/spokora-free.php';
	if ( ! is_readable( $file ) ) {
		$version = defined( 'SPOKORA_VERSION' ) ? trim( (string) SPOKORA_VERSION ) : '0.0.0';
		return $version;
	}
	$data    = get_plugin_data( $file, false, false );
	$version = ! empty( $data['Version'] ) ? trim( (string) $data['Version'] ) : ( defined( 'SPOKORA_VERSION' ) ? trim( (string) SPOKORA_VERSION ) : '0.0.0' );
	return $version;
}

/**
 * Clear update caches after a successful upgrade.
 */
function spokora_free_plugin_reset_update_state() {
	delete_transient( 'spokora_free_update_remote' );
	delete_site_transient( 'update_plugins' );
	$GLOBALS['spokora_free_plugin_installed_version_bust'] = true;
	if ( function_exists( 'wp_clean_plugins_cache' ) ) {
		wp_clean_plugins_cache( true );
	}
}

/**
 * @param WP_Upgrader $upgrader Upgrader instance.
 * @param array       $options  Upgrade context.
 */
function spokora_free_plugin_after_upgrade( $upgrader, $options ) {
	unset( $upgrader );
	if ( empty( $options['action'] ) || 'update' !== $options['action'] || empty( $options['type'] ) || 'plugin' !== $options['type'] ) {
		return;
	}
	$plugins = array();
	if ( ! empty( $options['plugins'] ) && is_array( $options['plugins'] ) ) {
		$plugins = $options['plugins'];
	}
	if ( ! empty( $options['plugin'] ) && is_string( $options['plugin'] ) ) {
		$plugins[] = $options['plugin'];
	}
	if ( ! in_array( spokora_free_plugin_basename(), $plugins, true ) ) {
		return;
	}
	spokora_free_plugin_reset_update_state();
}
add_action( 'upgrader_process_complete', 'spokora_free_plugin_after_upgrade', 10, 2 );

/**
 * @return array<string, mixed>
 */
function spokora_free_plugin_update_remote( $force_refresh = false ) {
	$cached = $force_refresh ? false : get_transient( 'spokora_free_update_remote' );
	if ( is_array( $cached ) ) {
		$checked = isset( $cached['checked_at'] ) ? (int) $cached['checked_at'] : 0;
		if ( ! $force_refresh && $checked > 0 && ( time() - $checked ) < HOUR_IN_SECONDS ) {
			return $cached;
		}
	}
	$info_url = apply_filters( 'spokora_free_plugin_info_url', 'https://spokora.com/wp-json/spokora/v1/free-plugin-info' );
	$info_url = add_query_arg( 't', (string) time() . '-' . wp_rand( 1000, 999999 ), $info_url );
	$response = wp_remote_get(
		$info_url,
		array(
			'timeout' => 15,
			'headers' => array(
				'Accept'     => 'application/json',
				'User-Agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . home_url( '/' ),
			),
		)
	);
	if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
		$miss = array(
			'ok'         => false,
			'checked_at' => time(),
		);
		set_transient( 'spokora_free_update_remote', $miss, 15 * MINUTE_IN_SECONDS );
		return $miss;
	}
	$data = json_decode( (string) wp_remote_retrieve_body( $response ), true );
	if ( ! is_array( $data ) || empty( $data['version'] ) ) {
		$miss = array(
			'ok'         => false,
			'checked_at' => time(),
		);
		set_transient( 'spokora_free_update_remote', $miss, 15 * MINUTE_IN_SECONDS );
		return $miss;
	}
	$data['version']    = trim( (string) $data['version'] );
	$data['ok']         = true;
	$data['checked_at'] = time();
	set_transient( 'spokora_free_update_remote', $data, 12 * HOUR_IN_SECONDS );
	return $data;
}

/**
 * @param array{version: string, package: string, tested?: string, requires?: string, requires_php?: string} $offer Remote offer.
 * @return object
 */
function spokora_free_plugin_update_response_object( array $offer ) {
	$plugin_file = spokora_free_plugin_basename();
	$package     = isset( $offer['package'] ) ? (string) $offer['package'] : '';
	return (object) array(
		'id'           => 'spokora.com/spokora-free',
		'slug'         => 'spokora-free',
		'plugin'       => $plugin_file,
		'new_version'  => (string) $offer['version'],
		'url'          => 'https://spokora.com/',
		'package'      => $package,
		'tested'       => isset( $offer['tested'] ) ? (string) $offer['tested'] : '',
		'requires'     => isset( $offer['requires'] ) ? (string) $offer['requires'] : '6.0',
		'requires_php' => isset( $offer['requires_php'] ) ? (string) $offer['requires_php'] : '7.4',
	);
}

/**
 * @param array<string, mixed> $remote Remote payload.
 * @return array{version: string, package: string, tested?: string, requires?: string, requires_php?: string}|null
 */
function spokora_free_plugin_pending_update_from_remote( array $remote ) {
	if ( empty( $remote['ok'] ) || empty( $remote['version'] ) ) {
		return null;
	}
	if ( ! version_compare( trim( (string) $remote['version'] ), spokora_free_plugin_installed_version(), '>' ) ) {
		return null;
	}
	$package = '';
	if ( ! empty( $remote['download'] ) ) {
		$package = (string) $remote['download'];
	} elseif ( ! empty( $remote['package'] ) ) {
		$package = (string) $remote['package'];
	}
	return array(
		'version'      => trim( (string) $remote['version'] ),
		'package'      => $package,
		'tested'       => isset( $remote['tested'] ) ? (string) $remote['tested'] : '',
		'requires'     => isset( $remote['requires'] ) ? (string) $remote['requires'] : '6.0',
		'requires_php' => isset( $remote['requires_php'] ) ? (string) $remote['requires_php'] : '7.4',
	);
}

/**
 * @return bool
 */
function spokora_free_plugin_should_refresh_update_remote() {
	if ( ! is_admin() ) {
		return false;
	}
	global $pagenow;
	if ( in_array( $pagenow, array( 'plugins.php', 'update-core.php', 'index.php' ), true ) ) {
		return true;
	}
	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
	return '' !== $page && str_starts_with( $page, 'spokora' );
}

/**
 * @return array{version: string, package: string, tested?: string, requires?: string, requires_php?: string}|null
 */
function spokora_free_plugin_pending_update( $force_refresh = false ) {
	static $pending  = null;
	static $resolved = false;
	if ( $force_refresh ) {
		$pending  = null;
		$resolved = false;
	}
	if ( $resolved ) {
		return $pending;
	}
	$resolved = true;
	$remote   = spokora_free_plugin_update_remote( spokora_free_plugin_should_refresh_update_remote() );
	$pending  = spokora_free_plugin_pending_update_from_remote( is_array( $remote ) ? $remote : array() );
	return $pending;
}

/**
 * @param mixed                $update      Existing update.
 * @param array<string, mixed> $plugin_data Plugin header.
 * @param string               $plugin_file Plugin basename.
 * @param array<int, string>   $locales     Locales.
 * @return mixed
 */
function spokora_free_inject_plugin_update( $update, $plugin_data, $plugin_file, $locales ) {
	unset( $plugin_data, $locales );
	if ( spokora_free_plugin_basename() !== $plugin_file ) {
		return $update;
	}
	$remote = spokora_free_plugin_update_remote( true );
	$offer  = spokora_free_plugin_pending_update_from_remote( is_array( $remote ) ? $remote : array() );
	if ( ! $offer ) {
		return $update;
	}
	$obj = spokora_free_plugin_update_response_object( $offer );
	return array(
		'slug'         => $obj->slug,
		'plugin'       => $obj->plugin,
		'new_version'  => $obj->new_version,
		'url'          => $obj->url,
		'package'      => $obj->package,
		'tested'       => $obj->tested,
		'requires'     => $obj->requires,
		'requires_php' => $obj->requires_php,
	);
}
add_filter( 'update_plugins_spokora.com', 'spokora_free_inject_plugin_update', 10, 4 );

/**
 * @param mixed $transient update_plugins transient value.
 * @return mixed
 */
function spokora_free_pre_set_update_plugins_transient( $transient ) {
	if ( ! is_object( $transient ) ) {
		$transient = new stdClass();
	}
	if ( empty( $transient->checked ) || ! is_array( $transient->checked ) ) {
		$transient->checked = array();
	}
	$plugin_file = spokora_free_plugin_basename();
	$transient->checked[ $plugin_file ] = spokora_free_plugin_installed_version();
	if ( ! isset( $transient->no_update ) || ! is_array( $transient->no_update ) ) {
		$transient->no_update = array();
	}
	$remote = spokora_free_plugin_update_remote( spokora_free_plugin_should_refresh_update_remote() );
	$offer  = spokora_free_plugin_pending_update_from_remote( is_array( $remote ) ? $remote : array() );
	if ( ! $offer ) {
		if ( isset( $transient->response[ $plugin_file ] ) ) {
			unset( $transient->response[ $plugin_file ] );
		}
		return $transient;
	}
	if ( ! isset( $transient->response ) || ! is_array( $transient->response ) ) {
		$transient->response = array();
	}
	unset( $transient->no_update[ $plugin_file ] );
	$transient->response[ $plugin_file ] = spokora_free_plugin_update_response_object( $offer );
	return $transient;
}
add_filter( 'pre_set_site_transient_update_plugins', 'spokora_free_pre_set_update_plugins_transient', 20 );

/**
 * @param mixed $transient update_plugins transient.
 * @return mixed
 */
function spokora_free_filter_site_transient_update_plugins( $transient ) {
	if ( ! is_admin() ) {
		return $transient;
	}
	$plugin_file = spokora_free_plugin_basename();
	$offer       = spokora_free_plugin_pending_update();
	if ( ! $offer ) {
		if ( is_object( $transient ) && isset( $transient->response[ $plugin_file ] ) ) {
			unset( $transient->response[ $plugin_file ] );
		}
		return $transient;
	}
	if ( ! is_object( $transient ) ) {
		$transient = new stdClass();
	}
	if ( empty( $transient->checked ) || ! is_array( $transient->checked ) ) {
		$transient->checked = array();
	}
	$transient->checked[ $plugin_file ] = spokora_free_plugin_installed_version();
	if ( ! isset( $transient->response ) || ! is_array( $transient->response ) ) {
		$transient->response = array();
	}
	if ( ! isset( $transient->no_update ) || ! is_array( $transient->no_update ) ) {
		$transient->no_update = array();
	}
	unset( $transient->no_update[ $plugin_file ] );
	$transient->response[ $plugin_file ] = spokora_free_plugin_update_response_object( $offer );
	return $transient;
}
add_filter( 'site_transient_update_plugins', 'spokora_free_filter_site_transient_update_plugins', 20 );

/**
 * @param mixed  $result Existing result.
 * @param string $action Requested action.
 * @param object $args   Request args.
 * @return mixed
 */
function spokora_free_plugin_details( $result, $action, $args ) {
	if ( 'plugin_information' !== $action || ! is_object( $args ) || empty( $args->slug ) || 'spokora-free' !== $args->slug ) {
		return $result;
	}
	$remote    = spokora_free_plugin_update_remote( true );
	$installed = spokora_free_plugin_installed_version();
	$latest    = ( is_array( $remote ) && ! empty( $remote['ok'] ) && ! empty( $remote['version'] ) )
		? trim( (string) $remote['version'] )
		: $installed;
	$changelog = '';
	if ( is_array( $remote ) && ! empty( $remote['changelog'] ) ) {
		$changelog = (string) $remote['changelog'];
	}
	if ( '' === $changelog ) {
		$changelog = '<p>' . esc_html( $latest ) . '</p>';
	}
	$check_link = current_user_can( 'update_plugins' )
		? '<p><a href="' . esc_url( spokora_free_plugin_check_updates_url() ) . '">' . esc_html__( 'Check for updates', 'spokora' ) . '</a></p>'
		: '';
	$description  = '<p>' . esc_html__( 'Free SEO, schema, sitemap, and redirects for WordPress websites. No account. Updates from spokora.com without registering the site.', 'spokora' ) . '</p>';
	$description .= '<p><strong>' . esc_html__( 'This site', 'spokora' ) . ':</strong> ' . esc_html( sprintf( __( 'installed %1$s · latest on spokora.com %2$s', 'spokora' ), $installed, $latest ) ) . '</p>';
	$description .= $check_link;
	$description .= '<p><a href="https://spokora.com/updates/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Release notes on spokora.com', 'spokora' ) . '</a></p>';
	$description .= '<p><a href="' . esc_url( admin_url( 'admin.php?page=' . spokora_dashboard_page_slug() ) ) . '">' . esc_html__( 'Open Spokora Home', 'spokora' ) . '</a></p>';
	$support      = '<p><a href="https://forum.spokora.com/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Spokora support forum', 'spokora' ) . '</a></p>';
	$support     .= '<p><a href="https://spokora.com/updates/#signup" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Sign up for update emails', 'spokora' ) . '</a></p>';
	$package      = '';
	if ( is_array( $remote ) && ! empty( $remote['download'] ) ) {
		$package = (string) $remote['download'];
	}
	return (object) array(
		'name'          => 'Spokora Free',
		'slug'          => 'spokora-free',
		'version'       => $latest,
		'author'        => '<a href="https://thatonefirm.com">That One Firm</a>',
		'homepage'      => 'https://spokora.com/',
		'requires'      => is_array( $remote ) && ! empty( $remote['requires'] ) ? (string) $remote['requires'] : '6.0',
		'requires_php'  => is_array( $remote ) && ! empty( $remote['requires_php'] ) ? (string) $remote['requires_php'] : '7.4',
		'tested'        => is_array( $remote ) && ! empty( $remote['tested'] ) ? (string) $remote['tested'] : '',
		'download_link' => $package,
		'sections'      => array(
			'description' => $description,
			'changelog'   => $changelog,
			'support'     => $support,
		),
	);
}
add_filter( 'plugins_api', 'spokora_free_plugin_details', 20, 3 );

/**
 * @param string $message     Default update message HTML.
 * @param array  $plugin_data Plugin header.
 * @return string
 */
function spokora_free_plugin_in_update_message( $message, $plugin_data ) {
	unset( $plugin_data );
	$links = array();
	if ( current_user_can( 'update_plugins' ) ) {
		$links[] = '<a href="' . esc_url( spokora_free_plugin_check_updates_url() ) . '">' . esc_html__( 'Check for updates', 'spokora' ) . '</a>';
	}
	$links[] = '<a href="https://forum.spokora.com/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Support', 'spokora' ) . '</a>';
	$links[] = '<a href="https://spokora.com/updates/" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Updates', 'spokora' ) . '</a>';
	return $message . ' ' . implode( ' | ', $links );
}

/**
 * @return string
 */
function spokora_free_plugin_check_updates_url() {
	return wp_nonce_url(
		admin_url( 'plugins.php?spokora_free_check_updates=1' ),
		'spokora_free_check_updates'
	);
}

/**
 * @return string Status slug.
 */
function spokora_free_plugin_run_check_for_updates() {
	spokora_free_plugin_reset_update_state();
	$remote = spokora_free_plugin_update_remote( true );
	if ( empty( $remote['ok'] ) || empty( $remote['version'] ) ) {
		return 'failed';
	}
	if ( function_exists( 'wp_update_plugins' ) ) {
		wp_update_plugins();
	}
	spokora_free_plugin_pending_update( true );
	$offer = spokora_free_plugin_pending_update_from_remote( $remote );
	if ( ! $offer ) {
		return 'current';
	}
	if ( '' === $offer['package'] ) {
		return 'available_no_package';
	}
	return 'available';
}

/**
 * Handle Check for updates from Plugins.
 */
function spokora_free_plugin_handle_check_for_updates() {
	if ( ! isset( $_GET['spokora_free_check_updates'] ) ) {
		return;
	}
	if ( ! current_user_can( 'update_plugins' ) ) {
		wp_die( esc_html__( 'You do not have permission to update plugins.', 'spokora' ) );
	}
	check_admin_referer( 'spokora_free_check_updates' );
	$status   = spokora_free_plugin_run_check_for_updates();
	$redirect = wp_get_referer();
	if ( ! is_string( $redirect ) || '' === $redirect ) {
		$redirect = admin_url( 'plugins.php' );
	}
	$redirect = remove_query_arg( array( 'spokora_free_check_updates', '_wpnonce', 'spokora_free_updates_checked' ), $redirect );
	wp_safe_redirect( add_query_arg( 'spokora_free_updates_checked', $status, $redirect ) );
	exit;
}
add_action( 'load-plugins.php', 'spokora_free_plugin_handle_check_for_updates', 5 );
add_action( 'load-update-core.php', 'spokora_free_plugin_handle_check_for_updates', 5 );

/**
 * Feedback after Check for updates.
 */
function spokora_free_plugin_check_for_updates_notice() {
	global $pagenow;
	if ( ! in_array( $pagenow, array( 'plugins.php', 'update-core.php' ), true ) || ! current_user_can( 'update_plugins' ) ) {
		return;
	}
	if ( ! isset( $_GET['spokora_free_updates_checked'] ) ) {
		return;
	}
	$status  = sanitize_key( wp_unslash( $_GET['spokora_free_updates_checked'] ) );
	$remote  = get_transient( 'spokora_free_update_remote' );
	$latest  = is_array( $remote ) && ! empty( $remote['version'] ) ? (string) $remote['version'] : '';
	$updates = get_site_transient( 'update_plugins' );
	$has_row = is_object( $updates ) && isset( $updates->response[ spokora_free_plugin_basename() ] );

	switch ( $status ) {
		case 'available':
			if ( $has_row ) {
				$message = $latest
					? sprintf(
						/* translators: 1: new version */
						__( 'Spokora Free %1$s is available. Use Update now on this screen — no license key.', 'spokora' ),
						$latest
					)
					: __( 'A Spokora Free update is available. Use Update now on this screen — no license key.', 'spokora' );
			} else {
				$message = __( 'A Spokora Free update is available from spokora.com. Refresh this page once, or download the zip from spokora.com.', 'spokora' );
			}
			echo '<div class="notice notice-warning is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
			break;
		case 'available_no_package':
			echo '<div class="notice notice-warning is-dismissible"><p>' . esc_html__( 'A newer Spokora Free is on spokora.com. Download the zip from the homepage — WordPress did not get a package URL.', 'spokora' ) . '</p></div>';
			break;
		case 'current':
			$message = $latest
				? sprintf(
					/* translators: 1: installed version, 2: latest from spokora.com */
					__( 'Spokora Free is up to date (installed %1$s, latest %2$s). No registration required.', 'spokora' ),
					spokora_free_plugin_installed_version(),
					$latest
				)
				: sprintf(
					/* translators: %s: installed version */
					__( 'Spokora Free is up to date (version %s).', 'spokora' ),
					spokora_free_plugin_installed_version()
				);
			echo '<div class="notice notice-success is-dismissible"><p>' . esc_html( $message ) . '</p></div>';
			break;
		case 'failed':
			echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__( 'Could not reach spokora.com for version info. Try again in a few minutes.', 'spokora' ) . '</p></div>';
			break;
	}
}
add_action( 'admin_notices', 'spokora_free_plugin_check_for_updates_notice', 5 );

/**
 * Admin notice when a newer Free zip is waiting.
 */
function spokora_free_plugin_update_admin_notice() {
	if ( ! current_user_can( 'update_plugins' ) ) {
		return;
	}
	global $pagenow;
	if ( in_array( $pagenow, array( 'plugins.php', 'update-core.php' ), true ) ) {
		return;
	}
	$pending = spokora_free_plugin_pending_update();
	if ( ! $pending ) {
		return;
	}
	$plugins_url = admin_url( 'plugins.php' );
	$message     = sprintf(
		/* translators: 1: new version, 2: plugins link */
		__( 'Spokora Free %1$s is available (no registration). Update from %2$s.', 'spokora' ),
		$pending['version'],
		'<a href="' . esc_url( $plugins_url ) . '">' . esc_html__( 'Plugins', 'spokora' ) . '</a>'
	);
	echo '<div class="notice notice-warning"><p>' . wp_kses_post( $message ) . '</p></div>';
}
add_action( 'admin_notices', 'spokora_free_plugin_update_admin_notice' );

/**
 * Bind row hooks once the basename is known.
 */
function spokora_free_plugin_bind_row_hooks() {
	$file = spokora_free_plugin_basename();
	add_filter( 'in_plugin_update_message-' . $file, 'spokora_free_plugin_in_update_message', 10, 2 );
}
add_action( 'plugins_loaded', 'spokora_free_plugin_bind_row_hooks' );
