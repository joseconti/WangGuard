<?php

function wangguard_get_table( $table_slug ) {
	global $wpdb;

	$tables = array(
		'questions',
		'userstatus',
		'reportqueue',
		'signupsstatus',
		'cronjobs'
	);

	if ( in_array( $table_slug, $tables ) )
		return $wpdb->base_prefix . 'wangguard' . $table_slug;

	return false;
}

/**
 * Get the data from userstatus table
 *
 * @param $args
 */
function wangguard_get_users_status_list( $args = array(), $count = false ) {
	global $wpdb;

	$defaults = array(
		'user_status' => array(), // Search by User Status
		'user_ip' => false, // Search by User IP
		'per_page' => 10,
		'page' => 1,
		'orderby' => 'ID',
		'order' => 'ASC',
		's' => false
	);

	$args = wp_parse_args( $args, $defaults );

	$table = wangguard_get_table( 'userstatus' );

	// WHERE CLAUSE
	$where = array();

	if ( ! empty( $args['user_status'] ) ) {
		if ( is_string( $args['user_status'] ) )
			$args['user_status'] = array( $args['user_status'] );


		$user_status_where = array();
		foreach ( $args['user_status'] as $user_status ) {
			$user_status_where[] = $wpdb->prepare( "wus.user_status = %s", $user_status );
		}
		$user_status_where = implode( ' OR ', $user_status_where );
		$where[] = "( $user_status_where )";
	}

	if ( $args['user_ip'] )
		$where[] = $wpdb->prepare( "user_ip = %s", $args['user_ip'] );

	if ( ! empty( $args['s'] ) ) {
		$where[] = $wpdb->prepare(
			"( u.user_login LIKE %s OR u.user_nicename LIKE %s OR u.user_email LIKE %s )",
			'%' . $args['s'] . '%',
			'%' . $args['s'] . '%',
			'%' . $args['s'] . '%'
		);
	}

	if ( ! empty( $where ) )
		$where = "WHERE " . implode( " AND ", $where );
	else
		$where = "";



	// ORDER BY CLAUSE
	$allowed_orderby = array( 'ID', 'user_ip', 'user_status', 'user_proxy_id', 'user_login', 'user_nicename', 'user_email' );
	if ( ! in_array( $args['orderby'], $allowed_orderby ) )
		$args['orderby'] = $defaults['orderby'];

	if ( $args['orderby'] == 'user_status' )
		$args['orderby'] = 'wus.user_status';

	$allowed_order = array( 'DESC', 'ASC' );
	if ( ! in_array( strtoupper( $args['order'] ), $allowed_order ) )
		$args['order'] = $defaults['order'];

	$orderby = $args['orderby'];
	$order = $args['order'];

	$order = "ORDER BY $orderby $order";


	// LIMIT CLAUSE
	$limit = '';
	$per_page = intval( $args['per_page'] );
	$page = absint( $args['page'] );

	if ( $per_page > -1 )
		$limit = $wpdb->prepare( "LIMIT %d, %d", intval( ( $page - 1 ) * $per_page ), intval( $per_page ) );


	// JOIN CLAUSE
	$join = array();
	$join[] = "JOIN $wpdb->users u ON u.ID = wus.ID";

	$join = implode( " ", $join );

	// Query!
	if ( ! $count ) {
		$query = "SELECT wus.*, u.user_status AS wp_user_status, u.user_email, u.user_nicename, u.user_login, u.user_registered FROM $table wus $join $where $order $limit";
		$results = $wpdb->get_results( $query );
	}
	else {
		$query = "SELECT COUNT( wus.ID ) FROM $table wus $join $where";
		$results = absint( $wpdb->get_var( $query ) );
	}

	return $results;
}

/**
 * Get a single user data from wangguarduserstatus table
 *
 * @param $user_id
 *
 * @return Object
 */
function wangguard_get_user_status_data( $user_id ) {
	global $wpdb;
	$user_id = absint( $user_id );

	$table = wangguard_get_table( 'userstatus' );

	$result = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM $table WHERE ID = %d", $user_id ) );
	if ( ! $result )
		return false;

	return $result;
}

/**
 * Checks if a user is a splogger
 *
 * @param $user_id
 *
 * @return bool
 */
function wangguard_is_splogger( $user ) {
	if ( is_integer( $user ) || empty( $user->use_status ) )
		$user = wangguard_get_user_status_data( $user );

	if ( ! $user )
		return false;

	return $user->user_status === 'reported';
}


function wangguard_get_user_status( $user_id ) {

}

function wangguard_get_all_user_statuses() {
	return array(
		'reported' => __( 'Reported as Splogger', 'wangguard' ),
		'force-checked' => __( 'Checked (forced)', 'wangguard' ),
		'checked' => __( 'Checked', 'wangguard' ),
		'whitelisted' => __( 'Whitelisted', 'wangguard' ),
		'moderation-splogger' => __( 'moderation-splogger', 'wangguard' ),
		'moderation-allowed' => __( 'moderation-allowed', 'wangguard' )
	);
}

