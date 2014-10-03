<?php

/**
 * The public shortcodes functionality.
 *
 * Defines and sorts shortcodes.
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Public_Shortcodes {

	/**
	 * Requests data from the Generous API.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Api    $api    Maintains requests to the Generous API.
	 */
	private $api;

	/**
	 * Prepares and outputs data to html.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Public_Output    $output     Maintains methods to convert data to html templates.
	 */
	private $output;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->api = WP_Generous_Api::obtain();
		$this->output = new WP_Generous_Public_Output();

	}

	/**
	 * Load the specified shortcode attributes.
	 *
	 * @since    0.1.0
	 * @var      array    $attr       Specified shortcode attributes.
	 * @return   string               The rendered html to output.
	 */
	public function load( $atts ) {

		if( isset( $atts['category'] ) ) {
			return $this->category( $atts['category'] );
		}

	}

	/**
	 * Output category shortcode.
	 *
	 * @since    0.1.0
	 * @var      string    $id       Specified category id.
	 * @return   string              The rendered html to output.
	 */
	private function category( $id ) {

		$data = $this->api->get_category( $id );

		return $this->output->category_sliders($data['sliders']);		

	}

}