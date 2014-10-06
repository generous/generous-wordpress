<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and hooks.
 *
 * @since      0.1.0
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
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Loader               $loader        Maintains and registers all hooks for the plugin.
	 */
	private $loader;

	/**
	 * The shortcodes are responsible for maintaining callbacks for the shortcodes.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Public_Shortcodes    $shortcodes    Maintains callbacks for the shortcodes.
	 */
	private $shortcodes;

	/**
	 * Retrieves data, generally from the Api.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Public_Data          $data          Saves and retrieves data.
	 */
	private $data;

	/**
	 * Requests data from the Generous API.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Api                  $api           Maintains all Generous API requests.
	 */
	private $api;

	/**
	 * Initialize the class, set its properties, and load depenencies.
	 *
	 * @since    0.1.0
	 * @var      string    $name       The name of the plugin.
	 * @var      string    $version    The version of this plugin.
	 * @var      array     $options    The settings of the plugin.
	 */
	public function __construct( $name, $version, $options, $loader, $api ) {

		$this->name = $name;
		$this->version = $version;
		$this->options = $options;
		$this->loader = $loader;
		$this->api = $api;

		$this->load_dependencies();

	}

	/**
	 * Load the required dependencies for the public.
	 *
	 * Include the following files that make up the admin:
	 *
	 * - WP_Generous_Public_Shortcodes
	 * - WP_Generous_Public_Post
	 * - WP_Generous_Public_Posts
	 * - WP_Generous_Public_Output
	 * - WP_Generous_Public_Filters
	 * - WP_Generous_Public_Data
	 * - Public functions
	 *
	 * Create an instance of shortcodes which will be used for callbacks.
	 * Create an instance of data which will be used to retrieve saved Api data.
	 *
	 * Set options of posts.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-shortcodes.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-post.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-posts.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-output.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-filters.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous-public-data.php';
		require_once plugin_dir_path( __FILE__ ) . 'wp-generous-public-functions.php';

		$this->shortcodes = new WP_Generous_Public_Shortcodes( $this->options, $this->api );
		$this->data = new WP_Generous_Public_Data();

		$posts = WP_Generous_Public_Posts::obtain();
		$posts->set_options( $this->options );
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

		add_permastruct( 'generous_page', "/{$this->options['permalink']}/%generous_page%" );
		add_permastruct( 'generous_category', "/{$this->options['permalink']}/%generous_category%" );
		add_permastruct( 'generous_slider', "/{$this->options['permalink']}/%generous_slider%" );

	}

	/**
	 * Register the rewrite endpoints for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function add_rewrite_endpoints() {
		add_rewrite_endpoint( $this->options['permalink'], EP_PERMALINKS, EP_PAGES );
	}

	/**
	 * Register the custom templates for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $template   The original template.
	 * @return   string                The replaced, updated, or original template.
	 */
	public function add_custom_templates( $template ) {

		if ( ( $id = get_query_var( 'generous_page' ) ) || ( $id = get_query_var( 'generous_category' ) ) ) {

			// If id exists, change template, otherwise allow 404.
			if( false !== $this->data->get( $id ) ) {

				add_filter( 'the_content', array( $this, 'custom_the_content' ) );
				$template = locate_template( 'page.php' );

			}

			return $template;

		} else if ( $this->is_default() ) {

			$template = locate_template( 'page.php' );

			return $template;

		} else {

			return $template;

		}
		
	}

	/**
	 * Register the custom title for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $title      The original title.
	 * @return   string                The replaced, updated, or original title.
	 */
	public function custom_the_title( $title ) {   
		return isset( $this->options['title'] ) ? $this->options['title'] : 'Store';
	}

	/**
	 * Register the custom content for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $content    The original content.
	 * @return   string                The replaced, updated, or original content.
	 */
	public function custom_the_content( $content ) {

		if ( $id = get_query_var( 'generous_page' ) ) {
			return "[generous page={$id}]";
		} else if ( $id = get_query_var( 'generous_category' ) ) {
			return "[generous category={$id}]";
		}

	}
 	
 	/**
	 * Register custom pages for the public-facing side of the site.
	 *
	 * @since    0.1.0
	 * @var      array     $posts      The original posts.
	 * @return   array                 The updated or original posts.
	 */
	public function add_custom_page( $posts ) {

		global $wp_query;

		$slug = $this->options['permalink'];
		$title = isset( $this->options['title'] ) ? $this->options['title'] : 'Store';

		// Check unknown category/slider id query
		if ( $id = get_query_var( 'generous_page' ) ) {

			$data = $this->api->get_unknown( $id );
			$this->data->add( $id, $data );

			if ( false === $this->data->get( $id ) ) {

				return $this->set_404();

			} else {

				$post = $this->set_post( $slug, $data );

				$posts = NULL;
				$posts[] = $post;

				$wp_query->is_page = true;
				$wp_query->is_singular = true;
				$wp_query->is_home = false;
				$wp_query->is_archive = false;
				$wp_query->is_category = false;

				unset($wp_query->query["error"]);
				$wp_query->query_vars["error"] = '';
				$wp_query->is_404 = false;

			}

		// Check category query
		} else if ( $id = get_query_var( 'generous_category' ) ) {

			$data = $this->api->get_category( $id );
			$this->data->add( $id, $data );

			if ( false === $this->data->get( $id ) ) {
				return $this->set_404();
			}

		// Check slider query
		} else if ( $id = get_query_var( 'generous_slider' ) ) {

			$data = $this->api->get_slider( $id );
			$this->data->add( $id, $data );

			if ( false === $this->data->get( $id ) ) {
				return $this->set_404();
			}

		// Check default page
		} else if ( $this->is_default() ){

			$post = new stdClass;
			$post->ID = -1;
			$post->post_author = 1;
			$post->post_name = $slug;
			$post->guid = get_bloginfo('wpurl' . '/' . $slug);
			$post->post_title = $title;
			$post->post_content = "[generous store]";
			$post->post_status = 'static';
			$post->comment_status = 'closed';
			$post->ping_status = 'closed';
			$post->comment_count = 0;
			$post->post_date = current_time('mysql');
			$post->post_date_gmt = current_time('mysql',1);

			$posts = NULL;
			$posts[] = $post;

			$wp_query->is_page = true;
			$wp_query->is_singular = true;
			$wp_query->is_home = false;
			$wp_query->is_archive = false;
			$wp_query->is_category = false;

			unset($wp_query->query["error"]);
			$wp_query->query_vars["error"]="";
			$wp_query->is_404 = false;

		} else {

			// Everything else - do not modify

		}

		return $posts;  

	}

	/**
	 * Force Wordpress to use a 404 page.
	 *
	 * @since    0.1.0
	 * @var      array     $message    The message to output, if allowed.
	 * @return   array                 Empty posts.
	 */
	public function set_404( $message = 'Page not found' ) {

		global $wp_query;

		$wp_query->set_404();
		$wp_query->query_vars['error'] = $message;
		$wp_query->is_404 = true;

		return array();

	}

	/**
	 * Creates a temporary post-like object.
	 *
	 * @since    0.1.0
	 * @var      string    $root_slug  The root of the plugins permalink.
	 * @var      array     $data       The data to pull info from.
	 * @return   object                The pretend post object.
	 */
	public function set_post( $root_slug, $data ) {

		$post = new stdClass;

		if( isset( $data ) ) {

			if( isset( $data['title'] ) ) {
				$post_title = $data['title'];
			} else if ( isset( $data['slider'] ) ) {
				$post_title = $data['slider']['title'];
			}

			if( isset( $data['slug'] ) ) {
				$post_slug = $data['slug'];
			} else if ( isset( $data['slider'] ) ) {
				$post_slug = $data['slider']['slug'];
			}

			$post = new stdClass;
			$post->ID = -1;
			$post->post_author = 1;
			$post->post_name = $root_slug . '/' .  $post_slug;
			$post->guid = get_bloginfo( 'url' ) . '/' . $root_slug . '/' . $post_slug . '/';
			$post->post_title = $post_title;
			$post->post_status = 'static';
			$post->comment_status = 'closed';
			$post->ping_status = 'closed';
			$post->comment_count = 0;
			$post->post_date = current_time('mysql');
			$post->post_date_gmt = current_time('mysql',1);

		}

		return $post;

	}

	/**
	 * Checks if the current page is the default store page.
	 *
	 * @since    0.1.0
	 * @return   bool                  True if yes, false if no.
	 */
	public function is_default() {

		global $wp;

		$slug = $this->options['permalink'];

		$is_request_slug = strtolower( $wp->request ) == $slug;
		$is_query_slug = ( $wp->query_vars['page_id'] == $slug || $wp->query_vars['p'] == $slug );

		$has_no_posts = count( $posts == 0 );
		$is_slug = ( $is_request_slug || $is_query_slug );

		return ( $has_no_posts && $is_slug ) ? true : false;

	}

}
