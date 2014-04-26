<?php //WangGuard Plugin, Help page

function wangguard_help() {
	global $wpdb,$wangguard_nonce, $wangguard_api_key;

	if ( !current_user_can('level_10') )
		die(__('Cheatin&#8217; uh?', 'wangguard'));

	if ( defined('WANGGUARD_VERSION') )  { $wangguard_version = WANGGUARD_VERSION; }
	if ( defined('WANGGUARD_REST_PATH') ) {$wangguard_rest_path = WANGGUARD_REST_PATH;}
	
	//Creating some links
	
	$wangguarwebipcheck = '<a href="http://www.whatismyip.com/">What Is My IP</a>';
	if ( ! is_multisite() ) {
									$wangguarsettingspage = '<a href="' .esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) ) . '">' . __( 'WangGuard Settings', 'wangguard' ) . '</a>';
									$wangguaruserspage = '<a href="' .esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_users' ), 'admin.php' ) ) ) . '">' . __( 'WangGuard Users', 'wangguard' ) . '</a>';
									} else { 
									$wangguarsettingspage = '<a href="' .esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_conf' ), 'admin.php' ) ) ) . '">' . __( 'WangGuard Settings', 'wangguard' ) . '</a>';
									$wangguaruserspage = '<a href="' .esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_users' ), 'admin.php' ) ) ) . '">' . __( 'WangGuard Users', 'wangguard' ) . '</a>';
	}
	?>
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'WangGuard Help', 'wangguard' ), $wangguard_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Help about WangGuard %s. You can use the contact form if you don\'t find an answer to your question', 'wangguard'  ), $wangguard_version ); ?></div>
			<div class="wangguard-badge"><?php printf( __( 'Version %s' ), $wangguard_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) ); }
				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Help', 'wangguard' ); ?>
				</a><a class="nav-tab" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Help Us', 'wangguard' ); ?>
					<a class="nav-tab" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_contact' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_contact' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Contact', 'wangguard' ); ?>
				</a>
			</h2>

		<!--	<div class="changelog">
				<h3><?php _e( 'WangGuard Server IP Check', 'wangguard' ); ?></h3>

				<div class="feature-section">
					<h4><?php _e( 'This is a very important test, Server IP Check', 'wangguard' ); ?></h4>
					<p>
						<strong>Server IP</strong>: <?php echo $_SERVER['SERVER_ADDR']; ?><br />
						<strong>Your IP  </strong>: <?php echo wangguard_get_the_ip(); ?>
					</p>
					<p><?php if ( wangguard_get_the_ip() == $_SERVER['SERVER_ADDR'] ) {
										printf( __( '<strong style="color:#FF0000;">WARNING:</strong> Your server is reporting it\'s own IP as user IP. Please go to %s and check <strong>\'Do NOT verify client IP address\'</strong>', 'wangguard' ), $wangguarsettingspage ); }
										else {
											_e('<strong style="color:#00CC00;">OK</strong> Looks like your server reports the correct User IP', 'wangguard' );}
					
						?>
					</p>
				</div>
			</div> -->

			<div class="changelog">
				<h3><?php _e( 'First steps', 'wangguard' ); ?></h3>

				<div class="feature-section">
					<h4><?php _e( 'Activate WangGuard', 'wangguard' ); ?></h4>
				  	<p><?php _e( 'Get an API Key for your website. You need to register once. With your account, you can get a new API key for every website you own. You only needs to login at WangGuard.com', 'wangguard' ); ?></p>
                  	<h4><?php _e( 'Test WangGuard', 'wangguard' ); ?></h4>
				  	<p><?php _e( 'Many people activate WangGuard and don\'t test the registration form. Is very important to test the registration form once WangGuard is active.', 'wangguard' ); ?></p>
               	  	<p><?php _e( 'For test the it follow this steps:', 'wangguard' ); ?></p>
                    	<ul>
                    		<li><?php _e( '1.- Activate WangGuard', 'wangguard' ); ?></li>
                    		<li><?php printf( __( '2.- Go to Configuration -> %s -> and enable \'<strong>Do NOT verify client IP address</strong>\'.', 'wangguard' ), $wangguarsettingspage ); ?></li>
                    		<li><?php _e( '3.- Now, lets go to register on your own website. Are you blocked? Look at the FAQ below "First Steps".', 'wangguard' ); ?></li>
                    		<li><?php _e( '4.- If you are not blocked, try to register with this email <code>splog@wangguard.com</code>. You have to be blocked.', 'wangguard' ); ?></li>
                        </ul>
               	  	<p><?php _e( 'Ok, if you are not blocked in the step 3 or blocked in the step 4, we go on track :-).', 'wangguard' ); ?></p>
                    <p><?php _e( 'The next steps are very important, we have to check if you website is reporting your real IP or the server IP:', 'wangguard' ); ?></p>
                    	<ul>
                    		<li><?php printf( __( '5- Go to %s', 'wangguard' ), $wangguaruserspage); ?></li>
                    		<li><?php _e( '6- Look for the new user that you created in the step 3', 'wangguard' ); ?></li>
                    		<li><?php _e( '7- Look the user IP.', 'wangguard' ); ?></li>
                    		<li><?php printf( __( '8- Visit a website like %s for know your real IP', 'wangguard' ), $wangguarwebipcheck ); ?></li>
                    	</ul>
                    <p><?php _e( 'Are they not the same IP? Look at the FAQ below "First Steps".', 'wangguard' ); ?></p>
                    <p><?php _e( 'Are they the same IP? You may be putting a beer in the fridge (if you can drink alcohol, if not, put a soda or a beer without acohol), becasue we need few more steps for has WangGuard ready', 'wangguard' ); ?></p>
                    <br />
                	<p><?php _e( 'Ok, if you arrived here is because WangGuard is 100% compatible with your installation, so lets go to configure it!', 'wangguard' ); ?></p>
                    <h4><?php _e( 'Configuration', 'wangguard' ); ?></h4>
                    <p><?php  printf( __( 'Now we will start with the %s tab.', 'wangguard' ), $wangguarsettingspage ); ?></p>
                    <p><?php _e( 'Not to much to say, because I think all settings are too clear.', 'wangguard' ); ?></p>
                    <p><?php _e( 'I just want to mention three that may go unnoticed.', 'wangguard' ); ?></p>
                    <ul>
                    	<li><?php _e( '<strong>Allow reporting users from Posts admin screen.</strong> If you allow to your users to write at your blog, you will love this tool. Activating this tool, you will be able to report users from Post Screen', 'wangguard' ); ?></li>
                        <li><?php _e( '<strong>Check email domains agains the DNS server.</strong> Many people think this is not necessary, because they use BuddyPress or WordPress Multisite and they sent and activation email. That\'s right, all signups will be a real emails, but, How many emails do you sent to fake emails? Do you now that you can be flagged as Spam server if you sent a lot of activation emails to fake emails? This tool will help you to avoid this problem.', 'wangguard' ); ?></li>
                        <li><?php _e( '<strong>Do NOT verify client IP address.</strong> Maybe it is the most important configuration in WangGuard and many people don\'t know it. This tool is for check or not check the user IP, by default WangGuard always check the user IP. If you are testing WangGuard, you always need to mark it. If you don\'t mark it, your IP will be blocked by suspicious activity. That is the reason that this is the step #2 in "<strong>First Steps</strong>". In the same way, if you are a speaker in a WordCamp (for example), you will need to mark this option because probably you will have many signups from the same IP.', 'wangguard' ); ?></li>
					</ul>
                    <p><?php _e( 'Go to the next tab, <strong>Blocked domains</strong>', 'wangguard' ); ?></p>
                    <p><?php _e( 'Yo will see different domains:', 'wangguard' ); ?></p>
                    <ul>
                    	<li><?php _e( '<strong>Common Domains</strong> Never block all domains. Between these domains there are domains like gmail, yahoo, msn, hotmail, etc. In general, you should not block any of these, but in some cases, you might be interested in blocking certain domains that only are used by sploggers on your site.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>Free domains</strong> these are free domains, from our experience, practically all are domains belonging to unwanted users. You can block registrations or not. Note that you could block a legitimate user but represent only a 0.5% of them.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>Disposable E-mail</strong> Our advice is that you block all of them. These emails are temporary emails, which means that once they sign up after 1 hour the email is no longer valid.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>Top-level domains</strong> This list is interesting for those who have many unwanted users from specific TLD countries.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>mail.com Domains</strong> mail.com has the largest free domains email service. For this reason we have dedicated a specific list. There is no need to block any in particular, but if there is a domain from which you receive many unwanted users, block it.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>Dynamic Domains</strong> These domains are often used by the sploggers or unwanted users to create mail servers in their home and/or office. Almost certainly you can block all of them.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>Hospitals & Clinics</strong> These are domains of hospitals and clinics. In these domains have been detected unwanted users. Emails from unwanted users are already being blocked by WangGuard without the need of selecting any domain from this list.', 'wangguard' ); ?></li>
                       <li><?php _e( '<strong>Colleges & Universities</strong> These are domains of Colleges & Universities. In these domains have been detected unwanted users. Emails from unwanted users are already being blocked by WangGuard without the need of selecting any domain from this list.', 'wangguard' ); ?></li>
                   </ul>
                   <p><?php _e( 'Now that you already know all the different domine listings, mark the domains you wish to block.', 'wangguard' ); ?></p>
                   <p><?php _e( 'To finish WangGuard setup, you can create some security Questions, but it is not necesary. We recomment you use security Questions if you have many fake signups (less 10%) with WangGuard activated.', 'wangguard' ); ?></p>
                   <?php _e( '<strong>Never</strong> use this questions', 'wangguard' ); ?>
                   <ul>
                   		<li><?php _e( 'Never use math questions, many bots know math.', 'wangguard' ); ?></li>
                        <li><?php _e( 'Never use obvious questions, eg. The actual President of USA is... Many bots use a very big data base with asnwers for this questions', 'wangguard' ); ?></li>
                   </ul>
				</div>
			</div>

			<div class="changelog">
				<h3><?php _e( 'FAQ', 'wangguard' ); ?></h3>

				<div class="feature-section">
					<h4><?php _e( 'I\'m blocked testing WangGuard Step #3', 'wangguard' ); ?></h4>
					<p><?php _e( 'Basically, there are two options:', 'wangguard' ); ?></p>
					<ul>
					<li><?php _e( 'The error is "Domain not Allowed", that\'s because you are using a plugin or a theme with signup form not compatible with WangGuard. If yes, you will need to speak with the theme or plugin developer. (WangGuard will add its own signup form in a future release)', 'wangguard' ); ?></li>
					<li><?php _e( 'You use another plugin for filter signups. Some plugins break WangGuard. There are some Capchas that break WangGuard. Try to deactivate that plugins', 'wangguard'); ?>
					</li>
					</ul>

					<h4><?php _e( 'The IP are not the same step #8', 'wangguard' ); ?></h4>
					<p><?php _e( 'You are using a reverse proxy or load balancer. You need to speak with your server admin and tell him that add X-Forwarded-For to the Header. It will fix this problem. If you has this problem, you don\'t want to check the users IP because all users will be blocked.', 'wangguard' ); ?></p>
					<h4><?php _e( 'Some users are blocked by WangGuard', 'wangguard' ); ?></h4>
					<p><?php _e( 'There are some reason:', 'wangguard' ); ?></p>
					<ul>
					<li><?php _e( 'He was reported by a user, he need to contact with us and we will remove the email ', 'wangguard' ); ?></li>
					<li><?php _e( 'He tried to register many times, ex: he forgot to fill some fields and the IP was blocked after some tries. He need to contact with us', 'wangguard'); ?>
					</li>
					<li><?php _e( 'He is using a proxy or VPN. We block all proxys and VPNs.', 'wangguard'); ?>
					<li><?php _e( 'He is using TOR network. We block the TOR network.', 'wangguard'); ?>
					</li>
					</ul>
					<h4><?php _e( 'Which is the difference between Third Party Plugins and Add-ons', 'wangguard' ); ?></h4>
					<p><?php _e( 'Basically, Third Party Plugins are plugins that Works with WangGuard and if it is present adds some functionalities. WangGuard Add-ons, are plugins that needs WangGuard plugin and it adds functionalities.', 'wangguard' ); ?></p>
					<h4><?php _e( 'WangGuard is not saving the API Key, settings or security questions', 'wangguard' ); ?></h4>
					<p><?php _e( 'That\'s because there was something wrong at WangGuard activation and WangGuard database tables weren\'t created.', 'wangguard' ); ?></p>
					<p><?php _e( 'Please, copy the next code and use phpMyadmin or similar software for create WangGuard tables.', 'wangguard' ); ?></p>
					<p>
					<?php

							$sitetableprefix= $wpdb->base_prefix;
							$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";


