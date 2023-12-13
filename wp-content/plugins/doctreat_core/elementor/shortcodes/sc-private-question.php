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

if( !class_exists('Doctreat_Private_Question') ){
	class Doctreat_Private_Question extends Widget_Base {

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      base
		 */
		public function get_name() {
			return 'dc_element_private_question';
		}

		/**
		 *
		 * @since    1.0.0
		 * @access   static
		 * @var      title
		 */
		public function get_title() {
			return esc_html__( 'Private Question', 'doctreat_core' );
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
				'enable_question',
				[
					'type'      	=> \Elementor\Controls_Manager::SWITCHER,
					'label'     	=> esc_html__( 'Question section Enable/Disbale', 'doctreat_core' ),
					'label_on' 		=> esc_html__( 'Show', 'doctreat_core' ),
					'label_off' 	=> esc_html__( 'Hide', 'doctreat_core' ),
					'return_value' 	=> 'yes',
					'default' 		=> 'yes',
				]
			);

			$this->add_control(
				'question_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Question section title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add question section title. leave it empty to hide.', 'doctreat_core'),
				]
			);
			$this->add_control(
				'question_subtitle',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Question section sub title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add question section sub title. leave it empty to hide.', 'doctreat_core'),
				]
			);

			$this->add_control(
				'question_detail',
				[
					'type'      	=> Controls_Manager::TEXTAREA,
					'label' 		=> esc_html__('Question section detail', 'doctreat_core'),
        			'description' 	=> esc_html__('Add question section detail. leave it empty to hide.', 'doctreat_core'),
				]
			);
			
			$this->add_control(
				'feedback_title',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Feedback title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add feedback title. leave it empty to hide.', 'doctreat_core'),
				]
			);

			$this->add_control(
				'feedback_subtitle',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Feedback sub title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add feedback sub title. leave it empty to hide.', 'doctreat_core'),
				]
			);

			$this->add_control(
				'feedback_btntext',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Feedback button title', 'doctreat_core'),
        			'description' 	=> esc_html__('Add feedback button title. leave it empty to hide.', 'doctreat_core'),
				]
			);

			$this->add_control(
				'feedback_btnurl',
				[
					'type'      	=> Controls_Manager::TEXT,
					'label' 		=> esc_html__('Feedback button url', 'doctreat_core'),
        			'description' 	=> esc_html__('Add feedback button url. leave it empty to hide.', 'doctreat_core'),
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
			$settings 			= $this->get_settings_for_display();
			$enable_question    = !empty($settings['enable_question']) ? $settings['enable_question'] : '';
			$question_title    	= !empty($settings['question_title']) ? $settings['question_title'] : '';
			$question_subtitle  = !empty($settings['question_subtitle']) ? $settings['question_subtitle'] : '';
			$question_detail    = !empty($settings['question_detail']) ? $settings['question_detail'] : '';
			$feedback_title    	= !empty($settings['feedback_title']) ? $settings['feedback_title'] : '';
			$feedback_subtitle  = !empty($settings['feedback_subtitle']) ? $settings['feedback_subtitle'] : '';
			$feedback_btntext   = !empty($settings['feedback_btntext']) ? $settings['feedback_btntext'] : '';
			$feedback_btnurl    = !empty($settings['feedback_btnurl']) ? $settings['feedback_btnurl'] : '';
			
			//Main Query 
			$query_args = array(
				'numberposts' 	=> 3,
				'post_type' 	=> 'healthforum',
				'post_status' 	=> 'publish'
			);
			
			$posts      = get_posts($query_args);
			$class		= 'dc-login-question';
			if( is_user_logged_in() ){
				$class		= 'dc-question-model';
			}
			
			//dc-question-model
			?>
			<div class="dc-haslayout dc-private_question">
				<div class="row">
					<?php if(!empty($enable_question) && $enable_question === 'yes'){?>
						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
							<div class="dc-prohelpholder">
								<div class="dc-sectionhead dc-sectionheadvtwo">
									<?php if(!empty($question_title) || !empty($question_subtitle) ){?>
										<div class="dc-sectiontitle">
											<h2><?php echo esc_html($question_title);?> <span><?php echo esc_html($question_subtitle);?></span></h2>
										</div>
									<?php } ?>
									<?php if(!empty($question_detail)){?>
										<div class="dc-description"><p><?php echo esc_html($question_detail);?></p></div>
									<?php } ?>
								</div>
								<form class="dc-formtheme dc-formhelp">
									<fieldset>
										<div class="form-group">
											<input type="text" name="search" value="" class="form-control dc-question-title" placeholder="<?php esc_attr_e('Add title here','doctreat_core');?>" required="">
										</div>
										<div class="form-group">
											<textarea class="form-control dc-question-detail" placeholder="<?php esc_attr_e('Type your question','doctreat_core');?>"></textarea>
										</div>
										<div class="form-group dc-btnarea">
											<a href="javascript:;" class="dc-btn <?php echo esc_attr($class);?>"><?php esc_html_e('Ask Free Query','doctreat_core');?></a>
										</div>
									</fieldset>
								</form>
							</div>
						</div>
						<?php include( get_template_directory() . '/directory/post-question.php' ); ?>
					<?php } ?>
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
						<div class="dc-feedbackholder">
						<?php if(!empty($feedback_title) || !empty($feedback_subtitle) ){?>
							<div class="dc-sectionhead">
								<div class="dc-sectiontitle">
									<h2><span><?php echo esc_html($feedback_title);?></span><?php echo esc_html($feedback_subtitle);?></h2>
								</div>
							</div>
						<?php } ?>
						<?php if ($posts) {
								foreach ($posts as $post) { 
									$db_specialities	= apply_filters('doctreat_get_tax_query',array(),$post->ID,'specialities','');
									$sp_url				= !empty($db_specialities[0]->term_id) ? get_term_link($db_specialities[0]->term_id) : '';
									$sp_title			= !empty($db_specialities[0]->name) ? $db_specialities[0]->name : '';
									$speciality_img		= !empty( $db_specialities[0] ) ? get_term_meta( $db_specialities[0]->term_id, 'logo', true ) : '';
									if( !empty( $speciality_img['attachment_id'] ) ){
										$thumbnail	= wp_get_attachment_image_src( $speciality_img['attachment_id'],'doctreat_latest_articles_widget', true );

										$thumbnail	= !empty( $thumbnail[0] ) ? $thumbnail[0] : '';
									}

									$title		= get_the_title( $post->ID );
									$title		= !empty( $title ) ? $title : '';
									$contents	= !empty( $post->post_content ) ? substr($post->post_content,112) : '';
									$link		= get_the_permalink($post->ID);
									$link		= !empty( $link ) ? $link : '';

									$post_date	= get_post_field('post_date',$post->ID);
									$answered	= get_comments_number($post->ID);
									$answered	= !empty( $answered ) ? $answered : 0;
								?>
								<div class="dc-feedbackcontent-holder">
									<?php if( !empty( $thumbnail ) ){?>
										<figure class="dc-feedbackimg dc-color1">
											<img width="" height="" src="<?php echo esc_url( $thumbnail );?>" alt="<?php echo esc_attr($title);?>">
										</figure>
									<?php } ?>
									<div class="dc-feedbackcontent">
										<div class="dc-title">
									<?php if( !empty( $title ) ){ ?><h3><a href="<?php echo esc_url( $link );?>"><?php echo esc_html( $title );?></a></h3><?php } ?>
											<a href="<?php echo esc_url($sp_url);?>"><?php echo esc_html($sp_title);?></a>
											<span><i class="ti-comments"></i> <?php echo intval( $answered );?>&nbsp;<?php esc_html_e('Answered','doctreat_core');?></span>
										</div>
									<?php if(!empty($contents)){?>
										<div class="dc-description"><p><?php echo esc_html( $contents );?></p></div>
									<?php } ?>
									</div>
								</div>
							<?php }  ?>

							<?php if(!empty($feedback_btntext)){?>
								<div class="dc-btnarea">
									<hr>
									<a href="<?php echo esc_url($feedback_btnurl);?>" class="dc-btn"><?php echo esc_html($feedback_btntext);?></a>
								</div>
							<?php } ?>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<script>
				jQuery(document).on('ready', function() {
					jQuery('.dc-question-model').on('click', function(){
						var title 	= jQuery('.dc-question-title').val();
						var detail 	= jQuery('.dc-question-detail').val();
						jQuery('#freequery input[name="title"]').val(title);
						jQuery('#freequery textarea[name="description"]').val(detail);
						jQuery("#freequery").modal('show'); 
					});
					jQuery('.dc-login-question').on('click', function(){
						jQuery('#dc-loginbtn').click();
						jQuery("html, body").animate({ scrollTop: 0 }, "slow");
					});
				});
			</script>
		<?php 
		}
	}

	Plugin::instance()->widgets_manager->register( new Doctreat_Private_Question ); 
}