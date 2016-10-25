<?php 

/* Load jQuery Latest Version
*
* @since      1.0.0
* @package    Easy Contact PopUP
* @author     Amity Themes <info@amitythemes.com>
*/
function ecp_latest_jQuery() {
	wp_enqueue_script('jquery');
}

/* Loadmodernizr
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/
function ecp_modernizr() {
	if (!is_admin()) {
    	wp_enqueue_script( 'ecp-modernizr-js' ,	ECP_JS_FOLDER. 'modernizr.custom.js');
    }
}

/* Load Plugin CSS Style
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/
function ecp_lib_css() {
	if (!is_admin()) {
    	wp_enqueue_style( 'ecp-main-css', ECP_CSS_FOLDER . 'main.css');
    	wp_enqueue_style( 'ecp-effects-css', ECP_CSS_FOLDER . 'effects.css');
    }
}

/* Load Plugin JS Files
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/
function ecp_lib_js() {
	if (!is_admin()) {
    	wp_enqueue_script( 'ecp-classie-js'	  , ECP_JS_FOLDER. 'classie.js', false, false, true );
}
}

/* Load Plugin Effects JS
*
* @since      1.0.0
* @package    Easy Contact PopUP 
* @author     WPQastle <info@wpqastle.com>
*/

function ecp_effects_js() { 
	if (!is_admin()) { ?>
    	<script type="text/javascript" src="<?php echo ECP_JS_FOLDER. 'ecp-effects.js' ?>"></script>
	<?php }
}

/* 
* Load Custom CSS
*
* @since      1.0.0
* @package    Easy Contact PopUP
* @author     WP Qastle <info@wpqastle.com>
*/

function ecp_custom_css() { 
	if (!is_admin()) {
		$btn_bg_color = ecp_get_option('button-bg-color', 'ecp_button_options', '#222222');
		$btn_txt_color = ecp_get_option('button-text-color', 'ecp_button_options', '#FFFFFF');
		$popup_bg_color = ecp_get_option('popup-bg-color', 'ecp_popup_options', '#333333');
		$popup_txt_color = ecp_get_option('popup-text-color', 'ecp_popup_options', '#FFFFFF');
		$popup_title_bg_color = ecp_get_option('popup-title-bg-color', 'ecp_popup_options', '#222222');
		$popup_title_color = ecp_get_option('popup-title-color', 'ecp_popup_options', '#FFFFFF');

		$color = ecp_get_option('popup-bg-overlay-color', 'ecp_popup_options', '#000000');
		$opacity = ecp_get_option('popup-bg-overlay-opacity', 'ecp_popup_options', '0.5');;
		$rgba = hex2rgba($color, $opacity);
?>
    	
<style type="text/css">
    .ecp-button {background-color:<?php echo $btn_bg_color; ?>;}
    .ecp-button .arrow { color:<?php echo $btn_txt_color; ?>;}
	.ecp-content {background-color:<?php echo $popup_bg_color; ?>; color:<?php echo $popup_txt_color; ?>}
	.ecp-content h3 {background-color:<?php echo $popup_title_bg_color; ?>; color:<?php echo $popup_title_color; ?>;}
	.ecp-overlay { background: <?php echo $rgba; ?>; }
</style>
	<?php }
}

/* 
* Load Custom JS
*
* @since      1.0.0
* @package    Easy Contact PopUP
* @author     WP Qastle <info@wpqastle.com>
*/

function ecp_custom_js() {
	if (!is_admin()) {
	$onload_time = ecp_get_option('onload-popup-timeframe', 'ecp_button_options', '3000');
?>
<script type="text/javascript">
	/* Popup onload Load */
	window.onload = setTimeout( function(){ 
		document.getElementById("onload-popup").click();
	} , <?php echo $onload_time; ?> );

</script>
	<?php }
}

/* 
* Load Custom Admin CSS
*
* @since      1.0.0
* @package    Easy Contact PopUP
* @author     WP Qastle <info@wpqastle.com>
*/
function ecp_custom_admin_css() { 
	if (is_admin()) {			
    	wp_enqueue_style( 'ecp-onoff-css', ECP_CSS_FOLDER . 'onoff.css');
    	wp_enqueue_style( 'ecp-rangeslider-css', ECP_CSS_FOLDER . 'rangeslider.css');
    	wp_enqueue_style( 'ecp-admin-css', ECP_CSS_FOLDER . 'admin.css');
	}
}

/* 
* Load Custom Admin JS
*
* @since      1.0.0
* @package    Easy Contact PopUP
* @author     WP Qastle <info@wpqastle.com>
*/
function ecp_custom_admin_js() {
	if (is_admin()) { 
    		wp_enqueue_script( 'ecp-onoff-js', ECP_JS_FOLDER. 'jquery.onoff.min.js');
    		wp_enqueue_script( 'ecp-rangeslider-js', ECP_JS_FOLDER. 'rangeslider.min.js');
		?>

	<?php }
}
