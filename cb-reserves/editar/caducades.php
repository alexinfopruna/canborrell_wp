<?php

if (!defined('ROOT'))  define('ROOT', "../taules/");
require(ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();
require(ROOT . "Gestor_pagaments.php");

$test = isset($_REQUEST['test']);
$sms_activat = !$test;

define('SMS_ACTIVAT', $sms_activat);

require(ROOT . DB_CONNECTION_FILE);
require_once(ROOT . INC_FILE_PATH . 'valors.php');
require_once(ROOT . INC_FILE_PATH . 'alex.inc');
include_once( "SMSphp/EsendexSendService.php" );

$mensaini = "";

echo "\n\n\n\n<br/>**********************************************************************************************<br/>";
echo "\n\n\n\n<br/><br/>" . date("D d-m-Y H:i:s") . " Execució  /home/hostings/webs/can-borrell.com/www/htdocs/cb-reserves/editar/caducades.php <br/><br/>";
echo "<br/><br/><br/>";


//enviaSMS("606782798", "12.01","2024-04-05","5421.02 ","cat");
//die("CADUCADESsss DIE");
?>
<?php

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

/* * *************************************************************************** */
// CADUCADES
include("sms_caducades.php");
echo "\n\n\n\n<br/>-------------------------------------------------------------------------------------------<br/>";

$mensaini = sms_caducades();
echo "\n\n\n\n<br/>-------------------------------------------------------------------------------------------<br/>";

$mensaini .= historic($canborrell);
echo "\n\n\n\n<br/>-------------------------------------------------------------------------------------------<br/>";

$mensaini .= recordatori($canborrell, 0);
$mensaini .= recordatori($canborrell, 1);
$mensaini .= recordatori($canborrell, 3);
echo "\n\n\n\n<br/>-------------------------------------------------------------------------------------------<br/>";

////$mensaini .= $gestor->recordatori_petites_3dies();

echo "<br/>-------------------------------------------------------------------------------------------<br/>";
if (!empty($mensaini)) {
  $f = fopen('mensaini.txt', 'w');
  fwrite($f, $mensaini);
  fclose($f);

  echo $mensaini;
}
else
  echo "No s'ha enviat cap recordatori";

function recordatori($canborrell, $dies) {
  $bodi = "<br><br> NO HI HA RESERVES PER RECORDATORI <br><br>";
  $ENVIAT = 1000 - $dies;
  $pagaments = new Gestor_pagaments();
  $sms="";
  $query_reserves = "SELECT * FROM reserves WHERE data_limit <= ADDDATE(CURDATE(), INTERVAL $dies DAY) AND data_limit >=CURDATE() AND data >=CURDATE()  AND (estat=2 OR estat=3 OR estat=7) AND data>=CURDATE() AND  (num_1<$ENVIAT OR num_1<=>NULL) AND  (num_2<>666 OR num_2<=>NULL)";
  //$query_reserves = "SELECT * FROM reserves WHERE data_limit <= ADDDATE(CURDATE(), INTERVAL $dies DAY) AND data_limit >=CURDATE() AND data >=CURDATE()  AND estat=2 AND data>=CURDATE() AND  (num_1<$ENVIAT OR num_1<=>NULL) AND  (num_2<>666 OR num_2<=>NULL)";
  //$query_reserves = "SELECT * FROM reserves WHERE data_limit <= ADDDATE(CURDATE(), INTERVAL $dies DAY) AND data_limit >=CURDATE() AND data >=CURDATE()  AND estat=2 AND data>=CURDATE() AND  (num_2<>666 OR num_2<=>NULL)";
  echo "<br/><br/>RECORDATORI<br/>";
  echo $query_reserves;
  echo "<br/><br/><br/>";
  $reserves = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $nr = mysqli_num_rows($reserves);

  if ($dies == 0)
    $sms = " PER MAIL I SMS ";
  $mensa = "\\n\\n\\nS´HAN ENVIAT ELS SEGÜENTS RECORDATORIS $sms(abans $dies dies):\\n\\n\\n";

  while ($row = mysqli_fetch_array($reserves)) {
    echo "\n\n\n\n<br>*************************************<br>";
    echo"";
    echo $row["id_reserva"] . " >> " . $row["data"] . "" . " (" . $row["estat"] . ") >>>>> " . $row['data_limit'] . "    num_1:" . $row['num_1'] . "    num_2:" . $row["num_2"];

    $estat = $pagaments->get_estat_multipago($row["id_reserva"]);
    if ($estat==100){
      echo "Multipago....";
       continue;
    }

    $plantilla = "templates/recordatori_cli.lbi";
    // if ($dies == 1)      $plantilla = "templates/recordatori_1dia_cli.lbi";
    mail_cli($row["id_reserva"], $plantilla);
    echo "\n\n\n\nRECORDATORI mail_cli({$row['tel']},{$row['preu_reserva']},$lafecha,{$row["id_reserva"]});";

    $mensa .= "ID Reserva: " . $row["id_reserva"] . " amb data límit per pagar: " . data_llarga($row['data_limit']) . " \\n";

    if ($dies <= 1) {
      preg_match("/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $row['data'], $mifecha);
      $lafecha = $mifecha[3] . "/" . $mifecha[2];

      print_log("RECORDATORI enviaSMS({$row['tel']},{$row['preu_reserva']},$lafecha,{$row["id_reserva"]});");
        enviaSMS($row['tel'], $row['preu_reserva'], $lafecha, $row["id_reserva"], $row["lang"]);
        echo "\n\n\n\nRECORDATORI enviaSMS({$row['tel']},{$row['preu_reserva']},$lafecha,{$row["id_reserva"]});";
        $mensa .= "SMS ENVIAT: " . $row['tel'] . " \\n";

    }

    $query_reserves = "UPDATE reserves SET num_1=$ENVIAT WHERE id_reserva=" . $row["id_reserva"];
    echo "<br/><br/>" . $query_reserves . "<br/><br/>";

    if (SMS_ACTIVAT)
      $update = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  }

  if ($nr > 0)
    $bodi = $mensa;

  return $bodi;
}

function historic($canborrell) {

  $bodi = "<br><br> NO HI HA RESERVES PER L'HISTORIC <br><br>";

  $query_reserves = "SELECT * FROM reserves WHERE CURDATE()>ADDDATE(data , 30) AND (num_2<>666 OR num_2<=>NULL)";
  $reserves = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $nr = mysqli_num_rows($reserves);

  echo "<br/><br/>HISTORIC<br/>";
  echo $query_reserves;
  echo "<br/><br/><br/>";

  $mensa = "LES SEGÜENTS RESERVES HAN PASSAT A L´HISTÒRIC PER PORTAR 30 DIES CADUCADES\\n\\n\\n";
  // echo "RESERVES ".$nr."   *********<br>";
  while ($row = mysqli_fetch_array($reserves)) {
    $mensa .= "ID Reserva: " . $row["id_reserva"] . " pel dia    " . data_llarga($row['data']) . " \\n";
  }

  if ($nr > 0)
    $bodi = $mensa;

  $query_reserves = "UPDATE reserves SET num_2=666 WHERE CURDATE()>ADDDATE(data , 30) AND (num_2<>666 OR num_2<=>NULL)";
  if (SMS_ACTIVAT)
    $reserves = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

  return $bodi;
  //exit();
}

function mail_cli($id = false, $plantilla = "templates/recordatori_cli.lbi") {
  require_once("mailer.php");
  global $camps, $mmenu, $txt, $database_canborrell, $canborrell, $lang, $gestor;

  if ($id) {
    $query = "SELECT * FROM reserves WHERE id_reserva=$id";
  }
  else {
    $query = "SELECT * FROM reserves ORDER BY id_reserva DESC Limit 1";
  }
  /*********************************************************************************************************************************/
  $Result = mysqli_query($canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $fila = mysqli_fetch_assoc($Result);
  $id = $fila['id_reserva'];
  $lang = $lang_cli = $fila['lang'];
  $v = 50;
  
  //print_r($fila);
  $b64 = base64_encode($fila["id_reserva"] . "&" . $fila['tel'] . "&" . $lang);
  $link = 'https://' . $_SERVER['HTTP_HOST'] . '/reservar/pagament?rid=' . $b64 . '&lang=' . $lang;
  $aki = "<a href='" . $link . "' class='dins'>AQUI</a>";
  $copia = "Recordatori de Reserva";
  $altbdy = "Su reserva para el Restaurante Can Borrel ha sido confirmada. \n\nDebido a que su cliente de correo no puede interpretar correctamente este mensaje no es posible automatizar el proceso de pago.\n\n Por favor, póngase en contacto con el restaurante llamando al 936 929 723 o al 936 910 605. \n\nDisculpe las molestias";



  $avui = date("d/m/Y");
  $ara = date("H:i");

  $file = getcwd()."/".$plantilla;

//  echo file_exists($plantilla)?"EXISTE":"NO EXISTE";
//  $file = $plantilla;

  $t = new Template('.', 'comment');
  echo file_exists($plantilla)?"EXISTE":"NO EXISTE";

  $t->set_file("page", $file);
  $dat_limit = data_llarga($fila['data_limit'], $lang);
  $dlim = "";
  $dlim = $dat_limit;
  
  echo " ----------<br>";
  echo " ----------<br>";
  echo " ----------<br>";
  echo $lang;
  echo "....";
  echo $aki;
  echo "....";
  echo $dat_limit;
  echo " ----------<br>";
  echo " ----------<br>";
  echo " ----------<br>";
   
  ///////////// TEXTES
  if ($v == 50) {
    $dlim = $dat_limit;
    $idd = $fila['id_reserva'] + 100000;
    $fila['import'] = "***********";
    $mulink = substr($fila['email'], 0, 2) . substr($fila['nom'], 0, 2) . $idd . "***" . substr($fila['import'], 0, 2);

    $t->set_var('data_limit', $dat_limit);
    $t->set_var('dat_limit', $dat_limit);
    $t->set_var('self', $file);
    $t->set_var('ident', $txt[75][$lang]);
    $t->set_var('confirma', $txt[76][$lang]);
    $t->set_var('cancela', $txt[77][$lang]);
    $t->set_var('id_banc', "RESERVA-" . $fila['id_reserva']);
    $t->set_var('confirlink', $mulink);
    $t->set_var('cancelink', $mulink);
  }

  $t->set_var('caducada', $txt[80][$lang]);
  $t->set_var('avui', $avui);
  $t->set_var('titol', $txt[$v][$lang]);
  $t->set_var('text1', $txt[$v + 1][$lang]);
  $t->set_var('text2', $txt[$v + 2][$lang]);
  $t->set_var('contacti', $txt[9][$lang]);
  $t->set_var('import', $preu = 0);
  $t->set_var('aki', $aki);
  $t->set_var('datat', $datat = 0);

  $t->set_var('cdata_reserva', $camps[8][$lang]);
  $t->set_var('cnom', $camps[1][$lang]);
  $t->set_var('cadults', $camps[2][$lang]);
  $t->set_var('cnens10_14', $camps[3][$lang]);
  $t->set_var('cnens4_9', $camps[4][$lang]);
  $t->set_var('ccotxets', $camps[5][$lang]);
  $t->set_var('cobservacions', $camps[6][$lang]);
  $t->set_var('cpreu_reserva', $camps[7][$lang]);
  //////////// DADES RESERVA
  $dat_cat = data_llarga($fila['data'], $lang);


  $t->set_var('id_reserva', $fila['id_reserva']);
  $t->set_var('data', $dat_cat);
  $t->set_var('hora', substr($fila['hora'], 0, 5));
  $t->set_var('nom', $fila['nom']);
  $t->set_var('tel', $fila['tel']);
  $t->set_var('fax', $fila['fax']);
  $t->set_var('email', $fila['email']);
  $m = (int) $fila['menu'];
  $n = $mmenu[$m]['cat'];


  ///// COMANDA
  //$gestor=new gestor_reserves();
  $comanda = $gestor->plats_comanda($fila['id_reserva']);
  if ($comanda)
    $n = $comanda;
  else
    $n = $mmenu[$m]['cat'];

  $t->set_var('menu', $n);
  $t->set_var('adults', (int) $fila['adults']);
  $t->set_var('nens10_14', (int) $fila['nens10_14']);
  $t->set_var('nens4_9', (int) $fila['nens4_9']);
  $t->set_var('txt_1', "");
  $t->set_var('txt_2', "");
  $t->set_var('cresposta', $txt[79][$lang]);
  $t->set_var('resposta', $fila['resposta']);
  $t->set_var('cotxets', (int) $fila['cotxets']);
  $t->set_var('observacions', $fila['observacions']);
  $t->set_var('preu_reserva', $fila['preu_reserva']);

  $t->parse("OUT", "page");
  $html = $t->get("OUT");
echo "<br><br><br>".$html."<br><br><br>";
  //$t->p("OUT");
  $recipient = $fila['email'];
  $subject = "..::Reserva Can Borrell: Recordatori reserva" . " " . $fila['id_reserva'];

  if (SMS_ACTIVAT)
    $r = mailer_reserva($id, $plantilla, $recipient, $subject, $html, $altbdy, null, false, MAIL_CCO);
  else {
    echo "<br/>";
    echo "<br/>";
    echo "MAIL RECORDATORI $id";
    echo "<br/>";
    echo $html;
    echo "<br/>";
    echo "<br/>";
    echo "<br/>";
  }
  $nreserva = $fila['id_reserva'];
  print_log("Enviament RECORDATORI($r): $nreserva -- $recipient, $subject: $copia");


  ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
  return ($fila['id_reserva']);
}

function enviaSMS($numMobil, $importReserva, $diaReserva, $idReserva, $lang) {
  global $txt;
  $mensa = $txt[92][$lang];

  echo "............$mensa.........";
  $mensa = str_replace("%diaReserva", $diaReserva, $mensa);
  $mensa = str_replace("%importReserva", $importReserva, $mensa);
  $mensa = str_replace("%idReserva", $idReserva, $mensa);

 // Test Variables - assign values accordingly:
  $essendex_user = $username = "restaurant@can-borrell.com";   // Your Username (normally an email address).
  $essendex_pwd = $password = "iridioArgon:17";   // Your Password.
  $accountReference = "EX0062561";  // Your Account Reference (either your virtual mobile number, or EX account number).
  $originator = "Rest.Can Borrell";  // An alias that the message appears to come from (alphanumeric characters only, and must be less than 11 characters).
  $recipients = $numMobil;  // The mobile number(s) to send the message to (comma-separated).
  $body = $mensa;   // The body of the message to send (must be less than 160 characters).
  $type = "Text";   // The type of the message in the body (e.g. Text, SmartMessage, Binary or Unicode).
  $validityPeriod = 0;  // The amount of time in hours until the message expires if it cannot be delivered.
  $result;   // The result of a service request.
  //$messageIDs = array($idReserva);		// A single or comma-separated list of sent message IDs.
  $messageStatus;   // The status of a sent message.

  $sendService = new EsendexSendService($username, $password, $accountReference);
  //echo $lang."   ---------------------- TEEEST: $body  ---------------------------<br>";
  //if (SMS_ACTIVAT && ENVIA_SMS)
    $result = $sendService->SendMessage($recipients, $body, $type);

echo $result?"S":"N";
  echo "<br/>";
  echo "<br/>";
  echo "SMS RECORDATORI $idReserva";
  echo "<br/>";
  echo $body;
  echo "<br/>";
  echo "<br/>";
  echo "<br/>";

  //print_log("ENVIAT SMS: $numMobil RESERVA $idReserva");
  //print_log("RESULTAT ENVIO: ".$result['Result']." / ".$result['MessageIDs']);
}

?>
