<?php
/**
 * Email Helper To Send Email
 * @since    1.0.0
 */
if (!class_exists('DoctreatForum')) {

    class DoctreatForum extends Doctreat_Email_helper{

        public function __construct() {
			//do stuff here
        }	

		/**
		 * @Send hospital request
		 *
		 * @since 1.0.0
		 */
		public function send($params = '') {
			global $theme_settings;
			extract($params);
			$email_to 			= $email;
			$subject_default 	= esc_html__('New question posted', 'doctreat_core');
			$contact_default 	= esc_html__('Hello,
									A new question has been posted and needs an approval.
									%signature%', 'doctreat_core');
			
			$subject		= !empty( $theme_settings['question_posted'] ) ? $theme_settings['question_posted'] : $subject_default;
			$email_content	= !empty( $theme_settings['question_posted_content'] ) ? $theme_settings['question_posted_content'] : $contact_default;
			$email_to		= !empty( $theme_settings['question_posted_admin'] ) ? $theme_settings['question_posted_admin'] : get_option('admin_email', 'info@example.com');
			
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%signature%", $sender_info, $email_content);
			$email_content = str_replace("%question%", $question, $email_content);
			$email_content = str_replace("%category%", $category, $email_content);
			$email_content = str_replace("%description%", $description, $email_content);
			$email_content = str_replace("%name%", $name, $email_content);

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
}