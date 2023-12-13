<?php 
/**
 *
 * The template part for displaying doctors in listing
 *
 * @package   Doctreat
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @since 1.0
 */
global $post,$theme_settings;
$post_id 		= !empty( $args['post_id']) ? $args['post_id'] : '';
$user_id		= doctreat_get_linked_profile_id($post->ID,'post');
$location_id	= get_post_meta($post_id, '_doctor_location',true);
$doctor_location	= !empty($theme_settings['doctor_location']) ? $theme_settings['doctor_location'] : '';
$location		= doctreat_get_location($location_id);
$location		= !empty( $location['_country'] ) ? $location['_country'] : '';
$bookig_days	= doctreat_get_booking_clinic_days( $user_id );
$bookig_days	= !empty( $bookig_days ) ? $bookig_days : array();

if ( 'publish' !== get_post_status ( $location_id ) ) {
    return;
}

if(!empty($doctor_location) && $doctor_location !== 'hospitals' && !empty($location_id)){?>
<div class="dc-docpostholder dc-search-hospitals">
	<div class="dc-docpostcontent">
		<div class="dc-searchvtwo">
			<?php do_action('doctreat_get_doctor_thumnail',$location_id);?>
			<?php do_action('doctreat_get_doctor_clinic_details',$location_id);?>
		</div>
		<div class="dc-doclocation dc-doclocationvtwo">
			<?php if( !empty( $location ) ){?>
				<span><i class="ti-direction-alt"></i><?php echo esc_html( $location );?></span>
			<?php } ?>
			<?php if( !empty( $bookig_days ) ){?>
				<span>
					<i class="lnr lnr-clock"></i><?php 
						$total_bookings	= count( $bookig_days );
						$start			= 0;
						foreach( $bookig_days as $val ){ 
							$day_name	= doctreat_get_week_keys_translation($val);
							$start ++;
							if( $val == $day ){  
								$availability	= 'yes';
								echo '<em class="dc-bold">'.$day_name.'</em>'; 
							} else {
								echo esc_html( $day_name );
							}
							if( $start != $total_bookings ) {
								echo ', ';
							}
						}
					?>
				</span>
			<?php } ?>
		</div>
	</div>
</div>
<?php }