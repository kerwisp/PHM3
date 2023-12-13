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

if( !class_exists('Doctreat_Home_Slider') ){
	class Doctreat_Home_Slider extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_slider_v1';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Home Slider', 'doctreat_core' );
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
				'autplay',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Autoplay slides', 'doctreat_core'),
					'default' 		=> 'FALSE',
					'options' => [
						'FALSE' 	=> esc_html__('No', 'doctreat_core'),
						'carousel' 	=> esc_html__('Yes', 'doctreat_core')
					],
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
						],
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
							'name'  => 'secondary_title',
							'label' => esc_html__( 'Add secondary title', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn1_text',
							'label' => esc_html__( 'Add first button text', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn1_url',
							'label' => esc_html__( 'Add first button url', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn2_text',
							'label' => esc_html__( 'Add second button text', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn2_url',
							'label' => esc_html__( 'Add second button url', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
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
			$settings 	= $this->get_settings_for_display();
			$sliders	= !empty($settings['slider']) ? $settings['slider'] : '';
			$autplay	= !empty($settings['autplay']) ? $settings['autplay'] : 'FALSE';
			$flag 		= rand(9999, 999999);
			
			$slide_counter	= 1;
			?>
			<div class="dc-sc-slider dc-homesliderholder dc-haslayout dynamic-secton">
				<?php if( !empty( $sliders ) ){?>
					<div id="dc-homeslider" class="dc-homeslider">
						<div id="carouselControls" class="carousel slide" data-ride="<?php echo esc_attr($autplay);?>">
							<div class="carousel-inner">
								<?php 
									foreach( $sliders as $slide ){
										$active_class = !empty( $slide_counter ) && $slide_counter ===1 ? 'active' : '';
										$slide_counter ++;
										$image				= !empty( $slide['image']['url']) ? $slide['image']['url'] : '';
										$number				= !empty( $slide['number']) ? $slide['number'] : '';
										$title				= !empty( $slide['title']) ? $slide['title'] : '';
										$sub_title			= !empty( $slide['sub_title']) ? $slide['sub_title'] : '';
										$secondary_title	= !empty( $slide['secondary_title']) ? $slide['secondary_title'] : '';
										$btn1_text			= !empty( $slide['btn1_text']) ? $slide['btn1_text'] : '';
										$btn1_url			= !empty( $slide['btn1_url']) ? $slide['btn1_url'] : '';
										$btn2_text			= !empty( $slide['btn2_text']) ? $slide['btn2_text'] : '';
										$btn2_url			= !empty( $slide['btn2_url']) ? $slide['btn2_url'] : '';
										
									?>
									<div class="carousel-item <?php echo esc_attr( $active_class );?>" id="carousel-item-<?php echo intval($slide_counter);?>">
										<div class="d-flex justify-content-center dc-craousel-content">
											<div class="mx-auto">
												<?php if( !empty( $image ) ){?>
													<img width="" height="" class="d-block dc-bannerimg" src="<?php echo esc_url( $image );?>" alt="<?php echo esc_attr( $title );?>">
												<?php } ?>
												<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $secondary_title ) ){?>
													<div class="dc-bannercontent dc-bannercotent-craousel" >
														<div class="dc-content-carousel">
															<?php if( !empty( $number ) ) { ?><div class="dc-num"><?php echo esc_html( $number );?></div><?php } ?>
															<h1>
																<?php if( !empty( $title )){?><em><?php echo esc_html( $title );?></em><?php } ?>
																<?php echo esc_html( $sub_title );?>
																<?php if( !empty( $secondary_title )) { ?><span> <?php echo esc_html( $secondary_title );?></span><?php }?>
															</h1>
															<?php if( !empty( $btn1_text ) || !empty( $btn2_text ) ){?>
																<div class="dc-btnarea">
																	<?php if( !empty( $btn1_text )) {?>
																		<a href="<?php echo esc_url( $btn1_url );?>" class="dc-btn dc-btnactive"><?php echo esc_html( $btn1_text );?></a>
																	<?php } ?>
																	<?php if( !empty( $btn2_text )) {?>
																		<a href="<?php echo esc_url( $btn2_url );?>" class="dc-btn"><?php echo esc_html( $btn2_text );?></a>
																	<?php } ?>
																</div>
															<?php } ?>
														</div>
													</div>
												<?php } ?>
											</div>
										</div>
									</div>
								<?php } ?>
								
								<a class="dc-carousel-control-prev" href="#carouselControls" role="button" data-slide="prev">
									<span class="dc-carousel-control-prev-icon" aria-hidden="true"><span><?php esc_html_e('PR','doctreat_core');?></span><span class="d-block"><?php esc_html_e('EV','doctreat_core');?></span></span>
									<span class="sr-only"><?php esc_html_e('Previous','doctreat_core');?></span>
								</a>
								<a class="dc-carousel-control-next" href="#carouselControls" role="button" data-slide="next">
									<span class="dc-carousel-control-next-icon " aria-hidden="true"><span><?php esc_html_e('NE','doctreat_core');?></span><span class="d-block"><?php esc_html_e('XT','doctreat_core');?></span></span>
									<span class="sr-only"><?php esc_html_e('Next','doctreat_core');?></span>
								</a>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Home_Slider ); 
	}