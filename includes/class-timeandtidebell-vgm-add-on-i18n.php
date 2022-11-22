<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://boomdevs.com/
 * @since      1.0.0
 *
 * @package    Timeandtidebell_Vgm_Add_On
 * @subpackage Timeandtidebell_Vgm_Add_On/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Timeandtidebell_Vgm_Add_On
 * @subpackage Timeandtidebell_Vgm_Add_On/includes
 * @author     Boomdevs <contact@boomdevs.com>
 */
class Timeandtidebell_Vgm_Add_On_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'timeandtidebell-vgm-add-on',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
