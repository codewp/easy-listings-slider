<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Validator class for the plugin.
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Validator {

	/**
	 * Validating HEX Color.
	 *
	 * @since  1.0.0
	 * @param  string $color
	 * @return boolean
	 */
	public function validate_color( $color ) {
		if ( preg_match( '/^#[a-f0-9]{6}$/i', $color ) ) {
			return true;
		}
		return false;
	}

}
