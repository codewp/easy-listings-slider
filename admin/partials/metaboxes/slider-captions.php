<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var ELS_HTML_Elements $html
 * @var string $images_url
 * @var array $slide_numbers
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
					<th style="width: 20%;"><?php _e( 'Slide number', 'els' ) ?></th>
					<th style="width: 2%"></th>
				</tr>
			</thead>
			<tbody>
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
				<tr>
					<td class="submit" colspan="4" style="float: none; clear:both; background: #fff;">
						<a class="button-secondary els_add_repeatable" style="margin: 6px 0 10px;"><?php _e( 'Add New Caption', 'els' ); ?></a>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
