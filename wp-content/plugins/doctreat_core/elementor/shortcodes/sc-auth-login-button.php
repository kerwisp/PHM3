<?php
/**
 * Shortcode
 *
 *
 * @package    Doctreat
 * @subpackage Doctreat/admin
 * @author     Amentotech <theamentotech@gmail.com>
 */

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if( !class_exists('Doctreat_Login_Buttons') ){
	class Doctreat_Login_Buttons extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'wt_element_auth_login';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Login button', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-lock-user';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      category of shortcode
		 */
		public function get_categories() {
			return [ 'doctreat-elements' ];
		}

		/**
		 * Register category controls.
		 * @since    1.0.0
		 * @access   protected
		 */
		protected function register_controls() {
			
			//Content
			$this->start_controls_section(
				'content_section',
				[
					'label' => esc_html__( 'Content', 'doctreat_core' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'title_color',
				[
					'label' => __( 'Title Color', 'doctreat_core' ),
					'type' => Controls_Manager::COLOR,
				]
			);
			
			$this->add_control(
				'menu',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Show menu after login','doctreat_core' ),
					'default' 		=> 'no',
					'options' 		=> [
										'yes' 	=> esc_html__('Yes', 'doctreat_core'),
										'no' 	=> esc_html__('No', 'doctreat_core'),
								],
				]
			);
			
			$this->end_controls_section();
		}

		/**
		 * Render shortcode
		 *
		 * @since 1.0.0
		 * @access protected
		 */
		protected function render() {
			global $theme_settings,$post,$current_user;
			$settings = $this->get_settings_for_display();
			$title_color		= !empty( $settings['title_color'] ) ? $settings['title_color'] : '#484848';
			$menu			= !empty( $settings['menu'] ) ? $settings['menu'] : 'no';
			$is_auth		= !empty( $theme_settings['user_registration'] ) ? $theme_settings['user_registration'] : '';
			$is_register	= !empty( $theme_settings['registration_form'] ) ? $theme_settings['registration_form'] : '';
			$is_login		= !empty( $theme_settings['login_form'] ) ? $theme_settings['login_form'] : '';
			$redirect		= !empty( $_GET['redirect'] ) ? esc_url( $_GET['redirect'] ) : '';

			$current_page	= '';
			if ( is_singular('doctors')){
				$current_page	= !empty( $post->ID ) ? intval( $post->ID ) : '';
			}

			$signup_page_slug   = doctreat_get_signup_page_url();  
			$user_identity 	= !empty($current_user->ID) ? $current_user->ID : 0;
			$user_type		= apply_filters('doctreat_get_user_type', $user_identity );

			if ( is_user_logged_in() ) {
				if ( !empty($menu) && $menu === 'yes' && ( $user_type === 'doctors' || $user_type === 'hospitals' || $user_type === 'regular_users')  ) {
					echo '<div class="dc-afterauth-buttons">';
					do_action('doctreat_print_user_nav');
					echo '</div>';
				}
			} else{

				if( !empty( $is_auth ) ){?>

				<div class="dc-login-buttons dc-loginarea">
					<?php if( !empty( $is_login ) ) {?>
						<figure class="dc-userimg">
							<img src="<?php echo esc_url(get_template_directory_uri());?>/images/user.png" alt="<?php esc_html_e('user', 'doctreat_core'); ?>">
						</figure>
						<div class="dc-loginoption">
							<a href="javascript:;" id="dc-loginbtn" class="dc-loginbtn" style="color:<?php echo esc_attr($title_color);?>"><?php esc_html_e('Login','doctreat_core');?></a>
							<div class="dc-loginformhold">
								<div class="dc-loginheader">
									<span><?php esc_html_e('Login','doctreat_core');?></span>
									<a href="javascript:;"><i class="fa fa-times"></i></a>
								</div>
								<form class="dc-formtheme dc-loginform do-login-form">
									<fieldset>
										<div class="form-group">
											<input type="text" name="username" class="form-control" placeholder="<?php esc_html_e('Username', 'doctreat_core'); ?>">
										</div>
										<div class="form-group">
											<input type="password" name="password" class="form-control" placeholder="<?php esc_html_e('Password', 'doctreat_core'); ?>">
										</div>
										<div class="dc-logininfo">
											<span class="dc-checkbox">
												<input id="dc-login" type="checkbox" name="rememberme">
												<label for="dc-login"><?php esc_html_e('Keep me logged in','doctreat_core');?></label>
											</span>
											<input type="submit" class="dc-btn do-login-button" data-id="<?php echo intval($current_page);?>" value="<?php esc_attr_e('Login','doctreat_core');?>">
										</div>
										<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect );?>">
										<input type="hidden" name="redirect_id" value="<?php echo intval($current_page);?>">
									</fieldset>
									<div class="dc-loginfooterinfo">
										<a href="javascript:;" class="dc-forgot-password"><?php esc_html_e('Forgot password?','doctreat_core');?></a>
										<?php if ( !empty($is_register) ) {?>
											<a href="<?php echo esc_url(  $signup_page_slug ); ?>"><?php esc_html_e('Create account','doctreat_core');?></a>
										<?php }?>
									</div>
								</form>
								<form class="dc-formtheme dc-loginform do-forgot-password-form dc-hide-form">
									<fieldset>
										<div class="form-group">
											<input type="email" name="email" class="form-control get_password" placeholder="<?php esc_html_e('Email', 'doctreat_core'); ?>">
										</div>

										<div class="dc-logininfo">
											<a href="javascript:;" class="dc-btn do-get-password"><?php esc_html_e('Get Pasword','doctreat_core');?></a>
										</div>                                                               
									</fieldset>
									<div class="dc-loginfooterinfo">
										<a href="javascript:;" class="dc-show-login"><?php esc_html_e('Login Now','doctreat_core');?></a>
										<?php if ( !empty($is_register) ) {?>
											<a href="<?php echo esc_url(  $signup_page_slug ); ?>"><?php esc_html_e('Create account','doctreat_core');?></a>
										<?php }?>
									</div>
								</form>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php }
			}
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Login_Buttons ); 
}