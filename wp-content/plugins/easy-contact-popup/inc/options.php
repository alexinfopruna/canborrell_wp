<?php
/*
 * WordPress settings API class
 *
 * @author WPQastle
 */
if ( !class_exists('ECP_Settings_API_Main' ) ):
class ECP_Settings_API_Main {

    private $settings_api;

    function __construct() {
        $this->settings_api = new ECP_Settings_API;
        add_action( 'admin_init', array($this, 'admin_init') );
        add_action( 'admin_menu', array($this, 'admin_menu') );
    }

    function admin_init() {

        //set the settings
        $this->settings_api->set_sections( $this->get_settings_sections() );
        $this->settings_api->set_fields( $this->get_settings_fields() );

        //initialize settings
        $this->settings_api->admin_init();
    }

    function admin_menu() {
        add_menu_page( 'ECP Options', 'ECP Options', 'delete_posts', 'easy_contact_popup_options', array($this, 'plugin_page'), plugins_url( '/easy-contact-popup/lib/img/icon.png' ));
    }

    function get_settings_sections() {
        $sections = array(
            array(
                'id' => 'ecp_general_options',
                'title' => __( 'General Options', 'wpq-ecp' )
            ),
            array(
                'id' => 'ecp_button_options',
                'title' => __( 'Button Options', 'wpq-ecp' )
            ),
            array(
                'id' => 'ecp_popup_options',
                'title' => __( 'PopUP Options', 'wpq-ecp' )
            ),
        );
        return $sections;
    }

    /**
     * Returns all the settings fields
     *
     * @return array settings fields
     */
    function get_settings_fields() {
      
        $settings_fields = array(
            'ecp_general_options' => array(
                 array(
                    'name'    => 'ecp_shortcode',
                    'label'   => __( 'Shortcode', 'wpq-ecp' ),
                    'desc'    => __( 'Put here shortcode', 'wpq-ecp' ),
                    'type'    => 'text',
                    'default' => ''
                ),
            ),

            'ecp_button_options' => array(
                array(
                    'name'    => 'enable-button',
                    'label'   => __( 'Fixed Button Enable', 'wpq-ecp' ),
                    'desc'    => __( 'Please select ON or OFF to display fixed horizontal button in your website', 'wpq-ecp' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),

                 array(
                    'name'    => 'button-position',
                    'label'   => __( 'Button Position', 'wpq-ecp' ),
                    'desc'    => __( 'Please select fixed horizontal button display position', 'wpq-ecp' ),
                    'type'    => 'select',
                    'options' => array(
                        'left' => 'Left',
                        'right'  => 'Right'
                    )
                ),

                array(
                    'name'    => 'button_title',
                    'label'   => __( 'Button Title', 'wpq-ecp' ),
                    'desc'    => __( 'Type Here Button Title (default: Contact Us)', 'wpq-ecp' ),
                    'type'    => 'text',
                    'default' => 'Contact Us'
                ),

                array(
                    'name'    => 'button-bg-color',
                    'label'   => __( 'Button Background Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for button background', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222222'
                ),

                 array(
                    'name'    => 'button-text-color',
                    'label'   => __( 'Button Title Text Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for button title text', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFFFFF'
                ),

                array(
                    'name'    => 'onload-popup-enable',
                    'label'   => __( 'Auto Onload PopUP Enable', 'wpq-ecp' ),
                    'desc'    => __( 'Please select ON or OFF to active onload popup in your website', 'wpq-ecp' ),
                    'type'    => 'checkbox',
                ),

                 array(
                    'name'    => 'onload-popup-timeframe',
                    'label'   => __( 'Onload Time delay', 'wpq-ecp' ),
                    'desc'    => __( 'Default 3000 milliseconds (1 second is equal to 1000 milliseconds.)', 'wpq-ecp' ),
                    'type'    => 'number',
                    'default' => '3000'
                )
            ),

            'ecp_popup_options' => array(
                array(
                    'name'    => 'popup_title',
                    'label'   => __( 'Title', 'wpq-ecpwpq-ecp' ),
                    'desc'    => __( 'Type Here popup Title', 'wpq-ecp' ),
                    'type'    => 'text',
                    'default' => 'Contact Us'
                ),

                array(
                    'name'    => 'popup-effect',
                    'label'   => __( 'Effects', 'wpq-ecp' ),
                    'desc'    => __( 'Select a effects for popup form [Buy <a target="_blank" href="https://wpqastle.com/">Pro Version</a> Now For All Effects]', 'wpq-ecp' ),
                    'type'    => 'select',
                    'default' => 'ecp-effect-1',
                    'options' => array(
                        'ecp-effect-1'   => 'Fade in & Scale',
                        'ecp-effect-2'   => 'Right Slide in (pro)',
                        'ecp-effect-3'   => 'Bottom Slide in (pro)',
                        'ecp-effect-4'   => 'Newspaper (pro)',
                        'ecp-effect-5'   => 'Fall (pro)',
                        'ecp-effect-6'   => 'Side Fall (pro)',
                        'ecp-effect-7'   => 'Sticky Up (pro)',
                        'ecp-effect-8'   => 'Horizontal 3D Flip (pro)',
                        'ecp-effect-9'   => 'Vertical 3D Flip (pro)',
                        'ecp-effect-10'  => '3D Sign (pro)',
                        'ecp-effect-11'  => 'Super Scaled (pro)',
                        'ecp-effect-12'  => 'Just Me (pro)',
                        'ecp-effect-13'  => '3D Slit (pro)',
                        'ecp-effect-14'  => '3D Rotate Bottom (pro)',
                        'ecp-effect-15'  => '3D Rotate In Left (pro)',
                        'ecp-effect-16'  => 'Blur (pro)',
                    )
                ),

                array(
                    'name'    => 'popup-title-bg-color',
                    'label'   => __( 'Title Background Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup title background', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222222'
                ),

                array(
                    'name'    => 'popup-title-color',
                    'label'   => __( 'Title Text Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup title text', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFFFFF'
                ),

                 array(
                    'name'    => 'popup-bg-color',
                    'label'   => __( 'Background Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup background', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#333333'
                ),

                array(
                    'name'    => 'popup-text-color',
                    'label'   => __( 'Text Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup text', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFFFFF'
                ),

                array(
                    'name'    => 'popup-bg-overlay-color',
                    'label'   => __( 'Overlay Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup background overlay', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#333333'
                ),

                array(
                    'name'    => 'popup-bg-overlay-opacity',
                    'label'   => __( 'Overlay Opacity', 'wpq-ecp' ),
                    'desc'    => __( 'Please select a value', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '1',
                    'step'    => '0.1'
                ),


            ),
        );

        return $settings_fields;
    }

    function plugin_page() {
        echo '<div class="top-ads"><p class="left-text">Upgrade to <strong><a target="_blank" href="https://wpqastle.com/">Easy Contact PopUP Pro</a></strong> today</p> <span class="right-text"> Version: '.ECP_PLUGIN_VER.'</span></div>';
        echo '<div class="wrap ecp-wrap">';
        echo '<h2 class="ecp-option-title">Easy Contact PopUP</h2>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
        echo '<div class="ecp-ads">';
        echo '<a target="_blank" href="https://wpqastle.com/"><img src="'.plugins_url( '/easy-contact-popup/lib/img/ecp-pro.png').'" alt="Easy Contact PopUP Pro"></a>';
        echo '<p class="ads-txt">Remove these ads? </br> Upgrade to <a target="_blank" href="https://wpqastle.com/">Easy Contact PopUP Pro »</a></p>';
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

$settings = new ECP_Settings_API_Main();