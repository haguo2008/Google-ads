<?php
function ads_get_ip() {
	if ( isset( $_SERVER['HTTP_CLIENT_IP'] ) && ! empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif ( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) && ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = ( isset( $_SERVER['REMOTE_ADDR'] ) ) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
	}
	$ip = filter_var( $ip, FILTER_VALIDATE_IP );
	$ip = ( $ip === false ) ? '0.0.0.0' : $ip;
	return $ip;
}

function ads_plugin_body_class($classes) {
	$hideads   = isset($_COOKIE['site_ads']) ? ' ads-hide' : ' ads-display';
    $classes[] = $hideads;
    return $classes;
}
add_filter('body_class', 'ads_plugin_body_class');

function set_newuser_cookie() {
	$time = get_option( 'google_ads_options' );
	$a = (int)$time['ads_cookie'];
	$ip = $a * 86400;
	$domain = ($_SERVER['HTTP_HOST'] != 'localhost') ? $_SERVER['HTTP_HOST'] : false;
    if (!isset($_COOKIE['site_ads'])) { 
        //setcookie('site_ads', 1, ip2long(ads_get_ip()).time(), '/', $domain, false); 
		setcookie('site_ads', 1, time() + $ip, '/', $domain, false); 
    } 
}

add_action( 'wp_ajax_ads_ajax_action', 'click_ads_ajax_action' );
add_action( 'wp_ajax_nopriv_ads_ajax_action', 'click_ads_ajax_action' );
function click_ads_ajax_action() {
	if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( $_POST['_wpnonce'], 'ads-ajax-nonce' ) ) {
    set_newuser_cookie();       
    die();
  } else {
    die( '机器人! 滚！！！' );
  }
}