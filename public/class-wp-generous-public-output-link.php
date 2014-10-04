<?php

/**
 * Maintains hooks to generate links.
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Public_Output_Link {

	/**
	 * Used to determine to output a permalink file structure or not.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string    $permalinks      Whether or not permalinks are active.
	 */
	private $permalinks;

	/**
	 * Used to define the initial path of the permalink.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      string    $permalink       The endpoint specified within the plugin options.
	 */
	public $permalink;

	/**
	 * Used to define the name of the query parameter.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      string    $query_var       The variable name of the query parameter.
	 */
	public $query_var;

	/**
	 * Used to define the value of the query parameter.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      string    $query_val       The value of the query parameter.
	 */
	public $query_val;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      string    $query_val       Whether or not permalinks are active.
	 */
	public function __construct( $permalinks ) {

		$this->permalinks = $permalinks;

	}

	/**
	 * Returns a url.
	 *
	 * @since    0.1.0
	 * @var      string    $post_link       Current link. Invalid, do not use.
	 * @var      string    $post            Current post. Invalid, do not use.
	 * @return   string                     The url to output.
	 */
	public function custom_the_permalink( $post_link, $post ) {

		if ( $this->permalinks === true ) {
			return "/{$this->permalink}/{$this->query_val}";
		} else {
			return "/?{$this->query_var}={$this->query_val}";
		}

	}

}
