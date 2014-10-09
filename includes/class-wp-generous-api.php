<?php

/**
 * Maintains requests to the Generous Api.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/includes
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Api {

	/**
	 * Singleton instance of this class.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      WP_Generous_Api     $instance           The instance of this class.
	 */
	public static $instance;

	/**
	 * Contains the general settings for the plugin specified by the user.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      array               $plugin_options     The settings of the plugin.
	 */
	private $plugin_options;

	/**
	 * Obtain the original instance that was created.
	 *
	 * @since     0.1.0
	 * @return    WP_Generous_Api                        The instance of this class.
	 */
	public static function obtain( $plugin_options = false )
	{

		if ( ! self::$instance ) { 

			self::$instance = new WP_Generous_Api( $plugin_options );

			if ( false !== $plugin_options ) {
				self::$instance->plugin_options = $plugin_options; 
			}

		}
	
		return self::$instance; 

	}

	/**
	 * Handles the Api request and returns the response.
	 *
	 * @since     0.1.0
	 * @access   private
	 * @return    array|false             The Api response.
	 */
	private function request( $method, $endpoint ) {

		$data = Generous::customRequest( $method, $endpoint );

		if ( $data && !isset($data['error'] ) ) {
			return $data;
		} else {
			return false;
		}

	}

	/**
	 * Get the account name for the specified account.
	 *
	 * @since     0.1.0
	 * @return    array|false             Account data.
	 */
	public function get_account( $id = false ) {

		if ( false === $id ) {
			$id = $this->plugin_options['username'];
		}

		return $this->request( 'GET', "accounts/{$id}" );

	}

	/**
	 * Get the list of categories for the specified account.
	 *
	 * @since     0.1.0
	 * @return    array|false             Categories data.
	 */
	public function get_categories() {
		return $this->request( 'GET', "accounts/{$this->plugin_options['username']}/store/categories" );
	}

	/**
	 * Get the category data for the specified id.
	 *
	 * @since     0.1.0
	 * @var       string         $id      Category id.
	 * @return    array|false             Category data.
	 */
	public function get_category( $id ) {
		return $this->request( 'GET', "accounts/{$this->plugin_options['username']}/store/categories/{$id}" );
	}

	/**
	 * Get the slider data for the specified id.
	 *
	 * @since     0.1.0
	 * @var       string         $id      Slider id.
	 * @return    array                   Category data.
	 */
	public function get_slider( $id ) {
		return $this->request( 'GET', "accounts/{$this->plugin_options['username']}/store/slider/{$id}" );
	}

	/**
	 * Get the (uknown) data for the specified (slug) id.
	 *
	 * @since     0.1.0
	 * @var       string         $id      Slug (category or slider).
	 * @return    array                   Unknown data.
	 */
	public function get_unknown( $id ) {
		return $this->request( 'GET', "accounts/{$this->plugin_options['username']}/store/verify/{$id}" );
	}

}
