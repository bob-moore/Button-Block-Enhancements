<?php
/**
 * Asset provider.
 *
 * @package Bmd\ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @link    https://github.com/bob-moore/button-block-enhancements
 */

namespace Bmd\ButtonBlockEnhancements\Providers;

use Bmd\ButtonBlockEnhancements\Services;

/**
 * Enqueues editor controls and shared block styles.
 */
class Assets
{
	/**
	 * Constructor.
	 *
	 * @param Services\UrlResolver      $url_resolver       URL resolver.
	 * @param Services\FilePathResolver $file_path_resolver File path resolver.
	 */
	public function __construct(
		protected Services\UrlResolver $url_resolver,
		protected Services\FilePathResolver $file_path_resolver
	) {
	}

	/**
	 * Enqueue editor script and styles.
	 *
	 * @return void
	 */
	public function enqueueEditorAssets(): void
	{

		$asset_data = $this->getAssetData( 'editor' );

		wp_enqueue_script(
			handle: 'button-block-enhancements-editor',
			src: $this->url_resolver->resolve( 'build/editor.js' ),
			deps: $asset_data['dependencies'],
			ver: $asset_data['version']
		);

		wp_add_inline_script(
			str_replace( '_', '-', 'button-block-enhancements-editor' ),
			'window.buttonBlockEnhancements = ' . wp_json_encode(
				[
					'iconFamilies' => apply_filters( 'button_block_enhancements_icon_families', [] ),
				]
			) . ';',
			'before'
		);

		wp_enqueue_style(
			handle: 'enable-button-icons-editor-styles',
			src: $this->url_resolver->resolve( 'build/editor.css' ),
			deps: [],
			ver: $asset_data['version']
		);
	}

	/**
	 * Register block styles for the core Button block.
	 *
	 * @return void
	 */
	public function enqueueBlockStyles(): void
	{
		wp_enqueue_block_style(
			'core/button',
			[
				'handle' => 'button-block-enhancements-styles',
				'src'    => $this->url_resolver->resolve( 'build/styles.css' ),
				'ver'    => '1.0.0',
				'path'   => $this->file_path_resolver->resolve( 'build/styles.css' ),
			]
		);
	}

	/**
	 * Resolve script dependency metadata from WordPress build asset files.
	 *
	 * @param string $key Build asset key without the `.asset.php` suffix.
	 *
	 * @return array{dependencies: array<int, string>, version: string|null}
	 */
	protected function getAssetData( string $key ): array
	{
		$asset_file = $this->file_path_resolver->resolve( "build/{$key}.asset.php" );

		if ( ! is_file( $asset_file ) ) {
			return [
				'dependencies' => [],
				'version'      => null,
			];
		}

		$data = include $asset_file;

		if ( ! is_array( $data ) ) {
			return [
				'dependencies' => [],
				'version'      => null,
			];
		}

		$dependencies = $data['dependencies'] ?? [];
		$version      = $data['version'] ?? null;

		return [
			'dependencies' => is_array( $dependencies ) ? $dependencies : [],
			'version'      => is_string( $version ) ? $version : null,
		];
	}
}
