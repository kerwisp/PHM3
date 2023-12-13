<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Doctreat
 * @subpackage Doctreat/admin
 */

/**
 * @Rename Menu
 * @return {}
 */
if (!function_exists('doctreat_rename_admin_menus')) {
	add_action( 'admin_menu', 'doctreat_rename_admin_menus');
	function doctreat_rename_admin_menus() {
		global $menu,$submenu;
		foreach( $menu as $key => $menu_item ) {
			if( $menu_item[2] == 'edit.php?post_type=doctors' ){
				$menu[$key][0] = esc_html__('Doctreat','doctreat_core');
			}
		}
	}
}



/**
 * @Import User Menu
 * @return {}
 */
if (!function_exists('doctreat_import_users_menu')) {
	add_action('admin_menu', 'doctreat_import_users_menu');
	function  doctreat_import_users_menu(){
		add_submenu_page('edit.php?post_type=doctors', 
							 esc_html__('Import User','doctreat_core'), 
							 esc_html__('Import User','doctreat_core'), 
							 'manage_options', 
							 'import_users',
							 'doctreat_import_users_template',
						 	10
						 );

	}
}

/**
 * @Import Users
 * @return {}
 */
if (!function_exists('doctreat_import_users_template')) {
	function  doctreat_import_users_template(){
		
		$permalink = add_query_arg( 
								array(
									'&type=file',
								)
							);	
		
		//Import users via file
		if ( !empty( $_FILES['users_csv']['tmp_name'] ) ) {
			$import_user	= new Doctreat_Import_User();
			$import_user->doctreat_import_user();
			?>
			<div class="notice notice-success is-dismissible">
				<p><?php esc_html_e('User Imported Successfully','doctreat_core');?></p>
			</div>
			<?php
		}
	   ?>
       <h3 class="theme-name"><?php esc_html_e('Import Users','doctreat_core');?></h3>
       <div id="import-users" class="import-users">
            <div class="theme-screenshot">
                <img alt="<?php esc_attr_e('Import Users','doctreat_core');?>" src="<?php echo get_template_directory_uri();?>/admin/images/users.jpg">
            </div>
			<h3 class="theme-name"><?php esc_html_e('Import dummy','doctreat_core');?></h3>
            <div class="user-actions">
                <a href="javascript:;" class="button button-primary doc-import-users"><?php esc_html_e('Import Dummy','doctreat_core');?></a>
            </div>
	   </div>
       <div id="import-users" class="import-users custom-import">
            <form method="post" action="<?php echo cus_prepare_final_url('file','import_users'); ?>"  enctype="multipart/form-data">
				<div class="theme-screenshot">
					<img alt="<?php esc_attr_e('Import dummy','doctreat_core');?>" src="<?php echo get_template_directory_uri();?>/admin/images/excel.jpg">
				</div>
				<h3 class="theme-name">
					<input id="upload-dummy-csv" type="file" name="users_csv" >
					<label for="upload-dummy-csv" class="button button-primary upload-dummy-csv"><?php esc_html_e('Choose File','doctreat_core');?></lable>
				</h3>
				<div class="user-actions">
					<input type="submit" class="button button-primary" value="<?php esc_html_e('Import From File','doctreat_core');?>">
					
				</div>
            </form>
		</div>
        <?php
	}
}


/**
 * @init            tab url
 * @package         Amentotech
 * @subpackage      tailors-online/admin/partials
 * @since           1.0
 * @desc            Display The Tab System URL
 */
if (!function_exists('cus_prepare_final_url')) {

    function cus_prepare_final_url($tab='',$page='import_users') {
		$permalink = '';
		$permalink = add_query_arg( 
								array(
									'?page'	=>   urlencode( $page ) ,
									'tab'	=>   urlencode( $tab ) ,
								)
							);	
		
		return esc_url( $permalink );
	}
}

/**
 * @Import Users
 * @return {}
 */
if (!function_exists('doctreat_import_users')) {
	function  doctreat_import_users(){
		$json				= array();
		if( function_exists('doctreat_validate_user') ) { 
			doctreat_validate_user();
		}; //if user is logged in

		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it againe', 'doctreat_core');
			wp_send_json( $json );
		}
		
		$import_user	= new Doctreat_Import_User();
		$import_user->doctreat_import_user();
		
		
		// Health Forum authors
		if ( function_exists('doctreat_update_post_auther_healthforum')) { doctreat_update_post_auther_healthforum(); }
		if ( function_exists('doctreat_update_healthforum_comments_author')) { doctreat_update_healthforum_comments_author(); }
		
		// Update post authors IDs
		if ( function_exists('doctreat_update_post_auther')) { doctreat_update_post_auther(); }
		// update hospitals team authors
		if ( function_exists('doctreat_update_post_auther_hospital_team')) { doctreat_update_post_auther_hospital_team(); }

		
		$json['type']		= 'success';	
		$json['message']	= esc_html__('User Imported Successfully','doctreat_core' );
		wp_send_json( $json );
	}
	add_action('wp_ajax_doctreat_import_users', 'doctreat_import_users');	
}



/**
 * @Import Users
 * @return {}
 */
if (!function_exists('doctreat_save_theme_settings')) {
	function  doctreat_save_theme_settings(){
		$settings	= $_POST['settings'];
		$json		= array();
		
		if( function_exists('doctreat_validate_user') ) { 
			doctreat_validate_user();
		}; //if user is logged in

		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it againe', 'doctreat_core');
			wp_send_json( $json );
		}
		
		update_option( 'dc_theme_settings', $settings, true );
		
		$json['type']	= 'success';	
		$json['message']	= esc_html__('Settings updated','doctreat_core' );
		wp_send_json( $json );	
	}
	add_action('wp_ajax_doctreat_save_theme_settings', 'doctreat_save_theme_settings');	
}

