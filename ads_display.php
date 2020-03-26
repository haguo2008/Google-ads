<?php
defined( 'ABSPATH' ) or die( 'No script kiddies please' );
/**
 * Plugin Name: ads display
 * Description: 点击后广告自定义cookie记录隐藏时间。
 */

define( 'ADS_VERSION','2.0' );
define( 'ADS_CSS_DIR', plugin_dir_url( __FILE__ ) . 'css' );
define( 'ADS_JS_DIR', plugin_dir_url( __FILE__ ) . 'js' );
if( !defined( 'ADS_DIR' ) ) {
	define( 'ADS_DIR', dirname( __FILE__ ) ); // Plugin dir
}
if ( !class_exists( 'ADS_Enqueue' ) ) {
    class ADS_Enqueue {

        function __construct() {
			
            add_action( 'wp_enqueue_scripts', array( $this, 'register_ads_assets' ) );
			add_action( 'admin_head', array( $this, 'admin_scripts' ) );
			
    }
		
		function admin_scripts() {
        ?>
        <script></script>
        <style type="text/css"></style>
        <?php
    }
        function register_ads_assets() {
            wp_enqueue_style( 'ADS-CSS', ADS_CSS_DIR . '/ads.css', array(), ADS_VERSION );
            wp_enqueue_script( 'ADS-JS', ADS_JS_DIR . '/ads.js', array( 'jquery' ), ADS_VERSION );
            $ajax_nonce = wp_create_nonce( 'ads-ajax-nonce' );
            $js_object = array( 'admin_ajax_url' => admin_url( 'admin-ajax.php' ), 'admin_ajax_nonce' => $ajax_nonce );
            wp_localize_script( 'ADS-JS', 'ads_js_object', $js_object );
        }
    }
    new ADS_Enqueue();
}
require ADS_DIR .'/includes/admin/admin.php';
// Functions file
require_once( ADS_DIR . '/includes/functions.php' );
