<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Single listing page gallery slider.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/public
 * @author     Taher Atashbar<taher.atashbar@gmail.com>
 */

class ELS_Public_Single_Slider {

	/**
	 * Constructor of the class
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		global $epl_settings;
		$display_gallery = 0;
		if ( ! empty( $epl_settings ) && isset( $epl_settings['display_single_gallery'] ) ) {
			$display_gallery = $epl_settings['display_single_gallery'];
		}
		// @todo adding settings checker for enablity of single listing slider.
		if ( 1 == $display_gallery ) {
			if ( remove_action( 'epl_property_gallery', 'epl_property_gallery' ) ) {
				// Adding action for displaying gallery in slider.
				$loader->add_action( 'epl_property_gallery', $this, 'display_single_listing_slider' );
			}
		}
	}

	/**
	 * Displaying slider in single listing page.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function display_single_listing_slider() {
		$listing_gallery = ELS_IOC::make( 'listings' )->get_gallery( get_the_ID() );
		if ( count( $listing_gallery ) ) {
			$jssor_slider = new ELS_Public_Jssor_Slider( array( 'image_ids' => $listing_gallery ) );
			$jssor_slider->display();
		}
	}

}
