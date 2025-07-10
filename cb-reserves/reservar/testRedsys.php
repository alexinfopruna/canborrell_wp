<?php

if (!defined('ROOT'))
  define('ROOT', "../taules/");
require_once (ROOT . "Gestor.php");

/* * ************** PERMISOS ADMIN *************************************** */
if (!isset($_SESSION['permisos']))
  die("error:sin permisos"); /*   * ******* */
if ($_SESSION['permisos'] < 200)
  die("error:sin permisos"); /*   * ********* */
/* * ************** PERMISOS ADMIN *************************************** */
$id = $lang = "not set";
$tpv_config_file = isset($_REQUEST['tpv_config_file']) ? $_REQUEST['tpv_config_file'] : TPV_CONFIG_FILE;
include(ROOT . INC_FILE_PATH . $tpv_config_file); //NECESSITO TENIR A PUNT 4id i $lang
echo $clave256;
echo $url;
echo $trans;

require (ROOT . "../reservar/Gestor_form.php");
$gestorf = new Gestor_form();
echo $gestorf->generaFormTpvSHA256(substr(time(),6,6), 0.1, "Test TPV", "reserva_pk_tpv_ok_callback");