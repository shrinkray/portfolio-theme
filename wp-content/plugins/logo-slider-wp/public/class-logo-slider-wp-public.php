<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://logichunt.com
 * @since      1.0.0
 *
 * @package    Logo_Slider_WP
 * @subpackage Logo_Slider_WP/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Logo_Slider_WP
 * @subpackage Logo_Slider_WP/public
 * @author     LogicHunt <info.logichunt@gmail.com>
 */
class Logo_Slider_WP_Public {


    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private  $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private  $version;

    /**
     * @var Lgx_Carousel_Settings_API
     */
    private $settings_api;




    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {

        $this->plugin_name = $plugin_name;
        $this->version     = $version;

        $this->settings_api = new Lgx_Carousel_Settings_API($plugin_name, $version);

        add_shortcode('logo-slider', array($this, 'logo_slider_wp_shortcode_function' ));
    }


    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Logo_Slider_WP_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Logo_Slider_WP_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_style('logo-owl', plugin_dir_url( __FILE__ ) . 'assets/lib/owl.carousel2/owl.carousel.css', array(), $this->version, 'all' );
        wp_enqueue_style('logo-owltheme', plugin_dir_url( __FILE__ ) . 'assets/lib/owl.carousel2/owl.theme.default.min.css', array(), $this->version, 'all' );

        wp_enqueue_style( 'lgx-logo-animate',  plugin_dir_url( __FILE__ ) . 'assets/lib/animate/animate-logo.css', array(), '20', 'all' );

        wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/logo-slider-wp-public.css', array(), $this->version, 'all' );

    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Logo_Slider_WP_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Logo_Slider_WP_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */

        wp_enqueue_script('logoowljs', plugin_dir_url( __FILE__ ) . 'assets/lib/owl.carousel2/owl.carousel.js', array( 'jquery' ), $this->version, false );
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/logo-slider-wp-public.js', array( 'jquery' ), $this->version, false );

        // Localize the script
        $translation_array = array(
            'owl_navigationTextL'    => plugin_dir_url( __FILE__ ). 'assets/img/prev.png',
            'owl_navigationTextR'    => plugin_dir_url( __FILE__ ) . 'assets/img/next.png',
        );
        wp_localize_script( $this->plugin_name, 'logosliderwp', $translation_array );

