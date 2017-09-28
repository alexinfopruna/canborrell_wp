<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ROOT'))
  define('ROOT', "../../taules/");

require_once(ROOT . "gestor_reserves.php");

if (!defined('LLISTA_DIES_NEGRA'))
  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA'))
  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_DIES_BLANCA'))
  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");

class Gestor_config extends Gestor {

  public function __construct($db_connection_file = DB_CONNECTION_FILE, $usuari_minim = 16) {
    parent::__construct($db_connection_file, $usuari_minim);
  }

  public function set_value($var, $val){
    echo "set_value($var, $val)";
     echo " <br/>";
      echo " <br/>";
    $sql="UPDATE config SET config_val='$val' WHERE config_var='$var'";
    //$this->qry_result=TRUE;
    $this->qry_result = mysqli_query($this->connexioDB, $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    
    $sql2="SELECT config_val FROM config   WHERE config_var='$var'";
    $result = mysqli_query($this->connexioDB, $sql2) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_array($result);
    $val2 = $row['config_val'];
    
    echo $sql;
    echo "  ..........  (".$this->qry_result.") .... ";
    echo " <br/>";
    echo " <br/>";
    echo "RESULTAT: $var ---> $val2";
    echo " <br/>";
    echo " <br/>";
    return $sql;

    return true;
  }

}

/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
// AJAX

if (isset($accio) && !empty($accio)) {
  if (!isset($_REQUEST['b']))
    $_REQUEST['b'] = null;
  if (!isset($_REQUEST['c']))
    $_REQUEST['c'] = null;
  if (!isset($_REQUEST['d']))
    $_REQUEST['d'] = null;
  if (!isset($_REQUEST['e']))
    $_REQUEST['e'] = null;
  if (!isset($_REQUEST['f']))
    $_REQUEST['f'] = null;
  if (!isset($_REQUEST['g']))
    $_REQUEST['g'] = null;
  if (!isset($_REQUEST['p']))
    $_REQUEST['p'] = null;
  if (!isset($_REQUEST['q']))
    $_REQUEST['q'] = null;
  if (!isset($_REQUEST['r']))
    $_REQUEST['r'] = null;

  $gestor = new Gestor_config(64);

  if (method_exists($gestor, $accio)) {

    $logables = array('cancelReserva', 'insertUpdateClient', 'salvaUpdate', 'submit', 'update_client', 'esborra_client', 'inserta_reserva', 'update_reserva', 'esborra_reserva', 'enviaSMS', 'permuta', 'permuta_reserva', '', '', '', '', '', '', '', '', '', '', '');
    $log = in_array($accio, $logables);
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];


    $gestor->out(call_user_func(array($gestor, $accio), $_REQUEST['b'], $_REQUEST['c'], $_REQUEST['d'], $_REQUEST['e'], $_REQUEST['f'], $_REQUEST['g']));
  }
}
?>
