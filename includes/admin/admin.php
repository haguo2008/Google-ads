<?php
class google_ads_admin {
  
	static public $instance;
  
	public $product_anti_code_obj;
  
	public $options;
  
	private function __construct(){
		$this->options = get_option( 'google_ads_options' );
		add_filter( 'set-screen-option', array( $this, 'set_screen' ), 10, 3 );
		add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', array( $this, 'google_ads_menu') );
		add_action( 'admin_init', array( $this, 'google_ads_options_settings_init' ) );
	}
  
	private function __clone() {}
  
	function google_ads_menu() {
		add_menu_page( 'Google ads', 'Ads Cookie', 'manage_options', 'google_ads_options', array(&$this, 'google_ads_options'),'dashicons-admin-network',80);
	}
  
	function google_ads_options_settings_init() {
		register_setting( 'Googleadscookie', 'google_ads_options' );
		add_settings_section(
			'google_ads_plugin_section',
			__( 'Google Ads 配置详情', 'google-ads' ),
			array($this, 'google_ads_description_callback'),
			'Googleadscookie'
		);

		add_settings_field(
			'ads_cookie',
			__( '设置 Google Ads Cookie 时间', 'google-ads' ),
			array($this, 'google_ads_section'),
			'Googleadscookie',
			'google_ads_plugin_section'
		);
	
	}
	
		function google_ads_section() {
		echo '<input class="google-ads" type="text" name="google_ads_options[ads_cookie]" value="'.$this->options['ads_cookie'].'">';
		echo '<p class="description">请填写数字单位是 ( 天 )。</p>';
	}
	
	function google_ads_description_callback() {
		echo __( 'cookie时效设置', 'google-ads' );
	}
	
	  function set_screen( $status, $option, $value ) {
		return $value; 
	}
	
	function google_ads_options(){
		include_once( ADS_DIR .'/includes/admin/ads-settings-options.php');		
	}
  
	public static function get_instance() {
		if ( ! isset( self::$instance ) ) {
		self::$instance = new self();
    }
		return self::$instance;
	}
}

add_action( 'plugins_loaded', function () {
	google_ads_admin::get_instance();
} );