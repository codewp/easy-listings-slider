<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.asanaplugins.com/
 * @since             1.0.0
 * @package           Easy_Listings_Slider
 *
 * @wordpress-plugin
 * Plugin Name:       Easy Listings Slider
 * Plugin URI:        http://www.asanaplugins.com/
 * Description:       Easy to use and advanced slider extension for Easy Property Listings plugin.
 * Version:           1.0.1
 * Author:            Asana Plugins
 * Author URI:        http://www.asanaplugins.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       els
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-els-activator.php
 */
function activate_easy_listings_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-els-activator.php';
	ELS_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-els-deactivator.php
 */
function deactivate_easy_listings_slider() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-els-deactivator.php';
	ELS_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_easy_listings_slider' );
register_deactivation_hook( __FILE__, 'deactivate_easy_listings_slider' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-easy-listings-slider.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_easy_listings_slider() {
	if ( ! class_exists( 'Easy_Property_Listings' ) ) {
		if ( ! class_exists( 'EPL_Extension_Activation' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'includes/class-epl-extension-activation.php';
		}
		$activation = new EPL_Extension_Activation( plugin_basename( __FILE__ ) );
		$activation->run();
	} else {
		$plugin = new Easy_Listings_Slider();
		$plugin->run();
	}
}
add_action( 'plugins_loaded', 'run_easy_listings_slider' );
