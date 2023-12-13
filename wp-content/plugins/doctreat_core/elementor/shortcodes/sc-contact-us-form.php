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

if( !class_exists('Doctreat_Contact_Us_Form') ){
	class Doctreat_Contact_Us_Form extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_contact_us_form';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Contact Us', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-slider-album';
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
			$contact_forms		= array();
			if( function_exists('doctreat_prepare_custom_posts') ){
				$contact_forms 	= doctreat_prepare_custom_posts('wpcf7_contact_form',-1);
			}
			$version 		= array(
									'v1' 	=> esc_html__('V1','doctreat_core'),
									'v2' 	=> esc_html__('V2','doctreat_ccore')
								);
			//Content
			$this->start_controls_section(
				'content_section',
				[
					'label' => esc_html__( 'Content', 'doctreat_core' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			
			
			$this->add_control(
				'title',
				[
					'label'  => esc_html__( 'Add title', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'sub_title',
				[
					'label'  => esc_html__( 'Add sub title', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'description',
				[
					'label'  => esc_html__( 'Add Details', 'doctreat_core' ),
					'type'   => Controls_Manager::WYSIWYG,
				]
			);
			
			$this->add_control(
				'contact_form',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Select Contact Form', 'doctreat_core'),
					'description' 			=> esc_html__('Select Contact Form to display.', 'doctreat_core'),
					'options'   	=> $contact_forms,
					'default' 		=> 'none',
					'multiple' 		=> true,
				]
			);
			
			$this->add_control(
				'version',
				[
					'label'  		=> esc_html__( 'Select Version', 'doctreat_core' ),
					'type'   		=> Controls_Manager::SELECT,
					'options'   	=> $version,
					'default' 		=> 'v1',
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
			$settings 		= $this->get_settings_for_display();
			$title			= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title		= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$description	= !empty($settings['description']) ? $settings['description'] : '';
			$contact_form	= !empty($settings['contact_form']) ? $settings['contact_form'] : '';
			$version		= !empty($settings['version']) ? $settings['version'] : 'v1';
			$flag 				= rand(9999, 999999);
			
			?>
			<div class="dc-haslayout-<?php echo esc_attr( $version );?> dc contact-form">
				<?php if( $version === 'v1' ){ ?>
					<div class="row justify-content-center dynamic-secton-<?php echo esc_attr( $flag );?>">
						<div class="col-12 col-sm-12 col-md-12 col-lg-8">
							<div class="dc-sectionhead dc-text-center dc-pnone">
								<?php if( !empty( $title ) || !empty( $sub_title ) ){ ?>
									<div class="dc-sectiontitle">
										<h2>
											<?php if( !empty( $title ) ){?><span><?php echo esc_html( $title );?></span><?php } ?>
											<?php echo do_shortcode( $sub_title );?>
										</h2>
									</div>
								<?php } ?>
								<?php if( !empty( $description ) ){?>
									<div class="dc-description"><?php echo do_shortcode( $description );?></div>
								<?php } ?>
							</div>
							<?php if( !empty( $contact_form ) ){?>
								<div class="dc-form dc-floatclear dc-form-first"><?php echo do_shortcode('[contact-form-7 id="' . $contact_form . '"]');?> </div>	
							<?php } ?>						
						</div>
					</div>
				<?php } elseif( $version === 'v2' ){ ?>
					<div class="dc-contactvone">
						<?php if( !empty( $title ) ) { ?>
							<div class="dc-title">
								<h4><?php echo esc_html( $title );?></h4>
							</div>
						<?php } ?>
						<?php if( !empty( $contact_form ) ){?>
							<div class="dc-formtheme dc-medicalform"><?php echo do_shortcode('[contact-form-7 id="' . $contact_form . '"]');?></div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Contact_Us_Form ); 
	}