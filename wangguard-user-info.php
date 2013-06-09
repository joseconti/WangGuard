<?php
//WangGuard Users Info

function wangguard_users_info() {
	global $wpdb,$wangguard_nonce, $wangguard_api_key,$wangguard_api_host , $wangguard_rest_path;
	

	if ( !current_user_can('level_10') )
		die(__('Cheatin&#8217; uh?', 'wangguard'));

		echo "ID del usuario:" . $_GET["userID"] . "<br>";
	}
?>
