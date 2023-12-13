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

if( !class_exists('Doctreat_Feedback') ){
	class Doctreat_Feedback extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_feedback';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Feedback', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-person';
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
				'title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section title. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'sub_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Sub title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section sub title. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
		
			$this->add_control(
				'feedback',
				[
					'label'  => esc_html__( 'Add Feedback', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name'  => 'title',
							'label' => esc_html__( 'Add Title', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'sub_title',
							'label' => esc_html__( 'Add sub title', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'description',
							'label' => esc_html__( 'Add Detail', 'doctreat_core' ),
							'type'  => Controls_Manager::WYSIWYG,
						],
						[
							'name' 			=> 'avatar',
							'type'      	=> Controls_Manager::MEDIA,
							'label'     	=> esc_html__( 'Upload Image', 'doctreat_core' ),
							'description'   => esc_html__( 'Upload image.', 'doctreat_core' ),
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

			$title        	= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title    	= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$feedbacks		= !empty($settings['feedback']) ? $settings['feedback'] : array();
			$flag 			= rand(9999, 999999);
			?>
			<div class="dc-feedback dc-testimonials-holder dc-haslayout dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="dc-testimonials">
					<div class="container">
						<div class="row justify-content-center align-self-center">
							<div class="col-xs-12 col-sm-12 col-md-8 col-md-push-2 col-lg-8 col-lg-push-2">
								<div class="dc-testimonials-head">
									<div class="dc-heart">
										<span class="dc-hearticon"><i class="lnr lnr-heart"></i></span>
									</div>
									<?php if( !empty( $title  || !empty( $sub_title )) ){?>
										<div class="dc-title">
											<h3>
												<?php echo esc_html( $title );?>
												<?php if( !empty( $sub_title ) ) { ?><span><?php echo esc_html( $sub_title );?></span><?php } ?>
											</h3>
										</div>
									<?php }?>
								</div>
							</div>
							
							<?php if( !empty( $feedbacks ) ){?>
								<div class="col-xs-12 col-sm-12 col-md-10 col-md-push-1 col-lg-8 col-lg-push-2">
									<div class="dc-customerfeedbacks">
										<div id="dc-authorpicslider-<?php echo esc_attr( $flag );?>" class="slider-nav center">
											<?php 
												foreach( $feedbacks as $feedback ){ 
													$img_url	= !empty( $feedback['avatar']['url'] ) ? $feedback['avatar']['url'] : '';
													$title		= !empty( $feedback['title'] ) ? $feedback['title'] : '';
													if( !empty( $img_url ) ){ ?>
														<div><figure class="dc-slide"><img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $title );?>"></figure></div>
												<?php } ?>
											<?php } ?>
										</div>
										<div id="dc-feedbackslider-<?php echo esc_attr( $flag );?>" class="dc-feedbackslider slider-single ">
											<?php 
												foreach( $feedbacks as $feedback ){ 
													$img_url	= !empty( $feedback['avatar']['url'] ) ? $feedback['avatar']['url'] : '';
													$title		= !empty( $feedback['title'] ) ? $feedback['title'] : '';
													$sub_title		= !empty( $feedback['sub_title'] ) ? $feedback['sub_title'] : '';
													
													$description		= !empty( $feedback['description'] ) ? $feedback['description'] : '';
													if( !empty( $img_url )){ ?>
														<div class=" dc-testimonialscontent">
															<?php if( !empty( $description ) ){?>
																<div class="dc-description">
																	<blockquote><?php echo do_shortcode( $description );?></blockquote>
																</div>
															<?php } ?>
															<?php if( !empty( $title ) || !empty( $sub_title ) ){?>
																<div class="dc-title">
																	<h3><?php echo esc_html( $title );?></h3>
																	<?php if( !empty( $sub_title ) ){?>
																	<span><?php echo esc_html( $sub_title );?></span>
																	<?php } ?>
																</div>
															<?php } ?>
														</div>
												<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<script>
				jQuery(document).on('ready', function() {
					var authorpicslider = jQuery('#dc-authorpicslider-<?php echo esc_js( $flag );?>')
					var feedbackslider = jQuery('#dc-feedbackslider-<?php echo esc_js( $flag );?>')
					if (authorpicslider && feedbackslider !== null) {
					  jQuery(authorpicslider).slick({
						rtl: <?php echo doctreat_owl_rtl_check();?>,
						slidesToShow: 3,
						   slidesToScroll: 1,
						   asNavFor: feedbackslider,
						   dots: false,
						   loop:false,
						   arrows:false,
						   centerMode: true,
						   centerPadding: '0',
						   focusOnSelect: true,
						   swipe: true,
						   speed: 500,
						   easing: 'easeOutElastic',
					  });
						
					  jQuery(feedbackslider).slick({
						rtl: <?php echo doctreat_owl_rtl_check();?>,
						slidesToShow: 1,
						slidesToScroll: 1,
						arrows: false,
						loop:false,
						fade: false,
						swipe: false,
						asNavFor: authorpicslider,
					  });
						
					  jQuery(authorpicslider).on('click init', function(event, slick, direction){
						jQuery('.slick-current.slick-active').next('.slick-slide').addClass('dc-next-slide');
						jQuery('.slick-current.slick-active').prev('.slick-slide').addClass('dc-prev-slide');
					  });
						
					  jQuery(authorpicslider).on('beforeChange', function(event, slick, direction){
						jQuery('.slick-slide').removeClass('dc-next-slide');
						jQuery('.slick-slide').removeClass('dc-prev-slide');
					  });
					}
				});
			</script>
			</div>
		<?php 
			wp_enqueue_style('slick');
			wp_enqueue_script('slick');
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Feedback ); 
}