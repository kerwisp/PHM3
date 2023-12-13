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

if( !class_exists('Doctreat_Home_SliderV2') ){
	class Doctreat_Home_SliderV2 extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_slider_v2';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Home Slider V2', 'doctreat_core' );
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
			//Content
			$this->start_controls_section(
				'content_section',
				[
					'label' => esc_html__( 'Content', 'doctreat_core' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'hide_location',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Hide locations', 'doctreat_core'),
					'description' 			=> esc_html__('Hide location dropdown.', 'doctreat_core'),
					'default' => 'no',
					'options' => [
						'no' 	=> esc_html__('No', 'doctreat_core'),
						'yes' 	=> esc_html__('Yes', 'doctreat_core')
					],
				]
			);
			
			$this->add_control(
				'opacity',
				[
					'label'  => esc_html__( 'Opacity', 'doctreat_core' ),
					'type'   => Controls_Manager::SELECT,
					'default' => '0.2',
					'options' => [
						'0.1' 	=> esc_html__('0.1', 'doctreat_core'),
						'0.2' 	=> esc_html__('0.2', 'doctreat_core'),
						'0.3' 	=> esc_html__('0.3', 'doctreat_core'),
						'0.4' 	=> esc_html__('0.4', 'doctreat_core'),
						'0.5' 	=> esc_html__('0.5', 'doctreat_core'),
						'0.6' 	=> esc_html__('0.6', 'doctreat_core'),
						'0.7' 	=> esc_html__('0.7', 'doctreat_core'),
						'0.8' 	=> esc_html__('0.8', 'doctreat_core'),
						'0.9' 	=> esc_html__('0.9', 'doctreat_core'),
						'1.0' 	=> esc_html__('1.0', 'doctreat_core')
					],
				]
			);
			
			$this->add_control(
				'overlay_bg',
				[
					'type'      	=> Controls_Manager::COLOR,
					'label'			=> esc_html__('Background overlay color', 'doctreat_core'),
					'description' 			=> esc_html__('Add background overlay color', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'slider',
				[
					'label'  => esc_html__( 'Add slide', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name' 			=> 'image',
							'type'      	=> Controls_Manager::MEDIA,
							'label'     	=> esc_html__( 'Upload slide Image', 'doctreat_core' ),
							'description'   => esc_html__( 'Upload image.', 'doctreat_core' ),
							'default' => [
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							],
						]
					],
					'default' => [],
				]
			);
			$this->add_control(
				'search_form',
				[
					'type'      	=> \Elementor\Controls_Manager::SWITCHER,
					'label'     	=> esc_html__( 'Form Enable/Disbale', 'doctreat_core' ),
					'label_on' 		=> esc_html__( 'Show', 'doctreat_core' ),
					'label_off' 	=> esc_html__( 'Hide', 'doctreat_core' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'yes',
				]
			);
			$this->add_control(
				'image',
				[
					'type'      	=> Controls_Manager::MEDIA,
					'label'     	=> esc_html__( 'Main Image', 'doctreat_core' ),
					'description'   => esc_html__( 'Add Image. leave it empty to hide.', 'doctreat_core' ),
					'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
				]
			);
			$this->add_control(
				'title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add title. leave it empty to hide.', 'doctreat_core' ),
				]
			);

			$this->add_control(
				'sub_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Sub Title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add subtitle. leave it empty to hide.', 'doctreat_core' ),
				]
			);
			$this->add_control(
				'description',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Sub Description', 'doctreat_core' ),
					'description'   => esc_html__( 'Add description. leave it empty to hide.', 'doctreat_core' ),
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
			$sliders		= !empty($settings['slider']) ? $settings['slider'] : '';
			$main_image		= !empty($settings['image']) ? $settings['image'] : '';
			$search_form    = !empty($settings['search_form']) ? $settings['search_form'] : '';
			$title			= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title		= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$opacity		= !empty($settings['opacity']) ? $settings['opacity'] : '0.2';
			$overlay_bg		= !empty($settings['overlay_bg']) ? 'style=background:'.$settings['overlay_bg'] : '';
			$description	= !empty($settings['description']) ? $settings['description'] : '';
			$hide_location			= !empty($settings['hide_location']) ? $settings['hide_location'] : 'no';
			$search_page	= '';
			if( function_exists('doctreat_get_search_page_uri') ){
				$search_page  = doctreat_get_search_page_uri('doctors');
			}
			$flag 			= rand(9999, 999999);
			
			$slide_counter	= 1;
			
			$hide_loc = 'dc-hidelocation'; 
			if( !empty($hide_location) && $hide_location === 'no'){
				$hide_loc = 'dc-hidelocation'; 
			}
			?>
			<div class="dc-homeslidervtwo dc-haslayout <?php echo esc_attr($hide_loc);?>" <?php echo esc_attr($overlay_bg);?>>
				<?php if(!empty($sliders)){?>
					<div id="dc-bannervtwo-<?php echo intval($slide_counter);?>" class="dc-bannervtwo owl-carousel">
						<?php 
							foreach($sliders as $slide ){ 
								$image				= !empty( $slide['image']['url']) ? $slide['image']['url'] : '';
								if(!empty($image)){ ?>
									<div class="item">
										<figure class="dc-silderimg"><img style="opacity: <?php echo esc_attr($opacity);?>" width="" height="" src="<?php echo esc_url($image);?>" alt="<?php esc_html_e('Doctreat Header','doctreat_core');?>"></figure>
									</div>
							<?php } ?>
						<?php } ?>
					</div>
				<?php } ?>
				<div class="dc-bannervtwocontent">
					<div class="container">
						<div class="row">
						<?php if( !empty( $search_form ) && $search_form === 'yes' ){?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-6">
								<div class="dc-medicalfacility">
									<?php if(!empty($title)  || !empty($sub_title)  || !empty($description) ){?>
										<div class="dc-title">
											<h2><em><?php echo esc_attr( $title );?></em><span> <?php echo esc_attr( $sub_title );?> </span><?php echo esc_attr( $description );?></h2>
										</div>
									<?php } ?>
									<form class="dc-formtheme dc-medicalform dc-form-advancedsearch-v2" action="<?php echo esc_url( $search_page );?>" method="get">
										<fieldset>
											<?php if( function_exists('doctreat_get_search_text_field') ){?>
											<div class="form-group">
												<?php do_action('doctreat_get_search_text_field');?>
											</div>
										<?php } ?>
										<?php if( function_exists('doctreat_get_search_locations') && $hide_location === 'no' ){?>
											<div class="form-group">
												<div class="dc-select">
													<?php do_action('doctreat_get_search_locations');?>
												</div>
											</div>
										<?php } ?>
											<div class="form-group dc-btnarea">
												<a href="javascript:;" class="dc-docsearch">
													<span class="dc-advanceicon"><i></i> <i></i> <i></i></span>
													<span><?php echo wp_kses(__('Advanced Search','doctreat_core'),array('br' => array()));?></span>
												</a>
												<button class="dc-btn dc-serach-form-v2"><?php esc_html_e('Search now','doctreat_core');?></button>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
							<?php } ?>
							<?php if(!empty($main_image['url'])) {?>
								<div class="d-none col-md-6 d-lg-block">
									<figure class="dc-slidercontentimg">
										<img width="" height="" src="<?php echo esc_url($main_image['url']);?>" alt="<?php esc_attr_e('Search Form','doctreat_core');?>">
									</figure>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<script>
				
				jQuery(window).load(function() {
					jQuery('.dc-docsearch').on('click', function(){
						jQuery('.dc-form-advancedsearch-v2').submit();
					});
					
					jQuery('.dc-serach-form-v2').on('click', function(){
						jQuery('.dc-form-advancedsearch-v2').submit();
					});
					/* BANNER SLIDER V TWO	*/
					var _dc_bannervtwo = jQuery("#dc-bannervtwo-<?php echo esc_js($slide_counter);?>")
					_dc_bannervtwo.owlCarousel({
						rtl: <?php echo doctreat_owl_rtl_check();?>,
						items:1,
						loop:true,
						nav:false,
						autoplay:true,
						smartSpeed:450,
						mouseDrag: false,
						animateOut: 'fadeOut',
						animateIn: 'fadeIn',
						autoplayHoverPause:false
					});
				});
			</script>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Home_SliderV2 ); 
	}