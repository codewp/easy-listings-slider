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

	 $( "#slider-data-container .tabs" ).tabs().addClass( "ui-tabs-vertical ui-helper-clearfix" );
	 $( "#slider-data-container .tabs li" ).removeClass( "ui-corner-top" ).addClass( "ui-corner-left" );

})( jQuery );
