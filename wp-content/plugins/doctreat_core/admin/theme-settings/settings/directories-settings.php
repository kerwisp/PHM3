<?php

/**
 * Directory Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection(
	$opt_name,
	array(
		'title'            => esc_html__('Directory Settings', 'doctreat_core'),
		'id'               => 'directory_general_settings',
		'subsection'       => false,
		'icon'			   => 'el el-time',
		'fields'           => array(
			array(
				'id'   	=> 'directories_divider',
				'type' 	=> 'info',
				'title' => esc_html__('General Settings', 'doctreat_core'),
				'style' => 'info',
			),
			array(
				'id'       => 'doctor_location',
				'type'     => 'select',
				'title'    => esc_html__('Doctors locations', 'doctreat_core'),
				'desc' => esc_html__('Doctors availability locations where he provide the services. It could be only one clinic or hospitals or both at the same time.', 'doctreat_core'),
				'options'  => array(
					'clinic' 		=> esc_html__('Doctors own clinic', 'doctreat_core'),
					'hospitals' 	=> esc_html__('Only hospitals', 'doctreat_core'),
					'both' 			=> esc_html__('Both hospitals and clinics', 'doctreat_core')
				),
				'default'  => 'hospitals',
			),
			array(
				'id'       => 'listing_type',
				'type'     => 'select',
				'title'    => esc_html__('System Access type?', 'doctreat_core'),
				'desc' => wp_kses(__('Please select only one of the following options.<br/>
1) In "Paid Listings" doctors have to buy a package to get online appointments<br/>
2) In "Free listings" All the features are free to use', 'doctreat_core'), array(
					'a' => array(
						'href' => array(),
						'title' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				)),
				'options'  => array(
					'paid' 	=> esc_html__('Paid Listing', 'doctreat_core'),
					'free' 	=> esc_html__('Free Listing', 'doctreat_core')
				),
				'default'  => 'paid',
			),

			array(
				'title' 	=> esc_html__('Remove doctor invitation', 'doctreat_core'),
				'id'  		=> 'remove_doc_invite',
				'type'  	=> 'select',
				'default'  => 'no',
				'desc' 		=> esc_html__('Remove doctor invitation options', 'doctreat_core'),
				'options'	=> array(
					'yes'	  => esc_html__('Yes', 'doctreat_core'),
					'no'	  => esc_html__('No', 'doctreat_core'),
				)
			),
			array(
				'title' 	=> esc_html__('Multiple location(country) selection', 'doctreat_core'),
				'id'  		=> 'multiple_locations',
				'type'  	=> 'select',
				'default'  => 'no',
				'desc' 		=> esc_html__('Allow the users to select multiple location from the edit post in admin dashboard only', 'doctreat_core'),
				'options'	=> array(
					'yes'	  => esc_html__('Yes', 'doctreat_core'),
					'no'	  => esc_html__('No', 'doctreat_core'),
				)
			),
			array(
				'title' 	=> esc_html__('Remove hospital invitation', 'doctreat_core'),
				'id'  		=> 'remove_hos_invite',
				'type'  	=> 'select',
				'default'  => 'no',
				'desc' 		=> esc_html__('Remove hospital invitation options', 'doctreat_core'),
				'options'	=> array(
					'yes'	  => esc_html__('Yes', 'doctreat_core'),
					'no'	  => esc_html__('No', 'doctreat_core'),
				)
			),
			array(
				'title' 	=> esc_html__('Enable cart', 'doctreat_core'),
				'id'  		=> 'enable_cart',
				'type'  	=> 'select',
				'default'  => 'no',
				'desc' 		=> esc_html__('Enable cart button in header', 'doctreat_core'),
				'options'	=> array(
					'yes'	  => esc_html__('Yes', 'doctreat_core'),
					'no'	  => esc_html__('No', 'doctreat_core'),
				)
			),
			array(
				'id'       => 'base_name_disable',
				'type'     => 'switch',
				'title'    => esc_html__('Enable/Disable Base name', 'doctreat_core'),
				'default'  => false,
				'desc'     => esc_html__('Enable or Disable Base name for front-end pages.', 'doctreat_core'),
			),
			array(
				'id'    => 'name_base_doctors',
				'type'  => 'multi_text',
				'show_empty'  => false,
				'title' => esc_html__('Names base for doctors', 'doctreat_core'),
				'desc'	=> esc_html__('Add name base for doctors like Dr, Prof. etc', 'doctreat_core'),
				'required' => array('base_name_disable', '=', true),
			),
			array(
				'id'    => 'name_base_users',
				'type'  => 'multi_text',
				'show_empty'  => false,
				'title' => esc_html__('Names base for regular users', 'doctreat_core'),
				'desc'	=> esc_html__('Add name base for regular users like Mr, Miss. etc', 'doctreat_core'),
				'required' => array('base_name_disable', '=', true),
			),
			array(
				'id'    => 'dashboard_tpl',
				'type'  => 'select',
				'title' => esc_html__('Select dashboard page', 'doctreat_core'),
				'data'  => 'pages'
			),
			array(
				'id'    => 'dir_datasize',
				'type'  => 'text',
				'title' => esc_html__('Add upload size', 'doctreat_core'),
				'desc' => esc_html__('Maximum image upload size. Max 5MB, add in bytes. for example 5MB = 5242880', 'doctreat_core'),
				'default' => '5242880',
			),

			array(
				'id'	=> 'calendar_locale',
				'title' => esc_html__('Calendar Language', 'doctreat_core'),
				'type'  => 'text',
				'value'  => '',
				'desc' => wp_kses(__('Add code. It will be like "en" for english. Leave it empty to use default. Click here to get code <a href="https://developers.google.com/admin-sdk/directory/v1/languages" target="_blank"> Get Code </a>', 'doctreat_core'), array(
					'a' => array(
						'href' => array(),
						'title' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				)),
			),
			array(
				'title' 	=> esc_html__('Calendar Date Format', 'doctreat_core'),
				'id'  		=> 'calendar_format',
				'type'  	=> 'select',
				'value'  	=> 'Y-m-d',
				'desc' 		=> esc_html__('Select your calendar date format.', 'doctreat_core'),
				'options'	=> array(
					'Y-m-d'	  => 'Y-m-d',
					'Y/m/d'	  => 'Y/m/d',
				)
			),

			array(
				'id'    => 'hospital_team_prefix',
				'type'  => 'text',
				'title' => esc_html__('Hospitals Team', 'doctreat_core'),
				'default' => 'TEAM#',
			),
			array(
				'id'    => 'feedback_questions',
				'type'  => 'multi_text',
				'title' => esc_html__('Feedback Question', 'doctreat_core'),
				'desc'	=> esc_html__('Add feedback questions.', 'doctreat_core')
			),

			array(
				'id'       => 'enable_gallery',
				'type'     => 'switch',
				'title'    => esc_html__('Enable/Disable Gallery', 'doctreat_core'),
				'default'  => true,
				'desc'     => esc_html__('Enable or Disable gallery for doctor and hospital.', 'doctreat_core'),
			),
			array(
				'id'       => 'enable_seo',
				'type'     => 'switch',
				'title'    => esc_html__('Enable/Disable SEO', 'doctreat_core'),
				'default'  => true,
				'desc'     => esc_html__('Enable or Disable seo for post and pages.', 'doctreat_core'),
			),
			array(
                'id'       => 'enable_phone',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable/Disable phone', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Enable phone number in registration', 'doctreat_core' ),
			),
			array(
				'id'       => 'doctors_contactinfo',
				'type'     => 'select',
				'title'    => esc_html__('Show contact info', 'doctreat_core'),
				'desc'     => esc_html__('Show doctors and hospitals contact information on their details pages', 'doctreat_core'),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core')
				),
				'default'  => 'yes',
			),
			array(
				'id'       => 'hide_chat_buble',
				'type'     => 'select',
				'title'    => esc_html__('Hide chat buble', 'doctreat_core'),
				'desc'     => esc_html__('Hide chat buble on doctor detail pages', 'doctreat_core'),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core')
				),
				'default'  => 'no',
			),
			array(
				'id'       => 'hide_services_by_package',
				'type'     => 'select',
				'title'    => esc_html__('Services according to package', 'doctreat_core'),
				'desc'     => esc_html__('Hide services according to package limit on doctor detail page', 'doctreat_core'),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core')
				),
				'default'  => 'no',
			),
			array(
				'id'   	=> 'directories_divider2',
				'type' 	=> 'info',
				'title' => esc_html__('Chat Settings', 'doctreat_core'),
				'style' => 'info',
			),
			array(
				'id'       => 'chat',
				'type'     => 'select',
				'title'    => esc_html__('Real Time Chat?', 'doctreat_core'),
				'desc'     => esc_html__('Enable real time chat or use simple inbox system.', 'doctreat_core'),
				'options'  => array(
					'inbox' 	=> esc_html__('Inbox', 'doctreat_core'), 
					'chat' 		=> esc_html__('Real Time Chat', 'doctreat_core'),
					'guppy' 		=> esc_html__('WP Guppy', 'doctreat_core')
				),
			),
			array(
				'id'       => 'host',
				'type'     => 'text',
				'title'    => esc_html__('Host?', 'doctreat_core'),
				'desc'     => __('Please add the host, default would be http://localhost <br>1. Host could be either http://localhost <br>2. OR could be http://yourdomain.com', 'doctreat_core'),
				'default'  => '',
				'required' => array('chat', '=', 'chat'),
			),
			array(
				'id'       => 'port',
				'type'     => 'text',
				'title'    => esc_html__('Port?', 'doctreat_core'),
				'desc'     => esc_html__('', 'doctreat_core'),
				'default'  => '3000',
				'required' => array('chat', '=', 'chat'),
			),
			array(
				'id'       => 'guppy',
				'type'     => 'info',
				'title'    => esc_html__('WP Guppy Chat Solution', 'doctreat_core'),
				'desc' => wp_kses(__('Install the WP Guppy plugin first. <a href="https://wp-guppy.com/" target="_blank">Get WP Guppy plugin</a>
									', 'doctreat_core'), array(
					'a' => array(
						'href' => array(),
						'title' => array(),
						'target' => array()
					),
					'br' => array(),
					'em' => array(),
					'strong' => array(),
				)),
				'required' => array('chat', '=', 'guppy'),
			),
			array(
				'id'       => 'guppy',
				'type'     => 'info',
				'title'    => esc_html__( 'WP Guppy Chat Solution', 'doctreat_core' ),
				'desc' => wp_kses( __( 'Install the WP Guppy plugin first. <a href="https://wp-guppy.com/" target="_blank">Get WP Guppy plugin</a>
									', 'doctreat_core'),array(
														'a' => array(
															'href' => array(),
															'title' => array(),
															'target' => array()
														),
														'br' => array(),
														'em' => array(),
														'strong' => array(),
													)),
				'required' => array( 'chat', '=', 'guppy' ),
			),
		)
	)
);


Redux::setSection(
	$opt_name,
	array(
		'title'            => esc_html__('Images Settings', 'doctreat_core'),
		'id'               => 'dir_general_settings',
		'desc'       	   => '',
		'subsection'       => true,
		'icon'			   => 'el el-braille',
		'fields'           => array(
			array(
				'id'    => 'default_doctor_avatar',
				'type'  => 'media',
				'title' => esc_html__('Default image for doctor', 'doctreat_core')
			),
			array(
				'id'    => 'default_doctor_banner',

				'type'  => 'media',
				'title' => esc_html__('Default image for all users banner', 'doctreat_core')
			),
			array(
				'id'    => 'default_hospital_image',
				'type'  => 'media',
				'title' => esc_html__('Default image for hospital', 'doctreat_core')
			),
			array(
				'id'    => 'default_others_users',
				'type'  => 'media',
				'title' => esc_html__('Default image for all type of other users.', 'doctreat_core')
			),
			array(
				'id'    => 'new_messages',
				'type'  => 'media',
				'title' => esc_html__('Message Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Message Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'total_appointments',
				'type'  => 'media',
				'title' => esc_html__('Appointments Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Appointments Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'saved_items',
				'type'  => 'media',
				'title' => esc_html__('Saved Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Saved Item Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'available_balance',
				'type'  => 'media',
				'title' => esc_html__('Available Balance Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Available Balance Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'package_expiry',
				'type'  => 'media',
				'title' => esc_html__('Package Expiry Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Package Expiry Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'avalible_balance_img',
				'type'  => 'media',
				'title' => esc_html__('Avalible Balance Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Avalible Balance Image Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'service_spec',
				'type'  => 'media',
				'title' => esc_html__('Manage Service Image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Manage Services and specilities image sashboard', 'doctreat_core')
			),
			array(
				'id'    => 'invoice_img',
				'type'  => 'media',
				'title' => esc_html__('Invoices Image for Dashboard', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Invoices Image Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'published_articles_img',
				'type'  => 'media',
				'title' => esc_html__('Total Published Articles Image for Dashboard', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Published Articles Image Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'dashboard_payouts',
				'type'  => 'media',
				'title' => esc_html__('Payouts Settings', 'doctreat_core'),
				'desc'	=> esc_html__('Icons for payouts in doctors dashboard ', 'doctreat_core')
			),
			array(
				'id'    => 'article_add_url',
				'type'  => 'media',
				'title' => esc_html__('Articles Image for Dashboard', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Articles Image Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'manage_team_img',
				'type'  => 'media',
				'title' => esc_html__('Manage team image', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for manage team image Dashboard', 'doctreat_core')
			),
			array(
				'id'    => 'pdf_logo',
				'type'  => 'media',
				'title' => esc_html__('Default logo image for prescription pdf', 'doctreat_core')
			),
		)
	)
);

Redux::setSection(
	$opt_name,
	array(
		'title'            => esc_html__('Map Settings', 'doctreat_core'),
		'id'               => 'map_settings',
		'desc'       	   => '',
		'subsection'       => true,
		'icon'			   => 'el el-braille',
		'fields'           => array(
			array(
				'id'   	=> 'directories_map_divider',
				'type' 	=> 'info',
				'title' => esc_html__('Map Settings', 'doctreat_core'),
				'style' => 'info',
			),
			array(
				'id'       => 'dir_map_type',
				'type'     => 'select',
				'title'    => esc_html__('Map Type', 'doctreat_core'),
				'desc'     => esc_html__('Select Map Type.', 'doctreat_core'),
				'options'  => array(
					'ROADMAP' 		=> esc_html__('ROADMAP', 'doctreat_core'),
					'SATELLITE' 	=> esc_html__('SATELLITE', 'doctreat_core'),
					'HYBRID' 		=> esc_html__('HYBRID', 'doctreat_core'),
					'TERRAIN' 		=> esc_html__('TERRAIN', 'doctreat_core'),
				),
			),
			array(
				'id'       => 'map_styles',
				'type'     => 'select',
				'title'    => esc_html__('Map Style', 'doctreat_core'),
				'desc'     => esc_html__('Select Map Style.', 'doctreat_core'),
				'options'  => array(
					'none' => esc_html__('NONE', 'doctreat_core'),
					'view_1' => esc_html__('Default', 'doctreat_core'),
					'view_2' => esc_html__('View 2', 'doctreat_core'),
					'view_3' => esc_html__('View 3', 'doctreat_core'),
					'view_4' => esc_html__('View 4', 'doctreat_core'),
					'view_5' => esc_html__('View 5', 'doctreat_core'),
					'view_6' => esc_html__('View 6', 'doctreat_core'),
				),
			),
			array(
				'id'       => 'dir_map_scroll',
				'type'     => 'select',
				'title'    => esc_html__('Map Draggable', 'doctreat_core'),
				'desc'     => esc_html__('Enable Map Draggable.', 'doctreat_core'),
				'options'  => array(
					'false' => esc_html__('No', 'doctreat_core'),
					'true' 	=> esc_html__('Yes', 'doctreat_core'),
				),
			),
			array(
				'id'    => 'dir_map_marker',
				'type'  => 'media',
				'title' => esc_html__('Map Marker', 'doctreat_core'),
				'desc'	=> esc_html__('Default image for Map Marker', 'doctreat_core')
			),
			array(
				'id'       => 'dir_zoom',
				'type'     => 'select',
				'title'    => esc_html__('Map Draggable', 'doctreat_core'),
				'desc'     => esc_html__('Enable Map Draggable.', 'doctreat_core'),
				'options'  => array(
					'false' => esc_html__('No', 'doctreat_core'),
					'true' 	=> esc_html__('Yes', 'doctreat_core'),
				),
			),
			array(
				'id' 		=> 'dir_zoom',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Map Zoom', 'doctreat_core'),
				'desc' 		=> esc_html__('Select map zoom level', 'doctreat_core'),
				"default" 	=> 11,
				"min" 		=> 1,
				"step" 		=> 1,
				"max" 		=> 20,
				'display_value' => 'label'
			),
			array(
				'id'       => 'dir_latitude',
				'type'     => 'text',
				'title'    => esc_html__('Latitude', 'doctreat_core'),
				'desc'     => esc_html__('Default Latitude for map.', 'doctreat_core'),
				'default'  => '51.5001524',
			),
			array(
				'id'       => 'dir_longitude',
				'type'     => 'text',
				'title'    => esc_html__('Longitude', 'doctreat_core'),
				'desc'     => esc_html__('Default Longitude for map.', 'doctreat_core'),
				'default'  => '-0.1262362',
			),
		)
	)
);
