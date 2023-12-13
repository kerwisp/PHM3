<?php
/**
 * Elementor Page buider config
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat
 *
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die('No kiddies please!');
}

if( !class_exists( 'Doctreat_Elementor' ) ) {

	final class Doctreat_Elementor{
		private static $_instance = null;
		
		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      string    doctreat core
		 */
        public function __construct() {
            add_action( 'elementor/elements/categories_registered', array( &$this, 'doctreat_init_elementor_widgets' ) );
            add_action( 'elementor/widgets/register', array( &$this, 'elementor_shortcodes' ),  20 );
        }
		
	
		/**
		 * class init
         * @since 1.1.0
         * @static
         * @var      string    doctreat core
         */
        public static function instance () {
            if ( is_null( self::$_instance ) ) {
                self::$_instance = new self();
            }
            return self::$_instance;
        }
		
		/**
		 * Add category
		 * @since    1.0.0
		 * @access   static
		 * @var      string    doctreat core
		 */
        public function doctreat_init_elementor_widgets( $elements_manager ) {
            $elements_manager->add_category(
                'doctreat-elements',
                [
                    'title' => esc_html__( 'Doctreat Elements', 'doctreat_core' ),
                    'icon' 	=> 'fa fa-plug',
                ]
            );
        }

        /**
		 * Add widgets
		 * @since    1.0.0
		 * @access   static
		 * @var      string    doctreat core
		 */
        public function elementor_shortcodes() {
			$dir = DoctreatGlobalSettings::get_plugin_path();
			$scan_shortcodes = glob("$dir/elementor/shortcodes/*");
			foreach ($scan_shortcodes as $filename) {
				$file = pathinfo($filename);
				if( !empty( $file['filename'] ) ){
					@include_once doctreat_template_exsits( '/elementor/shortcodes/'.$file['filename'] );
				}
			}

			//Theme
			$dir = get_stylesheet_directory();
			$scan_shortcodes = glob("$dir/extend/elementor/shortcodes/*");

			foreach ($scan_shortcodes as $filename) {
				if( !empty( $file['filename'] ) ){
					@include_once $filename;
				} 
			}
		}
		 
	}
}

//Init class
if ( did_action( 'elementor/loaded' ) ) {
    Doctreat_Elementor::instance();
}