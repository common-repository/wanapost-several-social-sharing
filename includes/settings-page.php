<?php 
if( ! defined("WSSS_VERSION") ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit;
}
?>
<div id="ss" class="wrap">
	<div class="wss-container">
		<div class="wss-column wss-primary">
			<h2>Wanapost SeveralSocial Sharing</h2>
			<form id="wsss_settings" method="post" action="options.php">
			<?php settings_fields( 'wanapost-several-social-sharing' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Social share button','wanapost-several-social-sharing');?></label>
					</th>
					<td>
						<input type="checkbox" id="wanapost_share" name="wanapost-several-social-sharing[wanapost_several_social_options][]" value="wanapost" <?php checked( in_array( 'wanapost', $opts['wanapost_several_social_options'] ), true ); ?> checked="checked" onclick="return false" disabled="disabled" readonly/><label for="wanapost_share"><?php echo _e('Wanapost','wanapost-several-social-sharing')?></label><br />
						<?php
						$socials = array('Facebook','Twitter','Google Plus','Linkedin','Pinterest','Stumbleupon','Tumblr','Vkontakte','Reddit','Viadeo','Digg','Delicious','Evernote','Yummly','Email','Yahoo! Mail','Gmail','Outlook','WhatsApp','Viber','Xing');
						foreach($socials as $social){
						?>
						<input type="checkbox" id="<?php echo strtolower(str_replace(array(' ','!'),'',$social))?>_share" name="wanapost-several-social-sharing[wanapost_several_social_options][]" value="<?php echo strtolower(str_replace(array(' ','!'),'',$social))?>" <?php checked( in_array( strtolower(str_replace(array(' ','!'),'',$social)), $opts['wanapost_several_social_options'] ), true ); ?> /><label for="<?php echo strtolower(str_replace(array(' ','!'),'',$social))?>_share"><?php echo $social?></label><br />
						<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<th><label for="social_icon_position"><?php _e('Social Icon Position','wanapost-several-social-sharing');?></label></th>
					<td>
						<select name="wanapost-several-social-sharing[social_icon_position]">
							<option value="before" <?php if($opts['social_icon_position'] == 'before') echo "selected='selected'"?>><?php _e('Before Content','wanapost-several-social-sharing');?></option>
							<option value="after" <?php if($opts['social_icon_position'] == 'after') echo "selected='selected'"?>><?php _e('After Content','wanapost-several-social-sharing');?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th><label for="before_button_text"><?php _e('Text before Sharing buttons','wanapost-several-social-sharing');?></label></th>
					<td>
						<input type="text" class="widefat" name="wanapost-several-social-sharing[before_button_text]" id="before_button_text" value="<?php echo esc_attr($opts['before_button_text']); ?>" /> 
					</td>
				</tr>
				<tr valign="top">
					<th><label for="before_button_text"><?php _e('Text Position','wanapost-several-social-sharing');?></label></th>
					<td>
						<select name="wanapost-several-social-sharing[text_position]">
							<option value="left" <?php if($opts['text_position'] == 'left') echo "selected='selected'"?>><?php _e('Left','wanapost-several-social-sharing');?></option>
							<option value="right" <?php if($opts['text_position'] == 'right') echo "selected='selected'"?>><?php _e('Right','wanapost-several-social-sharing');?></option>
							<option value="top" <?php if($opts['text_position'] == 'top') echo "selected='selected'"?>><?php _e('Top','wanapost-several-social-sharing');?></option>
							<option value="bottom" <?php if($opts['text_position'] == 'bottom') echo "selected='selected'"?>><?php _e('Bottom','wanapost-several-social-sharing');?></option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th><label for="pinterest_image"><?php _e('Default share image','wanapost-several-social-sharing')?></label></th>
					<td>
						<input type="text" name="wanapost-several-social-sharing[pinterest_image]" id="pinterest_image"  value="<?php echo esc_attr($opts['pinterest_image']); ?>"/><input type="button" class="set_custom_images button" id="set_custom_images" value="<?php _e('Upload','wanapost-several-social-sharing')?>" />
						<input type="button" class="button" id="remove_custom_images" value="<?php _e('Remove','wanapost-several-social-sharing')?>" />
						<br /><small><?php _e('Required for Pinterest', 'wanapost-several-social-sharing'); ?></small>
						<div id="set_custom_image_src"><?php if($opts['pinterest_image'] != ''): ?><img src="<?php echo $opts['pinterest_image'];?>" width="100px" /> <?php endif;?></div>
						<label for="pinterest_blank_image"><?php _e('Default Blank share image','wanapost-several-social-sharing')?></label>
						<br />
						<select name="wanapost-several-social-sharing[pinterest_blank_image]">
							<option value="0" <?php if($opts['pinterest_blank_image'] == '0') echo "selected='selected'"?>><?php _e('Default Blank share image','wanapost-several-social-sharing')?></option>
							<option value="1" <?php if($opts['pinterest_blank_image'] == '1') echo "selected='selected'"?>><?php _e('Remote generated image','wanapost-several-social-sharing')?></option>
						</select>
						<br /><small><?php _e('Use a generated image for Pinterest if blank image is used', 'wanapost-several-social-sharing'); ?></small>
					</td>
				</tr>
				<tr valign="top">
					<th><label for="background_icon_size"><?php _e('Default Background Sizes','wanapost-several-social-sharing')?></label></th>
					<td>
						<label for="background_icon_size"><?php _e('Default Background icon Size','wanapost-several-social-sharing')?></label>
						<br />
						<select name="wanapost-several-social-sharing[background_icon_size]">
							<option value="8" <?php if($opts['background_icon_size'] == '8') echo "selected='selected'"?>>8px</option>
							<option value="16" <?php if($opts['background_icon_size'] == '16') echo "selected='selected'"?>>16px</option>
							<option value="24" <?php if($opts['background_icon_size'] == '24') echo "selected='selected'"?>>24px</option>
							<option value="32" <?php if($opts['background_icon_size'] == '32') echo "selected='selected'"?>>32px</option>
						</select>
						<br />
						<label for="background_icon_size"><?php _e('Default Background color Size','wanapost-several-social-sharing')?></label>
						<br />
						<select name="wanapost-several-social-sharing[background_color_size]">
							<option value="16" <?php if($opts['background_color_size'] == '16') echo "selected='selected'"?>>16px</option>
							<option value="24" <?php if($opts['background_color_size'] == '24') echo "selected='selected'"?>>24px</option>
							<option value="32" <?php if($opts['background_color_size'] == '32') echo "selected='selected'"?>>32px</option>
							<option value="48" <?php if($opts['background_color_size'] == '48') echo "selected='selected'"?>>48px</option>
							<option value="64" <?php if($opts['background_color_size'] == '64') echo "selected='selected'"?>>64px</option>
						</select>
					</td>
				</tr>
				<tr valign="top">
					<th><label for="background_icon_size"><?php _e('Default Background Border radius','wanapost-several-social-sharing')?></label></th>
					<td>
						<select name="wanapost-several-social-sharing[background_border_radius]">
							<?php for($i=0; $i<=100; $i++){ ?>
							<option value="<?php echo $i; ?>" <?php if($opts['background_border_radius'] == $i) echo "selected='selected'"?>><?php echo $i; ?>px</option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><label><?php _e('Load plugin scripts','wanapost-several-social-sharing');?></label></th>
					<td>
						<input type="hidden" name="wanapost-several-social-sharing[load_static][]" id="load_icon_css" value="load_css" <?php checked( in_array( 'load_css', $opts['load_static'] ), true ); ?> checked="checked" onclick="return false" disabled="disabled" readonly><label for="load_icon_css" style="visibility:hidden; width:0px; display:none"><?php _e('Load Share button CSS','wanapost-several-social-sharing');?></label>
						<input type="checkbox" name="wanapost-several-social-sharing[load_static][]" id="load_popup_js" value="load_js"  <?php checked( in_array( 'load_js', $opts['load_static'] ), true ); ?>><label for="load_popup_js"><?php _e('Use Popup to share links','wanapost-several-social-sharing') ?></label>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<label><?php _e('Automatically add sharing links?', 'wanapost-several-social-sharing'); ?></label>
					</th>
					<td>
						<ul>
						<?php foreach( $post_types as $post_type_id => $post_type ) { ?>
							<li>
								<label>
									<input type="checkbox" name="wanapost-several-social-sharing[auto_add_post_types][]" value="<?php echo esc_attr( $post_type_id ); ?>" <?php checked( in_array( $post_type_id, $opts['auto_add_post_types'] ), true ); ?>> <?php printf( __(' Auto display to %s', 'wanapost-several-social-sharing' ), $post_type->labels->name ); ?>
								</label>
							</li>
						<?php } ?>
						</ul>
						<small><?php _e('Automatically add the sharing links to the begining/end of the selected post types.', 'wanapost-several-social-sharing'); ?></small>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="wsss_wanapost_username"><?php _e('Wanapost Username', 'wanapost-several-social-sharing'); ?></label>
					</th>
					<td>
						<ul>
							<li style="line-height: 15px !important;">
								<label>
									<a href="http://www.wanapost.com" target="_blank" title="<?php _e('New window', 'wanapost-several-social-sharing'); ?>">
										<b><?php _e('New account? Free registration to autopost on Wanapost.com', 'wanapost-several-social-sharing'); ?></b>
									</a>
								</label>
							</li>
							<li style="line-height: 15px !important;">
								<label>
									<input type="text" name="wanapost-several-social-sharing[wanapost_username]" id="wsss_wanapost_username" class="widefat" placeholder="wanapost" value="<?php echo esc_attr($opts['wanapost_username']); ?>">
									<small><?php _e('Set this if you want to append "via @your Wanapost.com Username" to autopost.', 'wanapost-several-social-sharing'); ?></small>
								</label>
							</li>
							<li style="line-height: 15px !important;">
								<label>
									<a href="http://www.wanapost.com/index.php?a=settings&b=key" target="_blank" title="<?php _e('New window', 'wanapost-several-social-sharing'); ?>">
										<b><?php _e('Generate my keys on Wanapost.com', 'wanapost-several-social-sharing'); ?></b>
									</a>
								</label>
							</li>
							<li style="line-height: 15px !important;">
								<label>
									<input type="text" name="wanapost-several-social-sharing[wanapost_public_key]" id="wsss_wanapost_public_key" class="widefat" placeholder="Public Key" value="<?php echo esc_attr($opts['wanapost_public_key']); ?>">
									<small><?php _e('Set Public Key
 if you want to autopost on Wanapost.com.', 'wanapost-several-social-sharing'); ?></small>
								</label>
							</li>
							<li style="line-height: 15px !important;">
								<label>
									<input type="text" name="wanapost-several-social-sharing[wanapost_private_key]" id="wsss_wanapost_private_key" class="widefat" placeholder="Secret Key" value="<?php echo esc_attr($opts['wanapost_private_key']); ?>">
									<small><?php _e('Set Secret Key if you want to autopost on Wanapost.com.', 'wanapost-several-social-sharing'); ?></small>
								</label>
							</li>
						</ul>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row">
						<label for="wsss_twitter_username"><?php _e('Twitter Username', 'wanapost-several-social-sharing'); ?></label>
					</th>
					<td>
						<input type="text" name="wanapost-several-social-sharing[twitter_username]" id="wsss_twitter_username" class="widefat" placeholder="wanapostcom" value="<?php echo esc_attr($opts['twitter_username']); ?>">
						<small><?php _e('Set this if you want to append "via @your Twitter Username" to tweets.', 'wanapost-several-social-sharing'); ?></small>
					</td>
				</tr>
			</table>
			<?php
				submit_button();
			?>
		</form>
	</div>

	<div class="wss-column wss-secondary">

		<div class="wss-box">
			<h3 class="wss-title"><?php _e( 'Do not forget to create an account on Wanapost.com', 'wanapost-several-social-sharing' ); ?></h3>
			<p><?php _e( 'It\'s completely free and it will remain.', 'wanapost-several-social-sharing' ); ?></p>
			<div class="wss-donate">
				<a href="http://www.wanapost.com/" title="Wanapost" target="_blank"><img src="<?php echo WSSS_PLUGIN_URL; ?>/wanapost.jpg" width="100%"/></a>
			</div>
			<ul class="ul-square">
				<li><a href="http://www.wanapost.com/register" target="_blank"><?php _e( 'Register', 'wanapost-several-social-sharing' ); ?></a></li>
				<li><a href="http://www.wanapost.com/login" target="_blank"><?php _e( 'Login', 'wanapost-several-social-sharing' ); ?></a></li>
				<li><a href="http://www.wanapost.com/index.php?a=settings&b=key" target="_blank"><?php _e( 'Keys', 'wanapost-several-social-sharing' ); ?></a></li>
			</ul>
			<p><?php _e( 'Do you want to see a demo!?', 'wanapost-several-social-sharing' ); ?></p>
			<ul class="ul-square">
				<li><a href="http://www.wanapost.com/@belaadel" target="_blank"><?php printf( __( 'Demo on Wanapost.com', 'wanapost-several-social-sharing' ), '&#9733;&#9733;&#9733;&#9733;&#9733;' ); ?></a></li>
			</ul>
			<p><?php _e( 'Some other ways to support this plugin', 'wanapost-several-social-sharing' ); ?></p>
			<ul class="ul-square">
				<li><a href="http://wordpress.org/support/view/plugin-reviews/wanapost-several-social-sharing?rate=5#postform" target="_blank"><?php printf( __( 'Leave a %s review on WordPress.org', 'wanapost-several-social-sharing' ), '&#9733;&#9733;&#9733;&#9733;&#9733;' ); ?></a></li>
				<li><a href="http://twitter.com/intent/tweet/?text=<?php echo urlencode('I am using Wordpress "Wanapost Several Social Sharing" plugin to show social sharing buttons on my WordPress site.'); ?>&via=wanapostcom&url=<?php echo urlencode('http://wordpress.org/plugins/wanapost-several-social-sharing/'); ?>" target="_blank"><?php _e('Tweet about this plugin','wanapost-several-social-sharing');?></a></li>
				<li><a href="http://wordpress.org/plugins/wanapost-several-social-sharing/#compatibility"  target="_blank"><?php _e( 'Vote "works" on the WordPress.org plugin page', 'wanapost-several-social-sharing' ); ?></a></li>
			</ul>
		</div>
		<div class="wss-box">
			<h3 class="wss-title"><?php _e( 'Looking for support?', 'wanapost-several-social-sharing' ); ?></h3>
			<p><?php printf( __( 'Please use the %splugin support forums%s on WordPress.org.', 'wanapost-several-social-sharing' ), '<a href="http://wordpress.org/plugins/wanapost-several-social-sharing/">', '</a>' ); ?></p>
		</div>
		<div class="wss-box">
			<h3 class="wss-title"><?php _e( 'Credits', 'wanapost-several-social-sharing' ); ?></h3>
			<p><?php printf( __( 'The code of this plugin was based on %sarjunjain08\'s plugin%s on WordPress.org.', 'wp-social-sharing' ), '<a href="http://wordpress.org/plugins/wp-social-sharing/" title="wp-social-sharing" target="_blank">', '</a>' ); ?></p>
		</div>
		<br style="clear:both; " />
	</div>
</div>
</div>
