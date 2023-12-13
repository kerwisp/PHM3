<?php
/**
 * Article Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Article Settings', 'doctreat_core' ),
        'id'               => 'article_settings',
		'desc'       	   => '',
		'subsection'       => false,
		'icon' 			   => 'el el-edit',
        'fields'           => array(
			array(
				'id'       => 'article_option',
				'type'     => 'select',
				'title'    => esc_html__( 'Article status?', 'doctreat_core' ),
				'desc'     => esc_html__( 'Select either articles should be published or needs the admin approval before publish.', 'doctreat_core' ),
				'options'  => array(
					'pending' 	=> esc_html__('Needs approval', 'doctreat_core'),
					'publish' 	=> esc_html__('Auto published', 'doctreat_core') 
				),
				'default'  => 'pending',
			),
		)
	)
);