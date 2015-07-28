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
