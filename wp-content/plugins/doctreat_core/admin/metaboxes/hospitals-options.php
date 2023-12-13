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

global $wp_registered_sidebars,$theme_settings;
$json	 = array();
$form_el = new AMetaboxes();

$gallery_option	= !empty($theme_settings['enable_gallery']) ? $theme_settings['enable_gallery'] : '';

$menu	= array();
$menu[]	= array( esc_html__('Personal details', 'doctreat_core') , 'ho_details' , 'pushpin' , true );
$menu[]	= array( esc_html__('Location', 'doctreat_core') , 'drlocation' , 'pushpin' , false );
$menu[]	= array( esc_html__('Specialities & Services', 'doctreat_core') , 'ho_services' , 'pushpin' , false );
$menu[]	= array( esc_html__('Registration', 'doctreat_core') , 'ho_registration' , 'pushpin' , false );

if(!empty($gallery_option)){
	$menu[]	= array( esc_html__('Gallery', 'doctreat_core') , 'ho_gallery' , 'pushpin' , false );	
}

$specialities		= doctreat_get_taxonomy_array('specialities');
$specialities_json	= array();
$specialities_json['categories'] = array();
if( !empty( $specialities ) ){
	foreach( $specialities as $speciality ) {
		$services_array				= doctreat_list_service_by_specialities($speciality->term_id);
		$json[$speciality->term_id] = $services_array;
	}
	
	$specialities_json['categories'] = $json;
}

