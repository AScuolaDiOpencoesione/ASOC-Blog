<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://ingmmo.com
 * @since      1.0.0
 *
 * @package    Asoc_Blogs
 * @subpackage Asoc_Blogs/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Asoc_Blogs
 * @subpackage Asoc_Blogs/includes
 * @author     Marco Montanari <marco.montanari@gmail.com>
 */
class Asoc_Blogs_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'asoc-blogs',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
