<?php
/**
 * Typography Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Typography', 'doctreat_core' ),
        'id'               => 'typography_settingss',
        'subsection'       => false,
		'icon'			   => 'el el-text-height',
        'fields'           => array(
			array(
				'id'       => 'typography_option',
				'type'     => 'switch',
				'title'    => esc_html__( 'Typography', 'doctreat_core' ),
				'default'  => false,
				'desc'     => esc_html__( 'Enable/Disable', 'doctreat_core' ),
            ),
			array(
				'id'          => 'regular_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('Regular Font', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Arial', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'body_paragraph_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('Body paragraph', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Arial', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'h1_heading_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('H1 Heading', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Arial', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'h2_heading_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('H2 Heading_typography', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Arial', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'h3_heading_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('H3 Heading Typography', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Abel', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'h4_heading_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('H4 Heading Typography', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Abel', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'h5_heading_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('H5 Heading Typography', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Abel', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			),
			array(
				'id'          => 'h6_heading_typography',
				'type'        => 'typography', 
				'title'       => esc_html__('H6 Heading Typography', 'doctreat_core'),
				'google'      => true, 
				'font-backup' => true,
				
				'units'       =>'px',
				'subtitle'    => esc_html__('Default Font for body ul li.', 'doctreat_core'),
				'default'     => array(
					'color'       => '#333', 
					'font-style'  => '700', 
					'font-family' => 'Abel', 
					'google'      => false,
					'font-size'   => '33px', 
					'line-height' => '40'
				),
				'required' => array( 'typography_option', '=', true ),
			)
		)
	)
);