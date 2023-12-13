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

if( !class_exists('Doctreat_Teams') ){
	class Doctreat_Teams extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_teams';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Teams', 'doctreat_core' );
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
				'team_members',
				[
					'label'  => esc_html__( 'Add team Member', 'doctreat_core' ),
					'type'   => Controls_Manager::REPEATER,
					'fields' => [
						[
							'name'  => 'name',
							'label' => esc_html__( 'Add name', 'doctreat_core' ),
							'type'  => Controls_Manager::TEXT,
						],
						[
							'name'  => 'designation',
							'label' => esc_html__( 'Add designation', 'doctreat_core' ),
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
						],
						[
							'name' 			=> 'facebook',
							'type'      	=> Controls_Manager::TEXT,
							'label'     	=> esc_html__( 'Facebook link', 'doctreat_core' ),
							'description'   => esc_html__( 'Add facebook link. Leave it empty to hide.', 'doctreat_core' ),
						],
						[
							'name' 			=> 'twitter',
							'type'      	=> Controls_Manager::TEXT,
							'label'     	=> esc_html__( 'Twitter link', 'doctreat_core' ),
							'description'   => esc_html__( 'Add twitter link. Leave it empty to hide.', 'doctreat_core' ),
						],
						[
							'name' 			=> 'linkedin',
							'type'      	=> Controls_Manager::TEXT,
							'label'     	=> esc_html__( 'LinkedIn link', 'doctreat_core' ),
							'description'   => esc_html__( 'Add LinkedIn link. Leave it empty to hide.', 'doctreat_core' ),
						],
						[
							'name' 			=> 'instagram',
							'type'      	=> Controls_Manager::TEXT,
							'label'     	=> esc_html__( 'Instagram link', 'doctreat_core' ),
							'description'   => esc_html__( 'Add instagram link. Leave it empty to hide.', 'doctreat_core' ),
						],
						[
							'name' 			=> 'googleplus',
							'type'      	=> Controls_Manager::TEXT,
							'label'     	=> esc_html__( 'Googleplus link', 'doctreat_core' ),
							'description'   => esc_html__( 'Add googleplus link. Leave it empty to hide.', 'doctreat_core' ),
						],
						[
							'name' 			=> 'youtube',
							'type'      	=> Controls_Manager::TEXT,
							'label'     	=> esc_html__( 'Youtube link', 'doctreat_core' ),
							'description'   => esc_html__( 'Add youtube link. Leave it empty to hide.', 'doctreat_core' ),
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
			$settings 	= $this->get_settings_for_display();

			$title        = !empty($settings['title']) ? $settings['title'] : '';
			$sub_title    = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$description  = !empty($settings['description']) ? $settings['description'] : '';
			$team_members = !empty($settings['team_members']) ? $settings['team_members'] : array();
			
			$flag			= rand(9999, 999999);
			$social_links	= array();
			
			?>
			<div class=" dc-team dc-haslayout  dynamic-secton-<?php echo esc_attr( $flag );?>">
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
						
						<?php if( !empty( $team_members ) ) { ?>
							<div class="dc-ourteamholder">
							<?php
								foreach( $team_members as $member ) {
									$avatar 	  	= !empty( $member['avatar']['url'] ) ? $member['avatar']['url'] : get_template_directory_uri().'/images/avatar.jpg';
									$name         	= !empty( $member['name'] ) ? $member['name'] : '';
									$designation  	= !empty( $member['designation'] ) ? $member['designation'] : '';
									
									if( function_exists('doctreat_list_socila_media') ){
										$social_links	= doctreat_list_socila_media();
									}
									
									if( !empty( $avatar ) ||
										!empty( $name ) ||
										!empty( $designation )   ) { ?>
										<div class="col-12 col-sm-12 col-md-6 col-lg-4 float-left">
											<div class="dc-ourteam">
												<?php if( !empty( $avatar ) ) { ?>
													<figure class="dc-ourteamimg"><img width="" height="" src="<?php echo esc_attr( $avatar ); ?>" alt="<?php echo esc_attr( $name );?>"></figure>
												<?php } ?>
												<div class="dc-ourteamcontent">
													<?php if( !empty( $name ) || !empty( $designation ) ) { ?>
														<div class="dc-title">
															<?php if( !empty( $designation ) ) { ?><a href="#"><?php echo esc_html( $designation ); ?></a><?php } ?>
															<?php if( !empty( $name ) ) { ?><h3><a href="#"><?php echo esc_html( $name ); ?></a></h3><?php } ?>
														</div>
													<?php } ?>
													
													<?php if( !empty( $social_links ) ) {?>
													
														<ul class="dc-simplesocialicons dc-socialiconsborder">
															<?php 
																foreach ( $social_links as $key => $social_link ) { 
																	
																	if( !empty( $member[$key]) ) { ?>
																	<li class="<?php echo esc_attr( $social_link['class'] ); ?>"><a href="<?php echo esc_url( $member[$key] ); ?>"><i class="<?php echo esc_attr( $social_link['icon'] ); ?>"></i></a></li>
																<?php } ?>
																
															<?php } ?>   
														</ul>
													<?php } ?>   
												</div>
											</div>
										</div>
									<?php }?>
								<?php }?>
							</div>
						<?php }?>
					</div>
				</div>
			</div>
		<?php 
		}
	}
	Plugin::instance()->widgets_manager->register( new Doctreat_Teams ); 
}