        wp_enqueue_script('jquery');
    }




    /**
     * Plugin Output Function
     * @param $atts
     *
     * @return string
     *  @since 1.0.0
     */

    public static function lgx_output_function($params){

        //Query args
        $cats       = trim($params['cat'] );
        $order      = trim($params['order'] );
        $orderby    = trim( $params['orderby']);
        $limit      = intval(trim($params['limit']));
        $compnayanme_en     = trim($params['companyname']);

        //Carousel Style
        $logo_height 	= intval(trim($params['maxheight']));
        $logo_width  	= intval(trim($params['maxwidth']));
        $border      	= trim($params['border']);
        $bordercolor 	= trim($params['bordercolor']);
        $navposition 	= trim($params['navposition']);
        $enbg     		= trim($params['enbg']);
        $bgcolor    	= trim($params['bgcolor']);
        $hovertype    	= trim($params['hovertype']);

        //Data Attribute
        $data_attr                        = array();
        $data_attr['margin']              = intval($params['margin']);
        $data_attr['loop']                = ($params['loop'] == 'no') ? 'false' : 'true';
        $data_attr['autoplay']            = ($params['autoplay'] == 'no') ? 'false' : 'true';
        $data_attr['autoplaytimeout']     = intval(trim($params['autoplay_timeout']) );
        $data_attr['lazyload']            = trim($params['lazyload']);
        $data_attr['autoplayhoverpause']  = ($params['hover_pause'] == 'no') ? 'false' : 'true';
        $data_attr['dots']                = ($params['dots'] == 'no') ? 'false' : 'true';
        $data_attr['smartspeed']          = trim($params['smartspeed']);
        $data_attr['slidespeed']          = trim($params['slidespeed']);
        $data_attr['paginationspeed']     = trim($params['paginationspeed']);

        //
        $data_attr['itemlarge']           = intval($params['itemlarge']);
        $data_attr['itemdesk']            = intval($params['itemdesk']);
        $data_attr['itemtablet']          = intval($params['itemtablet']);
        $data_attr['itemmobile']          = intval($params['itemmobile']);

        $data_attr['navlarge']           = ($params['navlarge'] == 'no') ? 'false' : 'true';
        $data_attr['navdesk']            = ($params['navdesk'] == 'no') ? 'false' : 'true';
        $data_attr['navtablet']          = ($params['navtablet'] == 'no') ? 'false' : 'true';
        $data_attr['navmobile']          = ($params['navmobile'] == 'no') ? 'false' : 'true';




        // Mixing
        $border_color_style = ($border == 'yes') ? 'style="border-color:'.$bordercolor.';"' : '';
        $border_class       = ($border == 'yes') ? 'wp-logo-border' : '';
        $logo_style = 'style="max-width: '.$logo_width.'px;max-height: '.$logo_height.'px;"';

        $bg_style = ($enbg == 'yes') ? 'style=" background-color:'.$bgcolor.';"' : '';



        // Apply Data Attribute
        $data_attr_str = '';
        foreach ($data_attr as $key => $value) {
            $data_attr_str .= ' data-' . $key . '="' . $value . '" ';
        }


        $logo_args = array(
            'post_type'         => array( 'logosliderwp' ),
            'post_status'       => array( 'publish' ),
            'order'             => $order,
            'orderby'           => $orderby,
            'posts_per_page'    => $limit
        );

        // Category to Array Convert
        if( !empty($cats) && $cats != '' ){
            $cats = trim($cats);
            $cats_arr   = explode(',', $cats);

            if(is_array($cats_arr) && sizeof($cats_arr) > 0){
                $logo_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'logosliderwpcat',
                        'field'    => 'slug',
                        'terms'    => $cats_arr
                    )
                );

            }
        }


        // The  Query
        $logo_post = new WP_Query( $logo_args );
        $logo_item    = '';

        // The Loop
        if ( $logo_post->have_posts() ) {

            while ( $logo_post->have_posts() ) {

                $logo_post->the_post();
                $post_id            = get_the_ID();
                $metavalues         = get_post_meta( $post_id, '_logosliderwpmeta', true );
                $company_name       = $metavalues['company_name'];
                $company_url        = $metavalues['company_url'];

                $logo_img = '';
                if (has_post_thumbnail( $post_id )) {
                    $thumb_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id), true );
                    $thumb_url      = $thumb_url[0];
                    $logo_img .= '<div class="lgx-logo-item" '.$border_color_style.'>';
                    $logo_img .= (!empty($company_url) ? '<a href="'.$company_url.'" target="_blank">' : '');
                    $logo_img .= '<img class="lgx-logo-img" src="'.$thumb_url.'" '.$logo_style.'  title="'.(!empty($company_name)? $company_name : 'Company').'" />';
                    $logo_img .= (!empty($company_url) ? '</a>' : '');
                    $logo_img .= ( (!empty($company_name) && $compnayanme_en == 'yes' ) ? '<h4 class="logo-company-name">'.$company_name.'</h4>': '');
                    $logo_img .= '</div>';
                }

                $logo_item .= '<div class="item lgx-log-item" >';
                $logo_item .= $logo_img;
                $logo_item .=  '</div>';

            }
            wp_reset_postdata();// Restore original Post Data

            //Output String
            $output  = '<div  class="lgx-logo-slider-wp">';
            $output .= '<div class="lgx-logo-wrapper '.$border_class.' nav-position-'.$navposition.' hover-'.$hovertype.'" '.$bg_style.' >';
            $output .= '<div class="owl-carousel lgx-logo-carousel" ' . $data_attr_str . ' >' . $logo_item . '</div>';
            $output .= '</div>';
            $output .= '</div>';

            return $output;

        } // Check post exist
        else {
            _e('There are no item. Please Add Slider Item', 'logo-slider-wp');
        }



    }


    /**
     * Define Short Code Function
     *
     * @param $atts
     *
     * @return mixed
     * @since 1.0.0
     */

    public function logo_slider_wp_shortcode_function($atts) {

        $cats_set       = trim($this->settings_api->get_option('logosliderwp_settings_cat', 'logosliderwp_basic', ''));

        $order_set      = $this->settings_api->get_option('logosliderwp_settings_order', 'logosliderwp_basic', 'DESC');

        $orderby_set    = $this->settings_api->get_option('logosliderwp_settings_orderby', 'logosliderwp_basic', 'orderby');

        $limit_set      = trim($this->settings_api->get_option('logosliderwp_settings_limit', 'logosliderwp_basic', -1));

        $max_height      = trim($this->settings_api->get_option('logosliderwp_settings_height', 'logosliderwp_basic', 350));

        $max_width      = trim($this->settings_api->get_option('logosliderwp_settings_width', 'logosliderwp_basic', 350));

        $compnayanme_set     = trim($this->settings_api->get_option('logosliderwp_settings_show_company', 'logosliderwp_basic', 'no'));



        //Data Attribute
        $margin_set     = trim($this->settings_api->get_option('logosliderwp_settings_margin', 'logosliderwp_config', 10));

        $loop_set       = $this->settings_api->get_option('logosliderwp_settings_loop', 'logosliderwp_config', 'yes');

        $autoplay_set   = trim($this->settings_api->get_option('logosliderwp_settings_autoplay', 'logosliderwp_config', 'yes'));

        $lazyload_set   = trim($this->settings_api->get_option('logosliderwp_settings_lazyload', 'logosliderwp_config', 'no'));
        $lazyload_set   = ( !empty($lazyload_set) && !is_null($lazyload_set) && ($lazyload_set == 'yes')  ) ? 'true' : 'false';

        $smartspeed_set  = trim($this->settings_api->get_option('logosliderwp_settings_smartspeed', 'logosliderwp_config', '500'));
        $slidespeed_set  = trim($this->settings_api->get_option('logosliderwp_settings_slidespeed', 'logosliderwp_config', '200'));
        $paginationspeed_set  = trim($this->settings_api->get_option('logosliderwp_settings_paginationspeed', 'logosliderwp_config', '800'));
        $rewindspeed_set  = trim($this->settings_api->get_option('logosliderwp_settings_rewindspeed', 'logosliderwp_config', '1000'));

        $autoplay_timeout_set = trim($this->settings_api->get_option('logosliderwp_settings_autoplay_timeout', 'logosliderwp_config', 500));


        $hover_pause_set  = $this->settings_api->get_option('logosliderwp_settings_hover_pause', 'logosliderwp_config', 'no');

        $dots_set         	= trim($this->settings_api->get_option('logosliderwp_settings_dots', 'logosliderwp_config', 'yes'));


        // Responsive
        $item_set_lagedesctop   = $this->settings_api->get_option('logosliderwp_settings_largedesktop_item', 'logosliderwp_responsive', 5);
        $nav_set_lagedesctop   =  $this->settings_api->get_option('logosliderwp_settings_desktop_nav', 'logosliderwp_responsive', 'yes');

        $item_set_desctop    = $this->settings_api->get_option('logosliderwp_settings_desktop_item', 'logosliderwp_responsive', 4);
        $nav_set_desctop     =  $this->settings_api->get_option('logosliderwp_settings_desktop_nav', 'logosliderwp_responsive', 'yes');

        $item_set_tablet    = $this->settings_api->get_option('logosliderwp_settings_tablet_item', 'logosliderwp_responsive', 3);
        $nav_set_tablet    =  $this->settings_api->get_option('logosliderwp_settings_tablet_nav', 'logosliderwp_responsive', 'yes');

        $item_set_mobile   = $this->settings_api->get_option('logosliderwp_settings_mobile_item', 'logosliderwp_responsive', 2);
        $nav_set_mobile    =  $this->settings_api->get_option('logosliderwp_settings_mobile_nav', 'logosliderwp_responsive', 'yes');



        //Style
        $bgcolor_set    	= trim($this->settings_api->get_option('logosliderwp_settings_bgcolor', 'logosliderwp_style', '#f1f1f1'));
        $bordercolor_set    	= trim($this->settings_api->get_option('logosliderwp_settings_bordercolor', 'logosliderwp_style', '#f1f1f1'));
        $enbg_set        		=  $this->settings_api->get_option('logosliderwp_settings_bgcolor_en', 'logosliderwp_style', 'no');
        $border_set       	 	=  $this->settings_api->get_option('logosliderwp_settings_border_en', 'logosliderwp_style', 'no');
        $navposition_set        =  $this->settings_api->get_option('logosliderwp_settings_nav_position', 'logosliderwp_style', 'b-center');
        $hovertype_set        =  $this->settings_api->get_option('logosliderwp_settings_hover_type', 'logosliderwp_style', 'default');

        $atts = shortcode_atts(array(
            'order'            => $order_set,
            'orderby'          => $orderby_set,
            'limit'            => $limit_set,
            'hovertype'        => $hovertype_set,
            'companyname'      => $compnayanme_set,
            'maxheight'        => $max_height,
            'maxwidth'         => $max_width,
            'enbg'             =>  $enbg_set,
            'border'           =>  $border_set,
            'bordercolor'      => $bordercolor_set,
            'navposition'      => $navposition_set,
            'cat'              => $cats_set,
            'bgcolor'          => $bgcolor_set,
            'margin'           => $margin_set,
            'lazyload'         => $lazyload_set,
            'loop'             => $loop_set,
            'autoplay'         => $autoplay_set,
            'autoplay_timeout' => $autoplay_timeout_set,
            'hover_pause'      => $hover_pause_set,
            'dots'             => $dots_set,
            'smartspeed'       => $smartspeed_set,
            'slidespeed'       => $slidespeed_set,
            'paginationspeed'  => $paginationspeed_set,
            'rewindspeed'      => $rewindspeed_set,
            'itemlarge'        => $item_set_lagedesctop,
            'itemdesk'         => $item_set_desctop,
            'itemtablet'       => $item_set_tablet,
            'itemmobile'       => $item_set_mobile,
            'navlarge'         => $nav_set_lagedesctop,
            'navdesk'          => $nav_set_desctop,
            'navtablet'        => $nav_set_tablet,
            'navmobile'        => $nav_set_mobile,
        ), $atts, 'logo-slider');

        $output = $this->lgx_output_function($atts);

        return $output;
    }

}
