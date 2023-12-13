<?php

/**
 * Define Global Settings
 *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */

global $guppySetting;
$guppySetting	= get_option( "wpguppy_settings");

/**
 * Return user roles
 *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if( !function_exists( 'wpguppy_user_roles' ) ) {
	function wpguppy_user_roles(){
        global $wp_roles;
        if ( ! isset( $wp_roles ) ){
            $wp_roles = new WP_Roles();
        }
		
        $roles_array    = array();
        $roles          = !empty($wp_roles->roles) ? $wp_roles->roles : array();
		
        if( !empty($roles) ){
            foreach($roles as $key => $values ){
                $roles_array[$key]  = !empty($values['name']) ? $values['name'] : '';
            }
        }
		
        return $roles_array;
    }
}


/**
 * Return All static text
 *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if( !function_exists( 'wpguppy_default_text' ) ) {
    function wpguppy_default_text() {
        $list = array(
			'profile_settings'       => array( 'default' 	=> esc_html__('Profile settings', 'wpguppy-lite'),
											   'title'		=> esc_html__('Profile settings', 'wpguppy-lite')),
			'mute'       			 => array( 'default' 	=> esc_html__('Mute notifications', 'wpguppy-lite'),
											   'title'		=> esc_html__('Mute notifications', 'wpguppy-lite')),
			'logout'       			 => array( 'default' 	=> esc_html__('Logout', 'wpguppy-lite'),
											   'title'		=> esc_html__('Logout', 'wpguppy-lite')),
			'full_name'       		 => array( 'default' 	=> esc_html__('Full name', 'wpguppy-lite'),
											   'title'		=> esc_html__('Full name', 'wpguppy-lite')),
			'email'       			 => array( 'default' 	=> esc_html__('Email address', 'wpguppy-lite'),
											   'title'		=> esc_html__('Email address', 'wpguppy-lite')),
			'password'       			 => array( 'default' 	=> esc_html__('Password', 'wpguppy-lite'),
											   'title'		=> esc_html__('Password', 'wpguppy-lite')),
			'phone'       			 => array( 'default' 	=> esc_html__('Phone', 'wpguppy-lite'),
											   'title'		=> esc_html__('Phone', 'wpguppy-lite')),
			'upload_photo'       	 => array( 'default' 	=> esc_html__('to upload profile photo', 'wpguppy-lite'),
											   'title'		=> esc_html__('Upload photo', 'wpguppy-lite')),
			'remove'       			 => array( 'default' 	=> esc_html__('Remove', 'wpguppy-lite'),
											   'title'		=> esc_html__('Remove', 'wpguppy-lite')),
			'start_chat_text'       			 => array( 'default' 	=> esc_html__('Start now', 'wpguppy-lite'),
											   'title'		=> esc_html__('Start now text', 'wpguppy-lite')),
			'save_changes'       	=> array( 'default' 	=> esc_html__('Save changes', 'wpguppy-lite'),
											   'title'		=> esc_html__('Save changes', 'wpguppy-lite')),
			'contacts'       		=> array( 'default' 	=> esc_html__('Contacts', 'wpguppy-lite'),
											   'title'		=> esc_html__('Contacts', 'wpguppy-lite')),
			'requests_heading'       		=> array( 'default' 	=> esc_html__('Requests', 'wpguppy-lite'),
											   'title'		=> esc_html__('Requests heading text', 'wpguppy-lite')),
			'search'       			=> array( 'default' 	=> esc_html__('Search here', 'wpguppy-lite'),
											   'title'		=> esc_html__('Search here', 'wpguppy-lite')),
			'no_results'       		=> array( 'default' 	=> esc_html__('No results to show', 'wpguppy-lite'),
											   'title'		=> esc_html__('No results to show', 'wpguppy-lite')),
			'sent'       			=> array( 'default' 	=> esc_html__('Sent', 'wpguppy-lite'),
											   'title'		=> esc_html__('Sent', 'wpguppy-lite')),
			'decline_user'       			=> array( 'default' 	=> esc_html__('Your request has been declined by this user', 'wpguppy-lite'),
											   'title'		=> esc_html__('Decline User Text', 'wpguppy-lite')),
			'invite'       			=> array( 'default' 	=> esc_html__('Invite', 'wpguppy-lite'),
											   'title'		=> esc_html__('Invite', 'wpguppy-lite')),
			'invitation_top_desc'    => array( 'default' 	=> esc_html__('Hey there! It looks like this contact is not in your friend list. Would you like to chat with this user?', 'wpguppy-lite'),
											   'title'		=> esc_html__('Contact is not in friend list', 'wpguppy-lite')),
			'invitaion_bottom_desc' => array( 'default' 	=> esc_html__('Hey there, I would like to add you in my friend list, Please hit “Accept” to start chatting', 'wpguppy-lite'),
											   'title'		=> esc_html__('Accept Friend Request', 'wpguppy-lite')),
			'accept_invite'       	=> array( 'default' 	=> esc_html__('Accept', 'wpguppy-lite'),
											   'title'		=> esc_html__('Accept', 'wpguppy-lite')),
			'decline_invite'       	=> array( 'default' 	=> esc_html__('Decline', 'wpguppy-lite'),
											   'title'		=> esc_html__('Decline', 'wpguppy-lite')),
			'start_chat_txt'       	=> array( 'default' 	=> esc_html__('Start chat', 'wpguppy-lite'),
											   'title'		=> esc_html__('Start chat text', 'wpguppy-lite')),
			'start_conversation'    => array( 'default' 	=> esc_html__('Select the user to start your conversation', 'wpguppy-lite'),
											   'title'		=> esc_html__('Start conversation', 'wpguppy-lite')),
			'chat'       			=> array( 'default' 	=> esc_html__('Search chat', 'wpguppy-lite'),
											   'title'		=> esc_html__('Search Chat', 'wpguppy-lite')),
			'profile'       		=> array( 'default' 	=> esc_html__('Profile', 'wpguppy-lite'),
											   'title'		=> esc_html__('Profile', 'wpguppy-lite')),
			'type_message'       	=> array( 'default' 	=> esc_html__('Type your message here', 'wpguppy-lite'),
											   'title'		=> esc_html__('Type message', 'wpguppy-lite')),
			'search_results'        => array( 'default' 	=> esc_html__('Searching results', 'wpguppy-lite'),
											   'title'		=> esc_html__('Searching results', 'wpguppy-lite')),
			'unblock'       		=> array( 'default' 	=> esc_html__('Unblock', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unblock', 'wpguppy-lite')),
			'block_user'       		=> array( 'default' 	=> esc_html__('Block user', 'wpguppy-lite'),
											   'title'		=> esc_html__('Block user', 'wpguppy-lite')),
			'unblock_user'       	=> array( 'default' 	=> esc_html__('Unblock user', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unblock user', 'wpguppy-lite')),
			'offline'       		=> array( 'default' 	=> esc_html__('Offline', 'wpguppy-lite'),
											   'title'		=> esc_html__('Offline', 'wpguppy-lite')),
			'online'       			=> array( 'default' 	=> esc_html__('Online', 'wpguppy-lite'),
											   'title'		=> esc_html__('Online', 'wpguppy-lite')),
			'settings'       		=> array( 'default' 	=> esc_html__('Settings', 'wpguppy-lite'),
											   'title'		=> esc_html__('Settings', 'wpguppy-lite')),
			'actions'      			=> array( 'default' 	=> esc_html__('Actions', 'wpguppy-lite'),
											   'title'		=> esc_html__('Actions', 'wpguppy-lite')),
			'mute_conversation'     => array( 'default' 	=> esc_html__('Mute conversation', 'wpguppy-lite'),
											   'title'		=> esc_html__('Mute conversation', 'wpguppy-lite')),
			'unmute_conversation'   => array( 'default' 	=> esc_html__('Unmute conversation', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unmute conversation', 'wpguppy-lite')),
			'privacy_settings'      => array( 'default' 	=> esc_html__('Privacy settings', 'wpguppy-lite'),
											   'title'		=> esc_html__('Privacy settings', 'wpguppy-lite')),
			'block_user'       		=> array( 'default' 	=> esc_html__('Block user', 'wpguppy-lite'),
											   'title'		=> esc_html__('Block user', 'wpguppy-lite')),
			'clear_chat'       		=> array( 'default' 	=> esc_html__('Clear chat', 'wpguppy-lite'),
											   'title'		=> esc_html__('Clear chat', 'wpguppy-lite')),
			'clear_chat_description'    => array( 'default' 	=> esc_html__('Are you sure you want to clear your chat history?', 'wpguppy-lite'),
											   'title'		=> esc_html__('Clear chat description', 'wpguppy-lite')),								   								   
			'clear_chat_button'    		=> array( 'default' 	=> esc_html__('Yes! clear all', 'wpguppy-lite'),
											   'title'		=> esc_html__('Yes! clear all', 'wpguppy-lite')),
			'load_more'       			=> array( 'default' 	=> esc_html__('Load more', 'wpguppy-lite'),
											   'title'		=> esc_html__('Load more', 'wpguppy-lite')),
			'block_user_description'  	=> array( 'default' 	=> esc_html__('Are you sure you want to block this user?', 'wpguppy-lite'),
											   'title'		=> esc_html__('Block user description?', 'wpguppy-lite')),
			'block_user_title'        	=> array( 'default' 	=> esc_html__('Block user “((username))”', 'wpguppy-lite'),
											   'title'		=> esc_html__('Block user title', 'wpguppy-lite')),
			'block_user_button'       	=> array( 'default' 	=> esc_html__('Yes! block right now', 'wpguppy-lite'),
											   'title'		=> esc_html__('Block user button', 'wpguppy-lite')),
			'not_right_now'       	  	=> array( 'default' 	=> esc_html__('Not right now', 'wpguppy-lite'),
											   'title'		=> esc_html__('Not right now', 'wpguppy-lite')),
			'blocked_user_message'    	=> array( 'default' 	=> esc_html__('You have blocked this user. %Unblock% now to start chatting again', 'wpguppy-lite'),
											   'title'		=> esc_html__('Blocked user message', 'wpguppy-lite')),
			'unblock_user_heading'    	=> array( 'default' 	=> esc_html__('Unblock user “((username))”', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unblock user heading', 'wpguppy-lite')),
			'you_are_blocked'    	  	=> array( 'default' 	=> esc_html__('You have been blocked by this user', 'wpguppy-lite'),
												'title'		=> esc_html__('You have been blocked by this user', 'wpguppy-lite')),
			'blocked'    	  			=> array( 'default' 	=> esc_html__('Blocked', 'wpguppy-lite'),
											   'title'		=> esc_html__('Blocked', 'wpguppy-lite')),
			'your_name'    	  			=> array( 'default' 	=> esc_html__('Your name', 'wpguppy-lite'),
											   'title'		=> esc_html__('Your name', 'wpguppy-lite')),
			'your_email'    	  		=> array( 'default' 	=> esc_html__('Your email', 'wpguppy-lite'),
											   'title'		=> esc_html__('Your email', 'wpguppy-lite')),
			'your_phone'    	  		=> array( 'default' 	=> esc_html__('Your phone number', 'wpguppy-lite'),
											   'title'		=> esc_html__('Your phone number', 'wpguppy-lite')),
			'respond_invite'    	  	=> array( 'default' 	=> esc_html__('Respond to invite', 'wpguppy-lite'),
											   'title'		=> esc_html__('Respond to invite', 'wpguppy-lite')),
			'resend_invite'    	  		=> array( 'default' 	=> esc_html__('Resend anyway', 'wpguppy-lite'),
											   'title'		=> esc_html__('Resend anyway', 'wpguppy-lite')),
			'is_typing'    	  			=> array( 'default' 	=> esc_html__('is typing', 'wpguppy-lite'),
												'title'		=> esc_html__('Typing for one user', 'wpguppy-lite')),
			'are_typing'    	  		=> array( 'default' 	=> esc_html__('are typing', 'wpguppy-lite'),
												'title'		=> esc_html__('Less than 4 users are typing', 'wpguppy-lite')),
			'unblock_user_description'  => array( 'default' 	=> esc_html__('Are you sure you want to unblock this user?', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unblock user description', 'wpguppy-lite')),
			'unblock_button'       		=> array( 'default' 	=> esc_html__('Yes! unblock right now ', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unblock button', 'wpguppy-lite')),
			'reply_message'       		=> array( 'default' 	=> esc_html__('Reply message', 'wpguppy-lite'),
											   'title'		=> esc_html__('Reply message', 'wpguppy-lite')),
			'click_here'       			=> array( 'default' 	=> esc_html__('Click here', 'wpguppy-lite'),
											   'title'		=> esc_html__('click here', 'wpguppy-lite')),
			'delete'       				=> array( 'default' 	=> esc_html__('Delete', 'wpguppy-lite'),
											   'title'		=> esc_html__('Delete', 'wpguppy-lite')),
			'unblock_now'       		=> array( 'default' 	=> esc_html__('Unblock now', 'wpguppy-lite'),
											   'title'		=> esc_html__('Unblock now ', 'wpguppy-lite')),	
			'deleted_message'       	=> array( 'default' 	=> esc_html__('This message was deleted', 'wpguppy-lite'),
											   'title'		=> esc_html__('Deleted message', 'wpguppy-lite')),
			'more_text'       			=> array( 'default' 	=> esc_html__('more', 'wpguppy-lite'),
											   'title'		=> esc_html__('User more text', 'wpguppy-lite')),
			'search_conversation'       => array( 'default' 	=> esc_html__('Search in conversation', 'wpguppy-lite'),
											   'title'		=> esc_html__('Search in conversation text', 'wpguppy-lite')),
			'you'  						=> array( 'default' 	=> esc_html__('You', 'wpguppy-lite'),
											   'title'		=> esc_html__('You', 'wpguppy-lite')),
			'error_title'  				=> array( 'default' 	=> esc_html__('Oops...', 'wpguppy-lite'),
											   'title'		=> esc_html__('Oops...', 'wpguppy-lite')),
			'search_txt'       			=> array( 'default' 	=> esc_html__('Search user here', 'wpguppy-lite'),
											   'title'		=> esc_html__('Search user text', 'wpguppy-lite')),
			'you_txt'       			=> array( 'default' 	=> esc_html__('You', 'wpguppy-lite'),
											   'title'		=> esc_html__('You text', 'wpguppy-lite')),
			'auto_inv_receiver_msg'     => array( 'default' 	=> esc_html__("“((username))” added you to the friend list, let\'s chat now", 'wpguppy-lite'),
											   'title'		=> esc_html__('Auto Invite receiver message text', 'wpguppy-lite')),
			'auto_inv_sender_msg'       => array( 'default' 	=> esc_html__("You have added “((username))” to your friend list, let\'s chat now", 'wpguppy-lite'),
											   'title'		=> esc_html__('Auto Invite sender message text', 'wpguppy-lite')),
			'open_in_messenger'       	=> array( 'default' 	=> esc_html__("Open in messenger", 'wpguppy-lite'),
											   'title'		=> esc_html__('Open in messenger text', 'wpguppy-lite')),
			'empty_field_required'      => array( 'default' 	=> esc_html__("Please fill all the required fields.", 'wpguppy-lite'),
											   'title'		=> esc_html__('Empty fields required text.', 'wpguppy-lite')),
			'input_params_err'       	=> array( 'default' 	=> esc_html__("Something went wrong.", 'wpguppy-lite'),
											   'title'		=> esc_html__('Input params validation error.', 'wpguppy-lite')),
			'invalid_input_file'       	=> array( 'default' 	=> esc_html__("Invalid file type or file size.", 'wpguppy-lite'),
											   'title'		=> esc_html__('Invalid file type or file size error text.', 'wpguppy-lite')),
			'empty_input_err_txt'       => array( 'default' 	=> esc_html__("Please, enter all the required details.", 'wpguppy-lite'),
											   'title'		=> esc_html__('Empty input field error text', 'wpguppy-lite')),
			'crop_img_txt'       		=> array( 'default' 	=> esc_html__("Crop image", 'wpguppy-lite'),
											   'title'		=> esc_html__('Crop image text', 'wpguppy-lite')),
			'signin_box_hdr_txt'       	=> array( 'default' 	=> esc_html__("Let’s chat together", 'wpguppy-lite'),
											   'title'		=> esc_html__('Sign in widget box header text', 'wpguppy-lite')),
			'cancel_txt'       			=> array( 'default' 	=> esc_html__("Cancel", 'wpguppy-lite'),
											   'title'		=> esc_html__('Cancel button text', 'wpguppy-lite')),
			'contact_tooltip_txt'       => array( 'default' 	=> esc_html__("Contact list", 'wpguppy-lite'),
											   'title'		=> esc_html__('Contact list tooltip text', 'wpguppy-lite')),
			'conv_tooltip_txt'      	=> array( 'default' 	=> esc_html__("Chats", 'wpguppy-lite'),
											   'title'		=> esc_html__('Conversation list tooltip text', 'wpguppy-lite')),
			'friend_tooltip_txt'       	=> array( 'default' 	=> esc_html__("Friends", 'wpguppy-lite'),
											   'title'		=> esc_html__('Friend list tooltip text', 'wpguppy-lite')),
			'block_tooltip_txt'       	=> array( 'default' 	=> esc_html__("Blocked users", 'wpguppy-lite'),
											   'title'		=> esc_html__('Block list tooltip text', 'wpguppy-lite')),
			'close_all_conversation'	=> array( 'default' 	=> esc_html__("Close all conversation", 'wpguppy-lite'),
												'title'		=> esc_html__('Close all conversation', 'wpguppy-lite')),
			'contact_tab_txt'       	=> array( 'default' 	=> esc_html__("Contact list", 'wpguppy-lite'),
											   	'title'		=> esc_html__('Contact list tab text', 'wpguppy-lite')),
			'friend_tab_txt'       		=> array( 'default' 	=> esc_html__("Friends", 'wpguppy-lite'),
											  	'title'		=> esc_html__('Friend list tab text', 'wpguppy-lite')),
			'block_tab_txt'       		=> array( 'default' 	=> esc_html__("Blocked users", 'wpguppy-lite'),
												'title'		=> esc_html__('Block list tab text', 'wpguppy-lite')),
			'login_tab_txt'       		=> array( 'default' 	=> esc_html__("Login", 'wpguppy-lite'),
											   	'title'		=> esc_html__('Login tab heading text', 'wpguppy-lite')),
			'customer_tab_txt'       	=> array( 'default' 	=> esc_html__("Customer support", 'wpguppy-lite'),
											   'title'		=> esc_html__('Customer support tab text', 'wpguppy-lite')),
			'setting_tab_txt'       	=> array( 'default' 	=> esc_html__("Settings", 'wpguppy-lite'),
											   'title'		=> esc_html__('Setting tab text', 'wpguppy-lite')),
			'private_tab_txt'       	=> array( 'default' 	=> esc_html__("Private chats", 'wpguppy-lite'),
											   'title'		=> esc_html__('Private tab heading text', 'wpguppy-lite')),
			'name_txt'      			=> array( 'default' 	=> esc_html__("Name", 'wpguppy-lite'),
											   'title'		=> esc_html__('Name text', 'wpguppy-lite')),
			'dont_have_account_txt' 	=> array( 'default' 	=> html_entity_decode(stripslashes(esc_html__("Don\'t have account?", 'wpguppy-lite')), ENT_QUOTES),
											   'title'		=> esc_html__("Don't have account? text", 'wpguppy-lite')),
			'guest_login_txt'      		=> array( 'default' 	=> esc_html__("Start as guest today", 'wpguppy-lite'),
											   'title'		=> esc_html__('Start as guest login text', 'wpguppy-lite')),
			'have_account_txt'      	=> array( 'default' 	=> esc_html__("Do you have account?", 'wpguppy-lite'),
											   'title'		=> esc_html__('Do you have account text', 'wpguppy-lite')),
			'login_txt'      			=> array( 'default' 	=> esc_html__("Sign in now", 'wpguppy-lite'),
											   'title'		=> esc_html__('Sign in now text', 'wpguppy-lite')),
			'admin_support_agent_tab'   => array( 'default' 	=> esc_html__("Agents", 'wpguppy-lite'),
											   'title'		=> esc_html__('Agents text', 'wpguppy-lite')),
			'admin_support_msgs_tab'    => array( 'default' 	=> esc_html__("Messages", 'wpguppy-lite'),
											   'title'		=> esc_html__('Admin support messages tab text', 'wpguppy-lite')),
			//------------------------Whatsapp Translation------------------------//
			'whatsapp_support_desc'     => array( 'default' 	=> esc_html__('Need help? Click on the user to start a quick {{conversation_name}} conversation', 'wpguppy-lite'),
											   	'title'		=> esc_html__('Whatsapp support title description', 'wpguppy-lite')),
			'whatsap_list_title'       	=> array( 'default' 	=> esc_html__('WhatsApp chat support', 'wpguppy-lite'),
												'title'		=> esc_html__('Whatsapp support title text', 'wpguppy-lite')),
			'list_respond_text'       	=> array( 'default' 	=> esc_html__('Our online team will respond in few minutes', 'wpguppy-lite'),
												'title'		=> esc_html__('Online team respond text', 'wpguppy-lite')),
			'conversation_name_txt'     => array( 'default' 	=> esc_html__('WhatsApp', 'wpguppy-lite'),
												'title'		=> esc_html__('Whatsapp conversation name (like "Whatsapp")', 'wpguppy-lite')),
			'upload_photo_btn'       	=> array( 'default' 	=> esc_html__('Upload photo', 'wpguppy-lite'),
											   'title'		=> esc_html__('Upload photo button text', 'wpguppy-lite')),
			'mute_alert_txt'       		=> array( 'default' 	=> esc_html__('Mute alerts', 'wpguppy-lite'),
											   'title'		=> esc_html__('Mute notifications', 'wpguppy-lite')),
			'upload_photo_dsc'       	=> array( 'default' 	=> esc_html__('Click on the button below to upload your profile photo', 'wpguppy-lite'),
											   'title'		=> esc_html__('Upload photo description text', 'wpguppy-lite')),
			'invalid_email'       		=> array( 'default' 	=> esc_html__('Please, enter a valid email address', 'wpguppy-lite'),
											   'title'		=> esc_html__('Invalid email address', 'wpguppy-lite')),
);
		
		$list = apply_filters('wpguppy_default_text_filter', $list);

		return $list;
    }
    add_filter( 'wpguppy_default_text', 'wpguppy_default_text', 10, 1 );
}


/**
 * Time slots
 *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if ( ! function_exists( 'guppy_time_slots' ) ) {
	function guppy_time_slots( $key = '' ) {

		$list = array(		
					'00:00'	=> esc_html__('00:00', 'wpguppy-lite'),
					'01:00'	=> esc_html__('01:00', 'wpguppy-lite'),
					'02:00'	=> esc_html__('02:00', 'wpguppy-lite'),
					'03:00'	=> esc_html__('03:00', 'wpguppy-lite'),
					'04:00'	=> esc_html__('04:00', 'wpguppy-lite'),
					'05:00'	=> esc_html__('05:00', 'wpguppy-lite'),
					'06:00'	=> esc_html__('06:00', 'wpguppy-lite'),
					'07:00'	=> esc_html__('07:00', 'wpguppy-lite'),
					'08:00'	=> esc_html__('08:00', 'wpguppy-lite'),
					'09:00'	=> esc_html__('09:00', 'wpguppy-lite'),
					'10:00'	=> esc_html__('10:00', 'wpguppy-lite'),
					'11:00'	=> esc_html__('11:00', 'wpguppy-lite'),
					'12:00'	=> esc_html__('12:00', 'wpguppy-lite'),
					'13:00'	=> esc_html__('13:00', 'wpguppy-lite'),
					'14:00'	=> esc_html__('14:00', 'wpguppy-lite'),
					'15:00'	=> esc_html__('15:00', 'wpguppy-lite'),
					'16:00'	=> esc_html__('16:00', 'wpguppy-lite'),
					'17:00'	=> esc_html__('17:00', 'wpguppy-lite'),
					'18:00'	=> esc_html__('18:00', 'wpguppy-lite'),
					'19:00'	=> esc_html__('19:00', 'wpguppy-lite'),
					'20:00'	=> esc_html__('20:00', 'wpguppy-lite'),
					'21:00'	=> esc_html__('21:00', 'wpguppy-lite'),
					'22:00'	=> esc_html__('22:00', 'wpguppy-lite'),
					'23:00'	=> esc_html__('23:00', 'wpguppy-lite'),
					'23:59'	=> esc_html__('23:59', 'wpguppy-lite'),
				);
		$list = apply_filters('guppy_time_slots_filter', $list);
		if( !empty($key) ){
			$list   = !empty($list[$key]) ? $list[$key] : '';
		}	
		return $list;	
	}
	add_filter( 'guppy_time_slots', 'guppy_time_slots', 10, 1 );
}

/**
 * @init users online status
  *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_OnlineInit')) {
	add_action('init', 'wpguppy_OnlineInit');
	add_action('admin_init', 'wpguppy_OnlineInit');
	function wpguppy_OnlineInit(){
		$logged_in_users = get_transient('wpguppy_online_status'); 
		$user = wp_get_current_user(); //Get the current user's data
		if(empty($logged_in_users)){
			$query_meta_args = array(
				array(
					'key'     	=> 'wpguppy_user_online',                 
					'compare' 	=> '=',
					'value' 	=> '1',
				)
			);
			
			$query_args = array(
				'fields' 			=> array('id'),
				'number'			=> -1,
				'meta_query' 		=> $query_meta_args
			);
			
			$all_logined_users = get_users( $query_args );
			if(!empty($all_logined_users)){
				foreach( $all_logined_users as $single ) {
					delete_user_meta($single->id, 'wpguppy_user_online');
				}
			}
		}
		
		if ($user->ID > 0 && (!isset($logged_in_users[$user->ID]['last']) || $logged_in_users[$user->ID]['last'] <= time() - 900) ){
			$logged_in_users[$user->ID] = array(
				'id' 		=> $user->ID,
				'last' 		=> time(),
			);
			set_transient('wpguppy_online_status', $logged_in_users, 900);
			update_user_meta($user->ID,'wpguppy_user_online','1');
		}
		
		if(!empty($logged_in_users)){
			foreach($logged_in_users as $single){
				if($single['last'] < time() - 900){
					delete_user_meta($single['id'], 'wpguppy_user_online');
				}
			}
		}
	}
}

/**
 * @logout users online status update
  *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_LogoutInit')) {
	add_action('wp_logout', 'wpguppy_LogoutInit');
	function wpguppy_LogoutInit($userId){
		$logged_in_users = get_transient('wpguppy_online_status'); 
		if( !empty( $userId ) ){
			if( !empty( $logged_in_users[$userId] ) ){
				unset($logged_in_users[$userId]);
				set_transient('wpguppy_online_status', $logged_in_users, 900);
			}
			
			delete_user_meta($userId,'wpguppy_user_online');
		}
	}
}

/**
 * @Check if user is online
  *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_UserOnline')) {
	add_filter('wpguppy_UserOnline','wpguppy_UserOnline',10,1);
	function wpguppy_UserOnline($id){	
		$logged_in_users = get_transient('wpguppy_online_status'); 
		return isset($logged_in_users[$id]['last']) && $logged_in_users[$id]['last'] > time() - 900;
	}
}

/**
 * @get user last login
  *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_UserLastLogin')) {
	add_action('wpguppy_UserLastLogin','wpguppy_UserLastLogin',10,1);
	function wpguppy_UserLastLogin($id){
		$logged_in_users = get_transient('wpguppy_online_status'); 

		if ( isset($logged_in_users[$id]['last']) ){
			return $logged_in_users[$id]['last'];
		} else {
			return false;
		}
	}	
}

/**
 * @get send message to guppy user
  *
 * @throws error
 * @author Amentotech <wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_send_message_to_user')) {
	add_action('wpguppy_send_message_to_user', 'wpguppy_send_message_to_user', 10, 3);
	function wpguppy_send_message_to_user($senderId=0, $receiverId=0, $message = ''){
		$guppyModel     = WPGuppy_Model::instance();
        $fetchResults 	= $guppyModel->getGuppyFriend($senderId, $receiverId, false);
        $send_message   = false;
		
        if(empty($fetchResults)){
            $data 	= array(
                'send_by' 				=> $senderId,
                'send_to' 				=> $receiverId,
                'friend_status'			=> '1',
                'friend_created_date' 	=> date('Y-m-d H:i:s'),
            );
            $guppyModel->insertData('wpguppy_friend_list', $data, false);
            $send_message = true;
        }elseif($fetchResults['friend_status'] == 1){
            $send_message = true;
        }
		
        if($send_message && !empty($message)){
            $messageData        = array();
            $messageSentTime 	= date('Y-m-d H:i:s');
			$timestamp 			= strtotime($messageSentTime);
			
			$messageData['sender_id'] 			= $senderId; 
			$messageData['receiver_id'] 		= $receiverId; 
			$messageData['user_type'] 			= 1;  
			$messageData['message'] 			= wp_strip_all_tags(($message)); 
			$messageData['chat_type'] 			= 1; 
			$messageData['message_type'] 		= 0; 
			$messageData['timeStamp'] 			= $timestamp; 
			$messageData['message_sent_time'] 	= $messageSentTime;

            $guppyModel->insertData('wpguppy_message' , $messageData, false);

			$messageData['messageType'] 		= 0;

			//Message sent for themes comptibility
			do_action('wpguppy_on_message_sent',$messageData, '', $senderId, $receiverId);
        }
	}	
}

/**
 * @get send message to guppy user
  *
 * @throws error
 * @author Amentotech <wpguppy@gmail.com>
 * @return 
 */
