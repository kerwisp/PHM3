<?php

/**
 * @package   Doctreat Core
 * @author    Amentotech
 * @link      http://amentotech.com/
 * @version 1.0
 * @since 1.0
 */
if (!class_exists('Doctreat_Prescription')) {

    class Doctreat_Prescription {

        /**
         * @access  public
         * @Init Hooks in Constructor
         */
        public function __construct() {
            add_action('init', array(&$this, 'init_post_type'));
            add_action( 'diseases_add_form_fields', array(&$this, 'doctreat_diseases_meta'), 10, 2 );
			add_action( 'diseases_edit_form_fields', array(&$this, 'doctreat_diseases_meta_edit'), 10, 2 );
			
			add_action( 'edited_diseases', array(&$this, 'doctreat_diseases_meta_update'), 10, 2 );  
			add_action( 'create_diseases', array(&$this, 'doctreat_diseases_meta_save'), 10, 2 );
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
            $labels = array(
                'name' 				=> esc_html__('Prescription', 'doctreat_core'),
                'all_items' 		=> esc_html__('Prescription', 'doctreat_core'),
                'singular_name' 	=> esc_html__('Prescription', 'doctreat_core'),
                'add_new' 			=> esc_html__('Add Prescription', 'doctreat_core'),
                'add_new_item' 		=> esc_html__('Add New Prescription', 'doctreat_core'),
                'edit' 				=> esc_html__('Edit', 'doctreat_core'),
                'edit_item' 		=> esc_html__('Edit Prescription', 'doctreat_core'),
                'new_item' 			=> esc_html__('New Prescription', 'doctreat_core'),
                'view' 				=> esc_html__('View Prescription', 'doctreat_core'),
                'view_item' 		=> esc_html__('View Prescription', 'doctreat_core'),
                'search_items' 		=> esc_html__('Search Prescription', 'doctreat_core'),
                'not_found' 		=> esc_html__('No Prescription found', 'doctreat_core'),
                'not_found_in_trash' => esc_html__('No Prescription found in trash', 'doctreat_core'),
                'parent' 			=> esc_html__('Parent Prescription', 'doctreat_core'),
            );
			
            $args = array(
                'labels' 				=> $labels,
                'description' 			=> esc_html__('This is where you can add prescription ', 'doctreat_core'),
                'public' 				=> true,
                'supports' 				=> array('title','author'),
                'show_ui' 				=> true,
                'capability_type' 		=> 'post',
                'map_meta_cap' 			=> true,
                'publicly_queryable' 	=> true,
                'hierarchical' 			=> false,
                'menu_position' 		=> 10,
                'rewrite' 				=> array('slug' => 'prescription', 'with_front' => true),
                'query_var' 			=> false,
                'has_archive' 			=> false,
            );
			
			//Regirster Vital Signs Taxonomy
            $vital_labels = array(
                'name'              => esc_html__('Vital Signs', 'doctreat_core'),
                'singular_name'     => esc_html__('Vital Sign','doctreat_core'),
                'search_items'      => esc_html__('Search Vital Sign', 'doctreat_core'),
                'all_items'         => esc_html__('All Vital Sign', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Vital Sign', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Vital Sign:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Vital Sign', 'doctreat_core'),
                'update_item'       => esc_html__('Update Vital Sign', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Vital Sign', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Vital Sign Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Vital Signs', 'doctreat_core'),
            );
            
            $vital_args = array(
                'hierarchical'          => true,
                'labels'                => $vital_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'vital-signs'),
            );
			
            register_taxonomy('vital_signs', array('prescription'), $vital_args);
            
            //Regirster Childhood illness Taxonomy
            $illness_labels = array(
                'name'              => esc_html__('Childhood illness', 'doctreat_core'),
                'singular_name'     => esc_html__('Childhood illness','doctreat_core'),
                'search_items'      => esc_html__('Search Childhood illness', 'doctreat_core'),
                'all_items'         => esc_html__('All Childhood illness', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Childhood illness', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Childhood illness:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Childhood illness', 'doctreat_core'),
                'update_item'       => esc_html__('Update Childhood illness', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Childhood illness', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Childhood illness Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Childhood illness', 'doctreat_core'),
            );
            
            $illness_args = array(
                'hierarchical'          => true,
                'labels'                => $illness_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'childhood-illness'),
            );
			
            register_taxonomy('childhood_illness', array('prescription'), $illness_args);

            //Regirster Medicine type Taxonomy
            $medicine_labels = array(
                'name'              => esc_html__('Medicine types', 'doctreat_core'),
                'singular_name'     => esc_html__('Medicine type','doctreat_core'),
                'search_items'      => esc_html__('Search Medicine type', 'doctreat_core'),
                'all_items'         => esc_html__('All Medicine type', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Medicine type', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Medicine type:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Medicine type', 'doctreat_core'),
                'update_item'       => esc_html__('Update Medicine type', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Medicine type', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Medicine type Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Medicine types', 'doctreat_core'),
            );
            
            $medicine_args = array(
                'hierarchical'          => true,
                'labels'                => $medicine_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'medicine-types'),
            );
			
            register_taxonomy('medicine_types', array('prescription'), $medicine_args);

            //Regirster Medicine Usage Taxonomy
            $usage_labels = array(
                'name'              => esc_html__('Medicine Usage', 'doctreat_core'),
                'singular_name'     => esc_html__('Medicine Usage','doctreat_core'),
                'search_items'      => esc_html__('Search Medicine Usage', 'doctreat_core'),
                'all_items'         => esc_html__('All Medicine Usage', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Medicine Usage', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Medicine Usage:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Medicine Usage', 'doctreat_core'),
                'update_item'       => esc_html__('Update Medicine Usage', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Medicine Usage', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Medicine Usage Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Medicine Usage', 'doctreat_core'),
            );
            
            $usage_args = array(
                'hierarchical'          => true,
                'labels'                => $usage_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'medicine-usage'),
            );
			
            register_taxonomy('medicine_usage', array('prescription'), $usage_args);

            //Regirster Medicine Duration Taxonomy
            $duration_labels = array(
                'name'              => esc_html__('Medicine Duration', 'doctreat_core'),
                'singular_name'     => esc_html__('Medicine Duration','doctreat_core'),
                'search_items'      => esc_html__('Search Medicine Duration', 'doctreat_core'),
                'all_items'         => esc_html__('All Medicine Duration', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Medicine Duration', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Medicine Duration:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Medicine Duration', 'doctreat_core'),
                'update_item'       => esc_html__('Update Medicine Duration', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Medicine Duration', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Medicine Duration Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Medicine Duration', 'doctreat_core'),
            );
            
            $duration_args = array(
                'hierarchical'          => true,
                'labels'                => $duration_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'medicine-duration'),
            );
			
            register_taxonomy('medicine_duration', array('prescription'), $duration_args);

            //Status Taxonomy
            $duration_labels = array(
                'name'              => esc_html__('Marital status', 'doctreat_core'),
                'singular_name'     => esc_html__('Marital status','doctreat_core'),
                'search_items'      => esc_html__('Search Marital status', 'doctreat_core'),
                'all_items'         => esc_html__('All Marital status', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Marital status', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Marital status:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Marital status', 'doctreat_core'),
                'update_item'       => esc_html__('Update Marital status', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Marital status', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Marital status Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Marital status', 'doctreat_core'),
            );
            
            $duration_args = array(
                'hierarchical'          => true,
                'labels'                => $duration_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'marital-status'),
            );
			
            register_taxonomy('marital_status', array('prescription'), $duration_args);

             //Diseases Taxonomy
             $diseases_labels = array(
                'name'              => esc_html__('Disease', 'doctreat_core'),
                'singular_name'     => esc_html__('Disease','doctreat_core'),
                'search_items'      => esc_html__('Search Diseases', 'doctreat_core'),
                'all_items'         => esc_html__('All Diseases', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Disease', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Disease:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Disease', 'doctreat_core'),
                'update_item'       => esc_html__('Update Disease', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Disease', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Disease Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Diseases', 'doctreat_core'),
            );
            
            $diseases_args = array(
                'hierarchical'          => true,
                'labels'                => $diseases_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'diseases'),
            );
			
            register_taxonomy('diseases', array('prescription'), $diseases_args);
            
             //Regirster Laboratory Tests Taxonomy
             $labe_labels = array(
                'name'              => esc_html__('Laboratory Tests', 'doctreat_core'),
                'singular_name'     => esc_html__('Laboratory Tests','doctreat_core'),
                'search_items'      => esc_html__('Search Laboratory Tests', 'doctreat_core'),
                'all_items'         => esc_html__('All Laboratory Tests', 'doctreat_core'),
                'parent_item'       => esc_html__('Parent Laboratory Tests', 'doctreat_core'),
                'parent_item_colon' => esc_html__('Parent Laboratory Tests:', 'doctreat_core'),
                'edit_item'         => esc_html__('Edit Laboratory Tests', 'doctreat_core'),
                'update_item'       => esc_html__('Update Laboratory Tests', 'doctreat_core'),
                'add_new_item'      => esc_html__('Add New Laboratory Tests', 'doctreat_core'),
                'new_item_name'     => esc_html__('New Laboratory Tests Name', 'doctreat_core'),
                'menu_name'         => esc_html__('Laboratory Tests', 'doctreat_core'),
            );
            
            $labe_args = array(
                'hierarchical'          => true,
                'labels'                => $labe_labels,
                'show_ui'               => true,
                'show_admin_column'     => false,
                'query_var'             => true,
                'rewrite'               => array('slug' => 'laboratory-tests'),
            );
			
            register_taxonomy('laboratory_tests', array('prescription'), $labe_args);

            register_post_type('prescription', $args);
			
        }

        /**
		 * Add service meta
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function doctreat_diseases_meta() { ?>
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
		public	function doctreat_diseases_meta_edit($term) { 
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
		public	function doctreat_diseases_meta_save( $term_id ) {
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
		public	function doctreat_diseases_meta_update( $term_id ) {
			if( !empty( $_POST['speciality'] ) && $_POST['speciality'] ) {
				update_term_meta( $term_id, 'speciality', $_POST['speciality'] );
			}
		} 
    }

    new Doctreat_Prescription();
}

