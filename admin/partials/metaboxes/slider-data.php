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
		<div id="general-tab" class="slider-options-panel">
			<div class="row">
				<div class="col-label">
					<label for="slider_type"><?php _e( 'Slider type', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<select id="slider_type" name="slider_type">
						<?php
						$slider_types = $slider->get_types();
						foreach ( $slider_types as $id => $name ) {
							echo '<option value="' . esc_attr( $id ) . '" ' . selected( $slider->get_type(), $id, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slider_theme"><?php _e( 'Slider theme', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<select id="slider_theme" name="slider_theme">
						<?php
						foreach ( $slider->get_themes() as $id => $name ) {
							echo '<option value="' . esc_attr( $id ) . '" ' . selected( $slider->get_theme(), $id, false ) . '>' . $name . '</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slider_container_id"><?php _e( 'Slider container id', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="text" id="slider_container_id" name="slider_container_id" value="<?php echo esc_attr( $slider->get_container_id() ) ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slider_width"><?php _e( 'Slider width', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="number" id="slider_width" name="slider_width" value="<?php echo esc_attr( $slider->get_width() ) ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slider_height"><?php _e( 'Slider height', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="number" id="slider_height" name="slider_height" value="<?php echo esc_attr( $slider->get_height() ) ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label><?php _e( 'Automatically crop and resize slider images based on above size.', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="radio" name="slider_auto_crop_resize" id="slider_auto_crop_resize_off" value="0" <?php checked( $slider->get_auto_crop_resize(), false ) ?>>
					<label for="slider_auto_crop_resize_off"><?php _e( 'Off', 'els' ) ?></label>
					<br/>
					<input type="radio" name="slider_auto_crop_resize" id="slider_auto_crop_resize_on" value="1" <?php checked( $slider->get_auto_crop_resize(), true ) ?>>
					<label for="slider_auto_crop_resize_on"><?php _e( 'On', 'els' ) ?></label>
					<br/>
				</div>
			</div>
		</div>
		<div id="navigation-tab" class="slider-options-panel">
			<div class="row">
				<div class="col-label">
					<label><?php _e( 'Autoplay', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="radio" name="auto_play" id="auto_play_off" value="0" <?php checked( $slider->get_auto_play(), false ) ?>>
					<label for="auto_play_off"><?php _e( 'Off', 'els' ) ?></label>
					<br/>
					<input type="radio" name="auto_play" id="auto_play_on" value="1" <?php checked( $slider->get_auto_play(), true ) ?>>
					<label for="auto_play_on"><?php _e( 'On', 'els' ) ?></label>
					<br/>
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="autoplay_interval"><?php _e( 'Autoplay interval', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="number" id="autoplay_interval" name="autoplay_interval" value="<?php echo esc_attr( $slider->get_auto_play_interval() ) ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slide_duration"><?php _e( 'Slide duration', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="number" id="slide_duration" name="slide_duration" value="<?php echo esc_attr( $slider->get_slide_duration() ) ?>">
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="loop"><?php _e( 'Loop type', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<select id="loop" name="loop">
						<option value="0" <?php selected( 0, $slider->get_loop() ) ?>><?php _e( 'Stop', 'els' ) ?></option>
						<option value="1" <?php selected( 1, $slider->get_loop() ) ?>><?php _e( 'Loop', 'els' ) ?></option>
						<option value="2" <?php selected( 2, $slider->get_loop() ) ?>><?php _e( 'Rewind', 'els' ) ?></option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="drag_orientation"><?php _e( 'Drag orientation', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<select id="drag_orientation" name="drag_orientation">
						<option value="0" <?php selected( 0, $slider->get_drag_orientation() ) ?>><?php _e( 'No drag', 'els' ) ?></option>
						<option value="1" <?php selected( 1, $slider->get_drag_orientation() ) ?>><?php _e( 'Horizental', 'els' ) ?></option>
						<option value="2" <?php selected( 2, $slider->get_drag_orientation() ) ?>><?php _e( 'Vertical', 'els' ) ?></option>
						<option value="3" <?php selected( 3, $slider->get_drag_orientation() ) ?>><?php _e( 'Either', 'els' ) ?></option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
