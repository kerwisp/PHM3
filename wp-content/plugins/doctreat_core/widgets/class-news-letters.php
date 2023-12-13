<?php
/**
 * The NewsLetters widgets functionality of the plugin.
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

if (!class_exists('Doctreat_NewsLetters')) {

    class Doctreat_NewsLetters extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_newsletters' , // Base ID
                    esc_html__('News Letters | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' 	=> '',
					'description' 	=> esc_html__('News Letters' , 'doctreat_core') , 
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
			
			$title		= (!empty($instance['title']) ) ? esc_attr($instance['title']) : '';
            $details 	= (!empty($instance['details']) ) ? esc_attr($instance['details']) : '';
			
            $before			= ($args['before_widget']);
			$after	 		= ($args['after_widget']);
			$mailchimp 	    = new Doctreat_MailChimp();
                       
			echo ($before);
			if( !empty( $title ) ) {?>
				<div class="dc-ftitle"><h3><?php echo esc_attr($title);?></h3></div>
			<?php } ?>
			<?php if( !empty( $details ) ) {?>
				<div class="dc-footercontent dc-newsletterholder">
					<div class="dc-description"><p><?php echo esc_attr($details);?></p></div>
				</div>
			<?php } 
			$mailchimp->doctreat_mailchimp_form();
			echo ( $after );
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form($instance) {
            // outputs the options form on admin
			$title		= (!empty($instance['title']) ) ? esc_attr($instance['title']) : '';
            $details 	= (!empty($instance['details']) ) ? esc_attr($instance['details']) : '';
						
            ?>
			<p>
                <label for="<?php echo ( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo ( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('details') ); ?>"><?php esc_html_e('Details','doctreat_core'); ?></label> 
                <textarea id="details" name="<?php echo esc_attr($this->get_field_name('details')); ?>" class="widefat"><?php echo esc_attr($details); ?></textarea>
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
            $instance               = $old_instance;
			$instance['title']		= (!empty($new_instance['title']) ) ? esc_attr($new_instance['title']) : '';
            $instance['details'] 	= (!empty($new_instance['details']) ) ? esc_attr($new_instance['details']) : '';

            return $instance;
        }

    }
}

//register widget
function doctreat_register_NewsLetters_widgets() {
	register_widget( 'Doctreat_NewsLetters' );
}
add_action( 'widgets_init', 'doctreat_register_NewsLetters_widgets' );