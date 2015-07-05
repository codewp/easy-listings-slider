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

	$( 'input[type=checkbox]' ).on( 'click', function( event ) {
 		if ( 'cb-select-all-2' === $( this ).attr( 'id' ) || 'cb-select-all-1' === $( this ).attr( 'id' ) ) {
 			if ( $( this ).is( ':checked' ) ) {
 				$( 'input[type=checkbox]' ).each(function() {
 					$( this ).prop( "checked", true );
 				});
 			} else {
 				$( 'input[type=checkbox]' ).each(function() {
 					$( this ).prop( "checked", false );
 				});
 			}
 		} else {
 			var all_checkboxes = $( 'input[type=checkbox]:not(#cb-select-all-1, #cb-select-all-2)' ).length;
 			var checked_checkboxes = $( 'input[type=checkbox]:checked:not(#cb-select-all-1, #cb-select-all-2)' ).length;
 			if ( all_checkboxes === checked_checkboxes ) {
 				$( '#cb-select-all-2, #cb-select-all-1' ).prop( "checked", true );
 			} else {
 				$( '#cb-select-all-2, #cb-select-all-1' ).prop( "checked", false );
 			}
 		}
	});

})( jQuery );
