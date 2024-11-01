<?php
if( ! defined("WSSS_VERSION") ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

function wsss_get_options(){	
	static $options;

	if( ! $options ) {
		$defaults = array(
			'twitter_username' => "",
			'auto_add_post_types' => array( 'post' ),
			'wanapost_several_social_options'=>array('wanapost','facebook','twitter','googleplus','linkedin','pinterest','xing'),
			'load_static'=>array('load_css','load_js'),
			'pinterest_image'=>"",
			'before_button_text'=>'',
			'text_position' => 'left'
		);

		$db_option = get_option( 'wanapost-several-social-sharing', array());
		if(!isset($db_option['load_static'])){
			$db_option['load_static']=array();
		}
		if(!isset($db_option['wanapost_several_social_options'])){
			$db_option['wanapost_several_social_options']=array();
		}
		if(!isset($db_option['auto_add_post_types'])){
			$db_option['auto_add_post_types']=array();
		}
	
		if( ! $db_option ) {
			update_option( 'wanapost-several-social-sharing', $defaults );
		}
		
		$options = wp_parse_args( $db_option, $defaults );
	}
	return $options;
}
?>