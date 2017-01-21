<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * HTML elements renderer.
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_HTML_Elements {

	/**
	 * Renders an HTML Dropdown
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function select( $args = array() ) {
		$defaults = array(
			'options'          => array(),
			'name'             => null,
			'class'            => '',
			'id'               => '',
			'selected'         => 0,
			'chosen'           => false,
			'placeholder'      => null,
			'multiple'         => false,
			'show_option_all'  => _x( 'All', 'all dropdown items', 'els' ),
			'show_option_none' => _x( 'None', 'no dropdown items', 'els' )
		);

		$args = wp_parse_args( $args, $defaults );


		if ( $args['multiple'] ) {
			$multiple = ' MULTIPLE';
		} else {
			$multiple = '';
		}

		if ( $args['chosen'] ) {
			$args['class'] .= ' els-select-chosen';
		}

		if ( $args['placeholder'] ) {
			$placeholder = $args['placeholder'];
		} else {
			$placeholder = '';
		}

		$output = '<select name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( sanitize_key( str_replace( '-', '_', $args['id'] ) ) ) . '" class="els-select ' . esc_attr( $args['class'] ) . '"' . $multiple . ' data-placeholder="' . $placeholder . '">';

		if ( $args['show_option_all'] ) {
			if ( $args['multiple'] ) {
				$selected = selected( true, in_array( 0, $args['selected'] ), false );
			} else {
				$selected = selected( $args['selected'], 0, false );
			}
			$output .= '<option value="all"' . $selected . '>' . esc_html( $args['show_option_all'] ) . '</option>';
		}

		if ( ! empty( $args['options'] ) ) {

			if ( $args['show_option_none'] ) {
				if ( $args['multiple'] ) {
					$selected = selected( true, in_array( -1, $args['selected'] ), false );
				} else {
					$selected = selected( $args['selected'], -1, false );
				}
				$output .= '<option value="-1"' . $selected . '>' . esc_html( $args['show_option_none'] ) . '</option>';
			}

			foreach ( $args['options'] as $key => $option ) {

				if ( $args['multiple'] && is_array( $args['selected'] ) ) {
					$selected = selected( true, in_array( $key, $args['selected'] ), false );
				} else {
					$selected = selected( $args['selected'], $key, false );
				}

				$output .= '<option value="' . esc_attr( $key ) . '"' . $selected . '>' . esc_html( $option ) . '</option>';
			}
		}

		$output .= '</select>';

		return $output;
	}

	/**
	 * Renders an HTML Checkbox
	 *
	 * @since 1.0.0
	 *
	 * @param array $args
	 *
	 * @return string
	 */
	public function checkbox( $args = array() ) {
		$defaults = array(
			'name'     => null,
			'current'  => null,
			'class'    => 'els-checkbox',
			'options'  => array(
				'disabled' => false,
				'readonly' => false,
			)
		);

		$args = wp_parse_args( $args, $defaults );

		$options = '';
		if ( ! empty( $args['options']['disabled'] ) ) {
			$options .= ' disabled="disabled"';
		} elseif ( ! empty( $args['options']['readonly'] ) ) {
			$options .= ' readonly';
		}

		$output = '<input type="checkbox"' . $options . ' name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $args['name'] ) . '" class="' . $args['class'] . ' ' . esc_attr( $args['name'] ) . '" ' . checked( 1, $args['current'], false ) . ' />';

		return $output;
	}

	/**
	 * Renders an HTML Text field
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Arguments for the text field
	 * @return string Text field
	 */
	public function text( $args = array() ) {

		$defaults = array(
			'name'         => 'text',
			'type'		   => 'text',
			'value'        => null,
			'label'        => null,
			'desc'         => null,
			'placeholder'  => '',
			'class'        => 'regular-text',
			'disabled'     => false,
			'autocomplete' => '',
			'data'         => false,
			'min'		   => null,
			'max'		   => null,
		);

		$args = wp_parse_args( $args, $defaults );

		$disabled = '';
		if ( $args['disabled'] ) {
			$disabled = ' disabled="disabled"';
		}

		$data = '';
		if ( ! empty( $args['data'] ) ) {
			foreach ( $args['data'] as $key => $value ) {
				$data .= 'data-' . $key . '="' . $value . '" ';
			}
		}

		$output = '<span id="els-' . sanitize_key( $args['name'] ) . '-wrap">';

		$output .= '<label class="els-label" for="els-' . sanitize_key( $args['name'] ) . '">' . esc_html( $args['label'] ) . '</label>';

		if ( ! empty( $args['desc'] ) ) {
			$output .= '<span class="els-description">' . esc_html( $args['desc'] ) . '</span>';
		}

		$output .= '<input type="' . esc_attr( $args['type'] ) . '" name="' .
			esc_attr( $args['name'] ) . '" id="' . esc_attr( $args['name'] )  .
			'" autocomplete="' . esc_attr( $args['autocomplete'] )  . '" value="' .
			esc_attr( $args['value'] ) . '" placeholder="' . esc_attr( $args['placeholder'] ) . '"' .
			( ! is_null( $args['min'] ) ? 'min="' . esc_attr( $args['min'] ) . '"' : '' ) .
			( ! is_null( $args['max'] ) ? 'max="' . esc_attr( $args['max'] ) . '"' : '' ) .
			' class="' . $args['class'] . '" ' . $data . '' . $disabled . '/>';

		$output .= '</span>';

		return $output;
	}

	/**
	 * Renders an HTML Number field
	 *
	 * @since  1.0.0
	 * @param  array  $args
	 * @return string
	 */
	public function number( $args = array() ) {
		$args['type'] = 'number';
		return $this->text( $args );
	}

	/**
	 * Renders an HTML Color Picker field.
	 *
	 * @since  1.0.0
	 * @param  array  $args
	 * @return string
	 */
	public function color_picker( $args = array() ) {
		$args['class'] = 'colorpick';
		return $this->text( $args );
	}

	/**
	 * Renders an HTML textarea
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Arguments for the textarea
	 * @return string textarea
	 */
	public function textarea( $args = array() ) {
		$defaults = array(
			'name'        => 'textarea',
			'value'       => null,
			'label'       => null,
			'desc'        => null,
			'class'       => 'large-text',
			'disabled'    => false,
		);

		$args = wp_parse_args( $args, $defaults );

		$disabled = '';
		if ( $args['disabled'] ) {
			$disabled = ' disabled="disabled"';
		}

		$output = '<span id="els-' . sanitize_key( $args['name'] ) . '-wrap">';

		$output .= '<label class="els-label" for="els-' . sanitize_key( $args['name'] ) . '">' . esc_html( $args['label'] ) . '</label>';

		$output .= '<textarea name="' . esc_attr( $args['name'] ) . '" id="' . esc_attr( $args['name'] ) . '" class="' . $args['class'] . '"' . $disabled . '>' . esc_attr( $args['value'] ) . '</textarea>';

		if ( ! empty( $args['desc'] ) ) {
			$output .= '<span class="els-description">' . esc_html( $args['desc'] ) . '</span>';
		}

		$output .= '</span>';

		return $output;
	}

}
