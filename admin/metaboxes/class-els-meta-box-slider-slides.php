<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The slider slides meta box.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin/metaboxes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Meta_Box_Slider_Slides extends ELS_Admin_Controller {

	public function __construct( ELS_Loader $loader ) {
		// Action for saving slider data.
		$loader->add_action( 'els_save_listing_meta', $this, 'save', 20, 2 );
	}

	/**
	 * Outputing slider slides meta box content.
	 *
	 * @since 1.0.0
	 * @param  WP_Post $post
	 * @return void
	 */
	public function output( $post ) {
		$slider      = new ELS_Slider( $post->ID );
		$slides      = $slider->get_slides();
		$attachments = array();
		if ( strlen( $slides ) ) {
			$attachments = array_filter( explode( ',', $slides ) );
		}
		$this->render_view( 'metaboxes.slider-slides',
			array(
				'slides'      => $slides,
				'attachments' => $attachments,
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
		$attachment_ids = isset( $_POST['els_slider_images'] ) ?
			array_filter( explode( ',', sanitize_text_field( $_POST['els_slider_images'] ) ) ) : array();

		update_post_meta( $post_id, 'slides', implode( ',', $attachment_ids ) );
	}

}
