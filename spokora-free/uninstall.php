<?php
/**
 * Uninstall Spokora Free.
 *
 * Does not delete spokora_options or post SEO meta. Those keys are shared with
 * Spokora Pro; wiping them would punish someone who is switching plugins.
 *
 * @package Spokora
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

delete_option( 'spokora_free_plugin_version_stored' );
delete_option( 'spokora_onboarding_pending' );
delete_transient( 'spokora_activation_redirect' );
delete_transient( 'spokora_upgrade_wizard_redirect' );
