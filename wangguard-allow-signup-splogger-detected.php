<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS REGISTRATION FORM BEGINS **/
/********************************************************************/

function wangguard_allow_signup_whitelisted(){
	$wggstopcheck = true;
			return $wggstopcheck;
}

function wangguard_allow_singup_splogger_check_email( $user_email ){

  $sploggerallowedtosignup = wangguard_look_for_allowed_email($user_email);

  if ( $sploggerallowedtosignup ) {

  		add_filter('pre_wangguard_validate_signup_form_wordpress_no_multisite', 'wangguard_allow_signup_whitelisted',10,3);
			}
}
add_action('pre_wangguard_validate_signup_form_wordpress_no_multisite', 'wangguard_allow_singup_splogger_check_email');

/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS REGISTRATION FORM ENDS **/
/********************************************************************/

/********************************************************************/
/*** ADD MESSAGE IN THE WORDPRESS MULTISITE REGISTRATION FORM BEGINS **/
/********************************************************************/

if (is_multisite()) {
		// require( dirname( __FILE__ ) . '/wangguard-blacklisted-words-wpmu.php' );
	}


/********************************************************************/

/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS BUDDYPRESS REGISTRATION FORM BEGINS **/
/********************************************************************/

function wangguard_bp_allow_sploggers_detected_code() {
   // require( dirname( __FILE__ ) . '/wangguard-blacklisted-words-bp.php' );
}
add_action( 'bp_include', 'wangguard_bp_allow_sploggers_detected_code' );



/********************************************************************/
/*** CHECK DOMAINS IN THE WORDPRESS BUDDYPRESS REGISTRATION FORM ENDS **/
/********************************************************************/

/********************************************************************/
/*** CHECK DOMAINS IN THE WOOCOMMERCE MY ACCOUNT FORM BEGINS **/
/********************************************************************/
function wangguard_llow_sploggers_detected_code_woocommerce($user_name, $email, $errors){

		$user_email = $_POST['email'];

        $blocked = wangguard_check_bl_word_email($user_email);

		if ($blocked) {
			$errors->add('user_email',   __('<strong>ERROR</strong>: Your email has words not Allowed in this site.', 'wangguard-blacklisted-words'));
			return $errors;
        }
}
// if (get_option('woocommerce_enable_myaccount_registration')=='yes') add_action('woocommerce_before_customer_login_form', 'wangguard_blacklisted_words_woocommerce_add_on');
/********************************************************************/
/*** CHECK DOMAINS IN THE WOOCOMMERCE MY ACCOUNT FORM ENDS **/
/********************************************************************/

/********************************************************************/
/*** LOOK FOR EMAILS BEGINS **/
/********************************************************************/


function wangguard_look_for_allowed_email($user_email){

	$arrayallowedbemails = get_site_option('wangguard_allow_signup_emails_list');
	if( !$arrayallowedbemails || empty($arrayallowedbemails) ) {
		return false;
		} else {
			foreach ($arrayallowedbemails as $key => $value) {$arrayallowedbemails[$key] = trim ($value);}
			$search_for = $user_email;
			if (array_search ($search_for, $arrayallowedbemails, true)===false) {
					return false;
					} else {
						return true;
					}
			}
		}

/********************************************************************/
/*** LOOK FOR EMAILS ENDS **/
/********************************************************************/
?>