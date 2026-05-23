=== Button Block Enhancements ===
Contributors: Bob Moore
Tags: block-editor, gutenberg, button, icons, blocks
Requires at least: 6.9
Tested up to: 7.0
Stable tag: 1.2.1
Requires PHP: 8.2
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add icons and hover/focus colors to the core/button block.

== Description ==

Button Block Enhancements extends the core/button block with icon controls and hover/focus color controls in the block sidebar.

This plugin supersedes Enable Button Icons (https://github.com/bob-moore/enable-button-icons). All icon functionality has been migrated here and extended with additional enhancements.

Under the hood, the plugin now boots through Main, which builds a PHP-DI container, then resolves a controller that delegates responsibilities to focused asset/icon providers, render transformers, and filesystem/URL resolver services.

What it does:

**Icons**

* Adds icon controls to core/button in the block editor.
* Supports WordPress icons, MUI icon families (standard, Outlined, Rounded, Sharp), and custom SVG markup.
* Lets developers register additional static JSON icon families with a PHP filter.
* Supports left/right icon position.
* Supports per-button icon size using CSS units.
* Renders sanitized inline SVG on the frontend.
* Clicking the currently selected icon removes it.

**Hover/Focus Colors**

* Adds text and background color controls for hover/focus states in the block inspector's Color panel.
* Colors apply to :hover, :focus, and :focus-visible states on the frontend.
* Supports alpha channel, is clearable, and integrates with Reset All.
* Previews live in the editor.
* Outputs CSS custom properties on the button wrapper so themes can override or extend behavior.

This plugin is distributed through GitHub releases and includes a scoped updater so WordPress can surface updates from this repository.

== Installation ==

= Install as a WordPress plugin =

1. Download the latest release zip from GitHub.
2. In WordPress admin, go to Plugins > Add New Plugin > Upload Plugin.
3. Upload the zip and activate Button Block Enhancements.

= Install via Composer (library usage) =

1. Require the package:

`composer require bmd/button-block-enhancements`

2. Ensure the Composer autoloader is loaded:

`require_once __DIR__ . '/vendor/autoload.php';`

3. Instantiate and mount the package:

`use Bmd\ButtonBlockEnhancements\Main;`
`$plugin = new Main( [ 'package' => 'your_plugin_slug', 'path' => $dependency_path, 'url' => $dependency_url ] );`
`$plugin->mount();`

The `path` and `url` values must point to the Button Block Enhancements dependency root, not the file where you call it. The `package` value is used for extension filters/actions so the package can inherit your parent plugin namespace when embedded. The package's own script and style handles remain fixed as `button-block-enhancements-*` to avoid collisions with the parent plugin's handles.

You may omit `path` and `url` when WordPress can resolve the dependency location automatically, but passing them explicitly is safest for Composer-embedded plugins and themes. Container compilation is only enabled automatically when `environment` is `production` and a writable package cache is available.

== Frequently Asked Questions ==

= Is this plugin in the WordPress Plugin Directory? =

No. It is distributed via GitHub releases.

= Does this plugin support updates in wp-admin? =

Yes. It includes a GitHub updater integration so WordPress can detect updates from this repo.

= Which icon sets are included? =

WordPress icons and MUI icon families (standard, Outlined, Rounded, and Sharp), plus a custom SVG option. Developers can also register additional static JSON icon families with the `button_block_enhancements_icon_families` filter.

= What CSS custom properties are available? =

`--bmd-button-icon-size` (default 1em) controls icon width and height. `--bmd-button-icon-gap` (default 0.75em) controls the gap between the icon and button text. `--bmd-button-focus-color` and `--bmd-button-focus-background-color` are set per-block and control hover/focus state colors.

= Does this replace Enable Button Icons? =

Yes. Button Block Enhancements supersedes Enable Button Icons and adds hover/focus color support alongside the migrated icon functionality.

== Changelog ==

= 1.2.1 =

* Fixed a Utilities bug that created a malformed package URL in embedded contexts.
* Fixed a bug that caused style and script handle collisions when included via Composer.
* Updated Composer usage documentation to bootstrap through Main with array config.
* Renamed render/content mutation classes from Processors to Transformers.
* Moved PHPCS, PHPStan, and PHPUnit config to root-level files and added a combined Composer test script.
* Added CSS and JavaScript lint GitHub workflows.
* Committed npm lockfile policy and optional dependency config so CI installs include platform-optional packages such as fsevents.
* Cleaned Composer export rules for root declaration files and removed the misspelled declerations.d.ts file.

= 1.1.1 =

* Standardized release metadata and package versions on 1.1.1.
* Updated the documentation to reflect the current controller/provider/transformer architecture and Composer bootstrap API.

= 1.1.0 =

* Moved GitHub updater dependency to scoped/bundled — no longer a transitive Composer requirement for consumers who install via Composer.

= 1.0.0 =

* Initial release.
* Migrated button icon functionality from Enable Button Icons.
* Added hover/focus color controls (text and background) to the Button block Color panel.
* Added CSS custom properties for icon gap, icon size, and focus colors.
* Rebuilt on service-based plugin architecture (bmd/wp-framework).
* Added scoped GitHub updater.

== Upgrade Notice ==

= 1.2.1 =

No action required for standalone plugin users. Composer consumers should bootstrap with `Bmd\ButtonBlockEnhancements\Main` and array config instead of the old Controller constructor example.

= 1.1.1 =

No action required. Documentation and release metadata update.

= 1.1.0 =

No action required. Internal dependency packaging change only.

= 1.0.0 =

Initial release. Supersedes Enable Button Icons with additional hover/focus color support.