function wangguard_translate_user_status( $status ) {
	$all_status = wangguard_get_all_user_statuses();

	if ( isset( $all_status[ $status ] ) )
		return $all_status[ $status ] ;

	return '';
}

function wangguard_user_status_dropdown( $args ) {
	$defaults = array(
		'name' => 'user-status',
		'id' => false,
		'show_empty' => __( 'All Statuses', 'wangguard' ),
		'selected' => '',
		'class' => '',
		'echo' => true
	);

	$args = wp_parse_args( $args, $defaults );

	extract( $args );

	if ( ! $id )
		$id = $name;

	if ( ! $echo )
		ob_start();

	$all_status = wangguard_get_all_user_statuses();

	?>
	<select class="<?php echo esc_attr( $class ); ?>" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>">
		<?php if ( ! empty( $show_empty ) ): ?>
			<option value="" <?php selected( empty( $selected ) ); ?>><?php echo esc_html( $show_empty ); ?></option>
		<?php endif; ?>

		<?php foreach ( $all_status as $key => $label ): ?>
			<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $selected, $key ); ?>><?php echo esc_html( $label ); ?></option>
		<?php endforeach; ?>

	</select>
	<?php

	if ( ! $echo )
		return ob_get_clean();
}


function wangguard_get_api_key() {
	global $wangguard_api_key;
	return $wangguard_api_key;
}

/**
function wangguard_set_user_status( $users, $status, $scope = 'email' ) {
	global $wpdb;

	if ( ! is_array( $users ) ) {
		$users = array( $users );
	}

	$users = array_map( 'absint', $users );

	if ( empty( $users ) ) {
		return new WP_Error( 'empty-users', __( 'Users list empty', 'wangguard' ) );
	}

	$api_key = wangguard_get_api_key();
	$valid = wangguard_verify_key($api_key);

	if ( $valid == 'failed' || $valid == 'invalid' || $valid == 'noplan' ) {
		return new WP_Error( 'api-key-' . $valid, __( 'Invalid API Key', 'wangguard' ) );
	}

	$delete_user = get_site_option ( "wangguard-delete-users-on-report" ) == '1';
	$users_flagged = array();

	foreach ( $users as $user_id ) {
		$user = get_userdata( $user_id );
		if ( ! user_can( $user_id, 'administrator' ) ) {

			if ( ! empty( $user->user_email ) ) {
				$user_status_data = wangguard_get_user_status_data( $user_id );

				//Get the user's client IP from which he signed up
				$user_ip = isset( $user_status_data->user_ip ) ? $user_status_data->user_ip : '';
				$proxy_ip = isset( $user_status_data->proxy_ip ) ? $user_status_data->proxy_ip : '';

				if ( $scope == 'domain' ) {
					$http_string = "wg=<in><apikey>$api_key</apikey><domain>"
					               . wangguard_extract_domain( $user->user_email )
					               . "</domain><ip>" . $user_ip . "</ip><proxyip>" . $proxy_ip . "</proxyip></in>";

					$op = 'add-domain.php';
				}
				elseif ( $scope == 'email' ) {
					$http_string = "wg=<in><apikey>$api_key</apikey><email>"
					               . $user->user_email
					               . "</email><ip>" . $user_ip . "</ip><proxyip>" . $proxy_ip . "</proxyip></in>";

					$op = 'add-email.php';
				}
				else {
					return new WP_Error( 'invalid-scope', __( 'Invalid Scope', 'wangguard' ) );
				}

				 wangguard_http_post( $http_string, $op );
			}

			if ( $delete_user && current_user_can( 'delete_users' ) ) {
				wangguard_delete_user_and_blogs( $user_id );
			}
			else {
				global $wpdb;

				$user_status_data = wangguard_get_user_status_data( $user_id );
				if ( $user_status_data ) {
					//Update the new status
					$table_name = wangguard_get_table( "userstatus" );
					$wpdb->query( $wpdb->prepare( "UPDATE $table_name set user_status = 'reported' where ID = '%d'", $user_id ) );
				} else {
					//if for some reason user status record doesn't exists, create it
					//Try to get the user's client IP from which he signed up
					$table_name = wangguard_get_table( "signupsstatus" );
					$user_ip    = $wpdb->get_var( $wpdb->prepare( "select user_ip from $table_name where signup_username = %s", $user->user_login ) );
					$user_ip   = ( is_null( $user_ip ) ? '' : $user_ip );
					$proxy_ip    = $wpdb->get_var( $wpdb->prepare( "select user_proxy_ip from $table_name where signup_username = %s", $user->user_login ) );
					$proxy_ip    = ( is_null( $proxy_ip ) ? '' : $proxy_ip );

					//create the record
					$table_name = wangguard_get_table( "userstatus" );
					$wpdb->query( $wpdb->prepare( "insert into $table_name values ( %d , 'reported' , '%s' , '%s')", $user_id, $user_ip, $proxy_ip ) );
				}
			}

			$users_flagged[] = $user_id;

		}
	}

	return $users_flagged;

}**/