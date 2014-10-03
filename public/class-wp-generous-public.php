<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks.
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Public {

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
	 * The shortcodes are responsible for maintaining callbacks for the shortcodes.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      WP_Generous_Public_Shortcodes    $shortcodes    Maintains callbacks for the shortcodes.
	 */
	public $shortcodes;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $name, $version ) {

		$this->name = $name;
		$this->version = $version;

		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for the public.
	 *
	 * Include the following files that make up the admin:
	 *
	 * - WP_Generous_Public_Settings. Handles callbacks for the shortcodes.
	 *
	 * Create an instance of shortcodes which will be used for callbacks.
	 * Register the short codes.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-shortcodes.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-output.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-output-filters.php';

		$this->shortcodes = new WP_Generous_Public_Shortcodes();
		$this->add_shortcodes();

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->name, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/css/generous-wp.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->name, plugin_dir_url( dirname( __FILE__ ) ) . 'assets/js/generous-wp.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the shortcodes for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	private function add_shortcodes() {

		add_shortcode( 'generous', array( $this->shortcodes, 'load' ) ) ;

	}

}
