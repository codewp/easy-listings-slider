<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-facing menu creator of the plugin.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Menu {

	/**
	 * array of plugin menus.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private $menus;

	/**
	 * settings menu of the plugin.
	 *
	 * @since 1.0.0
	 * @var ELS_Admin_Settings_Menu
	 */
	private $settings_menu;

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		$this->load_dependencies();

		$this->menus  = array();

		// Settings menu of the plugin containing actions for registering settings.
		$this->settings_menu = new ELS_Admin_Settings_Menu( $loader );
		// Actions for creating menus of the plugin
		$loader->add_action( 'admin_menu', $this, 'settings_menu' );
	}

	/**
	 * Loading dependencies of the class.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	protected function load_dependencies() {
		require_once plugin_dir_path( __FILE__ ) . 'menus/class-els-admin-settings-menu.php';
	}

	/**
	 * Adding settings menu.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function settings_menu() {
		$this->menus[] = add_submenu_page( 'edit.php?post_type=els_slider', __( 'Easy Listings Slider Settings', 'els' ),
			__( 'Settings', 'els' ), 'manage_options', 'els-settings',
			array( $this->settings_menu, 'create_menu' ) );
	}

	/**
	 * Getting plugin menus.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_menus() {
		return $this->menus;
	}

}
