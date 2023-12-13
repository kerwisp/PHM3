<?php
/**
 *
 * The template part for displaying results in search pages.
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
$aside_class 	= 'pull-right';
$content_class 	= 'pull-left';
if ( is_active_sidebar( 'sidebar-1' ) ) {
	$section_width  = 'col-xs-12 col-sm-12 col-md-12 col-lg-8';
} else{
	$section_width  = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
}
?>
<div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
    <div class="dc-haslayout search-page-header">
	    <div class="border-left dc-haslayout">
	        <h3><?php printf(esc_html__('Search Results for : %s' , 'doctreat') , get_search_query() ); ?></h3>
	    </div>
	    <div class="need-help dc-haslayout">
			<h4><?php  esc_html_e('Need a new search?','doctreat');?> </h4>
			<p><?php  esc_html_e('If you didn\'t find what you were looking for, try a new search!','doctreat');?></p>
		</div>
		<div class="dc-blog-search dc-haslayout">
			<?php get_search_form();?>
		</div>
	</div>
	<?php 
		if ( have_posts() && strlen( trim(get_search_query()) ) != 0 ) {
			get_template_part( 'template-parts/archive-templates/search', 'list' );
		}
	?>
</div>
<?php if ( is_active_sidebar( 'sidebar-1' ) ) {?>
	<aside id="dc-sidebar" class="col-xs-12 col-sm-12 col-md-12 col-lg-4 dc-sidebar-grid mt-lg-0 <?php echo sanitize_html_class($aside_class); ?>">
		<div class="dc-sidebar">
			<?php get_sidebar(); ?>
		</div>
	</aside>
<?php } ?>
			
