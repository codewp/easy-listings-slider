<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Filter view to allow user for filtering listings.
 *
 * @var array|WP_Query $listings
 * @var array $listings_status
 * @var array $listings_type
 * @var string $current_listing_type
 * @var string $current_listing_status
 * @var string $current_listing_special
 */
?>
<div class="tablenav top">
	<div class="actions">
		<form action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>?action=load_listings_list&amp;TB_iframe=true" method="post">
			<select name="listing_special">
				<option value="all" <?php selected( $current_listing_special, 'all' ) ?>><?php _e( 'All', 'els' ) ?></option>
				<option value="featured" <?php selected( $current_listing_special, 'featured' ) ?>><?php _e( 'Featured', 'els' ) ?></option>
			</select>
			<select name="listing_type">
				<option value="all" <?php selected( $current_listing_type, 'all' ) ?>><?php _e( 'All', 'els' ) ?></option>
				<?php
				foreach ( $listings_type as $key => $value ) {
					echo '<option value="' . esc_attr( $key ) . '" ' . selected( $current_listing_type, $key ) . '>' . $value . '</option>';
				}
				?>
			</select>
			<select name="listing_status">
				<option value="all" <?php selected( $current_listing_status, 'all' ) ?>><?php _e( 'All', 'els' ) ?></option>
				<?php
				foreach ( $listings_status as $key => $value ) {
					echo '<option value="' . esc_attr( $key ) . '" ' . selected( $current_listing_status, $key ) . '>' . $value . '</option>';
				}
				?>
			</select>
			<input type="submit" value="<?php _e( 'Filter', 'els' ) ?>" class="button" id="post-query-submit" name="filter_action">
		</form>
		<?php
		if ( $listings instanceof WP_Query ) {
			if ( $listings->have_posts() ) {
				echo '<a href="#" id="add_listings" onclick="parent.window.add_listings();" class="button media-button button-primary button-large media-button-select">' . __( 'Add to slider', 'els' ) . '</a>';
			}
		}
		?>
	</div>
</div>
