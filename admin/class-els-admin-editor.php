<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class responsible for editor in admin-area.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Editor extends ELS_Admin_Controller {

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		$loader->add_action( 'admin_init', $this, 'define_shortcode_button' );
		$loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
	}

	/**
	 * Hooks for defining shortcode button.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function define_shortcode_button() {
		/*
		 * Add a button for shortcodes to the WP editor.
		 */
		if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
			add_filter( 'mce_buttons', array( $this, 'register_shortcode_button' ) );
			add_filter( 'mce_external_plugins', array( $this, 'add_shortcode_tinymce_plugin' ) );
		}
	}

	/**
	 * Registerring shortcode buttons.
	 *
	 * @since  1.0.0
	 * @param  array $buttons
	 * @return array
	 */
	public function register_shortcode_button( $buttons ) {
		array_push( $buttons, '|', 'els_shortcode_buttons' );
		return $buttons;
	}

	/**
	 * Adding shortcode tinymce plugins.
	 *
	 * @since 1.0.0
	 * @param array $plugins
	 */
	public function add_shortcode_tinymce_plugin( $plugins ) {
		global $wp_version;

		if ( version_compare( $wp_version, '3.9', '>=' ) ) {
			// Use minified libraries if SCRIPT_DEBUG is turned off
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			$plugins['EasyListingsSliderShortcodes'] = $this->get_js_url() . 'editor/editor-plugin' . $suffix . '.js';
		}

		return $plugins;
	}

	/**
	 * Enqueue and localize scripts.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		$sliders        = new ELS_Sliders();
		$editor_sliders = $sliders->get_sliders();
		if ( count( $editor_sliders ) ) {
			wp_localize_script( 'jquery', 'elsSliders', array( 'sliders' => $editor_sliders ) );
			?>
			<style type="text/css">
				.mce-i-els_shortcode_buttons {
					background: url("<?php echo $this->get_images_url() ?>els-editor-button.png") no-repeat scroll 0 2px !important;
					left: 3px;
				    position: relative !important;
				    top: -1px;
				}
			</style>
			<?php
		}
	}

}
