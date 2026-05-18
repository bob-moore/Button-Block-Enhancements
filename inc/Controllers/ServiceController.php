<?php
/**
 * Service Controller
 *
 * Manages and coordinates core service components of the application,
 * including script loading, style loading, and path resolution services.
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

use Bmd\WPFramework;

/**
 * Service Controller Class
 *
 * Controls the registration and execution of core application services.
 * Extends the framework's base service controller with plugin-specific services.
 *
 * @subpackage Controllers
 * @since      1.0.0
 */
class ServiceController extends WPFramework\Controllers\ServiceController
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
			[]
		);
	}
}
