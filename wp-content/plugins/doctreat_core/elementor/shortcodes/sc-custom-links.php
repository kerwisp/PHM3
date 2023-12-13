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

if( !class_exists('Doctreat_Custom_Links') ){
	class Doctreat_Custom_Links extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_custom_links';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Custom Links', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-testimonial';
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
				'links',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Links in a row','doctreat_core' ),
					'default' 		=> '5',
					'options' 		=> [
										'2' 	=> esc_html__('2', 'doctreat_core'),
										'3' 	=> esc_html__('3', 'doctreat_core'),
										'4' 	=> esc_html__('4', 'doctreat_core'),
										'5' 	=> esc_html__('5', 'doctreat_core'),
								],
				]
			);
			
			$this->add_control(
				'autplay',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Auto play','doctreat_core' ),
					'default' 		=> 'false',
					'options' 		=> [
										'false' 	=> esc_html__('No', 'doctreat_core'),
										'true' 		=> esc_html__('Yes', 'doctreat_core'),
								],
				]
			);
			
			$this->add_control(
				'custom_links',
				[
					'label'  => esc_html__( 'Add section', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name'  => 'number',
							'label' => esc_html__( 'Add number', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'title',
							'label' => esc_html__( 'Add title', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'sub_title',
							'label' => esc_html__( 'Add sub title', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn_text',
							'label' => esc_html__( 'Add button text', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn_url',
							'label' => esc_html__( 'Add button url', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'section_color',
							'label' => esc_html__( 'Section color', 'doctreat_core' ),
							'type'  => Controls_Manager::COLOR,
						],
						[
							'name'  		=> 'bg_image',
							'type'      	=> Controls_Manager::MEDIA,
							'label'     	=> esc_html__( 'Background Image', 'doctreat_core' ),
							'description'   => esc_html__( 'Upload image for element background', 'doctreat_core' ),
							'default' => [
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							],
						]
					],
					'default' => [],
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
			$custom_links	= !empty($settings['custom_links']) ? $settings['custom_links'] : '';
			$links			= !empty($settings['links']) ? $settings['links'] : 5;
			$autplay		= !empty($settings['autplay']) ? $settings['autplay'] : false;
			$flag 			= rand(9999, 999999);
			
			$slide_counter	= 0;
			
			?>
			<div class="dc-sc-slider dc-customlinksholder dc-haslayout dynamic-secton-<?php echo esc_attr( $flag );?>">
				<?php if( !empty( $custom_links ) ){?>
					<div class="container-fluid">
						<div class="row">
							<div id="dc-doctorslider-<?php echo esc_attr( $flag );?>" class="dc-doctorslider owl-carousel dc-doctorslider-<?php echo esc_attr( $flag );?>">
								<?php
									foreach( $custom_links as $section ){
										$number		= !empty( $section['number'] ) ? $section['number'] : '';
										$title		= !empty( $section['title'] ) ? $section['title'] : '';
										$sub_title	= !empty( $section['sub_title'] ) ? $section['sub_title'] : '';
										$btn_text	= !empty( $section['btn_text'] ) ? $section['btn_text'] : '';
										$btn_url	= !empty( $section['btn_url'] ) ? $section['btn_url'] : '';
										$color		= !empty( $section['section_color'] ) ? $section['section_color'] : '';
										$bg_image		= !empty( $section['bg_image']['url'] ) ? $section['bg_image']['url'] : '';
										$slide_counter	++;
									?>
									<div class="item dc-doctordetails-holder dc-titlecolor<?php echo intval($slide_counter);?>">
										<?php if( !empty( $bg_image ) ) {?>
											<span class="dc-slidercounter"><img width="" height="" src="<?php echo esc_url( $bg_image ) ;?>" alt="<?php esc_html_e('links','doctreat_core');?>"></span>
										<?php } else if( !empty($number)){ ?>
											<span class="dc-slidercounter"><?php echo esc_html($number);?></span>
										<?php } ?>
										<?php if( !empty( $title )  || !empty( $sub_title )) {?>
											<h3>
												<?php if( !empty( $title ) ) { ?><span><?php echo esc_html( $title ) ;?></span><?php } ?>
												<?php echo esc_html( $sub_title ) ;?>
											</h3>
										<?php } ?>
										<?php if( !empty( $btn_text ) ){?>
											<a href="<?php echo esc_url( $btn_url ) ;?>" class="dc-btn"><?php echo esc_html( $btn_text ) ;?></a>
										<?php } ?>
										<?php
											if( !empty ( $color ) ) { ?>
												<style>
													.dc-titlecolor<?php echo intval($slide_counter);?> h3{ color : <?php echo esc_html($color);?>}
													.dc-titlecolor<?php echo intval($slide_counter);?> .dc-btn{ border-color : <?php echo esc_html($color);?>}
												</style>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
							
						</div>
					</div>
				<?php } ?>
			</div>
			<?php 
			 $script = "
                jQuery(window).load(function() {
					function initshowCarousel() {
						jQuery('.dc-doctorslider-".esc_js( $flag )."').owlCarousel({
							rtl: ".doctreat_owl_rtl_check().",
							loop:false,
							margin:0,
							navSpeed:500,
							nav:false,
							autoplay: ".$autplay.",
							items:".$links.",
							responsiveClass:true,
							responsive:{
								0:{
									items:1,
								},
								600:{
									items:2,
								},
								800:{
									items:3,
								},
								1080:{
									items:4,
								},
								1280:{
									items:".$links.",
								},
							}	
						});
					}
					
					initshowCarousel();
					setTimeout(function(){ initshowCarousel(); }, 2000);
					setTimeout(function(){ initshowCarousel(); }, 3000);
					setTimeout(function(){ initshowCarousel(); }, 4000);
				});
                    
                    ";
                wp_add_inline_script( 'doctreat-callback', $script, 'after' );
			?>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Custom_Links ); 
	}