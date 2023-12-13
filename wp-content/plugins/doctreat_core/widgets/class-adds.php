<?php
/**
 * The adds widgets functionality of the plugin.
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

if (!class_exists('Doctreat_Adds')) {

    class Doctreat_Adds extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_adds' , // Base ID
                    esc_html__('Ads | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' 	=> 'dc-sidebaradds dc-searchresultad',
					'description' 	=> esc_html__('ads' , 'doctreat_core') , 
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
            extract($instance);
			
            $contents 	= !empty($instance['contents']) ? ($instance['contents']) : '';
			
			  
            $before		= ($args['before_widget']);
			$after	 	= ($args['after_widget']);
			
			echo ($before);
			?>
			<?php echo do_shortcode($contents);?>
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
            $contents 	= !empty($instance['contents']) ? ($instance['contents']) : '';
			
            ?>
            <p>
                <label for="<?php echo ( $this->get_field_id('contents') ); ?>"><?php esc_html_e('Contents','doctreat_core'); ?></label> 
                <textarea class="widefat" id="<?php echo ( $this->get_field_id('contents') ); ?>" name="<?php echo ( $this->get_field_name('contents') ); ?>"><?php echo do_shortcode($contents); ?></textarea>
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
            $instance['contents'] 		= !empty($new_instance['contents']) ? $new_instance['contents'] : '';

            return $instance;
        }

    }

}

//register widget
function doctreat_register_Adds_widgets() {
	register_widget( 'Doctreat_Adds' );
}
add_action( 'widgets_init', 'doctreat_register_Adds_widgets' );