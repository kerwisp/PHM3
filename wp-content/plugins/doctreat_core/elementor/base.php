<?php
/**
 * Elementor Page buider base
 *
 * This file will include all global settings which will be used in all over the plugin,
 * It have gatter and setter methods
 *
 * @link              https://themeforest.net/user/amentotech/portfolio
 * @since             1.0.0
 * @package           Doctreat
 *
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die('No kiddies please!');
}

/**
 * @prepare Custom taxonomies array
 * @return array
 */
function elementor_get_taxonomies($post_type = 'post', $taxonomy = 'category', $hide_empty = 0, $dataType = 'input') {
	$args = array(
		'type' 			=> $post_type,
		'child_of'  	=> 0,
		'parent' 		=> '',
		'orderby' 		=> 'name',
		'order' 		=> 'ASC',
		'hide_empty' 	=> $hide_empty,
		'hierarchical' 	=> 1,
		'exclude' 		=> '',
		'include' 		=> '',
		'number' 		=> '',
		'taxonomy' 		=> $taxonomy,
		'pad_counts' 	=> false
	);

	$categories = get_categories($args);

	if ($dataType == 'array') {
		return $categories;
	}

	$custom_Cats = array();

	if (isset($categories) && !empty($categories)) {
		foreach ($categories as $key => $value) {
			$custom_Cats[$value->term_id] = $value->name;
		}
	}

	return $custom_Cats;
} 

/**
 * @prepare Custom taxonomies array
 * @return array
 */
function elementor_get_posts($post_type = 'post', $taxonomy = 'category', $hide_empty = 1, $dataType = 'input') {
	$args = array(
		'type' 			=> $post_type,
		'child_of'  	=> 0,
		'parent' 		=> '',
		'orderby' 		=> 'name',
		'order' 		=> 'ASC',
		'hide_empty' 	=> $hide_empty,
		'hierarchical' 	=> 1,
		'exclude' 		=> '',
		'include' 		=> '',
		'number' 		=> '',
		'taxonomy' 		=> $taxonomy,
		'pad_counts' 	=> false
	);

	$categories = get_categories($args);

	if ($dataType == 'array') {
		return $categories;
	}

	$custom_Cats = array();

	if (isset($categories) && !empty($categories)) {
		foreach ($categories as $key => $value) {
			$custom_Cats[$value->term_id] = $value->name;
		}
	}

	return $custom_Cats;
} 

/**
 * @prepare Social links array
 * @return array
 */
function doctreat_social_profile () {
	$social_profile = array ( 
						'facebook_link'	=> array (
											'class'	=> 'dc-facebook',
											'icon'	=> 'fab fa-facebook-f',
											'lable' => esc_html__('Facebook','doctreat_core'),
										),
						'twitter_link'	=> array (
											'class'	=> 'dc-twitter',
											'icon'	=> 'fab fa-twitter',
											'lable' => esc_html__('Twitter','doctreat_core'),
										),
						'linkedin_link'	=> array (
											'class'	=> 'dc-linkedin',
											'icon'	=> 'fab fa-linkedin-in',
											'lable' => esc_html__('LinkedIn','doctreat_core'),
										),
						'googleplus_link'=> array (
											'class'	=> 'dc-googleplus',
											'icon'	=> 'fab fa-google-plus-g',
											'lable' => esc_html__('Google Plus','doctreat_core'),
										),
						'youtube_link'=> array (
											'class'	=> 'dc-youtube',
											'icon'	=> 'fab fa-youtube',
											'lable' => esc_html__('Google Plus','doctreat_core'),
										),
		
						);
	return $social_profile;
}