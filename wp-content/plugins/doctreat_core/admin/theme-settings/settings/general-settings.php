<?php
/**
 * General Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'General Settings', 'doctreat_core' ),
	'id'               => 'general_settings',
	'subsection'       => false,
	'icon'			   => 'el el-globe',
	'fields'           => array(
			array(
                'id'       => 'site_loader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Preloader on/off', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( '', 'doctreat_core' ),
            ),	
			array(
				'id'       => 'loader_type',
				'type'     => 'select',
				'title'    => esc_html__('Select Type', 'doctreat_core'), 
				'desc'     => esc_html__('Please select loader type.', 'doctreat_core'),
				'options'  => array(
					'default' 	=> esc_html__('Default', 'doctreat_core'), 
					'custom' 	=> esc_html__('Custom', 'doctreat_core'), 
				),
				'default'  => 'default',
				'required' => array( 'site_loader', '=', true ),
			),
			array(
                'id'       => 'loader_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( 'Loader image?', 'doctreat_core' ),
                'compiler' => 'true',
                'desc'     => esc_html__( 'Uplaod loader image', 'doctreat_core' ),
				'required' => array( 'loader_type', '=', 'custom' )
            ),	
			array(
				'id' 		=> 'loader_wide',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Set loader width', 'doctreat_core'),
				'desc' 		=> esc_html__('Leave it empty to hide', 'doctreat_core'),
				"default" 	=> 100,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 500,
				'display_value' => 'label',
			),
			array(
				'id' 		=> 'loader_height',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Set loader height', 'doctreat_core'),
				'desc' 		=> esc_html__('Leave it empty to hide', 'doctreat_core'),
				"default" 	=> 100,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 500,
				'display_value' => 'label',
			),
			array(
				'id'       => 'loader_duration',
				'type'     => 'select',
				'title'    => esc_html__('Loader duration?', 'doctreat_core'), 
				'desc'     => esc_html__('Select site loader speed', 'doctreat_core'),
				'options'  => array(
					'250' 	=> esc_html__('1/4th Seconds', 'doctreat_core'), 
					'500' 	=> esc_html__('Half Second', 'doctreat_core'), 
					'1000' 	=> esc_html__('1 Second', 'doctreat_core'), 
					'2000' 	=> esc_html__('2 Seconds', 'doctreat_core'), 
				),
				'default'  => '250',
				'required' => array( 'site_loader', '=', true ),
			),
			array(
                'id'       => '404_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => esc_html__( '404 image?', 'doctreat_core' ),
                'compiler' => 'true',
                'desc'     => esc_html__( 'Uplaod loader image', 'doctreat_core' )
            ),
			array(
                'id'       => '404_title',
                'type'     => 'text',
                'title'    => esc_html__( '404 title', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => 'Ooopps! Page Not Found',
            ),
            array(
                'id'       => '404_subtitle',
                'type'     => 'text',
                'title'    => esc_html__( '404 sub title', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => 'Something Went Wrong',
            ),
			array(
                'id'       => '404_description',
                'type'     => 'textarea',
                'title'    => esc_html__( '404 description', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => '',
			),
			
		)
	)
);