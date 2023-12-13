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

if( !class_exists('Doctreat_News_Article') ){
	class Doctreat_News_Article extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_news_articles';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'News/Blogs', 'doctreat_core' );
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
			$categories	= elementor_get_taxonomies();
			$categories	= !empty($categories) ? $categories : array();
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
				'blog_view',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Listing type','doctreat_core' ),
					'description'   => esc_html__('List/Grid settings are below.', 'doctreat_core' ),
					'default' 		=> 'list',
					'options' 		=> [
										'grid' 	=> esc_html__('Grid', 'doctreat_core'),
										'list' 	=> esc_html__('List', 'doctreat_core'),
										],
				]
			);
			$this->add_control(
				'get_method',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('News By','doctreat_core' ),
					'description'   => esc_html__('Select news by category or item.', 'doctreat_core' ),
					'default' 		=> 'by_cats',
					'options' 		=> [
										'by_posts' 	=> esc_html__('By item', 'doctreat_core'),
										'by_cats' 	=> esc_html__('By Categories', 'doctreat_core'),
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
				'categories_options',
				[
					'label' => esc_html__( 'Categories settings', 'doctreat_core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				'categories',
				[
					'type'      	=> Controls_Manager::SELECT2,
					'label'			=> esc_html__('Categories', 'doctreat_core'),
					'description' 			=> esc_html__('Select categories to display posts.', 'doctreat_core'),
					'options'   	=> $categories,
					'default' 		=> '',
					'multiple' 		=> true,
					'label_block' 	=> true,
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
			
			$this->add_control(
				'posts_options',
				[
					'label' => esc_html__( 'Posts/Items settings', 'doctreat_core' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			
			$this->add_control(
				'posts',
				[
					'type'      	=> Controls_Manager::TEXTAREA,
					'label'     	=> esc_html__('Add posts ID\'s','doctreat_core' ),
					'description'   => esc_html__('Add posts ID\'s with comma seprated e.g (10,19) if News by selection is By item.', 'doctreat_core' ),
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'list_section',
				[
					'label' => esc_html__( 'List settings', 'doctreat_core' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'list',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Listing type','doctreat_core' ),
					'default' 		=> 'full',
					'options' 		=> [
										'full' 	=> esc_html__('Full', 'doctreat_core'),
										'small' => esc_html__('Small', 'doctreat_core'),
										],
				]
			);
			$this->end_controls_section();
			$this->start_controls_section(
				'grid_section',
				[
					'label' => esc_html__( 'Grid settings', 'doctreat_core' ),
					'tab' => Controls_Manager::TAB_CONTENT,
				]
			);
			
			$this->add_control(
				'columns',
				[
					'type'      	=> Controls_Manager::SELECT,
					'label'     	=> esc_html__('Description','doctreat_core' ),
					'default' 		=> '2_cols',
					'options' 		=> [
										6 	=> esc_html__('Classic View Two Columns', 'doctreat_core'),
										4 	=> esc_html__('Three Columns', 'doctreat_core'),
										3 	=> esc_html__('Four Columns', 'doctreat_core')
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
			$settings = $this->get_settings_for_display();
			global $paged;
			
			$blog_view	= !empty($settings['blog_view']) ? $settings['blog_view'] : '';	
			$pg_page  = get_query_var('page') ? get_query_var('page') : 1; //rewrite the global var
			$pg_paged = get_query_var('paged') ? get_query_var('paged') : 1; //rewrite the global var
			//paged works on single pages, page - works on homepage
			$paged    = max($pg_page, $pg_paged);
			$title    = !empty($settings['title']) ? $settings['title'] : '';
			$desc     = !empty($settings['description']) ? $settings['description'] : '';
			
			$size     =  !empty( $settings['list'] )? $settings['list'] : 'full';
			$columns     =  !empty( $settings['columns'] )? $settings['columns'] : '4';

			if (isset($settings['get_method']) && $settings['get_method'] === 'by_posts' && !empty($settings['posts'])) {
				$posts_in['post__in'] 	= !empty($settings['posts']) ? explode(',',$settings['posts']) : array();
				$order      			= 'DESC';
				$orderby    			= 'ID';
				$show_posts 			= -1;
			} else {
				$cat_sepration = array();
				$cat_sepration = $settings['categories'];
				$order         = !empty($settings['order']) ? $settings['order'] : 'DESC';
				$orderby       = !empty($settings['orderby']) ? $settings['orderby'] : 'ID';
				$show_posts    = !empty($settings['show_posts']['size']) ? $settings['show_posts']['size'] : -1;
				
				if (!empty($cat_sepration)) {
					$slugs = array();
					
					foreach ($cat_sepration as $value) {
						$term    = get_term($value, 'category');
						$slugs[] = $term->slug;
					}
					
					$filterable = $slugs;
					$tax_query['tax_query'] = array(
						'relation' => 'AND',
						array(
							'taxonomy' => 'category',
							'terms'    => $filterable,
							'field'    => 'slug',
					));
				}
			}
			//Main Query 
			$query_args = array(
				'posts_per_page' 		=> $show_posts,
				'post_type' 			=> 'post',
				'paged' 				=> $paged,
				'order' 				=> $order,
				'orderby' 				=> $orderby,
				'paged' 				=> $paged,
				'post_status' 			=> 'publish',
				'ignore_sticky_posts' 	=> 1
			);

			//By Categories
			if (!empty($cat_sepration)) {
				$query_args = array_merge($query_args, $tax_query);
			}
			//By Posts 
			if (!empty($posts_in)) {
				$query_args = array_merge($query_args, $posts_in);
			}
			
			$query      = new \WP_Query($query_args);
			$count_post = $query->found_posts;
			
			if( !empty( $blog_view ) && $blog_view === 'list' ) { ?>
				<div class="dc-twocolumns dc-borderlt-0 dc-haslayout">
					<div class="col-md-8 col-xl-9 float-right">
						<div class="row dc-articles-mt">
							<?php if(!empty( $title ) ) {?>
								<div class="col-sm-12 float-left">
									<div class="dc-searchresult-head">
										<div class="dc-title"><h3><?php echo esc_html($title);?></h3></div>
									</div>
								</div>
							<?php } ?>
							
							<?php 
								if ($query->have_posts()) { 
									while ($query->have_posts()) { 
										$query->the_post();
										global $post;
										$height = intval(220);
										$width  = intval(308);

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
										<div class="col-sm-12 float-right">
											<div class="dc-article d-flex">
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
													<div class="dc-title dc-ellipsis dc-titlep">
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
								<?php } wp_reset_postdata(); ?>
								<?php if (isset($settings['show_pagination']) && $settings['show_pagination'] == 'yes' && $count_post > $show_posts ) : ?>
										<div class="col-sm-12 float-right"><?php doctreat_prepare_pagination($count_post, $show_posts); ?></div>
								   <?php endif; ?>
							<?php } ?>
							
						</div>
					</div>
				</div>
			<?php } else if( !empty( $blog_view ) && $blog_view === 'grid' ) {	?>
					<?php if(!empty( $title ) ) {?>
						<div class="dc-searchresult-head pt-sm-0">
							<div class="dc-title"><h3><?php echo esc_html( $title );?></h3></div>
						</div>
					<?php } ?>
					<?php if ($query->have_posts()) { ?>
						<div class="dc-articlesholder">
							<div class="row dc-articlesrow">
								<?php
								while ($query->have_posts()) { 
									$query->the_post();
									global $post;
									if( !empty( $columns ) && ( $columns == 6 || $columns == 4 ) ){
										$height = intval(389);
										$width  = intval(545);
									} else{
										$height = intval(250);
										$width  = intval(255);
									}
			
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
									<div class="col-12 col-sm-12 col-md-6 col-xl-4 col-xl-<?php echo esc_attr( $columns );?>">
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
												<div class="dc-title dc-ellipsis dc-titlep">
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
									<?php 
									} wp_reset_postdata(); 
										if (isset($settings['show_pagination']) && $settings['show_pagination'] == 'yes' && $count_post > $show_posts ) : 	?>	<div class="col-12"><?php doctreat_prepare_pagination( $count_post, $show_posts ); ?></div>
								<?php endif; ?>
							</div>
						</div>
					<?php } ?>
			<?php } ?>
		<?php 
		}

	}

	Plugin::instance()->widgets_manager->register( new Doctreat_News_Article ); 
}