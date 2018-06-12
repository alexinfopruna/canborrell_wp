<?php

if (!defined('ROOT'))
  define('ROOT', "");


//if (!defined('TOTES_HORES'))
//  define('TOTES_HORES', array("", "11:00", "11:15", "11:30", "11:45",
//    "12:00", "12:15", "12:30", "12:45",
//    "13:00", "13:15", "13:30", "13:45",
//    "14:00", "14:15", "14:30", "14:45",
//    "15:00", "15:15", "15:30", "15:45",
//    "16:00", "16:15", "16:30", "16:45",
//    "17:00"));




require_once (ROOT . "./gestor_reserves.php");
require_once(ROOT . INC_FILE_PATH . "llista_dies_taules.php");
/*
ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
 * 
 */
if (!defined('ROOT'))
  define('ROOT', './');

class RestrictionController extends gestor_reserves {
static $TOTES_HORES =array("", "11:00", "11:15", "11:30", "11:45",
    "12:00", "12:15", "12:30", "12:45",
    "13:00", "13:15", "13:30", "13:45",
    "14:00", "14:15", "14:30", "14:45",
    "15:00", "15:15", "15:30", "15:45",
    "16:00", "16:15", "16:30", "16:45",
    "17:00");
  
  
  function __contruct($usuari_minim = 1) {
    parent::__construct(DB_CONNECTION_FILE, $usuari_minim);
  }

  public function getActiveRules($data, $adults = 0, $nens = 0, $cotxets = 0, $sqlquery = false) {
    $sum = $adults + $nens;
    $senar = ($sum) & 1;
    $parell = !$senar;
//echo "{'ee':'$sum .. $parell'}";die();
    $where_adults = $this->mountWhereCoberts('adults', $adults, $parell);

    $where_nens = $this->mountWhereCoberts('nens', $nens);

    $where_cotxets = $this->mountWhereCoberts('cotxets', $cotxets);


    $where_data = $this->mountWhereDate($data);
    
    $where = $where_data . $where_adults . $where_nens . $where_cotxets;
//$where = $where_data . $where_adults . " AND (restriccions_adults='Parell' OR restriccions_adults='Senar' OR TRUE $where_nens)" . $where_cotxets;
//$order = "ORDER BY restriccions_data DESC, restriccions_data = restriccions_datafi";
//$order = " ORDER BY restriccions_data DESC, restriccions_hora  ";
    $order = " ORDER BY restriccions_data = '2011-01-01', restriccions_adults ";


    $query = "SELECT * 
FROM restriccions 
WHERE restriccions_active = TRUE $where
$order
";
    //echo "$query";die();
    if ($sqlquery)
      return "$data >>> $adults | $nens | $cotxets >>>>>>>>>>>>> " . $query;
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (isset($_REQUEST['test']))
      echo "---------------------- $data, $adults, $nens, $cotxets -----------------------------<br><br><br>";
//$rules = mysqli_fetch_all ($Result1, MYSQLI_ASSOC);

    $rules = [];
    while ($row = $Result1->fetch_assoc()) {
      $rules[] = $row;
    }


    if (isset($_REQUEST['test']))
      echo ">>> $query <br><br>";
    while ($row = mysqli_fetch_row($Result1)) {
      
    }


    return $rules;
  }

  /*   * ************************************************************************ */

  public function getHores($data = 0, $adults = 0, $nens = 0, $cotxets = 0) {
    if (!$adults || !defined("CONTROL_HORES_NENS") || !CONTROL_HORES_NENS)
      return;

    if ($nens == "undefined")
      $nens = 0;

    $index = 'cacheNens' . $data . "-" . ($adults + $nens);
    $time = time();
    $cache = FALSE;
    if (isset($_SESSION[$index]) && count($_SESSION[$index]['hores']) && $_SESSION[$index]['timestamp'] > $time) {
      $cache = $_SESSION[$index]['hores'];
    }



    $rules = $this->getActiveRules($data, $adults, $nens, $cotxets);

    $jsonrules = json_encode($rules);
    if (!$rules)
      return false;

//$hores = $this->subArrayHoresb($rules[0]['restriccions_hores']);
    $hores = $cache ? $cache : $this->interseccio_hores($rules);
//$hores = $this->interseccio_hores($rules);
    /**/
    //if (count($rules)) {
    $cachev = array();
    $cachev['timestamp'] = time() + CB_CHILD_CACHE_MAX_TIME;
    $cachev['hores'] = $hores;
    $_SESSION[$index] = $cachev;
    //   } 


    return $hores;
  }