if ( !function_exists('wpguppy_update_user_information') ) {
	add_action('wpguppy_update_user_information', 'wpguppy_update_user_information', 10, 5);
	function wpguppy_update_user_information($name = '', $phone='', $email = '', $user_id = '', $user_image = ''){
		$guppyModel     = WPGuppy_Model::instance();
		$where 		 	= "user_id=".$user_id; 
		$fetchResults 	= $guppyModel->getData('id','wpguppy_users',$where );
		$data 	= array(
			'user_id' 		=> $user_id,
			'user_name' 	=> $name,
			'user_email'	=> $email,
			'user_image'	=> $user_image,
			'user_phone'	=> $phone,
		);

        if( empty( $fetchResults ) ) {
            $guppyModel->insertData('wpguppy_users', $data, false );
        } else {
			$where = array( 'user_id' => $user_id );
			$guppyModel->updateData('wpguppy_users', $data, $where );
		}
	}	
}

/**
 * @get check already friend
  *
 * @throws error
 * @author Amentotech <wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_is_already_friend')) {
	add_filter('wpguppy_is_already_friend', 'wpguppy_is_already_friend', 10, 2);
	function wpguppy_is_already_friend($senderId=0, $receiverId=0){
		$guppyModel     = WPGuppy_Model::instance();
        $fetchResults 	= $guppyModel->getGuppyFriend($senderId, $receiverId, false);
        return !empty($fetchResults) && $fetchResults['friend_status'] == 1 ? true : false;
	}	
}

/**
 * @get count of unread messages
  *
 * @throws error
 * @author Amentotech <wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_count_all_unread_messages')) {
	add_filter('wpguppy_count_all_unread_messages','wpguppy_count_all_unread_messages', 10, 1);
	function wpguppy_count_all_unread_messages($userId = 0){
		
        $guppyModel     = WPGuppy_Model::instance();
		$restApiObj 	= WP_GUPPY_LITE_RESTAPI::instance('wpguppy-lite', WP_GUPPY_LITE_VERSION);
		$filterData =  array();
        $filterData['receiverId'] = $userId;

		// get one to one chat message unread count
		$filterData['chatType'] = '1';
		$filterData['receiverId'] = $userId;
		$onetoOneChatCount = $guppyModel->getUnreadCount($filterData);
		return intval( $onetoOneChatCount );
	}	
}

/**
 * @get count of unread messages of a user
  *
 * @throws error
 * @author Amentotech <wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_count_specific_user_unread_messages')) {
	add_filter('wpguppy_count_specific_user_unread_messages','wpguppy_count_specific_user_unread_messages', 10, 2);
	function wpguppy_count_specific_user_unread_messages($senderId=0, $receiverId=0){
		$filterData =  array();
        $filterData['chatType'] 	= '1';
        $filterData['senderId'] 	= $senderId;
        $filterData['receiverId'] 	= $receiverId;
        $guppyModel     = WPGuppy_Model::instance();
        $unreadCount 	= $guppyModel->getUnreadCount($filterData);
        return ! empty( $unreadCount ) ? intval( $unreadCount ) : 0;
	}	
}

/**
 * @Edit user information
  *
 * @throws error
 * @author Amentotech <wpguppy@gmail.com>
 * @return 
 */
