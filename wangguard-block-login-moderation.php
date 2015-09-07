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

function wangguard_site_check() {
	global $blog_id;
	$blog = get_current_blog_id();
	$admin_email = get_blog_option($blog, 'admin_email');

	$user = get_user_by( 'email', $admin_email );
	$user_id = $user->ID;
	if ( $user_id ) $status = wangguard_block_login_moderation_user_status($user_id);
	if ( $status != 'moderation-allowed' && $status != 'moderation-splogger' )
		return true;
	// Allow super admins to see blocked sites
	if ( is_super_admin() )
		return true;
	if ( $status == 'moderation-allowed' || $status == 'moderation-splogger' ) {
		if ( file_exists( plugin_dir_path( __FILE__ ) . '/blog-moderated.php' ) )
			return plugin_dir_path( __FILE__ ) . '/blog-moderated.php';
		else
			wp_die( __( 'This site is under moderation.' ), '', array( 'response' => 410 ) );
	}
	return true;
}
function wangguard_check_website(){
	if ( is_multisite() ) {
		if ( true !== ( $file = wangguard_site_check() ) ) {
			require( $file );
			die();
		}
		unset($file);
	}
}
add_action('init', 'wangguard_check_website')

?>