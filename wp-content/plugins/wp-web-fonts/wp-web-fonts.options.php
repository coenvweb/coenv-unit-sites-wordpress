<div class="update-nag"><br>
	<p><strong>Thank you for using WP Web Fonts! </strong><span style="color:#990000;">If you think this software is useful please support the development with a donation or <a href="http://wordpress.org/extend/plugins/wp-web-fonts/stats/" target="_blank">rate this Plugin</a>.</span><br>Feel free to contact me for support or feature requests at <a href="http://saquery.com/wordpress/wp-web-fonts/" >saquery.com/wordpress/wp-web-fonts/</a> or <a href="mailto:webmaster@saquery.com"> via EMail</a><br>
	</p><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	
	<input type="hidden" name="cmd" value="_s-xclick">
	<input type="hidden" name="hosted_button_id" value="SQRUU7JKE7KFS">
	<input type="image" src="https://www.paypalobjects.com/WEBSCR-640-20110429-1/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
	<img alt="" border="0" src="https://www.paypalobjects.com/WEBSCR-640-20110429-1/de_DE/i/scr/pixel.gif" width="1" height="1">
	</form>
</div>
<div class="wrap">
	<h2>WP Web Fonts Options</h2>
<p>
Brighten up your blog with Web fonts from google. See <a href="http://wordpress.org/extend/plugins/wp-web-fonts/screenshots/" target="_blank">screenshots area</a> to give you an idea how easy it is.
Search hundreds of font families on <a href="http://www.google.com/webfonts" target="_blank">http://www.google.com/webfonts</a>, then add the one you like to your Blog! 


</p>
	<form method="post" action="options.php">
		<?php settings_fields( 'wpwebfontsOptions' ); ?>
		<table class="form-table">
			<tr valign="top" rowspan="2">
				<th scope="row" ><strong></strong></th>
			</tr>
			<tr valign="top">
				<td width="50%">
					<span>1. (Step 3. Add this code to your website:)</span> 
					<input style="width:100%;" type="text" name="wp-web-fonts-font-family" value="<?php echo (get_option('wp-web-fonts-font-family','')); ?>" />
				</td>
				<td width="50%">
					<span>2. (Step 4. Integrate the fonts into your CSS)</span> 
					<input style="width:100%;" type="text" name="wp-web-fonts-font-family-name" value="<?php echo (get_option('wp-web-fonts-font-family-name','')); ?>" />
				</td>
			</tr>
			<tr valign="top">
				<td width="50%">
				</td>
				<td width="50%">
					<i>Above you can setup CSS Rules for html, body. You can add font-size to adjust web fonts.</i> 
				</td>
			</tr>
			 
		</table>
		
		<p class="submit">
			<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</form>
</div>