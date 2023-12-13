<?php
/**
 *
 * The template used for doctors post style
 *
 * @package   doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
global $theme_settings,$current_user,$post;
$redirect_unverified			= !empty( $theme_settings['redirect_unverified'] ) ? $theme_settings['redirect_unverified'] : '';

if(!empty($redirect_unverified) && $redirect_unverified === 'yes'){
	//if user is unverified and blocked then redirect to home page
	$profile_option	= get_post_meta( $post->ID, '_profile_blocked', true );
	$is_verified	= get_post_meta( $post->ID, '_is_verified', true );
	if( ( !empty($is_verified) && $is_verified === 'no' ) || ( !empty($profile_option) && $profile_option === 'on' ) ){
		wp_redirect(home_url('/'));
		die();
	}
}

get_header();

$booking_option			= doctreat_theme_option();
$doctor_detail_forum	= !empty( $theme_settings['doctor_detail_forum'] ) ? $theme_settings['doctor_detail_forum'] : '';
$enable_options			= !empty($theme_settings['doctors_contactinfo']) ? $theme_settings['doctors_contactinfo'] : '';

if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ 
	$section_width     	= 'col-12 col-lg-12 col-xl-9';
} else {
	$section_width     	= 'col-12 col-lg-12 col-xl-9';
}

$doctor_user_id	= '';

while ( have_posts() ) {
	the_post();
	global $post;
	$width			= 271;
	$height			= 194;
	$thumbnail      = doctreat_prepare_thumbnail($post->ID, $width, $height);
	$doctor_user_id	= doctreat_get_linked_profile_id($post->ID,'post');
	$profile_option	= get_post_meta( $post->ID, '_profile_blocked', true );
	$is_verified	= get_post_meta( $post->ID, '_is_verified', true );
	$profile_option	= !empty($profile_option) ? $profile_option : '';
	$post_meta		= doctreat_get_post_meta( $post->ID );
	$am_socials		= !empty($post_meta['am_socials']) ? $post_meta['am_socials'] : '';
	$social_settings	= array();
	if(function_exists('doctreat_get_social_media_icons_list')){
		$social_settings	= doctreat_get_social_media_icons_list('no');
	}

	$social_available = 'no';
	if(!empty($social_settings) && is_array($social_settings) ) {
		foreach($social_settings as $key => $val ) {
			if(!empty($am_socials[$key])){
				$social_available = 'yes';
				break;
			}
		}
	}
	
	
	$social_sidebar	= array();
	
	$social_sidebar['social_available']	= $social_available;
	$social_sidebar['social_settings']	= $social_settings;

	$latitude		    = get_post_meta( $post->ID , '_latitude',true );
	$longitude		    = get_post_meta( $post->ID , '_longitude',true );
	?>
	<div class="dc-haslayout dc-parent-section">
		<div class="container">
			<div class="row">
				<div id="dc-twocolumns" class="dc-twocolumns dc-haslayout">
					<?php if( !empty($profile_option) && $profile_option ==='on' ){
						do_action('doctreat_empty_records_html','dc-empty-hospital-location',esc_html__( 'The profile is a temporary block from user.', 'doctreat' ));
					} else { ?>
						<div class="<?php echo esc_attr($section_width);?> float-left">
							<?php get_template_part('directory/front-end/templates/doctors/single/basic'); ?>
							<div class="dc-docsingle-holder">
								<ul class="dc-navdocsingletab nav navbar-nav">
									<li class="nav-item dc-available-location">
										<a data-toggle="tab" href="#locations"><?php esc_html_e('Available Locations','doctreat');?></a>
									</li>
									<li class="nav-item dc-doctor-detail">
										<a id="userdetails-tab" class="active" data-toggle="tab" href="#userdetails"><?php esc_html_e('Doctor Details','doctreat');?></a>
									</li>
									<?php if( !empty($doctor_detail_forum) && $doctor_detail_forum === 'no' ){?>
										<li class="nav-item dc-forum-section">
											<a id="comments-tab" data-toggle="tab" href="#comments"><?php esc_html_e('Forum Discussion','doctreat');?></a>
										</li>
									<?php }?>
									<li class="nav-item dc-doc-feedback">
										<a id="feedback-tab" data-toggle="tab" href="#feedback"><?php esc_html_e('Feedback','doctreat');?></a>
									</li>
									<li class="nav-item  dc-doc-articles">
										<a id="articles-tab" data-toggle="tab" href="#articles"><?php esc_html_e('Articles','doctreat');?></a>
									</li>
								</ul>
								<div class="tab-content dc-contentdoctab dc-haslayout">
									<?php get_template_part('directory/front-end/templates/doctors/single/locations'); ?>
									<?php get_template_part('directory/front-end/templates/doctors/single/userdetails'); ?>
									<?php if( !empty($doctor_detail_forum) && $doctor_detail_forum === 'no' ){get_template_part('directory/front-end/templates/doctors/single/consultation');}?>
									<?php  get_template_part('directory/front-end/templates/doctors/single/feedback'); ?>
									<?php get_template_part('directory/front-end/templates/doctors/single/articles'); ?>
									<div class="dc-shareprofile">
										<?php doctreat_prepare_social_sharing( false,esc_html__('Share Profile','doctreat'),true,'dc-simplesocialicons dc-socialiconsborder',$thumbnail ); ?>
									</div>
								</div>
							</div>
						</div>
						<?php if(  is_active_sidebar( 'doctor-sidebar-right' ) 
								 || ( !empty($social_available) && $social_available === 'yes' )
								 || (!empty($latitude) && !empty($longitude) && !empty($enable_options))
							){ ?>
							<div class="col-12 col-md-6 col-lg-6 col-xl-3 float-left">
								<aside id="dc-sidebar" class="dc-sidebar dc-sidebar-grid float-left mt-xl-0">
									<?php
										get_template_part('directory/front-end/templates/doctors-location-sidebar');
										get_template_part('directory/front-end/templates/sidebar-social','',$social_sidebar);
										if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ 
											dynamic_sidebar( 'doctor-sidebar-right' );
										}
									?>
								</aside>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php
if( ( empty($profile_option) || $profile_option ==='off' ) && !empty($doctor_user_id) && $doctor_user_id !== $current_user->ID  && ( apply_filters('doctreat_is_feature_allowed', 'dc_chat', $doctor_user_id) === true )
) {
	get_template_part('directory/front-end/templates/messages'); 
}
	
if ( is_user_logged_in() ) {
	get_template_part('directory/front-end/templates/doctors/single/addfeedback');
}

get_template_part('directory/front-end/templates/doctors/single/bookings'); 
	
}

get_footer(); 