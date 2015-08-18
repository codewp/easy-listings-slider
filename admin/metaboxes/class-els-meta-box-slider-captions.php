<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The slider captions meta box.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin/metaboxes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Meta_Box_Slider_Captions extends ELS_Admin_Controller {

	/**
	 * Constructor of the class.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		// Action for saving slider captions.
		$loader->add_action( 'els_save_listing_meta', $this, 'save', 20, 2 );
	}

	/**
	 * Outputing slider captions meta box content.
	 *
	 * @since 1.0.0
	 * @param  WP_Post $post
	 * @return void
	 */
	public function output( $post ) {
		$slider      = new ELS_Slider( $post->ID );
		$slides      = $slider->get_slides();
		$attachments = $slide_numbers = array();
		if ( strlen( $slides ) ) {
			$attachments = array_filter( explode( ',', $slides ) );
			if ( count( $attachments ) ) {
				$slide_numbers = array_combine( range( 1, count( $attachments ) ), range( 1, count( $attachments ) ) );
			}
		}

		// Filtering content of captions tinymce editor.
		add_filter( 'the_editor_content', array( $this, 'filter_caption_editor_content' ), 5 );

		$this->render_view( 'metaboxes.slider-captions', array(
				'html'                     => ELS_IOC::make( 'html' ),
				'images_url'               => $this->get_images_url(),
				'slide_numbers'            => $slide_numbers,
				'captions'                 => $slider->get_captions(),
				'caption_transition_types' => $this->get_transition_types(),
				'fonts'					   => ELS_IOC::make( 'font_manager' )->get_font_family()
			)
		);
	}

	/**
	 * Saving slider slides.
	 *
	 * @since 1.0.0
	 * @param  int $post_id
	 * @param  WP_Post $post
	 * @return void
	 */
	public function save( $post_id, $post ) {
		if ( count( $_POST['els_slider_captions'] ) ) {
			// ELS_Validator instance.
			$validator       = ELS_IOC::make( 'validator' );
			// ELS_Color_Converter instance.
			$color_converter = new ELS_Color_Converter();
			// captions array that should be saved.
			$captions  = array();
			// captions transition types.
			$caption_transition_types = $this->get_transition_types();
			$caption_transition_types = array_keys( $caption_transition_types );

			foreach ( $_POST['els_slider_captions'] as $caption ) {
				$sanitized_caption                 = array();
				// Detail fields.
				$sanitized_caption['name']         = wp_kses_post( $caption['name'] );
				// Transition fields.
				if ( in_array( $caption['play_in_transition_type'], $caption_transition_types ) ) {
					$sanitized_caption['play_in_transition_type'] = $caption['play_in_transition_type'];
				} else {
					$sanitized_caption['play_in_transition_type'] = $caption_transition_types[0];
				}

				if ( in_array( $caption['play_out_transition_type'], $caption_transition_types ) ) {
					$sanitized_caption['play_out_transition_type'] = $caption['play_out_transition_type'];
				} else {
					$sanitized_caption['play_out_transition_type'] = $caption_transition_types[0];
				}
				// Style fields.
				$sanitized_caption['slide_number']     = absint( $caption['slide_number'] );
				$sanitized_caption['offsetx']          = (int) $caption['offsetx'];
				$sanitized_caption['offsety']          = (int) $caption['offsety'];
				$sanitized_caption['width']            = absint( $caption['width'] );
				$sanitized_caption['height']           = absint( $caption['height'] );
				$sanitized_caption['line_height']	   = absint( $caption['line_height'] ) > 8 ? absint( $caption['line_height'] ) : 30;
				$sanitized_caption['padding']          = absint( $caption['padding'] );
				$sanitized_caption['font_size']        = absint( $caption['font_size'] ) > 0 ? absint( $caption['font_size'] ) : 20;
				$sanitized_caption['font_family']	   = sanitize_text_field( $caption['font_family'] );
				$sanitized_caption['font_weight']	   = in_array( $caption['font_weight'], array( 'normal', 100, 200, 300, 400, 500, 600, 700, 800, 900 ) ) ? $caption['font_weight'] : 'normal';
				$sanitized_caption['font_style']	   = in_array( $caption['font_style'], array( 'normal', 'italic' ) ) ? $caption['font_style'] : 'normal';
				$sanitized_caption['text_align']       = in_array( $caption['text_align'], array( 'left', 'center', 'right' ) ) ? $caption['text_align'] : 'center';
				$sanitized_caption['color']            = $validator->validate_color( $caption['color'] ) ? $caption['color'] : '#000000';
				$sanitized_caption['color']			   = $color_converter->hex_to_rgba( $sanitized_caption['color'] );
				$sanitized_caption['background_color'] = $validator->validate_color( $caption['background_color'] ) ? $caption['background_color'] : '';
				$sanitized_caption['background_color'] = $color_converter->hex_to_rgba( $sanitized_caption['background_color'], 60 );

				if ( strlen( $sanitized_caption['name'] ) ) {
					$captions[ $sanitized_caption['slide_number'] ][] = $sanitized_caption;
				}
			}
			update_post_meta( $post_id, 'captions', $captions );
		} else {
			update_post_meta( $post_id, 'captions', array() );
		}
	}

	/**
	 * Getting caption transition types.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	private function get_transition_types() {
		return apply_filters( 'els_slider_caption_transition_types',
			array(
				'*'			  => __( 'Random', 'els' ),
				'no'		  => __( 'No', 'els' ),
				'L'           => 'L',
				'R'           => 'R',
				'T'           => 'T',
				'B'           => 'B',
				'TR'          => 'TR',
				'L|IB'        => 'L|IB',
				'R|IB'        => 'R|IB',
				'T|IB'        => 'T|IB',
				'CLIP|LR'     => 'CLIP|LR',
				'CLIP|TB'     => 'CLIP|TB',
				'CLIP|L'      => 'CLIP|L',
				'MCLIP|R'     => 'MCLIP|R',
				'MCLIP|T'     => 'MCLIP|T',
				'WV|B'        => 'WV|B',
				'TORTUOUS|VB' => 'TORTUOUS|VB',
				'LISTH|R'     => 'LISTH|R',
				'RTT|360'     => 'RTT|360',
				'RTT|10'      => 'RTT|10',
				'RTTL|BR'     => 'RTTL|BR',
				'T|IE*IE'     => 'T|IE*IE',
				'RTTS|R'      => 'RTTS|R',
				'RTTS|T'      => 'RTTS|T',
				'DDGDANCE|RB' => 'DDGDANCE|RB',
				'ZMF|10'      => 'ZMF|10',
				'DDG|TR'      => 'DDG|TR',
				'FLTTR|R'     => 'FLTTR|R',
				'FLTTRWN|LT'  => 'FLTTRWN|LT',
				'ATTACK|BR'   => 'ATTACK|BR',
				'FADE'        => 'FADE',
			)
		);
	}

	/**
	 * Filtering content of captions editor to removing p from content.
	 *
	 * @since  1.0.0
	 * @param  string $content
	 * @return string
	 */
	public function filter_caption_editor_content( $content ) {
		// Removing default filter for tinymce content.
		remove_filter( 'the_editor_content', 'wp_richedit_pre' );

		$content = convert_chars( $content );
		$content = htmlspecialchars( $content, ENT_NOQUOTES, get_option( 'blog_charset' ) );
		return $content;
	}

}
