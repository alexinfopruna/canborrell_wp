<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('ROOT'))
  define('ROOT', "../taules/");


require_once(ROOT . "gestor_reserves.php");

//if (!defined('LLISTA_DIES_NEGRA'))  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "bloq.txt");
if (!defined('LLISTA_DIES_NEGRA'))
  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
//if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra_online.txt");
if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))
  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA'))
  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
if (!defined('LLISTA_DIES_BLANCA'))
  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
if (!defined('TPV_CONFIG_FILE'))
  define("TPV_CONFIG_FILE", "TPV256_test.php");


$usr = new Usuari(2, "alex", 255);
$_SESSION['uSer'] = $usr;

//require_once(ROOT . "Restriccions.php");

/* * ******************************************************************************************************* */
/* * ************************************************* */
/* * ************************************************* */
/* * ************************************************* */

class RestriccionsTaules extends gestor_reserves {

  public function __construct() {
    $debug = FALSE;
    if (isset($_SERVER['HTTP_REFERER']))
      $debug = (strstr($_SERVER['HTTP_REFERER'], '4200'));
    $usuari_minim = 0;
    parent::__construct(DB_CONNECTION_FILE, $usuari_minim);
  }

  public function pliiin($txt, $reset = FALSE) {
   // $f = fopen("pliiin.txt", $reset ? "w" : "a");
   // fwrite($f, " ---> " . $txt);
   // fclose($f);
  }

  protected function dies2dec($binArray) {
    //$binArray=array_map(fn ($v) => $v===false ? 0 : $v,$binArray);

    $strBin = implode($binArray);
    return $num = bindec($strBin);
  }

  protected function dies2bin($decNum) {
    $strbin = substr("00000000" . decbin($decNum), -8);
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
      $n['restriccions_hores'] = $this->hores2bin($n['restriccions_hores']);
    }
    return $n;
  }

  public function parseFiltre($filtre) {
    if (!isset($filtre->restriccions_taula_id)) {
      $filtre->restriccions_taula_id = 0;
    }
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

    return $filtre;
  }

  /*   * ************************************************************************************************************ */
  /*   * ************************************************************************************************************ */
  /*   * ************************************************************************************************************ */

  public function getRestriccions($id = null, $taula_id = 0, $data = ">=2000-01-01", $datafi = "<=3011-01-01") {
    $where = " where TRUE ";
    $rcotxets = ", `restriccions_cotxets` ";
    $rcotxets = " ";

    $where .= (empty($id)) ? "" : ' AND restriccions_id' . $id;
    $where .= (empty($taula_id)) ? "" : ' AND restriccions_$taula_id' . $nens;

    $were_data = " AND (restriccions_data $data AND restriccions_datafi $datafi)  ";

    $where .= $were_data;

    $group = "";
    $order = " order by  restriccions_taula_id DESC ";
    $order = " order by  restriccions_id DESC ";

    $query = "SELECT * FROM
(
  SELECT `restriccions_active`,`restriccions_id`,`restriccions_taula_id`,`restriccions_description`,`restriccions_data`, `restriccions_datafi`, `restriccions_dies`,`restriccions_hora`, `restriccions_hores` FROM RestriccioHoresTaula where TRUE $were_data
  UNION 
  SELECT `restriccions_active`,`restriccions_id`,`restriccions_taula_id`,`restriccions_description`,`restriccions_data`, `restriccions_datafi`, `restriccions_dies`,`restriccions_hora`, `restriccions_hores`   FROM RestriccioHoresTaula where `restriccions_data`='2011-01-01'
  
) R
     $where    
       
       
      $group
        
$order
        ";
    $plin = "{'data':\"$query\"}";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $json = [];
    while ($row = $Result1->fetch_assoc()) {
      //  $row['restriccions_description']=$query;
      //   $row['restriccions_data'] = Gestor::cambiaf_a_normal($row['restriccions_data']);
      //   $row['restriccions_datafi'] = Gestor::cambiaf_a_normal($row['restriccions_datafi']);
      $json[] = $row;
    }


    return $this->resposta_json($json, $where);
  }

  public function getRestriccio($id) {
    return $this->getRestriccions($id);
  }

  public function insertRestriccio($restriccio) {
    
    $restriccio->restriccions_hores = $this->dies2dec($restriccio->restriccions_hores);
   
    if ($restriccio->restriccions_datafi < $restriccio->restriccions_data)
      $restriccio->restriccions_datafi = $restriccio->restriccions_data;

    if ($restriccio->restriccions_dies == "")
      $restriccio->restriccions_dies = array(0, 0, 0, 0, 0, 1, 1);
    $restriccio->restriccions_dies = $this->dies2dec($restriccio->restriccions_dies);

    //if (!$restriccio->restriccions_active) $restriccio->restriccions_active=0;
    //else 
    $restriccio->restriccions_active=1;
    
    $query = "REPLACE INTO RestriccioHoresTaula 
      (restriccions_active, restriccions_taula_id, restriccions_data, restriccions_datafi, restriccions_hora, restriccions_hores,  restriccions_dies, restriccions_description)

      VALUES ('{$restriccio->restriccions_active}',
             '{$restriccio->restriccions_taula_id}',
             '{$restriccio->restriccions_data}', 
             '{$restriccio->restriccions_datafi}',
             '{$restriccio->restriccions_hora}',
             '{$restriccio->restriccions_hores}',
             '{$restriccio->restriccions_dies}',
             '{$restriccio->restriccions_description}')";


    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $this->getRestriccions();
  }

  public function updateRestriccio($restriccio) {
    $restriccio->restriccions_dies = $this->dies2dec($restriccio->restriccions_dies);
    $restriccio->restriccions_hores = $this->dies2dec($restriccio->restriccions_hores);
    if ($restriccio->restriccions_datafi < $restriccio->restriccions_data)
      $restriccio->restriccions_datafi = $restriccio->restriccions_data;

    $plin = $restriccio->restriccions_hores;
    $this->pliiin($plin);
    if ($restriccio->restriccions_active=="")$restriccio->restriccions_active=0;

if (!($restriccio->restriccions_active))$restriccio->restriccions_active=0;
    
    $query = "UPDATE  RestriccioHoresTaula 
 
      SET restriccions_active= '$restriccio->restriccions_active',
          restriccions_taula_id =   '$restriccio->restriccions_taula_id', 
          restriccions_data =   '$restriccio->restriccions_data', 
          restriccions_datafi = '$restriccio->restriccions_datafi',
          restriccions_dies = '$restriccio->restriccions_dies',
          restriccions_hora = '$restriccio->restriccions_hora',
          restriccions_hores = '$restriccio->restriccions_hores',
          restriccions_description = '$restriccio->restriccions_description'
            
          WHERE restriccions_id = '$restriccio->restriccions_id'
       ";




    //$query = str_replace("%%%", $query, $query);
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $plin = "{'data':\"zzzz$query\"}";
    $this->pliiin($plin);
//return $query;
    return $this->getRestriccions();
  }

  public function saveHores($ides, $hores) {
    $dechores = $this->dies2dec($hores);
    $arides = implode(", ", $ides);

    $query = "UPDATE  RestriccioHoresTaula 
 
      SET restriccions_hores= $dechores
        WHERE restriccions_id IN ($arides) ";


    //  echo $query;die();
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $this->getRestriccions();
  }

  public function deleteRestriccio($id) {
    $query = "DELETE FROM RestriccioHoresTaula WHERE
 restriccions_id=$id";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    return $this->getRestriccions();
  }

  public function horesDisponibles($restriccio) {
    return "horesDisponibles MAAAAL";
  }

  public function recuperataules() {
    //    $query = "SELECT distinct estat_taula_id, estat_taula_nom FROM `estat_taules` "; 
    $query = "SELECT distinct estat_taula_nom FROM `estat_taules` ";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    while ($row = $Result1->fetch_assoc()) {
      $json[] = $row['estat_taula_nom'];
    }
    
    $json=array();
    return $this->resposta_json($json);
  }
}

