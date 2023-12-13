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

if( !class_exists('Doctreat_Easy_Steps') ){
	class Doctreat_Easy_Steps extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_easy_steps';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Easy Steps', 'doctreat_core' );
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
				'description',
				[
					'type'      	=> Controls_Manager::WYSIWYG,
					'label' 		=> esc_html__('Description', 'doctreat_core'),
        			'description' 	=> esc_html__('Add description. Leave it empty to hide description.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'work_process',
				[
					'label'  => esc_html__( 'Add work process', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
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
							'name' 			=> 'image',
							'type'      	=> Controls_Manager::MEDIA,
							'label'     	=> esc_html__( 'Upload image', 'doctreat_core' ),
							'description'   => esc_html__( 'Upload image.', 'doctreat_core' ),
							'default' => [
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							],
						],
						[
							'name' 			=> 'description',
							'type'      	=> Controls_Manager::WYSIWYG,
							'label'     	=> esc_html__( 'Description', 'doctreat_core' ),
							'description'   => esc_html__( 'Add description .', 'doctreat_core' ),
						]
						,
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
			$settings 			= $this->get_settings_for_display();
			
			$title       		= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title   		= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$desc  	     		= !empty($settings['description']) ? $settings['description'] : '';

			$work_process  		= !empty($settings['work_process']) ? $settings['work_process'] : array();
			$count_process		= 0;
			$flag 				= rand(9999, 999999);
			?>
			<div class="dc-aboutstep dc-easy-steps dc-haslayout dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="container">
					<div class="row justify-content-center align-self-center">
						<?php if( !empty( $title )  || !empty( $sub_title ) || !empty( $desc ) ){?>
							<div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-8 push-lg-2">
								<div class="dc-sectionhead dc-text-center">
									<?php if( !empty( $title )  || !empty( $sub_title ) ){?>
										<div class="dc-sectiontitle">
											<h2>
												<span><?php echo esc_html( $title );?></span>
												<?php if( !empty( $sub_title ) ) {?><?php echo do_shortcode( $sub_title ); ?><?php } ?>
											</h2>
										</div>
									<?php } ?>
									<?php if( !empty( $desc ) ){?>
										<div class="dc-description"><?php echo do_shortcode( $desc );?></div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<?php if( !empty( $work_process ) ) {?>
							<div class="dc-welcome-holder dc-bksteps">
								<?php 
									foreach ( $work_process as $work_proc ){ 
										$img_url	= !empty( $work_proc['image']['url'] ) ? $work_proc['image']['url'] : '';
										$title		= !empty( $work_proc['title'] ) ? $work_proc['title'] : '';
										$sub_title	= !empty( $work_proc['sub_title'] ) ? $work_proc['sub_title'] : '';
										$description= !empty( $work_proc['description'] ) ? $work_proc['description'] : '';
									?>
									<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 float-left">
										<div class="dc-welcomecontent">
											<?php if( !empty( $img_url ) ){?>
												<figure class="dc-welcomeimg"><img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr($title);?>"></figure>
												<?php } ?>
											<?php if( !empty( $title ) || !empty( $sub_title )) {?>
												<div class="dc-title">
													<h3><?php if( !empty ( $title ) ) {?><span><?php echo esc_html( $title ) ;?></span><?php } ?><?php echo esc_html( $sub_title );?></h3>
												</div>
											<?php } ?>
											<?php if( !empty( $description ) ){?>
												<div class="dc-description"><?php echo do_shortcode( $description );?></div>
											<?php } ?>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Easy_Steps ); 
}