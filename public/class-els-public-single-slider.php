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
	 * Settings of the plugin.
	 *
	 * @since 1.0.0
	 * @var   ELS_Settings
	 */
	private $els_settings;

	/**
	 * Constructor of the class
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		$this->els_settings = ELS_IOC::make( 'settings' );
		if ( $this->els_settings->get_slider_in_single_page() ) {
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
			$jssor_slider                     = new ELS_Public_Jssor_Slider( array( 'image_ids' => $listing_gallery ) );
			$jssor_slider->theme              = $this->els_settings->get_single_page_slider_theme();
			$jssor_slider->width              = $this->els_settings->get_single_page_slider_width();
			$jssor_slider->height             = $this->els_settings->get_single_page_slider_height();
			$jssor_slider->fill_mode		  = $this->els_settings->get_single_page_slider_fill_mode();
			$jssor_slider->auto_play          = $this->els_settings->get_single_page_slider_autoplay();
			$jssor_slider->auto_play_interval = $this->els_settings->get_single_page_slider_autoplay_interval();
			$jssor_slider->slide_duration     = $this->els_settings->get_single_page_slider_slide_duration();
			$jssor_slider->loop               = $this->els_settings->get_single_page_slider_loop();
			$jssor_slider->drag_orientation   = $this->els_settings->get_single_page_slider_drag_orientation();

			$jssor_slider->display();
		}
	}

}
