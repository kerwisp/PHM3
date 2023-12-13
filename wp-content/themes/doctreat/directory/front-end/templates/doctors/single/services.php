	<?php
/**
 *
 * The template used for displaying doctors services
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://amentotech.com/user/amentotech/portfolio
 * @version 1.0
 * @since 1.0
 */
global $post,$theme_settings;
$post_id 			= $post->ID;
$am_specialities	= doctreat_get_post_meta( $post_id,'am_specialities');
if( !empty( $am_specialities ) ) {
    /* show services according to doctor package */
    $hide_service_accord_package	= !empty( $theme_settings['hide_services_by_package'] ) ? $theme_settings['hide_services_by_package'] : 'no';
    $author_id                      = get_post_field ('post_author', $post_id);
    $no_service_in_package          = doctreat_get_subscription_metadata('dc_services',$author_id);
    ?>
<div class="dc-services-holder dc-aboutinfo">
	<div class="dc-infotitle">
		<h3><?php esc_html_e('Offered Services','doctreat');?></h3>
	</div>
	<div id="dc-accordion" class="dc-accordion" role="tablist" aria-multiselectable="true">
		<?php
			foreach ( $am_specialities as $key => $specialities) {
				$specialities_title	= doctreat_get_term_name($key ,'specialities');
				$logo 				= get_term_meta( $key, 'logo', true );
				$logo				= !empty( $logo['url'] ) ? $logo['url'] : '';
				$services			= !empty( $specialities ) ? $specialities : '';
				$service_count		= !empty($services) ? count($services) : 0;
			?>
			<div class="dc-panel">
				<?php if( !empty( $specialities_title ) ){?>
					<div class="dc-paneltitle">
						<?php if( !empty( $logo ) ){?>
							<figure class="dc-titleicon">
								<img src="<?php echo esc_url( $logo );?>" alt="<?php echo esc_attr( $specialities_title );?>">
							</figure>
						<?php } ?>
						<span>
							<?php echo esc_html( $specialities_title );?>
							 <?php if( !empty( $service_count ) ){
                                if($hide_service_accord_package === 'yes' && ($service_count > $no_service_in_package) ) {?>
                                    <em><?php echo intval($no_service_in_package);?>&nbsp;<?php esc_html_e( 'Service(s)','doctreat');?></em>
                                <?php } else {?>
								    <em><?php echo intval($service_count);?>&nbsp;<?php esc_html_e( 'Service(s)','doctreat');?></em>
							 <?php } } ?>
						 </span>
					</div>
				<?php } ?>
				
				<?php if( !empty( $services ) ){ ?>
					<div class="dc-panelcontent">
						<div class="dc-childaccordion" role="tablist" aria-multiselectable="true">
							<?php
                                $count = 0;
								foreach ( $services as $key => $service ) {
                                    /* Show service according to Package */
                                    if($hide_service_accord_package === 'yes') {
                                        $count = $count + 1;
                                        if ($count > $no_service_in_package) {
                                            break;
                                        }
                                    }
									$service_title	= doctreat_get_term_name($key ,'services');
									$service_title	= !empty( $service_title ) ? $service_title : '';
									$service_price	= !empty( $service['price'] ) ? $service['price'] : '';
									$description	= !empty( $service['description'] ) ? $service['description'] : '';
								?>
								<div class="dc-subpanel">
									<?php if( !empty( $service_title ) ) { ?>
										<div class="dc-subpaneltitle">
											<span>
												<?php echo esc_html( $service_title );?>
												<?php if( !empty( $service_price ) ) {?><em><?php doctreat_price_format($service_price); ?></em><?php } ?>
											</span>
										</div>
									<?php } ?>
									<?php if( !empty( $description ) ){?>
										<div class="dc-subpanelcontent">
											<div class="dc-description">
												<p><?php echo nl2br( $description );?></p>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>	
		<?php } ?>
	</div>
</div>
<?php } ?>
<?php
	$inline_script = 'jQuery(document).on("ready", function() { 
		themeAccordion();
		childAccordion(); });';
	wp_add_inline_script( 'doctreat-callback', $inline_script, 'after' );