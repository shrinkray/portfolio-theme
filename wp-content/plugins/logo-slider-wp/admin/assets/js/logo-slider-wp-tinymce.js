(function() {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
     *
     *
	 */

    jQuery(document).ready(function($) {

        tinymce.create('tinymce.plugins.logo_slider_wp', {
            init: function(ed, url) {
                ed.addCommand('lgx_logoslider_add_shortcode', function() {
                    var content = '[logo-slider]';
                    tinymce.execCommand('mceInsertContent', false, content);
                });
                ed.addButton('lgx_logo_button', {title: 'Insert Logo Slider Shortcode', cmd: 'lgx_logoslider_add_shortcode', image: url + '/../img/ls-logo.png'});
            }
        });

        tinymce.PluginManager.add('lgx_logo_button', tinymce.plugins.logo_slider_wp);

    });

})();
