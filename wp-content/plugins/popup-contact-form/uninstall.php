<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('PopupContact_title');
delete_option('PopupContact_fromemail');
delete_option('PopupContact_On_Homepage');
delete_option('PopupContact_On_Posts');
delete_option('PopupContact_On_Pages');
delete_option('PopupContact_On_Archives');
delete_option('PopupContact_On_Search');
delete_option('PopupContact_On_SendEmail');
delete_option('PopupContact_On_MyEmail');
delete_option('PopupContact_On_Subject');
delete_option('PopupContact_On_Captcha');
delete_option('PopupContact_Caption');
delete_option('PopupContact_homeurl');
 
// for site options in Multisite
delete_site_option('PopupContact_title');
delete_site_option('PopupContact_fromemail');
delete_site_option('PopupContact_On_Homepage');
delete_site_option('PopupContact_On_Posts');
delete_site_option('PopupContact_On_Pages');
delete_site_option('PopupContact_On_Archives');
delete_site_option('PopupContact_On_Search');
delete_site_option('PopupContact_On_SendEmail');
delete_site_option('PopupContact_On_MyEmail');
delete_site_option('PopupContact_On_Subject');
delete_site_option('PopupContact_On_Captcha');
delete_site_option('PopupContact_Caption');
delete_site_option('PopupContact_homeurl');