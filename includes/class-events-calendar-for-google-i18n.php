<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://blueplugins.com/
 * @since      1.0.0
 *
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    ECFG_Events_Calendar_for_Google
 * @subpackage ECFG_Events_Calendar_for_Google/includes
 * @author     Blue Plugins <rupinder.php@gmail.com>
 */
class ECFG_events_calendar_google_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'events-calendar-for-google',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
