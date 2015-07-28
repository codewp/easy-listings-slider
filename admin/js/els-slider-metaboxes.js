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

	$( function() {
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
		 				$( '#els_captions .els_repeatable_row select.els_repeatable_slide_select_field' ).each( function() {
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
		 	$( '#els_captions .els_repeatable_row select.els_repeatable_slide_select_field' ).each( function() {
		 		if ( $( this ).val() == slide_number ) {
		 			ElsCaptionConfiguration.removeCaption( $( this ).closest('tr') );
		 		}
		 	});

		 	// Decreasing number of slides in captions slide_number select.
		 	$( '#els_captions .els_repeatable_row select.els_repeatable_slide_select_field' ).each( function() {
		 		if ( $( this ).val() > slide_number ) {
		 			// Decreasing slide numbers that are greater than removed slide number.
		 			$( this ).val( $( this ).val() - 1 );
		 		}
		 		$( 'option:last', this ).remove();
		 	});

		 	// Showing first caption specification.
		 	ElsCaptionConfiguration.showFirstCaption();

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
			            	$( '#els_captions .els_repeatable_row select.els_repeatable_slide_select_field' ).each( function() {
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

			/**
			 * Caption default values.
			 *
			 * @since 1.0.0
			 * @type  object
			 */
			captionDefaults : {
				offsetx : 250,
				offsety : 250,
				width : 300,
				height : 100,
				font_size : 20,
				text_align : 'center',
				color : '#000000'
			},

			/**
			 * Initialize function of the class.
			 *
			 * @since  1.0.0
			 * @return void
			 */
			init : function() {
				this.add();
				this.remove();
				this.showCaptionSpecification( true );
			},

			/**
			 * Cloning a row from captions table to creating another one.
			 *
			 * @since  1.0.0
			 * @param  object row
			 * @return object
			 */
			cloneRepeatable : function( row ) {
				// Retrieve the highest current key
				var key = 0, highest = 0;
				row.parent().find( 'tr.els_repeatable_row' ).each(function() {
					var current = $(this).data( 'key' );
					if( parseInt( current ) > highest ) {
						highest = current;
					}
				});
				key = highest += 1;

				var clone = row.clone();

				clone.removeClass( 'els_add_blank' );

				clone.attr( 'data-key', key );
				clone.find( 'td input' ).val( '' );
				clone.find( 'td select' ).each( function() {
					$( this ).val( $( 'option:first', this ).val() );
				} );
				clone.find( 'input, select, textarea' ).each(function() {
					var name = $( this ).attr( 'name' );

					name = name.replace( /\[(\d+)\]/, '[' + parseInt( key ) + ']');

					$( this ).attr( 'name', name ).attr( 'id', name );
				});

				return clone;
			},

			/**
			 * Cloning specificatoin of a captoin to creating another one.
			 *
			 * @since  1.0.0
			 * @param  object specification
			 * @return object
			 */
			cloneSpecification: function( specification ) {
				// Retrieve the highest current key
				var key = specification.data( 'key' ) ? specification.data( 'key' ) + 1 : 1;
				var clone = specification.clone();
				// Removing tinymce editor from clone and adding textarea instead of it to clone.
				clone.find( '.caption_content' ).html( '<textarea id="caption_editor_' + key + '" name="els_slider_captions[' + key + '][name]"></textarea>' );
				clone.attr( 'data-key', key );
				clone.attr( 'id', clone.attr( 'id' ).replace( /\d+/g, key ) );
				clone.find( 'input, textarea' ).val( '' );
				clone.find( 'select' ).each( function() {
					$( this ).val( $( 'option:first', this ).val() );
				} );
				clone.find( 'input, select, textarea' ).each(function() {
					var name = $( this ).attr( 'name' );
					var id   = $( this ).attr( 'id' );
					if ( name ) {
						name = name.replace( /\[(\d+)\]/, '[' + parseInt( key ) + ']');
						$( this ).attr( 'name', name );
					}
					if ( id && id.match( /\[(\d+)\]/ ) ) {
						id = id.replace( /\[(\d+)\]/, '[' + parseInt( key ) + ']');
						$( this ).attr( 'id', id );
					}
				});
				clone.find('div').each( function() {
					var id = $( this ).prop( 'id' );
					if ( id && id.match( /caption/ ) ) {
						id = id.replace( /\d+/g, parseInt( key ) );
						$( this ).prop( 'id', id ).prop( 'name', id );
					}
				});
				clone.find( 'a' ).each( function() {
					var href = $( this ).attr( 'href' );
					if ( href ) {
						href = href.replace( /\d+/g, parseInt( key ) );
						$( this ).attr( 'href', href );
					}
				});

				return clone;
			},

			/**
			 * Adding a new caption.
			 *
			 * @since  1.0.0
			 * @return void
			 */
			add: function() {
				$( 'body' ).on( 'click', '.submit .els_add_repeatable', function(e) {
					e.preventDefault();
					var button = $( this ),
					row = button.parent().parent().prev( 'tr' ),
					clone = ElsCaptionConfiguration.cloneRepeatable( row );
					clone.insertAfter( row ).find('input, textarea, select').filter(':visible').eq(0).focus();
					// Cloning specification.
					var $specification = $( '.caption_specification #caption_spec_' + ( row.data( 'key' ) ? row.data( 'key' ) : 0 ) );
					var specification_clone = ElsCaptionConfiguration.cloneSpecification( $specification );
					$( '.caption_specification' ).children().hide();
					specification_clone.insertAfter( $specification );
					// Applying tinymce to cloned specification textarea.
					tinymce.init( {
						selector: '#caption_detail_' + specification_clone.data( 'key' ) + ' .caption_content textarea'
					} );
					specification_clone.show();
					ElsCaptionConfiguration.showCaptionSpecification( false );
				});
			},

			/**
			 * Removing a caption by clicking on the remove button.
			 *
			 * @sine   1.0.0
			 * @return void
			 */
			remove : function() {
				$( 'body' ).on( 'click', '.els_remove_repeatable', function(e) {
					e.preventDefault();

					var row   = $(this).parent().parent( 'tr' ),
						count = row.parent().find( 'tr' ).length - 1,
						key   = row.data( 'key' ) ? row.data( 'key' ) : 0;

					if( count > 1 ) {
						$( 'input, select', row ).val( '' );
						row.fadeOut( 'fast' ).remove();
						// Removing caption specification for selected caption.
						$( '.caption_specification #caption_spec_' + key ).remove();
					} else {
						$( 'input', row ).val( '' );
						$( 'select', row ).val( 'all' );
						// Removing caption specification values.
						$( 'input:not([type="button"])', '.caption_specification #caption_spec_' + key ).val( '' );
						$( 'select', '.caption_specification #caption_spec_' + key ).each( function() {
							$( this ).val( $( 'option:first', this ).val() );
						});
						tinymce.get( 'caption_editor_' + key ).setContent('');
					}

					// Showing first caption specification.
					ElsCaptionConfiguration.showFirstCaption();
				});
			},

			/**
			 * Removing a caption that are related to removed slide.
			 *
			 * @since  1.0.0
			 * @param  object row
			 * @return void
			 */
			removeCaption: function( row ) {
				if ( row.length ) {
					var rowCount = row.closest('tbody').find( 'tr' ).length - 1,
						key      = row.data( 'key' ) ? row.data( 'key' ) : 0;
					if ( rowCount > 1 ) {
						$( 'input, select', row ).val( '' );
						row.fadeOut( 'fast' ).remove();
						// Removing caption specification for selected caption.
						$( '.caption_specification #caption_spec_' + key ).remove();
					} else {
						$( 'input', row ).val( '' );
						$( 'select', row ).val( 'all' );
						// Removing caption specification values.
						$( 'input:not([type="button"])', '.caption_specification #caption_spec_' + key ).val( '' );
						$( 'select', '.caption_specification #caption_spec_' + key ).each( function() {
							$( this ).val( $( 'option:first', this ).val() );
						});
						tinymce.get( 'caption_editor_' + key ).setContent('');
					}
				}
			},

			/**
			 * Show specification of the caption like it's content, offsets, width, etc.
			 *
			 * @sice   1.0.0
			 * @param  boolean showFirstSpec  showing first caption specification or not.
			 * @return void
			 */
			showCaptionSpecification: function( showFirstSpec ) {
				// jQuery tabs for caption_spec_tabs.
				$( '.caption_spec_tabs' ).tabs();
				if ( showFirstSpec ) {
					// Showing first caption specification on init.
					$( '.caption_specification .caption_spec_tabs:first' ).show();
				}
				// Showing selected caption specification.
				$( '#els_captions tbody tr.els_repeatable_row' ).on('click', function(event) {
					event.preventDefault();
					var key = $( this ).data( 'key' ) > 0 ? $( this ).data( 'key' ) : 0;
					$( '.caption_specification' ).children().hide();
					$( '.caption_specification #caption_spec_' + key ).show();

					// Preview caption.
					ElsCaptionConfiguration.captionsPreview( key );
				});
			},

			/**
			 * Preview caption on the test image slider.
			 *
			 * @since  1.0.0
			 * @param  int id
			 * @return void
			 */
			captionsPreview: function( id ) {
				var offsetX          = $( 'input[name="els_slider_captions[' + id + '][offsetx]"]' ).val();
				var offsetY          = $( 'input[name="els_slider_captions[' + id + '][offsety]"]' ).val();
				var width            = $( 'input[name="els_slider_captions[' + id + '][width]"]' ).val();
				var height           = $( 'input[name="els_slider_captions[' + id + '][height]"]' ).val();
				var font_size        = $( 'input[name="els_slider_captions[' + id + '][font_size]"]' ).val();
				var text_align       = $( 'select[name="els_slider_captions[' + id + '][text_align]"]' ).val();
				var color            = $( 'input[name="els_slider_captions[' + id + '][color]"]' ).val();
				var background_color = $( 'input[name="els_slider_captions[' + id + '][background_color]"]' ).val();
				var captionContent   = tinymce.get( 'caption_editor_' + id ) ?
					tinymce.get( 'caption_editor_' + id ).getContent() : '';
				if ( ! captionContent ) {
					$( '#preview_caption' ).html( '' );
					return;
				}
				var caption =  '<div class="caption-background" style="' +
				( background_color ? 'background: ' + background_color + ';' : '' ) + '">' +
				'</div>' +
				'<div class="caption-forground" style="' +
				'font-size: ' + ( parseInt( font_size ) > 0 ? parseInt( font_size ) : this.captionDefaults.font_size ) + 'px;' +
				' text-align:' + ( text_align ? text_align : this.captionDefaults.text_align ) + ';' +
				' color:' + ( color ? color : this.captionDefaults.color ) + ';' +
				'">' + captionContent + '</div>';

				$( '#preview_caption' ).css( {
					'left' : parseInt( offsetX ) >= 0 ? parseInt( offsetX ) + 'px' : this.captionDefaults.offsetx + 'px',
					'top' : parseInt( offsetY ) >= 0 ? parseInt( offsetY ) + 'px' : this.captionDefaults.offsety + 'px',
					'width' : parseInt( width ) > 0 ? parseInt( width ) + 'px' : this.captionDefaults.width + 'px',
					'height' : parseInt( height ) > 0 ? parseInt( height ) + 'px' : this.captionDefaults.height + 'px'
				} );

				$( '#preview_caption' ).html( caption );
			},

			/**
			 * Showing first caption details.
			 *
			 * @since  1.0.0
			 * @return void
			 */
			showFirstCaption: function() {
				// Showing first caption specification.
				$( '.caption_specification' ).children().hide();
				var $first_caption_spec = $( '.caption_specification .caption_spec_tabs:first' );
				$first_caption_spec.show();
				// Showing first caption in preview.
				var id = $first_caption_spec.data( 'key' ) ? $first_caption_spec.data( 'key' ) : 0;
				this.captionsPreview( id );
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
	});

})( jQuery );
