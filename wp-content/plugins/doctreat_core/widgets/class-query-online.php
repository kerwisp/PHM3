<?php
/**
 * The Query Online widgets functionality of the plugin.
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

if (!class_exists('Doctreat_Query_Online')) {

    class Doctreat_Query_Online extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_query_online' , // Base ID
                    esc_html__('Query Online | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' 	=> 'dc-sidebarquery dc-widget dc-onlineoptions',
					'description' 	=> esc_html__('Doctreat Query Online' , 'doctreat_core') , 
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
			
			$title			= (!empty($instance['title']) ) ? ($instance['title']) : '';
            $app_img 		= (!empty($instance['app_img']) ) ? ($instance['app_img']) : '';
			
			$sub_title		= !empty($instance['sub_title'])  ? ($instance['sub_title']) : '';
			$btn_text		= !empty($instance['btn_text'])  ? ($instance['btn_text']) : '';
			$btn_url		= !empty($instance['btn_url'])  ? ($instance['btn_url']) : '';
			
			$consultation_num 		= !empty($instance['consultation_num'])  ? ($instance['consultation_num']) : '';
			$consultation_text		= !empty($instance['consultation_text'])  ? ($instance['consultation_text']) : '';
			  
            $before		= ($args['before_widget']);
			$after	 	= ($args['after_widget']);
			
			echo ($before);?>
				<?php if( !empty( $app_img ) ){?>
					<figure class="dc-onlinuserimg">
						<img width="" height="" src="<?php echo esc_url( $app_img );?>" alt="<?php esc_html_e('Query online','doctreat_core');?>">
						<figcaption><span><?php esc_html_e('Live','doctreat_core');?></span></figcaption>
					</figure>
				<?php } ?>
				<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $btn_text )  ) {?>
					<div class="dc-onlineoption-content">
						<?php if( !empty( $title ) || !empty( $sub_title ) ) {?>
							<div class="dc-title">
								<h3><?php if( !empty( $title ) ) {?><span><?php echo esc_html( $title );?></span><?php } ?><?php echo esc_html( $sub_title );?></h3>
							</div>
						<?php } ?>
						<div class="dc-btnarea">
							<?php if( !empty( $btn_text ) ) {?>
								<a href="<?php echo esc_url( $btn_url );?>" class="dc-btn dc-btnactive"><?php echo esc_html( $btn_text );?></a>
							<?php } ?>
							<?php if( !empty( $consultation_num ) || !empty( $consultation_text ) ){?>
								<span>
									<?php echo esc_html( $consultation_num );?>
									<?php if(!empty( $consultation_text ) ){?><em><?php echo esc_html( $consultation_text );?></em><?php } ?>
								</span>
							<?php } ?>
						</div>
					</div>
				<?php }?>
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
			$title			= (!empty($instance['title']) ) ? ($instance['title']) : '';
            $app_img 		= (!empty($instance['app_img']) ) ? ($instance['app_img']) : '';
			
			$sub_title		= !empty($instance['sub_title'])  ? ($instance['sub_title']) : '';
			$btn_text		= !empty($instance['btn_text'])  ? ($instance['btn_text']) : '';
			$btn_url		= !empty($instance['btn_url'])  ? ($instance['btn_url']) : '';
			
			$consultation_num 		= !empty($instance['consultation_num'])  ? ($instance['consultation_num']) : '';
			$consultation_text		= !empty($instance['consultation_text'])  ? ($instance['consultation_text']) : '';
			
			
            ?>
			
            <p>
                <label for="<?php echo ( $this->get_field_id('app_img') ); ?>"><?php esc_html_e('Image url','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('app_img') ); ?>" name="<?php echo ( $this->get_field_name('app_img') ); ?>" type="text" value="<?php echo esc_url($app_img); ?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?><?php esc_html_e( 'Upload', 'doctreat_core' ); ?></span>
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo ( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('sub_title') ); ?>"><?php esc_html_e('Sub title','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('sub_title') ); ?>" name="<?php echo ( $this->get_field_name('sub_title') ); ?>" type="text" value="<?php echo esc_attr($sub_title); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('btn_text') ); ?>"><?php esc_html_e('Button Text','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('btn_text') ); ?>" name="<?php echo ( $this->get_field_name('btn_text') ); ?>" type="text" value="<?php echo esc_attr($btn_text); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('btn_url') ); ?>"><?php esc_html_e('Button Url','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('btn_url') ); ?>" name="<?php echo ( $this->get_field_name('btn_url') ); ?>" type="text" value="<?php echo esc_attr($btn_url); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('consultation_num') ); ?>"><?php esc_html_e('No of consultations','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('consultation_num') ); ?>" name="<?php echo ( $this->get_field_name('consultation_num') ); ?>" type="text" value="<?php echo esc_attr($consultation_num); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('consultation_text') ); ?>"><?php esc_html_e('Consultation text','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('consultation_text') ); ?>" name="<?php echo ( $this->get_field_name('consultation_text') ); ?>" type="text" value="<?php echo esc_attr($consultation_text); ?>">
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
            $instance                    = $old_instance;
            $instance['app_img']		= (!empty($new_instance['app_img']) ) ? esc_url($new_instance['app_img']) : '';
            $instance['title'] 			= (!empty($new_instance['title']) ) ? esc_attr($new_instance['title']) : '';
			$instance['sub_title']		= !empty($new_instance['sub_title'])  ? esc_attr($new_instance['sub_title']) : '';
			
			$instance['btn_text']				= !empty($new_instance['btn_text'])  ? esc_attr($new_instance['btn_text']) : '';
			$instance['btn_url']				= !empty($new_instance['btn_url'])  ? esc_attr($new_instance['btn_url']) : '';
			$instance['consultation_num']		= !empty($new_instance['consultation_num'])  ? esc_attr($new_instance['consultation_num']) : '';
			$instance['consultation_text']		= !empty($new_instance['consultation_text'])  ? esc_attr($new_instance['consultation_text']) : '';

            return $instance;
        }

    }

}

//register widget
function doctreat_register_query_online_widgets() {
	register_widget( 'Doctreat_Query_Online' );
}
add_action( 'widgets_init', 'doctreat_register_query_online_widgets' );