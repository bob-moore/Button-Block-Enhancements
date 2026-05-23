# Button Block Enhancements

![Button Block Enhancements](assets/banner-large.webp)

[![WordPress](https://img.shields.io/badge/WordPress-6.9%2B-3858e9?logo=wordpress&logoColor=fff)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.2%2B-777bb4?logo=php&logoColor=fff)](https://www.php.net/)
[![Latest Release](https://img.shields.io/github/v/release/bob-moore/button-block-enhancements?label=release)](https://github.com/bob-moore/button-block-enhancements/releases/latest)
[![License](https://img.shields.io/badge/license-GPL--2.0--or--later-blue)](https://www.gnu.org/licenses/gpl-2.0.html)

[![Lint PHP](https://github.com/bob-moore/button-block-enhancements/actions/workflows/phpcs.yml/badge.svg)](https://github.com/bob-moore/button-block-enhancements/actions/workflows/phpcs.yml)
[![PHPStan](https://github.com/bob-moore/button-block-enhancements/actions/workflows/phpstan.yml/badge.svg)](https://github.com/bob-moore/button-block-enhancements/actions/workflows/phpstan.yml)
[![PHPUnit](https://github.com/bob-moore/button-block-enhancements/actions/workflows/phpunit.yml/badge.svg)](https://github.com/bob-moore/button-block-enhancements/actions/workflows/phpunit.yml)

Want to give it a test drive? Try it in the WP Playground: [![Try it in the WordPress Playground](https://img.shields.io/badge/WP_Playground-v1.1.1-blue?logo=wordpress&logoColor=%23fff&labelColor=%233858e9&color=%233858e9)](https://playground.wordpress.net/?blueprint-url=https://raw.githubusercontent.com/bob-moore/button-block-enhancements/main/_playground/blueprint-github.json)

Add icons and hover/focus colors to the WordPress Button block (`core/button`) in both the editor and frontend.

## Features

### Icons

- Adds icon controls to `core/button` in the block inspector.
- Supports icon libraries:
  - WordPress icons
  - MUI icons
  - MUI variant families, including Outlined, Rounded, and Sharp
  - Custom SVG input
- Lets you set icon position (left/right).
- Lets you set icon size per button using CSS units (for example `1em`, `20px`, `1.25rem`).
- Renders sanitized inline SVG on the frontend.
- Clicking the currently selected icon removes it.

### Hover/Focus Colors

- Adds text and background color controls for hover/focus states to `core/button` in the block inspector's Color panel.
- Colors apply to `:hover`, `:focus`, and `:focus-visible` states on the frontend.
- Supports alpha channel, is clearable, and integrates with "Reset All".
- Previews live in the editor.
- Outputs CSS custom properties (`--bmd-button-focus-color`, `--bmd-button-focus-background-color`) on the button wrapper so themes can override or extend behavior.

### Architecture

- Boots through a single `Controller` that builds a small PHP-DI container and mounts all WordPress hooks.
- Splits responsibilities into focused providers (`Assets`, `Icons`), transformers (`Colors`, `Icons`), and resolver services for file paths and URLs.
- Scopes bundled runtime dependencies in release zips to avoid conflicts with other plugins.
- Ships release zips with a compiled container cache, while Composer installs exclude `cache/` so host projects can decide whether to compile their own container.
- Can be embedded in other plugins or themes via Composer.

## Requirements

- WordPress 6.9+
- PHP 8.2+

## Installation

### Install as a plugin

1. Download the latest release zip from GitHub releases.
2. In WordPress admin, go to Plugins -> Add New Plugin -> Upload Plugin.
3. Upload the zip and activate Button Block Enhancements.

### Install via Composer (library usage)

If you are embedding this into your own project:

```bash
composer require bmd/button-block-enhancements
```

Then bootstrap:

```php
use Bmd\ButtonBlockEnhancements\Controller;

$dependency_url  = plugin_dir_url( __FILE__ ) . 'vendor/bmd/button-block-enhancements/';
$dependency_path = plugin_dir_path( __FILE__ ) . 'vendor/bmd/button-block-enhancements/';


$plugin = new Controller(
    $dependency_url,
    $dependency_path,
    false
);

$plugin->mount();
```

The constructor expects the public URL and filesystem path pointing to the Button Block Enhancements dependency root, not the file where you call it. The third argument enables PHP-DI container compilation; leave it `false` for Composer-embedded usage unless your project manages its own cache lifecycle.

## Usage

### Icons

1. Add a Button block.
2. Open the block sidebar.
3. Open the **Icon** panel.
4. Choose an icon library (WordPress, MUI, MUI Outlined/Rounded/Sharp, or Custom SVG).
5. Pick an icon. Click it again to remove it.
6. Open the **Icon Styles** panel to set icon size and position (left/right).
7. Save and view the post.

### Hover/Focus Colors

1. Add a Button block.
2. Open the block sidebar.
3. Open the **Color** panel.
4. Use the **Text: Focus** and **Background: Focus** controls to pick hover/focus colors.
5. Save and view the post.

## CSS Custom Properties

The following CSS custom properties are available for theming:

| Property | Default | Description |
|---|---|---|
| `--bmd-button-icon-size` | `1em` | Icon width and height |
| `--bmd-button-icon-gap` | `0.75em` | Gap between icon and button text |
| `--bmd-button-focus-color` | — | Text color on hover/focus (set per-block) |
| `--bmd-button-focus-background-color` | — | Background color on hover/focus (set per-block) |

## Custom Icon Families

Developers can register additional static JSON icon families with the `button_block_enhancements_icon_families` filter. Each JSON file should contain an array of picker-compatible icon objects with `name`, `label`, and `source` properties.

```php
add_filter( 'button_block_enhancements_icon_families', function ( $families ) {
    $families['brand-icons'] = array(
        'label' => 'Brand Icons',
        'url'   => plugin_dir_url( __FILE__ ) . 'icons/brand-icons.json',
    );

    return $families;
} );
```

## Changelog

### 1.2.1

- Fixed bug that in Utilities that creates a malformed URL
- Fixed bug that caused style and script handle collisions when included via composer.

### 1.1.1

- Documented the controller/provider/transformer architecture used by the current plugin bootstrap.
- Standardized all release metadata and package versions on 1.1.1.

### 1.1.0

- Rebuilt the plugin around a focused PHP-DI controller and provider/transformer services.
- Scoped release dependencies to reduce conflicts with other plugins.
- Split editor-only styles from block styles registered against `core/button`.
- Added optional compiled container cache handling for release builds.
- Removed the legacy framework/updater architecture.
- Migrated button icon functionality from [Enable Button Icons](https://github.com/bob-moore/enable-button-icons).
- Added hover/focus color controls and CSS custom properties for icon gap, icon size, and focus colors.
