<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Api Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

$mailchip_list	=  get_transient( 'latest-mailchimp-list' );

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Api Settings', 'doctreat_core' ),
        'id'               => 'api-settings',
		'subsection'       => false,
       	'desc'       	   => '',
		'icon'       	   => 'el el-key',
        'fields'           => array(
			array(
				'id'    =>'divider_1',
				'type'  => 'info',
				'title' => esc_html__('Google API Key', 'doctreat_core'),
    			'style' => 'info',
			),
			array(
                'id'       => 'google_map',
                'type'     => 'text',
                'title'    => esc_html__( 'Google Map Key', 'doctreat_core' ),
                'desc' 	   => wp_kses( __( 'Enter google map key here. It will be used for google maps. Get and Api key From <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank"> Get API KEY </a>', 'doctreat_core' ), array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						) ),
                'default'  => '',
            ),
			array(
				'id'   	=>'divider_2',
				'type' 	=> 'info',
				'title' => esc_html__('MailChimp API Key', 'doctreat_core'),
    			'style' => 'info',
			),
			array(
                'id'       => 'mailchimp_key',
                'type'     => 'text',
                'title'    => esc_html__( 'MailChimp Key', 'doctreat_core' ),
                'desc' 	=> wp_kses( __( 'Get Api key From <a href="https://us11.admin.mailchimp.com/account/api/" target="_blank"> Get API KEY </a> <br/> You can create list <a href="https://us11.admin.mailchimp.com/lists/" target="_blank">here</a><br>'.esc_html__('Latest MailChimp List ','doctreat_core').'<a href="#" class="am-latest-mailchimp-list">'.esc_html__('Click here','doctreat_core').'</a>', 'doctreat_core' ), array(
							'a' => array(
								'href' => array(),
								'class' => array(),
								'title' => array()
							),
							'br' => array(),
							'em' => array(),
							'strong' => array(),
						) ),
                'default'  => '',
            ),
			array(
				'id'       => 'mailchimp_list',
				'type'     => 'select',
				'title'    => esc_html__('MailChimp List', 'doctreat_core'), 
				'desc'     => esc_html__('Select one of the list for newsletters', 'doctreat_core'),
				'options'  => $mailchip_list,
			),
			array(
				'id'    =>'divider_3',
				'type'  => 'info',
				'title' => esc_html__('Twitter API Key', 'doctreat_core'),
    			'style' => 'info',
			),
			array(
                'id'       => 'consumer_key',
                'type'     => 'text',
                'title'    => esc_html__( 'Consumer Key', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => '',
            ),
			array(
                'id'       => 'consumer_secret',
                'type'     => 'text',
                'title'    => esc_html__( 'Consumer Key Secret', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => '',
            ),
			array(
                'id'       => 'access_token',
                'type'     => 'text',
                'title'    => esc_html__( 'Access Token', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => '',
            ),
			array(
                'id'       => 'access_token_secret',
                'type'     => 'text',
                'title'    => esc_html__( 'Access Token Secret', 'doctreat_core' ),
                'desc'     => esc_html__( '', 'doctreat_core' ),
                'default'  => '',
            )
		)
	)
);