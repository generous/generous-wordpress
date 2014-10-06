<?php

/**
 * Maintains methods and data for public functions.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Public_Posts {

	/**
	 * Singleton instance of this class.
	 *
	 * @since    0.1.0
	 * @access   public
	 * @var      WP_Generous_Public_Posts         $instance     The instance of this class.
	 */
	public static $instance;

	/**
	 * The data stored to loop.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string                           $data         The key-stored data to loop.
	 */
	public $data = array();

	/**
	 * The current key being looped.
	 *
	 * @since    0.1.0
	 * @access   private
	 * @var      string                           $current      Current key being looped.
	 */
	public $current;

	/**
	 * Obtain the original instance that was created.
	 *
	 * @since     0.1.0
	 * @var      string                           $type         The key to obtain. ('categories' || 'sliders')
	 * @var      array                            $data         Array of items to be looped.
	 * @return    WP_Generous_Public_Posts                      The instance of this class.
	 */
	public static function obtain( $type = NULL, $data = NULL ) {

		if ( !self::$instance ) { 
			self::$instance = new WP_Generous_Public_Posts();
		}

		if( NULL !== $type && NULL != $data ) {
			self::$instance->add( $type, $data );
		}

		return self::$instance; 

	}

	/**
	 * Adds data that needs to be looped.
	 *
	 * @since    0.1.0
	 * @var      string    $type     The key to add. ('categories' || 'sliders')
	 * @var      array     $data     Array of items to be looped.
	 */
	private function add( $type, $data ) {
		$this->data[ $type ] = new WP_Generous_Public_Post( $type, $data, $this->options['permalink'] );
	}

	/**
	 * Checks to see if there's more data to access.
	 *
	 * @since    0.1.0
	 * @var      string    $type     The key to check: 'categories' || 'sliders'
	 * @return   bool                True if yes, false if no.
	 */
	public function have( $type ) {

		if( $this->data[ $type ]->index < $this->data[ $type ]->total - 1 ) {

			$this->data[ $type ]->index++;
			$this->current = $type;

			return true;

		} else {

			$this->data[ $type ]->reset();

			return false;

		}

	}

	/**
	 * Outputs the title of the current item.
	 *
	 * @since    0.1.0
	 */
	public function get_title() {
		return $this->data[ $this->current ]->get_title();
	}

	/**
	 * Outputs the permalink of the current item.
	 *
	 * @since    0.1.0
	 */
	public function get_permalink() {
		return $this->data[ $this->current ]->get_permalink();
	}

	/**
	 * Outputs the content of the current item.
	 *
	 * @since    0.1.0
	 */
	public function get_content() {
		return $this->data[ $this->current ]->get_content();
	}

	/**
	 * Sets the plugin options.
	 *
	 * @since    0.1.0
	 */
	public function set_options( $options ) {
		$this->options = $options;
	}

}
