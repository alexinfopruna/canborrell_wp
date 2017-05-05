<?php
if (!defined('ROOT')) define('ROOT', "../taules/");                      
require (ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();
if (!$gestor->valida_sessio(64))  
{
  header("Location: login.php");
  die();
}                            
	$cfg=new Configuracio();
                            $rows = $cfg->array_vars();
                            
                            
function parse_type($type, $val, $label, $descripcio){
  $widget = $val;
  $typ = substr(strtoupper($type),0,3);
  //if (substr($type,0,3) == "INT") parse_type_int($type);
  
  switch($typ) {
    case "BOO":
        $checked = ($val=="true"?"checked":"");
        $widget='<label><input type="checkbox" name="'.$label.'" value="'.$val.'" '.$checked.'>'.$label.'</label>';
    break;
  
    case "URL":
      $widget='<input type="text" name="vehicle" value="Bike">';
    break;
  
    case "PAT":
      $widget='<input type="text" name="vehicle" value="Bike">';
    break;
  
    case "EMA":
      $widget='<input type="text" name="vehicle" value="Bike">';
    break;
  
    case "TIM":
      $widget='<input type="text" name="vehicle" value="Bike">';
    break;
  
    case "INT":
      $widget=parse_type_int($type, $val, $label, $descripcio);
    break;
  
    case "FLO":
      $widget=parse_type_int($type, $val, $label, $descripcio);
    break;
  
    default:
      $widget='<input type="text" name="vehicle" value="DEF">';
    break;
    
  }
  
  return $widget;
}     

function parse_type_int($type, $val, $label, $descripcio){
  $parts=explode("_",$type);
  if (!isset($parts[1])) return '<input type="text" name="'.$label.'" value="'.$val.'">';
  if (!isset($parts[2])) $parts[2]=100;
  //if (!isset($parts[3])) $parts[3]=0;
  
return '<input type="range" min="'.$parts[1].'" max="'.$parts[2].'" id="'.$label.'" name="'.$label.'" value="'.$val.'" onchange="printValue(\''.$label.'\',\'range_'.$label.'\')">'
  //return '<input type="range" min="" max="" id="'.$label.'" name="'.$label.'" value="'.$val.'" onchange="$(\'#'.$label.'\').val(\''.$label.'\')">'
      . '<input id="range_'.$label.'" type="text" size="2" value="'.$val.'">';
}
                            
?><!DOCTYPE HTML>
<html>
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE> Llistat de factures Proforma </TITLE>
<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
<link type="text/css" href="../reservar/css/custom-theme/jquery.ui.all.css" rel="stylesheet" />	
	
<link type="text/css" href="../reservar/css/form_reserves.css" rel="stylesheet" />	

               <?php echo Gestor::loadJQuery("2.0.3"); ?>

<script>
    function printValue(sliderID, textbox) {
        var x = document.getElementById(textbox);
        var y = document.getElementById(sliderID);
        x.value = y.value;
    }
</script>
</head>
<body>
<h1>Configuració del sistema</h1>
<div class="cb-llistat ui-corner-all">
    <table>
       
<?php

	foreach ($rows as $k=>$v)
	{
                              $widget = parse_type($v['config_type'], $v['config_val'], $v['config_var'], $v['config_descripcio']);
                              
                              echo $row = "<tr>"
                                  . "<td>".$v['config_var']."</td>"
                                  . "<td>".$widget."</td>"
                                  . "<td>".$v['config_descripcio']."</td>"
                                  . "<td>".$v['config_type']."</td>"
                                  . "</tr>";
                              
                              
	}
?>
    
   
   </table>
</div>

</body>
</html>