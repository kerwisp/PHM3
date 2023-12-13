<?php
/**
 * Health Forum Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Health Forum Settings', 'doctreat_core' ),
        'id'               => 'health_forum_settings',
		'subsection'       => false,
		'icon'			   => 'el el-list-alt',
        'fields'           => array(
			array(
				'id'       => 'hf_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Title', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add title or leave it empty to hide.', 'doctreat_core'),
				'default'  => esc_html__( 'Ask Query To Qualifed Doctors', 'doctreat_core'),
			),
			array(
				'id'       => 'hf_sub_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Sub title', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add sub title or leave it empty to hide.', 'doctreat_core'),
				'default'  => 'To Get Your Solution',
			),
			array(
				'id'       => 'hf_description',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Description', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add description or leave it empty to hide.', 'doctreat_core'),
				'default'  => esc_html__( 'Lorem ipsum dolor amet consectetur adipisicing elit eiuim sete eiu tempor incididunt.', 'doctreat_core'),
			),
			array(
				'id'       => 'hf_btn_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Button text', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add button text or leave it empty to hide.', 'doctreat_core'),
				'default'  => esc_html__( 'Post Your Question', 'doctreat_core'),
			),
			array(
				'id'       => 'hf_image',
				'type'     => 'media',
				'title'    => esc_html__( 'Add Image', 'doctreat_core' ),
				'desc'     => esc_html__( 'Add image or leave it empty to hide.', 'doctreat_core'),
				'default'  => '',
			),
			array(
                'id'       => 'hf_search_form',
                'type'     => 'switch',
                'title'    => esc_html__( 'Search Header form Enable/Disable', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( '', 'doctreat_core' ),
            ),
			array(
				'title' 	=> esc_html__( 'Remove doctor invitation', 'doctreat_core' ),
				'id'  		=> 'remove_doc_invite',
				'type'  	=> 'select',
				'default'  => 'no',
				'desc' 		=> esc_html__('Remove doctor invitation options', 'doctreat_core'),
				'options'	=> array(
					'yes'	  => esc_html__( 'Yes', 'doctreat_core' ),
					'no'	  => esc_html__( 'No', 'doctreat_core' ),
				)
			),
			array(
				'id'       => 'doctor_detail_forum',
				'type'     => 'select',
				'title'    => esc_html__('Hide forum tab', 'doctreat_core'), 
				'desc'     => esc_html__('Hide forum tab from doctor detail page', 'doctreat_core'),
				'options'  => array(
					'yes'	  => esc_html__( 'Yes', 'doctreat_core' ),
					'no'	  => esc_html__( 'No', 'doctreat_core' ),
				),
				'default'  => 'no',
			),
		)
	)
);