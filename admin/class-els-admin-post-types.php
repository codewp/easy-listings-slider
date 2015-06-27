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
					'supports'        => apply_filters( 'els_slider_support', array( 'title' ) )
				)
			)
		);
	}

}
