<?php
/**
 * Main app file
 *
 * PHP Version 8.2
 *
 * @package Bmd_ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/button-block-enhancements
 * @since   1.0.0
 */

namespace Bmd\ButtonBlockEnhancements;

use Bmd\WPFramework;
use Bmd\WPFramework\Services\ServiceLocator;

/**
 * Main App Class
 *
 * Defines the service container and mounts the plugin.
 *
 * @subpackage Traits
 */
class Main extends WPFramework\Main
{
	/**
	 * The name of the plugin.
	 *
	 * @var string
	 */
	public const PACKAGE = 'button_block_enhancements';

	/**
	 * Get service container definitions
	 *
	 * Defines the providers that should be available in the service container.
	 *
	 * @since  1.0.0
	 * @access public
	 *
	 * @return array<string, mixed> Array of service definitions.
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			Controllers\ProcessorController::class => ServiceLocator::autowire(),
			Controllers\ContextController::class   => ServiceLocator::autowire(),
			Controllers\ProviderController::class  => ServiceLocator::autowire(),
			Controllers\ServiceController::class   => ServiceLocator::autowire(),
		];
	}
}
