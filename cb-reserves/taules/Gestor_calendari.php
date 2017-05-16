<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if (!defined('ROOT'))
  define('ROOT', "");

if (isset($_GET['f']))   define("LLISTA_DIES_NEGRA",  $_GET['f']);
if (isset($_GET['fblanc']))   define("LLISTA_DIES_BLANCA",  $_GET['fblanc']);


require_once(ROOT . "gestor_reserves.php");
if (!defined('LLISTA_DIES_NEGRA'))
  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA'))
  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "llista_nits_negra.txt");  
if (!defined('LLISTA_DIES_BLANCA'))
  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");

class Gestor_calendari extends Gestor {

  public function __construct($db_connection_file = DB_CONNECTION_FILE, $usuari_minim = 16) {
    parent::__construct($db_connection_file, $usuari_minim);
  }

  public function click($data){
    $data =  str_replace('/', '-', $data);
    $data = Gestor::cambiaf_a_mysql($data);
    $data = Gestor::cambiaf_a_normal($data);
    
    $llista = $this->get_llista_dies();
    
    if (isset($llista[$data])){
      $estat = $llista[$data]=='tancat'?'obert':null;
    }
    else{
      $estat="tancat";
    }
    
    $llista[$data] = $estat;
    $llista2 = $this->guarda_fitxer_dies(LLISTA_DIES_BLANCA, $llista, "obert");
    $llista3 = $this->guarda_fitxer_dies(LLISTA_DIES_NEGRA, $llista, "tancat");
  }
  
  public function get_llista_dies() {
    $llista = array();

    $llista = $this->llegir_fitxer_dies(LLISTA_DIES_NEGRA, $llista, "tancat");
    $llista = $this->llegir_fitxer_dies(LLISTA_DIES_BLANCA, $llista, "obert");
    
    return $llista;
  }

  private function llegir_fitxer_dies($file, $llista, $val) {
    $handle = fopen($file, "r");
    if ($handle) {
      while (($line = fgets($handle)) !== false) {
        $line = trim($line);
        
        $llista[$line] = $val;
      }
      fclose($handle);
      echo "<pre>";
      var_dump($llista);
    }
    else {
      die("FILE ERROR: " . LLISTA_DIES_BLANCA);
    }
    return $llista;
  }

  private function guarda_fitxer_dies($file, $llista, $val) {
    $filteredArray = array_filter($llista, array($this, 'filterArray' . $val));
    foreach ($filteredArray as $key => $value) {
      $mykey = Gestor::cambiaf_a_mysql($key);
      $arr[$mykey] = $val;
    }
    ksort($arr);
    $filteredArray = $arr;
    //ksort($filteredArray);
//print_r($filteredArray);
    $fp = fopen($file  , 'w');
    foreach ($filteredArray as $key => $value) {
 
      $key = str_replace("/", "-", $key);
    //$key = Gestor::cambiaf_a_mysql($key);
    $key = Gestor::cambiaf_a_normal($key);
      
      
      if ($key!=null) $text .= $key . "\n";
    }
    echo " $text $val";
    fwrite($fp, $text) or die("Could not write file! $file");
    fclose($fp);

    return $text;
  }

  private function filterArrayobert($value) {
    return ($value == "obert");
  }

  private function filterArraytancat($value) {
    return ($value == "tancat");
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

  $gestor = new Gestor_calendari(64);

  if (method_exists($gestor, $accio)) {

    $logables = array('cancelReserva', 'insertUpdateClient', 'salvaUpdate', 'submit', 'update_client', 'esborra_client', 'inserta_reserva', 'update_reserva', 'esborra_reserva', 'enviaSMS', 'permuta', 'permuta_reserva', '', '', '', '', '', '', '', '', '', '', '');
    $log = in_array($accio, $logables);
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];


    $gestor->out(call_user_func(array($gestor, $accio), $_REQUEST['b'], $_REQUEST['c'], $_REQUEST['d'], $_REQUEST['e'], $_REQUEST['f'], $_REQUEST['g']));
  }
}
?>
