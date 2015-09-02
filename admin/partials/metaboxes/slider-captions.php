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
 * @var array $fonts
 */
?>
<div id="els_slider_captions_container">
	<p>
		<strong><?php _e( 'Captions preview', 'els' ) ?></strong>
	</p>
	<div id="els_captions_preview" class="captions_preview" style="height: 500px; width: 100%; position: relative;">
		<div id="preview_caption" style="position: absolute; z-index: 10;"></div>
		<img id="captions_preview_img" src="<?php echo esc_attr( $images_url ) . 'slide-caption-preview.jpg' ?>" width="100%" height="500px" style="position: relative;">
	</div>
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
			$color_converter = new ELS_Color_Converter();
			$captions_count  = 0;
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
										'quicktags'		=> array(
											'buttons' => 'strong,em,link,block,ul,ol,li,close',
										),
										'tinymce'		=> array(
											'setup' => 'function( editor ) {' .
												'
												// Preview caption on change of caption content.
												editor.on( "change", function( e ) { var captionId = jQuery( \'#\' + this.id ).closest( \'div.caption_spec_tabs\' ).data( \'key\' ); ElsCaptionConfiguration.captionsPreview( captionId ); } ),
												// Preview first caption content on loading page.
												editor.on( "init", function( e ) { var captionId = jQuery( \'#\' + this.id ).closest( \'div.caption_spec_tabs\' ).data( \'key\' ); if ( 1 === captionId ) { ElsCaptionConfiguration.captionsPreview( captionId ); } } );
												'
											. '}',
											'forced_root_block' => false,
										)
									)
								);
								?>
							</div>
						</div>
						<div id="caption_transition_<?php echo $captions_count ?>" class="slider-options-panel">
							<div class="row">
								<div class="col-label">
									<label for="els_slider_captions[<?php echo $captions_count ?>][play_in_transition_type]"><?php _e( 'Play in transition type', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
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
									<img class="help_tip" data-tip="<?php _e( 'Caption play in transition type', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Play out transition type', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
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
									<img class="help_tip" data-tip="<?php _e( 'Caption play out transition type', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
								</div>
							</div>
						</div>
						<div id="caption_style_<?php echo $captions_count ?>" class="slider-options-panel">
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'OffsetX', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][offsetx]',
											'value' => (int) $caption_detail['offsetx'],
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
									<img class="help_tip" data-tip="<?php _e( 'Controling position of the caption by changing it\'s X offset', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'OffsetY', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][offsety]',
											'value' => (int) $caption_detail['offsety'],
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
									<img class="help_tip" data-tip="<?php _e( 'Controling position of the caption by changing it\'s Y offset', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Width', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][width]',
											'value' => absint( $caption_detail['width'] ),
											'min'   => 0,
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Height', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][height]',
											'value' => absint( $caption_detail['height'] ),
											'min'   => 0,
											'class' => 'els_repeatable_name_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Line height', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][line_height]',
											'value' => absint( $caption_detail['line_height'] ),
											'min'   => 8,
											'class' => 'els_repeatable_text_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Padding', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][padding]',
											'value' => absint( $caption_detail['padding'] ),
											'min'   => 0,
											'class' => 'els_repeatable_text_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Font size', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][font_size]',
											'value' => absint( $caption_detail['font_size'] ) > 0 ? absint( $caption_detail['font_size'] ) : 20,
											'min'   => 1,
											'class' => 'els_repeatable_text_field',
										)
									);
									echo ' ' . __( 'px', 'els' );
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Font family', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][font_family]',
											'options'          => $fonts,
											'selected'		   => $caption_detail['font_family'],
											'show_option_none' => false,
											'show_option_all'  => false,
											'class'            => 'els_repeatable_slide_select_field font-family',
										)
									);
									?>
								</div>
							</div>
							<div class="row font-weight-only">
								<div class="col-label">
									<label><?php _e( 'Font weight', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][font_weight]',
											'options'          => array(
												'normal' => __( 'Normal', 'els' ),
												100      => 100,
												200      => 200,
												300      => 300,
												400      => 400,
												500      => 500,
												600      => 600,
												700      => 700,
												800      => 800,
												900      => 900,
											),
											'selected'		   => $caption_detail['font_weight'],
											'show_option_none' => false,
											'show_option_all'  => false,
											'class'            => 'els_repeatable_slide_select_field font-weight',
										)
									);
									?>
								</div>
							</div>
							<div class="row font-style-only">
								<div class="col-label">
									<label><?php _e( 'Font style', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][font_style]',
											'options'          => array(
												'normal' => __( 'Normal', 'els' ),
												'italic' => __( 'Italic', 'els' )
											),
											'selected'		   => $caption_detail['font_style'],
											'show_option_none' => false,
											'show_option_all'  => false,
											'class'            => 'els_repeatable_slide_select_field font-style',
										)
									);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Text align', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									echo $html->select( array(
											'name'    => 'els_slider_captions[' . $captions_count . '][text_align]',
											'options' => array(
												'left'   => __( 'Left', 'els' ),
												'center' => __( 'Center', 'els' ),
												'right'  => __( 'Right', 'els' )
											),
											'selected'         => $caption_detail['text_align'],
											'show_option_none' => null,
											'show_option_all'  => null,
											'class'            => 'els_repeatable_select_field',
										)
									);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Color', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									$color = '#000000';
									if ( ! empty( $caption_detail['color'] ) ) {
										$color = $color_converter->rgba_to_hex( $caption_detail['color'] );
									}
									echo $html->color_picker( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][color]',
											'value' => esc_attr( $color ),
											'class' => 'els_repeatable_text_field',
										)
									);
									?>
								</div>
							</div>
							<div class="row">
								<div class="col-label">
									<label><?php _e( 'Background color', 'els' ) ?></label>
								</div>
								<div class="col-value">
									<?php
									$background_color = '';
									if ( ! empty( $caption_detail['background_color'] ) ) {
										$background_color = $color_converter->rgba_to_hex( $caption_detail['background_color'] );
									}
									echo $html->color_picker( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][background_color]',
											'value' => esc_attr( $background_color ),
											'class' => 'els_repeatable_text_field',
										)
									);
									?>
								</div>
							</div>
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
								'quicktags'		=> array(
									'buttons' => 'strong,em,link,block,ul,ol,li,close',
								),
								'tinymce'		=> array(
									'setup' => 'function( editor ) {' .
										'
										// Preview caption on change of caption content.
										editor.on( "change", function( e ) { var captionId = jQuery( \'#\' + this.id ).closest( \'div.caption_spec_tabs\' ).data( \'key\' ); ElsCaptionConfiguration.captionsPreview( captionId ); } );
										'
									. '}',
									'forced_root_block' => false,
								)
							)
						);
						?>
					</div>
				</div>
				<div id="caption_transition_0" class="slider-options-panel">
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Play in transition type', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][play_in_transition_type]',
									'options'          => $caption_transition_types,
									'selected'		   => '*',
									'show_option_none' => null,
									'show_option_all'  => null,
									'class'            => 'els_repeatable_slide_select_field',
								)
							);
							?>
							<img class="help_tip" data-tip="<?php _e( 'Caption play in transition type', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Play out transition type', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][play_out_transition_type]',
									'options'          => $caption_transition_types,
									'selected'		   => '*',
									'show_option_none' => null,
									'show_option_all'  => null,
									'class'            => 'els_repeatable_slide_select_field',
								)
							);
							?>
							<img class="help_tip" data-tip="<?php _e( 'Caption play out transition type', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
						</div>
					</div>
				</div>
				<div id="caption_style_0" class="slider-options-panel">
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'OffsetX', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][offsetx]',
									'value' => 250,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
							<img class="help_tip" data-tip="<?php _e( 'Controling position of the caption by changing it\'s X offset', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'OffsetY', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][offsety]',
									'value' => 250,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
							<img class="help_tip" data-tip="<?php _e( 'Controling position of the caption by changing it\'s Y offset', 'els' ) ?>" src="<?php echo $images_url ?>help.png" width="16" height="16" />
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Width', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][width]',
									'value' => 300,
									'min'   => 0,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Height', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][height]',
									'value' => 100,
									'min'   => 0,
									'class' => 'els_repeatable_name_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Line height', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][line_height]',
									'value' => 30,
									'min'   => 8,
									'class' => 'els_repeatable_text_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Padding', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][padding]',
									'value' => 0,
									'min'   => 0,
									'class' => 'els_repeatable_text_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Font size', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][font_size]',
									'value' => 20,
									'min'   => 1,
									'class' => 'els_repeatable_text_field',
								)
							);
							echo ' ' . __( 'px', 'els' );
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Font family', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][font_family]',
									'options'          => $fonts,
									'selected'		   => 'Tahoma',
									'show_option_none' => false,
									'show_option_all'  => false,
									'class'            => 'els_repeatable_slide_select_field font-family',
								)
							);
							?>
						</div>
					</div>
					<div class="row font-weight-only">
						<div class="col-label">
							<label><?php _e( 'Font weight', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][font_weight]',
									'options'          => array(
										'normal' => __( 'Normal', 'els' ),
										100      => 100,
										200      => 200,
										300      => 300,
										400      => 400,
										500      => 500,
										600      => 600,
										700      => 700,
										800      => 800,
										900      => 900,
									),
									'selected'		   => 'normal',
									'show_option_none' => false,
									'show_option_all'  => false,
									'class'            => 'els_repeatable_slide_select_field font-weight',
								)
							);
							?>
						</div>
					</div>
					<div class="row font-style-only">
						<div class="col-label">
							<label><?php _e( 'Font style', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][font_style]',
									'options'          => array(
										'normal' => __( 'Normal', 'els' ),
										'italic' => __( 'Italic', 'els' )
									),
									'selected'		   => 'normal',
									'show_option_none' => false,
									'show_option_all'  => false,
									'class'            => 'els_repeatable_slide_select_field font-style',
								)
							);
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Text align', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->select( array(
									'name'    => 'els_slider_captions[0][text_align]',
									'options' => array(
										'left'   => __( 'Left', 'els' ),
										'center' => __( 'Center', 'els' ),
										'right'  => __( 'Right', 'els' )
									),
									'selected'         => 'center',
									'show_option_none' => null,
									'show_option_all'  => null,
									'class'            => 'els_repeatable_select_field',
								)
							);
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Color', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->color_picker( array(
									'name'  => 'els_slider_captions[0][color]',
									'value' => '#000000',
									'class' => 'els_repeatable_text_field',
								)
							);
							?>
						</div>
					</div>
					<div class="row">
						<div class="col-label">
							<label><?php _e( 'Background color', 'els' ) ?></label>
						</div>
						<div class="col-value">
							<?php
							echo $html->color_picker( array(
									'name'  => 'els_slider_captions[0][background_color]',
									'class' => 'els_repeatable_text_field',
								)
							);
							?>
						</div>
					</div>
				</div>
			</div>
			<?php
		}
		?>
	</div>
</div>
