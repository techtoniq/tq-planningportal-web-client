<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.techtoniq.com
 * @since             1.0.0
 * @package           Tq_Planningportal_Web_Client
 *
 * @wordpress-plugin
 * Plugin Name:       Planning Portal Scraper
 * Plugin URI:        https://github.com/techtoniq/tq_planningportal_web_client
 * Description:       Shortcode which scrapes a local council "Public Access to Planning" search page to display planning application results.
 * Version:           1.0.0
 * Author:            Techtoniq
 * Author URI:        www.techtoniq.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tq-planningportal-web-client
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
define( 'TQ_PLANNINGPORTAL_WEB_CLIENT_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-tq-planningportal-web-client-activator.php
 */
function activate_tq_planningportal_web_client() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tq-planningportal-web-client-activator.php';
	Tq_Planningportal_Web_Client_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-tq-planningportal-web-client-deactivator.php
 */
function deactivate_tq_planningportal_web_client() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-tq-planningportal-web-client-deactivator.php';
	Tq_Planningportal_Web_Client_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_tq_planningportal_web_client' );
register_deactivation_hook( __FILE__, 'deactivate_tq_planningportal_web_client' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tq-planningportal-web-client.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tq_planningportal_web_client() {

	$plugin = new Tq_Planningportal_Web_Client();
	$plugin->run();

}
run_tq_planningportal_web_client();
