<?php
/**
 * Plugin bootstrap file
 *
 * PHP Version 8.2
 *
 * @package Bmd_ButtonBlockEnhancements
 * @author  Bob Moore <bob@bobmoore.dev>
 * @license GPL-2.0-or-later
 * @link    https://github.com/bob-moore/button-block-enhancements
 * @since   1.0.0
 *
 * @wordpress-plugin
 * Plugin Name: Button Block Enhancements
 * Plugin URI:  https://github.com/bob-moore/button-block-enhancements
 * Description: Enable hover/focus colors and icons for the core/button block.
 * Version:     1.0.0
 * Author:      Bob Moore
 * Author URI:  https://www.bobmoore.dev
 * Requires at least: 6.9
 * Tested up to: 7.0
 * Requires PHP: 8.2
 * License:     GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: button_block_enhancements
 */

namespace Bmd\ButtonBlockEnhancements;

use Bmd\GithubWpUpdater;

defined( 'ABSPATH' ) || exit;

/**
 * Autoload dependencies and initialize the plugin.
 *
 * This function is hooked to the 'plugins_loaded' action to ensure that
 * all plugins are loaded before this plugin initializes.
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

		require_once $composer_autoload;

		$config = [
			'config.package' => Main::PACKAGE,
			'config.dir'     => plugin_dir_path( __FILE__ ),
			'config.url'     => plugin_dir_url( __FILE__ ),
		];

		$plugin = new Main( $config );
		$plugin->mount();

	} catch ( \Error $e ) {
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