  public function getHoresRules($data = 0, $adults = 0, $nens = 0, $cotxets = 0) {

    $query = $this->getActiveRules($data, $adults, $nens, $cotxets, true);
    $rules = $this->getActiveRules($data, $adults, $nens, $cotxets);

    $rules2 = array();
    foreach ($rules as $k => $rule) {
      $rule['restriccions_hores'] = $this->subArrayHoresb($rule['restriccions_hores']);

      $rules2[] = $rule;
    }
//print_r($rules2);die();
    $jsonrules = json_encode($rules);
//echo "{dd:$data, vv:$adults, bb:$nens, nn:$jsonrules}";die();
    if (!$rules) {
      $rules[0]['restriccions_hora'] = '00:00';
      $rules[0]['restriccions_hores'] = '8589934591';
    }

    //$hores = $this->subArrayHoresb($rules[0]['restriccions_hores']);
    $hores = $this->interseccio_hores($rules);
    $r['rules'] = $rules2;
    $r['hores'] = $hores;
    $r['query'] = $query;
    return $r;
  }

  /*   * ************************************************************************ */

  public function getHoresCoberts($data, $coberts ) {
    $diesBin = array(64, 32, 16, 8, 4, 2, 1);
    $ds = date('N', strtotime($data));
    $diaBin = $diesBin[$ds - 1];


    $wherediasem = "  (restriccions_dies = 0 OR restriccions_dies & $diaBin > 0) AND ";

    $were_data = "restriccions_active = 1 AND (restriccions_data='2011-01-01' OR restriccions_data <= '$data' AND restriccions_datafi >='$data') AND ";
    $query = "SELECT * FROM RestriccioHoresTaula where $were_data  $wherediasem restriccions_taula_id = '$coberts'";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nr = mysqli_num_rows($Result1); 
    if (!$nr) return null; // SI NO HI HA RESTRICCIONS SON TOTES
    
    $hores = array();
    while ($row = $Result1->fetch_assoc()) {
      $hores = $hores | $row['restriccions_hores'];
    }
//    echo "-- $hores ----";
    //echo $query;die();
    //var_dump(TOTES_HORES);
    
    $hores = $this->subArrayHoresb($hores);
    return($hores);
  }


  
  /*   * ************************************************************************ */

  public function getHoresTaules($data, $taules) {
    $hores_taula = array();

    foreach ($taules as $k => $v) {
      
   //   $hores = $this->getHoresTaula($data, $v->id); //$rc->
      $hores = $this->getHoresTaula($data, $v->nom); //$rc->
      
      $hores_taula = array_merge($hores_taula, $hores);
     }

    $hores_taula = array_unique($hores_taula);
    $hores_taula = array_diff($hores_taula, ['99:99']);
    sort($hores_taula);

    return $hores_taula;
  }

  
  
  
  /*   * ************************************************************************ */

  public function getHoresTaula($data, $taulaId) {
    $were_data = "restriccions_active = 1 AND (restriccions_data='2011-01-01' OR restriccions_data <= '$data' AND restriccions_datafi >='$data') AND ";
    $query = "SELECT * FROM RestriccioHoresTaula where $were_data restriccions_taula_id = '$taulaId'";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nr = mysqli_num_rows($Result1); 
    if (!$nr) return RestrictionController::$TOTES_HORES; // SI NO HI HA RESTRICCIONS SON TOTES
    $rules = array();
    $hores = array();
    while ($row = $Result1->fetch_assoc()) {
      $rules[] = $row;
    }

    $hores = $this->interseccio_hores($rules);
    return($hores);
  }

  /** LA REGLA MES MODERNA * */
  private function interseccio_hores($rules) {
    if (!sizeof($rules))
      return false;

    $rule = $rules[0];
    return $this->subArrayHoresb($rule['restriccions_hores']);
  }

  /** INTERSECCIO RESTRICTIVA * */
  private function interseccio_horesxxx($rules) {
    $inter = RestrictionController::$TOTES_HORES;

    foreach ($rules as $k => $rule) {
      $hores = $this->subArrayHoresb($rule['restriccions_hores']);
      $inter = array_intersect($inter, $hores);
    }
    //echo $inter;die();
    return array_values($inter);
  }

