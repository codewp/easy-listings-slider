<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Thumbnail theme of jssor slider.
 *
 * @var array $data
 * @var string $js_url
 * @var string $css_url
 * @var string $images_url
 */

// Registering scripts
wp_enqueue_script( 'jssor-thumbnail-slider', $js_url . 'slider/jssor/thumbnail.js', array( 'jquery' ), false, true );
wp_localize_script( 'jssor-thumbnail-slider', 'data', $data );
// Registering styles
wp_enqueue_style( 'jssor-thumbnail-slider', $css_url . 'slider/jssor/thumbnail.css' );
?>
<div id="slider_container" style="position: relative; width: 720px; height: 480px; overflow: hidden;">
	<!-- Loading Screen -->
	<div u="loading" style="position: absolute; top: 0px; left: 0px;">
	    <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;
	        background-color: #000; top: 0px; left: 0px;width: 100%;height:100%;">
	    </div>
	    <div style="position: absolute; display: block; background: url(<?php echo esc_url( $images_url ) . 'jssor/loading.gif' ?>) no-repeat center center;
	        top: 0px; left: 0px;width: 100%;height:100%;">
	    </div>
	</div>

	<!-- Slides Container -->
	<div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 720px; height: 480px;
	    overflow: hidden;">
	    <?php
    	for ( $i = 0; $i < count( $data['image_ids'] ); $i++ ) {
    		echo '<div>';
    		echo wp_get_attachment_image( (int) $data['image_ids'][ $i ], 'large', false, array( 'u' => 'image' ) );
    		echo wp_get_attachment_image( (int) $data['image_ids'][ $i ], 'thumbnail', false, array( 'u' => 'thumb' ) );
    		// output captions that should be shown in all of slides.
    		if ( count( $data['captions'][0] ) ) {
    		    foreach ( $data['captions'][0] as $caption ) {
    		        echo '<div class="caption" u="caption" t="' . esc_attr( $caption['play_in_transition_type'] ) . '" t2="' . esc_attr( $caption['play_out_transition_type'] ) . '" du="600" style="position:absolute; left:' . (int) $caption['offsetx'] . 'px; top:' . (int) $caption['offsety'] . 'px; width:' . absint( $caption['width'] ) . 'px; height:' . absint( $caption['height'] ) . 'px;">';
    		        echo $caption['name'];
    		        echo '</div>';
    		    }
    		}
    		// output captions that related to this slide.
    		if ( count( $data['captions'][ $i + 1 ] ) ) {
    		    foreach ( $data['captions'][ $i + 1 ] as $caption ) {
    		        echo '<div class="caption" u="caption" t="' . esc_attr( $caption['play_in_transition_type'] ) . '" t2="' . esc_attr( $caption['play_out_transition_type'] ) . '" du="600" style="position:absolute; left:' . (int) $caption['offsetx'] . 'px; top:' . (int) $caption['offsety'] . 'px; width:' . absint( $caption['width'] ) . 'px; height:' . absint( $caption['height'] ) . 'px;">';
    		        echo $caption['name'];
    		        echo '</div>';
    		    }
    		}
    		echo '</div>';
    	}
	    ?>
	</div>

	<!-- thumbnail navigator container -->
	<div u="thumbnavigator" class="jssort07" style="width: 720px; height: 100px; left: 0px; bottom: 0px;">
		<!-- Thumbnail Item Skin Begin -->
		<div u="slides" style="cursor: default;">
		    <div u="prototype" class="p">
		        <div u="thumbnailtemplate" class="i"></div>
		        <div class="o"></div>
		    </div>
		</div>
		<!-- Thumbnail Item Skin End -->
		<!-- Arrow Left -->
		<span u="arrowleft" class="jssora11l" style="top: 123px; left: 8px;">
		</span>
		<!-- Arrow Right -->
		<span u="arrowright" class="jssora11r" style="top: 123px; right: 8px;">
		</span>
	</div>
</div>
