<?php
/**
 * Booking Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Booking Settings', 'doctreat_core' ),
        'id'               => 'booking_settings',
        'subsection'       => false,
		'icon'			   => 'el el-time',
        'fields'           => array(
			array(
				'id'    => 'appointment_prefix',
				'type'  => 'text',
				'title' => esc_html__( 'Appointment', 'doctreat_core' ), 
				'default' => 'APP#',
			),
			array(
				'id'       => 'allow_consultation_zero',
				'type'     => 'select',
				'title'    => esc_html__('Allow consultation fee to 0', 'doctreat_core'), 
				'desc' =>  __( 'Allow consultation fee to 0, while adding location', 'doctreat_core' ),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core') 
				),
				'default'  => 'no',
			),
			array(
				'id'       => 'allow_booking_zero',
				'type'     => 'select',
				'title'    => esc_html__('Allow booking fee to 0', 'doctreat_core'), 
				'desc' =>  __( 'Allow booking fee to 0, while booking with doctor', 'doctreat_core' ),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core') 
				),
				'default'  => 'no',
			),
            array(
                'id'       => 'hide_prescription',
                'type'     => 'select',
                'title'    => esc_html__('Hide prescription', 'doctreat_core'),
                'desc' 	   =>  esc_html__( 'Hide prescription module', 'doctreat_core' ),
                'options'  => array(
                    'yes' 	=> esc_html__('Yes', 'doctreat_core'),
                    'no' 	=> esc_html__('No', 'doctreat_core')
                ),
                'default'  => 'no',
            ),
			array(
				'id'       => 'hide_prescription',
				'type'     => 'select',
				'title'    => esc_html__('Hide prescription', 'doctreat_core'), 
				'desc' 	   =>  esc_html__( 'Hide prescription module', 'doctreat_core' ),
				'options'  => array(
					'yes' 	=> esc_html__('Yes', 'doctreat_core'),
					'no' 	=> esc_html__('No', 'doctreat_core') 
				),
				'default'  => 'no',
			),
			array(
				'id'       => 'precription_details',
				'type'     => 'select',
				'default'  => 'hospital',
				'title'    => esc_html__('Show prescription details', 'doctreat_core'), 
				'desc' =>  __( 'Show either hospital details on prescription or doctor details like logo, name etc', 'doctreat_core' ),
				'options'  => array(
					'hospital' 	=> esc_html__('Hospital details', 'doctreat_core'),
					'doctor' 	=> esc_html__('Doctor details', 'doctreat_core') 
				),
				'default'  => 'doctor',
			),
			array(
                'id'       => 'dashboad_booking_option',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Booking', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'Enable it to add custom bookings from doctor dashboard', 'doctreat_core' ),
			),
			array(
                'id'       => 'feedback_option',
                'type'     => 'switch',
                'title'    => esc_html__( 'Feedback to doctors', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( 'By enable this patient will be able to add feedback having atleast 1 booking with the doctor. By defult any user can post a feedback.', 'doctreat_core' )
			),
			array(
                'id'       => 'booking_verification',
                'type'     => 'switch',
                'title'    => esc_html__('Remove user verification', 'doctreat_core' ),
                'default'  => true,
				'desc'     => esc_html__('If this switch is enabled then verification steps will appear, you can disable this options to disable verification steps in the booking process', 'doctreat_core' )
			),
		)
	)
);