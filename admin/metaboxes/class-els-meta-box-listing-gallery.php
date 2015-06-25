<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ELS_Meta_Box_Listing_Gallery extends ELS_Admin_Controller {

	/**
	 * Constructor of meta box.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		// Action for saving listing gallery.
		$loader->add_action( 'els_save_listing_meta', $this, 'save', 20, 2 );
	}
	/**
	 * Outputing gallery meta box content.
	 * @param WP_Post $post The object for the current post.
	 * @return void
	 */
	public function output( $post ) {
		$this->render_view( 'metaboxes.listing-gallery', array( 'post' => $post ) );
	}

	/**
	 * Saving listing gallery meta box.
	 *
	 * @since 1.0.0
	 * @param  int $post_id
	 * @param  WP_Post $post
	 * @return void
	 */
	public function save( $post_id, $post ) {
		$attachment_ids = isset( $_POST['els_listing_gallery_images'] ) ?
			array_filter( explode( ',', sanitize_text_field( $_POST['els_listing_gallery_images'] ) ) ) : array();

		update_post_meta( $post_id, 'els_listing_gallery', implode( ',', $attachment_ids ) );
	}

}
