<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('ROOT'))
  define('ROOT', "../taules/");

require_once(ROOT . "gestor_reserves.php");

if (!defined('LLISTA_DIES_NEGRA'))
  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))
  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA'))
  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
if (!defined('LLISTA_DIES_BLANCA'))
  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
if (!defined('TPV_CONFIG_FILE'))
  define("TPV_CONFIG_FILE", "TPV256_test.php");

set_error_handler("var_dump");
ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
$usr = new Usuari(2, "alex", 255);
$_SESSION['uSer'] = $usr;


require_once(ROOT . "RestrictionController.php");

/* * ******************************************************************************************************* */
/* * ************************************************* */
/* * ************************************************* */
/* * ************************************************* */

class Restriccions extends gestor_reserves {

  public function __construct() {
    $debug = FALSE;
    if (isset($_SERVER['HTTP_REFERER']))
      $debug = (strstr($_SERVER['HTTP_REFERER'], '4200'));
    /*
      if ( !$debug && $_SESSION['permisos'] < 16) {
      header("Content-Type: application/json");
      $err=array('error',0);
      echo "ERROR";
      echo json_encode($err);
      die();
      }
     */
    $usuari_minim = 0;
    parent::__construct(DB_CONNECTION_FILE, $usuari_minim);
  }

  public function pliiin($txt, $reset = FALSE) {
    $f = fopen("pliiin.txt", $reset ? "w" : "a");
    fwrite($f, " ---> " . $txt);
    fclose($f);
  }

  protected function dies2dec($binArray) {
    $strBin = implode($binArray);
    return $num = bindec($strBin);
  }
  protected function mesos2dec($binArray) {
    $strBin = implode($binArray);
    return $num = bindec($strBin);
  }

  protected function dies2bin($decNum) {
    $strbin = substr("00000000" . decbin($decNum), -8);
    $arrayBib = str_split($strbin);
    $integerIDs = array_map('intval', $arrayBib);
    return $integerIDs;
  }
  protected function mesos2bin($decNum) {
    $strbin = substr("000000000000" . decbin($decNum), -12);
    $arrayBib = str_split($strbin);
    $integerIDs = array_map('intval', $arrayBib);
    return $integerIDs;
  }

  protected function hores2bin($decNum) {
    $strbin = substr("00000000000000000000000000000000" . decbin($decNum), -26);
    $arrayBib = str_split($strbin);
    $integerIDs = array_map('intval', $arrayBib);
    return $integerIDs;
  }

  protected function resposta_json($json, $ret2 = "ok") {
    // echo "EEEEEEEEEEEEEEEEEEEEEEEE";die();
    if (!is_array($json))
      $json = array("resposta" => $json);

    $json = array_map(array($this, 'booleanize'), $json);
    $ret = json_encode($json);
    $ret = "{\"data\":$ret,\"extra\":\"$ret2\"}";
    return $ret;
  }

  protected function booleanize($n) {
    if (isset($n['restriccions_active'])) {
      $n['restriccions_active'] = (bool) $n['restriccions_active'] ? 1 : 0;
      $n['restriccions_dies'] = $this->dies2bin($n['restriccions_dies']);
      $n['restriccions_mesos'] = $this->mesos2bin($n['restriccions_mesos']);
      $n['restriccions_hores'] = $this->hores2bin($n['restriccions_hores']);
    }
    return $n;
  }

