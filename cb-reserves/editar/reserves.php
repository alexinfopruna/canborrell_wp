<?php

if (!isset($_POST['DATA2'])) {
  header("location: ../reservar/form_grups.php");
}
if (!defined('ROOT'))
  define('ROOT', "../taules/");
require_once(ROOT . "Gestor.php");
require_once(ROOT . "gestor_reserves.php");

include(ROOT . DB_CONNECTION_FILE);
include(ROOT . INC_FILE_PATH . 'valors.php');
include(ROOT . INC_FILE_PATH . 'alex.inc');
if (!$AJAX)
  valida_admin('editar.php');
//$gestor = new gestor_reserves();
$old_lang_code['cat'] = 'cat';
$old_lang_code['ca'] = 'cat';
$old_lang_code['es'] = 'esp';
$old_lang_code['esp'] = 'esp';
$old_lang_code['en'] = 'en';

$l = $lang = $gestor->idioma();
$lang = $old_lang_code[$lang];

$estat = 1;
require_once(ROOT . "../taules/Gestor_pagaments.php");
$gestor = new Gestor_pagaments();

//$preu = calcula_preu();
$comensals = $_POST['nens10_14']+$_POST['nens4_9']+$_POST['adults'];
$preu = $gestor->calcula_preu_grups($comensals);

$data = cambiaf_a_mysql($_POST['DATA2']);

$hora = $_POST['hora'] . ":00";

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "no_quotes":
      $theValue = str_replace("'", "`", $theValue);
      $theValue = str_replace('"', "``", $theValue);
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      // $theValue = htmlentities($theValue,ENT_QUOTES);

      break;

    case "text":
      $theValue = htmlspecialchars($theValue, ENT_QUOTES);
      //$theValue = htmlentities($theValue,ENT_QUOTES);
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

$resp['cat'] = $resp['ca'] = "Petició de reserva rebuda";
$resp['esp'] = $resp['es'] = "Petición de reserva recibida";
$resp['en'] = "Request for a received reservation";
if ($_POST['nens10_14'] <= 0)
  $_POST['txt_1'] = "NO";
if ($_POST['nens4_9'] <= 0)
  $_POST['txt_2'] = "NO";
$_POST['data_creacio'] = date("Y-m-d H:i:s");
$_POST['num_1'] = '';
$_POST['num_2'] = '';
$_POST['id_reserva'] = '';

if (isset($_POST['nocalsots']) && $_POST['nocalsots'] > 0)
  $_POST['observacions'] = "<b>Sol·licitades " . $_POST['nocalsots'] . " substitucions de menú calçotada per menú nº1</b><br/><br/>" . $_POST['observacions'];
if (!isset($_POST['factura']))
  $_POST['factura'][0] = 0;
$query = sprintf("INSERT INTO reserves (id_reserva, `data`, client_id, nom, tel, fax, email, hora, menu, adults, nens10_14, nens4_9, cotxets, observacions, resposta, estat, data_creacio, preu_reserva, lang, txt_1, txt_2, num_1, num_2,factura,factura_cif,factura_nom,factura_adresa,reserva_navegador,reserva_info, preu_persona) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", GetSQLValueString($_POST['id_reserva'], "int"), GetSQLValueString($data, "date"), GetSQLValueString($_POST['client_id'], "int"), GetSQLValueString($_POST['client_nom'] . " " . $_POST['client_cognoms'], "text"), GetSQLValueString($_POST['tel'], "text"), GetSQLValueString($_POST['fax'], "text"), GetSQLValueString($_POST['email'], "text"), GetSQLValueString($hora, "date"), GetSQLValueString($_POST['menu'], "int"), GetSQLValueString($_POST['adults'], "int"), GetSQLValueString($_POST['nens10_14'], "int"), GetSQLValueString($_POST['nens4_9'], "int"), GetSQLValueString($_POST['cotxets'], "int"), GetSQLValueString($_POST['observacions'], "text"), GetSQLValueString($resp[$lang], "text"), GetSQLValueString($estat, "int"), GetSQLValueString($_POST['data_creacio'], "date"), GetSQLValueString($preu, "double"), GetSQLValueString($lang, "text"), GetSQLValueString($_POST['txt_1'], "text"), GetSQLValueString($_POST['txt_2'], "text"), GetSQLValueString($_POST['num_1'], "int"), GetSQLValueString($_POST['num_2'], "int"), $_POST['factura'][0] ? 1 : 0, GetSQLValueString($_POST['factura_cif'], "text"), GetSQLValueString($_POST['factura_nom'], "text"), GetSQLValueString($_POST['factura_adresa'], "text"), GetSQLValueString($_POST['reserva_navegador'], "text"), GetSQLValueString($_POST['reserva_info'], "text"), GetSQLValueString(preu_persona_grups, "double"));

