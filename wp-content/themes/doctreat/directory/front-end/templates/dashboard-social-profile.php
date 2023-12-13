<?php
/**
 *
 * The template part for displaying social profile 
 *
 * @package   doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */

global $current_user,$theme_settings;

$user_identity 	 	= $current_user->ID;
$linked_profile  	= doctreat_get_linked_profile_id($user_identity);
$user_type			= apply_filters('doctreat_get_user_type', $user_identity );
$social_links	= !empty( $theme_settings['social_links'] ) ? $theme_settings['social_links'] : '';
$am_socials		= doctreat_get_post_meta( $linked_profile, 'am_socials');

if(!empty($social_links) && $social_links === 'yes'){	
	$social_settings    = function_exists('doctreat_get_social_media_icons_list') ? doctreat_get_social_media_icons_list('no') : array();
?>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">		
	<form class="dc-social-profile" method="post">	
		<div class="dc-dashboardbox dc-dashboardtabsholder">
			<?php get_template_part('directory/front-end/templates/doctors/dashboard', 'profile-settings-tabs'); ?>
			<div class="dc-tabscontent tab-content">
				<div class="dc-yourdetails dc-tabsinfo">
					<div class="dc-tabscontenttitle">
						<h3><?php esc_html_e('Social profiles', 'doctreat'); ?></h3>
					</div>
					<div class="dc-formtheme dc-userform social-profiles-wrap">
						<fieldset>
							<?php
							if(!empty($social_settings)) {
								foreach($social_settings as $key => $val ) {
									$icon		= !empty( $val['icon'] ) ? $val['icon'] : '';
									$classes	= !empty( $val['classses'] ) ? $val['classses'] : '';
									$placeholder	= !empty( $val['placeholder'] ) ? $val['placeholder'] : '';
									$color			= !empty( $val['color'] ) ? $val['color'] : '#484848';
									$social_url		= '';
									$social_url		= !empty($am_socials[$key]) ? $am_socials[$key] : '';
									
									$is_enabled		= !empty($theme_settings[$key]) ? $theme_settings[$key] : '';
									if(!empty($is_enabled)){
									?>
										<div class="form-group form-group-half  dc-inputwithicon <?php echo esc_attr( $classes );?>">
											<i class="dc-icon <?php echo esc_attr( $icon );?>" style="color:<?php echo esc_attr( $color );?> !important"></i>
											<input type="text" name="basics[<?php echo esc_attr($key);?>]" class="form-control" value="<?php echo esc_attr($social_url); ?>" placeholder="<?php echo esc_attr($placeholder); ?>">
										</div>
								<?php }} ?>
							<?php } ?>
						</fieldset>
					</div>
				</div>
			</div>
		</div>
		<div class="dc-updatall">
			<i class="ti-announcement"></i>
			<span><?php esc_html_e('Update all the latest changes made by you, by just clicking on Save &amp; Update button.', 'doctreat'); ?></span>
			<a class="dc-btn dc-update-social-link" data-id="<?php echo esc_attr( $user_identity ); ?>" data-post="<?php echo esc_attr( $linked_profile ); ?>" href="javascript:;"><?php esc_html_e('Save &amp; Update', 'doctreat'); ?></a>
		</div>	
	</form>		
</div>
<?php }