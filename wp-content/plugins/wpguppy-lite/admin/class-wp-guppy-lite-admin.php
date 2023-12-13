<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/
 * @since      1.0.0
 *
 * @package    Wp_Guppy_Lite
 * @subpackage Wp_Guppy_Lite/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Guppy_Lite
 * @subpackage Wp_Guppy_Lite/admin
 * @author     Amento Tech Pvt ltd <info@amentotech.com>
 */
class Wp_Guppy_Lite_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Guppy_Lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Guppy_Lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		 wp_enqueue_style( 'wp-color-picker' );
		 wp_enqueue_style( 'wpguppy-lite-settings', plugin_dir_url( __FILE__ ) . 'css/wpguppy-admin.css',array(), $this->version, 'all');
		 wp_enqueue_style( 'jquery_confirm', plugin_dir_url( __FILE__ ) . 'css/jquery-confirm.min.css',array(), $this->version, 'all');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Guppy_Lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Guppy_Lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script('wpguppy-lite-settings', plugin_dir_url( __FILE__ ) . 'settings/js/settings.js',array( 'wp-color-picker' ), $this->version, true);
		wp_enqueue_script('jquery_confirm', plugin_dir_url( __FILE__ ) . 'settings/js/jquery-confirm.min.js',array( 'wp-color-picker' ), $this->version, true);

		wp_localize_script('wpguppy-lite-settings', 'scripts_constants', array(
			'rest_db_message'	=> esc_html__('Are you sure you want to reset databse?','wpguppy-lite'),
			'is_admin'			=> 'no',
			'ajaxurl' 			=> admin_url('admin-ajax.php'),
			'ajax_nonce'		=> wp_create_nonce('ajax_nonce')
		));

	}

}