/* * *************************************************************************** */

//echo $query;die();
$Result1 = $gestor->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
$idr = $id = ((is_null($___mysqli_res = mysqli_insert_id($canborrell))) ? false : $___mysqli_res);
//print_log("Recepció de reserva: ".$_POST['id_reserva'].": ".$_POST['client_nom']." ".$_POST['client_cognoms']);


$gestor->xgreg_log(">>> <span class='grups'>Recepció de reserva GRUPS: <span class='idr'>$idr</span> > {$_POST['tel']} </span>", 0, '/log/logGRUPS.txt');

///////////////////////////////////////////////////////
// GUARDA COMANDA
for ($i = 1; isset($_POST['plat_id_' . $i]); $i++) {
  $insertSQL = sprintf("INSERT INTO comanda ( comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
		VALUES (%s, %s, %s)", $idr, $_POST['plat_id_' . $i], $_POST['plat_quantitat_' . $i]);
  //echo $insertSQL;
  $result = $gestor->log_mysql_query($insertSQL, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  // echo  $cd=mysql_insert_id($canborrell);echo " *** ";
}


$id = mail_plantilla();

if ($AJAX || !empty($json['resposta'])) {
  $json['resposta'] = "ok";
  $json['error'] = "";
  $json['email'] = "";
  $json['extra'] = "RESERVA GUARDADA";
  echo json_encode($json);
  die();
}


die();
die();
die();

if ($lang == "cat") {
  header("location: ../cat/gracies.html");
}
else {
  header("location: ../esp/gracies.html");
}

///////////////////////////////////////////////////////////////////////
function mail_plantilla($id = false) {
  Gestor::xgreg_log(">>> <span class='grups'>Enviament mail reserva GRUPS: <span class='idr'>" . $id . "</span></span>", 1, '/log/logGRUPS.txt');


  global $lang, $camps, $mmenu, $txt, $database_canborrell, $canborrell;
  if (!isset($_SESSION))
    session_start();
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

  $id = $fila['id_reserva'];

  $avui = date("d/m/Y");
  $ara = date("H:i");
  /////// ATENCIO
  $file = "templates/pre_reserva_rest.lbi";


  $t = new Template('.', 'comment');
  $t->set_file("page", $file);

  ///////////// TEXTES
  			$t->set_var('self',$file);

  $t->set_var('avui', $avui);
  $t->set_var('titol', $txt[10][$lang]);
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

  ///// COMANDA
  $gestor = new gestor_reserves();
  $comanda = $gestor->plats_comanda($fila['id_reserva']);

  $t->set_var('id_reserva', $fila['id_reserva']);
  $t->set_var('data', $dat_cat);
  $t->set_var('hora', substr($fila['hora'], 0, 5));
  $t->set_var('nom', $fila['nom']);
  $t->set_var('tel', $fila['tel']);
  $t->set_var('fax', $fila['fax']);
  $t->set_var('email', $fila['email']);
  $m = (int) $fila['menu'];

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
  //$t->p("OUT");


  $subject = "Can-Borrell: SOL·LICITUD DE RESERVA PER GRUP ".$fila['id_reserva'];
  $headers = "From: Restaurant Can Borrell " . MAIL_RESTAURANT . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-type: text/html; charset=UTF-8\r\n";
  $headers .= "Return-Path: Restaurant Can Borrell " . MAIL_RESTAURANT . "\r\n";
  ////////////////////////////////////////PROVA MAIL

  $recipient = MAIL_RESTAURANT;

  include("mailer.php");
  if (!isset($altbdy))
    $altbdy = '';


  $r = mailer_reserva($id, 'pre_reserva_rest', $recipient, $subject, $html, $altbdy);
  //echo $html;
  //print_log("Enviament mail reserva ".$fila['id_reserva']." ($r): $recipient, $subject");
  $gestor->xgreg_log(">>> <span class='grups'>Enviament mail reserva GRUPS: <span class='idr'>" . $fila['id_reserva'] . "</span> >  ($r): $recipient, $subject</span>", 1, '/log/logGRUPS.txt');

  ((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);
  return ($fila['id_reserva']);
}

?>