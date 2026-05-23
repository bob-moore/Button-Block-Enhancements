<?php
/**
 * Hook registrar — wires all static WordPress actions and filters.
 *
 * @package Bmd\ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @link    https://github.com/bob-moore/button-block-enhancements
 */

namespace Bmd\ButtonBlockEnhancements;

use DI\Attribute\Inject;

/**
 * Registers all static WordPress actions and filters for the plugin.
 *
 * PHP-DI calls registerActions() and registerFilters() automatically after
 * construction via method injection. All hook registration lives here so no
 * other class ever calls add_action() or add_filter() directly.
 */
class Controller extends Module
{
	/**
	 * Register WordPress action hooks.
	 *
	 * @param Providers\Assets $assets Asset provider.
	 *
	 * @return void
	 */
	#[Inject]
	public function registerActions(
		Providers\Assets $assets,
	): void {
		add_action( 'enqueue_block_editor_assets', [ $assets, 'enqueueEditorAssets' ] );
		add_action( 'init', [ $assets, 'enqueueBlockStyles' ] );
	}

	/**
	 * Register WordPress filter hooks.
	 *
	 * @param Transformers\Icons  $icons          Icon block transformer.
	 * @param Transformers\Colors $colors         Color block transformer.
	 * @param Providers\Icons     $icon_provider  Icon family provider.
	 *
	 * @return void
	 */
	#[Inject]
	public function registerFilters(
		Transformers\Icons $icons,
		Transformers\Colors $colors,
		Providers\Icons $icon_provider,
	): void {
		add_filter( 'render_block_core/button', [ $icons, 'renderBlock' ], 10, 2 );
		add_filter( 'render_block_core/button', [ $colors, 'renderBlock' ], 10, 2 );
		add_filter( "{$this->package}_icon_families", [ $icon_provider, 'provideIconFamilies' ] );
	}
}
