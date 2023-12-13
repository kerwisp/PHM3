<?php
/**
 * Search Doctors Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Search Doctors Settings', 'doctreat_core' ),
        'id'               => 'search_doctors_settings',
        'desc'       	   => '',
		'icon' 			   => 'el el-search',
		'subsection'       => false,
        'fields'           => array(
			array(
                'id'       => 'search_form',
                'type'     => 'switch',
                'title'    => esc_html__( 'Search form', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Enable search form in header', 'doctreat_core' ),
			),	
			array(
				'title' 	=> esc_html__( 'Home search bar', 'doctreat_core' ),
				'id'  		=> 'show_search_bar',
				'type'  	=> 'select',
				'default'  => 'no',
				'desc' 		=> esc_html__('Show search bar on home page', 'doctreat_core'),
				'required' => array( 'search_form', '=', true ),
				'options'	=> array(
					'yes'	  => esc_html__( 'Yes', 'doctreat_core' ),
					'no'	  => esc_html__( 'No', 'doctreat_core' ),
				)
			),
			array(
				'id'       => 'search_type',
				'type'     => 'select',
				'title'    => esc_html__('Search type', 'doctreat_core'), 
				'desc'     => esc_html__('Select defult search type.', 'doctreat_core'),
				'options'  => array(
					'both' 			=> esc_html__('Both doctors and hospitals', 'doctreat_core'), 
					'doctors' 		=> esc_html__('Doctors', 'doctreat_core'), 
					'hospitals' 	=> esc_html__('Hospitals', 'doctreat_core'), 
				),
				'default'  => 'both',
				'required' => array( 'search_form', '=', true ),
			),
		
			array(
                'id'       => 'gender_search',
                'type'     => 'switch',
                'title'    => esc_html__( 'Search Gender', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Enable/disable Gender search option', 'doctreat_core' ),
				'required' => array( 'search_type', '=', 'doctors' ),
            ),
			array(
				'id'       => 'hide_location',
				'type'     => 'select',
				'title'    => esc_html__('Hide location', 'doctreat_core'), 
				'desc'     => esc_html__('Hide location dropdown.', 'doctreat_core'),
				'options'  => array(
					'no' 		=> esc_html__('No', 'doctreat_core'), 
					'yes' 		=> esc_html__('Yes', 'doctreat_core'), 
				),
				'default'  => 'no',
				'required' => array( 'search_form', '=', true ),
			),
			array(
				'id'       => 'redirect_unverified',
				'type'     => 'select',
				'title'    => esc_html__('Redirect users detail page', 'doctreat_core'), 
				'desc'     => esc_html__('Redirect the visitors to see user detail page if user account is not verified or deactive profiles', 'doctreat_core'),
				'options'  => array(
					'no' 		=> esc_html__('No', 'doctreat_core'), 
					'yes' 		=> esc_html__('Yes', 'doctreat_core'), 
				),
				'default'  => 'no',
				'required' => array( 'search_form', '=', true ),
			),
			array(
				'id'    	=> 'search_result_page',
				'type'  	=> 'select',
				'title' 	=> esc_html__( 'Search result page', 'doctreat_core' ), 
				'data'  	=> 'pages',
				'desc'     => esc_html__('Select search result page.', 'doctreat_core'),
			),
			array(
                'id'       => 'dashboard_search',
                'type'     => 'switch',
                'title'    => esc_html__( 'Dashboard search', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Enable dashboard header search option', 'doctreat_core' ),
            ),
			array(
                'id'       => 'add_settings',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable/Disable Ad', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( '', 'doctreat_core' ),
            ),	
			array(
				'id'       => 'show_add',
				'type'     => 'select',
				'title'    => esc_html__('Select Ads Section', 'doctreat_core'), 
				'desc'     => esc_html__('Please select Ads Section.', 'doctreat_core'),
				'options'  => array(
					'top' 		=> esc_html__('Top', 'doctreat_core'), 
					'middle' 	=> esc_html__('Middle', 'doctreat_core'), 
					'bottom' 	=> esc_html__('Bottom', 'doctreat_core'), 
				),
				'default'  => 'default',
				'required' => array( 'add_settings', '=', true ),
			),	
			array(
				'id'       => 'add_code',
				'type'     => 'textarea',
                'title'    => esc_html__( 'Ad code', 'doctreat_core' ),
                'desc'     => esc_html__( 'Enter ad code here.', 'doctreat_core' ),
                'default'  => '',
				'required' => array( 'add_settings', '=', true ),
			),
		)
	)
);