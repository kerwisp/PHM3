<?php
/**
 * Titlebar Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$social_settings    = function_exists('doctreat_get_social_media_icons_list') ? doctreat_get_social_media_icons_list('yes') : array();

$social_list	= array();
$social_list[]	= array(
				'id'   	=>'social_divider',
				'type' 	=> 'info',
				'title' => esc_html__('Enable social settings for the doctors and hospitals', 'doctreat_core'),
				'style' => 'info',
			);
$social_list[]	= array(
				'id'       => 'social_links',
				'type'     => 'select',
				'title'    => esc_html__('Enable social links', 'doctreat_core'), 
				'desc'     => esc_html__('Enable social links for the doctors and hospitals, then select what social links do you want to enable', 'doctreat_core'),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core') 
				),
				'default'  => 'no',
			);
if(!empty($social_settings)) {
    foreach($social_settings as $key => $val ) {
		$social_list[]	= array(
				'id'    => $key,
				'type'  => 'switch',
				'default'  => false,
				'title' => $val,
				'desc'	=> $val
			);
	}
}
Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Social Profiles', 'doctreat_core' ),
        'id'               => 'social_settings',
        'subsection'       => false,
		'icon'			   => 'el el-address-book',
        'fields'           => $social_list
	)
);