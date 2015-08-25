(function() {

    // Skip if sliders list is not available
    if ( ! elsSliders || ! elsSliders.sliders ) {
        return;
    }

    tinymce.create('tinymce.plugins.EasyListingsSliderShortcodes', {

        /**
         * Initializes the plugin, this will be executed after the plugin has been created.
         * This call is done before the editor instance has finished it's initialization so use the onInit event
         * of the editor instance to intercept that event.
         *
         * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
         * @param {string} url Absolute URL to where the plugin is located.
         */
        init : function(ed, url) {
            var sliders   = elsSliders.sliders,
                menuItems = [],
                itemLabel;

            for ( sliderId in sliders ) {
                itemLabel = sliders[sliderId]['title'] + ' [#' + sliderId + ']';
                menuItems.push( { text: itemLabel, value: sliderId } );
            }

            ed.addButton('els_shortcode_buttons', {
                text: false,
                icon: false,
                title: 'Easy Listings Slider',
                type: 'menubutton',
                menu: menuItems,
                onselect: function(e) {
                    ed.selection.setContent( '[els_slider id="' + e.control.value() + '"]' );
                }
            });
        },

        /**
         * Creates control instances based in the incomming name. This method is normally not
         * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
         * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
         * method can be used to create those.
         *
         * @param {String} n Name of the control to create.
         * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
         * @return {tinymce.ui.Control} New control instance or null if no control was created.
         */
        createControl : function(n, cm) {
            return null;
        },

        /**
         * Returns information about the plugin as a name/value array.
         * The current keys are longname, author, authorurl, infourl and version.
         *
         * @return {Object} Name/value array containing information about the plugin.
         */
        getInfo : function() {
            return {
                longname : 'Easy Listings Slider Shortcode',
                author : 'Taher Atashbar',
                version : "1.0.0"
            };
        }
    });

    // Register plugin
    tinymce.PluginManager.add( 'EasyListingsSliderShortcodes', tinymce.plugins.EasyListingsSliderShortcodes );

})();
