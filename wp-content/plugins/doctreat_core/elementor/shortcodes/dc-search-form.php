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

if( !class_exists('Doctreat_Search_Form') ){
	class Doctreat_Search_Form extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_search_form';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Search form', 'doctreat_core' );
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
					'label'     	=> esc_html__( 'Form', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section title. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'hide_location',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'			=> esc_html__('Hide locations', 'doctreat_core'),
					'description' 			=> esc_html__('Hide location dropdown.', 'doctreat_core'),
					'default' => 'no',
					'options' => [
						'no' 	=> esc_html__('No', 'doctreat_core'),
						'yes' 	=> esc_html__('Yes', 'doctreat_core')
					],
				]
			);
			
			$this->add_control(
				'search_form',
				[
					'type'      	=> \Elementor\Controls_Manager::SWITCHER,
					'label'     	=> esc_html__( 'Form Enable/Disbale', 'doctreat_core' ),
					'label_on' 		=> esc_html__( 'Show', 'doctreat_core' ),
					'label_off' 	=> esc_html__( 'Hide', 'doctreat_core' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'yes',
				]
			);
			
			$this->add_control(
				'doctor_image',
				[
					'type'      	=> Controls_Manager::MEDIA,
					'label'     	=> esc_html__( 'Section Image', 'doctreat_core' ),
					'description'   => esc_html__( 'Upload image for doctor section', 'doctreat_core' ),
					'default' => [
                        'url' => \Elementor\Utils::get_placeholder_image_src(),
                    ],
				]
			);
			
			$this->add_control(
				'doctor_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section title. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'doctor_sub_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Sub title', 'doctreat_core' ),
					'description'   => esc_html__( 'Add section sub title. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'btn_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Butten Text', 'doctreat_core' ),
					'description'   => esc_html__( 'Add butten text. Leave it empty to hide.', 'doctreat_core' ),
				]
			);
			
			$this->add_control(
				'btn_link',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Butten Url', 'doctreat_core' ),
					'description'   => esc_html__( 'Add butten url.', 'doctreat_core' ),
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

			$title        		= !empty($settings['title']) ? $settings['title'] : '';
			$search_form    	= !empty($settings['search_form']) ? $settings['search_form'] : '';
			$doctor_image  		= !empty($settings['doctor_image']['url']) ? $settings['doctor_image']['url'] : '';
			$doctor_title		= !empty($settings['doctor_title']) ? $settings['doctor_title'] : '';
			$doctor_sub_title	= !empty($settings['doctor_sub_title']) ? $settings['doctor_sub_title'] : '';
			$btn_title			= !empty($settings['btn_title']) ? $settings['btn_title'] : '';
			$btn_link			= !empty($settings['btn_link']) ? $settings['btn_link'] : '#';
			$hide_location		= !empty($settings['hide_location']) ? $settings['hide_location'] : 'no';
			
			$search_page	= '';
			if( function_exists('doctreat_get_search_page_uri') ){
				$search_page  = doctreat_get_search_page_uri('doctors');
			}
			$flag 			= rand(9999, 999999);
			
			$hide_loc = 'dc-hidelocation'; 
			if( !empty($hide_location) && $hide_location === 'no'){
				$hide_loc = ''; 
			}
			?>
			<div class="dc-haslayout dc-section-<?php echo intval($flag);?> <?php echo esc_attr($hide_loc);?>">
				<div class="dc-searchform-holder">
					<div class="dc-advancedsearch">
						<?php if( !empty( $title ) ){?>
							<div class="dc-title">
								<h2><?php echo esc_html( $title );?></h2>
							</div>
						<?php } ?>
						<?php if( !empty( $search_form ) && $search_form === 'yes' ){?>
							<form class="dc-formtheme dc-form-advancedsearch" action="<?php echo esc_url( $search_page );?>" method="get">
								<fieldset>
									<?php if( function_exists('doctreat_get_search_text_field') ){?>
										<div class="form-group">
											<?php do_action('doctreat_get_search_text_field');?>
										</div>
									<?php } ?>
									<?php if( function_exists('doctreat_get_search_locations') && $hide_location === 'no' ){?>
										<div class="form-group">
											<div class="dc-select">
												<?php do_action('doctreat_get_search_locations');?>
											</div>
										</div>
									<?php } ?>
									<div class="dc-formbtn">
										<button class="dc-serach-form"><i class="ti-search"></i><span>&nbsp;<?php esc_html_e('Search now','doctreat_core');?></span></button>
									</div>
								</fieldset>
								<fieldset class="advancefilters-wrap">
									<div class="form-group">
										<div class="dc-select">
											<?php do_action('doctreat_get_search_speciality');?>
										</div>
									</div>
									<div class="form-group">
										<div class="dc-select" id="search_services">
											<?php do_action('doctreat_get_search_services');?>
										</div>
									</div>
								</fieldset>
							</form>
						<?php } ?>
						<div class="dc-advancesearch-holder">
							<a href="javascript:;" class="dc-docsearch dc-serach-toggle">
								<span class="dc-advanceicon"><i></i> <i></i> <i></i></span>
								<span><?php echo wp_kses(__('Advanced Search','doctreat_core'),array(
										'br' => array()
									));?></span>
							</a>
						</div>
					</div>
					<?php if( !empty( $doctor_sub_title ) || !empty( $doctor_sub_title ) || !empty( $btn_title ) || !empty( $doctor_image )) {?>
						<div class="dc-jointeamholder">
							<div class="dc-jointeam">
								<?php if( !empty( $doctor_image ) ){ ?>
									<figure class="dc-jointeamimg">
										<img width="" height="" src="<?php echo esc_url( $doctor_image );?>" alt="<?php esc_attr_e('img description','doctreat_core');?>">
									</figure>
								<?php } ?>
								<?php if( !empty( $doctor_sub_title ) || !empty( $doctor_sub_title ) || !empty( $btn_title )) {?>
									<div class="dc-jointeamcontent">
										<?php if( !empty( $doctor_sub_title ) || !empty( $doctor_sub_title ) ) {?>
											<h3>
												<?php if( !empty( $doctor_title ) ){?>
													<span><?php echo esc_html( $doctor_title );?></span>
												<?php } ?>
												<?php echo esc_html($doctor_sub_title);?>
											</h3>
										<?php } ?>
										<?php if( !empty( $btn_title ) ){?>
											<a href="<?php echo esc_url( $btn_link );?>" class="dc-btn dc-btnactive"><?php echo esc_html( $btn_title );?></a>
										<?php } ?>
									</div>
								<?php } ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<script>
				jQuery(document).on('ready', function() {
					jQuery('.dc-serach-form').on('click', function(){
						jQuery('.dc-form-advancedsearch').submit();
					});
				});
			</script>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Search_Form ); 
}