  public function parseFiltre($filtre) {
    if (!isset($filtre->restriccions_data)) {
      $filtre->restriccions_data = '2011-01-01';
      $filtre->restriccions_datafi = '3011-01-01';
    }
    if (!isset($filtre->restriccions_datafi) || is_null($filtre->restriccions_datafi) || $filtre->restriccions_datafi < $filtre->restriccions_data)
      $filtre->restriccions_datafi = $filtre->restriccions_data;

    $filtre->restriccions_data = $this->cambiaf_a_mysql(substr($filtre->restriccions_data, 0, 10));
    $filtre->restriccions_datafi = $this->cambiaf_a_mysql(substr($filtre->restriccions_datafi, 0, 10));

    $filtre->restriccions_data = ">='{$filtre->restriccions_data}'";
    $filtre->restriccions_datafi = "<='{$filtre->restriccions_datafi}'";

    if (!isset($filtre->restriccions_adults) || $filtre->restriccions_adults == "Tot")
      $filtre->restriccions_adults = '>=0';
    $filtre->restriccions_adults = is_numeric($filtre->restriccions_adults) ? '=' . $filtre->restriccions_adults : $filtre->restriccions_adults;

    if (!isset($filtre->restriccions_nens) || $filtre->restriccions_nens == "Tot")
      $filtre->restriccions_nens = '>=0';
    $filtre->restriccions_nens = is_numeric($filtre->restriccions_nens) ? '=' . $filtre->restriccions_nens : $filtre->restriccions_nens;

    if (!isset($filtre->restriccions_cotxets) || $filtre->restriccions_cotxets == "Tot")
      $filtre->restriccions_cotxets = '>=0';
    $filtre->restriccions_cotxets = is_numeric($filtre->restriccions_cotxets) ? '=' . $filtre->restriccions_cotxets : $filtre->restriccions_cotxets;

    if (!isset($filtre->restriccions_suma) || $filtre->restriccions_suma == "Tot")
      $filtre->restriccions_suma = '>=0';
    $filtre->restriccions_suma = is_numeric($filtre->restriccions_suma) ? '=' . $filtre->restriccions_suma : $filtre->restriccions_suma;


    return $filtre;
  }

  /*   * ************************************************************************************************************ */
  /*   * ************************************************************************************************************ */
  /*   * ************************************************************************************************************ */

  public function getRestriccions($id = null, $data = ">=2000-01-01", $datafi = "<=3011-01-01", $adults = null, $nens = null, $cotxets = null, $suma = null) {
 
    
    $where = " where TRUE ";
    $rcotxets = ", `restriccions_cotxets` ";
    $rcotxets = " ";


    // $were_data = "";

    $where .= (empty($id)) ? "" : ' AND restriccions_id' . $id;
    $where .= (empty($adults)) ? "" : ' AND restriccions_adults' . $adults;
    $where .= (empty($nens)) ? "" : ' AND restriccions_nens' . $nens;
    $where .= (empty($cotxets)) ? "" : ' AND restriccions_cotxets' . $cotxets;
    $where .= (empty($suma)) ? "" : ' AND restriccions_nens + restriccions_adults ' . $suma;
    //$where .= (empty($suma)) ? "" : ' AND restriccions_mesos ' . $suma;

    $were_data = " AND (restriccions_data $data AND restriccions_datafi $datafi)  ";

    $where .= $were_data;

    $group = "";
    //$order =" ORDER BY  restriccions_active DESC, restriccions_data DESC, restriccions_adults, restriccions_nens  DESC ";
    //   $order =" ORDER BY   restriccions_id DESC";
    $order = " order by  restriccions_cotxets , restriccions_adults , restriccions_nens DESC ";

    $query = "SELECT * FROM
(
  SELECT `restriccions_active`,`restriccions_id`,`restriccions_description`,`restriccions_suma`,`restriccions_adults`,`restriccions_nens`, restriccions_cotxets,`restriccions_data`, `restriccions_datafi`, `restriccions_dies`,`restriccions_mesos`,`restriccions_hora`, `restriccions_hores` FROM restriccions where TRUE $were_data
  UNION 
  SELECT `restriccions_active`,`restriccions_id`,`restriccions_description`,`restriccions_suma`,`restriccions_adults`,`restriccions_nens`, restriccions_cotxets,`restriccions_data`, `restriccions_datafi`, `restriccions_dies`,`restriccions_mesos`,`restriccions_hora`, `restriccions_hores`   FROM restriccions where `restriccions_data`='2011-01-01'
  
) R
     $where    
       
       
      $group
        
$order
        ";
    $plin = "{'data':\"$query\"}";
    //  $this->pliiin($plin);
//echo "{'data':$query}";die();
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//echo "{'data':'aaa'}";
    //$json = mysqli_fetch_all($Result1, MYSQLI_ASSOC);
    $json = [];
    while ($row = $Result1->fetch_assoc()) {
//  $row["restriccions_hores"]=array(0,0,0,0,0,0,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,0,1,1,1);
      $json[] = $row;
    }


    return $this->resposta_json($json, $where);
  }

