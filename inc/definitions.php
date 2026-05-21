<?php
/**
 * PHP-DI service definitions.
 *
 * @package Bmd\ButtonBlockEnhancements
 */

namespace Bmd\ButtonBlockEnhancements;

return [
	Controller::class                => \DI\autowire(),
	// Services
	Services\FilePathResolver::class => \DI\autowire(),
	Services\UrlResolver::class      => \DI\autowire(),
	Services\ScriptLoader::class     => \DI\autowire(),
	Services\StyleLoader::class      => \DI\autowire(),
	// Providers
	Providers\Assets::class          => \DI\autowire(),
	Providers\Icons::class           => \DI\autowire(),
	// Processors
	Processors\Icons::class          => \DI\autowire(),
	Processors\Colors::class         => \DI\autowire(),
];
