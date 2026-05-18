<?php
/**
 * Editor Context Handler Definition
 *
 * PHP Version 8.2
 *
 * @package button_block_enhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/button-block-enhancements
 * @since   1.0.0
 */

namespace Bmd\ButtonBlockEnhancements\Context;

use Bmd\WPFramework\Context\Admin;

/**
 * Editor context handler
 *
 * @subpackage Context
 */
class Editor extends Admin
{
	/**
	 * Do something specific for editor page context,
	 * for example, enqueue editor-specific assets or set up data for the block editor.
	 */
	public function enqueueEditorAssets(): void
	{
		$this->enqueueScript(
			handle: "{$this->package}-editor",
			path: 'build/editor.js'
		);

		wp_add_inline_script(
			str_replace( '_', '-', "{$this->package}-editor" ),
			'window.buttonBlockEnhancements = ' . wp_json_encode(
				[
					'iconFamilies' => $this->getIconFamilies(),
				]
			) . ';',
			'before'
		);

		$this->enqueueStyle(
			handle: "{$this->package}-editor",
			path: 'build/editor.css'
		);
	}

	/**
	 * Get icon families available to the editor.
	 *
	 * @return array<string, array{label: string, url: string}>
	 */
	protected function getIconFamilies(): array
	{
		$filtered_icon_families = apply_filters( 'button_block_enhancements_icon_families', [] );

		if ( ! is_array( $filtered_icon_families ) ) {
			return [];
		}

		$valid_families = [];

		foreach ( $filtered_icon_families as $slug => $family ) {
			if (
				! is_string( $slug ) ||
				! is_array( $family ) ||
				empty( $family['label'] ) ||
				empty( $family['url'] ) ||
				! is_string( $family['label'] ) ||
				! is_string( $family['url'] )
			) {
				continue;
			}

			$valid_families[ sanitize_key( $slug ) ] = [
				'label' => sanitize_text_field( $family['label'] ),
				'url'   => esc_url_raw( $family['url'] ),
			];
		}

		return $valid_families;
	}

}
