<?php
/**
 * The apps download widgets functionality of the plugin.
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

if (!class_exists('Doctreat_Apps')) {

    class Doctreat_Apps extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_apps' , // Base ID
                    esc_html__('Get Mobile App | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' 	=> 'dc-sidebarapps dc-widget dc-mobileappoptions',
					'description' 	=> esc_html__('Doctreat apps' , 'doctreat_core') , 
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
            $description 	= !empty($instance['description']) ? ($instance['description']) : '';
			
			  
            $before		= ($args['before_widget']);
			$after	 	= ($args['after_widget']);
			
			echo ($before);?>
			<?php if( !empty( $app_img ) ){?>
				<figure class="dc-appimgs">
					<img width="" height="" src="<?php echo esc_url( $app_img );?>" alt="<?php esc_attr_e('App downloads','doctreat_core');?>">
				</figure>
			<?php } ?>
			<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $description ) ){?>
				<div class="dc-mobileapp-content">
					<?php if( !empty( $title ) || !empty( $sub_title ) ) {?>
						<div class="dc-title">
							<h3>
								<?php if( !empty( $title ) ) {?><span><?php echo esc_html($title);?></span><?php } ?>
								<?php echo esc_html($sub_title);?>
							</h3>
						</div>
					<?php } ?>
					<?php if( !empty( $description ) ){?>
						<div class="dc-description">
							<p><?php echo esc_html( $description );?></p>
						</div>
					<?php } ?>
					<div class="dc-appemail-form">
						<input type="email" name="app_email" value="" class="form-control" placeholder="<?php esc_attr_e('Email ID','doctreat_core');?>" required="">
						<button type="submit" class="dc-get-app"><i class="fa fa-paper-plane"></i></button>
					</div>
				</div>	
			<?php } ?>					
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
            $description 	= !empty($instance['description']) ? ($instance['description']) : '';
			
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
                <label for="<?php echo ( $this->get_field_id('description') ); ?>"><?php esc_html_e('Description','doctreat_core'); ?></label> 
                <textarea class="widefat" id="<?php echo ( $this->get_field_id('description') ); ?>" name="<?php echo ( $this->get_field_name('description') ); ?>"><?php echo esc_html($description); ?></textarea>
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
            $instance['description'] 	= !empty($new_instance['description']) ? esc_textarea($new_instance['description']) : '';

            return $instance;
        }

    }

}

//register widget
function doctreat_register_Apps_widgets() {
	register_widget( 'Doctreat_Apps' );
}
add_action( 'widgets_init', 'doctreat_register_Apps_widgets' );