?>
<div class="dc-main-metaoptions">
	<div class="am_option_tabs">
		<ul><?php $form_el->form_process_general_menu($menu); ?></ul>
	</div>
	
	<div class='am_metabox'>
		<?php if(!empty($gallery_option)){ ?>
			<div id="am_ho_gallery_tab" style="display:none" >
				<?php
					$form_el->form_process_gallery(
						array(
							'name' 		=> esc_html__('Gallery', 'doctreat_core'),
							'id' 		=> 'gallery',
							'std' 		=> '',
							'desc' 		=> esc_html__('', 'doctreat_core'),
							'meta' 		=> ''
						)
					);
				?>
			</div>
		<?php } ?>
	   <div id="am_ho_details_tab" >
		<?php
		   $form_el->form_process_text(
				array('name' 	=> esc_html__('Sub heading','doctreat_core'),
					'id' 		=> 'sub_heading',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
		   $form_el->form_process_text(
				array('name' 	=> esc_html__('First name','doctreat_core'),
					'id' 		=> 'first_name',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
		   $form_el->form_process_text(
				array('name' 	=> esc_html__('Last name','doctreat_core'),
					'id' 		=> 'last_name',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
			$form_el->form_process_text(
				array('name' 	=> esc_html__('Personal mobile number','doctreat_core'),
					'id' 		=> 'mobile_number',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
		   $form_el->form_process_text(
				array('name' 	=> esc_html__('Short description','doctreat_core'),
					'id' 		=> 'short_description',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
		   $form_el->form_process_radio_working(
				array(
					'name' 	=> esc_html__('Working Time','doctreat_core'),
					'id' 		=> 'availability',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
		   $form_el->form_process_checkbox_days(
				array(
					'name' 	=> esc_html__('Days I Offer My Services','doctreat_core'),
					'id' 		=> 'week_days',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);
			$form_el->form_repeater_single(
				array('name' 		=> esc_html__('Phone Number"s','doctreat_core'),
					'id' 			=> 'phone_numbers',
					'std' 			=> '',
					'field_type'	=> 'text',
					'desc' 			=> esc_html__('','doctreat_core'),
					'meta' 			=> '',
					'btn_text'		=> esc_html__('Add row','doctreat_core'),
				)
			);
			$form_el->form_process_text(
				array('name' 	=> esc_html__('Web url','doctreat_core'),
					'id' 		=> 'web_url',
					'std' 		=> '',
					'desc' 		=> esc_html__('','doctreat_core'),
					'meta' 		=> ''
				)
			);

		?>
		</div>
		<div id="am_drlocation_tab" style="display:none" >
			 <?php
				$form_el->form_process_text(
					array(
						'name' 	=> esc_html__('Address','doctreat_core'),
						'id' 		=> '_address',
						'std' 		=> '',
						'option' 	=> 'single',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> '',

					)
				);
				$form_el->form_process_text(
					array(
						'name' 	=> esc_html__('Latitude','doctreat_core'),
						'id' 		=> '_latitude',
						'std' 		=> '',
						'option' 	=> 'single',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> '',

					)
				);
				$form_el->form_process_text(
					array(
						'name' 	=> esc_html__('Longitude','doctreat_core'),
						'id' 		=> '_longitude',
						'std' 		=> '',
						'option' 	=> 'single',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> '',

					)
				);
			?>
		</div>
		<div id="am_ho_services_tab" style="display:none">
			 <?php
				$form_el->form_nested_repeater(
					array('name' 	=> esc_html__('Manage specialities & services','doctreat_core'),
						'id' 		=> 'specialities',
						'std' 		=> '',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> '',
						'btn_text'	=> esc_html__('Add row','doctreat_core'),
						'fields' 	=> array (
											array(
												'name' 		=> esc_html__('Name base','doctreat_core'),
												'id' 		=> 'speciality_id',
												'std' 		=> 'default',
												'desc' 		=> '',
												//'options' 	=> $name_bases,
												'field_type' => 'specialities',
											)
										)
						  )
					);
			?>
		</div>
		<div id="am_ho_registration_tab" style="display:none">
			 <?php
				$form_el->form_process_text(
					array('name' 	=> esc_html__('Registration number','doctreat_core'),
						'id' 		=> 'registration_number',
						'std' 		=> '',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> ''
					)
				);
				$form_el->form_process_upload(
					array('name' 	=> esc_html__('Upload document','doctreat_core'),
						'id' 		=> 'document',
						'std' 		=> '',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> '',
						'thumnail'	=> false
					)
				);
				$form_el->form_process_checkbox(
					array(
						'name' 		=> esc_html__('Verified document','doctreat_core'),
						'id' 		=> 'is_verified',
						'std' 		=> 'no',
						'desc' 		=> esc_html__('','doctreat_core'),
						'meta' 		=> ''
					)
				);
			?>
		</div>
	</div>
	<script>
		var DT_Editor = {};
			DT_Editor.elements = {};
			window.DT_Editor = DT_Editor;
			DT_Editor.elements = jQuery.parseJSON( '<?php echo addslashes(json_encode($specialities_json['categories']));?>' );
	</script>           
	<script type="text/template" id="tmpl-load-specialities">
		<div class="repeater-wrap-inner specialities_parents" id="{{data.counter}}">
			<div class="remove-repeater"><span class="dashicons dashicons-trash"></span></div>
			<div class="am_field">
				<div class="am_field dropdown-style">
					<?php doctreat_get_specialities_list('am_specialities[{{data.counter}}][speciality_id]');?>
				</div>
				<div class="services-wrap">
					<div class="system-buttons">
						<a href="javascript:;" id="add-service-{{data.counter}}" data-id="{{data.counter}}" class="add-repeater-services"><?php echo esc_html__('Add Services','doctreat_core');?></a>
					</div>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="tmpl-load-services">
		<div class="repeater-wrap-inner services-item" id="{{data.counter}}">
			<div class="remove-repeater"><span class="dashicons dashicons-trash"></span></div>
			<div class="am_field">
				<div class="am_field dropdown-style related-services">
					<select name="am_specialities[{{data.id}}][services][{{data.counter}}][service]" class="sp_services">
						<#if( !_.isEmpty(data['options']) ) {#>
							<#
								var _option	= '';
								_.each( data['options'] , function(element, index, attr) {
									var _checked	= '';

								#>
									<option value="{{index}}" data-id="{{index}}">{{element["name"]}}</option>
								<#	
								});
							#>
						<# } #>
					</select>
				</div>
				<div class="am_field">
					<input type="text" name="am_specialities[{{data.id}}][services][{{data.counter}}][price]" placeholder="<?php esc_html_e('Price','doctreat_core');?>" class="">
				</div>
				<div class="am_field">
					<textarea name="am_specialities[{{data.id}}][services][{{data.counter}}][description]" placeholder="<?php esc_html_e('Description','doctreat_core');?>" class=""></textarea>
				</div>
			</div>
		</div>
	</script>
	<script type="text/template" id="tmpl-load-services-options">
		<# if( !_.isEmpty(data['options']) ) {#>
			<# _.each( data['options'] , function(element, index, attr) {#>
					<option value="{{index}}" data-id="{{index}}">{{element["name"]}}</option>
				<#	});
			#>
		<# } #>
	</script>
	<script type="text/template" id="tmpl-load-phone_numbers">
		<div class="repeater-wrap-inner">
			<div class="remove-repeater"><span class="dashicons dashicons-trash"></span></div>
			<div class="am_field">
				<input type="text" placeholder="<?php echo esc_html__('Phone number','doctreat_core');?>" id="field-{{data.counter}}" name="am_{{data.name}}[]" value="">
			</div>
		</div>
	</script>
</div>