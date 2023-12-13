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

if( !class_exists('Doctreat_Dokan') ){
	class Doctreat_Dokan extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_dokan';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Dokan Shortcode', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-click';
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
				'dokan',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Dokan shortcodes', 'doctreat_core'),
					'description' 			=> esc_html__('Dokan shortcodes for the pages setup', 'doctreat_core'),
					'options' => [
						'[dokan-dashboard]' 	=> esc_html__('Vendor Dashboard', 'doctreat_core'),
						'[dokan-stores]' 		=> esc_html__('Vendor Listing', 'doctreat_core'),
						'[dokan-my-orders]' 	=> esc_html__('Dokan My Orders', 'doctreat_core')
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
			$settings 			= $this->get_settings_for_display();
			$dokan      		= !empty($settings['dokan']) ? $settings['dokan'] : '';
			?>
			<div class="dc-dokan-shortcode dc-haslayout dokan-dashboard">
				<?php if( !empty( $dokan ) ) {?><?php echo do_shortcode( $dokan ); ?><?php } ?>
			</div>
		<?php
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Dokan ); 
}