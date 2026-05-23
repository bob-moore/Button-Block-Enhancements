<?php
/**
 * Plugin bootstrap.
 *
 * @wordpress-plugin
 * Plugin Name: Button Block Enhancements
 * Plugin URI:  https://github.com/bob-moore/button-block-enhancements
 * Description: Enable hover/focus colors and icons for the core/button block.
 * Version:     1.2.1
 * Author:      Bob Moore
 * Author URI:  https://www.bobmoore.dev
 * Requires at least: 6.9
 * Tested up to: 7.0
 * Requires PHP: 8.2
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: button_block_enhancements
 *
 * @package Bmd\ButtonBlockEnhancements
 */

namespace Bmd\ButtonBlockEnhancements;

use Bmd\GithubWpUpdater;

defined( 'ABSPATH' ) || exit;

/**
 * Load dependencies and mount the plugin after WordPress has loaded plugins.
 *
 * @return void
 */
function burn_baby_burn(): void
{
	try {
		$scoped_autoload   = plugin_dir_path( __FILE__ ) . 'vendor/scoped/autoload.php';
		$scoper_autoload   = plugin_dir_path( __FILE__ ) . 'vendor/scoped/scoper-autoload.php';
		$composer_autoload = plugin_dir_path( __FILE__ ) . 'vendor/autoload.php';

		if ( is_file( $scoped_autoload ) && is_file( $scoper_autoload ) ) {
			require_once $scoped_autoload;
			require_once $scoper_autoload;
		}

		if ( ! is_file( $composer_autoload ) ) {
			throw new \RuntimeException( 'Button Block Enhancements dependencies are missing. Run composer install before activating the plugin.' );
		}

		require_once $composer_autoload;

		$plugin = new Main(
			[
				'package' => 'button_block_enhancements',
				'version' => '1.2.1',
				'path'    => plugin_dir_path( __FILE__ ),
				'url'     => plugin_dir_url( __FILE__ ),
			]
		);
		$plugin->mount();

	} catch ( \Throwable $e ) {
		error_log( $e->getMessage() );
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\burn_baby_burn' );

/**
 * Initialize the update function from github
 *
 * @return void
 */
function update_from_github(): void
{
	try {
		$updater = new GithubWpUpdater(
			__FILE__,
			[
				'github.user' => 'bob-moore',
				'github.repo' => 'Button-Block-Enhancements',
				'github.branch' => 'main',
				'plugin.banners' => [
					'low' => plugin_dir_url( __FILE__ ) . 'assets/banner-large.webp',
					'high' => plugin_dir_url( __FILE__ ) . 'assets/banner-small.webp',
				],
				'plugin.icons' => [
					'default' => plugin_dir_url( __FILE__ ) . 'assets/icon.webp',
				],
			]
		);
		$updater->mount();
	} catch ( \Error $e ) {
		error_log( $e->getMessage() );
	}
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\update_from_github' );
