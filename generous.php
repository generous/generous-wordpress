<?php
/**
 * Plugin Name:       Generous
 * Plugin URI:        https://genero.us
 * Description:       Integrate Generous sliders within your website. Official Generous plugin.
 * Version:           0.1.0
 * Author:            Generous
 * Author URI:        https://genero.us
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       generous
 * Domain Path:       /languages
 *
 * @since             0.1.0
 *
 * @package           WP_Generous
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Load Generous SDK
if ( ! class_exists( 'Generous' ) ) {
	require_once plugin_dir_path( __FILE__ ) . 'generous-sdk-php/src/Generous.php';
}

// Load initial dependencies
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-generous-activator.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-generous-deactivator.php';
require_once plugin_dir_path( __FILE__ ) . 'class-wp-generous.php';

register_activation_hook( __FILE__, array( 'WP_Generous_Activator', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Generous_Deactivator', 'deactivate' ) );

/**
 * Begins execution of the plugin.
 *
 * @since    0.1.0
 */
function wp_generous_init() {
	$plugin = new WP_Generous();
	$plugin->run();
}

wp_generous_init();