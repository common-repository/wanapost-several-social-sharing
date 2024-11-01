<?php
/*
Plugin Name: WanaPost Several Social Sharing
Version: 1.0
Plugin URI: http://wordpress.org/plugins/wanapost-several-social-sharing/
Description: Adds very attractive responsive social sharing buttons of WanaPost, Facebook, Twitter, Google+ , Linkedin, Pinterest, Stumbleupon, Viadeo, Digg, Deliciuos, Evernote, Yummly, Email (mailto), Yahoo! Mail, Gmail, Outlook (Hotmail), Whatsapp, Viberand Xing to wordpress posts, pages or media. 
Author: Mohammed Belaadel
Author URI: http://www.belaadel.com/
Demo URI: http://www.wanapost.com/@belaadel
Contributors: arjunjain08, belaadel, lyscreation
Text Domain: wanapost-several-social-sharing
License: GPL v3
Wordpress version supported: 3.5 and above
Tags: wanapost share, wanapost autopost, wanapost auto ping, responsive social buttons, responsive social sharing buttons, responsive button, social buttons, social sharing, sharing buttons, twitter share, xing share, googleplus share, facebook share, linkedin share, pinterest share, share button for custom post type
*/

if ( ! defined( 'ABSPATH' )) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
define('AUTOSAVE_INTERVAL',100);
if (!defined( 'WP_POST_REVISIONS'))
define('WP_POST_REVISIONS',false);
if (!defined( 'AUTOSAVE_INTERVAL'))
define('AUTOSAVE_INTERVAL',900);
define( "WSSS_VERSION", "1.0" );  // db versioin
define( "WSSS_PLUGIN_DIR", plugin_dir_path( __FILE__ ) ); 
define( "WSSS_PLUGIN_URL", plugins_url( '/' , __FILE__ ) );
// Create Text Domain For Translations
load_plugin_textdomain('wanapost-several-social-sharing', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');

require_once WSSS_PLUGIN_DIR . 'includes/plugin.php';

if( ! is_admin() ) {
	require_once WSSS_PLUGIN_DIR . 'includes/class-public.php';
	new WSSS_Public();
} elseif( ! defined("DOING_AJAX") || ! DOING_AJAX ) {
	require WSSS_PLUGIN_DIR . 'includes/class-admin.php';
	new WSSS_Admin();
}

register_activation_hook(__FILE__, array('WSSS_Admin','wsss_plugin_activation_action'));
?>