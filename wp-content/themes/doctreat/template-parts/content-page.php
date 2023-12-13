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

if ( is_active_sidebar( 'sidebar-1' ) ) {
	$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-8';
} else{
	$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
}

$aside_class   = 'pull-right';
$content_class = 'pull-left';
?>
<div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
	<?php 
		if ( have_posts() ) { 
			get_template_part( 'template-parts/archive-templates/content', 'list' );
		} else{
			get_template_part( 'template-parts/content', 'none' );
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
			
