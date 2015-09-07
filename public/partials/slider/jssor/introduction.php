<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Introduction theme of jssor slider.
 *
 * @var array  $data
 * @var string $js_url
 * @var string $css_url
 * @var string $images_url
 */

// Use minified libraries if SCRIPT_DEBUG is turned off
$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
// Registering scripts
wp_enqueue_script( 'jssor-introduction-slider', $js_url . 'slider/jssor/introduction' . $suffix . '.js', array( 'jquery' ), false, true );
wp_localize_script( 'jssor-introduction-slider', 'data', $data );
// Registering styles
wp_enqueue_style( 'jssor-slider-common-style', $css_url . 'slider/jssor/common' . $suffix . '.css' );
wp_enqueue_style( 'jssor-introduction-slider', $css_url . 'slider/jssor/introduction' . $suffix . '.css' );
/**
 * Printing scripts when scripts should be printed manually
 * And admin-header.php does not loaded.
 */
if ( 1 === (int) $data['print_scripts'] ) {
    wp_print_scripts( 'jssor-introduction-slider' );
    wp_print_styles( array( 'jssor-slider-common-style', 'jssor-introduction-slider' ) );
}
?>
<div id="<?php echo esc_attr( $data['id'] ) ?>" class="slider_container" style="position: relative; margin: 0 auto; width: <?php echo absint( $data['width'] ) ? absint( $data['width'] ) : 980 ?>px;
        height: <?php echo absint( $data['height'] ) ? absint( $data['height'] ) : 380 ?>px; overflow: hidden;">
        <!-- Loading Screen -->
        <div u="loading" style="position: absolute; top: 0px; left: 0px;">
            <div style="filter: alpha(opacity=70); opacity:0.7; position: absolute; display: block;

                background-color: #000; top: 0px; left: 0px;width: 100%; height:100%;">
            </div>
            <div style="position: absolute; display: block; background: url(<?php echo esc_url( $images_url ) . 'jssor/loading.gif' ?>) no-repeat center center;

                top: 0px; left: 0px;width: 100%;height:100%;">
            </div>
        </div>
        <!-- Slides Container -->
        <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: <?php echo absint( $data['width'] ) ? absint( $data['width'] ) : 980 ?>px; height: <?php echo absint( $data['height'] ) ? absint( $data['height'] ) : 380 ?>px; overflow: hidden;">
            <?php
            for ( $i = 0; $i < count( $data['image_ids'] ); $i++ ) {
                echo '<div>';
                echo wp_get_attachment_image( (int) $data['image_ids'][ $i ], 'large', false, array( 'u' => 'image' ) );
                // output captions that should be shown in all of slides.
                if ( ! empty( $data['captions'][0] ) ) {
                    foreach ( $data['captions'][0] as $caption ) {
                        $caption_color            = strval( $caption['color'] );
                        $caption_background_color = strval( $caption['background_color'] );
                        echo '<div class="caption" u="caption" t="' . esc_attr( $caption['play_in_transition_type'] ) .
                            '" t2="' . esc_attr( $caption['play_out_transition_type'] ) .
                            '" du="600" style="border-radius: 4px; left:' . (int) $caption['offsetx'] . 'px;' .
                            ' top:' . (int) $caption['offsety'] . 'px;' .
                            ' width:' . ( absint( $caption['width'] ) ? absint( $caption['width'] ) . 'px;' : '100%;' ) .
                            ' height:' . ( absint( $caption['height'] ) ? absint( $caption['height'] ) . 'px;' : '100%;' ) .
                            ' line-height:' . ( absint( $caption['line_height'] ) ? absint( $caption['line_height'] ) . 'px;' : '30px;' ) .
                            ( absint( $caption['font_size'] ) ? ' font-size:' .  absint( $caption['font_size'] ) . 'px;' : '' ) .
                            ( absint( $caption['padding'] ) ? ' padding:' .  absint( $caption['padding'] ) . 'px;' : '' ) .
                            ( ! empty( $caption['font_family'] ) ? ' font-family:' . esc_attr( $caption['font_family'] ) . ';' : '' ) .
                            ( ! empty( $caption['font_weight'] ) ? ' font-weight:' . esc_attr( $caption['font_weight'] ) . ';' : '' ) .
                            ( ! empty( $caption['font_style'] ) ? ' font-style:' . esc_attr( $caption['font_style'] ) . ';' : '' ) .
                            ( ! empty( $caption['text_align'] ) ? ' text-align:' . esc_attr( $caption['text_align'] ) . ';' : '' ) .
                            ( ! empty( $caption_color ) ? ' color:' . esc_attr( $caption_color ) . ';' : '' ) .
                            ( ! empty( $caption_background_color ) ? ' background:' . esc_attr( $caption_background_color ) . ';' : '' ) .
                            '">';
                        echo $caption['name'];
                        echo '</div>';
                    }
                }
                // output captions that related to this slide.
                if ( ! empty( $data['captions'][ $i + 1 ] ) ) {
                    foreach ( $data['captions'][ $i + 1 ] as $caption ) {
                        $caption_color            = strval( $caption['color'] );
                        $caption_background_color = strval( $caption['background_color'] );
                        echo '<div class="caption" u="caption" t="' . esc_attr( $caption['play_in_transition_type'] ) .
                            '" t2="' . esc_attr( $caption['play_out_transition_type'] ) .
                            '" du="600" style="border-radius: 4px; left:' . (int) $caption['offsetx'] . 'px;' .
                            ' top:' . (int) $caption['offsety'] . 'px;' .
                            ' width:' . ( absint( $caption['width'] ) ? absint( $caption['width'] ) . 'px;' : '100%;' ) .
                            ' height:' . ( absint( $caption['height'] ) ? absint( $caption['height'] ) . 'px;' : '100%;' ) .
                            ' line-height:' . ( absint( $caption['line_height'] ) ? absint( $caption['line_height'] ) . 'px;' : '30px;' ) .
                            ( absint( $caption['font_size'] ) ? ' font-size:' .  absint( $caption['font_size'] ) . 'px;' : '' ) .
                            ( absint( $caption['padding'] ) ? ' padding:' .  absint( $caption['padding'] ) . 'px;' : '' ) .
                            ( ! empty( $caption['font_family'] ) ? ' font-family:' . esc_attr( $caption['font_family'] ) . ';' : '' ) .
                            ( ! empty( $caption['font_weight'] ) ? ' font-weight:' . esc_attr( $caption['font_weight'] ) . ';' : '' ) .
                            ( ! empty( $caption['font_style'] ) ? ' font-style:' . esc_attr( $caption['font_style'] ) . ';' : '' ) .
                            ( ! empty( $caption['text_align'] ) ? ' text-align:' . esc_attr( $caption['text_align'] ) . ';' : '' ) .
                            ( ! empty( $caption_color ) ? ' color:' . esc_attr( $caption_color ) . ';' : '' ) .
                            ( ! empty( $caption_background_color ) ? ' background:' . esc_attr( $caption_background_color ) . ';' : '' ) .
                            '">';
                        echo $caption['name'];
                        echo '</div>';
                    }
                }
                echo '</div>';
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
