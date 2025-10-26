<?php
/**
 * Private/Plugin-scoped functions.
 *
 * @package WP_Vulnz
 */

namespace WP_Vulnz;

// Block direct access.
defined( 'ABSPATH' ) || die();

/**
 * Get the main plugin instance.
 *
 * @return Plugin The plugin instance.
 */
function get_plugin(): Plugin {
	global $wp_vulnz_plugin;
	return $wp_vulnz_plugin;
}


/**
 * Get the API client instance.
 *
 * @return Api_Client The API client instance.
 */
function get_api_client(): Api_Client {
	global $wp_vulnz_plugin;
	return $wp_vulnz_plugin->get_api_client();
}

/**
 * Sanitize the API key.
 *
 * @param string $api_key The API key to sanitize.
 *
 * @return string The sanitized API key.
 */
function sanitize_api_key( string $api_key ): string {
	$sanitised = preg_replace( '/[^a-zA-Z0-9]/', '', $api_key );
	if ( ! is_string( $sanitised ) ) {
		$sanitised = '';
	}

	return $sanitised;
}


/**
 * Get the cache key for storing website data.
 *
 * @param string $domain The domain name.
 *
 * @return string|null The cache key, or null if the domain is empty.
 */
function get_website_cache_key( string $domain ): ?string {
	$cache_key = null;

	if ( ! empty( $domain ) ) {
		$cache_key = 'wp_vulnz_website_' . md5( $domain );
	}

	return $cache_key;
}


/**
 * Get the list of installed plugins with their slugs and versions.
 *
 * @return array List of installed plugins with 'slug' and 'version' keys.
 */
function get_installed_plugins(): array {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = array();
	foreach ( \get_plugins() as $plugin_file => $plugin_data ) {
		$slug = \dirname( $plugin_file );
		if ( '.' === $slug ) {
			$slug = \basename( $plugin_file, '.php' );
		}
		$plugins[] = array(
			'slug'    => $slug,
			'version' => $plugin_data['Version'],
		);
	}

	return $plugins;
}
