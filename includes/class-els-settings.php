<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class responsible for plugin settigns.
 *
 * @link       http://www.asanaplugins.com/
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

	/**
	 * Magic __get function to dispatch a call to retrieve a private property
	 *
	 * @param  string $key
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( method_exists( $this, 'get_' . $key ) ) {
			return call_user_method( 'get_' . $key, $this );
		} else if ( array_key_exists( $key, $this->plugin_settings ) ) {
			return $this->plugin_settings[ $key ];
		}

		return null;
	}

	/**
	 * Getting single listing page slider state.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public function get_slider_in_single_page() {
		return isset( $this->plugin_settings['slider_in_single_page'] ) &&
			'disabled' === $this->plugin_settings['slider_in_single_page'] ? false : true;
	}

	/**
	 * Getting single listing page slider theme.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_single_page_slider_theme() {
		return ! empty( $this->plugin_settings['single_page_slider_theme'] ) ?
			$this->plugin_settings['single_page_slider_theme'] : 'thumbnail';
	}

	/**
	 * Getting single listing page slider width.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_width() {
		return ! empty( $this->plugin_settings['single_page_slider_width'] ) ?
			absint( $this->plugin_settings['single_page_slider_width'] ) : 800;
	}

	/**
	 * Getting single listing page slider height.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_height() {
		return ! empty( $this->plugin_settings['single_page_slider_height'] ) ?
			absint( $this->plugin_settings['single_page_slider_height'] ) : 480;
	}

	/**
	 * Getting single listing page slider fill mode feature.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_fill_mode() {
		return ! empty( $this->plugin_settings['single_page_slider_fill_mode'] ) ?
			absint( $this->plugin_settings['single_page_slider_fill_mode'] ) : 0;
	}

	/**
	 * Getting single listing page slider autoplay.
	 *
	 * @since  1.0.0
	 * @return boolean
	 */
	public function get_single_page_slider_autoplay() {
		return isset( $this->plugin_settings['single_page_slider_autoplay'] ) &&
			'disabled' === $this->plugin_settings['single_page_slider_autoplay'] ? false : true;
	}

	/**
	 * Getting single listing page slider autoplay_interval
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_autoplay_interval() {
		return ! empty( $this->plugin_settings['single_page_slider_autoplay_interval'] ) ?
			absint( $this->plugin_settings['single_page_slider_autoplay_interval'] ) : 4000;
	}

	/**
	 * Getting single listing page slider slide_duration.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_slide_duration() {
		return ! empty( $this->plugin_settings['single_page_slider_slide_duration'] ) ?
			absint( $this->plugin_settings['single_page_slider_slide_duration'] ) : 500;
	}

	/**
	 * Getting single listing page slider slider_loop.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_loop() {
		return isset( $this->plugin_settings['single_page_slider_loop'] ) ?
			absint( $this->plugin_settings['single_page_slider_loop'] ) : 1;
	}

	/**
	 * Getting single listing page slider drag_orientation.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_single_page_slider_drag_orientation() {
		return isset( $this->plugin_settings['single_page_slider_drag_orientation'] ) ?
			absint( $this->plugin_settings['single_page_slider_drag_orientation'] ) : 3;
	}

}
