<?php
/**
 * Email Helper To Send Email
 * @since    1.0.0
 */
if (!class_exists('DoctreatArticleNotify')) {

    class DoctreatArticleNotify extends Doctreat_Email_helper{

        public function __construct() {
			//do stuff here
        }	
		
		
		
		/**
		 * @Send doctor email
		 *
		 * @since 1.0.0
		 */
		public function send_article_pending_email($params = '') {
			
			global $theme_settings;
			extract($params);
			$email_to 			= $email;
			$subject_default 	= esc_html__('Your Article is pending status', 'doctreat_core');
			$contact_default 	= wp_kses(__('Hello %doctor_name%<br/>

							Your article %article_title% has been received with pending status. <br/>
							%signature%,<br/>', 'doctreat_core'),array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'br' => array(),
										'em' => array(),
										'strong' => array(),
									));
			
			$subject		= !empty( $theme_settings['article_pending_subject'] ) ? $theme_settings['article_pending_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['article_pending_content'] ) ? $theme_settings['article_pending_content'] : $contact_default;

			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%doctor_name%", $doctor_name, $email_content); 
			$email_content = str_replace("%article_title%", $article_title, $email_content); 
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
		
		/**
		 * @Send doctor email
		 *
		 * @since 1.0.0
		 */
		public function send_admin_pending_email($params = '') {
			
			global $theme_settings;
			extract($params);
			$subject_default 	= esc_html__('%doctor_name% send article', 'doctreat_core');
			$contact_default 	= wp_kses(__('Hello !<br/>

							%doctor_name% send article %article_title% with pending status.<br/>
							%signature%,<br/>', 'doctreat_core'),array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'br' => array(),
										'em' => array(),
										'strong' => array(),
									));
			
			$subject		= !empty( $theme_settings['admin_article_pending_subject'] ) ? $theme_settings['admin_article_pending_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['admin_article_pending_content'] ) ? $theme_settings['admin_article_pending_content'] : $contact_default;
			
			$email_to		= !empty( $theme_settings['admin_email'] ) ? $theme_settings['admin_email'] : get_option('admin_email', 'info@example.com');
			
			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%doctor_name%", $doctor_name, $email_content); 
			$email_content = str_replace("%article_title%", $article_title, $email_content); 
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
		
		/**
		 * @Send doctor email
		 *
		 * @since 1.0.0
		 */
		public function send_article_publish_email($params = '') {
			
			global $theme_settings;
			extract($params);
			$email_to 			= $email;
			$subject_default 	= esc_html__('Your Article is publish status', 'doctreat_core');
			$contact_default 	= wp_kses(__('Hello %doctor_name%<br/>

							Your article %article_title% has been received with publish status. <br/>
							%signature%,<br/>', 'doctreat_core'),array(
										'a' => array(
											'href' => array(),
											'title' => array()
										),
										'br' => array(),
										'em' => array(),
										'strong' => array(),
									));
			
			$subject		= !empty( $theme_settings['article_publish_subject'] ) ? $theme_settings['article_publish_subject'] : $subject_default;
			
			$email_content	= !empty( $theme_settings['article_publish_content'] ) ? $theme_settings['article_publish_content'] : $contact_default;

			//Email Sender information
			$sender_info = $this->process_sender_information();
			
			$email_content = str_replace("%doctor_name%", $doctor_name, $email_content); 
			$email_content = str_replace("%article_title%", $article_title, $email_content); 
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

	new DoctreatArticleNotify();
}