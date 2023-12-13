<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_Health_Forum')) {

    class Doctreat_Health_Forum {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_post_type'));
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
            $labels = array(
                'name' 				=> esc_html__('Health Forum', 'doctreat_core'),
                'all_items' 		=> esc_html__('Health Forum Posts', 'doctreat_core'),
                'singular_name' 	=> esc_html__('Health Forum Post', 'doctreat_core'),
                'add_new' 			=> esc_html__('Add Post', 'doctreat_core'),
                'add_new_item' 		=> esc_html__('Add Health Forum Post', 'doctreat_core'),
                'edit' 				=> esc_html__('Edit', 'doctreat_core'),
                'edit_item' 		=> esc_html__('Edit Health Forum Post', 'doctreat_core'),
                'new_item' 			=> esc_html__('New Health Forum Post', 'doctreat_core'),
                'view' 				=> esc_html__('View Health Forum Post', 'doctreat_core'),
                'view_item' 		=> esc_html__('View Health Forum Post', 'doctreat_core'),
                'search_items' 		=> esc_html__('Search Health Forum Posts', 'doctreat_core'),
                'not_found' 		=> esc_html__('No Health Forum Post found', 'doctreat_core'),
                'not_found_in_trash' => esc_html__('No Health Forum Post found in trash', 'doctreat_core'),
                'parent' 			=> esc_html__('Parent Health Forum Post', 'doctreat_core'),
            );
            $args = array(
                'labels' 				=> $labels,
                'description' 			=> esc_html__('This is where you can add new post related Health Forum', 'doctreat_core'),
                'public' 				=> true,
                'supports' 				=> array('title','editor','comments','author'),
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap' 			=> true,
                'publicly_queryable' 	=> true,
                'exclude_from_search' 	=> true,
                'hierarchical' 			=> false,
                'menu_position' 		=> 10,
				'menu_icon'   			=> 'dashicons-format-quote',
                'rewrite' 				=> array('slug' => 'health-forum', 'with_front' => true),
                'query_var' 			=> false,
				'has_archive' 			=> false,
				'capabilities' 			=> array('create_posts' => false)
            );
			
            register_post_type('healthforum', $args);
			
        }
    }

    new Doctreat_Health_Forum();
}

