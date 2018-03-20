<?php
if (!defined('ROOT'))  define('ROOT', "../taules/");
require_once(ROOT . "gestor_reserves.php");

class Gestor_pagaments extends gestor_reserves {
  
  
  /**
   * 
   * @param type $reserva_id
   * @return type
   * 
   * retorna un integer que és l'IMPORT que ja s'ha pagat
   */
  public function get_total_import_pagaments($reserva_id = 0) {
    $query = "SELECT  SUM(pagaments_grups_import) AS total
      FROM pagaments_grups 
      where pagaments_grups_reserva_id =  $reserva_id AND pagaments_grups_resposta_tpv < 100  AND pagaments_grups_resposta_tpv IS NOT NULL"
        . " GROUP BY pagaments_grups_reserva_id";
    
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if ($this->total_rows = mysqli_num_rows($this->qry_result))   {
      $this->last_row = mysqli_fetch_assoc($this->qry_result);
    }
    else{
      $row = $this->load_reserva($reserva_id, 'reserves');
      if ($row['estat']==3 || $row['estat']==7 ) $this->last_row['total'] = $row['preu_reserva'];
    }
    if (!isset($this->last_row['total'])) $this->last_row['total'] = 0;
    return  number_format ( $this->last_row['total'],2 );     
  }

  /**
   * 
   * @param type $reserva_id
   * @return type
   * 
   * retorna un integer que és el NUM de coberts que ja s'han abonat
   */
  public function get_total_coberts_pagats($reserva_id = 0) {
    $query = "SELECT  pagaments_grups_import, pagaments_grups_preu_unit
   FROM pagaments_grups 
   where pagaments_grups_reserva_id =  $reserva_id AND pagaments_grups_resposta_tpv < 100  AND pagaments_grups_resposta_tpv IS NOT NULL";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //if ($this->total_rows = mysqli_num_rows($this->qry_result))      $this->last_row = mysqli_fetch_assoc($this->qry_result);
    $coberts= 0;
    
    if (!$this->total_rows = mysqli_num_rows($this->qry_result))   {
      $reserva = $this->load_reserva($reserva_id, 'reserves');
      if ($reserva['estat']==3 || $reserva['estat']==7 ){
        $coberts = $reserva['preu_reserva'] / preu_persona_grups;
      }
    }
   
    while( $row = mysqli_fetch_assoc($this->qry_result)){
        $coberts += ($row['pagaments_grups_import'] / $row['pagaments_grups_preu_unit']);
    }
    return $coberts;     
  }

  /**
   * 
   * @param type $reserva_id
   * @return type
   * 
   * retorna un integer que és el NUM de coberts que ja s'han abonat
   */
  public function get_import_pendent($reserva_id = 0) {
   $r = $this->load_reserva($reserva_id, 'reserves');
   $pagat = $this->get_total_import_pagaments($reserva_id);
   
   
    return number_format($r['preu_reserva'] - $pagat,2 );     
  }

  /**
   * 
   * @param type $reserva_id
   * @return type
   * 
   * retorna array de rows
   */
  public function get_llistat_pagaments($reserva_id = 0) {
    $rows=Array();
    $query = "SELECT  pagaments_grups_nom_pagador, pagaments_grups_import, pagaments_grups_preu_unit
   FROM pagaments_grups 
   where pagaments_grups_reserva_id =  $reserva_id AND pagaments_grups_resposta_tpv < 100  AND pagaments_grups_resposta_tpv IS NOT NULL";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //if ($this->total_rows = mysqli_num_rows($this->qry_result))      $this->last_row = mysqli_fetch_assoc($this->qry_result);
    while( $row = mysqli_fetch_assoc($this->qry_result)){
        $row['coberts'] = ($row['pagaments_grups_import'] / $row['pagaments_grups_preu_unit']);
        $row['pagaments_grups_import'] = number_format ( $row['pagaments_grups_import'],2 );   
        $rows[] = $row;
    }
    return $rows;     
  }
  
  /**
   * 
   * @param type $reserva_id
   * returna 
   * 0 = no s'ha pagat
   * 8 = pagament parcial
   * 100 = pagament total
   */
  public function get_estat_multipago($reserva_id){
      $this->neteja_impagats();
    
      $estat = 0;
      $r = $this->load_reserva($reserva_id, 'reserves');
      $import = $r['preu_reserva'];
      $pagades = $this->get_total_import_pagaments($reserva_id);
      if ($pagades >= $import) $estat=100;
      if ($pagades > 0 && $pagades < $import) $estat=8;
      if (($r['estat']==3 || $r['estat']==7) &&  $pagades==0) $estat = 100; // RESERVES ANTIGUES
      
      //echo $pagades;die();
      return $estat;
  }
  
