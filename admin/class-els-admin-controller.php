<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-facing controller of the plugin.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Controller {

	/**
	 * Rendering requested view.
	 *
	 * @since   1.0.0
	 * @param   string  $view
	 * @param   array   $variables
	 */
	public function render_view( $view, array $variables = array() ) {
		$view = trim( $view );
		if ( strlen( $view ) ) {
			if ( count( $variables ) ) {
				extract( $variables, EXTR_OVERWRITE );
			}
			if ( strpos( $view, '.' ) !== false ) {
				$view = str_replace( '.', '/', $view );
			}
			$path = plugin_dir_path( __FILE__ ) . 'partials/' . $view . '.php';
			if ( file_exists( $path ) ) {
				include $path;
			} else {
				echo 'File not found.';
			}
		}
	}

}
