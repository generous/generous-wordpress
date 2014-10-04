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
	 * @var      string                           $name         The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string                           $version       The current version of this plugin.
	 */
	private $version;

	/**
	 * Contains the general settings for the plugin specified by the user.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      array                            $options       The settings of the plugin.
	 */
	private $options;

	/**
	 * The shortcodes are responsible for maintaining callbacks for the shortcodes.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      WP_Generous_Public_Shortcodes    $shortcodes    Maintains callbacks for the shortcodes.
	 */
	public $shortcodes;

	/**
	 * Initialize the class, set its properties, and load depenencies.
	 *
	 * @since    0.1.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 * @var      array     $options    The settings of the plugin.
	 */
	public function __construct( $name, $version, $options ) {

		$this->name = $name;
		$this->version = $version;
		$this->options = $options;

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
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-shortcodes.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-output.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-output-filters.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-output-link.php';

		$this->shortcodes = new WP_Generous_Public_Shortcodes( $this->options );

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
	public function add_shortcodes() {

		add_shortcode( 'generous', array( $this->shortcodes, 'load' ) ) ;

	}

	/**
	 * Register the rewrite rules for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function add_rewrite_rules() {

		add_rewrite_rule(
			'^'.$this->options['permalink'].'/([^/]*)/?',
			'index.php?generous_page=$matches[1]&generous_category=$matches[1]&generous_slider=$matches[1]',
			'top'
		);

	}

	/**
	 * Register the rewrite tags for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function add_rewrite_tags() {

		$regex_slug = '^[a-z0-9]+(?:-[a-z0-9]+)*$';

		add_rewrite_tag( '%generous_page%', $regex_slug );
		add_rewrite_tag( '%generous_category%', $regex_slug );
		add_rewrite_tag( '%generous_slider%', $regex_slug );

		add_permastruct( 'generous_page', "/{$this->options['permalink']}/%generous_page%", false );
		add_permastruct( 'generous_category', "/{$this->options['permalink']}/%generous_category%", false );
		add_permastruct( 'generous_slider', "/{$this->options['permalink']}/%generous_slider%", false );

	}

	/**
	 * Register the rewrite endpoints for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function add_rewrite_endpoints() {

		add_rewrite_endpoint( $this->options['permalink'], EP_PERMALINKS ); // Adds endpoint to permalinks

	}

	/**
	 * Register the custom templates for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $template   The original template.
	 */
	public function add_custom_templates( $template ) {

		if ( get_query_var( 'generous_page' ) ) {

			add_filter( 'the_title', array( $this, 'custom_the_title' ) );
			add_filter( 'the_content', array( $this, 'custom_the_content' ) );

			$new_template = locate_template( 'page.php' );

			return $new_template;

		}
		
		if ( get_query_var( 'generous_category' ) ) {

			add_filter( 'the_title', array( $this, 'custom_the_title' ) );
			add_filter( 'the_content', array( $this, 'custom_the_content' ) );

			$new_template = locate_template( 'page.php' );

			return $new_template;

		} else {

			return $template;

		}
		
	}

	/**
	 * Register the custom title for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $title      The original title.
	 */
	public function custom_the_title( $title ) {   
		return 'Store';
	}

	/**
	 * Register the custom content for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $content    The original content.
	 */
	public function custom_the_content( $content ) {

		if ( get_query_var( 'generous_page' ) ) {
			return '[generous category=' . get_query_var( 'generous_page' ) . ']';
		}

		if ( get_query_var( 'generous_category' ) ) {
			return '[generous category=' . get_query_var( 'generous_category' ) . ']';
		}

	}

}
