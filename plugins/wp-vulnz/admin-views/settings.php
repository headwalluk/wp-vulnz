<?php
/**
 * Settings page for the WP VULNZ plugin.
 *
 * @package WP_Vulnz
 */

// Block direct access.
defined( 'ABSPATH' ) || die();

echo '<div class="wrap">';
printf( '<h1>%s</h1>', esc_html( get_admin_page_title() ) );

printf( '<p>%s</p>', esc_html__( 'You can get your API key by logging in to your VULNZ account and generating a new key in the dashboard.', 'wp-vulnz' ) );

printf( '<p>Default API URL: %s</p>', esc_url( 'https://vulnz.headwall.net/api' ) );

printf( '<form action="%s" method="post">', esc_url( admin_url( 'options.php' ) ) );
\settings_fields( 'wp_vulnz_settings' );
\do_settings_sections( 'wp-vulnz' );

echo '<table class="form-table">';

echo '<tr valign="top">';
printf( '<th scope="row">%s</th>', esc_html__( 'Enable Connection to VULNZ', 'wp-vulnz' ) );
printf( '<td><input type="checkbox" name="wp_vulnz_enabled" value="1" %s /></td>', checked( 1, get_option( 'wp_vulnz_enabled' ), false ) );
echo '</tr>';

echo '<tr valign="top">';
printf( '<th scope="row">%s</th>', esc_html__( 'API URL', 'wp-vulnz' ) );
printf( '<td><input type="text" name="wp_vulnz_api_url" value="%s" size="50" /></td>', esc_attr( get_option( 'wp_vulnz_api_url' ) ) );
echo '</tr>'; // .form-table row.

echo '<tr valign="top">';
printf( '<th scope="row">%s</th>', esc_html__( 'API Key', 'wp-vulnz' ) );
printf( '<td><input type="password" name="wp_vulnz_api_key" value="%s" size="50" autocomplete="off" /></td>', esc_attr( get_option( 'wp_vulnz_api_key' ) ) );
echo '</tr>'; // .form-table row.

echo '</table>'; // .form-table.

\submit_button();

echo '</form>'; // options.php.
echo '</div>'; // .wrap.
