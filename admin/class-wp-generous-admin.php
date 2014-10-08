<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for styles/js and the menu.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/admin
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $name    The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Requests data from the Generous API.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Api               $api         Maintains all Generous API requests.
	 */
	private $api;

	/**
	 * The settings are responsible for maintaining callbacks for the admin settings.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Admin_Settings    $settings    Maintains callbacks for the admin settings.
	 */
	private $settings;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version, $api ) {

		$this->name = $name;
		$this->version = $version;
		$this->api = $api;

		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for the admin.
	 *
	 * Include the following files that make up the admin:
	 *
	 * - WP_Generous_Admin_Settings. Handles callbacks for the settings page.
	 *
	 * Create an instance of settings which will be used for callbacks.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-admin-settings.php';

		$this->settings = new WP_Generous_Admin_Settings( $this->name, $this->version, $this->api );

	}

	/**
	 * Register the stylesheets for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->name, plugin_dir_url( __FILE__ ) . 'css/generous-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->name, plugin_dir_url( __FILE__ ) . 'js/generous-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the settings menu for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function add_settings_menu() {

		add_options_page(
			'Generous', 
			'Generous', 
			'manage_options', 
			$this->name, 
			array( $this->settings, 'output_page' )
		);

	}

	/**
	 * Register the default options settings for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function register_settings_default() {

		register_setting(
			$this->settings->option_group,
			$this->settings->option_group,
			array( $this->settings, 'sanitize' )
		);

		add_settings_section(
			'section_default',
			'Default Settings',
			'',
			$this->settings->option_group
		);

		add_settings_field(
			'username',
			'Username',
			array( $this->settings, 'output_input_username' ),
			$this->settings->option_group,
			'section_default'
		);

		add_settings_field(
			'permalink',
			'Permalink',
			array( $this->settings, 'output_input_permalink' ),
			$this->settings->option_group,
			'section_default'
		);

	}

}