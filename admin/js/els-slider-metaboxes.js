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

	 // slides file uploads
	 var slides_frame;
	 var $image_ids = $('#els_slider_images');
	 var $slider_images = $('#els-slider-slides-container ul.slider_images');

	 $('.add_slider_images').on( 'click', 'a.images_loader', function( event ) {
	 	var $el = $(this);
	 	var attachment_ids = $image_ids.val();

	 	event.preventDefault();

	 	// If the media frame already exists, reopen it.
	 	if ( slides_frame ) {
	 		slides_frame.open();
	 		return;
	 	}

	 	// Create the media frame.
	 	slides_frame = wp.media.frames.slides = wp.media({
	 		// Set the title of the modal.
	 		title: $el.data('choose'),
	 		button: {
	 			text: $el.data('update'),
	 		},
	 		states : [
	 			new wp.media.controller.Library({
	 				title: $el.data('choose'),
	 				filterable :	'all',
	 				multiple: true,
	 			})
	 		]
	 	});

	 	// When an image is selected, run a callback.
	 	slides_frame.on( 'select', function() {

	 		var selection = slides_frame.state().get('selection');
	 		var attachment_image;

	 		selection.map( function( attachment ) {

	 			attachment = attachment.toJSON();
	 			if ( attachment.id ) {
	 				attachment_ids   = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
	 				attachment_image = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

	 				$slider_images.append('\
	 					<li class="image" data-attachment_id="' + attachment.id + '">\
	 						<img src="' + attachment_image + '" />\
	 						<ul class="actions">\
	 							<li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li>\
	 						</ul>\
	 					</li>');
	 			}

	 		});

	 		$image_ids.val( attachment_ids );
	 	});

	 	// Finally, open the modal.
	 	slides_frame.open();
	 });

	 // Image ordering
	 /*$slider_images.sortable({
	 	items: 'li.image',
	 	cursor: 'move',
	 	scrollSensitivity:40,
	 	forcePlaceholderSize: true,
	 	forceHelperSize: false,
	 	helper: 'clone',
	 	opacity: 0.65,
	 	placeholder: 'wc-metabox-sortable-placeholder',
	 	start:function(event,ui){
	 		ui.item.css('background-color','#f6f6f6');
	 	},
	 	stop:function(event,ui){
	 		ui.item.removeAttr('style');
	 	},
	 	update: function(event, ui) {
	 		var attachment_ids = '';

	 		$('#els-slider-slides-container ul li.image').css('cursor','default').each(function() {
	 			var attachment_id = jQuery(this).attr( 'data-attachment_id' );
	 			attachment_ids = attachment_ids + attachment_id + ',';
	 		});

	 		$image_ids.val( attachment_ids );
	 	}
	 });*/

	 // Remove images
	 $('#els-slider-slides-container').on( 'click', 'a.delete', function() {
	 	$(this).closest('li.image').remove();

	 	var attachment_ids = '';

	 	$('#els-slider-slides-container ul li.image').css('cursor','default').each(function() {
	 		var attachment_id = jQuery(this).attr( 'data-attachment_id' );
	 		attachment_ids = attachment_ids + attachment_id + ',';
	 	});
	 	attachment_ids = attachment_ids.replace( /,$/, '' );
	 	$image_ids.val( attachment_ids );

	 	// remove any lingering tooltips
	 	$( '#tiptip_holder' ).removeAttr( 'style' );
	 	$( '#tiptip_arrow' ).removeAttr( 'style' );

	 	return false;
	 });

	// Listings slides upload.
	if ( $( '.listings_loader' ).length > 0 ) {
	    var $els_slider_images = '';

	    $('body').on('click', '.listings_loader', function(e) {
	        e.preventDefault();
	        $els_slider_images = $( '#els_slider_images' );
	        tb_show( els_slider.add_listings, ajaxurl + '?action=load_listings_list&TB_iframe=true' );
	    });

	    window.add_listings = function() {
	        if ( $els_slider_images ) {
	            var selected_listings = jQuery('#TB_iframeContent').contents().find( 'input[type=checkbox]:checked:not(#cb-select-all-1, #cb-select-all-2)' ).closest( 'tr' );
	            selected_listings.each( function() {
	            	var img = $( 'img', this );
	            	if ( img.length ) {
	            		$els_slider_images.val( $els_slider_images.val() + ( $els_slider_images.val().length > 0 ? ',' : '' ) + img.data( 'id' ) );
		            	$slider_images.append('\
	 						<li class="image" data-attachment_id="' + img.data( 'id' ) + '">\
	 							<img src="' + img.attr( 'src' ) + '" />\
	 							<ul class="actions">\
	 								<li><a href="#" class="delete" title="' + $( '.listings_loader' ).data('delete') + '">' + $( '.listings_loader' ).data('text') + '</a></li>\
	 							</ul>\
	 						</li>');
	            	}
	            } );
	            tb_remove();
	        }
	        $els_slider_images = '';
	    };
	}

})( jQuery );
