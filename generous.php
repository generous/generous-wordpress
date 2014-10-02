<?php
/**
 * Plugin Name:       Generous
 * Plugin URI:        https://genero.us
 * Description:       Integrate Generous sliders within your website. Official Generous plugin.
 * Version:           0.1.0
 * Author:            Generous
 * Author URI:        https://genero.us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       generous
 * Domain Path:       /languages
 *
 * @since             0.1.0
 *
 * @package           Generous
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load initial dependencies
require_once plugin_dir_path( __FILE__ ) . 'includes/class-generous-activator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-generous-deactivator.php';

register_activation_hook( __FILE__, array( 'Generous_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'Generous_Deactivator', 'deactivate' ) );

/**
 * The core Generous class.
 *
 * @since      0.1.0
 *
 * @package    Generous
 * @subpackage Generous/includes
 * @author     Matthew Govaere <matthew@genero.us>
 */
class Generous {

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
	 * @var      string    $Generous    The string used to uniquely identify this plugin.
	 */
	protected $Generous = 'generous';

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      Generous_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

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
	 * - Generous_Loader. Orchestrates the hooks of the plugin.
	 * - Generous_i18n. Defines internationalization functionality.
	 * - Generous_Admin. Defines all hooks for the dashboard.
	 * - Generous_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'includes/class-generous-loader.php';
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-generous-i18n.php';
		require_once plugin_dir_path( __FILE__ ) . 'admin/class-generous-admin.php';
		require_once plugin_dir_path( __FILE__ ) . 'public/class-generous-public.php';

		$this->loader = new Generous_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Generous_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Generous_i18n();
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

		$plugin_admin = new Generous_Admin( $this->get_Generous(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'custom_menu' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Generous_Public( $this->get_Generous(), $this->get_version() );

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
		return $this->Generous;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    Generous_Loader    Orchestrates the hooks of the plugin.
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

/**
 * Begins execution of the plugin.
 *
 * @since    0.1.0
 */
function init_Generous() {
	$plugin = new Generous();
	$plugin->run();
}

init_Generous();