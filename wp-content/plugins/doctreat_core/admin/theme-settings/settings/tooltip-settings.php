<?php
/**
 * ToolTIp Settings
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */

$tool_tip_array	= array(
					array(
						'id'       => 'tip_content_bg',
						'type'     => 'color',
						'title'    => esc_html__('Content Background color', 'doctreat_core'), 
						'subtitle' => esc_html__('Pick a tooltip  Content Background color (default: #3fabf3).', 'doctreat_core'),
						'default'  => '#3fabf3',
					),
					array(
						'id'       => 'tip_content_color',
						'type'     => 'color',
						'title'    => esc_html__('Content color', 'doctreat_core'), 
						'subtitle' => esc_html__('Pick a tooltip  Content color  (default: #3fabf3).', 'doctreat_core'),
						'default'  => '#fff',
					),
					array(
						'id'       => 'tip_title_bg',
						'type'     => 'color',
						'title'    => esc_html__('Title Background color', 'doctreat_core'), 
						'subtitle' => esc_html__('Pick a tooltip  Title Background color(default: #3fabf3).', 'doctreat_core'),
						'default'  => '#3fabf3',
					),
					array(
						'id'       => 'tip_title_color',
						'type'     => 'color',
						'title'    => esc_html__('Title color', 'doctreat_core'), 
						'subtitle' => esc_html__('Pick a tooltip  Title color(default: #3fabf3).', 'doctreat_core'),
						'default'  => '#fff',
					)
				);

$field_array	= array();
if( function_exists('doctreat_tooltip_fields')){
	$field_array	= doctreat_tooltip_fields();
}

if(!empty($field_array)){
	$tool_tip_array[]	= array(
		'id'   	=>'tooltip_field_divider',
		'type' 	=> 'info',
		'title' => esc_html__('Tooltip field text', 'doctreat_core'),
		'style' => 'info',
	);
	foreach($field_array as $key	=> $val){
		$tool_tip_array[]	= array(
				'id'       => 'tip_'.$key,
				'type'     => 'text',
				'title'    =>	$val,
				'default'  => ''
		);
	}
}

Redux::setSection( $opt_name, array(
        'title'            => esc_html__( 'Tooltip Settings', 'doctreat_core' ),
        'id'               => 'tooltip_settings',
        'subsection'       => false,
		'icon'			   => 'el el-ok-circle',
        'fields'           => $tool_tip_array,
	)
);