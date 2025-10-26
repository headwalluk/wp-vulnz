<?php
/**
 * Summary page for the WP VULNZ this_plugin.
 *
 * @package WP_Vulnz
 */

// Block direct access.
defined( 'ABSPATH' ) || die();

$api_client = WP_Vulnz\get_plugin()->get_api_client();
$site_url   = \site_url();
$our_domain = \wp_parse_url( $site_url, PHP_URL_HOST );

$website_data = $api_client->get_website( $our_domain );

echo '<div class="wrap">';
printf( '<h1>%s</h1>', esc_html( get_admin_page_title() ) );
echo '<p>Summary information will be displayed here.</p>';
printf( '<button id="wp-vulnz-sync-now" class="button button-primary">%s</button>', esc_html__( 'Sync Now', 'wp-vulnz' ) );


if ( empty( $website_data ) ) {
	echo '<p>' . esc_html__( 'No data available for this website. Please click "Sync Now" to retrieve data from the API.', 'wp-vulnz' ) . '</p>';
} elseif ( ! array_key_exists( 'wordpress-plugins', $website_data ) ) {
	echo '<p>' . esc_html__( 'No plugin data available for this website.', 'wp-vulnz' ) . '</p>';
} else {
	printf( '<h2>%s</h2>', esc_html__( 'Installed Plugins', 'wp-vulnz' ) );
	echo '<table class="wp-list-table widefat fixed striped">';
	echo '<thead>';
	echo '<tr>';
	printf( '<th scope="col">%s</th>', esc_html__( 'Plugin', 'wp-vulnz' ) );
	printf( '<th scope="col">%s</th>', esc_html__( 'Version', 'wp-vulnz' ) );
	printf( '<th scope="col">%s</th>', esc_html__( 'Vulnerabilities', 'wp-vulnz' ) );
	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';
	foreach ( $website_data['wordpress-plugins'] as $this_plugin ) {
		echo '<tr>';
		printf( '<td>%s</td>', esc_html( $this_plugin['title'] ) );
		printf( '<td>%s</td>', esc_html( $this_plugin['version'] ) );
		echo '<td>';
		if ( ! empty( $this_plugin['vulnerabilities'] ) ) {
			echo '<ul>';
			foreach ( $this_plugin['vulnerabilities'] as $vulnerability ) {
				printf( '<li><a href="%s" target="_blank" rel="noopener noreferrer">%s</a></li>', esc_url( $vulnerability ), esc_html( $vulnerability ) );
			}
			echo '</ul>';
		} else {
			printf( '<p>%s</p>', esc_html__( 'No known vulnerabilities', 'wp-vulnz' ) );
		}
		echo '</td>';
		echo '</tr>';
	}
	echo '</tbody>';
	echo '</table>'; // .wp-list-table
}

echo '</div>'; // .wrap
