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

if( !class_exists('Doctreat_How_WorksV2') ){
	class Doctreat_How_WorksV2 extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_how_worksv2';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'How It works V2', 'doctreat_core' );
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
			$alignment = array(
								'float-right' 	=> esc_html__('Right','doctreat_core'),
								'float-left' 	=> esc_html__('Left','doctreat_ccore')
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
					'label'  => esc_html__( 'Add description', 'doctreat_core' ),
					'type'   => Controls_Manager::WYSIWYG,
				]
			);
			$this->add_control(
				'work_process',
				[
					'label'  => esc_html__( 'Add work process', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name'  => 'text_number',
							'label' => esc_html__( 'Add Number', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'title',
							'label' => esc_html__( 'Add title', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  		=> 'sub_title',
							'label' 		=> esc_html__( 'Add sub title', 'doctreat_core' ),
							'description' 	=> esc_html__('Add description. Leave it empty to hide description.', 'doctreat_core'),
							'type'  		=> Controls_Manager::TEXT,
						],
						[
							'name'  => 'description',
							'label' => esc_html__( 'Description', 'doctreat_core' ),
							'type'  => Controls_Manager::WYSIWYG,
							'default' => '',
						],
						[
							'name'  		=> 'content_alginment',
							'label' 		=> esc_html__( 'Content Section Alignment', 'doctreat_core' ),
							'description' 	=> esc_html__('Select right or left.', 'doctreat_core'),
							'type'      	=> Controls_Manager::SELECT,
							'options'   	=> $alignment,
							'default' 		=> '',
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
							'name'  		=> 'image_alginment',
							'label' 		=> esc_html__( 'Image Section Alignment', 'doctreat_core' ),
							'description' 	=> esc_html__('Select right or left.', 'doctreat_core'),
							'type'      	=> Controls_Manager::SELECT,
							'options'   	=> $alignment,
							'default' 		=> '',
						],
					],
					'default' => [],
				]
			);
			
			$this->add_control(
				'btn_title',
				[
					'label'  => esc_html__( 'Add Button title', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			$this->add_control(
				'btn_url',
				[
					'label'  => esc_html__( 'Add butten url', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
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
			
			$title			= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title		= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$description	= !empty($settings['description']) ? $settings['description'] : '';
			
			$btn_title		= !empty($settings['btn_title']) ? $settings['btn_title'] : '';
			$btn_url		= !empty($settings['btn_url']) ? $settings['btn_url'] : '#';
			
			$work_process		= !empty($settings['work_process']) ? $settings['work_process'] : array();
			$count_process		= 0;
			$flag 				= rand(9999, 999999);
			?>
			<div class="dc-itsworkvtwov2 dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="dc-howitswork">
					<div class="dc-sectionhead dc-text-center">
						<?php if( !empty( $sub_title ) || !empty( $title ) ){?>
							<div class="dc-sectiontitle">
								<h2>
									<?php if( !empty( $title ) ) { ?><span><?php echo esc_html( $title );?></span><?php } ?>
									<?php if( !empty( $sub_title ) ) echo wp_kses($sub_title,array(
										'em' => array()
									));?>
								</h2>
							</div>
						<?php } ?>
						<?php if( !empty( $description ) ){ ?>
							<div class="dc-description"><?php echo do_shortcode( $description );?></div>
						<?php } ?>
					</div>									
				</div>
				<?php if( !empty( $work_process ) ){ ?>
					<div class="dc-workingtimeline">
						<div class="main-timeline">
							<?php 
								foreach( $work_process as $process ){ 
									$title				= !empty( $process['title'] ) ? $process['title'] : '';
									$text_number		= !empty( $process['text_number'] ) ? $process['text_number'] : '';
									$sub_title			= !empty( $process['sub_title'] ) ? $process['sub_title'] : '';
									$description		= !empty( $process['description'] ) ? $process['description'] : '';
									$img_url			= !empty( $process['image']['url'] ) ? $process['image']['url'] : '';
									$imag_alginment		= !empty( $process['image_alginment'] ) ? $process['image_alginment'] : '';
									$content_alginment	= !empty( $process['content_alginment'] ) ? $process['content_alginment'] : '';
								?>
								<div class="timeline">
									<div class="timeline-icon">
									</div>
									<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $description ) ){?>
										<div class="timeline-content <?php echo esc_attr( $content_alginment );?>">
											<?php if( !empty( $title ) || !empty( $sub_title ) ){?>
												<div class="dc-title">
													<h3>
														<?php if( !empty( $title ) ) { ?><span><?php echo esc_html( $title ) ;?></span><?php } ?>
														<?php if( !empty( $sub_title ) )  echo esc_html( $sub_title ); ?>
													</h3>
												</div>
											<?php } ?>
											<?php if( !empty( $description ) ){?>
												<div class="dc-description"><?php echo wp_kses( $description,array('p' => array()) );?></div>
											<?php } ?>
										</div>
									<?php } ?>
									<?php if( !empty( $text_number ) || !empty( $img_url ) ) {?>
										<div class="timeline-content <?php echo esc_attr( $imag_alginment );?>">
											<div class="dc-contentwithimg">
												<?php if( !empty( $imag_alginment ) && $imag_alginment === 'float-left' ) {?>
													<?php if( !empty( $text_number ) ) { ?><span class="align-self-center"><?php echo esc_html( $text_number );?></span><?php } ?>
													<?php if( !empty( $img_url ) ){?>
														<figure><img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $title );?>"></figure>
													<?php } ?>
												<?php } elseif( !empty( $imag_alginment ) && $imag_alginment === 'float-right' ) { ?>
													<?php if( !empty( $img_url ) ){?>
														<figure>
															<img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $title );?>">
														</figure>
													<?php } ?>
													<?php if( !empty( $text_number ) ) { ?><span class="align-self-center"><?php echo esc_html( $text_number );?></span><?php } ?>
												<?php } ?>
											</div>
										</div>	
									<?php } ?>										
								</div>
							<?php } ?>
						</div>
						<?php if( !empty( $btn_title ) ){?>
							<div class="dc-btnarea">
								<a href="<?php echo esc_url( $btn_url );?>" class="dc-btn"><?php echo esc_html( $btn_title );?></a>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_How_WorksV2 ); 
}