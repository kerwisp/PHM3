<?php
/**
 * The get Contact information widgets functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    Doctreat
 * @subpackage Doctreat/admin
 */
 
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Doctreat_ContactInfo')) {

    class Doctreat_ContactInfo extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_contactinfo' , // Base ID
                    esc_html__('Contact information | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' 	=> 'dc-widget dc-widgetarticlesholder dc-copntactinfowidtget',
					'description' 	=> esc_html__('Contact information' , 'doctreat_core') , 
				) // Args
            );
        }

        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
        public function widget($args , $instance) {
            // outputs the content of the widget
			global $post;
			
            extract($instance);
						
			$logo_link	= !empty($instance['logo_link']) ? ($instance['logo_link']) : '';
            $logo_url 	= !empty($instance['logo_url']) ? ($instance['logo_url']) : '';
			
			$contact_detail		= !empty($instance['contact_detail'])  ? ($instance['contact_detail']) : '';
            $contact_address	= !empty($instance['contact_address']) ? ($instance['contact_address']) : '';
			$contact_email		= !empty($instance['contact_email']) ? sanitize_email($instance['contact_email']) : '';
			$contact_phone 		= !empty($instance['contact_phone']) ? ($instance['contact_phone']) : '';
			
			$facebook_url 		= !empty($instance['facebook_url']) ? esc_url($instance['facebook_url']) : '';
			$twitter_url 		= !empty($instance['twitter_url']) ? esc_url($instance['twitter_url']) : '';
			$google_url 		= !empty($instance['google_url']) ? esc_url($instance['google_url']) : '';
			$linkin_url 		= !empty($instance['linkin_url']) ? esc_url($instance['linkin_url']) : '';
			$youtube_url 		= !empty($instance['youtube_url']) ? esc_url($instance['youtube_url']) : '';
			$feeds_url 			= !empty($instance['feeds_url']) ? esc_url($instance['feeds_url']) : '';
			$instagram_url 		= !empty($instance['instagram_url']) ? esc_url($instance['instagram_url']) : '';
			 
            $before	= ($args['before_widget']);
			$after	 = ($args['after_widget']);
			
			echo ($before);
				?>
				<?php if( !empty( $logo_url ) ){?>
					<strong class="dc-logofooter"><a href="<?php echo esc_url($logo_link);?>"><img width="" height="" class="amsvglogo" src="<?php echo esc_url($logo_url);?>" alt="<?php esc_html_e('company logo here','doctreat_core');?>"></a></strong>
				<?php } ?>
				<div class="dc-footercontent">
					<?php if( !empty( $contact_detail ) ){?>
						<div class="dc-description">
							<p><?php echo do_shortcode(nl2br( $contact_detail ) );?></p>
						</div>
					<?php }?>
					<?php if( !empty( $contact_address ) || !empty( $contact_email ) || !empty( $contact_phone ) ){?>
						<ul class="dc-footercontactus">
							<?php if( !empty( $contact_address ) ) {?>
								<li><address><i class="lnr lnr-location"></i> <?php echo esc_attr($contact_address);?></address></li>
							<?php }?>
							<?php if( !empty( $contact_email ) ) {?>
								<li><a href="#"><i class="lnr lnr-envelope"></i> <?php echo sanitize_email($contact_email);?></a></li>
							<?php } ?>
							<?php if( !empty( $contact_phone ) ) {?>
								<li><span><i class="lnr lnr-phone-handset"></i> <?php echo esc_attr($contact_phone);?></span></li>
							<?php } ?>
						</ul>
					<?php } ?>
					<?php if( !empty( $facebook_url ) || !empty( $twitter_url ) || !empty( $google_url ) || !empty( $linkin_url )  || !empty( $feeds_url ) || !empty( $youtube_url ) || !empty($instagram_url) ){?>
						<div class="dc-fsocialicon">
							<ul class="dc-simplesocialicons">
								<?php if( !empty( $facebook_url )) { ?>
									<li class="dc-facebook"><a target="_blank" href="<?php echo esc_url($facebook_url);?>"><i class="fab fa-facebook-f"></i></a></li>
								<?php } ?>
								<?php if( !empty( $twitter_url )) { ?>
									<li class="dc-twitter"><a target="_blank" href="<?php echo esc_url($twitter_url);?>"><i class="fab fa-twitter"></i></a></li>
								<?php } ?>
								<?php if( !empty( $linkin_url )) { ?>
									<li class="dc-linkedin"><a target="_blank" href="<?php echo esc_url($linkin_url);?>"><i class="fab fa-linkedin-in"></i></a></li>
								<?php } ?>
								<?php if( !empty( $google_url )) { ?>
									<li class="dc-googleplus"><a target="_blank" href="<?php echo esc_url($google_url);?>"><i class="fab fa-google-plus-g"></i></a></li>
								<?php } ?>
								<?php if( !empty( $feeds_url )) { ?>
									<li class="dc-rss"><a target="_blank" href="<?php echo esc_url($feeds_url);?>"><i class="fa fa-rss"></i></a></li>
								<?php } ?>
								<?php if( !empty( $youtube_url )) { ?>
									<li class="dc-youtube"><a target="_blank" href="<?php echo esc_url($youtube_url);?>"><i class="fab fa-youtube"></i></a></li>
								<?php } ?>
								<?php if( !empty( $instagram_url )) { ?>
									<li class="dc-instagram"><a target="_blank" href="<?php echo esc_url($instagram_url);?>"><i class="fab fa-instagram"></i></a></li>
								<?php } ?>
							</ul>
						</div>
					<?php } ?>
				</div>
				<?php
			echo ( $after );
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form($instance) {
            // outputs the options form on admin
			$logo_link	= !empty($instance['logo_link']) ? esc_attr($instance['logo_link']) : '';
            $logo_url 	= !empty($instance['logo_url']) ? esc_attr($instance['logo_url']) : '';
			
			$contact_detail		= !empty($instance['contact_detail'])  ? esc_attr($instance['contact_detail']) : '';
            $contact_address	= !empty($instance['contact_address']) ? esc_attr($instance['contact_address']) : '';
			$contact_email		= !empty($instance['contact_email']) ? sanitize_email($instance['contact_email']) : '';
			$contact_phone 		= !empty($instance['contact_phone']) ? esc_attr($instance['contact_phone']) : '';
			
			$facebook_url 		= !empty($instance['facebook_url']) ? esc_url($instance['facebook_url']) : '';
			$twitter_url 		= !empty($instance['twitter_url']) ? esc_url($instance['twitter_url']) : '';
			$google_url 		= !empty($instance['google_url']) ? esc_url($instance['google_url']) : '';
			$linkin_url 		= !empty($instance['linkin_url']) ? esc_url($instance['linkin_url']) : '';
			$youtube_url 		= !empty($instance['youtube_url']) ? esc_url($instance['youtube_url']) : '';
			$feeds_url 			= !empty($instance['feeds_url']) ? esc_url($instance['feeds_url']) : '';
			$instagram_url 		= !empty($instance['instagram_url']) ? esc_url($instance['instagram_url']) : '';
			
            ?>
			<p>
                <label for="<?php echo ( $this->get_field_id('logo_link') ); ?>"><?php esc_html_e('Logo Link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('logo_link') ); ?>" name="<?php echo ( $this->get_field_name('logo_link') ); ?>" type="text" value="<?php echo esc_url($logo_link); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('logo_url') ); ?>"><?php esc_html_e('Logo url','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('logo_url') ); ?>" name="<?php echo ( $this->get_field_name('logo_url') ); ?>" type="text" value="<?php echo esc_url($logo_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('contact_detail') ); ?>"><?php esc_html_e('Details','doctreat_core'); ?></label> 
                <textarea id="contact_detail" name="<?php echo esc_attr($this->get_field_name('contact_detail')); ?>" class="widefat"><?php echo esc_attr($contact_detail); ?></textarea>
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('contact_address') ); ?>"><?php esc_html_e('Address','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('contact_address') ); ?>" name="<?php echo ( $this->get_field_name('contact_address') ); ?>" type="text" value="<?php echo esc_attr($contact_address); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('contact_email') ); ?>"><?php esc_html_e('Email','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('contact_email') ); ?>" name="<?php echo ( $this->get_field_name('contact_email') ); ?>" type="text" value="<?php echo esc_attr($contact_email); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('contact_phone') ); ?>"><?php esc_html_e('Phone','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('contact_phone') ); ?>" name="<?php echo ( $this->get_field_name('contact_phone') ); ?>" type="text" value="<?php echo esc_attr($contact_phone); ?>">
            </p>
            
            <p>
                <label for="<?php echo ( $this->get_field_id('facebook_url') ); ?>"><?php esc_html_e('Facebook link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('facebook_url') ); ?>" name="<?php echo ( $this->get_field_name('facebook_url') ); ?>" type="text" value="<?php echo esc_url($facebook_url); ?>">
            </p>
            
            <p>
                <label for="<?php echo ( $this->get_field_id('twitter_url') ); ?>"><?php esc_html_e('Twitter link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('twitter_url') ); ?>" name="<?php echo ( $this->get_field_name('twitter_url') ); ?>" type="text" value="<?php echo esc_url($twitter_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('google_url') ); ?>"><?php esc_html_e('Google Plus link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('google_url') ); ?>" name="<?php echo ( $this->get_field_name('google_url') ); ?>" type="text" value="<?php echo esc_url($google_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('linkin_url') ); ?>"><?php esc_html_e('LinkedIn link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('linkin_url') ); ?>" name="<?php echo ( $this->get_field_name('linkin_url') ); ?>" type="text" value="<?php echo esc_url($linkin_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('youtube_url') ); ?>"><?php esc_html_e('Youtube link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('youtube_url') ); ?>" name="<?php echo ( $this->get_field_name('youtube_url') ); ?>" type="text" value="<?php echo esc_url($youtube_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('feeds_url') ); ?>"><?php esc_html_e('Feeds link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('feeds_url') ); ?>" name="<?php echo ( $this->get_field_name('feeds_url') ); ?>" type="text" value="<?php echo esc_url($feeds_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('instagram_url') ); ?>"><?php esc_html_e('Instagram link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('instagram_url') ); ?>" name="<?php echo ( $this->get_field_name('instagram_url') ); ?>" type="text" value="<?php echo esc_url($instagram_url); ?>">
            </p>
            <?php
        }

        /**
         * Processing widget options on save
         *
         * @param array $new_instance The new options
         * @param array $old_instance The previous options
         */
        public function update($new_instance , $old_instance) {
            // processes widget options to be saved
            $instance				= $old_instance;
           	$instance['logo_link']	= !empty($new_instance['logo_link']) ? esc_url($new_instance['logo_link']) : '';
            $instance['logo_url'] 	= !empty($new_instance['logo_url']) ? esc_url($new_instance['logo_url']) : '';
			
			$instance['contact_detail']		= !empty($new_instance['contact_detail'])  ? esc_attr($new_instance['contact_detail']) : '';
            $instance['contact_address']	= !empty($new_instance['contact_address']) ? esc_attr($new_instance['contact_address']) : '';
			$instance['contact_email']		= !empty($new_instance['contact_email']) ? sanitize_email($new_instance['contact_email']) : '';
			$instance['contact_phone'] 		= !empty($new_instance['contact_phone']) ? esc_attr($new_instance['contact_phone']) : '';
			
			$instance['facebook_url'] 		= !empty($new_instance['facebook_url']) ? esc_url($new_instance['facebook_url']) : '';
			$instance['twitter_url'] 		= !empty($new_instance['twitter_url']) ? esc_url($new_instance['twitter_url']) : '';
			$instance['google_url'] 		= !empty($new_instance['google_url']) ? esc_url($new_instance['google_url']) : '';
			$instance['linkin_url'] 		= !empty($new_instance['linkin_url']) ? esc_url($new_instance['linkin_url']) : '';
			$instance['youtube_url'] 		= !empty($new_instance['youtube_url']) ? esc_url($new_instance['youtube_url']) : '';
			$instance['feeds_url'] 			= !empty($new_instance['feeds_url']) ? esc_url($new_instance['feeds_url']) : '';
			$instance['instagram_url'] 		= !empty($new_instance['instagram_url']) ? esc_url($new_instance['instagram_url']) : '';

            return $instance;
        }

    }

}

//register widget
function doctreat_register_ContactInfo_widgets() {
	register_widget( 'Doctreat_ContactInfo' );
}
add_action( 'widgets_init', 'doctreat_register_ContactInfo_widgets' );