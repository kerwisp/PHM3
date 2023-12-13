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

if (!class_exists('Doctreat_Apps_Downloads')) {

    class Doctreat_Apps_Downloads extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_apps_downloads' , // Base ID
                    esc_html__('Apps Download | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' 	=> 'dc-footerapps',
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
			
			$google_app_link	= (!empty($instance['google_app_link']) ) ? esc_url($instance['google_app_link']) : '';
            $google_app_img 	= (!empty($instance['google_app_img']) ) ? esc_url($instance['google_app_img']) : '';
			$title				= (!empty($instance['title']) ) ? ($instance['title']) : '';
			$app_store_link		= !empty($instance['app_store_link'])  ? esc_url($instance['app_store_link']) : '';
            $app_store_img 		= !empty($instance['app_store_img']) ? esc_url($instance['app_store_img']) : '';

            $before	= ($args['before_widget']);
			$after	 = ($args['after_widget']);
			
			echo ($before);
				?>
				<?php if(!empty($title)){?><div class="dc-ftitle"><h3><?php echo esc_html($title);?></h3></div><?php }?>
				<ul class="dc-btnapps">
					<?php if( !empty( $google_app_link ) && !empty( $google_app_img ) ) { ?>
						<li><a href="<?php echo esc_url($google_app_link);?>"><img width="" height="" src="<?php echo esc_url($google_app_img);?>" alt="<?php esc_attr_e('Android app','doctreat_core');?>"></a></li>
					<?php } ?>
					<?php if( !empty( $app_store_img ) && !empty( $app_store_link ) ) { ?>
						<li><a href="<?php echo esc_url($app_store_link);?>"><img width="" height="" src="<?php echo esc_url($app_store_img);?>" alt="<?php esc_attr_e('Android app','doctreat_core');?>"></a></li>
					<?php } ?>
				</ul>
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
			$google_app_link	= (!empty($instance['google_app_link']) ) ? esc_url($instance['google_app_link']) : '';
            $google_app_img 	= (!empty($instance['google_app_img']) ) ? esc_url($instance['google_app_img']) : '';
			$title				= (!empty($instance['title']) ) ? ($instance['title']) : '';
			$app_store_link		= !empty($instance['app_store_link'])  ? esc_url($instance['app_store_link']) : '';
            $app_store_img 		= !empty($instance['app_store_img']) ? esc_url($instance['app_store_img']) : '';
			
            ?>
            <p>
                <label for="<?php echo ( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo ( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
			<p>
                <label for="<?php echo ( $this->get_field_id('google_app_link') ); ?>"><?php esc_html_e('Google Play Link','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('google_app_link') ); ?>" name="<?php echo ( $this->get_field_name('google_app_link') ); ?>" type="text" value="<?php echo esc_url($google_app_link); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('google_app_img') ); ?>"><?php esc_html_e('Google app Image url','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('google_app_img') ); ?>" name="<?php echo ( $this->get_field_name('google_app_img') ); ?>" type="text" value="<?php echo esc_url($google_app_img); ?>">
                <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Upload Logo', 'doctreat_core' ); ?></span>
            </p>
            <p>
               <label for="<?php echo ( $this->get_field_id('app_store_link') ); ?>"><?php esc_html_e('App Store Link','doctreat_core'); ?></label> 
               <input class="widefat" id="<?php echo ( $this->get_field_id('app_store_link') ); ?>" name="<?php echo ( $this->get_field_name('app_store_link') ); ?>" type="text" value="<?php echo esc_url($app_store_link); ?>">                
            </p>
            <p>
               <label for="<?php echo ( $this->get_field_id('app_store_img') ); ?>"><?php esc_html_e('App store Image url','doctreat_core'); ?></label> 
               <input class="widefat" id="<?php echo ( $this->get_field_id('app_store_img') ); ?>" name="<?php echo ( $this->get_field_name('app_store_img') ); ?>" type="text" value="<?php echo esc_url($app_store_img); ?>">
               <span id="upload" class="button upload_button_wgt"><?php esc_html_e( 'Upload Logo', 'doctreat_core' ); ?></span>
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
            $instance                    	= $old_instance;
            $instance['google_app_link']	= (!empty($new_instance['google_app_link']) ) ? esc_url($new_instance['google_app_link']) : '';
            $instance['google_app_img'] 	= (!empty($new_instance['google_app_img']) ) ? esc_url($new_instance['google_app_img']) : '';
			$instance['title'] 			= (!empty($new_instance['title']) ) ? esc_attr($new_instance['title']) : '';
			$instance['app_store_link']	= !empty($new_instance['app_store_link'])  ? esc_url($new_instance['app_store_link']) : '';
            $instance['app_store_img'] 	= !empty($new_instance['app_store_img']) ? esc_url($new_instance['app_store_img']) : '';

            return $instance;
        }

    }

}

//register widget
function doctreat_register_Apps_Downloads_widgets() {
	register_widget( 'Doctreat_Apps_Downloads' );
}
add_action( 'widgets_init', 'doctreat_register_Apps_Downloads_widgets' );