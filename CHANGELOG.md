# Changelog

All notable changes to this project will be documented in this file.

The format is based on Keep a Changelog, and this project adheres to Semantic Versioning.

## [1.0.2] - 2025-10-26
- Tidying up bits-and-bobs in the codebase.
- Added a settings link from the wp-admin/plugins.php page.
- Moved the PLUGIN_VERSION constant so it gets updated properly with the plugin's header meta.

## [1.0.0] - 2025-10-26

### Added
- Admin menu with Summary and Settings pages.
- Settings for API URL and API Key.
- Hourly background task to sync site data to the configured VULNZ API.
- "Sync Now" action to trigger an immediate sync.

### Changed
- Documentation and WordPress readme.
- Promoted to first stable release.

## [0.1.0] - 2025-10-26

### Added
- Initial plugin scaffolding and integration with the VULNZ API.
- Basic admin UI and configuration.
