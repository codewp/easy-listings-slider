<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Color Converter.
 *
 * @link
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Color_Converter {

	/**
	 * Hex to RGBA converter.
	 *
	 * @since  1.0.0
	 * @param  string  $hex
	 * @param  integer $opacity
	 * @return stdClass	with { r, g, b, a } properties.
	 */
	public function hex_to_rgba( $hex, $opacity = 60 ) {
		$hex = str_replace( '#', '', $hex );
		if ( $opacity > 100 ) {
			$opacity = 100;
		} else if ( $opacity < 0 ) {
			$opacity = 0;
		}

		$rgba = new stdClass();
		if ( 3 === strlen( $hex ) ) {
			$rgba->r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$rgba->g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$rgba->b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else if ( strlen( $hex ) >= 6 ) {
			$rgba->r = hexdec( substr( $hex, 0, 2 ) );
			$rgba->g = hexdec( substr( $hex, 2, 2 ) );
			$rgba->b = hexdec( substr( $hex, 4, 2 ) );
		}
		$rgba->a = $opacity / 100;

		return $rgba;
	}

	/**
	 * RGBA to Hex converter.
	 *
	 * @since  1.0.0
	 * @param  stdClass $rgba
	 * @return string
	 */
	public function rgba_to_hex( stdClass $rgba ) {
		if ( ! empty( $rgba->a ) && ! empty( $rgba->g ) && ! empty( $rgba->b ) ) {
			$hex = '#';
			$hex .= str_pad( dechex( $rgba->r ), 2, 0, STR_PAD_LEFT );
			$hex .= str_pad( dechex( $rgba->g ), 2, 0, STR_PAD_LEFT );
			$hex .= str_pad( dechex( $rgba->b ), 2, 0, STR_PAD_LEFT );

			return $hex;
		}
		return '';
	}

}