echo '<textarea class="code" readonly="readonly" cols="80" rows="16">
CREATE TABLE '.$sitetableprefix.'wangguardquestions (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	Question VARCHAR(255) NOT NULL,
	Answer VARCHAR(50) NOT NULL,
	RepliedOK INT(11) DEFAULT 0 NOT NULL,
	RepliedWRONG INT(11) DEFAULT 0 NOT NULL,
	UNIQUE KEY id (id)
) '.$charset_collate.';
		
CREATE TABLE '.$sitetableprefix.'wangguarduserstatus (
	ID BIGINT(20) NOT NULL,
	user_status VARCHAR(20) NOT NULL,
	user_ip VARCHAR(15) NOT NULL,
	user_proxy_ip VARCHAR(15) NOT NULL,
	UNIQUE KEY ID (ID)
) '.$charset_collate.';

CREATE TABLE '.$sitetableprefix.'wangguardreportqueue (
	ID BIGINT(20) NULL,
	blog_id BIGINT(20) NULL,
	reported_on TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	reported_by_ID BIGINT(20) NOT NULL,
	KEY reported_by_ID (reported_by_ID),
	KEY ID (ID),
	KEY blog_id (blog_id),
	UNIQUE KEY ID_blog (ID , blog_id)
) '.$charset_collate.';

