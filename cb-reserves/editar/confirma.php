<?php
if (!defined('ROOT'))
  define('ROOT', "../taules/");
require_once(ROOT . "Gestor.php");
require_once(ROOT . "gestor_reserves.php");


require_once(ROOT . INC_FILE_PATH . 'alex.inc');

require(ROOT . DB_CONNECTION_FILE);
require_once(ROOT . INC_FILE_PATH . 'valors.php');
require_once('mailer.php');
//   error_reporting(E_ALL); 
$ltxt[0]['cat'] = "Gràcies un cop haguem comprovat el pagament, la reserva serà vàlida";
$ltxt[0]['esp'] = "Gracias, una vez comprovado el pago, la reserva será válida";
$ltxt[0]['en'] = "Thank you, once the payment is confirmed, the reservation will be vàlid";

$ltxt[1]['esp'] = "NO OLVIDE LLEVAR EL JUSTIFICANTE DEL INGRESO PARA QUE LE DESCONTEMOS EL IMPORTE ABONADO POR LA RESERVA CUANDO PASE POR CAJA EN EL RESTAURANTE";
$ltxt[1]['cat'] = "NO OBLIDI PORTAR EL JUSTIFICANT DE L'INGRÈS PER TAL QUE LI DESCOMPTEM L'IMPORT ABONAT PER LA RESERVA QUAN PASSI PER CAIXA AL RESTAURANT";
$ltxt[1]['en'] = "DO NOT FORGET TO BRING THE PAYMENT RECEIPT SO THE RESERVATION PAYMENT CAN BE REFUNDED WHEN PAYING IN THE RESTAURANT";

$ltxt[2]['cat'] = "Si us plau, indiqui la referència del pagament que <b>ja ha realitzat</b> per tal que podem validar la seva reserva.<br/><br/> El número que ens ha d'indicar aquí és la REFERÈNCIA DE L'OPERACIÓ que el banc assigna a la transferència que ha realitzat. Acostuma a ser de 12 o 14 dígits.<br/><br/><b>No és el número de reserva que li va donar el restaraurant</b>. El facilita el banc en realitzar el pagament i és l'identificador que ens permet localitzar l'ingrès que ha realitzat<br/><br/>La imatge inferior és <b>un exemple</b> de com localitzar-lo";
$ltxt[2]['esp'] = "Por favor, indique la referencia del pago que <b>ya ha realizado</b> para que podamos validar su reserva.<br/><br/> El número que debe indicar aquí es el número de REFERENCIA DE LA OPERACIÓN que el banco asigna a la transferencia que ha realizado. Acostumbra a ser de 12 o 14 dígitos.<br/><br/><b>No es el número de reserva que le dió el restaraurant</b>. Lo facilita el banco al realizar el pago y es el identificador que nos permite localizar el ingreso que ha realizado<br/><br/>La imagen inferior es <b>un ejemplo</b> de como localizarlo";
$ltxt[2]['en'] = "Please, show the  reference of the payment that  <b>has been made<b>so we can validate your reservation.<br/><br/> The number that should be shown here is the TRANSACTION REFERENCE number which the bank assigns to the transfer that has been made. It is usually 12 or 14 didgits.<br/><br/><b>This is not the reservation number given by the restaurant</b>. The bank gives it when the payment is made and it enables us  to find the transaction that you have made<br/><br/<The image below is<b>an example</b> of how to find it";


$ltxt[3]['cat'] = "Indiqui aquí la referència del pagament";
$ltxt[3]['esp'] = "Indique aquí la referencia del pago";
$ltxt[3]['en'] = "Show payment reference here";

$ltxt[4]['cat'] = "Confirmar pagament";
$ltxt[4]['esp'] = "Confirmar pago";
$ltxt[4]['en'] = "Confirm payment";

$ltxt[5]['cat'] = "NO SE HA ENCONTRADO LA RESERVA SOLICITADA";
$ltxt[5]['esp'] = "NO S'HA TROBAT  LA RESERVA SOL·LICITADA";
$ltxt[5]['en'] = "RESERVATION NOT FOUND";

$ltxt[6]['cat'] = "ESTA RESERVA YA CONSTA COMO PAGADA CON TARJETA DE CREDITO. <b>NO NECESITA CONFIRMAR EL PAGO</b>.<br/><br/>SI NO HA RECIBIDO UNA NOTIFICACIÓN DEL RESTAURANTE CONFIRMANDOLE LA RECEPCIÓN DEL PAGO CONTACTE CON NOSOTROS";
$ltxt[6]['esp'] = "ESTA RESERVA YA CONSTA COMO PAGADA CON TARJETA DE CREDITO. <b>NO NECESITA CONFIRMAR EL PAGO</b>.<br/><br/>SI NO HA RECIBIDO UNA NOTIFICACIÓN DEL RESTAURANTE CONFIRMANDOLE LA RECEPCIÓN DEL PAGO CONTACTE CON NOSOTROS";
$ltxt[6]['en'] = "THIS RESERVATION IS ALREADY REGISTERED AS PAYD<b>YOU DO NOT NEED TO CONFIRM IT</b>.<br/><br/>IF YOU HAVE'NT RECEIVED A CONFIRMATION EMAIL, CONTACT US";


