<?php

/**
 * Define the internationalization functionality
 *
 *
 * @link       https://wtsn.eu
 * @since      1.0.0
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 */

/**
 * Define the internationalization functionality.
 *
 *
 * @since      1.0.0
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 * @author     Tomas Antal <tomas.antal@wtsn.eu>
 */
class Wtsn_Light_Maintenance_Mode_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'wtsn-light-maintenance-mode',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
