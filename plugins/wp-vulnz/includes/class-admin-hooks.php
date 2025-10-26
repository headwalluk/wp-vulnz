<?php
/**
 * Admin hooks for the WP VULNZ plugin.
 *
 * @package WP_Vulnz
 */

namespace WP_Vulnz;

use Error;

// Block direct access.
defined( 'ABSPATH' ) || die();

/**
 * Class Admin_Hooks
 */
class Admin_Hooks {

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook The current admin page hook.
	 */
	public function enqueue_assets( $hook ) {
		if ( 'toplevel_page_wp-vulnz-summary' !== $hook ) {
			return;
		}

		\wp_enqueue_style( 'wp-vulnz-admin', PLUGIN_URL . 'assets/admin.css', array(), PLUGIN_VERSION );

		\wp_enqueue_script( 'wp-vulnz-admin', PLUGIN_URL . 'assets/admin.js', array( 'jquery' ), PLUGIN_VERSION, true );

		\wp_localize_script(
			'wp-vulnz-admin',
			'wp_vulnz',
			array(
				'nonce' => \wp_create_nonce( SYNC_NOW_ACTION_NONCE ),
			)
		);
	}

	/**
	 * Render the plugin summary page.
	 */
	public function render_summary_page() {
		include_once PLUGIN_DIR . 'admin-views/vulnz-overview.php';
	}

	/**
	 * Render the plugin settings page.
	 */
	public function render_settings_page() {
		include_once PLUGIN_DIR . 'admin-views/settings.php';
	}

	/**
	 * Display an admin notice if the plugin is not enabled.
	 */
	public function admin_notice() {
		if ( ! \get_option( 'wp_vulnz_enabled' ) ) {
			printf(
				'<div class="notice notice-warning"><p>%s <a href="%s">%s</a></p></div>',
				esc_html__( 'WP VULNZ API is not enabled. ', 'wp-vulnz' ),
				esc_url( get_our_settings_url() ),
				esc_html__( 'Click here to enable', 'wp-vulnz' )
			);
		}
	}

	/**
	 * Add a settings link to the plugin's entry in the plugins list table.
	 *
	 * @param array $links An array of plugin action links.
	 * @return array
	 */
	public function add_settings_link( $links ) {
		$settings_link = sprintf(
			'<a href="%s">%s</a>',
			get_our_settings_url(),
			\__( 'Settings', 'wp-vulnz' )
		);
		\array_unshift( $links, $settings_link );
		return $links;
	}
}
