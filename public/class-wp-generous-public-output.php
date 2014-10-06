<?php

/**
 * Maintains methods to convert data to public html templates.
 *
 * @since      0.1.0
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
	private static $permalink;

	/**
	 * Converts filters to specified data.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      WP_Generous_Public_Output_Filters    $filters           Maintains methods to convert filters to data.
	 */
	private static $filters;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @var      string                               $options           The settings of the plugin.
	 */
	public function __construct( $options = false ) {

		if ( false !== $options ) {

			self::$permalink = $options['permalink'];
			self::$filters = new WP_Generous_Public_Filters();

		}

	}

	/**
	 * Outputs a store.
	 *
	 * @since    0.1.0
	 * @return   string                      The gathered html to output.
	 */
	public function store() {

		ob_start();

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-store.php';

		return ob_get_clean();

	}

	/**
	 * Outputs list of categories.
	 *
	 * @since    0.1.0
	 * @var      array    $data              Data from the specified slider.
	 * @return   string                      The gathered html to output.
	 */
	public function slider( $data ) {

		ob_start();

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-slider.php';

		return self::$filters->slider( $data, ob_get_clean() );

	}

	/**
	 * Outputs sliders from a category.
	 *
	 * @since    0.1.0
	 * @var      array    $data              Data from the specified category.
	 * @return   string                      The gathered html to output.
	 */
	public function sliders_list( $data ) {

		$post = WP_Generous_Public_Posts::obtain( 'sliders', $data['sliders'] );

		ob_start();

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-sliders-list.php';

		return ob_get_clean();

	}

	/**
	 * Outputs list of categories.
	 *
	 * @since    0.1.0
	 * @var      array    $data              Data from the specified slider.
	 * @return   string                      The gathered html to output.
	 */
	public function sliders_list_item( $data ) {

		ob_start();

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-sliders-list-item.php';

		return self::$filters->slider( $data, ob_get_clean() );

	}

	/**
	 * Outputs a slider.
	 *
	 * @since    0.1.0
	 * @var      array    $data              Data from the specified slider.
	 * @return   string                      The gathered html to output.
	 */
	public function categories_list( $data ) {

		$post = WP_Generous_Public_Posts::obtain( 'categories', $data );

		ob_start();

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-categories-list.php';

		return self::$filters->category( $data, ob_get_clean() );

	}

	/**
	 * Outputs a slider.
	 *
	 * @since    0.1.0
	 * @var      array    $data              Data from the specified slider.
	 * @return   string                      The gathered html to output.
	 */
	public function categories_list_item( $data ) {

		ob_start();

		include plugin_dir_path( __FILE__ ) . 'partials/wp-generous-categories-list-item.php';

		return self::$filters->category( $data, ob_get_clean() );

	}

}
