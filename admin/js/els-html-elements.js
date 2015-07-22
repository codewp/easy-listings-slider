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

	 $( function() {
	 	var ElsHtmlElements = {
	 	 	init: function() {
	 	 		this.colorPicker();
	 	 	},

	 	 	/**
	 	 	 * HTML Color Picker field
	 	 	 *
	 	 	 * @since  1.0.0
	 	 	 * @return void
	 	 	 */
	 	 	colorPicker: function() {
	 			$('.colorpick').wpColorPicker();
	 	 	}
	 	};
	 	ElsHtmlElements.init();
	 });

})( jQuery );
