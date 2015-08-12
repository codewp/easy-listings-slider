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

				$slider       = new ELS_Slider( absint( $attributes['id'] ) );
				$jssor_slider = ELS_IOC::make( 'slider_factory' )->get_jssor_slider( $slider );

				ob_start();
				// Displaying slider.
				$jssor_slider->display();
				return ob_get_clean();

			}
		}
	}

}
