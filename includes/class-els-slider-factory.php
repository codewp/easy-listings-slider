<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Factory class for sliders.
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Slider_Factory {

	/**
	 * Getting an instance of Jssor_Slider by ELS_Slider instance.
	 *
	 * @since  1.0.0
	 * @param  ELS_Slider $slider
	 * @return ELS_Public_Jssor_Slider
	 */
	public function get_jssor_slider( ELS_Slider $slider ) {
		$jssor_slider                     = new ELS_Public_Jssor_Slider();
		$slides  						  = $slider->get_slides();
		$jssor_slider->image_ids          = array_filter( explode( ',', $slides ) );
		$jssor_slider->captions           = $slider->get_captions();
		$jssor_slider->captions_fonts     = $slider->get_captions_font();
		$jssor_slider->theme              = $slider->get_theme();
		$jssor_slider->id                 = $slider->get_container_id();
		$jssor_slider->width              = $slider->get_width();
		$jssor_slider->height             = $slider->get_height();
		$jssor_slider->fill_mode		  = $slider->get_fill_mode();
		$jssor_slider->auto_play          = $slider->get_auto_play();
		$jssor_slider->loop               = $slider->get_loop();
		$jssor_slider->auto_play_interval = $slider->get_auto_play_interval();
		$jssor_slider->slide_duration     = $slider->get_slide_duration();
		$jssor_slider->drag_orientation   = $slider->get_drag_orientation();

		return $jssor_slider;
	}

}
