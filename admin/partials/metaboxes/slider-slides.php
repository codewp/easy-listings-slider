<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var string $slides
 * @var array $attachments
 */

wp_nonce_field( 'els_save_data', 'els_meta_nonce' );
?>
<div id="els-slider-slides-container">
	<ul class="slider_images">
		<?php
		if ( count( $attachments ) ) {
			foreach ( $attachments as $attachment_id ) {
				?>
				<li class="image" data-attachment_id="<?php echo esc_attr( $attachment_id ) ?>">
				<?php echo wp_get_attachment_image( $attachment_id, 'thumbnail' ) ?>
				<ul class="actions">
					<li><a href="#" class="delete tips" data-tip="<?php _e( 'Delete image', 'els' ) ?>"><?php _e( 'Delete', 'els' ) ?></a></li>
				</ul>
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
	data-text="<?php _e( 'Delete', 'els' ); ?>"><?php _e( 'Add slider images', 'els' ); ?></a>
	<a class="thickbox" href="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>?action=load_listings_list"  title="<?php _e( 'Listings', 'els' ) ?>"><?php _e( 'Load Featured Listings', 'els' ) ?></a>
</p>
