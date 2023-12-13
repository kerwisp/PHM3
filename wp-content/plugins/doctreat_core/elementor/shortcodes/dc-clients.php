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

if( !class_exists('Doctreat_Clients') ){
	class Doctreat_Clients extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_clients';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Clients', 'doctreat_core' );
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
				'description',
				[
					'type'      	=> Controls_Manager::WYSIWYG,
					'label'     	=> esc_html__( 'Description', 'doctreat_core' )
				]
			);

			
			
			$this->add_control(
				'clients',
				[
					'label'  => esc_html__( 'Add Clients', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name'  => 'name',
							'label' => esc_html__( 'Add name', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'url',
							'label' => esc_html__( 'Add Url', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
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
			$settings = $this->get_settings_for_display();

			$title        	= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title    	= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$description  	= !empty($settings['description']) ? $settings['description'] : '';
			$clients		= !empty($settings['clients']) ? $settings['clients'] : array();
			$flag 			= rand(9999, 999999);
			?>
			<div class="dc-clients dc-haslayout dynamic-secton-<?php echo esc_attr( $flag );?>">
				<div class="container">
					<div class="row justify-content-center align-self-center">
						<?php if( !empty( $title  || !empty( $sub_title ) || !empty( $description ) ) ){?>
							<div class="col-xs-12 col-sm-12 col-md-8 push-md-2 col-lg-8 push-lg-2">
								<div class="dc-sectionhead dc-text-center">
									<?php if( !empty( $title ) || !empty( $sub_title ) ){?>
										<div class="dc-sectiontitle">
											<h2>
												<?php if( !empty( $title ) ) { ?><span><?php echo esc_html( $title );?></span><?php } ?>
												<?php echo do_shortcode( $sub_title );?>
											</h2>
										</div>
									<?php } ?>
									<?php if( !empty( $description ) ){?>
										<div class="dc-description"><?php echo do_shortcode( $description );?></div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<?php if( !empty( $clients ) ){?>
							<div class="col-12 col-sm-12 col-md-12 col-lg-12 float-left">
								<div class="dc-clientslogo">
									<ul>
										<?php 
											foreach( $clients as $client ) {
												$name        	= !empty($client['name']) ? $client['name'] : '';
												$url        	= !empty($client['url']) ? $client['url'] : '';
												$img_url       	= !empty($client['avatar']['url']) ? $client['avatar']['url'] : '';
												if( !empty( $img_url ) ){ ?>
													<li><a href="<?php echo esc_url( $url );?>"><img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $name );?> "></a></li>
											<?php } ?>
										<?php } ?>
									</ul>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Clients ); 
}