<?php
/**
 * Constants used by the plugin.
 *
 * @package WP_Vulnz
 */

namespace WP_Vulnz;

// Block direct access.
defined( 'ABSPATH' ) || die();

define( 'WP_Vulnz\PLUGIN_VERSION', '0.1.0' );
define( 'WP_Vulnz\PLUGIN_PATH', \plugin_dir_path( __FILE__ ) );
define( 'WP_Vulnz\PLUGIN_INCLUDES', PLUGIN_PATH . 'includes/' );
define( 'WP_Vulnz\PLUGIN_URL', \plugin_dir_url( __FILE__ ) );

// Cron schedule and action names.
const SCHEDULE_NAME = 'wp_vulnz';

// AJAX action names.
const SYNC_NOW_ACTION_NAME  = 'wp_vulnz_sync_now';
const SYNC_NOW_ACTION_NONCE = 'wp_vulnz_sync_now_nonce';

const WEBSITE_DATA_CACHE_TTL = \MINUTE_IN_SECONDS;

const API_REQUEST_TIMEOUT = 10;
