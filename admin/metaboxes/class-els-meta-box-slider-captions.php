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
