<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var ELS_Slider $slider
 * @var string     $images_url
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
					<img class="help_tip" data-tip="<?php _e( 'Types of slides that should be shown in the slider', 'els' ) ?>" src="<?php echo $images_url ?>help.png" height="16" width="16" />
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
					<img class="help_tip" data-tip="<?php _e( 'Slider HTML element id attribute, this field is optional', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slider_width"><?php _e( 'Slider width', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="number" id="slider_width" name="slider_width" value="<?php echo esc_attr( $slider->get_width() ) ?>">
					<img class="help_tip" data-tip="<?php _e( 'Slider width in pixel', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label for="slider_height"><?php _e( 'Slider height', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="number" id="slider_height" name="slider_height" value="<?php echo esc_attr( $slider->get_height() ) ?>">
					<img class="help_tip" data-tip="<?php _e( 'Slider height in pixel', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
				</div>
			</div>
			<div class="row">
				<div class="col-label">
					<label><?php _e( 'Fill mode', 'els' ) ?></label>
				</div>
				<div class="col-value">
					<input type="radio" name="slider_fill_mode" id="slider_fill_mode_stretch" value="0" <?php checked( $slider->get_fill_mode(), 0 ) ?> />
					<label for="slider_fill_mode_stretch"><?php _e( 'Stretch', 'els' ) ?></label>
					<br/>
					<input type="radio" name="slider_fill_mode" id="slider_fill_mode_contain" value="1" <?php checked( $slider->get_fill_mode(), 1 ) ?> />
					<label for="slider_fill_mode_contain"><?php _e( 'Contain (keep aspect ratio and put all inside slide)', 'els' ) ?></label>
					<br/>
					<input type="radio" name="slider_fill_mode" id="slider_fill_mode_cover" value="2" <?php checked( $slider->get_fill_mode(), 2 ) ?> />
					<label for="slider_fill_mode_cover"><?php _e( 'Cover (keep aspect ratio and cover whole slide)', 'els' ) ?></label>
					<br/>
					<input type="radio" name="slider_fill_mode" id="slider_fill_mode_actual_size" value="4" <?php checked( $slider->get_fill_mode(), 4 ) ?> />
					<label for="slider_fill_mode_actual_size"><?php _e( 'Actual size', 'els' ) ?></label>
					<br/>
					<input type="radio" name="slider_fill_mode" id="slider_fill_mode_contain_large" value="5" <?php checked( $slider->get_fill_mode(), 5 ) ?> />
					<label for="slider_fill_mode_contain_large"><?php _e( 'Contain for large image and actual size for small image', 'els' ) ?></label>
					<br/>
					<p class="description"><?php _e( 'How to fill content of slider with images?', 'els' ) ?></p>
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
					<p class="description"><?php _e( 'This feature will automatically playes slides inside slider if enabled.', 'els' ) ?></p>
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
