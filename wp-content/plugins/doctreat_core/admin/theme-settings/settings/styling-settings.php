<?php
/**
 * Stylings Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Stylings', 'doctreat_core' ),
        'id'               => 'styling_settings',
        'subsection'       => false,
		'icon'			   => 'el el-css',
        'fields'           => array(
			array(
                'id'       => 'site_colors',
                'type'     => 'switch',
                'title'    => esc_html__( 'Site colors', 'doctreat_core' ),
                'default'  => false,
				'desc'     => esc_html__( '', 'doctreat_core' ),
            ),	
			array(
				'id'       => 'theme_primary_color',
				'type'     => 'color',
				'title'    => esc_html__('Theme Primary Color', 'doctreat_core'), 
				'subtitle' => esc_html__('Pick a theme color for the theme (default: #3fabf3).', 'doctreat_core'),
				'default'  => '#3fabf3',
				'required' => array( 'site_colors', '=', true ),
			),
			array(
				'id'       => 'theme_secondary_color',
				'type'     => 'color',
				'title'    => esc_html__('Theme Secondary Color', 'doctreat_core'), 
				'subtitle' => esc_html__('Pick a Secondary Color for the theme (default: #ff5851).', 'doctreat_core'),
				'default'  => '#ff5851',
				'required' => array( 'site_colors', '=', true ),
			),
			array(
				'id'       => 'theme_tertiary_color',
				'type'     => 'color',
				'title'    => esc_html__('Theme Tertiary Color', 'doctreat_core'), 
				'subtitle' => esc_html__('Pick a theme color for the theme (default: #3d4461).', 'doctreat_core'),
				'default'  => '#3d4461',
				'required' => array( 'site_colors', '=', true ),
			),
			array(
				'id'       => 'theme_footer_color',
				'type'     => 'color',
				'title'    => esc_html__('Theme Footer Color', 'doctreat_core'), 
				'subtitle' => esc_html__('Pick a footer color for the theme (default: #3d4461).', 'doctreat_core'),
				'default'  => '#3d4461',
				'required' => array( 'site_colors', '=', true ),
			)
		)
	)
);