<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Doctreat
 * @subpackage Doctreat/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Doctreat
 * @subpackage Doctreat/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */
class Doctreat_Admin {

    public function __construct() {
        $this->plugin_name 	= DoctreatGlobalSettings::get_plugin_name();
        $this->version 		= DoctreatGlobalSettings::get_plugin_verion();
        $this->plugin_path 	= DoctreatGlobalSettings::get_plugin_path();
        $this->plugin_url 	= DoctreatGlobalSettings::get_plugin_url();
        $this->prepare_post_types();
    }

    /**
     * Register the spost types for the admin area.
     *
     * @since    1.0.0
     */
    public function prepare_post_types() {
        $dir = $this->plugin_path;
        $scan_PostTypes = glob("$dir/admin/post-types/*");
        foreach ($scan_PostTypes as $filename) {
            @include $filename;
        }
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
         * defined in Doctreat_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Doctreat_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style('system-styles', $this->plugin_url . 'admin/css/system-admin.css', array(), $this->version, 'all');
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
         * defined in Doctreat_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Doctreat_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */        
        wp_enqueue_script('doctreat_core_plugin_js', plugin_dir_url( __FILE__ ) . 'js/functions.js', array('jquery','doctreat-admin-functions'), $this->version, false);       
    }

}
