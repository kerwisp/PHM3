<?php
/**
 *
 * Theme Home Page
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
get_header(); ?>
<div class="container">
    <div class="row">
		<?php get_template_part( 'template-parts/content', 'page' ); ?>
    </div>
</div>
<?php get_footer(); ?>