<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://ingmmo.com
 * @since             1.0.2
 * @package           Asoc_Blogs
 *
 * @wordpress-plugin
 * Plugin Name:       asoc-blogs
 * Plugin URI:        http://www.ascuoladiopencoesione.it/asoc-blogs
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.2
 * Author:            Marco Montanari
 * Author URI:        http://ingmmo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       asoc-blogs
 * Domain Path:       /languages
 * Network:           true
 * GitHub Plugin URI: https://github.com/afragen/github-updater
 * GitHub Branch:     master
 * GitHub Languages:  https://github.com/afragen/github-updater-translations
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-asoc-blogs-activator.php
 */
function activate_asoc_blogs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-asoc-blogs-activator.php';
	Asoc_Blogs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-asoc-blogs-deactivator.php
 */
function deactivate_asoc_blogs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-asoc-blogs-deactivator.php';
	Asoc_Blogs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_asoc_blogs' );
register_deactivation_hook( __FILE__, 'deactivate_asoc_blogs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-asoc-blogs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_asoc_blogs() {

	$plugin = new Asoc_Blogs();
	$plugin->run();

}
run_asoc_blogs();
