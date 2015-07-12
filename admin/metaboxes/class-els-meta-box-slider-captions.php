<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The slider captions meta box.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin/metaboxes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Meta_Box_Slider_Captions extends ELS_Admin_Controller {

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		// Action for saving slider captions.
		$loader->add_action( 'els_save_listing_meta', $this, 'save', 20, 2 );
	}

	/**
	 * Outputing slider captions meta box content.
	 *
	 * @since 1.0.0
	 * @param  WP_Post $post
	 * @return void
	 */
	public function output( $post ) {
		$slider      = new ELS_Slider( $post->ID );
		$slides      = $slider->get_slides();
		$attachments = $slide_numbers = array();
		if ( strlen( $slides ) ) {
			$attachments = array_filter( explode( ',', $slides ) );
			if ( count( $attachments ) ) {
				$slide_numbers = array_combine( range( 1, count( $attachments ) ), range( 1, count( $attachments ) ) );
			}
		}

		$this->render_view( 'metaboxes.slider-captions', array(
				'html'          => ELS_IOC::make( 'html' ),
				'images_url'    => $this->get_images_url(),
				'slide_numbers' => $slide_numbers,
			)
		);
	}

	/**
	 * Saving slider slides.
	 *
	 * @since 1.0.0
	 * @param  int $post_id
	 * @param  WP_Post $post
	 * @return void
	 */
	public function save( $post_id, $post ) {

	}

}
