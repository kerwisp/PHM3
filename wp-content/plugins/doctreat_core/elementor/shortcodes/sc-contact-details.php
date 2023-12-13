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

if( !class_exists('Doctreat_Contact_Details') ){
	class Doctreat_Contact_Details extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_contact_details';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Contact Details', 'doctreat_core' );
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
			
			$version 		= array(
									'v1' 	=> esc_html__('V1','doctreat_core'),
									'v2' 	=> esc_html__('V2','doctreat_ccore')
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
				'address',
				[
					'label'  => esc_html__( 'Add Address', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'phone',
				[
					'label'  => esc_html__( 'Add Phone', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'email',
				[
					'label'  => esc_html__( 'Add Email address', 'doctreat_core' ),
					'type'   => Controls_Manager::TEXT,
				]
			);
			
			$this->add_control(
				'version',
				[
					'label'  		=> esc_html__( 'Select Version', 'doctreat_core' ),
					'type'   		=> Controls_Manager::SELECT,
					'options'   	=> $version,
					'default' 		=> 'v1',
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
			$address		= !empty($settings['address']) ? $settings['address'] : '';
			$phone			= !empty($settings['phone']) ? $settings['phone'] : '';
			$email			= !empty($settings['email']) ? $settings['email'] : '';
			$version		= !empty($settings['version']) ? $settings['version'] : 'v1';
			$flag 			= rand(9999, 999999);
			
			?>
			<div class="dc-haslayout dc-haslayout-<?php echo esc_attr( $version );?> align-self-center">
				<?php if( $version === 'v1' ){ ?>
					<div class="dc-welcomecontent">
						<?php if( !empty( $img_url ) ){?>
							<figure class="dc-welcomeimg"><img width="" height="" src="<?php echo esc_url( $img_url );?>" alt="<?php echo esc_attr( $title );?>"></figure>
						<?php } ?>
						<?php if( !empty( $title ) || !empty( $sub_title ) ){ ?>
							<div class="dc-title">
								<h3>
									<?php if( !empty( $title ) ){?><span><?php echo esc_html( $title );?></span><?php } ?><?php echo esc_html( $sub_title );?>
								</h3>
							</div>
						<?php } ?>
						<?php if( !empty( $description ) ){?>
							<div class="dc-description dc-paddingr"><?php echo do_shortcode( $description );?></div>
						<?php } ?>
						<?php if( !empty( $address ) || !empty( $phone ) || !empty( $email ) ){?>
							<div class="dc-contactinfo dc-floatclear">
								<ul>
									<?php if( !empty( $address ) ) {?>
										<li><span><span class="lnr lnr-location"></span><?php echo esc_html( $address );?></span></li>
									<?php }?>
									<?php if( !empty( $email ) ) {?>
										<li><span class="lnr lnr-envelope"></span><?php echo esc_html( $email );?></li>
									<?php }?>
									<?php if( !empty( $phone ) ) {?>
										<li><span class="lnr lnr-phone-handset"></span><?php echo esc_html( $phone );?></li>
									<?php }?>
								</ul>
							</div>
						<?php } ?>
					</div>
				<?php } elseif( $version === 'v2' ){ ?>
					<div class="dc-cntctfrmdetail">
						<?php if( !empty( $title ) || !empty( $sub_title ) ){ ?>
							<div class="dc-title">
								<h3>
									<?php if( !empty( $title ) ){?><span><?php echo esc_html( $title );?></span><?php } ?><?php echo esc_html( $sub_title );?>
								</h3>
							</div>
						<?php } ?>
						<?php if( !empty( $description ) ){?>
						<div class="dc-description"><?php echo do_shortcode( $description );?></div>
						<?php } ?>
						<?php if( !empty( $address ) || !empty( $phone ) || !empty( $email ) ){?>
							<ul class="dc-formcontactus">
								<?php if( !empty( $address ) ) {?>
									<li><address><i class="lnr lnr-location"></i><?php echo esc_html( $address );?></address></li>
								<?php }?>
								<?php if( !empty( $email ) ) {?>
									<li><a href="mailto:<?php echo esc_html( $email );?>"><i class="lnr lnr-envelope"></i><?php echo esc_html( $email );?></a></li>
								<?php }?>
								<?php if( !empty( $phone ) ) {?>
									<li><span><i class="lnr lnr-phone-handset"></i><?php echo esc_html( $phone );?></span></li>
								<?php }?>
							</ul>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Contact_Details ); 
	}