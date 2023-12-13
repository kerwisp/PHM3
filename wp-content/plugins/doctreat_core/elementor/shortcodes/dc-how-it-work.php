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

if( !class_exists('Doctreat_How_Works') ){
	class Doctreat_How_Works extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_how_works';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'How It works', 'doctreat_core' );
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
			$image_alignment = array(
								'float-right' 	=> esc_html__('Right','doctreat_core'),
								'' 				=> esc_html__('Left','doctreat_ccore')
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
							'name'  => 'btn_text',
							'label' => esc_html__( 'Button text', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'btn_url',
							'label' => esc_html__( 'Button url', 'doctreat_core' ),
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
							'name'  => 'image_alginment',
							'label' => esc_html__( 'Image Alignment', 'doctreat_core' ),
							'description' 	=> esc_html__('Select right or left.', 'doctreat_core'),
							'type'      	=> Controls_Manager::SELECT,
							'options'   	=> $image_alignment,
							'default' 		=> '',
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
			$settings = $this->get_settings_for_display();

			$work_process		= !empty($settings['work_process']) ? $settings['work_process'] : array();
			$count_process		= 0;
			$flag 				= rand(9999, 999999);
			?>
			<div class="dc-itsworkvtwo dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 col-xl-9">
					<div class="dc-itsworkvtwo">
						<?php 
							if( !empty( $work_process ) ){
								foreach( $work_process as $process ) {
									$title			= !empty( $process['title'] ) ? $process['title'] : '';
									$sub_title		= !empty( $process['sub_title'] ) ? $process['sub_title'] : '';
									$description	= !empty( $process['description'] ) ? $process['description'] : '';
									$btn_text		= !empty( $process['btn_text'] ) ? $process['btn_text'] : '';
									$btn_url		= !empty( $process['btn_url'] ) ? $process['btn_url'] : '';
									$img_url		= !empty( $process['image']['url'] ) ? $process['image']['url'] : '';
									$img_alginment	= !empty( $process['image_alginment'] ) ? 'class="'.$process['image_alginment'].'"' : '';
									$col_alginment	= !empty( $process['image_alginment'] ) ? 'order-1' : '';
								?>
								<div class="dc-itsworkvtwoitem">
									<div class="row">
										<div class="col-12 col-md-12 col-lg-6 <?php echo esc_attr( $col_alginment );?>">
											<div class="dc-workvtwocontent">
												<?php if( !empty( $title ) || !empty( $sub_title ) ){ ?>
													<div class="dc-title">
														<h3>
															<?php if( !empty( $title ) ){ ?><span><?php echo esc_html( $title );?></span><?php } ?>
															 <?php echo esc_html( $sub_title );?>
														</h3>
													</div>
												<?php } ?>
												<?php if( !empty( $description ) ){?>
													<div class="dc-description"><?php echo do_shortcode ( $description );?></div>
												<?php } ?>
												<?php if( !empty( $btn_text ) ){?>
													<div class="dc-btnarea">
														<a href="<?php echo esc_url( $btn_url );?>" class="dc-btn"><?php echo esc_html( $btn_text );?></a>
													</div>
												<?php } ?>
											</div>												
										</div>
										<?php if( !empty( $img_url ) ){ ?>
											<div class="col-12 col-md-12 col-lg-6">
												<div class="dc-workvtwoimg">
													<figure>
														<img width="" height="" <?php echo esc_attr($img_alginment);?> src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $title );?>">
													</figure>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_How_Works ); 
}