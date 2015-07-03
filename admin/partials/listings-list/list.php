<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * View for list Listings.
 *
 * @var WP_Query $listings
 * @var array $listings_status
 * @var array $listings_type
 * @var string $current_listing_type
 * @var string $current_listing_status
 * @var string $current_listing_special
 * @var int $current_posts_per_page
 */
?>
<table class="wp-list-table widefat fixed striped posts">
	<thead>
		<tr>
			<th id="cb" class="manage-column column-cb check-column" style="" scope="col">
				<label class="screen-reader-text" for="cb-select-all-1"><?php _e( 'Select All', 'els' ) ?></label>
				<input id="cb-select-all-1" type="checkbox">
			</th>
			<th id="listing_thumb" class="manage-column column-listing_thumb" style="" scope="col"><?php _e( 'Image', 'els' ) ?></th>
			<th style="" class="manage-column column-title sortable desc" id="title" scope="col"><?php _e( 'Title', 'els' ) ?></th>
			<th style="" class="manage-column column-listing" id="listing" scope="col"><?php _e( 'Listing Details', 'els' ) ?></th>
			<th style="" class="manage-column column-listing_status" id="listing_status" scope="col"><?php _e( 'Status', 'els' ) ?></th>
		</tr>
	</thead>
	<tbody id="the-list">
		<?php
		while ( $listings->have_posts() ) {
			$listings->the_post();
			?>
			<tr id="post-<?php the_ID() ?>" class="iedit author-self level-0 post-<?php the_ID() ?> type-listing has-post-thumbnail hentry">
				<th class="check-column" scope="row">
					<label for="cb-select-<?php the_ID() ?>" class="screen-reader-text"><?php echo __( 'Select', 'els' ) . ' ' . get_the_title() ?></label>
					<input type="checkbox" value="<?php the_ID() ?>" name="post[]" id="cb-select-<?php the_ID() ?>">
					<div class="locked-indicator"></div>
				</th>
				<td class="listing_thumb column-listing_thumb">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( array( 100, 100 ), array( 'class' => 'attachment-admin-list-thumb wp-post-image', 'data-id' => get_post_thumbnail_id() ) );
					}
					?>
				</td>
				<td class="post-title page-title column-title">
					<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" target="_blank"><?php the_title(); ?></a>
				</td>
				<td class="listing column-listing">
					<?php
					/* Get the post meta. */
					$property_address_suburb = get_the_term_list( get_the_ID(), 'location', '', ', ', '' );
					$heading                 = get_post_meta( get_the_ID(), 'property_heading', true );
					$beds                    = get_post_meta( get_the_ID(), 'property_bedrooms', true );
					$baths                   = get_post_meta( get_the_ID(), 'property_bathrooms', true );
					$rooms                   = get_post_meta( get_the_ID(), 'property_rooms', true );
					$land                    = get_post_meta( get_the_ID(), 'property_land_area', true );
					$land_unit               = get_post_meta( get_the_ID(), 'property_land_area_unit', true );

					if ( ! empty( $heading ) ) {
						echo '<div class="type_heading"><strong>' , $heading , '</strong></div>';
					}

					echo '<div class="type_suburb">' , $property_address_suburb , '</div>';

					if ( ! empty( $beds ) || ! empty( $baths ) ) {
						echo '<div class="epl_meta_beds_baths">';
							echo '<span class="epl_meta_beds">' , $beds , ' ' , __( 'Beds', 'epl' ) , ' | </span>';
							echo '<span class="epl_meta_baths">' , $baths , ' ' , __( 'Baths', 'epl' ) , '</span>';
						echo '</div>';
					}

					if ( ! empty( $rooms ) ) {
						if ( $rooms == 1 ) {
							echo '<div class="epl_meta_rooms">' , $rooms , ' ' , __( 'Room', 'epl' ) , '</div>';
						} else {
							echo '<div class="epl_meta_rooms">' , $rooms , ' ' , __( 'Rooms', 'epl' ) , '</div>';
						}
					}

					if ( ! empty( $land ) ) {
						echo '<div class="epl_meta_land_details">';
						echo '<span class="epl_meta_land">' , $land , '</span>';
						echo '<span class="epl_meta_land_unit"> ' , $land_unit , '</span>';
						echo '</div>';
					}
					?>
				</td>
				<td class="listing_status column-listing_status">
					<?php
					$listing_status = get_post_meta( get_the_ID(), 'property_status', true );
					if ( ! empty( $listing_status ) ) {
						echo '<span class="type_' . esc_attr( strtolower( $listing_status ) ) . '">' .
							$listings_status[ $listing_status ] . '</span>';
					}
					?>
				</td>
			</tr>
			<?php
		}
		?>
	</tbody>
	<tfoot>
		<tr>
			<th class="manage-column column-cb check-column" style="" scope="col">
				<label class="screen-reader-text" for="cb-select-all-2"><?php _e( 'Select All', 'els' ) ?></label>
				<input id="cb-select-all-2" type="checkbox">
			</th>
			<th style="" class="manage-column column-listing_thumb" scope="col"><?php _e( 'Image', 'els' ) ?></th>
			<th style="" class="manage-column column-title sortable desc" scope="col"><?php _e( 'Title', 'els' ) ?></th>
			<th style="" class="manage-column column-listing" scope="col"><?php _e( 'Listing Details', 'els' ) ?></th>
			<th style="" class="manage-column column-listing_status" scope="col"><?php _e( 'Status', 'els' ) ?></th>
		</tr>
	</tfoot>
</table>
<?php
// Pagination output.
$big            = 999999999; // need an unlikely integer
$search_for     = array( $big, '#038;' );
$replace_with   = array( '%#%', '&' );
$paginate_links = paginate_links( array(
	'base'     => str_replace( $search_for, $replace_with, esc_url( get_pagenum_link( $big ) ) ),
	'format'   => '?paged=%#%',
	'current'  => max( 1, $listings->get( 'paged' ) ),
	'total'    => $listings->max_num_pages,
	'add_args' => array(
		'listing_type'    => $current_listing_type,
		'listing_status'  => $current_listing_status,
		'posts_per_page'  => $current_posts_per_page,
		'listing_special' => $current_listing_special,
	),
) );
if ( $paginate_links ) {
	echo '<div class="tablenav bottom">' . $paginate_links . '</div>';
}

wp_reset_postdata();
