<?php
/**
 *
 * The template used for displaying audio post formate
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $paged,$wp_query;
$search_show_posts    = get_option('posts_per_page');
?>
<div class="blog-list-view-template">
	<?php 
	while (have_posts()) : the_post();
		global $post;
		$width 		= 1140;
		$height 	= 400;
		$thumbnail  = doctreat_prepare_thumbnail($post->ID , $width , $height);
		
		$stickyClass = '';
		if (is_sticky()) {
			$stickyClass = 'sticky';
		}
	
		$categries		=  get_the_term_list( $post->ID, 'category', '', '', '' );
		?>                         
		<article class="dc-article <?php echo esc_attr($stickyClass);?>">
			<div class="dc-articlecontent">
				<?php if( !empty( $thumbnail ) ){?>
					<figure class="dc-classimg">
						<?php doctreat_get_post_thumbnail($thumbnail,$post->ID,'linked');?>
					</figure>
				<?php }?>
				
				<div class="dc-title">
					<h3><?php doctreat_get_post_title($post->ID); ?></h3>
				</div>
			    <div class="dc-description">
					<p><?php echo doctreat_prepare_excerpt(350); ?></p>
					<?php if(!empty( $categries )){?>
						<div class="dc-tagslist tagcloud d-flex dc-tags1 flex-wrap"><span><?php esc_html_e('Categories','doctreat');?>:&nbsp;</span><?php echo do_shortcode($categries);?></div>
					<?php }?>
					<?php
						if( function_exists('doctreat_get_article_meta') ){
							do_action('doctreat_get_article_meta',$post->ID);
						}
					?>
				</div>
				<?php if ( is_sticky() ) {?>
					<span class="sticky-wrap dc-themetag dc-tagclose"><i class="fa fa-bolt" aria-hidden="true"></i>&nbsp;<?php esc_html_e('Featured','doctreat');?></span>
				<?php }?>
			</div>
		</article>
	<?php
	endwhile;
	wp_reset_postdata();
	$qrystr = '';
	if ($wp_query->found_posts > $search_show_posts) {?>
		<div class="theme-nav">
			<?php 
				if (function_exists('doctreat_prepare_pagination')) {
					echo doctreat_prepare_pagination($wp_query->found_posts , $search_show_posts);
				}
			?>
		</div>
	<?php }?>
</div>