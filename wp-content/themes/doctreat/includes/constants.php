<?php

/**
 *  Contants
 */
if (!function_exists('doctreat_prepare_constants')) {

    function doctreat_prepare_constants() {
		global $current_user,$theme_settings;
		$is_loggedin = 'false';
		$user_type = '';
		$startweekday		= get_option('start_of_week');
		$startweekday		=  !empty( $startweekday ) ?  $startweekday : 0;
		$calendar_format	= !empty( $theme_settings['calendar_format'] ) ? $theme_settings['calendar_format'] : 'Y-m-d';
		
        if (is_user_logged_in()) {
            $is_loggedin 	= 'true';
			$user_type		= apply_filters('doctreat_get_user_type', $current_user->ID );
        }

		$dir_map_marker		= !empty( $theme_settings['dir_map_marker'] ) ? $theme_settings['dir_map_marker'] : get_template_directory_uri() . '/images/marker.png';
		$dir_map_type		= !empty( $theme_settings['dir_map_type'] ) ? $theme_settings['dir_map_type'] : 'ROADMAP';
		$dir_zoom			= !empty( $theme_settings['dir_zoom'] ) ? $theme_settings['dir_zoom'] : '12';
		$dir_longitude		= !empty( $theme_settings['dir_longitude'] ) ? $theme_settings['dir_longitude'] : '-0.1262362';
		$dir_latitude		= !empty( $theme_settings['dir_latitude'] ) ? $theme_settings['dir_latitude'] : '51.5001524';
		$dir_map_scroll		= !empty( $theme_settings['dir_map_scroll'] ) ? $theme_settings['dir_map_scroll'] : 'false';
		$map_styles			= !empty( $theme_settings['map_styles'] ) ? $theme_settings['map_styles'] : 'none';
		$dir_datasize		= !empty( $theme_settings['dir_datasize'] ) ? $theme_settings['dir_datasize'] : '5242880';
		$calendar_locale	= !empty( $theme_settings['calendar_locale'] ) ? $theme_settings['calendar_locale'] : 'en';
		$loader_duration	= !empty( $theme_settings['loader_duration'] ) ? $theme_settings['loader_duration'] : '';
        
		$tip_content_bg		=  !empty( $theme_settings['tip_content_bg'] ) ?  $theme_settings['tip_content_bg']  : '';
		$tip_content_color	=  !empty( $theme_settings['tip_content_color']  ) ?  $theme_settings['tip_content_color'] : '';
		$tip_title_bg		=  !empty( $theme_settings['tip_title_bg'] ) ?  $theme_settings['tip_title_bg'] : '';
		$tip_title_color	=  !empty( $theme_settings['tip_title_color'] ) ?  $theme_settings['tip_title_color'] : '';
		
		if( $dir_datasize >= 1024 ){
			 $dir_datasize		= trim($dir_datasize);
			 $data_size_in_kb 	= $dir_datasize / 1024;
		} else{
			$data_size_in_kb = 5242880;
		}
		
		$chat_settings	= !empty( $theme_settings['chat'] )  ? $theme_settings['chat'] : '';
		$chat_host		=  !empty( $theme_settings['host'] ) ?  $theme_settings['host'] : 'http://localhost';
		$chat_port		=  !empty( $theme_settings['port'] ) ?  $theme_settings['port'] : '81';
		
		$chat_feature	= 'inbox';	
		$chat_page		= 'no';	
		
		if( !empty( $theme_settings['chat'] ) && $theme_settings['chat'] === 'chat' ){
			$chat_feature	= 'chat';	
		}else if( !empty( $theme_settings['chat'] ) && $theme_settings['chat'] === 'guppy' ){
			$chat_feature	= 'guppy';	
		}
		
		$current_user_id	= !empty( $current_user->ID ) ? $current_user->ID : '';
		$listing_type		= doctreat_theme_option('listing_type');
		if ( function_exists( 'doctreat_is_feature_value' )) {
			$dc_services		= doctreat_is_feature_value( 'dc_services', $current_user_id);
			$dc_downloads		= doctreat_is_feature_value( 'dc_downloads', $current_user_id);
			$dc_articles		= doctreat_is_feature_value( 'dc_articles', $current_user_id);
			$dc_awards			= doctreat_is_feature_value( 'dc_awards', $current_user_id);
			$dc_memberships		= doctreat_is_feature_value( 'dc_memberships', $current_user_id);
        } else {
			$dc_services	= false;
			$dc_downloads	= false;
			$dc_articles	= false;
			$dc_awards		= false;
			$dc_memberships	= false;
		}
				
		$chat_page		= 'no';	
		
		if ( ( is_page_template('directory/dashboard.php') && isset($_GET['ref']) && $_GET['ref'] === 'chat' ) || is_singular('doctors') ) {
			$chat_page		= 'yes';	
        }
		
		$is_rtl					= doctreat_rtl_check();
		$currency_symbols		= doctreat_get_current_currency();
		$currency_symbols		= $currency_symbols['symbol'];
		$dir_spinner 			= get_template_directory_uri() . '/images/spinner.gif';
		$chatloader 			= get_template_directory_uri() . '/images/chatloader.gif';
		
        wp_localize_script('doctreat-callback', 'scripts_vars', array(
            'ajaxurl'           => admin_url('admin-ajax.php'),           
            'valid_email'       => esc_html__('Please add a valid email address.','doctreat'),          
            'forgot_password'   => esc_html__('Reset Password','doctreat'),          
            'login'             => esc_html__('Login','doctreat'), 
            'is_loggedin'       => $is_loggedin,
			'user_type'       	=> $user_type,
			'copy_profile_msg'	=> esc_html__('You are successfully copy the user profile.', 'doctreat'),
			'allow_booking'  	=> esc_html__('You are not allowed for appointment.', 'doctreat'),
			'allow_feedback'  	=> esc_html__('You are not allowed to add feedback.', 'doctreat'),
			'booking_message'  	=> esc_html__('Please login to book this doctor', 'doctreat'),
			'feedback_message'  => esc_html__('Please login to add the feedback.', 'doctreat'),
            'wishlist_message'  => esc_html__('Please login to save this users into your wishlist', 'doctreat'),
            'message_error'     => esc_html__('No kiddies please', 'doctreat'),
            'award_image'       => esc_html__('Image title', 'doctreat'),
            'data_size_in_kb'   => $data_size_in_kb . 'kb',
            'award_image_title' => esc_html__('Your image title', 'doctreat'),
            'award_image_size'  => esc_html__('File size', 'doctreat'),
            'document_title'    => esc_html__('Document Title', 'doctreat'),
			'emptyCancelReason' => esc_html__('Cancelled reason is required', 'doctreat'),
			'package_update'	=> esc_html__('Please update your package to access this service.', 'doctreat'),
			'location_required'	=> esc_html__('Please select the location.', 'doctreat'),
			'speciality_required'	=> esc_html__('Select a speciality.','doctreat'),
			'email_required'		=> esc_html__('Email is required.','doctreat'),
			'update_booking'				=> esc_html__('Change booking status', 'doctreat'),
			'update_booking_status_message'	=> esc_html__('Are you sure you want to change this booking status?','doctreat'),
			'spinner'   	=> '<img class="sp-spin" src="'.esc_url($dir_spinner).'">',
			'chatloader'   	=> '<img class="sp-chatspin" src="'.esc_url($chatloader).'">',
			'nothing' 		=> esc_html__('Oops, nothing found!','doctreat'),
			'days' 			=> esc_html__('Days','doctreat'),
			'hours' 		=> esc_html__('Hours','doctreat'),
			'minutes' 		=> esc_html__('Minutes','doctreat'),
			'expired' 		=> esc_html__('EXPIRED','doctreat'),
			'min_and' 		=> esc_html__('Minutes and','doctreat'),
			'seconds' 		=> esc_html__('Seconds','doctreat'),
			'yes' 			=> esc_html__('Yes','doctreat'),
			'no' 			=> esc_html__('No','doctreat'),
			'order' 		=> esc_html__('Add to cart','doctreat'),
			'order_message' => esc_html__('Are you sure you want to buy this package?','doctreat'),
			'slots_remove' 			=> esc_html__('Remove slot(s)','doctreat'),
			'slots_remove_message' 	=> esc_html__('Are you sure you want to remove this slot(s)?','doctreat'),
			'change_status' 		=> esc_html__('Change status','doctreat'),
			'change_status_message' => esc_html__('Are you sure you want to change team member status?','doctreat'),
			'location_remove' 			=> esc_html__('Remove Location','doctreat'),
			'location_remove_message'	=> esc_html__('Are you sure you want to remove this location.','doctreat'),
			'download_attachments' 		=> esc_html__('Add Attachments', 'doctreat'),				
			'cache_title' 				=> esc_html__('Confirm?','doctreat'),
			'cache_message' 			=> esc_html__('Never show this message again','doctreat'),
			'delete_account'    		=> esc_html__('Delete Account', 'doctreat'),
			'delete_account_message'    => esc_html__('Are you sure you want to delete your account?', 'doctreat'),
			'delete_article'    		=> esc_html__('Delete Article', 'doctreat'),
			'delete_article_message'    => esc_html__('Are you sure you want to delete your article?', 'doctreat'),
			'empty_spaces_message'    	=> esc_html__('There are no spaces for remove.', 'doctreat'),
			'remove_itme' 				=> esc_html__('Remove from Saved', 'doctreat'),
			'remove_itme_message' 		=> esc_html__('Are you sure you want to remove this?', 'doctreat'),
			'required_field' 			=> esc_html__('field is required','doctreat'),
			'remove_payouts'			=> esc_html__('Remove Payouts Settings','doctreat'),
			'remove_payouts_message'	=> esc_html__('Are you sure you want to remove Payouts Settings','doctreat'),
			'empty_message'				=> esc_html__('Message is required','doctreat'),
			'account_verification'				=> esc_html__('Your account has been verified.','doctreat'),
			'listing_type'		=> $listing_type,
            'dir_map_marker' 	=> $dir_map_marker,
            'dir_map_type' 		=> $dir_map_type,
            'dir_zoom' 			=> $dir_zoom,
            'dir_longitude' 	=> $dir_longitude,
            'dir_latitude' 		=> $dir_latitude,
            'dir_map_scroll' 	=> $dir_map_scroll,
            'map_styles' 		=> $map_styles,
			'currency_symbols'	=> $currency_symbols,
			'dc_services'		=> $dc_services,
			'dc_downloads'		=> $dc_downloads,
			'dc_articles'		=> $dc_articles,
			'dc_awards'			=> $dc_awards,
			'dc_memberships'	=> $dc_memberships,
			'chat_page'			=> $chat_page,
			'chat_host' 		=> $chat_host,
			'chat_port' 		=> $chat_port,
			'chat_settings' 	=> $chat_settings,
			'loader_duration'	=> $loader_duration,
			'tip_content_bg' 	=> $tip_content_bg,
			'tip_content_color' => $tip_content_color,
			'tip_title_bg' 		=> $tip_title_bg,
			'tip_title_color' 	=> $tip_title_color,
			'calendar_format' 	=> $calendar_format,
			'calendar_locale' 	=> $calendar_locale,
			'startweekday' 		=> $startweekday,
			'is_rtl' 			=> $is_rtl,
			'ajax_nonce' 		=> wp_create_nonce('ajax_nonce'),
        ));
    }

    add_action('wp_enqueue_scripts', 'doctreat_prepare_constants', 90);
}