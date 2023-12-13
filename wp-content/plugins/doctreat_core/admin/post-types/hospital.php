<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_Hospital')) {

    class Doctreat_Hospital {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_post_type'));
			add_action('add_meta_boxes', array(&$this, 'linked_profile_add_meta_box'), 10, 2);
        }
		
		/**
		 * @Linked Profile metabox
		 * @return {post}
		 */
		public function linked_profile_add_meta_box($post_type,$post) {
			$linked_profile	= doctreat_get_linked_profile_id($post->ID,'post');
			
			if(empty( $linked_profile )){return;}
			
			if ($post_type === 'hospitals') {
                add_meta_box(
                        'linked_profile', esc_html__('Linked Profile', 'doctreat_core'), array(&$this, 'linked_profile_meta_box_print'), 'hospitals', 'side', 'high'
                );
            }
		}
		
		/**
		 * @Linked Profile metabox
		 * @return {post}
		 */
		public function linked_profile_meta_box_print($post) {
			$linked_profile	= doctreat_get_linked_profile_id($post->ID,'post');
			if(empty( $linked_profile )){return;}
			?>
			<ul class="review-info">
                <li>
                    <span class="push-right">
                    	<a target="_blank" href="<?php echo get_edit_user_link( $linked_profile );?>"><?php esc_html_e('View User Profile', 'doctreat_core'); ?></a>
                    </span>
                </li>
			</ul>
			<?php
		}

        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_post_type() {
            $this->prepare_post_type();
        }
				
        /**
         * @Prepare Post Type Category
         * @return post type
         */
        public function prepare_post_type() {
			global $theme_settings;
            $labels = array(
                'name' 				=> esc_html__('Hospitals', 'doctreat_core'),
                'all_items' 		=> esc_html__('Hospitals', 'doctreat_core'),
                'singular_name' 	=> esc_html__('Hospital', 'doctreat_core'),
                'add_new' 			=> esc_html__('Add Hospital', 'doctreat_core'),
                'add_new_item' 		=> esc_html__('Add New Hospital', 'doctreat_core'),
                'edit' 				=> esc_html__('Edit', 'doctreat_core'),
                'edit_item' 		=> esc_html__('Edit Hospital', 'doctreat_core'),
                'new_item' 			=> esc_html__('New Hospital', 'doctreat_core'),
                'view' 				=> esc_html__('View Hospital', 'doctreat_core'),
                'view_item' 		=> esc_html__('View Hospital', 'doctreat_core'),
                'search_items' 		=> esc_html__('Search Hospital', 'doctreat_core'),
                'not_found' 		=> esc_html__('No Hospital found', 'doctreat_core'),
                'not_found_in_trash' => esc_html__('No Hospital found in trash', 'doctreat_core'),
                'parent' 			=> esc_html__('Parent Hospitals', 'doctreat_core'),
            );
			
            $args = array(
                'labels' 				=> $labels,
                'description' 			=> esc_html__('This is where you can add new company', 'doctreat_core'),
                'public' 				=> true,
                'supports' 				=> array('title','editor','thumbnail','author'),
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap' 			=> true,
                'publicly_queryable' 	=> true,
                'hierarchical' 			=> false,
                'menu_position' 		=> 10,
				'menu_icon'   			=> 'dashicons-admin-multisite',
                'rewrite' 				=> array('slug' => 'hospital', 'with_front' => true),
                'query_var' 			=> false,
                'has_archive' 			=> false,
				'capabilities' 			=> array('create_posts' => false)
            );
            
            register_post_type('hospitals', $args);
			
        }
    }

    new Doctreat_Hospital();
}

