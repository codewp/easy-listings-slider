<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @var string $images_url
 */
?>
<p class="about-description"><?php _e( 'Use the tips below to get started using Easy Listings Slider. You will be up and running in no time!', 'els' ); ?></p>
<div class="changelog">
	<h3><?php _e( 'Creating Your First Slider', 'els' );?></h3>
	<div class="feature-section">
		<img src="<?php echo esc_url( $images_url ) ?>welcome/new-slider.png" class="els-welcome-screenshots" />
		<h4><?php printf( __( '<a href="%s">Sliders &rarr; Add Slider</a>', 'els' ), admin_url( 'post-new.php?post_type=els_slider' ) ); ?></h4>
		<p><?php printf( __( 'The Sliders menu is your access point for all aspects of your Easy Listings Slider, slider creation and setup. To create your first slider, simply click Add Slider and then fill out the slider details.', 'els' ) ); ?></p>

		<h4><?php _e( 'Slider Slides', 'els' ) ?></h4>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/slides.png" class="els-welcome-screenshots" />
		<p><?php _e( 'You can add images and listings images to slider as slides from slides metabox as shown in the image, please note that for adding listings images to slider you should choose slider type as ( Listings or Listings And Images ) from slider general settings.', 'els' ) ?></p>

		<h4><?php _e( 'Slider Captions', 'els' ) ?></h4>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/captions-preview.png" class="els-welcome-screenshots" />
		<p><?php _e( 'You can add captions for slides from Slider Captions metabox, also as shown in above image you can preview each of captions on creation or by clicking on it from captions table.', 'els' ) ?></p>
		<p>
			<?php _e( 'For adding new caption, you can click on add new caption button as shown in below image. From captions table you can select each caption slide by clicking on Slide number select box and selecting desired slide number so this caption will show on selected slide or you can select All to showing caption on all of slides.', 'els' ) ?>
		</p>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/captions.png" class="els-welcome-screenshots" />

		<h4><?php _e( 'Caption Specification', 'els' ) ?></h4>
		<p><?php _e( 'As shown in above image you can set specification of each caption by choosing it from captions table. In caption specification section you can set text content of caption and it\'s transitions and styles.', 'els' ) ?></p>
	</div>

	<h3><?php _e( 'How to preview sliders after creating them', 'els' ) ?></h3>
	<div class="feature-section">
		<img src="<?php echo esc_url( $images_url ) ?>welcome/slider-preview.png" class="els-welcome-screenshots" />
		<img src="<?php echo esc_url( $images_url ) ?>welcome/sliders.png" class="els-welcome-screenshots" />
		<p><?php printf( __( 'After creating slider, you can preview it from <a href="%s">Easy Listings Slider sliders page</a>. For preview each slider you can click on Preview button to preview it as shown in above image.', 'els' ), admin_url( 'edit.php?post_type=els_slider' ) ) ?></p>
	</div>

	<h3><?php _e( 'How to add slider to pages', 'els' );?></h3>
	<div class="feature-section">
		<p><?php _e( 'After creating slider, you can add it to page by one of below methods', 'els' ) ?></p>
		<h4><?php _e( 'Method One', 'els' ) ?></h4>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/add-slider.png" class="els-welcome-screenshots" />
		<p><?php printf( __( 'In Wordpress %s and above a button will adds to pages editor as shown in above image and you can see and select your created sliders and it will adds to page content.', 'els' ), '3.9' ) ?></p>
		<h4><?php _e( 'Method two', 'els' ) ?></h4>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/sliders.png" class="els-welcome-screenshots" />
		<p><?php _e( 'You can copy slider shortcode and paste it inside pages content. Slider shortcode is shown above image inside rectangle.', 'els' ) ?></p>
	</div>

	<h3><?php _e( 'Single Listing Gallery Slider', 'els' );?></h3>
	<div class="feature-section">
		<h4><?php _e( 'How to enable single listing gallery slider', 'els' ) ?></h4>
		<p><?php printf( __( 'Go to <a href="%s">Easy Listings Slider Settings</a> and check that is <strong>Display slider in single listing page</strong> feature enabled. By default this feature is enabled by <strong>Easy Listings Slider</strong>.', 'els' ), admin_url( 'edit.php?post_type=els_slider&page=els-settings' ) ) ?></p>
		<h4><?php _e( 'How to add gallery images to single listing page slider', 'els' ) ?></h4>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/listing-gallery.png" class="els-welcome-screenshots" />
		<p><?php _e( 'After activating Easy Listings Slider a new metabox will add to Listings page as shown in the above image. By means of this metabox you can add images to listing gallery and Easy Listings Slider will show this gallery as slider in single listing page.', 'els' ) ?></p>
		<h4><?php _e( 'Settings of single listing page slider', 'els' ) ?></h4>
		<img src="<?php echo esc_url( $images_url ) ?>welcome/els-settings.png" class="els-welcome-screenshots" />
		<p><?php printf( __( 'You can set settings of slider in single listing page like it\'s width, height, theme, autoplay and etc by referring to <a href="%s">Easy Listings Slider Settings</a> page.', 'els' ), admin_url( 'edit.php?post_type=els_slider&page=els-settings' ) ) ?></p>
	</div>
</div>