if (!function_exists('wpguppy_custom_user_profile_fields')) {
	function wpguppy_custom_user_profile_fields($user){
		$settings 	= !empty($user->ID) ?  get_user_meta( $user->ID, 'wpguppy_user_settings', true ) : array();
		$name 		= !empty($settings['name']) ? sanitize_text_field($settings['name']) : '';
		$email 		= !empty($settings['email']) ? sanitize_email($settings['email']) : '';
		$phone 		= !empty($settings['phone']) ? sanitize_text_field($settings['phone']) : '';
		?>
		<h3><?php esc_html_e('WP Guppy Lite user settings','wpguppy-lite');?></h3>
		<span class="description"><?php esc_html_e('This settings will be added to WP plugin. You may leave this infromation empty','wpguppy-lite');?></span>
		<table class="form-table">
			<tr>
				<th><label><?php esc_html_e('Name','wpguppy-lite');?></label></th>
				<td><input class="regular-text" type="text" value="<?php echo esc_attr($name);?>" name="guppy[name]"></td>
			</tr>
			<tr>
				<th><label><?php esc_html_e('Email','wpguppy-lite');?></label></th>
				<td><input class="regular-text" type="text" value="<?php echo esc_attr($email);?>" name="guppy[email]"></td>
			</tr>
			<tr>
				<th><label><?php esc_html_e('Phone','wpguppy-lite');?></label></th>
				<td><input class="regular-text" type="text" value="<?php echo esc_attr($phone);?>" name="guppy[phone]"></td>
			</tr>
		</table>
	  <?php
	}
	add_action( "user_new_form", "wpguppy_custom_user_profile_fields" );
	add_action( 'show_user_profile', 'wpguppy_custom_user_profile_fields' );
	add_action( 'edit_user_profile', 'wpguppy_custom_user_profile_fields' );
}

