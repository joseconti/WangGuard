<?php 
/*  
	Some code taked from WooCommerce

	Copyright 2010  WangGuard (email : admin@wangguard.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	
	function wangguard_about() {
		global $wpdb,$wangguard_nonce, $wangguard_api_key;
		$wangguard_plugin_url = plugin_dir_url('wangguard-admin.php');
		
		if ( defined('WANGGUARD_API_HOST') ) {$wangguard_api_host = WANGGUARD_API_HOST;}
		if ( defined('WANGGUARD_REST_PATH') ) {$wangguard_rest_path = WANGGUARD_REST_PATH;}
		
		if ( !current_user_can('level_10') )die(__('Cheatin&#8217; uh?', 'wangguard'));
		
		if ( defined('WANGGUARD_VERSION') )  {
			$wangguard_version = WANGGUARD_VERSION;
		}

		?>
		<div class="wrap about-wrap">
			<h1><?php  printf( __( 'Welcome to WangGuard %s' ), $wangguard_version ); ?></h1>
			<div class="about-text"><?php  printf( __( 'Thank you for updating to the latest version! WangGuard %s is ready to learn to use, communicate better with us, coloborate with us and more', 'wangguard'  ), $wangguard_version ); ?></div>
			<div class="wangguard-badge"><?php  printf( __( 'Version %s' ), $wangguard_version ); ?></div>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_about' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_about' ), 'admin.php' ) ) );
		}

		?>">
					<?php  _e( 'What&#8217;s New' ); ?>
				</a><a class="nav-tab" href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) );
		}

		?>">
					<?php  _e( 'Credits' ); ?>
				</a><a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_development' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_development' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab">
					<?php  _e( 'Development' ); ?>
				</a>
			</h2>
			<div class="changelog">
				<h3><?php  _e( 'Welcome to WangGuard, Welcome to the revolution', 'wangguard' ); ?></h3>
				<div class="feature-section col two-col">
					<img class="image-100" src="<?php  echo $wangguard_plugin_url . 'wangguard/img/wangguard-about.png'; ?>" width=100% />
					<div>
						<h4><?php  _e( 'Working Hard', 'wangguard' ); ?></h4>
						<p><?php  _e( 'We\'re working hard to be the best anti-splog system in the world. With your help, we will be. ', 'wangguard' ); ?></p>
					</div>
					<div class="last-feature">
					<h4><?php  _e( 'WangGuard 1.6 RC1, Why?', 'wangguard' ); ?></h4>
					<p><?php  _e( 'In recent months, we have been working very hard on this new version, but we have found that previous versions didn\'t work with WordPress 3.9 and BuddyPress 2.0, so we have to release this RC1 version. This version is working perfectly, although there is some unfinished pages.', 'wangguard' ); ?></p>
					</div>
				</div>
			</div>
			<div class="changelog">
				<h3><?php  _e( 'New Help page', 'wangguard' ); ?></h3>
				<div class="feature-section images-stagger-right">
					<img class="image-66" src="<?php  echo $wangguard_plugin_url . 'wangguard/img/wangguard-help.png'; ?>" width=100% />
					<h4><?php  _e( 'Introducing Help Section', 'wangguard' ); ?></h4>
					<p><?php  _e( 'Now you can get help from WangGuard or Help to WangGuard. Just go to ', 'wangguad' ); ?><a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) );
		}

		?>"><?php  _e('Help', 'wangguard'); ?></a><?php  _e(' section and use the tab that best fits your needs.', 'wangguard' ); ?></p>
					<p><?php  _e( 'In <strong>Help tab</strong>, you will find help about WangGuard, first steps, etc.', 'wangguard' ); ?></p>
					<p><?php  _e( 'In <strong>Help Us tab</strong>, you will find how you can help WangGuard.', 'wangguard' ); ?></p>
					<p><?php  _e( 'In <strong>Contact</strong> tab, you will find contact form, yes, from your own administration!.', 'wangguard' ); ?></p>
				</div>
			</div>
			<div class="return-to-dashboard">
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Go to WangGuard Settings', 'wangguard' ); ?></a>
			</div>
		</div>
		<?php
	}

	/*****************************************************************************************************/	
	/*****************************************************************************************************/
	/**
	 * Render Contributors List
	 *
	 * @access public
	 * @return string $contributor_list HTML formatted list of contributors.
	 */
	function wangguard_contributors() {
		$contributors = get_contributors_wangguard();
		
		if ( empty( $contributors ) )return '';
		$contributor_list = '<ul class="wp-people-group">';
		foreach ( $contributors as $contributor ) {
			
			if ( $contributor->login != 'joseconti')  {
				$contributor_list .= '<li class="wp-person">';
				$contributor_list .= sprintf( '<a href="%s" title="%s">',esc_url( 'https://github.com/' . $contributor->login ),esc_html( sprintf( __( 'View %s', 'wangguard' ), $contributor->login ) ));
				$contributor_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $contributor->avatar_url ), esc_html( $contributor->login ) );
				$contributor_list .= '</a>';
				$contributor_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $contributor->login ), esc_html( $contributor->login ) );
				$contributor_list .= '</a>';
				$contributor_list .= '</li>';
			} else {
				continue;
			}

		}

		$contributor_list .= '</ul>';
		return $contributor_list;
	}

	/*****************************************************************************************************/	
	/*****************************************************************************************************/
	/**
	 * Render Commits List
	 *
	 * @access public
	 * @return string $contributor_list HTML formatted list of contributors.
	 */
	function wangguard_commits() {
		$commits = get_commits_wangguard();
		
		if ( empty( $commits ) )return '';
		$commit_list = '';
		foreach ( $commits as $commit ) {
			$commit_list .= '<div class="changelog">';
			$commit_list .= '<div class="feature-section col two-col">';
			$commit_list .= '<div>';
			$commit_list .= '<ul class="wp-people-group">';
			$commit_list .= '<li class="wp-person">';
			$commit_list .= sprintf( '<a href="%s" title="%s">',esc_url( $commit->author->html_url ),esc_html( sprintf( __( 'View %s', 'wangguard' ), $commit->commit->author->name ) ));
			$commit_list .= sprintf( '<img src="%s" width="64" height="64" class="gravatar" alt="%s" />', esc_url( $commit->author->avatar_url ), esc_html( $commit->author->login ) );
			$commit_list .= '</a>';
			$commit_list .= sprintf( '<a class="web" href="%s">%s</a>', esc_url( 'https://github.com/' . $commit->commit->author->name ), esc_html( $commit->commit->author->name ) );
			$commit_list .= '</a>';
			$wangguardcommitdate = new DateTime($commit->commit->author->date);
			$commit_list .= '<span class="title">Made on ' . $wangguardcommitdate->format("l, d F Y H:i:s") . '</span>';
			$commit_list .= '</li>';
			$commit_list .= '</ul>';
			$commit_list .= '</div>';
			$commit_list .= '<div class="last-feature">';
			$commit_list .= '<h4>Commit:</h4>';
			$commit_list .= '<p>';
			$commit_list .= $commit->commit->message;
			$commit_list .= '</p>';
			$commit_list .= '<p>';
			$commit_list .= sprintf( 'See this Commit in <a href="%s">Github</a>', esc_url( 'https://github.com/joseconti/WangGuard/commit/' . $commit->sha));
			$commit_list .= '</p>';
			$commit_list .= '</div>';
			$commit_list .= '</div>';
			$commit_list .= '</div>';
			$commit_list .= '<br />';
		}

		//$commit_list .= '</ul>';
		return $commit_list;
	}

	/**
	 * Retreive list of contributors from GitHub.
	 *
	 * @access public
	 * @return void
	 */ //TODO filter Jose and Maxi
	function get_contributors_wangguard() {
		$contributors = get_transient( 'wangguard_contributors' );
		
		if ( false !== $contributors )return $contributors;
		$response = wp_remote_get( 'https://api.github.com/repos/joseconti/wangguard/contributors', array( 'sslverify' => false ) );
		
		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )return array();
		$contributors = json_decode( wp_remote_retrieve_body( $response ) );
		
		if ( ! is_array( $contributors ) )return array();
		set_transient( 'wangguard_contributors', $contributors, 3600 );
		return $contributors;
	}

	/**
	 * Retreive list of commits from GitHub.
	 *
	 * @access public
	 * @return void
	 */
	function get_commits_wangguard() {
		$commits = get_transient( 'wangguard_commits' );
		
		if ( false !== $commits )return $commits;
		$response = wp_remote_get( 'https://api.github.com/repos/joseconti/wangguard/commits', array( 'sslverify' => false ) );
		
		if ( is_wp_error( $response ) || 200 != wp_remote_retrieve_response_code( $response ) )return array();
		$commits = json_decode( wp_remote_retrieve_body( $response ) );
		
		if ( ! is_array( $commits ) )return array();
		set_transient( 'wangguard_commits', $commits, 3600 );
		return $commits;
	}

	function wangguard_credits() {
		
		if ( defined('WANGGUARD_VERSION') )  {
			$wangguard_version = WANGGUARD_VERSION;
		}

		?>
		<div class="wrap about-wrap">
			<h1><?php  printf( __( 'WangGuard %s Credits', 'wangguard' ), $wangguard_version ); ?></h1>
			<div class="about-text"><?php  _e( 'These are the people that actually makes WangGuard possible', 'wangguard' ); ?></div>
			<div class="wangguard-badge"><?php  printf( __( 'Version %s' ), $wangguard_version ); ?></div>
			<h2 class="nav-tab-wrapper">
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_about' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_about' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab">
					<?php  _e( 'What&#8217;s New' ); ?>
				</a><a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab nav-tab-active">
					<?php  _e( 'Credits' ); ?>
				</a><a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_development' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_development' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab">
					<?php  _e( 'Development' ); ?>
				</a>
			</h2>
			<p class="about-description"><?php  _e( 'WangGuard is created by a worldwide splog haters.', 'wangguard' ); ?></p>
			<p>
				Want to contribute to <strong>WangGuard</strong>? You can do it in many ways.
				You can see all the ways in 
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Help Us' ); ?></a>
				.
			</p>
			<h4 class="wp-people-group"><?php  _e( 'Project Leader and Core Developer', 'wangguard' ); ?></h4>
			<ul class="wp-people-group">
				<li class="wp-person">
					<a title="View joseconti" href="https://github.com/joseconti">
					<img class="gravatar" height="64" width="64" alt="joseconti" src="https://secure.gravatar.com/avatar/58739a905a719e6f1591333917b3118b?d=https://a248.e.akamai.net/assets.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png">
					</a>
					<a class="web" href="https://github.com/joseconti">Jose Conti</a>
					<span class="title"><?php  _e( 'Founder and the greater splog hater in the world', 'wangguard'); ?></span>
				</li>
			</ul>
			<h4 class="wp-people-group"><?php  _e( 'Contributing Developers', 'wangguard' ); ?></h4>
			<?php  echo wangguard_contributors(); ?>
			<p>
				<?php  _e( 'Want to be here? more info in ', 'wangguard' ); ?>
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Help Us', 'wangguard' ); ?></a>
				.
			</p>
			<div class="return-to-dashboard">
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Go to WangGuard Settings', 'wangguard' ); ?></a>
			</div>
		</div>
		<?php
	}

	
	function wangguard_development() {
		
		if ( defined('WANGGUARD_VERSION') )  {
			$wangguard_version = WANGGUARD_VERSION;
		}

		?>
		<div class="wrap about-wrap">
			<h1><?php  _e( 'WangGuard Development', 'wangguard'); ?></h1>
			<div class="about-text"><?php  _e( 'Follow WangGuard Development', 'wangguard' ); ?></div>
			<div class="wangguard-badge"><?php  printf( __( 'Version %s' ), $wangguard_version ); ?></div>
			<h2 class="nav-tab-wrapper">
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_about' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_about' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab">
					<?php  _e( 'What&#8217;s New' ); ?>
				</a><a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab">
					<?php  _e( 'Credits' ); ?>
				</a><a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_development' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_development' ), 'admin.php' ) ) );
		}

		?>" class="nav-tab nav-tab-active">
					<?php  _e( 'Development' ); ?>
				</a>
			</h2>
			<p class="about-description"><?php  _e( 'WangGuard is created by a worldwide splog haters.', 'wangguard' ); ?></p>
			<p>
				<?php  _e('Want to contribute to <strong>WangGuard</strong>? You can do it in many ways.
You can see all ways in ', 'wangguard'); ?>
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Help Us' ); ?></a>
				.
			</p>
			<h4 class="wp-people-group"><?php  _e( 'WangGuard Commits', 'wangguard' ); ?></h4>
			<?php  echo wangguard_commits(); ?>
			<p>
				<?php  _e( 'Want to be here? more info in ', 'wangguard' ); ?>
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Help Us', 'wangguard' ); ?></a>
				.
			</p>
			<div class="return-to-dashboard">
				<a href="<?php 
		
		if ( !is_multisite() ) {
			echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );
		} else {
			echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );
		}

		?>"><?php  _e( 'Go to WangGuard Settings', 'wangguard' ); ?></a>
			</div>
		</div>
		<?php
 } ?>