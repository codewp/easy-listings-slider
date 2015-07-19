<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var ELS_HTML_Elements $html
 * @var string $images_url
 * @var array $slide_numbers
 * @var array $captions
 * @var array $caption_transition_types
 */
?>
<div id="els_slider_captions_container">
	<p>
		<strong><?php _e( 'Slider captions:', 'els' ); ?></strong>
	</p>
	<div id="els_captions" class="edd_meta_table_wrap">
		<table class="widefat els_repeatable_table" width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th><?php _e( 'Caption Type', 'els' ) ?></th>
					<th style="width: 50%;"><?php _e( 'Slide number', 'els' ) ?></th>
					<th style="width: 2%"></th>
				</tr>
			</thead>
			<tbody>
				<?php
				if ( count( $captions ) ) {
					$captions_count = 0;
					foreach ( $captions as $slide_number => $caption_details ) {
						foreach ( $caption_details as $caption_detail ) {
							$captions_count++;
							?>
							<tr class="els_repeatable_row" data-key="<?php echo $captions_count ?>">
								<td>
									<span><?php _e( 'Text', 'els' ) ?></span>
								</td>
								<td>
									<?php
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][slide_number]',
											'options'          => $slide_numbers,
											'selected'		   => $slide_number,
											'show_option_none' => null,
											'class'            => 'els_repeatable_slide_select_field',
										)
									);
									?>
								</td>
								<td>
									<a href="#" class="els_remove_repeatable" data-type="file" style="background: url(<?php echo esc_url( $images_url ) . 'xit.gif'; ?>) no-repeat;">&times;</a>
								</td>
							</tr>
							<?php
						}
					}
				} else {
					?>
					<tr class="els_repeatable_row" data-key="0">
						<td>
							<span><?php _e( 'Text', 'els' ) ?></span>
						</td>
						<td>
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][slide_number]',
									'options'          => $slide_numbers,
									'selected'		   => null,
									'show_option_none' => null,
									'class'            => 'els_repeatable_slide_select_field',
								)
							);
							?>
						</td>
						<td>
							<a href="#" class="els_remove_repeatable" data-type="file" style="background: url(<?php echo esc_url( $images_url ) . 'xit.gif'; ?>) no-repeat;">&times;</a>
						</td>
					</tr>
					<?php
				}
				?>
				<tr>
					<td class="submit" colspan="4" style="float: none; clear:both; background: #fff;">
						<a class="button-secondary els_add_repeatable" style="margin: 6px 0 10px;"><?php _e( 'Add New Caption', 'els' ); ?></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<p>
		<strong><?php _e( 'Caption specification:', 'els' ); ?></strong>
	</p>
	<div class="caption_specification">
		<?php
		if ( count( $captions ) ) {
			$captions_count = 0;
			foreach ( $captions as $slide_number => $caption_details ) {
				foreach ( $caption_details as $caption_detail ) {
					$captions_count++;
					?>
					<div class="caption_spec_tabs" id="caption_spec_<?php echo $captions_count ?>" style="display: none;" data-key="<?php echo $captions_count ?>">
						<ul>
							<li><a href="#caption_detail_<?php echo $captions_count ?>"><?php _e( 'Content', 'els' ) ?></a></li>
							<li><a href="#caption_transition_<?php echo $captions_count ?>"><?php _e( 'Transition', 'els' ) ?></a></li>
							<li><a href="#caption_style_<?php echo $captions_count ?>"><?php _e( 'Style', 'els' ) ?></a></li>
						</ul>
						<div id="caption_detail_<?php echo $captions_count ?>">
							<div class="caption_content">
								<?php
								wp_editor( stripslashes( $caption_detail['name'] ), 'caption_editor_' . $captions_count,
									array(
										'media_buttons' => false,
										'textarea_rows' => 5,
										'textarea_name' => 'els_slider_captions[' . $captions_count . '][name]',
										'teeny'			=> true,
										'wpautop'		=> false,
									)
								);
								?>
							</div>
						</div>
						<div id="caption_transition_<?php echo $captions_count ?>">
							<p>
								<label>
									<?php
									echo __( 'Play in transition type', 'els' ) . ' : ';
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][play_in_transition_type]',
											'options'          => $caption_transition_types,
											'selected'		   => $caption_detail['play_in_transition_type'],
											'show_option_none' => null,
											'show_option_all'  => null,
											'class'            => 'els_repeatable_slide_select_field',
										)
									);
									?>
								</label>
							</p>
							<p>
								<label>
									<?php
									echo __( 'Play out transition type', 'els' ) . ' : ';
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][play_out_transition_type]',
											'options'          => $caption_transition_types,
											'selected'		   => $caption_detail['play_out_transition_type'],
											'show_option_none' => null,
											'show_option_all'  => null,
											'class'            => 'els_repeatable_slide_select_field',
										)
									);
									?>
								</label>
							</p>
						</div>
						<div id="caption_style_<?php echo $captions_count ?>">
							<p>
								<label>
									<?php
									echo __( 'OffsetX', 'els' ) . ' : ';
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][offsetx]',
											'value' => (int) $caption_detail['offsetx'],
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</label>
							</p>
							<p>
								<label>
									<?php
									echo __( 'OffsetY', 'els' ) . ' : ';
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][offsety]',
											'value' => (int) $caption_detail['offsety'],
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</label>
							</p>
							<p>
								<label>
									<?php
									echo __( 'Width', 'els' ) . ' : ';
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][width]',
											'value' => absint( $caption_detail['width'] ),
											'min'   => 0,
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</label>
							</p>
							<p>
								<label>
									<?php
									echo __( 'Height', 'els' ) . ' : ';
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][height]',
											'value' => absint( $caption_detail['height'] ),
											'min'   => 0,
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</label>
							</p>
						</div>
					</div>
					<?php
				}
			}
		} else {
			?>
			<div class="caption_spec_tabs" id="caption_spec_0" style="display: none;" data-key="0">
				<ul>
					<li><a href="#caption_detail_0"><?php _e( 'Content', 'els' ) ?></a></li>
					<li><a href="#caption_transition_0"><?php _e( 'Transition', 'els' ) ?></a></li>
					<li><a href="#caption_style_0"><?php _e( 'Style', 'els' ) ?></a></li>
				</ul>
				<div id="caption_detail_0">
					<div class="caption_content">
						<?php
						wp_editor( '', 'caption_editor_0', array(
								'media_buttons' => false,
								'textarea_rows' => 5,
								'textarea_name' => 'els_slider_captions[0][name]',
								'teeny'			=> true,
								'wpautop'		=> false,
							)
						);
						?>
					</div>
				</div>
				<div id="caption_transition_0">
					<p>
						<label>
							<?php
							echo __( 'Play in transition type', 'els' ) . ' : ';
							echo $html->select( array(
									'name'             => 'els_slider_captions[' . $captions_count . '][play_in_transition_type]',
									'options'          => $caption_transition_types,
									'selected'		   => null,
									'show_option_none' => null,
									'show_option_all'  => null,
									'class'            => 'els_repeatable_slide_select_field',
								)
							);
							?>
						</label>
					</p>
					<p>
						<label>
							<?php
							echo __( 'Play out transition type', 'els' ) . ' : ';
							echo $html->select( array(
									'name'             => 'els_slider_captions[' . $captions_count . '][play_out_transition_type]',
									'options'          => $caption_transition_types,
									'selected'		   => null,
									'show_option_none' => null,
									'show_option_all'  => null,
									'class'            => 'els_repeatable_slide_select_field',
								)
							);
							?>
						</label>
					</p>
				</div>
				<div id="caption_style_0">
					<p>
						<label>
							<?php
							echo __( 'OffsetX', 'els' ) . ' : ';
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][offsetx]',
									'value' => 0,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</label>
					</p>
					<p>
						<label>
							<?php
							echo __( 'OffsetY', 'els' ) . ' : ';
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][offsety]',
									'value' => 0,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</label>
					</p>
					<p>
						<label>
							<?php
							echo __( 'Width', 'els' ) . ' : ';
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][width]',
									'min'   => 0,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</label>
					</p>
					<p>
						<label>
							<?php
							echo __( 'Height', 'els' ) . ' : ';
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][height]',
									'min'   => 0,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</label>
					</p>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
