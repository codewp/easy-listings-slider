<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * APIs that are common between listings.
 *
 * @link       http://www.asanaplugins.com/
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

	/**
	 * Getting all of listings status of Easy Property Listings.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_listings_status() {
		$listings_status = apply_filters( 'epl_opts_property_status_filter', array(
			'current'	=>	__( 'Current', 'epl' ),
			'withdrawn'	=>	__( 'Withdrawn', 'epl' ),
			'offmarket'	=>	__( 'Off Market', 'epl' ),
			'sold'		=>	array(
				'label'		=>	__( 'Sold', 'epl' ),
				'exclude'	=>	array( 'rental' )
			),
			'leased'	=>	array(
				'label'		=>	__( 'Leased', 'epl' ),
				'include'	=>	array( 'rental', 'commercial', 'commercial_land', 'business' )
			)
		) );
		foreach ( $listings_status as $key => $value ) {
			if ( is_array( $value ) ) {
				$listings_status[ $key ] = $value['label'];
			}
		}
		return apply_filters( 'els_listings_status', $listings_status );
	}

}
