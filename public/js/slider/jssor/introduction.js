(function( $ ) {
	'use strict';

	/**
	 * From here, you're able to define handlers for when the DOM is
	 * ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * Or when the window is loaded:
	 *
     * $( window ).load(function() {
     *
     * });
     *
     * ... and so on.
	 */

	 var options = {
	 	$ArrowKeyNavigation: true,
	 	$SlideEasing: $JssorEasing$.$EaseOutQuint,
	 	$MinDragOffsetToSlide: 20,
	 	$SlideSpacing: 0,
	    $AutoPlay: '1' === data.auto_play ? true : false,           //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
	    $AutoPlayInterval: parseInt( data.auto_play_interval ),     //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
	    $SlideDuration: parseInt( data.slide_duration ),            //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
	    $DragOrientation: parseInt( data.drag_orientation ),        //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $DisplayPieces is greater than 1, or parking position is not 0)

	    $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
	        $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
	        $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
	        $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
	        $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
	        $Lanes: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
	        $SpacingX: 4,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
	        $SpacingY: 4,                                   //[Optional] Vertical space between each item in pixel, default value is 0
	        $Orientation: 1                                 //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
	    },

	    $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
	        $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
	        $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
	        $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
	        $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
	    }
	 };

	 var jssor_slider = new $JssorSlider$("slider_container", options);

	 //responsive code begin
	 //you can remove responsive code if you don't want the slider scales while window resizes
	 function ScaleSlider() {
	     var parentWidth = jssor_slider.$Elmt.parentNode.clientWidth;
	     if (parentWidth)
	         jssor_slider.$ScaleWidth(Math.max(Math.min(parentWidth, 980), 300));
	     else
	         window.setTimeout(ScaleSlider, 30);
	 }
	 ScaleSlider();

	 $(window).bind("load", ScaleSlider);
	 $(window).bind("resize", ScaleSlider);
	 $(window).bind("orientationchange", ScaleSlider);
	 //responsive code end

})( jQuery );
