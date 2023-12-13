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

if( !class_exists('Doctreat_Health_Forum') ){
	class Doctreat_Health_Forum extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_health_forum';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Health Forum', 'doctreat_core' );
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
				'search_form',
				[
					'label' 		=> esc_html__( 'Enable Search Form', 'doctreat_core' ),
					'type' 			=> \Elementor\Controls_Manager::SWITCHER,
					'label_on' 		=> esc_html__( 'Enable', 'doctreat_core' ),
					'label_off' 	=> esc_html__( 'Disable', 'doctreat_core' ),
					'description'   => esc_html__( 'Enable/Disable the search form.', 'doctreat_core' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'yes',
					
				]
			);
			
			$this->add_control(
				'search_page_action',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label'     	=> esc_html__( 'Search Page Action url', 'doctreat_core' ),
					'description'   => esc_html__( 'if search is Enable then add action url.', 'doctreat_core' ),
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
				'order',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Order','doctreat_core' ),
					'description'   => esc_html__('Select posts Order.', 'doctreat_core' ),
					'default' 		=> 'DESC',
					'options' 		=> [
										'ASC' 	=> esc_html__('ASC', 'doctreat_core'),
										'DESC' 	=> esc_html__('DESC', 'doctreat_core'),
										],
				]
			);
			
			$this->add_control(
				'orderby',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Post Order','doctreat_core' ),
					'description'   => esc_html__('View Posts By.', 'doctreat_core' ),
					'default' 		=> 'ID',
					'options' 		=> [
										'ID' 		=> esc_html__('Order by post id', 'doctreat_core'),
										'author' 	=> esc_html__('Order by author', 'doctreat_core'),
										'title' 	=> esc_html__('Order by title', 'doctreat_core'),
										'name' 		=> esc_html__('Order by post name', 'doctreat_core'),
										'date' 		=> esc_html__('Order by date', 'doctreat_core'),
										'rand' 		=> esc_html__('Random order', 'doctreat_core'),
										'comment_count' => esc_html__('Order by number of comments', 'doctreat_core'),
										],
				]
			);
			
			$this->add_control(
				'show_pagination',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Pagination option','doctreat_core' ),
					'description'   => esc_html__('Select pagination option.', 'doctreat_core' ),
					'default' 		=> 'no',
					'options' 		=> [
										'yes' 	=> esc_html__('Yes', 'doctreat_core'),
										'no' 	=> esc_html__('No', 'doctreat_core'),
										],
				]
			);
			
			$this->add_control(
				'show_posts',
				[
					'label' => __( 'Number of posts', 'doctreat_core' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'posts' ],
					'range' => [
						'posts' => [
							'min' => 1,
							'max' => 100,
							'step' => 1,
						]
					],
					'default' => [
						'unit' => 'posts',
						'size' => 9,
					]
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
			global $paged;
			
			$settings = $this->get_settings_for_display();
						
			$title    				= !empty($settings['title']) ? $settings['title'] : '';
			$search_form    		= !empty($settings['search_form']) ? $settings['search_form'] : '';
			$search_page_action    	= !empty($settings['search_page_action']) ? $settings['search_page_action'] : '';
						
			$pg_page  = get_query_var('page') ? get_query_var('page') : 1; 
			$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1;
			$paged    = max($pg_page, $pg_paged);
			
			$order         = !empty($settings['order']) ? $settings['order'] : 'DESC';
			$orderby       = !empty($settings['orderby']) ? $settings['orderby'] : 'ID';
			$show_posts    = !empty($settings['show_posts']['size']) ? $settings['show_posts']['size'] : -1;
			
			//Main Query 
			$query_args = array(
							'posts_per_page' 		=> $show_posts,
							'post_type' 			=> 'healthforum',
							'paged' 				=> $paged,
							'order' 				=> $order,
							'orderby' 				=> $orderby,
							'post_status' 			=> 'publish',
							'ignore_sticky_posts' 	=> 1
						);
				
			$query      = new WP_Query($query_args);
			$count_post = $query->found_posts;
			
			$height = intval(40);
			$width  = intval(40);
			
			$date_formate	= get_option('date_format');
			?>
			<?php if( !empty( $search_form ) && $search_form === 'yes' ){?>
				<div class="dc-innerbanner">
					<form class="dc-formtheme dc-forumform" action="<?php esc_url($search_page_action);?>">
						<fieldset>
							<div class="form-group">
								<input type="text" name="search" class="form-control" placeholder="<?php esc_html_e('Type Your Query','doctreat_core');?>">
							</div>
							<?php if( class_exists('Doctreat_Walker_Location_Dropdown')) { ?>
								<div class="form-group">
									<div class="dc-select">
										<select class="chosen-select locations" data-placeholder="<?php esc_html_e('specialities','doctreat_core');?>" name="specialities">
											<option value=""><?php esc_html_e('Select a speciality','doctreat_core');?></option>
												<?php
													wp_list_categories( array(
															'taxonomy' 			=> 'specialities',
															'hide_empty' 		=> false,
															'style' 			=> '',
															'walker' 			=> new \Doctreat_Walker_Location_Dropdown,
														)
													);
												?>
										</select>
									</div>
								</div>
							<?php } ?>
							<div class="dc-btnarea">
								<a href="javascript:;" class="dc-btn"><?php esc_html_e('Search','doctreat_core');?></a>
							</div>
						</fieldset>
					</form>
				</div>
			<?php } ?>
			<div class="dc-docsingle-holder">
				<div class="tab-content dc-haslayout">
					<div class="dc-contentdoctab dc-feedback-holder" id="feedback">
						<div class="dc-feedback">
							<div class="dc-searchresult-head">
								<?php if( !empty( $title ) ) {?><div class="dc-title"><h4><?php echo esc_html( $title );?></h4></div><?php } ?>
								<div class="dc-rightarea">
									<div class="dc-select">
										<select>
											<option value=""><?php esc_html_e('Sort By:','doctreat_core');?></option>
											<option value="Sort By:">Last created on top</option>
											<option value="Sort By:">Last modified on top</option>
											<option value="Sort By:">Alphabetically (A-Z)</option>
											<option value="Sort By:">Alphabetically (Z-A)</option>
										</select>
									</div>
								</div>
							</div>
							<div class="dc-consultation-content">
								<?php 
								if ($query->have_posts()) { 
									while ($query->have_posts()) { 
										$query->the_post();
										global $post;
										
										if( function_exists('doctreat_prepare_thumbnail') ){
											$thumbnail  = doctreat_prepare_thumbnail($post->ID, $width, $height);
										}

										$thumbnail	= !empty( $thumbnail ) ? $thumbnail : '';
										$title		= get_the_title( $post->ID );
										$title		= !empty( $title ) ? $title : '';
										$contents	= get_the_content($post->ID);
										$link		= get_the_permalink($post->ID);
										$link		= !empty( $link ) ? $link : '';
										
										$post_date	= get_post_field('post_date',$post->ID);
										$answered	= get_comments_number($post->ID);
										$answered	= !empty( $answered ) ? $answered : 0;
										?>
										<div class="dc-consultation-details">
											<?php if( !empty( $thumbnail ) ){?>
												<figure class="dc-consultation-img dc-imgcolor1">
													<img width="" height="" src="<?php echo esc_url( $thumbnail );?>" alt="<?php echo esc_attr($title);?>">
												</figure>
											<?php } ?>
											<?php if( !empty( $title ) || !empty( $post_date ) ) {?>
												<div class="dc-consultation-title">
													<h5>
														<?php if( !empty( $title ) ) {?>
															<a href="<?php echo esc_url( $link );?>"><?php echo esc_html( $title );?></a>
														<?php } ?>
														<?php if( !empty( $post_date ) ){?>
															<em><?php echo date_i18n($date_formate,strtotime($post_date));?></em>
														<?php } ?>
													</h5>
													<span><?php echo intval( $answered );?>&nbsp;<?php esc_html_e('Answered','doctreat_core');?></span>
												</div>
											<?php } ?>
											<?php if( !empty( $contents ) ){?>
												<div class="dc-description"><?php echo esc_html( $contents );?></div>
											<?php } ?>
										</div>
									<?php } wp_reset_postdata(); ?>
									<?php if (isset($settings['show_pagination']) && $settings['show_pagination'] == 'yes' && $count_post > $show_posts ) : ?>
										<?php doctreat_prepare_pagination($count_post, $show_posts); ?>
								   <?php endif; ?>
								<?php } ?>								
							</div>
						</div>
					</div>
				</div>
			</div>
			
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Health_Forum ); 
}