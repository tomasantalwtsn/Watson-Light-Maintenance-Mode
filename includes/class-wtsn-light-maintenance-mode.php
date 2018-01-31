<?php

/**
 *
 * @link       https://wtsn.eu
 * @since      0.1.2
 *
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 */

/**
 * The core plugin class.
 *
 *
 * @since      0.1.2
 * @package    Wtsn_Light_Maintenance_Mode
 * @subpackage Wtsn_Light_Maintenance_Mode/includes
 * @author     Tomas Antal <tomas.antal@wtsn.eu>
 */
class Wtsn_Light_Maintenance_Mode {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.2
	 * @access   protected
	 * @var      Wtsn_Light_Maintenance_Mode_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.2
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.2
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 *
	 * @since    0.1.2
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '0.1.2';
		}
		$this->plugin_name = 'wtsn-light-maintenance-mode';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 *
	 * - Wtsn_Light_Maintenance_Mode_Loader. Orchestrates the hooks of the plugin.
	 * - Wtsn_Light_Maintenance_Mode_i18n. Defines internationalization functionality.
	 * - Wtsn_Light_Maintenance_Mode_Admin. Defines all hooks for the admin area.
	 * - Wtsn_Light_Maintenance_Mode_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wtsn-light-maintenance-mode-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-wtsn-light-maintenance-mode-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-wtsn-light-maintenance-mode-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-wtsn-light-maintenance-mode-public.php';

		$this->loader = new Wtsn_Light_Maintenance_Mode_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wtsn_Light_Maintenance_Mode_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Wtsn_Light_Maintenance_Mode_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_before_admin_bar_render', $plugin_admin, 'add_switch_to_admin_bar', 100 );

	}


	/**
	 * Hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.2
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wtsn_Light_Maintenance_Mode_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'get_header', $plugin_public, 'add_maintenance_page');

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.2
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 *
	 * @since     0.1.2
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.2
	 * @return    Wtsn_Light_Maintenance_Mode_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.2
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get the options
	 *
	 * @since     0.1.2    
	 */
	public static function wtsn_get_option( $option, $section, $default = '' ) {

		$options = get_option( $section );
	
		if ( isset( $options[$option] ) ) {
			return $options[$option];
		}
	
		return $default;
	}

	/**
	 * Clear cache of the caching plugins
	 *
	 * @since     0.1.2

	 */
	public static function wtsn_clear_cache() {
		// WP Super Cache
		if ( function_exists( 'wp_cache_clear_cache' ) ) {
			ob_end_clean();
			wp_cache_clear_cache();
		}
		
		// W3 Total Cache
		if ( function_exists( 'w3tc_pgcache_flush' ) ) {
			ob_end_clean();
			w3tc_pgcache_flush();
		}

		// Cachify Cache
			if ( has_action('cachify_flush_cache') ) {
			do_action('cachify_flush_cache');
		}
		
	
		// WP-Rocket Cache
		if ( function_exists( 'rocket_clean_domain' ) ) {
			rocket_clean_domain();
		}
	}

}
