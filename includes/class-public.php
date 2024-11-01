<?php
if(!defined("WSSS_VERSION")) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}

class WSSS_Public {
	
	public function __construct() {
		add_filter( 'the_content', array( $this, 'add_links_after_content' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_assets' ), 99 );
		add_shortcode( 'wanapost-several-social-sharing',array($this,'wanapost-several-social-sharing'));
	}
	
	public function add_links_after_content( $content ){
		$opts = wsss_get_options();
		$show_buttons = false;
		
		if( ! empty( $opts['auto_add_post_types'] ) && in_array( get_post_type(), $opts['auto_add_post_types'] ) && is_singular( $opts['auto_add_post_types'] ) ) {
			$show_buttons = true;
		}
			
		$show_buttons = apply_filters( 'wsss_display', $show_buttons );
		if( ! $show_buttons ) {
			return $content;
		}
		$opts['icon_order']=get_option('wanapost-several-social-sharing');
		
		if($opts['social_icon_position'] == 'before' ){
			return $this->wanapost_several_social_sharing($opts).$content;
		}
		else{
			return $content . $this->wanapost_several_social_sharing($opts);			
		}
	}
	
	public function load_assets() 
	{
		$opts = wsss_get_options();
		wp_enqueue_style( 'wanapost-several-social-sharing', WSSS_PLUGIN_URL . 'static/social_share.css', array(), WSSS_VERSION );
		foreach ($opts['load_static'] as $static){
			/*
			if($static == 'load_css'){
				wp_enqueue_style( 'wanapost-several-social-sharing', WSSS_PLUGIN_URL . 'static/social_share.css', array(), WSSS_VERSION );
			}	
			*/
			if($static == 'load_js'){
				wp_enqueue_script( 'wanapost-several-social-sharing', WSSS_PLUGIN_URL . 'static/socialshare.js', array(), WSSS_VERSION, true );				
			}		
		}
	}

	public function wanapost_several_social_sharing( $atts=array() ) {
		$socials = array('Wanapost','Facebook','Twitter','Google Plus','Linkedin','Pinterest','Stumbleupon','Tumblr','Vkontakte','Reddit','Viadeo','Digg','Delicious','Evernote','Yummly','Email','Yahoo! Mail','Gmail','Outlook','WhatsApp','Viber','Xing');
		$icons = array('w','f','t','g','l','p','s','u','v','r','i','d','c','n','y','e','h','m','o','a','b','x');
		foreach($socials as $social){
			$small_social = strtolower(str_replace(array(' ','!'),'',$social));
		//	extract(shortcode_atts(array("{$small_social}_text" => __( "Share on {$social}", 'social-sharing' )),$atts));
		}
		extract(shortcode_atts(array(
				'wanapost_several_social_options' => 'wanapost,facebook,twitter,googleplus',
				'twitter_username' => 'wanapostcom',
				'icon_order'=>'w,f,t,g,l,p,x',
				'social_image'=> '', 
				'show_icons'=>'1',
				'before_button_text'=>'',
				'text_position'=> 'top'
		),$atts));

		if(!is_array($wanapost_several_social_options))
			$wanapost_several_social_options = array_filter( array_map( 'trim', explode( ',',$wanapost_several_social_options ) ) );
		
		remove_filter('the_title','wptexturize');
		
		$title = urlencode(html_entity_decode(get_the_title()));
		add_filter('the_title','wptexturize');
		
		$url = urlencode( get_permalink() );
	
		$loadjs='';
		
		$thumb = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'medium' );
		$thumb_url = $thumb['0'];
		if($thumb_url == ''){
			if(isset($atts['pinterest_image']) && $atts['pinterest_image'] == ''){
				if($atts['pinterest_blank_image'])
				$thumb_url = WSSS_PLUGIN_URL.'static/blank.jpg';	
				else			
				$thumb_url = 'http://www.apercite.fr/api/apercite/800x600/oui/oui/'.get_home_url().'?p='.get_the_ID();								
			}
			else{
				$thumb_url = $atts['pinterest_image'];	
			}
		}
		if($social_image == ''){
			$social_image = $thumb_url;
		}
		$social_image = urlencode($social_image);
		
		$opts=wsss_get_options();
		foreach ($opts['load_static'] as $static){
		    if($static == 'load_js'){
		       $loadjs='onclick="return wsss_plugin_loadpopup_js(this);"';
		    }
		}
		
		$wssssocial_sharing='';
		foreach($socials as $social){
			$small_social = strtolower(str_replace(array(' ','!'),'',$social));
			$wssssocials["wsssbutton_{$small_social}"] = "button-{$social}";
			$wssssocials["wsss_button_{$small_social}"] = "{$small_social}-icon";
			$social_text["{$small_social}_text"] = __( "Share on {$social}", 'social-sharing' );
		}
		if($show_icons){
			$wssssocial_sharing='wss-social-sharing';
			foreach($socials as $social){
				$small_social = strtolower(str_replace(array(' ','!'),'',$social));
				$wssssocials["wsssbutton_{$small_social}"] = "wss-button-{$small_social}";
				$wssssocials["wsss_button_{$small_social}"] = "{$small_social}-icon";
				$social_text["{$small_social}_text"] = __( "Share on {$social}", 'social-sharing' );
				$social_text["{$small_social}_icon"] = $small_social;
			}
		}
		
		$s_orders=get_option('wanapost-several-social-sharing');
		$s_order = $sorders['wanapost_several_social_options'];
		if($s_order){
			if(is_array($s_order))
			foreach ($s_order as $order => $value){
				$s_order .= $order.',';
			}
	    }
		foreach($icons as $icon){
			$s_order .= $icon.',';
		}
		if(empty($s_order)) $s_order= 'w,f,t,g,l,p,s,u,v,r,i,d,c,n,y,e,h,m,o,a,b,x';
		$icon_order=explode(',',$s_order);
		ob_start();
		?>
		<div class="social-sharing <?php echo $wssssocial_sharing;?>">
			<?php if(!empty($before_button_text) && ($text_position == 'left' || $text_position == 'top')):?>
			<span class="<?php echo $text_position;?> before-sharebutton-text"><?php echo $before_button_text; ?></span>
	        <?php endif;?>
			<div class="social-share-container">
				<div class="social-share-content">
					<div class="share-icon-container"><div class="share-icon-padding">
					<a <?php echo $loadjs;?> href="http://www.wanapost.com/share.php?text=<?php echo $title; ?>&url=<?php echo $url; ?>" target="_blank" title="<?php echo $social_text['wanapost_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['wanapost_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div>
			<?php
	        foreach($icon_order as $o) {
	        	switch($o) {
	        		case 'f':
	        			if(in_array('facebook', $wanapost_several_social_options)){
	        			?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" title="<?php echo $social_text['facebook_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> background_icon_size<?php echo $atts['background_icon_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['facebook_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
	        		break;
	        		case 't':
	        			if(in_array('twitter', $wanapost_several_social_options)){
	        			?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://twitter.com/intent/tweet/?text=<?php echo $title; ?>&url=<?php echo $url; ?><?php if(!empty($twitter_username)) {  echo '&via=' . $twitter_username; } ?>" target="_blank" title="<?php echo $social_text['twitter_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['twitter_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
	        		break;
	        		case 'g':
	        			if(in_array('googleplus', $wanapost_several_social_options)){
	        			?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://plus.google.com/share?url=<?php echo $url; ?>" target="_blank" title="<?php echo $social_text['googleplus_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['googleplus_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
	        		break;
					case 'l':
						if(in_array('linkedin', $wanapost_several_social_options)){
							?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo substr($url,0,1024);?>&title=<?php echo substr($title,0,200);?>" target="_blank" title="<?php echo $social_text['linkedin_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['linkedin_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
						}
	        		break;
	        		case 'p':
	        			if(in_array('pinterest', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://pinterest.com/pin/create/button/?url=<?php echo $url;?>&media=<?php echo $social_image;?>&description=<?php echo $title;?>" target="_blank" title="<?php echo $social_text['pinterest_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['pinterest_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 's':
	        			if(in_array('stumbleupon', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://www.stumbleupon.com/badge?url=<?php echo $url;?>&text=<?php echo $title;?>" target="_blank" title="<?php echo $social_text['stumbleupon_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['stumbleupon_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'u':
	        			if(in_array('tumblr', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://www.tumblr.com/widgets/share/tool?canonicalUrl=<?php echo $url;?>" target="_blank" title="<?php echo $social_text['tumblr_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['tumblr_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'v':
	        			if(in_array('vkontakte', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://vkontakte.ru/share.php?url=<?php echo $url;?>&image=<?php echo $social_image;?>&description=<?php echo $title;?>" target="_blank" title="<?php echo $social_text['vkontakte_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['vkontakte_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'r':
	        			if(in_array('reddit', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://pinterest.com/pin/create/button/?url=<?php echo $url;?>&media=<?php echo $social_image;?>&description=<?php echo $title;?>" target="_blank" title="<?php echo $social_text['reddit_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['reddit_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'i':
	        			if(in_array('viadeo', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://www.viadeo.com/shareit/share/?url=<?php echo $url;?>&title=<?php echo $title;?>" target="_blank" title="<?php echo $social_text['viadeo_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['viadeo_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'd':
	        			if(in_array('digg', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://digg.com/submit?phase=&url=<?php echo $url;?>" target="_blank" title="<?php echo $social_text['digg_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['digg_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'c':
	        			if(in_array('delicious', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://delicious.com/save?v=5&noui&jump=close&url=<?php echo $url;?>" target="_blank" title="<?php echo $social_text['delicious_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['delicious_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'n':
	        			if(in_array('evernote', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://www.evernote.com/clip.action?url=<?php echo $url;?>" target="_blank" title="<?php echo $social_text['evernote_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['evernote_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'y':
	        			if(in_array('yummly', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://www.yummly.com/urb/verify?url=<?php echo $url;?>&image=<?php echo $social_image;?>&title=<?php echo $title;?>&yumtype=button" target="_blank" title="<?php echo $social_text['yummly_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['yummly_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'e':
	        			if(in_array('email', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="mailto:?subject=<?php echo $title;?>&body=<?php echo $title.' - '.$url;?>" target="_blank" title="<?php echo $social_text['email_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['email_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'h':
	        			if(in_array('yahoomail', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="http://compose.mail.yahoo.com/?subject=<?php echo $title;?>&body=<?php echo $title.' - '.$url;?>" target="_blank" title="<?php echo $social_text['yahoomail_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['yahoomail_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'm':
	        			if(in_array('gmail', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://mail.google.com/mail/u/0/?view=cm&fs=1&su=<?php echo $title;?>&body=<?php echo $title.' - '.$url;?>" target="_blank" title="<?php echo $social_text['gmail_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['gmail_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'o':
	        			if(in_array('outlook', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://outlook.live.com/owa/?path=/mail/action/compose&to=&subject=<?php echo $title;?>&body=<?php echo $title.' - '.$url;?>" target="_blank" title="<?php echo $social_text['outlook_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['outlook_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'a':
	        			if(in_array('whatsapp', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="whatsapp://send?text=<?php echo $title;?>&body=<?php echo $title.' - '.$url;?>" target="_blank" title="<?php echo $social_text['whatsapp_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['whatsapp_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
					case 'b':
	        			if(in_array('viber', $wanapost_several_social_options)){
	        				?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="viber://forward?text=<?php echo $title;?>&body=<?php echo $title.' - '.$url;?>" target="_blank" title="<?php echo $social_text['viber_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['viber_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
	        			}
					break;
                    case 'x':
                        if(in_array('xing', $wanapost_several_social_options)){
                    	    ?><div class="share-icon-container"><div class="share-icon-padding">
					<a rel="external nofollow" <?php echo $loadjs;?> href="https://www.xing.com/spi/shares/new?url=<?php echo $url;?>" target="_blank" title="<?php echo $social_text['xing_text']; ?>"><div class="background_icon_size<?php echo $atts['background_icon_size']; ?> share-social-color<?php echo $atts['background_color_size']; ?> <?php echo str_replace(array(' ','!'),'',strtolower($social_text['xing_icon'])); ?>-icon" style="border-radius:<?php echo $atts['background_border_radius']; ?>px;"></div></a>
					</div></div><?php
                        }
	        		break;
	        	}
	        } ?>
			</div>
			</div>
	        <?php if(!empty($before_button_text) && ($text_position == 'bottom' || $text_position == 'right')):?>
			<span class="<?php echo $text_position;?>  before-sharebutton-text"><?php echo $before_button_text; ?></span>
	        <?php endif;?>
	    </div>
	    <?php
	  	$output = ob_get_contents();
		ob_end_clean();
		return $output;
	}
}
?>