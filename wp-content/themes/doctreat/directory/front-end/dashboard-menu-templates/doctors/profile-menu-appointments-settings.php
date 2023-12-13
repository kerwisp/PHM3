<?php
/**
 *
 * The template part for displaying the dashboard menu
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */

global $current_user, $theme_settings;

$reference 		 = (isset($_GET['ref']) && $_GET['ref'] <> '') ? $_GET['ref'] : '';
$mode 			 = (isset($_GET['mode']) && $_GET['mode'] <> '') ? $_GET['mode'] : '';
$url_identity 	= $current_user->ID;
$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : 'hospitals';

if( apply_filters('doctreat_is_appointment_allowed', 'dc_bookings', $url_identity) === true ){
	if(!empty($doctor_location) && $doctor_location === 'both'){?>
	<li class="menu-item-has-children <?php echo esc_attr( $reference === 'appointment' && ( $mode ==='setting' || $mode === 'location-settings' ) ? 'dc-active' : ''); ?>">
		<span class="dc-dropdowarrow"><i class="lnr lnr-chevron-right"></i></span>
		<a href="javascript:;">
			<i class="ti-clipboard"></i>
			<span><?php esc_html_e('Appointment Settings','doctreat');?></span>
		</a>
		<ul class="sub-menu" style="display:<?php echo esc_attr( $reference === 'appointment' && ( $mode ==='setting' || $mode === 'location-settings' ) ? 'block' : ''); ?>">
			<li class="<?php echo esc_attr( $reference === 'appointment' && $mode ==='setting' ? 'dc-active' : ''); ?>">
				<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('appointment', $url_identity,'','setting'); ?>">
					<span><?php esc_html_e('Hospital Settings','doctreat');?></span>
				</a>
			</li>
			<li class="<?php echo esc_attr( $reference === 'appointment' && $mode === 'location-settings' ? 'dc-active' : ''); ?>">
				<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('appointment', $url_identity,'','location-settings'); ?>">
					<span><?php esc_html_e('Clinic Settings','doctreat');?></span>
				</a>
			</li>
		</ul>
	</li>
<?php }else if(!empty($doctor_location) && $doctor_location === 'clinic'){?>
	<li class="<?php echo esc_attr( $reference === 'appointment' && $mode ==='setting' ? 'dc-active' : ''); ?>">
		<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('appointment', $url_identity,'','location-settings'); ?>">
			<i class="ti-clipboard"></i>
			<span><?php esc_html_e('Appointment Settings','doctreat');?></span>
		</a>
	</li>
<?php }else if(!empty($doctor_location) && $doctor_location === 'hospitals'){?>
	<li class="<?php echo esc_attr( $reference === 'appointment' && $mode ==='setting' ? 'dc-active' : ''); ?>">
		<a href="<?php Doctreat_Profile_Menu::doctreat_profile_menu_link('appointment', $url_identity,'','setting'); ?>">
			<i class="ti-clipboard"></i>
			<span><?php esc_html_e('Appointment Settings','doctreat');?></span>
		</a>
	</li>
<?php }
}