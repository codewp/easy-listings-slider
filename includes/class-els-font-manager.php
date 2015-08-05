<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Font Manager of the plugin.
 *
 * @link
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     Taher Atashbar <taher.atashbar@gmail.com>
 */

class ELS_Font_Manager {

	/**
	 * Getting Google WebFonts from google api url.
	 *
	 * @since  1.0.0
	 * @param  string $key
	 * @param  string $sort
	 * @return array
	 */
	public function get_google_webfonts( $key = 'AIzaSyA1Q0uFOhEh3zv_Pk31FqlACArFquyBeQU', $sort = 'alpha' ) {
		if ( $font_list = get_site_transient( 'els-google-fonts' ) ) {
			return $font_list;
		}

		$google_api_url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=' . $key . '&sort=' . $sort;

		$response = wp_remote_retrieve_body( wp_remote_get( $google_api_url, array( 'sslverify' => false ) ) );

		if ( ! is_wp_error( $response ) ) {
			$data = json_decode( $response, true );
		}

		if ( ! empty( $data['errors'] ) || empty( $data['items'] ) ) {
			$data = $this->get_default_google_webfonts();
		}

		$font_list = array();

		if ( count( $data['items'] ) ) {
			foreach ( $data['items'] as $item ) {
				$font_list[ $item['family'] ] = $item;
			}
		}

		$week_in_seconds = defined( 'WEEK_IN_SECONDS' ) && WEEK_IN_SECONDS ? WEEK_IN_SECONDS : 60 * 60 * 24 * 7;
		set_site_transient( 'els-google-fonts', $font_list, 4 * $week_in_seconds );
		return $font_list;
	}

	/**
	 * Getting Google WebFonts from json google-fonts file as default Google WebFonts.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_default_google_webfonts() {
		$json_data = file_get_contents( ELS_IOC::make( 'asset_manager' )->get_public_fonts() . 'google-fonts.json' );
		return json_decode( $json_data, true );
	}

	/**
	 * Getting Google font families.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_google_font_family() {
		$font_list = $this->get_google_webfonts();
		$fonts = array();
		if ( count( $font_list ) ) {
			foreach ( $font_list as $font_family => $font ) {
				$fonts[ $font_family ] = $font_family;
			}
		}
		return $fonts;
	}

	/**
	 * Getting font families.
	 *
	 * @since  1.0.0
	 * @return array
	 */
	public function get_font_family() {
		return apply_filters('els_font_family',
			array_merge(
				array(
					__( 'Use Your Themes', 'popup-maker' )	=> 'inherit',
					__( 'Sans-Serif', 'popup-maker' )		=> 'Sans-Serif',
					__( 'Tahoma', 'popup-maker' )			=> 'Tahoma',
					__( 'Georgia', 'popup-maker' )			=> 'Georgia',
					__( 'Comic Sans MS', 'popup-maker' )	=> 'Comic Sans MS',
					__( 'Arial', 'popup-maker' )			=> 'Arial',
					__( 'Lucida Grande', 'popup-maker' )	=> 'Lucida Grande',
					__( 'Times New Roman', 'popup-maker' )	=> 'Times New Roman',
				), $this->get_google_font_family() )
		);
	}

}
