(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-specific JavaScript source
	 * should reside in this file.
	 *
	 * Note that this assume you're going to use jQuery, so it prepares
	 * the $ function reference to be used within the scope of this
	 * function.
	 *
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
	 * ...and so on.
	 *
	 * Remember that ideally, we should not attach any more than a single DOM-ready or window-load handler
	 * for any particular page. Though other scripts in WordPress core, other plugins, and other themes may
	 * be doing this, we should try to minimize doing that in our own work.
	 */
	 $(function() {
	 	// Listing gallery file uploads
	 	var listing_gallery_frame;
	 	var $image_gallery_ids = $('#els_listing_gallery_images');
	 	var $listing_images = $('#listing_gallery_container ul.listing_images');

	 	$('.add_listing_images').on( 'click', 'a', function( event ) {
	 		var $el = $(this);
	 		var attachment_ids = $image_gallery_ids.val();

	 		event.preventDefault();

	 		// If the media frame already exists, reopen it.
	 		if ( listing_gallery_frame ) {
	 			listing_gallery_frame.open();
	 			return;
	 		}

	 		// Create the media frame.
	 		listing_gallery_frame = wp.media.frames.listing_gallery = wp.media({
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
	 		listing_gallery_frame.on( 'select', function() {

	 			var selection = listing_gallery_frame.state().get('selection');
	 			var attachment_image;

	 			selection.map( function( attachment ) {

	 				attachment = attachment.toJSON();
	 				if ( attachment.id ) {
	 					attachment_ids   = attachment_ids ? attachment_ids + "," + attachment.id : attachment.id;
	 					attachment_image = attachment.sizes.thumbnail ? attachment.sizes.thumbnail.url : attachment.url;

	 					$listing_images.append('\
	 						<li class="image" data-attachment_id="' + attachment.id + '">\
	 							<img src="' + attachment_image + '" />\
	 							<ul class="actions">\
	 								<li><a href="#" class="delete" title="' + $el.data('delete') + '">' + $el.data('text') + '</a></li>\
	 							</ul>\
	 						</li>');
	 				}

	 			});

	 			$image_gallery_ids.val( attachment_ids );
	 		});

	 		// Finally, open the modal.
	 		listing_gallery_frame.open();
	 	});

	 	// Image ordering
	 	$listing_images.sortable({
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

	 			$('#listing_gallery_container ul li.image').css('cursor','default').each(function() {
	 				var attachment_id = jQuery(this).attr( 'data-attachment_id' );
	 				attachment_ids = attachment_ids + attachment_id + ',';
	 			});

	 			$image_gallery_ids.val( attachment_ids );
	 		}
	 	});

	 	// Remove images
	 	$('#listing_gallery_container').on( 'click', 'a.delete', function() {
	 		$(this).closest('li.image').remove();

	 		var attachment_ids = '';

	 		$('#listing_gallery_container ul li.image').css('cursor','default').each(function() {
	 			var attachment_id = jQuery(this).attr( 'data-attachment_id' );
	 			attachment_ids = attachment_ids + attachment_id + ',';
	 		});

	 		$image_gallery_ids.val( attachment_ids );

	 		// remove any lingering tooltips
	 		$( '#tiptip_holder' ).removeAttr( 'style' );
	 		$( '#tiptip_arrow' ).removeAttr( 'style' );

	 		return false;
	 	});

	 	// Slider Actions Column in Sliders admin page.
	 	var sliderActions = {

	 		/**
	 		 * initialize class.
	 		 *
	 		 * @since  1.0.0
	 		 * @return void
	 		 */
	 		init : function() {
	 			this.previewSlider();
	 		},

	 		/**
	 		 * Preview slider.
	 		 *
	 		 * @since  1.0.0
	 		 * @return void
	 		 */
	 		previewSlider : function() {
	 			$( 'body' ).on( 'click', 'a.slider-preview-action', function( e ) {
	 				e.preventDefault();
	 				var slider = $( this ).data( 'id' );
	 				tb_show( $( this ).data( 'text' ), $( this ).prop( 'href' ) + '&width=' + ( $(window).width() - 50 ) + '&height=' + ( $(window).height() - 80 ) + '&TB_iframe=true' );
	 			});
	 		}

	 	}
	 	sliderActions.init();

	 	// Tooltips
	 	jQuery( '.help_tip' ).tipTip( {
	 	    'attribute' : 'data-tip',
	 	    'fadeIn' : 50,
	 	    'fadeOut' : 50,
	 	    'delay' : 200
	 	} );

	 	// Subscribe.
	 	var subscribe = {

	 		/**
	 		 * Initialize.
	 		 *
	 		 * @since  1.0.0
	 		 * @return void
	 		 */
	 		init : function() {
	 			this.openPopup();
	 			this.closePopup();
	 			this.subscribe();
	 		},

	 		/**
	 		 * Opening subscribe popup.
	 		 *
	 		 * @since  1.0.0
	 		 * @return void
	 		 */
	 		openPopup : function() {
	 			$('[data-popup=popup-1]').fadeIn('slow');
	 		},

	 		/**
	 		 * Closing subscribe popup.
	 		 *
	 		 * @since  1.0.0
	 		 * @return void
	 		 */
	 		closePopup : function() {
	 			$('[data-popup-close]').on('click', function(e)  {
	 			    var targeted_popup_class = jQuery(this).attr('data-popup-close');
	 			    $('[data-popup="' + targeted_popup_class + '"]').fadeOut(350);

	 			    e.preventDefault();
	 			});
	 		},

	 		/**
	 		 * Subscription.
	 		 *
	 		 * @since  1.0.0
	 		 * @return void
	 		 */
	 		subscribe : function() {
	 			$('#subscribe').click(function(event) {
	 				var validator = false;
	 				if ( ! jQuery.trim( jQuery( '#name' ).val() ) ) {
	 					jQuery( '#name' ).addClass('error-field');
	 					validator = true;
	 				} else {
	 					jQuery( '#name' ).removeClass( 'error-field' );
	 				}

	 				if ( ! subscribe.validateEmail( $('#email').val() ) ) {
	 					jQuery( '#email' ).addClass('error-field');
	 					validator = true;
	 				} else {
	 					jQuery( '#email' ).removeClass( 'error-field' );
	 				}

	 				if ( ! validator ) {
	 					subscribe.showMessage( 'Please wait...', 0 );
	 					// Sending email.
	 					$.ajax({
	 						url: ajaxurl,
	 						type: 'POST',
	 						dataType: 'json',
	 						data: {
	 							action : 'send_subscribe_email',
	 							subscribe_nonce : elsAdminData.subscribe_nonce,
	 							name: jQuery.trim( jQuery( '#name' ).val() ),
	 							email: $('#email').val()
	 						},
	 					})
	 					.done(function( response ) {
	 						subscribe.showMessage( response.message, response.success );
	 						$('[data-popup=popup-1]').delay( 2500 ).fadeOut('slow');
	 					})
	 					.fail(function( response ) {
	 						subscribe.showMessage( 'Some error occurred in subscription.', 0 );
	 					});
	 				}
	 			});
	 		},

	 		/**
	 		 * Validating email address.
	 		 *
	 		 * @since  1.0.0
	 		 * @param  string email
	 		 * @return boolean
	 		 */
	 		validateEmail : function( email ) {
	 			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	 			return regex.test( email );
	 		},

	 		/**
	 		 * Showing information message on top of the popup.
	 		 *
	 		 * @since  1.0.0
	 		 * @param  string message
	 		 * @param  int type
	 		 * @return void
	 		 */
	 		showMessage : function( message, type ) {
		    	jQuery( '#popup-message' ).css( 'padding', '3px' );
		    	jQuery( '#popup-message' ).html('');
		    	jQuery('#popup-message' ).html( message );
		    	jQuery( '#popup-message' ).show();
		    	if ( 1 == type ) {
		    		jQuery( '#popup-message' ).css( 'border', '1px solid rgb(60, 221, 60)' );
		    	} else {
		    		jQuery( '#popup-message' ).css( 'border', '1px solid rgb(221, 60, 91)' );
		    	}
		    }

	 	};
	 	subscribe.init();

	 });

})( jQuery );
