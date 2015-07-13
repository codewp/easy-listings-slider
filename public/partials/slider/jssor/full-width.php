<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Full-Width theme of jssor slider.
 *
 * @var array $data
 * @var string $js_url
 * @var string $css_url
 * @var string $images_url
 */

// Registering scripts
wp_enqueue_script( 'jssor-fullwidth-slider', $js_url . 'slider/jssor/fullwidth.js', array( 'jquery' ), false, true );
wp_localize_script( 'jssor-fullwidth-slider', 'data', $data );
// Registering styles
wp_enqueue_style( 'jssor-fullwidth-slider', $css_url . 'slider/jssor/fullwidth.css' );
?>
<div id="slider_container" style="position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
            <div style="position: absolute; display: block; background: url(<?php echo esc_url( $images_url ) . 'jssor/loading.gif' ?>) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
            </div>
        </div>
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px;
            height: 500px; overflow: hidden;">
            <?php
			if ( count( $data['image_ids'] ) ) {
				foreach ( $data['image_ids'] as $image_id ) {
					echo '<div>';
					echo wp_get_attachment_image( (int) $image_id, 'large', false, array( 'u' => 'image' ) );
					echo '</div>';
				}
			}
			?>
        </div>
        <!-- bullet navigator container -->
        <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"></div>
        </div>
        <!--#endregion Bullet Navigator Skin End -->
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
        </span>
</div>
