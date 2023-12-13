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

if( !class_exists('Doctreat_Latest_Articles') ){
	class Doctreat_Latest_Articles extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_latest_articles';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Latest Articles', 'doctreat_core' );
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      icon
		 */
		public function get_icon() {
			return 'eicon-eye';
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
					'label' 		=> esc_html__('Title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add newsletter title. leave it empty to hide.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'sub_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Sub title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add sub title. leave it empty to hide.', 'doctreat_core'),
				]
			);

			$this->add_control(
				'description',
				[
					'type'      	=> Controls_Manager::WYSIWYG,
					'label' 		=> esc_html__('Description', 'doctreat_core'),
        			'description' 	=> esc_html__('Add newsletter description. leave it empty to hide.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'posts',
				[
					'type'      	=> Controls_Manager::TEXTAREA,
					'label' 		=> esc_html__('Posts ID\'s', 'doctreat_core'),
        			'description' 	=> esc_html__('Add Posts ID\'s with comma(,) separated e.g(15,21). Leave it empty to show latest posts.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'noofposts',
				[
					'type'      	=> Controls_Manager::NUMBER,
					'min' 			=> 1,
					'max' 			=> 100,
					'step' 			=> 1,
					'default' 		=> 10,
					'label' 		=> esc_html__('Number of latests posts', 'doctreat_core'),
        			'description' 	=> esc_html__('Add Number of latests posts. It\'s only working if  Posts ID\'s field is null.', 'doctreat_core'),
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

			$title       = !empty($settings['title']) ? $settings['title'] : '';
			$sub_title   = !empty($settings['sub_title']) ? $settings['sub_title'] : '';
			$desc  	     = !empty($settings['description']) ? $settings['description'] : '';
			$posts_ids   = !empty($settings['posts']) ? explode( ',' ,$settings['posts'] ): array();
			
			$args 		= array();
			
			if( !empty( $posts_ids ) ){
				$args['post__in'] = $posts_ids;
			} else {
				$noofposts   = !empty($settings['noofposts']) ? $settings['noofposts'] : get_option( 'posts_per_page' );
				$args['numberposts']	= $noofposts;
			}
			
			$args['order']		= 'DESC';
			$args['orderby']	= 'ID';
			$posts 	= get_posts($args);
			$height = intval(389);
			$width  = intval(545);
			$cat_link	= '';
			?>
			<div class="dc-sc-latest-articals dc-haslayout">
				<div class="container">
					<div class="row justify-content-center align-self-center">
						<?php if( !empty( $title ) || !empty( $sub_title ) || !empty( $desc ) ) {?>
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 push-lg-2">
								<div class="dc-sectionhead dc-text-center">
									<?php if( !empty( $title ) || !empty( $sub_title ) ) {?>
										<div class="dc-sectiontitle">
											<h2>
												<?php if( !empty( $title ) ) {?><span><?php echo esc_html( $title );?></span><?php } ?>
												<?php echo wp_kses($sub_title,array('em' => array()));?>
											</h2>
										</div>
									<?php } ?>
									<?php if( !empty( $desc ) ) {?>
										<div class="dc-description"><?php echo do_shortcode( $desc );?></div>
									<?php } ?>
								</div>
							</div>
						<?php } ?>
						<?php if( !empty( $posts ) ) {?>
							<div class="dc-articlesholder">
								<?php 
									foreach( $posts as $post ){
										if( function_exists('doctreat_prepare_thumbnail') ){
											$thumbnail  = doctreat_prepare_thumbnail($post->ID, $width, $height);
										}
										
										$thumbnail	= !empty( $thumbnail ) ? $thumbnail : '';
										
										$title		= get_the_title( $post->ID );
										$title		= !empty( $title ) ? $title : '';
										$link		= get_the_permalink($post->ID);
										$link		= !empty( $link ) ? $link : '';
										
										$post_auther	= get_post_field('post_author', $post->ID );
										$post_auther	= !empty( $post_auther ) ? intval($post_auther) : '';
										
										if( function_exists('doctreat_get_linked_profile_id') ){
											$profile_id	= doctreat_get_linked_profile_id($post_auther,'users' );
										}
										
										$profile_id		= !empty( $profile_id ) ? $profile_id : '';
										$categries		=  get_the_term_list( $post->ID, 'category', '', ',', '' );
									?>
									<div class="col-12 col-sm-12 col-md-6 col-lg-4 float-left">
										<div class="dc-article">
											<figure class="dc-articleimg">
												<?php if( !empty( $thumbnail ) ) {?>
													<img width="" height="" src="<?php echo esc_url( $thumbnail );?>" alt="<?php echo esc_attr( $title );?>">
												<?php } ?>
												<?php 
													if( function_exists('doctreat_get_article_author' ) ) {
														if( !empty( $profile_id ) ){
															do_action('doctreat_get_article_author',$profile_id);
														}
													}
												?>
											</figure>
											<div class="dc-articlecontent">
												<div class="dc-title">
													<?php echo do_shortcode($categries);?>
													<h3><a href="<?php echo esc_url( $link );?>"><?php echo esc_html( $title );?></a></h3>
													<?php 
														if( function_exists('doctreat_post_date') ){
															do_action('doctreat_post_date',$post->ID);
														}
													?>
												</div>
												<?php
													if( function_exists('doctreat_get_article_sharing') ){
														do_action('doctreat_get_article_sharing',$post->ID);
													}
												?>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Latest_Articles ); 
}