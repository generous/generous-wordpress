<?php

/**
 * Maintains methods to convert data to public html templates.
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Public_Output {

	/**
	 * Converts filters to specified data.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Public_Output_Filters    $filters    Maintains methods to convert filters to data.
	 */
	private $filters;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->filters = new WP_Generous_Public_Output_Filters();

	}

	/**
	 * Outputs sliders from a category.
	 *
	 * @since    0.1.0
	 * @var      array    $data       Slider data from the specified category.
	 * @return   string               The loaded html to output.
	 */
	public function category_sliders( $data ) {

		$html = "";

		foreach( $data as $slider ) {

			ob_start();

			include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-public-category-slider.php';

			$html .= $this->filters->slider($slider, ob_get_clean());

		}

		return $html;

	}

}
