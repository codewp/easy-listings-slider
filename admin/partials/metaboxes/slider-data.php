<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var ELS_Slider $slider
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
					<?php
					$slider_types = $slider->get_types();
					foreach ( $slider_types as $id => $name ) {
						echo '<option value="' . esc_attr( $id ) . '" ' . selected( $slider->get_type(), $id, false ) . '>' . $name . '</option>';
					}
					?>
				</select>
			</p>
			<p>
				<label for="slider_theme"><?php _e( 'Slider theme', 'els' ) ?></label>
				<select id="slider_theme" name="slider_theme">
					<?php
					foreach ( $slider->get_themes() as $id => $name ) {
						echo '<option value="' . esc_attr( $id ) . '" ' . selected( $slider->get_theme(), $id, false ) . '>' . $name . '</option>';
					}
					?>
				</select>
			</p>
			<p>
				<label for="slider_container_id"><?php _e( 'Slider container id', 'els' ) ?></label>
				<input type="text" id="slider_container_id" name="slider_container_id" value="<?php echo esc_attr( $slider->get_container_id() ) ?>" />
			</p>
			<p>
				<label for="slider_width"><?php _e( 'Slider width', 'els' ) ?></label>
				<input type="number" id="slider_width" name="slider_width" value="<?php echo esc_attr( $slider->get_width() ) ?>">
			</p>
			<p>
				<label for="slider_height"><?php _e( 'Slider height', 'els' ) ?></label>
				<input type="number" id="slider_height" name="slider_height" value="<?php echo esc_attr( $slider->get_height() ) ?>">
			</p>
			<p>
				<label><?php _e( 'Automatically crop and resize slider images based on above size.', 'els' ) ?></label>
				<label>
					<?php _e( 'Off', 'els' ) ?>
					<input type="radio" name="slider_auto_crop_resize" value="0" <?php checked( $slider->get_auto_crop_resize(), false ) ?>>
				</label>
				<label>
					<?php _e( 'On', 'els' ) ?>
					<input type="radio" name="slider_auto_crop_resize" value="1" <?php checked( $slider->get_auto_crop_resize(), true ) ?>>
				</label>
			</p>
		</div>
		<div id="navigation-tab">
			<p>
				<label><?php _e( 'Autoplay', 'els' ) ?></label>
				<label>
					<?php _e( 'Off', 'els' ) ?>
					<input type="radio" name="auto_play" value="0" <?php checked( $slider->get_auto_play(), false ) ?>>
				</label>
				<label>
					<?php _e( 'On', 'els' ) ?>
					<input type="radio" name="auto_play" value="1" <?php checked( $slider->get_auto_play(), true ) ?>>
				</label>
			</p>
			<p>
				<label for="autoplay_interval"><?php _e( 'Autoplay interval', 'els' ) ?></label>
				<input type="number" id="autoplay_interval" name="autoplay_interval" value="<?php echo esc_attr( $slider->get_auto_play_interval() ) ?>">
			</p>
			<p>
				<label for="slide_duration"><?php _e( 'Slide duration', 'els' ) ?></label>
				<input type="number" id="slide_duration" name="slide_duration" value="<?php echo esc_attr( $slider->get_slide_duration() ) ?>">
			</p>
			<p>
				<label for="loop"><?php _e( 'Loop type', 'els' ) ?></label>
				<select id="loop" name="loop">
					<option value="0" <?php selected( 0, $slider->get_loop() ) ?>><?php _e( 'Stop', 'els' ) ?></option>
					<option value="1" <?php selected( 1, $slider->get_loop() ) ?>><?php _e( 'Loop', 'els' ) ?></option>
					<option value="2" <?php selected( 2, $slider->get_loop() ) ?>><?php _e( 'Rewind', 'els' ) ?></option>
				</select>
			</p>
			<p>
				<label for="drag_orientation"><?php _e( 'Drag orientation', 'els' ) ?></label>
				<select id="drag_orientation" name="drag_orientation">
					<option value="0" <?php selected( 0, $slider->get_drag_orientation() ) ?>><?php _e( 'No drag', 'els' ) ?></option>
					<option value="1" <?php selected( 1, $slider->get_drag_orientation() ) ?>><?php _e( 'Horizental', 'els' ) ?></option>
					<option value="2" <?php selected( 2, $slider->get_drag_orientation() ) ?>><?php _e( 'Vertical', 'els' ) ?></option>
					<option value="3" <?php selected( 3, $slider->get_drag_orientation() ) ?>><?php _e( 'Either', 'els' ) ?></option>
				</select>
			</p>
		</div>
	</div>
</div>
