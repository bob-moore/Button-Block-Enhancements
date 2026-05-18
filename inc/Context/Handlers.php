<?php
/**
 * Context Type Enum
 *
 * Defines the available context types for the application
 *
 * @package Bmd_ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/button-block-enhancements
 * @since   1.0.0
 */

namespace Bmd\ButtonBlockEnhancements\Context;

/**
 * Context Type Enumeration
 *
 * Defines all available context handlers for different WordPress page types
 *
 * @subpackage Context
 */
enum Handlers: string
{
	/** EDITOR page handler */
	case EDITOR = Editor::class;
	/** No specific handler */
	case NONE = '';
}
