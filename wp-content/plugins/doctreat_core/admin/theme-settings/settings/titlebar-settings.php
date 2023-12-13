<?php
/**
 * Titlebar Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Titlebar Settings', 'doctreat_core' ),
        'id'               => 'titlebar_settings',
        'subsection'       => false,
		'icon'			   => 'el el-address-book',
        'fields'           => array(
			array(
				'id'       => 'titlebar_type',
				'type'     => 'select',
				'title'    => esc_html__('Breadcrumbs', 'doctreat_core'), 
				'desc'     => esc_html__('Enable or disable breadcrumbs. It will hide all over the site', 'doctreat_core'),
				'options'  => array(
					'default' 	=> esc_html__('Show it', 'doctreat_core'), 
					'none' 		=> esc_html__('None, hide it', 'doctreat_core'), 
				),
				'default'  => 'default',
			),
			array(
				'id'       => 'title_bar_bg',
				'type'     => 'color',
				'title'    => esc_html__('Title bar background color', 'doctreat_core'), 
				'subtitle' => esc_html__('Add titlebar background color.', 'doctreat_core'),
				'default'  => '#f7f7f7',
			),
			array(
				'id'       => 'title_bar_text',
				'type'     => 'color',
				'title'    => esc_html__('Title bar text color', 'doctreat_core'), 
				'subtitle' => esc_html__('Add titlebar text color.', 'doctreat_core'),
				'default'  => '#767676',
			),
		)
	)
);