<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Settings menu creator of the plugin
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin/menus
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Settings_Menu extends ELS_Admin_Controller {

	/**
	 * Rendering content of menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function create_menu() {
		$this->render_view( 'menus.settings-menu', array( 'tabs' => $this->get_settings_tabs() ) );
	}

	/**
	 * Retrieve settings tabs
	 *
	 * @since   1.0.0
	 * @return  array $tabs
	 */
	public function get_settings_tabs() {
		$tabs = array(
			'general' => __( 'General', 'els' )
		);

		return apply_filters( 'els_settings_tabs', $tabs );
	}

}
