<?php
/**
 * Email Helper To Send Email
 * @since    1.0.0
 */
if (!class_exists('DoctreatRegisterNotify')) {

    class DoctreatRegisterNotify extends Doctreat_Email_helper{

        public function __construct() {
			//do stuff here
        }
		
		/**
		 * @Send User to approved
		 *
		 * @since 1.0.0
		 */
		public function send_approved_user_email($params = '') {
			
			global $theme_settings;
			extract($params);
			$email_to 			= $email;
			$subject_default 	= esc_html__('Your account is approved', 'doctreat_core');
			$contact_default 	= 'Hello %username%!<br/>
									Your account has been approved by the admin. You can now login and check your dashboard<br/>
									%signature%';
			
			$subject		= !empty( $theme_settings['approved_user_subject'] ) ? $theme_settings['approved_user_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['approved_user_content'] ) ? $theme_settings['approved_user_content'] : $contact_default;
			                      

			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%username%", $username, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content); 
			$email_content = str_replace("%site%", $site, $email_content);  
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
		}

		/**
		 * @Send welcome doctor email
		 *
		 * @since 1.0.0
		 */
		public function send_doctor_email($params = '') {
			
			global $theme_settings;
			extract($params);
			$email_to 			= $email;
			$subject_default 	= esc_html__('Thank you for registering', 'doctreat_core');
			$contact_default 	= 'Hello %name%!<br/>

									Thanks for registering at %site%. You can now login to manage your account using the following credentials:<br/>
									Email: %email%<br/>
									Password: %password%<br/><br/>
									%signature%';
			
			$subject		= !empty( $theme_settings['doctor_registration_subject'] ) ? $theme_settings['doctor_registration_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['doctor_registration_content'] ) ? $theme_settings['doctor_registration_content'] : $contact_default;
			                      

			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $name, $email_content); 
			$email_content = str_replace("%password%", $password, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content); 
			$email_content = str_replace("%site%", $site, $email_content); 
			$email_content = str_replace("%verification_link%", $verification_link, $email_content);
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
		}
		
		/**
		 * @Send welcome hospital email
		 *
		 * @since 1.0.0
		 */
		public function send_hospital_email($params = '') {
			global $theme_settings;
			extract($params);
			$email_to 			= $email;
			$subject_default 	= esc_html__('Thank you for registering', 'doctreat_core');
			$contact_default 	= 'Hello %name%!<br/>

									Thanks for registering at %site%. You can now login to manage your account using the following credentials:<br/>
									Email: %email%<br/>
									Password: %password%<br/><br/>
									%signature%';
			
			$subject		= !empty( $theme_settings['hospital_registration_subject'] ) ? $theme_settings['hospital_registration_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['hospital_registration_content'] ) ? $theme_settings['hospital_registration_content'] : $contact_default;
			                     
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $name, $email_content); 
			$email_content = str_replace("%password%", $password, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content); 
			$email_content = str_replace("%site%", $site, $email_content); 
			$email_content = str_replace("%verification_link%", $verification_link, $email_content);
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
		}
		
		/**
		 * @Send welcome Patients email
		 *
		 * @since 1.0.0
		 */
		public function send_regular_user_email($params = '') {
			
			extract($params);
			global $theme_settings;
			$email_to 			= $email;
			$subject_default 	= esc_html__('Thank you for registering', 'doctreat_core');
			$contact_default 	= 'Hello %name%!<br/>

									Thanks for registering at %site%. You can now login to manage your account using the following credentials:<br/>
									Email: %email%<br/>
									Password: %password%<br/><br/>
									%signature%';
			
			$subject		= !empty( $theme_settings['regular_registration_subject'] ) ? $theme_settings['regular_registration_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['regular_registration_content'] ) ? $theme_settings['regular_registration_content'] : $contact_default;
			                     
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $name, $email_content); 
			$email_content = str_replace("%password%", $password, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content);
			$email_content = str_replace("%site%", $site, $email_content); 
			$email_content = str_replace("%verification_link%", $verification_link, $email_content);
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();
			
			wp_mail($email_to, $subject, $body);
		}
		
		/**
		 * @Send welcome Patients email
		 *
		 * @since 1.0.0
		 */
		public function send_seller_user_email($params = '') {
			
			extract($params);
			global $theme_settings;
			$email_to 			= $email;
			$subject_default 	= esc_html__('Thank you for registering', 'doctreat_core');
			$contact_default 	= 'Hello %name%!
									Thank you for the registeration on our %site%. You can now login to manage your account using the below details credentials:
									Email: %email%
									Password: %password%
									%signature%';
			
			$subject		= !empty( $theme_settings['seller_subject'] ) ? $theme_settings['seller_subject'] : $subject_default;
			$email_content	= !empty( $theme_settings['seller_content'] ) ? $theme_settings['seller_content'] : $contact_default;
			                     
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $name, $email_content); 
			$email_content = str_replace("%password%", $password, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content);
			$email_content = str_replace("%verification_link%", $verification_link, $email_content);
			$email_content = str_replace("%site%", $site, $email_content); 
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();
			
			wp_mail($email_to, $subject, $body);
		}
		
		/**
		 * @Send welcome admin email
		 *
		 * @since 1.0.0
		 */
		public function send_admin_email($params = '') {
			global $theme_settings;
			extract($params);
			$subject_default = esc_html__('New user registration', 'doctreat_core');
			$contact_default = 'Hello!<br/>
								A new user "%name%" with email address "%email%" has registered on your website. Please login to check user detail.
								<br/>
								%signature%';
			
			$email_to		= !empty( $theme_settings['admin_email'] ) ? $theme_settings['admin_email'] : get_option('admin_email', 'info@example.com');
			
			$subject		= !empty( $theme_settings['admin_register_subject'] ) ? $theme_settings['admin_register_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['admin_register_content'] ) ? $theme_settings['admin_register_content'] : $contact_default;
			

			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $name, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content); 
			$email_content = str_replace("%verification_link%", $verification_link, $email_content);
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

			$body .= $this->prepare_email_footers();	
			
			wp_mail($email_to, $subject, $body);
		}

		/**
		 * @Send verification email
		 *
		 * @since 1.0.0
		 */
		public function send_verification($params = '') {
			extract($params);
			global $theme_settings;
			$email_to = $email;
			
			$subject_default = esc_html__('Email Verification Link', 'doctreat_core');
			$contact_default = 'Hello %name%!<br/>

								Your account has created on %site%. Verification is required, To verify your account please use below link:<br> 
								Verification Link: %verification_link%<br/>

								%signature%';

			$subject		= !empty( $theme_settings['resend_subject'] ) ? $theme_settings['resend_subject'] : $subject_default;
			$email_content	= !empty( $theme_settings['resend_content'] ) ? $theme_settings['resend_content'] : $contact_default;
			                     
			
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $name, $email_content);
			
			if(!empty($password)){
				$email_content = str_replace("%password%", $password, $email_content);
			}
			
			$email_content = str_replace("%email%", $email, $email_content);
			$email_content = str_replace("%verification_link%", $verification_link, $email_content);
			$email_content = str_replace("%site%", $site, $email_content); 
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';
			$body .= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
		}		
		
	}

	new DoctreatRegisterNotify();
}