// CLASS

/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
/* * ********************************************* */
header("Content-Type: application/json");

$r = new RestriccionsTaules();
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

switch ($accio) {
  case 'deleterestriccio':
    echo $r->deleteRestriccio($id);
    break;
  /*
   * 
   * 
   * 
   *    * 
   * 
<div class="wpb_wrapper section-fullwidth"><img class=" vc_box_border_grey" src="/wp-content/uploads/2017/10/mapa-web2126.jpg" style="margin: auto;display: block;" usemap="#Map">

<map name="Map" id="Map">
    <area alt="London" title="" href="http://isardsat.co.uk" shape="rect" coords="922,83,979,154" href="http://www.google.com"/>
    <area alt="Barcelona" title="" href="http://isardsat.cat" shape="rect" coords="953,261,1003,326" href="http://www.google.com"/>
    <area alt="Polska" title="" href="http://isardsat.pl" shape="rect" coords="1158,18,1204,87" href="http://www.google.com"/>
  
</map>
</div>
   * 
    case 'desglose':
    $restriccio->restriccions_data = "2011-01-01";
    $restriccio->restriccions_datafi = "2031-01-01";
    $restriccio->restriccions_dies = array(0, 0, 0, 0, 0, 1, 1);
    $restriccio->restriccions_active = 1;
    $restriccio->restriccions_hora = "14:00";
    $restriccio->restriccions_description = "Desglose generated";
    $restriccio->restriccions_taula_id = 0;

    echo $r->desglose($restriccio);
    break;
   */
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

  case 'recuperataules':
    echo $r->recuperataules();
    break;

  case 'getrestriccions':
  default:


    $filtre = new stdClass();
    if ($params)
      $filtre = $restriccio;
    $filtre = $r->parseFiltre($filtre);
    echo $r->getRestriccions(null, $filtre->restriccions_taula_id, $filtre->restriccions_data, $filtre->restriccions_datafi);
    break;
}


