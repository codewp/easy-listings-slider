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
 */
?>
<div id="els_slider_captions_container">
	<p>
		<strong><?php _e( 'Slider captions:', 'els' ); ?></strong>
	</p>
	<input type="hidden" id="els_slider_captions" value=""/>
	<div id="els_captoins" class="edd_meta_table_wrap">
		<table class="widefat els_repeatable_table" width="100%" cellpadding="0" cellspacing="0">
			<thead>
				<tr>
					<th><?php _e( 'Caption', 'els' ) ?></th>
					<th style="width: 10%"><?php _e( 'Offsetx', 'els' ) ?> (px)</th>
					<th style="width: 10%"><?php _e( 'Offsety', 'els' ) ?> (px)</th>
					<th style="width: 10%"><?php _e( 'Width', 'els' ) ?> (px)</th>
					<th style="width: 10%"><?php _e( 'Height', 'els' ) ?> (px)</th>
					<th style="width: 20%;"><?php _e( 'Slide number', 'els' ) ?></th>
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
									<?php
									echo $html->text( array(
											'name'        => 'els_slider_captions[' . $captions_count . '][name]',
											'value'		  => sanitize_text_field( $caption_detail['name'] ),
											'placeholder' => __( 'Caption name', 'els' ),
											'class'       => 'els_repeatable_name_field large-text',
										)
									);
									?>
								</td>
								<td>
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][offsetx]',
											'value' => (int) $caption_detail['offsetx'],
											'class' => 'els_repeatable_name_field large-text',
										)
									);
									?>
								</td>
								<td>
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][offsety]',
											'value' => (int) $caption_detail['offsety'],
											'class' => 'els_repeatable_name_field large-text',
										)
									);
									?>
								</td>
								<td>
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][width]',
											'value' => absint( $caption_detail['width'] ),
											'min'   => 0,
											'class' => 'els_repeatable_name_field large-text',
										)
									);
									?>
								</td>
								<td>
									<?php
									echo $html->number( array(
											'name'  => 'els_slider_captions[' . $captions_count . '][height]',
											'value' => absint( $caption_detail['height'] ),
											'min'   => 0,
											'class' => 'els_repeatable_name_field large-text',
										)
									);
									?>
								</td>
								<td>
									<?php
									echo $html->select( array(
											'name'             => 'els_slider_captions[' . $captions_count . '][slide_number]',
											'options'          => $slide_numbers,
											'selected'		   => $slide_number,
											'show_option_none' => null,
											'class'            => 'els_repeatable_slide_number_field',
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
					<tr class="els_repeatable_row">
						<td>
							<?php
							echo $html->text( array(
									'name'        => 'els_slider_captions[0][name]',
									'placeholder' => __( 'Caption name', 'els' ),
									'class'       => 'els_repeatable_name_field large-text',
								)
							);
							?>
						</td>
						<td>
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][offsetx]',
									'value' => 0,
									'class' => 'els_repeatable_name_field large-text',
								)
							);
							?>
						</td>
						<td>
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][offsety]',
									'value' => 0,
									'class' => 'els_repeatable_name_field large-text',
								)
							);
							?>
						</td>
						<td>
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][width]',
									'min'   => 0,
									'class' => 'els_repeatable_name_field large-text',
								)
							);
							?>
						</td>
						<td>
							<?php
							echo $html->number( array(
									'name'  => 'els_slider_captions[0][height]',
									'min'   => 0,
									'class' => 'els_repeatable_name_field large-text',
								)
							);
							?>
						</td>
						<td>
							<?php
							echo $html->select( array(
									'name'             => 'els_slider_captions[0][slide_number]',
									'options'          => $slide_numbers,
									'selected'		   => null,
									'show_option_none' => null,
									'class'            => 'els_repeatable_slide_number_field',
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
</div>