CREATE TABLE '.$sitetableprefix.'wangguardsignupsstatus (
	signup_username VARCHAR(60) NOT NULL,
	user_status VARCHAR(20) NOT NULL,
	user_ip VARCHAR(15) NOT NULL,
	user_proxy_ip VARCHAR(15) NOT NULL,
	UNIQUE KEY signup_username (signup_username)
) '.$charset_collate.';

CREATE TABLE '.$sitetableprefix.'wangguardcronjobs (
	id mediumint(9) NOT NULL AUTO_INCREMENT,
	RunOn VARCHAR(20) NOT NULL,
	RunAt VARCHAR(5) NOT NULL,
	Action VARCHAR(1) NOT NULL,
	UsersTF VARCHAR(1) NOT NULL,
	LastRun TIMESTAMP NULL,
	UNIQUE KEY id (id)
) '.$charset_collate.';
</textarea>' ?>

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
function wangguard_help_us() {
	global $wpdb,$wangguard_nonce, $wangguard_api_key;

	if ( !current_user_can('level_10') )
		die(__('Cheatin&#8217; uh?', 'wangguard'));

	if ( defined('WANGGUARD_VERSION') )  { $wangguard_version = WANGGUARD_VERSION; } ?>
	<?php $wangguard_plugin_url = plugin_dir_url('wangguard-admin.php'); ?>
	<?php $wangguardreviewexample = '<a href="http://www.shoutmeloud.com/wangguard-plugin-stop-wordpress-user-registration-spam.html">shoutmeloud</a>'; ?>
	<?php $wangguarddevelopmentgithub = '<a href="https://github.com/joseconti/WangGuard">Github</a>'; ?>
	<?php $wangguardwordpressreview = '<a href="http://wordpress.org/support/view/plugin-reviews/wangguard">WordPress.org</a>'; ?>
	<?php $wangguardtranslatedlanguages = 'Spanish and Italian'; ?>
	<?php if ( ! is_multisite() ) {
									$wangguarcontributors = '<a href="' .esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) ) . '">' . __( 'Credits', 'wangguard' ) . '</a>';
									} else { 
									$wangguarcontributors = '<a href="' .esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_credits' ), 'admin.php' ) ) ) . '">' . __( 'Credits', 'wangguard' ) . '</a>';
									} ?>
	
		<div class="wrap about-wrap">
			<h1><?php printf( __( 'Help Us', 'wangguard' ), $wangguard_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Help us! WangGuard %s is ready but we want to release the next version!', 'wangguard'  ), $wangguard_version ); ?></div>
			<div class="wangguard-badge"><?php printf( __( 'Version %s' ), $wangguard_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a class="nav-tab" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Help', 'wangguard' ); ?>
				<a class="nav-tab nav-tab-active" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) ); }
				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Help Us', 'wangguard' ); ?>
				</a><a class="nav-tab" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_contact' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_contact' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Contact', 'wangguard' ); ?>
				</a>
			</h2>

			<div class="changelog">
				<h3><?php _e( 'How to help Us?', 'wangguard' ); ?></h3>
				<div class="feature-section col two-col">
					<div>
						<h4><?php _e( 'Donate', 'wangguard' ); ?></h4>
						<p><?php _e( 'You can donate to the project. WangGuard needs servers and that server aren\'t free. In a future, we will activate the Premium accounts for who make money with their website, but now is free and will be free for every one for a long time. If you donate some bucks, you will help us to continue developing and maintaining WangGuard. If you make a donation, contact and sent us your WangGuard user email, Paypal transaction ID, and the amount. We will add it as credit for you once we start with Premium accounts.', 'wangguard' ); ?></p>
					</div>
					<div class="last-feature">
						<h4><?php _e( 'PayPal Donation', 'wangguard' ); ?></h4>
						<p>
							<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
								<input type="hidden" name="cmd" value="_s-xclick">
								<input type="hidden" name="hosted_button_id" value="QLLHHFRXDSJZC">
								<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
								<img alt="" border="0" src="https://www.paypalobjects.com/es_ES/i/scr/pixel.gif" width="1" height="1">
							</form>
						</p>
					</div>
				</div>
				<div class="feature-section images-stagger-left">
					<div>
						<img class="image-66" src="<?php echo $wangguard_plugin_url . 'wangguard/img/wangguard-review.png'; ?>" width="100%" />
						<h4><?php _e( 'Write a review on WordPress.org', 'wangguard' ); ?></h4>
						<p><?php printf( __( 'You can write a review in %s. If you write a review, many people will know WangGuard functionality and they will use it.', 'wangguard' ), $wangguardwordpressreview ); ?></p>
						<p><?php _e( 'If you have an account on wordpress.org, you only will need a few minutes and We\'ll appreciate it.', 'wangguard' ); ?></p>
					</div>
				</div>
				<div class="feature-section images-stagger-right">
					<div>
						<img class="image-66" src="<?php echo $wangguard_plugin_url . 'wangguard/img/wangguard-review-web.png'; ?>" width="100%" />
						<h4><?php _e( 'Write a review on your website', 'wangguard' ); ?></h4>
						<p><?php _e( 'You can write a review about WangGuard. That will help a lot to us. If you write a review, many people will know WangGuard, the more known and used is WangGuard, the more effective. The review will help to you and WangGuard.', 'wangguard' ); ?></p>
						<p><?php printf( __( 'You can see a nice review made by %s', 'wangguard' ), $wangguardreviewexample ); ?></p>
					</div>
				</div>
				<div class="feature-section images-stagger-left">
					<div>
						<img class="image-66" src="<?php echo $wangguard_plugin_url . 'wangguard/img/wangguard-translate.jpg'; ?>" width="100%" />
						<h4><?php _e( 'Translate WangGuard', 'wangguard' ); ?></h4>
						<p><?php printf( __( 'WangGuard is used in over 200 countries around the world, but is only translated into %s.', 'wangguard' ), $wangguardtranslatedlanguages ); ?></p>
						<p><?php printf( __( 'You can fork WangGuard in %s and pull your translation, or you can email us your po/mo files and we will add to WangGuard.', 'wangguard' ), $wangguarddevelopmentgithub ); ?></p>
						<p><?php printf( __( 'If you translate WangGuard to your language, once we launch the Premium accounts, we will upgrade your account to Premium account and you will be in %s screen (if you use Github).', 'wangguard' ), $wangguarcontributors ); ?></p>
					</div>
				</div>
				<div class="feature-section images-stagger-right">
					<div>
						<img class="image-66" src="<?php echo $wangguard_plugin_url . 'wangguard/img/wangguard-code-developers.jpg'; ?>" width="100%" />
						<h4><?php _e( 'Contribute developing', 'wangguard' ); ?></h4>
						<p><?php _e( 'If you are a developer, you can contribute to WangGuard development.', 'wangguard' ); ?></p>
						<p><?php printf( __( 'You can fork WangGuard in %s and pull your code. If your code follow the WordPress standard coding, and it\'s a very interesting feature or you fix a bug, we will add it to the core.', 'wangguard' ), $wangguarddevelopmentgithub ); ?></p>
						<p><?php printf( __( 'But that\'s not all. If you are a rocked developer, once we launch the Premium accounts, we will upgrade your account to Premium account and you will be in %s screen.', 'wangguard' ), $wangguarcontributors ); ?></p>
					</div>
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


