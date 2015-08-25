<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * APIs that are common in sliders.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     taher.atashbar@gmail.com
 */

class ELS_Sliders {

	/**
	 * Getting sliders.
	 *
	 * @since  1.0.0
	 * @return array $sliders with id and title for each slider.
	 */
	public function get_sliders() {
		$sliders = array();
		$query = new WP_Query( array(
			'post_type'   => 'els_slider',
			'post_status' => 'publish',
		) );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$post = $query->next_post();
				$sliders[ $post->ID ] = array(
					'id'    => $post->ID,
					'title' => $post->post_title,
				);
			}
			wp_reset_postdata();
		}
		return $sliders;
	}

}
