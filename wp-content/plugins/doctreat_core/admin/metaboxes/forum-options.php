<?php
/**
 * @File Type	General Options for pages, posts and custom post type
 * @package	 	WordPress
 * @link 		https://themeforest.net/user/amentotech
 */

// die if accessed directly
if (!defined('ABSPATH')) {
    die('no kiddies please!');
}

global $wp_registered_sidebars;

$form_el 				= new AMetaboxes();
$am_sidebarsArray		= array();
$am_sidebarsArray[''] 	= esc_html__('No Sidebar','doctreat_core');
$sidebars = $wp_registered_sidebars;
if (is_array($sidebars) && !empty($sidebars)) {
    foreach ($sidebars as $key => $sidebar) {
        $am_sidebarsArray[$key] = $sidebar['name'];
    }
}

$revsliders		= array();
$revsliders[0] 	= esc_html__('Select a slider','doctreat_core');
if (class_exists('RevSlider')) {
	if( function_exists('doctreat_prepare_rev_slider') ){
		$revsliders	= doctreat_prepare_rev_slider();
	}	
}

$form_el = new AMetaboxes();
$menu	= array();
$menu[]	= array( esc_html__('Seo', 'doctreat_core') , 'seo' , 'pushpin' , true );
$menu[]	= array( esc_html__('Sidebar', 'doctreat_core') , 'sidebar' , 'pushpin' , false );
$menu[]	= array( esc_html__('Page Title Bar', 'doctreat_core') , 'pagetitlebar' , 'pushpin' , false );
?>
<div class="dc-main-metaoptions">
	<div class="am_option_tabs">
		<ul><?php $form_el->form_process_general_menu($menu); ?></ul>
	</div>
	<div class='am_metabox'>
		<div id="am_seo_tab">
			<?php
				$form_el->form_process_text(
						array('name' 	=> esc_html__('Seo Title','doctreat_core'),
							'id' 		=> 'seo_title',
							'std' 		=> '',
							'desc' 		=> esc_html__('','doctreat_core'),
							'meta' 		=> ''
						)
				);

				$form_el->form_process_textarea(
						array('name' 	=> esc_html__('Seo Description','doctreat_core'),
							'id' 		=> 'seo_description',
							'std' 		=> '',
							'desc' 		=> esc_html__('','doctreat_core'),
							'meta' 		=> ''
						)
				);

				$form_el->form_process_text(
						array('name' 	=> esc_html__('Seo Keywords','doctreat_core'),
							'id' 		=> 'seo_keywords',
							'std' 		=> '',
							'desc' 		=> esc_html__('','doctreat_core'),
							'meta' 		=> ''
						)
				);
			?>
		</div>
		<div id="am_sidebar_tab" style="display:none">
		<?php
			$form_el->form_process_select(
					array('name' 	=> esc_html__('Layout','doctreat_core'),
						'id' 		=> 'layout',
						'std' 		=> 'no_sidebar',
						'desc' 		=> esc_html__('Select sidebar layout to display sidebar on this page.','doctreat_core'),
						'options' 	=> array(
							'default' 			=> esc_html__('Default Setting','doctreat_core'),
							'no_sidebar' 		=> esc_html__('No Sidebar','doctreat_core'),
							'left_sidebar' 		=> esc_html__('Left Sidebar','doctreat_core'),
							'right_sidebar' 	=> esc_html__('Right Sidebar','doctreat_core'),
						)
					)
			);

			$form_el->form_process_select(
					array('name' 	=> esc_html__('Sidebar','doctreat_core'),
						'id' 		=> 'sidebar',
						'std' 		=> '',
						'desc' 		=> esc_html__('Choose left sidebar.','doctreat_core'),
						'options' 	=> $am_sidebarsArray
					)
			);
		?>
		</div>
		<div id="am_pagetitlebar_tab" style="display:none">
		<?php
			$form_el->form_process_select(
					array('name' 	=> esc_html__('Page Title Bar','doctreat_core'),
						'id' 		=> 'title_bar',
						'std' 		=> 'default',
						'desc' 		=> '',
						'options' => array(
							'default' 	=> esc_html__('Default Setting','doctreat_core'),
							'custom'	=> esc_html__('Custom Settings','doctreat_core'),
							'rev' 		=> esc_html__('Revolution Slider','doctreat_core'),
							'custom'	=> esc_html__('Custom Shortcode','doctreat_core'),
							'hide' 		=> esc_html__('None, hide it','doctreat_core'),
						)
					)
			);

			$form_el->form_process_select(
				array('name' 	=> esc_html__('Breadcrumb?','doctreat_core'),
					'id' 		=> 'breadcrumb',
					'std' 		=> 'custom',
					'desc' 		=> esc_html__('Enable or disable breadcrumb for this page.','doctreat_core'),
					'options' => array(
						'enable' 	=> esc_html__('Enable','doctreat_core'),
						'disable'	=> esc_html__('Disable','doctreat_core'),
					)
				)
			);

			$form_el->form_process_select(
					array('name' 	=> esc_html__('Choose Resolution Slider','doctreat_core'),
						'id' 		=> 'rev_slider',
						'std' 		=> '',
						'desc' 		=> esc_html__('Select Revolution Slider.','doctreat_core'),
						'options' 	=> $revsliders
					)
			);

			$form_el->form_process_textarea(
					array('name' 	=> esc_html__('Add shortcode','doctreat_core'),
						'id' 		=> 'shortcode',
						'std' 		=> '',
						'desc' 		=> esc_html__('Add any shortcode in textarea','doctreat_core'),
					)
			);
		?>
		</div>
	</div>
</div>
