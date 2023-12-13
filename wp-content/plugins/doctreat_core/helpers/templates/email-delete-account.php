<?php
/**
 * Email Helper To Delete Account
 * @since    1.0.0
 */
if (!class_exists('DoctreatDeleteAccount')) {

    class DoctreatDeleteAccount extends Doctreat_Email_helper{

        public function __construct() {
			//do stuff here
        }

		/**
		 * @Send report user email
		 *
		 * @since 1.0.0
		 */
		public function send($params = '') {
			global $theme_settings;
			extract($params);
			$subject_default = esc_html__('Account Deleted', 'doctreat_core');
			$email_default = 'Hi,<br/>

								An existing user has deleted the account due to the following reason: 
								<br/>
								%reason%
								<br/><br/>
								%signature%,<br/>';
			$subject			= !empty( $theme_settings['remove_account_subject'] ) ? $theme_settings['remove_account_subject'] : $subject_default;
			$email_content		= !empty( $theme_settings['remove_account_content'] ) ? $theme_settings['remove_account_content'] : $subject_default;
			$email_to			= !empty( $theme_settings['remove_account_email'] ) ? $theme_settings['remove_account_email'] :  get_option('admin_email', 'somename@example.com');
			
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%name%", $username, $email_content); 
			$email_content = str_replace("%message%", $description, $email_content); 
			$email_content = str_replace("%reason%", $reason, $email_content); 
			$email_content = str_replace("%email%", $email, $email_content); 
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

	new DoctreatDeleteAccount();
}