<?php

/*
* Plugin Dependencies Cheker
*
* @since      1.0.0
* @package    Breaking News Ticker
* @author     WP Qastle <info@wpqastle.com>
*/
function plugin_dependencies_admin_notice() {
    // Verify that CF7 is active and updated to the required version (currently 3.9.0)
    if ( is_plugin_active('contact-form-7/wp-contact-form-7.php') ) {
    } else {
    	echo '<div class="error ecp-error"><p><strong> Contact Form 7</strong>  is not activated. The Contact Form 7 Plugin must be installed and activated before you can use <strong> Easy Contact PopUP</strong>.</p></div>';
    }
}

/*
* Disable default CSS for this form
* Disables CSS that comes bundled with Contact Form 7.
 */

if (!isset($disable_css)) $disable_css = null;

if ($disable_css == 'off') { define( 'WPCF7_LOAD_CSS', false ); }

/* 
* Get Options
*
* @since      1.0.0
* @package    Breaking News Ticker
* @author     WP Qastle <info@wpqastle.com>
*/

function ecp_get_option( $option, $section, $default = '' ) {
    $options = get_option( $section );
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
    return $default;
}

/* Load Plugin Fixed Horizontal Button
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/
function ecp_insert_button() {
    	$btn_position = ecp_get_option('button-position', 'ecp_button_options', 'left');
    	$btn_title = ecp_get_option('button_title', 'ecp_button_options', 'Contact Now');
        echo '<div class="ecp-button '.$btn_position.'"> ';
        echo '<a href="#" class="ecp-trigger arrow" data-modal="modal" id="onload"> ';
       	echo $btn_title;
        echo '</a>';
        echo '</div> ';
    }

/* Load Plugin Onload Button
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/

function ecp_onload_button() {
    echo '<a href="#" class="ecp-trigger" data-modal="modal" id="onload-popup"></a> ';
}

/* Load Plugin Overlay 
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/
function ecp_insert_overlay() {
    echo ' <div class="ecp-overlay"></div> ';
}

/* Load Plugin Modal/PopUP Box
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/

function ecp_insert_popup_modal() {
	$ecp_effect = ecp_get_option('popup-effect', 'ecp_popup_options', 'ecp-effect-1');
	echo "<div class='ecp-modal ".$ecp_effect."' id='modal'> ";
	echo "<div class='ecp-content'> ";
	echo "<h3>" .ecp_get_option('popup_title', 'ecp_popup_options', 'Contact Now'). "<span class='ecp-close'></span>" . "</h3>";
	echo "<div>";
    
    $contact_form = ecp_get_option('ecp_shortcode', 'ecp_general_options', '');

    if (!empty($contact_form)) {
	   echo  do_shortcode(''.$contact_form.'');
    } 

    else {
       echo ' <div class="ecp-error-form"><p> Please Set a<strong> Contact Form 7</strong> Shortcode. Check This <a href="https://www.youtube.com/watch?v=kK0rg8Lt9kw" target="_blank" > Video Tutorial </a></p></div>';
   }
	echo "</div>";
	echo " </div> ";
	echo " </div> ";
}

if (!function_exists( 'ecp_hex2rgba' ) ) {
    function ecp_hex2rgba($color, $opacity = false) {
                 
        $default = 'rgb(0,0,0)';
                    
        //Return default if no color provided
        if(empty($color))
                return $default; 
                 
            //Sanitize $color if "#" is provided 
            if ($color[0] == '#' ) {
                $color = substr( $color, 1 );
            }
        
            //Check if color has 6 or 3 characters and get values
            if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
            } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
            } else {
                return $default;
            }
                 
            //Convert hexadec to rgb
            $rgb =  array_map('hexdec', $hex);
                 
            //Check if opacity is set(rgba or rgb)
            if($opacity){
            
            if(abs($opacity) > 1)
            $opacity = 1.0;
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
            } else {
                $output = 'rgb('.implode(",",$rgb).')';
            }
        
        //Return rgb(a) color string
        return $output;
    }
}