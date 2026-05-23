<?php
/**
 * PHP-DI service definitions.
 *
 * @package Bmd\ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @link    https://github.com/bob-moore/button-block-enhancements
 */

namespace Bmd\ButtonBlockEnhancements;

return [
	Controller::class                => \DI\autowire(),
	// Services.
	Services\FilePathResolver::class => \DI\autowire(),
	Services\UrlResolver::class      => \DI\autowire(),
	Services\ScriptLoader::class     => \DI\autowire(),
	Services\StyleLoader::class      => \DI\autowire(),
	// Providers.
	Providers\Assets::class          => \DI\autowire(),
	Providers\Icons::class           => \DI\autowire(),
	// Transformers.
	Transformers\Icons::class        => \DI\autowire(),
	Transformers\Colors::class       => \DI\autowire(),
];