$ltxt[7]['cat'] = "LA RESERVA QUE INTENTA VALIDAR COMO PAGADA POR TRANSFERENCIA NO CONSTA COMO CONFIRMADA. PUEDE HABER CADUCADO, O ESTAR PENDIENTE DE CONFIRMACION. <br/><br/>POR FAVOR, CONTACTE CON EL RESTAURANTE";
$ltxt[7]['esp'] = "LA RESERVA QUE INTENTA VALIDAR COMO PAGADA POR TRANSFERENCIA NO CONSTA COMO CONFIRMADA. PUEDE HABER CADUCADO, O ESTAR PENDIENTE DE CONFIRMACION. <br/><br/>POR FAVOR, CONTACTE CON EL RESTAURANTE";
$ltxt[7]['en'] = "THIS RESERVATION IS NOT CONFIRMED. IT COULD BE EXPIRED, OR WAITING FER CONFIRMATIONBY DE RESTAURANT.<br/><br/>PLEASE, CONTACT THE RESTAURANT";

$ltxt[8]['cat'] = "CONFIRMACIÓ REPETIDA O NULA";
$ltxt[8]['esp'] = "CONFIRMACIÓ REPETIDA O NULA";
$ltxt[8]['en'] = "CONFIRMATION IS REPEATED OR NULL";


$id = intval(substr($_GET['id'], 5, 5));
/* * *************************************************************************** */

$query = "SELECT * FROM reserves WHERE id_reserva=" . $id;
$result = mysqli_query($canborrell, $query);
$rou = mysqli_fetch_array($result);
$lang = $rou['lang'];
$resposta = $rou['resposta'];
if (!$rou) {
  echo '<meta http-equiv="Refresh" content="7;URL=../index.html" />';
  die($ltxt[5][$lang] );
  exit();
}
if ($rou["estat"] == 7) {
  echo '<meta http-equiv="Refresh" content="10;URL=../index.html" />';
  die($ltxt[6][$lang] );
  exit();
}

if ($rou["estat"] != 2) {
  echo '<meta http-equiv="Refresh" content="7;URL=../index.html" />';
  die($ltxt[7][$lang] );
  exit();
}

if (($_POST['nref'] == "confirma") && ($_POST['referencia'] != "")) {

  //echo "<DIV align=center><br><br>".$ltxt[0][$lang]."</DIV>";


  $resposta.="<br><br>PAGADA PER TRANSFERENCIA. REF:" . $_POST['referencia'];
  /*   * *************************************************************************** */
  $query = "UPDATE reserves SET num_2=999, resposta='$resposta' WHERE id_reserva=" . $id;
  $result = mysqli_query($canborrell, $query);
  print_log("Transferència confirmada pel client: $id");


  mail_restaurant($id);
  echo '<meta http-equiv="Refresh" content="7;URL=../index.html" />';
  die("<DIV align=center><br><br>" . $ltxt[0][$lang] . "</DIV>");
  print_log("Transferència confirmada pel client: $id");
  //mysql_free_result($result);	
  //echo("2");	


  die("<DIV align=center><br><br>" . $ltxt[0][$lang] . "</DIV>");
}
else {
  $query = "SELECT * FROM reserves WHERE id_reserva=" . $id . " AND num_2=999";
  $result = mysqli_query($canborrell, $query);
  $repe = mysqli_num_rows($result);
  $rou = mysqli_fetch_array($result);

  if ($repe) {
    // COMPROVA QUE NO ESTIGUI JA CONFIRMADA
    echo '<meta http-equiv="Refresh" content="5;URL=../index.html" />';
    die("<br><br>($ltxt[8][$lang] )");
    exit();
  }
}

