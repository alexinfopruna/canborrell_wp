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
                'title' => __( 'General', 'wpq-ecp' )
            ),
            array(
                'id' => 'ecp_button_options',
                'title' => __( 'Button', 'wpq-ecp' )
            ),
            array(
                'id' => 'ecp_popup_options',
                'title' => __( 'PopUP', 'wpq-ecp' )
            ),

            array(
                'id' => 'ecp_form_design_options',
                'title' => __( 'Form Design', 'wpq-ecp' )
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
                
                array(
                    'name'    => 'disable-css',
                    'label'   => __( 'Disable default CF7 form CSS', 'wpq-ecp' ),
                    'desc'    => __( 'Disable CSS that comes bundled with Contact Form 7 (When you off default css only this time FORM DESIGN working', 'wpq-ecp' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),
            ),

            'ecp_button_options' => array(
                array(
                    'name'    => 'enable-button',
                    'label'   => __( 'Fixed Button Enable', 'wpq-ecp' ),
                    'desc'    => __( 'Select ON or OFF to display fixed horizontal button in your website', 'wpq-ecp' ),
                    'type'    => 'checkbox',
                    'default' => 'on'
                ),

                 array(
                    'name'    => 'button-position',
                    'label'   => __( 'Button Position', 'wpq-ecp' ),
                    'desc'    => __( 'Select fixed horizontal button display position', 'wpq-ecp' ),
                    'type'    => 'select',
                    'options' => array(
                        'left' => 'Left',
                        'right'  => 'Right'
                    )
                ),                 

                array(
                    'name'    => 'button-left-position',
                    'label'   => __( 'Button Left Position', 'wpq-ecp' ),
                    'desc'    => __( 'If you select left position button use it to fixed postion', 'wpq-ecp' ),
                    'type'    => 'number',
                    'default' => '-60'
                ),

                array(
                    'name'    => 'button-right-position',
                    'label'   => __( 'Button Right Position', 'wpq-ecp' ),
                    'desc'    => __( 'If you select right position button use it to fixed postion', 'wpq-ecp' ),
                    'type'    => 'number',
                    'default' => '-60'
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
                    'default' => '#222'
                ),

                 array(
                    'name'    => 'button-text-color',
                    'label'   => __( 'Button Title Text Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for button title text', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'onload-popup-enable',
                    'label'   => __( 'Auto Onload PopUP Enable', 'wpq-ecp' ),
                    'desc'    => __( 'Select ON or OFF to active onload popup in your website', 'wpq-ecp' ),
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
                    'name'    => 'popup-position',
                    'label'   => __( 'Popup Position', 'wpq-ecp' ),
                    'desc'    => __( 'Select popup display position', 'wpq-ecp' ),
                    'type'    => 'select',
                    'options' => array(
                        'absolute' => 'Absolute',
                        'fixed'  => 'Fixed'
                    )
                ),

                array(
                    'name'    => 'popup-modal-width',
                    'label'   => __( 'Popup Window Width', 'wpq-ecp' ),
                    'desc'    => __( 'Select a value', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',
                    'default' => '40'
                ),

                array(
                    'name'    => 'popup-modal-top-position',
                    'label'   => __( 'Popup Window Top Position', 'wpq-ecp' ),
                    'desc'    => __( 'Select a value', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',
                    'default' => '50'
                ),

                array(
                    'name'    => 'popup-modal-left-position',
                    'label'   => __( 'Popup Window Left Position', 'wpq-ecp' ),
                    'desc'    => __( 'Select a value', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',                  
                    'default' => '50'
                ),

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
                    'desc'    => __( 'Select a effects for popup form', 'wpq-ecp' ),
                    'type'    => 'select',
                    'default' => 'ecp-effect-1',
                    'options' => array(
                        'ecp-effect-1'   => 'Fade in & Scale',
                        'ecp-effect-2'   => 'Right Slide in',
                        'ecp-effect-3'   => 'Bottom Slide in',
                        'ecp-effect-4'   => 'Newspaper',
                        'ecp-effect-5'   => 'Fall',
                        'ecp-effect-6'   => 'Side Fall',
                        'ecp-effect-7'   => 'Sticky Up',
                        'ecp-effect-8'   => 'Horizontal 3D Flip',
                        'ecp-effect-9'   => 'Vertical 3D Flip',
                        'ecp-effect-10'  => '3D Sign',
                        'ecp-effect-11'  => 'Super Scaled',
                        'ecp-effect-12'  => 'Just Me',
                        'ecp-effect-13'  => '3D Slit',
                        'ecp-effect-14'  => '3D Rotate Bottom',
                        'ecp-effect-15'  => '3D Rotate In Left',
                    )
                ),

                array(
                    'name'    => 'popup-title-bg-color',
                    'label'   => __( 'Title Background Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup title background', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'popup-title-color',
                    'label'   => __( 'Title Text Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup title text', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'popup-title-font-size',
                    'label'   => __( 'Title Font Size', 'wpq-ecp' ),
                    'desc'    => __( 'Put font size for modal text', 'wpq-ecp' ),
                    'type'    => 'number',
                    'default' => '24'
                ),

                 array(
                    'name'    => 'popup-bg-color',
                    'label'   => __( 'Background Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup background', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'popup-text-color',
                    'label'   => __( 'Text Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup text', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'popup-font-size',
                    'label'   => __( 'Text Font Size', 'wpq-ecp' ),
                    'desc'    => __( 'Put font size for modal text', 'wpq-ecp' ),
                    'type'    => 'number',
                    'default' => '16'
                ),

                array(
                    'name'    => 'popup-bg-overlay-color',
                    'label'   => __( 'Overlay Color', 'wpq-ecp' ),
                    'desc'    => __( 'Pick a color for popup background overlay', 'wpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
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

            'ecp_form_design_options' => array(

                array(
                    'name'    => 'input_field_bg',
                    'label'   => __( 'Input Field Background', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'input_field_width',
                    'label'   => __( 'Input Field Width', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',
                    'default' => '100'
                ),

                array(
                    'name'    => 'input_field_color',
                    'label'   => __( 'Input Field Text Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'input_field_font_size',
                    'label'   => __( 'Input Field Font Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '16'
                ),

                array(
                    'name'    => 'input_border_width',
                    'label'   => __( 'Input Border Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                array(
                    'name'    => 'input_border_color',
                    'label'   => __( 'Input Border Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'input_border_radius',
                    'label'   => __( 'Input Border Radius', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                // Select
                array(
                    'name'    => 'select_field_bg',
                    'label'   => __( 'Select Field Background', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'

                ),

                array(
                    'name'    => 'select_field_width',
                    'label'   => __( 'Select Field Width', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',
                    'default' => '100'
                ),

                array(
                    'name'    => 'select_field_color',
                    'label'   => __( 'Select Field Text Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'select_field_font_size',
                    'label'   => __( 'Select Field Font Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '16'
                ),

                array(
                    'name'    => 'select_border_width',
                    'label'   => __( 'Select Border Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                array(
                    'name'    => 'select_border_color',
                    'label'   => __( 'Select Border Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'select_border_radius',
                    'label'   => __( 'Select Border Radius', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                // Textarea
                array(
                    'name'    => 'textarea_field_bg',
                    'label'   => __( 'Textarea Field Background', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'textarea_field_width',
                    'label'   => __( 'Textarea Field Width', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',
                    'default' => '100'
                ),

                array(
                    'name'    => 'textarea_field_color',
                    'label'   => __( 'Textarea Field Text Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'textarea_field_font_size',
                    'label'   => __( 'Textarea Field Font Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '16'
                ),

                array(
                    'name'    => 'textarea_border_width',
                    'label'   => __( 'Textarea Border Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                array(
                    'name'    => 'textarea_border_color',
                    'label'   => __( 'Textarea Border Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'textarea_border_radius',
                    'label'   => __( 'Textarea Border Radius', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                // Submit Button Design
                array(
                    'name'    => 'submit_button_width_size',
                    'label'   => __( 'Submit Button Width', 'wpq-ecp' ),
                    'type'    => 'range',
                    'min'     => '0',
                    'max'     => '100',
                    'step'    => '1',
                    'default' => '50'
                ),

                array(
                    'name'    => 'submit_button_bg',
                    'label'   => __( 'Sunmit Button Background', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#222'
                ),

                array(
                    'name'    => 'submit_button_text_color',
                    'label'   => __( 'Sunmit Button Text Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'submit_button_font_size',
                    'label'   => __( 'Submit button font size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '16'
                ),

                array(
                    'name'    => 'submit_button_border_width',
                    'label'   => __( 'Submit Button Border Size', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),

                array(
                    'name'    => 'submit_button_border_color',
                    'label'   => __( 'Submit Button Border Color', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'color',
                    'default' => '#FFF'
                ),

                array(
                    'name'    => 'submit_button_border_radius',
                    'label'   => __( 'Submit Button Border Radius', 'wpq-ecpwpq-ecp' ),
                    'type'    => 'number',
                    'default' => '1'
                ),
            ),
        );

        return $settings_fields;
    }

    function plugin_page() {
       // echo '<div class="top-ads"><p class="left-text">Upgrade to <strong><a target="_blank" href="https://wpqastle.com/">Easy Contact PopUP Pro</a></strong> today</p> <span class="right-text"> Version: '.ECP_PLUGIN_VER.'</span></div>';
        echo '<div class="wrap ecp-wrap">';
        echo '<h2 class="ecp-option-title">Easy Contact PopUP</h2>';
        $this->settings_api->show_navigation();
        $this->settings_api->show_forms();
        echo '</div>';
        echo "Enjoyed Easy Contact PopUp? Please leave us a <a href='https://wordpress.org/support/plugin/easy-contact-popup/reviews/#postform' target='_blank'>5 star</a> rating. We really appreciate your support! ";
       // echo '<div class="ecp-ads">';
       // echo '<a target="_blank" href="https://wpqastle.com/"><img src="'.plugins_url( '/easy-contact-popup/lib/img/ecp-pro.png').'" alt="Easy Contact PopUP Pro"></a>';
        //echo '<p class="ads-txt">Remove these ads? </br> Upgrade to <a target="_blank" href="https://wpqastle.com/">Easy Contact PopUP Pro »</a></p>';
        //echo '</div>';
    }

}
endif;

$settings = new ECP_Settings_API_Main();