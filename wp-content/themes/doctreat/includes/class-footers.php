<?php
/**
 *
 * Class used as base to create theme footer
 *
 * @package   Doctreat
 * @author    amentotech
 * @link      https://themeforest.net/user/amentotech/portfolio
 * @since 1.0
 */
if (!class_exists('Doctreat_Prepare_Footers')) {

    class Doctreat_Prepare_Footers {

        function __construct() {
            add_action('doctreat_do_process_footers', array(&$this, 'doctreat_do_process_footers'));
        }

        /**
         * @Prepare Footer
         * @return {}
         * @author amentotech
         */
        public function doctreat_do_process_footers() { ?>
            </main>    
            <?php 

			//hide for dashboard
			if (is_page_template('directory/dashboard.php')) {
				echo '</div>';
			} else{
				$this->doctreat_do_process_footer_v1();
			}

		}

        /**
         * @Prepare Footer V1
         * @return {}
         * @author amentotech
         */
        public static function doctreat_do_process_footer_v1() {
			global $theme_settings;
			$footer_type		= !empty( $theme_settings['footer_type'] ) ? $theme_settings['footer_type'] : '';
			$contact_section	= !empty( $theme_settings['footer_contact_section'] ) ? $theme_settings['footer_contact_section'] : '';
			$emergency_text		= !empty( $theme_settings['emergency_text'] ) ? $theme_settings['emergency_text'] : '';
			$emergency_phone	= !empty( $theme_settings['emergency_phone'] ) ? $theme_settings['emergency_phone'] : '';
			$emergency_logo		= !empty( $theme_settings['emergency_logo'] ) ? $theme_settings['emergency_logo']['url'] : '';
			$emergency_email_text		= !empty( $theme_settings['emergency_email_text'] ) ? $theme_settings['emergency_email_text'] : '';
			$emergency_email			= !empty( $theme_settings['emergency_email'] ) ? $theme_settings['emergency_email'] : '';
			$emergency_support_logo		= !empty( $theme_settings['emergency_support_logo'] ) ? $theme_settings['emergency_support_logo']['url'] : '';
			
			$footer_copyright	= !empty( $theme_settings['copyright'] ) ? $theme_settings['copyright'] : '';

			$blogname 	= wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);
			$copryclass	= 'dc-widget-disbaled';
			

            ?>
            <footer id="dc-footer" class="dc-footer dc-haslayout">
            	<?php if( !empty( $contact_section ) ) {?>
					<div class="dc-footertopbar">
						<div class="container">
							<div class="row">
								<div class="col-12">
									<div class="dc-fcall-email-wrap">
										<div class="dc-footer-call-email">
											<?php if( !empty( $emergency_logo ) || !empty( $emergency_phone ) ) {?>
												<div class="dc-callinfoholder">
													<?php if( !empty( $emergency_logo ) ) {?>
														<figure class="dc-callinfoimg">
															<img width="" height="" src="<?php echo esc_url($emergency_logo);?>" alt="<?php echo esc_attr($blogname);?>">
														</figure>
													<?php } ?>
													<?php if( !empty( $emergency_phone ) && !empty( $emergency_text ) ){?>
														<div class="dc-callinfocontent">
															<h3><span><?php echo sanitize_textarea_field($emergency_text);?></span> <a href="tel:<?php echo esc_html($emergency_email);?>"><?php echo sanitize_textarea_field($emergency_phone);?></a></h3>
														</div>
													<?php } ?>
												</div>
											<?php } ?>
											<?php if( !empty( $emergency_support_logo ) || !empty( $emergency_email_text ) ){?>
												<div class="dc-callinfoholder dc-mailinfoholder">
													<?php if( !empty( $emergency_support_logo ) ){?>
														<figure class="dc-callinfoimg">
															<img width="" height="" src="<?php echo esc_url($emergency_support_logo);?>" alt="<?php echo esc_attr($blogname);?>">
														</figure>
													<?php } ?>
													<?php if( !empty( $emergency_email_text ) && !empty( $emergency_email ) ){?>
														<div class="dc-callinfocontent">
															<?php if( is_email( $emergency_email ) ){?>
															<h3><span><?php echo esc_html($emergency_email_text);?></span> <a href="mailto:<?php echo sanitize_email($emergency_email);?>"><?php echo esc_html($emergency_email);?></a></h3>
															<?php }else{?>
																<h3><span><?php echo esc_html($emergency_email_text);?></span> <a href="mailto:<?php echo esc_html($emergency_email);?>"><?php echo esc_html($emergency_email);?></a></h3>
															<?php }?>
														</div>
													<?php } ?>
												</div>
												<span class="dc-or-text"><?php esc_html_e('- OR -','doctreat');?></span>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				<?php }?>
				<?php 
				if( is_active_sidebar( 'footer-col-1' )
				  || is_active_sidebar( 'footer-col-2' )
				  || is_active_sidebar( 'footer-col-3' )
				  ){
					$copryclass	= 'dc-widget-enabled';
					?>
					<div class="dc-fthreecolumns">
						<div class="container">
							<div class="row">
								<?php if ( is_active_sidebar( 'footer-col-1' ) ) {?>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 float-left">
										<?php dynamic_sidebar( 'footer-col-1' );?>
									</div>
								<?php }?>
								<?php if ( is_active_sidebar( 'footer-col-2' ) ) {?>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 float-left">
										<?php dynamic_sidebar( 'footer-col-2' );?>
									</div>
								<?php }?>
								<?php if ( is_active_sidebar( 'footer-col-3' ) ) {?>
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 float-left">
										<?php dynamic_sidebar( 'footer-col-3' );?>
									</div>
								<?php }?>
							</div>
						</div>
					</div>
				<?php } ?>
				<?php if( !empty( $footer_copyright ) ) { ?>
					<div class="dc-footerbottom <?php echo esc_attr( $copryclass );?>">
						<div class="container">
							<div class="row">
								<div class="col-12 col-sm-12">
									<p class="dc-copyright"><?php echo do_shortcode( $footer_copyright );?></p>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</footer>
			</div>
			
			<?php 

        }
    }
    new Doctreat_Prepare_Footers();
}