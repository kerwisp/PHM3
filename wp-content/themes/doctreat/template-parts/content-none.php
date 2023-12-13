<?php
/**
 *
 * The template part for displaying a message that posts cannot be found.
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
?>

	
<section class="dc-haslayout search-page-header">
<div class="border-left dc-haslayout"> <h3><?php esc_html_e('Nothing Found' , 'doctreat'); ?></h13></div>
	<?php if (is_search()) : ?>
			<div class="border-left dc-haslayout">
				<h3><?php printf(esc_html__('Search Results for : %s' , 'doctreat') , get_search_query()); ?></h3>
			</div>
			<div class="need-help dc-haslayout">
				<h4><?php  esc_html_e('Need a new search?','doctreat');?> </h4>
				<p><?php  esc_html_e('If you didn\'t find what you were looking for, try a new search!','doctreat');?></p>
			</div>
			<div class="dc-blog-search dc-haslayout">
				<?php get_search_form();?>
			</div>
		<?php else : ?>
			<div class="need-help dc-haslayout">
				<h4><?php  esc_html_e('Need a new search?','doctreat');?> </h4>
				<p><?php  esc_html_e('If you didn\'t find what you were looking for, try a new search!','doctreat');?></p>
			</div>
			<div class="dc-blog-search dc-haslayout">
				<?php get_search_form();?>
			</div>
	<?php endif; ?>
</section>
	
