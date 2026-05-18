<?php
/**
 * Provider Controller
 *
 * Manages and coordinates various WordPress functionality providers,
 * including blocks, context handling, images, patterns, editor settings,
 * and template parts.
 *
 * PHP Version 8.2
 *
 * @package    Bmd_ButtonBlockEnhancements
 * @subpackage Controllers
 * @author     Bob Moore <bob@bobmoore.dev>
 * @license    GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link       https://github.com/bob-moore/button-block-enhancements
 * @since      1.0.0
 */

namespace Bmd\ButtonBlockEnhancements\Controllers;

use Bmd\ButtonBlockEnhancements\Providers;
use Bmd\WPFramework;
use Bmd\WPFramework\Services\ServiceLocator;

use DI\Attribute\Inject;

/**
 * Provider Controller Class
 *
 * Controls the registration and execution of WordPress functionality providers.
 * Extends the framework's base provider controller with plugin-specific providers.
 *
 * @subpackage Controllers
 * @since      1.0.0
 */
class ProviderController extends WPFramework\Controllers\ProviderController
{
	/**
	 * Get service container definitions
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return array<string, mixed> Array of service definitions.
	 */
	public static function getServiceDefinitions(): array
	{
		return array_merge(
			parent::getServiceDefinitions(),
			[
				Providers\Icons::class => ServiceLocator::autowire(),
			]
		);
	}

	/**
	 * Mount Icons Provider
	 *
	 * @param Providers\Icons $provider Instance of Icons provider.
	 *
	 * @return void
	 */
	#[Inject]
	public function mountIcons( Providers\Icons $provider ): void
	{
		add_filter( 'button_block_enhancements_icon_families', [ $provider, 'provideIconFamilies' ], 1 );
	}
}
