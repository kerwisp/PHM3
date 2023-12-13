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

if( !class_exists('Doctreat_Aboutus') ){
	class Doctreat_Aboutus extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_about_us';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'About us', 'doctreat_core' );
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
					'label'  => esc_html__( 'Add description', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXTAREA,
				]
			);
			$this->add_control(
				'btn1_text',
				[
					'label'  => esc_html__( 'Add first button text', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			$this->add_control(
				'btn1_url',
				[
					'label'  => esc_html__( 'Add first button url', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			$this->add_control(
				'btn2_text',
				[
					'label'  => esc_html__( 'Add second button text', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			$this->add_control(
				'btn2_url',
				[
					'label'  => esc_html__( 'Add second button url', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
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
				'image_title',
				[
					'label'  => esc_html__( 'Add title', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
					'description'   => esc_html__( 'Image related title.', 'doctreat_core' ),
				]
			);
			$this->add_control(
				'image_sub_title',
				[
					'label'  => esc_html__( 'Add sub title', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
					'description'   => esc_html__( 'Image related sub title.', 'doctreat_core' ),
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
			$sub_title		= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$description	= !empty($settings['description']) ? $settings['description'] : '';
			
			$img_url		= !empty($settings['image']['url']) ? $settings['image']['url'] : '';
			$image_title	= !empty($settings['image_title']) ? $settings['image_title'] : '';
			$img_sub_title	= !empty($settings['image_sub_title']) ? $settings['image_sub_title'] : '';
			
			$btn1_text		= !empty($settings['btn1_text']) ? $settings['btn1_text'] : '';
			$btn1_url		= !empty($settings['btn1_url']) ? $settings['btn1_url'] : '';
			$btn2_text		= !empty($settings['btn2_text']) ? $settings['btn2_text'] : '';
			$btn2_url		= !empty($settings['btn2_url']) ? $settings['btn2_url'] : '';
			
			$flag 			= rand(9999, 999999);
			?>
			<div class="sc-about-us dc-haslayout dc-sectionbg dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="container">
					<div class="row">
						<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $description ) || !empty( $btn1_text ) || !empty( $btn2_text )   ) {?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-6 align-self-center">
								<div class="dc-bringcarecontent">
									<div class="dc-sectionhead dc-sectionheadvtwo">
										<?php if( !empty( $title ) || !empty( $sub_title ) ){ ?>
											<div class="dc-sectiontitle">
												<h2>
													<?php echo esc_html( $title );?>
													<?php if( !empty( $sub_title ) ) {?><span><?php echo esc_html( $sub_title );?></span><?php } ?>
												</h2>
											</div>
										<?php } ?>
										<?php if( !empty( $description ) ){?>
											<div class="dc-description">
												<p><?php echo esc_html( $description );?></p>
											</div>
										<?php } ?>
									</div>
									<?php if( !empty( $btn1_text ) || !empty( $btn2_text ) ){?>
										<div class="dc-btnarea">
											<?php if( !empty( $btn1_text )) {?><a href="<?php echo esc_url( $btn1_url );?>" class="dc-btn"><?php echo esc_html( $btn1_text );?></a><?php } ?>
											<?php if( !empty( $btn2_text )) {?><a href="<?php echo esc_url( $btn2_url );?>" class="dc-btn dc-btnactive"><?php echo esc_html( $btn2_text );?></a><?php } ?>
										</div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<?php if( !empty( $img_url ) || !empty( $image_title ) || !empty( $img_sub_title ) ){?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-6">
								<div class="dc-bringimg-holder">
									<figure class="dc-doccareimg">
										<?php if( !empty( $img_url )) {?><img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $image_title );?>"><?php } ?>
										<?php if( !empty( $image_title ) || !empty( $img_sub_title ) ){?>
											<figcaption>
												<div class="dc-doccarecontent">
													<h3><?php if( !empty( $image_title)) {?><em><?php echo esc_html( $image_title );?></em><?php } ?><?php echo esc_html( $img_sub_title );?></h3>
												</div>
											</figcaption>
										<?php } ?>
									</figure>
								</div>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Aboutus ); 
	}