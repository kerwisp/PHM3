<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/
 * @since      1.0.0
 *
 * @package    Wp_Guppy_Lite
 * @subpackage Wp_Guppy_Lite/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Guppy_Lite
 * @subpackage Wp_Guppy_Lite/public
 * @author     Amento Tech Pvt ltd <info@amentotech.com>
 */
class Wp_Guppy_Lite_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		
		add_action('wp_footer', 							array($this, 'wpGuppyWidgetChat'));
		add_shortcode('getGuppyConversation',				array(&$this,'wpguppy_getGuppyConversation'));

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
		 * defined in Wp_Guppy_Lite_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Guppy_Lite_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style('wpguppy-app-css', WP_GUPPY_LITE_DIRECTORY_URI.'chatapp/dist/css/app.css',array(), $this->version, 'all');
		wp_enqueue_style('wpguppy-vendors-css', WP_GUPPY_LITE_DIRECTORY_URI.'chatapp/dist/css/vendors.css',array(), $this->version, 'all');
		wp_enqueue_style( $this->plugin_name.'-guppy-icons', plugin_dir_url( __FILE__ ) . 'css/guppy-icons.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-guppy-public.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script('wpguppy-app-js', WP_GUPPY_LITE_DIRECTORY_URI.'chatapp/dist/js/app.js', array(), $this->version, true);
		wp_enqueue_script('wpguppy-vendors-js', WP_GUPPY_LITE_DIRECTORY_URI.'chatapp/dist/js/vendors.js', array(), $this->version, true);

	}
	
	/**
	 * Guppy Conversation shortcode
	 *
	 * @since    1.0.0
	*/
	public function wpguppy_getGuppyConversation(){
		return '<div id="wpguppy-messanger-chat"></div>';
	}

	/**
	 * widget chat Initialize
	 *
	 * @since    1.0.0
	*/
	public function wpGuppyWidgetChat(){
		echo do_shortcode('<div id="wpguppy-widget-chat"></div>');
	}

}
