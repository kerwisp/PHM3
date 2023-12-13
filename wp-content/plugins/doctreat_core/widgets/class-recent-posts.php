<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/**
 * Description of class-out-authors-widget
 *
 * @author ab
 */
 
if (!defined('ABSPATH')) {
    die('Direct access forbidden.');
}

if (!class_exists('Doctreat_RecentPosts')) {

    class Doctreat_RecentPosts extends WP_Widget {

        /**
         * Register widget with WordPress.
         */
        function __construct() {

            parent::__construct(
                    'doctreat_recentposts' , // Base ID
                    esc_html__('Populor posts | Doctreat' , 'doctreat_core') , // Name
                array (
                	'classname' => 'dc-widget dc-widgetarticlesholder dc-recentposts',
					'description' => esc_html__('Doctreat Populor posts' , 'doctreat_core') , 
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
			$number_of_posts = isset($instance['number_of_posts']) && !empty($instance['number_of_posts']) ? $instance['number_of_posts'] : 3;
			$title = isset($instance['title']) && !empty($instance['title']) ? $instance['title'] : '';
			  
            $before	= ($args['before_widget']);
			$after	 = ($args['after_widget']);
			
			$img_width  	= intval(65);
			$img_height 	= intval(65);
			//exlude current
			$exclude		= array(1);
			
			$date_formate	= get_option('date_format');
			
			echo ($before);
				$query_args = array(
					'posts_per_page' => $number_of_posts,
					'post_type' => 'post',
					'order' => 'DESC',
					'post_status' => 'publish',
					'orderby' => 'ID',
					'post__not_in' => $exclude,
					'suppress_filters' => false,
					'ignore_sticky_posts' => 1
				);

				if (!empty($title) ) {
					echo ($args['before_title'] . apply_filters('widget_title', esc_attr($title)) . $args['after_title']);
				}
	
				$p_query = new WP_Query($query_args);
				if( $p_query->have_posts() ) {
				?>
				<div class="dc-widgetcontent">
				<?php 
					while ($p_query->have_posts()) : $p_query->the_post();
						global $post;
					?>
						<div class="dc-particlehold">
							<div class="dc-particlecontent">
								<h3><?php doctreat_get_post_title($post->ID); ?></h3>
								<span><i class="lnr lnr-clock"></i> <?php echo date_i18n($date_formate,strtotime(get_the_date()));?></span>
							</div>
						</div>
					<?php 
					endwhile;
					wp_reset_postdata(); ?>
				</div>
				<?php
				}
			echo ( $after );
        }

        /**
         * Outputs the options form on admin
         *
         * @param array $instance The widget options
         */
        public function form($instance) {
            // outputs the options form on admin
            $title           = !empty($instance['title']) ? $instance['title'] : esc_html__('Populor Articles' , 'doctreat_core');
            $number_of_posts = !empty($instance['number_of_posts']) ? $instance['number_of_posts'] : 3;
            ?>
			<p>
                <label for="<?php echo ( $this->get_field_id('title') ); ?>"><?php esc_html_e('Title:','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('title') ); ?>" name="<?php echo ( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($title); ?>">
            </p>
            <p>
                <label for="<?php echo ( $this->get_field_id('number_of_posts') ); ?>"><?php esc_html_e('Number of posts to show:','doctreat_core'); ?></label> 
                <input class="widefat" id="<?php echo ( $this->get_field_id('number_of_posts') ); ?>" name="<?php echo ( $this->get_field_name('number_of_posts')); ?>" type="number" min="1" value="<?php echo esc_attr($number_of_posts); ?>">
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
            $instance['title']           = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
            $instance['number_of_posts'] = (!empty($new_instance['number_of_posts']) ) ? strip_tags($new_instance['number_of_posts']) : '';

            return $instance;
        }

    }

}
//register widget
function doctreat_register_recentposts_widgets() {
	register_widget( 'Doctreat_RecentPosts' );
}
add_action( 'widgets_init', 'doctreat_register_recentposts_widgets' );