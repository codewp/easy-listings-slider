<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-facing HTML elements.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_HTML_Element extends ELS_Admin_Controller {

	/**
	 * Callback that called when rendering callback not found for element type.
	 *
	 * @since   1.0.0
	 * @param   $args
	 */
	public function missing( $args ) {
		printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'elm' ), $args['id'] );
	}

}