/**
 * @Update user information when new user created
 * @type create
 */
if (!function_exists('wpguppy_create_wp_user')) {
	add_action( 'user_register', 'wpguppy_create_wp_user',10,1 );
    function wpguppy_create_wp_user($user_id) {
		$settings	= !empty($_POST['guppy']) ? $_POST['guppy'] : array();
		if( !empty( $settings['name'] ) || !empty( $settings['email'] ) || !empty( $settings['phone'] ) ) {
			$name 	= !empty($settings['name']) ? wp_strip_all_tags(stripslashes($settings['name']) ) : '';
			$phone 	= !empty($settings['phone']) ? $settings['phone'] : '';
			$email 	= !empty($settings['email']) ? $settings['email'] : '';
			do_action('wpguppy_update_user_information',$name,$phone,$email,$user_id, '');

			//update user meta
			update_user_meta($user_id,'wpguppy_user_settings',$settings);
		}

		//Add guppy admins with new user chat
		$users = get_users(array(
			'meta_key'     => 'is_guppy_admin',
			'meta_value'   => 1,
			'meta_compare' => '=',
			'fields'	   => 'ID'
		));

		if(!empty($users)){
			foreach($users as $key => $senderID){
				do_action('wpguppy_send_message_to_user',$senderID,$user_id,'');
			}
		}
	}
}

