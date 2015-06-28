<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The slider data meta box.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin/metaboxes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Meta_Box_Slider_Data extends ELS_Admin_Controller {

	/**
	 * constructor of the slider data meta box.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		// Action for saving slider data.
		$loader->add_action( 'els_save_listing_meta', $this, 'save', 10, 2 );
	}

	/**
	 * Outputing slider data meta box content.
	 *
	 * @since 1.0.0
	 * @param  WP_Post $post
	 * @return void
	 */
	public function output( $post ) {
		$this->register_scripts();
		$this->render_view( 'metaboxes.slider-data', array( 'post' => $post ) );
	}

	/**
	 * Registering scripts and styles.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function register_scripts() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		// Registering scripts.
		wp_enqueue_script( 'els-slider-metaboxes', $this->get_js_url() . 'els-slider-metaboxes' . $suffix . '.js',
			array( 'jquery-ui-tabs' ), false, true );
		// Registering styles.
		wp_enqueue_style( 'els-slider-metaboxes', $this->get_css_url() . 'els-slider-metaboxes' . $suffix . '.css' );
	}

	/**
	 * Saving slider data.
	 *
	 * @since 1.0.0
	 * @param  int $post_id
	 * @param  WP_Post $post
	 * @return void
	 */
	public function save( $post_id, $post ) {

	}

}
