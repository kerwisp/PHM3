<?php
/**
 * WordPress Theme Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

if ( ! class_exists( 'Redux' ) ) { return;}

$opt_name 	= "theme_settings";
$opt_name   = apply_filters( 'doctreat_theme_settings_option_name', $opt_name );
$theme 		= wp_get_theme();

$args = array(
    'opt_name'    		=> $opt_name,
    'display_name' 		=> $theme->get('Name') ,
    'display_version' 	=> $theme->get('Version') ,
    'menu_type' 		=> 'menu',
    'allow_sub_menu' 	=> true,
    'menu_title' 		=> esc_html__('Theme Settings', 'doctreat_core'),
	'page_title'        => esc_html__('Theme Settings', 'doctreat_core') ,
    'google_api_key' 	=> '',
    'google_update_weekly' => false,
    'async_typography' 	   => true,
    'admin_bar' 		=> true,
    'admin_bar_icon' 	=> '',
    'admin_bar_priority'=> 50,
    'global_variable' 	=> $opt_name,
    'dev_mode' 			=> false,
    'update_notice' 	=> false,
    'customizer' 		=> false,
    'page_priority' 	=> null,
    'page_parent' 		=> 'themes.php',
    'page_permissions'  => 'manage_options',
    'menu_icon' 		=> 'dashicons-performance',
    'last_tab' 			=> '',
    'page_icon' 		=> 'icon-themes',
    'page_slug' 		=> 'themeoptions',
    'save_defaults' 	=> true,
    'default_show' 		=> false,
    'default_mark' 		=> '',
    'show_import_export' => true
);
 
Redux::setArgs ($opt_name, $args);

$scan = glob("$dir/admin/theme-settings/settings/*");
foreach ( $scan as $path ) {
	include $path;
}


//Redux design wrapper start
if( !function_exists('system_redux_style_start') ){
    add_action ('redux/'.$opt_name.'/panel/before', 'system_redux_style_start');
    function system_redux_style_start($value){
        echo '<div class="amt-redux-design">';
    }
}

//Redux design wrapper end
if( !function_exists('system_redux_style_end') ){
    add_action ('redux/'.$opt_name.'/panel/after', 'system_redux_style_end');
    function system_redux_style_end($value){
        echo '</div>';
    }
}