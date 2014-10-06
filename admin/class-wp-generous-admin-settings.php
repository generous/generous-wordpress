<?php

/**
 * The settings functionality of the plugin.
 *
 * Maintains general callbacks for the admin settings.
 *
 * @since      0.1.0
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
	 * @var      string                $option_group  The name of the option group.
	 */
	public $option_group = 'generous_settings';
	
	/**
	 * The ID of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string                $name          The ID of this plugin.
	 */
	private $name;

	/**
	 * The version of this plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string                $version       The current version of this plugin.
	 */
	private $version;

	/**
	 * Requests data from the Generous API.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Api       $api           Maintains all Generous API requests.
	 */
	private $api;

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

	}

	/**
	 * Output the html for the settings page.
	 *
	 * @since    0.1.0
	 */
	public function output_page() {

		$page = array(
			'option_group' => $this->option_group,
			'options' => get_option($this->option_group)
		);

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-admin-display.php';

		// Hacky workaround to make sure rewrite rules are refreshed.
		if ( isset( $_GET['settings-updated'] ) && $_GET['settings-updated'] ) {
			flush_rewrite_rules();
		}

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

		if ( isset( $input['username'] ) ) {

			if ( $input['username'] !== '' ) {
				$data = $this->api->get_account( $input['username'] );

				if ( false !== data ) {

					$results['username'] = $input['username'];

					if ( isset( $data['name'] ) ) {
						$results['title'] = $data['name'];
					} else if ( isset( $data['title'] ) ) {
						$results['title'] = $data['title'];
					}

				}
			} else {
				$results['username'] = '';
				$results['title'] = '';
			}

		}

		if ( isset( $input['permalink'] ) ) {
			$results['permalink'] = $input['permalink'];
		}

		return $results;

	}
}
