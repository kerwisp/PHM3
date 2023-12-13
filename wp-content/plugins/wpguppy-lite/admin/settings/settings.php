<?php

if (!class_exists('WPGuppy_Lite_Plugin_Options')) {
    /**
     *
     * @package WP Guppy
     */
	class WPGuppy_Lite_Plugin_Options {
        private static $_instance = null;
		
		/**
         * PRIVATE CONSTRUCTOR
         */
		public function __construct() {
			if (!is_plugin_active('wp-guppy/wp-guppy.php') ) {  
				add_action('admin_menu', array(&$this, 'wpguppy_admin_menu'));
				add_action('wp_ajax_wpguppy_update_guppy_admin_status', array(&$this,'wpguppy_update_guppy_admin_status'));
				add_action('wp_ajax_get_wpguppy_whatsapp_user_info', array(&$this,'get_wpguppy_whatsapp_user_info'));
				add_action('wp_ajax_wpguppy_update_whatsapp_info', array(&$this,'wpguppy_update_whatsapp_info'));

			}
		}

		/**
         * Call this method to get singleton
         *
         * @return 
         */
        public static function instance()
        {
            if (self::$_instance === null) {
                self::$_instance = new WPGuppy_Lite_Plugin_Options();
            }
            return self::$_instance;
        }

		/**
		 * Is admin, update status
		 *
		 * @link       wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		function wpguppy_update_guppy_admin_status() {
			global $wpdb;
			$json		= array();
			$user_id	= !empty($_POST['user_id']) 	? intval($_POST['user_id']) : '';
			$status		= !empty($_POST['status']) 		? intval($_POST['status']) : '';

			if( !is_admin() || empty($user_id) ){
				$json['type']		= 'error';
				$json['message']	= esc_html__('You are not allowed to perform this action!','wpguppy-lite');
				wp_send_json($json);
			}

			update_user_meta($user_id, 'is_guppy_admin', $status);
			
			$json['type']		= 'success';
			$json['message']	= esc_html__('Update status','wpguppy-lite');
			wp_send_json($json);
		}

		

		/**
		 * Load plugin menu
		 *
		 * @link       wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		public function wpguppy_admin_menu() {
			$menu_slug = 'wpguppy_options';
			$messages_page	= add_menu_page(esc_html__('WP Guppy Lite','wpguppy-lite'), 
											esc_html__('WP Guppy Lite','wpguppy-lite'), 
											'administrator',
											'wpguppy_settings',
											array( &$this,'wpguppy_settings'),
											WP_GUPPY_LITE_DIRECTORY_URI.'/admin/images/guppy.svg'
										);			
			add_action( "load-".$messages_page, array(&$this, 'wpguppy_load_settings') );
		}

		/**
		 * Load settings
		 *
		 * @link       wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		function wpguppy_load_settings() {
			global $pagenow;
			if ( isset($_POST["wpguppy_submit"]) && $_POST["wpguppy_submit"] == 'yes' ) {
				check_admin_referer( "wpguppy_options" );
				$settings = get_option( "wpguppy_settings" );
				if ($pagenow == 'admin.php' && $_GET['page'] == 'wpguppy_settings') {
					$wpguppy_settings	= !empty($_POST['wpguppy_settings']) ? sanitize_text_or_array_field($_POST['wpguppy_settings']) : array();
					$updated = update_option( "wpguppy_settings", $wpguppy_settings );
				}
				
				$url_params = isset($_GET['tab']) ? 'updated=true&tab='.sanitize_text_field($_GET['tab']) : 'updated=true';
				wp_redirect(admin_url('admin.php?page=wpguppy_settings&'.$url_params));
				exit;
			}
		}
		
		/**
		 * Guppy settings
		 *
		 * @link       wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		public function wpguppy_settings() {
			global	$wpguppy_settings;
			$tabs = array(
				'general'			=> esc_html__('General','wpguppy-lite'),
				'tabs'				=> esc_html__('Chat tabs','wpguppy-lite'),
				'style'				=> esc_html__('Styles','wpguppy-lite'),
				'media'				=> esc_html__('Media','wpguppy-lite'),
				'real-time-chat'	=> esc_html__('Real time chat','wpguppy-lite'),
				'translation'		=> esc_html__('Translation','wpguppy-lite'),
			);	
			$wpguppy_settings       = get_option( "wpguppy_settings" );
			$current_tab			= !empty($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'general';
			?>
			<?php $this->wpguppy_settings_tabs($tabs,$current_tab);?>
			<div id="poststuff">
				<form autocomplete="off" method="post" id="gp-settings-page-form" action="<?php admin_url('admin.php?page=wpguppy_options'); ?>">
					<?php
						foreach($tabs as $key => $tab ){
							$display_class	= !empty($current_tab) && $current_tab == $key ? '' : 'hide-if-js';
							wp_nonce_field( "wpguppy_options" ); 
							?>
							<div class="tab-content gb-tab-content <?php echo esc_attr($display_class);?>" id="tb-content-<?php echo esc_attr($key);?>">
								<div class="wrap">
									<?php require WP_GUPPY_LITE_DIRECTORY . 'admin/settings/templates/'.$key.'-options.php'; ?>
								</div>
								<?php if( !empty($key)){?>
									<input type="hidden" name="wpguppy_submit" value="yes"/>
									<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="<?php esc_attr_e('Save changes','wpguppy-lite');?>"></p>
								<?php }	?>
							</div>
						<?php
						} 
					echo '</div></div>';?>
				</form>
			</div>
			<?php
			
		}
		
		/**
		 * Guppy Tabs settings
		 *
		 * @link       wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		public function wpguppy_settings_tabs( $tabs,$current = '' ) {
			echo '<h2 class="nav-tab-wrapper">';
			
				foreach ( $tabs as $tab => $name ) {
					$class = ( $tab == $current ) ? ' nav-tab-active' : '';
					echo "<a id=".esc_attr($tab)."-settings-tab' data-tab_id=".esc_attr( $tab )." href='javascript:;' class='gp-tabs-settings nav-tab".esc_attr($class)."'>".esc_html($name)."</a>";
				}
			
			echo '</h2>';
		}

		/**
		 * get user whatsapp support info
		 *
		 * @link       https://wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		function get_wpguppy_whatsapp_user_info() {
			
			$json		= array();
			$user_id	= !empty($_GET['user_id']) ? $_GET['user_id'] : '';
			if( !is_admin() || empty($user_id) ){
				$json['type']		= 'error';
				$json['message']	= esc_html__('You are not allowed to perform this action!','wpguppy-lite');
				wp_send_json($json);
			}
			
			$guppy_whatsapp_info 	= get_user_meta($user_id, 'guppy_whatsapp_info', true);
			$user_designation 		= !empty($guppy_whatsapp_info['user_designation']) ? $guppy_whatsapp_info['user_designation'] : '';
			$user_contact 			= !empty($guppy_whatsapp_info['user_contact']) ? $guppy_whatsapp_info['user_contact'] : '';
			$user_default_message 	= !empty($guppy_whatsapp_info['user_default_message']) ? $guppy_whatsapp_info['user_default_message'] : '';
			$user_offline_message 	= !empty($guppy_whatsapp_info['user_offline_message']) ? $guppy_whatsapp_info['user_offline_message'] : '';
			$user_availability 		= !empty($guppy_whatsapp_info['user_availability']) ? $guppy_whatsapp_info['user_availability'] : array();
			$user_timezone 			= !empty($guppy_whatsapp_info['user_timezone']) ? $guppy_whatsapp_info['user_timezone'] : '';
			$guppy_time_slots 		= apply_filters( 'guppy_time_slots', '' );
			$guppy_timezones_list 	= guppy_timezones_list();
			$available_days 		= array();
			$start = get_option('start_of_week');
			
			$start 	= $start -1; 	//  -1 is for to start array index
			$end 	= $start + 6;
			for ($i = $start; $i <= $end; $i++) {
				$day = strtolower(jddayofweek($i,1));
				$available_days[$day] = $day;
			}

			ob_start();
			?>
			<form class="at-themeform" id="guppy-whatsapp-info-form">
				<fieldset>
					<div class="at-form-group">
						<label class="at-form-title"><?php esc_html_e('Add designation','wpguppy-lite');?></label>
						<div class="at-form-field">
							<input type="text" class="at-form-control" placeholder="<?php echo esc_attr('Enter designation title');?>" name="user_designation" value="<?php echo esc_attr($user_designation);?>" required="">
						</div>
					</div>
					<div class="at-form-group">
						<label class="at-form-title"><?php esc_html_e('Add contact number','wpguppy-lite');?></label>
						<div class="at-form-field">
							<input type="text" class="at-form-control" placeholder="<?php echo esc_attr('Enter contact number');?>" name="user_contact" value="<?php echo esc_attr($user_contact);?>" required="">
							<em><?php echo esc_html('Add WhatsApp contact number with a plus sign (+).', 'wpguppy-lite'); ?><a href="https://faq.whatsapp.com/general/contacts/how-to-add-an-international-phone-number" target="_blank"><?php echo esc_html('Read full detail', 'wpguppy-lite'); ?></a></em>
						</div>
					</div>
					<div class="at-form-group">
						<label class="at-form-title"><?php esc_html_e('Available time slots','wpguppy-lite');?></label>
						<div class="at-form-field-options">
							<?php if(!empty($available_days)){ ?>
								<?php foreach($available_days as $day=> $time){ ?>
									<?php
									$day_checked = $time_disabled = '';
									if(!empty($user_availability[$day])){
										$day_checked = 'checked';
									}else{
										$time_disabled = 'disabled';
									}
									?>
									<div class="at-form-field-wrap">
										<span class="db-guppy-checkbox">
											<input type="checkbox" name="available_days[]" <?php echo esc_attr($day_checked); ?> id="<?php echo esc_attr($day);?>" value="<?php echo esc_attr($day);?>">
											<label class="at-form-subtitle" for="<?php echo esc_attr($day);?>"><?php echo esc_attr(ucfirst($day));?></label>
										</span>
										<span class="at-select">
											<select  <?php echo esc_attr($time_disabled); ?> name="start_time[<?php echo esc_attr($day)?>]" id ="start_time_<?php echo esc_attr($day)?>">
												<?php if(!empty($guppy_time_slots)){?>
													<?php foreach($guppy_time_slots as $slot=> $value){ ?>
														<?php  
															$start_time_selected = '';
															$match_time = $value.':00';
															if(!empty($user_availability[$day]) && $user_availability[$day]['start_time'] == $match_time){
																$start_time_selected = 'selected';
															} 
														?>
														<option value="<?php echo esc_attr($value);?>" <?php echo esc_attr($start_time_selected); ?>><?php echo esc_attr($value);?></option>
													<?php } ?>	
												<?php } ?>
											</select>
										</span>
										<span class="at-select">
											<select <?php echo esc_attr($time_disabled); ?> name="end_time[<?php echo esc_attr($day)?>]" id ="end_time_<?php echo esc_attr($day)?>">
												<?php if(!empty($guppy_time_slots)){ 
													unset($guppy_time_slots['00:00']);
													?>
													<?php foreach($guppy_time_slots as $slot=> $value){ ?>
														<?php  
															$end_time_selected = '';
															$match_time = $value.':00';
															if(!empty($user_availability[$day]) && $user_availability[$day]['end_time'] == $match_time){
																$end_time_selected = 'selected';
															} 
														?>
														<option value="<?php echo esc_attr($value);?>" <?php echo esc_attr($end_time_selected); ?>><?php echo esc_attr($value);?></option>
													<?php } ?>	
												<?php } ?>
											</select>
										</span>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					<div class="at-form-group">
						<label class="at-form-title"><?php esc_html_e('Add time zone','wpguppy-lite');?></label>
						<div class="at-form-field">
							<select  name="user_timezone" id ="user_timezone">
								<option value=""><?php esc_html_e('Select time zone','wpguppy-lite');?></option>
								<?php if(!empty($guppy_timezones_list)){ ?>
									<?php foreach($guppy_timezones_list as $key=> $value){ ?>
										<?php  
											$timezone_selected = '';
											$match_time = $value.':00';
											if($user_timezone == $key){
												$timezone_selected = 'selected';
											} 
										?>
										<option value="<?php echo esc_attr($key);?>" <?php echo esc_attr($timezone_selected); ?>><?php echo esc_attr($value);?></option>
									<?php } ?>	
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="at-form-group">
						<label class="at-form-title"><?php esc_html_e('Default message','wpguppy-lite');?></label>
						<div class="at-form-field">
							<textarea type="text" class="at-form-control" placeholder="<?php echo esc_attr('Enter default message');?>" name="user_default_message" required=""> <?php echo ($user_default_message);?></textarea>
						</div>
					</div>
					<div class="at-form-group">
						<label class="at-form-title"><?php esc_html_e('Offline message','wpguppy-lite');?></label>
						<div class="at-form-field">
							<textarea type="text" class="at-form-control" placeholder="<?php echo esc_attr('Enter offline message');?>" name="user_offline_message" required=""> <?php echo ($user_offline_message);?></textarea>
						</div>
					</div>
					<div class="at-form-group">
						<div class="at-form-field">
							<button type="button" class="update-guppy-whatsapp-info" data-id="<?php echo esc_attr($user_id);?>"><?php esc_html_e('Save & update','wpguppy-lite');?></button>
						</div>
					</div>
				</fieldset>
			</form>
			<?php
			$html = ob_get_clean();
			$json['type']		= 'success';
			$json['html']	= $html;
			wp_send_json($json);
		}
		/**
		 * Update whatsapp support user information
		 *
		 * @link       https://wp-guppy.com
		 * @since      1.0.0
		 *
		 * @package    wp-guppy
		 * @subpackage wp-guppy/admin
		 */
		function wpguppy_update_whatsapp_info() {
			$json					= array();
			$user_id				= !empty($_POST['user_id']) ? $_POST['user_id'] : '';
			$status					= !empty($_POST['status']) 	? ($_POST['status']) : '';
			if( !is_admin() || empty($user_id) ){
				$json['type']		= 'error';
				$json['message']	= esc_html__('You are not allowed to perform this action!','wpguppy-lite');
				wp_send_json($json);
			}
			if($status == 1){
				$user_designation			= !empty($_POST['user_designation']) 		? wp_strip_all_tags($_POST['user_designation']) : '';
				$user_contact				= !empty($_POST['user_contact']) 			? sanitize_text_field($_POST['user_contact']) : '';
				$user_default_message		= !empty($_POST['user_default_message']) 	? wp_strip_all_tags($_POST['user_default_message']) : '';
				$user_offline_message		= !empty($_POST['user_offline_message'])    ? wp_strip_all_tags($_POST['user_offline_message']) : '';
				$available_days				= !empty($_POST['available_days']) 			? $_POST['available_days'] : array();
				$user_timezone				= !empty($_POST['user_timezone']) 			? $_POST['user_timezone'] : '';
				$start_time					= !empty($_POST['start_time']) 				? $_POST['start_time'] : array();
				$end_time					= !empty($_POST['end_time']) 				? $_POST['end_time'] : array();
				$time_slots 				= array();
				if(empty($user_designation) 
					|| empty($user_contact)
					|| empty($user_default_message)
					|| empty($user_offline_message)
					|| empty($available_days)
					|| empty($user_timezone)){
					$json['type'] = 'error';
					$json['message']        = sprintf( __( 'Oops! it looks like you missed something', 'wpguppy-lite' ));
					wp_send_json($json);
				}
				if(!empty($available_days)){
					foreach($available_days as $day){
						if(!empty($start_time[$day]) && !empty($end_time[$day])){
							$start_time_slot = date('Y-m-d '.$start_time[$day].':00');
							$end_time_slot = date('Y-m-d '.$end_time[$day].':00');
							if(strtotime($start_time_slot) >= strtotime($end_time_slot)){
                                $json['type'] = 'error';
                                $json['message']        = sprintf( __( 'Oops! there is an issue with your <strong>%s</strong> available time slot', 'wpguppy-lite' ), ucfirst($day));
                               wp_send_json($json);
                            }
							$time_slots[$day] = array(
								'start_time'	=> $start_time[$day].':00',
								'end_time'		=> $end_time[$day].':00',
							);
						}
					}
				}
				$data = array(
					'user_designation' 			=> $user_designation,	
					'user_contact' 				=> $user_contact,	
					'user_default_message' 		=> $user_default_message,	
					'user_offline_message' 		=> $user_offline_message,	
					'user_availability' 		=> $time_slots,	
					'user_timezone' 			=> $user_timezone,	
				);
				
				update_user_meta($user_id, 'guppy_whatsapp_info', $data);
			}
			update_user_meta($user_id, 'is_guppy_whatsapp_user', $status);
			
			$json['type']		= 'success';
			$json['message']	= esc_html__("Wohoo! you have added user's swhatsapp details successfully",'wpguppy-lite');
			wp_send_json($json);
		}
	}
	
	WPGuppy_Lite_Plugin_Options::instance();
}