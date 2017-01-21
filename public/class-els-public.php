<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/public
 * @author     taher.atashbar@gmail.com
 */
class ELS_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 * @param      ELS_Loader $loader
	 */
	public function __construct( $plugin_name, $version, ELS_Loader $loader ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->loader      = $loader;

		$this->load_dependencies();
		$this->define_globals();
	}

	/**
	 * Loading dependencies that required in public-facing area.
	 *
	 * @since 1.0.0
	 */
	private function load_dependencies() {
		/**
		 * The controller class of public-facing area.
		 */
		require_once $this->get_path() . 'class-els-public-controller.php';
		/**
		 * Base class for sliders.
		 */
		require_once $this->get_path() . 'class-els-public-slider-base.php';
		/**
		 * PHP class for Jssor javascript slider plugin.
		 */
		require_once $this->get_path() . 'class-els-public-jssor-slider.php';
		/**
		 * The class responsible for displaying slider in single listing page.
		 */
		require_once $this->get_path() . 'class-els-public-single-slider.php';
		/**
		 * Slider shortcode.
		 */
		require_once $this->get_path() . 'shortcodes/class-els-shortcode-slider.php';
	}

	/**
	 * Defining hooks of plugin public-facing.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function define_hooks() {
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts' );

		// Hook for single listing page slider.
		new ELS_Public_Single_Slider( $this->loader );

		// Shortcodes.
		$this->loader->add_shortcode( 'els_slider', new ELS_Shortcode_Slider(), 'output' );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ELS_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ELS_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in ELS_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The ELS_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

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
	 * Getting url of public-facing area.
	 *
	 * @since   1.0.0
	 * @return  string
	 */
	public function get_url() {
		return plugin_dir_url( __FILE__ );
	}

	/**
	 * Getting path of public-facing area.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_path() {
		return plugin_dir_path( __FILE__ );
	}

	/**
	 * Defining objects that should be accessed globally.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function define_globals() {
		ELS_IOC::bind( 'els_public_controller', new ELS_Public_Controller() );
	}

}
