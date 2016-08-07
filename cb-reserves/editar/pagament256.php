<?php
$r = null;
$surt = false;

// RESET ESTA (testTPV)
if (isset($_REQUEST['reset_estat']) && $_REQUEST['reset_estat'] == 'reset_estat') {
  $id_reserva = isset($_REQUEST['pidr']) ? $_REQUEST['pidr'] : '****';
  $idr = substr($id_reserva,-4);
  $dest = 'http://' . $_SERVER['HTTP_HOST'] . "/reservar/Gestor_form.php?a=reset_estat&b=$idr&c=reserves";
  header("Location: $dest ");
}


if (!defined('ROOT'))
  define('ROOT', "../taules/");
require_once(ROOT . "Gestor.php");
require_once(ROOT . "gestor_reserves.php");

require(ROOT . DB_CONNECTION_FILE);
require_once(INC_FILE_PATH . 'valors.php');
require_once(INC_FILE_PATH . 'alex.inc'); //valida_admin('editar.php') ;
$titol['cat'] = "PAGAMENT DE RESERVA";
$titol['esp'] = "PAGO DE RESERVA";
$titol['en'] = "PAYMENT OF RESERVATION";
$subtitol['cat'] = "Dades de la reserva";
$subtitol['esp'] = "Datos de la reserva";
$subtitol['esp'] = "Reservation Information";

if (!isset($_GET["id"])) {
  $surt = true;
}
else {
  $id = $_GET["id"];
}


/* * *************************************************************************** */
$gestor = new gestor_reserves();
/* * *************************************************************************** */
$gestor->xgreg_log("PÀGINA PAGAMENT GRUPS: <span class='idr'>$id</span>");
//CADUCADES
$query_reserves = "UPDATE reserves SET estat=6 WHERE ADDDATE(data_limit,INTERVAL 1 DAY) < NOW() AND data_limit>'2008-01-01' AND estat=2";
$reserves = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if ($id)
  $query = "SELECT * FROM reserves WHERE id_reserva=$id";
