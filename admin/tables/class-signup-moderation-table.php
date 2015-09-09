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
			'user_status'       => __( 'Splogger?', 'wangguard' ),
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
			$args = array(
				'echo' => false,
				'selected' => isset( $_GET['user_status'] ) ? $_GET['user_status'] : ''
			);
			$status_dropdown = wangguard_user_status_dropdown( $args );
			?>
			<div class="alignleft actions">
				<?php echo $status_dropdown; ?>
				<input type="submit" name="filter_action" class="button" value="<?php echo esc_attr( 'Filter', 'wangguard' ); ?>">
			</div>
			<?php
		}

	}

	function process_bulk_action() {

		if ( ! current_user_can( 'manage_options' ) )
			return;

		if ( 'splog' === $this->current_action() ) {
			if ( ! empty( $_POST['user'] ) && is_array( $_POST['user'] ) ) {
				// Splog users
				foreach ( $_POST['user'] as $user_id ) {
					wangguard_splog_user( absint( $user_id ) );
				}
			}

		}

		if ( 'unsplog' === $this->current_action() ) {

			if ( ! empty( $_POST['user'] ) && is_array( $_POST['user'] ) ) {
				// Unsplog users
				foreach ( $_POST['user'] as $user_id ) {
					wangguard_unsplog_user( absint( $user_id ) );
				}
			}

		}

		if( 'open' === $this->current_action() ) {
			$ids = array();

			if ( isset( $_POST['ticket'] ) && is_array( $_POST['ticket'] ) )
				$ids = $_POST['ticket'];
			elseif ( isset( $_GET['tid'] ) && is_numeric( $_GET['tid'] ) )
				$ids = array( $_GET['tid'] );

			$ids = array_map( 'absint', $ids );
			foreach ( $ids as $id ) {
				if ( incsub_support_current_user_can( 'open_ticket', $id ) )
					incsub_support_restore_ticket_previous_status( $id );
			}
		}

		if( 'close' === $this->current_action() ) {
			$ids = array();
			if ( isset( $_POST['ticket'] ) && is_array( $_POST['ticket'] ) )
				$ids = $_POST['ticket'];
			elseif ( isset( $_GET['tid'] ) && is_numeric( $_GET['tid'] ) )
				$ids = array( $_GET['tid'] );

			$ids = array_map( 'absint', $ids );
			foreach ( $ids as $id ) {
				if ( incsub_support_current_user_can( 'close_ticket', $id ) )
					incsub_support_close_ticket( $id );
			}
		}

	}

	function get_bulk_actions() {
		$actions = array(
			'splog'    => __( 'Mark as Splogger', 'wangguard' ),
			'unsplog'    => __( 'Unmark as Splogger', 'wangguard' )
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
			'user_status' => isset( $_GET['user_status'] ) ? $_GET['user_status'] : false,
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