<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://boomdevs.com/
 * @since             1.0.0
 * @package           Timeandtidebell_Vgm_Add_On
 *
 * @wordpress-plugin
 * Plugin Name:       Timeandtidebell VGM Add On
 * Plugin URI:        https://#
 * Description:       This is a description of the plugin.
 * Version:           1.0.0
 * Author:            Boomdevs
 * Author URI:        https://boomdevs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       timeandtidebell-vgm-add-on
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TIMEANDTIDEBELL_VGM_ADD_ON_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-timeandtidebell-vgm-add-on-activator.php
 */
function activate_timeandtidebell_vgm_add_on() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-timeandtidebell-vgm-add-on-activator.php';
	Timeandtidebell_Vgm_Add_On_Activator::activate();
}


/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-timeandtidebell-vgm-add-on-deactivator.php
 */
function deactivate_timeandtidebell_vgm_add_on() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-timeandtidebell-vgm-add-on-deactivator.php';
	Timeandtidebell_Vgm_Add_On_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_timeandtidebell_vgm_add_on' );
register_deactivation_hook( __FILE__, 'deactivate_timeandtidebell_vgm_add_on' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-timeandtidebell-vgm-add-on.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_timeandtidebell_vgm_add_on() {

	$plugin = new Timeandtidebell_Vgm_Add_On();
	$plugin->run();

}
run_timeandtidebell_vgm_add_on();

function ttb_wp_ajax_approve_marker(){
	var_dump("hello");
	die();
}
add_action( 'wp_ajax_approve_marker', 'ttb_wp_ajax_approve_marker', 9999);
