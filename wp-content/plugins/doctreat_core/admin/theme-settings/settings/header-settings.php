<?php
/**
 * Header Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$list_social_media	= array();
if( function_exists( 'doctreat_list_socila_media') ) {
	$lists = doctreat_list_socila_media();
	foreach( $lists as $key	=> $item) {
		$list_social_media[$key]	= $item['lable'];
	}
}

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Header Settings', 'doctreat_core' ),
        'id'               => 'header_settings',
		'icon'			   => 'el el-align-justify',
		'subsection'       => false,
        'fields'           => array(
			array(
				'id'		=> 'main_logo',
				'type' 		=> 'media',
				'url'		=> true,
				'title' 	=> esc_html__('Logo', 'doctreat_core'),
				'desc' 		=> esc_html__('Upload site header logo.', 'doctreat_core'),
			),
			array(
				'id' 		=> 'logo_wide',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Set logo width', 'doctreat_core'),
				'desc' 		=> esc_html__('Leave it empty to hide', 'doctreat_core'),
				"default" 	=> 143,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 500,
				'display_value' => 'label',
			),
			array(
                'id'       => 'header_type',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Header Layout', 'doctreat_core' ),
                'desc'     => esc_html__( 'Select Header Layout you want to show.', 'doctreat_core' ),
                'options'  => array(
                    'header_1' => array(
                        'alt' => esc_html__('Header Layout 1','doctreat_core'),
                        'img' => esc_url( get_template_directory_uri() . '/images/headers/h_1.jpg' )
                    ),
                ),
                'default'  => 'header_1'
            ),
			array(
                'id'       => 'topbar_h1',
                'type'     => 'switch',
                'title'    => esc_html__( 'Top bar', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( '', 'doctreat_core' ),
				'required' => array( 'header_type', '=', 'header_1' ),
            ),
			array(
                'id'       => 'em_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Emergency text', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => 'Emergency Help!',
				'required' => array( 'topbar_h1', '=', true ),
            ),
			array(
                'id'       => 'em_phone',
                'type'     => 'multi_text',
                'title'    => esc_html__( 'Emergency phone number', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => '+1 234 5678 - 9',
				'required' => array( 'topbar_h1', '=', true ),
            ),
			array(
				'id' 		=> 'social_icons',
				'type' 		=> 'sortable',
				'title' 	=> esc_html__('Social Media', 'doctreat_core'),
				'desc' 		=> esc_html__('Social Icons for Footer. You can sort it out as you want.', 'doctreat_core'),
				'label' 	=> true,
				'options' 	=> $list_social_media
			),
		)
	)
);