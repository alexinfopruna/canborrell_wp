<?php 
/*************** ACTIONS ***************/
add_action('wp_head'	, 	'ecp_custom_css');					// Load Custom CSS
add_action('init'		,	'ecp_lib_css');						// Load Lib CSS

add_action('init'		,	'ecp_modernizr');					// Load Modernizr
add_action('init'		,	'ecp_latest_jQuery'); 				// Load Latest Jquery
add_action('init'		,	'ecp_lib_js');						// Load Lib Js

add_action('wp_footer'	,	'ecp_insert_popup_modal', 20 );		// Load Popup Box

/*******************************************************************************/
$fixed_button = ecp_get_option('enable-button', 'ecp_button_options', 'on');

	if ($fixed_button == 'on') {
		add_action('wp_footer'	,	'ecp_insert_button', 30 );	// Load Insert Button
	} else {
	}

$onload_pupup = ecp_get_option('onload-popup-enable', 'ecp_button_options', 'off');
	if ($onload_pupup == 'on') {
		add_action('wp_footer'	,	'ecp_onload_button', 35 );	// Load Insert Button
		add_action('wp_footer'	,	'ecp_custom_js'); 			// load Custom js
	} else {
	}

/*******************************************************************************/
add_action('wp_footer'	,	'ecp_insert_overlay', 40 ); 		// load overlay
add_action('wp_footer'	,	'ecp_effects_js', 50 ); 			// load effect js

add_action('admin_notices', 'plugin_dependencies_admin_notice' );
add_action('admin_enqueue_scripts'	, 	'ecp_custom_admin_css');	// Load Custom CSS
add_action('admin_enqueue_scripts'	, 	'ecp_custom_admin_js');		// Load Custom CSS


