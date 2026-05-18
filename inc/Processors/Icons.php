<?php
/**
 * Button icon processor.
 *
 * PHP Version 8.2
 *
 * @package    Bmd_ButtonBlockEnhancements
 * @subpackage Processors
 * @author     Bob Moore <bob@bobmoore.dev>
 * @license    GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link       https://github.com/bob-moore/button-block-enhancements
 * @since      1.0.0
 */

namespace Bmd\ButtonBlockEnhancements\Processors;

use Bmd\WPFramework\Abstracts;

/**
 * Adds stored button icons to core/button frontend markup.
 *
 * @subpackage Processors
 */
class Icons extends Abstracts\Module
{
	/**
	 * Allowed SVG tags and attributes for stored icons.
	 *
	 * @return array<string, array<string, bool>>
	 */
	protected function getAllowedSvgTags(): array
	{
		return [
			'svg'    => [
				'xmlns'           => true,
				'viewbox'         => true,
				'width'           => true,
				'height'          => true,
				'fill'            => true,
				'stroke'          => true,
				'stroke-width'    => true,
				'stroke-linecap'  => true,
				'stroke-linejoin' => true,
				'aria-hidden'     => true,
				'focusable'       => true,
				'class'           => true,
				'role'            => true,
			],
			'path'   => [
				'd'         => true,
				'fill'      => true,
				'stroke'    => true,
				'fill-rule' => true,
				'clip-rule' => true,
			],
			'circle' => [
				'cx'     => true,
				'cy'     => true,
				'r'      => true,
				'fill'   => true,
				'stroke' => true,
			],
			'rect'   => [
				'x'      => true,
				'y'      => true,
				'width'  => true,
				'height' => true,
				'rx'     => true,
				'ry'     => true,
				'fill'   => true,
				'stroke' => true,
			],
			'line'   => [
				'x1'     => true,
				'y1'     => true,
				'x2'     => true,
				'y2'     => true,
				'stroke' => true,
			],
			'g'      => [
				'fill'      => true,
				'stroke'    => true,
				'transform' => true,
			],
			'use'    => [
				'href'       => true,
				'xlink:href' => true,
			],
			'defs'   => [],
			'title'  => [],
		];
	}

	/**
	 * Render icons on core Button blocks.
	 *
	 * @param string               $block_content Rendered block markup.
	 * @param array<string, mixed> $block         Parsed block data.
	 *
	 * @return string Filtered block markup.
	 */
	public function renderIcon( string $block_content, array $block ): string
	{
		$icon = $block['attrs']['icon'] ?? null;

		if ( ! is_array( $icon ) ) {
			return $block_content;
		}

		$icon_src  = $icon['src'] ?? null;
		$icon_name = $icon['name'] ?? null;

		if ( ! is_string( $icon_src ) || ! is_string( $icon_name ) || '' === $icon_src || '' === $icon_name ) {
			return $block_content;
		}

		$position_left = ! empty( $block['attrs']['iconPositionLeft'] );
		$icon_size     = $block['attrs']['iconSize'] ?? '';
		$safe_svg      = wp_kses( $icon_src, $this->getAllowedSvgTags() );

		$processor = new \WP_HTML_Tag_Processor( $block_content );

		if ( $processor->next_tag() ) {
			$processor->add_class( 'has-icon__' . sanitize_html_class( $icon_name ) );

			if ( $position_left ) {
				$processor->add_class( 'has-icon-position__left' );
			}

			if ( is_string( $icon_size ) && '' !== trim( $icon_size ) ) {
				$current_style = (string) $processor->get_attribute( 'style' );
				$size_style    = '--bmd-button-icon-size:' . sanitize_text_field( $icon_size ) . ';';

				$processor->set_attribute( 'style', trim( $current_style . ' ' . $size_style ) );
			}
		}

		$block_content = $processor->get_updated_html();
		$icon_span     = '<span class="wp-block-button__link-icon" aria-hidden="true">' . $safe_svg . '</span>';
		$replacement   = $position_left ? '$1' . $icon_span . '$2$3' : '$1$2' . $icon_span . '$3';
		$updated       = preg_replace( '/(<a[^>]*>)(.*?)(<\/a>)/is', $replacement, $block_content );

		return is_string( $updated ) ? $updated : $block_content;
	}
}
