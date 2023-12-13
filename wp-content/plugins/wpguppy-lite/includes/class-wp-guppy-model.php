<?php
if (!class_exists('WPGuppy_Model')) {
    /**
     * Database operations Module
     * 
     * @package WP Guppy
    */

	/**
	 * Register all database operations & fucntions
	 *
	 * @link       wp-guppy.com
	 * @since      1.0.0
	 *
	 * @package    wp-guppy
	 * @subpackage wp-guppy/includes
	 */

	/**
	 * Register all actions and filters for the plugin.
	 *
	 * Maintain a list of all hooks that are registered throughout
	 * the plugin, and register them with the WordPress API. Call the
	 * run function to execute the list of actions and filters.
	 *
	 * @package    wp-guppy
	 * @subpackage wp-guppy/includes
	 * @author     wp-guppy <wpguppy@gmail.com>
	 */

	class WPGuppy_Model{


		/**
         * Initialize Singleton
         *
         * @var [void]
         */

        private static $_instance = null;
		
		
		/**
         * Call this method to get singleton
         *
         * @return wp-guppy Instance
         */
        public static function instance(){
            if (self::$_instance === null) {
                self::$_instance = new WPGuppy_Model();
            }
            return self::$_instance;
        }	

		/**
		 * Get guppy users 
		 *
		 * @param string $limit
		 * @param string $offset
		 * @param string $searchQuery
		 * @return void
		*/
		public function getGuppyFriend($userId = 0, $loginedUser = 0, $is_exclude = false){
			global $wpdb;
			$guppyFriends = $wpdb->prefix . 'wpguppy_friend_list';
			
			if($is_exclude){
				$where = " ($guppyFriends.send_by= $loginedUser OR $guppyFriends.send_to= $loginedUser)"; 
				$where .= " AND	($guppyFriends.friend_status= 0 OR $guppyFriends.friend_status= 1 OR  $guppyFriends.friend_status= 3) ";
			}else{
				$where = " ($guppyFriends.send_by= $loginedUser AND $guppyFriends.send_to= $userId)"; 
				$where .= " OR	($guppyFriends.send_by= $userId AND $guppyFriends.send_to= $loginedUser)";
			}

			$query = "SELECT $guppyFriends.*
			FROM $guppyFriends

			WHERE $where";
			if($is_exclude){
				$fetchResults = $wpdb->get_results( $query, ARRAY_A );
			}else{
				$fetchResults = $wpdb->get_row( $query, ARRAY_A );
			}
			return $fetchResults;
		}
		
		/**
		 * Get guppy friends 
		 *
		 * @param string $limit
		 * @param string $offset
		 * @param string $searchQuery
		 * @return void
		*/
		public function getGuppyContactList($limit, $offset, $searchQuery, $loginedUser, $friendStatus){
			global $wpdb;
			$userTable = $wpdb->prefix . 'users';
			$guppyFriends = $wpdb->prefix . 'wpguppy_friend_list';
			
			$searchFriend = '';
			if(!empty($searchQuery)){
				$searchFriend =" AND $userTable.display_name LIKE '%$searchQuery%'"; 	
			}
			if($friendStatus=='1'){
				$query = "SELECT * FROM (
						SELECT $userTable.display_name as userName, $guppyFriends.send_by, $guppyFriends.send_to 
						FROM $guppyFriends 
						INNER JOIN $userTable ON $guppyFriends.send_to = $userTable.ID 
						WHERE $guppyFriends.friend_status = '1'
						AND $guppyFriends.send_by = $loginedUser $searchFriend
					UNION ALL
						SELECT $userTable.display_name as userName, $guppyFriends.send_by, $guppyFriends.send_to 
						FROM $guppyFriends 
						INNER JOIN $userTable ON $guppyFriends.send_by = $userTable.ID 
						WHERE $guppyFriends.friend_status = '1'
						AND $guppyFriends.send_to = $loginedUser $searchFriend
				)as t ORDER BY t.userName  ASC  LIMIT $offset, $limit";
			}else{
				$query = "SELECT * FROM (
					SELECT $userTable.display_name as userName, $guppyFriends.send_by, $guppyFriends.send_to 
					FROM $guppyFriends 
					INNER JOIN $userTable ON $guppyFriends.send_to = $userTable.ID 
					WHERE $guppyFriends.friend_status = '3'
					AND $guppyFriends.send_to = $loginedUser $searchFriend
				)as t ORDER BY t.userName  ASC  LIMIT $offset, $limit";
			}

			$fetchResults = $wpdb->get_results( $query, ARRAY_A );
			return $fetchResults;
		}

		/**
		 * Get guppy friend requests
		 *
		 * @param string $limit
		 * @param string $offset
		 * @param string $searchQuery
		 * @return void
		*/
		public function getGuppyFriendRequests($limit, $offset, $searchQuery, $loginedUser){
			global $wpdb;
			$userTable = $wpdb->prefix . 'users';
			$guppyFriends = $wpdb->prefix . 'wpguppy_friend_list';
			
			$searchRequests = '';
			if(!empty($searchQuery)){
				$searchRequests =" AND $userTable.display_name LIKE '%$searchQuery%'"; 	
			}
			
			$query = "SELECT * FROM (
				SELECT $userTable.display_name as userName, $guppyFriends.send_by
				FROM $guppyFriends 
				INNER JOIN $userTable ON $guppyFriends.send_to = $userTable.ID 
				WHERE $guppyFriends.friend_status = '0'
				AND $guppyFriends.send_to = $loginedUser $searchRequests
			)as t ORDER BY t.userName  ASC  LIMIT $offset, $limit";
			$fetchResults = $wpdb->get_results( $query, ARRAY_A );
			return $fetchResults;
		}

		/**
		 * Get User Information
		 *
		 * @param string $type
		 * @param string $send_by
		 * @return void
		*/
		public  function getUserInfoData($type = '', $userID = '', $sizes = array()){
			$info = '';
			switch ($type) {
				case "avatar":
					$info = get_avatar_url($userID, $sizes);	
				break;

				case "useremail":
					$user_data 	= get_userdata($userID);
					if(!empty($user_data)){
						$info 	= $user_data->user_email;
					}
				break;

				case "username":
					$user_data 	= get_userdata($userID);
					if(!empty($user_data)){
						$info 	= $user_data->display_name;
					}
				break;

				case "url":
					$info = get_author_posts_url($userID);
				break;
			}
			return $info;
		}

		/**
		 * get user info
		 *
		 * @since    1.0.0
		*/
		public function getUserInfo($userType, $userId){
			$userName = $userAvatar = '';
			if( $userType == '1' ){
				$userAvatar 	= $this->getUserInfoData('avatar', $userId, array('width' => 150, 'height' => 150));
				$userName 		= $this->getUserInfoData('username', $userId, array());
				$where 		 	= "user_id='". $userId."'"; 
				$userinfo 		= $this->getData('user_name,user_image','wpguppy_users',$where );
				
				if(!empty($userinfo)){
					$info 				= $userinfo[0];
					$userName 			= $info['user_name'];
					if(!empty($info['user_image'])){
						$userImage 			= unserialize($info['user_image']);
						$userAvatar 		= $userImage['attachments'][0]['thumbnail'];
					}
				}
			}else{
				$where 		 	= "guest_id='". $userId."'"; 
				$userinfo 		= $this->getData('*', 'wpguppy_guest_account', $where );
				if(!empty($userinfo)){
					$info 					= $userinfo[0];
					$userName 				= $info['name'];
				}
				
			}
			
			if($userName != ''){
				$lastname = '';
				$name =	explode(' ' , $userName);
				if(!empty($name[1])){
					$lastname = ' '. ucfirst(substr($name[1], 0, 1));
				}
				$userName = ucfirst($name[0]).$lastname; 
			}
			return array(
				'userName' 		=> $userName,
				'userAvatar' 	=> $userAvatar,
			);
		}

		/**
		 * Get  table Information
		 *
		 * @param string $table_name
		 * @param array $where
		 * @param string $order_col
		 * @param string $order_by
		 * @return 
		*/
		public function getData($fields='*', $table_name='', $where='', $order_col=false, $order_by=false, $group_by=false){
			global $wpdb;
			$table_name = $wpdb->prefix .$table_name;
			$query = "SELECT $fields FROM $table_name WHERE $where ";
			if($group_by){
				$query .=" GROUP BY $group_by";
			}
			if($order_col){
				$query .=" ORDER BY $order_col  $order_by";
			}
			$fetchResults  = $wpdb->get_results($query, ARRAY_A);
			return $fetchResults;
		}

		/**
		 * Insert table data
		 *
		 * @param string $table_name
		 * @param array $data
		 * @return 
		*/
		public function insertData( $table_name = '', $data= array(), $lastId = true, $batchInsert = false){
			global $wpdb;
			$table_name = $wpdb->prefix.$table_name;
			if($batchInsert){
				$wpdb->insert_multiple($table_name, $data);
			}else{
				$wpdb->insert($table_name, $data);
			}
			if($lastId){
				return $wpdb->insert_id;
			}
		}
		
		/**
		 * update table data
		 *
		 * @param string $table_name
		 * @param array $data
		 * @return 
		*/
		public function updateData($table_name='', $data= array(), $where= array()){
			global $wpdb;
			$table_name = $wpdb->prefix .$table_name;
			$response = $wpdb->update($table_name, $data, $where);

			return $response;
		}

		/**
		 * delete table data
		 *
		 * @param string $table_name
		 * @param array $data
		 * @return 
		*/
		public function deleteData($table_name='',$where= array()){
			global $wpdb;
			$table_name = $wpdb->prefix .$table_name;
			$response = $wpdb->delete($table_name, $where);
			return $response;
		}

		

		/**
		 * Load user messages
		 *
		 * @since    1.0.0
		*/
		public function getUserMessageslist($loginedUser, $limit, $offset, $searchQuery, $chatType){
			global $wpdb;
			$guppyMessages 		= $wpdb->prefix . 'wpguppy_message';
			$userTable 			= $wpdb->prefix . 'users';
			$searchMessage  = $jointable = '';
			
			if(!empty($searchQuery)){
				$jointable = "INNER JOIN $userTable ON $userTable.ID = $guppyMessages.sender_id OR $userTable.ID = $guppyMessages.receiver_id";
				$searchMessage =" AND $guppyMessages.chat_type = '1'  AND ($guppyMessages.message LIKE '%$searchQuery%' OR $userTable.display_name LIKE '%$searchQuery%') group by $guppyMessages.id"; 	
			}
			
			$maxMessageIds = "SELECT $guppyMessages.id FROM $guppyMessages
			$jointable
			WHERE $guppyMessages.id IN ( 
				SELECT MAX(id) AS id 
				FROM ( 
					SELECT id, sender_id AS guppy_sender 
					FROM $guppyMessages 
					WHERE (receiver_id = $loginedUser OR sender_id = $loginedUser) 
					AND $guppyMessages.chat_type = '1'
					AND $guppyMessages.user_type <>'0'
					UNION ALL
					SELECT id, receiver_id AS guppy_sender 
					FROM $guppyMessages 
					WHERE (sender_id = $loginedUser OR receiver_id = $loginedUser) 
					AND $guppyMessages.chat_type = '1'
					AND $guppyMessages.user_type <>'0'

				) t GROUP BY guppy_sender
			)
			$searchMessage 
			ORDER BY id DESC LIMIT $offset, $limit";
			$getResult = $wpdb->get_results($maxMessageIds, ARRAY_A);
			
			$fetchResults = $messageIds = array(); 

			if(!empty($getResult)){
				foreach($getResult as $result){
					$messageIds[] = $result['id'];
				}
				$messageIds = implode(',',$messageIds);
			}
			if(!empty($messageIds)){
				$message_query = "SELECT $guppyMessages.*
				FROM $guppyMessages 
				WHERE $guppyMessages.id IN($messageIds)
				GROUP BY $guppyMessages.id
				ORDER BY $guppyMessages.id  DESC";
				$fetchResults  = $wpdb->get_results($message_query, ARRAY_A);
			}
			return	$fetchResults;
		}

		/**
		 * Load user admin support messages
		 *
		 * @since    1.0.0
		*/
		public function getUserAdminSupportMessages($loginedUser, $limit, $offset, $searchQuery, $isSupportMember){
			global $wpdb;
			$guppyMessages 		= $wpdb->prefix . 'wpguppy_message';
			$userTable 			= $wpdb->prefix . 'users';
			$searchMessage = $searchGroup = $jointable = $where = '';
			
			if(!empty($searchQuery)){ 	
				$searchMessage =" AND $guppyMessages.chat_type = '3'  AND ($guppyMessages.message LIKE '%$searchQuery%')"; 	
			}

			if($isSupportMember){
				$where = " AND $guppyMessages.sp_member_id = '$loginedUser'";
			}else{
				$where = " AND $guppyMessages.sp_member_id <> '$loginedUser'";
			}

			$messageQuery = "SELECT * FROM $guppyMessages
			$jointable
			WHERE $guppyMessages.id IN ( 
				SELECT MAX(id) AS id 
				FROM ( 
					SELECT id, sp_sender_id AS guppy_sender 
					FROM $guppyMessages 
					WHERE (sp_rec_id = '$loginedUser' OR sp_sender_id = '$loginedUser') 
					AND $guppyMessages.chat_type = '3'
					$where
					
					UNION ALL
					SELECT id, sp_rec_id AS guppy_sender 
					FROM $guppyMessages 
					WHERE (sp_sender_id = '$loginedUser' OR sp_rec_id = '$loginedUser') 
					AND $guppyMessages.chat_type = '3'
					$where

				) t GROUP BY guppy_sender
			)
			$searchMessage 
			ORDER BY $guppyMessages.id DESC LIMIT $offset, $limit";

			$fetchResults  = $wpdb->get_results($messageQuery, ARRAY_A);
			return	$fetchResults;
		}

		/**
		 * Load user last messages
		 *
		 * @since    1.0.0
		*/
		public function getUserLatestMessage( $loginedUser, $userId){
			global $wpdb;
			$guppyMessages 		= $wpdb->prefix . 'wpguppy_message';
			$query = "SELECT * FROM $guppyMessages WHERE (( sender_id = $loginedUser OR receiver_id = $loginedUser ) AND ( sender_id = $userId OR receiver_id = $userId )) AND `chat_type`=1 AND `user_type`=1 ORDER BY ID DESC LIMIT 1";
			$fetchResults = $wpdb->get_results($query, ARRAY_A);
			return	$fetchResults;
		}
		
		/**
		 * get guppy unread message count
		 *
		 * @since    1.0.0
		*/

		public function getUnreadCount($filterData){

			global $wpdb;
			$guppyMessages 		= $wpdb->prefix . 'wpguppy_message';
			$unSeenCount 		= 0;
			$where 	= "message_status = '0'";
			$where 	.= " AND message_type <> '4'";
			if($filterData['chatType'] == '3' && !empty($filterData['senderId']) && !empty($filterData['receiverId'])){
				$where 	.= " AND sp_sender_id 		='" .$filterData['senderId']."'";
				$where 	.= " AND sp_rec_id 			='" .$filterData['receiverId']."'"; 
				$where 	.= " AND chat_type 			=	'3'"; 
			} elseif($filterData['chatType'] == '1' && !empty($filterData['senderId']) && !empty($filterData['receiverId'])){
				$where 	.= " AND sender_id 	=" 	.$filterData['senderId'];
				$where 	.= " AND receiver_id =" 	.$filterData['receiverId']; 
				$where 	.= " AND chat_type 	='1'"; 
				$where 	.= " AND user_type 	='1'"; 
			}elseif(!empty($filterData['receiverId']) && in_array($filterData['chatType'], array('0','1', '3'))){
				
				if($filterData['chatType'] == 3){
					$where 	.= " AND sp_rec_id ='" .$filterData['receiverId']."'"; 
				}else{
					$where 	.= " AND receiver_id ='" .$filterData['receiverId']."'"; 
					$where 	.= " AND user_type 	=1"; 
				}
				$where 	.= " AND chat_type=".	$filterData['chatType']; 
				
			}
			$query = "SELECT id FROM $guppyMessages WHERE $where"; 
			$fetchResults = $wpdb->get_results($query, ARRAY_A);
			if(!empty($fetchResults)){
				$unSeenCount = count($fetchResults);
			}
			return $unSeenCount;	
		}
		

		/**
		 * get user chat
		 *
		 * @since    1.0.0
		*/

		public  function getGuppyChat($filterData){

			global $wpdb;
			$guppyMessages 	= $wpdb->prefix . 'wpguppy_message';
			$userChat 		= array();
			$selectFields 	= " $guppyMessages.*";

			$query = "SELECT * FROM (SELECT $selectFields 
			FROM $guppyMessages ";
			
			
			if( $filterData['chatType'] == '3' ){
				$query .=" WHERE (sp_sender_id = '". $filterData['actionBy'] ."' OR sp_rec_id = '". $filterData['actionBy'] ."')"; 
				$query .=" AND (sp_rec_id ='" .$filterData['userId']. "' OR sp_sender_id ='". $filterData['userId']."')"; 
				$query .=" AND $guppyMessages.chat_type = '3'";
			}elseif($filterData['chatType'] == '1'){
				$query .=" WHERE (sender_id = ". $filterData['actionBy'] ." OR receiver_id = ". $filterData['actionBy'] .")"; 
				$query .=" AND (receiver_id =" .$filterData['userId']. " OR sender_id =". $filterData['userId'].")"; 
				$query .=" AND $guppyMessages.chat_type = '1'";
				$query .=" AND $guppyMessages.user_type = '1'";
			}

			if(!empty($filterData['chatClearTime'])){
				$query .=" AND $guppyMessages.message_sent_time > '".$filterData['chatClearTime']."' "; 
			}
			
			if(!empty($filterData['offset'])){
				$query .=" AND $guppyMessages.id < ".$filterData['offset'].""; 	
				$query .=" ORDER BY $guppyMessages.id  DESC LIMIT " .$filterData['limit']. ') msg ORDER BY id ASC';
			}else{
				$query .=" ORDER BY $guppyMessages.id  DESC LIMIT ". $filterData['offset'].',' .$filterData['limit'].') msg ORDER BY id ASC';
			}

			$fetchResults  = $wpdb->get_results($query, ARRAY_A);
			return $fetchResults;
		}	

		/**
		 * Get Chat key
		 *
		 * @since    1.0.0
		*/
		public function getChatKey($chatType = '0', $chatId = 0, $postReceiverId = 0){
			$chatKey = $chatId;
			if($chatType == '0' ){
				$chatKey = $chatId.'_'.$postReceiverId.'_0';
			}elseif($chatType == '1'){
				$chatKey = $chatId.'_1';
			}elseif($chatType == '2'){
				$chatKey = $chatId.'_2';
			}elseif($chatType == '3'){
				$chatKey = $chatId.'_3'; // for customer  support members
			}elseif($chatType == '4'){
				$chatKey = $chatId.'_4'; // for whatsapp support members
			}
			return $chatKey;
		}

		/**
		 * upgrade database
		 *
		 * @since    1.0.0
		*/
		public function createGuestAccountTable($version){
			global $wpdb;
			$wpguppy_guest_account 		= $wpdb->prefix . 'wpguppy_guest_account';
			$charsetCollate 			= $GLOBALS['wpdb']->get_charset_collate();
			if ($wpdb->get_var("SHOW TABLES LIKE '$wpguppy_guest_account'") != $wpguppy_guest_account) {
				$guestAccount = "CREATE TABLE $wpguppy_guest_account (
					guest_id 			varchar (255)  NOT NULL,
					name 				varchar (255)  NOT NULL,
					email 				varchar (255)  NOT NULL,
					ip_address			varchar (255)  NOT NULL,
					user_agent			varchar (255)  NOT NULL,
					PRIMARY KEY (guest_id),
					INDEX index_column (email)                           
					) {$charsetCollate};";   
										
				require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
				dbDelta($guestAccount);
				update_option('wpguppylite_version',$version);
			}
		}
		/**
		 * upgrade database
		 *
		 * @since    1.0.0
		*/
		public function updateMessageColumns($version){

			global $wpdb;
			$guppyMessages 		= $wpdb->prefix . 'wpguppy_message';
			$guppyGuest 		= $wpdb->prefix . 'wpguppy_guest_account';
			$addColumns 		= array();
			
			$addColumns[$guppyMessages.'***sp_sender_id'] 	= "ALTER TABLE $guppyMessages 		ADD  `sp_sender_id` varchar(255) DEFAULT NULL COMMENT 'guest / registered user id' AFTER `receiver_id`, ADD INDEX (`sp_sender_id`);";
			$addColumns[$guppyMessages.'***sp_rec_id'] 		= "ALTER TABLE $guppyMessages 		ADD  `sp_rec_id` varchar(255) DEFAULT NULL COMMENT 'guest / registered user id' AFTER `sp_sender_id`, 	ADD INDEX (`sp_rec_id`);";
			$addColumns[$guppyMessages.'***sp_member_id'] 	= "ALTER TABLE $guppyMessages 		ADD  `sp_member_id` int(20) DEFAULT '0' COMMENT 'support member id' AFTER `sp_rec_id`, ADD INDEX (`sp_member_id`);";
			
			foreach($addColumns as $key=>$query){
				$data = explode('***',$key);
				$tableName 		= $data[0]; 
				$columnName 	= $data[1]; 
				$column = $wpdb->get_results( $wpdb->prepare("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = %s AND TABLE_NAME = %s AND COLUMN_NAME = %s ",DB_NAME, $tableName, $columnName) );
				if(empty($column)){
					$wpdb->query($query);
				}
			}
			update_option('wpguppylite_version',$version);
		}
		
		
	}
}