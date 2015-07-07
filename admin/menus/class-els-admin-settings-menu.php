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
	 * Object for rendering html elements.
	 *
	 * @since 1.0.0
	 * @var ELS_Admin_HTML_Element
	 */
	private $html_element;

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader             $loader
	 * @param ELS_Admin_HTML_Element $html_element
	 */
	public function __construct( ELS_Loader $loader, ELS_Admin_HTML_Element $html_element ) {
		$this->html_element = $html_element;
		// Registering settings.
		$loader->add_action( 'admin_init', $this, 'register_settings' );
	}

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

	public function register_settings() {
		if ( false === get_option( 'els_settings' ) ) {
			add_option( 'els_settings' );
		}

		$els_settings = $this->get_registered_settings();
		if ( count( $els_settings ) ) {
			foreach ( $els_settings as $tab => $settings ) {
				add_settings_section( 'els_settings_' . $tab, null, '__return_false', 'els_settings_' . $tab );

				foreach ( $settings as $option ) {
					$name = isset( $option['name'] ) ? $option['name'] : '';

					add_settings_field(
						'els_settings[' . $option['id'] . ']',
						$name,
						method_exists( $this->html_element, $option['type'] ) ?
							array( $this->html_element, $option['type'] ) : array( $this->html_element, 'missing' ),
						'els_settings_' . $tab,
						'els_settings_' . $tab,
						array(
							'section'  => $tab,
							'id'       => isset( $option['id'] )      ? $option['id']      : null,
							'desc'     => ! empty( $option['desc'] )  ? $option['desc']    : '',
							'desc_tip' => isset( $option['desc_tip'] ) ? $option['desc_tip'] : false,
							'name'     => isset( $option['name'] )    ? $option['name']    : null,
							'size'     => isset( $option['size'] )    ? $option['size']    : null,
							'options'  => isset( $option['options'] ) ? $option['options'] : '',
							'std'      => isset( $option['std'] )     ? $option['std']     : '',
							'min'      => isset( $option['min'] )     ? $option['min']     : null,
							'max'      => isset( $option['max'] )     ? $option['max']     : null,
							'step'     => isset( $option['step'] )    ? $option['step']    : null,
						)
					);
				}
			}
		}

		// Creates our settings in the options table
		register_setting( 'els_settings', 'els_settings', array( $this, 'els_settings_sanitize' ) );
	}

	/**
	 * Retrieve plugin settings
	 *
	 * @since   1.0.0
	 * @return  array
	 */
	public function get_registered_settings() {
		$els_settings = array();

		return apply_filters( 'els_registered_settings', $els_settings );
	}

	/**
	 * Settings Sanitization
	 *
	 * Adds a settings error (for the updated message)
	 * At some point this will validate input
	 *
	 * @since 1.0.0
	 *
	 * @param array $input The value inputted in the field
	 *
	 * @return string $input Sanitizied value
	 */
	public function els_settings_sanitize() {

	}

}
