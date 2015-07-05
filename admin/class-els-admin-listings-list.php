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
	private $paged;				// Page number that should be shown.
	private $listing_type;		// Type of listings to load.
	private $listing_status;	// Status of listings to load.
	private $listing_special;	// Special listings to load like( featured ) listings.
	private $listings;			// Filtered listings that should be shown.

	/**
	 * Constructor of the ELS_Admin_Listings_List
	 *
	 * @since 1.0.0
	 * @param integer $posts_per_page
	 * @param integer $paged
	 * @param string  $listing_type
	 * @param string  $listing_status
	 * @param string  $listing_special
	 */
	public function __construct( $posts_per_page = 3, $paged = 1, $listing_type = 'all', $listing_status = 'all',
		$listing_special = 'all' ) {

		$this->posts_per_page  = absint( $posts_per_page );
		$this->paged           = absint( $paged );
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
		$this->posts_per_page = 3;
		if ( (int) $posts_per_page > 0 ) {
			$this->posts_per_page = (int) $posts_per_page;
		}
	}

	/**
	 * Setting page number that should be load.
	 *
	 * @since 1.0.0
	 * @param int $paged
	 */
	public function set_paged( $paged ) {
		$this->paged = 1;
		if ( absint( $paged ) > 0 ) {
			$this->paged = absint( $paged );
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
		$listing_types = epl_get_active_post_types();
		$listing_types = array_keys( $listing_types );
		if ( ! empty( $listing_type ) && in_array( $listing_type, $listing_types ) ) {
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
		$listings_status = ELS_IOC::make( 'listings' )->get_listings_status();
		$listings_status = array_keys( $listings_status );
		if ( ! empty( $listing_status ) && in_array( $listing_status, $listings_status ) ) {
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
		$this->listing_special = 'all';
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
				'paged'			 => $this->paged,
			);

			// Setting post_type of WP_Query
			$filter_args['post_type'] = 'all' === $this->listing_type ?
				array_keys( $listing_types ) : $this->listing_type;

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

		$args = array(
			'listings_status'         => ELS_IOC::make( 'listings' )->get_listings_status(),
			'listings_type'           => epl_get_active_post_types(),
			'listings'                => $this->listings,
			'current_listing_type'    => $this->listing_type,
			'current_listing_status'  => $this->listing_status,
			'current_listing_special' => $this->listing_special,
			'current_posts_per_page'  => $this->posts_per_page,
		);
		// Rendering header.
		$this->render_view( 'listings-list.header', array( 'css_url' => $this->get_css_url() ) );
		// Rendering filter bar for filtering listings.
		$this->render_view( 'listings-list.filter', $args );
		// Rendering list view or empty view.
		$this->render_view( "listings-list.$view", ( 'empty' !== $view ? $args : array() ) );
		// Rendering footer.
		$this->render_view( 'listings-list.footer', array(
			'js_url' => $this->get_js_url(),
			'includes_url' => includes_url()
		) );
	}

}
