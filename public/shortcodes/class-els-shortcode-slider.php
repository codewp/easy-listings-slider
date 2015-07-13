<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Slider shortcode of the plugin.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/public/shortcodes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Shortcode_Slider {

	/**
	 * Outputing content of the shortcode.
	 *
	 * @since  1.0.0
	 * @param  array $atts
	 * @param  string $content
	 * @return void
	 */
	public function output( $atts, $content = '' ) {
		$attributes = shortcode_atts( array( 'id' => false ), $atts );

		if ( absint( $attributes['id'] ) ) {
			if ( 'els_slider' === get_post_type( absint( $attributes['id'] ) ) ) {
				$slider = new ELS_Slider( absint( $attributes['id'] ) );
				$slides = $slider->get_slides();
				if ( strlen( $slides ) ) {
					$slides = array_filter( explode( ',', $slides ) );
					if ( count( $slides ) ) {
						$jssor_slider                     = new ELS_Public_Jssor_Slider();
						$jssor_slider->image_ids          = $slides;
						$jssor_slider->theme			  = $slider->get_theme();
						$jssor_slider->auto_play          = $slider->get_auto_play();
						$jssor_slider->loop               = $slider->get_loop();
						$jssor_slider->auto_play_interval = $slider->get_auto_play_interval();
						$jssor_slider->slide_duration     = $slider->get_slide_duration();
						$jssor_slider->drag_orientation   = $slider->get_drag_orientation();

						// Displaying slider.
						$jssor_slider->display();
					}
				}
			}
		}
	}

}
