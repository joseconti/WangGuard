<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

//Check user status
function wangguard_block_login_moderation_user_status($userid){
	global $wpdb;

	$table_name = $wpdb->base_prefix . "wangguarduserstatus";
	$status = $wpdb->get_var( $wpdb->prepare("select user_status from $table_name where ID = %d" , $userid) );

	if ( $status ) return $status;

}

/********************************************************************/
/*** CHECK MODERATION USER IN THE WORDPRESS LOGIN FORM BEGINS **/
/********************************************************************/

function wangguard_block_login_moderation_check_user_login( $user, $username, $password ) {

	$user = get_user_by( 'login', $username );
	$userid = $user->ID;
	if ($userid) $status = wangguard_block_login_moderation_user_status($userid);

	if ( $status == 'moderation-allowed' || $status == 'moderation-splogger' ) {
		return new WP_Error(1, 'Your account is under moderation.<br />Contact with the webmaster');
	}
	return $user;
}
add_filter( 'authenticate', 'wangguard_block_login_moderation_check_user_login', 30, 3 );

?>