/**
 * Recursive sanitation for text or array
 * 
 * @param $array_or_string (array|string)
 * @since  0.1
 * @return mixed
 */
if (!function_exists('sanitize_text_or_array_field')) {
	function sanitize_text_or_array_field($array_or_string) {
		if( is_string($array_or_string) ){
			$array_or_string = sanitize_text_field($array_or_string);
		}elseif( is_array($array_or_string) ){
			foreach ( $array_or_string as $key => &$value ) {
				if ( is_array( $value ) ) {
					$value = sanitize_text_or_array_field($value);
				}
				else {
					$value = sanitize_text_field( $value );
				}
			}
		}

		return $array_or_string;
	}
}

/**
 * @Add new column in user listing wp
 * @type create
 */
if (!function_exists('wpguppy_add_wp_user_column')) {
	function wpguppy_add_wp_user_column( $column ) {
		$column['guppy_action'] = esc_html__('WP Guppy','wpguppy-lite');
		return $column;
	}
	add_filter( 'manage_users_columns', 'wpguppy_add_wp_user_column' );
}

/**
 * @Display admin column value
 * @type create
 */
if (!function_exists('wpguppy_display_admin_column_data')) {
	function wpguppy_display_admin_column_data( $val, $column_name, $user_id ) {

		switch ($column_name) {
			case 'guppy_action' :
				$is_admin				= get_user_meta( $user_id, 'is_guppy_admin', true );
				$is_guppy_whatsapp_user	= get_user_meta( $user_id, 'is_guppy_whatsapp_user', true );
				$admin_text = 'Make admin';
				$admin_class = $whatsapp_class = '';
				$value = 1;
				if(!empty($is_admin) && $is_admin == 1){
					$admin_class 	= 'db-guppy-greenbg';
					$admin_text 	= 'Admin';
					$value = 0;
				}
				$is_guppy_whatsapp_user_checked = false;
				if(!empty($is_guppy_whatsapp_user) && $is_guppy_whatsapp_user == 1){
					$is_guppy_whatsapp_user_checked 	= 'checked';
					$whatsapp_class 	= 'db-guppy-greenicon';
				}
				ob_start();
				?>
				<div class="db-guppy-whatsappcheck wpguppy-is-admin">
					<button type="button" class="wpguppy-is-admin button-secondary <?php echo esc_attr($admin_class); ?>" name="is_guppy_admin" value="<?php esc_attr_e($value); ?>" data-removeadmintext="<?php echo esc_attr__('Make admin', 'wpguppy-lite'); ?>" data-admintext="<?php echo esc_attr__('Admin', 'wpguppy-lite'); ?>" data-id="<?php echo esc_attr($user_id);?>"><?php echo esc_attr($admin_text, 'wpguppy-lite'); ?></button>
				</div>
				<div class="db-guppy-whatsappcheck">
					<input type="checkbox"   <?php echo esc_attr($is_guppy_whatsapp_user_checked); ?> data-id="<?php echo esc_attr($user_id);?>" name="is_guppy_whatsapp_user_checked">
					<i class="gp-whatsapp-icon<?php echo esc_attr($user_id) ?> dashicons dashicons-whatsapp <?php echo esc_attr($whatsapp_class); ?>"></i>
					<a href="javascript:;" class="guppy_whatsapp_user_edit"  data-id="<?php echo esc_attr($user_id);?>"><?php echo esc_html('Edit', 'wpguppy-lite'); ?></a>
				</div>
					 
				
				<?php
				return ob_get_clean();

			default:
		}
		return $val;
	}
	add_filter( 'manage_users_custom_column', 'wpguppy_display_admin_column_data', 20, 3 );
}


