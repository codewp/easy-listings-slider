<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Introduction theme of jssor slider.
 *
 * @var array $data
 * @var string $js_url
 * @var string $css_url
 * @var string $images_url
 */

// Registering scripts
wp_enqueue_script( 'jssor-introduction-slider', $js_url . 'slider/jssor/introduction.js', array( 'jquery' ), false, true );
wp_localize_script( 'jssor-introduction-slider', 'data', $data );
// Registering styles
wp_enqueue_style( 'jssor-introduction-slider', $css_url . 'slider/jssor/introduction.css' );
?>
<div id="slider_container" style="position: relative; width: 980px;
        height: 380px; overflow: hidden;">
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;

                background-color: #000; top: 0px; left: 0px;width: 100%; height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;

                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 980px; height: 380px; overflow: hidden;">
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
        <div u="navigator" class="jssorb03" style="bottom: 16px; right: 6px;">
            <!-- bullet navigator item prototype -->
            <div u="prototype"><div u="numbertemplate"></div></div>
        </div>
        <!--#endregion Bullet Navigator Skin End -->
        <!-- Arrow Left -->
        <span u="arrowleft" class="jssora20l" style="top: 123px; left: 8px;">
        </span>
        <!-- Arrow Right -->
        <span u="arrowright" class="jssora20r" style="top: 123px; right: 8px;">
        </span>
</div>
