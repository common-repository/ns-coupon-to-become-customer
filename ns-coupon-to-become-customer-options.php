<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function ns_ctbc_options()
{
	//COMMENTS
	add_option('ns-ctbc-enable-privacy-policy', '');
	add_option('ns-ctbc-coupon-name', '');
	add_option('ns-ctbc-popup-title', '');
	add_option('ns-ctbc-popup-subtitle', '');
	add_option('ns-ctbc-popup-privacy-policy', '');

}

register_activation_hook( __FILE__, 'ns_ctbc_options');

function ns_ctbc_register_options_group(){
	/*Field options*/

	//COMMENTS
	register_setting('ns_ctbc_options_group', 'ns-ctbc-enable-privacy-policy'); 
	register_setting('ns_ctbc_options_group', 'ns-ctbc-coupon-name'); 
	register_setting('ns_ctbc_options_group', 'ns-ctbc-popup-title'); 
	register_setting('ns_ctbc_options_group', 'ns-ctbc-popup-subtitle');
	register_setting('ns_ctbc_options_group', 'ns-ctbc-popup-privacy-policy');

}

add_action ('admin_init', 'ns_ctbc_register_options_group');

?>