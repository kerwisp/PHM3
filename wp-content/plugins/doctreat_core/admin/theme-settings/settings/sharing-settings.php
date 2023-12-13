<?php
/**
 * Sharing Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Sharing Settings', 'doctreat_core' ),
        'id'               => 'sharing_settings',
        'subsection'       => false,
		'icon'			   => 'el el-share',
        'fields'           => array(
			array(
				'id'		   => 'social_facebook',
                'title'        => esc_html__('Facebook' , 'doctreat_core') ,
                'type'         => 'switch' ,
                'default'      => 'false' ,
                'desc'         => esc_html__('Facebook Sharing on/off' , 'doctreat_core') ,
            ) ,
			array(
				'id'		   => 'social_twitter',
                'title'        => esc_html__('Twitter Share' , 'doctreat_core') ,
                'type'         => 'switch' ,
                'default'      => 'false' ,
                'desc'         => esc_html__('Twitter Sharing on/off' , 'doctreat_core') ,
            ) ,
			array(
                'id'       => 'twitter_username',
                'type'     => 'text',
                'title'    => esc_html__( 'Twitter username', 'doctreat_core' ),
                'desc'     => esc_html__( 'This will be used in the tweet for the via parameter. The site name will be used if no twitter username is provided. Do not include the @', 'doctreat_core' ),
                'default'  => '',
				'required' => array( 'social_twitter', '=', true )
            ),
			array(
				'id'		   => 'social_gmail',
                'title'        => esc_html__('Google Share', 'doctreat_core') ,
                'type'         => 'switch' ,
                'default'      => 'false' ,
                'desc'         => esc_html__('Google Share on/off' , 'doctreat_core') ,
            ) ,
			array(
				'id'		   => 'social_pinterest',
                'title'        => esc_html__('Pinterest Share', 'doctreat_core') ,
                'type'         => 'switch' ,
                'default'      => 'false' ,
                'desc'         => esc_html__('Pinterest Sharing on/off', 'doctreat_core') ,
            ) ,
		)
	)
);