<?php
/**
 *
 * The template used for displaying hodpital post style
 *
 * @package   doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

get_header();
$section_width     	= 'col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-9';

if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ 
	$section_width     	= 'col-12 col-lg-12 col-xl-9';
} else {
	$section_width     	= 'col-12 col-lg-12 col-xl-9';
}

while ( have_posts() ) {
the_post();
global $post;

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

?>
<div class="dc-haslayout dc-parent-section">
	<div class="container">
		<div class="row">
			<div id="dc-twocolumns" class="dc-twocolumns dc-haslayout">
				<div class="<?php echo esc_attr($section_width);?> float-left">
					<?php get_template_part('directory/front-end/templates/hospitals/single/basic'); ?>
					<div class="dc-docsingle-holder dc-hospsingle-holder">
						<ul class="dc-navdocsingletab nav navbar-nav">
							<li class="nav-item">
								<a data-toggle="tab" href="#locations"><?php esc_html_e('Onboard Doctors','doctreat');?></a>
							</li>
							<li class="nav-item">
								<a class="active" id="userdetails-tab" data-toggle="tab" href="#userdetails"><?php esc_html_e('Hospital Details','doctreat');?></a>
							</li>
						</ul>
						<div class="tab-content dc-haslayout">
							<?php get_template_part('directory/front-end/templates/hospitals/single/onboarddoctors'); ?>
							<?php get_template_part('directory/front-end/templates/hospitals/single/userdetails'); ?>
						</div>
					</div>
				</div>
				
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xl-3 float-left">
						<aside id="dc-sidebar" class="dc-sidebar dc-sidebar-grid float-left mt-xl-0">
							<?php
								get_template_part('directory/front-end/templates/location-sidebar');
								get_template_part('directory/front-end/templates/sidebar-social','',$social_sidebar);
								if(  is_active_sidebar( 'doctor-sidebar-right' ) ){ 
									dynamic_sidebar( 'doctor-sidebar-right' );
								}
							?>
						</aside>
					</div>
				
			</div>
		</div>
	</div>
</div>
<?php }
get_footer(); 
