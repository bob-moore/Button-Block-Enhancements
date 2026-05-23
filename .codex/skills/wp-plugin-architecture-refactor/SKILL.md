---
name: wp-plugin-architecture-refactor
description: "Use when refactoring Bob Moore's WordPress plugins to the Button Block Enhancements architecture: PHP-DI Main/Controller bootstrapping, Module package injection, Providers, Transformers, Services, Composer embedding, fixed asset handles, root-level tooling, release packaging, and clean Composer exports."
compatibility: "WordPress 6.9+, PHP 8.2+. Filesystem-based agent with Composer, PHPCS, PHPStan, PHPUnit, and optional WordPress build tooling."
---

# WP Plugin Architecture Refactor

## Goal

Refactor WordPress plugins toward the Button Block Enhancements architecture:

- `Main` owns configuration and the PHP-DI container.
- `Controller` registers all WordPress hooks via PHP-DI method injection.
- `Module` provides injected package context for filters/actions.
- `Providers` expose assets, data, integrations, and source collections.
- `Transformers` alter rendered markup or data payloads.
- `Services` provide reusable infrastructure such as path/url resolution and asset loading.

Use this skill when the user asks to migrate, modernize, standardize, or refactor one of Bob's plugins to this architecture.

## Inspect First

Before editing, gather:

- main plugin file and plugin header
- `composer.json` autoload/autoload-dev/scripts
- current hook registration locations
- existing service-like classes
- render filters, markup mutation, or data transformation code
- asset build outputs and `.asset.php` files
- package/release files: `.gitattributes`, readmes, build scripts, updater code
- test/tooling layout: `phpcs.xml`, `phpstan.neon`, `phpunit.xml`, `phpunit/`

Prefer existing project conventions unless they conflict with this architecture.

## Target Structure

Use this shape where practical:

```text
inc/
  Main.php
  Controller.php
  Module.php
  definitions.php
  Providers/
  Services/
  Transformers/
```

Keep the main plugin file thin: load Composer autoload, configure `Main`, mount it, and handle updater/bootstrap-only behavior.

## Container Pattern

`Main` should:

- accept config overrides such as `environment`, `package`, `path`, and `url`
- default `package` to the plugin slug with underscores for hooks/filters
- default `path` and `url` to the package root
- call `$builder->useAttributes( true )`
- add config definitions before class definitions
- load `inc/definitions.php`
- mount `Controller`
- optionally support compiled containers for production/release builds

`definitions.php` should use `DI\autowire()` for classes in `Controller`, `Providers`, `Services`, and `Transformers`.

## Module Injection

Use method injection for package context:

```php
#[Inject( [ 'package' => 'package' ] )]
public function setPackage( string $package ): void
{
    $this->package = trim( Utilities::slugify( $package ) );
}
```

Use the injected package for filters and actions that should inherit the host plugin namespace when embedded via Composer.

Do not use the injected package for WordPress script/style handles owned by the dependency package.

## Hook Registration

Put hook registration in `Controller` only. Use injected dependencies:

```php
#[Inject]
public function registerFilters(
    Transformers\Icons $icons,
    Transformers\Colors $colors,
    Providers\Icons $icon_provider,
): void {
    add_filter( 'render_block_core/button', [ $icons, 'renderBlock' ], 10, 2 );
    add_filter( "{$this->package}_icon_families", [ $icon_provider, 'provideIconFamilies' ] );
}
```

Avoid scattered `add_action()` and `add_filter()` calls in providers, services, or transformers unless the existing plugin architecture makes centralization unsafe.

## Layer Naming

- `Providers`: supply assets, icon families, integrations, config-derived values, or source data.
- `Transformers`: change rendered markup, arrays, REST payloads, or other content flowing through filters.
- `Services`: reusable infrastructure with narrow responsibilities.

Use `Transformers`, not `Processors`, for render/content mutation classes.

## Asset Loading

Centralize asset registration in services:

- `FilePathResolver` resolves package-relative filesystem paths.
- `UrlResolver` resolves package-relative URLs.
- `AssetLoader` reads `.asset.php` metadata.
- `ScriptLoader` registers/enqueues scripts.
- `StyleLoader` registers/enqueues styles and block styles.

Use relative asset paths such as `build/editor.js` so loaders can find `.asset.php` dependencies and versions.

Asset dependency filters may use the injected package:

```php
apply_filters( "{$this->package}_script_dependencies_{$handle}", $dependencies )
```

## Fixed Handles

For Composer-embedded packages, hardcode package-owned WordPress asset handles so they do not collide with the host plugin's handles:

```php
protected const EDITOR_SCRIPT_HANDLE = 'button-block-enhancements-editor';
protected const EDITOR_STYLE_HANDLE  = 'button-block-enhancements-editor-styles';
protected const BLOCK_STYLE_HANDLE   = 'button-block-enhancements-styles';
```

Adapt the prefix to the package being refactored. Keep filters/actions package-injected; keep handles package-owned.

## Composer Embedding

For packages intended to work as Composer dependencies:

- constructor/config docs should tell host plugins to pass the dependency package root path and URL
- avoid assuming the main plugin file is the package root
- allow host containers to provide explicit `constructorParameter()` values while preserving attributes/autowiring
- keep generic scalar config keys intentional and document collision risks when embedded in another container

## Tooling Layout

Prefer root-level tool configs:

```text
composer.json
phpcs.xml
phpstan.neon
phpunit.xml
phpunit/
```

Composer scripts should include:

```json
"phpsniff": "./vendor/bin/phpcs ./inc -v --standard='./phpcs.xml'",
"phpstan": "./vendor/bin/phpstan analyze -c ./phpstan.neon --memory-limit=2048M",
"phpunit": "./vendor/bin/phpunit --configuration ./phpunit.xml --verbose",
"test": [ "@phpsniff", "@phpstan", "@phpunit" ]
```

If moving PHPUnit from `tests/phpunit/` to `phpunit/`, update bootstrap paths. From `phpunit/bootstrap.php`, load Composer with:

```php
require_once dirname( __DIR__ ) . '/vendor/autoload.php';
```

## Composer Exports

Use `.gitattributes` to keep Composer installs clean. Exclude development-only files and root declaration files:

```gitattributes
.codex/              export-ignore
.github/             export-ignore
.gitattributes       export-ignore
cache/               export-ignore
/*.d.ts              export-ignore
node_modules/        export-ignore
src/                 export-ignore
tests/               export-ignore
phpunit/             export-ignore
phpcs.xml            export-ignore
phpstan.neon         export-ignore
phpunit.xml          export-ignore
```

Adjust entries to the package's actual runtime needs. Verify with:

```bash
git archive --worktree-attributes --format=tar HEAD | tar -tf -
```

## Release Packaging

For GitHub release zip workflows:

- keep release zip contents explicit in `composer.json` or the existing build script
- scope bundled runtime dependencies if the plugin ships as a standalone WordPress plugin
- exclude compiled container cache from Composer exports unless host projects manage the cache lifecycle
- update plugin header version, readmes, and changelog together

## Documentation

Update `README.md` and `readme.txt` to describe:

- standalone plugin bootstrap
- Composer dependency usage
- required dependency root path and URL arguments
- `Controller + Providers + Transformers + Services`
- fixed asset handles versus inherited package filters/actions
- clean Composer export behavior

## Verification

Run the repo's available checks after refactoring:

```bash
composer dump-autoload
composer run test
```

If the plugin has JavaScript/CSS assets, run the established build command too. Inspect renamed namespaces with `rg "Processors|Transformers|processor|transformer"` and leave `WP_HTML_Tag_Processor` references intact.
