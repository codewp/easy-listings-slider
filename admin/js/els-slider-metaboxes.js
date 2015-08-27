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
		 $( "#slider-data-container .tabs" ).tabs().addClass( 'ui-tabs' );

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
		 var slidesFrame;
		 var $image_ids = $('#els_slider_images');
		 var $slider_images = $('#els-slider-slides-container ul.slider_images');

		 $('.add_slider_images').on( 'click', 'a.images_loader', function( event ) {
		 	var $el = $(this);
		 	var attachment_ids = $image_ids.val();

		 	event.preventDefault();

		 	// If the media frame already exists, reopen it.
		 	if ( slidesFrame ) {
		 		slidesFrame.open();
		 		return;
		 	}

		 	// Create the media frame.
		 	slidesFrame = wp.media.frames.slides = wp.media({
		 		// Set the title of the modal.
		 		title: $el.data('choose'),
		 		button: {
		 			text: $el.data('update')
		 		},
		 		states : [
		 			new wp.media.controller.Library({
		 				title: $el.data('choose'),
		 				filterable :	'all',
		 				multiple: true
		 			})
		 		]
		 	});

		 	// When an image is selected, run a callback.
		 	slidesFrame.on( 'select', function() {

		 		var selection = slidesFrame.state().get('selection');
		 		var attachment_image;

		 		selection.map( function( attachment ) {

		 			attachment = attachment.toJSON();
		 			if ( attachment.id ) {
		 				attachment_ids   = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
		 				attachment_image = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;
		 				var slideNumber  = ( $( 'li.image', $slider_images ).length ? $( 'li.image', $slider_images ).length : 0 ) + 1;

		 				$slider_images.append('\
		 					<li class="image" data-attachment_id="' + attachment.id + '">\
		 						<img src="' + attachment_image + '" />\
		 						<ul class="actions">\
		 							<li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li>\
		 						</ul>\
		 						<span class="slide-number">#' + slideNumber + '</span>\
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
		 	slidesFrame.open();
		 });

		 // Image ordering
		 $slider_images.sortable({
		 	items: 'li.image',
		 	cursor: 'move',
		 	scrollSensitivity:40,
		 	forcePlaceholderSize: true,
		 	forceHelperSize: false,
		 	helper: 'clone',
		 	opacity: 0.65,
		 	placeholder: 'els-metabox-sortable-placeholder',
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

		 		// Ordering numbers of slides.
		 		$('#els-slider-slides-container ul li.image span.slide-number').each( function( i ) {
		 			$( this ).html( '#' + ( i + 1 ) );
		 		});
		 	}
		 });

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
		            		var slideNumber  = ( $( 'li.image', $slider_images ).length ? $( 'li.image', $slider_images ).length : 0 ) + 1;
		            		$els_slider_images.val( $els_slider_images.val() + ( $els_slider_images.val().length > 0 ? ',' : '' ) + img.data( 'id' ) );
			            	$slider_images.append('\
		 						<li class="image" data-attachment_id="' + img.data( 'id' ) + '">\
		 							<img src="' + img.attr( 'src' ) + '" />\
		 							<ul class="actions">\
		 								<li><a href="#" class="delete" title="' + $( '.listings_loader' ).data('delete') + '">' + $( '.listings_loader' ).data('text') + '</a></li>\
		 							</ul>\
		 							<span class="slide-number">#' + slideNumber + '</span>\
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

		/**
		 * Slider captions configurations.
		 * Making this Object as window global variable to accessing it
		 * from captions tinymce editor.
		 *
		 * @since 1.0.0
		 * @type  Object
		 */
		window.ElsCaptionConfiguration = {

			/**
			 * Caption default values.
			 *
			 * @since 1.0.0
			 * @type  object
			 */
			captionDefaults : {
				name : '',
				offsetx : 250,
				offsety : 250,
				width : 300,
				height : 100,
				line_height : 30,
				padding : 0,
				font_size : 20,
				font_family : 'Tahoma',
				font_weight : 'normal',
				font_style : 'normal',
				text_align : 'center',
				color : '#000000',
				background_color : '',
				play_in_transition_type : '*',
				play_out_transition_type : '*'
			},

			/**
			 * Cache object for Google WebFonts to don't adding them to page multi times.
			 *
			 * @since 1.0.0
			 * @type  Object
			 */
			cacheGoogleFonts : {},

			/**
			 * Initialize function of the class.
			 *
			 * @since  1.0.0
			 * @return void
			 */
			init : function() {
				this.add();
				this.remove();
				this.showCaptionSpecification();
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
				// Removing tinymce editor from clone and using textarea instead of it to clone.
				clone.find( '.caption_content .wp-editor-container' ).html( function() {
					var textarea = $( this ).find( 'textarea' );
					textarea.attr( 'id', textarea.attr( 'id' ).replace( /\d+/g, key ) );
					textarea.attr( 'name', textarea.attr( 'name' ).replace( /\d+/g, key ) );
					textarea.html( '' ).css( 'display', 'block' );
					return textarea;
				} );
				// Changing active tab in tinymce editor to visual tab.
				clone.find( '#wp-caption_editor_' + ( key - 1 ) + '-wrap' ).attr( 'class', function( index, value ) {
					return value.replace( /html-active/, 'tmce-active' );
				} );
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
				clone.find('div, button, a').each( function() {
					var id = $( this ).prop( 'id' );
					if ( id && id.match( /caption/ ) ) {
						id = id.replace( /\d+/g, parseInt( key ) );
						$( this ).prop( 'id', id ).prop( 'name', id );
					}
					// Caption editor switch buttons.
					if ( $( this ).hasClass( 'wp-switch-editor' ) ) {
						var editorId = $( this ).data( 'wp-editor-id' );
						if ( editorId ) {
							editorId = editorId.replace( /\d+/g, parseInt( key ) );
							$( this ).attr( 'data-wp-editor-id', editorId );
						}
					}
					// Replacing href in <a> tags.
					if ( 'A' === $( this ).prop( 'tagName' ) ) {
						var href = $( this ).attr( 'href' );
						if ( href ) {
							href = href.replace( /\d+/g, parseInt( key ) );
							$( this ).attr( 'href', href );
						}
					}
				});

				// Setting default values to clone.
				this.setCaptionSpecDefaults( key, clone, true );

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
					// Applying caption editor tinymce to cloned specification textarea.
					captionEditorView.create( specification_clone.data( 'key' ) );
					specification_clone.show();
					ElsCaptionConfiguration.showCaptionSpecification( specification_clone.data( 'key' ) );
					// Preview new caption.
					ElsCaptionConfiguration.captionsPreview( specification_clone.data( 'key' ) );
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
						$( '.caption_specification #caption_spec_' + key ).fadeOut( 'fast' ).remove();
					} else {
						$( 'input', row ).val( '' );
						$( 'select', row ).val( 'all' );
						// Setting default values to caption specifications.
						ElsCaptionConfiguration.setCaptionSpecDefaults( key );
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
						// Setting default values to caption specifications.
						this.setCaptionSpecDefaults( key );
						tinymce.get( 'caption_editor_' + key ).setContent('');
					}
				}
			},

			/**
			 * Show specification of the caption like it's content, offsets, width, etc.
			 *
			 * @sice   1.0.0
			 * @param  int captionId Id of caption that should be shown otherwise show first caption.
			 * @return void
			 */
			showCaptionSpecification: function( captionId ) {
				// jQuery tabs for caption_spec_tabs.
				$( '.caption_spec_tabs' ).tabs();
				// Removing all of active class from table rows.
				$( '#els_captions tbody tr.els_repeatable_row' ).removeClass( 'active' );
				if ( captionId >= 0 ) {
					// Showing specified caption specification.
					$( '.caption_specification #caption_spec_' + captionId ).show();
					// Setting active class to specified caption row.
					$( '#els_captions tbody tr.els_repeatable_row[data-key="' + captionId + '"]' ).addClass('active');
				} else {
					// Showing first caption specification on init.
					$( '.caption_specification .caption_spec_tabs:first' ).show();
					// Setting active class to first row.
					$( '#els_captions tbody tr.els_repeatable_row:first' ).addClass('active');
				}
				// Showing selected caption specification.
				$( '#els_captions tbody tr.els_repeatable_row' ).on('click', function(event) {
					event.preventDefault();

					// Removing all of active class from table rows.
					$( '#els_captions tbody tr.els_repeatable_row' ).removeClass( 'active' );
					// Setting active class to clicked row.
					$( this ).addClass('active');

					var key = $( this ).data( 'key' ) > 0 ? $( this ).data( 'key' ) : 0;
					$( '.caption_specification' ).children().hide();
					$( '.caption_specification #caption_spec_' + key ).show();

					// Preview caption.
					ElsCaptionConfiguration.captionsPreview( key );
				});
				// Using color picker in specifications.
				jQuery( 'input[type=text].colorpick' ).wpColorPicker({
					change: function( event, ui ) {
						var name = $( this ).attr( 'name' );
						if ( /\[background_color\]/.test( name ) ) {
							var background_color = ui.color.toString();
							// converting background color to RGBA mode.
							if ( background_color.length ) {
								background_color = colorConverter.hexToRgba( background_color, 60 );
							}
							// Setting background-color of caption in caption preview.
							$( '#preview_caption .caption' ).css( 'background-color', background_color );
						} else if ( /\[color\]/.test( name ) ) {
							// Setting color of caption in caption preview.
							$( '#preview_caption .caption' ).css( 'color', ui.color.toString() );
						}
					}
				});
				// Controlling FontOptions
				this.fontOptionControl();
				this.updateCaptionPreview();
			},

			/**
			 * Setting default values to caption specification.
			 *
			 * @since 1.0.0
			 * @param int    key
			 * @param object captionSpec
			 * @param boolean removeIris Removing iris color picker and creating new color picker.
			 */
			setCaptionSpecDefaults: function( key, captionSpec, removeIris ) {
				if ( ! captionSpec ) {
					captionSpec = $( '.caption_specification #caption_spec_' + key );
				}
				$( 'textarea[name="els_slider_captions[' + key + '][name]"]', captionSpec ).val( this.captionDefaults.name );
				$( 'select[name="els_slider_captions[' + key + '][play_in_transition_type]"]', captionSpec ).val( this.captionDefaults.play_in_transition_type );
				$( 'select[name="els_slider_captions[' + key + '][play_out_transition_type]"]', captionSpec ).val( this.captionDefaults.play_out_transition_type );
				$( 'input[name="els_slider_captions[' + key + '][offsetx]"]', captionSpec ).val( this.captionDefaults.offsetx );
				$( 'input[name="els_slider_captions[' + key + '][offsety]"]', captionSpec ).val( this.captionDefaults.offsety );
				$( 'input[name="els_slider_captions[' + key + '][width]"]', captionSpec ).val( this.captionDefaults.width );
				$( 'input[name="els_slider_captions[' + key + '][height]"]', captionSpec ).val( this.captionDefaults.height );
				$( 'input[name="els_slider_captions[' + key + '][line_height]"]', captionSpec ).val( this.captionDefaults.line_height );
				$( 'input[name="els_slider_captions[' + key + '][padding]"]', captionSpec ).val( this.captionDefaults.padding );
				$( 'input[name="els_slider_captions[' + key + '][font_size]"]', captionSpec ).val( this.captionDefaults.font_size );
				$( 'select[name="els_slider_captions[' + key + '][font_family]"]', captionSpec ).val( this.captionDefaults.font_family );
				$( 'select[name="els_slider_captions[' + key + '][font_weight]"]', captionSpec ).val( this.captionDefaults.font_weight );
				// Enabling disabled font-weights.
				$( 'select[name="els_slider_captions[' + key + '][font_weight]"] option', captionSpec ).each( function() {
					$( this ).prop( 'disabled', false );
				});
				$( 'select[name="els_slider_captions[' + key + '][font_style]"]', captionSpec ).val( this.captionDefaults.font_style );
				// Enabling disabled font-styles.
				$( 'select[name="els_slider_captions[' + key + '][font_style]"] option', captionSpec ).each( function() {
					$( this ).prop( 'disabled', false );
				});
				$( 'select[name="els_slider_captions[' + key + '][text_align]"]', captionSpec ).val( this.captionDefaults.text_align );
				if ( ! removeIris ) {
					$( 'input[name="els_slider_captions[' + key + '][color]"]', captionSpec ).iris( 'color', this.captionDefaults.color );
					$( 'input[name="els_slider_captions[' + key + '][background_color]"]', captionSpec ).val( this.captionDefaults.background_color );
					$( '#els-els_slider_captions' + key + 'background_color-wrap a.wp-color-result', captionSpec ).css( 'background-color', '' );
				} else {
					/**
					 * Removing wp-color-picker created elements.
					 * And replacing them with input types so color-picker can create new color-picker on input types.
					 */
					$( '#caption_style_' + key + ' .wp-picker-container', captionSpec ).each( function() {
						var name = $( 'input[type=text].colorpick', this ).attr( 'name' );
						var value = ElsCaptionConfiguration.captionDefaults.color;
						if ( /background_color/.test( name ) ) {
							value = ElsCaptionConfiguration.captionDefaults.background_color;
						}
						$( 'input[type=text].colorpick', this ).val( value );
						$( this ).closest( '.col-value' ).html( $( 'input[type=text].colorpick', this ) );
					});
				}
			},

			/**
			 * Updating content and specification of caption in the caption preview.
			 *
			 * @since  1.0.0
			 * @return void
			 */
			updateCaptionPreview: function() {
				$( '.caption_spec_tabs input, .caption_spec_tabs select, .caption_spec_tabs textarea' ).not( 'input.colorpick' ).on( 'change', function() {
					var captionId = $( this ).closest( 'div.caption_spec_tabs' ).data( 'key' );
					ElsCaptionConfiguration.captionsPreview( captionId );
				});
				// Removing color and background-color of caption on clearing color.
				$( 'input[type=button].wp-picker-clear' ).on( 'click', function() {
					var name = $( this ).siblings( 'input[type=text].colorpick' ).attr( 'name' );
					if ( /\[background_color\]/.test( name ) ) {
						// Removing background color of caption in caption preview.
						$( '#preview_caption .caption' ).css( 'background-color', '' );
					} else if ( /\[color\]/.test( name ) ) {
						// Using default color for caption in caption preview.
						$( '#preview_caption .caption' ).css( 'color', ElsCaptionConfiguration.captionDefaults.color );
					}
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
				var offsetX          = $( 'input[name="els_slider_captions[' + id + '][offsetx]"]' ).val(),
					offsetY          = $( 'input[name="els_slider_captions[' + id + '][offsety]"]' ).val(),
					width            = $( 'input[name="els_slider_captions[' + id + '][width]"]' ).val(),
					height           = $( 'input[name="els_slider_captions[' + id + '][height]"]' ).val(),
					line_height		 = $( 'input[name="els_slider_captions[' + id + '][line_height]"]' ).val(),
					padding			 = $( 'input[name="els_slider_captions[' + id + '][padding]"]' ).val(),
					font_size        = $( 'input[name="els_slider_captions[' + id + '][font_size]"]' ).val(),
					font_family		 = $( 'select[name="els_slider_captions[' + id + '][font_family]"]' ).val(),
					font_weight      = $( 'select[name="els_slider_captions[' + id + '][font_weight]"]' ).val(),
					font_style 		 = $( 'select[name="els_slider_captions[' + id + '][font_style]"]' ).val(),
					text_align       = $( 'select[name="els_slider_captions[' + id + '][text_align]"]' ).val(),
					color            = $( 'input[name="els_slider_captions[' + id + '][color]"]' ).val(),
					background_color = $( 'input[name="els_slider_captions[' + id + '][background_color]"]' ).val(),
					captionContent   = tinymce.get( 'caption_editor_' + id ) ?
						tinymce.get( 'caption_editor_' + id ).getContent() : '';

				if ( ! captionContent ) {
					$( '#preview_caption' ).html( '' );
					return;
				}
				if ( els_slider.google_fonts[ font_family ] !== undefined ) {
					var link = "//fonts.googleapis.com/css?family=" + font_family;
					if ( 'normal' !== font_weight  ) {
					    link += ':' + font_weight;
					}
					if ( 'italic' === font_style ) {
						if ( -1 === link.indexOf( ':' ) ) {
							link += ":";
						}
					    link += 'italic';
					}
					if ( ! this.cacheGoogleFonts[ font_family ] || ! this.cacheGoogleFonts[ font_family ][ link ] ) {
						jQuery( 'body' ).append( '<link href="' + link + '" rel="stylesheet" type="text/css">' );
						// Caching this font link.
						if ( ! this.cacheGoogleFonts[ font_family ] ) {
							this.cacheGoogleFonts[ font_family ] = {};
						}
						this.cacheGoogleFonts[ font_family ][ link ] = true;
					}
				}
				// converting colors to RGBA mode.
				if ( background_color.length ) {
					background_color = colorConverter.hexToRgba( background_color, 60 );
				}

				var caption = '<div class="caption" style="border-radius: 4px;' +
				' width: ' + ( parseInt( width ) > 0 ? parseInt( width ) + 'px;' : this.captionDefaults.width + 'px;' ) +
				' height: ' + ( parseInt( height ) > 0 ? parseInt( height ) + 'px;' : this.captionDefaults.height + 'px;' ) +
				' line-height: ' + ( parseInt( line_height ) >= 8 ? parseInt( line_height ) + 'px;' : this.captionDefaults.line_height + 'px;' ) +
				' font-size: ' + ( parseInt( font_size ) > 0 ? parseInt( font_size ) : this.captionDefaults.font_size ) + 'px;' +
				' padding: ' + ( parseInt( padding ) > 0 ? parseInt( padding ) : this.captionDefaults.padding ) + 'px;' +
				' font-family: ' + ( font_family.length ? font_family : 'inherit' ) + ';' +
				' font-weight: ' + ( font_weight.length ? font_weight : 'normal' ) + ';' +
				' font-style: ' + ( font_style.length ? font_style : 'normal' ) + ';' +
				' text-align:' + ( text_align ? text_align : this.captionDefaults.text_align ) + ';' +
				' color:' + ( color ? color : this.captionDefaults.color ) + ';' +
				( background_color ? ' background: ' + background_color + ';' : '' ) +
				'">' + captionContent + '</div>';

				$( '#preview_caption' ).css( {
					'left' : parseInt( offsetX ) >= 0 ? parseInt( offsetX ) + 'px' : this.captionDefaults.offsetx + 'px',
					'top' : parseInt( offsetY ) >= 0 ? parseInt( offsetY ) + 'px' : this.captionDefaults.offsety + 'px'
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
			},

			/**
			 * Controlling font options( family, weight, style ) in captions.
			 *
			 * @since  1.0.0
			 * @return void
			 */
			fontOptionControl: function() {
				$( '.caption_specification select.font-family' ).each( function() {
					ElsCaptionConfiguration.updateFontOptions( $( this ) );
				});
				$( '.caption_specification select.font-family' ).on( 'change', function() {
					ElsCaptionConfiguration.updateFontOptions( $( this ), true );
				});
			},

			/**
			 * Updating font options( weight, style ) based on font-family.
			 *
			 * @since  1.0.0
			 * @param  Object fontFamilySelect font family select HTML element
			 * @param  boolean if true change values of font optoins to default value
			 * @return void
			 */
			updateFontOptions : function( fontFamilySelect, changeValue ) {
				var id = fontFamilySelect.closest('div.caption_spec_tabs').data( 'key' ),
				    $font_weight = $( 'select[name="els_slider_captions[' + id + '][font_weight]"]'),
					$font_style  = $( 'select[name="els_slider_captions[' + id + '][font_style]"]'),
					$font_weight_options = $font_weight.find( 'option' ),
			        $font_style_options = $font_style.find( 'option' );

			    // Google Font Chosen
			    if ( els_slider.google_fonts[ fontFamilySelect.val() ] !== undefined ) {
			        var font = els_slider.google_fonts[ fontFamilySelect.val() ];

			        $font_weight_options.each( function() {
			        	$( this ).prop( 'disabled', true );
			        });
			        $font_style_options.each( function() {
			        	$( this ).prop( 'disabled', true );
			        });

			        if ( font.variants.length ) {
			            for ( var i = 0, max = font.variants.length; i < max ; i++ ) {
			                if ( font.variants[ i ] === 'regular' ) {
			                    jQuery( 'option[value="normal"]', $font_weight ).prop( 'disabled', false );
			                    jQuery( 'option[value="normal"]', $font_style ).prop( 'disabled', false );
			                } else {
			                    if ( font.variants[ i ].indexOf('italic') >= 0 ) {
			                        jQuery( 'option[value="italic"]', $font_style ).prop( 'disabled', false );
			                    }
			                    jQuery( 'option[value="' + parseInt( font.variants[i], 10 ) + '"]', $font_weight ).prop( 'disabled', false );
			                }
			            }
			        }
			    // Standard Font Chosen
			    } else {
			        $font_weight_options.each( function() {
			        	$( this ).prop( 'disabled', false );
			        });
			        $font_style_options.each( function() {
			        	$( this ).prop( 'disabled', false );
			        });
			    }
			    // Changing values of font options to default values.
			    if ( changeValue ) {
			    	$font_weight.val( 'normal' );
			    	$font_style.val( 'normal' );
			    }
			}

		}
		ElsCaptionConfiguration.init();

		/**
		 * TinyMce view of captions.
		 *
		 * @since 1.0.0
		 * @type  Object
		 */
		var captionEditorView = {

			settings : {},		// Settings of WpEditor
			qtagSettings : {},	// Tag settings of WpEditor

			/**
			 * Initialize caption editor tinymce properties.
			 *
			 *@since   1.0.0
			 * @return void
			 */
			init: function() {
				var firstCaptionId = $( '.caption_specification .caption_spec_tabs:first' ).data( 'key' );
				// Getting settings of tinymce editor that created by wp.
				this.settings      = window.tinyMCEPreInit.mceInit[ 'caption_editor_' + firstCaptionId ];
				this.qtagSettings  = window.tinyMCEPreInit.qtInit[ 'caption_editor_' + firstCaptionId ];
			},

			/**
			 * Creating a new captionEditorView.
			 *
			 * @since  1.0.0
			 * @param  int id
			 * @return void
			 */
			create: function( id ) {
				var settings = $.extend( {}, this.settings || {},
					{ selector : '#caption_detail_' + id + ' .caption_content textarea' } );
				tinymce.init( settings );
				var qtagSettings = $.extend( {}, this.qtagSettings || {},
					{ id : 'caption_editor_' + id } );
				var qtags = quicktags( qtagSettings );
				QTags._buttonsInit();
			}

		};
		captionEditorView.init();

		/**
		 * Color converter class.
		 *
		 * @since 1.0.0
		 * @type  Object
		 */
		var colorConverter = {
			/**
			 * Converting Hex color to RGBA color
			 *
			 * @since  1.0.0
			 * @param  string hex
			 * @param  int opacity
			 * @return string
			 */
			hexToRgba : function( hex, opacity ) {
				hex = hex.replace('#', '');
				if ( 3 === hex.length ) {
					var r = parseInt( hex.substring(0, 1) + hex.substring(0, 1), 16 ),
					    g = parseInt( hex.substring(1, 2) + hex.substring(1, 2), 16 ),
					    b = parseInt( hex.substring(2, 3) + hex.substring(2, 3), 16 );
				} else if ( hex.length >= 6 ) {
					var r = parseInt(hex.substring(0, 2), 16),
					    g = parseInt(hex.substring(2, 4), 16),
					    b = parseInt(hex.substring(4, 6), 16);
				}
				return 'rgba(' + r + ',' + g + ',' + b + ',' + opacity / 100 + ')';
			}
		}

	});

})( jQuery );