/**
 * @Add RTL support
 * @type load
 */
if(!function_exists('wpguppy_add_rtl_support')){
	function wpguppy_add_rtl_support( $classes ) {
		if ( is_rtl() ) {
			$classes[] = 'wpguppy-rtl';
		}
		
		return $classes;
	}
	add_filter( 'body_class','wpguppy_add_rtl_support' );
}

/**
 * @upgrade wpguppy database
  *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */

if (!function_exists('upgradeWPGuppy_DB')) {
	add_action('init', 'upgradeWPGuppy_DB');
	add_action('admin_init', 'upgradeWPGuppy_DB');
	function upgradeWPGuppy_DB(){
		// database upgradation
		$guppyModel	= WPGuppy_Model::instance();

		if( version_compare(WP_GUPPY_LITE_VERSION,'1.0.5') > 0 ){
			$guppyModel->updateMessageColumns(WP_GUPPY_LITE_VERSION);
			$guppyModel->createGuestAccountTable(WP_GUPPY_LITE_VERSION);
		}
	}
}

/**
 * @Get WP Guppy Pro
 * @type load
 */
if(!function_exists('wpguppy_lite_admin_notices_list')){
	function wpguppy_lite_admin_notices_list() {
		if(!is_plugin_active('wpguppy-lite/wpguppy-lite.php')){?>
			<div class="notice notice-success is-dismissible">
				<p><strong><?php esc_html_e( 'WP Guppy Pro - A live chat plugin have bunch of features like files, gallery, audio, video and voice note sharing', 'wpguppy-lite' ); ?></strong></p>
				<p><a class="button button-primary" target="_blank" href="https://codecanyon.net/item/wpguppy-a-live-chat-plugin-for-wordpress/34619534?s_rank=1"><?php esc_html_e( 'Get WP Guppy Pro', 'wpguppy-lite' ); ?></a></p>
			</div>
			<?php
		}
	}
	add_action( 'admin_notices', 'wpguppy_lite_admin_notices_list' );
}


