<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wecode.agency
 * @since             1.0.0
 * @package           petition
 *
 * @wordpress-plugin
 * Plugin Name:       Petition
 * Plugin URI:        https://wecode.agency
 * Description:       Petition plugin for Avalon.
 * Version:           1.0.0
 * Author:            Tobiasz Gerczuk
 * Author URI:        https://wecode.agency
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       petition
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
define( 'petition_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-petition-activator.php
 */
function activate_petition() {
	require_once plugin_dir_path(__FILE__) . 'includes/class-petition-activator.php';
	petition_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-petition-deactivator.php
 */
function deactivate_petition() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-petition-deactivator.php';
	petition_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_petition' );
register_deactivation_hook( __FILE__, 'deactivate_petition' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-petition.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_petition() {

	$plugin = new Petition();
	$plugin->run();

}
run_petition();
