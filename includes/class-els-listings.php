<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * APIs that are common between listings.
 *
 * @link
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Listings {

	/**
	 * Getting listing gallery.
	 *
	 * @since 1.0.0
	 * @param  int $listing_id
	 * @return array Array of listing images ids.
	 */
	public function get_gallery( $listing_id ) {
		if ( metadata_exists( 'post', $listing_id, 'els_listing_gallery' ) ) {
			$listing_gallery = get_post_meta( $listing_id, 'els_listing_gallery', true );
			if ( strlen( $listing_gallery ) ) {
				return array_filter( explode( ',', $listing_gallery ) );
			}
		}
		return array();
	}

}
