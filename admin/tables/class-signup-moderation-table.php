<?php

class WangGuard_Signup_Moderation_Table extends WP_List_Table {

	function __construct( $args = array() ){
		parent::__construct( array(
			'singular'  => __( 'User', 'wangguard' ),
			'plural'    => __( 'Users', 'wangguard' ),
			'ajax'      => false
		) );
	}

	function column_default( $item, $column_name ) {
		if ( isset( $item->$column_name ) )
			return $item->$column_name;

		return '';
	}

	function column_cb( $item ){
		return sprintf(
			'<input type="checkbox" name="%1$s[]" value="%2$s" />',
			$this->_args['singular'],
			$item->ID
		);
	}

	function column_user_login( $item ) {
		$row_actions = array();

		$splog_url = add_query_arg( array(
			'user' => $item->ID,
			'action' => 'splog'
		) );

		$unsplog_url = add_query_arg( array(
			'user' => $item->ID,
			'action' => 'unsplog'
		) );

		$row_actions['splog'] =  sprintf( '<a href="%s">%s</a>', esc_url( $splog_url ), __( 'Mark as Splogger', 'wangguard' ) );
		$row_actions['unsplog'] =  sprintf( '<a href="%s">%s</a>', esc_url( $unsplog_url ), __( 'Approve User', 'wangguard' ) );

		return $item->user_login . $this->row_actions( $row_actions );
	}


	function column_signup( $item ) {
		return date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), strtotime( $item->user_registered ) );
	}


	function column_user_status( $item ) {
		return wangguard_translate_user_status( $item->user_status );
	}

	function get_columns(){
		$columns = array(
			'cb'                => '<input type="checkbox" />',
			'ID'                => __( 'User ID', 'wangguard' ),
			'user_login'        => __( 'Username', 'wangguard' ),
			'user_nicename'     => __( 'Name', 'wangguard' ),
			'user_email'        => __( 'Email', 'wangguard' ),
			'user_registered'   => __( 'Sign Up On', 'wangguard' ),
			'user_ip'           => __( 'User IP', 'wangguard' ),
			'user_proxy_ip'     => __( 'User Proxy IP', 'wangguard' ),
		);


		return $columns;
	}

	function get_sortable_columns() {
		return array(
			'ID'                => array( 'ID', true ),
			'user_login'        => array( 'user_login', false ),
			'user_nicename'     => array( 'user_nicename', false ),
			'user_email'        => array( 'user_email', false ),
			'user_registered'   => array( 'user_registered', false ),
			'user_ip'           => array( 'user_ip', false ),
			'user_proxy_ip'     => array( 'user_proxy_ip', false ),
			'user_status'       => array( 'user_status', false )
		);
	}

	function extra_tablenav( $which ) {
		if ( 'top' == $which) {

			$selected = isset( $_GET['user_status'] ) ? $_GET['user_status'] : ''
			?>
			<div class="alignleft actions">
				<select class="" name="user-status" id="user-status">
					<option value="" <?php selected( $selected, '' ); ?>>All Statuses</option>
					<option value="moderation-splogger" <?php selected( $selected, 'moderation-splogger' ); ?>><?php echo wangguard_translate_user_status( 'moderation-splogger' ); ?></option>
					<option value="moderation-allowed" <?php selected( $selected, 'moderation-allowed' ); ?>><?php echo wangguard_translate_user_status( 'moderation-allowed' ); ?></option>
				</select>
				<input type="submit" name="filter_action" class="button" value="<?php echo esc_attr( 'Filter', 'wangguard' ); ?>">
			</div>
			<?php
		}

	}

	function process_bulk_action() {

		if ( ! current_user_can( 'manage_options' ) )
			return;

		if ( 'splog' === $this->current_action() ) {
			if ( ! empty( $_REQUEST['user'] ) ) {
				$users = $_REQUEST['user'];
				if ( ! is_array( $users ) )
					$users = array( $users );

				// Splog users
				$users_ids = array_map( 'absint', $users );
				wangguard_report_users( $users_ids, 'email', false );
			}

		}

		if ( 'unsplog' === $this->current_action() ) {

			if ( ! empty( $_REQUEST['user'] ) ) {
				$users = $_REQUEST['user'];
				if ( ! is_array( $users ) )
					$users = array( $users );

				// Unsplog users
				$users_ids = array_map( 'absint', $users );
				wangguard_whitelist_report( $users_ids );
				foreach ( $users_ids as $user_id )
					wangguard_send_user_signup_approved( $user_id );
			}

		}

	}

	function get_bulk_actions() {
		$actions = array(
			'splog'    => __( 'Mark as Splogger', 'wangguard' ),
			'unsplog'    => __( 'App    rove User', 'wangguard' )
		);
		return $actions;
	}

	function prepare_items() {
		$per_page = 10;

		$columns = $this->get_columns();
		$hidden = array( 'ID' );
		$sortable = $this->get_sortable_columns();

		$this->_column_headers = array(
			$columns,
			$hidden,
			$sortable
		);

		$current_page = $this->get_pagenum();

		$this->process_bulk_action();

		$args = array(
			'page' => $current_page,
			'per_page' => $per_page,
			'orderby' => isset( $_GET['orderby'] ) ? $_GET['orderby'] : 'ID',
			'order' => isset( $_GET['order'] ) ? $_GET['order'] : 'ASC',
			'user_status' => isset( $_GET['user_status'] ) ? $_GET['user_status'] : array( 'moderation-splogger', 'moderation-allowed' ),
			's' => isset( $_GET['s'] ) ? $_GET['s'] : false
		);
		$this->items = wangguard_get_users_status_list( $args );
		$total_items = wangguard_get_users_status_list( $args, true );

		$this->set_pagination_args( array(
			'total_items' => $total_items,
			'per_page'    => $per_page,
			'total_pages' => ceil($total_items/$per_page)
		) );
	}

}