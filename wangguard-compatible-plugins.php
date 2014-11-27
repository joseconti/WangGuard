<?php //empezamos
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
*Looking for banner
*/
function wangguard_look_for_plugin_banner($bannerurl)
{
   $handle = @fopen($bannerurl, "r");
   if ($handle == false)
             return false;
   fclose($handle);
      return true;
}
/**
* Getting WangGuard compatible plugins from WordPress.org
*/
 function wangguard_compatible_plugins() {
	global $wpdb,$wangguard_nonce, $wangguard_api_key, $wangguard_rest_path;
	if ( defined('WANGGUARD_API_HOST') ) {$wangguard_api_host = WANGGUARD_API_HOST;}
	$wangguard_plugin_url = plugin_dir_url('wangguard-admin.php');
	if ( !current_user_can('level_10') )
		die(__('Cheatin&#8217; uh?', 'wangguard'));
	if ( defined('WANGGUARD_VERSION') )  { $wangguard_version = WANGGUARD_VERSION; } ?>
		<div class="wrap about-wrap">
			<h1><?php _e( 'Plugins compatibles with WangGuard' ); ?></h1>
			<div class="about-text"><?php _e( 'Third party plugins compatibles with WangGuard', 'wangguard'  ); ?></div>
			<div class="wangguard-badge"><?php printf( __( 'Version %s' ), $wangguard_version ); ?></div>
			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_compatible_plugins' ), 'admin.php' ) ) ); }
				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_compatible_plugins' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Third party plugins', 'wangguard' ); ?>
				</a>
			</h2>
			<div class="changelog">
				<h3><?php _e( 'Third party plugins', 'wangguard' ); ?></h3>
					<?php
$args = array(
	'search' => 'wangguard',
	'fields' => array(
		'downloaded' => true,
		'downloadlink' => true,
		'slug' => true
	)
);
// Make request and extract plug-in object. Action is query_plugins
$response = wp_remote_post(
	'http://api.wordpress.org/plugins/info/1.0/',
	array(
		'body' => array(
			'action' => 'query_plugins',
			'request' => serialize((object)$args)
		)
	)
);
if ( !is_wp_error($response) ) {
	$returned_object = unserialize(wp_remote_retrieve_body($response));
	$plugins = $returned_object->plugins;
	if ( !is_array($plugins) ) {
		// Response body does not contain an object/array
		echo "An error has occurred";
	}
	else {
		// Display a list of the plug-ins and the number of downloads
		//print_r ($plugins);
		if ( $plugins ) {
		add_thickbox();
		//print_r($returned_object->plugins);
			foreach ( $plugins as $plugin ) {
			 if ( ( $plugin->name == 'CM Invitation Codes' ) || ( $plugin->name == 'WangGuard' ) || ( $plugin->author_profile == '//profiles.wordpress.org/jconti' ) ) {
			 // I'm sorry CM Invitation Codes Developer, but you are making Spam tags. 
			 continue; } else {
			echo '<div class="changelog">';
			//echo '<h3>'.esc_html($plugin->name). '</h4>';
					echo '<div class="feature-section images-stagger-right">';
					$bannerurl = "http://s-plugins.wordpress.org/" . esc_html($plugin->slug) . "/assets/banner-772x250.png"; 
						if ( wangguard_look_for_plugin_banner ( $bannerurl ) ) {
						echo '<img class="image-66" src="http://s-plugins.wordpress.org/' . esc_html($plugin->slug) . '/assets/banner-772x250.png" alt="">';
						}
						else {
							echo '<img class="image-66" src="' . plugin_dir_url('wangguard-admin.php') . 'wangguard/img/no-banner.png" alt="">';
						}
								echo '<div class="feature-section images-stagger-right">';
									echo '<h4>'.esc_html($plugin->name). '</h4>';
									echo '<p>'.esc_html($plugin->short_description).'</p>';
									// echo '<p>'.esc_html($plugin->download_link).'</p>';
									echo '<a href="' . self_admin_url( 'plugin-install.php?tab=plugin-information&amp;plugin=' . $plugin->slug . '&amp;TB_iframe=true&amp;width=600&amp;height=550' ) . '" class="thickbox" title="' . esc_attr( sprintf( __( 'More information about %s' ), $plugin->name ) ) . '">' . __( 'Details', 'wangguard' ) . '</a>';
								echo '</div>';
						echo '</div>';		}
		} echo '</div>';
	}
} }
else {
	// Error object returned
	echo "An error has occurred";
}
					?>				</div>
										</div>
			<div class="return-to-dashboard">
				<a href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) ); }
				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) );} ?>"><?php _e( 'Go to WangGuard Settings', 'wangguard' ); ?></a>
			</div>
		</div>
<?php } ?>