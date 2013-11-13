<?php

function wangguard_core_mark_user_spam_admin( $user_id ) {
 	include_once 'bp-activity/bp-activity-classes.php';
	bp_core_process_spammer_status( $user_id, 'spam' );
}

?>