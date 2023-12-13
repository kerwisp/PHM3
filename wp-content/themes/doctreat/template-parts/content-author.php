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

$section_width = 'col-xs-12 col-sm-12 col-md-12 col-lg-8';
$aside_class 	= 'pull-right';
$content_class  = 'pull-left';
$object_id 			= get_queried_object_id();
$udata      		= get_userdata($object_id);
$registered 		= $udata->user_registered;
$facebook	   		= get_user_meta( $object_id, 'facebook', true);
$twitter	   		= get_user_meta( $object_id, 'twitter', true);
$linkedin	   		= get_user_meta( $object_id, 'linkedin', true);
$pinterest	   		= get_user_meta( $object_id, 'pinterest', true);
$google_plus	    = get_user_meta( $object_id, 'google_plus', true);
$instagram	   		= get_user_meta( $object_id, 'instagram', true);
$tumblr	   			= get_user_meta( $object_id, 'tumblr', true);
$skype	   			= get_user_meta( $object_id, 'skype', true);
$user_post_count    = count_user_posts( $object_id , 'post' );
?>
<div class="<?php echo esc_attr( $section_width );?> page-section <?php echo sanitize_html_class($content_class); ?>">
	<?php get_template_part( 'template-parts/archive-templates/content', 'list' );?>
</div>
<aside id="dc-sidebar" class="col-xs-12 col-sm-12 col-md-12 col-lg-4 dc-sidebar-grid mt-lg-0 <?php echo sanitize_html_class($aside_class); ?>">
	<div class="dc-author">
		<div class="dc-authordetails">
			<?php if( !empty( $object_id ) ){?>
				<figure><?php echo get_avatar($object_id, 150); ?></figure>
			<?php }?>
			<div class="dc-authorcontent">
				<div class="dc-authorhead">
					<div class="dc-boxleft">
						<h3><?php echo get_the_author(); ?></h3>
						<span><?php esc_html_e('Author Since', 'doctreat'); ?>:&nbsp;<?php echo date(get_option('date_format'), strtotime($registered)); ?></span> 
					</div>
				</div>
			</div>
			<?php if ( get_the_author_meta( 'description',$object_id ) ) : ?>
				<div class="dc-description"><p><?php the_author_meta( 'description',$object_id ); ?></p></div>
			<?php endif; ?>
			<?php
			$facebook  = get_the_author_meta('facebook', $object_id);
			$twitter   = get_the_author_meta('twitter', $object_id);
			$pinterest = get_the_author_meta('pinterest', $object_id);
			$linkedin  = get_the_author_meta('linkedin', $object_id);
			$tumblr    = get_the_author_meta('tumblr', $object_id);
			$google    = get_the_author_meta('google', $object_id);
			$instagram = get_the_author_meta('instagram', $object_id);
			$skype     = get_the_author_meta('skype', $object_id);

			if (!empty($facebook) || 
				!empty($twitter) || 
				!empty($pinterest) || 
				!empty($linkedin) || 
				!empty($tumblr) || 
				!empty($google) || 
				!empty($instagram) 
				|| !empty($skype) ) {
				?>
				<div class="dc-boxright">
					<ul class="dc-socialiconssimple">
						<?php if (!empty($facebook)) { ?>
							<li class="dc-facebook">
								<a href="<?php echo esc_url($facebook); ?>">
									<i class="fab fa-facebook-f"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($twitter)) { ?>
							<li class="dc-twitter">
								<a href="<?php echo esc_url($twitter); ?>">
									<i class="fab fa-twitter"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($pinterest)) { ?>
							<li class="dc-dribbble">
								<a href="<?php echo esc_url($pinterest); ?>">
									<i class="fab fa-pinterest-p"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($linkedin)) { ?>
							<li class="dc-linkedin">
								<a href="<?php echo esc_url($linkedin); ?>">
									<i class="fab fa-linkedin"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($tumblr)) { ?>
							<li class="dc-tumblr">
								<a href="<?php echo esc_url($tumblr); ?>">
									<i class="fab fa-tumblr"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($google)) { ?>
							<li class="dc-googleplus">
								<a href="<?php echo esc_url($google); ?>">
									<i class="fab fa-google"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($instagram)) { ?>
							<li class="dc-dribbble">
								<a href="<?php echo esc_url($instagram); ?>">
									<i class="fab fa-instagram"></i>
								</a>
							</li>
						<?php } ?>
						<?php if (!empty($skype)) { ?>
							<li  class="dc-skype">
								<a href="<?php echo esc_url($skype); ?>">
									<i class="fab fa-skype"></i>
								</a>
							</li>
						<?php } ?>
					</ul>
				</div>
			<?php } ?>
		</div>
	</div>
	<?php 
		if ( is_active_sidebar( 'sidebar-1' ) ) {
			get_sidebar();
		}
	?>
</aside>
			
