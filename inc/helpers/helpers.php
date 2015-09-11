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
	$user = wangguard_get_user_status_data( $user_id );
	if ( ! $user )
		return false;

	return $user->user_status;
}

function wangguard_get_all_user_statuses() {
	return array(
		'reported' => __( 'Reported as Splogger', 'wangguard' ),
		'force-checked' => __( 'Checked (forced)', 'wangguard' ),
		'checked' => __( 'Checked', 'wangguard' ),
		'whitelisted' => __( 'Whitelisted', 'wangguard' ),
		'moderation-splogger' => __( 'Moderate Splogger', 'wangguard' ),
		'moderation-allowed' => __( 'Moderate User', 'wangguard' )
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


function wangguard_send_user_signup_approved( $user ) {
	$email = '';
	if ( is_email( $user ) ) {
		$email = $user;
	}
	elseif ( is_integer( $user ) ) {
		$user = get_userdata( absint( $user ) );
		if ( empty( $user->user_email ) )
			return;
		$email = $user->user_email;
	}
	elseif ( ! empty( $user->user_email ) ) {
		$email = $user->user_email;
	}
	else {
		return;
	}

	$home_url = is_multisite() ? network_site_url() : site_url();

	if ( is_multisite() ) {
		$current_site = get_current_site();
		$site_name = $current_site->site_name;
	}
	else {
		$site_name = get_bloginfo( 'name' );
	}

	$message = sprintf( __( 'Hi your account has been approved in %s [%s]', 'wangguard' ), $site_name, esc_url( $home_url ) );
	$subject = sprintf( __( '[%s] Account approved', 'wangguard' ), $site_name );
	wp_mail( $email, $subject, $message );
}