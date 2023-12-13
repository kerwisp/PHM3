<?php
/**
 *
 * The template used for doctors experience
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */

global $post;

$post_id 		= $post->ID;
$am_experiences	= doctreat_get_post_meta( $post_id,'am_experiences');
if( !empty( $am_experiences ) ) {
?>
<div class="dc-experience-holder dc-experiencedoc dc-aboutinfo">
	<div class="dc-infotitle">
		<h3><?php esc_html_e('Experience','doctreat');?></h3>
	</div>
	<ul class="dc-expandedu">
		<?php 
			foreach( $am_experiences as $exp ){
				$company_name	= !empty( $exp['company_name'] ) ? $exp['company_name'] : '';
				$job_title		= !empty( $exp['job_title'] ) ? $exp['job_title'] : '';
				$job_description		= !empty( $exp['job_description'] ) ? $exp['job_description'] : '';
				$start		= !empty( $exp['start_date'] ) ? date_i18n('Y', strtotime($exp['start_date'])) : '';
				$ending		= !empty( $exp['ending_date'] ) ? date_i18n('Y', strtotime($exp['ending_date'])) : esc_html__('Present','doctreat');
				$des_class	= !empty($job_description) ? 'dc-tab-des-enb' : '';
				if( !empty( $job_title ) ){ ?>
					<li class="<?php echo esc_attr($des_class);?>">
						<div class="dc-subpaneltitle">
							<span>
								<?php echo esc_html( $job_title );?>
								<?php if( !empty( $start ) && !empty( $ending ) ){?><em>( <?php echo esc_html( $start );?> - <?php echo esc_html( $ending );?> )</em><?php } ?>
							</span>
							<?php if( !empty( $company_name ) ) { ?><em><?php echo esc_html( $company_name );?></em><?php } ?>
						</div>
						<?php if( !empty( $job_description ) ){?>
							<div class="dc-subpanelcontent">
								<div class="dc-description">
									<p><?php echo nl2br( $job_description );?></p>
								</div>
							</div>
						<?php } ?>
					</li>
			<?php } ?>
		<?php } ?>
	</ul>
</div>
<?php }