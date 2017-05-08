<?php
if (!defined('ROOT')) define('ROOT', "../../taules/");                      
require (ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();
if (!$gestor->valida_sessio(64))  
{
  header("Location: ../login.php");
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
        //$widget='<label><input type="checkbox" name="'.$label.'" value="'.$val.'" '.$checked.'>'.$label.'</label>';
        $widget='<paper-toggle-button '.$checked.'>'.$label.' </paper-toggle-button>';
    break;
  
    case "URL":
      $widget='<paper-input error-message="Invalid input!" label="'.$label.'" value="'.$val.'"></paper-input>';
    break;
  
    case "PAT":
      $widget='<paper-input error-message="Invalid input!" label="'.$label.'" value="'.$val.'"></paper-input>';
    break;
  
    case "EMA":
      $widget='<gold-email-input auto-validate required validator="email-validator" value="'.$val.'">'
        . '<iron-icon icon="mail" prefix></iron-icon>
  <div suffix>@email.com</div>'
        . '</gold-email-input>';
    break;
  
    case "TIM":
      $parsed = date_parse($val);
    //   $widget='<paper-time-input value="{{result}}" hour="4" min="00" am-pm="AM"></paper-time-input>';

      $widget='<paper-time-input format="24" value="'.$val.'" hour="'.number_format($parsed['hour'],2).'" min="'.number_format($parsed['minute'],2).'" label="'.$label.'" ></paper-time-input>';
      //$widget='<datetime-picker format="24" value="'.$val.'"></datetime-picker>';
      //$widget='<compound-timepicker hours="'.$parsed['hour'].'"  minutes="'.$parsed['minute'].'"  time-format="24"></compound-timepicker>        
    break;
  
    case "INT":
      $widget=parse_type_int($type, $val, $label, $descripcio);
    break;
  
    case "FLO":
      $widget=parse_type_int($type, $val, $label, $descripcio);
    break;
  
  
    case "TST":
      
      //$pattern = "((http[s]?\:)\/\/)?([^\?\:\/#]+)(\:([0-9]+))?(\/[^\?\#]*)?(\?([^#]*))?(#.*)?";
      $pattern = '((http[s]?://))?([^\?:\/#]+)(:([0-9]+))?(/[^\?#]*)?(\?([^#]*))?(#.*)?';
      $widget = '<paper-input pattern="'.$pattern.'" prevent-invalid-input error-message="Invalid input!" label="'.$pattern.$label.'" value="'.$val.'" required auto-validate error-message="needs some text!"  auto-validate="validate">'.$val.'</paper-input>';
      break;
  
    default:
      $widget='<paper-input error-message="Invalid input!" label="'.$label.'" value="'.$val.'">'.$val.'</paper-input>';
    break;
    
  }
  
  return $widget;
}     

function parse_type_int($type, $val, $label, $descripcio){
  $typ = substr(strtoupper($type),0,3);
  $parts=explode("_",$type);
  
  $pattern = $typ=="FLO"?"[0-9]+(\.[0-9]{2})*":"[0-9]";
  
  if (!isset($parts[1])) return '<paper-input prevent-invalid-input error-message="Invalid input!" label="'.$pattern.$label.'" value="'.$val.'" required auto-validate error-message="needs some text!" allowed-pattern="'.$pattern.'" auto-validate="validate">'.$val.'</paper-input>';
  if (!isset($parts[2])) $parts[2]=100;
 // return '<paper-slider id="ratings"   max="10" max-markers="10" step="1" value="5"></paper-slider>';
 return '<paper-slider value="'.$val.'" label="'.$label.'" step="1" snaps max-markers="10" dir="ltr" min="'.$parts[1].'" max="'.$parts[2].'" editable   ></paper-slider>';
     
}
                            
?><!DOCTYPE HTML>
<html>
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title> Configuració del sistema </title>



 <script src="bower_components/webcomponentsjs/webcomponents-lite.js"></script>

    <link rel="import" href="bower_components/compound-timepicker/compound-timepicker.html">
  <link rel="import" href="bower_components/paper-time-picker/paper-time-picker.html">
  <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
  <link rel="import" href="bower_components/paper-button/paper-button.html">
  <link rel="import" href="bower_components/gold-email-input/gold-email-input.html">
  <link rel="import" href="bower_components/paper-slider/paper-slider.html">
  <link rel="import" href="bower_components/paper-checkbox/paper-checkbox.html">
  <link rel="import" href="bower_components/paper-toggle-button/paper-toggle-button.html">
  <link rel="import" href="bower_components/paper-time-input/paper-time-input.html">
  
  
  <link rel="import" href="bower_components/paper-styles/paper-styles.html">
  



<script>
    function printValue(sliderID, textbox) {
        var x = document.getElementById(textbox);
        var y = document.getElementById(sliderID);
        x.value = y.value;
    }
    
    function validate(){alert("EEEE");}
</script>

<style>
  table td{
      border:#AAA solid 1px;
padding:4px;
background-color: #EEE;
}

.paper-slider-0{width:100%}
</style>
</head>
<body>
<h1>Configuració del sistema</h1>



<div class="cb-llistat ui-corner-all">
    <table>
       
<?php
$row=array("config_var"=>"teeest","config_val"=>"45478","config_type"=>"TST","config_descripcio"=>"teeest");
array_unshift($rows,$row);

	foreach ($rows as $k=>$v)
	{
                              $widget = parse_type($v['config_type'], $v['config_val'], $v['config_var'], $v['config_descripcio']);
                              
                              echo $row = "<tr>"
                                 // . "<td>".$v['config_var']."</td>"
                                  . "<td>".$v['config_val']."</td>"
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