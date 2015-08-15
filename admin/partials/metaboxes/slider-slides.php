<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var string $slider_type
 * @var string $slides
 * @var array $attachments
 */

wp_nonce_field( 'els_save_data', 'els_meta_nonce' );
?>
<div id="els-slider-slides-container">
	<ul class="slider_images">
		<?php
		if ( count( $attachments ) ) {
			for ( $i = 0; $i < count( $attachments ); $i++ ) {
				?>
				<li class="image" data-attachment_id="<?php echo esc_attr( $attachments[ $i ] ) ?>">
					<?php echo wp_get_attachment_image( $attachments[ $i ], 'thumbnail' ) ?>
					<ul class="actions">
						<li><a href="#" class="delete tips" data-tip="<?php _e( 'Delete image', 'els' ) ?>"><?php _e( 'Delete', 'els' ) ?></a></li>
					</ul>
					<span class="slide-number">#<?php echo $i + 1 ?></span>
				</li>
				<?php
			}
		}
		?>
	</ul>

	<input type="hidden" id="els_slider_images" name="els_slider_images" value="<?php echo esc_attr( $slides ); ?>" />
</div>
<p class="add_slider_images hide-if-no-js">
	<a class="images_loader" href="#" data-choose="<?php _e( 'Add Images to Slider', 'els' ); ?>"
	data-update="<?php _e( 'Add to slider', 'els' ); ?>" data-delete="<?php _e( 'Delete image', 'els' ); ?>"
	data-text="<?php _e( 'Delete', 'els' ); ?>"
	style="<?php echo 'listings' === $slider_type ? 'display:none;' : '' ?>">
	<?php _e( 'Add Images', 'els' ); ?></a>
	<a class="listings_loader" href="#" title="<?php _e( 'Listings', 'els' ) ?>"
	data-delete="<?php _e( 'Delete image', 'els' ); ?>" data-text="<?php _e( 'Delete', 'els' ); ?>"
	style="<?php echo 'images' === $slider_type ? 'display:none;' : '' ?>">
	<?php _e( 'Add Listings', 'els' ) ?></a>
</p>
