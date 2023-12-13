<?php if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * Custom Scripts Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
		'title'      => esc_html__( 'CSS/JS Scripts', 'doctreat_core' ),
		'id'         => 'custom_code',
		'desc'       => '',
		'icon' 		 => 'el el-css',
		'subsection'       => false,
		'fields'     => array(
			array(
				'id'       => 'custom_css',
				'type'     => 'ace_editor',
				'title'    => esc_html__('Custom CSS', 'doctreat_core'),
				'subtitle' => esc_html__('Paste your CSS code here.', 'doctreat_core'),
				'mode'     => 'css',
				'theme'    => 'monokai',
				'desc'     => '',
				'default'  => ""
			),
			array(
				'id'       => 'custom_js',
				'type'     => 'ace_editor',
				'title'    => esc_html__('Custom JS', 'doctreat_core'),
				'subtitle' => esc_html__('Paste your JS code here.', 'doctreat_core'),
				'mode'     => 'css',
				'theme'    => 'monokai',
				'desc'     => '',
				'default'  => ""
			),
		)
	) 
);