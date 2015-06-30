<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The class responsible for list Listings.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Admin_Listings_List extends ELS_Admin_Controller {

	private $posts_per_page;	// Number of listings for each page.
	private $listing_type;		// Type of listings to load.
	private $listing_status;	// Status of listings to load.
	private $listing_special;	// Special listings to load like( featured ) listings.
	private $listings;			// Filtered listings that should be shown.

	/**
	 * Constructor of the ELS_Admin_Listings_List
	 *
	 * @since 1.0.0
	 * @param integer $posts_per_page
	 * @param string  $listing_type
	 * @param string  $listing_status
	 * @param string  $listing_special
	 */
	public function __construct( $posts_per_page = 10, $listing_type = 'all', $listing_status = 'all',
		$listing_special = 'featured' ) {
		$this->posts_per_page  = (int) $posts_per_page;
		$this->listing_type    = $listing_type;
		$this->listing_status  = $listing_status;
		$this->listing_special = $listing_special;
	}

	/**
	 * Setting number of listings for each page.
	 *
	 * @since 1.0.0
	 * @param int $posts_per_page
	 */
	public function set_posts_per_page( $posts_per_page ) {
		$this->posts_per_page = 10;
		if ( (int) $posts_per_page > 0 ) {
			$this->posts_per_page = (int) $posts_per_page;
		}
	}

	/**
	 * Setting type of listings that should be listed.
	 *
	 * @since 1.0.0
	 * @param string $listing_type
	 */
	public function set_listing_type( $listing_type ) {
		$this->listing_type = 'all';
		if ( ! empty( $listing_type ) ) {
			$this->listing_type = $listing_type;
		}
	}

	/**
	 * Setting status of listings that should be listed.
	 *
	 * @since 1.0.0
	 * @param string $listing_status
	 */
	public function set_listing_status( $listing_status ) {
		$this->listing_status = 'all';
		if ( ! empty( $listing_status ) ) {
			$this->listing_status = $listing_status;
		}
	}

	/**
	 * Setting special listings to load like loading featured listings.
	 *
	 * @since 1.0.0
	 * @param string $listing_special
	 */
	public function set_listing_special( $listing_special ) {
		$this->listing_special = 'featured';
		if ( ! empty( $listing_special ) && in_array( $listing_special, array( 'all', 'featured' ) ) ) {
			$this->listing_special = $listing_special;
		}
	}

	/**
	 * Filtering listings that should be shown based on request.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function filter() {
		$listing_types = epl_get_active_post_types();
		if ( count( $listing_types ) ) {
			$filter_args = array(
				'posts_per_page' => $this->posts_per_page,
				'orderby'        => 'date',
				'order'          => 'ASC',
				'paged'			 => get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1,
			);

			// Setting post_type of WP_Query
			$filter_args['post_type'] = 'all' === $this->listing_type ? array_keys( $listing_types ) : $this->listing_type;

			// Loading special listings if it is not all.
			if ( 'all' !== $this->listing_special ) {
				$filter_args['meta_query'][] = array(
					'key'     => 'property_featured',
					'value'   => 'yes',
					'compare' => 'IN',
				);
			}

			// Loading listings based on status if it is not all.
			if ( 'all' !== $this->listing_status ) {
				$filter_args['meta_query'][] = array(
					'key'     => 'property_status',
					'value'   => $this->listing_status,
					'compare' => 'IN',
				);
			}

			$this->listings = new WP_Query( $filter_args );
		}
	}

	/**
	 * Displaying filtered listings based on request.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function display() {
		$this->filter();
		/**
		 * Choosing between empty view and list view.
		 * When there is not any listing to show user empty view otherwise use list view.
		 */
		$view = 'empty';
		if ( $this->listings instanceof WP_Query ) {
			if ( $this->listings->have_posts() ) {
				$view = 'list';
			}
		}

		$args = array();
		if ( 'empty' !== $view ) {
			$listings_status = apply_filters( 'epl_opts_property_status_filter', array(
				'current'	=>	__( 'Current', 'epl' ),
				'withdrawn'	=>	__( 'Withdrawn', 'epl' ),
				'offmarket'	=>	__( 'Off Market', 'epl' ),
				'sold'		=>	array(
					'label'		=>	__( 'Sold', 'epl' ),
					'exclude'	=>	array( 'rental' )
				),
				'leased'	=>	array(
					'label'		=>	__( 'Leased', 'epl' ),
					'include'	=>	array( 'rental', 'commercial', 'commercial_land', 'business' )
				)
			) );
			foreach ( $listings_status as $key => $value ) {
				if ( is_array( $value ) ) {
					$listings_status[ $key ] = $value['label'];
				}
			}

			$args = array(
				'listings'        => $this->listings,
				'listings_status' => $listings_status,
			);
		}
		$this->render_view( "listings-list.$view", $args );
	}

}
