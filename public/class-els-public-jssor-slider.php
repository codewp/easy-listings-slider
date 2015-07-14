<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * PHP Class for Jssor Slider javascript plugin.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/public
 * @author     Taher Atashbar<taher.atashbar@gmail.com>
 */

class ELS_Public_Jssor_Slider extends ELS_Public_Slider_Base {

	/**
	 * Properties of the class.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $data = array(
		'image_ids'          => array(),
		'captions'			 => array(),
		'theme'              => 'thumbnail',
		'auto_play'          => true,
		'loop'               => 1, 				// Enable loop(circular) of carousel or not, 0: stop, 1: loop, 2 rewind
		'auto_play_interval' => 4000,
		'slide_duration'     => 500,
		'drag_orientation'   => 3, 				// 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1
	);

	/**
	 * version number of the slider.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private $version = '19.0';

	/**
	 * Registering slider dependencies( js and css ) files.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	protected function register_dependencies() {
		// Use minified libraries if SCRIPT_DEBUG is turned off
		$script_debug = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? true : false;

		if ( $script_debug ) {
			wp_enqueue_script( 'jssor', plugin_dir_url( __FILE__ ) . 'js/jssor/jssor.js', array( 'jquery' ), $this->version, true );
			wp_enqueue_script( 'jssor-slider', plugin_dir_url( __FILE__ ) . 'js/jssor/jssor.slider.js', array( 'jquery' ), $this->version, true );
		} else {
			wp_enqueue_script( 'jssor', plugin_dir_url( __FILE__ ) . 'js/jssor/jssor.slider.mini.js', array( 'jquery' ), $this->version, true );
		}
	}

	/**
	 * Displaying slider content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display() {
		// Displaying slider only when it has images.
		if ( count( $this->data['image_ids'] ) ) {
			$this->register_dependencies();
			$this->render_view( 'slider.jssor.' . $this->data['theme'], array(
				'data'       => $this->data,
				'css_url'    => plugin_dir_url( __FILE__ ) . 'css/',
				'js_url'     => plugin_dir_url( __FILE__ ) . 'js/',
				'images_url' => plugin_dir_url( __FILE__ ) . 'images/',
			) );
		}
	}

}
