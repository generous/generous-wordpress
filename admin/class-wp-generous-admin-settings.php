<?php

/**
 * The settings functionality of the plugin.
 *
 * Maintains general callbacks for the admin settings.
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/admin
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Admin_Settings {

	/**
	 * The option group for the settings.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      string    $option_group    The name of the option group.
	 */
	public $option_group = 'generous_settings';
	
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
	 * Output the html for the settings page.
	 *
	 * @since    0.1.0
	 */
	public function output_page() {

		$page = array(
			'option_group' => $this->option_group
		);

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-admin-display.php';

	}

	/**
	 * Output the input for username.
	 *
	 * @since    0.1.0
	 */
	public function output_input_username()
	{

		$options = get_option($this->option_group);

		echo "<input name=\"{$this->option_group}[username]\" size=\"40\" type=\"text\" value=\"{$options['username']}\" />";

	}

	/**
	 * Output the input for permalink.
	 *
	 * @since    0.1.0
	 */
	public function output_input_permalink()
	{

		$options = get_option($this->option_group);

		echo "<input name=\"{$this->option_group}[permalink]\" size=\"40\" type=\"text\" value=\"{$options['permalink']}\" />";

	}

	/**
	 * Sanitize and validate fields.
	 *
	 * @since    0.1.0
	 */
	public function sanitize( $input ) {

		$results = array();

		if( isset( $input['username'] ) ) {

			$results['username'] = $input['username'];

		}

		if( isset( $input['permalink'] ) ) {

			$results['permalink'] = $input['permalink'];

			flush_rewrite_rules();

		}

		return $results;

	}
}
