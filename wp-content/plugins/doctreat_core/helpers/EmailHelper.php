<?php
/**
 * Email Helper For Theme
 * @since    1.0.0
 */
if (!class_exists('Doctreat_Email_helper')) {

    class Doctreat_Email_helper {

        public function __construct() {
            add_filter('wp_mail_content_type', array(&$this, 'doctreat_set_content_type'));
        }

        /**
         * Email Headers From
         * @since    1.0.0
         */
        public function doctreat_wp_mail_from($email) {
			global $theme_settings;			
			$email_from_id	= !empty( $theme_settings['email_from_id'] ) ? $theme_settings['email_from_id'] : 'info@no-reply.com';
            return $email_from_id;
        }

        /**
         * Email Headers From name
         * @since    1.0.0
         */
        public function doctreat_wp_mail_from_name($name) {
			global $theme_settings;
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$email_from_name	= !empty( $theme_settings['email_from_name'] ) ? $theme_settings['email_from_name'] : $blogname;
            return $email_from_name;

        }

        /**
         * Email Content type
         *
         *
         * @since    1.0.0
         */
        public function doctreat_set_content_type() {
            return "text/html";
        }

        /**
         * Get Email Header
         * Return email header html
         * @since    1.0.0
         */
        public function prepare_email_headers() {
            global $current_user,$theme_settings;
            ob_start();
            $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
            $email_banner = array();	
			
			$banner	= !empty( $theme_settings['email_banner']['url'] ) ? doctreat_add_http( $theme_settings['email_banner']['url']) : '';
			
            ?>
            <div style="min-width:100%;background-color:#f6f7f9;margin:0;width:100%;color:#283951;font-family:'Helvetica','Arial',sans-serif;padding: 60px 0;">
				<div style="background: #FFF;max-width: 600px; width: 100%; margin: 0 auto; overflow: hidden; color: #919191; font:400 16px/26px 'Open Sans', Arial, Helvetica, sans-serif;">
					<div style="width: 100%; float: left; padding: 30px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
						<strong style="float: left; padding: 0 0 0 30px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><a style="float: left; color: #55acee; text-decoration: none;" href="<?php echo esc_url(home_url('/')); ?>"><?php echo ( $this->process_get_logo() ); ?></a></strong>
					</div>
					<?php if (!empty($banner)) { ?>
						<div id="dc-banner" class="dc-banner" style="width: 100%; float: left; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><img style="width: 100%; height: auto; display: block;" src="<?php echo esc_url($banner); ?>" alt="<?php echo esc_attr($blogname); ?>"></div>
					<?php } ?>
					<div style="width: 100%; float: left; padding: 30px 30px 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
                    <?php
                    return ob_get_clean();
                }

		/**
		 * Get Email Footer
		 *
		 * Return email footer html
		 *
		 * @since    1.0.0
		 */
		public function prepare_email_footers($params = '') {
			global $current_user,$theme_settings;
			ob_start();
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$footer_bg_color	= !empty( $theme_settings['footer_bg_color'] ) ?  $theme_settings['footer_bg_color'] : '#ff5851';
			$footer_text_color	= !empty( $theme_settings['footer_text_color'] ) ?  $theme_settings['footer_text_color'] : '#fff';
			$email_copyrights	= !empty( $theme_settings['email_copyrights'] ) ?  $theme_settings['email_copyrights'] : esc_html__('Copyright', 'doctreat_core').'&nbsp;&copy;&nbsp;'. date('Y'). esc_html__(' | All Rights Reserved', 'doctreat_core'); 
			
			?>
					</div>
					<div style="width:100%;float:left;background: <?php echo esc_attr( $footer_bg_color );?>;padding: 30px 15px;text-align:center;box-sizing:border-box;border-radius: 0  0 5px 5px;">
						<p style="font-size: 13px; line-height: 13px; color: <?php echo esc_attr( $footer_text_color );?>; margin: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo do_shortcode($email_copyrights);?></p>
					</div>
				</div>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @Process Sender Information
		 * @since 1.0.0
		 * 
		 * @return {data}
		 */
		public function process_sender_information($params = '') {
			global $current_user;
			ob_start();
			$blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$tagline = wp_specialchars_decode(get_option('blogdescription'), ENT_QUOTES);

			$sender_avatar = array();
			
			global $theme_settings;			
			
			$avatar					= !empty( $theme_settings['email_sender_avatar']['url'] ) ? doctreat_add_http($theme_settings['email_sender_avatar']['url']) : '';
			$sender_name			= !empty( $theme_settings['email_sender_name'] ) ? $theme_settings['email_sender_name'] : $blogname;
			$sender_tagline			= !empty( $theme_settings['email_sender_tagline'] ) ? $theme_settings['email_sender_tagline'] : $tagline;
			$sender_url				= !empty( $theme_settings['email_sender_url'] ) ? $theme_settings['email_sender_url'] : '';
			
			?>
			<div style="width: 100%; float: left; padding: 15px 0 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
				<?php if (!empty($avatar)) { ?>
					<div style="float: left; border-radius: 5px; overflow: hidden; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
						<img style="display: block;" src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($blogname); ?>">
					</div>
				<?php } ?>
				<?php if (!empty($sender_name) || !empty($sender_tagline) || !empty($sender_url)) { ?>
					<div style="overflow: hidden; padding: 0 0 0 20px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;">
						<p style="margin: 0 0 7px; font-size: 14px; line-height: 14px; color: #919191; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php esc_html_e('Regards', 'doctreat_core'); ?></p>
						<?php if (!empty($sender_name)) { ?>
							<h2 style="font-size: 18px; line-height: 18px; margin: 0 0 5px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; color: #333; font-weight: normal;font-family: 'Work Sans', Arial, Helvetica, sans-serif;"><?php echo esc_attr($sender_name); ?></h2>
						<?php } ?>
						<?php if (!empty($sender_tagline)) { ?>
							<p style="margin: 0 0 7px; font-size: 14px; line-height: 14px; color: #919191; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><?php echo esc_attr($sender_tagline); ?></p>
						<?php } ?>
						<?php if (!empty($sender_url)) { ?>
							<p style="margin: 0; font-size: 14px; line-height: 14px; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;"><a style=" color: #55acee; text-decoration: none;" href="<?php echo esc_url($sender_url); ?>"><?php echo esc_url($sender_url); ?></a></p>
							<?php } ?>
					</div>
				<?php } ?>
			</div>
			<?php
			return ob_get_clean();
		}

		/**
		 * @Registration
		 *
		 * @since 1.0.0
		 */
		public function process_get_logo($params = '') {
			//Get Logo
			global $theme_settings;			
			
			$logo		= !empty( $theme_settings['email_logo']['url'] ) ? doctreat_add_http($theme_settings['email_logo']['url']) : doctreat_add_http(get_template_directory_uri() . '/images/logo.png');
			$email_logo_width		= !empty( $theme_settings['email_logo_width'] ) ? $theme_settings['email_logo_width'] : 100;
			
			return '<img style="max-width:'.$email_logo_width.'px;" src="' . esc_url($logo) . '" alt="' . esc_html__('email-header', 'doctreat_core') . '" />';
			
		}

	}

	new Doctreat_Email_helper();
}