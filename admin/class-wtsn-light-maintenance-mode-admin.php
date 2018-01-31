<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wtsn.eu
 * @since      1.0.0
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/admin
 * @author     Tomas Antal <tomas.antal@wtsn.eu>
 */
class Wtsn_Light_Maintenance_Mode_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}



	/**
	 * Register the switch to the Admin bar
	 *
	 * @since    1.0.0
	 */
	public function add_switch_to_admin_bar() {
	
		global $wp_admin_bar;
		$wtsn_mntnnc_show_in_adminbar_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_show_in_adminbar', 'wtsn_mntnnc_advanced_options');

		if ( ! is_admin()
			||! is_object( $wp_admin_bar ) 
			|| ! function_exists( 'is_admin_bar_showing' ) 
			|| ! is_admin_bar_showing() 
			|| $wtsn_mntnnc_show_in_adminbar_opt === 'no') {
			return;
		}

		$wtsn_mntnnc_settings = get_site_url() . '/wp-admin/options-general.php?page=wtsn_mntnnc#wtsn_mntnnc_basic_options'; 
		$wtsn_mntnnc_activate_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_activate', 'wtsn_mntnnc_basic_options');
		$wtsn_mntnnc_is_active = ($wtsn_mntnnc_activate_opt === 'yes') ? 'ON' : 'OFF';
		$wtsn_mntnnc_action = ($wtsn_mntnnc_is_active === 'ON') ? 'off' : 'on';



		$args = array(
			'id'    => 'wtsn-support',
			'title' => '<span class="ab-icon dashicons dashicons-admin-tools"></span>' . __('Maintenance: ' . $wtsn_mntnnc_is_active),
			'href'  => '' );
		$wp_admin_bar->add_node( $args );

		$args = array(
			'parent' => 'wtsn-support',
			'id'    => 'wtsn-pro-support',
			'title' => __('Turn ' . $wtsn_mntnnc_action ),
			'href'  => $wtsn_mntnnc_settings );
		$wp_admin_bar->add_node( $args );

	}


}
