<?php  $url = mpp_ss_social()->get_url();  ?>
	<table class="form-table s3-settings-table" xmlns="http://www.w3.org/1999/html">
		<tr>
			<th>
				<label for="select-style"><?php _e( 'Select style', 'mpp-social-share' ) ?></label>
			</th>
			<td>
				<p>
					<label>
						<input type="radio" name="mpp-ss-settings[select-style]" value="horizontal-with-count" <?php checked( $settings['select-style'], 'horizontal-with-count' ); ?> />
						<img src="<?php echo $url. 'assets/images/horizontal-with-count.png' ; ?>">
					</label>
				</p>
				<p>
					<label>
						<input type="radio" name="mpp-ss-settings[select-style]" value="small-buttons" <?php checked( $settings['select-style'], 'small-buttons' ); ?> />
						<img src="<?php echo $url  .  'assets/images/small-buttons.png' ; ?>">
					</label>
				</p>
				<p>
					<label>
						<input type="radio" name="mpp-ss-settings[select-style]" value="horizontal-w-c-square" <?php checked( $settings['select-style'], 'horizontal-w-c-square' ); ?> />
						<img src="<?php echo $url  .  'assets/images/horizontal-w-c-square.png' ; ?>">
					</label>
				</p>
				<p>
					<label>
						<input type="radio" name="mpp-ss-settings[select-style]" value="horizontal-w-c-r-border" <?php checked( $settings['select-style'], 'horizontal-w-c-r-border' ); ?> />
						<img src="<?php echo $url  .  'assets/images/horizontal-w-c-r-border.png' ; ?>">
					</label>
				</p>
				<p>
					<label>
						<input type="radio" name="mpp-ss-settings[select-style]" value="horizontal-w-c-circular" <?php checked( $settings['select-style'], 'horizontal-w-c-circular' ); ?> />
						<img src="<?php echo $url  .  'assets/images/horizontal-w-c-circular.png' ; ?>">
					</label>
				</p>
			</td>
		</tr>
		<tr>
			<th>
				<label for="select-style"><?php _e( 'Select services', 'mpp-social-share' ) ?></label>
			</th>
			<td>
				<?php foreach ($settings['available-services'] as $service) : ?>
					<label>
						<input type="checkbox" name="mpp-ss-settings[selected-services][]" value="<?php echo $service ; ?>" <?php checked( in_array( $service, (array)$settings['selected-services'] ) ); ?> />
						<?php echo $service; ?>
						<input type="hidden" name="mpp-ss-settings[available-services][]" value="<?php echo $service ; ?>" />
					</label>
					<br>
				<?php endforeach; ?>
			</td>
		</tr>
		<tr>
			<th>
				<label for="select-postion"><?php _e( 'Select Position ( Post/Page )', 'mpp-social-share' ) ?></label>
			</th>
			<td>
				<label>
					<input type="checkbox" name="mpp-ss-settings[select-position][]" value="before-content" <?php checked( in_array( 'before-content', (array)$settings['select-position'] ) ); ?> />
					<?php _e( 'Before Content', 'mpp-social-share' ) ?>
				</label>
				<br>
				<label>
					<input type="checkbox" name="mpp-ss-settings[select-position][]" value="after-content" <?php checked( in_array( 'after-content', (array)$settings['select-position'] ) ); ?> />
					<?php _e( 'After Content', 'mpp-social-share' ) ?>
				</label>
				<br>
			</td>
		</tr>
		<tr>
			<th>
				<label for="select-postion"><?php _e( 'Show on', 'mpp-social-share' ) ?></label>
			</th>
			<td>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="home" <?php checked( in_array( 'home', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Home Page', 'mpp-social-share' ) ?>
				</label>
				<br>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="pages" <?php checked( in_array( 'pages', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Pages', 'mpp-social-share' ) ?>
				</label>
				<br>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="posts" <?php checked( in_array( 'posts', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Posts', 'mpp-social-share' ) ?>
				</label>
				<br/>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="archive" <?php checked( in_array( 'archive', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Archives', 'mpp-social-share' ) ?>
				</label>
				<br/>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="gallery_list" <?php checked( in_array( 'gallery_list', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Gallery Listing', 'mpp-social-share' ) ?>
				</label>
				<br/>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="gallery_single" <?php checked( in_array( 'gallery_single', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Single Gallery', 'mpp-social-share' ) ?>
				</label>
				<br/>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="media_single" <?php checked( in_array( 'media_single', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Single Media', 'mpp-social-share' ) ?>
				</label>
				<br/>
				<label>
					<input type="checkbox" name="mpp-ss-settings[show-on][]" value="light_box" <?php checked( in_array( 'light_box', (array)$settings['show-on'] ) ); ?>>
					<?php _e( 'Light Box', 'mpp-social-share' ) ?>
				</label>
			</td>
		</tr>
		<tr>
			<th>
				<label for="exclude-on"><?php _e( 'Exclude on', 'mpp-social-share' )?></label>
			</th>
			<td>
				<label>
					<input type="text" name="mpp-ss-settings[exclude-on]" value="<?php echo $settings['exclude-on']; ?>">
					<small><em><?php _e( 'Comma seperated post ids Eg:', 'mpp-social-share' )?></em><code>1207,1222</code></small>
				</label>
			</td>
		</tr>
		<tr class="tr-select-animation">
			<th>
				<label for="select-animations"><?php _e( 'Select Animations', 'mpp-social-share' ) ?></label>
			</th>
			<td>
				<label>
					<input type="checkbox" name="mpp-ss-settings[select-animations][]" value="tooltip" <?php checked( (!empty($settings['select-animations']) && in_array( 'tooltip', $settings['select-animations'] )) ); ?>>
					<?php _e( 'Tooltip Animation', 'mpp-social-share' ) ?>
				</label>
				<br>
				<label>
					<input type="checkbox" name="mpp-ss-settings[select-animations][]" value="360-rotation" <?php checked( (!empty($settings['select-animations']) && in_array( '360-rotation', $settings['select-animations'] )) ); ?>>
					<?php _e( '360d Rotation', 'mpp-social-share' ) ?><small><em>(<?php _e( 'Looks good only for circular icons', 'mpp-social-share' ) ?>)</em></small>
				</label>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e( 'Save Changes', 'mpp-social-share' );?>">
	</p>
</form>
