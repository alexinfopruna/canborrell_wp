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

		$disable_css = ecp_get_option('disable-css', 'ecp_general_options', 'on');
		//button style
		$bbc 	= 	ecp_get_option('button-bg-color', 'ecp_button_options', '#222');
		$btc 	= 	ecp_get_option('button-text-color', 'ecp_button_options', '#FFF');
		$blp 	= 	ecp_get_option('button-left-position', 'ecp_button_options', '-64');
		$brp 	= 	ecp_get_option('button-left-position', 'ecp_button_options', '-64');

		$pp 	= 	ecp_get_option('popup-position', 'ecp_popup_options', 'absolute');
		$pmw 	= 	ecp_get_option('popup-modal-width', 'ecp_popup_options', '40');
		$pmtp 	= 	ecp_get_option('popup-modal-top-position', 'ecp_popup_options', '50');
		$pmlp 	= 	ecp_get_option('popup-modal-left-position', 'ecp_popup_options', '50');

		$pbc 	= 	ecp_get_option('popup-bg-color', 'ecp_popup_options', '#FFF');
		$ptc 	= 	ecp_get_option('popup-text-color', 'ecp_popup_options', '#222');
		$pfs 	= 	ecp_get_option('popup-font-size', 'ecp_popup_options', '16');

		$ptbc 	= 	ecp_get_option('popup-title-bg-color', 'ecp_popup_options', '#222');
		$pt_color = ecp_get_option('popup-title-color', 'ecp_popup_options', '#FFF');
		$ptfs 	= 	ecp_get_option('popup-title-font-size', 'ecp_popup_options', '24');

		$pboc 	= ecp_get_option('popup-bg-overlay-color', 'ecp_popup_options', '#222');
		$pboo 	= ecp_get_option('popup-bg-overlay-opacity', 'ecp_popup_options', '0.7');

		$ecp_rgba 	= ecp_hex2rgba($pboc, $pboo);

		$ifw 	=	ecp_get_option('input_field_width', 'ecp_form_design_options', '100');
		$ifbc 	=	ecp_get_option('input_field_bg', 'ecp_form_design_options', '#FFF');
		$ifc 	= 	ecp_get_option('input_field_color', 'ecp_form_design_options', '#222');
		$ibc 	=	ecp_get_option('input_border_color', 'ecp_form_design_options', '#222');
		$iffs 	=	ecp_get_option('input_field_font_size', 'ecp_form_design_options', '16');
		$ibw 	=	ecp_get_option('input_border_width', 'ecp_form_design_options', '1');
		$ibr 	=	ecp_get_option('input_border_radius', 'ecp_form_design_options', '1');

		$sfw 	=	ecp_get_option('select_field_width', 'ecp_form_design_options', '100');;
		$sfbc 	=	ecp_get_option('select_field_bg', 'ecp_form_design_options', '#FFF');
		$sfc 	= 	ecp_get_option('select_field_color', 'ecp_form_design_options', '#222');
		$sbc 	=	ecp_get_option('select_border_color', 'ecp_form_design_options', '#222');
		$sffs 	=	ecp_get_option('select_field_font_size', 'ecp_form_design_options', '16');
		$sbw 	=	ecp_get_option('select_border_width', 'ecp_form_design_options', '1');
		$sbr 	=	ecp_get_option('select_border_radius', 'ecp_form_design_options', '1');

		$tfw 	=	ecp_get_option('textarea_field_width', 'ecp_form_design_options', '100');
		$tfbc 	=	ecp_get_option('textarea_field_bg', 'ecp_form_design_options', '#FFF');
		$tfc 	= 	ecp_get_option('textarea_field_color', 'ecp_form_design_options', '#222');
		$tbc 	=	ecp_get_option('textarea_border_color', 'ecp_form_design_options', '#222');
		$tffs 	=	ecp_get_option('textarea_field_font_size', 'ecp_form_design_options', '16');
		$tbw 	=	ecp_get_option('textarea_border_width', 'ecp_form_design_options', '1');
		$tbr 	=	ecp_get_option('textarea_border_radius', 'ecp_form_design_options', '1');

		$sbws 	=	ecp_get_option('submit_button_width_size', 'ecp_form_design_options', '100');
		$sbb 	=	ecp_get_option('submit_button_bg', 'ecp_form_design_options', '#222');
		$sbtc 	=	ecp_get_option('submit_button_text_color', 'ecp_form_design_options', '#FFF');
		$sbfs 	=	ecp_get_option('submit_button_font_size', 'ecp_form_design_options', '16');
		$sbbc	=	ecp_get_option('submit_button_border_color', 'ecp_form_design_options', '#FFF');
		$sbbw	=	ecp_get_option('submit_button_border_width', 'ecp_form_design_options', '0');
		$sbbr 	=	ecp_get_option('submit_button_border_radius', 'ecp_form_design_options', '1');
