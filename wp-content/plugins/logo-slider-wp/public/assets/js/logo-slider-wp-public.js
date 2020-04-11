(function() {
    'use strict';

    /**
     * All of the code for your public-facing JavaScript source
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
     */


    jQuery(document).ready(function($) {

        $('.lgx-logo-carousel').each(function(){
            var $logoitem = $(this);
            var dataAttr = $logoitem.data();
           //console.log(dataAttr.autoplayhoverpause);
            var logocarouselParams = {
                addClassActive:true,
                loop:dataAttr.loop,
                dots:dataAttr.dots,
                autoplay:dataAttr.autoplay,
                lazyLoad: dataAttr.lazyload,
                autoplayTimeout:dataAttr.autoplaytimeout,
                margin:dataAttr.margin,
                autoplayHoverPause:dataAttr.autoplayhoverpause,
                navText :['<img src="'+logosliderwp.owl_navigationTextL+'" alt="Left"/>','<img src="'+logosliderwp.owl_navigationTextR+'" alt="Right"/>'],
                smartSpeed:dataAttr.smartspeed,
                slideSpeed : dataAttr.slidespeed,
                paginationSpeed : dataAttr.paginationspeed,
                rewindSpeed : dataAttr.rewindspeed,
                responsiveClass:true,
                responsive:{
                    // Item in Mobile Devices (Less than 768px)
                    0:{
                        items:dataAttr.itemmobile,
                        nav:dataAttr.navmobile
                    },
                    // Item in Tablets Devices (768px and Up)
                    768:{
                        items:dataAttr.itemtablet,
                        nav:dataAttr.navtablet
                    },
                    // Item in Desktops Devices (Desktops 992px)

                    992:{
                        items:dataAttr.itemdesk,
                        nav:dataAttr.navdesk
                    },
                    // Item in Large Desktops Devices (1200px and Up)
                    1200:{
                        items:dataAttr.itemlarge,
                        nav:dataAttr.navlarge
                    }
                }

            };
            $logoitem.owlCarousel(logocarouselParams);
            //
        });

    });



})();
