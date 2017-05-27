<?php
if (!defined('ROOT'))
  define('ROOT', "../../taules/");
require (ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();

if (!$gestor->valida_sessio(64)) {
  header("Location: ../login.php");
  die();
}

if ($_REQUEST['a'] == "envia"){
  
  
  echo "ENVIANT...<br><br>";
  $idr = $_REQUEST['b'];
  $plantilla = $_REQUEST['c'];
  $destinatari = $_REQUEST['d'];
  
  $extres['subject'] = "PROVES TEST MAIL";
  $extres['subject'] = $this->l("Can-Borrell: CONFIRMACIÓ PAGA I SENYAL", FALSE)." ".$idr;
  echo $gestor->enviaMail($idr, $plantilla, $destinatari, $extres);
}

/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */



/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
/* * *********************************************************************************************************************** */
?><!DOCTYPE HTML>
<html>
    <head>
        <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <title> Test mail </title>


        <style>
            body{display: flex;justify-content:center;}

            table{width:100%;}
            table td{
                //text-align:right;
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
        </style>
    </head>
    <body>
        <div>
           
            <a href="test_mail.php?a=test&b=0000&c=alexzencode@gmail.com&d=../reservar/confirmada_&lang=en"> test_mail.php?a=envia&b=0000&c=../reservar/confirmada_&d=alexzencode@gmail.com&lang=en</a>
            <br><br>
            ../reservar/confirmada_
            <br>
            ../taules/confirmada_
            <br>
            ../reservar/cancelada_
            <br>
            ../taules/cancelada_
            <br>
            ../reservar/paga_i_senyal_
            <br>
            
        </div>
        
        <?php
    echo $gestor->getLanguage();
        echo"<pre>";
        var_dump($_REQUEST);
        echo"</pre>";
        
?>

    </body>
</html>