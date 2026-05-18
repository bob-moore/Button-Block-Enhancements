<?php
/**
 * Plugin service container and hook loader.
 *
 * @package Bmd\ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later https://www.gnu.org/licenses/gpl-2.0.html
 * @link    https://github.com/bob-moore/button-block-enhancements
 */

namespace Bmd\ButtonBlockEnhancements;

/**
 * Builds the plugin container and registers WordPress hooks.
 */
class Controller
{
	/**
	 * Compiled container class name.
	 */
	protected const COMPILED_CONTAINER_CLASS = 'ButtonBlockEnhancementsCompiledContainer';

	/**
	 * Shared service container.
	 *
	 * @var \DI\Container|null
	 */
	protected static ?\DI\Container $services = null;

	/**
	 * Constructor.
	 *
	 * @param string $url  Plugin directory URL.
	 * @param string $path Plugin directory path.
	 * @param bool   $cache Whether to compile the container into the plugin cache directory.
	 */
	public function __construct(
		protected string $url = '',
		protected string $path = '',
		protected bool $cache = false,
	) {
		if ( empty( self::$services ) ) {
			$this->init();
		}
	}

	/**
	 * Build the service container.
	 *
	 * @return void
	 */
	protected function init(): void
	{
		$container_builder = new \DI\ContainerBuilder();

		$container_builder->useAttributes( true );

		$container_builder->addDefinitions(
			[
				Services\FilePathResolver::class => \DI\autowire(),
				Services\UrlResolver::class      => \DI\autowire(),
				Providers\Icons::class           => \DI\autowire(),
				Processors\Icons::class          => \DI\autowire(),
				Providers\Assets::class          => \DI\autowire(),
				Processors\Colors::class         => \DI\autowire(),
			]
		);

		if ( $this->cache ) {
			$container_builder->enableCompilation(
				dirname( __DIR__ ) . '/cache',
				self::COMPILED_CONTAINER_CLASS
			);
		}

		self::$services = $container_builder->build();
		self::$services->set( 'config.path', ! empty( $this->path ) ? $this->path : Utilities::getPath() );
		self::$services->set( 'config.url', ! empty( $this->url ) ? $this->url : Utilities::getUrl() );
	}

	/**
	 * Update the root URL used by URL-aware services.
	 *
	 * @param string $url Plugin directory URL.
	 *
	 * @return void
	 */
	public function setUrl( string $url ): void
	{
		self::$services->get( Services\UrlResolver::class )->setUrl( $url );
	}

	/**
	 * Update the root path used by file path-aware services.
	 *
	 * @param string $path Plugin directory path.
	 *
	 * @return void
	 */
	public function setPath( string $path ): void
	{
		self::$services->get( Services\FilePathResolver::class )->setDir( $path );
	}

	/**
	 * Register all plugin hooks.
	 *
	 * @return void
	 */
	public function mount(): void
	{
		$this->mountActions();
		$this->mountFilters();
	}

	/**
	 * Register WordPress actions.
	 *
	 * @return void
	 */
	protected function mountActions(): void
	{
		add_action(
			'enqueue_block_editor_assets',
			[
				self::$services->get( Providers\Assets::class ),
				'enqueueEditorAssets',
			]
		);
		add_action(
			'init',
			[
				self::$services->get( Providers\Assets::class ),
				'enqueueBlockStyles',
			]
		);
		add_filter(
			'button_block_enhancements_icon_families',
			[
				self::$services->get( Providers\Icons::class ),
				'provideIconFamilies',
			]
		);
	}

	/**
	 * Register WordPress filters.
	 *
	 * @return void
	 */
	protected function mountFilters(): void
	{
		add_filter(
			'render_block_core/button',
			[
				self::$services->get( Processors\Icons::class ),
				'renderBlock',
			],
			10,
			2
		);
		add_filter(
			'render_block_core/button',
			[
				self::$services->get( Processors\Colors::class ),
				'renderBlock',
			],
			10,
			2
		);
	}

	/**
	 * Get a service from the initialized container.
	 *
	 * @param string $service Service class or entry name.
	 *
	 * @return object|null Service instance, or null before bootstrap has run.
	 */
	public static function getInstance( string $service ): ?object
	{
		return self::$services instanceof \DI\Container && self::$services->has( $service )
			? self::$services->get( $service )
			: null;
	}
}
