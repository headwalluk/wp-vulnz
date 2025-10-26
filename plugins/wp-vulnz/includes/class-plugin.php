<?php
/**
 * Core plugin functionality.
 *
 * @package WP_Vulnz
 */

namespace WP_Vulnz;

// Block direct access.
defined( 'ABSPATH' ) || die();

/**
 * The main plugin class.
 */
class Plugin {

	/**
	 * Cron event hook name.
	 */
	private const CRON_HOOK = 'wp_vulnz_hourly_event';

	/**
	 * Initialse the plugin and set up hooks.
	 */
	public function __construct() {
		\add_action( 'init', array( $this, 'init' ) );

		\add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		\add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	/**
	 * Initialize the plugin.
	 */
	public function init() {
		// Register cron callback for our hourly task.
		\add_action( SCHEDULE_NAME, array( $this, 'run_hourly_task' ) );

		\add_action( 'wp_ajax_' . SYNC_NOW_ACTION_NAME, array( $this, 'ajax_sync_now' ) );
	}

	/**
	 * Initialize the admin area.
	 */
	public function admin_init() {
		$this->register_settings();

		$admin_hooks = $this->get_admin_hooks();

		\add_action( 'admin_enqueue_scripts', array( $admin_hooks, 'enqueue_assets' ) );
		\add_action( 'admin_notices', array( $admin_hooks, 'admin_notice' ) );
	}

	/**
	 * Admin_Hooks instance.
	 *
	 * @var Admin_Hooks
	 */
	private $admin_hooks;

	/**
	 * Get the Admin_Hooks instance.
	 *
	 * @return Admin_Hooks The Admin_Hooks instance.
	 */
	public function get_admin_hooks(): Admin_Hooks {
		if ( null === $this->admin_hooks ) {
			$this->admin_hooks = new Admin_Hooks();
		}

		return $this->admin_hooks;
	}

	/**
	 * Api_Client instance.
	 *
	 * @var Api_Client
	 */
	private $api_client;

	/**
	 * Get the API instance.
	 *
	 * @return Api_Client The Api_Client instance.
	 */
	public function get_api_client(): Api_Client {
		if ( null === $this->api_client ) {
			$this->api_client = new Api_Client();
		}
		return $this->api_client;
	}

	/**
	 * Add the plugin settings page to the admin menu.
	 */
	public function admin_menu() {
		$admin_hooks = $this->get_admin_hooks();

		\add_menu_page(
			\__( 'WP VULNZ', 'wp-vulnz' ),
			\__( 'WP VULNZ', 'wp-vulnz' ),
			'manage_options',
			'wp-vulnz-summary',
			array( $admin_hooks, 'render_summary_page' ),
			'dashicons-shield-alt',
			80
		);

		\add_submenu_page( 'wp-vulnz-summary', \__( 'Summary', 'wp-vulnz' ), \__( 'Summary', 'wp-vulnz' ), 'manage_options', 'wp-vulnz-summary', array( $admin_hooks, 'render_summary_page' ) );

		\add_submenu_page(
			'wp-vulnz-summary',
			\__( 'Settings', 'wp-vulnz' ),
			\__( 'Settings', 'wp-vulnz' ),
			'manage_options',
			'wp-vulnz-settings',
			array(
				$admin_hooks,
				'render_settings_page',
			)
		);
	}

	/**
	 * Render the plugin settings page.
	 */
	public function register_settings() {
		\register_setting(
			'wp_vulnz_settings',
			'wp_vulnz_enabled',
			array(
				'type'    => 'boolean',
				'default' => false,
			)
		);

		\register_setting(
			'wp_vulnz_settings',
			'wp_vulnz_api_url',
			array(
				'type'              => 'string',
				'sanitize_callback' => 'esc_url_raw',
				'default'           => 'https://vulnz.headwall.net/api',
			)
		);

		\register_setting(
			'wp_vulnz_settings',
			'wp_vulnz_api_key',
			array(
				'type'              => 'string',
				'sanitize_callback' => '\\WP_Vulnz\\sanitize_api_key',
			)
		);
	}

	/**
	 * Run the hourly scheduled task.
	 *
	 * This checks the plugin enable setting and, if enabled, performs
	 * a lightweight action and updates a "last run" timestamp. Replace
	 * the TODO section with your actual hourly logic (e.g. syncing with
	 * the VULNZ API).
	 */
	public function run_hourly_task(): void {
		$enabled = (bool) \get_option( 'wp_vulnz_enabled', false );
		if ( ! $enabled ) {
			return;
		}

		$this->sync_website_with_vulnz();

		// Record when the task last ran for admin visibility.
		\update_option( 'wp_vulnz_last_cron_run', \current_time( 'mysql' ) );
	}

	/**
	 * Plugin activation: schedule the hourly cron if not already scheduled.
	 */
	public static function activate(): void {
		if ( ! \wp_next_scheduled( SCHEDULE_NAME ) ) {
			// Schedule to run at the next whole hour, then hourly.
			\wp_schedule_event( \time(), 'hourly', SCHEDULE_NAME );
		}
	}

	/**
	 * Plugin deactivation: clear the scheduled cron hook.
	 */
	public static function deactivate(): void {
		\wp_clear_scheduled_hook( SCHEDULE_NAME );
	}

	/**
	 * Ajax handler for the "Sync Now" button.
	 */
	public function ajax_sync_now() {
		if ( ! \current_user_can( 'manage_options' ) ) {
			\wp_send_json_error( array( 'message' => 'Permission denied.' ), 403 );
		}

		$nonce = isset( $_POST['nonce'] ) ? \sanitize_text_field( \wp_unslash( $_POST['nonce'] ) ) : '';
		if ( ! \wp_verify_nonce( $nonce, SYNC_NOW_ACTION_NONCE ) ) {
			\wp_send_json_error( array( 'message' => 'Nonce verification failed.' ), 403 );
		}

		if ( ! $this->sync_website_with_vulnz() ) {
			\wp_send_json_error( array( 'message' => 'Failed to sync with the API.' ), 500 );
		}

		\wp_send_json_success( array( 'message' => 'Sync successful.' ) );
	}

	/**
	 * Sync the website data with the API.
	 *
	 * @return bool True on success, false on failure.
	 */
	public function sync_website_with_vulnz(): bool {
		$api_client = $this->get_api_client();
		if ( ! $api_client->is_available() ) {
			return false;
		}

		$site_url = \site_url();
		$domain   = \wp_parse_url( $site_url, PHP_URL_HOST );

		if ( ! is_string( $domain ) || empty( $domain ) ) {
			return false;
		}

		$body = array(
			'title'             => \get_bloginfo( 'name' ),
			'is_ssl'            => \is_ssl(),
			'meta'              => array(
				'Admin'      => \wp_login_url(),
				'Owner'      => \get_bloginfo( 'admin_email' ),
				'WP Version' => \get_bloginfo( 'version' ),
			),
			'wordpress-plugins' => get_installed_plugins(),
		);

		return $api_client->create_or_update_website( $domain, $body );
	}
}
