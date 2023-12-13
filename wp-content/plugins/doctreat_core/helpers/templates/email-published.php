<?php
/**
 * Email Helper To Send Email
 * @since    1.0.0
 */
if (!class_exists('Doctreat_Published')) {

    class Doctreat_Published extends Doctreat_Email_helper{

        public function __construct() {
			//do stuff here
        }

		/**
		 * @Approve freelancer & Employer Profiles
		 *
		 * @since 1.0.0
		 */
		public function publish_approve_user_acount($params = '') {
			global $theme_settings;
			extract($params);
			$subject_default = esc_html__('Account Approved!', 'doctreat_core');
			$email_default   = 'Hello %name%<br/>
							Your account has been approved. You can now login to setup your profile.
							
							<a href="%site_url%">Login Now</a>

							%signature%';

			$subject		= !empty( $theme_settings['approve_account_subject'] ) ? $theme_settings['approve_account_subject'] : $subject_default;
			$email_content	= !empty( $theme_settings['approve_account_content'] ) ? $theme_settings['approve_account_content'] : $email_default;                     

			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%site_url%", $site_url, $email_content); 
			$email_content = str_replace("%name%", $name, $email_content); 
			$email_content = str_replace("%signature%", $sender_info, $email_content);

			$body = '';
			$body .= $this->prepare_email_headers();

			$body .= '<div style="width: 100%; float: left; padding: 0 0 60px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">';
			$body .= '<div style="width: 100%; float: left;">';
			$body .= wpautop( $email_content );
			$body .= '</div>';
			$body .= '</div>';

            $body 		.= $this->prepare_email_footers();
			wp_mail($email_to, $subject, $body);
		}
	}

	new Doctreat_Published();
}