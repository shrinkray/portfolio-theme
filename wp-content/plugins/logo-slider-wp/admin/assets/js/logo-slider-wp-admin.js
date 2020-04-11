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

        $('.logosliderwp_settings_bgimage_url-text').click(function(e) {
            e.preventDefault();

            var $_this = $(this);
            var image = wp.media({
                title: wpnpaddon.add_leftimg_title,
                multiple: false
            }).open()
                .on('select', function(e) {

                    var uploaded_image = image.state().get('selection').first();
                    var image_url = uploaded_image.toJSON().url;

                    $('.logosliderwp_settings_bgimage_url-text').val(image_url);

                    $_this.next('.description').find('.lgxwp_bg_img').removeClass('hidden');
                    $('#lgxwp_bg_previousimg').attr('src', image_url).removeClass('hidden');

                });
        });



    });


})();
