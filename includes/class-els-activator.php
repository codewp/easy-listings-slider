<?php

/**
 * Fired during plugin activation
 *
 * @link       http://codewp.github.io/easy-listings-slider
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     taher.atashbar@gmail.com
 */
class ELS_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		// Add the transient to redirect
		set_transient( '_els_activation_redirect', true, 30 );
	}

}
