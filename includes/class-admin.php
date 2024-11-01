<?php
if( ! defined("WSSS_VERSION") ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class WSSS_Admin {

	private $code_version = 1;
	
	public function __construct() {

		add_action( 'admin_init', array( $this, 'register_settings' ) );
		add_action( 'admin_menu', array( $this, 'add_menu_item' ) );
		
		add_filter( "plugin_action_links_wanapost-several-social-sharing/index.php", array( $this, 'add_settings_link' ) );

		if ( isset( $_GET['page'] ) && $_GET['page'] === 'wanapost-several-social-sharing' ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_css' ) );
		}
	}
	
	function wsss_plugin_activation_action(){
		$defaults = array(
				'twitter_username' => "",
				'auto_add_post_types' => array( 'post' ),
				'wanapost_several_social_options'=>array('wanapost','facebook','twitter','googleplus','linkedin','pinterest','xing'),
				'social_icon_position'=>'after',
				'load_static'=>array('load_css','load_js'),
				'background_icon_size'=>'16',
				'background_color_size'=>'32',
				'pinterest_image'=>"",
				'pinterest_blank_image'=>'1',
				'show_icons'=>'1',
				'before_button_text'=>'',
				'text_position'=>'left'
		);
		update_option( 'wanapost-several-social-sharing', $defaults );
		update_option( 'wanapost-several-social-sharing','w,f,t,g,l,p,x');
		update_option( 'wanapost-several-social-sharing_pluign_version ',WSSS_VERSION);
	}
	
	public function load_css() {
		wp_enqueue_style ( 'wanapost-several-social-sharing', WSSS_PLUGIN_URL . 'static/admin-styles.css' );
		wp_enqueue_media();
		wp_enqueue_script( 'wanapost-several-social-sharing', WSSS_PLUGIN_URL . 'static/socialshareadmin.js', array(), WSSS_VERSION, true );
	}

	public function register_settings() {
		register_setting( 'wanapost-several-social-sharing', 'wanapost-several-social-sharing', array($this, 'sanitize_settings') );
	}

	public function sanitize_settings( $settings ) {
		$settings['before_button_text'] = trim( strip_tags( $settings['before_button_text'] ) );
		$settings['auto_add_post_types'] = ( isset( $settings['auto_add_post_types'] ) ) ? $settings['auto_add_post_types'] : array();
		$settings['show_sharebutton'] = ( isset( $settings['show_sharebutton'] ) ) ? $settings['show_sharebutton'] : array();
		return $settings;
	}

	public function add_settings_link( $links ) {
		$settings_link = '<a href="options-general.php?page=wanapost-several-social-sharing">'. __('Settings') . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	public function add_menu_item() {
		add_options_page( 'Wanapost SeveralSocial Sharing', 'Wanapost SeveralSocial Sharing', 'manage_options', 'wanapost-several-social-sharing', array( $this, 'show_settings_page' ) );
	}

	public function show_settings_page() {
		$opts = wsss_get_options();
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		include WSSS_PLUGIN_DIR . 'includes/settings-page.php';
	}
}
function Wanapost_Ping($ID, $post) {  
	 $opts = wsss_get_options();
	 $ping = 'http://www.wanapost.com/ping.php';
	 $data = array(
		'username' =>  esc_attr($opts['wanapost_username']),
		'public_key' => esc_attr($opts['wanapost_public_key']),
		'private_key' => esc_attr($opts['wanapost_private_key']),
		'url' => get_permalink( $ID ),
		'text' => $post->post_title,
	 );
	 // use key 'http' even if you send the request to https://...
	 $options = array(
		'http' => array(
		   'header' => "Content-type: application/x-www-form-urlencoded\r\n",
		   'method' => 'POST',
		   'content' => http_build_query($data)
		)
	 );
	 $context = stream_context_create($options);
	 $result = file_get_contents($ping, false, $context);
	 if (($result === FALSE) || ($result == FALSE)) { /*echo 'No';*/ }
	 if (($result === TRUE) || ($result == TRUE)) { /*echo 'Yes';*/ }
	 //var_dump($result);
} 
// Ping published post and page to Wanapost.com 
add_action('publish_post', 'Wanapost_Ping', 10, 2);
add_action('publish_page', 'Wanapost_Ping', 10, 2); 
?>