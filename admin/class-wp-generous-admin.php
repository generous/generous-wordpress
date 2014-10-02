<?php

/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks for styles/js and the menu.
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
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $name       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

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
	 * Register the custom menu for the dashboard.
	 *
	 * @since    0.1.0
	 */
	public function custom_menu() {

		add_menu_page( 'Generous', 'Generous', 'manage_options', 'generous', array( $this, 'output_page_settings' ) );

	}

	/**
	 * Output the html for the settings page.
	 *
	 * @since    0.1.0
	 */
	public function output_page_settings() {

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-admin-display.php';

	}

}
