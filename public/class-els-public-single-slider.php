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

	private $plugin_public;

	public function __construct( ELS_Public $plugin_public ) {
		$this->plugin_public = $plugin_public;

		global $epl_settings;
		$display_gallery = 0;
		if ( ! empty( $epl_settings ) && isset( $epl_settings['display_single_gallery'] ) ) {
			$display_gallery = $epl_settings['display_single_gallery'];
		}
		// @todo adding settings checker for enablity of single listing slider.
		if ( 1 == $display_gallery ) {
			if ( remove_action( 'epl_property_gallery', 'epl_property_gallery' ) ) {
				// Adding action for displaying gallery in slider.
				$this->plugin_public->get_loader()->add_action( 'epl_property_gallery', $this, 'display_single_listing_slider' );
			}
		}
	}

	public function display_single_listing_slider() {
		$attachments = get_children( array(
			'post_parent'    => get_the_ID(),
			'post_type'      => 'attachment',
			'post_mime_type' => 'image',
		) );
		if ( count( $attachments ) ) {
			echo 'display single listing slider test';
		}
	}

}
