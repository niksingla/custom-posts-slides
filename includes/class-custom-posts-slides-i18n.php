<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://linkedin.com/in/programmernik/
 * @since      1.0.0
 *
 * @package    Custom_Posts_Slides
 * @subpackage Custom_Posts_Slides/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Custom_Posts_Slides
 * @subpackage Custom_Posts_Slides/includes
 * @author     Nikhil <nikhilsingla1@outlook.com>
 */
class Custom_Posts_Slides_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'custom-posts-slides',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
