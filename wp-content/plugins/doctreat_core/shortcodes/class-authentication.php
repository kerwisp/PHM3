<?php
/**
 * File Type : Authentication
 */
if (!class_exists('SC_Doctreat_Authentication')) {

    class SC_Doctreat_Authentication {

        /**
         * Construct Shortcode
         */
        public function __construct() {
            add_shortcode('doctreat_authentication', array(&$this, 'shortCodeCallBack'));
        }

		
        /**
         * Return Authentication Result
         */
        public function shortCodeCallBack($atts) {
			global $current_user, $wp_roles,$theme_settings;		
			$atts = shortcode_atts( array(
						'title' 		=> '',
					), $atts, 'doctreat_authentication' );
			
			ob_start();			                     
                      
            $site_key 				= '';
            $protocol 				= is_ssl() ? 'https' : 'http';

            $login_register 		= !empty( $theme_settings['user_registration'] ) ? $theme_settings['user_registration'] : '';       
			$registration_form 		= !empty( $theme_settings['registration_form'] ) ? $theme_settings['registration_form'] : '';       
			$login_form 			= !empty( $theme_settings['login_form'] ) ? $theme_settings['login_form'] : '';           
            $redirect   			= !empty( $_GET['redirect'] ) ? esc_url( $_GET['redirect'] ) : '';
			$enable_phone 			= !empty( $theme_settings['enable_phone'] ) ? $theme_settings['enable_phone'] : '';       
			
			$reg_option 	= !empty( $theme_settings['user_type_registration'] ) ? $theme_settings['user_type_registration'] : array();
			$step_image 	= !empty( $theme_settings['step_image']['url'] ) ? $theme_settings['step_image']['url'] : ''; 
			$step_title 	= !empty( $theme_settings['step_title'] ) ? $theme_settings['step_title'] : esc_html__('Join For a Good Start', 'doctreat_core');
			$step_desc 		= !empty( $theme_settings['step_description'] ) ? $theme_settings['step_description'] : ''; 
			$term_text 		= !empty( $theme_settings['term_text'] ) ? $theme_settings['term_text'] : '';
			$remove_location 		= !empty( $theme_settings['remove_location'] ) ? $theme_settings['remove_location'] : 'no';
			$terms_link 	= !empty( $theme_settings['term_page'] ) ? get_permalink( intval( $theme_settings['term_page'] ) ) : '';
			
			$user_types		= array();      
			if( function_exists( 'doctreat_list_user_types' ) ) {
				$user_types	= doctreat_list_user_types();
			}
			
		    if (!is_user_logged_in()) {?>
			 <div class="dc-haslayout dc-parent-section">
				<div class="row justify-content-md-center">
					<div class="col-xs-12 col-sm-12 col-md-10 push-md-1 col-lg-8 push-lg-2">
						<div class="dc-registerformhold">
							<form class="dc-formtheme dc-formregister">
								<div class="tab-content dc-registertabcontent">
									<div class="dc-registerformmain">
										<?php if( !empty( $step_image ) ){?>
											<figure class="dc-joinformsimg">
												<img src="<?php echo esc_url( $step_image ); ?>" alt="<?php esc_html_e('Registration', 'doctreat_core'); ?>">
											</figure>
										<?php }?>
										<?php if( !empty( $step_title ) || !empty( $step_desc ) ) { ?>
											<div class="dc-registerhead">
												<?php if( !empty( $step_title ) ) { ?>
													<div class="dc-title">
														<h3><?php echo esc_attr( $step_title ); ?></h3>
													</div>
												<?php } ?>
												<?php if( !empty( $step_desc ) ) { ?>
													<div class="description">
														<?php echo do_shortcode( $step_desc ); ?>
													</div>
												<?php } ?>
											</div>
										<?php } ?>
										<div class="dc-joinforms">
											<fieldset class="dc-registerformgroup">
												<div class="form-group form-group-half">
													<input type="text" name="first_name" class="form-control" value="" placeholder="<?php esc_attr_e('First Name', 'doctreat_core'); ?>">
												</div>
												<div class="form-group form-group-half">
													<input type="text" name="last_name" value="" class="form-control" placeholder="<?php esc_attr_e('Last Name', 'doctreat_core'); ?>">
												</div>
												<div class="form-group form-group-half">
													<input type="text" name="username" class="form-control" value="" placeholder="<?php esc_attr_e('username', 'doctreat_core'); ?>">
												</div>

												<div class="form-group form-group-half">
													<input type="email" name="email" class="form-control" value="" placeholder="<?php esc_attr_e('Email', 'doctreat_core'); ?>">
												</div>
											</fieldset>
											
											<fieldset class="dc-registerformgroup">
												<?php if(!empty($remove_location) && $remove_location == 'no'){?>
													<div class="form-group">
														<span class="dc-select">
															<?php do_action('doctreat_get_locations_list','location',''); ?>	
														</span>
													</div>
												<?php }?>
												<?php if(!empty($enable_phone) ){?>
													<div class="form-group toolip-wrapo">
														<input type="text" name="am_mobile_number" class="form-control" value="" placeholder="<?php esc_attr_e('Personal mobile number*', 'doctreat_core'); ?>">
														<?php do_action('doctreat_get_tooltip','element','am_phone_numbers');?>
													</div>
												<?php }?>
												<div class="form-group form-group-half">
													<input type="password" name="password" class="form-control" placeholder="<?php esc_html_e('Password*', 'doctreat_core' ); ?>">
												</div>
												<div class="form-group form-group-half">
													<input type="password" name="verify_password" class="form-control" placeholder="<?php esc_html_e('Retype Password*', 'doctreat_core' ); ?>">
												</div>
											</fieldset>
											
											<fieldset class="dc-formregisterstart">
												<div class="dc-title dc-formtitle"><h4><?php esc_html_e('Start as :', 'doctreat_core' ); ?></h4></div>
												<?php if( !empty( $user_types ) ){ ?>
													<ul class="dc-startoption">
														<?php
															foreach( $user_types as $key => $val) {
																$checked	= !empty( $key ) && $key === 'doctors' ? 'checked=""' : '';
																$display	= !empty( $key ) && $key === 'seller' ? esc_html__('Store name','doctreat_core') : esc_html__('Display name','doctreat_core');
																if( !empty($reg_option) && in_array($key,$reg_option)){?>
																<li>
																	<span class="dc-radio" data-display="<?php echo esc_attr($display);?>">
																		<input id="dc-<?php echo esc_attr($key);?>" type="radio" name="user_type" value="<?php echo esc_attr($key);?>" <?php echo esc_attr($checked);?>>
																		<label for="dc-<?php echo esc_attr($key);?>"><?php echo esc_html($val);?></label>
																	</span>
																</li>
															<?php } ?>
														<?php } ?>
													</ul>
												<?php } ?>
											</fieldset>
											<fieldset class="dc-termsconditions">
												<div class="dc-checkboxholder">
													<div class="form-group form-group-half wt-display-type">
														<input type="text" name="display_name" class="form-control" value="" placeholder="<?php esc_attr_e('Display Name', 'doctreat_core'); ?>">
													</div>								
													<span class="dc-checkbox">
														<input id="termsconditions" type="checkbox" name="termsconditions" value="checked">
														<label for="termsconditions">
															<span>
																<?php echo esc_html( $term_text ); ?>
																<?php if( !empty( 	$terms_link ) ) { ?>
																	<a target="_blank" href="<?php echo esc_url( $terms_link ); ?>">
																		<?php esc_html_e('Terms & Conditions', 'doctreat_core'); ?>
																	</a>
																<?php } ?>
															</span>
														</label>
													</span>	
													<div class="form-group">
														<button class="dc-btn rg-step-start" type="submit"><?php esc_html_e('Signup Now', 'doctreat_core'); ?></button>
													</div>							
												</div>
											</fieldset>
										</div>
									</div>
								</div>    
								<?php if( !is_user_logged_in() ){ ?>
									<div class="dc-registerformfooter">
										<span><?php esc_html_e('Already Have an Account?', 'doctreat_core' ); ?><a class="dc-loginbtn" data-toggle="modal" data-target="#dc-loginpopup" href="javascript:;">&nbsp;<?php esc_html_e('Login Now', 'doctreat_core'); ?></a></span>
									</div>
								<?php } ?>
							</form>                                        
						</div>                                        
					</div>
				</div>
			</div>
			<?php
			}
			echo ob_get_clean();
        }
      
    }
    new SC_Doctreat_Authentication();
}