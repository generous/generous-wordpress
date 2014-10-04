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
	 * The permalink endpoint specified within the plugin options.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string                               $permalink         The root endpoint of the permalink structure.
	 */
	private $permalink;

	/**
	 * Whether or not permalinks are active.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      bool                                 $permalinks        Whether or not permalinks are active.
	 */
	private $permalinks;

	/**
	 * Converts filters to specified data.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Public_Output_Filters    $filters           Maintains methods to convert filters to data.
	 */
	private $filters;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string                               $options           The settings of the plugin.
	 */
	public function __construct( $options ) {

		$this->permalink = $options['permalink'];
		$this->permalinks = ( get_option( 'permalink_structure' ) != '' ) ? true : false;
		$this->filters = new WP_Generous_Public_Output_Filters();

	}

	/**
	 * Outputs sliders from a category.
	 *
	 * @since    0.1.0
	 * @var      array    $data       Slider data from the specified category.
	 * @return   string               The gathered html to output.
	 */
	public function category_sliders( $data ) {

		$html = "";

		foreach( $data as $slider ) {
			
			$link = new WP_Generous_Public_Output_Link( $this->permalinks );
			$link->permalink = $this->permalink;
			$link->query_var = 'generous_slider';
			$link->query_val = $slider['slug'];

			add_filter( 'the_permalink', array( $link, 'custom_the_permalink' ) );
			
			ob_start();

			include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-public-category-slider.php';

			$html .= $this->filters->slider( $slider, ob_get_clean() );

		}

		return $html;

	}

}
