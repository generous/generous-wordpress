<?php

/**
 * Maintains methods to convert filters to data.
 *
 * @since      0.1.0
 *
 * @package    WP_Generous
 * @subpackage WP_Generous/public
 * @author     Matthew Govaere <matthew@genero.us>
 */
class WP_Generous_Public_Filters {

	/**
	 * Used for formatting prices.
	 *
	 * @since    0.1.0
	 * @access   private
	 *
	 * @var      WP_Generous_Formatter    $formatter         Maintains methods for formatting.
	 */
	private $formatter;

	/**
	 * Properly converts currencies for displaying.
	 *
	 * @since    0.1.0
	 * @access   private
	 *
	 * @var      WP_Generous_Currency     $currency          Maintains methods for currency.
	 */
	private $currency;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {
		$this->formatter = WP_Generous_Formatter::obtain();
		$this->currency = WP_Generous_Currency::obtain();
	}

	/**
	 * Converts slider filters to slider data.
	 *
	 * @since    0.1.0
	 *
	 * @param    array    $data         Data to replace the filter with.
	 * @param    array    $content      Content to search within.
	 *
	 * @return   string                 New content with replaced filters.
	 */
	public function slider( $data, $content ) {

		$filters = array();

		if ( isset( $data['title'] ) ) {
			$filters['title'] = $data['title'];
		}

		if ( isset( $data['cover_photo'], $data['default_photo']['small'] ) ) {
			$filters['cover_photo'] = $data['default_photo']['small'];
		}

		if ( isset( $data['suggested_price'] ) ) {
			$filters['suggested_price'] = $this->formatter->price( $data['suggested_price'], $data['currency'], false );
			$filters['suggested_price_whole'] = $this->formatter->price_whole( $data['suggested_price'], $data['currency'], false );
		}
		
		if ( isset( $data['currency'] ) ) {
			$filters['currency_symbol'] = $this->currency->symbol( $data['currency'] );
		}

		if ( isset( $data['items'] ) ) {
			$filters['item_total'] = count( $data['items'] );
		}

		if ( isset( $data['short_url'] ) ) {
			$filters['button_slider_overlay'] = $data['short_url'];
		}

		if ( isset( $data['items'] ) ) {

			$filters['item_total'] = count( $data['items'] );

			if( $filters['item_total'] === 1 ) {
				$filters['item_total_label'] = _x( 'Item', '1 Item' );
			} else {
				$filters['item_total_label'] = _x( 'Items', '2 Items' );
			}

		}

		foreach ( $filters as $filter => $replacement ) {
			$content = $this->convert( $filter, $replacement, $content );
		}

		return $content;

	}

	/**
	 * Converts category filters to category data.
	 *
	 * @since    0.1.0
	 *
	 * @param    array    $data         Data to replace the filter with.
	 * @param    array    $content      Content to search within.
	 *
	 * @return   string                 New content with replaced filters.
	 */
	public function category( $data, $content ) {

		$filters = array();

		if ( isset( $data['title'] ) ) {
			$filters['title'] = $data['title'];
		}

		foreach ( $filters as $filter => $replacement ) {
			$content = $this->convert( $filter, $replacement, $content );
		}

		return $content;

	}

	/**
	 * Replaces the specified filter with the proper data.
	 *
	 * @since    0.1.0
	 *
	 * @param    array    $filter       Filtert to search for.
	 * @param    array    $data         Data to replace the filter with.
	 * @param    array    $content      Content to search within.
	 *
	 * @return   string                 New content with replace filters.
	 */
	private function convert( $filter, $data, $content ) {
		return str_replace( '[' . $filter.  ']', $data, $content );
	}

}
