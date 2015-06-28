<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var WP_Post $post
 */

wp_nonce_field( 'els_save_data', 'els_meta_nonce' );
?>
<div id="slider-data-container">
	<div class="tabs">
		<ul>
			<li><a href="#general-tab"><?php _e( 'General', 'els' ) ?></a></li>
			<li><a href="#navigation-tab"><?php _e( 'Navigation', 'els' ) ?></a></li>
		</ul>
		<div id="general-tab">
			<p>
				<label for="slider_type"><?php _e( 'Slider type', 'els' ) ?></label>
				<select id="slider_type" name="slider_type">
					<option value="featured" selected="selected"><?php _e( 'Featured Listings', 'els' ) ?></option>
					<option value="image"><?php _e( 'Images', 'els' ) ?></option>
					<option value="featured_image"><?php _e( 'Featured Listings And Images', 'els' ) ?></option>
				</select>
			</p>
			<p>
				<label for="slider_width"><?php _e( 'Slider width', 'els' ) ?></label>
				<input type="number" id="slider_width" name="slider_width" value="800">
			</p>
			<p>
				<label for="slider_height"><?php _e( 'Slider height', 'els' ) ?></label>
				<input type="number" id="slider_height" name="slider_height" value="480">
			</p>
			<p>
				<label><?php _e( 'Automatically crop and resize slider images based on above size.', 'els' ) ?></label>
				<label>
					<?php _e( 'Off', 'els' ) ?>
					<input type="radio" name="slider_auto_crop_resize" value="0" checked="checked">
				</label>
				<label>
					<?php _e( 'On', 'els' ) ?>
					<input type="radio" name="slider_auto_crop_resize" value="1">
				</label>
			</p>
		</div>
		<div id="navigation-tab">
			<p>
				<label><?php _e( 'Autoplay', 'els' ) ?></label>
				<label>
					<?php _e( 'Off', 'els' ) ?>
					<input type="radio" name="slider_auto_play" value="0">
				</label>
				<label>
					<?php _e( 'On', 'els' ) ?>
					<input type="radio" name="slider_auto_play" value="1" checked="checked">
				</label>
			</p>
			<p>
				<label for="autoplay_interval"><?php _e( 'Autoplay interval', 'els' ) ?></label>
				<input type="number" id="autoplay_interval" name="autoplay_interval" value="4000">
			</p>
			<p>
				<label for="slide_duration"><?php _e( 'Slide duration', 'els' ) ?></label>
				<input type="number" id="slide_duration" name="slide_duration" value="500">
			</p>
			<p>
				<label for="loop"><?php _e( 'Loop type', 'els' ) ?></label>
				<select id="loop" name="loop">
					<option value="0"><?php _e( 'Stop', 'els' ) ?></option>
					<option value="1" selected="selected"><?php _e( 'Loop', 'els' ) ?></option>
					<option value="2"><?php _e( 'Rewind', 'els' ) ?></option>
				</select>
			</p>
			<p>
				<label for="drag_orientation"><?php _e( 'Drag orientation', 'els' ) ?></label>
				<select id="drag_orientation" name="drag_orientation">
					<option value="0"><?php _e( 'No drag', 'els' ) ?></option>
					<option value="1"><?php _e( 'Horizental', 'els' ) ?></option>
					<option value="2"><?php _e( 'Vertical', 'els' ) ?></option>
					<option value="3" selected="selected"><?php _e( 'Either', 'els' ) ?></option>
				</select>
			</p>
		</div>
	</div>
</div>
