<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.asanaplugins.com/
 * @since      1.0.0
 *
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Easy_Listings_Slider
 * @subpackage Easy_Listings_Slider/includes
 * @author     taher.atashbar@gmail.com
 */
class Easy_Listings_Slider {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      ELS_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'easy-listings-slider';
		$this->version = '1.0.1';

		$this->load_dependencies();
		$this->define_globals();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - ELS_Loader. Orchestrates the hooks of the plugin.
	 * - ELS_i18n. Defines internationalization functionality.
	 * - ELS_Admin. Defines all hooks for the admin area.
	 * - ELS_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once $this->get_path() . 'includes/class-els-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $this->get_path() . 'includes/class-els-i18n.php';

		/**
		 * The class responsible for inversion of control (IOC) of the plugin.
		 */
		require_once $this->get_path() . 'includes/class-els-ioc.php';

		/**
		 * The class responsible for validation.
		 */
		require_once $this->get_path() . 'includes/class-els-validator.php';

		/**
		 * The class responsible for managing plugin assets.
		 */
		require_once $this->get_path() . 'includes/class-els-asset-manager.php';

		/**
		 * The class responsible for plugin settigns.
		 */
		require_once $this->get_path() . 'includes/class-els-settings.php';

		/**
		 * The class responsible for managing plugin fonts.
		 */
		require_once $this->get_path() . 'includes/class-els-font-manager.php';

		/**
		 * The class responsible for plugin HTML elements render.
		 */
		require_once $this->get_path() . 'includes/class-els-html-elements.php';

		/**
		 * The class that contains functions that are common between listings.
		 */
		require_once $this->get_path() . 'includes/class-els-listings.php';

		/**
		 * Apis that are common between sliders.
		 */
		require_once $this->get_path() . 'includes/class-els-sliders.php';

		/**
		 * The Slider Object class.
		 */
		require_once $this->get_path() . 'includes/class-els-slider.php';

		/**
		 * The Factory class for sliders.
		 */
		require_once $this->get_path() . 'includes/class-els-slider-factory.php';

		/**
		 * The class responsible for creating RGBA colors.
		 */
		require_once $this->get_path() . 'includes/color/class-els-color-rgba.php';

		/**
		 * The class responsible for converting colors.
		 */
		require_once $this->get_path() . 'includes/class-els-color-converter.php';

		/**
		 * Base controller class of the plugin.
		 */
		require_once $this->get_path() . 'includes/class-els-controller.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once $this->get_path() . 'admin/class-els-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once $this->get_path() . 'public/class-els-public.php';

		$this->loader = new ELS_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the ELS_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new ELS_i18n();
		$plugin_i18n->set_domain( $this->get_plugin_name() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {
		/**
		 * All of admin hooks are defined in define_hooks() of ELS_Admin.
		 */
		$plugin_admin = ELS_IOC::make( 'plugin_admin' );
		$plugin_admin->define_hooks();
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		/**
		 * All of public hooks are defined in define_hooks() of ELS_Public.
		 */
		$plugin_public = ELS_IOC::make( 'plugin_public' );
		$plugin_public->define_hooks();
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    ELS_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Getting path of include area.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_path() {
		return plugin_dir_path( dirname( __FILE__ ) );
	}

	/**
	 * Defining objects that should be accessed globally.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function define_globals() {
		ELS_IOC::bind( 'validator', new ELS_Validator() );
		ELS_IOC::bind( 'asset_manager', new ELS_Asset_Manager() );
		ELS_IOC::bind( 'font_manager', new ELS_Font_Manager() );
		ELS_IOC::bind( 'html', new ELS_HTML_Elements() );
		ELS_IOC::bind( 'settings', new ELS_Settings() );
		ELS_IOC::bind( 'slider_factory', new ELS_Slider_Factory() );
		ELS_IOC::bind( 'listings', new ELS_Listings() );
		ELS_IOC::bind( 'plugin_admin', new ELS_Admin( $this->plugin_name, $this->version, $this->loader ) );
		ELS_IOC::bind( 'plugin_public', new ELS_Public( $this->plugin_name, $this->version, $this->loader ) );
	}

}
