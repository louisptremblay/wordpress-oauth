<?php
/**
 * WordPress Mobile Oauth Options Page
 *
 * @author Justin Greer <justin@justin-greer.com>
 * @package WordPress Mobile Oauth
 */
function my_plugin_page (){ ?>

	<div class="wrap">
		<h2>Mobile OAuth Settings</h2>

		<form method="post" action="options.php"> 

			<?php 
				settings_fields( 'mobile-oauth-settings' );
				do_settings_sections( 'mobile-oauth-settings' );
			?>

			<table class="form-table">
				<tbody>
					<tr class="option-mobile-oauth-avaliablity">
						<th scope="row"> Disable Mobile OAuth API </th>
						<td>
							<fieldset>
								<legend class="screen-reader-text">
									<span> Disable Mobile OAuth API </span>
								</legend>
								<label for="disable_mobile_oauth_api">
									<input name="disable_mobile_oauth_api" 
											type="checkbox" 
											id="disable_mobile_oauth_api" 
											value="1" 
											<?php echo (get_option('disable_mobile_oauth_api') ? 'checked="checked"' : ''); ?> >
									Deny all incomming/outgoing connections for Mobile OAuth
								</label>
								<p class="description">
									May cause issues if an application depends on this feature.
								</p>
							</fieldset>
						</td>
					</tr>
				</tbody>
			</table>
		
			<?php submit_button(); ?>
		
		</form>

	</div>
<?php
}