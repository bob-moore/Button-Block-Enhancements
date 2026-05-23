<?php
/**
 * Resolver service tests.
 *
 * @package Bmd\ButtonBlockEnhancements
 */

namespace Bmd\ButtonBlockEnhancements\PHPUnit;

use Bmd\ButtonBlockEnhancements\Services\FilePathResolver;
use Bmd\ButtonBlockEnhancements\Services\UrlResolver;
use WP_Mock\Tools\TestCase;

/**
 * @covers \Bmd\ButtonBlockEnhancements\Services\FilePathResolver
 * @covers \Bmd\ButtonBlockEnhancements\Services\UrlResolver
 */
final class ResolverTest extends TestCase
{
	/**
	 * File paths are normalized without forcing a trailing slash.
	 *
	 * @return void
	 */
	public function testFilePathResolverAppendsRelativePaths(): void
	{
		$resolver = new FilePathResolver( '/var/www/plugin/' );

		$this->assertSame( '/var/www/plugin', $resolver->resolve() );
		$this->assertSame( '/var/www/plugin/build/editor.js', $resolver->resolve( '/build/editor.js' ) );
	}

	/**
	 * URLs are normalized without adding a trailing slash to file assets.
	 *
	 * @return void
	 */
	public function testUrlResolverAppendsRelativePaths(): void
	{
		$resolver = new UrlResolver( 'https://example.test/plugin/' );

		$this->assertSame( 'https://example.test/plugin', $resolver->resolve() );
		$this->assertSame( 'https://example.test/plugin/build/editor.js', $resolver->resolve( '/build/editor.js' ) );
	}
}
