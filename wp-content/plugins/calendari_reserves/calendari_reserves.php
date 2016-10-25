<?php

/*
  Plugin Name: calendari_reserves
  Plugin URI: can-borrell.com
  Description: Incrusta un calendari de reserves
  Version: 1.0
  Author: Alex Garcia
  Author URI: dadapuntcat.cat
 */

/*
  calendari_reserves esto aparecerá directamente en el panel de
  administración de plugins
 */

function calendari_reserves() {
  //echo '<br>calendari_reserves<br>calendari_reserves<br>calendari_reserves';
}

function calendari_reserves_instala() {
  
}

function calendari_reserves_desinstala() {
  
}

function calendari_reserves_panel() {
  include('template/panel.html');
  echo "<h1>{$_POST['<br>calendari_reservesinserta']}</h1>";
}

function calendari_reserves_add_menu() {
  if (function_exists('add_options_page')) {
    //add_menu_page
    add_options_page('calendari_reserves', 'calendari_reserves', 8, basename(__FILE__), 'calendari_reserves_panel');
  }
}

if (function_exists('add_action')) {
  add_action('admin_menu', 'calendari_reserves_add_menu');
}



function reserves_bootstrap() {
  if (!defined("GESTOR")) {
    
    //echo $_SERVER['DOCUMENT_ROOT'];die();
    if (!defined('ROOT'))
      define('ROOT', $_SERVER['DOCUMENT_ROOT']."/cb-reserves/taules/");
    require_once (ROOT . "gestor_reserves.php");

    $lang = gestor_reserves::getLanguage();
    
    
    require_once("cb-reserves/translate_web_$lang.php");
  }

  echo "         <script> ";

  global $gestor;
  $gestor = new gestor_reserves();
}

function load_calendari_reserves() {
  
  global $gestor;
  $gestor->lng = $lang = Gestor::getLanguage();
  $l = $gestor->lng;
  
   // wp_register_script('uii18', '//ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/i18n/jquery-ui-i18n.min.js', array('jquery'), null, true);
  //wp_enqueue_script('uii18')
  
  
  
  $PERSONES_GRUP = $gestor->configVars("persones_grup");
  echo $gestor->dumpJSVars();
  echo " \n      var PERSONES_GRUP =" . $PERSONES_GRUP . ";";
  echo "\n      var lang = \"" . $lang . "\";\n \n \n ";

  //TRANSLATES
  if (!defined("LLISTA_DIES_NEGRA"))
    define("LLISTA_DIES_NEGRA", INC_FILE_PATH . "llista_dies_negra_online.txt");
  if (!defined("LLISTA_DIES_BLANCA"))
    define("LLISTA_DIES_BLANCA", INC_FILE_PATH . "llista_dies_blanca.txt");
  if (!defined("LLISTA_NITS_NEGRA"))
    define("LLISTA_NITS_NEGRA", INC_FILE_PATH . "llista_dies_negra_online.txt");

    if (!defined("PREU_MIG"))
    define("PREU_MIG", $gestor->configVars("PREU_MIG"));

  
  require_once(ROOT . INC_FILE_PATH . 'alex.inc');
  require_once (ROOT . INC_FILE_PATH . "llista_dies_taules.php");

  $llista_negra = llegir_dies(LLISTA_DIES_NEGRA);
  print crea_llista_js($llista_negra, "LLISTA_NEGRA");
  print "\n////////////1\n";

  $llista_blanca = llegir_dies(LLISTA_DIES_BLANCA);
  print crea_llista_js($llista_blanca, "LLISTA_BLANCA");
  print "\n////////////2\n";


  $llista_dies_no_carta = llegir_dies(INC_FILE_PATH . "llista_dies_no_carta.txt");
  print crea_llista_js($llista_dies_no_carta, "LLISTA_DIES_NO_CARTA");
  print "\n////////////3\n";

  echo "\n          if (typeof variable === 'undefined') var RDATA;\n\n ";
  echo "\n         </script>\n\n ";

  wp_enqueue_style('jqueryui', '/cb-reserves/css/jquery-ui.css');

  wp_register_script('datepicker', '/cb-reserves/taules/js/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js', array('jquery'), null, true);
  wp_enqueue_script('datepicker');

      wp_register_script('lang_calend', '/cb-reserves/taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-'.ICL_LANGUAGE_CODE.'.js', array('jquery'), null, true);
  wp_enqueue_script('lang_calend');
  
    wp_register_script('canborrell', '/cb-reserves' . '/js/cb_static.js', array('jquery'), null, true);
  wp_enqueue_script('canborrell');


  

}

/* * ************************************************************************** */
/* * ************************************************************************** */
/* * ************************************************************************** */

//ojo con la sintaxis de la funcion add_action 
add_action('calendari_reserves/calendari_reserves.php', 'calendari_reserves_instala');
add_action('calendari_reserves/calendari_reserves.php', 'calendari_reserves_desinstala');

$gestor = new stdClass;
add_action("wp_enqueue_scripts", "reserves_bootstrap");
add_action("wp_enqueue_scripts", "load_calendari_reserves");
//add_action("wp_footer","calendari_reserves");
//include("/cb-reserves/bootstrap.php");


include("widget/calendari_reserves_widget.php");



?>
