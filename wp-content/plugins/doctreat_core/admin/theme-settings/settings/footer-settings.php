<?php
/**
 * Footer Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Footer Settings', 'doctreat_core' ),
        'id'               => 'footer_settings',
        'subsection'       => false,
		'icon'			   => 'el el-align-center',
        'fields'           => array(
			array(
				'id'       => 'footer_type',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Footer Layout', 'doctreat_core' ),
				'desc'     => esc_html__( 'Select footer Layout you want to show.', 'doctreat_core' ),
				'options'  => array(
					'footer_1' => array(
						'alt' => esc_html__('Footer Layout 1','doctreat_core'),
						'img' => esc_url( get_template_directory_uri() . '/images/footer_1.png' )
					),
				),
				'default'  => 'footer_1'
			),
			array(
				'id'       => 'copyright',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Copyright text', 'doctreat_core' ),
				'desc'     => esc_html__( '', 'doctreat_core' ),
				'default'  => 'Copyrights © 2019 by Doctreat. All Rights Reserved.',
				'required' => array( 'footer_type', '=', 'footer_1' ),
			),
			array(
				'id'       => 'footer_contact_section',
				'type'     => 'switch',
				'title'    => esc_html__( 'Contact section', 'doctreat_core' ),
				'default'  => false,
				'desc'     => esc_html__( 'Enable/Disable contact section', 'doctreat_core' ),
			),	
			array(
				'id'       => 'emergency_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Emergency text', 'doctreat_core' ),
				'default'  => 'Emergency Call',
				'desc'     => esc_html__( 'Emergency text for Contact section ', 'doctreat_core' ),
				'required' => array( 'footer_contact_section', '=', true ),
			),
			array(
				'id'       => 'emergency_phone',
				'type'     => 'text',
				'title'    => esc_html__( 'Emergency phone', 'doctreat_core' ),
				'default'  => '+1 234 5678 - 9',
				'desc'     => esc_html__( 'Emergency phone for Contact section ', 'doctreat_core' ),
				'required' => array( 'footer_contact_section', '=', true ),
			),
			array(
				'id'		=> 'emergency_logo',
				'type' 		=> 'media',
				'url'       => false,
				'title' 	=> esc_html__('Image', 'doctreat_core'),
				'desc' 		=> esc_html__('Upload Image to be shown on emergency phone for Contact section.', 'doctreat_core'),
				'required' 	=> array( 'footer_contact_section', '=', true ),
			),
			array(
				'id'       => 'emergency_email_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Emergency email text', 'doctreat_core' ),
				'default'  => '24/7 Email Support',
				'desc'     => esc_html__( 'Emergency email text for Contact section ', 'doctreat_core' ),
				'required' => array( 'footer_contact_section', '=', true ),
			),
			array(
				'id'       => 'emergency_email',
				'type'     => 'text',
				'title'    => esc_html__( 'Emergency email', 'doctreat_core' ),
				'default'  => 'info@domain.com',
				'desc'     => esc_html__( 'Emergency email for Contact section ', 'doctreat_core' ),
				'required' => array( 'footer_contact_section', '=', true ),
			),
			array(
				'id'		=> 'emergency_support_logo',
				'type' 		=> 'media',
				'url'       => false,
				'title' 	=> esc_html__('Image', 'doctreat_core'),
				'desc' 		=> esc_html__('Upload Image to be shown on emergency email for Contact section.', 'doctreat_core'),
				'required' 	=> array( 'footer_contact_section', '=', true ),
			),
		)
	)
);