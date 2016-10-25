<?php 
/*
Plugin Name: Easy Contact PopUP 
Plugin URI: https://wpqastle.com/
Description: Highly Customizable, stylish, modern, flexible, responsive, beautiful and easy to use contact pop-up plugin for WordPress. Currently it's only integration with Contact Form 7.
Version: 1.0.0
Author: WPQastle, fahim.xyz
Author URI: https://wpqastle.com
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Domain Path: /languages
Text Domain: wpq-ecp
Copyright 2016  WPQastle  (email : info@wpqastle.com)
*/

// If this file is called directly, abort.
if (!defined( 'WPINC' ) ) {
    die;
}

/*** Global Paths and Folders ***/
define('ECP_PLUGIN_VER'		  	, 	'1.0.0' );
define('ECP_PLUGIN_PATH'      	, 	 plugin_dir_url(  __FILE__  ));
define('ECP_PLUGIN_DIR'       	, 	 dirname( __FILE__ ) . '/' );
define('ECP_PLUGIN_MAIN_PATH' 	, 	 plugin_basename( __FILE__ ));
define('ECP_LIB_FOLDER'       	, 	 ECP_PLUGIN_PATH	. 'lib/');
define('ECP_CSS_FOLDER'       	, 	 ECP_LIB_FOLDER	. 'css/');
define('ECP_JS_FOLDER'       	, 	 ECP_LIB_FOLDER	. 'js/');
define('ECP_INC_FOLDER'       	, 	 ECP_PLUGIN_DIR	. 'inc/');

/** Functions File Load **/
require(ECP_INC_FOLDER . 'functions.php');

/** Load All Scripts and CSS files **/
require(ECP_INC_FOLDER . 'enqueue-script.php');

/** Load ECP Options **/
require(ECP_INC_FOLDER . 'class.options-api.php');
require(ECP_INC_FOLDER . 'options.php');

/** Load All Hooks **/
require(ECP_INC_FOLDER . 'hooks.php');