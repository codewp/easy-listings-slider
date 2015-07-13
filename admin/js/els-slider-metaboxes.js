var tb_position;

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

	 // Controlling slider type and allowing only for adding selected type.
	 $( '#slider_type' ).on( 'change', function() {
	 	if ( 'images' === $( this ).val() ) {
	 		$( '.add_slider_images .images_loader' ).show();
	 		$( '.add_slider_images .listings_loader' ).hide();
	 	} else if ( 'listings' === $( this ).val() ) {
	 		$( '.add_slider_images .images_loader' ).hide();
	 		$( '.add_slider_images .listings_loader' ).show();
	 	} else {
	 		$( '.add_slider_images .images_loader' ).show();
	 		$( '.add_slider_images .listings_loader' ).show();
	 	}
	 });

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
	 				// Increasing number of slides in captions.
	 				$( '.els_repeatable_slide_number_field' ).each( function() {
	 					$(this).append( '<option value="' + $('option', this).length + '">' + $('option', this).length + '</option>' );
	 				});
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
	 	// Finding deleted slide number.
	 	var slide_number = $( '#els-slider-slides-container .slider_images' ).children( 'li' ).index( $(this).closest('li.image') ) + 1;

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

	 	// Removing all of captions that relates to removed slide.
	 	$( '.els_repeatable_slide_number_field' ).each( function() {
	 		if ( $( this ).val() == slide_number ) {
	 			ElsCaptionConfiguration.removeRow( $( this ).closest('tr') );
	 		}
	 	});

	 	// Decreasing number of slides in captions slide_number select.
	 	$( '.els_repeatable_slide_number_field' ).each( function() {
	 		if ( $( this ).val() > slide_number ) {
	 			// Decreasing slide numbers that are greater than removed slide number.
	 			$( this ).val( $( this ).val() - 1 );
	 		}
	 		$( 'option:last', this ).remove();
	 	});

	 	return false;
	 });

	// Listings slides upload.
	if ( $( '.listings_loader' ).length > 0 ) {
	    var $els_slider_images = '';

	    $('body').on('click', '.listings_loader', function(e) {
	        e.preventDefault();
	        $els_slider_images = $( '#els_slider_images' );
	        tb_show( els_slider.add_listings, ajaxurl + '?action=load_listings_list&width=800&height=500&TB_iframe=true' );
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
		            	// Increasing number of slides in captions.
		            	$( '.els_repeatable_slide_number_field' ).each( function() {
		            		$(this).append( '<option value="' + $('option', this).length + '">' + $('option', this).length + '</option>' );
		            	});
	            	}
	            } );
	            tb_remove();
	        }
	        $els_slider_images = '';
	    };
	}

	// Slider captions configurations.
	var ElsCaptionConfiguration = {
		init : function() {
			this.add();
			this.remove();
		},

		clone_repeatable : function( row ) {
			// Retrieve the highest current key
			var key = 1, highest = 1;
			row.parent().find( 'tr.els_repeatable_row' ).each(function() {
				var current = $(this).data( 'key' );
				if( parseInt( current ) > highest ) {
					highest = current;
				}
			});
			key = highest += 1;

			var clone = row.clone();

			/** manually update any select box values */
			clone.find( 'select' ).each(function() {
				$( this ).val( row.find( 'select[name="' + $( this ).attr( 'name' ) + '"]' ).val() );
			});

			clone.removeClass( 'els_add_blank' );

			clone.attr( 'data-key', key );
			clone.find( 'td input, td select' ).val( '' );
			clone.find( 'input, select, textarea' ).each(function() {
				var name = $( this ).attr( 'name' );

				name = name.replace( /\[(\d+)\]/, '[' + parseInt( key ) + ']');

				$( this ).attr( 'name', name ).attr( 'id', name );
			});

			return clone;
		},

		add: function() {
			$( 'body' ).on( 'click', '.submit .els_add_repeatable', function(e) {
				e.preventDefault();
				var button = $( this ),
				row = button.parent().parent().prev( 'tr' ),
				clone = ElsCaptionConfiguration.clone_repeatable( row );
				clone.insertAfter( row ).find('input, textarea, select').filter(':visible').eq(0).focus();
			});
		},

		remove : function() {
			$( 'body' ).on( 'click', '.els_remove_repeatable', function(e) {
				e.preventDefault();

				var row   = $(this).parent().parent( 'tr' ),
					count = row.parent().find( 'tr' ).length - 1,
					type  = $(this).data('type'),
					repeatable = 'tr.els_repeatable_' + type + 's';

				if( count > 1 ) {
					$( 'input, select', row ).val( '' );
					row.fadeOut( 'fast' ).remove();
				} else {
					$( 'input', row ).val( '' );
					$( 'select', row ).val( 'all' );
				}

				/* re-index after deleting */
				$(repeatable).each( function( rowIndex ) {
					$(this).find( 'input, select' ).each(function() {
						var name = $( this ).attr( 'name' );
						name = name.replace( /\[(\d+)\]/, '[' + rowIndex+ ']');
						$( this ).attr( 'name', name ).attr( 'id', name );
					});
				});
			});
		},

		removeRow: function( row ) {
			if ( row.length ) {
				var rowCount = row.closest('tbody').find( 'tr' ).length - 1;
				if ( rowCount > 1 ) {
					$( 'input, select', row ).val( '' );
					row.fadeOut( 'fast' ).remove();
				} else {
					$( 'input', row ).val( '' );
					$( 'select', row ).val( 'all' );
				}
			}
		}
	}
	ElsCaptionConfiguration.init();

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
