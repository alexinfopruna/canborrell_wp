<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!defined('ROOT'))
  define('ROOT', "../taules/");
require(ROOT . "gestor_reserves.php");
/*
  class Restriccio{
  var $restriccions_active;// = TRUE;
  var $restriccions_data;// = '2017-02-01';
  var $restriccions_datafi;// = '2017-02-02';
  var $restriccions_adults;// = 2;
  var $restriccions_nens;// = 1;
  var $restriccions_cotxets;// = 0;
  var $restriccions_hora;// = "11:00";
  var $restriccions_description;// = "none";

  function __construct($active, $data, $datafi, $adults, $nens, $cotxets, $hora, $desc=null){
  $this->restriccions_active = $active;
  $this->restriccions_data = $data;
  $this->restriccions_datafi = $datafi;
  $this->restriccions_adults = $adults;
  $this->restriccions_nens = $nens;
  $this->restriccions_cotxets = $cotxets;
  $this->restriccions_hora = $hora;
  $this->restriccions_description = $desc;
  }
  }
 */
/* * ************************************************* */
/* * ************************************************* */
/* * ************************************************* */

class Restriccions extends gestor_reserves {

  public function __construct($usuari_minim = 1) {
    parent::__construct(DB_CONNECTION_FILE, $usuari_minim);
  }

  private function pliiin($txt, $reset = TRUE) {
    $f = fopen("pliiin.txt", $reset ? "w" : "a");
    fwrite($f, " ---> " . $txt);
    fclose($f);
  }

  public function getRestriccions($id = null, $data = "2011-01-01", $adults = null, $nens = null, $cotxets = null) {

    $data = '2017-01-24';
    $datafi = '2017-01-24';
    $where = " where TRUE ";
    $rcotxets = ", `restriccions_cotxets` ";
    $rcotxets = " ";

    $were_data = " AND (restriccions_data>='$data' AND restriccions_data<='$datafi')  ";
    $were_data = "";

    $where .= (empty($id)) ? "" : ' AND restriccions_id=' . $id;
    $where .= (empty($adults)) ? "" : ' AND restriccions_adults=' . $adults;
    $where .= (empty($nens)) ? "" : ' AND restriccions_nens=' . $nens;
    $where .= (empty($cotxets)) ? "" : ' AND restriccions_cotxets=' . $cotxets;

    // $group = " group by `restriccions_adults`,`restriccions_nens` $rcotxets ";
    $group = "";
    $query = "SELECT * FROM
(
  SELECT `restriccions_active`,`restriccions_id`,`restriccions_description`,`restriccions_adults`,`restriccions_nens`, restriccions_cotxets,`restriccions_data`, `restriccions_datafi`,`restriccions_hora`  FROM restriccions where TRUE $were_data
  UNION 
  SELECT `restriccions_active`,`restriccions_id`,`restriccions_description`,`restriccions_adults`,`restriccions_nens`, restriccions_cotxets,`restriccions_data`, `restriccions_datafi`,`restriccions_hora`  FROM restriccions where `restriccions_data`='2011-01-01'
  order by restriccions_data DESC
) R
     $where    
       
      $group
        
ORDER BY  restriccions_data, restriccions_adults, restriccions_nens  DESC
        ";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $json = mysqli_fetch_all($Result1, MYSQLI_ASSOC);
    return $this->resposta_json($json);
  }

  private function resposta_json($json) {
    if (!is_array($json))
      $json = array("resposta" => $json);

    $json = array_map(array($this, 'booleanize'), $json);
    $ret = json_encode($json);

    $ret2 = "OK";
    $ret = "{\"data\":$ret,\"extra\":\"$ret2\"}";
    return $ret;
  }

  private function booleanize($n) {
    if (isset($n['restriccions_active']))
      $n['restriccions_active'] = (bool) $n['restriccions_active'] ? 1 : 0;
    return $n;
  }

  public function getRestriccio($id) {
    return $this->getRestriccions($id);
  }

  public function insertRestriccio($restriccio) {
    $query = "INSERT INTO restriccions 
      (restriccions_active, restriccions_data, restriccions_datafi, restriccions_adults, restriccions_nens, restriccions_cotxets, restriccions_hora, restriccions_description)

      VALUES ('{$restriccio->restriccions_active}',
             '{$restriccio->restriccions_data}', 
             '{$restriccio->restriccions_datafi}',
             '{$restriccio->restriccions_adults}', 
             '{$restriccio->restriccions_nens}', 
             '{$restriccio->restriccions_cotxets}',
             '{$restriccio->restriccions_hora}',
             '{$restriccio->restriccions_description}')";
$this->pliiin($query);
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return $this->getRestriccions();
  }

  public function updateRestriccio($restriccio) {
    $query = "UPDATE  restriccions 
 
      SET restriccions_active= '$restriccio->restriccions_active',
          restriccions_data =   '$restriccio->restriccions_data', 
          restriccions_datafi = '$restriccio->restriccions_datafi',
          restriccions_adults = '$restriccio->restriccions_adults', 
          restriccions_nens = '$restriccio->restriccions_nens', 
          restriccions_cotxets = '$restriccio->restriccions_cotxets',
          restriccions_hora = '$restriccio->restriccions_hora',
          restriccions_description = '$restriccio->restriccions_description'
            
          WHERE restriccions_id = '$restriccio->restriccions_id'
       ";
    $plin = "{'data':\"$query\"}";
    $this->pliiin($plin);
    
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //return"UPDATED";
   // return $this->getRestriccions();
  }

  public function deleteRestriccio($id) {
    $query = "DELETE FROM restriccions WHERE restriccions_id=$id";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//return $this->resposta_json("ESBORRAT id=$id");

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

$usr = new Usuari("alex", "Alkaline10", 64);
$_SESSION['uSer'] = $usr;
$r = new Restriccions();

$stparams = file_get_contents('php://input');
$params = json_decode($stparams);


$accio = $params->accio;
$id = $params->data->restriccions_id;
$restriccio = $params->data;


switch ($accio) {
  case 'deleterestriccio':
    echo $r->deleteRestriccio($id);
    break;

  case 'updaterestriccio':

   echo $r->updateRestriccio($restriccio);
   // echo $r->insertRestriccio($restriccio);
    break;

  case 'insertrestriccio':

    echo $r->insertRestriccio($restriccio);
    break;

  case 'getrestriccions':
  default:

    echo $r->getRestriccions();
    break;
}


