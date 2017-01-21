<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.asanaplugins.com/
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
		 * The class responsible for admin editor functionalities.
		 */
		require_once $this->get_path() . 'class-els-admin-editor.php';
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
		/**
		 * Welcome pages controller of the plugin.
		 */
		require_once $this->get_path() . 'class-els-admin-welcome.php';
	}

	/**
	 * Defining hooks of plugin admin area.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function define_hooks() {
		// Actions.
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $this, 'enqueue_scripts' );
		// Filters.
		$this->loader->add_filter( 'plugin_row_meta', $this, 'plugin_row_meta_links', 10, 2 );
		// Rate us on wordpress.org.
		$this->loader->add_filter( 'admin_footer_text', $this, 'rate_us' );

		// Hooks for post types.
		new ELS_Admin_Post_types( $this->loader );
		// Hooks for meta boxes.
		new ELS_Admin_Meta_Boxes( $this->loader );
		// Hooks for admin notices.
		new ELS_Admin_Notices( $this->loader );
		// Hooks for preview slider in admin-area.
		new ELS_Admin_Slider_Preview( $this->loader );
		// Hooks for admin editor.
		new ELS_Admin_Editor( $this->loader );
		// Hooks for plugin admin menus.
		$this->menu_manager = new ELS_Admin_Menu( $this->loader );
		// Hooks for welcome pages of the plugin.
		new ELS_Admin_Welcome( $this->loader, $this->version );
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

		$epl_active_post_types = epl_get_active_post_types();
		if ( count( $epl_active_post_types ) )  {
			$epl_active_post_types = array_keys( epl_get_active_post_types() );
			if ( in_array( $typenow, $epl_active_post_types ) ) {
				$return = true;
			}
		}

		// Slider type admin page.
		if ( 'els_slider' === $typenow ) {
			$return = true;
		}

		// Welcome pages of the plugin.
		if ( 'dashboard_page_els-getting-started' === $screen->id ) {
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
		wp_enqueue_style( 'els_admin_notices', plugin_dir_url( __FILE__ ) . 'css/els-admin-notices' . $suffix . '.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'thickbox' );
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
		}
		wp_enqueue_script( 'thickbox' );

		// Loading only in els_slider post types.
		if ( 'els_slider' === $typenow ) {
			// wordpress Color Picker.
			wp_enqueue_script( 'wp-color-picker' );
		}

		wp_enqueue_script( 'jquery-tiptip', plugin_dir_url( __FILE__ ) . 'js/jquery-tiptip/jquery.tipTip' . $suffix . '.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'els-admin-globals', plugin_dir_url( __FILE__ ) . 'js/els-admin-globals' . $suffix . '.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/els-admin' . $suffix . '.js', array( 'jquery' ), $this->version, false );
		wp_localize_script( $this->plugin_name, 'elsAdminData', array( 'subscribe_nonce' => wp_create_nonce( 'subscribe_email_send' ) ) );
	}

	/**
	 * Plugin row meta links
	 * This function adds additional links below the plugin in admin plugins page.
	 *
	 * @since  1.0.0
	 * @param  array  $links 	The array having default links for the plugin.
	 * @param  string $file 	The name of the plugin file.
	 * @return array  $links 	Plugin default links and specific links.
	 */
	public function plugin_row_meta_links( $links, $file ) {
		if ( false !== strpos( $file, 'easy-listings-slider.php' ) ) {
			$plugin_links = array(
				'<a href="' . admin_url( 'index.php?page=els-getting-started' ) . '">' . esc_html__( 'Getting Started', 'els' ) . '</a>',
			);
			$links = array_merge( $links, $plugin_links );
		}

		return $links;
	}

	/**
	 * Add rating links to the admin dashboard
	 *
	 * @since  1.0.0
	 * @param  string $footer_text The existing footer text
	 * @return string
	 */
	public function rate_us( $footer_text ) {
		if ( ! $this->is_admin_page() ) {
			return $footer_text;
		}

		$rate_text = sprintf( __( 'Thank you for using <strong>Easy Listings Slider</strong>! Please <a href="%1$s" target="_blank">rate us</a> on <a href="%1$s" target="_blank">WordPress.org</a>', 'els' ),
			'https://wordpress.org/support/view/plugin-reviews/easy-listings-slider?filter=5#postform'
		);

		return str_replace( '</span>', '', $footer_text ) . ' | ' . $rate_text . '</span>';
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
