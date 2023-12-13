<?php
/**
 * Maintainance Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Maintainance Settings', 'doctreat_core' ),
        'id'               => 'maintainance_settings',
        'subsection'       => false,
		'icon'			   => 'el el-time',
        'fields'           => array(
			array(
                'id'       => 'maintenance',
                'type'     => 'switch',
                'title'    => esc_html__( 'Select Enable/Disable', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Enable or disable maintainace page', 'doctreat_core' ),
            ),
			array(
				'id'       => 'date',
				'type'     => 'date',
				'title'    => esc_html__( 'Add Date', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add Date or leave it empty to hide.', 'doctreat_core' ),
				'required' => array( 'maintenance', '=', true ),
			),
			array(
				'id'		=> 'cm_logo',
				'type' 		=> 'media',
				'url'       => false,
				'title' 	=> esc_html__('Logo', 'doctreat_core'),
				'desc' 		=> esc_html__('Upload Logo.', 'doctreat_core'),
				'required' 	=> array( 'maintenance', '=', true ),
			),
			array(
				'id'       => 'cm_title',
				'type'     => 'text',
				'default'  => 'Stay Tuned We’re',
				'title'    => esc_html__( 'Title', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add title or leave it empty to hide.', 'doctreat_core' ),
				'required' => array( 'maintenance', '=', true ),
			),
			array(
				'id'       => 'cm_sub_title',
				'type'     => 'text',
				'default'  => 'Launching Very Soon!',
				'title'    => esc_html__( 'Sub Title', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add sub title or leave it empty to hide.', 'doctreat_core' ),
				'required' => array( 'maintenance', '=', true ),
			),
			array(
				'id'       => 'cm_description',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Description', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add Description or leave it empty to hide', 'doctreat_core' ),
				'required' => array( 'maintenance', '=', true ),
			),
			array(
				'id'		=> 'cm_image',
				'type' 		=> 'media',
				'url'       => false,
				'title' 	=> esc_html__('Image', 'doctreat_core'),
				'desc' 		=> esc_html__('Upload Image to be shown.', 'doctreat_core'),
				'required' 	=> array( 'maintenance', '=', true ),
			),
			array(
				'id'       => 'cm_copyright',
				'type'     => 'textarea',
				'default'  => 'Copyrights © 2019 by doctreat. All Rights Reserved.',
				'title'    => esc_html__( 'Copyright', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add Copyright or leave it empty to hide', 'doctreat_core' ),
				'required' => array( 'maintenance', '=', true ),
			)
		)
	)
);