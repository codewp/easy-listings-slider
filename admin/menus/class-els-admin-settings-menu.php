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
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader             $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		$this->load_dependencies();
		// Registering settings.
		$loader->add_action( 'admin_init', $this, 'register_settings' );
	}

	/**
	 * Loading dependencies of the class.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	private function load_dependencies() {
		/**
		 * The class responsible for rendering HTML elements in settings pages.
		 */
		require_once $this->get_path() . 'class-els-admin-settings-html-elements.php';
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

	/**
	 * Add all settings sections and fields.
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function register_settings() {
		if ( false === get_option( 'els_settings' ) ) {
			add_option( 'els_settings' );
		}

		$els_settings = $this->get_registered_settings();
		if ( count( $els_settings ) ) {
			// Getting an instance of settings HTML elements class.
			$html_elements = new ELS_Admin_Settings_HTML_Elements();
			foreach ( $els_settings as $tab => $settings ) {
				add_settings_section( 'els_settings_' . $tab, null, '__return_false', 'els_settings_' . $tab );

				foreach ( $settings as $option ) {
					$name = isset( $option['name'] ) ? $option['name'] : '';

					add_settings_field(
						'els_settings[' . $option['id'] . ']',
						$name,
						method_exists( $html_elements, $option['type'] ) ?
							array( $html_elements, $option['type'] ) : array( $html_elements, 'missing' ),
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
		$els_settings = array(
			/** General Settings */
			'general' => array(
				'slider_in_single_page' => array(
					'id'      => 'slider_in_single_page',
					'name'    => __( 'Display slider in single listing page', 'els' ),
					'desc'    => __( 'This option will shows the slider in single listing page if enabled.', 'els' ),
					'type'    => 'radio',
					'std'     => 'enabled',
					'options' => array(
						'enabled'  => __( 'Enabled', 'els' ),
						'disabled' => __( 'Disabled', 'els' )
					)
				),
				'single_page_slider_theme' => array(
					'id' => 'single_page_slider_theme',
					'name' => __( 'Theme of single page slider', 'els' ),
					'desc' => __( 'Single listing page slider theme', 'els' ),
					'type' => 'select',
					'std' => 'thumbnail',
					'options' => apply_filters( 'els_single_page_slider_theme', array(
							'thumbnail'    => __( 'Thumbnail', 'els' ),
							'full-width'   => __( 'Full Width', 'els' ),
							'introduction' => __( 'Introduction', 'els' ),
						)
					)
				),
				'single_page_slider_width' => array(
					'id'   => 'single_page_slider_width',
					'name' => __( 'Width of single page slider', 'els' ),
					'desc' => __( 'Single listing page slider width in pixels.', 'els' ),
					'type' => 'number',
					'size' => 'small',
					'std'  => '800',
				),
				'single_page_slider_height' => array(
					'id'   => 'single_page_slider_height',
					'name' => __( 'Height of single page slider', 'els' ),
					'desc' => __( 'Single listing page slider height in pixels.', 'els' ),
					'type' => 'number',
					'size' => 'small',
					'std'  => '480',
				),
				'single_page_slider_fill_mode' => array(
					'id' => 'single_page_slider_fill_mode',
					'name' => __( 'Fill mode', 'els' ),
					'desc' => __( 'How to fill content of slider by images?', 'els' ),
					'type' => 'radio',
					'std' => '0',
					'options' => array(
						'0' => __( 'Stretch', 'els' ),
						'1' => __( 'Contain (keep aspect ratio and put all inside slide)', 'els' ),
						'2' => __( 'Cover (keep aspect ratio and cover whole slide)', 'els' ),
						'4' => __( 'Actual size', 'els' ),
						'5' => __( 'Contain for large image and actual size for small image', 'els' ),
					)
				),
				'single_page_slider_autoplay' => array(
					'id' => 'single_page_slider_autoplay',
					'name' => __( 'Autoplay', 'els' ),
					'desc' => __( 'This feature will automatically playes slides if enabled in single listing page.', 'els' ),
					'type' => 'radio',
					'std' => 'enabled',
					'options' => array(
						'enabled'  => __( 'Enabled', 'els' ),
						'disabled' => __( 'Disabled', 'els' )
					)
				),
				'single_page_slider_autoplay_interval' => array(
					'id'   => 'single_page_slider_autoplay_interval',
					'name' => __( 'Autoplay interval', 'els' ),
					'desc' => __( 'Interval of autoplay in single listing page.', 'els' ),
					'type' => 'number',
					'size' => 'small',
					'std'  => '4000',
				),
				'single_page_slider_slide_duration' => array(
					'id'   => 'single_page_slider_slide_duration',
					'name' => __( 'Slide duration', 'els' ),
					'desc' => __( 'Duration of slide in single listing page.', 'els' ),
					'type' => 'number',
					'size' => 'small',
					'std'  => '500',
				),
				'single_page_slider_loop'	 => array(
					'id'      => 'single_page_slider_loop',
					'name'    => __( 'Single listing page slider loop', 'els' ),
					'desc'    => __( 'Slider loop type in single listing page.', 'els' ),
					'type'    => 'select',
					'std'     => '1',
					'options' => array(
						'0' => __( 'Stop', 'els' ),
						'1' => __( 'Loop', 'els' ),
						'2' => __( 'Rewind', 'els' ),
					)
				),
				'single_page_slider_drag_orientation'	 => array(
					'id'      => 'single_page_slider_drag_orientation',
					'name'    => __( 'Single listing page drag orientation', 'els' ),
					'desc'    => __( 'Drag orientation type in single listing page.', 'els' ),
					'type'    => 'select',
					'std'     => '3',
					'options' => array(
						'0' => __( 'No drag', 'els' ),
						'1' => __( 'Horizental', 'els' ),
						'2' => __( 'Vertical', 'els' ),
						'3' => __( 'Either', 'els' ),
					)
				),
			),
		);

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
	public function els_settings_sanitize( $input = array() ) {
		$els_settings = ELS_IOC::make( 'settings' )->get_settings();

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return $input;
		}

		parse_str( $_POST['_wp_http_referer'], $referrer );

		$settings = $this->get_registered_settings();
		$tab      = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

		$input = apply_filters( 'els_settings_' . $tab . '_sanitize', $input );
		// Loop through each setting being saved and pass it through a sanitization filter
		foreach ( $input as $key => $value ) {

			// Get the setting type (checkbox, select, etc)
			$type = isset( $settings[ $tab ][ $key ]['type'] ) ? $settings[ $tab ][ $key ]['type'] : false;

			if ( $type ) {
				// Field type specific filter
				$input[ $key ] = apply_filters( 'els_settings_sanitize_' . $type, $value, $key );
			}

			// General filter
			$input[ $key ] = apply_filters( 'els_settings_sanitize', $input[ $key ], $key );
		}

		// Loop through the whitelist and unset any that are empty for the tab being saved
		if ( ! empty( $settings[ $tab ] ) ) {
			foreach ( $settings[ $tab ] as $key => $value ) {

				// settings used to have numeric keys, now they have keys that match the option ID. This ensures both methods work
				if ( is_numeric( $key ) ) {
					$key = $value['id'];
				}

				if ( empty( $input[ $key ] ) && isset( $els_settings[ $key ] ) ) {
					unset( $els_settings[ $key ] );
				}
			}
		}

		// Merge our new settings with the existing
		$output = array_merge( $els_settings, $input );

		add_settings_error( 'els-notices', '', __( 'Settings updated.', 'els' ), 'updated' );

		return $output;
	}

}