  public function getRestriccio($id) {
    return $this->getRestriccions($id);
  }

  protected function desglose_coberts($val, $MAX = 20) {
    $tot = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22);

    if ($val == "Parell")
      return array(0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20);
    if ($val == "Senar")
      return array(1, 3, 5, 7, 9, 11, 13, 15, 17, 19);
    if ($val == "Tot")
      return array_slice(array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20), 0, $MAX);

    $op = FALSE;
    if (!is_numeric(substr($val, 0, 1))) {
      $op = substr($val, 0, 1);
      $k = intval(substr($val, 1));
    }

    if (!$op)
      return array($val);
    //return array($k, $MAX);
    if ($op == ">")
      return array_slice($tot, $k, $MAX - $k);
    if ($op == "<")
      return array_slice($tot, 0, $k);

    return FALSE;
  }

  public function desglose($restriccio) {

    $restriccio->restriccions_adults = ">1";
    $restriccio->restriccions_nens = ">7";
    $restriccio->restriccions_cotxets = "1";

    $adults = $this->desglose_coberts($restriccio->restriccions_adults, 21);
    $nens = $this->desglose_coberts($restriccio->restriccions_nens, 9);
    //var_dump($restriccio->restriccions_adults);die();
    $desglose = $adults;
    $desglose = array_fill_keys($desglose, $nens);


    $rest = $restriccio;

//var_dump($desglose);die();
    foreach ($desglose as $k => $a) {
      foreach ($a as $k2 => $n) {

        $restriccio->restriccions_adults = $k;
        $restriccio->restriccions_nens = $n;
        echo " $k ----> $n <br>";
          $this->insertRestriccio($rest);
      }
    }
  }

  public function insertRestriccio($restriccio) {
    if ($restriccio->restriccions_datafi < $restriccio->restriccions_data)
      $restriccio->restriccions_datafi = $restriccio->restriccions_data;

    if ($restriccio->restriccions_dies == "")
      $restriccio->restriccions_dies = array();
    $restriccio->restriccions_dies = $this->dies2dec($restriccio->restriccions_dies);

    //if ($restriccio->restriccions_hora == "") $restriccio->restriccions_hora=array();
    if ($restriccio->restriccions_adults == "Parell")
      $restriccio->restriccions_nens = "Tot";
    if ($restriccio->restriccions_adults == "Senar")
      $restriccio->restriccions_nens = "Tot";


    // APAREIX UN INTRO SORPRESA... EL TREIEM
    $restriccio->restriccions_suma = is_numeric($restriccio->restriccions_suma) ? intval($restriccio->restriccions_suma) : $s;
    $restriccio->restriccions_nens = is_numeric($restriccio->restriccions_nens) ? intval($restriccio->restriccions_nens) : $s;
    $restriccio->restriccions_adults = is_numeric($restriccio->restriccions_adults) ? intval($restriccio->restriccions_adults) : $s;
    $restriccio->restriccions_cotxets = is_numeric($restriccio->restriccions_cotxets) ? intval($restriccio->restriccions_cotxets) : $s;



    $query = "REPLACE INTO restriccions 
      (restriccions_active, restriccions_data, restriccions_datafi, restriccions_suma, restriccions_dies, restriccions_adults, restriccions_nens, restriccions_cotxets, restriccions_hora, restriccions_description)

      VALUES ('{$restriccio->restriccions_active}',
             '{$restriccio->restriccions_data}', 
             '{$restriccio->restriccions_datafi}',
             '{$restriccio->restriccions_suma}',
             '{$restriccio->restriccions_dies}',
             '{$restriccio->restriccions_adults}', 
             '{$restriccio->restriccions_nens}', 
             '{$restriccio->restriccions_cotxets}',
             '{$restriccio->restriccions_hora}',
             '{$restriccio->restriccions_description}')";

//echo $query;
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $this->getRestriccions();
  }

  public function updateRestriccio($restriccio) {
    $restriccio->restriccions_dies = $this->dies2dec($restriccio->restriccions_dies);
    $restriccio->restriccions_mesos = $this->mesos2dec($restriccio->restriccions_mesos);
    $restriccio->restriccions_hores = $this->dies2dec($restriccio->restriccions_hores);
    if ($restriccio->restriccions_datafi < $restriccio->restriccions_data)
      $restriccio->restriccions_datafi = $restriccio->restriccions_data;
    if ($restriccio->restriccions_adults == "Parell")
      $restriccio->restriccions_nens = "Tot";
    if ($restriccio->restriccions_adults == "Senar")
      $restriccio->restriccions_nens = "Tot";

    $plin = $restriccio->restriccions_hores;
    $this->pliiin($plin);

    // APAREIX UN INTRO SORPRESA... EL TREIEM
    $restriccio->restriccions_suma = is_numeric($restriccio->restriccions_suma) ? intval($restriccio->restriccions_suma) : $s;
    $restriccio->restriccions_nens = is_numeric($restriccio->restriccions_nens) ? intval($restriccio->restriccions_nens) : $s;
    $restriccio->restriccions_adults = is_numeric($restriccio->restriccions_adults) ? intval($restriccio->restriccions_adults) : $s;
    $restriccio->restriccions_cotxets = is_numeric($restriccio->restriccions_cotxets) ? intval($restriccio->restriccions_cotxets) : $s;

    $query = "UPDATE  restriccions 
 


      SET restriccions_active= '$restriccio->restriccions_active',
          restriccions_data =   '$restriccio->restriccions_data', 
          restriccions_datafi = '$restriccio->restriccions_datafi',
          restriccions_suma = '$restriccio->restriccions_suma',
          restriccions_dies = '$restriccio->restriccions_dies',
          restriccions_mesos = '$restriccio->restriccions_mesos',
          restriccions_adults = '$restriccio->restriccions_adults', 
          restriccions_nens = '$restriccio->restriccions_nens', 
          restriccions_cotxets = '$restriccio->restriccions_cotxets',
          restriccions_hora = '$restriccio->restriccions_hora',
          restriccions_hores = '$restriccio->restriccions_hores',
          restriccions_description = '$restriccio->restriccions_description'
            
          WHERE restriccions_id = '$restriccio->restriccions_id'
       ";


    //echo $query;die();
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    // $ar= mysqli_affected_rows($this->connexioDB) ;
    //return $plin;
    $plin = "{'data':\"sssss$query\"}";
    $this->pliiin($plin);

    return $this->getRestriccions();
  }

  public function saveHores($ides, $hores) {
    $dechores = $this->dies2dec($hores);
    $arides = implode(", ", $ides);

    $query = "UPDATE  restriccions 
 
      SET restriccions_hores= $dechores
        WHERE restriccions_id IN ($arides) ";


    //  echo $query;die();
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $this->getRestriccions();
  }

  public function deleteRestriccio($id) {
    $query = "DELETE FROM restriccions WHERE
 restriccions_id=$id";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//return $this->resposta_json("ESBORRAT id=$id");

    return $this->getRestriccions();
  }

  public function horesDisponibles($restriccio) {
    $data = $restriccio->data;
    $cotxets = $restriccio->cotxets;
    $accesible = 0;
    $nens = $restriccio->nens;
    $adults = $restriccio->adults;
    $coberts = $adults + $nens;

    $mydata = $this->cambiaf_a_mysql(substr($data, 0, 10));
    $this->taulesDisponibles->tableHores = "estat_hores";   //ANULAT GESTOR HORES FORM. Tot es gestiona igual, des d'estat hores

    $this->taulesDisponibles->data = $mydata;
    $this->taulesDisponibles->persones = $coberts;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->accesible = $accesible;
    $this->taulesDisponibles->tableHores = "estat_hores";  //ANULAT GESTOR HORES FORM. Toto es gestiona igual, des de estat hores

    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_nits_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;

    $rc = new RestrictionController();
    $rules = $rc->getHoresRules($mydata, $adults, $nens, $cotxets);
    $this->taulesDisponibles->rang_hores_nens = array_values($rules['hores']);
    /*     * ******************************************************** */
    $this->taulesDisponibles->torn = 1;
    $dinar = $this->taulesDisponibles->recupera_hores(false, true);

    $this->taulesDisponibles->torn = 2;
    $dinarT2 = $this->taulesDisponibles->recupera_hores(false, true);

    if (!$dinar)
      $dinar = array();
    if (!$dinarT2)
      $dinarT2 = array();
    $rules['horesReals'] = array_merge($dinar, $dinarT2);
    /*     * ********************************************************* */
    $this->taulesDisponibles->rang_hores_nens = array();
    //$this->taulesDisponibles->data = "2011-01-01";
    $this->taulesDisponibles->torn = 1;
    $dinar = $this->taulesDisponibles->recupera_hores(false, true);

    $this->taulesDisponibles->torn = 2;
    $dinarT2 = $this->taulesDisponibles->recupera_hores(false, true);

    if (!$dinar)
      $dinar = array();
    if (!$dinarT2)
      $dinarT2 = array();
    $rules['hores'] = array_merge($dinar, $dinarT2);

    return json_encode($rules);
    //////////////////////////////////					
  }

  protected function rang_hores_nens($data, $adults, $nens = 0, $cotxets = 0) {
    if (!RestrictionController::restrictionsActive($data, $adults )) return;
    //if (!$adults || !defined("CONTROL_HORES_NENS") || !CONTROL_HORES_NENS)
    //controla si es cap de setamana
    $finde = FALSE;
    $ds = date('N', strtotime($data));
    //if ($ds==6 ) $finde=TRUE;
    //if ($ds==7 ) $finde=TRUE;
    //if (!$finde) return FALSE;
    if ($nens == "undefined")
      $nens = 0;
    //echo " .. $nens ..";die();

    /*     * *************************** */
    require("hores_nens.php");
    /*     * **************************** */

    $limit = FALSE;
    if (isset($limits[$adults][$nens]))
      $limit = $limits[$adults][$nens];

    $time = time();
    $cache = FALSE;
    $limitNens = FALSE;
    if ($limit)
      $limitNens = $limit;

    /*     * ******************************************************* */
    // COTXETS
    /*     * ******************************************************* */
    $limitcotxets = FALSE;
    if (isset($limit_cotxets[$cotxets])) {
      $limitcotxets = $limit_cotxets[$cotxets][1];
      if ($limitcotxets && $limitNens)
        $limitNens = array_intersect($limitcotxets, $limitNens);
      else
        $limitNens = $limitcotxets;
    }
    return $limitNens;
  }
  
  
  public function saveMesosAll($mesos){
    $decmesos = $this->mesos2dec($mesos);
   $query = "UPDATE  restriccions 
 
      SET restriccions_mesos= $decmesos";
   $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //$nr = mysqli_num_rows($Result1); 
    echo $query;
  }

  
  public function saveMesosSelect($ides, $mesos) {
      $decmesos = $this->mesos2dec($mesos);
    $arides = implode(", ", $ides);

    $query = "UPDATE  restriccions 
 
      SET restriccions_mesos= $decmesos
        WHERE restriccions_id IN ($arides) ";


     // echo $query;die();
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //return $this->getRestriccions();
     echo $Result1." --- ".$query;
  }  
  public function onUpdateDaysAll($mesos){
    $decmesos = $this->dies2dec($mesos);
   $query = "UPDATE  restriccions 
 
      SET restriccions_dies= $decmesos";
   $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //$nr = mysqli_num_rows($Result1); 
    echo $query;
  }

  
  public function onUpdateDaysSelect($ides, $mesos) {
      $decmesos = $this->dies2dec($mesos);
    $arides = implode(", ", $ides);

    $query = "UPDATE  restriccions 
 
      SET restriccions_dies= $decmesos
        WHERE restriccions_id IN ($arides) ";


     // echo $query;die();
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $this->getRestriccions();
  }  
  
}

