<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/admin
 * @author     taher.atashbar@gmail.com
 */
class ELS_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      ELS_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	private $loader;

	/**
	 * Menu manger of the plugin admin area.
	 *
	 * @since 1.0.0
	 * @access private
	 * @var ELS_Admin_Menu
	 */
	private $menu_manager;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, ELS_Loader $loader ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->loader      = $loader;

		$this->load_dependencies();
	}

	/**
	 * Loading amin area dependencies.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function load_dependencies() {
		/**
		 * The controller class of admin area.
		 */
		require_once $this->get_path() . 'class-els-admin-controller.php';
		/**
		 * The class responsible for Post Types related functionalities of the plugin.
		 */
		require_once $this->get_path() . 'class-els-admin-post-types.php';
		/**
		 * The class responsible for list Listings.
		 */
		require_once $this->get_path() . 'class-els-admin-listings-list.php';
		/**
		 * The class responsible for Meta Boxes of the plugin.
		 */
		require_once $this->get_path() . 'class-els-admin-meta-boxes.php';
		/**
		 * The class responsible for creating menus of the plugin.
		 */
		require_once $this->get_path() . 'class-els-admin-menu.php';
		/**
		 * The class responsible for showing notices in admin area.
		 */
		require_once $this->get_path() . 'class-els-admin-notices.php';
		/**
		 * The class responsible for preview sliders in admin area.
		 */
		require_once $this->get_path() . 'class-els-admin-slider-preview.php';
	}

	/**
	 * Defining hooks of plugin admin area.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function define_hooks() {
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );

		// Hooks for post types.
		new ELS_Admin_Post_types( $this->loader );
		// Hooks for meta boxes.
		new ELS_Admin_Meta_Boxes( $this->loader );
		// Hooks for admin notices.
		new ELS_Admin_Notices( $this->loader );
		// Hooks for preview slider in admin-area.
		new ELS_Admin_Slider_Preview( $this->loader );
		// Hooks for plugin admin menus.
		$this->menu_manager = new ELS_Admin_Menu( $this->loader );
	}

	/**
	 * Determines whether the current admin page is an ELM admin page.
	 *
	 * Only works after the `wp_loaded` hook, & most effective
	 * starting on `admin_menu` hook.
	 *
	 * @since 1.0.0
	 * @return boolean
	 */
	public function is_admin_page() {
		if ( ! is_admin() || ! did_action( 'wp_loaded' ) ) {
			return false;
		}
		global $typenow;

		$return = false;
		$screen = get_current_screen();

		$epl_active_post_types = array_keys( epl_get_active_post_types() );
		if ( count( $epl_active_post_types ) )  {
			if ( in_array( $typenow, $epl_active_post_types ) ) {
				$return = true;
			}
		}

		// Slider type admin page.
		if ( 'els_slider' === $typenow ) {
			$return = true;
		}

		return (bool) apply_filters( 'els_is_admin_page', $return );
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 * @param string
	 */
	public function enqueue_styles( $hook ) {
		if ( ! apply_filters( 'els_load_admin_scripts', $this->is_admin_page(), $hook ) ) {
			return;
		}

		global $wp_version, $typenow;

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/els-admin' . $suffix . '.css', array(), $this->version, 'all' );
		if ( ! function_exists( 'wp_enqueue_media' ) || version_compare( $wp_version, '3.5', '<' ) ) {
			wp_enqueue_style( 'thickbox' );
		}

		// Loading only in els_slider post types.
		if ( 'els_slider' === $typenow ) {
			// jQueryUi.
			wp_enqueue_style( 'jquery-ui-css', plugin_dir_url( __FILE__ ) . 'css/jquery-ui/jquery-ui' . $suffix . '.css' );
			wp_enqueue_style( 'jquery-ui-theme', plugin_dir_url( __FILE__ ) . 'css/jquery-ui/jquery-ui-theme' . $suffix . '.css' );
			// wordpress Color Picker.
			wp_enqueue_style( 'wp-color-picker' );
			// editor.css for tinymce.
			wp_enqueue_style( 'editor-buttons' );
		}
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 * @param string
	 */
	public function enqueue_scripts( $hook ) {
		if ( ! apply_filters( 'els_load_admin_scripts', $this->is_admin_page(), $hook ) ) {
			return;
		}

		global $wp_version, $typenow;

		// Use minified libraries if SCRIPT_DEBUG is turned off
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// Including media libraries based on Wordpress version.
		if ( function_exists( 'wp_enqueue_media' ) && version_compare( $wp_version, '3.5', '>=' ) ) {
			//call for new media manager
			wp_enqueue_media();
		} else {
			wp_enqueue_script( 'media-upload' );
			wp_enqueue_script( 'thickbox' );
		}

		// Loading only in els_slider post types.
		if ( 'els_slider' === $typenow ) {
			// wordpress Color Picker.
			wp_enqueue_script( 'wp-color-picker' );
		}

		wp_enqueue_script( 'els-admin-globals', plugin_dir_url( __FILE__ ) . 'js/els-admin-globals' . $suffix . '.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/els-admin' . $suffix . '.js', array( 'jquery' ), $this->version, false );
	}

	/**
	 * Getting version.
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Getting loader of ELS.
	 *
	 * @since 1.0.0
	 * @return ELS_Loader
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Getting url of admin area.
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	public function get_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Getting path of admin area.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_path() {
		return plugin_dir_path( __FILE__ );
	}

}