///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
///////////////////////////////////////////////////////
function mail_restaurant($id = false) {
  global $lang, $mmenu, $txt, $database_canborrell, $canborrell;
  //session_start();

  if ($id) {
    $query = "SELECT * FROM reserves WHERE id_reserva=$id";
  }
  else {
    $query = "SELECT * FROM reserves ORDER BY id_reserva DESC Limit 1";
  }

  /*   * *************************************************************************** */

  /*   * *************************************************************************** */
  $Result = mysqli_query($canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $fila = mysqli_fetch_assoc($Result);

  $avui = date("d/m/Y");
  $ara = date("H:i");
  $file = "templates/transfer_rest.lbi";


  $t = new Template('.', 'comment');
  $t->set_file("page", $file);

  ///////////// TEXTES
  			$t->set_var('self',$file);

  $t->set_var('avui', $avui);
  $t->set_var('titol', "RESERVA CANCELADA PEL PROPI CLIENT");
  $t->set_var('text1', $txt[11][$lang]);
  $t->set_var('text2', $txt[12][$lang]);
  $t->set_var('contacti', $txt[22][$lang]);

  $t->set_var('cdata_reserva', $camps[8][$lang]);
  $t->set_var('cnom', $camps[1][$lang]);
  $t->set_var('cadulst', $camps[2][$lang]);
  $t->set_var('cnens10_14', $camps[3][$lang]);
  $t->set_var('cnens4_9', $camps[4][$lang]);
  $t->set_var('ccotxets', $camps[5][$lang]);
  $t->set_var('cobservacions', $camps[6][$lang]);
  $t->set_var('cpreu_reserva', $camps[7][$lang]);



  //////////// DADES RESERVA
  $dat_cat = data_llarga($fila['data']);


  $t->set_var('referencia', $_POST['referencia']);
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
  $gestor = new gestor_reserves();
  $comanda = $gestor->plats_comanda($fila['id_reserva']);
  if ($comanda)
    $n = $comanda;
  else
    $n = $mmenu[$m]['cat'];

  $t->set_var('menu', $n);
  $t->set_var('adults', (int) $fila['adults']);
  $t->set_var('nens10_14', (int) $fila['nens10_14']);
  $t->set_var('nens4_9', (int) $fila['nens4_9']);
  //$t->set_var('txt_1'," menú: ".$fila['txt_1']);
  //$t->set_var('txt_2'," menú: ".$fila['txt_2']);
  $t->set_var('txt_1', "");
  $t->set_var('txt_2', "");
  $t->set_var('cresposta', $txt[79]['cat']);
  $t->set_var('resposta', $fila['resposta']);
  $t->set_var('cotxets', (int) $fila['cotxets']);
  $t->set_var('observacions', $fila['observacions']);
  $t->set_var('preu_reserva', $fila['preu_reserva']);

  $t->parse("OUT", "page");
  $html = $t->get("OUT");

  //////// SORTIDA PER PANTALLA
  //$t->p("OUT");
  ///////////////////////////

  $recipient = MAIL_RESTAURANT;
  $subject = "Can-Borrell: RESERVA " . $fila['id_reserva'] . " PAGADA PER TRANSFERENCIA. REF: " . $_POST['referencia'];
  $r = mailer_reserva($fila['id_reserva'], "Confirmada Grups", $recipient, $subject, $html, $altbdy);

  $nreserva = $fila['id_reserva'];
  print_log("Enviament mail($r): $nreserva -- $recipient, $subject");

  ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
  return ($fila['id_reserva']);
}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="//www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Confirmación de reserva</title>
        <link href="css/estils.css" rel="stylesheet" type="text/css" />
        <style type="text/css">
            <!--
            .Estilo2 {color: #570600; font-size: 14px; }
            .caixa{
                margin:auto;
                background-color:#FFFFFF;
                border:thin solid #660000;
                padding:15px;
                margin-bottom: 30px;	

            }

            .center{
                top:50%; 
                left:50%;

                width:600px;
                position:absolute; 
                margin-top:-280px;	
                margin-left:-300px;	

            }
            -->
        </style>


    </head>

    <body>
        <table width="775" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#f8f8f0">
            <tbody><tr>
                    <td background="../img/fons_9a.jpg" align="right" colspan="2"><a href="../index.htm"><img height="114" border="0" width="303" title="INICI" src="../img/lg_sup.gif"/></a></td>
                </tr>
                <tr height="700" bgcolor="#FFFFFF">
                    <td>
                    </td>
                </tr>
            </tbody>
        </table>
        <div  class="center">
            <div align="center">
                <div  class="caixa">
                    <form id="form1" name="form1" method="post" action="">
                        <p class="Estilo2"><?php echo $ltxt[2][$lang]; ?></p>
                        <p class="Estilo2"><img src="../img/referenciaop.jpg" alt="Referencia Operaci&oacute;n" width="400"  longdesc="Referencia Operaci&oacute;n" /></p>
                        <p class="Estilo2">&nbsp;</p>
                        <hr />
                        <p class="Estilo2" ><span class="Estilo2" style="color:#990000;border:thin"><?php echo $ltxt[3][$lang]; ?>:</span>  
                            <input name="referencia" type="text" size="20" style="width:100px"  />
                        </p>
                        <p>
                            <input name="Submit" type="submit" class="bt"  value="<?php echo $ltxt[4][$lang]; ?>" style="width:150px" /><input name="nref" type="hidden" value="confirma" />
                        </p>
                        <p><br/>
                        </p>
                    </form>
                </div>
                <strong><?php echo $ltxt[1][$lang]; ?></strong></div>
        </div>

    </body>
</html>


