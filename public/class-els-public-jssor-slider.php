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
		'print_scripts'		 => false,			// A flag for printing scripts when admin-header.php does not loaded.
		'show_no_images'	 => false,			// A flag for showing slider has not images when it has not images.
		'image_ids'          => array(),
		'captions'			 => array(),
		'captions_fonts'	 => array(),
		'theme'              => 'thumbnail',
		'id'				 => '',
		'width'				 => 800,
		'height'			 => 480,
		'fill_mode'			 => 0,
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
		/**
		 * Printing scripts when scripts should be printed manually
		 * And admin-header.php does not loaded.
		 */
		if ( $this->data['print_scripts'] ) {
			wp_script_is( 'jssor-slider' ) ?
				wp_print_scripts( array( 'jssor', 'jssor-slider' ) ) : wp_print_scripts( 'jssor' );
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
			if ( count( $this->data['captions_fonts'] ) ) {
				$this->data['print_scripts'] ?
					ELS_IOC::make( 'font_manager' )->enqueue_google_fonts( $this->data['captions_fonts'], true ) :
					ELS_IOC::make( 'font_manager' )->enqueue_google_fonts( $this->data['captions_fonts'] );
			}
			$this->data['id'] = trim( $this->data['id'] ) ? trim( $this->data['id'] ) : 'slider_container_' . current_time( 'timestamp' );
			$this->render_view( 'slider.jssor.' . $this->data['theme'], array(
				'data'       => $this->data,
				'css_url'    => plugin_dir_url( __FILE__ ) . 'css/',
				'js_url'     => plugin_dir_url( __FILE__ ) . 'js/',
				'images_url' => plugin_dir_url( __FILE__ ) . 'images/',
			) );
		} else if ( $this->data['show_no_images'] ) {
			wp_enqueue_style( 'jssor-slider-no-images', plugin_dir_url( __FILE__ ) . 'css/' . 'slider/jssor/no-images.css' );
			if ( $this->data['print_scripts'] ) {
				wp_print_styles( 'jssor-slider-no-images' );
			}
			?>
			<div id="message" class="error">
				<p>
					<strong>
						<?php
						echo __( 'Slider has not images to show', 'els' );
						?>
					</strong>
				</p>
			</div>
			<?php
		}
	}

}
