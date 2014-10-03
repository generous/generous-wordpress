<?php

/**
 * Maintains requests to the Generous API.
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
	 * @var      WP_Generous_Api     $instance    The instance of this class.
	 */
	public static $instance;

	/**
	 * Obtain the original instance that was created.
	 *
	 * @since     0.1.0
	 * @return    WP_Generous_Api    The instance of this class.
	 */
	public static function obtain()
	{

		if ( !self::$instance ) { 
			self::$instance = new WP_Generous_Api; 
		}
	
		return self::$instance; 

	}

	/**
	 * Get the category data.
	 *
	 * @since     0.1.0
	 * @var       string    $id      Specified category id.
	 * @return    array              The category data.
	 */
	public function get_category( $id ) {

		$options = get_option('generous_settings');

		$data = Generous::customRequest( 'GET', "accounts/{$options['username']}/store/categories/{$id}" );

		return $data;

	}
	
}
