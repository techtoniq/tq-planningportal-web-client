<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       www.techtoniq.com
 * @since      1.0.0
 *
 * @package    Tq_Planningportal_Web_Client
 * @subpackage Tq_Planningportal_Web_Client/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Tq_Planningportal_Web_Client
 * @subpackage Tq_Planningportal_Web_Client/includes
 * @author     Techtoniq <matt@techtoniq.com>
 */
class Tq_Planningportal_Web_Client_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'tq-planningportal-web-client',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
