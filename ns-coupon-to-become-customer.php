<?php
/*
Plugin Name: NS Coupon to Become Customer
Description: This plugin allows you to increase your users and sales thanks to coupons! 
Version: 1.2.2
Author: NsThemes
Author URI: http://www.nsthemes.com
License: GNU General Public License v2.0
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: ns-coupon-to-become-customer
Domain Path: /i18n
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


/** 
 * @author        PluginEye
 * @copyright     Copyright (c) 2019, PluginEye.
 * @version         1.0.0
 * @license       https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License Version 3
 * PLUGINEYE SDK
*/

require_once('plugineye/plugineye-class.php');
$plugineye = array(
    'main_directory_name'       => 'ns-coupon-to-become-customer',
    'main_file_name'            => 'ns-coupon-to-become-customer.php',
    'redirect_after_confirm'    => 'admin.php?page=ns-coupon-to-become-customer%2Fns-admin-options%2Fns_admin_option_dashboard.php',
    'plugin_id'                 => '191',
    'plugin_token'              => 'NWNmZTFiZjdlM2NjYjNiMWZiYTA2MTYxNDJkMzQ4YmQ4YTk3N2UzYWEzZDY1ZGFiODJhNWFjMTFlZDE2ZDRlMjJmZjU0NjA0NThkNGY=',
    'plugin_dir_url'            => plugin_dir_url(__FILE__),
    'plugin_dir_path'           => plugin_dir_path(__FILE__)
);

$plugineyeobj191 = new pluginEye($plugineye);
$plugineyeobj191->pluginEyeStart();      
        

if ( ! defined( 'NS_CTBC_PLUGIN_DIR' ) )
    define( 'NS_CTBC_PLUGIN_DIR', untrailingslashit( dirname( __FILE__ ) ) );
if ( ! defined( 'NS_CTBC_PLUGIN_DIR_URL' ) )
    define( 'NS_CTBC_PLUGIN_DIR_URL', plugin_dir_url(__FILE__) );

/*========================================================*/
/*					   REQUIRE FILES				      */
/*========================================================*/
require_once(NS_CTBC_PLUGIN_DIR.'/ns-coupon-to-become-customer-mail.php');
require_once( plugin_dir_path( __FILE__ ).'ns-coupon-to-become-customer-options.php');
require_once( plugin_dir_path( __FILE__ ).'ns-admin-options/ns-admin-options-setup.php');


/*========================================================*/
//  frontend CSS: is included only if 
//  user is not logged in and in cart page			          
/*========================================================*/
function ns_ctbc_css( $hook ) {
    if(!is_user_logged_in() && ( is_page( 'cart' ) || is_cart() )){
        wp_enqueue_style('ns-ctbc-style-custom', NS_CTBC_PLUGIN_DIR_URL. '/ASSETS/CSS/style.css');
        wp_enqueue_style( 'all-min', NS_CTBC_PLUGIN_DIR_URL. '/ASSETS/CSS/all.min.css', array(), '1.0.0' );
    }
}
add_action( 'wp_enqueue_scripts', 'ns_ctbc_css' );

/*========================================================*/
//  frontend JS: is included only if 
//  user is not logged in and in cart page		          
/*========================================================*/
function ns_ctbc_js( $hook ) {
    if(!is_user_logged_in() && ( is_page( 'cart' ) || is_cart()) && !isset($_COOKIE['visited'])){
        wp_enqueue_script( 'ns-ctbc-js-custom', NS_CTBC_PLUGIN_DIR_URL. '/ASSETS/JS/ns-coupon-to-become-customer-modal.js', array(), '1.0.0', true );
        wp_localize_script( 'ns-ctbc-js-custom', 'nssendcoupon', array( 'ajax_url' => admin_url( 'admin-ajax.php' )));
    }
}
add_action( 'wp_enqueue_scripts', 'ns_ctbc_js' );


