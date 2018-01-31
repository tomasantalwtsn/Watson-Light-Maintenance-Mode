<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://wtsn.eu
 * @since      0.1.2
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/public
 * @author     Tomas Antal <tomas.antal@wtsn.eu>
 */
class Wtsn_Light_Maintenance_Mode_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.2
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.2
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.2
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Adding the settings page to the admin area
	 *
	 * @since    0.1.2
	 */
	public function add_maintenance_page() {
		// Checking for the capabilities and if this is the public facing page
		if ( is_admin() || current_user_can('manage_options') ){
			return;
		}

		// Checking if the maintenance mode is turned on
		$wtsn_mntnnc_activate_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_activate', 'wtsn_mntnnc_basic_options');
		if ($wtsn_mntnnc_activate_opt !== "yes") {
			return;	
		}

		$blog_title = get_bloginfo();
		// Getting the option values
		$wtsn_mntnnc_title_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_title', 'wtsn_mntnnc_basic_options', __('Maintenance', 'wtsn-light-maintenance-mode') );
		$wtsn_mntnnc_text_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_text', 'wtsn_mntnnc_basic_options');
		$wtsn_mntnnc_title_color_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_title_color', 'wtsn_mntnnc_advanced_options');
		$wtsn_mntnnc_text_color_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_text_color', 'wtsn_mntnnc_advanced_options');
		$wtsn_mntnnc_image_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_image', 'wtsn_mntnnc_advanced_options');
		$wtsn_mntnnc_response_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_response', 'wtsn_mntnnc_advanced_options');

		$wtsn_mntnnc_image_output = $wtsn_mntnnc_image_opt ? "<center><img src='$wtsn_mntnnc_image_opt' alt='" . __('Maintenance mode', 'wtsn-light-maintenance-mode') . "' width='700'></center>" : '';

		//Creating the view and stopping the execution
		wp_die(
			"<h1 style='color:$wtsn_mntnnc_title_color_opt;'>$wtsn_mntnnc_title_opt</h1> <br>
			$wtsn_mntnnc_image_output
			<p style='color:$wtsn_mntnnc_text_color_opt;'>$wtsn_mntnnc_text_opt</p>",
			$blog_title . " - " . __('Maintenance', 'wtsn-light-maintenance-mode'),
			array('response' => $wtsn_mntnnc_response_opt)
		);

	}

}
