<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The admin-facing HTML elements.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_HTML_Element extends ELS_Admin_Controller {

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

}
