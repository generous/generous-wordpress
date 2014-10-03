<?php

/**
 * The core WP Generous class.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/includes
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous {

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version = '0.1.0';

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string    $WP_Generous    The string used to uniquely identify this plugin.
	 */
	protected $WP_Generous = 'generous';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      WP_Generous_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      WP_Generous_Api    $api    Maintains all Generous API requests.
	 */
	protected $api;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - WP_Generous_Loader. Orchestrates the hooks of the plugin.
	 * - WP_Generous_i18n. Defines internationalization functionality.
	 * - WP_Generous_Api. Sets endpoints for Generous API requests.
	 * - WP_Generous_Admin. Defines all hooks for the dashboard.
	 * - WP_Generous_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 * Create an instance of the api which will be used for API requests.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-generous-loader.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-generous-api.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-generous-i18n.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-wp-generous-admin.php';
		require_once plugin_dir_path( __FILE__ ) . 'public/class-wp-generous-public.php';

		$this->loader = new WP_Generous_Loader();
		$this->api = WP_Generous_Api::obtain();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the WP_Generous_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new WP_Generous_i18n();
		$plugin_i18n->set_domain( $this->get_Generous() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new WP_Generous_Admin( $this->get_Generous(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_settings_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_settings_default' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new WP_Generous_Public( $this->get_Generous(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_Generous() {
		return $this->WP_Generous;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    WP_Generous_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
