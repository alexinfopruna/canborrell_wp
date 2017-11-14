<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('ROOT') or define('ROOT', '../taules/');


require_once(ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();
if (!$gestor->valida_sessio(64)) {
  header("Location: login.php");
  die();
}

if (!defined('LLISTA_NITS_NEGRA'))  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_DIES_BLANCA'))  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
$LLISTA_DIES_NEGRA = LLISTA_DIES_NEGRA;

if (isset($_GET['f'])) $LLISTA_DIES_NEGRA = $_GET['f'];


require_once(ROOT . INC_FILE_PATH . "llista_dies_taules.php");
require_once(ROOT . '../reservar/translate_ca.php');

$data=isset($_GET['data'])?$_GET['data']:date("d-m-Y");
$d= date_parse_from_format ("d-m-Y", $data );
$mydata=$d['year'].'-'.$d['month'].'-'.$d['day'];

function read_llista($file, $class){
  
  $handle = fopen($file, "r");
if ($handle) {
    while (($line = fgets($handle)) !== false) {
        // process the line read.
      
      $blanca.= '<li class="fila '.$class.'">'. $line.'</li>';
    }

    fclose($handle);
} else {
  die ("FILE ERROR: ".$file);
    // error opening the file.
} 
  return $blanca;
}

$path_parts = pathinfo($LLISTA_DIES_NEGRA);
$filename = $path_parts['filename'];
$info="";


 $info="ELS DIES MARCATS AL CALENDARI AFECTEN A TOTS ELS CALENDARIS DEL SISTEMA:
   <ul>
   <li>Calendari del control taules</li>
   <li>Calendaris reserves online petites i grups</li>
   <li>Calendari de nits obert</li>
   </ul>";
 
 $path_parts = pathinfo(LLISTA_DIES_BLANCA);
$filenameb = $path_parts['filename'];
$info=""
 
?><!DOCTYPE HTML>
<html>
    <head>
        <title>Gestó calendari</title>
           <link rel="stylesheet" href="/wp-content/plugins/magee-shortcodes/assets/bootstrap/css/bootstrap.min.css"> 
        <link type="text/css" href="/cb-reserves/taules/css/blitzer/jquery-ui-1.8.9.forms.css" rel="stylesheet" />	
        <?php echo Gestor::loadJQuery(); ?>
        <script type="text/javascript" src="/cb-reserves/taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
        <script type="text/javascript" src="/cb-reserves/taules/js/jquery.metadata.js"></script>
        <script type="text/javascript" src="/cb-reserves/taules/js/jquery.validate.min.js"></script>
        <!--   -->
        <style>
            html, body{margin:10px;}
            .content{display:flex;justify-content: center;}
          .ui-state-default, .ui-widget-content .ui-state-default{font-size: 2em;}
          .ui-datepicker{width: 30em;}
          .descans .ui-state-default{background: lightgray}
          .tancat .ui-state-default{background: tomato;color:white;}
          .obert .ui-state-default{background: #43a047;color:white;}
          .normal a{}
          .ui-datepicker td.ui-datepicker-current-day{border:solid 3px #444}
          
          ul{border:solid 1px #666;padding:15px;margin:15px;}
          li{padding:5px;list-style-type: none;margin:1px;color:white;text-align: right}
          li.blanca{background:#43a047}
          li.negra{background-color: tomato}
          
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
}

        </style>


    </head>
    <body style="">
        <h1>Control de dies obert / tancat</h1>
            <!--<div>
                Llista negra: <?php echo $LLISTA_DIES_NEGRA ?><br>
        Llista blanca: <?php echo LLISTA_DIES_BLANCA ?>

        </div>-->
        
        <h3 class="alert alert-warning"><?php echo $info ?></h3>
        <div class="alert alert-info">
        <p>Fent click els dies canvies d'estat normal > obert > tancat</p>
        <p><b>Cal marcar TOTS els dies festius com a obert (encara queno sigui DL o DM) per tal que s'apliquin les restriccions!!</b><p>
            </div>
        <div class="content">
            <div class="overlay" style="display:none">
    
  </div>
        <div id="calendari" class=" ui-corner-all fr-seccio-dia"></div>
        
            <div>
              
                    <ul id="llista_blanca">
                          <?php echo $filenameb ?>
                  <?php echo read_llista(LLISTA_DIES_BLANCA, "blanca");?>
                </ul>
        </div>
        
                    <div>
                        
                    <ul id="llista-negra">
                        <?php echo $filename ?>
                  <?php echo read_llista($LLISTA_DIES_NEGRA, "negra");?>
                </ul>
        </div>
</div>
    
    <script>
      
<?php 
                            $llista_negra=llegir_dies($LLISTA_DIES_NEGRA);
                            $llista_blanca=llegir_dies(LLISTA_DIES_BLANCA);
                            print crea_llista_js($llista_negra,"LLISTA_NEGRA"); 
                            print "\n\n";	
                            print crea_llista_js($llista_blanca,"LLISTA_BLANCA");  	
?>      
      var DATA=new Date("<?php echo $mydata ?>");
      var FNEGRE="<?php echo $LLISTA_DIES_NEGRA ?>";
      var FBLANC="<?php echo LLISTA_DIES_BLANCA ?>";
              
      $(function () {
          monta_calendari("#calendari");
      });


      /********************************************************************************************************************
       MONTA CALENDARI
       */

      function monta_calendari(selector)
      {
          var defData = DATA;

          $(selector).datepicker("destroy");
          $(selector).datepicker({
              beforeShowDay: function (date, inst) {
                  var r = new Array(3);

                  if (llistanegra(date))
                  {
                      r[0] = true;
                      r[1] = "tancat";
                      r[2] = l("Tancat");
                  }
                  else if (llistablanca(date)) 
                  {
                      r[0] = true;
                      r[1] = "obert";
                      r[2] = l("Obert excepcional");
                  }
                  else if ((date.getDay() == 1 || date.getDay() == 2  ))
                  {
                      r[0] = true;
                      r[1] = "descans";
                      r[2] = l("Descans setmanal");
                  }


                  else{
                      r[0] = true;
                      r[1] = "normal";
                      r[2] = l("Reservar");

                  }
                  return r;
              },
                 onSelect: function(dateText, inst) {
        //var date = $(this).val();
        var dades={data:dateText,accio:"block"}
        
        var accio="normal";
        if ($(".ui-datepicker-current-day").hasClass('obert')) accio="tancat";
        if ($(".ui-datepicker-current-day").hasClass('normal')) accio="obert";
        //accio="obert";
        DATA=dateText;
        desti="../taules/Gestor_calendari.php?a=click&b="+DATA+"&c="+accio+"&f="+FNEGRE+"&fblanc="+FBLANC;
        
        $.post(desti,dades,callback);
    },
              defaultDate: defData,
              minDate: 1
          });

//CARREGA IDIOMA
          var lng = lang.substring(0, 2);
          $(selector).datepicker("option",
                  $.datepicker.regional[ lng ]);

              $('.ui-datepicker-calendar .ui-state-active').removeClass('ui-state-active');
              $('.ui-datepicker-calendar .ui-state-hover').removeClass('ui-state-hover');
          


          /* BLOQUEJA EL DIA SI ESEM EDITANT LA RESERVA PER IMPEDIR QUE ES MODIFIQUI */
          if (typeof BLOQ_DATA !== 'undefined') {
              $(selector).datepicker("option", "minDate", BLOQ_DATA);
              $(selector).datepicker("option", "maxDate", BLOQ_DATA);
          }


      }


      var callback = function(dades){
        $(".overlay").show();
       window.location.href="gestio_calendari.php?data="+DATA+"&f="+FNEGRE+"&fblanc="+FBLANC;
      }

      function llistanegra(date)
      {
//return false;
          var y = date.getFullYear();
          var m = date.getMonth();     // integer, 0..11
          var d = date.getDate();      // integer, 1..31

          var t = LLISTA_NEGRA[m];

          if (!t)
              return false;
          for (var i in t)
              if (t[i] == d)
                  return true;

          return false;
      }

      /********************************************************************************************************************/
      function llistablanca(date)
      {
          var y = date.getFullYear();
          var m = date.getMonth();     // integer, 0..11
          var d = date.getDate();      // integer, 1..31

          var t = LLISTA_BLANCA[m];

          if (!t)
              return false;
          for (var i in t)
              if (t[i] == d)
                  return true;


          return false;
      }

      /********************************************************************************************************************/

    </script>
    </body>
</html>