<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var WP_Post $post
 */

wp_nonce_field( 'els_save_data', 'els_meta_nonce' );
?>
