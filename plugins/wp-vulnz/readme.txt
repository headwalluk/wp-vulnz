=== VULNZ ===
Contributors: headwalluk
Tags: security, vulnerabilities, api, integration
Requires at least: 6.0
Tested up to: 6.6
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A plugin to integrate with the VULNZ API.

== Description ==

VULNZ is a companion WordPress plugin for the VULNZ project. It provides an admin UI and background tasks that communicate with a VULNZ API endpoint, making it useful for demos, local testing, and future integrations with the wider VULNZ ecosystem.

- Project home (core project): https://github.com/headwalluk/vulnz
- Plugin site: https://vulnz.headwall.net

Features in this repository version:

- Admin menu (WP Admin → WP VULNZ) with Summary and Settings pages
- Configurable API URL and API Key
- Hourly background task to sync site data to the configured VULNZ API
- Optional on-demand sync from the admin UI

Data sent during a sync includes basic site metadata (site title, whether SSL is enabled, admin login URL, admin email, WordPress version) and a list of installed plugins, so that the VULNZ service can reason about your environment.

== Installation ==

1. Copy or symlink the plugin folder into your WordPress installation:
   - From this repo: `plugins/wp-vulnz/`
   - To your site: `wp-content/plugins/wp-vulnz/`
2. In WordPress Admin, go to Plugins and activate “VULNZ”.
3. Open WP Admin → WP VULNZ → Settings and:
   - Toggle Enable
   - Set the API URL (defaults to `https://vulnz.headwall.net/api`)
   - Add your API Key
4. Optionally click “Sync Now” on the settings/summary page to trigger an immediate sync.

== Frequently Asked Questions ==

= What is VULNZ? =
VULNZ is an external project for working with vulnerability data and related workflows. See https://github.com/headwalluk/vulnz for background and documentation.

= Does this plugin require an external service? =
Yes. You will need access to a VULNZ API endpoint. By default the plugin points to `https://vulnz.headwall.net/api`, but you can change this in Settings.

= What data does the plugin send? =
When enabled, the plugin sends basic site metadata (title, SSL status, admin login URL, WordPress version) and your installed plugin list to the configured VULNZ API to help assess the environment.

No personal data are sent - only website metadata.

= Can I disable background syncing? =
Yes. Turn off the Enable setting under WP VULNZ → Settings to stop the hourly task.

== Screenshots ==
1. WP VULNZ Summary and Settings pages in the WordPress admin.

== Changelog ==

= 1.0.2 =
* Tidying up bits-and-bobs in the codebase.
* Added a settings link from the wp-admin/plugins.php page.
* Moved the PLUGIN_VERSION constant so it gets updated properly with the plugin's header meta.

= 1.0.0 =
* First stable release.
* Admin Summary and Settings pages.
* Configurable API URL and API Key.
* Hourly background sync and on-demand "Sync Now".
* Documentation updates.

= 0.1.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.0 =
First stable release; no breaking changes expected.
