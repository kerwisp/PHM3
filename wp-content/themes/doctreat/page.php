<?php
/**
 *
 * Theme Page template
 *
 * @package   doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
global $post; 
get_header();
$post_meta			= doctreat_get_post_meta( $post->ID );
$am_layout			= !empty( $post_meta['am_layout'] ) ? $post_meta['am_layout'] : '';
$am_sidebar			= !empty( $post_meta['am_left_sidebar'] ) ? $post_meta['am_left_sidebar'] : '';

$current_position	= 'full';
$sidebar_enabled	= 'dc-disabled';
if (!empty($am_layout) && $am_layout === 'right_sidebar') {
    $aside_class   		= 'order-last';
    $content_class 		= 'order-first';
	$section_width     	= 'col-12 col-md-7 col-lg-8 col-xl-9';
	$current_position	= 'dc-siderbar';
	$sidebar_enabled	= 'dc-enabled';
} elseif (!empty($am_layout) && $am_layout === 'left_sidebar') {
    $aside_class   		= 'order-first';
    $content_class 		= 'order-last';
	$section_width     	= 'col-12 col-md-7 col-lg-8 col-xl-9';
	$current_position	= 'dc-siderbar';
	$sidebar_enabled	= 'dc-enabled';
} else {
	if ( is_active_sidebar( 'sidebar-pages-1' ) ){
		if (!empty($am_layout) && $am_layout === 'no_sidebar') {
			$aside_class   = '';
			$content_class = '';
		} else{
			$aside_class   		= 'order-last';
			$content_class 		= 'order-first';
			$section_width     	= 'col-12 col-md-12 col-lg-8';
			$current_position	= 'dc-siderbar';
			$sidebar_enabled	= 'dc-enabled';
		}
		
	} else{
		$aside_class   = '';
		$content_class = '';
		$am_sidebar	   = '';
	}
	
}

$height = 466;
$width  = 1170;

$main_class		= !is_front_page() ? 'dc-parent-section '.$sidebar_enabled : '';

if (isset($current_position) && ( $current_position == 'full' )) {
    while (have_posts()) : the_post();
  		global $post;
        ?>
        <div class="container">
            <div class="dc-haslayout dc-haslayout page-data <?php echo esc_attr($main_class);?>">
                <?php
					do_action('doctreat_prepare_section_wrapper_before',$post->ID);
					$thumbnail = doctreat_prepare_thumbnail($post->ID , $width , $height);
					if( $thumbnail ){?>
						<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" >
						<?php
					}
					?>
					<div class="dc-description">
						<?php  
							the_content();
							wp_link_pages( array(
											'before'      => '<div class="dc-paginationvtwo"><nav class="dc-pagination"><ul>',
											'after'       => '</ul></nav></div>',
										) );
						?>
					</div>
					<?php
					// If comments are open or we have at least one comment, load up the comment template.
					if (comments_open() || get_comments_number()) :
						comments_template();
					endif;
					do_action('doctreat_prepare_section_wrapper_after');
                ?>
            </div>
        </div>
        <?php
    endwhile;
} else { ?> 
    <div class="container">
        <div class="dc-haslayout page-data <?php echo esc_attr($main_class);?>">
           	<?php do_action('doctreat_prepare_section_wrapper_before',$post->ID); ?>
            	<div class="row">
					<div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>  page-section twocolumn-page-section">
						<?php
							while (have_posts()) : the_post();
								global $post;
								$thumbnail = doctreat_prepare_thumbnail($post->ID , $width , $height);
								if( $thumbnail ){?>
									<img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" >
								<?php }?>

								<div class="dc-description">
									<?php  
										the_content();
										wp_link_pages( array(
														'before'      => '<div class="dc-paginationvtwo"><nav class="dc-pagination"><ul>',
														'after'       => '</ul></nav></div>',
													) );
									?>
								</div>
								<?php
								// If comments are open or we have at least one comment, load up the comment template.
								if (comments_open() || get_comments_number()) :
									comments_template();
								endif;
							endwhile;
						?>
					</div>
					<?php if ( !empty( $am_sidebar ) && is_active_sidebar( $am_sidebar ) ) {?>
							<div class="col-12 col-md-5 col-lg-4 col-xl-3 dc-sidebar-grid mt-md-0 mt-xl-0 <?php echo sanitize_html_class($aside_class); ?>">
								<aside id="dc-sidebar" class="dc-sidebar">
									<?php dynamic_sidebar( $am_sidebar );?>
								</aside>
							</div>
							<?php
						} elseif ( is_active_sidebar( 'sidebar-pages-1' ) ) {?>
							<div class="col-12 col-md-12 col-lg-4 dc-sidebar-grid mt-lg-0 <?php echo sanitize_html_class($aside_class); ?>">
								<aside id="dc-sidebar" class="dc-sidebar">
									<?php dynamic_sidebar( 'sidebar-pages-1' );?>
								</aside>
							</div>
					<?php }?>
           		</div>
            <?php do_action('doctreat_prepare_section_wrapper_after'); ?>
        </div>
    </div>
<?php } ?>
<?php get_footer();