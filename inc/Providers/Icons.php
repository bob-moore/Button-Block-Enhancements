<?php
/**
 * Icons Provider
 *
 * PHP Version 8.2
 *
 * @package    Bmd_ButtonBlockEnhancements
 * @subpackage Providers
 * @author     Bob Moore <bob@bobmoore.dev>
 * @license    GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link       https://github.com/bob-moore/button-block-enhancements
 * @since      1.0.0
 */

namespace Bmd\ButtonBlockEnhancements\Providers;

use Bmd\WPFramework\Abstracts;
use Bmd\WPFramework\Services\UrlResolver;

/**
 * Provides built-in icon families via the icon families filter.
 *
 * @subpackage Providers
 */
class Icons extends Abstracts\Module
{
	/**
	 * Public constructor
	 *
	 * @param UrlResolver $url_resolver : url resolver service instance.
	 * @param string      $package      : package name, optional.
	 */
	public function __construct(
		protected UrlResolver $url_resolver,
		string $package = ''
	) {
		parent::__construct( $package );
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
