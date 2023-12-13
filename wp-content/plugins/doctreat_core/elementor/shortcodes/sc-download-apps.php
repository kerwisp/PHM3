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

if( !class_exists('Doctreat_Download_APP') ){
	class Doctreat_Download_APP extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_download_app';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Download APPS', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-download-button';
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
				'image',
				[
					'type'      	=> Controls_Manager::MEDIA,
					'label'     	=> esc_html__( 'Upload Image', 'doctreat_core' ),
					'description'   => esc_html__( 'Upload Image. leave it empty to hide.', 'doctreat_core' ),
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
					'type'      	=> Controls_Manager::WYSIWYG,
					'label'     	=> esc_html__( 'Description', 'doctreat_core' ),
					'description'   => esc_html__( 'Add description. leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'logos',
				[
					'label'  => esc_html__( 'Logos', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name'  => 'image',
							'label' => esc_html__( 'Select logo', 'doctreat_core' ),
							'type'  => Controls_Manager::MEDIA,
							'default' => [
								'url' => \Elementor\Utils::get_placeholder_image_src(),
							],
						],
						[
							'name'  => 'link_url',
							'label' => esc_html__( 'Add URL', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'link_target',
							'label' => esc_html__( 'Link Target', 'doctreat_core' ),
							'type'  => Controls_Manager::SELECT,
							'default' => '_blank',
							'options' => [
								'_blank' 	=> esc_html__('New Tab', 'doctreat_core'),
								'_self' 	=> esc_html__('Current Tab', 'doctreat_core'),
							],
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
			$image 	   = !empty($settings['image']['url']) ? $settings['image']['url'] : '';
			$title     = !empty($settings['title']) ? $settings['title'] : '';
			$sub_title = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$desc  	   = !empty($settings['description']) ? $settings['description'] : '';
			$logos 	   = !empty($settings['logos']) ? $settings['logos'] : array();
			?>
			<div class="dc-haslayout dc-bgcolor">
				<div class="container">
					<?php if( !empty( $image ) || !empty( $title ) || !empty( $sub_title ) || !empty( $desc ) || !empty( $logos ) ) { ?>
						<div class="row">
							<?php if( !empty( $image ) ) { ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
									<div class="dc-appbgimg">
										<figure>
											<img width="" height="" src="<?php echo esc_url($image); ?>" alt="<?php esc_attr_e('APP' ,'doctreat_core') ?>">
										</figure>
									</div>
								</div>
							<?php } ?>
							<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $desc ) || !empty( $logos ) ) { ?>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6 justify-content-center align-self-center">
									<div class="dc-appcontent">
										<div class="dc-sectionhead dc-sectionheadvtwo">
											<?php if( !empty( $title ) || !empty( $sub_title ) ) {?>
												<div class="dc-sectiontitle">
													<h2>
														<?php echo esc_html( $title );?>
														<?php if( !empty( $sub_title ) ) {?>
															<span><?php echo esc_html( $sub_title ) ;?></span>
														<?php } ?>
													</h2>
												</div>
											<?php } ?>
											<?php if( !empty( $desc ) ){?>
												<div class="dc-description">
													<?php echo wp_kses_post( do_shortcode( $desc ) ); ?>
												</div>
											<?php } ?>
										</div>
										<?php if( !empty( $logos ) ) { ?>
											<ul class="dc-appicons">
												<?php 
													foreach( $logos as $key => $logo ) { 
														$image  = !empty( $logo['image']['url'] ) ? $logo['image']['url'] : '';
														$url    = !empty( $logo['link_url'] ) ? $logo['link_url'] : '#';
														$target = !empty( $logo['link_target'] ) ? $logo['link_target'] : '_blank';
														if( !empty( $image ) ) { ?>
															<li>
																<a target="<?php echo esc_attr($target); ?>" href="<?php echo esc_url($url); ?>">
																<?php if( !empty( $image ) ) { ?>
																	<figure><img width="" height="" src="<?php echo esc_url( $image ); ?>" alt="<?php esc_attr_e('Logo', 'doctreat_core'); ?>"></figure>
																<?php } ?>
																</a>
															</li>
														<?php } ?>
													<?php } ?>
											</ul>
										<?php } ?>
									</div>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Download_APP ); 
}