/**
 * update mailchimp array
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_mailchimp_array' ) ) {
	function doctreat_mailchimp_array(){
		$json		= array();
		
		if( function_exists('doctreat_validate_user') ) { 
			doctreat_validate_user();
		}; //if user is logged in

		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it againe', 'doctreat_core');
			wp_send_json( $json );
		}
		
		$transName 	= 'latest-mailchimp-list';
		$mailChip = get_transient( $transName );
		if( empty($mailChip) ){
			$list_array	= array();
			if( function_exists('doctreat_mailchimp_list') ) {
				$list_array	= doctreat_mailchimp_list();
				set_transient( $transName, $list_array, 60 * 60 * 24 );
			}
		}
		
		$json['type']	= 'success';	
		$json['message']	= esc_html__('MailChimp is updated','doctreat_core' );
		wp_send_json($json);
	}
	add_action('doctreat_mailchimp_array', 'doctreat_mailchimp_array');
	add_action('wp_ajax_doctreat_mailchimp_array', 'doctreat_mailchimp_array');	
}


/**
 * update mailchimp array
 *
 * @throws error
 * @author Amentotech <theamentotech@gmail.com>
 * @return 
 */
if( !function_exists(  'doctreat_cron_interval_array' ) ) {
	function doctreat_cron_interval_array(){
		$json		= array();
		
		if( function_exists('doctreat_validate_user') ) { 
			doctreat_validate_user();
		}; //if user is logged in

		//security check
		$do_check = check_ajax_referer('ajax_nonce', 'security', false);
		if ( $do_check == false ) {
			$json['type'] = 'error';
			$json['message'] = esc_html__('Security check failed, this could be because of your browser cache. Please clear the cache and check it againe', 'doctreat_core');
			wp_send_json( $json );
		}
		
		$transName 	= 'cron-interval-list';
		$schedules_list		= array();

		$schedules		= doctreat_cron_schedule();
		if( !empty( $schedules ) ) {
			foreach ( $schedules as $key => $val ) {
				$schedules_list[$key]	= $val['display'];
			}
		}
		
		set_transient( $transName, $schedules_list,60 * 60 * 60 * 24 );
		
		$json['type']	= 'success';	
		$json['message']	= esc_html__('CRON Interval has been updated','doctreat_core' );
		wp_send_json($json);
	}
	add_action('wp_ajax_doctreat_cron_interval_array', 'doctreat_cron_interval_array');	
}

/**
 * @get settings
 * @return {}
 */
if (!function_exists('doctreat_get_theme_settings')) {
	function  doctreat_get_theme_settings($key='',$type=''){
		$sp_theme_settings = get_option( 'dc_theme_settings' );
		$setting	= !empty( $sp_theme_settings[$type][$key] ) ? $sp_theme_settings[$key] : $sp_theme_settings;
		return $setting;
	}
	add_filter('doctreat_get_theme_settings', 'doctreat_get_theme_settings', 10, 2);
}

/**
 * @Prepare social sharing links
 * @return sizes
 */
if (!function_exists('doctreat_prepare_social_sharing')) {

    function doctreat_prepare_social_sharing($default_icon = 'false', $social_title = '', $title_enable = 'true', $classes = '', $thumbnail = '') {
		global $wp_query;
        $output    = '';

        $social_facebook 	= 'enable';
		$social_twitter 	= 'enable';
		$social_gmail 		= 'enable';
		$social_pinterest 	= 'enable';
		$twitter_username 	= '';

		//author page
		if( is_author() ){
			$author_profile = $wp_query->get_queried_object();
			$permalink		= esc_url(get_author_posts_url($author_profile->ID));
			$title			= doctreat_get_username($author_profile->ID);
		} else{
			$permalink	= get_the_permalink();
			$title		=  get_the_title();
		}

        $output .= "<ul class='".$classes."'>";
        if ($title_enable == 'true' && !empty( $social_title )) {
            $output .= '<li class="dc-sharejob"><span>' . $social_title . ':</span></li>';
        }
        if (isset($social_facebook) && $social_facebook == 'enable') {
            $output .= '<li class="dc-facebook"><a href="//www.facebook.com/sharer.php?u=' . urlencode(esc_url($permalink)) . '" onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fab fa-facebook-f"></i></a></li>';
        }

        if (isset($social_twitter) && $social_twitter == 'enable') {
            $output .= '<li class="dc-twitter"><a href="//twitter.com/intent/tweet?text=' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '&url=' . urlencode(esc_url($permalink)) . '&via=' . urlencode(!empty($twitter_username) ? $twitter_username : get_bloginfo('name') ) . '"  ><i class="fab fa-twitter"></i></a></li>';
            $tweets = '!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");';
            wp_add_inline_script('doctreat-callback', $tweets);
        }

        if (isset($social_gmail) && $social_gmail == 'enable') {
            $output .= '<li class="dc-googleplus"><a href="//plus.google.com/share?url=' . esc_url($permalink) . '" onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fab fa-google"></i></a></li>';
        }
        if (isset($social_pinterest) && $social_pinterest == 'enable') {
            $output .= '<li class="dc-pinterestp"><a href="//pinterest.com/pin/create/button/?url=' . esc_url($permalink) . '&amp;media=' . (!empty($thumbnail) ? $thumbnail : '' ) . '&description=' . htmlspecialchars(urlencode(html_entity_decode($title, ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8') . '" onclick="window.open(this.href, \'post-share\',\'left=50,top=50,width=600,height=350,toolbar=0\'); return false;"><i class="fab fa-pinterest-p"></i></a></li>';
        }

        $output .= '</ul>';
        echo do_shortcode($output, true);
    }
}
