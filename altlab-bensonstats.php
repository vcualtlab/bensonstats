<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://luetkemj.github.io
 * @since             1.0.0
 * @package           Altlab_Bensonstats
 *
 * @wordpress-plugin
 * Plugin Name:       ALT Lab Benson Stats
 * Plugin URI:        https://github.com/vcualtlab/bensonstats
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Mark Luetke
 * Author URI:        http://luetkemj.github.io
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       altlab-bensonstats
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-altlab-bensonstats-activator.php
 */
function activate_altlab_bensonstats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-altlab-bensonstats-activator.php';
	Altlab_Bensonstats_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-altlab-bensonstats-deactivator.php
 */
function deactivate_altlab_bensonstats() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-altlab-bensonstats-deactivator.php';
	Altlab_Bensonstats_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_altlab_bensonstats' );
register_deactivation_hook( __FILE__, 'deactivate_altlab_bensonstats' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-altlab-bensonstats.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_altlab_bensonstats() {

	$plugin = new Altlab_Bensonstats();
	$plugin->run();

}
run_altlab_bensonstats();
