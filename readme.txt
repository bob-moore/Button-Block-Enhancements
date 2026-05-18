=== Button Block Enhancements ===
Contributors: Bob Moore
Tags: block-editor, gutenberg, button, icons, blocks
Requires at least: 6.9
Tested up to: 7.0
Stable tag: 1.1.0
Requires PHP: 8.2
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Add icons and hover/focus colors to the core/button block.

== Description ==

Button Block Enhancements extends the core/button block with icon controls and hover/focus color controls in the block sidebar.

This plugin supersedes Enable Button Icons (https://github.com/bob-moore/enable-button-icons). All icon functionality has been migrated here and extended with additional enhancements.

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

3. Instantiate and mount the service:

`use Bmd\ButtonBlockEnhancements\Main as ButtonBlockEnhancements;`
`$plugin = new ButtonBlockEnhancements( [ 'config.package' => 'your_plugin_name', 'config.dir' => $dependency_path, 'config.url' => $dependency_url ] );`
`$plugin->mount();`

The config expects the filesystem path and public URL pointing to the Button Block Enhancements dependency root, not the file where you call it.

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

= 1.1.0 =

No action required. Internal dependency packaging change only.

= 1.0.0 =

Initial release. Supersedes Enable Button Icons with additional hover/focus color support.
