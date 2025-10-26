# wp-vulnz

This repository hosts a single WordPress plugin, VULNZ. The plugin exists to support and integrate with the broader VULNZ project:

- VULNZ (core project): https://github.com/headwalluk/vulnz

The plugin provides an admin UI and background tasks intended to communicate with the VULNZ API, making it useful for demos, local testing, and future integrations with the VULNZ ecosystem.

## Repository layout

- `plugins/wp-vulnz/` — The WordPress plugin source (PHP, assets, admin views)
- `LICENSE` — GPL-2.0-or-later license file

## Getting started

- Option A: Install from a prebuilt ZIP
  - Download a ready-to-go ZIP from `dist/plugins/` in this repo. You'll see two ZIP files:
    - One with the version number in the filename (e.g. `wp-vulnz-<version>.zip`)
    - One without the version number (e.g. `wp-vulnz.zip`)
    These are identical; some systems prefer the versioned filename.
  - In your WordPress Admin, go to Plugins → Add New → Upload Plugin, select the ZIP, then Install and Activate.

- Option B: Install from source (copy/symlink)
  - Copy or symlink the plugin folder into a WordPress installation:
    - From this repo: `plugins/wp-vulnz/`
    - To your site: `wp-content/plugins/wp-vulnz/`
  - Activate “VULNZ” in WordPress Admin → Plugins

- Configure under WordPress Admin → WP VULNZ → Settings

Notes:
- This repository does not include WordPress core. Use any standard WordPress environment.
- The plugin targets modern WordPress and PHP; see the plugin’s `readme.txt` for minimum versions and details.

## Related projects

- VULNZ: https://github.com/headwalluk/vulnz

## Changelog

See `CHANGELOG.md` for release notes.

## License

GPL-2.0-or-later. See `LICENSE` for details.
