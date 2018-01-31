<?php

/**
 * Fired during plugin deactivation
 *
 * @link       https://wtsn.eu
 * @since      1.0.0
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 * @author     Tomas Antal <tomas.antal@wtsn.eu>
 */
class Wtsn_Light_Maintenance_Mode_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		Wtsn_Light_Maintenance_Mode::wtsn_clear_cache();

	}

}
