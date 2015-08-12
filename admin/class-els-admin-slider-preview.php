<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Preview slider in admin area.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Slider_Preview {

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		// Hook for creating slider preview page.
		$loader->add_action( 'admin_menu', $this, 'slider_preview_page' );
	}

	/**
	 * Creating a page for slider preview.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function slider_preview_page() {
		add_submenu_page(
			'options.php', __( 'Slider Preview', 'els' ), __( 'Slider Preview', 'els' ),
			'manage_options', 'els_slider_preview', array( $this, 'preview' )
		);
	}

	/**
	 * Preview caption.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function preview() {
		$slider = absint( $_GET['slider'] );

		die();	// this is required to terminate immediately and return a proper response
	}

}
