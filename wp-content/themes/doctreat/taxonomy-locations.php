<?php
/**
 *
 * The template used for displaying default location result
 *
 * @package   doctreat
 * @author    Amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
global $wp_query;
get_header();
get_template_part("directory/doctor", "search");
get_footer();