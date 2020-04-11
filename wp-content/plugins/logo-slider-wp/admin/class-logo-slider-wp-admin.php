<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://logichunt.com
 * @since      1.0.0
 *
 * @package    Logo_Slider_WP
 * @subpackage Logo_Slider_WP/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Logo_Slider_WP
 * @subpackage Logo_Slider_WP/admin
 * @author     LogicHunt <info.logichunt@gmail.com>
 */
class Logo_Slider_WP_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * @var Lgx_Carousel_Settings_API
	 */
	private $settings_api;

	/**
	 * The plugin plugin_base_file of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string plugin_base_file The plugin plugin_base_file of the plugin.
	 */
	protected $plugin_base_file;


	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */

	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */

	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->settings_api = new Lgx_Carousel_Settings_API($plugin_name, $version);


		$this->plugin_base_file = plugin_basename(plugin_dir_path(__FILE__).'../' . $this->plugin_name . '.php');

	}





	/**
	 * Declare Custom Post Type For Carousal
	 * @since 1.0.0
	 */

	public function logosliderwp_initialize() {

		//custom post type labels
		$labels_logosliderwp = array(
			'name'               => _x('Logo Slider', 'Logo Slider', 'logoslider-domain'),
			'singular_name'      => _x('Slider Item', 'Slider Items', 'logoslider-domain'),
			'menu_name'          => __('Logo Slider', 'logoslider-domain'),
			'all_items'          => __('All Logo', 'logoslider-domain'),
			'view_item'          => __('View Item', 'logoslider-domain'),
			'add_new_item'       => __('Add New Logo', 'logoslider-domain'),
			'add_new'            => __('Add New Logo', 'logoslider-domain'),
			'edit_item'          => __('Edit Carousel Item', 'logoslider-domain'),
			'update_item'        => __('Update Carousel Item', 'logoslider-domain'),
			'search_items'       => __('Search Carousel', 'logoslider-domain'),
			'not_found'          => __('No Carousel items found', 'logoslider-domain'),
			'not_found_in_trash' => __('No Carousel items found in trash', 'logoslider-domain')
		);

		$args_logosliderwp   = array(
			'label'               => __('Logo Slider', 'logoslider-domain'),
			'description'         => __('Logo Slider WP Post Type', 'logoslider-domain'),
			'labels'              => $labels_logosliderwp,
			'supports'            => array( 'title', 'thumbnail' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_icon'           => plugins_url('/logo-slider-wp/admin/assets/img/ls-logo.png'),
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
		);


		//declare custom post type logosliderwp
		register_post_type( 'logosliderwp', $args_logosliderwp);


		// Register Taxonomy
		$logosliderwp_cat_args = array(
			'hierarchical'   => true,
			'label'          => __('Categories', 'logoslider-domain'),
			'show_ui'        => true,
			'query_var'      => true,
			'show_admin_column' => true,
			'singular_label' => __('Category', 'logoslider-domain'),
		);
		register_taxonomy('logosliderwpcat', array('logosliderwp'), $logosliderwp_cat_args);
	}


    /**
     * Add metabox for custom post type
     *
     * @since    1.0.0
     */
    public function add_meta_boxes_metabox() {

        //portfoliopro meta box
        add_meta_box(
            'metabox_logosliderwp', __( 'Company Information', $this->plugin_name ), array(
                $this,
                'metabox_logosliderwp_display'
            ), 'logosliderwp', 'normal', 'high'
        );

    }


    /**
     * Render Metabox under logosliderwp
     *
     * logosliderwp meta field
     *
     * @param $post
     *
     * @since 1.0
     *
     */

    public function metabox_logosliderwp_display( $post ) {

        $fieldValues = get_post_meta( $post->ID, '_logosliderwpmeta', true );

        wp_nonce_field( 'metaboxlogosliderwp', 'metaboxlogosliderwp[nonce]' );

        echo '<div id="logosliderwp_metabox_wrapper">';

        $company_url        = isset( $fieldValues['company_url'] ) ? $fieldValues['company_url'] : '';
        $company_name    = isset( $fieldValues['company_name'] ) ? $fieldValues['company_name'] : '';
        ?>


        <table class="form-table">
            <tbody>

            <?php do_action( 'logosliderwp_meta_fields_before_start', $fieldValues ); ?>

            <tr valign="top">
                <td><?php _e( 'Company Name', $this->plugin_name ) ?></td>
                <td>
                    <input type="text" name="metaboxlogosliderwp[company_name]" value='<?php echo $company_name; ?>'/>
                </td>
            </tr>

            <tr valign="top">
                <td><?php _e( 'Company URL', $this->plugin_name ) ?></td>
                <td>
                    <input type="url" name="metaboxlogosliderwp[company_url]" value='<?php echo $company_url; ?>'/>
                </td>
            </tr>

            <?php
            //allow others to show more custom fields at end
            do_action( 'logosliderwp_meta_fields_after_start', $fieldValues );
            ?>

            </tbody>
        </table>

        <?php
        echo '</div>';


    }


    /**
     * Determines whether or not the current user has the ability to save meta data associated with this post.
     *
     * Save portfoliopro Meta Field
     *
     * @param        int $post_id //The ID of the post being save
     * @param         bool //Whether or not the user has the ability to save this post.
     */
    public function save_post_metabox_logosliderwp( $post_id, $post ) {

        $post_type = 'logosliderwp';

        // If this isn't a 'book' post, don't update it.
        if ( $post_type != $post->post_type ) {
            return;
        }

        if ( ! empty( $_POST['metaboxlogosliderwp'] ) ) {

            $postData = $_POST['metaboxlogosliderwp'];

            $saveableData = array();

            if ( $this->user_can_save( $post_id, 'metaboxlogosliderwp', $postData['nonce'] ) ) {

                $saveableData['company_url']  = esc_url( $postData['company_url'] );
                $saveableData['company_name']  = sanitize_text_field( $postData['company_name'] );

                update_post_meta( $post_id, '_logosliderwpmeta', $saveableData );
            }
        }
    }// End  Meta Save


    /**
     * Determines whether or not the current user has the ability to save meta data associated with this post.
     *
     * user_can_save
     *
     * @param        int $post_id // The ID of the post being save
     * @param        bool /Whether or not the user has the ability to save this post.
     *
     * @since 1.0
     */
    public function user_can_save( $post_id, $action, $nonce ) {

        $is_autosave    = wp_is_post_autosave( $post_id );
        $is_revision    = wp_is_post_revision( $post_id );
        $is_valid_nonce = ( isset( $nonce ) && wp_verify_nonce( $nonce, $action ) );

        // Return true if the user is able to save; otherwise, false.
        return ! ( $is_autosave || $is_revision ) && $is_valid_nonce;

    }




    /**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		$this->plugin_screen_hook_suffix  = add_submenu_page('edit.php?post_type=logosliderwp', __('Logo Slider Settings', 'logoslider-domain'), __('Logo Slider Settings', 'logoslider-domain'), 'manage_options', 'logosliderwpsettings', array($this, 'display_plugin_admin_settings'));

	}

    /**
     * Change Feature iamge input Position
     */
   public  function logo_slider_wp_img_box(){
        remove_meta_box( 'postimagediv', 'logosliderwp', 'side' );
        add_meta_box('postimagediv', __('Company Logo'), 'post_thumbnail_meta_box', 'logosliderwp', 'normal', 'high');
    }




    /**
	 * Add support link to plugin description in /wp-admin/plugins.php
	 *
	 * @param  array  $plugin_meta
	 * @param  string $plugin_file
	 *
	 * @return array
	 */
	public function logo_slider_wp_support_link($plugin_meta, $plugin_file) {

		if ($this->plugin_base_file == $plugin_file) {
			$plugin_meta[] = sprintf(
				'<a href="%s">%s</a>', 'http://logichunt.com/', __('Support', 'logoslider-domain')
			);
		}

		return $plugin_meta;
	}



	public function display_plugin_admin_settings() {
	/*	$test = $this->settings_api->get_option('logosliderwp_settings_cat', 'logosliderwp_config', 'test');
		var_dump($test);*/

		global $wpdb;

		$plugin_data = get_plugin_data(plugin_dir_path(__DIR__) . '/../' . $this->plugin_base_file);

		include('partials/admin-settings-display.php');
	}

	/**
	 * Settings init
	 */
	public function logo_slider_wp_setting_init() {
		//set the settings
		$this->settings_api->set_sections($this->get_settings_sections());
		$this->settings_api->set_fields($this->get_settings_fields());

		//initialize settings
		$this->settings_api->admin_init();

		//$role = get_role('administrator');
	}




	/**
	 * Ensure post thumbnail support is turned on.
	 */
	public function add_thumbnail_support_logo_slider() {
		if ( ! current_theme_supports( 'post-thumbnails' ) ) {
			add_theme_support( 'post-thumbnails' );
		}
		add_post_type_support( 'logosliderwp', 'thumbnail' );
	}


	/**
	 * Setings Sections
	 * @return array|mixed|void
	 */

	public function get_settings_sections() {

		$sections = array(
			array(
				'id'    => 'logosliderwp_basic',
				'title' => __('Basic Settings', 'logoslider-domain'),
			),

            array(
                'id'    => 'logosliderwp_responsive',
                'title' => __('Responsive Control', 'logoslider-domain'),
            ),
			array(
				'id'    => 'logosliderwp_config',
				'title' => __('Slider Options', 'logoslider-domain'),
			),
            array(
                'id'    => 'logosliderwp_style',
                'title' => __('Style Settings', 'logosliderwp-domain'),
            ),

        );

		$sections = apply_filters('logo_slider_settings_sections', $sections);

		return $sections;
	}

	/**
	 * Returns all the settings fields
	 *
	 * @return array settings fields
	 */
	public  function get_settings_fields() {


		$settings_fields = array(

			'logosliderwp_basic' => array(
				array(
					'name'     => 'logosliderwp_settings_cat',
					'label'    => __('Default Categories(slug)', 'logoslider-domain'),
					'desc'     => __('Please input category slug with comma( , ). Example: categoey1, category2 ', 'logoslider-domain'),
					'type'     => 'text',
					'default'  => '',
					'desc_tip' => true,
				),

				array(
					'name'             => 'logosliderwp_settings_order',
					'label'            => __('Item Order', 'logoslider-domain'),
					'desc'             => __('Direction to sort item.', 'logoslider-domain'),
					'type'             => 'select',
					'default'          => 'DESC',
					'options'          => array(
						'ASC' => __( 'Ascending', 'logoslider-domain' ),
						'DESC'   => __( 'Descending', 'logoslider-domain' ),
					),
				),

				array(
					'name'             => 'logosliderwp_settings_orderby',
					'label'            => __('Item Order By', 'logoslider-domain'),
					'desc'             => __('Sort retrieved item.', 'logoslider-domain'),
					'type'             => 'select',
					'default'          => 'date',
					'options'          => array(
						'date'      => __( 'Date', 'logoslider-domain' ),
						'ID'        => __( 'ID', 'logoslider-domain' ),
						'title'     => __( 'Title', 'logoslider-domain' ),
						'modified'  => __( 'Modified', 'logoslider-domain' ),
						'rand'      => __( 'Random', 'logoslider-domain' ),
					),
				),


                array(
                    'name'     => 'logosliderwp_settings_show_company',
                    'label'         => __('Show Company Name', 'logoslider-domain'),
                    'type'          => 'radio',
                    'required'      => false,
                    'default'  => 'no',
                    'options' => array(
                        'yes' => __('Yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),

                array(
                    'name'     => 'logosliderwp_settings_height',
                    'label'    => __('Logo Height(px)', 'logoslider-domain'),
                    'desc'     => __('Set Maximum Logo Height in px', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '350',
                    'desc_tip' => true,
                ),

                array(
                    'name'     => 'logosliderwp_settings_width',
                    'label'    => __('Logo Width(px)', 'logoslider-domain'),
                    'desc'     => __('Set Maximum Logo Width in px', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '350',
                    'desc_tip' => true,
                ),

                array(
                    'name'     => 'logosliderwp_settings_limit',
                    'label'    => __('Item Limit', 'logoslider-domain'),
                    'desc'     => __('Please input total number of item, that want to display front end. -1 means all published post.', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '-1',
                    'desc_tip' => true,
                ),

            ),// Single

            // Style Settings
            'logosliderwp_style' => array(

                array(
                    'name'     => 'logosliderwp_settings_nav_position',
                    'label'         => __('Nav Position', 'logoslider-domain'),
                    'type'          => 'radio',
                    'required'      => false,
                    'default'       => 'b-center',
                    'options' => array(
                        'b-center' => __('Bottom Center','logoslider-domain'),
                        'v-mid' => __('Vertically Middle','logoslider-domain'),
                        'v-mid-hover' => __('Vertically Middle (On Over)','logoslider-domain'),

                    )
                ),

                array(
                    'name'     => 'logosliderwp_settings_hover_type',
                    'label'         => __('Hover Effect', 'logoslider-domain'),
                    'type'          => 'radio',
                    'required'      => false,
                    'default'       => 'default',
                    'options' => array(
                        'default' => __('Default','logoslider-domain'),
                        'grayscale'   => __('Gray Scale','logoslider-domain'),
                        'hblur'   => __('Blur','logoslider-domain'),
                        'zoomin'  => __('Zoom In','logoslider-domain'),
                        'none'    => __('None','logoslider-domain'),
                    )
                ),

                array(
                    'name'     => 'logosliderwp_settings_bgcolor_en',
                    'label'         => __('Enabled  Background Color', 'logoslider-domain'),
                    'type'          => 'radio',
                    'required'      => false,
                    'options' => array(
                        'yes' => __('Yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),

                array(
                    'name'    => 'logosliderwp_settings_bgcolor',
                    'label'   => __('Background  Color', 'lgxcarousel-domain'),
                    'desc'    => __('Please select Carousel Background color.', 'lgxcarousel-domain'),
                    'type'    => 'color',
                    'default' => '#f1f1f1'
                ),

                array(
                    'name'     => 'logosliderwp_settings_border_en',
                    'label'         => __('Enabled Border', 'logoslider-domain'),
                    'type'          => 'radio',
                    'required'      => false,
                    'options' => array(
                        'yes' => __('Yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),

                array(
                    'name'    => 'logosliderwp_settings_bordercolor',
                    'label'   => __('Border Color', 'lgxcarousel-domain'),
                    'type'    => 'color',
                    'default' => '#d02c21'
                ),

            ),// Single

            //Responsive Settings
            'logosliderwp_responsive' => array(

                // View Port Large Desktop
                array(
                    'name'     => 'logosliderwp_settings_largedesktop_item',
                    'label'    => __('Item in Large Desktops', 'logoslider-domain'),
                    'desc'     => __('Item in Large Desktops Devices (1200px and Up)', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '5',
                    'desc_tip' => true,
                ),

                array(
                    'name'     => 'logosliderwp_settings_largedesktop_nav',
                    'label'         => __('Show Nav(Large Desktops)', 'logoslider-domain'),
                    'desc'          => __( 'Show Nav in Large Desktops', 'logoslider-domain' ),
                    'type'          => 'radio',
                    'tooltip'       => __('Enabled by default','logoslider-domain'),
                    'required'      => false,
                    'default'       => 'yes',
                    'options' => array(
                        'yes' => __('yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),

                // View Port Desktop
                array(
                    'name'     => 'logosliderwp_settings_desktop_item',
                    'label'    => __('Item in Desktops', 'logoslider-domain'),
                    'desc'     => __('Item in Desktops Devices (Desktops 992px).', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '4',
                    'desc_tip' => true,
                ),

                array(
                    'name'     => 'logosliderwp_settings_desktop_nav',
                    'label'         => __('Show Nav(Desktops)', 'logoslider-domain'),
                    'desc'          => __( 'Show Nav in Desktops', 'logoslider-domain' ),
                    'type'          => 'radio',
                    'tooltip'       => __('Enabled by default','logoslider-domain'),
                    'required'      => false,
                    'default'       => 'yes',
                    'options' => array(
                        'yes' => __('yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),

                // View Port Tab
                array(
                    'name'     => 'logosliderwp_settings_tablet_item',
                    'label'    => __('Item in Tablets', 'logoslider-domain'),
                    'desc'     => __('Item in Tablets Devices (768px and Up)', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '3',
                    'desc_tip' => true,
                ),

                array(
                    'name'     => 'logosliderwp_settings_tablet_nav',
                    'label'         => __('Enabled largedesktop Nav', 'logoslider-domain'),
                    'desc'          => __( 'Show Nav(Tablet)', 'logoslider-domain' ),
                    'type'          => 'radio',
                    'tooltip'       => __('Show Nav in Large Tablet','logoslider-domain'),
                    'required'      => false,
                    'default'       => 'yes',
                    'options' => array(
                        'yes' => __('yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),


                // View Port Mobile
                array(
                    'name'     => 'logosliderwp_settings_mobile_item',
                    'label'    => __('Item in Mobile', 'logoslider-domain'),
                    'desc'     => __('Item in Mobile Devices (Less than 768px)', 'logoslider-domain'),
                    'type'     => 'number',
                    'default'  => '2',
                    'desc_tip' => true,
                ),

                array(
                    'name'     => 'logosliderwp_settings_mobile_nav',
                    'label'         => __('Show Nav(Mobile)', 'logoslider-domain'),
                    'desc'          => __( 'Show next/prev buttons.', 'logoslider-domain' ),
                    'type'          => 'radio',
                    'tooltip'       => __('Show Nav in Mobile"','logoslider-domain'),
                    'required'      => false,
                    'default'       => 'yes',
                    'options' => array(
                        'yes' => __('yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),


            ),


            // OWL CONFIG
			'logosliderwp_config'   => array(

                array(
                    'name'     => 'logosliderwp_settings_loop',
                    'label'         => __('Enabled Loop', 'logoslider-domain'),
                    'desc'          => __( 'Infinity loop. Duplicate last and first items to get loop illusion.', 'logoslider-domain' ),
                    'type'          => 'radio',
                    'tooltip'       => __('Enabled by default','logoslider-domain'),
                    'required'      => false,
                    'default'       => 'yes',
                    'options' => array(
                        'yes' => __('Yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),

                array(
                    'name'     => 'logosliderwp_settings_dots',
                    'label'         => __('Enabled Dots', 'logoslider-domain'),
                    'desc'          => __( 'Show dots navigation.', 'logoslider-domain' ),
                    'type'          => 'radio',
                    'tooltip'       => __('Enabled by default','logoslider-domain'),
                    'required'      => false,
                    'default'       => 'yes',
                    'options' => array(
                        'yes' => __('yes','logoslider-domain'),
                        'no' => __('No','logoslider-domain')
                    )
                ),


                array(
					'name'     => 'logosliderwp_settings_margin',
					'label'    => __('Margin', 'logoslider-domain'),
					'desc'     => __('margin-right(px) on item.', 'logoslider-domain'),
					'type'     => 'number',
					'default'  => '10',
					'desc_tip' => true,
				),


				array(
					'name'     => 'logosliderwp_settings_autoplay',
					'label'         => __('Enabled Autoplay', 'logoslider-domain'),
					'desc'          => __( 'Carousel item autoplay by default.', 'logoslider-domain' ),
					'type'          => 'radio',
					'tooltip'       => __('Enabled by default','logoslider-domain'),
					'required'      => false,
					'default'       => 'yes',
					'options' => array(
						'yes' => __('Yes','logoslider-domain'),
						'no' => __('No','logoslider-domain')
					)
				),

				array(
					'name'     => 'logosliderwp_settings_autoplay_timeout',
					'label'    => __('Autoplay Timeout', 'logoslider-domain'),
					'desc'     => __('autoplayTimeout', 'logoslider-domain'),
					'type'     => 'number',
					'default'  => '5000',
					'desc_tip' => true,
				),

				array(
					'name'     => 'logosliderwp_settings_hover_pause',
					'label'         => __('Autoplay Hover Pause', 'logoslider-domain'),
					'desc'          => __('Pause on mouse hover.', 'logoslider-domain' ),
					'type'          => 'radio',
					'tooltip'       => __('Disabled by default','logoslider-domain'),
					'required'      => false,
					'default'       => 'no',
					'options' => array(
						'yes' => __('Yes','logoslider-domain'),
						'no' => __('No','logoslider-domain')
					)
				),


				array(
					'name'     => 'logosliderwp_settings_lazyload',
					'label'         => __('Enabled Lazyload', 'logoslider-domain'),
					'desc'          => __('Lazy load images. data-src and data-src-retina for highres. Also load images into background inline style if element is not <img>', 'logoslider-domain' ),
					'type'          => 'radio',
					'tooltip'       => __('Disabled by default','logoslider-domain'),
					'required'      => false,
					'default'       => 'no',
					'options' => array(
						'yes' => __('Yes','logoslider-domain'),
						'no' => __('No','logoslider-domain')
					)
				),

			/*	array(
					'name'     => 'logosliderwp_settings_add_active',
					'label'         => __('Enabled Active Class', 'logoslider-domain'),
					'desc'          => __( 'Add Active class in current item.', 'logoslider-domain' ),
					'type'          => 'radio',
					'tooltip'       => __('Enabled by default','logoslider-domain'),
					'required'      => false,
					'default'       => 'yes',
					'options' => array(
						'yes' => __('Yes','logoslider-domain'),
						'no' => __('No','logoslider-domain')
					)
				),*/

				array(
					'name'     => 'logosliderwp_settings_autoplay_slidespeed',
					'label'    => __('Slide Speed', 'logoslider-domain'),
					'desc'     => __('Set Slide Speed', 'logoslider-domain'),
					'type'     => 'number',
					'default'  => '200',
					'desc_tip' => true,
				),


				array(
					'name'     => 'logosliderwp_settings_autoplay_paginationspeed',
					'label'    => __('Pagination Speed', 'logoslider-domain'),
					'desc'     => __('Set Pagination Speed', 'logoslider-domain'),
					'type'     => 'number',
					'default'  => '800',
					'desc_tip' => true,
				),

				array(
					'name'     => 'logosliderwp_settings_autoplay_rewindspeed',
					'label'    => __('Rewind Speed', 'logoslider-domain'),
					'desc'     => __('Set Rewind Speed', 'logoslider-domain'),
					'type'     => 'number',
					'default'  => '1000',
					'desc_tip' => true,
				)


			),//single


		);//Filed

		$settings_fields = apply_filters('logo_slider_settings_fields', $settings_fields);

		return $settings_fields;
	}


	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/css/logo-slider-wp-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'assets/js/logo-slider-wp-admin.js', array( 'jquery' ), $this->version, false );


		$translation_array = array(
			'add_leftimg_title'  => __('Add Previous Arrow Image', 'wpnextpreviouslinkaddon'),
			'add_rightimg_title' => __('Add Next Arrow Image', 'wpnextpreviouslinkaddon'),
		);
		wp_localize_script($this->plugin_name, 'wpnpaddon', $translation_array);
	}



	public function lgx_owl_register_tinymce_plugin($plugin_array) {
		$plugin_array['lgx_logo_button'] = plugin_dir_url( __FILE__ ) . 'assets/js/logo-slider-wp-tinymce.js';
		return $plugin_array;
	}

	public function lgx_owl_add_tinymce_button($buttons) {
		$buttons[] = "lgx_logo_button";
		return $buttons;
	}

}
