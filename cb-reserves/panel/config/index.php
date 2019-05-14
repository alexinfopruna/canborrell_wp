<?php
if (!defined('ROOT'))
  define('ROOT', "../../taules/");
require (ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();

if (!$gestor->valida_sessio(64)) {
  header("Location: ../login.php");
  die();
}

$cfg = new Configuracio();
/*
$were = NULL;
if ($_SESSION['uSer']->permisos < 255){
$were = "config_id>2 AND config_id<16 
OR config_id=35
OR config_id=38
OR config_id=39
OR config_id=40";
}
*/

global $dialog;
$dialog = 0;
$were = "  config_permisos <= ".$_SESSION['uSer']->permisos." ";
$rows = $cfg->array_vars($were);

/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */

function parse_type($type, $val, $label, $descripcio) {
  $widget = $val;
  $typ = substr(strtoupper($type), 0, 3);
  //if (substr($type,0,3) == "INT") parse_type_int($type);

  switch ($typ) {
    case "BOO":
      $checked = ($val == "true" ? "checked" : "");
      $widget = '<label aria-hidden="true" for="input" class="lx style-scope paper-input" id="paper-input-label-1">' . $label . '</label>';
      $widget .= '<paper-toggle-button ' . $checked . '  label="' . $label . '"  on-tap="postData_bool">' . "" . ' </paper-toggle-button>';
      break;

    case "URL":
      $pattern = '((http[s]?\:)\/\/)?([^\?\:\/#]+)(\:([0-9]+))?(\/[^\?\#]*)?(\?([^#]*))?(#.*)?';
      $pattern = '((http[s]?:)\/\/)?([^\?:\/#]+)(:([0-9]+))?(\/[^\?#]*)?(\?([^#]*))?(#.*)?';
      $widget = '<paper-input pattern="' . $pattern . '" prevent-invalid-input error-message="Invalid input!" label="' . $label . '" value="' . $val . '"   on-input="postData_input" required auto-validate error-message="needs some text!"  auto-validate="validate">' . $val . '</paper-input>';
      break;

    case "PAT":

      $pattern = '([\w-]+|(\.){1,2})?(\/([\w-]+|(\.){1,2}))*(.[a-zA-Z\/]+)';
      $widget = '<paper-input pattern="' . $pattern . '" prevent-invalid-input error-message="Invalid input!" label="' . $label . '" value="' . $val . '"   on-input="postData_input" required auto-validate error-message="needs some text!"  auto-validate="validate">' . $val . '</paper-input>';
      break;

    case "EMA":
      $widget = '<gold-email-input auto-validate required validator="email-validator"   on-input="postData_input"   label="' . $label . '"  value="' . $val . '">'
          . '<iron-icon icon="mail" prefix></iron-icon>
  <div suffix>@email.com</div>'
          . '</gold-email-input>';
      break;

    case "TIM":
      
     $parsed = date_parse($val);
      global $dialog;
      $dialog++;      
      
    $widget ='<paper-time-picker time="4:20pm"></paper-time-picker>';
     break;
    
    
    case "cccTIM":
     $parsed = date_parse($val);
      global $dialog;
      $dialog++;
      //   $widget='<paper-time-input value="{{result}}" hour="4" min="00" am-pm="AM"></paper-time-input>';
      //$widget='<paper-time-input format="24" value="'.$val.'" hour="'.number_format($parsed['hour'],2).'" min="'.number_format($parsed['minute'],2).'" label="'.$label.'" ></paper-time-input>';
      //$widget = '<compound-timepicker hours="' . $parsed['hour'] . '"  minutes="' . $parsed['minute'] . '"  time-format="24"   label="'.$label.'" ></compound-timepicker> ';
      //$widget = $parsed . '<paper-time-picker time="' . $val . '"></paper-time-picker>';
$widget = '<label aria-hidden="true" for="label1" class="lx style-scope paper-input" id="paper-input-label-1">' . $label . '</label>';

      $widget .= '<p id="time_' . $dialog . '" onclick="dialog_' . $dialog . '.open()" > {{time_' . $dialog . '}}</p>'.
  // <paper-button class="btn"  onclick="dialog_' . $dialog . '.open()" raised>Change Time</paper-button>
'<paper-dialog id="dialog_' . $dialog . '"  class="paper-time-picker-dialog" modal on-iron-overlay-closed="dismissDialog" >
  
  <paper-time-picker id="timePicker_' . $dialog . '"  time="' . $val . '"    on-change="postData_timer"   label="' . $label . '" ></paper-time-picker>
  <div class="buttons">
  
    <paper-button dialog-dismiss>Cancel</paper-button>
    <paper-button dialog-confirm onclick="dismissDialog(' . $dialog . ')">OK</paper-button>
  </div>
</paper-dialog>';
      break;

    case "INT":
      $widget = parse_type_int($type, $val, $label, $descripcio);
      break;

    case "FLO":
      $widget = parse_type_int($type, $val, $label, $descripcio);
      break;


    case "RAD":
      $widget = parse_type_radio($type, $val, $label, $descripcio);
      break;

    case "TTL":
      $pattern = '(\d)+\s(WEEK|WEEK|MONTH|YEAR|HOUR|MINUTE|SECOND)(S)*';
      $widget = '<paper-input pattern="' . $pattern . '"     on-input="postData_input"    prevent-invalid-input error-message="Invalid input!" label="' . $label . '" value="' . $val . '" required auto-validate error-message="needs some text!"  auto-validate="validate">' . $val . '</paper-input>';

      break;

    case "TST":

      //$pattern = "((http[s]?\:)\/\/)?([^\?\:\/#]+)(\:([0-9]+))?(\/[^\?\#]*)?(\?([^#]*))?(#.*)?";
      $pattern = '((http[s]?://))?([^\?:\/#]+)(:([0-9]+))?(/[^\?#]*)?(\?([^#]*))?(#.*)?';
      $widget = '<paper-input pattern="' . $pattern . '"    on-input="postData_input"    prevent-invalid-input error-message="Invalid input!" label="' . $label . '" value="' . $val . '" required auto-validate error-message="needs some text!"  auto-validate="validate">' . $val . '</paper-input>';
      break;

    case "TEX":
    case "TXT":
    default:
      $widget = '<paper-input error-message="Invalid input!" label="' . $label . '"     on-input="postData_input"   value="' . $val . '">' . $val . '</paper-input>';
      break;
  }

  return $widget;
}

/* * *********************************************************************************************************************** */

function parse_type_radio($type, $val, $label, $descripcio) {
  $typ = substr(strtoupper($type), 0, 3);
  $parts = explode("_", $type);

  $n = count($parts);
  $options = "";
  for ($i = 1; $i < $n; $i++) {
    $options.='  <paper-radio-button  label="' . $label . '" name="' . $parts[$i] . '" value="' . $parts[$i] . '">' . $parts[$i] . '</paper-radio-button>';
  }
$widget = '<label aria-hidden="true" for="label1" class="lx style-scope paper-input" id="paper-input-label-1">' . $label . '</label>';
  $html = $widget.'<paper-radio-group aria-labelledby="label1"    on-change="postData_input"   selected="' . $val . '"   label="' . $label . '" >' . $options . '</paper-radio-group>';

  return $html;
}

/* * *********************************************************************************************************************** */

function parse_type_int($type, $val, $label, $descripcio) {
  $typ = substr(strtoupper($type), 0, 3);
  $parts = explode("_", $type);

  $pattern = $typ == "FLO" ? "[0-9]+(\.[0-9]{2})*" : "[0-9]";

  if (!isset($parts[1]))
    return '<paper-input prevent-invalid-input error-message="Invalid input!" label="' . $label . '" value="' . $val . '"     on-input="postData_input"   required auto-validate error-message="needs some text!" allowed-pattern="' . $pattern . '" auto-validate="validate">' . $val . '</paper-input>';
  if (!isset($parts[2]))
    $parts[2] = 100;
  // return '<paper-slider id="ratings"   max="10" max-markers="10" step="1" value="5"></paper-slider>';
  $widget = '<label aria-hidden="true" for="label1" class="lx style-scope paper-input" id="paper-input-label-1">' . $label . '</label>';

  $widget .= '<paper-slider value="' . $val . '" label="' . $label . '" step="1" on-change="postData_input" pin snaps max-markers="10" dir="ltr" min="' . $parts[1] . '" max="' . $parts[2] . '" editable   ></paper-slider>';
  
  return $widget;
}

/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
?><!DOCTYPE HTML>
<html>
    <head>
        <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Configuració del sistema de reserves </title>
 <?php echo Gestor::loadJQuery("2.0.3"); ?>
<link type="text/css" href="../../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
<link type="text/css" href="../../reservar/css/custom-theme/jquery.ui.all.css" rel="stylesheet" />	        
        
        
        <script src="bower_components/webcomponentsjs/webcomponents-lite.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/ca.js"></script>

        <link rel="import" href="bower_components/compound-timepicker/compound-timepicker.html">
        <link rel="import" href="bower_components/paper-time-picker/paper-time-picker.html">
        <link rel="import" href="bower_components/paper-dialog/paper-dialog.html">
        <link rel="import" href="bower_components/paper-button/paper-button.html">
        <link rel="import" href="bower_components/gold-email-input/gold-email-input.html">
        <link rel="import" href="bower_components/paper-slider/paper-slider.html">
        <link rel="import" href="bower_components/paper-checkbox/paper-checkbox.html">
        <link rel="import" href="bower_components/paper-toggle-button/paper-toggle-button.html">
        <link rel="import" href="bower_components/paper-time-input/paper-time-input.html">
        <link rel="import" href="bower_components/paper-radio-group/paper-radio-group.html">
        <link rel="import" href="bower_components/paper-styles/paper-styles.html">

        <style>
            body{display: flex;justify-content:center;}
            
            table{width:100%;}
            table td{
                padding:20px;
            }
            
            td{border: #DDD solid 1px;}

            label{
                font-family: 'Roboto', 'Noto', sans-serif;
                color:#737373;
                color:#a72b2b !important; 
                font-size:12px;
                font-size:20px !important; 
                display: block;
            }
             label.lx{ font-size: 16px !important; }
            
           
            tablexxx td{
                border:#AAA solid 1px;
                padding:4px;
                background-color: #EEE;
            }
            .paper-slider-0{width:100%}
            .overlay {
                position: absolute;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
                height: 100%;
                width: 100%;
                opacity: 0.7;
                background:url(//www.can-borrell.com/wp-content/themes/onetone/images/loading.gif) center center no-repeat;
                background-color: white;
                z-index: 100;
            }
            
            #popup{
                width:  100px;
                margin:20px;
                color:#444;
            }
            
            .descripcio{font-size:12px;color:#444;}
        </style>
    </head>
    <body>
        <div>
            <template is="dom-bind" id="scope">
                <h1> Configuració del sistema de reserves </h1>
                <div id="overlay" class="overlay" style="display:none"></div>
                <!--
                <iron-ajax 
                    id="dataAjax" 
                    method="get"
                    handle-as="json"
                    contentType="application/json"
                    url="Gestor_config.php?a=set_value"
                    last-response={{data}}
                    on-response="postComplete"></iron-ajax>

                <paper-dialog id="dialog2">
                    <h2>Dialog Title</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                        irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </paper-dialog>
-->


                <div class="cb-llistat ui-corner-all">
                    <table >

                        <?php
                      //  $row = array("config_var" => "teeest", "config_val" => "45478", "config_type" => "TST", "config_descripcio" => "teeest");
                       // array_unshift($rows, $row);

                        foreach ($rows as $k => $v) {
                          $widget = parse_type($v['config_type'], $v['config_val'], $v['config_var'], $v['config_descripcio']);

                          echo $row = "<tr>"
                          //. "<td>" . $v['config_var'] . "</td>"
                          . "<td>" . $widget . "<br><span class='descripcio'> {$v['config_descripcio']}</span></td>"
                          //   . "<td>" . $v['config_val'] . "</td>"
                          // . "<td>" . $v['config_descripcio'] . "</td>"
                          // . "<td>" . $v['config_type'] . "</td>"
                          . "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </template>
        </div>
        <script>
        // var tims =<?php echo $dialog; ?>
/**/
          function printValue(sliderID, textbox) {
              var x = document.getElementById(textbox);
              var y = document.getElementById(sliderID);
              x.value = y.value;
          }

          function dismissDialog(dialog) {
              var p = document.querySelector('#timePicker_' + dialog);
              var dt = moment(p.time, ["h:mm A"]).format("HH:mm");

              //var t = document.querySelector('time_'+dialog);
              scope["time_" + dialog] = dt;

              // var normalizedEvent = Polymer.dom(a);
              var label = p.getAttribute("label");
              var val = dt;
              var t = document.querySelector('#scope');
              //var ajaxRequest = t.$.dataAjax;
              //ajaxRequest.body = {label: val}
              //ajaxRequest.url = "Gestor_config.php?a=set_value&b=" + label + "&c=" + val
              var url = "Gestor_config.php?a=set_value&b=" + label + "&jq=1&c=" + val
              //ajaxRequest.generateRequest();
              $("#popup").html(url+"...");
              $.post(url,respostaAjax);

          }

          (function (document) {
              'use strict';
              
              document.addEventListener('WebComponentsReady', function () {
                  var t = document.querySelector('#scope');
                  /*
                  var ajaxRequest = t.$.dataAjax;
                  var dialog;
                  for (dialog = 1; dialog <= tims; dialog++) {
                      var p = document.querySelector('#timePicker_' + dialog);
                      console.log(p);
                      var dt = moment(p.getAttribute("time"), ["h:mm A"]).format("HH:mm");
                      //var dt = moment("11:00 PM", ["h:mm A"]).format("HH:mm");
                      //alert(dt);
                      scope["time_" + dialog] = dt;
                  }
                  */
                  // make the iron-ajax call
                  t.postData_bool = function (a) {
                      document.getElementById("overlay").style.display = 'block';
                      var normalizedEvent = Polymer.dom(a);
                      var label = normalizedEvent.localTarget.getAttribute("label");
                      var val = normalizedEvent.localTarget.checked;

                      //ajaxRequest.body = {label: val}
                      //ajaxRequest.url = "Gestor_config.php?a=set_value&b=" + label + "&c=" + val
                      //ajaxRequest.generateRequest();
                      var url = "Gestor_config.php?a=set_value&b=" + label + "&jq=1&c=" + val
                      //ajaxRequest.generateRequest();
                      $("#popup").html(url+"...");
                      $.post(url,respostaAjax);
                  }

                  t.postData_input = function (a) {
                      document.getElementById("overlay").style.display = 'block';
                      var normalizedEvent = Polymer.dom(a);
                      var label = normalizedEvent.localTarget.getAttribute("label");
                      var val = normalizedEvent.localTarget.value;

                      //ajaxRequest.body = {label: val}
                      //ajaxRequest.url = "Gestor_config.php?a=set_value&b=" + label + "&c=" + val
                      //ajaxRequest.generateRequest();
                      var url = "Gestor_config.php?a=set_value&b=" + label + "&jq=1&c=" + val
                      //ajaxRequest.generateRequest();
                      $("#popup").html(url+"...");
                      $.post(url,respostaAjax);                 
                  }

                  t.postData_time = function (a) {
                      document.getElementById("overlay").style.display = 'block';
                      var p = document.querySelector('#timePicker_' + dialog);
                      var dt = moment(p.time, ["h:mm A"]).format("HH:mm");

                      //var t = document.querySelector('time_'+dialog);
                      scope["time_" + dialog] = dt;

                      // var normalizedEvent = Polymer.dom(a);
                      var label = p.getAttribute("label");
                      var val = p.time;
                      //ajaxRequest.body = {label: val}
                      //ajaxRequest.url = "Gestor_config.php?a=set_value&b=" + label + "&c=" + val
                      //ajaxRequest.generateRequest();
                      var url = "Gestor_config.php?a=set_value&b=" + label + "&jq=1&c=" + val
                      //ajaxRequest.generateRequest();
                      $("#popup").html(url+"...");
                      $.post(url,respostaAjax);                  
                  }
                  //callback on request complete
                  /*
                  t.postComplete = function () {
                      document.getElementById("overlay").style.display = 'none';
                      // alert('whoa! request complete');
                  }
                  */
              });
          })(document);


          function respostaAjax(dades){
            $("#popup").html(dades);
            document.getElementById("overlay").style.display = 'none';
          }
        </script>

        
        <div id="popup" style="display:none;clear:both">Comunicació AJAX<br><br></div>
    </body>
</html>