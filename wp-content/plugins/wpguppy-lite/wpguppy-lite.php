<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://themeforest.net/user/amentotech/
 * @since             1.0.0
 * @package           WpGuppy_Lite
 *
 * @wordpress-plugin
 * Plugin Name:       WPGuppy Lite
 * Plugin URI:        https://wp-guppy.com/
 * Description:       WPGuppy Lite is a well thought and clinically designed and developed WordPress chat plugin which has been engineered to fulfil the market needs. It is loaded with features without compromising on quality.
 * Version:           1.0.8
 * Author:            Amento Tech Pvt ltd
 * Author URI:        https://themeforest.net/user/amentotech/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wpguppy-lite
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

define( 'WP_GUPPY_LITE_VERSION', '1.0.8' );
define( 'WP_GUPPY_LITE_DIRECTORY', plugin_dir_path( __FILE__ ));
define( 'WP_GUPPY_LITE_DIRECTORY_URI', plugin_dir_url( __FILE__ ));
define( 'WP_GUPPY_ACTIVE_THEME_DIRECTORY', get_stylesheet_directory());
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-guppy-lite-activator.php
 */
function activate_wp_guppy_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-guppy-lite-activator.php';
	Wp_Guppy_Lite_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-guppy-lite-deactivator.php
 */
function deactivate_wp_guppy_lite() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-guppy-lite-deactivator.php';
	Wp_Guppy_Lite_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_guppy_lite' );
register_deactivation_hook( __FILE__, 'deactivate_wp_guppy_lite' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-guppy-lite.php';
require plugin_dir_path( __FILE__ ) . 'includes/functions.php';
require plugin_dir_path( __FILE__ ) . 'admin/settings/settings.php';
require plugin_dir_path( __FILE__ ) . 'wpbakery/vc-guppy.php';
require plugin_dir_path( __FILE__ ) . 'elementor/config.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_wp_guppy_lite() {

	$plugin = new Wp_Guppy_Lite();
	$plugin->run();

}
run_wp_guppy_lite();

/**
 * setting link
 *
 * @since    1.0.0
 */
function setting_link ( $links ) {
	$mylinks = array(
		'<a href="' . admin_url( 'admin.php?page=wpguppy_settings' ) . '">' . esc_html__('Settings', 'wpguppy-lite') . '</a>',
	);
	return array_merge( $mylinks, $links );
}

if (!function_exists('is_plugin_active')) {
    include_once(ABSPATH . 'wp-admin/includes/plugin.php');
}

if ( is_plugin_active('wp-guppy/wp-guppy.php') ) {
	deactivate_plugins('wpguppy-lite/wpguppy-lite.php');    
}

if ( is_plugin_active('wpguppy-lite/wpguppy-lite.php') ) {
	add_action('plugin_action_links_' . plugin_basename(__FILE__), 'setting_link');   
}
