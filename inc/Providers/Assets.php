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

use Bmd\ButtonBlockEnhancements\Module;
use Bmd\ButtonBlockEnhancements\Services;

/**
 * Enqueues editor controls and shared block styles.
 */
class Assets extends Module
{
	/**
	 * Constructor.
	 *
	 * @param Services\ScriptLoader $script_loader Script loader service.
	 * @param Services\StyleLoader  $style_loader  Style loader service.
	 */
	public function __construct(
		protected Services\ScriptLoader $script_loader,
		protected Services\StyleLoader $style_loader,
	) {
	}

	/**
	 * Enqueue editor script and styles.
	 *
	 * @return void
	 */
	public function enqueueEditorAssets(): void
	{
		$this->script_loader->enqueue(
			handle: "{$this->package}-editor",
			src: 'build/editor.js'
		);

		wp_add_inline_script(
			"{$this->package}-editor",
			'window.buttonBlockEnhancements = ' . wp_json_encode(
				[
					'iconFamilies' => apply_filters( "{$this->package}_icon_families", [] ),
				]
			) . ';',
			'before'
		);

		$this->style_loader->enqueue(
			handle: "{$this->package}-editor-styles",
			src: 'build/editor.css'
		);
	}

	/**
	 * Register a block-specific stylesheet for the core Button block.
	 *
	 * @return void
	 */
	public function enqueueBlockStyles(): void
	{
		$this->style_loader->enqueueBlockStyle(
			block_name: 'core/button',
			handle: "{$this->package}-styles",
			src: 'build/styles.css',
		);
	}
}
