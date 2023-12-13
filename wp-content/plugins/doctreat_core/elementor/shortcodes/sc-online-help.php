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

if( !class_exists('Doctreat_Online_Help') ){
	class Doctreat_Online_Help extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_online_help';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Online Help', 'doctreat_core' );
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
				'image',
				[
					'label'  => esc_html__( 'Add image', 'doctreat_core' ),
					'type'   => Controls_Manager::MEDIA,
					'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
				]
			);
			$this->add_control(
				'btn1text',
				[
					'label'  => esc_html__( 'Add first button text ', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'btn1url',
				[
					'label'  => esc_html__( 'Add first button url', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'btn2text',
				[
					'label'  => esc_html__( 'Add second button text ', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'btn2url',
				[
					'label'  => esc_html__( 'Add second button url', 'doctreat_core' ),
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
			$settings 		= $this->get_settings_for_display();
			$img_url		= !empty($settings['image']['url']) ? $settings['image']['url'] : '';
			$title			= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title		= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$description	= !empty($settings['description']) ? $settings['description'] : '';
			$btn1text		= !empty($settings['btn1text']) ? $settings['btn1text'] : '';
			$btn1url		= !empty($settings['btn1url']) ? $settings['btn1url'] : '';
			$btn2text		= !empty($settings['btn2text']) ? $settings['btn2text'] : '';
			$btn2url		= !empty($settings['btn2url']) ? $settings['btn2url'] : '';
			$flag 			= rand(9999, 999999);
			?>
			<div class="text-center dc-querycontent dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="container">
					<div class="row justify-content-center">
						<div class="col-12 col-sm-12 col-md-12 col-lg-8">	
							<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $description )){?>					
								<div class="dc-sectionhead dc-sectionheadvtwo">
									<?php if( !empty( $title ) || !empty( $sub_title ) ){?>
										<div class="dc-sectiontitle">
											<h2>
												<?php echo esc_html( $title );?>
												<?php if( !empty( $sub_title ) ) {?><span><?php echo esc_html( $sub_title );?></span><?php } ?>
											</h2>
										</div>
									<?php } ?>
									<?php if( !empty( $description ) ) {?>
										<div class="dc-description"><?php echo do_shortcode($description);?></div>
									<?php } ?>
								</div>
							<?php } ?>
							<?php if( !empty( $btn1text ) || !empty( $btn2text ) ){?>
								<div class="dc-btnarea d-flex justify-content-center">
									<?php if( !empty( $btn1text ) ) {?>
										<a href="<?php echo esc_html( $btn1url );?>" class="dc-btn dc-btnactive"><?php echo esc_html( $btn1text );?></a>
									<?php } ?>
									<?php if( !empty( $btn2text ) ) {?>
										<a href="<?php echo esc_html( $btn2url );?>" class="dc-btn"><?php echo esc_html( $btn2text );?></a>
									<?php } ?>
								</div>
							<?php } ?>
							<?php if( !empty( $img_url ) ){ ?>
								<figure class="dc-queryimg">
									<img width="" height="" src="<?php echo esc_url( $img_url ); ?>" alt="">
								</figure>
							<?php } ?>
						</div>
					</div>				
				</div>
			</div>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Online_Help ); 
	}