<?php
/**
 * Public functions for interacting with the WP VULNZ plugin.
 *
 * @package WP_Vulnz
 */

// Block direct access.
defined( 'ABSPATH' ) || die();

/**
 * Get the plugin instance.
 *
 * @return \WP_Vulnz\Plugin The plugin instance.
 */
function wp_vulnz_get_instance() {
	global $wp_vulnz_plugin;
	return $wp_vulnz_plugin;
}
