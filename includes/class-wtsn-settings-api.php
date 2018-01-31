<?php

/**
 * WordPress settings API class
 *
 */
if ( !class_exists('WTSN_Settings_API' ) ):
class WTSN_Settings_API {

    private $settings_api;

    function __construct() {
        $this->settings_api = new WeDevs_Settings_API;

        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    /**
     * Initalizing the section and fields
     *
     */
    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    /**
     * Adds the menu item
     *
     */
    function admin_menu() {
        add_options_page( 'Watson Maintenance', 'Watson Maintenance', 'delete_posts', 'wtsn_mntnnc', array($this, 'plugin_page') );
    }


    /**
     * Returns all the settings sections
     *
     * @return array settings sections
     */
    function get_settings_sections() {
        $sections = array(
            array(
                'id'    => 'wtsn_mntnnc_basic_options',
                'title' => __( 'Basic Settings', 'wtsn-light-maintenance-mode' )
            ),
            array(
                'id'    => 'wtsn_mntnnc_advanced_options',
                'title' => __( 'Advanced Settings', 'wtsn-light-maintenance-mode' )
            )
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
        $wtsn_mntnnc_image_preview_opt = Wtsn_Light_Maintenance_Mode::wtsn_get_option( 'wtsn_mntnnc_image', 'wtsn_mntnnc_advanced_options');
        $wtsn_mntnnc_image_default_url = '/wp-content/plugins/wtsn-light-maintenance-mode/public/img/wtsn_mntnnc4.jpeg' ; 
        $wtsn_mntnnc_image_default = get_site_url() . $wtsn_mntnnc_image_default_url;

        $settings_fields = array(
            'wtsn_mntnnc_basic_options' => array(
                array(
                    'name'    => 'wtsn_mntnnc_activate',
                    'label'   => __( 'Activate Maintenance Mode', 'wtsn-light-maintenance-mode' ),
                    'desc'    => __( 'Activate or deactivate the maintenance mode.', 'wtsn-light-maintenance-mode' ),
                    'type'    => 'radio',
                    'default' => 'no',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                ),
                array(
                    'name'              => 'wtsn_mntnnc_title',
                    'label'             => __( 'Title', 'wtsn-light-maintenance-mode' ),
                    'desc'              => __( 'If left empty, a default value will be used.', 'wtsn-light-maintenance-mode' ),
                    'placeholder'       => __( 'Maintenance', 'wtsn-light-maintenance-mode' ),
                    'type'              => 'text',
                    'default'           => 'Maintenance',
                    'sanitize_callback' => 'sanitize_text_field'
                ),
                array(
                    'name'        => 'wtsn_mntnnc_text',
                    'label'       => __( 'Description', 'wtsn-light-maintenance-mode' ),
                    'desc'        => __( 'You can add a longer description to your message here.', 'wtsn-light-maintenance-mode' ),
                    'placeholder' => __( 'We are currently doing some scheduled maintenance on our site. Please check back in a few minutes. Thank you.', 'wtsn-light-maintenance-mode' ),
                    'default'     => __( 'We are currently doing some scheduled maintenance on our site. Please check back in a few minutes. Thank you.', 'wtsn-light-maintenance-mode' ),
                    'type'        => 'textarea'
                )
            ),
            'wtsn_mntnnc_advanced_options' => array(
                array(
                    'name'    => 'wtsn_mntnnc_title_color',
                    'label'   => __( 'Title font color', 'wtsn-light-maintenance-mode' ),
                    'desc'    => __( '', 'wtsn-light-maintenance-mode' ),
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'name'    => 'wtsn_mntnnc_text_color',
                    'label'   => __( 'Description font color', 'wtsn-light-maintenance-mode' ),
                    'desc'    => __( '', 'wtsn-light-maintenance-mode' ),
                    'type'    => 'color',
                    'default' => ''
                ),
                array(
                    'name'    => 'wtsn_mntnnc_image',
                    'label'   => __( 'Image', 'wtsn-light-maintenance-mode' ),
                    'desc'    => __( 'Please save changes to update the preview.', 'wtsn-light-maintenance-mode' ),
                    'type'    => 'file',
                    'default' => $wtsn_mntnnc_image_default,
                    'options' => array(
                        'button_label' => 'Choose Image'
                    )
                ),
                array(
                    'name'        => 'wtsn_mntnnc_image_preview',
                    'desc'        => "<img src='$wtsn_mntnnc_image_preview_opt' alt='' style='height: 100px;'>",
                    'type'        => 'html'
                ),
                array(
                    'name'    => 'wtsn_mntnnc_response',
                    'label'   => __( 'HTTP Response type', 'wtsn-light-maintenance-mode' ),
                    'desc'    => __( '503 is advised.', 'wtsn-light-maintenance-mode' ),
                    'type'    => 'select',
                    'default' => '503',
                    'options' => array(
                        '500' => '500',
                        '503'  => '503'
                    )
                
                ),
                array(
                    'name'    => 'wtsn_mntnnc_show_in_adminbar',
                    'label'   => __( 'Show status in adminbar', 'wtsn-light-maintenance-mode' ),
                    'desc'    => __( 'You can hide the status from adminbar here.', 'wtsn-light-maintenance-mode' ),
                    'type'    => 'select',
                    'default' => 'yes',
                    'options' => array(
                        'yes' => 'Yes',
                        'no'  => 'No'
                    )
                
                )
            )
        );

        return $settings_fields;
    }

    /**
     * Adding the plugin page
     *
     */
    function plugin_page() {

        echo '<div class="wrap">';
        echo "<h1>" . __('Watson Lightweight Maintenance Mode', 'wtsn-light-maintenance-mode' ) . "</h1>";
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();

        echo '</div>';
    }

    /**
     * Get all the pages
     *
     * @return array page names with key value pairs
     */
    function get_pages() {
        $pages = get_pages();
        $pages_options = array();
        if ( $pages ) {
            foreach ($pages as $page) {
                $pages_options[$page->ID] = $page->post_title;
            }
        }

        return $pages_options;
    }

}
endif;
