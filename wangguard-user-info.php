<?php
//WangGuard Users Info

function wangguard_users_info() {
	global $wpdb,$wangguard_nonce, $wangguard_api_key,$wangguard_api_host , $wangguard_rest_path, $blog_id;
	

	if ( !current_user_can('level_10') )
		die(__('Cheatin&#8217; uh?', 'wangguard'));

		$userID = $_GET["userID"];
		$userIP = $_GET["userIP"];
		$user_info = get_userdata($userID);
		
	$blogID = $user_info->primary_blog;
	$blog_details = get_blog_details( array( 'blog_id' => $blogID ) );

      echo 'Username: ' . $user_info->user_login . '<br />';
      echo 'User ID: ' . $user_info->ID . '<br />';
      echo 'User IP: ' . $userIP . '<br />';
      echo 'User nicename: ' . $user_info->user_nicename . '<br />';
      echo 'User email: ' . $user_info->user_email . '<br />';
      echo 'User registered: ' . $user_info->user_registered . '<br />';
      echo 'User nickname: ' . $user_info->nickname . "<br />";
      echo 'Blog ID: ' . $blogID . '<br />';
      echo 'User primary Blog : ' . $blog_details->blogname . '<br />';
      echo get_avatar( $user_info->user_email , 120 );

}
      
?>