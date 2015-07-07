<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class responsible for plugin settigns.
 *
 * @link
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Settings {

	/**
	 * Plugin settings
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $plugin_settings;

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->plugin_settings = get_option( 'els_settings' );
		if ( empty( $this->plugin_settings ) ) {
			$this->plugin_settings = array();
		}
	}

	/**
	 * Getting plugin settings.
	 *
	 * @since 1.0.0
	 * @return array $plugin_settings
	 */
	public function get_settings() {
		return apply_filters( 'els_get_settings', $this->plugin_settings );
	}

}
