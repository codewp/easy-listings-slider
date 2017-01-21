<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     taher.atashbar@gmail.com
 */
class ELS_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		// Delete when this is Asana active free plugin.
		$asana_plugin = get_option( 'asana_active_free_plugin', '' );
		if ( 'easy-listings-slider' === $asana_plugin ) {
			delete_option( 'asana_active_free_plugin' );
		}
	}

}
