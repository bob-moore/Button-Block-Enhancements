<?php
/**
 * Processor Controller
 *
 * Manages and coordinates the registration and execution of processors
 * that handle specific data processing tasks within the application.
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

use Bmd\ButtonBlockEnhancements\Processors;
use Bmd\WPFramework\Services\ServiceLocator;
use Bmd\WPFramework\Abstracts;

use DI\Attribute\Inject;

/**
 * Processor Controller Class
 *
 * Handles the registration and management of data processors in the application.
 * Processors are responsible for handling specific data transformation or processing tasks.
 *
 * @subpackage Controllers
 * @since      1.0.0
 */
class ProcessorController extends Abstracts\Controller
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
		return [
			Processors\Colors::class => ServiceLocator::autowire(),
			Processors\Icons::class  => ServiceLocator::autowire(),
		];
	}

	/**
	 * Mount the color processor.
	 *
	 * @param Processors\Colors $handler Instance of the Colors class.
	 *
	 * @return void
	 */
	#[Inject]
	public function mountColorProcessor( Processors\Colors $handler ): void
	{
		add_filter( 'render_block_core/button', [ $handler, 'processButtonFocusColors' ], 10, 2 );
	}

	/**
	 * Mount the icon processor.
	 *
	 * @param Processors\Icons $handler Instance of the Icons class.
	 *
	 * @return void
	 */
	#[Inject]
	public function mountIconProcessor( Processors\Icons $handler ): void
	{
		add_filter( 'render_block_core/button', [ $handler, 'renderIcon' ], 10, 2 );
	}
}
