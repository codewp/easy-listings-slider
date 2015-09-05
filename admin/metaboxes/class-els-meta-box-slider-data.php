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
		$slider = new ELS_Slider( $post->ID );
		$this->render_view(
			'metaboxes.slider-data',
			array(
				'slider'     => $slider,
				'images_url' => $this->get_images_url(),
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
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		// Registering scripts.
		/**
		 * Do not use $suffix for below script because it has global window variable
		 * that used in php files for adding some functionality to captions editor.
		 */
		wp_enqueue_script( 'els-slider-metaboxes', $this->get_js_url() . 'els-slider-metaboxes.js',
			array( 'jquery-ui-tabs' ), false, true );
		wp_localize_script( 'els-slider-metaboxes', 'els_slider',
			array(
				'add_listings' => __( 'Add Listings to Slider', 'els' ),
				'google_fonts' => ELS_IOC::make( 'font_manager' )->get_google_webfonts()
			)
		);
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
		$fields = $this->get_fields();
		foreach ( $fields as $field ) {
			if ( isset( $_POST[ $field ] ) ) {
				update_post_meta( $post_id, $field, trim( $_POST[ $field ] ) );
			}
		}
	}

	/**
	 * Getting slider data meta box fields that should be save.
	 *
	 * @since 1.0.0
	 * @return array array of slider data meta box fields
	 */
	private function get_fields() {
		return
			apply_filters( 'els_slider_data_meta_box_fields',
				array(
					'slider_theme',
					'slider_type',
					'slider_container_id',
					'slider_width',
					'slider_height',
					'slider_fill_mode',
					'auto_play',
					'autoplay_interval',
					'slide_duration',
					'loop',
					'drag_orientation',
				)
			);
	}

}