   public function get_estat_pagament($order){
    $query = "SELECT * FROM `pagaments_grups` WHERE `pagaments_grups_redsys_id` = " . $order;
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!$this->total_rows = mysqli_num_rows($this->qry_result))  return NULL;
    $row = mysqli_fetch_assoc($this->qry_result);  
    if ($row['pagaments_grups_resposta_tpv']==0) $row['pagaments_grups_resposta_tpv']="99";
    return $row['pagaments_grups_resposta_tpv'];
  }
  
  
/*
   public function get_pagament_parcial($reserva_id = 0) {
        
   } 
  */
  
  public function get_multipago_activat($reserva_id) {
    return true;
  }

  public function afegir_pagament($order, $idr, $import, $preu_unit, $nom) {
    $nom  = htmlentities($nom);
    
    $query="INSERT INTO `pagaments_grups` (  `pagaments_grups_reserva_id`, `pagaments_grups_redsys_id`, `pagaments_grups_import`, `pagaments_grups_preu_unit`, `pagaments_grups_resposta_tpv`, `pagaments_grups_nom_pagador`, `pagaments_grups_aux`, `pagaments_grups_aux2`) "
        . "VALUES ( $idr, $order, $import, $preu_unit, NULL, '$nom', NULL, NULL);";
    return   $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  }
  
  public function valida_pagament($order,  $idr, $import, $resposta){
    
    $query = "SELECT * FROM `pagaments_grups` WHERE `pagaments_grups_redsys_id` = " . $order;
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
     
    if (!$this->total_rows = mysqli_num_rows($this->qry_result))  {
      $reserva = $this->load_reserva($idr, "reserves");
      $this->afegir_pagament($order, $idr, $import, preu_persona_grups, 'sense_nom');
    }

    $query="UPDATE `pagaments_grups` SET `pagaments_grups_resposta_tpv` = '$resposta',  pagaments_grups_import = '$import' WHERE `pagaments_grups`.`pagaments_grups_redsys_id` = $order;";
    echo "<br><br>".$query;
    return   $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
  }
  
  public function neteja_impagats($interval= "60 MINUTE"){
    $query = "DELETE FROM `pagaments_grups` WHERE pagaments_grups_resposta_tpv IS NULL AND pagaments_grups_timestamp < (NOW() - INTERVAL $interval )";
    return   $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  }
  

  /*   * ************************************************ */

  public function calcula_preu_grups($comensals) {
    $preu = $comensals * $this->configVars("preu_persona_grups");
    return $preu;
  }
}

/* * ******************************************************************************************* */
/* * ******************************************************************************************* */
/* * ******************************************************************************************* */
/* * ******************************************************************************************* */
/* * ******************************************************************************************* */
/* * ******************************************************************************************* */
/* * ********* AJAX************* */
/* * ********* AJAX************* */
/* * ********* AJAX************* */
/* * ********* AJAX************* */
if (isset($_REQUEST['a']))
  $accio = $_REQUEST['a'];
$_REQUEST['a'] = null;

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

  $gestor = new Gestor_pagaments(1);

  if (method_exists($gestor, $accio)) {

    $logables = array('cancelReserva', 'insertUpdateClient', 'salvaUpdate', 'submit', 'update_client', 'esborra_client', 'inserta_reserva', 'update_reserva', 'esborra_reserva', 'enviaSMS', 'permuta', 'permuta_reserva', '', '', '', '', '', '', '', '', '', '', '');
    $log = in_array($accio, $logables);
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    $sessuser = $_SESSION['uSer'];

    if (isset($sessuser))
      $user = $sessuser->id;

    if ($log) {
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
      $gestor->xgreg_log("Petició Gestor FORM: " . $accio . " user:$user ($ip) (b = " . $_REQUEST['b'] . ", c = " . $_REQUEST['c'] . ", d = " . $_REQUEST['d'] . " ----p = " . $_REQUEST['p'] . ", q = " . $_REQUEST['q'] . ", r = " . $_REQUEST['r'] . ", c = " . $_REQUEST['c'] . ", d = " . $_REQUEST['d'] . ", e = " . $_REQUEST['e'] . ") > " . $req . EOL, 1);
    }

    $respostes = array('respostaTPV', 'respostaTPV_SHA256');
    if (!$gestor->valida_sessio(1) && !in_array($accio, $respostes)) {
      echo "err100";
      die();
    }
    $gestor->out(call_user_func(array($gestor, $accio), $_REQUEST['b'], $_REQUEST['c'], $_REQUEST['d'], $_REQUEST['e'], $_REQUEST['f'], $_REQUEST['g']));
  }
  else {
    echo "$accio action not kown ";
  }
}
