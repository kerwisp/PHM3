<?php
/**
 * Jetpack Compatibility File
 * See: https://jetpack.me/
 *
 * @package Charity
 */

/**
 * Add theme support for Infinite Scroll.
 */
if (!function_exists('doctreat_jetpack_setup')) {
	function doctreat_jetpack_setup() {
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => 'doctreat_infinite_scroll_render',
			'footer'    => 'page',
		) );
	} 
	add_action( 'after_setup_theme', 'doctreat_jetpack_setup' );
}

if (!function_exists('doctreat_infinite_scroll_render')) {
	function doctreat_infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		}
	} 
}