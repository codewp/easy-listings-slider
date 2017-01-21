<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * RGBA Color.
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes/color
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Color_RGBA {

	private $r;
	private $g;
	private $b;
	private $a;

	/**
	 * Constructor of the class
	 *
	 * @since 1.0.0
	 * @param int  $r
	 * @param int  $g
	 * @param int  $b
	 * @param int  $a
	 */
	public function __construct( $r, $g, $b, $a = 100 ) {
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
		$this->a = $a / 100;
		if ( $a > 100 ) {
			$this->a = 1;
		} else if ( $a < 0 ) {
			$this->a = 0;
		}
	}

	/**
	 * Converting Object to string.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function __toString() {
		if ( ! is_null( $this->r ) && ! is_null( $this->g ) &&
			! is_null( $this->b ) && ! is_null( $this->a ) ) {
			return 'rgba(' . $this->r . ',' . $this->g . ',' . $this->b . ',' . $this->a . ')';
		}

		return '';
	}

	/**
	 * Getting red property of RGBA color.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_r() {
		return $this->r;
	}

	/**
	 * Getting green property of RGBA color.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_g() {
		return $this->g;
	}

	/**
	 * Getting blue property of RGBA color.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_b() {
		return $this->b;
	}

	/**
	 * Getting opacity property of RGBA color.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_a() {
		return $this->a;
	}

}
