<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ELS Slider Object.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Slider {

	/**
	 * Declare the default properities in WP_Post as we can't extend it
	 * Anything we've delcared above has been removed.
	 */
	public $ID = 0;
	public $post_author = 0;
	public $post_date = '0000-00-00 00:00:00';
	public $post_date_gmt = '0000-00-00 00:00:00';
	public $post_content = '';
	public $post_title = '';
	public $post_excerpt = '';
	public $post_status = 'publish';
	public $comment_status = 'open';
	public $ping_status = 'open';
	public $post_password = '';
	public $post_name = '';
	public $to_ping = '';
	public $pinged = '';
	public $post_modified = '0000-00-00 00:00:00';
	public $post_modified_gmt = '0000-00-00 00:00:00';
	public $post_content_filtered = '';
	public $post_parent = 0;
	public $guid = '';
	public $menu_order = 0;
	public $post_mime_type = '';
	public $comment_count = 0;
	public $filter;

	private $slides;
	private $captions;
	private $captions_fonts;
	private $type;
	private $theme;
	private $container_id;
	private $width;
	private $height;
	private $fill_mode;
	private $auto_play;
	private $auto_play_interval;
	private $slide_duration;
	private $loop;
	private $drag_orientation;

	/**
	 * Constructor of ELS_Slider.
	 *
	 * @since 1.0.0
	 * @param int|boolean $id
	 */
	public function __construct( $id = false ) {
		$this->get_instance( $id );
	}

	/**
	 * Getting an instace of slider base on it's id.
	 *
	 * @since 1.0.0
	 * @param  int|boolean $id
	 * @return ELS_Slider|false
	 */
	protected function get_instance( $id = false ) {

		global $wpdb;

		$post_id = (int) $id;
		if ( ! $post_id ) {
			return false;
		}

		$_post = wp_cache_get( $post_id, 'posts' );

		if ( ! $_post ) {
			$_post = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $wpdb->posts WHERE ID = %d LIMIT 1", $post_id ) );

			if ( ! $_post )
				return false;

			$_post = sanitize_post( $_post, 'raw' );
			wp_cache_add( $_post->ID, $_post, 'posts' );
		} elseif ( empty( $_post->filter ) ) {
			$_post = sanitize_post( $_post, 'raw' );
		}

		$post_variables = get_object_vars( $_post );
		foreach ( $post_variables as $key => $value ) {
			$this->$key = $value;
		}
	}

	/**
	 * Magic __get function to dispatch a call to retrieve a private property
	 *
	 * @since 1.0.0
	 * @param  string $key
	 * @return mixed
	 */
	public function __get( $key ) {
		if ( method_exists( $this, 'get_' . $key ) ) {
			return call_user_method( 'get_' . $key, $this );
		}

		return new WP_Error( 'els-slider-invalid-property', sprintf( __( 'Can\'t get property %s', 'els' ), $key ) );
	}

	/**
	 * Getting slides of slider.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_slides() {
		if ( ! isset( $this->slides ) ) {
			$this->slides = get_post_meta( $this->ID, 'slides', true );
		}

		return trim( $this->slides );
	}

	/**
	 * Getting captions of slider.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_captions() {
		if ( ! isset( $this->captions ) ) {
			$this->captions = get_post_meta( $this->ID, 'captions', true );
			if ( ! is_array( $this->captions ) ) {
				$this->captions = array();
			}
		}

		return $this->captions;
	}

	/**
	 * Returning fonts of captions.
	 *
	 * @since  1.0.0
	 * @return array  array of captions fotns.
	 */
	public function get_captions_font() {
		if ( ! isset( $this->captions_fonts ) ) {
			$captions             = $this->get_captions();
			$this->captions_fonts = array();
			if ( count( $captions ) ) {
				foreach ( $captions as $slide => $caption ) {
					foreach ( $caption as $caption_detail ) {
						if ( $caption_detail['font_family'] ) {
							$font_options = 'normal' !== $caption_detail['font_weight'] ? $caption_detail['font_weight'] : '';
							if ( 'italic' === $caption_detail['font_style'] ) {
								$font_options .= $caption_detail['font_style'];
							}
							if ( ! isset( $this->captions_fonts[ $caption_detail['font_family'] ] ) ) {
								$this->captions_fonts[ $caption_detail['font_family'] ] = array(
									'font_family'  => $caption_detail['font_family'],
									'font_options' => array( $font_options ),
								);
							}
							// Merging font options.
							else {
								if ( ! in_array( $font_options,
									$this->captions_fonts[ $caption_detail['font_family'] ]['font_options'] ) ) {
									array_push( $this->captions_fonts[ $caption_detail['font_family'] ]['font_options'], $font_options );
								}
							}
						}
					}
				}
			}
		}
		return $this->captions_fonts;
	}

	/**
	 * Getting type of slider.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_type() {
		if ( ! isset( $this->type ) ) {
			$this->type = get_post_meta( $this->ID, 'slider_type', true );
			$slider_types = array_keys( $this->get_types() );
			// Sanitize the type.
			if ( ! in_array( $this->type, $slider_types ) ) {
				// Using default value for type.
				$this->type = 'images';
			}
		}

		return $this->type;
	}

	/**
	 * Getting all possible types of slider.
	 *
	 * @since 1.0.0
	 * @return array
	 */
	public function get_types() {
		return apply_filters( 'els_slider_types', array(
			'images'          => __( 'Images', 'els' ),
			'listings'        => __( 'Listings', 'els' ),
			'listings_images' => __( 'Listings And Images', 'els' )
		) );
	}

	/**
	 * Getting theme of slider.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_theme() {
		if ( ! isset( $this->theme ) ) {
			$this->theme = get_post_meta( $this->ID, 'slider_theme', true );
			if ( empty( $this->theme ) ) {
				// Using full-width as default slider theme.
				$this->theme = 'full-width';
			}
		}

		return $this->theme;
	}

	/**
	 * Getting all of slider themes.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_themes() {
		return apply_filters( 'els_slider_themes', array(
			'thumbnail'    => __( 'Thumbnail', 'els' ),
			'full-width'   => __( 'Full Width', 'els' ),
			'introduction' => __( 'Introduction', 'els' ),
		) );
	}

	/**
	 * Getting container HTML element id attribute of the slider.
	 *
	 * @since  1.0.0
	 * @return string
	 */
	public function get_container_id() {
		if ( ! isset( $this->container_id ) ) {
			$this->container_id = get_post_meta( $this->ID, 'slider_container_id', true );
		}

		return trim( $this->container_id );
	}

	/**
	 * Getting width of slider.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function get_width() {
		if ( ! isset( $this->width ) ) {
			$this->width = (int) get_post_meta( $this->ID, 'slider_width', true );
			// Sanitize the width.
			if ( $this->width <= 0 ) {
				// Using defalut value for width.
				$this->width = 800;
			}
		}

		return $this->width;
	}

	/**
	 * Getting height of slider.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function get_height() {
		if ( ! isset( $this->height ) ) {
			$this->height = (int) get_post_meta( $this->ID, 'slider_height', true );
			// Sanitize the height.
			if ( $this->height <= 0 ) {
				// Using defalut value for height.
				$this->height = 480;
			}
		}

		return $this->height;
	}

	/**
	 * Getting fill mode feature of slider.
	 *
	 * @since  1.0.0
	 * @return int
	 */
	public function get_fill_mode() {
		if ( ! isset( $this->fill_mode ) ) {
			$this->fill_mode = get_post_meta( $this->ID, 'slider_fill_mode', true );
		}

		return absint( $this->fill_mode );
	}

	/**
	 * Getting auto play feature of slider.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public function get_auto_play() {
		if ( ! isset( $this->auto_play ) ) {
			$this->auto_play = get_post_meta( $this->ID, 'auto_play', true );
			// Sanitize the auto play.
			$this->auto_play = '0' === $this->auto_play ? false : true;
		}

		return $this->auto_play;
	}

	/**
	 * Getting auto play interval of slider.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function get_auto_play_interval() {
		if ( ! isset( $this->auto_play_interval ) ) {
			$this->auto_play_interval = (int) get_post_meta( $this->ID, 'autoplay_interval', true );
			// Sanitize auto_play_interval
			if ( $this->auto_play_interval <= 0 ) {
				// Using defalut value for auto_play_interval.
				$this->auto_play_interval = 4000;
			}
		}

		return $this->auto_play_interval;
	}

	/**
	 * Getting slide duration of slider.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function get_slide_duration() {
		if ( ! isset( $this->slide_duration ) ) {
			$this->slide_duration = (int) get_post_meta( $this->ID, 'slide_duration', true );
			// Sanitize slide_duration
			if ( $this->slide_duration <= 0 ) {
				// Using defalut value for slide_duration.
				$this->slide_duration = 500;
			}
		}

		return $this->slide_duration;
	}

	/**
	 * Getting loop type of slider.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function get_loop() {
		if ( ! isset( $this->loop ) ) {
			$this->loop = get_post_meta( $this->ID, 'loop', true );
			// Sanitize loop
			if ( ! in_array( $this->loop, array( '0', '1', '2' ) ) ) {
				// Using defalut value for loop.
				$this->loop = 1;
			}
		}

		return (int) $this->loop;
	}

	/**
	 * Getting drag orientation of slider.
	 *
	 * @since 1.0.0
	 * @return int
	 */
	public function get_drag_orientation() {
		if ( ! isset( $this->drag_orientation ) ) {
			$this->drag_orientation = get_post_meta( $this->ID, 'drag_orientation', true );
			// Sanitize drag_orientation
			if ( ! in_array( $this->drag_orientation, array( '0', '1', '2', '3' ) ) ) {
				// Using defalut value for drag_orientation.
				$this->drag_orientation = 3;
			}
		}

		return (int) $this->drag_orientation;
	}

}
