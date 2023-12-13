<?php
/**
 * Payment Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
$schedules_list	=  get_transient( 'cron-interval-list' );

$payment_method	= array('paypal' => esc_html__('Paypal','doctreat_core'),'bacs' => esc_html__('Direct Bank Transfer (BACS)', 'doctreat_core'));
Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Payment Settings', 'doctreat_core' ),
        'id'               => 'payment_settings',
        'subsection'       => false,
		'icon'			   => 'el el-credit-card',
        'fields'           => array(
			
			array(
				'id'       => 'payment_type',
				'type'     => 'select',
				'title'    => esc_html__('Select payment type', 'doctreat_core'), 
				'desc'     => esc_html__('Please select payment type. In case of offline payment settings, either you can enable payout settings or disable it. WooCommrece offline payment gateway will work with both type of payments.', 'doctreat_core'),
				'options'  => array(
					'online' 	=> esc_html__('Online', 'doctreat_core'),
					'offline' 	=> esc_html__('Offline', 'doctreat_core') 
				),
				'default'  => 'online',
			),
	
			array(
				'id'       => 'show_earning',
				'type'     => 'select',
				'title'    => esc_html__('Show earning?', 'doctreat_core'), 
				'desc'     => esc_html__('Show earning in doctors dashboard.', 'doctreat_core'),
				'options'  => array(
					'hide' 	=> esc_html__('Hide', 'doctreat_core'),
					'show' 	=> esc_html__('Show', 'doctreat_core') 
				),
				'default'  => 'show',
			),
			array(
                'id'       => 'enable_checkout_page',
                'type'     => 'select',
                'title'    => esc_html__( 'Enable WooCommerce checkout', 'doctreat_core' ),
                'default'  => 'hide',
				'options'  => array(
					'hide' 	=> esc_html__('Hide checkout page', 'doctreat_core'),
					'show' 	=> esc_html__('Use WooCommerce checkout', 'doctreat_core') 
				),
				'desc'     => esc_html__( 'If you will hide Woocommerce checkout then system will remove the payout settings from the doctors dashboard', 'doctreat_core' ),
				'required' => array( 'payment_type', '=', 'offline' )
			),
			array(
                'id'       => 'success_title',
                'type'     => 'text',
                'title'    => esc_html__( 'Success Title?', 'doctreat_core' ),
                'desc'     => esc_html__( 'Add success title or leave it empty to hide', 'doctreat_core' ),
				'required' => array( 'enable_checkout_page', '=', false )
            ),
			array(
                'id'       => 'success_desc',
                'type'     => 'editor',
                'title'    => esc_html__( 'Success Description?', 'doctreat_core' ),
                'desc'     => esc_html__( 'Add success description or leave it empty to hide', 'doctreat_core' ),
				'required' => array( 'enable_checkout_page', '=', false )
            ),
			array(
                'id'       => 'system_booking_oncall',
                'type'     => 'switch',
                'title'    => esc_html__( 'Appointment on call?', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Admin can enable appointment on calls. Either phone calls received to admin or allow doctors to show their own phone numbers to get appointments.', 'doctreat_core' ),
				'required' => array( 'payment_type', '=', 'offline' )
			),
			array(
				'id'		=> 'booking_model_logo',
				'type' 		=> 'media',
				'url'       => false,
				'title' 	=> esc_html__('Logo', 'doctreat_core'),
				'desc' 		=> esc_html__('Logo for appointment on call', 'doctreat_core'),
				'required' 	=> array( 'system_booking_oncall', '=', true ),
			),
			array(
				'id'       => 'booking_model_title',
				'type'     => 'text',
				'default'  => '',
				'title'    => esc_html__( 'Title', 'doctreat_core' ),
				'desc'     => esc_html__( 'Title which will show on appointment on call form.', 'doctreat_core' ),
				'required' => array( 'system_booking_oncall', '=', true ),
			),
			array(
				'id'       => 'booking_system_contact',
				'type'     => 'select',
				'default'  => 'doctor',
				'title'    => esc_html__('Appointments type?', 'doctreat_core'), 
				'desc'     => esc_html__('Either phone calls received to admin or allow doctors to show their own phone numbers to get appointments.', 'doctreat_core'),
				'options'  => array(
					'admin' 	=> esc_html__('By Admin', 'doctreat_core'),
					'doctor' 	=> esc_html__('By Doctors', 'doctreat_core') 
				),
				'required' => array( 'system_booking_oncall', '=', true ),
			),
			array(
				'id'    => 'booking_contact_numbers',
				'type'  => 'multi_text',
				'title' => esc_html__( 'Contact numbers', 'doctreat_core' ),
				'desc'	=> esc_html__('Add contact number.','doctreat_core'),
				'required' => array( 'booking_system_contact', '=', 'admin' )
			),
			array(
				'id'       => 'booking_contact_detail',
				'type'     => 'editor',
				'title'    => esc_html__( 'Details', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add booking details', 'doctreat_core' ),
				'default'  => '',
				'required' => array( 'booking_system_contact', '=', 'admin' )
			),

		)
	)
);

Redux::setSection( $opt_name, array(
	'title'            => esc_html__( 'Payout Settings ', 'doctreat_core' ),
	'id'               => 'payout_settings',
	'desc'       	   => '',
	'subsection'       => true,
	'icon'			   => 'el el-braille',	
	'fields'           => array(	
			array(
				'id' 		=> 'admin_commision',
				'type' 		=> 'slider',
				'title' 	=> esc_html__('Set admin commision', 'doctreat_core'),
				'desc' 		=> esc_html__('Select Service commission in percentage ( % ), set it to 0 to make commission free website', 'doctreat_core'),
				"default" 	=> 1,
				"min" 		=> 0,
				"step" 		=> 1,
				"max" 		=> 100,
				'display_value' => 'label',
			),
			array(
				'id'       => 'min_amount',
				'type'     => 'text',
				'title'    => esc_html__('Add min amount', 'doctreat_core'), 
				'desc'     => esc_html__('', 'doctreat_core'),
				'default'  => '',
			),
			array(
				'id'       => 'cron_interval',
				'type'     => 'select',
				'title'    => esc_html__('Cron job interval', 'doctreat_core'), 
				'desc'     => esc_html__('Select interval for payouts.', 'doctreat_core'),
				'desc' 	=> wp_kses( __( 'Select interval for payouts.<br> '.esc_html__('Get interval list','doctreat_core').' <a href="#" class="am-get-list">'.esc_html__('Click here','doctreat_core').'</a>', 'doctreat_core' ), array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						) ),
				'options'  => $schedules_list,
			),
			array(
				'id'       => 'payout_setting',
				'type'     => 'select',
				'multi'    => true,
				'title'    => esc_html__('Payout settings', 'doctreat_core'), 
				'desc'     => esc_html__('Please select payouts methods, at-least one payout method is required. Default would be PayPal', 'doctreat_core'),
				'options'  => $payment_method,
			),
		)
	)
);