/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
header("Content-Type: application/json");

$r = new Restriccions();
$accio = "getrestriccions";

if (isset($_REQUEST['a']))
  $accio = $_REQUEST['a'];
if (isset($_REQUEST['json']))
  $stparams = $_REQUEST['json'];
else
  $stparams = file_get_contents('php://input');

$params = json_decode($stparams);

if ($params) {
  $accio = $params->accio;
  $id = isset($params->data->restriccions_id) ? $params->data->restriccions_id : 0;
  $restriccio = $params->data;
}

/*
  echo " zzzzzzzzz ";
  print_r($_REQUEST);
  echo " ********* ";
  $stparams = file_get_contents('php://input');
  print_r($stparams);
  echo " ********* ";
  echo $accio; die();
 */

switch ($accio) {
  case 'deleterestriccio':
    echo $r->deleteRestriccio($id);
    break;

  case 'desglose':
    echo "DESGLOSE";
    //http://cbwp-localhost/cb-reserves/taules/Restriccions.php?json={%22accio%22:%22desglose%22,%22data%22:{%22data%22:%222017-10-01%22,%22adults%22:5,%22nens%22:3,%22cotxets%22:0}}
    $restriccio->restriccions_data = "2011-01-01";
    $restriccio->restriccions_datafi = "2011-01-01";
    $restriccio->restriccions_dies = array(0, 0, 0, 0, 0, 1, 1);
    $restriccio->restriccions_mesos = array(1,1,1,1,1,0, 0, 0, 0, 0, 1, 1);
    $restriccio->restriccions_active = 1;
    $restriccio->restriccions_hora = "14:00";
    $restriccio->restriccions_description = "Desglose generated";
    $restriccio->restriccions_suma = "Tot";

    echo $r->desglose($restriccio);
    break;

  case 'updaterestriccio':
    $plin = print_r($restriccio->restriccions_dies, true);
    $r->pliiin($plin);
    echo $r->updateRestriccio($restriccio);
    break;

  case 'insertrestriccio':
    echo $r->insertRestriccio($restriccio);
    break;

  case 'horesdisponibles':
    echo $r->horesDisponibles($restriccio);
    break;

  case 'horesdisponibles2':
    echo $r->horesDisponibles2($restriccio);
    break;

  case 'savehores':
    $ides = $params->ides;
    $r->saveHores($ides, $restriccio);
    break;

  case 'saveMesosAll':
    $data = $params->data;
    $r->saveMesosAll($data);
    break;

  case 'saveMesosSelect':
    $data = $params->data;
    $ides = $params->ides;
    $r->saveMesosSelect($ides, $data);
    break;

  case 'onUpdateDaysAll':
    $data = $params->data;
    $r->onUpdateDaysAll($data);
    break;

  case 'onUpdateDaysSelect':
    $data = $params->data;
    $ides = $params->ides;
    $r->onUpdateDaysSelect($ides, $data);
    break;

  case 'getrestriccions':
  default:
    $filtre = new stdClass();
    if ($params)
      $filtre = $restriccio;

    $filtre = $r->parseFiltre($filtre);
   // echo basename($_SERVER['REQUEST_URI']);
    echo $r->getRestriccions(null, $filtre->restriccions_data, $filtre->restriccions_datafi, $filtre->restriccions_adults, $filtre->restriccions_nens, $filtre->restriccions_cotxets, $filtre->restriccions_suma  );
    break;
}


