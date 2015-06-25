<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Base class for sliders.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/public
 * @author     Taher Atashbar<taher.atashbar@gmail.com>
 */

abstract class ELS_Public_Slider_Base extends ELS_Public_Controller {

	/**
	 * Properties of the class.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	protected $data = array();

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param array $data properties of the object.
	 */
	public function __construct( array $data = array() ) {
		foreach ( $data as $key => $value ) {
			if ( array_key_exists( $key, $this->data ) ) {
				$this->data[ $key ] = $value;
			}
		}
	}

	/**
	 * Set magic method of the class
	 *
	 * @since 1.0.0
	 * @param string $key
	 * @param mixed $value
	 */
	public function __set( $key, $value ) {
		if ( array_key_exists( $key, $this->data ) ) {
			$this->data[ $key ] = $value;
		}
	}

	/**
	 * Get magic method of the class.
	 *
	 * @since 1.0.0
	 * @param string $key
	 * @return mixed
	 */
	public function __get( $key ) {
		return array_key_exists( $key, $this->data ) ? $this->data[ $key ] : null;
	}

	/**
	 * Displaying slider content.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	abstract public function display();
}
