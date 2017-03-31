<?php
if (!defined('ROOT'))
  define('ROOT', "");


require_once (ROOT."./gestor_reserves.php");

ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
if (!defined('ROOT')) define('ROOT', './');

class RestrictionController  extends gestor_reserves{
function __contruct($usuari_minim = 1){
	parent::__construct(DB_CONNECTION_FILE, $usuari_minim);
  
}


public function getActiveRules($data, $adults=0, $nens=0, $cotxets=0, $sqlquery=false){
$sum = $adults+ $nens;
$senar= ($sum)&1;
$parell = !$senar;
//echo "{'ee':'$sum .. $parell'}";die();
$where_adults = $this->mountWhereCoberts('adults', $adults, $parell);

$where_nens = $this->mountWhereCoberts('nens', $nens);

$where_cotxets = $this->mountWhereCoberts('cotxets', $cotxets);


$where_data = $this->mountWhereDate($data);
$where = $where_data . $where_adults .  $where_nens . $where_cotxets;
//$where = $where_data . $where_adults . " AND (restriccions_adults='Parell' OR restriccions_adults='Senar' OR TRUE $where_nens)" . $where_cotxets;
//$order = "ORDER BY restriccions_data DESC, restriccions_data = restriccions_datafi";
//$order = " ORDER BY restriccions_data DESC, restriccions_hora  ";
$order = " ORDER BY restriccions_data = '2011-01-01', restriccions_adults ";
	

$query ="SELECT * 
FROM restriccions 
WHERE restriccions_active = TRUE $where
$order
";

if ($sqlquery) return "$data >>> $adults | $nens | $cotxets >>>>>>>>>>>>> ".  $query;
   $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
if (isset($_REQUEST['test'])) echo "---------------------- $data, $adults, $nens, $cotxets -----------------------------<br><br><br>";
//$rules = mysqli_fetch_all ($Result1, MYSQLI_ASSOC);

$rules = [];
while ($row = $Result1->fetch_assoc()) {
    $rules[] = $row;
}


if (isset($_REQUEST['test'])) echo ">>> $query <br><br>";
	while ($row= mysqli_fetch_row($Result1)){
}


return $rules;
}
/***************************************************************************/
public function getHores($data=0, $adults=0, $nens=0, $cotxets=0){
  
  $rules = $this->getActiveRules($data,$adults,$nens,$cotxets);
  
  $jsonrules=json_encode($rules);
  if (!$rules) return false;

//$hores = $this->subArrayHoresb($rules[0]['restriccions_hores']);
$hores = $this->interseccio_hores($rules);

  return $hores;
}

public function getHoresRules($data=0, $adults=0, $nens=0, $cotxets=0){
 
  $query = $this->getActiveRules($data,$adults,$nens,$cotxets,true);
  $rules = $this->getActiveRules($data,$adults,$nens,$cotxets);
  
  $rules2=array();
  foreach($rules as $k => $rule){                
    $rule['restriccions_hores'] = $this->subArrayHoresb($rule['restriccions_hores']);
  
    $rules2[]=$rule;
  }
//print_r($rules2);die();
  $jsonrules=json_encode($rules);
//echo "{dd:$data, vv:$adults, bb:$nens, nn:$jsonrules}";die();
  if (!$rules)  { 
    $rules[0]['restriccions_hora'] = '00:00';
    $rules[0]['restriccions_hores'] = '8589934591';
  }
  
  //$hores = $this->subArrayHoresb($rules[0]['restriccions_hores']);
  $hores = $this->interseccio_hores($rules);
  
  $r['rules']=$rules2;
  $r['hores']=$hores;
  $r['query']=$query;
  return $r;
}

/** LA REGLA MES MODERNA **/
private function interseccio_hores($rules){
    if (!sizeof($rules)) return false;

$rule = $rules[0];
  return $this->subArrayHoresb($rule['restriccions_hores']);
}

/** INTERSECCIO RESTRICTIVA **/
private function interseccio_horesxxx($rules){
   $inter =  array("","11:00", "11:15", "11:30", "11:45", 
    "12:00", "12:15", "12:30", "12:45", 
    "13:00", "13:15", "13:30",  "13:45", 
    "14:00", "14:15", "14:30",  "14:45", 
    "15:00", "15:15", "15:30",  "15:45", 
    "16:00", "16:15", "16:30", "16:45", 
    "17:00");
  
  foreach ($rules as $k => $rule){
    $hores = $this->subArrayHoresb($rule['restriccions_hores']);
    $inter=array_intersect($inter, $hores);
  }
  //echo $inter;die();
  return  array_values($inter); 
}

private function subArrayHoresb($decNum){
//$decNum=8589934591;
     $strbin = substr("00000000000000000000000000000000" . decbin ( $decNum ),-26);
     $arrayBib =  str_split( $strbin);
     $binHores = array_map('intval', $arrayBib);

//print_r( $binHores);
  $hores =  array("","11:00", "11:15", "11:30", "11:45", 
    "12:00", "12:15", "12:30", "12:45", 
    "13:00", "13:15", "13:30",  "13:45", 
    "14:00", "14:15", "14:30",  "14:45", 
    "15:00", "15:15", "15:30",  "15:45", 
    "16:00", "16:15", "16:30", "16:45", 
    "17:00");
 
//$result = array(1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1,1);
foreach ($binHores as $k => $v){
    if ($v) $result[] = $hores[$k];                   
}
return $result;
}

/*
private function subArrayHores($hora){
  $hores =  array("11:00", "11:15", "11:30", "11:45", 
    "12:00", "12:15", "12:30", "12:45", 
    "13:00", "13:15", "13:30",  "13:45", 
    "14:00", "14:15", "14:30",  "14:45", 
    "15:00", "15:15", "15:30",  "15:45", 
    "16:00", "16:15", "16:30", "16:45", 
    "17:00");
  $offset = array_search($hora, $hores);
  //echo "{'offset':'$hora'}";
  return $ar = array_slice($hores, $offset);
}
*/



private function dies2bin($decNum){
     $strbin = substr("00000000" . decbin ( $decNum ),-7);
     $arrayBib =  str_split( $strbin);
     $integerIDs = array_map('intval', $arrayBib);

     return $integerIDs;
}


/***************************************************************************/
private function mountWhereDate($data){
	$where=" AND (restriccions_data ='2011-01-01' OR (restriccions_data <= '$data' AND restriccions_datafi >= '$data')) ";
	
                            
                            $diesBin = array(64,32,16,8,4,2,1);
	$ds = date('N', strtotime($data));
	$diaBin=$diesBin[$ds-1];

$r=json_encode(	$diaBin);
	$where .= " AND ((restriccions_data <> '2011-01-01' AND restriccions_data = restriccions_datafi) OR (restriccions_dies & $diaBin > 0)) ";
//	echo "{'ddd':$where}";
return $where;
}
	
/************************************************************************/
private function mountWhereCoberts($field, $coberts, $parell=FALSE){
//if ($coberts == "Parell") return $where=" AND ((restriccions_adults + restriccions_nens) %2 = 0 )";
//if ($coberts == "Senar") return $where=" AND ((restriccions_adults + restriccions_nens) %2 <> 0 )";

if ($coberts=="undefined") $coberts='0';


$par="";
if ($field=='adults' && $parell) $par=", 'Parell'";
if ($field=='adults' && !$parell) $par=", 'Senar'";

//if ($field=='nens') ""

$arr = " restriccions_$field IN ('$coberts', "; 

for ($i=0;$i<$coberts;$i++) $arr .= "'>$i', ";
for ($i=20;$i>$coberts;$i--) $arr .= "'<$i', ";

if ($field=='adults' && !$parell) $par=", 'Senar'";
$arr  .= "'Tot' $par)";
$where = " AND $arr ";

return $where;
}
}

if (isset($_REQUEST['data'])) {
$rc=new RestrictionController();
$data = $_REQUEST['data'];
$adults = $_REQUEST['adults'];
$nens = $_REQUEST['nens'];
$cotxets = $_REQUEST['cotxets'];
$rules = $rc->getActiveRules($data,adults,$nens,$cotxets);
echo "<h1>RULES</h1>";
foreach ($rules as $row){ echo "<li><pre>";print_r($row);echo "</pre></li>";}
}

if (isset($_REQUEST['json'])) $stparams=$_REQUEST['json'];
else $stparams = file_get_contents('php://input');
$params = json_decode($stparams);

if ($params){
$accio = $params->accio;
$id = isset($params->data->restriccions_id)?$params->data->restriccions_id:0;
$restriccio = $params->data;

//var_dump($restriccio);
}



?>
