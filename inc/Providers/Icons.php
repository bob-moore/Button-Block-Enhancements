<?php
/**
 * Icon family provider.
 *
 * @package Bmd\ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @link    https://github.com/bob-moore/button-block-enhancements
 */

namespace Bmd\ButtonBlockEnhancements\Providers;

use Bmd\ButtonBlockEnhancements\Module;
use Bmd\ButtonBlockEnhancements\Services\UrlResolver;

/**
 * Provides built-in icon families via the icon families filter.
 */
class Icons extends Module
{
	/**
	 * Constructor.
	 *
	 * @param UrlResolver $url_resolver URL resolver.
	 */
	public function __construct(
		protected UrlResolver $url_resolver
	) {
	}

	/**
	 * Provide built-in icon families to the icon families filter.
	 *
	 * @param array<string, array{label: string, url: string}> $families Families added by earlier filters.
	 *
	 * @return array<string, array{label: string, url: string}>
	 */
	public function provideIconFamilies( array $families ): array
	{
		return array_merge(
			[
				'wordpress'    => [
					'label' => __( 'WordPress', 'button_block_enhancements' ),
					'url'   => $this->url_resolver->resolve( 'assets/icons/wordpress.json' ),
				],
				'mui'          => [
					'label' => __( 'MUI', 'button_block_enhancements' ),
					'url'   => $this->url_resolver->resolve( 'assets/icons/mui.json' ),
				],
				'mui-outlined' => [
					'label' => __( 'MUI - Outlined', 'button_block_enhancements' ),
					'url'   => $this->url_resolver->resolve( 'assets/icons/mui-outlined.json' ),
				],
				'mui-rounded'  => [
					'label' => __( 'MUI - Rounded', 'button_block_enhancements' ),
					'url'   => $this->url_resolver->resolve( 'assets/icons/mui-rounded.json' ),
				],
				'mui-sharp'    => [
					'label' => __( 'MUI - Sharp', 'button_block_enhancements' ),
					'url'   => $this->url_resolver->resolve( 'assets/icons/mui-sharp.json' ),
				],
			],
			$families
		);
	}
}