?>
    	
<style type="text/css">
    .ecp-button { background-color:<?php echo $bbc; ?>; cursor: pointer;}
    .ecp-button a { color:<?php echo $btc; ?>;}
	.ecp-button.left {left:<?php echo $blp; ?>px;}
	.ecp-button.right {right:<?php echo $brp; ?>px;}

    .ecp-modal {
    	width: <?php echo $pmw; ?>%;
    	top: <?php echo $pmtp; ?>%;
    	left: <?php echo $pmlp; ?>%;
		position: <?php echo $pp; ?>;
    }

	.ecp-content {
		background: <?php echo $pbc; ?>; 
		color: <?php echo $ptc; ?>;
		font-size: <?php echo $pfs; ?>px;
	}

	.ecp-content h3 {
		background-color: <?php echo $ptbc; ?>;
		color: <?php echo $pt_color; ?>;
		font-size: <?php echo $ptfs; ?>px;
	}

	.ecp-overlay { 
		background: <?php echo $ecp_rgba; ?>; 
	}

<?php if ($disable_css == 'off') { ?>

	.ecp-content input, textarea, select, button {
		margin: 5px 0;
		padding: 5px;
		-webkit-box-sizing: border-box;
		-moz-box-sizing: border-box;
		box-sizing: border-box;
	}

	.ecp-content input[type="text"], 
	.ecp-content input[type="email"], 
	.ecp-content input[type="tel"],  
	.ecp-content input[type="number"],  
	.ecp-content input[type="date"] {
		width: <?php echo $ifw; ?>%;
		background-color: <?php echo $ifbc; ?>;
		color: <?php echo $ifc; ?>;
		border-width: <?php echo $ibw; ?>px;
		border-color: <?php echo $ibc; ?>;
		border-radius: <?php echo $ibr; ?>px;
		font-size: <?php echo $iffs; ?>px;
	}

	.ecp-content select {
		width: <?php echo $sfw; ?>%;
		background-color: <?php echo $sfbc; ?>;
		color: <?php echo $sfc; ?>;
		border-width: <?php echo $sbw; ?>px;
		border-color: <?php echo $sbc; ?>;
		border-radius: <?php echo $sbr; ?>px;
		font-size: <?php echo $sffs; ?>px;
	}

	.ecp-content textarea {
		width: <?php echo $tfw; ?>%;
		background-color: <?php echo $tfbc; ?>;
		color: <?php echo $tfc; ?>;
		border-width: <?php echo $tbw; ?>px;
		border-color: <?php echo $tbc; ?>;
		border-radius: <?php echo $tbr; ?>px;
		font-size: <?php echo $tffs; ?>px;
	}

	.ecp-content input[type="submit"] {
		width: <?php echo $sbws; ?>%;
		background: <?php echo $sbb; ?>;
		font-size: <?php echo $sbfs; ?>px;
		color: <?php echo $sbtc; ?> !impotant;
		border-color: <?php echo $sbbc; ?>;
		border-width: <?php echo $sbbr; ?>px;
		border-radius: <?php echo $sbbr; ?>px;
	}

<?php } ?>

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
