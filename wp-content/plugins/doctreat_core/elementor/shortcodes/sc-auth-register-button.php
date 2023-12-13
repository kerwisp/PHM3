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

if( !class_exists('Doctreat_Register_Buttons') ){
	class Doctreat_Register_Buttons extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'wt_element_auth_register';
		}
		
		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Register button', 'doctreat_core' );
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
										'no' => esc_html__('No', 'doctreat_core'),
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
			$settings 		= $this->get_settings_for_display();
			$title_color	= !empty( $settings['title_color'] ) ? $settings['title_color'] : '#484848';
			$menu			= !empty( $settings['menu'] ) ? $settings['menu'] : 'no';
			$is_auth		= !empty( $theme_settings['user_registration'] ) ? $theme_settings['user_registration'] : '';
			$is_register	= !empty( $theme_settings['registration_form'] ) ? $theme_settings['registration_form'] : '';
			$signup_page_slug   = doctreat_get_signup_page_url();  
			
			$user_identity 	= !empty($current_user->ID) ? $current_user->ID : 0;
			$user_type		= apply_filters('doctreat_get_user_type', $user_identity );
			
			if ( is_user_logged_in()) {
				if ( !empty($menu) && $menu === 'yes' && ( $user_type === 'doctors' || $user_type === 'hospitals' || $user_type === 'regular_users')  ) {
					echo '<div class="dc-afterauth-buttons">';
						do_action('doctreat_print_user_nav');
					echo '</div>';
				}
			} else{
				if( !empty( $is_auth ) ){?>
				<div class="dc-register-buttons">
					<?php if ( !empty($is_register) ) {?>
						<a href="<?php echo esc_url(  $signup_page_slug ); ?>" class="dc-btn" style="color:<?php echo esc_attr($title_color);?>"><?php esc_html_e('Join Now','doctreat_core');?></a>
					<?php }?> 
				</div>
				<?php }
			}
			
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Register_Buttons ); 
}