$Result = mysqli_query($canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$fila = mysqli_fetch_assoc($Result);

$estat = $fila['estat'];
$import = $fila['preu_reserva'];
$nom = $fila['nom'];
$lang = $lang_cli = $fila['lang'];
if (!isset($lang))
  $lang = $lang_cli = "esp";

// comprovacions estat reserva
// ARREGLAR MISSATGES

if (($estat == 3) || ($estat == 7)) { // JA S?HA PAGAT 

  $titol['cat'] = "Aquesta reserva ja ha estat pagada<br><br><br><br><br><br>";
  $titol['esp'] = "Esta reserva ya ha sido pagada<br><br><br><br><br><br><br>";
  $titol['en'] = "This reservation has now been paid<br><br><br><br><br><br><br>";
  $surt = true;  
  $gestor->xgreg_log($titol['cat'],1);

}
else if ($estat != 2) {    // NO ESTA CONFIRMADA
  $titol['cat'] = "Lamentablement aquesta reserva no ha estat confirmada o ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Lamentablemente esta reserva no ha sido confirmada o ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
  $titol['en'] = "Unfortunately, this reservation has not been confirmed or has expired! Contact the restaurant<br><br><br><br><br><br><br><br>";
  $surt = true;
    $gestor->xgreg_log($titol['cat'],1);

}


// CADUCADA???
$d1 = cambiaf_a_normal($fila['data']);
$d2 = date("d/m/y");
$dif = compara_fechas($d1, $d2);
if ($dif < 0) {
  $titol['cat'] = "Aquesta reserva ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Esta reserva ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
  $titol['en'] = "This reservation has expired! Contact the restaurant<br><br><br><br><br><br><br><br>";
  $surt = true;
      $gestor->xgreg_log($titol['cat'],1);

  
}

// EXISTEIX???
if (mysqli_num_rows($Result) <= 0) {
  $titol['cat'] = "Ho sentim però aquesta reserva no apareix a la base de dades<br><br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Lo sentimos pero esta reserva no aparece en la base de datos<br><br><br><br><br><br><br><br><br>";
  $titol['en'] = "We’re sorry, but this reservation does not appear on our database<br><br><br><br><br><br><br><br><br>";
  $surt = true;
      $gestor->xgreg_log($titol['cat'],1);

}



((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Detall de reserva</title>
        <?php echo Gestor::loadJQuery("2.0.3"); ?>
        <link href="reserves.css" rel="stylesheet" type="text/css" />
        <link href="../css/estils.css" rel="stylesheet" type="text/css" />
        <?php
        $translate['COMPRA_SEGURA']['esp'] = "Para realizar el pago a través de esta pasarela bancaria, es necesario que hayas activado la tarjeta para COMPRA SEGURA A INTERNET en tu banco.\\n\\nCon esta activación te facilitarán un código de cuatro cifras que se requiere al final del proceso.\\n\\nDisculpa las moléstias";
        $translate['COMPRA_SEGURA']['cat'] = "Per poder realitzar el pagament a través d´aquesta passarel·la bancaria, cal que hagis activat la tarja per a COMPRA SEGURA A INTERNET al teu banc. \\n\\nAmb aquesta activació et facilitaran un codi de quatre xifres que és requerit al final del procès.\\n\\nDisculpa les molèsties";
        $translate['COMPRA_SEGURA']['en'] = "To make a payment using this bank gateway, you must activate the card for SECURE ONLINE PURCHASE in your bank.\\n\\nWith this activated you are given a code of four digits, needed to complete the process.\\n\\nSorry for the inconvenience";
        ?>
        <?php echo Gestor::loadJQuery(); ?>
        <script language=JavaScript>

          $(function () {
              $("#boto").click(function() {
                  alert("<?php echo $translate['COMPRA_SEGURA'][$lang] ?>");
                  document.getElementById('boto').style.display = 'none';
                  vent = window.open('', 'frame-tpv', 'width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
                  // vent.moveTo(eje_x,eje_y);
                  document.forms[0].submit();
              });
          });
        </script>
        <!-- ANULAT dynmenu.js -->

        <style>
            #boto{
                MARGIN: AUTO;
                DISPLAY: block;
            }

            input[type=text], .ds_input{display:none;}
        </style>
    </head>

    <body>
        <table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
            <tr>
                <td width="775" colspan="2" align="right" background="../img/fons_9a.jpg"><a href="../index"><img src="../img/lg_sup.gif" alt="img" width="303" height="114" border="0" title="INICI" /></a></td>
            </tr>
            <tr>
                <td bgcolor="#570600" colspan="2" align="center">
                    <?php if ($lang == "cat") { ?>	
                      <table cellpadding="0" cellspacing="0" width="761" height="18" border="0">
                          <tr>
                              <td><a href="index">CAN BORRELL</a> <img src="../img/separa_mn.gif" alt="g" width="1" height="8" border="0" /> <a href="fotos">FOTOS</a> <img src="../img/separa_mn.gif" alt="f" width="1" height="8" border="0" /> <a href="plats">PLATS</a> <img src="../img/separa_mn.gif" alt="e" width="1" height="8" border="0" /> <a href="on">COM ARRIBAR-HI</a> <img src="../img/separa_mn.gif" alt="d" width="1" height="8" border="0" /> <a href="excursions">EXCURSIONS</a> <img src="../img/separa_mn.gif" alt="c" width="1" height="8" border="0" /> <a href="historia">HIST&Ograve;RIA</a></td>
                              <td align="right"><a href="horaris">HORARIS</a> <img src="../img/separa_mn.gif" alt="b" width="1" height="8" border="0" /> <a href="reserves">RESERVES</a> <img src="../img/separa_mn.gif" alt="a" width="1" height="8" border="0" /> <font color="#FFFFFF"><b>CONTACTAR</b></font></td>
                          </tr>
                      </table>
                    <?php }
                    else {
                      ?>	
                      <table cellpadding="0" cellspacing="0" width="761" height="18" border="0">
                          <tr>
                              <td><a href="index">CAN BORRELL</a> <img src="../img/separa_mn.gif" alt="g" width="1" height="8" border="0" /> <a href="fotos">FOTOS</a> <img src="../img/separa_mn.gif" alt="f" width="1" height="8" border="0" /> <a href="plats">PLATOS</a> <img src="../img/separa_mn.gif" alt="e" width="1" height="8" border="0" /> <a href="on">COMO LLEGAR </a> <img src="../img/separa_mn.gif" alt="d" width="1" height="8" border="0" /> <a href="excursions">EXCURSIONES</a> <img src="../img/separa_mn.gif" alt="c" width="1" height="8" border="0" /> <a href="historia">HISTORIA</a></td>
                              <td align="right"><a href="horaris">HORARIOS</a> <img src="../img/separa_mn.gif" alt="b" width="1" height="8" border="0" /> <a href="reserves">RESERVAS</a> <img src="../img/separa_mn.gif" alt="a" width="1" height="8" border="0" /> <font color="#FFFFFF"><b>CONTACTAR</b></font></td>
                          </tr>
                      </table>

<?php } ?>	

                </td>
            </tr>
        </table>
        <table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center"><span class="titol"><?php echo $titol[$lang];
if ($surt && !isset($_REQUEST['testTPV']))
  exit();
?></span></td>
                <td width="12">  </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>  </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center"><?php echo $txt[40][$lang] ?>      </td>
                <td>  </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td align="center" class="estat">  
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><div align="center"><?php echo $txt[41][$lang] ?></div>    </td>
                <td align="center" class="estat">  </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" class="gran">&nbsp;</td>
                <td align="center" class="estat">  
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center" class="gran"><?php echo $subtitol[$lang] ?></td>
                <td align="center" class="estat">  </tr>
            <tr>
                <td width="12">&nbsp;</td>
                <td><table border="0" align="center" cellpadding="3" cellspacing="3">
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2">id_reserva</td>
                            <td width="320" align="right" bgcolor="#333333" class="llista"><div align="left" class="titol2"><?php echo $fila['id_reserva'];
echo $r;
?> </div></td>
                        </tr>

                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[8][$lang] ?></td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left" class="estat"><?php echo data_llarga($fila['data'], $lang); ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2">hora</td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left" class="estat"><?php echo substr($fila['hora'], 0, 5); ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[1][$lang] ?></td>
                            <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['nom']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2">tel</td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['tel']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2">fax</td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['fax']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2">email</td>
                            <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['email']; ?></div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2">menú</td>
                            <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php
///// COMANDA
                                    echo $comanda = $gestor->plats_comanda($fila['id_reserva']);
                                    ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[2][$lang] ?></td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int) $fila['adults']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[3][$lang]; ?></td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int) $fila['nens10_14']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[4][$lang]; ?></td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int) $fila['nens4_9']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[5][$lang]; ?></td>
                            <td width="320" align="right" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo (int) $fila['cotxets']; ?> </div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[6][$lang]; ?></td>
                            <td width="320" bgcolor="#CCCCCC" class="llista"><div align="left"><?php echo $fila['observacions']; ?></div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#660000" class="Estilo2">Respuesta</td>
                            <td width="320" bgcolor="#FFE6E1" class="llista"><div align="left"><?php echo $fila['resposta']; ?></div></td>
                        </tr>
                        <tr>
                            <td align="right" bgcolor="#333333" class="Estilo2"><?php echo $camps[7][$lang]; ?></td>
                            <td width="320" align="right" bgcolor="#999999" class="llista"><div align="left" class="estat">
                                    <div align="right" class="Estilo5"><?php echo $fila['preu_reserva']; ?> </div>
                                </div></td>
                        </tr>
                    </table></td>
                <td><p>&nbsp;</p>
                    <p>&nbsp;</p>
                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <?php
                    $id_reserva = ((int) $_GET["id"]) + 100000;
                    //$url_resposta = 'http://' . $_SERVER['HTTP_HOST'] . '/reservar/Gestor_form.php?a=respostaTPV_GRUPS_SHA256';
                    $responaseok_callback_alter = "reserva_grups_tpv_ok_callback";
                    $response = isset( $_GET["testTPV"])? $_GET["testTPV"]:-1;
                    
                    if (isset($_REQUEST["testTPV"]) &&  $_REQUEST["testTPV"] == 'testTPV') echo $gestor->generaTESTTpvSHA256($id_reserva, $import, $nom, $responaseok_callback_alter);
                    else echo $gestor->generaFormTpvSHA256($id_reserva, $import, $nom, $responaseok_callback_alter);
                    ?>  
                </td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><div align="center">
                        <p>&nbsp;</p>
                        <p><?php echo $txt[9][$lang] ?></p>
                    </div></td>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td></td>
                <td>&nbsp;</td>
            </tr>
        </table>
    </body>
</html>

