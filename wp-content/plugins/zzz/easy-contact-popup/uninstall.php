<?php

if( !defined( 'WP_UNINSTALL_PLUGIN' )) 

exit();
	
//All Options
$ecp_options = array('ecp_general_options', 'ecp_button_options', 'ecp_popup_options', 'ecp_form_design_options');

foreach ($ecp_options as $ecp_option) {
	delete_option($ecp_option);
}
