<?php
global $guppySetting;
if(!empty($guppySetting['rt_chat_settings']) 
	&& $guppySetting['rt_chat_settings'] == 'pusher'
	&& $guppySetting['pusher']=='enable'){
	require_once(WP_GUPPY_LITE_DIRECTORY.'libraries/pusher/vendor/autoload.php');
}

require_once(WP_GUPPY_LITE_DIRECTORY.'libraries/jwt/vendor/autoload.php');
/** Requiere the JWT library. */
use Firebase\JWT\JWT;

if (!class_exists('WP_GUPPY_LITE_RESTAPI')) {
    /**
     * REST API Module
     * 
     * @package WP Guppy
    */

	/**
	 * Register all rest api routes & function
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

	class WP_GUPPY_LITE_RESTAPI  extends WP_REST_Controller{

		/**
		 * The unique identifier of this plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
		*/
		private $plugin_name;

		/**
		 * The rest api url
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $restapiurl    rest api ajax url
		 */

		private $restapiurl = 'guppylite';


		/**
		 * The restapiversion
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $restapiversion    rest api version
		*/
		private $restapiversion = 'v2';

		/**
		 * The current version of the plugin.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of the plugin.
		 */
		private $version;

		/**
		 * private key for jwt.
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $secretKey   secret key for jwt.
		 */
		private $secretKey;

		/**
		 * database object
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of the plugin.
		 */
		private $guppyModel;
		
		/**
		 * Guppy Setting
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of the plugin.
		 */

		private $guppySetting;

		/**
		 * Show Record By Default
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of the plugin.
		 */

		private $showRec;
		/**
		 * private pusher
		 *
		 * @since    1.0.0
		 * @access   private
		 * @var      string    $version    The current version of the plugin.
		 */

		private  $pusher;

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
		public static function instance($plugin_name, $version){
            if (self::$_instance === null) {
                self::$_instance = new WP_GUPPY_LITE_RESTAPI($plugin_name, $version);
            }
            return self::$_instance;
        }

		/**
		 * Initialize the collections used to maintain the rest api routes.
		 *
		 * @since    1.0.0
		 */
		public function __construct($plugin_name, $version) {

			$this->plugin_name 		= $plugin_name;
			$this->version 			= $version;
			$this->secretKey 		= ',%]txNv^9J~,?-&EH-n;xy),LjN6*Zi/_YXKxTU_SkQ8F[q|du@/4DH*_v4qwJ}A';
			$guppyModel = WPGuppy_Model::instance();
			$this->guppyModel = $guppyModel;

			add_action('wp_enqueue_scripts', array(&$this,'registerGuppyConstant'),90);
			$this->registerRestRoutes();
			global $guppySetting;
			$this->guppySetting = $guppySetting;
			$this->showRec 		= !empty($this->guppySetting['showRec']) ? $this->guppySetting['showRec'] : 20;
			if(!empty($this->guppySetting['rt_chat_settings']) 
				&& $this->guppySetting['rt_chat_settings'] == 'pusher'
				&& $this->guppySetting['pusher']=='enable'){
				$appId 					= $this->guppySetting['option']['app_id'];
				$publicKey 				= $this->guppySetting['option']['app_key'];
				$secretKey 				= $this->guppySetting['option']['app_secret'];
				$appCluster 			= $this->guppySetting['option']['app_cluster'];
				if(!empty($appId) 
				&& !empty($publicKey) 
				&& !empty($secretKey) 
				&& !empty($appCluster)){
					$options = array(
						'useTLS'    => false,
						'cluster'   => $appCluster
					);
					$this->pusher = new Pusher\Pusher($publicKey, $secretKey, $appId, $options);
				}
			}
		}

		/**
		 * Register Guppy Constants
		 *
		 * @since    1.0.0
		*/

		public function registerRestRoutes(){

			add_action('rest_api_init', function() {

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'channel-authorize' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'guppyChannelAuthorize'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-guppy-users' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getGuppyUsers'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));
				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-guppy-friend-requests' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getGuppyFriendRequests'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));


				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'user-login' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'userAuth'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-profile-info' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getProfileInfo'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-unread-count' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getUnreadCount'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'update-profile-info' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'updateProfileInfo'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));
				
				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-guppy-contacts' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getGuppyContactList'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'send-guppy-invite' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'sendGuppyInvite'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));
				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'load-guppy-messages-list' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getUserMessageslist'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'load-guppy-chat' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getGuppyChat'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				
				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'send-guppy-message' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'sendMessage'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'delete-guppy-message' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'deleteGuppyMessage'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'update-guppy-message' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'updateGuppyMessage'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				
				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'update-user-status' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'updateGuppyUserStatus'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'clear-guppy-chat' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'clearGuppyChat'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'mute-guppy-notifications' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'muteGuppyNotification'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'get-messenger-chat-info' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'messengerChatInfo'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'register-guppy-account' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'registerGuppyGuestAccount'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));
				
				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-guppy-support-users' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getGuppySupportUsers'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'. $this->restapiversion , 'load-guppy-support-messages-list' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getGuppySupportMessagesList'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'load-guppy-whatsapp-users' , array(
					'methods'    			=>  WP_REST_Server::READABLE,
					'callback'   			=> array(&$this, 'getwhatsappUserList'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));

				register_rest_route($this->restapiurl.'/'.$this->restapiversion , 'user-typing' , array(
					'methods'    			=>  WP_REST_Server::CREATABLE,
					'callback'   			=> array(&$this, 'pusherTypeIndicator'),
					'args' 					=> array(),
					'permission_callback' 	=> '__return_true', 
				));
			});
		}

		/**
		 * Register Guppy Constants
		 *
		 * @since    1.0.0
		*/
		public function registerGuppyConstant(){
			
			$loginedUser 	= '';
			$userType		= '';
			if(is_user_logged_in()){
				global $current_user, $post;
				$loginedUser 	= $current_user->ID;
				$postId 		= !empty($post->ID) ? $post->ID : 0;
				$userType		= 1;
			}elseif(isset($_COOKIE['guppy_guest_account']) ){
				$session 		= explode('|', ($_COOKIE['guppy_guest_account']));
				$loginedUser 	= !empty($session[1]) ? $session[1] : ''; 
				$userType 		= 0;
			}
			$isSupportMember 	= false;
			$userData 	= get_userdata($loginedUser);
			if(!empty($userData)){
				$isSupportMember = get_user_meta($loginedUser, 'is_guppy_admin', true);
				if(!empty($isSupportMember) && $isSupportMember == 1){
					$isSupportMember = true;
				}
			}
			$settings  	= $this->getGuppySettings();
			$token  	= $this->getGuppyAuthToken($loginedUser);
			$authToken	= $token['authToken'];
			wp_localize_script($this->plugin_name, 'wpguppy_scripts_vars', array(
				'restapiurl'    		=> get_rest_url( null, $this->restapiurl.'/'.$this->restapiversion.'/') ,
				'rest_nonce'			=> wp_create_nonce('wp_rest'),
				'showRec'				=> $this->showRec, 
				'isSupportMember'		=> $isSupportMember,
				'userType'				=> $userType,
				'userId'				=> $loginedUser,
				'logoutUrl' 			=> esc_url(wp_logout_url(home_url('/'))), 
				'friendListStatusText'	=> $settings['textSetting'],
				'chatSetting' 			=> $settings['chatSetting'],
				'authToken' 			=> $authToken,
			));
		}

		/**
		 * Get guppy auth token
		 *
		 * @since    1.0.0
		*/
		public function getGuppyAuthToken($loginedUser , $ismobApp = false){
			$jwt 		= array();
			$issuedAt 	= time();
			$notBefore 	= $issuedAt + 10;
			$expire 	= $issuedAt + (DAY_IN_SECONDS * 1);
			if($ismobApp){
				$expire 	= $issuedAt + (DAY_IN_SECONDS * 60);
			}
			$token = array(
				'iss' => get_bloginfo('url'),
				'iat' => $issuedAt,
				'nbf' => $notBefore,
				'exp' => $expire,
				'data' => array(
					'user' => array(
						'id' => $loginedUser,
					),
				),
			);
			$authToken = JWT::encode($token, $this->secretKey , 'HS256');
			$jwt['authToken'] 		= $authToken;
			return $jwt;
		}

		/**
		 * Get guppy settings
		 *
		 * @since    1.0.0
		*/
		public function getGuppySettings($data = false){
			$settings 		= $json = array();
			$loginedUser 	= 0;
			if(is_user_logged_in()){
				global $current_user;
				$loginedUser = $current_user->ID;
			}
			if($data){
				$headers    		= $data->get_headers();
				$params     		= !empty($data->get_params()) 	? $data->get_params() 	: '';
				$loginedUser 		= !empty($params['userId']) ? intval($params['userId']) 	: 0; 
			}
			$default_bell_url    	= WP_GUPPY_LITE_DIRECTORY_URI.'public/media/notification-bell.wav';
			$messangerPageId 		= !empty($this->guppySetting['messanger_page_id']) ? $this->guppySetting['messanger_page_id'] 	: 0;
			$notificationBellUrl 	= !empty($this->guppySetting['notification_bell_url']) ? $this->guppySetting['notification_bell_url'] 	: $default_bell_url;
			$primaryColor 			= !empty($this->guppySetting['primary_color']) 		? $this->guppySetting['primary_color'] 		: '#FF7300';
			$secondaryColor 		= !empty($this->guppySetting['secondary_color']) 	? $this->guppySetting['secondary_color'] 	: '#0A0F26';
			$textColor 				= !empty($this->guppySetting['text_color']) 		? $this->guppySetting['text_color'] 		: '#000000';
			$enabledTabs 			= !empty($this->guppySetting['enabled_tabs']) 		? $this->guppySetting['enabled_tabs'] 		: array();
			$defaultActiveTab 		= !empty($this->guppySetting['default_active_tab']) ? $this->guppySetting['default_active_tab'] : 'contacts';
			$realTimeOption 		= !empty($this->guppySetting['rt_chat_settings'])  	? $this->guppySetting['rt_chat_settings'] 	: '';
			$pusherEnable 			= !empty($this->guppySetting['pusher'])  			&& $this->guppySetting['pusher'] == 'enable' 	? true 	: false;
			$socketEnable 			= !empty($this->guppySetting['socket'])  			&& $this->guppySetting['socket'] == 'enable' 	? true 	: false;
			$floatingWindowEnable 	= !empty($this->guppySetting['floating_window'])  	&& $this->guppySetting['floating_window'] == 'disable' 	? false 	: true;
			$whatsappSupportEnable 	= !empty($this->guppySetting['whatsapp_support'])  	&& $this->guppySetting['whatsapp_support'] == 'disable' 	? false 	: true;
			$floatingMessenger 		= !empty($this->guppySetting['floating_messenger']) && $this->guppySetting['floating_messenger'] == 'disable' 	? false 	: true;
			$appCluster 			= !empty($this->guppySetting['option']['app_cluster']) 		? $this->guppySetting['option']['app_cluster'] 	: '';
			$appKey 				= !empty($this->guppySetting['option']['app_key']) 			? $this->guppySetting['option']['app_key'] 	: '';
			$socketHost 			= !empty($this->guppySetting['option']['socket_host_url']) 	? $this->guppySetting['option']['socket_host_url'] 	: '';
			$socketPort 			= !empty($this->guppySetting['option']['socket_port_id']) 	? $this->guppySetting['option']['socket_port_id'] 	: '';
			$translations 			= !empty($this->guppySetting['translations']) 				? $this->guppySetting['translations'] 		: array();
			$floatingIcon 			= !empty($this->guppySetting['dock_layout_image']) 			? $this->guppySetting['dock_layout_image'] 	: '';
			$deleteMessageOption 	= !empty($this->guppySetting['delete_message']) 	&& $this->guppySetting['delete_message'] == 'disable' 	? false : true;
			$clearChatOption 		= !empty($this->guppySetting['clear_chat']) 		&& $this->guppySetting['clear_chat'] == 'disable' 	? false 	: true;
			$hideAccSettings 		= !empty($this->guppySetting['hide_acc_settings']) 	&& $this->guppySetting['hide_acc_settings'] == 'yes' ? true 	: false;
			$default_translations 	= wp_list_pluck(apply_filters( 'wpguppy_default_text','' ),'default');
			$autoInvite 	=	false;
			
			$roles =  $this->getUserRoles($loginedUser);
			 
			if(!empty($roles) && $roles['autoInvite']){
				$autoInvite = true;
			}
			foreach($default_translations as $key=> &$value){
				if(!empty($translations[$key])){
					$default_translations[$key] = $translations[$key];
				}
			}
			
			
			$chatSetting 	= array(
				'notificationBellUrl'	=> $notificationBellUrl,
				'translations'			=> $default_translations,
				'defaultActiveTab'		=> $defaultActiveTab,
				'enabledTabs'			=> $enabledTabs,
				'primaryColor' 			=> $primaryColor,	
				'secondaryColor' 		=> $secondaryColor,	
				'textColor' 			=> $textColor,	
				'autoInvite' 			=> $autoInvite,		
				'realTimeOption'		=> $realTimeOption,	
				'pusherEnable'			=> $pusherEnable,	
				'socketEnable'			=> $socketEnable,	
				'floatingWindowEnable'	=> $floatingWindowEnable,
				'whatsappSupportEnable'	=> $whatsappSupportEnable,	
				'floatingMessenger'		=> $floatingMessenger,
				'pusherKey'				=> $appKey,	
				'pusherCluster'			=> $appCluster,	
				'socketHost'			=> $socketHost,	
				'socketPort'			=> $socketPort,	
				'isRtl'					=> is_rtl(),
				'typingIcon'			=> WP_GUPPY_LITE_DIRECTORY_URI.'public/images/typing.gif',
				'videoThumbnail'		=> WP_GUPPY_LITE_DIRECTORY_URI.'public/images/video-thumbnail.jpg',
				'floatingIcon'			=> !empty($floatingIcon) ? $floatingIcon : WP_GUPPY_LITE_DIRECTORY_URI.'public/images/floating-logo.gif',
				'messangerPage'			=> apply_filters('wpguppy_messenger_link',get_the_permalink($messangerPageId)),
				'deleteMessageOption'	=> $deleteMessageOption,
				'messangerPageSeprator'	=> apply_filters('wpguppy_messenger_link_seprator','?'),
				'clearChatOption'		=> $clearChatOption,
				'hideAccSettings'		=> $hideAccSettings,
				'isMobileDevice'		=> wp_is_mobile(),
			);
			
			$textSetting	= array( 
				'sent' 				=> esc_html__( $default_translations['sent'], 'wpguppy-lite'), 
				'invite' 			=> esc_html__($default_translations['invite'], 'wpguppy-lite'),
				'blocked' 			=> esc_html__($default_translations['blocked'], 'wpguppy-lite'),
				'respond' 			=> esc_html__($default_translations['respond_invite'], 'wpguppy-lite'),
				'resend' 			=> esc_html__($default_translations['resend_invite'], 'wpguppy-lite'),
			);

			$settings['textSetting'] 	= $textSetting;
			$settings['chatSetting'] 	= $chatSetting;
			if($data){
				$json['settings']	= $settings;	
				return new WP_REST_Response($json, 200);
			}else{
				return $settings;
			}
		}

		/**
		 * Get guppy user Roles
		 *
		 * @since    1.0.0
		*/
		public function getUserRoles($userId) {
			$roles = array(
				'autoInvite' 	=> false,
			);
			if(!empty($userId)){
				$user_meta  		= get_userdata($userId);
				$user_roles 		= $user_meta->roles;
				$autoInvitesRoles 	= !empty($this->guppySetting['auto_invite']) ? $this->guppySetting['auto_invite'] : array();
				$autoInvite 		= false;
				if(!empty($user_roles)){
					foreach($user_roles as $single){
						if(in_array($single, $autoInvitesRoles)){
							$autoInvite = true;
						}
					}
					$roles['autoInvite'] 	= $autoInvite;
				}
			}
			return $roles;
		}

		/**
         * Login user for guppy mobile application
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
		*/
		public function userAuth($data) {
			
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$json 			= $userInfo = array();
			$username		= !empty( $params['username'] ) 		? $params['username'] : '';
			$userpassword	= !empty( $params['userpassword'] ) 	?  $params['userpassword']  : '';
			$isMobApp		= !empty( $params['isMobApp'] ) 		?  intval($params['isMobApp'])  : 0;
            if (!empty($username) && !empty($userpassword)) {
                
				$creds = array(
                    'user_login' 			=> $username,
                    'user_password' 		=> $userpassword,
                    'remember' 				=> true
                );
                
                $user = wp_signon($creds, false);
				
				if (is_wp_error($user)) {
                    $json['type']		= 'error';
                    $json['message']	= esc_html__('user name or password is not correct', 'wpguppy-lite');
					return new WP_REST_Response($json, 203);
                } else {
					
					unset($user->allcaps);
					unset($user->filter);

					$where 		 = "user_id=".$user->data->ID; 
					$fetchResults = $this->guppyModel->getData('*','wpguppy_users',$where );
					
					if(!empty($fetchResults)){
						$info 					= $fetchResults[0];
						$userInfo['userId'] 	= $user->data->ID;
						$userInfo['userName'] 	= $info['user_name'];
						$userInfo['userEmail'] 	= $info['user_email'];
						$userInfo['userPhone'] 	= $info['user_phone'];
					}else{
						$userInfo['userId'] 	= $user->data->ID;
						$userInfo['userName'] 	= $this->guppyModel->getUserInfoData('username', $user->data->ID , array());
						$userInfo['phoneNo'] 	= $this->guppyModel->getUserInfoData('userphone', $user->data->ID, array());
						$userInfo['email'] 		= $this->guppyModel->getUserInfoData('useremail', $user->data->ID, array());
					}

					$token 			= $this->getGuppyAuthToken($user->data->ID, true);
					$authToken 		= !empty( $token['authToken'] ) ? $token['authToken'] : '';
					$refreshToken 	= !empty( $token['refreshToken'] ) ? $token['refreshToken'] : '';
					update_user_meta($user->data->ID, 'wpguppy_app_auth_token', $authToken);
					$json['type']			= 'success';
					$json['message'] 		= esc_html__('You are logged in', 'wpguppy-lite');
					$json['userInfo'] 		= $userInfo;
					$json['authToken'] 		= $authToken;
					$json['refreshToken'] 	= $refreshToken;
					
					return new WP_REST_Response($json, 200);
                }                
            }else{
				$json['type']		= 'error';
				$json['message']	= esc_html__('user name and password are required fields.', 'wpguppy-lite');
				return new WP_REST_Response($json, 203);
			}
        }

		/**
         * Authorize Pusher Guppy Channel
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
		*/
		public function guppyChannelAuthorize($data){
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$socketId		= ! empty( $params['socket_id'] ) 		? $params['socket_id'] : 0;
			$channelName	= ! empty( $params['channel_name'] ) 	?  $params['channel_name']  : '';
			if($this->pusher){
				wp_send_json(json_decode( $this->pusher->socket_auth($channelName,$socketId)));
			}
		}

		/**
         * Guppy Authentication
         *
         * @param WP_REST_Request $request Full data about the request.
         * @return WP_Error|WP_REST_Request
		*/

		public function guppyAuthentication($params , $authtoken){
			
			$json 		= array();
			$type 		= 'success';
			$message 	= '';
			if(empty($params['userId']) 
				|| ( !empty($params['userType']) 
					&& $params['userType'] == 1 
					&& empty(get_userdata($params['userId']))
				)
			){
				$message   	= esc_html__('You are not allowed to perform this action!', 'wpguppy-lite');
				$type 		= 'error';	
			}else{
				list($token) = sscanf($authtoken, 'Bearer %s');
				if(!$token){
					$message   	= esc_html__('Authorization Token does not found!', 'wpguppy-lite');
					$type 		= 'error';
				}else{
					try {
						JWT::$leeway = 60;
						$token 	= JWT::decode($token, $this->secretKey, array('HS256'));
						$now 	= time();
						if ($token->iss != get_bloginfo('url') 
							|| !isset($token->data->user->id)
							|| $token->data->user->id != $params['userId']
							|| $token->exp < $now) {
							$message   	= esc_html__('You are not allowed to perform this action!', 'wpguppy-lite');
							$type 		= 'error';
							
						}
						
					}catch(Exception $e){
						$message   	= $e->getMessage();
						$type 		= 'error';
					}
				}
			}
			$json['type'] 			= $type;
			$json['message_desc']   = $message; 
			return $json;
		}

		/**
		 * Get timeFormat
		 *
		 * @since    1.0.0
		*/
		public function getTimeFormat($time){
			$time_offset 	= (float) get_option( 'gmt_offset' );
			$seconds 		= intval( $time_offset * HOUR_IN_SECONDS );
			$timestamp 		= strtotime( $time ) + $seconds;
			$timeFormat 	= !empty($time) ?  human_time_diff( $timestamp,current_time( 'timestamp' ) ).' '.esc_html__('ago','wpguppy-lite') : '';
			return $timeFormat;
		}
			
		/**
		 * Get guppy whatsappUser
		 *
		 * @since    1.0.0
		*/
		public function getwhatsappUserList($data){
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$json       	=  $userList = array();
			$offset 		= !empty($params['offset']) 		? intval($params['offset']) : 0; 
			$searchQuery 	= !empty($params['search']) 		? wp_strip_all_tags($params['search']) : '';
			$query_args = array(
				'fields' 			=> array('id'),
				'orderby' 			=> 'display_name',
				'order'   			=> 'DESC',
				'offset' 			=> $offset,
				'number'			=> $this->showRec,
				 'meta_query' => array(
				'relation' => 'AND',
					array(
						'key'   	=> 'is_guppy_whatsapp_user',
						'value' 	=> '1',
						'compare'   => '='
					)
				)
			);
			if( !empty($searchQuery) ){
				$query_args['search']	=  '*'.$searchQuery.'*';
			}
			$allusers = get_users( $query_args );

			if(!empty($allusers)){
				foreach($allusers as $user){
					$key 					= $this->guppyModel->getChatKey('4', $user->id);
					$guppyWhatsappInfo 		= get_user_meta($user->id, 'guppy_whatsapp_info', true);
					$userDesignation 		= !empty($guppyWhatsappInfo['user_designation']) 		? $guppyWhatsappInfo['user_designation'] : '';
					$userContact 			= !empty($guppyWhatsappInfo['user_contact']) 			? $guppyWhatsappInfo['user_contact'] : '';
					$userDefaultMessage 	= !empty($guppyWhatsappInfo['user_default_message']) 	? $guppyWhatsappInfo['user_default_message'] : '';
					$userOfflineMessage 	= !empty($guppyWhatsappInfo['user_offline_message']) 	? $guppyWhatsappInfo['user_offline_message'] : '';
					$userAvailability 		= !empty($guppyWhatsappInfo['user_availability']) 		? $guppyWhatsappInfo['user_availability'] : array();
					$usertimeZone 			= !empty($guppyWhatsappInfo['user_timezone']) 			? $guppyWhatsappInfo['user_timezone'] : '';
					 
					$userData 			= $this->guppyModel->getUserInfo('1', $user->id);
					$userName 			= $userData['userName'];
					$userAvatar 		= $userData['userAvatar'];
					$userList[$key] = array(
						'chatId'					=> $key,
						'userName' 					=> $userName,
						'userAvatar' 				=> $userAvatar,
						'userDesignation' 			=> $userDesignation,
						'userContact' 				=> $userContact,
						'userDefaultMessage'		=> $userDefaultMessage,
						'userOfflineMessage'		=> $userOfflineMessage,
						'availableTime' 			=> $userAvailability,
						'usertimeZone' 				=> $usertimeZone,
					);
				}
			}
			$json['type']		= 'success';
			$json['userList']	= (Object)$userList;
			$json['status']		= 200;
			return new WP_REST_Response($json , $json['status']);
		}
		/**
		 * send guppy invite
		 *
		 * @since    1.0.0
		*/
		public function sendGuppyInvite( $data ) {
			
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json       	=  $friendData = array();
			
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}

			$loginedUser 	= !empty($params['userId']) ? intval($params['userId']) 			: 0; 
			$sendTo			= !empty( $params['sendTo'] ) ? intval($params['sendTo']) 			: 0;
			$startChat		= !empty( $params['startChat'] ) ? intval($params['startChat']) 	: 0;
			$autoInvite 	= false;
			$loginUserRoles = $this->getUserRoles($loginedUser);
			$userMeta  		= get_userdata($sendTo);
			if($startChat == 1){
				if(!empty($loginUserRoles) && $loginUserRoles['autoInvite']){
					$autoInvite = true;
				}else{
					$json['type'] = 'error';
					$json['message_desc']   = esc_html__('You are not allowed to perform this action!', 'wpguppy-lite');
					return new WP_REST_Response($json , 203);
				}
			}
			$fetchResults 	= $this->guppyModel->getGuppyFriend($sendTo,$loginedUser,false);
			$response 		= false;
			if( empty(get_userdata($sendTo)) || $loginedUser == $sendTo){
				$json['type'] = 'error';
				$json['message_desc']   = esc_html__('You are not allowed to perform this action!', 'wpguppy-lite');
				return new WP_REST_Response($json , 203);
			} elseif(!empty( $fetchResults) && ($fetchResults['friend_status'] == '1' || $fetchResults['friend_status'] == '3')){
				$messageData 	= $messagelistData = array();
				// get receiver user info 
				$receiverUserName 	= $receiverUserAvatar = '';
				$userData 			= $this->getUserInfo('1', $sendTo);
				if(!empty($userData)){
					$receiverUserAvatar 	= $userData['userAvatar'];
					$receiverUserName 		= $userData['userName'];
				}
				$isOnline 			= wpguppy_UserOnline($sendTo);
				$userStatus = $this->getUserStatus($loginedUser, $sendTo, '1');
				$friendData = array(
					'userId' 		=> $sendTo,
					'chatType' 		=> 1,
					'chatId' 		=> $this->getChatKey('1',$sendTo),
					'friendStatus' 	=> $fetchResults['friend_status'],
					'userName' 	   	=> $receiverUserName,
					'userAvatar' 	=> $receiverUserAvatar,
					'blockedId' 	=> !empty($userStatus['blockedId']) ? $userStatus['blockedId'] : '',
					'isOnline' 		=> $isOnline,
					'isBlocked' 	=> $fetchResults['friend_status'] == 3 ? true : false,
				);
				$fetchResults 	= $this->guppyModel->getUserLatestMessage($loginedUser, $sendTo);  // senderId, receiverId
				$messageResult = ! empty($fetchResults) ? $fetchResults[0] : array();
				
				// check chat is cleard or not
				$chatClearTime  = '';
				$clearChat = false;
				$filterData = array();
				$filterData['actionBy'] 	= $loginedUser;
				$filterData['userId'] 		= $sendTo;
				$chatType = 1;
				$filterData['actionType'] 	= '0';
				$filterData['chatType']     = $chatType;
				$chatActions = $this->getGuppyChatAction($filterData);
				
				if(!empty($chatActions)){
					$chatClearTime = $chatActions['chatClearTime'];
				}

				$chatNotify = array();
				$chatNotify['actionBy'] 	= $loginedUser;
				$chatNotify['actionType'] 	= '2';
				$chatNotify['userId'] 		= $sendTo;
				$chatNotify['chatType'] 	= $chatType;
				$muteNotification = $this->getGuppyChatAction($chatNotify);
				
				if(!empty($muteNotification)){
					$muteNotification = true;
				}else{
					$muteNotification = false;
				}
				
				$message = $messageResult['message'];
				if(!empty($chatClearTime) && strtotime($chatClearTime) > strtotime($messageResult['message_sent_time'])){
					$clearChat 	= true;
					$message 	= '';
				}
				
				$messagelistData['messageId'] 			= $messageResult['id'];
				$messagelistData['message'] 			= $message;	
				$messagelistData['timeStamp'] 			= $messageResult['timestamp'];	
				$messagelistData['messageType'] 		= $messageResult['message_type'];
				$messagelistData['chatType'] 			= $messageResult['chat_type'];
				$messagelistData['isSender'] 			= $messageResult['sender_id'] == $loginedUser ? true : false;
				$messagelistData['messageStatus'] 		= $messageResult['message_status'];
				$messagelistData['userName'] 			= $receiverUserName;
				$messagelistData['userAvatar'] 			= $receiverUserAvatar;
				$messagelistData['chatId']				= $this->getChatKey('1',$sendTo);
				$messagelistData['blockedId'] 			= !empty($userStatus['blockedId']) ? $userStatus['blockedId'] : '';
				$messagelistData['clearChat'] 			= $clearChat;
				$messagelistData['isBlocked'] 			= !empty($userStatus['isBlocked']) ? $userStatus['isBlocked'] : false;
				$messagelistData['isOnline'] 			= !empty($userStatus['isOnline'])  ? $userStatus['isOnline'] : false;
				$messagelistData['UnreadCount'] 		= 0;
				$messagelistData['muteNotification'] 	= $muteNotification;
			
				$json['autoInvite']			= $autoInvite;
				$json['messagelistData']	= $messagelistData;
				$json['friendData']			= $friendData;
				$json['resendRequest']		= true;
				$json['type']				= 'success';
				$json['status']				= 200;
				return new WP_REST_Response($json , $json['status']);

			}elseif(!empty( $fetchResults) && ($fetchResults['friend_status'] == '2' || $fetchResults['friend_status'] == '0')){

				if($startChat == 1 &&  $autoInvite){
					$current_date 	= date('Y-m-d H:i:s');
					$friend_status 	= 1;
				}else{
					$current_date = $fetchResults['friend_created_date'];
					$friend_status = 0;
				}
				$where = array(
					'send_by' 				=> $loginedUser,
					'send_to' 				=> $sendTo,
				);

				$data 	= array(
					'friend_status'			=> $friend_status,
					'send_by' 				=> $loginedUser,
					'friend_created_date' 	=> $current_date,
					'send_to' 				=> $sendTo,
				);

				if($fetchResults['send_by'] != $loginedUser){
					$where = array(
						'send_by' 				=> $sendTo,
						'send_to' 				=> $loginedUser,
					);

					$data 	= array(
						'friend_status'			=> $friend_status,
						'send_by' 				=> $loginedUser,
						'friend_created_date' 	=> $current_date,
						'send_to' 				=> $sendTo,
					);
				}
				
				$response 	= $this->guppyModel->updateData( 'wpguppy_friend_list' , $data, $where);
			}elseif(empty($fetchResults)){
				if($startChat == 1 &&  $autoInvite){
					$current_date 	= date('Y-m-d H:i:s');
					$friend_status 	= 1;
				}else{
					$current_date = NULL;
					$friend_status = 0;
				}
				$data 	= array(
					'send_by' 				=> $loginedUser,
					'send_to' 				=> $sendTo,
					'friend_created_date' 	=> $current_date,
					'friend_status' 		=> $friend_status,
				);
				
				$response = $this->guppyModel->insertData('wpguppy_friend_list' , $data);	
			}
			
			$inviteStatus = esc_html__('Sent', 'wpguppy-lite');
			if ( $response) {
				if($startChat == 1 &&  $autoInvite){
					$isOnline 			= wpguppy_UserOnline($sendTo);
					// get receiver user info 
					$receiverUserName 	= $receiverUserAvatar = '';
					$userData 				= $this->getUserInfo('1', $sendTo);
					if(!empty($userData)){
						$receiverUserAvatar 	= $userData['userAvatar'];
						$receiverUserName 		= $userData['userName'];
					}
					// get sender user info 
					$senderUserName = $senderUserAvatar = '';
					$senderUserData 	= $this->getUserInfo(1, $loginedUser);
					if(!empty($senderUserData)){
						$senderUserName 	= $senderUserData['userName'];
						$senderUserAvatar 	= $senderUserData['userAvatar'];
					}
					$friendData = array(
						'userId' 		=> $sendTo,
						'chatType' 		=> 1,
						'chatId' 		=> $this->getChatKey('1',$sendTo),
						'friendStatus' 	=> 1,
						'userName' 	   	=> $receiverUserName,
						'userAvatar' 	=> $receiverUserAvatar,
						'blockedId' 	=> false,
						'isOnline' 		=> $isOnline,
						'isBlocked' 	=> false,
					);
					$messageData 	= $messagelistData = array();
					$messageSentTime 		= date('Y-m-d H:i:s');
					$timestamp 				= strtotime($messageSentTime);
					
					$messageData['sender_id'] 			= $loginedUser; 
					$messageData['receiver_id'] 		= $sendTo; 
					$messageData['user_type'] 			= 1; 
					$messageData['chat_type'] 			= 1; 
					$messageData['message_type'] 		= 4;
					$messageData['timestamp'] 			= $timestamp; 
					$messageData['message_sent_time'] 	= $messageSentTime;
					$data = array();
					$data['type'] = 1;
					$messageData['message'] = serialize($data); 
					$messageId = $this->guppyModel->insertData('wpguppy_message',$messageData);
					
					$messagelistData['messageId'] 			= $messageId;	
					$messagelistData['message'] 			= $data;	
					$messagelistData['timeStamp'] 			= $messageData['timestamp'];	
					$messagelistData['messageType'] 		= 4;
					$messagelistData['chatType'] 			= 1;
					$messagelistData['isSender'] 			= false;
					$messagelistData['messageStatus'] 		= '0';
					$messagelistData['userName'] 			= $senderUserName;
					$messagelistData['userAvatar'] 			= $senderUserAvatar;
					$messagelistData['chatId']				= $this->getChatKey('1',$loginedUser);
					$messagelistData['blockedId'] 			= false;
					$messagelistData['isBlocked'] 			= false;
					$messagelistData['isOnline'] 			= $isOnline;
					$messagelistData['UnreadCount'] 		= 0;
					$messagelistData['muteNotification'] 	= false;
					$messagelistData['isStartChat'] 		= true;
					
					$chatData = array(
						'chatType' 				=> 1,
						'chatId' 				=> $this->getChatKey('1',$sendTo),
						'messageId' 			=> $messageId,	
						'message' 				=> $data,	
						'timeStamp' 			=> $messageData['timestamp'],	
						'messageType' 			=> 4,
						'userType' 				=> 1,
						'messageStatus' 		=> '0',		
						'replyMessage' 			=> NULL,	
						'isOnline' 				=> $isOnline,	
						'metaData'				=> false,
						'userName'				=> $senderUserName,
						'userAvatar'			=> $senderUserAvatar,
						'clearChat'				=> false
					);
					$json['chatData']				= $chatData;
					$json['messagelistData']		= $messagelistData;
					$json['userName'] 				= $receiverUserName;
					$json['userAvatar'] 			= $receiverUserAvatar;
					
					if($this->pusher){
						$batchRequests = array();
						// send to receiver
						$pusherData = array(
							'chatId' 			=> $this->getChatKey('1',$loginedUser),
							'chatData'			=> $chatData,
							'chatType'			=> 1,
							'messagelistData' 	=> $messagelistData
						);
						$batchRequests[] = array(
							'channel' 	=> 'private-user-' . $sendTo,
							'name' 		=> 'recChatData',
							'data'		=> $pusherData,
						);

						// send to sender
						$chatData['isSender']				= true;
						$messagelistData['isSender'] 		= true;
						$messagelistData['userName'] 		= $receiverUserName;
						$messagelistData['userAvatar'] 		= $receiverUserAvatar;
						$messagelistData['UnreadCount'] 	= 0;
						$messagelistData['chatId']			= $this->getChatKey('1',$sendTo);
						$pusherData = array(
							'chatId' 			=> $this->getChatKey('1',$sendTo),
							'chatType'			=> 1,
							'chatData'			=> $chatData,
							'messagelistData' 	=> $messagelistData,
						);
						$batchRequests[] = array(
							'channel' 	=> 'private-user-' . $loginedUser,
							'name' 		=> 'senderChatData',
							'data'		=> $pusherData,
						);
						$this->pusher->triggerBatch($batchRequests);
					}
				}	
				$json['inviteStatus'] 	= $inviteStatus;
				$json['autoInvite']		= $autoInvite;
				$json['friendData']		= $friendData;
				$json['type']			= 'success';
				$json['resendRequest']	= false;
				$json['status']			= 200;
			} else {
				$json['type']	= 'error';
				$json['status']	= 203;
			}
			return new WP_REST_Response($json , $json['status']);
		}

		/**
		 * Register guest users
		 *
		 * @since    1.0.0
		*/
		public function registerGuppyGuestAccount($data){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json  = array();
			$type = 'error';
			$status = 203;
			$userId = 0;
			$authToken = '';
			$guestName 		= !empty($params['guestName']) ? wp_strip_all_tags($params['guestName']) : '';
			$guestEmail 	= !empty($params['guestEmail']) ? wp_strip_all_tags($params['guestEmail']) : '';
			$ipAddress 		= $_SERVER['REMOTE_ADDR'];
			$userAgent 		= $_SERVER['HTTP_USER_AGENT'];
			
			if(empty($guestName) || empty($guestEmail)){
				$json['type'] = 'error';
				$json['message_desc']   = esc_html__('Please fill the given details', 'wpguppy-lite');
				return new WP_REST_Response($json , 203);
			}else{

				$data 	= array(
					'name' 			=> $guestName,
					'email' 		=> $guestEmail,
					'ip_address' 	=> $ipAddress,
					'user_agent' 	=> $userAgent,
				);

				if(!session_id()){
					
					// long  time
					$sessionTime = 90 * 24 * 60 * 60;
					$sessionName = "guppy_guest_account";
					session_set_cookie_params($sessionTime);
					session_name($sessionName);
					session_start();

					$userId = session_id();
					$where 		 = "guest_id='$userId'"; 
					$fetchResults = $this->guppyModel->getData('guest_id,name','wpguppy_guest_account',$where );
					if(empty($fetchResults)){
						$data['guest_id'] = $userId;
						$this->guppyModel->insertData('wpguppy_guest_account' , $data);
					}
					
					$data['userId'] = $userId;
					$_SESSION[$sessionName] = $data;
					$cookiesValue =  $data['name']."|$userId";

					setcookie($sessionName, $cookiesValue, time() + $sessionTime, "/",);

					$token  	= $this->getGuppyAuthToken($userId);

					$authToken	= $token['authToken'];
					session_write_close();
				}
				
				$type 				= 'success';
				$status 			= 200;
				$json['userId']   	= $userId;	
				$json['authToken']  = $authToken;	
			}
			$json['type'] 	= $type;
			return new WP_REST_Response($json , $status);
		}

		/**
		 * Get guppy admin users
		 *
		 * @since    1.0.0
		*/
		public function getGuppySupportUsers($data){
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$offset 		= !empty($params['offset']) 	? intval($params['offset']) : 0; 
			$searchQuery 	= !empty($params['search']) 	? wp_strip_all_tags($params['search']) : '';
			$loginedUser 	= !empty($params['userId']) 	? $params['userId'] : 0;
			$userType 		= isset($params['userType']) 	? $params['userType'] : 1;
			$supportUsers = $json  = array();
			if($loginedUser){
				$response = $this->guppyAuthentication($params, $authToken);
				if(!empty($response) && $response['type']=='error'){
					return new WP_REST_Response($response , 203);
				}
			}
	
			$query_args = array(
				'fields' 			=> array('id'),
				'orderby' 			=> 'id',
				'order'   			=> 'DESC',
				'offset' 			=> $offset,
				'number'			=> $this->showRec,
				'meta_query' => array(
					'relation' => 'AND',
					array(
						'key'   	=> 'is_guppy_admin',
						'value' 	=> '1',
						'compare'   => '='
					)
				)
			);

			if( !empty($searchQuery) ){
				$query_args['search']	=  '*'.$searchQuery.'*';
			}
			$allusers = get_users( $query_args );

			if(!empty($allusers)){
				foreach($allusers as $user){
					
					$messageData = array();
					
					$key 		= $this->guppyModel->getChatKey(3, $user->id);
					$userData 	= $this->guppyModel->getUserInfo(1, $user->id);
					

					$filterData =  array();
					$filterData['chatType'] 		= 3;
					$filterData['senderId'] 		= $user->id;
					$filterData['receiverId'] 		= $loginedUser;	


					$unreadCount = $this->guppyModel->getUnreadCount($filterData);


					$supportUsers[$key] = array(
						'chatId'			=> $key,
						'chatType'			=> 3,
						'userName'			=> $userData['userName'],
						'isSupportMember' 	=> true,
						'UnreadCount' 		=> intval($unreadCount),
						'userAvatar'		=> $userData['userAvatar'],
						'isOnline'			=> wpguppy_UserOnline($user->id),
					);	
				}
			}
			
			$json['type']				= 'success';
			$json['supportUsers']	= (Object)$supportUsers;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * Get guppy support  messsages
		 *
		 * @since    1.0.0
		*/
		public function getGuppySupportMessagesList($data){
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$guppyMessageList = $json =  $userList = array();
			$offset 				= !empty($params['offset']) 			? intval($params['offset']) : 0; 
			$searchQuery 			= !empty($params['search']) 			? wp_strip_all_tags($params['search']) : '';
			$loginedUser 			= !empty($params['userId']) 			? $params['userId'] : 0;
			$userType 				= isset($params['userType']) 			? $params['userType'] : 1;
			$isSupportMember 		= !empty($params['isSupportMember']) 	? $params['isSupportMember'] : false;
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$fetchResults   = $this->guppyModel->getUserAdminSupportMessages($loginedUser, $this->showRec, $offset, $searchQuery, $isSupportMember);
			
			if(!empty($fetchResults)){
				foreach($fetchResults as $result){

					$messageData = array();
					if($result['sp_sender_id'] != $loginedUser){
						$spReceiverId = $result['sp_sender_id'];
					}else{
						$spReceiverId = $result['sp_rec_id']; 
					}
					$isSender = true;
					if($result['sp_sender_id'] != $loginedUser){
						$isSender= false; 
					}

					$message 						= $result['message'];
					$messageType 					= $result['message_type'];
					$timestamp 						= $result['timestamp'];
					$unreadCount					= 0;

					$filterData =  array();
					$filterData['chatType'] 		= $result['chat_type'];
					$filterData['senderId'] 		= $spReceiverId;
					$filterData['receiverId'] 		= $loginedUser;	
					
					$isRegistered = get_userdata($spReceiverId);
					$isSupportMember = false;
					$verifySupport = get_user_meta($spReceiverId, 'is_guppy_admin', true);
					if(!empty($verifySupport) && $verifySupport == 1){
						$isSupportMember = true;
					}else{
						$verifySupport = get_user_meta($loginedUser, 'is_guppy_admin', true);
						if(!empty($verifySupport) && $verifySupport == 1){
							$isSupportMember = true;
						}
					}

					$userData 	= $this->guppyModel->getUserInfo($isRegistered ? 1 : 0, $spReceiverId);
					$messageData['userAvatar']		= $userData['userAvatar'];	
					$messageData['userName'] 		= $userData['userName'];
					$messageData['isOnline'] 		= wpguppy_UserOnline($spReceiverId);
					
					$unreadCount = $this->guppyModel->getUnreadCount($filterData);
					if($result['message_status'] == 2 ){
						$message = '';
					}
					
					$chatId = $spReceiverId;
					if($message!=''){
						if($messageType == '0'){
							$message = html_entity_decode( stripslashes($message), ENT_QUOTES );
						}
					}
					$key 								= $this->guppyModel->getChatKey(3, $chatId);
					$messageData['chatId']				= $key;
					$messageData['isSender'] 			= $isSender;
					$messageData['message'] 	   		= $message;
					$messageData['messageType'] 		= $messageType;
					$messageData['isSupportMember'] 	= $isSupportMember;
					$messageData['messageStatus'] 		= $result['message_status'];
					$messageData['chatType'] 			= intval($result['chat_type']);
					$messageData['UnreadCount'] 		= intval( $unreadCount );
					$messageData['timeStamp'] 			= $timestamp;
					$messageData['messageId']			= Intval($result['id']);
					$guppyMessageList[$key] 			= $messageData;
				}
			}
			
			$json['type']				= 'success';
			$json['guppyMessageList']	= (Object)$guppyMessageList;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * update guppy user status
		 *
		 * @since    1.0.0
		*/
		public function updateGuppyUserStatus( $data ) {
			$headers    	= $data->get_headers();
			$params     	= ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json       	= array();
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$statusType		= ! empty( $params['statusType'] ) 	? intval($params['statusType'] ) : 0;
			$actionTo		= ! empty( $params['actionTo'] ) 	?  intval($params['actionTo'])  : 0 ;
			$loginedUser 	= !empty(  $params['userId']) 		? intval($params['userId']) : 0; 
			$response 		= false;
			if(!empty($statusType)){
				$user_meta  	= get_userdata($actionTo);
				$user_roles 	= $user_meta->roles;
				$allowed_roles = array( 'administrator');
				if (array_intersect( $allowed_roles, $user_roles ) && $statusType == 3 ) {
					$json['type'] = 'error';
					$json['message_desc']   = esc_html__('You are not allowed to block admin', 'wpguppy-lite');
					return new WP_REST_Response($json , 203);
				}
				$fetchResults 	= $this->guppyModel->getGuppyFriend($actionTo,$loginedUser,false);
				if(!empty($fetchResults)){
					$userData 	= $this->getUserInfo('1', $actionTo);
					$userAvatar = $userData['userAvatar'];
					$userName 	= $userData['userName'];
					$chatNotify = array();
					$chatNotify['actionBy'] 	= $loginedUser;
					$chatNotify['actionType'] 	= '2';
					$chatNotify['userId'] 		= $actionTo;
					$chatNotify['chatType'] 	= 1;
					$muteNotification = $this->getGuppyChatAction($chatNotify);
					if(!empty($muteNotification)){
						$muteNotification = true;
					}else{
						$muteNotification = false;
					}
					$updateData = array(
						'friend_status'	=> $statusType,
						'send_by' 		=> $actionTo,
						'send_to' 		=> $loginedUser,
					);
					if($statusType == 1){
						$updateData['friend_created_date'] = date('Y-m-d H:i:s');
						$response 	= $this->guppyModel->updateData( 'wpguppy_friend_list', $updateData, array('id' => $fetchResults['id']));	
					}elseif($statusType == 2 || $statusType == 3){
						$response 	= $this->guppyModel->updateData( 'wpguppy_friend_list', $updateData, array('id' => $fetchResults['id']));
						if($statusType ==3){
							if($this->pusher){
								$batchRequests = array();
								// send to sender
								$pusherData = array(
									'chatId' 			=> $this->getChatKey('1', $actionTo),
									'status' 			=> $statusType,
									'chatType' 			=> 1,
									'muteNotification'	=> $muteNotification,
									'userName' 	   		=> $userName,
									'userAvatar' 		=> $userAvatar,
									'clearChat' 		=> false,
									'blockedId' 		=> $actionTo,
									'blockerId' 		=> $loginedUser,
									'isBlocked' 		=> true,
									'isOnline' 			=> wpguppy_UserOnline($actionTo),
								);
								$batchRequests[] = array(
									'channel' 	=> 'private-user-' . $loginedUser,
									'name' 		=> 'updateUser',
									'data'		=> $pusherData,
								);

								// send to receiver
								$userData 					= $this->getUserInfo('1', $loginedUser);
								$senderUserAvatar 			= $userData['userAvatar'];
								$senderUserName 			= $userData['userName'];
								$chatNotify = array();
								$chatNotify['actionBy'] 	= $actionTo;
								$chatNotify['actionType'] 	= '2';
								$chatNotify['userId'] 		= $loginedUser;
								$chatNotify['chatType'] 	= 1;
								$senderMuteNotification = $this->getGuppyChatAction($chatNotify);
								if(!empty($senderMuteNotification)){
									$senderMuteNotification = true;
								}else{
									$senderMuteNotification = false;
								}
								$pusherData = array(
									'chatId' 			=> $this->getChatKey('1', $loginedUser),
									'status' 			=> $statusType,
									'chatType' 			=> 1,
									'muteNotification'	=> $senderMuteNotification,
									'userName' 	   		=> $senderUserName,
									'userAvatar' 		=> $senderUserAvatar,
									'clearChat' 		=> false,
									'blockedId' 		=> $actionTo,
									'blockerId' 		=> $loginedUser,
									'isBlocked' 		=> true,
									'isOnline' 			=> wpguppy_UserOnline($loginedUser),
								);
								$batchRequests[] = array(
									'channel' 	=> 'private-user-' . $actionTo,
									'name' 		=> 'updateUser',
									'data'		=> $pusherData,
								);
								$this->pusher->triggerBatch($batchRequests);
							}	
						}
					}elseif($statusType == 4 && empty($fetchResults['friend_created_date'])){
						$response 	=	$this->guppyModel->deleteData( 'wpguppy_friend_list',  array('id' => $fetchResults['id']));
						$statusType = 0;
					}elseif($statusType == 4 && !empty($fetchResults['friend_created_date'])){
						$statusType = 1;
						$updateData = array(
							'friend_status'	=> $statusType
						); 
						$response 	= $this->guppyModel->updateData( 'wpguppy_friend_list', $updateData, array('id' => $fetchResults['id']));
						if($this->pusher){
							$batchRequests = array();
							// send to sender
							$pusherData = array(
								'chatId' 			=> $this->getChatKey('1', $actionTo),
								'status' 			=> $statusType,
								'chatType' 			=> 1,
								'blockedId' 		=> $actionTo,
								'blockerId' 		=> $loginedUser,
								'muteNotification'	=> $muteNotification,
								'userName' 	   		=> $userName,
								'userAvatar' 		=> $userAvatar,
								'clearChat' 		=> false,
								'isBlocked' 		=> false,
								'isOnline' 			=> wpguppy_UserOnline($actionTo),
							);
							$batchRequests[] = array(
								'channel' 	=> 'private-user-' . $loginedUser,
								'name' 		=> 'updateUser',
								'data'		=> $pusherData,
							);
							// send to receiver
							$userData 	= $this->getUserInfo('1', $loginedUser);
							$senderUserAvatar 	= $userData['userAvatar'];
							$senderUserName 	= $userData['userName'];
							$chatNotify = array();
							$chatNotify['actionBy'] 	= $actionTo;
							$chatNotify['actionType'] 	= '2';
							$chatNotify['userId'] 		= $loginedUser;
							$chatNotify['chatType'] 	= 1;
							$senderMuteNotification = $this->getGuppyChatAction($chatNotify);
							if(!empty($senderMuteNotification)){
								$senderMuteNotification = true;
							}else{
								$senderMuteNotification = false;
							}
							$pusherData = array(
								'chatId' 			=> $this->getChatKey('1', $loginedUser),
								'status' 			=> $statusType,
								'chatType' 			=> 1,
								'blockedId' 		=> $actionTo,
								'blockerId' 		=> $loginedUser,
								'muteNotification'	=> $senderMuteNotification,
								'userName' 	   		=> $senderUserName,
								'userAvatar' 		=> $senderUserAvatar,
								'clearChat' 		=> false,
								'isBlocked' 		=> false,
								'isOnline' 			=> wpguppy_UserOnline($loginedUser),
							);
							$batchRequests[] = array(
								'channel' 	=> 'private-user-' . $actionTo,
								'name' 		=> 'updateUser',
								'data'		=> $pusherData,
							);
							$this->pusher->triggerBatch($batchRequests);
						}	
					}
				}
			}
			if (!empty($response)) {
				
				$userStatus = $this->getUserStatus($loginedUser, $actionTo, '1');
				$data = array(
					'muteNotification'	=> $muteNotification,
					'blockerId' 		=> $loginedUser,
					'chatId' 			=> $this->getChatKey('1',$actionTo),
					'chatType' 			=> 1,
					'status' 			=> $statusType,
					'userName' 	   		=> $userName,
					'userAvatar' 		=> $userAvatar,
					'blockedId' 		=> $userStatus['blockedId'],
					'isOnline' 			=> $userStatus['isOnline'],
					'isBlocked' 		=> $userStatus['isBlocked'],
					'clearChat' 		=> false,
				);
				$json['type']			= 'success';
				$json['userData']		= $data;
				$json['status']			= 200;
			}else{
				$json['type']	= 'error';
				$json['status']	= 203;
			}
			return new WP_REST_Response($json , $json['status']);
		}

		

		/**
		 * clear guppy chat
		 *
		 * @since    1.0.0
		*/
		public function clearGuppyChat( $data ) {
			$headers    	= $data->get_headers();
			$params     	= ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json       	= array();
			$response 		= $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}

			$actionTo		= ! empty( $params['actionTo'] ) 	? intval( $params['actionTo'] ) : 0 ;
			$loginedUser 	= ! empty(  $params['userId']) 		? intval($params['userId']) 	: 0; 
			$chatType 		= ! empty(  $params['chatType']) 	? $params['chatType'] 			: 0; 
			$chatId 		= ! empty(  $params['chatId']) 		? $params['chatId'] 			: ''; 
			$response 		= false;
			

			$filterData = array();
			$filterData['actionBy'] 	= $loginedUser;
			$filterData['chatType'] 	= $chatType;
			
			if(!empty($actionTo) && $chatType==1){
				$filterData['userId'] 		= $actionTo;
				$corresponding_id 			= $actionTo;
			}
			$filterData['actionType'] 	= '0';
			$chatActions = $this->getGuppyChatAction($filterData);

			if(!empty($chatActions)){
				$updateData = array(
					'action_by'				=> $loginedUser,
					'corresponding_id' 		=> $corresponding_id,
					'chat_type' 			=> $chatType,
					'action_type' 			=> '0',
					'action_time' 			=> date('Y-m-d H:i:s'),
					'action_updated_time' 	=> date('Y-m-d H:i:s'),
				);
				$response 	= $this->guppyModel->updateData( 'wpguppy_chat_action', $updateData, array('id' => $chatActions['chatActionId']));	
			
			}else{
				$insertData = array(
					'action_by'				=> $loginedUser,
					'corresponding_id' 		=> $corresponding_id,
					'chat_type' 			=> $chatType,
					'action_type' 			=> '0',
					'action_time' 			=> date('Y-m-d H:i:s'),
					'action_updated_time' 	=> date('Y-m-d H:i:s')
				);
				$response 	= $this->guppyModel->insertData( 'wpguppy_chat_action', $insertData);
			}
			
			if($response) {
				if($this->pusher){
					$pusherData = array(
						'actionTo' 	=> $actionTo,
						'chatId' 	=> $chatId,
						'chatType'  => $chatType,
						'userId' 	=> $loginedUser,
					);
					$this->pusher->trigger('private-user-'.$loginedUser, 'clearChat', $pusherData);
				}

				$json['type']		= 'success';
				$json['status']		= 200;
			}else{
				$json['type']	= 'error';
				$json['status']	= 203;
			}
			return new WP_REST_Response($json , $json['status']);
		}

		

		/**
		 * Get guppy users
		 *
		 * @since    1.0.0
		*/
		public function getGuppyUsers($data){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$guppyUsers = $json = $meta_query_args = array();
			$requestCount = 0;

			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$offset 		= !empty($params['offset']) ? intval($params['offset']) : 0; 
			$searchQuery 	= !empty($params['search']) ? wp_strip_all_tags($params['search']) : ''; 
			$loginedUser 	= !empty($params['userId']) ? intval($params['userId']) : 0; 

			$roles = $this->getUserRoles($loginedUser);
			$autoInvite 	= $roles['autoInvite'];
			$excludeIds 	= array($loginedUser);
			$fetchResults 	= $this->guppyModel->getGuppyFriend(false, $loginedUser, true);
			if(!empty($fetchResults)){
				foreach( $fetchResults as $result ) {
					if ( $result['friend_status'] == '3') {
						if($result['send_by'] == $loginedUser){
							$excludeIds[] = $result['send_to'];
						}else{
							$excludeIds[] = $result['send_by'];
						}
					}elseif($result['friend_status'] == '1'){
						if($result['send_by'] == $loginedUser){
							$excludeIds[] = $result['send_to'];
						}else{
							$excludeIds[] = $result['send_by'];
						}
					}elseif($result['friend_status'] == '0' && !$autoInvite && $result['send_to'] == $loginedUser ){
						$excludeIds[] = $result['send_by'];
					}
				}
			}
			$query_meta_args = array(
				'relation' => 'OR',
				array(
					'key'     => 'wpguppy_user_online',                 
					'compare' => 'NOT EXISTS'
				),
				array(
					'key'     => 'wpguppy_user_online',                 
					'compare' => 'EXISTS'
				)
			);
			$query_args = array(
				'fields' 			=> array('id'),
				'orderby' 			=> 'meta_value',
				'order' 			=> 'DESC',
				'offset' 			=> $offset,
				'number'			=> $this->showRec,
				'exclude'			=> $excludeIds,
				'meta_query' 		=> $query_meta_args
			);
			if( !empty($searchQuery) ){
				$query_args['search']	=  '*'.$searchQuery.'*';
			}
			$query_args = apply_filters('wpguppy_filter_user_params', $query_args);
			$allusers = get_users( $query_args );
			if(!empty($allusers)){
				foreach( $allusers as $user ) {

					$fetchResults 	= $this->guppyModel->getGuppyFriend($user->id, $loginedUser, false);
					
					$userData 	= $this->getUserInfo('1', $user->id);
					$userAvatar = $userData['userAvatar'];
					$userName 	= $userData['userName'];
					
					$friend_status	= !empty($fetchResults) ? $fetchResults['friend_status'] : '';
					$sendTo			= !empty($fetchResults) ? $fetchResults['send_to'] : ''; 
					$send_by		= !empty($fetchResults) ? $fetchResults['send_by'] : ''; 
					
					$inviteStatusText 	= 'invite';
					if ( $friend_status == '0' && $send_by == $loginedUser ) {
						$inviteStatusText = 'sent';
					}elseif ( $friend_status == '2' && $sendTo == $loginedUser ) {
						$inviteStatusText = 'invite';
					} elseif ( $friend_status == '2' ) {
						$inviteStatusText = 'resend';
					} elseif ( $friend_status == '3' && $send_by == $loginedUser) {
						$inviteStatusText = 'blocked';
					}

					$isOnline 		= wpguppy_UserOnline($user->id);
					$key 			= $this->getChatKey('1',$user->id);
					$guppyUsers[$key] = array(
						'chatType'		 => 1,
						'chatId'		 => $key,
						'statusText' 	 => $inviteStatusText,
						'friendStatus' 	 => intval( $friend_status ),
						'userName' 	   	 => $userName,
						'userAvatar' 	 => $userAvatar,
						'isOnline'		 => $isOnline,
					);	
				}
			}
			$json['type'] 					= 'success';
			$json['guppyUsers']     		= (Object)$guppyUsers;
			$json['autoInvite']     		= $autoInvite;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * Get guppy Friend requests
		 *
		 * @since    1.0.0
		*/
		public function getGuppyFriendRequests($data){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$guppyFriendRequests = $json  = array();
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$offset 		= !empty($params['offset']) ? intval($params['offset']) : 0; 
			$searchQuery 	= !empty($params['search']) ? wp_strip_all_tags($params['search']) : ''; 
			$loginedUser 	= !empty($params['userId']) ? intval($params['userId']) : 0; 
			$fetchResults 	= $this->guppyModel->getGuppyFriendRequests($this->showRec, $offset, $searchQuery, $loginedUser);
			if(!empty($fetchResults)){
				foreach( $fetchResults as $user ) {
					$userData 	= $this->getUserInfo('1', $user['send_by']);
					$userAvatar = $userData['userAvatar'];
					$userName 	= $userData['userName'];
					$inviteStatusText = 'respond';
					$key = $user['send_by'].'_1';
					$guppyFriendRequests[$key] = array(
						'userId'		 => intval( $user['send_by']),
						'statusText' 	 => $inviteStatusText,
						'userName' 	   	 => $userName,
						'userAvatar' 	 => $userAvatar,
					);	
				}
			}
			$json['type'] 					= 'success';
			$json['guppyFriendRequests']    = (Object)$guppyFriendRequests;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * get User Profile info
		 *
		 * @since    1.0.0
		*/
		public function getProfileInfo( $data ){
			
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$userInfo  	= $json = $userInfo = array();

			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$loginedUser 	= !empty($params['userId']) ? intval($params['userId']) : 0; 
			// check mute notification
			$muteNotification = false;
			$where 				= "action_by=".$loginedUser; 
			$where 				.= " AND action_type='1'"; 
			$checknotification 	= $this->guppyModel->getData('id','wpguppy_chat_action',$where );
			if(!empty($checknotification)){
				$muteNotification = true;
			}
			$userInfo['userId'] 			= $loginedUser;
			$userInfo['muteNotification'] 	= $muteNotification;
			$userInfo['userAvatar'] 		= $this->guppyModel->getUserInfoData('avatar', $loginedUser, array('width' => 150, 'height' => 150));
			// get user information
			$where 		 	= "user_id=".$loginedUser; 
			$fetchResults 	= $this->guppyModel->getData('*','wpguppy_users',$where );
			
			if(!empty($fetchResults)){
				$info 					= $fetchResults[0];
				$userInfo['userName'] 	= $info['user_name'];
				$userInfo['userEmail'] 	= $info['user_email'];
				$userInfo['userPhone'] 	= $info['user_phone'];
				if(!empty($info['user_image'])){
					$userImage 				= unserialize($info['user_image']);
					$avatar_url 			= $userImage['attachments'][0]['thumbnail'];
					$userInfo['userAvatar']	= $avatar_url;
				}
			}else{
				$userInfo['userName'] 		= $this->guppyModel->getUserInfoData('username', $loginedUser, array());
				$userInfo['userPhone'] 		= $this->guppyModel->getUserInfoData('userphone', $loginedUser, array());
				$userInfo['userEmail'] 		= $this->guppyModel->getUserInfoData('useremail', $loginedUser, array());
			}
			$json['type'] 					= 'success';
			$json['userInfo']   			= $userInfo;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * get unread Count 
		 *
		 * @since    1.0.0
		*/
		public function getUnreadCount( $data ){
			
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$userInfo  	= $json = $userInfo = $filterData = $unReadContent =  array();
			$requestCount = $onetoOneChatCount = 0;
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$loginedUser 	= !empty($params['userId']) 	? $params['userId'] : 0; 
			$userType 		= isset($params['userType']) 	? $params['userType'] : '1';
			
			$filterData['receiverId'] = $loginedUser;
			$filterData['userType'] = $userType;

			if($userType == 1){

				// get one to one chat message unread count
				$filterData['chatType'] = '1';
				$onetoOneChatCount = $this->guppyModel->getUnreadCount($filterData);

				// get invite request count
				$where 	= "send_to='".$loginedUser."'"; 
				$where .= " AND friend_status='0'";
				$fetchResults = $this->guppyModel->getData('id', 'wpguppy_friend_list', $where );
				if(!empty($fetchResults)){
					$requestCount = count($fetchResults);
				}
			}

			// get support base chat message unread count
			$filterData['chatType'] = '3';
			$supportbaseMsgCount = $this->guppyModel->getUnreadCount($filterData);
			$unReadContent['requestCount']   		= 	! empty( $requestCount ) ? intval( $requestCount ) : 0;
			$unReadContent['supportbaseChatCount']  = 	intval( $supportbaseMsgCount );
			$unReadContent['privateChatCount']   	=  	intval( $onetoOneChatCount );
			$json['type'] 							= 'success';
			$json['unReadContent']					= $unReadContent;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * update user profile Info
		 *
		 * @since    1.0.0
		*/
		public function updateProfileInfo( $data ){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$userImage  = !empty($data->get_file_params()) ? $data->get_file_params() 	: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$userInfo  	= $json = array();
			$avatar_url = '';
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}

			$userName 		= !empty($params['userName']) 	? wp_strip_all_tags($params['userName']) : ''; 
			$userEmail 		= !empty($params['userEmail']) 	? wp_strip_all_tags($params['userEmail']) : ''; 
			$userPhone 		= !empty($params['userPhone']) 	? wp_strip_all_tags($params['userPhone']) : ''; 
			$loginedUser 	= !empty($params['userId']) ? intval($params['userId']) : 0;
			$removeAvatar 	= !empty($params['removeAvatar']) ? intval($params['removeAvatar']) : 0;

			if(!empty($userImage)){
				$filterData = array();
				$filterData['userId'] 		= $loginedUser;
				$filterData['isProfile'] 	= true;
				$attachmentData =$this->uploadAttachments('1', $userImage, $filterData);
				if(!empty($attachmentData)){
					$userInfo['user_image'] = serialize($attachmentData);
					$avatar_url 	= $attachmentData['attachments'][0]['thumbnail'];
				}
			}elseif($removeAvatar=='1'){
				$userInfo['user_image'] = NULL;
			}
			
			$where 			= "user_id=".$loginedUser; 
			$fetchResults 	= $this->guppyModel->getData('*','wpguppy_users',$where );
			$userInfo['user_name'] = $userName;
			$userInfo['user_email'] = $userEmail;
			$userInfo['user_phone'] = $userPhone;
			wp_update_user(array('ID' => $loginedUser, 'display_name' => $userName));
			if(!empty($fetchResults)){
				$updateWhere = array(
					'user_id' 	=> $loginedUser,
				);
				$response = $this->guppyModel->updateData('wpguppy_users',$userInfo, $updateWhere);
			}else{
				$userInfo['user_id'] = $loginedUser;
				$response = $this->guppyModel->insertData('wpguppy_users',$userInfo);
			}
			$info = array(); 
			$info['userName'] 	= $userName;
			$info['userPhone'] 	= $userPhone;
			$info['userEmail'] 	= $userEmail;
			$info['userAvatar'] = $avatar_url;

			$json['type'] 		= 'success'; 
			$json['userInfo']   = $info;
			$json['response']   = $response;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * mute guppy notifications
		 *
		 * @since    1.0.0
		*/
		public function muteGuppyNotification( $data ){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 	: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json = array();

			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			
			$muteType 		= !empty($params['muteType']) 	? intval($params['muteType']) 	: 0; 
			$actionTo 		= !empty($params['actionTo']) 	? intval($params['actionTo']) 	: 0; 
			$loginedUser 	= !empty($params['userId']) 	? intval($params['userId']) 	: 0;
			$chatType 		= !empty($params['chatType']) 	? intval($params['chatType']) 	: 0;
			$chatId 		= !empty($params['chatId']) 	? $params['chatId'] 	: '';
			$type 			= 'error';
			$muteAll 		= '';
			$response 		= false;
			if($muteType == '1'){
				$where 			= "action_by=".$loginedUser; 
				$where 			.= " AND action_type='1'"; 
				$fetchResults 	= $this->guppyModel->getData('id','wpguppy_chat_action',$where );
				if(!empty($fetchResults)){
					$where = array(
						'action_by' 	=> $loginedUser,
						'action_type' 	=> '1',
					);
					$response = $this->guppyModel->deleteData('wpguppy_chat_action',$where);
					$muteAll = '0';
				}else{

					$data =array(
						'action_by' 			=> $loginedUser,
						'action_type' 			=> '1',
						'action_time' 			=> date('Y-m-d H:i:s'),
						'action_updated_time' 	=> date('Y-m-d H:i:s'),
					);
					$response = $this->guppyModel->insertData('wpguppy_chat_action',$data);
					$muteAll = '1';
				}
			}else{
				$corresponding_id = $actionTo;
				$where 			= "action_by=".$loginedUser; 
				$where 			.= " AND corresponding_id=".$corresponding_id; 
				$where 			.= " AND chat_type = ".$chatType; 
				$where 			.= " AND action_type = '2'"; 
				$fetchResults 	= $this->guppyModel->getData('id','wpguppy_chat_action',$where );
				if(!empty($fetchResults)){
					$response = $this->guppyModel->deleteData('wpguppy_chat_action', array('id'=> $fetchResults[0]['id']));
					$muteAll = '0';
				}else{
					$data =array(
						'action_by' 			=> $loginedUser,
						'corresponding_id' 		=>  $corresponding_id,
						'action_type' 			=> '2',
						'chat_type'				=> $chatType,
						'action_time' 			=> date('Y-m-d H:i:s'),
						'action_updated_time' 	=> date('Y-m-d H:i:s'),
					);
					$response = $this->guppyModel->insertData('wpguppy_chat_action',$data);
					$muteAll = '1';
				}
				
			}
			if($response){
				$type = 'success';
				if($this->pusher){
					$pusherData = array(
						'chatId' 	=> $chatId,
						'chatType'  => $chatType,
						'isMute' 	=> $muteAll == '1' ? true : false,
						'muteType' 	=> $muteType,
						'userId' 	=> $loginedUser,
					);
					$this->pusher->trigger('private-user-'.$loginedUser, 'updateMuteChatNotify', $pusherData);
				}
			}
			$json['type'] 			= $type;
			$json['actionTo'] 		= $actionTo;
			$json['chatType'] 		= $chatType;
			$json['muteAll'] 		= $muteAll;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * delete guppy Message
		 *
		 * @since    1.0.0
		*/
		public function deleteGuppyMessage( $data ){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 	: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json 		=   array();
			$chatType	= '';
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$type = 'error';
			$messageId 		= !empty($params['messageId']) 	? intval($params['messageId']) 	: 0; 
			$loginedUser 	= !empty($params['userId']) 	? intval($params['userId']) 	: 0; 
			
			if(!empty($messageId)){
				
				$where 			= "id =".$messageId; 
				$where 			.= " AND sender_id =".$loginedUser; 
				$where 			.= " AND message_status ='0'"; 
				$fetchResults 	= $this->guppyModel->getData('chat_type,receiver_id,sender_id','wpguppy_message',$where );
				if(!empty($fetchResults)){
					$response = $this->guppyModel->updateData('wpguppy_message',array('message_status' => '2'), array('id' => $messageId));
					if($response){
						$type = 'success';
						$chatId = '';
						$chatType = $fetchResults[0]['chat_type'];
						if( $fetchResults[0]['chat_type'] == '1' ) {
							$chatId 				= $this->getChatKey('1', $fetchResults[0]['sender_id']);
							$json['chatId'] 		=  $chatId;
							$json['receiverId'] 	=  $fetchResults[0]['receiver_id'];
						}
						$json['chatType'] 		= $chatType;
						if($chatType == '1'){
							if($this->pusher){
								$batchRequests = array();
								$pusherData = array(
									'chatId' 	=> $chatId,
									'chatType' 	=> $chatType,
									'messageId' => $messageId,
								);
								$batchRequests[] = array(
									'channel' 	=> 'private-user-' . $fetchResults[0]['receiver_id'],
									'name' 		=> 'deleteMessage',
									'data'		=> $pusherData,
								);
								// send to sender
								$chatId 				= $this->getChatKey('1', $fetchResults[0]['receiver_id']);
								$pusherData['chatId'] 	= $chatId;
								$batchRequests[] = array(
									'channel' 	=> 'private-user-' . $fetchResults[0]['sender_id'],
									'name' 		=> 'deleteMessage',
									'data'		=> $pusherData,
								);
								$this->pusher->triggerBatch($batchRequests);
							}
						}
					}
				}
			}	
			$json['type'] 			= $type;
			$json['messageId'] 		= $messageId;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * update guppy Message
		 *
		 * @since    1.0.0
		*/
		public function updateGuppyMessage( $data ){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 	: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json 		= $messageIds 	 = array();
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$type = 'error';
			$chatId 		= !empty($params['chatId']) 	? $params['chatId'] 	: ''; 
			$receiverId 	= !empty($params['userId']) 	? $params['userId'] 	: 0; 
			$chatType 		= !empty($params['chatType']) 	? $params['chatType'] 	: 0; 
			$messageCounter = 0;
			$chatkey 		= explode('_', $chatId);

			if(!empty($chatId) && !empty($receiverId) && ( $chatType == '1' || $chatType == '3' ) ){
				$senderId 		= $chatkey[0];
				$where 			= " chat_type =".$chatType;
				$where 			.= " AND message_status ='0'"; 

				if($chatType == '3'){
					$chatId = $this->guppyModel->getChatKey(3, $receiverId);
					$where 			.= " AND sp_rec_id ='".$receiverId."'"; 
					$where 			.= " AND sp_sender_id ='".$senderId."'"; 
				}else{
					$chatId = $this->guppyModel->getChatKey('1', $receiverId);
					$where 			 .= " AND receiver_id =".$receiverId; 
					$where 			.= " AND sender_id =".$senderId; 
				}
				
				$fetchResults 	= $this->guppyModel->getData('id','wpguppy_message',$where );
				
				if(!empty($fetchResults)){
					foreach($fetchResults as $result){
						$this->guppyModel->updateData('wpguppy_message',array('message_status' => '1', 'message_seen_time' => date('Y-m-d H:i:s')), array('id' => $result['id']));
						$messageIds[$result['id']] = true;
						$messageCounter++;
					}
				}

				if($this->pusher){
					$batchRequests = array();
					$pusherData = array(
						'chatId' 			=> $chatId,
						'chatType' 			=> $chatType,
						'messageIds' 		=> $messageIds,
						'isSender'			=> true,
						'messageCounter'	=> $messageCounter,
					);
					$batchRequests[] = array(
						'channel' 	=> 'private-user-' . $senderId,
						'name' 		=> 'updateMessage',
						'data'		=> $pusherData,
					);
					$pusherData = array(
						'chatId' 			=> $chatId,
						'chatType' 			=> $chatType,
						'messageIds' 		=> $messageIds,
						'isSender'			=> false,
						'senderId'			=> $senderId,
						'messageCounter'	=> $messageCounter,
					);
					$batchRequests[] = array(
						'channel' 	=> 'private-user-' . $receiverId,
						'name' 		=> 'updateMessage',
						'data'		=> $pusherData,
					);
					$this->pusher->triggerBatch($batchRequests);
				}
				$json['senderId'] 		= $senderId;	
			}
			$type = 'success';
			$json['type'] 				= $type;
			$json['messageIds'] 		= $messageIds;
			$json['messageCounter'] 	= $messageCounter;
			$json['chatId'] 			= $chatId;
			$json['chatType'] 			= $chatType;
			return new WP_REST_Response($json , 200);
		}


		/**
		 * Load  guppy contact list
		 *
		 * @since    1.0.0
		*/
		public function getGuppyContactList($data){
			
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 			? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$json       = array();

			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			
			$offset 		= !empty($params['offset']) ? 		intval($params['offset']) : 0; 
			$searchQuery 	= !empty($params['search']) 		? wp_strip_all_tags($params['search']) : ''; 
			$friendStatus 	= !empty($params['friendStatus']) 	? intval($params['friendStatus']) : ''; 
			$loginedUser 	= !empty($params['userId']) 		? intval($params['userId']) : 0;
			$fetchResults 	= $this->guppyModel->getGuppyContactList($this->showRec, $offset, $searchQuery, $loginedUser, $friendStatus);
			$guppyUsers 	= array();
			$unreadCount    = 0;
			if ( !empty( $fetchResults )) {
				foreach( $fetchResults as $result ) {
					if($result['send_by'] == $loginedUser){
						$friendId = intval( $result['send_to'] );
					}else{
						$friendId = intval( $result['send_by'] );
					}
					$userData 	= $this->getUserInfo('1', $friendId);
					$userAvatar = $userData['userAvatar'];
					$userName 	= $userData['userName'];

					$chatNotify = array();
					$chatNotify['actionBy'] 	= $loginedUser;
					$chatNotify['actionType'] 	= '2';
					$chatNotify['userId'] 		= $friendId;
					$chatNotify['chatType'] 	= 1;
					$muteNotification = $this->getGuppyChatAction($chatNotify);
					if(!empty($muteNotification)){
						$muteNotification = true;
					}else{
						$muteNotification = false;
					}
					
					$userStatus = $this->getUserStatus($loginedUser, $friendId, '1');
					$key 			= $this->getChatKey('1', $friendId);

					if( $friendStatus == '1' ){
						$filterData =  array();
						$filterData['chatType'] 		= '1';
						$filterData['senderId'] 		= $friendId;
						$filterData['receiverId'] 		= $loginedUser;	
						$unreadCount = $this->guppyModel->getUnreadCount($filterData);
					}

					$guppyUsers[$key] = array(
						'chatId' 			=> $key,
						'muteNotification'	=> $muteNotification,
						'friendStatus' 		=> $friendStatus,
						'userName' 	   		=> $userName,
						'userAvatar' 		=> $userAvatar,
						'blockedId' 		=> $userStatus['blockedId'],
						'isOnline' 			=> $userStatus['isOnline'],
						'isBlocked' 		=> $userStatus['isBlocked'],
						'UnreadCount'		=> intval( $unreadCount ),
					);
				}
			}
			$json['type'] 		= 'success'; 
			$json['contacts']  	= (Object)$guppyUsers;
			
			return new WP_REST_Response($json , 200);
		}

		/**
		 * Get user status
		 *
		 * @since    1.0.0
		*/
		public function getUserStatus($loginedUser=0, $userId=0, $chatType = false){
			$isOnline = $isBlocked = $blockedId = $blockerId = false;
			$userType = '0';
			if(get_userdata($loginedUser)){
				$userType = '1';
				$isOnline 		= wpguppy_UserOnline($userId);
				if(!empty($userId) && $chatType == '1'){
					$fetchResults 	= $this->guppyModel->getGuppyFriend($userId,$loginedUser,false);
					if(!empty($fetchResults) && $fetchResults['friend_status']=='3'){
						$isBlocked = true;
						$blockedId = $fetchResults['send_by'];
						$blockerId = $fetchResults['send_to'];
					}
				}
			}
			return array(
				'isOnline' 	=> $isOnline,
				'isBlocked' => $isBlocked,
				'blockedId' => $blockedId,
				'blockerId' => $blockerId,
				'userType' 	=> $userType,
			);
		}

		/**
		 * Load user messages
		 *
		 * @since    1.0.0
		*/
		public function getUserMessageslist($data){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$guppyMessageList  = $json  = array();
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$offset 		= !empty($params['offset']) ? intval($params['offset']) : 0; 
			$searchQuery 	= !empty($params['search']) ? wp_strip_all_tags($params['search']) : '';
			$loginedUser 	= !empty($params['userId']) ? intval($params['userId']) : 0;
			$chatType 		= !empty($params['chatType']) ? ($params['chatType']) : '1';
			$fetchResults   = $this->guppyModel->getUserMessageslist($loginedUser, $this->showRec, $offset, $searchQuery, $chatType);
			if(!empty($fetchResults)){
				foreach($fetchResults as $result){

					$messageData = array();
					if($result['sender_id'] != $loginedUser){
						$receiverId = $result['sender_id'];
					}else{
						$receiverId = $result['receiver_id']; 
					}
					$isSender = true;
					if($result['sender_id'] != $loginedUser){
						$isSender= false; 
					}
					$message 						= $result['message'];
					$messageType 					= $result['message_type'];
					$timestamp 						= $result['timestamp'];
					$clearChat 						= false;
					$unreadCount					= 0;
					$filterData =  array();
					$filterData['chatType'] = $result['chat_type'];
					$userData 	= $this->getUserInfo('1', $receiverId);
					
					$userStatus = $this->getUserStatus($loginedUser, $receiverId, '1');
					$messageData['blockedId'] 		= $userStatus['blockedId'];
					$messageData['isOnline'] 		= $userStatus['isOnline'];
					$messageData['isBlocked'] 		= $userStatus['isBlocked'];
					$messageData['userAvatar']		= $userData['userAvatar'];	
					$messageData['userName'] 		= $userData['userName'];
					$filterData['senderId'] 		= $receiverId;
					$filterData['receiverId'] 		= $loginedUser;	
					
					$unreadCount = $this->guppyModel->getUnreadCount($filterData);
					if($result['message_status'] == 2 ){
						$message = '';
					}
					
					// check chat is cleard or not
					$chatClearTime  = '';
					$filterData = array();
					$filterData['actionBy'] 	= $loginedUser;
					$filterData['userId'] 		= $receiverId;
					$chatType = 1;
					$filterData['actionType'] 	= '0';
					$filterData['chatType']     = $chatType;

					$chatActions = $this->getGuppyChatAction($filterData);
					if(!empty($chatActions)){
						$chatClearTime = $chatActions['chatClearTime'];
					}

					$chatNotify = array();
					$chatNotify['actionBy'] 	= $loginedUser;
					$chatNotify['actionType'] 	= '2';
					$chatNotify['userId'] 		= $receiverId;
					$chatNotify['chatType'] 	= $chatType;

					$muteNotification = $this->getGuppyChatAction($chatNotify);
					if(!empty($muteNotification)){
						$muteNotification = true;
					}else{
						$muteNotification = false;
					}
					if(!empty($chatClearTime) && strtotime($chatClearTime) > strtotime($result['message_sent_time'])){
						$clearChat 	= true;
						$message 	= '';
					}

					$chatId = $receiverId;
					if($message!=''){
						if($messageType == 4){
							$message = is_serialized($message) ? unserialize($message) : $message;
						}else{
							$message = html_entity_decode( stripslashes($message),ENT_QUOTES );
						}
					}
					$key 								= $this->getChatKey($result['chat_type'], $chatId);
					$messageData['chatId']				= $key;
					$messageData['isSender'] 			= $isSender;
					$messageData['message'] 	   		= $message;
					$messageData['messageType'] 		= $messageType;
					$messageData['clearChat'] 			= $clearChat;
					$messageData['messageStatus'] 		= $result['message_status'];
					$messageData['chatType'] 			= intval($result['chat_type']);
					$messageData['UnreadCount'] 		= intval( $unreadCount );
					$messageData['timeStamp'] 			= $timestamp;
					$messageData['muteNotification']	= $muteNotification;
					$messageData['messageId']			= Intval($result['id']);
					$guppyMessageList[$key] 			= $messageData;
				}
			}
			
			$json['type'] 				= 'success';
			$json['guppyMessageList']   = (Object)$guppyMessageList;
			return new WP_REST_Response($json , 200);		 
		}

		/**
		 * get user chat
		 *
		 * @since    1.0.0
		*/

		public  function getGuppyChat($data){
			
			$headers    	= $data->get_headers();
			$params     	= ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$chatMessages  	= $json  = $memberInfo = $filterData = array();
			$memberBlocked  = $userDisableReply = false;
			
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}

			$offset 		= !empty($params['offset']) 	? intval($params['offset']) 	: 0; 
			$receiverId 	= !empty($params['receiverId']) ? $params['receiverId'] : 0;
			$chatType 		= !empty($params['chatType']) 	? $params['chatType'] 	: 0;
			$loginedUser 	= !empty($params['userId']) 	? $params['userId'] 	: 0;
			$userType 		= isset($params['userType']) 	? $params['userType'] 			: 1;
			$filterData = array();
			$filterData['actionBy'] 	= $loginedUser;
			$filterData['chatType'] 	= $chatType;
			$filterData['userId'] 		= $receiverId;
			
			// add filter to check clear chat 
			$filterData['actionType'] 	= '0';
			$chatActions = $this->getGuppyChatAction($filterData);
			if(!empty($chatActions)){
				$chatClearTime = $chatActions['chatClearTime'];
				$filterData['chatClearTime'] = $chatClearTime;
			}
			// add filter for  pagination
			$filterData['limit'] 		= $this->showRec;
			$filterData['offset'] 		= $offset;
			$filterData['userType'] 	= 1;

			$fetchResults = $this->guppyModel->getGuppyChat($filterData);
			
			$isRegistered = get_userdata($receiverId);
			
			if(!empty($fetchResults)){
				
				$userName = $userAvatar  = '';
				$userData 	= $this->guppyModel->getUserInfo($isRegistered ? 1 : 0, $receiverId);
				if(!empty($userData)){
					$userName 	= $userData['userName'];
					$userAvatar = $userData['userAvatar'];
				}

				foreach($fetchResults as $result){
					$message =  '';
					$messageData = $attachmentsData = array();
					$isSender = true;
					
					if($result['chat_type'] == 3){

						if($result['sp_sender_id'] != $loginedUser){
							$senderId = $result['sp_sender_id'];
							$isSender= false; 
						}else{
							$senderId = $result['sp_rec_id'];
						}

					}else{

						if($result['sender_id'] != $loginedUser){
							$senderId = $result['sender_id'];
							$isSender= false; 
						}else{
							$senderId = $result['receiver_id'];
						}
					}

					$messageData['messageId'] 	= $result['id'];
					$messageData['isSender'] 	= $isSender;
					$messageData['userAvatar'] 	= $userAvatar;
					$messageData['userName'] 	= $userName;

					if($result['message_type'] == '4'){
						$message = is_serialized($result['message']) ? unserialize($result['message']) : $result['message'];
					}else{
						$message = html_entity_decode( stripslashes($result['message']),ENT_QUOTES );
					}
					
					$messageData['message'] 			= ($result['message_status'] !='2' ? $message : false);
					$messageData['attachmentsData'] 	= $attachmentsData;
					$messageData['replyMessage'] 		= !empty($result['reply_message']) ? unserialize($result['reply_message']) : NULL;
					$messageData['chatType'] 			= $result['chat_type'];
					$messageData['messageType'] 		= $result['message_type'];
					$messageData['messageStatus'] 		= $result['message_status'];
					$messageData['timeStamp'] 			= $result['timestamp'];

					$chatMessages[] = $messageData;
				}
			}

			if($offset == '0'){
				$filterData['actionType'] 	= '2';
				$muteNotification = $this->getGuppyChatAction($filterData);
				
				if(!empty($muteNotification)){
					$json['muteNotfication'] = true;
				}else{
					$json['muteNotfication'] = false;
				}
			}

			if($chatType == '1'){
				$chatId = $receiverId;
				$userStatus = $this->getUserStatus($loginedUser, $chatId, '1');
				$json['isOnline'] 		= $userStatus['isOnline'];
				$json['isBlocked'] 		= $userStatus['isBlocked'];
				$json['blockedId'] 		= $userStatus['blockedId'];
				$json['userType']   	= 1;
				$chatId = $this->guppyModel->getChatKey('1', $chatId);
			}elseif( $chatType == '3' ){
				$chatId = $receiverId;
				$chatId = $this->guppyModel->getChatKey('3', $chatId);
				$json['userType']   	= $userType;
				$json['isOnline'] 		= wpguppy_UserOnline($chatId);
			}
			$json['type'] 				= 'success';
			$json['chatId']   			= $chatId;
			$json['chatType']   		= $chatType;
			$json['chatMessages']   	= $chatMessages;
			return new WP_REST_Response($json , 200);
		}
		

		/**
		 * get Chat Actions 
		 *
		 * @since    1.0.0
		*/
		public function getGuppyChatAction($filterData){
			
			$result = array();
			
			$where 	= "action_by='".$filterData['actionBy']."'"; 
			if(is_array($filterData['actionType'])){
				$actionType = implode(',', $filterData['actionType']);
				$where .= " AND action_type IN(".$actionType.")";
			}else{
				$where .= " AND action_type=".$filterData['actionType'];
			}
			if(!empty($filterData['userId']) && ($filterData['chatType'] == '1' || $filterData['chatType'] == '3')){
				$where .= " AND corresponding_id='". $filterData['userId']."'";
				$where .= " AND chat_type=". $filterData['chatType'];
			}
			if(!empty($filterData['orderBy'])){	
				$where .= " ORDER BY ". $filterData['orderBy']." DESC";
			}
			$chatActions = $this->guppyModel->getData('*','wpguppy_chat_action',$where );
			
			if(!empty($chatActions)){
				if($filterData['actionType']=='0'){
					$result = array(
						'chatActionId' 				=> $chatActions[0]['id'],
						'chatActionType' 			=> $chatActions[0]['action_type'],
						'chatClearTime' 			=> $chatActions[0]['action_time']
					);
				}elseif($filterData['actionType']=='1' || $filterData['actionType']=='2'){
					$result = array(
						'chatActionId' 				=> $chatActions[0]['id'],
						'chatActionType' 			=> $chatActions[0]['action_type'],
						'muteActionTime' 			=> $chatActions[0]['action_time']
					);
				} elseif(is_array($filterData['actionType']) 
					&& (in_array('3', $filterData['actionType']) || in_array('4', $filterData['actionType']))){
					$result = $chatActions;
				}
			}
			return $result;
		}

		/**
		 * send message
		 *
		 * @since    1.0.0
		*/

		public  function sendMessage($data){
			$headers    	= $data->get_headers();
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$files     		= !empty($data->get_file_params()) ? $data->get_file_params() 	: '';

			$authToken  	= ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$messageData 	= $attachmentData = $userChat = $replyMessage = $json  = array();
			$verifyMember 	= false;
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}

			$receiverId 		= !empty($params['receiverId']) 	? $params['receiverId'] 	: 0; 
			$groupId 			= !empty($params['groupId']) 		? intval($params['groupId']) 		: 0;
			$postId 			= !empty($params['postId']) 		? intval($params['postId']) 		: 0;
			$chatType 			= !empty($params['chatType']) 		? intval($params['chatType']) 		: 0;
			$messageType 		= !empty($params['messageType']) 	? intval($params['messageType']) 	: 0;
			$message 			= !empty($params['message']) 		? $params['message'] 				: '';
			$replyId 			= !empty($params['replyId']) 		? intval($params['replyId']) 		: 0;
			$latitude 			= !empty($params['latitude']) 		? $params['latitude'] 				: 0;
			$longitude 			= !empty($params['longitude']) 		? $params['longitude'] 				: 0;
			$loginedUser 		= !empty($params['userId']) 		? $params['userId'] 		: 0; 
			$userType 			= isset($params['userType']) 		? $params['userType'] 				: 1; 
			
			if($chatType == '1'){
				$where 		 	= " (send_by =". $loginedUser." AND send_to =". $receiverId.") OR( send_by =". $receiverId." AND send_to =". $loginedUser." ) AND friend_status='1'"; 
				$verifyMember 	= $this->guppyModel->getData('id', 'wpguppy_friend_list', $where );
			}elseif($chatType == '3'){

				$isSupportMember = get_user_meta($receiverId, 'is_guppy_admin', true);
				if(!empty($isSupportMember)) {
					$verifyMember = true;
				}else{
					$isSupportMember = get_user_meta($loginedUser, 'is_guppy_admin', true);
					if(!empty($isSupportMember)){
						$verifyMember = true;
					}
				}
			}
			
			if(!$verifyMember){
				$message   				= esc_html__('You are not allowed to perform this action!', 'wpguppy-lite');
				$json['type'] 			= 'error';
				$json['message_desc']   = $message; 
				return new WP_REST_Response($json , 203);
			}
			
			$isOnline = false;
			$isRegistered = get_userdata($loginedUser);
			if(!empty($isRegistered)){
				if( $chatType == '1'
					|| $chatType == '3' ){
					$isOnline = wpguppy_UserOnline($loginedUser);
				}
			}
			if($messageType == '0'){
				$message = !empty($message) ? wp_strip_all_tags($message) : '';
			}

			// get message detail if reply message 
			if( !empty($replyId) ){
				$where 	= "id=". $replyId; 
				$messageDetail = $this->guppyModel->getData('message,message_type,chat_type,attachments','wpguppy_message', $where );
				if(!empty($messageDetail)){
					$messageDetail = $messageDetail[0];
					$replyMessage['messageId'] 		= $replyId;
					$replyMessage['messageType'] 	= $messageDetail['message_type'];
					$replyMessage['message'] 		= $messageDetail['message'];
					$replyMessage['chatType'] 		= $messageDetail['chat_type'];
					$replyMessage['attachmentsData'] = !empty($messageDetail['attachments']) ? unserialize($messageDetail['attachments']) : '';
				}
			}

			$messageData['user_type'] 	= 1;

			if( $chatType == '1'){

				$messageData['sender_id'] 		= $loginedUser; 
				$messageData['receiver_id'] 	= $receiverId; 

			}elseif( $chatType == '3'){
				
				$messageData['sender_id'] 		= 0;
				$messageData['receiver_id'] 	= 0;
				$messageData['sp_sender_id'] 	= $loginedUser;
				$messageData['sp_rec_id'] 		= $receiverId;
				
				$isSupportMember = get_user_meta($receiverId, 'is_guppy_admin', true);
				
				if(!empty($isSupportMember) && $isSupportMember == 1){
					$messageData['sp_member_id'] 		= $receiverId;
				}else{
					$isSupportMember = get_user_meta($loginedUser, 'is_guppy_admin', true);
					if(!empty($isSupportMember) && $isSupportMember == 1){
						$messageData['sp_member_id'] 		= $loginedUser;
					}
				}
			}

			$messageData['message'] 			= $message; 
			$messageData['chat_type'] 			= $chatType; 
			$messageData['message_type'] 		= $messageType; 
			$messageData['reply_message'] 		= !empty($replyMessage) ? serialize($replyMessage) : NULL; 
			$messageData['timestamp'] 			= strtotime(date('Y-m-d H:i:s')); 
			$messageData['message_sent_time'] 	= date('Y-m-d H:i:s'); 
			
			$response = $this->guppyModel->insertData('wpguppy_message', $messageData);

			if($response){

				$recIsRegistered = get_userdata($receiverId);

				$messagelistData = $filterData = $chatNotify = $conversationList =  array();

				$filterData['senderId'] 	= $loginedUser;
				$filterData['chatType'] 	= $chatType;

				// get sender user info 
				$senderUserName = $senderUserAvatar = '';
				$senderUserData 	= $this->guppyModel->getUserInfo($isRegistered ? 1 : 0, $loginedUser);
				if(!empty($senderUserData)){
					$senderUserName 	= $senderUserData['userName'];
					$senderUserAvatar 	= $senderUserData['userAvatar'];
				}	
				
				// get receiver user info 
				$receiverUserName = $receiverUserAvatar = '';
				$receiverUserData 			= $this->guppyModel->getUserInfo($recIsRegistered ? 1 : 0, $receiverId);
				if(!empty($receiverUserData)){
					$receiverUserName 			= $receiverUserData['userName'];
					$receiverUserAvatar 		= $receiverUserData['userAvatar'];
				}

				$messagelistData['messageId'] 			= $response;	
				$messagelistData['message'] 			= $message;	
				$messagelistData['timeStamp'] 			= $messageData['timestamp'];	
				$messagelistData['messageType'] 		= $messageType;
				$messagelistData['chatType'] 			= $chatType;
				$messagelistData['isSender'] 			= false;
				$messagelistData['messageStatus'] 		= '0';
				$messagelistData['userName'] 			= $senderUserName;
				$messagelistData['userAvatar'] 			= $senderUserAvatar;
				
				if(!empty($attachmentData)){
					$attachmentCounter = 1;
					foreach($attachmentData['attachments'] as &$single){
						$single['messageId'] = $response.'_'.$attachmentCounter++;
					}	
				}

				$chatData = array(
					'chatType' 				=> $chatType,
					'messageId' 			=> $response,	
					'message' 				=> $message,	
					'timeStamp' 			=> $messageData['timestamp'],	
					'messageType' 			=> $messageType,
					'messageStatus' 		=> '0',	
					'attachmentsData' 		=> $attachmentData,	
					'replyMessage' 			=> !empty($replyMessage) ? $replyMessage : NULL,	
					'isOnline' 				=> $isOnline,	
					'metaData'				=> !empty($params['metaData']) ? $params['metaData'] : false,
					'userName'				=> $senderUserName,
					'userAvatar'			=> $senderUserAvatar,
				);

				if(!empty($receiverId) && ($chatType == '1' || $chatType == '3')){
					
					$chatId = $this->guppyModel->getChatKey($chatType, $receiverId);

					$filterData['receiverId'] 	= $receiverId;
					$chatNotify['actionBy'] 	= $receiverId;
					$chatNotify['userId'] 		= $loginedUser;
					$chatNotify['actionType'] 	= '2';
					$chatNotify['chatType'] 	= $chatType;
					$chatData['chatId'] 		= $chatId;
					

					$getUnreadCount = $this->guppyModel->getUnreadCount($filterData);
					
					// check notification sound
					$muteNotification = $this->getGuppyChatAction($chatNotify);
					if(!empty($muteNotification)){
						$muteNotification = true;
					}else{
						$muteNotification = false;
					}

					$chatId = $this->guppyModel->getChatKey($chatType, $loginedUser);

					$isOnline = false;
					$isRegistered = get_userdata($receiverId);
					if(!empty($isRegistered)){
						if(  $chatType == '1' || $chatType == '3' ){
							$isOnline = wpguppy_UserOnline($receiverId);
						}
					}
					$messagelistData['chatId']				= $chatId;
					$messagelistData['blockedId'] 			= false;
					$messagelistData['isBlocked'] 			= false;
					$messagelistData['isOnline'] 			= $isRegistered ?  $isOnline: false;
					$messagelistData['UnreadCount'] 		= $getUnreadCount;
					$messagelistData['muteNotification'] 	= $muteNotification;

					if($chatType == 3){
						$messagelistData['isSupportMember'] 	= true;
					}

					$json['messagelistData'] 				= $messagelistData;
					
				}
				
				if($this->pusher){
					if( $chatType == '1' || $chatType == '3' ){
						
						$chatId = $this->guppyModel->getChatKey($chatType, $loginedUser);
						$batchRequests = array();
						// send to receiver
						$pusherData = array(
							'chatId' 			=> $chatId,
							'chatData'			=> $chatData,
							'chatType'			=> $chatType,
							'messagelistData' 	=> $messagelistData
						);
						$batchRequests[] = array(
							'channel' 	=> 'private-user-' . $receiverId,
							'name' 		=> 'recChatData',
							'data'		=> $pusherData,
						);

						// send to sender
						$chatNotify['actionBy'] 	= $loginedUser;
						$chatNotify['userId'] 		= $receiverId;
						$chatNotify['actionType'] 	= '2';
						$chatNotify['chatType'] 	= $chatType;
						// check notification sound
						$muteNotification = $this->getGuppyChatAction($chatNotify);
						if(!empty($muteNotification)){
							$muteNotification = true;
						}else{
							$muteNotification = false;
						}

						$isOnline 								= wpguppy_UserOnline($receiverId);
						$chatId 								= $this->guppyModel->getChatKey($chatType, $receiverId);
						$messagelistData['isOnline'] 			= $isOnline;
						$chatData['isSender'] 					= true;
						$messagelistData['isSender'] 			= true;
						$messagelistData['userName'] 			= $receiverUserName;
						$messagelistData['userAvatar'] 			= $receiverUserAvatar;
						$messagelistData['UnreadCount'] 		= 0;
						$messagelistData['chatId']				= $chatId;
						$messagelistData['muteNotification']	= $muteNotification;
						$pusherData = array(
							'chatId' 			=> $chatId,
							'chatType'			=> $chatType,
							'chatData'			=> $chatData,
							'messagelistData' 	=> $messagelistData,
						);
						
						$batchRequests[] = array(
							'channel' 	=> 'private-user-' . $loginedUser,
							'name' 		=> 'senderChatData',
							'data'		=> $pusherData,
						);
						$this->pusher->triggerBatch($batchRequests);
						
					}
				}

				//Message sent for themes comptibility
				do_action('wpguppy_on_message_sent', $chatData, $chatType, $loginedUser, $receiverId);
				
				$json['type'] 				= 'success';
				$json['chatData'] 			= $chatData;
				$json['chatType'] 			= $chatType;
			}else{
				$json['type'] 				= 'error';
			}
			return new WP_REST_Response($json , 200);
		}
		/**
		 * get user info
		 *
		 * @since    1.0.0
		*/
		public function getUserInfo($userType,$userId){
			$userName = $userAvatar = '';
			
			$userAvatar 	= $this->guppyModel->getUserInfoData('avatar', $userId, array('width' => 150, 'height' => 150));
			$userName 		= $this->guppyModel->getUserInfoData('username', $userId, array());
			$where 		 	= "user_id=". $userId; 
			$userinfo 		= $this->guppyModel->getData('user_name,user_image','wpguppy_users',$where );
			if(!empty($userinfo)){
				$info 					= $userinfo[0];
				$userName 			= $info['user_name'];
				if(!empty($info['user_image'])){
					$userImage 			= unserialize($info['user_image']);
					$userAvatar 		= $userImage['attachments'][0]['thumbnail'];
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
		 * upload attachments
		 *
		 * @since    1.0.0
		*/
		public function uploadAttachments($type, $files, $params){
			
			$upload 		= wp_upload_dir();
			$upload_dir 	= $upload['path'].'/';
			$attachmentType = '';
			$upload_attachments_dir = 'wpmedia';
			$attachmentData = $attachments = array();
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			foreach($files as $file){
				$name 		= sanitize_file_name($file["name"]);
				//file type check
				$filetype 			= wp_check_filetype($file['name']);
				$not_allowed_types	= array('php','javascript','js','exe','text/javascript','html');
				$file_ext			= !empty($filetype['ext']) ? $filetype['ext'] : '';
				
				if(empty($file_ext) || in_array($file_ext,$not_allowed_types)){
					$json['type'] = 'error';
					$json['message_desc']   = esc_html__('These file types are not allowed!', 'wpguppy-lite');
					return new WP_REST_Response($json , 203);
				}
				$i = 0;
				$parts = pathinfo($name);
				while (file_exists($upload_dir . $name)) {
					$i++;
					$name = $parts["filename"] . "-" . $i . "." . $parts["extension"];
				}
				$attachmentType = 'images';
				$size       	= $file['size'];
				$file_size  	= size_format($size, 2);

				//move file
				$newFile = $upload_dir .$name;
				$is_moved = move_uploaded_file($file["tmp_name"], $newFile);
				
				if($is_moved){
					$filename = basename($newFile);
					$attach_id = 0;
					$thumbnail = '';
					$file = $upload['url'] .'/'. sanitize_file_name($filename);
					
					$attachment = array(
						'post_mime_type' 	=> $filetype['type'],
						'post_title' 		=> sanitize_file_name($filename),
						'post_content' 		=> '',
						'post_status' 		=> 'inherit'
					);
					$attach_id 		= wp_insert_attachment($attachment, $newFile);
					
					if($attachmentType =='images'){
						$attach_data 	= wp_generate_attachment_metadata($attach_id, $newFile);
						wp_update_attachment_metadata($attach_id, $attach_data);
						$thumbnail 		= !empty($attach_data['sizes']['thumbnail']['file']) ? $upload['url'] . '/'. $attach_data['sizes']['thumbnail']['file'] : $upload['url'] . '/'. sanitize_file_name($filename);
						
					}
					$attachments[] = array(
						'attachmentId' 			=> $attach_id,
						'file' 					=> $file,
						'fileName'				=> sanitize_file_name($filename),
						'thumbnail' 			=> $thumbnail,
						'fileSize' 				=> esc_attr($file_size),
						'fileType' 				=> esc_attr($filetype['ext']),
					);

				}
			}
			if(!empty($attachments)){
				$attachmentData = array(
					'saveTo' 			=> $upload_attachments_dir,
					'attachmentType' 	=> $attachmentType,
					'attachments' 		=> $attachments,
				);
			}
			return $attachmentData;
		}
	
		
		/**
		 * get messanger chat info
		 *
		 * @since    1.0.0
		*/
		public function messengerChatInfo($data){
			$headers    = $data->get_headers();
			$params     = ! empty($data->get_params()) 		? $data->get_params() 		: '';
			$authToken  = ! empty($headers['authorization'][0]) ? $headers['authorization'][0] : '';
			$chatInfo 	= $json  = array();
			$isBlocked 	= $blockerId = $blockedId = false;
			$response = $this->guppyAuthentication($params, $authToken);
			if(!empty($response) && $response['type']=='error'){
				return new WP_REST_Response($response , 203);
			}
			$loginedUser 	= !empty($params['userId']) 	? $params['userId'] : 0;
			$chatId 		= !empty($params['chatId']) 	? $params['chatId'] : '';
			$chatType 		= !empty($params['chatType']) 	? $params['chatType'] 	: 0;
			$userType 		= isset($params['userType']) 	? $params['userType'] 	: 1;
			$chatId 		= explode('_', $chatId);
			$verifyMember = false;
			if($chatType == 1){
				$receiverId = $chatId[0];
				$where 		 	= " (send_by =". $loginedUser." AND send_to =". $receiverId.") OR( send_by =". $receiverId." AND send_to =". $loginedUser." ) AND friend_status IN(1,3)"; 
				$verifyMember 	= $this->guppyModel->getData('id', 'wpguppy_friend_list', $where );
				if(!$verifyMember){
					$json['type'] = 'error';
					$json['message_desc']   = esc_html__('You are not allowed to perform this action!', 'wp-guppy');
					return new WP_REST_Response($json , 203);
				}
				$chatNotify = array();
				$chatNotify['userId'] 		= $receiverId;
				$chatNotify['actionBy'] 	= $loginedUser;
				$chatNotify['actionType'] 	= '2';
				$chatNotify['chatType'] 	= $chatType;
				$muteNotification = $this->getGuppyChatAction($chatNotify);
				if(!empty($muteNotification)){
					$muteNotification = true;
				}else{
					$muteNotification = false;
				}
				$userData 	= $this->guppyModel->getUserInfo(1, $receiverId);
				if(!empty($userData)){
					$userName 	= $userData['userName'];
					$userAvatar = $userData['userAvatar'];
				}
				$userStatus = $this->getUserStatus($loginedUser, $receiverId, '1');
				$chatInfo['isOnline']			= $userStatus['isOnline'];
				$chatInfo['isBlocked']			= $userStatus['isBlocked'];
				$chatInfo['blockedId']			= $userStatus['blockedId'];
				$chatInfo['blockerId']			= $userStatus['blockerId'];
				$chatInfo['userName']			= $userName;
				$chatInfo['userAvatar']			= $userAvatar;
				$chatInfo['chatId'] 			= $this->guppyModel->getChatKey('1',$receiverId);
				$chatInfo['chatType'] 			= '1';
				$chatInfo['muteNotification'] 	= $muteNotification;
			}elseif( $chatType == 3 ){
				
				$receiverId = "$chatId[0]";
				$isRegistered = get_userdata($receiverId);
				$userData 	= $this->guppyModel->getUserInfo(!empty($isRegistered) ? 1 : 0 , $receiverId);
				if(!empty($userData)){
					$userName 	= $userData['userName'];
					$userAvatar = $userData['userAvatar'];
				}

				$isSupportMember = false;
				$verifySupport = get_user_meta($receiverId, 'is_guppy_admin', true);
				if(!empty($verifySupport) && $verifySupport == 1){
					$isSupportMember = true;
				}else{
					$verifySupport = get_user_meta($loginedUser, 'is_guppy_admin', true);
					if(!empty($verifySupport) && $verifySupport == 1){
						$isSupportMember = true;
					}
				}
				
				$chatInfo['isOnline']			= wpguppy_UserOnline($receiverId);
				$chatInfo['isBlocked']			= false;
				$chatInfo['blockedId']			= false;
				$chatInfo['blockerId']			= false;
				$chatInfo['userName']			= $userName;
				$chatInfo['userAvatar']			= $userAvatar;
				$chatInfo['isSupportMember']	= $isSupportMember;
				
				$chatInfo['chatId'] 			= $this->guppyModel->getChatKey('3',$receiverId);
				$chatInfo['chatType'] 			= '3';
				$chatInfo['muteNotification'] 	= false;
			}
			$json['type'] 		= 'success';
			$json['chatInfo']   = $chatInfo;
			return new WP_REST_Response($json , 200);
		}

		/**
		 * Get Chat key
		 *
		 * @since    1.0.0
		*/
		public function getChatKey($chatType = '0', $chatId = 0){
			$chatKey = $chatId;
			if($chatType == '1'){
				$chatKey = $chatId.'_1';
			}
			return $chatKey;
		}

		/**
		 * send data to pusher
		 *
		 * @since    1.0.0
		*/
		public function pusherTypeIndicator( $data ) {
			$params     	= !empty($data->get_params()) 		? $data->get_params() 		: '';
			$loginedUser 	= !empty($params['userId']) 		? $params['userId'] 		: 0;
			$chatId 		= !empty($params['chatId']) 		? $params['chatId'] 		: '';
			$userType 		= isset($params['userType']) 		? $params['userType'] 		: 1;
			$text 			= !empty($params['text']) 			? $params['text'] 			: '';
			$userName 		= !empty($params['userName']) 		? $params['userName'] 		: '';
			$senderId 		= !empty($params['senderId']) 		? $params['senderId'] 		: 0;
			$chatType 		= isset($params['chatType']) 		? $params['chatType'] 		: ''; 

			if(!empty($chatId)){
				$pusherData = array(
					'chatId' 		=> $params['chatId'],
					'chatType'		=> $chatType,
					'text'			=> $text,
					'userName'		=> $userName,
					'senderId'		=> $senderId,
				);
				$chatId 		= explode('_', $chatId);
				if( $chatType == 1 || $chatType == 3 ){
					$receiverId = $chatId[0]; 
					
					if($chatType == 3){
						if($userType == 0 && !empty($_COOKIE['guppy_guest_account'])){
							$guestAcc 	= explode('|', ($_COOKIE['guppy_guest_account']));
							$pusherData['userName'] = $guestAcc[0];
						}
					}
					$this->pusher->trigger('private-user-'.$receiverId, 'isTyping', $pusherData);
				}
			}
			return new WP_REST_Response('ok' , 200);
		}
	}
}