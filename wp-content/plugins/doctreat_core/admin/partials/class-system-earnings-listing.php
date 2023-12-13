<?php
/**
 * page earnings listing
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Elevator
 * @subpackage Doctreat/includes
 * @author     Amentotech <theamentotech@gmail.com>
 */
// extend TCPF with custom functions

if( !class_exists('Earnings_List') ){
	class Earnings_List extends WP_List_Table {

		public function __construct() {

			parent::__construct( [
				'singular' => esc_html__( 'Earnings', 'doctreat_core' ), 
				'plural'   => esc_html__( 'Earnings', 'doctreat_core' ),
				'ajax'     => false 
			] );
		}

		/**
		 * Retrieve earnings data from the database
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public static function get_earnings( $per_page = 5, $page_number = 1 ) {

			global $wpdb;

			$sql = "SELECT * FROM {$wpdb->prefix}dc_earnings";
			
			if( ! empty( $_REQUEST['s'] ) ){
				$search = intval( $_REQUEST['s'] );
				$sql .= " WHERE booking_id = $search";
			}
			
			if ( ! empty( $_REQUEST['orderby'] ) ) {
				$sql .= ' ORDER BY ' . esc_sql( $_REQUEST['orderby'] );
				$sql .= ! empty( $_REQUEST['order'] ) ? ' ' . esc_sql( $_REQUEST['order'] ) : ' ASC';
			} else {
				$sql .= ' ORDER BY id DESC';
			}

			
			$sql .= " LIMIT $per_page";
			$sql .= ' OFFSET ' . ( $page_number - 1 ) * $per_page;


			$result = $wpdb->get_results( $sql, 'ARRAY_A' );

			return $result;
		}

		/**
		 * Delete Earnings
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public static function delete_earnings( $id ) {
		  global $wpdb;
		  $wpdb->delete(
			"{$wpdb->prefix}dc_earnings",
			[ 'id' => $id ],
			[ '%d' ]
		  );
		}

		/**
		 * Change Earnings Status
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public static function change_staus_earnings( $id ,$status) {
		  global $wpdb;
			if( !empty( $id ) && !empty( $status ) ) {
				$data		= array('status'	=> $status );
				$where		= array('id'		=> $id );
				$updated 	= $wpdb->update( "{$wpdb->prefix}dc_earnings", $data, $where );
			}
		}

		/**
		 * Returns the count of records in the database.
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public static function record_count() {
			global $wpdb;

			$sql = "SELECT COUNT(*) FROM {$wpdb->prefix}dc_earnings";

			return $wpdb->get_var( $sql );
		}

		/**
		 * Text displayed when no Earnings data is available
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function no_items() {
			esc_html_e( 'No Earnings avaliable.', 'doctreat_core' );
		}

		/**
		 * Render a column when no column specific method exist.
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function column_default( $item, $column_name ) {
			$date_formate	= get_option('date_format');		

			switch ( $column_name ) {
				case 'user_id':
					$user_name	= doctreat_get_username($item[ $column_name ]);
					// create a nonce
					$delete_nonce = wp_create_nonce( 'sp_delete_earnings' );
					$title = esc_html__( 'Delete', 'doctreat_core' );


					$actions = [
						'delete' => sprintf( '<a href="?post_type=doctors&page=%s&action=%s&earnings=%s&_wpnonce=%s">'.$title.'</a>', esc_attr( $_REQUEST['page'] ), 'delete', absint( $item['id'] ), $delete_nonce )
					];

					return $user_name . $this->row_actions( $actions );
				case 'amount':
					return doctreat_price_format($item[ $column_name ]);
				case 'doctor_amount':
					return doctreat_price_format($item[ $column_name ]);
				case 'admin_amount':
					return doctreat_price_format($item[ $column_name ]);
				case 'booking_id':
					return '<a href="'.get_edit_post_link($item[ $column_name ]).'">'.get_the_title($item[ $column_name ]).'</a>';
				case 'order_id':
					return '<a href="'.get_edit_post_link($item[ $column_name ]).'"> #'.$item[ $column_name ].'</a>';
				case 'status':
					$status_nonce = wp_create_nonce( 'sp_delete_payout' );
					if( function_exists( 'doctreat_get_earning_status_list' ) ) {
						$status	= doctreat_get_earning_status_list();
					} else {
						$status	= array();
					}
					$chage_status	= array();
					if( !empty( $status ) ) {
						foreach( $status as $key => $val ) {
							if( $val !== $status[$item[ $column_name ]] ) {
								$actions = [
									'change_status' => sprintf( '<a href="?post_type=doctors&page=%s&action=%s&earnings=%s&status=%s&_wpnonce=%s">'.$val.'</a>', esc_attr( $_REQUEST['page'] ), 'change_status', absint( $item['id'] ),$key, $status_nonce )
								];
								$chage_status[]	= $this->row_actions( $actions );
							}
						}
					} 
					return $status[$item[ $column_name ]].implode(' ',$chage_status);
			}
		}
		
		/**
		 * Associative array of columns
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		function get_columns() {
			$columns = array(
				'user_id' 				=> esc_html__( 'User Name', 'doctreat_core' ),
				'booking_id'   			=> esc_html__( 'Booking', 'doctreat_core' ),
				'order_id'   			=> esc_html__( 'Order', 'doctreat_core' ),
				'amount'    			=> esc_html__( 'Amount', 'doctreat_core' ),
				'doctor_amount'    		=> esc_html__( 'Doctor Share', 'doctreat_core' ),
				'admin_amount'    		=> esc_html__( 'Admin Share', 'doctreat_core' ),								
				'status'   				=> esc_html__( 'Status', 'doctreat_core' )
			);

			return $columns;
		}

		/**
		 * Sortable
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function get_sortable_columns() {
			$sortable_columns = array(
				'user_id' 			=> array( 'user_id', true ),
				'booking_id' 		=> array( 'booking_id', true ),
				'doctor_amount' 	=> array( 'doctor_amount', false ),
				'admin_amount' 		=> array( 'admin_amount', false ),
				'order_id' 			=> array( 'order_id', false ),
				'status' 			=> array( 'status', false ),
				'amount' 			=> array( 'amount', false )
			);

			return $sortable_columns;
		}

		/**
		 * Handles data query and filter, sorting, and pagination.
		 *
		 * @throws error
		 * @author Amentotech <theamentotech@gmail.com>
		 * @return 
		 */
		public function prepare_items() {

			$this->_column_headers = $this->get_column_info();

			$per_page     = $this->get_items_per_page( 'earnings_per_page', 20 );
			$current_page = $this->get_pagenum();
			$total_items  = self::record_count();

			if( !empty( $_GET['action'] ) && !empty( $_GET['earnings'] ) && $_GET['action'] === 'delete' ){
				//delete action
				self::delete_earnings($_GET['earnings']);
			}

			if( !empty( $_GET['action'] ) && !empty( $_GET['earnings'] ) && $_GET['action'] === 'change_status' ){
				//change status action
				self::change_staus_earnings($_GET['earnings'],$_GET['status']);
			}

			$this->set_pagination_args( [
				'total_items' => $total_items, 
				'per_page'    => $per_page 
			] );

			$this->items = self::get_earnings( $per_page, $current_page );
		}
	}
}
