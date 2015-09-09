<?php

class WangGuard_Signup_Moderation_Admin_Menu {

	public $capability = 'manage_options';

	public function __construct() {
		$page = add_submenu_page(
			'wangguard_conf',
			__( 'Signup Moderation', 'wangguard'),
			__( 'Signup Moderation', 'wangguard' ),
			$this->capability,
			'wangguard_signupmod',
			array( $this, 'render' ) // The function that renders the screen
		);

		add_action( 'load-' . $page, array( $this, 'on_load' ) );

	}

	/**
	 * Triggered when the page is loaded
	 */
	public function on_load() {
		if ( isset( $_POST['filter_action'] ) || isset( $_POST['s'] ) ) {
			// We're filtering the table. Let's redirect with $_GET params instead

			$url = $_SERVER['REQUEST_URI'];
			if ( ! empty( $_POST['user-status'] ) )
				$url = add_query_arg( 'user_status', $_POST['user-status'], $url );
			else
				$url = remove_query_arg( 'user_status', $url );

			if ( ! empty( $_POST['s'] ) ) {
				$url = add_query_arg( 's', esc_attr( $_POST['s'] ), $url );
			}
			else {
				$url = remove_query_arg( 's', $url );
			}

			// Let's go to page 1 again
			$url = add_query_arg( 'paged', 1, $url );
			wp_safe_redirect( $url );
			die();
		}

	}

	public function render() {
		include_once( 'tables/class-signup-moderation-table.php' );
		$table = new WangGuard_Signup_Moderation_Table();
		$table->prepare_items();

		include( 'views/signup-moderation.php' );
	}

}