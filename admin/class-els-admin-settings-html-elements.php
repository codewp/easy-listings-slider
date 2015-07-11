<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class responsible for rendering HTML elements in settings pages.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Settings_HTML_Elements extends ELS_Admin_Controller {

	/**
	 * Callback that called when rendering callback not found for element type.
	 *
	 * @since   1.0.0
	 * @param   $args
	 */
	public function missing( $args ) {
		printf( __( 'The callback function used for the <strong>%s</strong> setting is missing.', 'els' ), $args['id'] );
	}

	/**
	 * Radio Callback
	 *
	 * Renders radio boxes.
	 *
	 * @since   1.0.0
	 * @param   array $args Arguments passed by the setting
	 * @return  void
	 */
	public function radio( $args ) {
		if ( count( $args['options'] ) ) {
			$els_settings = ELS_IOC::make( 'settings' )->get_settings();

			if ( true === $args['desc_tip'] ) {
				echo '<img class="help_tip" data-tip="' . esc_attr( $args['desc'] ) . '" src="' . esc_url( $this->get_images_url() ) . 'help.png" height="16" width="16" />';
			}
			foreach ( $args['options'] as $key => $option ) {
				$checked = false;

				if ( isset( $els_settings[ $args['id'] ] ) && $els_settings[ $args['id'] ] == $key ) {
					$checked = true;
				} else if ( isset( $args['std'] ) && $args['std'] == $key && ! isset( $els_settings[ $args['id'] ] ) ) {
					$checked = true;
				}

				echo '<input name="els_settings[' . $args['id'] . ']"" id="els_settings[' . $args['id'] . '][' . $key . ']" type="radio" value="' . $key . '" ' . checked( true, $checked, false ) . '/>&nbsp;' .
					'<label for="els_settings[' . $args['id'] . '][' . $key . ']">' . $option . '</label><br/>';
			}
			if ( false === $args['desc_tip'] ) {
				echo '<p class="description">' . $args['desc'] . '</p>';
			}
		}
	}

	/**
	 * Number Callback
	 *
	 * Renders number fields.
	 *
	 * @since   1.0.0
	 * @param   array $args Arguments passed by the setting
	 * @return  void
	 */
	public function number( $args ) {
		$els_settings = ELS_IOC::make( 'settings' )->get_settings();

		if ( isset( $els_settings[ $args['id'] ] ) ) {
			$value = $els_settings[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		$max  = isset( $args['max'] ) ? $args['max'] : 999999;
		$min  = isset( $args['min'] ) ? $args['min'] : 0;
		$step = isset( $args['step'] ) ? $args['step'] : 1;
		$size = ( isset( $args['size'] ) && ! is_null( $args['size'] ) ) ? $args['size'] : 'regular';

		if ( true === $args['desc_tip'] ) {
			echo '<img class="help_tip" data-tip="' . esc_attr( $args['desc'] ) . '" src="' . esc_url( $this->get_images_url() ) . 'help.png" height="16" width="16" />';
		}
		echo '<input type="number" step="' . esc_attr( $step ) . '" max="' . esc_attr( $max ) . '" min="' . esc_attr( $min ) . '" class="' . esc_attr( $size ) . '-text" id="els_settings[' . esc_attr( $args['id'] ) . ']" name="els_settings[' . esc_attr( $args['id'] ) . ']" value="' . esc_attr( stripslashes( $value ) ) . '"/>';
		if ( false === $args['desc_tip'] ) {
			echo '<label for="els_settings[' . esc_attr( $args['id'] ) . ']"> '  . esc_html( $args['desc'] ) . '</label>';
		}
	}

	/**
	 * Select Callback
	 *
	 * Renders select fields.
	 *
	 * @since 1.0.0
	 * @param  array $args Arguments passed by the setting
	 * @return void
	 */
	public function select( $args ) {
		$els_settings = ELS_IOC::make( 'settings' )->get_settings();

		if ( isset( $els_settings[ $args['id'] ] ) ) {
			$value = $els_settings[ $args['id'] ];
		} else {
			$value = isset( $args['std'] ) ? $args['std'] : '';
		}

		if ( true === $args['desc_tip'] ) {
			echo '<img class="help_tip" data-tip="' . esc_attr( $args['desc'] ) . '" src="' . esc_url( $this->get_images_url() ) . 'help.png" height="16" width="16" />';
		}
		echo '<select id="els_settings[' . esc_attr( $args['id'] ) . ']" name="els_settings[' . esc_attr( $args['id'] ) . ']"/>';
		if ( count( $args['options'] ) ) {
			foreach ( $args['options'] as $option => $name ) {
				$selected = selected( $option, $value, false );
				echo '<option value="' . esc_attr( $option ) . '" ' . $selected . '>' . esc_attr( $name ) . '</option>';
			}
		}
		echo '</select>';
		if ( false === $args['desc_tip'] ) {
			echo '<label for="els_settings[' . esc_attr( $args['id'] ) . ']"> '  . esc_attr( $args['desc'] ) . '</label>';
		}
	}

	/**
	 * Header Callback
	 *
	 * Renders the header.
	 *
	 * @since 1.0.0
	 * @param array $args Arguments passed by the setting
	 * @return void
	 */
	public function header( $args ) {
		echo '<hr/>';
	}

}