// function to get the IP address of the user
function wangguard_get_the_ip() {
	if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {

      return $_SERVER['HTTP_CF_CONNECTING_IP'];}

    elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	else {
		return $_SERVER["REMOTE_ADDR"];
	}
}

// This is a modified fuction of WooCommerce for get active plugins.

function wangguardgetactiveplugins () {
	$active_plugins = (array) get_option( 'active_plugins', array() );

         			if ( is_multisite() )
						$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );

					$wangguard_plugins = array();

					foreach ( $active_plugins as $plugin ) {

						$plugin_data = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );

						if ( ! empty( $plugin_data['Name'] ) ) {

							$wangguard_plugins[] = $plugin_data['Name'] . ' version ' . $plugin_data['Version'];

						}
					}

					if ( sizeof( $wangguard_plugins ) == 0 )
						$wangguardserverinfo = '-';
					else
						$wangguardserverinfo = implode( ', ', $wangguard_plugins );
						
						return $wangguardserverinfo;
}


function wangguard_contact_form($atts) {
	$form_data['your_name'] = '';
	$form_data['subject'] = '';
	$form_data['message'] = '';
	$form_data['email'] = '';
	$form_data['serverinfo'] = '';
	$message_copy = __('This is a copy for you: ','wangguard');
	$info = '';
	$sent = '';
	$wangguardserverinfo = wangguardgetactiveplugins ();
	extract(shortcode_atts(array(
		"subject" => '',
		"label_name" => ''.__('Name','wangguard').'',
		"label_email" => ''.__('E-mail','wangguard').'',
		"label_subject" => ''.__('Subject','wangguard').'',
		"label_message" => ''.__('Message','wangguard').'',
		"label_submit" => ''.__('Submit','wangguard').'',
		"error_empty" => ''.__('Please fill in all the required fields.','wangguard').'',
		"error_noemail" => ''.__('Please enter a valid e-mail address.','wangguard').'',
		"success" => ''.__('Thanks for your e-mail! We\'ll get back to you in the next 24h. If we don\'t contacted with you in the next 24h, maybe the email didn\'t arrive, please in that case use our website contact form.','wangguard').''
	), $atts));

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$error = false;
		$required_fields = array("your_name", "email", "message", "subject");

		foreach ($_POST as $field => $value) {
			if (get_magic_quotes_gpc()) {
				$value = stripslashes($value);
			}
			$form_data[$field] = strip_tags($value);
		}

		foreach ($required_fields as $required_field) {
			$value = trim($form_data[$required_field]);
			if(empty($value)) {
				$error = true;
				$result = $error_empty;
			}
		}

		if(!is_email($form_data['email'])) {
			$error = true;
			$result = $error_noemail;
		}
		
		if ( is_multisite() ) {
			$wangguardwordpressversion =  'WPMU ' ;
			} else {
					$wangguardwordpressversion = 'WP ' ;
					}
		if ( defined('WANGGUARD_VERSION') )  { $wangguard_version = WANGGUARD_VERSION; }
		if ( function_exists( 'phpversion' ) ) $wangguardphpversion =  phpversion();
		if ( function_exists( 'mysql_get_server_info' ) ) $wangguardmysqlversion =  mysql_get_server_info();
		if ( defined('WP_DEBUG') && WP_DEBUG ) { $wangguardwpdebug = 'Yes'; } else { $wangguardwpdebug = 'No'; }
		if ( function_exists( 'ini_get' ) ) $wangguarmaxexecutiontime = ini_get('max_execution_time');
		if ( function_exists( 'wangguardgetactiveplugins' ) ) $wangguaractiveplugins = wangguardgetactiveplugins();		
		if ($error == false) {
			$email_subject = "Contact from the Website [" . get_bloginfo('name') . "] " . $form_data['subject'];
			$email_message = $message_copy . "\n\n" . $form_data['message'] . "\n\nUser IP: " . wangguard_get_the_ip() . "\n\nServer IP: " . $_SERVER['SERVER_ADDR'] . "\n\nHome URL: " . home_url() . "\n\nSite URL: " . site_url() . "\n\nWangGuard version: " . $wangguard_version . "\n\nWordPress version: " . $wangguardwordpressversion . get_bloginfo('version') . "\n\nWeb Server Info: " . $_SERVER['SERVER_SOFTWARE'] . "\n\nPHP Version: " . $wangguardphpversion . "\n\nMySQL Version: " .  $wangguardmysqlversion . "\n\nWordPress Debug: " .  $wangguardwpdebug . "\n\nMax Execution Time: " . $wangguarmaxexecutiontime . "\n\nActive Plugins: ".$wangguardserverinfo;
			$headers  = "From: ".$form_data['email']." <".$form_data['email'].">\n";
			$headers .= "Content-Type: text/plain; charset=UTF-8\n";
			$headers .= "Content-Transfer-Encoding: 8bit\n";
			$email = 'admin@wangguard.com,'.$form_data['email'].'';
			wp_mail($email, $email_subject, $email_message, $headers);
			$result = $success;
			$sent = true;
		}
	}

	if(! $result = '') {
		$info = '<div class="info">'.$result.'</div>';
	}
	$email_form = '<form class="contact-form" method="post" action="'.get_permalink().'">
		<p>
			<label for="cf_name">'.$label_name.':</label>
			<input type="text" name="your_name" id="cf_name" size="50" maxlength="50" value="'.$form_data['your_name'].'" />
		</p>
		<p>
			<label for="cf_email">'.$label_email.':</label>
			<input type="text" name="email" id="cf_email" size="50" maxlength="50" value="'.$form_data['email'].'" />
		</p>
		<p>
			<label for="cf_subject">'.$label_subject.':</label>
			<input type="text" name="subject" id="cf_subject" size="50" maxlength="50" value="'.$subject.$form_data['subject'].'" />
		</p>
		<p>
			<label for="cf_message">'.$label_message.':</label>
			<textarea name="message" id="cf_message" cols="50" rows="15">'.$form_data['message'].'</textarea>
		</p>
		
		<p>
			<input class="button action" type="submit" value="'.$label_submit.'" name="send" id="cf_send" />
		</p>
	</form>';
	
	if($sent == true) {
		return $info.$success;
	} else {
		return $info.$email_form;
	}
} add_shortcode('wangguardcontact', 'wangguard_contact_form');


	function wangguard_contact() {
	
	global $wpdb,$wangguard_nonce, $wangguard_api_key;

	if ( !current_user_can('level_10') )
		die(__('Cheatin&#8217; uh?', 'wangguard'));
		
		if ( defined('WANGGUARD_VERSION') )  { $wangguard_version = WANGGUARD_VERSION; } ?>
        
       <?php $wangguardcontactformurl = '<a href="http://www.wangguard.com/contact">'. __('here', 'wangguard' ) . '</a>'; ?>
       

		<div class="wrap about-wrap">
			<h1><?php printf( __( 'WangGuard Contact', 'wangguard' ), $wangguard_version ); ?></h1>
			<div class="about-text"><?php printf( __( 'Questions or Support about WangGuard %s', 'wangguard' ), $wangguard_version ); ?></div>
			<div class="wangguard-badge"><?php printf( __( 'Version %s' ), $wangguard_version ); ?></div>

			<h2 class="nav-tab-wrapper">
				<a href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help' ), 'admin.php' ) ) );} ?>" class="nav-tab">
					<?php _e( 'Help', 'wangguard' ); ?>
				</a><a class="nav-tab" href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_help_us' ), 'admin.php' ) ) );} ?>">
					<?php _e( 'Help Us', 'wangguard' ); ?>
					<a href="<?php if ( !is_multisite() ) { echo esc_url( admin_url( add_query_arg( array( 'page' => 'wangguard_contact' ), 'admin.php' ) ) ); }

				else { echo esc_url( network_admin_url( add_query_arg( array( 'page' => 'wangguard_contact' ), 'admin.php' ) ) );} ?>" class="nav-tab nav-tab-active">
					<?php _e( 'Contact', 'wangguard' ); ?>
				</a>
			</h2>

			<p class="about-description"><?php printf( __('Contact with us. With this contact form you will send your Name, email, Subject, Message, Web URL, Site URL, IP Server, PHP Version, MySQL version and active plugins. This will help us to help you. If you don\'t want to send us all that information, use our website contact form %s', 'wangguard' ), $wangguardcontactformurl); ?></p>

			 <?php echo do_shortcode( '[wangguardcontact]' ) ?> 

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
?>