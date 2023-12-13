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

if( !class_exists('Doctreat_Health_Forum_Banner') ){
	class Doctreat_Health_Forum_Banner extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_health_forum_banner';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Health Forum Banner', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-posts-ticker';
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
					'label'     	=> esc_html__( 'Sub Title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section sub title. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'description',
				[
					'type'      	=> Controls_Manager::TEXTAREA,
					'label'     	=> esc_html__( 'Description', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section description. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'btn_text',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Button Text', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section button text. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'btn_url',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Button Url', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section button url. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'image',
				[
					'type'      	=> Controls_Manager::MEDIA,
					'label'     	=> esc_html__( 'Upload Image', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section Upload image. Leave it empty to hide.', 'doctreat_core' ),
					'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
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
						
			$title    		= !empty($settings['title']) ? $settings['title'] : '';
			$sub_title    	= !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$btn_text    	= !empty($settings['btn_text']) ? $settings['btn_text'] : '';
			$btn_url    	= !empty($settings['btn_url']) ? $settings['btn_url'] : '';
			$img_url    	= !empty($settings['image']['url']) ? $settings['image']['url'] : '';
			$desc     		= !empty($settings['description']) ? $settings['description'] : '';
			
			?>
			<div class="dc-questionsection">
				<div class="dc-askquery">
					<div class="dc-postquestion">
					<?php if( !empty( $title ) || !empty( $sub_title )){?>
						<div class="dc-title">
							<?php if( !empty( $title ) ) {?><span href="javascript:;"><?php echo esc_html( $title );?></span><?php } ?>
							<?php if( !empty( $sub_title ) ) {?><h2><?php echo esc_html( $sub_title );?></h2><?php } ?>
						</div>
					<?php } ?>
					<?php if( !empty( $desc ) ){?>
						<div class="dc-description"><?php echo esc_html($desc);?></div>
					<?php } ?>
					<?php if( !empty( $btn_text ) || !empty( $btn_url )){?>
						<div class="dc-btnarea">
							<a href="<?php echo esc_url( $btn_url );?>" class="dc-btn"><?php echo esc_html( $btn_text );?></a>
						</div>
					<?php } ?>
					</div>
					<?php if( !empty( $img_url ) ){?>
						<figure>
							<img width="" height="" src="<?php echo esc_url( $img_url);?>" alt="<?php esc_attr_e('Health Form','doctreat_core');?>">
						</figure>	
					<?php } ?>									
				</div>	
			</div>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Health_Forum_Banner ); 
}