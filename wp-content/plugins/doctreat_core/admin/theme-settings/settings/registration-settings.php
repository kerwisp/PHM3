<?php
/**
 * Registration Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$doctros_pages	= apply_filters( 'doctreat_doctor_redirect_after_login','');
Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Registration Settings', 'doctreat_core' ),
        'id'               => 'registration_settings',
		'desc'       	   => '',
		'icon' 			   => 'el el-child',
		'subsection'       => false,
        'fields'           => array(
			array(
				'id'		=> 'step_image',
				'type' 		=> 'media',
				'url'       => false,
				'title' 	=> esc_html__('Image', 'doctreat_core'),
				'desc' 		=> esc_html__('Upload Image to be shown on the registration form', 'doctreat_core'),
			),
			array(
				'id'       => 'step_title',
				'type'     => 'text',
				'title'    => esc_html__( 'title', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add title, which will serve as title on registration form', 'doctreat_core'),
				'default'  => 'Join For a Good Start',
			),
			array(
				'id'       => 'step_description',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Description', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add description, which will serve as description on registration form', 'doctreat_core'),
				'default'  => '',
			),
			array(
				'id'       => 'user_registration',
				'type'     => 'switch',
				'title'    => esc_html__( 'Login/Register', 'doctreat_core' ),
				'default'  => false,
				'desc'     => esc_html__( 'Enable/Disable registration', 'doctreat_core' ),
			),	
			array(
				'id'       => 'registration_form',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Registration Form?', 'doctreat_core' ),
				'default'  => false,
				'desc'     => esc_html__( 'Enable/Disable registration form', 'doctreat_core' ),
				'required' => array( 'user_registration', '=', true ),
			),
			array(
				'id'       => 'user_type_registration',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__('Show Registration type ?', 'doctreat_core'), 
				'desc'     => esc_html__('Show registration type by role. You can either select all to enable all the types of registration or you can remove from available list. For example hide hospital registration from front-end. At-least one registration type would be required', 'doctreat_core'),
				'options'  => array('doctors'=> esc_html__('Doctors','doctreat_core'),
									'hospitals'=> esc_html__('Hospitals','doctreat_core'),
									'regular_users'=> esc_html__('Patients','doctreat_core'),
									'seller'=> esc_html__('Pharmacy(Vendor)','doctreat_core')
								   ),
				'default'  => array('doctors','hospitals','regular_users','seller'),
				'required' => array( 'user_registration', '=', true ),
			),
			array(
				'id'       	=> 'login_form',
				'type'     	=> 'switch',
				'title'    	=> esc_html__( 'Login?', 'doctreat_core' ),
				'default'  	=> false,
				'desc'		=> esc_html__('Enable login form.','doctreat_core'),
				'required' 	=> array( 'user_registration', '=', true ),
			),
			array(
				'id'    => 'login_page',
				'type'  => 'select',
				'title' => esc_html__( 'Choose Page', 'doctreat_core' ), 
				'desc'	=> esc_html__('Choose registeration template page.','doctreat_core'),
				'data'  => 'pages',
				'required' => array( 'user_registration', '=', true ),
			),
			array(
				'id'       => 'verify_user',
				'type'     => 'select',
				'title'    => esc_html__( 'Verification', 'doctreat_core' ),
				'desc' => esc_html__('Note: If you select "Need to verify, after registration" then user will not be shown in search result until user will be verified by site owner. If you select "Verify by email" then users will get an email for verification. After clicking link user will be verified and available at the website.', 'doctreat_core'),
				'options'	=> array(
					'yes'   => esc_html__('Verify by email', 'doctreat_core'),
					'no'	=> esc_html__('Need to verify, after registration by admin', 'doctreat_core'),
					'remove'   => esc_html__('Remove verification all over the site', 'doctreat_core'),
				),
				'default'  => 'yes',
				'required' => array( 'user_registration', '=', true ),
			),

			array(
				'id'       => 'term_text',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Term text', 'doctreat_core' ),
				'desc'     => esc_html__( '', 'doctreat_core' ),
				'default'  => ''
			),
			array(
				'id'    => 'term_page',
				'type'  => 'select',
				'title' => esc_html__( 'Select Term Page', 'doctreat_core' ), 
				'data'  => 'pages'
			),
	
			array(
				'id'       => 'remove_location',
				'type'     => 'select',
				'title'    => esc_html__( 'Remove location field', 'doctreat_core' ),
				'desc' 		=> esc_html__('Remove location field from registration form', 'doctreat_core'),
				'options'	=> array(
					'yes'   => esc_html__('Yes', 'doctreat_core'),
					'no'	=> esc_html__('No', 'doctreat_core'),
				),
				'default'  => 'no',
			),
			array(
				'id'       => 'doctors_redirect_page',
				'type'     => 'select',
				'title'    => esc_html__('Redirect URL for doctor', 'doctreat_core'), 
				'desc'     => esc_html__('Redirect URL for doctor after login and registration.', 'doctreat_core'),
				'options'  => $doctros_pages,
				'default'  => 'dashboard',
			), 
			array(
				'id'       => 'hospital_redirect_page',
				'type'     => 'select',
				'title'    => esc_html__('Redirect URL for hospital', 'doctreat_core'), 
				'desc'     => esc_html__('Redirect URL for hospital after login and registration.', 'doctreat_core'),
				'options'  => $doctros_pages,
				'default'  => 'dashboard',
			)
		)
	)
);