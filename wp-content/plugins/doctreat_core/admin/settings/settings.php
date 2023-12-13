<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://themeforest.net/user/amentotech/portfolio
 * @since      1.0.0
 *
 * @package    doctreat
 * @subpackage doctreat/admin
 */
/**
 * @init            Theme Admin Menu init
 * @package         Amentotech
 * @subpackage      doctreat_core/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if (!function_exists('doctreat_core_admin_menu')) {
    add_action('admin_menu', 'doctreat_core_admin_menu');

    function doctreat_core_admin_menu() {
        $url = admin_url();
        add_submenu_page('edit.php?post_type=doctors', esc_html__('Settings', 'doctreat_core'), esc_html__('Settings', 'doctreat_core'), 'manage_options', 'doctreat_settings', 'doctreat_admin_page', 10
        );
		
    }

}


/**
 * @init            Settings Admin Page
 * @package         doctreat
 * @subpackage      doctreat/admin/partials
 * @since           1.0
 * @desc            This Function Will Produce All Tabs View.
 */
if (!function_exists('doctreat_admin_page')) {

    function doctreat_admin_page() {
		$settings	= doctreat_get_theme_settings();

		$protocol = is_ssl() ? 'https' : 'http';
		$post_args	= array( '_builtin' => false, 
							 'publicly_queryable' => true, 
							 'show_ui' => true 
						 );

		$term_args	= array( '_builtin' => false, 
						 'publicly_queryable' => true, 
						 'show_ui' => true 
					 );

		$taxonomies = get_taxonomies( $term_args, 'objects' ); 
		$post_types = get_post_types( $post_args,'objects' );
        $protocol = is_ssl() ? 'https' : 'http';
        ob_start();
		
        ?>
        <div id="dc-main" class="dc-main dc-addnew">
            <div class="wrap">
                <div id="dc-tab1s" class="dc-tabs">
                    <div class="dc-tabscontent">
                        <div id="dc-main" class="dc-main dc-features settings-main-wrap">
						    <div class="dc-featurescontent">
                                <div class="dc-twocolumns">
                                	<ul class="dc-tabsnav">
										<li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] === 'welcome' ? 'dc-active' : ''; ?>">
											<a href="<?php echo cus_prepare_final_url('welcome','settings'); ?>">
												<?php esc_html_e("What's New?", 'doctreat_core'); ?>
											</a>
										</li> 
										<li class="<?php echo isset( $_GET['tab'] ) && $_GET['tab'] === 'settings'? 'dc-active' : ''; ?>">
											<a href="<?php echo cus_prepare_final_url('settings','settings'); ?>">
												<?php esc_html_e('Settings', 'doctreat_core'); ?>
											</a>
										</li>
									</ul>
									<?php if( isset( $_GET['tab'] ) && $_GET['tab'] === 'settings' ){?>
										<div class="settings-wrap">
											<div class="dc-boxarea">
												<div id="tabone">
													<div class="dc-titlebox">
														<h3><?php esc_html_e('Rewrite URL', 'doctreat_core'); ?></h3>
													</div>
													<form method="post" class="save-settings-form">
														<?php if( !empty( $post_types ) ){
															foreach ($post_types as $key => $post_type) {?>
															<div class="dc-privacysetting">
																<span class="dc-tooltipbox">
																	<i>?</i>
																	<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'doctreat_core'); ?></span>
																</span>
																<span><?php echo esc_attr($post_type->label);?></span>
																<div class="sp-input-setting">
																	<div class="form-group">
																		<input type="text" name="settings[post][<?php echo esc_attr( $key );?>]" class="form-control" value="<?php echo  !empty( $settings['post'][$key] ) ?  esc_attr( $settings['post'][$key] ) : '';?>">
																	</div>
																</div>
															</div>
														<?php }}?>
														<?php if( !empty( $taxonomies ) ){ 
														foreach ($taxonomies as $key => $term) {?>
															<div class="dc-privacysetting">
																<span class="dc-tooltipbox">
																	<i>?</i>
																	<span class="tooltiptext"><?php esc_html_e('It will be used at post / Taxonomy detail page in URL as slug. Please use words without spaces.', 'doctreat_core'); ?></span>
																</span>
																<span><?php echo esc_attr($term->label);?></span>
																<div class="sp-input-setting">
																	<div class="form-group">
																		<input type="text" name="settings[term][<?php echo esc_attr( $key );?>]" class="form-control" value="<?php echo  !empty( $settings['term'][$key] ) ?  esc_attr( $settings['term'][$key] ) : '';?>">
																	</div>
																</div>
															</div>
														<?php }}?>
														
														<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary save-data-settings" value="<?php esc_html_e('Save Changes', 'doctreat_core'); ?>"></p>
													</form>
												</div>
											</div>
										</div>
										<?php }else{?>
										<div class="dc-content">
											<div class="dc-boxarea">
												<div class="dc-title">
													<h3><?php esc_html_e('Theme Requirements', 'doctreat_core'); ?></h3>
												</div>
												<div class="dc-contentbox">
													<ul class="dc-liststyle dc-dotliststyle dc-twocolumnslist">
														<li><?php esc_html_e('Minimum PHP version should be 7.0 or PHP version > 7.0','doctreat_core');?></li>
														<li><?php esc_html_e('PHP Zip extension Should be Installed','doctreat_core');?></li>
														<li><?php esc_html_e('max_execution_time = 300','doctreat_core');?></li>
														<li><?php esc_html_e('max_input_time = 300','doctreat_core');?></li>
														<li><?php esc_html_e('memory_limit = 300','doctreat_core');?></li>
														<li><?php esc_html_e('post_max_size = 100M','doctreat_core');?></li>
														<li><?php esc_html_e('upload_max_filesize = 100M','doctreat_core');?></li>
														<li><?php esc_html_e('CURL should be enabled to download Unyson extensions and demo content.','doctreat_core');?></li>
														<li><?php esc_html_e('Node.js for real-time chat','doctreat_core');?></li>
														<li><?php esc_html_e('allow_url_fopen and allow_url_include must be on','doctreat_core');?></li>	
													</ul>
												</div>
											</div>
										</div>
										<aside class="dc-sidebar">
											<div class="dc-widgetbox dc-widgetboxquicklinks">
												<div class="dc-title">
													<h3><?php esc_html_e('How to Install?', 'doctreat_core'); ?></h3>
												</div>
												<figure>
													<div style="position:relative;height:0;padding-bottom:56.25%">
														<iframe src="https://www.youtube.com/embed/vtMaqDtA4lA" width="640" height="360" frameborder="0" style="position:absolute;width:100%;height:100%;left:0" allowfullscreen></iframe>
													</div>
												</figure>
											</div>

											<div class="dc-widgetbox dc-widgetboxquicklinks">
												<div class="dc-title">
													<h3><?php esc_html_e('Get Support', 'doctreat_core'); ?></h3>
												</div>
												<a class="dc-btn" target="_blank" href="https://amentotech.ticksy.com/"><?php esc_html_e('Create Support Ticket', 'doctreat_core'); ?></a>
											</div>
										</aside>
									<?php }?>	
                                </div>
                                <div class="dc-socialandcopyright">
                                    <span class="dc-copyright"><?php echo date('Y'); ?>&nbsp;<?php esc_html_e('All Rights Reserved', 'doctreat_core'); ?> &copy; <a target="_blank"  href="https://themeforest.net/user/amentotech/"><?php esc_html_e('Amentotech', 'doctreat_core'); ?></a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo ob_get_clean();
    }
}
