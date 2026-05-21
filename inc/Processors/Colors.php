<?php
/**
 * Button color processor.
 *
 * @package Bmd\ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @link    https://github.com/bob-moore/button-block-enhancements
 */

namespace Bmd\ButtonBlockEnhancements\Processors;

use Bmd\ButtonBlockEnhancements\Module;

/**
 * Adds focus and hover color custom properties to core/button markup.
 */
class Colors extends Module
{
	/**
	 * Add frontend focus/hover color variables to the core/button wrapper.
	 *
	 * @param string               $block_content HTML output of the block.
	 * @param array<string, mixed> $block         Parsed block.
	 *
	 * @return string
	 */
	public function renderBlock( string $block_content, array $block ): string
	{
		$focus_color            = $block['attrs']['bmdFocusColor'] ?? '';
		$focus_background_color = $block['attrs']['bmdFocusBackgroundColor'] ?? '';

		if ( empty( $focus_color ) && empty( $focus_background_color ) ) {
			return $block_content;
		}

		$processor = new \WP_HTML_Tag_Processor( $block_content );

		if ( ! $processor->next_tag( [ 'class_name' => 'wp-block-button' ] ) ) {
			return $block_content;
		}

		$existing_classes = preg_split( '/\s+/', (string) $processor->get_attribute( 'class' ) );
		$existing_classes = is_array( $existing_classes ) ? $existing_classes : [];

		$classes = array_filter(
			array_unique(
				array_merge(
					array_filter(
						$existing_classes,
						static fn ( string $class_name ): bool => 'has-bmd-focus-colors' !== $class_name
					),
					[
						! empty( $focus_color ) ? 'has-bmd-focus-color' : '',
						! empty( $focus_background_color ) ? 'has-bmd-focus-background-color' : '',
					]
				)
			)
		);

		$existing_style = trim( (string) $processor->get_attribute( 'style' ) );

		if ( '' !== $existing_style && ! str_ends_with( $existing_style, ';' ) ) {
			$existing_style .= ';';
		}

		$styles = array_filter(
			[
				$existing_style,
				! empty( $focus_color )
					? sprintf( '--bmd-button-focus-color:%s;', sanitize_text_field( $focus_color ) )
					: '',
				! empty( $focus_background_color )
					? sprintf( '--bmd-button-focus-background-color:%s;', sanitize_text_field( $focus_background_color ) )
					: '',
			]
		);

		$processor->set_attribute( 'class', implode( ' ', $classes ) );
		$processor->set_attribute( 'style', implode( '', $styles ) );

		return $processor->get_updated_html();
	}
}
