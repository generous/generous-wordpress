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
	 * Converts slider filters to slider data.
	 *
	 * @since    0.1.0
	 * @var      array    $data         Data to replace the filter with.
	 * @var      array    $content      Content to search within.
	 * @return   string                 New content with replaced filters.
	 */
	public function slider( $data, $content ) {

		$filters = array(
			'title'             => $data['title'],
			'cover_photo'       => $data['cover_photo']['small'],
			'suggested_price'   => $data['suggested_price'],
		);

		foreach ( $filters as $filter => $replacement ) {
			$content = $this->convert( $filter, $replacement, $content );
		}

		return $content;

	}

	/**
	 * Converts category filters to category data.
	 *
	 * @since    0.1.0
	 * @var      array    $data         Data to replace the filter with.
	 * @var      array    $content      Content to search within.
	 * @return   string                 New content with replaced filters.
	 */
	public function category( $data, $content ) {

		$filters = array(
			'title' => $data['title']
		);

		foreach ( $filters as $filter => $replacement ) {
			$content = $this->convert( $filter, $replacement, $content );
		}

		return $content;

	}

	/**
	 * Replaces the specified filter with the proper data.
	 *
	 * @since    0.1.0
	 * @var      array    $filter       Filtert to search for.
	 * @var      array    $data         Data to replace the filter with.
	 * @var      array    $content      Content to search within.
	 * @return   string                 New content with replace filters.
	 */
	private function convert( $filter, $data, $content ) {
		return str_replace( '[' . $filter.  ']', $data, $content );
	}

}
