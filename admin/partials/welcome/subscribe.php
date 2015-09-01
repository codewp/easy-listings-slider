<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
<div class="popup" data-popup="popup-1">
    <div class="popup-inner">
    	<p id="popup-message" style="display: none;"></p>
        <h2><?php _e( 'Subscribe via email', 'els' ) ?></h2>
        <p><?php _e( 'Subscribe for getting our update news and news about our free plugins for Easy Property Listings and your real estate website.', 'els' ) ?></p>
        <input type="text" class="popup-input" name="name" placeholder="<?php _e( 'Name', 'els' ) ?>" id="name">
        <input type="email" class="popup-input" name="email" placeholder="<?php _e( 'Email', 'els' ) ?>" id="email">
    	<input class="emerald-flat-button" type="button" value="<?php _e( 'Subscribe', 'els' ) ?>" id="subscribe">
    	<input class="emerald-flat-button" data-popup-close="popup-1" type="button" value="<?php _e( 'Close', 'els' ) ?>" id="close">
        <a class="popup-close" data-popup-close="popup-1" style="color: #fff;" href="#">x</a>
    </div>
</div>
