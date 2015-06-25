<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_nonce_field( 'els_save_data', 'els_meta_nonce' );
?>
<div id="listing_gallery_container">
	<ul class="listing_images">
		<?php
		$listing_gallery = '';
		$attachments     = array();

		if ( metadata_exists( 'post', $post->ID, 'els_listing_gallery' ) ) {
			$listing_gallery = get_post_meta( $post->ID, 'els_listing_gallery', true );
		}

		if ( strlen( $listing_gallery ) ) {
			$attachments = array_filter( explode( ',', $listing_gallery ) );
		}

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

	<input type="hidden" id="els_listing_gallery_images" name="els_listing_gallery_images" value="<?php echo esc_attr( $listing_gallery ); ?>" />
</div>
<p class="add_listing_images hide-if-no-js">
	<a href="#" data-choose="<?php _e( 'Add Images to Listing Gallery', 'els' ); ?>"
	data-update="<?php _e( 'Add to gallery', 'els' ); ?>" data-delete="<?php _e( 'Delete image', 'els' ); ?>"
	data-text="<?php _e( 'Delete', 'els' ); ?>"><?php _e( 'Add listing gallery images', 'els' ); ?></a>
</p>
