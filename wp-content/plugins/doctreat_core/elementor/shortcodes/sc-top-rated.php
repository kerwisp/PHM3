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

if( !class_exists('Doctreat_TopRated') ){
	class Doctreat_TopRated extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_top_rated';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Top rated', 'doctreat_core' );
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
			$categories	= elementor_get_taxonomies('doctors','specialities');
			$categories	= !empty($categories) ? $categories : array();
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
				'post_ids',
				[
					'label'  	=> esc_html__( 'Doctors IDs', 'doctreat_core' ),
					'type'   	=> Controls_Manager::TEXT,
					'description' 		=> esc_html__('Add Doctors ids or leveve it empty to show latest doctors by Speciality.', 'doctreat_core'),
				]
			);
			$this->add_control(
				'speciality_img',
				[
					'label'  	=> esc_html__( 'Speciality Image', 'doctreat_core' ),
					'type'   	=> Controls_Manager::MEDIA,
					'description' 		=> esc_html__('Add Speciality Image or leveve it empty to hide.', 'doctreat_core'),
					'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
				]
			);
			$this->add_control(
				'specialities',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Specialities?', 'doctreat_core'),
					'description' 			=> esc_html__('Select speciality to display doctors.', 'doctreat_core'),
					'options'   	=> $categories,
					'default' 		=> 'none',
					'multiple' 		=> true,
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
			$post_ids		= !empty($settings['post_ids']) ? explode(',',$settings['post_ids']) : array();
			$specialities	= !empty($settings['specialities']) ? $settings['specialities'] : '';
			$logo			= !empty($settings['speciality_img']['url']) ? $settings['speciality_img']['url'] : '';
			$args			= array();
			$speciality_data		= array();
			
			if( function_exists('doctreat_get_term_by_type') ){
				$speciality_data	= doctreat_get_term_by_type('id',$specialities,'specialities','all');
			}
			
			$speciality_url	= '';
			if( !empty( $speciality_data ) ){
				$speciality_url	= get_term_link($speciality_data);
			}
			
			$doctors		= array();
			
			if( !empty( $specialities ) ){
				$args['posts_per_page']			= 10;
				$args['post_type']				= array('doctors');
				$args['post_status']			= 'publish';
				$args['ignore_sticky_posts']	= 1;
				if( !empty( $post_ids )) {
					$args['post__in']		= $post_ids;
				} else {
					$args['tax_query']		= array(
								array(
									'taxonomy' 	=> 'specialities',
									'field' 	=> 'term_id',
									'terms' 	=> $specialities,
								)
							);
				}
				
				$meta_query_args	= array();
			
				//default
				$meta_query_args[] = array(
					'key' 			=> '_profile_blocked',
					'value' 		=> 'off',
					'compare' 		=> '='
				);

				//serch only verified
				$meta_query_args[] = array(
					'key' 			=> '_is_verified',
					'value' 		=> 'yes',
					'compare' 		=> '='
				);

				if (!empty($meta_query_args)) {
					$query_relation = array('relation' => 'AND',);
					$meta_query_args = array_merge($query_relation, $meta_query_args);
					$args['meta_query'] = $meta_query_args;
				}
				
				$doctors 		= get_posts( $args );
			}
			
			$total_doctors		= count($doctors);
			$total_doctors		= !empty( $total_doctors ) ? intval($total_doctors) : 0;
			$flag 				= rand(9999, 999999);
			
			?>
			<div class="dc-haslayout sc-top-reted sc-top-retedv1">
				<?php if( !empty( $specialities ) && !empty( $speciality_data )) {?>
					<div class="container-fluid">
						<div class="row">
							<?php if( !empty( $title ) || !empty( $logo ) || !empty( $speciality_data->name ) || !empty( $speciality_data->description  ) ){ ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 col-xl-3">
									<div class="row">
										<div class="dc-ratedecontent dc-bgcolor">
											<?php if( !empty( $logo ) ){?>
												<figure class="dc-neurosurgeons-img">
													<img width="" height="" src="<?php echo esc_url( $logo );?>" alt="<?php echo esc_html( $speciality_data->name );?>">
												</figure>
											<?php } ?>
											<div class="dc-sectionhead dc-sectionheadvtwo dc-text-center">
												<?php if( !empty( $title ) || !empty( $speciality_data->name ) ){?>
													<div class="dc-sectiontitle">
														<h2><?php echo esc_html( $title ) ;?><span><?php echo esc_html( $speciality_data->name ) ;?></span></h2>
													</div>
												<?php } ?>
												<?php if( !empty( $speciality_data->description ) ){?>
													<div class="dc-description">
														<p><?php echo esc_html( $speciality_data->description );?></p>
													</div>
												<?php } ?>
											</div>
											<div class="dc-btnarea">
												<a href="<?php echo esc_url( $speciality_url);?>" class="dc-btn"><?php esc_html_e('View All','doctreat_core');?></a>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>
							<?php if( !empty( $doctors ) ){?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-xl-9">
									<div class="row">
										<div id="dc-docpostslider-<?php echo intval( $flag );?>" class="dc-docpostslider owl-carousel">
											<?php foreach ( $doctors as $doctor ){?>
												<div class="item">
													<div class="dc-docpostholder">
														<a href="<?php echo esc_url(get_the_permalink($doctor->ID));?>">
															<?php 
																if( function_exists('doctreat_get_doctor_thumnail') ){
																	do_action('doctreat_get_doctor_thumnail',$doctor->ID,261,205);
																}
															?>
														</a>
														<div class="dc-docpostcontent">
															<?php 
																if( function_exists('doctreat_get_favorit_check') ){ 				 	 	  			
																	do_action('doctreat_get_favorit_check',$doctor->ID,'large');
																}
				
																if( function_exists('doctreat_get_doctor_details') ){ 				 	 	  			
																	do_action('doctreat_get_doctor_details',$doctor->ID,1);
																}
				
																if( function_exists('doctreat_get_doctor_booking') ){ 				 	 	  			
																	do_action('doctreat_get_doctor_booking',$doctor->ID);
																}
															?>
														</div>
													</div>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			</div>
			<script>
				jQuery(window).load(function() {
					function showCarousel() {
						jQuery("#dc-docpostslider-<?php echo esc_js( $flag );?>").owlCarousel({
							loop:false,
							margin:30,
							navSpeed:1000,
							nav:false,
							items:5,
							autoHeight: false,
							autoplayHoverPause:true,
							autoplaySpeed:1000,
							autoplay: false,
							mouseDrag:false,
							navClass: ['dc-prev', 'dc-next'],
							navContainerClass: 'dc-docslidernav',
							navText: ['<span class="ti-arrow-left"></span>', '<span class="ti-arrow-right"></span>'],
							responsiveClass:true,
							responsive:{
								0:{
									items:1,
								},
								480:{
									items:2,
								},
								800:{
									items:3,
								},
								992:{
									items:2,
								},
								1200:{
									items:3,
								},
								1366:{
									items:4,
								},
								1681:{
									items:5,
								}
							}	
						});
					}
					
					showCarousel();
					setTimeout(function(){ showCarousel(); }, 1000);
				});
			</script>
		<?php
		}
	}
		
	Plugin::instance()->widgets_manager->register( new Doctreat_TopRated ); 
	}