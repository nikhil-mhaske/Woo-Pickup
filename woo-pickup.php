<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://nikhil.wisdmlabs.net
 * @since             1.0.0
 * @package           Woo_Pickup
 *
 * @wordpress-plugin
 * Plugin Name:       Woo Pickup
 * Plugin URI:        https://nikhil.wisdmlabs.net
 * Description:       Enhancing the Local pickup facility in WooCommerce.
Features:
1. Local Pickup option
2. Select from multiple stores
3. Select Pickup Date
4. Email on Order Confirmation
5. Reminder Email before one day of Pickup Date
 * Version:           1.0.0
 * Author:            Nikhil
 * Author URI:        https://nikhil.wisdmlabs.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-pickup
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'WOO_PICKUP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-pickup-activator.php
 */
function activate_woo_pickup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-pickup-activator.php';
	Woo_Pickup_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-pickup-deactivator.php
 */
function deactivate_woo_pickup() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-pickup-deactivator.php';
	Woo_Pickup_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_woo_pickup' );
register_deactivation_hook( __FILE__, 'deactivate_woo_pickup' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-pickup.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_woo_pickup() {

	$plugin = new Woo_Pickup();
	$plugin->run();

}
run_woo_pickup();
