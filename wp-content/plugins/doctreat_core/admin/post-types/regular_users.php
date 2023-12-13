<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_RegularUsers')) {

    class Doctreat_RegularUsers {

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
                'name' 				=> esc_html__('Patients', 'doctreat_core'),
                'all_items' 		=> esc_html__('Patients', 'doctreat_core'),
                'singular_name' 	=> esc_html__('Patients', 'doctreat_core'),
                'add_new' 			=> esc_html__('Add Patient', 'doctreat_core'),
                'add_new_item' 		=> esc_html__('Add New Patient', 'doctreat_core'),
                'edit' 				=> esc_html__('Edit', 'doctreat_core'),
                'edit_item' 		=> esc_html__('Edit Patient', 'doctreat_core'),
                'new_item' 			=> esc_html__('New Patient', 'doctreat_core'),
                'view' 				=> esc_html__('View Patient', 'doctreat_core'),
                'view_item' 		=> esc_html__('View Patient', 'doctreat_core'),
                'search_items' 		=> esc_html__('Search Patient', 'doctreat_core'),
                'not_found' 		=> esc_html__('No Patient found', 'doctreat_core'),
                'not_found_in_trash' => esc_html__('No Patient found in trash', 'doctreat_core'),
                'parent' 			=> esc_html__('Parent Patient', 'doctreat_core'),
            );
            $args = array(
                'labels' 				=> $labels,
                'description' 			=> esc_html__('This is where you can add new company', 'doctreat_core'),
                'public' 				=> false,
                'supports' 				=> array('title','editor','thumbnail','author'),
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap' 			=> true,
                'publicly_queryable' 	=> false,
                'exclude_from_search' 	=> true,
                'hierarchical' 			=> false,
                'menu_position' 		=> 10,
				'menu_icon'   			=> 'dashicons-money',
                'rewrite' 				=> array('slug' => 'regular_users', 'with_front' => true),
                'query_var' 			=> false,
                'has_archive' 			=> false,
				'capabilities' 			=> array('create_posts' => false)
            );
			
            register_post_type('regular_users', $args);
			
        }
    }

    new Doctreat_RegularUsers();
}

