<?php

/**
 * Fired during plugin activation
 *
 * @link       https://themeforest.net/user/amentotech/
 * @since      1.0.0
 *
 * @package    Wp_Guppy_Lite
 * @subpackage Wp_Guppy_Lite/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Guppy_Lite
 * @subpackage Wp_Guppy_Lite/includes
 * @author     Amento Tech Pvt ltd <info@amentotech.com>
 */
class Wp_Guppy_Lite_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		$wpguppy_message 			= $wpdb->prefix . 'wpguppy_message';
		$wpguppy_friend_list 		= $wpdb->prefix . 'wpguppy_friend_list';
		$wpguppy_chat_action 		= $wpdb->prefix . 'wpguppy_chat_action';
		$wpguppy_users 				= $wpdb->prefix . 'wpguppy_users';
		$wpguppy_guest_account 		= $wpdb->prefix . 'wpguppy_guest_account';
		$charsetCollate = $GLOBALS['wpdb']->get_charset_collate();
		if ($wpdb->get_var("SHOW TABLES LIKE '$wpguppy_message'") != $wpguppy_message) {            
			$privateChat = "CREATE TABLE $wpguppy_message (
				id 					int(11) NOT NULL AUTO_INCREMENT,
				sender_id 			int(20) UNSIGNED NOT NULL,
				receiver_id 		int(20) UNSIGNED NOT NULL,
				sp_sender_id 		varchar(255) DEFAULT NULL COMMENT 'guest / registered user id',
				sp_rec_id 			varchar(255) DEFAULT NULL COMMENT 'guest / registered user id',
				sp_member_id 		int(20) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'support member id',
				post_id 			int(20) UNSIGNED DEFAULT NULL,
				message 			text NULL,
				group_id 			int(20) UNSIGNED DEFAULT NULL,
				attachments 		text NULL,
				reply_message 		text  DEFAULT NULL,
				user_type 			tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0->guest, 1->registered)',
				chat_type 			tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0->post based, 1->one to one, 2->group chat)',
				message_type 		tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0->text, 1->attachment, 2->location ,3->voice note, 4->notify_message)',
				group_msg_seen_id 	varchar(255) DEFAULT NULL  		COMMENT 'group member message seen ids',
				message_status 		tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0->unseen, 1->seen, 2->delete)',
				timestamp 			varchar(20) DEFAULT NULL,
				message_sent_time 	datetime DEFAULT NULL,
				message_seen_time 	datetime DEFAULT NULL,
				PRIMARY KEY (id),
				INDEX index_column (sender_id,receiver_id,sp_sender_id,sp_rec_id,sp_member_id,post_id,group_id,user_type,chat_type,message_type,message_status)                           
				) {$charsetCollate};";   
									
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($privateChat);     
		}

		if ($wpdb->get_var("SHOW TABLES LIKE '$wpguppy_friend_list'") != $wpguppy_friend_list) {
			$privateChat = "CREATE TABLE $wpguppy_friend_list (
				id 					int(11)  NOT NULL AUTO_INCREMENT,
				send_by 			int(20)  UNSIGNED NOT NULL,
				send_to 			int(20)  UNSIGNED NOT NULL,
				friend_created_date datetime DEFAULT NULL,
				friend_status  		tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0->invite, 1->active, 2->decline, 3->blocked)',
				PRIMARY KEY (id),
				INDEX index_column (send_by,send_to,friend_status)                           
				) {$charsetCollate};";   
									
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($privateChat);     
		}

		if ($wpdb->get_var("SHOW TABLES LIKE '$wpguppy_chat_action'") != $wpguppy_chat_action) {
			$privateChat = "CREATE TABLE $wpguppy_chat_action (
				id 						int(11) NOT NULL AUTO_INCREMENT,
				action_by 				int(20)  UNSIGNED NOT NULL,
				corresponding_id 		int(20)  UNSIGNED DEFAULT NULL,
				chat_type  				tinyint(1) DEFAULT NULL COMMENT '(0->post based, 1->one to one, 2->group chat)',
				action_type  			tinyint(1) NOT NULL DEFAULT '0' COMMENT '(0->clear chat, 1-> mute all notification, 2-> mute specific notification, 3->group left, 4->removed from group, 5->group delete)',
				action_time 			datetime DEFAULT NULL,
				action_updated_time 	datetime DEFAULT NULL,
				PRIMARY KEY (id),
				INDEX index_column (action_by,corresponding_id,chat_type,action_type)                           
				) {$charsetCollate};";   
									
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($privateChat);     
		}
		
		if ($wpdb->get_var("SHOW TABLES LIKE '$wpguppy_users'") != $wpguppy_users) {
			$privateChat = "CREATE TABLE $wpguppy_users (
				id 					int(11) NOT NULL AUTO_INCREMENT,
				user_id 			int(20)  UNSIGNED NOT NULL,
				user_name 			varchar(255)   NOT NULL,
				user_email 			varchar(255)   DEFAULT NULL,
				user_image 			mediumtext  	DEFAULT NULL,
				user_phone 			varchar(255)   DEFAULT NULL,
				PRIMARY KEY (id),
				INDEX index_column (user_id)                           
				) {$charsetCollate};";   
									
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($privateChat);     
		}

		if ($wpdb->get_var("SHOW TABLES LIKE '$wpguppy_guest_account'") != $wpguppy_guest_account) {
			$privateChat = "CREATE TABLE $wpguppy_guest_account (
				guest_id 			varchar (255)  NOT NULL,
				name 				varchar (255)  NOT NULL,
				email 				varchar (255)  NOT NULL,
				ip_address			varchar (255)  NOT NULL,
				user_agent			varchar (255)  NOT NULL,
				PRIMARY KEY (guest_id),
				INDEX index_column (email)                           
				) {$charsetCollate};";   
									
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($privateChat);     
		}

		$wpguppy_settings = get_option('wpguppy_settings');
		
		if(empty($wpguppy_settings)){
			$enabled_tabs 				= array('contacts','messages','friends','blocked', 'customer_support');	
			$translations 				= wp_list_pluck(apply_filters( 'wpguppy_default_text','' ),'default');
			
			$default_settings = array(
				'default_active_tab' 	=> 'contacts',
				'enabled_tabs' 			=> $enabled_tabs,
				'primary_color' 		=> '#FF7300',
				'secondary_color' 		=> '#0A0F26',
				'text_color' 			=> '#999999',
				'pusher' 				=> 'disable',
				'floating_window' 		=> 'enable',
				'whatsapp_support' 		=> 'disable',
				'floating_messenger' 	=> 'enable',
				'delete_message'		=> 'enable',	
				'clear_chat'			=> 'enable',	
				'hide_acc_settings'		=> 'no',	
				'translations' 			=> $translations,
			);
			
			update_option('wpguppy_settings',$default_settings);

		}
    }

}
