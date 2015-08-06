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
wp_enqueue_style( 'jssor-slider-common-style', $css_url . 'slider/jssor/common.css' );
wp_enqueue_style( 'jssor-introduction-slider', $css_url . 'slider/jssor/introduction.css' );
?>
<div id="<?php echo esc_attr( $data['id'] ) ?>" class="slider_container" style="position: relative; width: <?php echo absint( $data['width'] ) ? absint( $data['width'] ) : 980 ?>px;
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
                if ( count( $data['captions'][0] ) ) {
                    foreach ( $data['captions'][0] as $caption ) {
                        echo '<div class="caption" u="caption" t="' . esc_attr( $caption['play_in_transition_type'] ) .
                            '" t2="' . esc_attr( $caption['play_out_transition_type'] ) .
                            '" du="600" style="left:' . (int) $caption['offsetx'] . 'px;' .
                            ' top:' . (int) $caption['offsety'] . 'px;' .
                            ' width:' . ( absint( $caption['width'] ) ? absint( $caption['width'] ) . 'px;' : '100%;' ) .
                            ' height:' . ( absint( $caption['height'] ) ? absint( $caption['height'] ) . 'px;' : '100%;' ) .
                            '">';

                        // Background of caption.
                        echo '<div class="caption-background" style="' .
                            ( ! empty( $caption['background_color'] ) ? 'background:' . esc_attr( $caption['background_color'] ) . ';' : '' ) .
                            '"></div>';

                        // Forground of caption.
                        echo '<div class="caption-forground" style="' .
                            ( absint( $caption['font_size'] ) ? ' font-size:' .  absint( $caption['font_size'] ) . 'px;' : '' ) .
                            ( ! empty( $caption['font_family'] ) ? ' font-family:' . esc_attr( $caption['font_family'] ) . ';' : '' ) .
                            ( ! empty( $caption['text_align'] ) ? ' text-align:' . esc_attr( $caption['text_align'] ) . ';' : '' ) .
                            ( ! empty( $caption['color'] ) ? ' color:' . esc_attr( $caption['color'] ) . ';' : '' ) .
                            '">';
                        echo $caption['name'];
                        echo '</div>';

                        echo '</div>';
                    }
                }
                // output captions that related to this slide.
                if ( count( $data['captions'][ $i + 1 ] ) ) {
                    foreach ( $data['captions'][ $i + 1 ] as $caption ) {
                        echo '<div class="caption" u="caption" t="' . esc_attr( $caption['play_in_transition_type'] ) .
                            '" t2="' . esc_attr( $caption['play_out_transition_type'] ) .
                            '" du="600" style="left:' . (int) $caption['offsetx'] . 'px;' .
                            ' top:' . (int) $caption['offsety'] . 'px;' .
                            ' width:' . ( absint( $caption['width'] ) ? absint( $caption['width'] ) . 'px;' : '100%;' ) .
                            ' height:' . ( absint( $caption['height'] ) ? absint( $caption['height'] ) . 'px;' : '100%;' ) .
                            '">';

                        // Background of caption.
                        echo '<div class="caption-background" style="' .
                            ( ! empty( $caption['background_color'] ) ? 'background:' . esc_attr( $caption['background_color'] ) . ';' : '' ) .
                            '"></div>';

                        // Forground of caption.
                        echo '<div class="caption-forground" style="' .
                            ( absint( $caption['font_size'] ) ? ' font-size:' .  absint( $caption['font_size'] ) . 'px;' : '' ) .
                            ( ! empty( $caption['font_family'] ) ? ' font-family:' . esc_attr( $caption['font_family'] ) . ';' : '' ) .
                            ( ! empty( $caption['text_align'] ) ? ' text-align:' . esc_attr( $caption['text_align'] ) . ';' : '' ) .
                            ( ! empty( $caption['color'] ) ? ' color:' . esc_attr( $caption['color'] ) . ';' : '' ) .
                            '">';
                        echo $caption['name'];
                        echo '</div>';

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
