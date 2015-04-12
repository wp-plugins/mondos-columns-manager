<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.squareonemd.co.uk
 * @since             1.0.0
 * @package           Mondos_Columns
 *
 * @wordpress-plugin
 * Plugin Name:       Mondos Columns Manager
 * Plugin URI:        http://www.squareonemd.co.uk/
 * Description:       Disable columns when viewing a list of posts, pages or users.
 * Version:           1.0.0
 * Author:            Elliott Richmond Square One
 * Author URI:        http://www.squareonemd.co.uk/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mondos-columns
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mondos-columns-activator.php
 */
function activate_mondos_columns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mondos-columns-activator.php';
	Mondos_Columns_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mondos-columns-deactivator.php
 */
function deactivate_mondos_columns() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mondos-columns-deactivator.php';
	Mondos_Columns_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mondos_columns' );
register_deactivation_hook( __FILE__, 'deactivate_mondos_columns' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mondos-columns.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mondos_columns() {

	$plugin = new Mondos_Columns();
	$plugin->run();

}
run_mondos_columns();
