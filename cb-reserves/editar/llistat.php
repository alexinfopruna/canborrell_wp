<?php
//phpinfo();die();
//require_once("../taules/errorHandler.php"); // DEBUG, MOSTRAR ERRORS I NOTICES

/* * ************************************************ */
//
// CODIFICACIO ESTAT
//
// 1 PENDENT
// 2 CONFIRMADA
// 3 PAGAT TRANSF 
// 4 DENEGADA
// 5 ELIMINADA
// 6 CADUCADA
// 7 PAGAT TPV
// 100 RES.PETITA
/* * ************************************************ */
if (!defined('ROOT'))
  define('ROOT', "../taules/");
require(ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();
if (!$gestor->valida_sessio()) {
  header("Location: login.php");
  die();
}

require(ROOT . DB_CONNECTION_FILE);

require_once(ROOT . INC_FILE_PATH . 'valors.php');
require_once(ROOT . INC_FILE_PATH . 'alex.inc');
valida_admin('login.php');

$bodi = "";
$mensaini = "";
$were = "";
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

$maxRows_reserves = 30;
$pageNum_reserves = 0;
if (isset($_GET['pageNum_reserves'])) {
  $pageNum_reserves = $_GET['pageNum_reserves'];
}
$startRow_reserves = $pageNum_reserves * $maxRows_reserves;
/* * *************************************************************************** */

//echo $database_canborrell, $canborrell;
// ESBORRA SI SE TERCIA
if (!empty($_POST['pdel'])) {
  $aLista = array_keys($_POST['pdel']);

  $check = Gestor::log_array($aLista);
  Gestor::xgreg_log("<span class='grups'>ESBORRA RESERVES MULTIPLE CHECK: </span>", 0, '/log/logGRUPS.txt');
  Gestor::xgreg_log("$check", 1, '/log/logGRUPS.txt');

  $query = "DELETE FROM reserves where id_reserva IN (" . implode(',', $aLista) . ") AND estat=5";
  $result = mysqli_query($canborrell, $query);
  Gestor::xgreg_log("$query", 1, '/log/logGRUPS.txt');
  $query = "UPDATE reserves SET estat=5 where id_reserva IN (" . implode(',', $aLista) . ")";
  $result = mysqli_query($canborrell, $query);
  Gestor::xgreg_log("$query", 1, '/log/logGRUPS.txt');
}
// APLICA FILTRE
if ((!isset($_POST["opcio_filtre"])) && (isset($_COOKIE['codi_filtre']))) {
  $codi = $_COOKIE['codi_filtre'];
  if (substr($codi, 0, 1))
    $_POST["opcio_filtre"][1] = " OR estat=3 OR estat=7 ";
  if (substr($codi, 1, 1))
    $_POST["opcio_filtre"][2] = " OR estat=2 ";
  if (substr($codi, 2, 1))
    $_POST["opcio_filtre"][3] = " OR estat=1 ";
  if (substr($codi, 3, 1))
    $_POST["opcio_filtre"][4] = " OR estat=4 ";
  if (substr($codi, 4, 1))
    $_POST["opcio_filtre"][5] = " OR estat=6";
  if (substr($codi, 5, 1))
    $_POST["opcio_filtre"][6] = " OR estat=5 ";
}

$extra_alert = "";
if (isset($_POST["opcio_filtre"])) {
  for ($i = 1; $i < 7; $i++)
    if (!isset($_POST["opcio_filtre"][$i]))
      $_POST["opcio_filtre"][$i] = "";
  if ($_POST["opcio_filtre"][5])
    $were.="WHERE (estat=6 " . $_POST["opcio_filtre"][1] . $_POST["opcio_filtre"][2] . $_POST["opcio_filtre"][3] . $_POST["opcio_filtre"][4] . $_POST["opcio_filtre"][6] . ")";
  else
    $were.="WHERE (DATA>=NOW()) AND (FALSE " . $_POST["opcio_filtre"][1] . $_POST["opcio_filtre"][2] . $_POST["opcio_filtre"][3] . $_POST["opcio_filtre"][4] . $_POST["opcio_filtre"][6] . ")";

  $codi = $_POST["opcio_filtre"][1] ? "1" : "0";
  $codi.=$_POST["opcio_filtre"][2] ? "1" : "0";
  $codi.=$_POST["opcio_filtre"][3] ? "1" : "0";
  $codi.=$_POST["opcio_filtre"][4] ? "1" : "0";
  $codi.=$_POST["opcio_filtre"][5] ? "1" : "0";
  $codi.=$_POST["opcio_filtre"][6] ? "1" : "0";

  setcookie("codi_filtre", $codi, time() + (60 * 60 * 24 * 365));
}
else {
  $were = "WHERE TRUE ";
  $codi = "111111000";
}


$were.=" AND (num_2<>666 OR num_2<=>NULL) ";  //// AMAGA L'HISTORIC!!!!
//$were.=" AND (num_2<>666) ";  //// AMAGA L'HISTORIC!!!!

$query_reserves = "SELECT DISTINCT id_reserva, estat, data, hora, nom, tel, email, adults, nens4_9, nens10_14, preu_reserva , ADDDATE(data_limit,1) AS dlimit, (email.reserva_id IS NOT NULL ) AS emails FROM reserves ";
$join_mail = " LEFT JOIN email ON email.reserva_id = id_reserva  AND email_resultat>0 ";
//$join_sms = " LEFT JOIN sms ON sms.sms_reserva_id = id_reserva ";

$group_mail = "";// GROUP BY  email.reserva_id ";
//$group_sms = " GROUP BY  sms.sms_reserva_id  ";
//$join_mail ="";$group_mail="";
$order = "ORDER BY IF(data < NOW(),1,0), IF(estat = 1,0,1),IF(estat = 2,0,1), IF(estat = 3,0,1),IF(estat = 7,0,1),estat, data ";
//$order="ORDER BY estat, data ";
$query_reserves .=  $join_mail . $were  . $group_mail.  $order;
$query_limit_reserves = sprintf("%s LIMIT %d, %d", $query_reserves, $startRow_reserves, $maxRows_reserves);
//echo $query_limit_reserves;
$reserves = mysqli_query($canborrell, $query_limit_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$row_reserves = mysqli_fetch_assoc($reserves);

//foreach($row_reserves as $k=>$v) echo "$k > $v";

if (isset($_GET['totalRows_reserves'])) {
  $totalRows_reserves = $_GET['totalRows_reserves'];
}
else {
  $all_reserves = mysqli_query($GLOBALS["___mysqli_ston"], $query_reserves);
  $totalRows_reserves = mysqli_num_rows($all_reserves);
}
$totalPages_reserves = ceil($totalRows_reserves / $maxRows_reserves) - 1;

$f = fopen('mensaini.txt', 'r');
$mensaini = fread($f, 4096);
fclose($f);
$f = fopen('mensaini.txt', 'w');
fclose($f);


if ($mensaini != "")
  $bodi = 'onload="alert(\'' . $mensaini . '\')"';
else
  $bodi = "";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Gestió de reserves</title>
        <link href="reserves.css" rel="stylesheet" type="text/css" />
        <link href="../css/estils.css" rel="stylesheet" type="text/css" />
        <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

        <link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
        <?php echo Gestor::loadJQuery("2.0.3"); ?>
        <script>
          $(function () {
              $(".cerca").click(function (e) {
                  $(this).attr("href", $(this).attr("href") + $("#ipcerca").val());
                  return true;
              });

              var msg = getParameterByName('msg'); // "lorem"           
              if (msg == 1) {
                  $("#alerta").dialog({
                      modal: true,
                      autoOpen: true,
                      buttons: {
                          Ok: function () {
                              $(this).dialog("close");
                              window.location.href = "llistat.php";
                          }
                      }
                  });
                  
              }


          });


          function getParameterByName(name, url) {
              if (!url)
                  url = window.location.href;
              name = name.replace(/[\[\]]/g, "\\$&");
              var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
                      results = regex.exec(url);
              if (!results)
                  return null;
              if (!results[2])
                  return '';
              return decodeURIComponent(results[2].replace(/\+/g, " "));
          }
        </script>
        <style type="text/css">
            td a, td a:visited, td a:link {color:#ccc} 
            
            .llista.mail_no a:hover{padding-right:5px}
td a:hover {color:white} 
            .EXIT{color:green}
            .ERROR{color:RED}
            .mail_error{background:red}
            .mail_ok{background:green}
            .mail_no{background:#333}
 /*           
            .blink_me {
  animation: blinker2 1s linear infinite;
}

@keyframes blinker2 {  
  50% { opacity: 0.0; }
}

   */         
   @-webkit-keyframes blinker {
       from {opacity: 1.0;}
       to {opacity: 0.3;}
   }
   .blink{
       text-decoration: blink;
       -webkit-animation-name: blinker;
       -webkit-animation-duration: 0.6s;
       -webkit-animation-iteration-count:infinite;
       -webkit-animation-timing-function:ease-in-out;
       -webkit-animation-direction: alternate;
   }

   <!--
            .Estilo5 {
                color: #FFFFFF;
                font-weight: bold;
            }
            .Estilo6 {font-size: 16px}
            INPUT {
                font-family: verdana, arial, helvetica;
                font-size: 11px;
                font-weight: bold;
                color: #770000;
                border:1px Solid #999999;
                background-color: #FFFFFF;
            }
            .inputblanc {
                font-family: verdana, arial, helvetica;
                font-size: 11px;
                font-weight: bold;
                color: #770000;
                border:1px Solid #999999;
                background-color: #FFFFFF;
            }

            -->
        </style>
    </head>

    <body  <?php echo $bodi ?>>
        <table width="775" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F8F8F0">
            <tr>
                <td bgcolor="#570600" colspan="2" align="center"><table cellpadding="0" cellspacing="0" width="716" height="19" border="0">
                        <tr>
                            <td><span class="Estilo5">GESTI&Oacute; RESERVES</span>  
                                <img src="../img/separa_mn.gif" alt="1" width="1" height="8" border="0" />
                                <a href="gestio_dies.php"> GESTI&Oacute; DIES PLENS </a> 
                                <img src="../img/separa_mn.gif" alt="2" width="1" height="8" border="0" /> 
                                <font color="#FFFFFF"><b><a href="editar.php?id=-1">EDITAR PREUS I SUGGERIMENTS </a></b>
                                    <img src="../img/separa_mn.gif" alt="2" width="1" height="8" border="0" /> 
                                    <font color="#FFFFFF"><b><a href="llistat_historic.php">HISTÒRIC </a></b></font></font>
                            </td>

                            <td align="right">
                                <a href="llistat_proves.php">DEV </a>
                                <img src="../img/separa_mn.gif" alt="2" width="1" height="8" border="0" />

                                <a href="dumpBD.php">COPIA</a>
                                <img src="../img/separa_mn.gif" alt="1" width="1" height="8" border="0" />
                                <a href="../cat/index.html">CAN BORRELL</a></td>
                        </tr>
                    </table></td>
            </tr>
        </table>
        <form id="filtrat" name="form1" method="post" action="llistat.php">
            <table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                <tr>
                    <td><div align="right"></div></td>
                    <td>&nbsp;</td>
                </tr>
                <tr style="width:100%">
                    <td><div align="right">Pagades</div></td>
                    <td><input name="opcio_filtre[1]" type="checkbox" class="input_blanc" value="OR estat=3 OR estat=7 " <?php if (substr($codi, 0, 1)) echo 'checked="checked"' ?> /></td>
                    <td><div align="right">Confirmades</div></td>
                    <td><input name="opcio_filtre[2]" type="checkbox" class="input_blanc" value="OR estat=2 " <?php if (substr($codi, 1, 1)) echo 'checked="checked"' ?> /></td>
                    <td><div align="right">Pendents</div></td>
                    <td><input name="opcio_filtre[3]" type="checkbox" class="input_blanc" value="OR estat=1 " <?php if (substr($codi, 2, 1)) echo 'checked="checked"' ?> /></td>
                    <td><div align="right">Denegades</div></td>
                    <td><input name="opcio_filtre[4]" type="checkbox" class="input_blanc" value="OR estat=4 " <?php if (substr($codi, 3, 1)) echo 'checked="checked"' ?> /></td>
                    <td><div align="right">Caducades</div></td>
                    <td><input name="opcio_filtre[5]" type="checkbox" class="input_blanc" value="OR data&lt;now() " <?php if (substr($codi, 4, 1)) echo 'checked="checked"' ?> /></td>
                    <td><div align="right">Eliminades</div></td>
                    <td><input type="checkbox" name="opcio_filtre[6]" class="input_blanc" value="OR estat=5 " <?php if (substr($codi, 5, 1)) echo 'checked="checked"' ?>/></td>
                    <td>&nbsp;</td>
                    <td>                
                        <input type="submit" name="Submit2" value="Aplicar" />
                        <input type="hidden" name="codi_filtre2" value="<?php echo $codi; ?>" />
                    </td>
                    <td><label></label></td>
                </tr>
            </table>
        </form>

        <table width="773" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
            <tr>
                <td>&nbsp;</td>
            </tr>

            <tr>
                <td><div align="center">
                        <p align="center" class="titol2">Llistat de Reserves</p>
                    </div></td>
            </tr>

            <tr>
                <td>
                    <form id="form1" method="post"  action="llistat.php"  onsubmit="JavaScript: if (confirm('Segur que vols esborrar les reserves marcades?\nRecordi que les reserves amb estat Eliminada s´esborraran definitivament')) {
                              return true;
                          } else {
                              return false;
                          }">

                        <table width="773" border="0" align="center" cellpadding="3" cellspacing="3" bordercolor="#666666">
                            <tr>
                                <td width="60" align="center" bgcolor="#333333" class="Estilo2"><input id="ipcerca" name="cercaid" type="text" size="3" maxlength="5" style="height:15px;text-align:right;" />
                                    <a href="detall.php?id=" class="cerca" ><img src="img/lupa.gif" alt="Cerca" width="20" height="20" border="0" style="vertical-align:bottom" /></a> </td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">estat</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">data</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">hora</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">nom</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">Tel&egrave;fon</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">e-mail</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">adults + nens </div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">preu reserva</div></td>
                                <td bgcolor="#333333" class="Estilo2"><div align="center">Del</div></td>
                            </tr>
                            <?php
                            do {
                              $r = $row_reserves;
                              $d1 = cambiaf_a_normal($row_reserves['data']);
                              $d2 = date("d/m/y");
                              $dif = compara_fechas($d1, $d2);
                              $color_data = ($dif < 0) ? "#ff3333" : "#CCCCCC";
                              
                              $class_mail = 'mail_no';
                              if ($row_reserves['estat']==2 && $row_reserves['emails']==0) $class_mail = 'mail_error blink';
                              if ($row_reserves['estat']==2 && $row_reserves['emails']==1) $class_mail = 'mail_ok';
                              
                              ?>
                              <tr>
                                  <td align="center" bgcolor="#333333" class="llista <?php echo $class_mail; ?>"><div align="right"><a href="detall.php?id=<?php echo $row_reserves['id_reserva']; ?>">&nbsp;&nbsp;<?php echo $row_reserves['id_reserva'] ?>&nbsp;&nbsp;</a></div></td>
                                  <td align="center" bgcolor="<?php echo $color[(int) $row_reserves['estat']]; ?>" class="estat"><?php echo $estat[(int) $row_reserves['estat']]; ?></td>
                                  <td align="right" bgcolor="<?php echo $color_data; ?>" class="estat"><?php echo data_llarga($row_reserves['data']); ?></td>
                                  <td align="right" bgcolor="#CCCCCC" class="estat"><?php echo substr($row_reserves['hora'], 0, 5); ?></td>
                                  <td bgcolor="#CCCCCC" class="llista" ><?php echo substr($row_reserves['nom'], 0, 16); ?></td>
                                  <td bgcolor="#CCCCCC" class="llista" ><?php echo $row_reserves['tel']; ?></td>
                                  <td bgcolor="#CCCCCC" class="llista" ><a href="mailto: <?php echo $row_reserves['email']; ?>" class="llista"><?php echo $row_reserves['email']; ?></a></td>
                                  <td align="right" bgcolor="#CCCCCC" class="llista"><?php
                                      echo (int) $row_reserves['adults'] . " + ";
                                      echo ((int) $row_reserves['nens10_14']) + ((int) $row_reserves['nens4_9']);
                                      ?></td>
                                  <td align="right" bgcolor="#999999" class="llista"><span class="estat"><?php echo $row_reserves['preu_reserva'] . "€"; ?></span></td>
                                  <td align="right" bgcolor="#999999" class="llista">
                                  <!--<div align="center"><a href="llistat.php?del=xxxxx<?php echo $row_reserves['id_reserva']; ?>" class="llista Estilo6" onclick="JavaScript: if (confirm('Segur que vols esborrar la reserva <?php echo $row_reserves['id_reserva']; ?>?')){return true;} else {return false;}"> 
                                    
                                    X</a></div>-->
                                      <div align="center"><input type="checkbox" style="background:#999999;" name="pdel[<?php echo $row_reserves['id_reserva']; ?>]" value="checkbox" />
                                      </div></td>
                              </tr>
<?php } while ($row_reserves = mysqli_fetch_assoc($reserves)); ?>

                            <tr>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td>
                                <td class="Estilo2">&nbsp;</td
                                ><td class="Estilo2"><input type="submit" name="Submit" value="Del" />
                                <!--<br/><input type="submit" name="HISTORIC" value="Hist" />-->
                                </td>
                            </tr>
                        </table>
                    </form>

                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" width="50%" align="center">
                        <tr>
                            <td width="10%" align="center">

                                <?php
                                $currentPage = $_SERVER['SCRIPT_NAME'];
                                $queryString_reserves = ''; // $_SERVER['QUERY_STRING'];

                                if ($pageNum_reserves > 0) { // Show if not first page 
                                  ?>
                                  <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, 0, $queryString_reserves); ?>"><img src="../img/First.gif" border=0></a>
<?php } // Show if not first page    ?>
                            </td>
                            <td width="10%" align="center"><?php if ($pageNum_reserves > 0) { // Show if not first page   ?>
                                  <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, max(0, $pageNum_reserves - 1), $queryString_reserves); ?>"><img src="../img/Previous.gif" border=0></a>
<?php } // Show if not first page    ?>
                            </td>
                            <td width="60%"  align="center"> Registres <?php echo ($startRow_reserves + 1) ?> a <?php echo min($startRow_reserves + $maxRows_reserves, $totalRows_reserves) ?> de <?php echo $totalRows_reserves ?> </td>
                            <td width="10%" align="center"><?php if ($pageNum_reserves < $totalPages_reserves) { // Show if not last page    ?>
                                  <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, min($totalPages_reserves, $pageNum_reserves + 1), $queryString_reserves); ?>"><img src="../img/Next.gif" border=0></a>
<?php } // Show if not last page    ?>
                            </td>
                            <td width="10%" align="center"><?php if ($pageNum_reserves < $totalPages_reserves) { // Show if not last page    ?>
                                  <a href="<?php printf("%s?pageNum_reserves=%d%s", $currentPage, $totalPages_reserves, $queryString_reserves); ?>"><img src="../img/Last.gif" border=0></a>
<?php } // Show if not last page    ?>
                            </td>
                        </tr>
                    </table>	
                </td>
            </tr>
        </table>
        
        <div id="alerta" style="display:none;">
            <?php
            echo 'reserva: ' . $_GET['idr'] . '<br>';
            echo 'Enviament SMS: ' . ($_GET['sms'] == 'ok' ? "<span class='EXIT'>EXIT</span>" : "<span class='ERROR'>ERROR</span>") . '<br>';
            echo 'Enviament EMAIL: ' . ($_GET['mail_cli'] == 'ok' ? "<span class='EXIT'>EXIT</span>" : "<span class='ERROR'>ERROR</span>") . '<br>';
            
            echo $extra_alert;
            
            ?>
        </div>
    </body>
</html>
<?php
((mysqli_free_result($reserves) || (is_object($reserves) && (get_class($reserves) == "mysqli_result"))) ? true : false);
?>	         