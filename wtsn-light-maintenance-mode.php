<?php

/**
 *
 * @link              https://wtsn.eu
 * @since             1.0.0
 * @package           Wtsn_Light_Maintenance_Mode
 *
 * @wordpress-plugin
 * Plugin Name:       Watson Lightweight Maintenance Mode
 * Plugin URI:        https://wtsn.eu
 * Description:       Simple and lightweight maintenance mode for your WordPress site.
 * Version:           0.4.2
 * Author:            Tomas Antal
 * Author URI:        https://wtsn.eu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wtsn-light-maintenance-mode
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'PLUGIN_NAME_VERSION', '0.4.2' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wtsn-light-maintenance-mode-activator.php
 */
function activate_wtsn_light_maintenance_mode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wtsn-light-maintenance-mode-activator.php';
	Wtsn_Light_Maintenance_Mode_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wtsn-light-maintenance-mode-deactivator.php
 */
function deactivate_wtsn_light_maintenance_mode() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wtsn-light-maintenance-mode-deactivator.php';
	Wtsn_Light_Maintenance_Mode_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wtsn_light_maintenance_mode' );
register_deactivation_hook( __FILE__, 'deactivate_wtsn_light_maintenance_mode' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wtsn-light-maintenance-mode.php';

/**
 * Handles the Settings API 
 */
require plugin_dir_path( __FILE__ ) . 'includes/class.settings-api.php';

/**
 * Hooks into the settings API handler and creates the settings page
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wtsn-settings-api.php';

/**
 * Begins execution of the plugin.
 *
 * @since    0.1.2
 */
function run_wtsn_light_maintenance_mode() {

	$plugin = new Wtsn_Light_Maintenance_Mode();
	$plugin->run();
	new WTSN_Settings_API();

}
run_wtsn_light_maintenance_mode();


