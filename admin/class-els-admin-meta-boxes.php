<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ELS_Admin_Meta_Boxes {

	private $gallery_meta_box;

	public function __construct( ELS_Loader $loader ) {
		// loading dependencies.
		$this->load_dependencies();
		// Gallery meta box instance.
		$this->gallery_meta_box = new ELS_Meta_Box_Listing_Gallery( $loader );

		// Actions for meta boxes.
		$loader->add_action( 'add_meta_boxes', $this, 'add_meta_boxes' );
		$loader->add_action( 'save_post', $this, 'save_meta_boxes', 1, 2 );
	}

	private function load_dependencies() {
		require_once plugin_dir_path( __FILE__ ) . 'metaboxes/class-els-meta-box-listing-gallery.php';
	}

	public function add_meta_boxes() {
		// Adding meta boxes to activated listing types.
		$listing_types = epl_get_active_post_types();
		if ( count( $listing_types ) ) {
			foreach ( $listing_types as $listing_type => $listing_type_label ) {
				add_meta_box( 'els_listing_gallery', __( 'Listing Gallery', 'els' ), array( $this->gallery_meta_box, 'output' ), $listing_type, 'side', 'low' );
			}
		}
	}

	/**
	 * Check if we're saving, the trigger an action based on the post type
	 *
	 * @param  id $post_id
	 * @param  WP_Post $post
	 * @return void
	 */
	public function save_meta_boxes( $post_id, $post ) {
		// $post_id and $post are required
		if ( empty( $post_id ) || empty( $post ) ) {
			return;
		}

		// Dont' save meta boxes for revisions or autosaves
		if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) ) {
			return;
		}

		// Check the nonce
		if ( ! isset( $_POST['els_meta_nonce'] ) || ! wp_verify_nonce( $_POST['els_meta_nonce'], 'els_save_data' ) ) {
			return;
		}

		// Check the post being saved == the $post_id to prevent triggering this call for other save_post events
		if ( empty( $_POST['post_ID'] ) || $_POST['post_ID'] != $post_id ) {
			return;
		}

		// Check user has permission to edit
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Triggering actions for saving meta boxes.
		do_action( 'els_save_listing_meta', $post_id, $post );
	}

}