/**
 * @add custom popup to admin side
  *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */

if (!function_exists('guppywhatsappPopup')) {
	if (!function_exists('is_plugin_active')) {
		include_once(ABSPATH . 'wp-admin/includes/plugin.php');
	}
	if(is_plugin_active('wpguppy-lite/wpguppy-lite.php')){
		add_action('admin_footer', 'guppywhatsappPopup');
		function guppywhatsappPopup(){
		?>	
			<div class="db-guppy-cus-modal">
				<div class="db-guppy-cus-modal-dialog">
					<div class="db-guppy-cus-modal-content" id="guppy-custom-popup"></div>
					<div class="db-guppy-cus-modal-header">
						<a href="#"  class="db-guppy-cus-close-modal">×</a>
						<h4 class="cus-modal-title"><?php esc_html_e('Add/edit whatsapp details','wpguppy-lite');?></h4>
					</div>
					<div class="db-guppy-cus-modal-body">
					</div>	
				</div>	
			</div>
		<?php	
		}
	}
}

/**
 * get time zone
 *
 * @throws error
 * @author WP Guppy<wpguppy@gmail.com>
 * @return 
 */
if ( ! function_exists( 'guppy_timezones_list' ) ) {
	function guppy_timezones_list(){

		$timezoneIdentifiers = DateTimeZone::listIdentifiers();
		$utcTime = new DateTime('now', new DateTimeZone('UTC'));

		$tempTimezones = array();
		foreach ($timezoneIdentifiers as $timezoneIdentifier) {
			$currentTimezone = new DateTimeZone($timezoneIdentifier);

			$tempTimezones[] = array(
				'offset' => (int)$currentTimezone->getOffset($utcTime),
				'identifier' => $timezoneIdentifier
			);
		}

		// Sort the array by offset,identifier ascending
		usort($tempTimezones, function($a, $b) {
			return ($a['offset'] == $b['offset'])
				? strcmp($a['identifier'], $b['identifier'])
				: $a['offset'] - $b['offset'];
		});

		$timezoneList = array();
		foreach ($tempTimezones as $tz) {
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
			$timezoneList[$tz['identifier']] = $tz['identifier'].' (UTC ' . $sign . $offset . ')';
		}

		return $timezoneList;

	}
}	