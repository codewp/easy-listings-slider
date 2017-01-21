<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin Asset Manager.
 *
 * @link 	   http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Asset_Manager {

	/**
	 * Get css url of admin area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_admin_css() {
		return plugin_dir_url( dirname( __FILE__ ) ) . 'admin/css/';
	}

	/**
	 * Get js url of admin area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_admin_js() {
		return plugin_dir_url( dirname( __FILE__ ) ) . 'admin/js/';
	}

	/**
	 * Get images url of admin area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_admin_images() {
		return plugin_dir_url( dirname( __FILE__ ) ) . 'admin/images/';
	}

	/**
	 * Get css url of public area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_public_css() {
		return plugin_dir_url( dirname( __FILE__ ) ) . 'public/css/';
	}

	/**
	 * Get js url of public area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_public_js() {
		return plugin_dir_url( dirname( __FILE__ ) ) . 'public/js/';
	}

	/**
	 * Get images url of public area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_public_images() {
		return plugin_dir_url( dirname( __FILE__ ) ) . 'public/images/';
	}

	/**
	 * Get fonts path of public area.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_public_fonts() {
		return plugin_dir_path( dirname( __FILE__ ) ) . 'public/fonts/';
	}

}
