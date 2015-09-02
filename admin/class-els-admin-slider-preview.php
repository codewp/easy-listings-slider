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
		$slider = ! empty( $_GET['slider'] ) ? absint( $_GET['slider'] ) : 0;
		if ( $slider && 'els_slider' === get_post_type( $slider ) ) {
			$slider       = new ELS_Slider( $slider );
			$jssor_slider = ELS_IOC::make( 'slider_factory' )->get_jssor_slider( $slider );
			// Because in preview page admin-header.php does not loaded so print scripts manually.
			$jssor_slider->print_scripts  = true;
			// Show message when slider has not images.
			$jssor_slider->show_no_images = true;

			$jssor_slider->display();
		}

		die();	// this is required to terminate immediately and return a proper response
	}

}
