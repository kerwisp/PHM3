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

if( !class_exists('Dcotreat_Specialities_Location') ){
	class Dcotreat_Specialities_Location extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_specialities_loc';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Doctors Specialities by location', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-skill-bar';
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
			$specilities	= elementor_get_taxonomies('doctors','specialities');
			$specilities	= !empty($specilities) ? $specilities : array();
			
			$locations	= elementor_get_taxonomies('doctors','locations');
			$locations	= !empty($locations) ? $locations : array();
			
			//Content
			$this->start_controls_section(
				'content_section',
				[
					'label' => esc_html__( 'Content', 'doctreat_core' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'section_heading',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Heading', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section heading. Leave it empty to hide.', 'doctreat_core' ),
				]
			);

			$this->add_control(
				'btn_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Button Title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add button title. Leave it empty to hide button.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'btn_link',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Button Link', 'doctreat_core'),
        			'description' 	=> esc_html__('Add button link. Leave it empty to hide.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'locations',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Location', 'doctreat_core'),
					'description' 			=> esc_html__('Select Location to display.', 'doctreat_core'),
					'options'   	=> $locations,
				]
			);
			
			$this->add_control(
				'specilities',
				[
					'type'      	=> Controls_Manager::SELECT2,
					'label'			=> esc_html__('specilities', 'doctreat_core'),
					'description' 			=> esc_html__('Select specilities to display.', 'doctreat_core'),
					'options'   	=> $specilities,
					'default' 		=> 'none',
					'multiple' 		=> true,
					'label_block' 	=> true,
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

			$section_heading     	= !empty($settings['section_heading']) ? $settings['section_heading'] : '';
			$specilities			= !empty($settings['specilities']) ? $settings['specilities'] : array();
			$location				= !empty($settings['locations']) ? $settings['locations'] : '';
			if( !empty($location) ) {
				$location      		= get_term($location);
				$location_name		= $location->name;
				$location_slug		= $location->slug;
			} else {
				$location_name		= '';
				$location_slug		= '';
			}
			$view_title					= !empty( $settings['btn_title'] )  ? $settings['btn_title'] : '';
			$view_url					= !empty( $settings['btn_link'] )  ? $settings['btn_link'] : '';
			$search_page	= '';
			if( function_exists('doctreat_get_search_page_uri') ){
				$search_page  = doctreat_get_search_page_uri('doctors');
			}

			$query_arg	= array();
			?>
			<div class="dc-sc-skill-location dc-haslayout">
				<?php if( !empty($specilities)) {?>
					<div class="dc-widgetskills">
						<div class="dc-fwidgettitle">
							<h3><?php echo esc_html($section_heading);?></h3>
						</div>
						<ul class="dc-fwidgetcontent">
							<?php foreach( $specilities as $specilty ) { 
									$specilty      = get_term($specilty);
									$query_arg['specialities'] 	= urlencode($specilty->slug);
									$query_arg['location'] 		= urlencode($location_slug);
									$url                 		= add_query_arg( $query_arg, esc_url($search_page));
							?>
							<li>
								<a href="<?php echo esc_url($url);?>">
									<?php echo esc_html($specilty->name);?>&nbsp;<?php echo esc_html_e('in','doctreat_core');?>&nbsp;<?php echo esc_html($location_name);?>
								</a>
							</li>
							<?php }?>
							<?php if( !empty($view_title) ) {?>
								<li class="dc-viewmore"><a href="<?php echo esc_url($view_url);?>"><?php echo esc_html($view_title);?></a></li>
							<?php } ?>
						</ul>
					</div>
				<?php } ?>
			</div>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Dcotreat_Specialities_Location ); 
}