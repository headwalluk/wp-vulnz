<?php
/**
 * Plugin Name:       VULNZ
 * Plugin URI:        https://vulnz.headwall.net
 * Description:       A plugin to integrate with the VULNZ API.
 * Version:           1.0.2
 * Author:            Paul Faulkner
 * Author URI:        https://headwall-hosting.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-vulnz
 * Domain Path:       /languages
 *
 * @package WP_Vulnz
 */

// Block direct access.
defined( 'ABSPATH' ) || die();

// Define the plugin version here for easy bumping during releases.
define( 'WP_Vulnz\PLUGIN_VERSION', '1.0.2' );
define( 'WP_Vulnz\PLUGIN_FILE', __FILE__ );

require_once plugin_dir_path( __FILE__ ) . 'constants.php';

require_once WP_Vulnz\PLUGIN_DIR . 'functions.php';
require_once WP_Vulnz\PLUGIN_DIR . 'functions-public.php';
require_once WP_Vulnz\PLUGIN_DIR . 'includes/class-plugin.php';
require_once WP_Vulnz\PLUGIN_DIR . 'includes/class-admin-hooks.php';
require_once WP_Vulnz\PLUGIN_DIR . 'includes/class-api-client.php';

// Register activation/deactivation hooks for scheduling the hourly task.
\register_activation_hook( __FILE__, array( '\WP_Vulnz\Plugin', 'activate' ) );
\register_deactivation_hook( __FILE__, array( '\WP_Vulnz\Plugin', 'deactivate' ) );

/**
 * Initialize the plugin.
 */
function wp_vulnz_run() {
	global $wp_vulnz_plugin;
	$wp_vulnz_plugin = new \WP_Vulnz\Plugin();
}

/**
 * Main entry point.
 */
wp_vulnz_run();
