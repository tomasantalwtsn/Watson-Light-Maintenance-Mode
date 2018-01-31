<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wtsn.eu
 * @since      1.0.0
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 * @author     Tomas Antal <tomas.antal@wtsn.eu>
 */
class Wtsn_Light_Maintenance_Mode_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		Wtsn_Light_Maintenance_Mode::wtsn_clear_cache();
	}

}
