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

if( !class_exists('Doctreat_Authentication') ){
	class Doctreat_Authentication extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'wt_element_authentication';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Authentication', 'doctreat_core' );
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
				'form_type',
				[
					'label' => esc_html__( 'Form type', 'doctreat_core' ),
					'type'  => Controls_Manager::SELECT,
					'default' => 'register',
					'options' => [
						'register' 	=> esc_html__('Register Form', 'doctreat_core')
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
			$settings = $this->get_settings_for_display();
			?>
			<div class="dc-sc-shortcode dc-haslayout">
				<?php
					if( isset( $settings['form_type'] ) && $settings['form_type'] === 'register' ){
						echo do_shortcode('[doctreat_authentication]');
					} else if( isset( $settings['form_type'] ) && $settings['form_type'] === 'login' ){
						echo do_shortcode('[doctreat_login]');
					} 
				?>
			</div>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Authentication ); 
}