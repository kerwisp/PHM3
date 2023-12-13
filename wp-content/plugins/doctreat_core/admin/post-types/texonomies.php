<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_Taxnomies')) {

    class Doctreat_Taxnomies {
		
		/**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_locations_taxonomy'));
			add_action('init', array(&$this, 'init_specialities_taxonomy'));
			add_action('init', array(&$this, 'init_services_taxonomy'));
			add_action('init', array(&$this, 'init_sidebars_taxonomy'));
			
			add_action( 'services_add_form_fields', array(&$this, 'doctreat_services_meta'), 10, 2 );
			add_action( 'services_edit_form_fields', array(&$this, 'doctreat_services_meta_edit'), 10, 2 );
			
			add_action( 'edited_services', array(&$this, 'doctreat_services_meta_update'), 10, 2 );  
			add_action( 'create_services', array(&$this, 'doctreat_services_meta_save'), 10, 2 );
			add_filter( 'manage_edit-services_columns',  array(&$this,'add_services_columns') );
			add_filter( 'manage_services_custom_column', array(&$this,'add_services_column_content'), 10, 3 );
			add_action( 'specialities_add_form_fields', array(&$this, 'doctreat_specialities_meta'), 10, 2 );
			add_action( 'create_specialities', array(&$this, 'doctreat_specialities_meta_save'), 10, 2 );
			
			add_action( 'specialities_edit_form_fields', array(&$this, 'doctreat_specialities_meta_edit'), 10, 2 );
			add_action( 'edited_specialities', array(&$this, 'doctreat_specialities_meta_update'), 10, 2 );   
			
			add_action( 'locations_add_form_fields', array(&$this, 'doctreat_locations_meta'), 10, 2 );
			add_action( 'create_locations', array(&$this, 'doctreat_locations_meta_save'), 10, 2 );
			
			add_action( 'locations_edit_form_fields', array(&$this, 'doctreat_locations_meta_edit'), 10, 2 );
			add_action( 'edited_locations', array(&$this, 'doctreat_locations_meta_update'), 10, 2 );   
			
        }
				
		/**
         * @Init taxonomy 
         * @return {post}
         */
        public function init_locations_taxonomy() {
            //Regirster skills Taxonomy
			$location_labels = array(
				'name' 				=> esc_html__('Locations', 'doctreat_core'),
				'singular_name' 	=> esc_html__('Location','doctreat_core'),
				'search_items' 		=> esc_html__('Search Location', 'doctreat_core'),
				'all_items' 		=> esc_html__('All Location', 'doctreat_core'),
				'parent_item' 		=> esc_html__('Parent Location', 'doctreat_core'),
				'parent_item_colon' => esc_html__('Parent Location:', 'doctreat_core'),
				'edit_item' 		=> esc_html__('Edit Location', 'doctreat_core'),
				'update_item' 		=> esc_html__('Update Location', 'doctreat_core'),
				'add_new_item' 		=> esc_html__('Add New Location', 'doctreat_core'),
				'new_item_name' 	=> esc_html__('New Location Name', 'doctreat_core'),
				'menu_name' 		=> esc_html__('Locations', 'doctreat_core'),
			);

			$location_args = array(
				'hierarchical' 				=> true,
				'labels'					=> $location_labels,
				'show_admin_column' 		=> true,
				'query_var'					=> true,
				'show_ui'                   => true,
				'show_in_quick_edit'        => true,
				'rewrite' 					=> array('slug' => 'location'),
			);
			register_taxonomy('locations', array('hospitals','doctors','regular_users','prescription'), $location_args);
        }
		
		/**
         * @Init taxonomy 
         * @return {post}
         */
        public function init_specialities_taxonomy() {
            //Regirster skills Taxonomy
			$specialities_labels = array(
				'name' 				=> esc_html__('Specialities', 'doctreat_core'),
				'singular_name' 	=> esc_html__('Specialities','doctreat_core'),
				'search_items' 		=> esc_html__('Search Specialities', 'doctreat_core'),
				'all_items' 		=> esc_html__('All Specialities', 'doctreat_core'),
				'parent_item' 		=> esc_html__('Parent Specialities', 'doctreat_core'),
				'parent_item_colon' => esc_html__('Parent Specialities:', 'doctreat_core'),
				'edit_item' 		=> esc_html__('Edit Specialities', 'doctreat_core'),
				'update_item' 		=> esc_html__('Update Specialities', 'doctreat_core'),
				'add_new_item' 		=> esc_html__('Add New Specialities', 'doctreat_core'),
				'new_item_name' 	=> esc_html__('New Specialities Name', 'doctreat_core'),
				'menu_name' 		=> esc_html__('Specialities', 'doctreat_core'),
			);

			$specialities_args = array(
				'hierarchical' 				=> true,
				'labels'					=> $specialities_labels,
				'show_admin_column' 		=> true,
				'query_var'					=> true,
				'show_ui'                   => true,
				'show_in_quick_edit'        => true,
				'rewrite' 					=> array('slug' => 'specialities'),
			);
			register_taxonomy('specialities', array('doctors','healthforum','hospitals'), $specialities_args);
        }
		
		/* @Init sidebars 
         * @return {post}
         */
        public function init_sidebars_taxonomy() {
			$sidebars_labels = array(
				'name' 				=> esc_html__('Sidebars', 'doctreat_core'),
				'singular_name' 	=> esc_html__('Sidebars','doctreat_core'),
				'search_items' 		=> esc_html__('Search Sidebars', 'doctreat_core'),
				'all_items' 		=> esc_html__('All Sidebars', 'doctreat_core'),
				'parent_item' 		=> esc_html__('Parent Sidebars', 'doctreat_core'),
				'parent_item_colon' => esc_html__('Parent Sidebars:', 'doctreat_core'),
				'edit_item' 		=> esc_html__('Edit Sidebars', 'doctreat_core'),
				'update_item' 		=> esc_html__('Update Sidebars', 'doctreat_core'),
				'add_new_item' 		=> esc_html__('Add New Sidebars', 'doctreat_core'),
				'new_item_name' 	=> esc_html__('New Sidebars Name', 'doctreat_core'),
				'menu_name' 		=> esc_html__('Sidebars', 'doctreat_core'),
			);

			$sidebars_args = array(
				'hierarchical' 			=> false,
				'labels' 				=> $sidebars_labels,
				'public' 				=> false,
				'show_in_nav_menus' 	=> false,
				'show_ui' 				=> true,
				'query_var' 			=> false,
				'rewrite' 				=> false,
			);
			
			register_taxonomy('dc_sidebars', 'doctors', $sidebars_args);
			
			$sidebars = get_terms( array(
				'taxonomy' => 'dc_sidebars',
				'hide_empty' => false,
			) );

			foreach ( $sidebars as $sidebar ) {
				register_sidebar(
					array(
						'id'            => 'doc-' . sanitize_title( $sidebar->name ),
						'name'          => $sidebar->name,
						'description'   => $sidebar->description,
						'before_widget' => '<div class="dc-widget dc-categories sidebar-box %2$s clr">',
						'after_widget'  => '</div>',
						'before_title'  => '<div class="dc-widgettitle"><h3>',
						'after_title'   => '</h3></div>',
					)
				);

			}
        }
		
		/**
         * @Init taxonomy 
         * @return {post}
         */
        public function init_services_taxonomy() {
            //Regirster skills Taxonomy
			$services_labels = array(
				'name' 				=> esc_html__('Services', 'doctreat_core'),
				'singular_name' 	=> esc_html__('Services','doctreat_core'),
				'search_items' 		=> esc_html__('Search services', 'doctreat_core'),
				'all_items' 		=> esc_html__('All services', 'doctreat_core'),
				'parent_item' 		=> esc_html__('Parent Services', 'doctreat_core'),
				'parent_item_colon' => esc_html__('Parent Services:', 'doctreat_core'),
				'edit_item' 		=> esc_html__('Edit Services', 'doctreat_core'),
				'update_item' 		=> esc_html__('Update Services', 'doctreat_core'),
				'add_new_item' 		=> esc_html__('Add New Services', 'doctreat_core'),
				'new_item_name' 	=> esc_html__('New Services Name', 'doctreat_core'),
				'menu_name' 		=> esc_html__('Services', 'doctreat_core'),
			);

			$services_args = array(
				'hierarchical' 				=> true,
				'labels'					=> $services_labels,
				'show_admin_column' 		=> true,
				'query_var'					=> true,
				'show_ui'                   => true,
				'show_in_quick_edit'        => true,
				'rewrite' 					=> array('slug' => 'services'),
			);
			register_taxonomy('services', array('doctors','hospitals'), $services_args);

        }
		/**
		 * Add service meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function doctreat_services_meta() { ?>
			<div class="form-field">
				<label for="speciality"><?php esc_html_e( 'Select speciality', 'doctreat_core' ); ?></label>
				<?php doctreat_get_specialities_list('speciality');?>
			</div>
		<?php
		}

		/**
		 * Edit service meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_services_meta_edit($term) { 
			$specialities 			= get_term_meta( $term->term_id, 'speciality', true );
			$current_specialities	= !empty( $specialities ) ? $specialities : '';
			
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="specialities"><?php esc_html_e( 'Select a speciality', 'doctreat_core' ); ?></label></th>
				<td>
					<?php doctreat_get_specialities_list('speciality',$current_specialities);?>
				</td>
			</tr>
		<?php
		}

		/**
		 * Save service meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_services_meta_save( $term_id ) {
			if( !empty( $_POST['speciality'] ) && $_POST['speciality'] ) {
				add_term_meta( $term_id, 'speciality', $_POST['speciality'] );
			}
		}  
		
		/**
		 * update service meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_services_meta_update( $term_id ) {
			if( !empty( $_POST['speciality'] ) && $_POST['speciality'] ) {
				update_term_meta( $term_id, 'speciality', $_POST['speciality'] );
			}
		} 
		
		/**
         * @Init taxonomy 
         * @return {post}
         */
		public function add_services_column_content( $content, $column_name, $term_id ){
			global $servicess;

			if( $column_name !== 'speciality' ){
				return $content;
			}

			$term_id = absint( $term_id );
			$services = get_term_meta( $term_id, 'speciality', true );
			if( !empty( $services ) ){
				$content = doctreat_get_term_by_type('id',$services,'specialities','name');
			}

			return $content;
		}
		
		/**
         * @shorting colmn
         * @return {post}
         */
		public function add_services_column_sortable( $sortable ){
			$sortable[ 'speciality' ] = 'speciality';
			return $sortable;
		}

		public function add_services_columns( $columns ){
			$columns['speciality'] = esc_html( 'Speciality', 'doctreat_core' );
			return $columns;
		}
		
		/**
		 * Add specialities meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function doctreat_specialities_meta() { ?>
			<div class="form-field">
				<label for="speciality"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?></label>
				<div class="am_field">
					<div class="section-upload">
						<div class="z-option-uploader">
							<div class="input-sec">
								<input id="logo" name="logo" type="hidden" class="upload" value="" />
								<input id="attachment_id" name="attachment_id" type="hidden" class="attachment_id" value="" />
							</div>
							<div class="system-buttons">
								<span id="upload" class="button system_media_upload_button"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?><?php esc_html_e( 'Upload', 'doctreat_core' ); ?></span>
								<span id="reset_upload" class="button remove-item" title="<?php esc_html_e( 'Upload', 'doctreat_core' ); ?>"><?php esc_html_e( 'Remove', 'doctreat_core' ); ?></span>
								<div class="screenshot" style="display: none;">
									<a href="#"><img src="#" class="system-upload-image"></a>';
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="form-field">
				<label for="speciality"><?php esc_html_e( 'Color', 'doctreat_core' ); ?></label>
				<div class="am_field">
					<input type="text" name="color" class="color-picker" value="#bada55" />
				</div>
			</div>
		<?php
		}
		
		/**
		 * Save specialities meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_specialities_meta_save( $term_id ) {
			$post_data	= array();
			
			if( $_POST['logo'] ) {
				$post_data['url']			= $_POST['logo'];
				$post_data['attachment_id']	= $_POST['attachment_id'];
				add_term_meta( $term_id, 'logo', $post_data );
			}
			if( $_POST['color'] ) {
				add_term_meta( $term_id, 'color', $_POST['color'] );
			}
		} 
		
		/**
		 * Edit specialities meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_specialities_meta_edit($term) { 
			$logo 			= get_term_meta( $term->term_id, 'logo', true );
			$current_logo	= !empty( $logo['url'] ) ? $logo['url'] : '';
			$attachment_id	= !empty( $logo['attachment_id'] ) ? $logo['attachment_id'] : '';
			$color 			= get_term_meta( $term->term_id, 'color', true );
			
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="specialities"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?></label></th>
				<td>
					<div class="am_field">
						<div class="section-upload">
							<div class="z-option-uploader">
								<div class="input-sec">
									<input id="logo" name="logo" type="hidden" class="upload" value="<?php echo esc_url($current_logo);?>" />
									<input id="attachment_id" name="attachment_id" type="hidden" class="attachment_id" value="<?php echo intval($attachment_id);?>" />
								</div>
								<div class="system-buttons">
									<span id="upload" class="button system_media_upload_button"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?><?php esc_html_e( 'Upload', 'doctreat_core' ); ?></span>
									<span id="reset_upload" class="button remove-item" title="<?php esc_html_e( 'Upload', 'doctreat_core' ); ?>"><?php esc_html_e( 'Remove', 'doctreat_core' ); ?></span>
									<div class="screenshot" <?php if( empty($current_logo )) { ?> style="display: none;" <?php } ?> >
										<a href="<?php echo esc_url($current_logo);?>"><img src="<?php echo esc_url($current_logo);?>" class="system-upload-image"></a>';
									</div>

								</div>
							</div>
						</div>
				</div>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="specialities"><?php esc_html_e( 'Color', 'doctreat_core' ); ?></label></th>
				<td>
					<div class="am_field">
						<input type="text" name="color" class="color-picker" value="<?php echo esc_attr( $color );?>" />
					</div>
				</td>
			</tr>
		<?php
		}
		
		/**
		 * update specialities meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_specialities_meta_update( $term_id ) {
			$post_data	= array();
			
			if( $_POST['logo'] || $_POST['attachment_id'] ) {
				$post_data['url']			= $_POST['logo'];
				$post_data['attachment_id']	= $_POST['attachment_id'];
				
				update_term_meta( $term_id, 'logo', $post_data );
			}
			if( $_POST['color'] ) {
				update_term_meta( $term_id, 'color', $_POST['color'] );
			}
		}
		
		/**
		 * Add locations meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function doctreat_locations_meta() { ?>
			<div class="form-field">
				<label for="speciality"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?></label>
				<div class="am_field">
					<div class="section-upload">
						<div class="z-option-uploader">
							<div class="input-sec">
								<input id="logo" name="logo" type="hidden" class="upload" value="" />
								<input id="attachment_id" name="attachment_id" type="hidden" class="attachment_id" value="" />
							</div>
							<div class="system-buttons">
								<span id="upload" class="button system_media_upload_button"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?><?php esc_html_e( 'Upload', 'doctreat_core' ); ?></span>
								<span id="reset_upload" class="button remove-item" title="<?php esc_html_e( 'Upload', 'doctreat_core' ); ?>"><?php esc_html_e( 'Remove', 'doctreat_core' ); ?></span>
								<div class="screenshot" style="display: none;">
									<a href="#"><img src="#" class="system-upload-image"></a>';
								</div>

							</div>
						</div>
					</div>
				</div>
			</div>
		<?php
		}
		
		/**
		 * Save locations meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_locations_meta_save( $term_id ) {
			
			$post_data	= array();
			
			if( $_POST['logo'] ) {
				$post_data['url']			= $_POST['logo'];
				$post_data['attachment_id']	= $_POST['attachment_id'];
				add_term_meta( $term_id, 'logo', $post_data );
			}
		} 
		
		/**
		 * Edit locations meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_locations_meta_edit($term) { 
			$logo 			= get_term_meta( $term->term_id, 'logo', true );
			$current_logo	= !empty( $logo['url'] ) ? $logo['url'] : '';
			$attachment_id	= !empty( $logo['attachment_id'] ) ? $logo['attachment_id'] : '';
			
			?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="locations"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?></label></th>
				<td>
					<div class="am_field">
						<div class="section-upload">
							<div class="z-option-uploader">
								<div class="input-sec">
									<input id="logo" name="logo" type="hidden" class="upload" value="<?php echo esc_url($current_logo);?>" />
									<input id="attachment_id" name="attachment_id" type="hidden" class="attachment_id" value="<?php echo intval($attachment_id);?>" />
								</div>
								<div class="system-buttons">
									<span id="upload" class="button system_media_upload_button"><?php esc_html_e( 'Logo', 'doctreat_core' ); ?><?php esc_html_e( 'Upload', 'doctreat_core' ); ?></span>
									<span id="reset_upload" class="button remove-item" title="<?php esc_html_e( 'Upload', 'doctreat_core' ); ?>"><?php esc_html_e( 'Remove', 'doctreat_core' ); ?></span>
									<div class="screenshot" <?php if( empty($current_logo )) { ?> style="display: none;" <?php } ?> >
										<a href="<?php echo esc_url($current_logo);?>"><img src="<?php echo esc_url($current_logo);?>" class="system-upload-image"></a>';
									</div>

								</div>
							</div>
						</div>
				</div>
				</td>
			</tr>
		<?php
		}
		
		/**
		 * update locations meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public	function doctreat_locations_meta_update( $term_id ) {
			
			$post_data	= array();
			
			if( $_POST['logo'] || $_POST['attachment_id'] ) {
				
				$post_data['url']			= $_POST['logo'];
				$post_data['attachment_id']	= $_POST['attachment_id'];
				
				update_term_meta( $term_id, 'logo', $post_data );
			}
		}
	}
	new Doctreat_Taxnomies();
}