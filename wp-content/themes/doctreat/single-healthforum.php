<?php
/**
 *
 * The template used for displaying default post style
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
get_header();
global $post,$theme_settings,$current_user; 

$post_meta			= doctreat_get_post_meta( $post->ID );
$am_layout			= !empty( $post_meta['am_layout'] ) ? $post_meta['am_layout'] : '';
$am_sidebar			= !empty( $post_meta['am_sidebar'] ) ? $post_meta['am_sidebar'] : '';
$user_info_id		= !empty( $current_user->ID ) ? doctreat_get_linked_profile_id($current_user->ID) : '';
if ( is_active_sidebar( 'sidebar-forum' )) {
	$section_width     	= 'col-12 col-md-7 col-lg-8 col-xl-9';
} else {
	$section_width     	= 'col-12';
}

$current_position	= 'full';
$aside_class   		= 'order-last';
$content_class 		= 'order-first';
$current_position	= 'dc-siderbar';

$title				= !empty( $theme_settings ['hf_title'] ) ? $theme_settings ['hf_title'] : '';
$sub_title			= !empty( $theme_settings ['hf_sub_title'] ) ? $theme_settings ['hf_sub_title'] : '';
$desc				= !empty( $theme_settings ['hf_description'] ) ? $theme_settings ['hf_description'] : '';
$btn_text			= !empty( $theme_settings ['hf_btn_text'] ) ? $theme_settings ['hf_btn_text'] : '';
$img_url			= !empty( $theme_settings ['hf_image']['url'] ) ? $theme_settings ['hf_image']['url'] : '';

while (have_posts()) : the_post();
	global $post;
	$profile_id	= doctreat_get_pofile_ID_by_post($post->ID);
?>
<div class="dc-haslayout dc-parent-section dcforum-single">
	<div class="container">
		<div class="row">
			<div class="<?php echo esc_attr($section_width); ?> <?php echo sanitize_html_class($content_class); ?>">
			<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $desc ) || !empty( $btn_text ) || !empty( $img_url ) ){?>
				<div class="dc-questionsection">
					<div class="dc-askquery">
						<div class="dc-postquestion">
							<?php if( !empty( $title ) || !empty( $sub_title )){?>
								<div class="dc-title">
									<?php if( !empty( $title ) ) {?><span><?php echo esc_html( $title );?></span><?php } ?>
									<?php if( !empty( $sub_title ) ) {?><h2><?php echo esc_html( $sub_title );?></h2><?php } ?>
								</div>
							<?php } ?>

							<?php if( !empty( $desc ) ){?>
								<div class="dc-description"><p><?php echo esc_html($desc);?></p></div>
							<?php } ?>

							<?php if( !empty( $btn_text ) ){?>
								<div class="dc-btnarea">
									<a href="#" data-toggle="modal" data-target="#freequery" class="dc-btn"><?php echo esc_html( $btn_text );?></a>
								</div>
							<?php } ?>
						</div>
						<?php if( !empty( $img_url ) ){?>
							<figure>
								<img src="<?php echo esc_url( $img_url);?>" alt="<?php esc_attr_e('Health Form','doctreat');?>">
							</figure>	
						<?php } ?>										
					</div>	
				</div>
			<?php } ?>
				<div class="dc-forumcomments">
					<div class="dc-forumcomments-details">
						<?php  if( !empty( $profile_id ) ){ do_action('doctreat_get_user_info_by_ID',$user_info_id); }?>
						<div class="dc-description"><?php the_content();?></div>
					</div>
					<?php comments_template();?>
				</div>
				<?php if (have_comments()) { ?>
					<div class="dc-docsingle-holder">
						<div class="tab-content dc-haslayout">
							<div class="dc-contentdoctab dc-feedback-holder" id="feedback">
								<div class="dc-feedback">
									<div class="dc-searchresult-head">
										<div class="dc-title"><h4><?php comments_number(esc_html__('0 Answers' , 'doctreat') , esc_html__('1 Answer' , 'doctreat') , esc_html__('% Answers' , 'doctreat')); ?></h4></div>
									</div>
									<div id="dc-comments" class="dc-consultation-content dc-forumcontent dc-comments">
										<ul><?php wp_list_comments(array ('callback' => 'doctreat_answers' ));?></ul>
										<?php the_comments_navigation(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<?php if ( is_active_sidebar( 'sidebar-forum' )) {?>
				<div class="col-12 col-md-5 col-lg-4 col-xl-3 float-left dc-sidebar-grid mt-md-0 <?php echo sanitize_html_class($aside_class); ?>">
					<aside id="dc-sidebar" class="dc-sidebar">
						<?php dynamic_sidebar( 'sidebar-forum' );  ?>
					</aside>
				</div>
			<?php }?>
		</div>
	</div>
</div>
<?php endwhile; ?>
<?php get_template_part('directory/post-question');?>
<?php
get_footer();