/*========================================================*/
//  MAIN function: if user not logged in: show modal and,
//  by action, in cart page only			          
/*========================================================*/
function ns_coupon_to_become_customer_main(){

    if(!is_user_logged_in()){
        if(!isset($_COOKIE['visited'])){
            $expire = strtotime('+ 24 hours');//TODO
            require_once(NS_CTBC_PLUGIN_DIR.'/ns-coupon-to-become-customer-modal.php');
            echo '<script>document.cookie = "visited=true; expires='.gmdate(DATE_RFC822, $expire).'";</script>';
        }
    }
}
// add_action( 'wp_loaded', 'ns_coupon_to_become_customer_main');
add_action( 'woocommerce_before_cart', 'ns_coupon_to_become_customer_main');



/*========================================================*/
//                  INCLUDE text domain			          
/*========================================================*/
function ns_ctbc_translate(){

    load_plugin_textdomain('ns-coupon-to-become-customer',false, basename( dirname( __FILE__ ) ) .'/i18n/');
}
add_action('plugins_loaded','ns_ctbc_translate');

/*========================================================*/
//                  ADD link premium			          
/*========================================================*/
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'ns_coupontobecomecustomer_add_action_links' );

function ns_coupontobecomecustomer_add_action_links ( $links ) {	//TODO change link!
 $mylinks = array('<a id="nsraclinkpremium" href="https://www.nsthemes.com/product/coupon-to-become-customer/?ref-ns=2&campaign=CTBC-linkpremium" target="_blank">'.__( 'Premium Version', 'ns-coupon-to-become-customer' ).'</a>');
return array_merge( $links, $mylinks );
}


/*========================================================*/
//  AJAX function: if is all right send mail with coupon          
/*========================================================*/
add_action( 'wp_ajax_nopriv_ns_wc_send_coupon', 'ns_wc_send_coupon' );
add_action( 'wp_ajax_ns_wc_send_coupon', 'ns_wc_send_coupon' );
function ns_wc_send_coupon(){
	$ns_resp = '';
    //check if mail is checked
	if(!isset($_POST['ns_mail_sender_mail']) || $_POST['ns_mail_sender_mail']=='' ){ 
        echo "error&mail";
        die();
    } 
    //check, if admin want, if privacy policy is checked
    if(get_option('ns-ctbc-enable-privacy-policy')=='on'){
        if(!isset($_POST['ns_terms_and_conditions']) || $_POST['ns_terms_and_conditions']!='accept'){ 
            echo "error&terms";
            die();
        } 
    }
   
    //receiver
    $ns_send_to = sanitize_text_field($_POST['ns_mail_sender_mail']);
    
    $ns_response = "done";
    
    $ns_mail_coupon = get_option('ns-ctbc-coupon-name');
    $ns_mail_name = get_bloginfo();
    
    $user_id = username_exists( $ns_send_to );
    if ( !$user_id and email_exists($ns_send_to) == false ) {
        $random_password = wp_generate_password( $length=12, $include_standard_special_chars=false );
        $user_id = wp_create_user( $ns_send_to, $random_password, $ns_send_to ); 
        $headers = array('Content-Type: text/html; charset=UTF-8');

        //change mail options
        add_filter( 'wp_mail_from_name', function() {return  get_bloginfo();});
        add_filter( 'wp_mail_from', function() {return get_option('admin_email');});
        if(!wp_mail($ns_send_to, 'Your coupon is here', ns_send_mail_ctbc( $ns_mail_coupon, $ns_mail_name), $headers ))
            $ns_response = "error";
        wp_new_user_notification($user_id, null, 'both');
        //reset mail options
        remove_filter( 'wp_mail_from_name', function() {return  get_bloginfo();});
        remove_filter( 'wp_mail_from', function() {return get_option('admin_email');});

    }else
        $ns_response = "error&registration";
    
	echo $ns_response;
	
    die();
}

?>