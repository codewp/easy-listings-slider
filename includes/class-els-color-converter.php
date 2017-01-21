<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Color Converter.
 *
 * @link       http://www.asanaplugins.com/
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
	 * @return ELS_Color_RGBA
	 */
	public function hex_to_rgba( $hex, $opacity = 100 ) {
		$hex = str_replace( '#', '', $hex );
		if ( $opacity > 100 ) {
			$opacity = 100;
		} else if ( $opacity < 0 ) {
			$opacity = 0;
		}

		if ( 3 === strlen( $hex ) ) {
			$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
			$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
			$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
		} else if ( strlen( $hex ) >= 6 ) {
			$r = hexdec( substr( $hex, 0, 2 ) );
			$g = hexdec( substr( $hex, 2, 2 ) );
			$b = hexdec( substr( $hex, 4, 2 ) );
		}

		return new ELS_Color_RGBA( $r, $g, $b, $opacity );
	}

	/**
	 * RGBA to Hex converter.
	 *
	 * @since  1.0.0
	 * @param  ELS_Color_RGBA $rgba
	 * @return string
	 */
	public function rgba_to_hex( ELS_Color_RGBA $rgba ) {
		if ( null !== $rgba->get_r() && null !== $rgba->get_g() &&
			null !== $rgba->get_b() ) {
			$hex = '#';
			$hex .= str_pad( dechex( $rgba->get_r() ), 2, 0, STR_PAD_LEFT );
			$hex .= str_pad( dechex( $rgba->get_g() ), 2, 0, STR_PAD_LEFT );
			$hex .= str_pad( dechex( $rgba->get_b() ), 2, 0, STR_PAD_LEFT );

			return $hex;
		}
		return '';
	}

}
