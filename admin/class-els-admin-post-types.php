<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class responsible for Post Types related functionalities of the plugin.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Post_Types {

	/**
	 * Constructor of post type registerer.
	 *
	 * @since 1.0.0
	 * @param ELS_Loader $loader
	 */
	public function __construct( ELS_Loader $loader ) {
		$loader->add_action( 'init', $this, 'register_post_types' );

		// Custom columns hooks.
		$loader->add_filter( 'manage_edit-els_slider_columns', $this, 'els_slider_columns' );
		$loader->add_action( 'manage_els_slider_posts_custom_column', $this, 'render_els_slider_columns', 10, 2 );
	}

	/**
	 * Registerring post types of the plugin.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function register_post_types() {
		if ( post_type_exists( 'els_slider' ) ) {
			return;
		}

		do_action( 'els_register_post_type' );

		register_post_type( 'els_slider',
			apply_filters( 'els_register_post_type_slider',
				array(
					'labels'              => array(
							'name'               => __( 'Sliders', 'els' ),
							'singular_name'      => __( 'Slider', 'els' ),
							'menu_name'          => _x( 'Sliders', 'Admin menu name', 'els' ),
							'add_new'            => __( 'Add Slider', 'els' ),
							'add_new_item'       => __( 'Add New Slider', 'els' ),
							'edit'               => __( 'Edit', 'els' ),
							'edit_item'          => __( 'Edit Slider', 'els' ),
							'new_item'           => __( 'New Slider', 'els' ),
							'view'               => __( 'View Slider', 'els' ),
							'view_item'          => __( 'View Slider', 'els' ),
							'search_items'       => __( 'Search Sliders', 'els' ),
							'not_found'          => __( 'No Sliders found', 'els' ),
							'not_found_in_trash' => __( 'No Sliders found in trash', 'els' ),
							'parent'             => __( 'Parent Slider', 'els' )
					),
					'show_ui'         => true,
					'map_meta_cap'    => true,
					'hierarchical'    => false,
					'has_archive'     => false,
					'rewrite'         => false,
					'query_var'       => false,
					'supports'        => apply_filters( 'els_slider_support', array( 'title' ) ),
					'menu_icon'		  => 'dashicons-slides',
				)
			)
		);
	}

	/**
	 * Custom columns of slider.
	 *
	 * @since 1.0.0
	 * @param  array $columns
	 * @return array $columns
	 */
	public function els_slider_columns( $columns ) {
		$columns = array(
			'cb'        => '<input type="checkbox"/>',
			'title'     => __( 'Name', 'els' ),
			'shortcode' => __( 'Shortcode', 'els' ),
			'slides'    => __( 'Slides', 'els' ),
			'type'		=> __( 'Type', 'els' ),
			'action'	=> __( 'Action', 'els' ),
			'date'      => __( 'Date', 'els' )
		);

		return apply_filters( 'els_slider_columns', $columns );
	}

	/**
	 * Rendering content of custom columns of slider.
	 *
	 * @since 1.0.0
	 * @param  string $column
	 * @param  int $post_id
	 * @return void
	 */
	public function render_els_slider_columns( $column, $post_id ) {
		if ( 'els_slider' === get_post_type( $post_id ) ) {
			$slider = new ELS_Slider( $post_id );
			switch ( $column ) {
				case 'shortcode' :
					echo '[els_slider id="' . $post_id . '"]';
					break;

				case 'slides' :
					$slides = $slider->get_slides();
					if ( strlen( $slides ) ) {
						$slides = array_filter( explode( ',', $slides ) );
						echo count( $slides ) > 0 ? count( $slides ) : 0;
					} else {
						echo 0;
					}
					break;

				case 'type' :
					$slider_type = $slider->get_type();
					if ( strlen( $slider_type ) ) {
						$types = $slider->get_types();
						echo $types[ $slider_type ];
					}
					break;

				case 'action' :
					echo '<a class="slider-preview-action button button-primary button-large" href="' .
						esc_url( admin_url( '/options.php?page=els_slider_preview&noheader&slider=' . urlencode( $post_id ) ) ) . '" data-text="' .
						__( 'Preview Slider', 'els' ) . '" data-id="' . (int) $post_id . '">'
						. __( 'Preview', 'els' ) . '</a>';
					break;

				default:
					break;
			}
		}
	}

}
