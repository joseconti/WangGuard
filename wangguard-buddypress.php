<?php
function wangguard_bp_core_process_spammer_status( $user_id, $status, $do_wp_cleanup = true ) {
	global $wpdb, $bp;

	// Bail if no user ID
	if ( empty( $user_id ) )
		return;

	// Bail if user ID is super admin
	if ( is_super_admin( $user_id ) )
		return;

	// Get the functions file
	if ( is_multisite() ) {
		require_once( ABSPATH . 'wp-admin/includes/ms.php' );
	}

	$is_spam = ( 'spam' == $status );

	// Only you can prevent infinite loops
	remove_action( 'make_spam_user', 'bp_core_mark_user_spam_admin' );
	remove_action( 'make_ham_user',  'bp_core_mark_user_ham_admin'  );

	
	//We hide cleanning BuddyPress activity.
	
	$wpdb->get_var( $wpdb->prepare( "UPDATE {$bp->activity->table_name} SET hide_sitewide = 1 WHERE user_id = %d", $user_id ) );
	
	
		// We add here all BuddyPress fucntions for Spam z
	bp_activity_spam_all_user_data( $user_id );
	
	// We need a special hook for is_spam so that components can delete data at spam time
	$bp_action = ( true === $is_spam ) ? 'wangguard_bp_make_spam_user' : 'wangguard_bp_make_ham_user';
	do_action( $bp_action, $user_id );

	// Allow plugins to do neat things
	do_action( 'bp_core_process_spammer_status', $user_id, $is_spam );

	// Put things back how we found them
	add_action( 'make_spam_user', 'bp_core_mark_user_spam_admin' );
	add_action( 'make_ham_user',  'bp_core_mark_user_ham_admin'  );

	return true;
}


function wangguard_spam_user( $userid ){		
		$status = 'spam';
		wangguard_bp_core_process_spammer_status($userid, $status);
}
add_action('wangguard_pre_mark_user_spam_wizard','wangguard_spam_user');
add_action('wangguard_pre_make_spam_user','wangguard_spam_user');

function wangguard_bp_activity_spam_all_user_data( $user_id = 0 ) {
	global $bp, $wpdb;

	// Do not delete user data unless a logged in user says so
	if ( empty( $user_id ) )
		return false;

	// Get all the user's activities.
	$activities = bp_activity_get( array( 'display_comments' => 'stream', 'filter' => array( 'user_id' => $user_id ), 'show_hidden' => true, ) );

	// Mark each as spam
	foreach ( (array) $activities['activities'] as $activity ) {

		// Create an activity object
		$activity_obj = new BP_Activity_Activity;
		foreach ( $activity as $k => $v )
			$activity_obj->$k = $v;

		// Mark as spam
		bp_activity_mark_as_spam( $activity_obj );

		/*
		 * If Akismet is present, update the activity history meta.
		 *
		 * This is usually taken care of when BP_Activity_Activity::save() happens, but
		 * as we're going to be updating all the activity statuses directly, for efficency,
		 * we need to update manually.
		 */
		if ( ! empty( $bp->activity->akismet ) )
			$bp->activity->akismet->update_activity_spam_meta( $activity_obj );

		// Tidy up
		unset( $activity_obj );
	}

	// Mark all of this user's activities as spam
	$wpdb->query( $wpdb->prepare( "UPDATE {$bp->activity->table_name} SET is_spam = 1 WHERE user_id = %d", $user_id ) );

	// Call an action for plugins to use
	do_action( 'bp_activity_spam_all_user_data', $user_id, $activities['activities'] );
}
add_action( 'wangguard_bp_make_spam_user', 'wangguard_bp_activity_spam_all_user_data' );


function wangguard_spam_all_data( $user_id ) {
	global $wpdb, $bp;
	$wpdb->query( $wpdb->prepare( "DELETE FROM {$bp->blogs->table_name} WHERE user_id = %d", $user_id ) );
	friends_remove_data( $user_id );
	$group_ids = BP_Groups_Member::get_group_ids( $user_id );
		foreach ( $group_ids['groups'] as $group_id ) {
			groups_update_groupmeta( $group_id, 'total_member_count', groups_get_total_member_count( $group_id ) - 1 );

			// If current user is the creator of a group and is the sole admin, delete that group to avoid counts going out-of-sync
			if ( groups_is_user_admin( $user_id, $group_id ) && count( groups_get_group_admins( $group_id ) ) < 2 && groups_is_user_creator( $user_id, $group_id ) )
				groups_delete_group( $group_id );
		}

		return $wpdb->query( $wpdb->prepare( "DELETE FROM {$bp->groups->table_name_members} WHERE user_id = %d", $user_id ) );
		BP_Groups_Member::delete_all_for_user( $user_id );
}
add_action( 'wangguard_bp_make_spam_user', 'wangguard_spam_all_data' );
?>