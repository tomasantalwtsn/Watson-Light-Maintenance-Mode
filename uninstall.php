<?php

/**
 * Fired when the plugin is uninstalled.
 *
 *
 * @link       https://wtsn.eu
 * @since      0.1.2
 *
 * @package    Wtsn_Light_Maintenance_Mode
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

function wtsn_mntnnc_uninstall() {
	
	delete_option( 'wtsn_mntnnc_basic_options' );
	delete_option( 'wtsn_mntnnc_advanced_options' );
	
}
wtsn_mntnnc_uninstall();