  private function subArrayHoresb($decNum) {
    $strbin = substr("00000000000000000000000000000000" . decbin($decNum), -26);

    $arrayBib = str_split($strbin);
    $binHores = array_map('intval', $arrayBib);
    $hores = RestrictionController::$TOTES_HORES;

    //NO POT QUEDAR BUIDA
    $result = array();
    $result = array('99:99');
    foreach ($binHores as $k => $v) {
      if ($v)
        $result[] = $hores[$k];
    }

    if (!count($result))
      $result = array('99:99');
    return $result;
  }

  private function dies2bin($decNum) {
    $strbin = substr("00000000" . decbin($decNum), -7);
    $arrayBib = str_split($strbin);
    $integerIDs = array_map('intval', $arrayBib);

    return $integerIDs;
  }

  /*   * ************************************************************************ */

  private function mountWhereDate($data) {
    //$dates = file(LLISTA_DIES_BLANCA);
    $dates[0]["dies_especials_data"]= '2010-01-01';
    $query = "SELECT dies_especials_data FROM dies_especials_small WHERE dies_especials_tipus ='white'";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nr = mysqli_num_rows($Result1); 
    if ($nr) $dates = mysqli_fetch_all($Result1, MYSQLI_ASSOC);
    foreach ($dates as $k => $value) {
      $dates[$k] = "'" . Gestor::cambiaf_a_mysql($value["dies_especials_data"]) . "'";
    }
    $indates = implode(", ", $dates);
    $whereindates = " OR '$data' IN ($indates) ";
    //      print_r($indates);die();


    $where = " AND (restriccions_data ='2011-01-01' OR (restriccions_data <= '$data' "
        . "AND restriccions_datafi >= '$data') ) ";

    $diesBin = array(64, 32, 16, 8, 4, 2, 1);
    $mesosBin = array(2048, 1024, 512, 256, 128, 64, 32, 16, 8, 4, 2, 1);
    $ds = date('N', strtotime($data));
    $mes = date('n', strtotime($data));
    $diaBin = $diesBin[$ds - 1];
    $mesBin =  $mesosBin[$mes - 1];
    
    //retriccions_mesos

    $r = json_encode($diaBin);
    $where .= " AND ((restriccions_data <> '2011-01-01' AND restriccions_data = restriccions_datafi) OR (restriccions_dies & $diaBin > 0  AND restriccions_mesos & $mesBin > 0) $whereindates  ) ";

    return $where;
  }

  /*   * ********************************************************************* */

  private function mountWhereCoberts($field, $coberts, $parell = FALSE) {
//if ($coberts == "Parell") return $where=" AND ((restriccions_adults + restriccions_nens) %2 = 0 )";
//if ($coberts == "Senar") return $where=" AND ((restriccions_adults + restriccions_nens) %2 <> 0 )";

    if ($coberts == "undefined")
      $coberts = '0';


    $par = "";
    if ($field == 'adults' && $parell)
      $par = ", 'Parell'";
    if ($field == 'adults' && !$parell)
      $par = ", 'Senar'";

//if ($field=='nens') ""

    $arr = " restriccions_$field IN ('$coberts', ";

    for ($i = 0; $i < $coberts; $i++)
      $arr .= "'>$i', ";
    for ($i = 20; $i > $coberts; $i--)
      $arr .= "'<$i', ";

    if ($field == 'adults' && !$parell)
      $par = ", 'Senar'";
    $arr .= "'Tot' $par)";
    $where = " AND $arr ";

    return $where;
  }
}

if (isset($_REQUEST['data'])) {
  $rc = new RestrictionController();
  $data = $_REQUEST['data'];
  $adults = $_REQUEST['adults'];
  $nens = $_REQUEST['nens'];
  $cotxets = $_REQUEST['cotxets'];
  $rules = $rc->getActiveRules($data, adults, $nens, $cotxets);
  echo "<h1>RULES</h1>";
  foreach ($rules as $row) {
    echo "<li><pre>";
    print_r($row);
    echo "</pre></li>";
  }
}

if (isset($_REQUEST['json']))
  $stparams = $_REQUEST['json'];
else
  $stparams = file_get_contents('php://input');
$params = json_decode($stparams);
//var_dump($stparams);die();
//echo "EEEE";
if ($params) {
  $accio = $params->accio;
  $id = isset($params->data->restriccions_id) ? $params->data->restriccions_id : 0;
  $restriccio = $params->data;
}
?>
