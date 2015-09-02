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
		// Ajax action for loading Listings in the thickbox.
		$loader->add_action( 'wp_ajax_load_listings_list', $this, 'load_listings_list' );
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

		// loading scripts.
		$this->register_scripts();

		$this->render_view( 'metaboxes.slider-slides',
			array(
				'slider_type' => $slider->get_type(),
				'slides'      => $slides,
				'attachments' => $attachments,
			)
		);
	}

	/**
	 * Registering scripts and styles.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function register_scripts() {
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_style( 'thickbox' );
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

	/**
	 * Ajax function for loading list of listings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_listings_list() {
		$list_listings = new ELS_Admin_Listings_List();
		if ( ! empty( $_REQUEST['posts_per_page'] ) ) {
			$list_listings->set_posts_per_page( absint( $_REQUEST['posts_per_page'] ) );
		}
		if ( ! empty( $_REQUEST['paged'] ) ) {
			$list_listings->set_paged( absint( $_REQUEST['paged'] ) );
		}
		if ( ! empty( $_REQUEST['listing_type'] ) ) {
			$list_listings->set_listing_type( $_REQUEST['listing_type'] );
		}
		if ( ! empty( $_REQUEST['listing_status'] ) ) {
			$list_listings->set_listing_status( $_REQUEST['listing_status'] );
		}
		if ( ! empty( $_REQUEST['listing_special'] ) ) {
			$list_listings->set_listing_special( $_REQUEST['listing_special'] );
		}
		$list_listings->display();

		die(); // Required for ajax requests.
	}

}
