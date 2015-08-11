var tb_position, TB_WIDTH, TB_HEIGHT;
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

	 /**
	  * Quick fix for thickbox issue with width and height in admin.
	  * @refer https://core.trac.wordpress.org/ticket/27473
	  *
	  * @return void
	  */
	 tb_position = function() {
	 	var isIE6 = typeof document.body.style.maxHeight === "undefined";
	 	jQuery("#TB_window").css({marginLeft: '-' + parseInt((TB_WIDTH / 2),10) + 'px', width: TB_WIDTH + 'px'});
	 	if ( ! isIE6 ) { // take away IE6
	 		jQuery("#TB_window").css({marginTop: '-' + parseInt((TB_HEIGHT / 2),10) + 'px'});
	 	}
	 }

})( jQuery );

var ElsHtmlElements = {

 	/**
 	 * HTML Color Picker field
 	 *
 	 * @since  1.0.0
 	 * @return void
 	 */
 	colorPicker: function( element_selector ) {
		if ( ! element_selector ) {
			jQuery( 'input[type=text].colorpick' ).wpColorPicker();
		} else {
			jQuery( element_selector ).wpColorPicker();
		}
 	}

};
