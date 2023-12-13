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

if( !class_exists('Doctreat_FeaturedDoctors') ){
	class Doctreat_FeaturedDoctors extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_featured_doctors';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Featured Doctors', 'doctreat_core' );
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
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add newsletter title. leave it empty to hide.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'sub_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Sub title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add sub title. leave it empty to hide.', 'doctreat_core'),
				]
			);

			$this->add_control(
				'description',
				[
					'type'      	=> Controls_Manager::WYSIWYG,
					'label' 		=> esc_html__('Description', 'doctreat_core'),
        			'description' 	=> esc_html__('Add newsletter description. leave it empty to hide.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'post_ids',
				[
					'label'  	=> esc_html__( 'Doctors IDs', 'doctreat_core' ),
					'type'   	=> Controls_Manager::TEXT,
					'description' 		=> esc_html__('Add Doctors ids or leveve it empty to show latest doctors by speciality.', 'doctreat_core'),
				]
			);
			

			$this->add_control(
				'specialities',
				[
					'type'      	=> Controls_Manager::SELECT2,
					'label'			=> esc_html__('Specialities?', 'doctreat_core'),
					'description' 			=> esc_html__('Select speciality to display doctors. leave it empty to show from all categories', 'doctreat_core'),
					'options'   	=> $categories,
					'default' 		=> 'none',
					'multiple' 		=> true,
				]
			);

			$this->add_control(
				'show_posts',
				[
					'type'      	=> Controls_Manager:: NUMBER,
					'label' 		=> esc_html__('Show Posts', 'doctreat_core'),
        			'description' 	=> esc_html__('Show number of posts', 'doctreat_core'),
				]
			);

			$this->add_control(
				'show_button',
				[
					'label' => esc_html__( 'Show All', 'doctreat_core' ),
					'description' 	=> esc_html__('Show all posts button', 'doctreat_core'),
					'type'  => Controls_Manager::SELECT,
					'default' => 'no',
					'options' => [
						'no' 	=> esc_html__('No', 'doctreat_core'),
						'yes' 	=> esc_html__('Yes', 'doctreat_core')
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
			$settings 		= $this->get_settings_for_display();
			$title       	= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title   	= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$show_posts   	= !empty($settings['show_posts']) ? $settings['show_posts'] : 4;
			$show_button   	= !empty($settings['show_button']) ? $settings['show_button'] : 'no';
			$desc  	     	= !empty($settings['description']) ? $settings['description'] : '';
			$post_ids			= !empty($settings['post_ids']) ? explode(',',$settings['post_ids']) : array();
			$specialities		= !empty($settings['specialities']) ? $settings['specialities'] : '';
			$args				= array();
			$speciality_data	= array();
			$search_page	= '';
			if( function_exists('doctreat_get_search_page_uri') ){
				$search_page  = doctreat_get_search_page_uri('doctors');
			}
			
			//check if search page
			if (is_page_template('directory/doctor-search.php')) {
				$specialities	= !empty($_GET['specialities']) ? $_GET['specialities'] : '';
			}

			$doctors		= array();
			$args['posts_per_page']			= $show_posts;
			$args['post_type']				= array('doctors');
			$args['post_status']			= 'publish';
			$args['ignore_sticky_posts']	= 1;
			
			if (is_page_template('directory/doctor-search.php')) {
				$args['tax_query']		= array(
							array(
								'taxonomy' 	=> 'specialities',
								'field' 	=> 'slug',
								'terms' 	=> $specialities,
							)
						);
			}else{
				if( !empty( $post_ids )) {
						$args['post__in']		= $post_ids;
					} else {
						if( !empty( $specialities ) ){
							$args['tax_query']		= array(
								array(
									'taxonomy' 	=> 'specialities',
									'field' 	=> 'term_id',
									'terms' 	=> $specialities,
								)
							);
						}
					}
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
			$total_doctors		= count($doctors);
			$total_doctors		= !empty( $total_doctors ) ? intval($total_doctors) : 0;
			$flag 				= rand(9999, 999999);
			
			?>
			<div class="dc-haslayout sc-top-reted">
				<div class="container">
					<div class="row justify-content-center align-self-center">
						<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $desc ) ) {?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 push-lg-2">
								<div class="dc-sectionhead dc-text-center">
									<?php if( !empty( $title ) || !empty( $sub_title ) ) {?>
										<div class="dc-sectiontitle">
											<h2>
												<?php if( !empty( $title ) ) {?><span><?php echo esc_html( $title );?></span><?php } ?>
												<?php echo wp_kses($sub_title,array('em' => array()));?>
											</h2>
										</div>
									<?php } ?>
									<?php if( !empty( $desc ) ) {?>
										<div class="dc-description"><?php echo do_shortcode( $desc );?></div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<?php if( !empty( $doctors ) ){?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
								<div class="dc-docfeatured">
									<div class="row">
										<?php foreach ( $doctors as $doctor ){?>
											<div class="col-12 col-sm-6 col-lg-4 col-xl-3">
												<div class="dc-docpostholder">
													<a href="<?php echo esc_url(get_the_permalink($doctor->ID));?>">
														<?php 
															if( function_exists('doctreat_get_doctor_thumnail') ){
																do_action('doctreat_get_doctor_thumnail',$doctor->ID,547,428);
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
																do_action('doctreat_get_doctor_booking',$doctor->ID,'no');
															}
														?>
													</div>
												</div>
											</div>
										<?php } ?>
										<?php if( !empty( $show_button ) && $show_button === 'yes' ){?>
										<div class="col-12">
											<div class="dc-btnarea">
												<a href="<?php echo esc_url( $search_page );?>" class="dc-btn"><?php esc_html_e('Show All', 'doctreat_core');?></a>
											</div>
										</div>
										<?php }?>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
		}
	}
		
	Plugin::instance()->widgets_manager->register( new Doctreat_FeaturedDoctors ); 
	}