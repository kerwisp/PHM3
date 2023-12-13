<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_Hospital_Team')) {

    class Doctreat_Hospital_Team {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_post_type'));
			add_action('add_meta_boxes', array(&$this, 'team_add_meta_box'), 10, 1);
			add_action('add_meta_boxes', array(&$this, 'doctor_info_add_meta_box'), 10, 2);	
			add_filter('manage_hospitals_team_posts_columns', array(&$this, 'team_columns_add'));
            add_action('manage_hospitals_team_posts_custom_column', array(&$this, 'team_columns'),10, 2);
            add_filter('manage_edit-hospitals_team_sortable_columns', array(&$this,'doctreat_hospital_team_sortable_columns'));
            add_action( 'pre_get_posts', array(&$this,'doctreat_hospital_team_orderby') );
        }
		
        /**
         * @Init Post Type
         * @return {post}
         */
        public function init_post_type() {
            $this->prepare_post_type();
        }
				
        /**
         * @Prepare Post Type Category
         * @return post type
         */
        public function prepare_post_type() {
			global $theme_settings;
            $labels = array(
                'name' 				=> esc_html__('Hospitals Team', 'doctreat_core'),
                'all_items' 		=> esc_html__('Hospitals Team', 'doctreat_core'),
                'singular_name' 	=> esc_html__('Hospital Team', 'doctreat_core'),
                'add_new' 			=> esc_html__('Add Hospital Team', 'doctreat_core'),
                'add_new_item' 		=> esc_html__('Add New Hospital Team', 'doctreat_core'),
                'edit' 				=> esc_html__('Edit', 'doctreat_core'),
                'edit_item' 		=> esc_html__('Edit Hospital Team', 'doctreat_core'),
                'new_item' 			=> esc_html__('New Hospital Team', 'doctreat_core'),
                'view' 				=> esc_html__('View Hospital Team', 'doctreat_core'),
                'view_item' 		=> esc_html__('View Hospital Team', 'doctreat_core'),
                'search_items' 		=> esc_html__('Search Hospital Team', 'doctreat_core'),
                'not_found' 		=> esc_html__('No Hospital Team found', 'doctreat_core'),
                'not_found_in_trash' => esc_html__('No Hospital Team found in trash', 'doctreat_core'),
                'parent' 			=> esc_html__('Parent Hospitals Team', 'doctreat_core'),
            );
			
            $args = array(
                'labels' 				=> $labels,
                'description' 			=> esc_html__('This is where you can add new Hospitals Team', 'doctreat_core'),
                'public' 				=> true,
                'supports' 				=> array('title','editor','thumbnail','author'),
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap' 			=> true,
                'publicly_queryable' 	=> false,
                'exclude_from_search' 	=> true,
                'hierarchical' 			=> false,
                'menu_position' 		=> 10,
				'menu_icon'   			=> 'dashicons-groups',
				'show_in_menu' 			=> 'edit.php?post_type=hospitals',
                'rewrite' 				=> array('slug' => 'hospital-team', 'with_front' => true),
                'query_var' 			=> false,
                'has_archive' 			=> false,
				'capabilities' 			=> array('create_posts' => false)
            );
			
			register_post_type('hospitals_team', $args);
        }
		
		/**
         * @Init Meta Boxes
         * @return {post}
         */
        public function team_add_meta_box($post_type) {
            if ($post_type == 'hospitals_team') {
                add_meta_box(
                        'team_info', esc_html__('Team Info', 'doctreat_core'), array(&$this, 'team_meta_box_teaminfo'), 'hospitals_team', 'side', 'high'
                );
            }
        }
		
		/**
         * @Init Review info
         * @return {post}
         */
        public function team_meta_box_teaminfo() {
            global $post;
			
			$hospital_id	= get_post_meta( $post->ID, 'hospital_id', true );
			$hospital_id	= !empty( $hospital_id ) ? intval( $hospital_id ) : '';
            $hospital_name	= function_exists('doctreat_full_name') ? doctreat_full_name($hospital_id) : get_the_title($hospital_id);
            
			$post_author		= get_post_field( 'post_author', $post->ID );
            $doctor_id		= function_exists('doctreat_get_linked_profile_id') && !empty( $post_author ) ? doctreat_get_linked_profile_id( $post_author ) : '';
			$doctor_name	= function_exists('doctreat_full_name') ? doctreat_full_name($doctor_id) : get_the_title($doctor_id);
			
            ?>
            <ul class="review-info team-info">
                <?php if (!empty( $hospital_id )) { ?>
                    <li>
                        <a href="<?php echo esc_url( get_the_permalink($hospital_id)); ?>" target="_blank" title="<?php esc_attr__('Click for user details', 'doctreat_core'); ?>">
                            <strong><?php esc_html_e('Hospital', 'doctreat_core'); ?>: </strong><?php echo esc_html($hospital_name); ?>
                        </a>
                    </li>
                <?php } ?>
                <?php if (!empty( $doctor_id )) { ?>
                    <li>
                        <a href="<?php echo esc_url( get_the_permalink( $doctor_id )); ?>" target="_blank" title="<?php esc_html__('Click for user details', 'doctreat_core'); ?>">
                            <strong><?php esc_html_e('Doctor', 'doctreat_core'); ?>: </strong><?php echo esc_html( $doctor_name ); ?>
                        </a>
                    </li>
                <?php } ?>
            </ul>
            <?php
        }
		
		/**
		 * @Prepare Columns
		 * @return {post}
		 */
		public function team_columns_add($columns) {
			
			$columns['doctor'] 		= esc_html__('Doctor','doctreat_core');
			$columns['hospital'] 	= esc_html__('Hospital','doctreat_core');
		 	$columns['date']		= esc_html__('Created / Modified Date','doctreat_core');
			$columns['title']		= esc_html__('Team ID#','doctreat_core');
  			return $columns;
		}
        
        /**
		 * @Get Quesry for shorting
		 * @return {}
		 */
        function doctreat_hospital_team_orderby( $query ) {
            if( ! is_admin() || ! $query->is_main_query() ) {
                return;
            }
			
            $orderby    = $query->get( 'orderby');
            $post_type  = $query->get('post_type');
			
            if ( 'hospital' === $orderby && !empty($post_type) && $post_type === 'hospitals_team') {
                $query->set( 'orderby', 'meta_value' );
                $query->set( 'meta_key', 'hospital_id' );
                $query->set( 'meta_type', 'numeric' );
              }
        }

        /**
		 * @Get Columns for shorting
		 * @return {}
		 */
        function doctreat_hospital_team_sortable_columns( $columns ) {
            $columns['doctor']      = 'doctor';
            $columns['hospital']    = 'hospital';
            return $columns;
        }
		/**
		 * @Get Columns
		 * @return {}
		 */
		public function team_columns($name) {
            global $post;
			
			$hospital_id	= get_post_meta( $post->ID,'hospital_id',true );
			$hospital_id	= !empty( $hospital_id ) ? intval( $hospital_id ) : '';
			$hospital_name	= function_exists('doctreat_full_name') ? doctreat_full_name($hospital_id) : get_the_title($hospital_id);
			
			$post_auter		= get_post_field( 'post_author',$post->ID );
			
            $doctor_id		= function_exists('doctreat_get_linked_profile_id') && !empty( $post_auter ) ? doctreat_get_linked_profile_id( $post_auter ) : '';
			$doctor_name	= function_exists('doctreat_full_name') ? doctreat_full_name($doctor_id) : get_the_title($doctor_id);
			
            $doctor   			= '<a href="'.get_edit_post_link($doctor_id).'">'.$doctor_name.'</a>';
			$hospital			= '<a href="'.get_edit_post_link($hospital_id).'">'.$hospital_name.'</a>';

            switch ($name) {
                case 'doctor':
                   if (!empty( $doctor) ) {
                        echo force_balance_tags( $doctor );
                    }
                    break;
                case 'hospital':
                    if (!empty( $hospital ) ) {
                        echo force_balance_tags( $hospital );
                    }
                    break;
            }
        }

        /**
		 * @Linked Chat metabox
		 * @return {post}
		 */
		public function doctor_info_add_meta_box($post_type, $post) {
			if ($post_type === 'hospitals_team' || $post_type === 'dc_locations') {
				add_meta_box(
					'doctreat_team_doctor_info',
					esc_html__('Location details', 'doctreat_core'),
					array(&$this, 'doctor_info_meta_box_print'),
					$post_type,
					'advanced',
					'high'
				);
			}
        }
        
        /**
		 * @Linked chat metabox
		 * @return {post}
		 */
		public function doctor_info_meta_box_print($post) {
            $user_identity 	    = get_post_meta( $post->ID, 'hospital_id', true );
            $id				    = $post->ID;

            $days			    = doctreat_get_week_array();
            $time_format 	    = get_option('time_format');

            $am_slots_data 		= get_post_meta( $id, 'am_slots_data', true);
            $am_slots_data		= !empty( $am_slots_data ) ? $am_slots_data : array();
            $am_consultant_fee	= get_post_meta( $id, '_consultant_fee', true);
            $am_consultant_fee	= !empty( $am_consultant_fee ) ? $am_consultant_fee : '';

            ?>
            <div class="dc-dashboardbox">
                <div class="dc-dashboardboxcontent dc-offerday-holder">
                    <?php do_action('doctreat_get_doctor_info_by_teamID', $id, $user_identity); ?>
                    <div class="dc-tabscontenttitle">
                        <h3><?php esc_html_e('Days I Offer My Services', 'doctreat_core');?></h3>
                    </div>
                    <?php if( !empty( $days ) ){?>
                        <div class="dc-childaccordion dc-offeraccordion" role="tablist" aria-multiselectable="true">
                        <?php 
                            foreach ($days as $key => $day) {
                                $day_slots	= !empty($am_slots_data[$key]) ? $am_slots_data[$key] : array();
                                $day_start	= !empty($day_slots['start_time']) ? $day_slots['start_time'] : '';
                                $day_end	= !empty($day_slots['end_time']) ? $day_slots['end_time'] : '';
                                $slots		= !empty($day_slots['slots']) ? $day_slots['slots'] : ''; ?>
                            <?php if (!empty($slots)) { ?>	
                            <div class="dc-subpanel">
                                <div class="dc-subpaneltitle dc-subpaneltitlevtwo">
                                    <?php if (!empty($day)) {?><span><?php echo esc_html($day);?></span><?php } ?>
                                </div>
                                <div class="dc-subpanelcontent">
                                    <div class="dc-dayspaces-holder dc-titlewithbtn">
                                        <div class="dc-spaces-holder">
                                            <ul class="dc-spaces-wrap dc-spaces-ul-<?php echo esc_html($key);?>">
                                                <?php
                                                    if (!empty($slots)) {
                                                        foreach ($slots as $slot_key => $slot_val) {
                                                            $slot_key_val = explode('-', $slot_key); ?>
                                                        <li>
                                                            <a href="javascript:;" class="dc-spaces">
                                                                <span><?php echo date($time_format, strtotime('2016-01-01' . $slot_key_val[0])); ?></span>
                                                                <span><?php esc_html_e('Spaces', 'doctreat_core'); ?>: <?php echo esc_html($slot_val['spaces']); ?></span>
                                                            </a>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="dc-dashboardboxcontent dc-appsetting dc-<?php echo esc_attr($key);?>">
                                    </div>
                                </div>
                            </div>
                        <?php } } ?>
                    </div>
                    <?php }?>
                </div>
            </div>
            <div class="dc-dashboardbox">
                <div class="dc-dashboardboxcontent dc-appsetting">
                   <div class="dc-tabscontenttitle">
						<h3><?php esc_html_e('Providing Services', 'doctreat_core');?></h3>
					</div>
                    <form class="dc-update-providingservices">
                        <div class="dc-tabscontenttitle">
                            <h3><?php esc_html_e('Consultation fee', 'doctreat_core');?></h3>
                        </div>
                        <div class="form-group">
                            <input type="text" disabled name="consultant_fee" class="form-control" value="<?php echo esc_attr($am_consultant_fee);?>" placeholder="<?php esc_attr_e('Consultation fee', 'doctreat_core');?>">
                        </div>
                        <div class="dc-tabscontenttitle">
                            <h3><?php esc_html_e('Specialties &amp; Services', 'doctreat_core');?></h3>
                        </div>
                        <?php if( !empty( $id ) ){ ?>
                            <div class="dc-providingservices">
                                <?php 
                                    $db_services = get_post_meta($id, '_team_services', true);
                                    $db_services	= !empty($db_services) ? $db_services : array();
                                    do_action('doctreat_get_group_services_with_speciality', $id, $db_services, 'echo', 'location');
                                ?>
                            </div>
                        <?php } ?>
                    </form>
                </div>
            </div>
            <?php
        }
    }

    new Doctreat_Hospital_Team();
}

