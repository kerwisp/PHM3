<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Doctreat
 * @subpackage Doctreat/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Doctreat
 * @subpackage Doctreat/public
 * @author     Amentotech <theamentotech@gmail.com>
 */
class Doctreat_Public {

    public function __construct() {

        $this->plugin_name = DoctreatGlobalSettings::get_plugin_name();
        $this->version = DoctreatGlobalSettings::get_plugin_verion();
        $this->plugin_path = DoctreatGlobalSettings::get_plugin_path();
        $this->plugin_url = DoctreatGlobalSettings::get_plugin_url();
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Doctreat_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Doctreat_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        //wp_enqueue_style('system-public', plugin_dir_url(__FILE__) . 'css/system-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
		global $theme_settings;
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Doctreat_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Doctreat_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_register_script('doctreat_core', plugin_dir_url(__FILE__) . 'js/system-public.js', array('jquery'), $this->version, false);	       
        //wp_enqueue_script('doctreat_core');	  
		
		$dependencies	= array('jquery');
		if( !empty( $theme_settings['chat'] ) && $theme_settings['chat'] === 'chat' ){
			$dependencies	= array('jquery','socket.io');
		}
		
		if ( ( is_page_template('directory/dashboard.php') && isset($_GET['ref']) && $_GET['ref'] === 'chat' ) || is_singular('doctors') ) {
			if( !empty( $theme_settings['chat'] ) && $theme_settings['chat'] !== 'guppy' ){
				wp_enqueue_script('doctreat_chat_module', plugin_dir_url(__FILE__) . 'js/doctreat_chat_module.js', $dependencies, $this->version, false);
			}
        }
    }

}
