<?php

/**
 * Fired during plugin activation
 *
 * @link       http://ingmmo.com
 * @since      1.0.0
 *
 * @package    Asoc_Blogs
 * @subpackage Asoc_Blogs/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Asoc_Blogs
 * @subpackage Asoc_Blogs/includes
 * @author     Marco Montanari <marco.montanari@gmail.com>
 */
class Asoc_Blogs_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();	
	}

}
