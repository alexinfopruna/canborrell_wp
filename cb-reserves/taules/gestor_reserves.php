<?php

if (!defined('ROOT'))
  define('ROOT', "");

require_once(ROOT . "Gestor.php");
if (!defined('LLISTA_DIES_NEGRA'))
  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA'))
  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_DIES_BLANCA'))
  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");

require_once(ROOT . "Menjador.php");
require_once(ROOT . "TaulesDisponibles.php");

header('Content-Type: text/html; charset=UTF-8');
header('Content-Encoding: bzip');
if (!isset($_SESSION))
  session_start();
if (!isset($_SESSION['data']))
  $_SESSION['data'] = date("Y-m-d");
if (!isset($_SESSION['torn']))
  $_SESSION['torn'] = 1;

setlocale(LC_ALL, 'ca_CA');

//class gestor_reserves
class gestor_reserves extends Gestor {

  protected $ordre;
  protected $database_name;
  protected $connexioDB;
  protected $qry_result;
  protected $last_row;
  protected $total_rows;
  protected $error;
// paginacio
  protected $currentPage;
  protected $maxRows_reserva;
  protected $pageNum_reserva;
  protected $startRow_reserva;
  public $taulesDisponibles;
  protected $menjadors;
  protected $data_BASE = "2011-01-01";

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      CONSTRUCTOR     *********** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function __construct($db_connection_file = DB_CONNECTION_FILE, $usuari_minim = 16) {
    parent::__construct($db_connection_file, $usuari_minim);
//COORDENADES MENJADORS
    include(ROOT . "coord_menjadors.php");
    $this->menjadors = $menjadors;
    $this->taulesDisponibles = new TaulesDisponibles($this);
    $this->taulesDisponibles->data = $_SESSION['data'];
    $this->taulesDisponibles->torn = $_SESSION['torn'];
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      BLOQUEJOS       ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function taula_bloquejada($taula_id) {
    $deleteSQL = "UPDATE " . ESTAT_TAULES . " SET estat_taula_blok = NULL,estat_taula_blok_sess = NULL WHERE estat_taula_blok < NOW() AND estat_taula_blok IS NOT NULL";
    $this->qry_result = mysqli_query($this->connexioDB, $deleteSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $sess = session_id();
    $sql = "SELECT estat_taula_blok FROM " . ESTAT_TAULES . "
    WHERE estat_taula_torn='" . $_SESSION['torn'] . "'
    AND estat_taula_data = '" . $_SESSION['data'] . "'
    AND estat_taula_taula_id = '$taula_id'
    AND (estat_taula_blok_sess <> '$sess') 
    AND (estat_taula_blok > NOW())";

    $this->qry_result = mysqli_query($this->connexioDB, $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $nr = mysqli_num_rows($this->qry_result);
    $this->reg_log("taula_bloquejada $taula_id = $nr");

    return $nr;
  }

//UNLOCK_AFTER

  public function bloqueig_taula($taula_id, $data, $torn, $unlock = false) {
//$torn=$_SESSION['torn'];
//$mydata=cambiaf_a_mysql($_SESSION['data']);
    $mydata = $this->cambiaf_a_mysql($data);

    $deleteSQL = "UPDATE " . ESTAT_TAULES . " SET estat_taula_blok = NULL,estat_taula_blok_sess = NULL WHERE estat_taula_blok < NOW() AND estat_taula_blok IS NOT NULL";
    $this->qry_result = mysqli_query($this->connexioDB, $deleteSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    if (!$taula_id || $taula_id == "null" || $taula_id == "undefined")
      return "ko";
    if ($unlock)
      $sess = $lock = " NULL ";
//else $lock=" DATE_ADD (NOW(), INTERVAL ".UNLOCK_AFTER.")";
    else {
      $lock = " NOW() + INTERVAL " . UNLOCK_AFTER;
      $sess = "'" . session_id() . "'";
    }


    $sql = "SELECT * FROM " . ESTAT_TAULES . "
    WHERE estat_taula_torn='" . $torn . "'
    AND (estat_taula_data = '" . $mydata . "' OR estat_taula_data = '" . $this->data_BASE . "')
    AND estat_taula_taula_id = '$taula_id'
    ORDER BY estat_taula_data DESC";

    $this->qry_result = mysqli_query($this->connexioDB, $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = $this->last_row = mysqli_fetch_assoc($this->qry_result);

    $rsql = "SELECT NOW() + INTERVAL " . UNLOCK_AFTER . " AS loc";
    $rs = mysqli_query($this->connexioDB, $rsql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $r = $this->last_row = mysqli_fetch_assoc($rs);
    $r = $r['loc'];

    $sessid = session_id();
    if ($row['estat_taula_data'] > $this->data_BASE)
      $sql = "UPDATE  " . ESTAT_TAULES . " 
      SET estat_taula_blok = $lock,
      estat_taula_blok_sess = $sess
      WHERE estat_taula_taula_id = $taula_id
      AND (estat_taula_blok_sess='$sessid' OR estat_taula_blok_sess IS NULL)
      AND estat_taula_data= '$mydata'
      AND estat_taula_torn= '$torn'";
    else
      $sql = sprintf("INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_blok, estat_taula_blok_sess) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($mydata, "text"), $this->SQLVal($row['estat_taula_nom'], "text"), $this->SQLVal($torn, "text"), $this->SQLVal($taula_id, "text"), $this->SQLVal($row['reserva_id'], "text"), $this->SQLVal($row['estat_taula_x'], "text"), $this->SQLVal($row['estat_taula_y'], "zero"), $this->SQLVal($row['estat_taula_persones'], "zero"), $this->SQLVal($row['estat_taula_cotxets'], "zero"), $this->SQLVal($row['estat_taula_grup'], "text"), $this->SQLVal($row['estat_taula_plena'], "text"), $lock, $sess);

    $this->qry_result = mysqli_query($this->connexioDB, $sql) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    return mysqli_affected_rows($this->connexioDB) ? "ok$unlock" : "ko$unlock";
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ******   RESERVES  ******** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */


  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      ESBORRA_RESERVA     *********** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function esborra_reserva($id_reserva, $permuta = false) {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

//return $this->accordion_reserves();

    $this->reg_log(" esborra_reserva($id_reserva, $permuta");
    $persones_default = PERSONES_DEFAULT;
    if ($id_reserva <= 1)
      return false;
    $query = "SELECT * FROM " . T_RESERVES . " WHERE id_reserva=$id_reserva";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = $this->last_row = mysqli_fetch_assoc($this->qry_result);
    if ($row['data'] < "2011")
      return "DATA ANOMALA esborra_reserva";



    $dataSMS = $dataSMS = $this->cambiaf_a_normal($row['data']);
    $hora = $row['hora'];
    $lang = $row['lang'];

    $mensa = "Restaurant Can Borrell: Su reserva para el $dataSMS a las $hora HA SIDO ANULADA. Si desea contactar con nosotros: 936929723 - 936910605. Gracias.(ID$id_reserva)";
    if ($lang == 'en') {
      $mensa = "Restaurant Can Borrell: Your reservation for the $dataSMS at $hora HAS BEEN CANCELLED. If you wish to contact us: 936929723 – 936910605. Thank you.(ID$id_reserva)";
    }

    $lang_r = Gestor::codelang($row['lang']);
    require_once(ROOT . "../editar/translate_editar_$lang_r.php");
    $mensa = Gestor::lv("Restaurant Can Borrell: La seva reserva per al %s a les %s HA ESTAT ANUL·LADA. Si desitja contactar amb nosaltres: 936929723 - 936910605. Gràcies.(ID%s)");
    $mensa = sprintf($mensa, $dataSMS, $hora, $id_reserva);


    if (!$permuta) {
      $this->enviaSMS($id_reserva, $mensa);
      $this->paperera_reserves($id_reserva);
//ENVIA MAIL
      global $translate;
      $lang = $this->lng;
      ob_start();
      require("../reservar/translate_$lang.php");
      ob_end_clean();
      $extres['subject'] = $this->lv("Can-Borrell: RESERVA CANCELADA ") . " " . $id_reserva;
      $mail = $this->enviaMail($id_reserva, "cancelada_", FALSE, $extres);
    }
    $this->estat_anterior($id_reserva);
    $deleteSQL = "DELETE FROM " . T_RESERVES . " WHERE id_reserva=$id_reserva";
    $res = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

//$usr=$_SESSION['admin_id'];
    $usr = $_SESSION['uSer']->id;

    $deleteSQL = "UPDATE " . ESTAT_TAULES . " SET reserva_id=0, estat_taula_usuari_modificacio=$usr WHERE reserva_id=$id_reserva";
    $res = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if ($permuta) {
      return $res;
    }
    return $this->accordion_reserves();
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      PEPEREREA_RESERVA     ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function paperera_reserves($id_reserva) {
    $this->xgreg_log("paperera_reserves($id_reserva)", 1);
    
    
    if (!isset($_SESSION['permisos']) || $_SESSION['permisos'] < 16)
      return "error:sin permisos";

    
    if (!defined("DB_CONNECTION_FILE_DEL"))
      return;
    
    $this->xgreg_log(DB_CONNECTION_FILE_DEL, 1);
    
    $reserva = $this->load_reserva($id_reserva);
    include(ROOT . DB_CONNECTION_FILE_DEL);
    $insertSQL = sprintf("REPLACE INTO " . T_RESERVES . " ( id_reserva, client_id, data, hora, adults, 
      nens4_9, nens10_14, cotxets, observacions, resposta, estat, reserva_info, reserva_pastis, reserva_info_pastis ) 
      VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($reserva['id_reserva'], "text"), $this->SQLVal($reserva['client_id'], "text"), $this->SQLVal($reserva['data'], "datePHP"), $this->SQLVal($reserva['hora'], "text"), $this->SQLVal($reserva['adults'], "zero"), $this->SQLVal($reserva['nens4_9'], "zero"), $this->SQLVal($reserva['nens10_14'], "zero"), $this->SQLVal($reserva['cotxets'], "zero"), $this->SQLVal($reserva['observacions'], "text"), $this->SQLVal($reserva['resposta'], "text"), $this->SQLVal($reserva['estat'], "text"), $this->SQLVal($reserva['reserva_info'], "text"), $this->SQLVal($reserva['reserva_pastis'], "text"), $this->SQLVal($reserva['reserva_info_pastis'], "text")
    );
    $this->qry_result = $this->log_mysql_query($insertSQL, $GLOBALS["___mysqli_stonDEL"]); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $insertSQL = sprintf("REPLACE INTO " . ESTAT_TAULES . " ( estat_taula_id,estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($reserva['estat_taula_id'], "text"), $this->SQLVal($reserva['estat_taula_data'], "text"), $this->SQLVal($reserva['estat_taula_nom'], "text"), $this->SQLVal($reserva['estat_taula_torn'], "text"), $this->SQLVal($reserva['estat_taula_taula_id'], "text"), $this->SQLVal($reserva['id_reserva'], "text"), $this->SQLVal($reserva['estat_taula_x'], "text"), $this->SQLVal($reserva['estat_taula_y'], "text"), $this->SQLVal($reserva['estat_taula_persones'], "zero"), $this->SQLVal($reserva['estat_taula_cotxets'], "zero"), $this->SQLVal($reserva['estat_taula_grup'], "text"), $this->SQLVal($reserva['estat_taula_plena'], "text"));

    $this->qry_result = $this->log_mysql_query($insertSQL, $GLOBALS["___mysqli_stonDEL"]); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $insertSQL = sprintf("REPLACE INTO client ( client_id, client_nom, client_cognoms, client_adresa, 
      client_localitat, client_cp, client_dni, client_telefon, client_mobil, client_email, client_conflictes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($reserva['client_id'], "text"), $this->SQLVal($reserva['client_nom'], "text"), $this->SQLVal($reserva['client_cognoms'], "text"), $this->SQLVal($reserva['client_adresa'], "text"), $this->SQLVal($reserva['client_localitat'], "text"), $this->SQLVal($reserva['client_cp'], "text"), $this->SQLVal($reserva['client_dni'], "text"), $this->SQLVal($reserva['client_telefon'], "text"), $this->SQLVal($reserva['client_mobil'], "text"), $this->SQLVal($reserva['client_email'], "text"), $this->SQLVal($reserva['client_conflictes'], "text"));

    $this->qry_result = $this->log_mysql_query($insertSQL, $GLOBALS["___mysqli_stonDEL"]);

// ESBORREM INFO CADUCADA
    if (CLEAR_DELETED_BEFORE) {
      $deleteSQL = "DELETE FROM " . T_RESERVES . " WHERE data > '" . $this->data_BASE . "' AND data< NOW() - INTERVAL " . CLEAR_DELETED_BEFORE;
      $this->qry_result = $this->log_mysql_query($deleteSQL, $GLOBALS["___mysqli_stonDEL"]); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $deleteSQL = "DELETE FROM " . ESTAT_TAULES . " WHERE estat_taula_data > '" . $this->data_BASE . "' AND estat_taula_data< NOW() - INTERVAL " . CLEAR_DELETED_BEFORE;
      $this->qry_result = $this->log_mysql_query($deleteSQL, $GLOBALS["___mysqli_stonDEL"]); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }

    ((is_null($___mysqli_res = mysqli_close($GLOBALS["___mysqli_stonDEL"]))) ? false : $___mysqli_res);
    ((bool) mysqli_query($this->connexioDB, "USE " . $this->database_name));


    return true;
  }

  private function coordenadaX($mydata, $torn) {
    $query = "SELECT estat_taula_x AS cnt FROM " . ESTAT_TAULES . " 	
		WHERE (estat_taula_data = '$mydata' AND estat_taula_torn = $torn) 
		AND estat_taula_nom LIKE '%G' 
		AND estat_taula_y = 390
		ORDER BY estat_taula_x DESC";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $cnt = mysqli_num_rows($Result1);

    $x = 32 * ($cnt) + 22;
    return $x;
  }

  //ALEX
  public function insert_reserva_grup($id_reserva) {
    $estatSQL = "SELECT * FROM reserves WHERE id_reserva=$id_reserva";

    $this->qry_result = mysqli_query($this->connexioDB, $estatSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($this->qry_result);
    if (!$row)
      header("location: ../editar/llistat.php?creada=No existeix la reserva $id_reserva");

    // JA EXISTEIX????
    $repeSQL = "SELECT id_reserva FROM " . T_RESERVES . " WHERE id_reserva=$id_reserva";
    $this->qry_result = mysqli_query($this->connexioDB, $repeSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (mysqli_num_rows($this->qry_result))
      header("location: ../editar/llistat.php?creada=Ja existeix la reserva $id_reserva");

    $client = $this->load_client($row['client_id']);
    if (!$client || ($row['estat'] != 3 && $row['estat'] != 7)) {
      header("location: ../editar/llistat.php?creada=No ha estat possible crear la taula per la reserva $id_reserva");
    }

    $_POST['id_reserva'] = $row['id_reserva'];
    $_POST['data'] = $row['data'];
    $_POST['hora'] = $row['hora'];
    $_POST['adults'] = $row['adults'];
    $_POST['nens4_9'] = $row['nens4_9'];
    $_POST['nens10_14'] = $row['nens10_14'];
    $_POST['cotxets'] = $row['cotxets'];
    $_POST['accessible'] = $row['accessible'];

    $_POST['reserva_info'] = $row['reserva_info'];
    $info = $this->decodeInfo($row['reserva_info']);
    $_POST['amplaCotxets'] = $info['ampla'];
    $_POST['selectorCadiraRodes'] = $info['ampla'] ? "on" : "";
    $_POST['selectorAccesible'] = $info['ampla'] ? "on" : "";

    $_POST['client_id'] = $row['client_id'];
    $_POST['client_mobil'] = $row['client_mobil'];
    $_POST['client_id'] = $row['client_id'];
    $_POST['client_id'] = $row['client_id'];
    $_POST['client_id'] = $row['client_id'];
    $_POST['observacions'] = $row['observacions'] . " *** Creada AUTO-GRUP " . $row['id_reserva'];
    $_POST['RESERVA_PASTIS'] = $row['RESERVA_PASTIS'];
    $_POST['INFO_PASTIS'] = $row['INFO_PASTIS'];
    $_POST['resposta'] = $row['preu_reserva'];
    $_POST['MM_insert'] = "insert_reserva";


    $this->taulesDisponibles->data = $_POST['data'];
    $this->taulesDisponibles->torn = $torn = $this->torn($data, $_POST['hora']);
    $this->taulesDisponibles->hora = $_POST['hora'];
    $this->taulesDisponibles->persones = $_POST['adults'] + $_POST['nens4_9'] + $_POST['nens10_14'];
    $this->taulesDisponibles->cotxets = $_POST['cotxets'];
    $this->taulesDisponibles->accesible = $_POST['accessible'];
    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;
    $this->taulesDisponibles->tableHores = "estat_hores";
    $this->taulesDisponibles->taules(TRUE);
    $taules = $this->taulesDisponibles->taulesDisponibles();

    $_POST['estat_taula_taula_id'] = $taules[0]->id;
    $_POST['taula_nom'] = $row['id_reserva'] . "G";
    //echo "Creant reserva....";
    $this->inserta_reserva();
    //echo "Reserva creada!";
    header("location: ../editar/llistat.php?creada=Taula creada correctament per la reserva $id_reserva");
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      INSERTA_RESERVA     ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function inserta_reserva() {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";
    if (!$this->valida_reserva($_POST['estat_taula_taula_id'], $this->cambiaf_a_mysql($_POST['data'])))
      return "DATA ANOMALA inserta_reserva";

    $this->reg_log("CREANT RESERVA: " . $_POST['data'] . " - " . $_POST['hora'] . " - " . $_POST['adults']);

    $_POST['client_id'] = isset($_POST['client_id']) ? $_POST['client_id'] : NULL;
    $_POST['client_mobil'] = isset($_POST['client_mobil']) ? $_POST['client_mobil'] : NULL;
    $_POST['RESERVA_PASTIS'] = isset($_POST['RESERVA_PASTIS']) ? $_POST['RESERVA_PASTIS'] : NULL;

    $_POST['client_id'] = $this->controlClient($_POST['client_id'], $_POST['client_mobil']);


    /*
     * reserva_info
     */
    $_POST['amplaCotxets'] = isset($_POST['amplaCotxets']) ? $_POST['amplaCotxets'] : 0;
    $online = $this->flagBit($_POST['reserva_info'], 1);
    $_POST['reserva_info'] = $this->encodeInfo($_POST['amplaCotxets'], 0, $online);
    $selectorCadiraRodes = (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes'] == 'on'); //cadira
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 8, $selectorCadiraRodes);
    $selectorAccesible = (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible'] == 'on');
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 9, $selectorAccesible);



    $editor_id = $this->SQLVal($_SESSION['uSer']->id, "text");
    if (isset($_REQUEST['editor_id']) && $_REQUEST['editor_id'])
      $editor_id = $_REQUEST['editor_id'];

    $estat = 100; // !!!!!!!!!! SEMPRE  ??????
    $insertSQL = sprintf("INSERT INTO " . T_RESERVES . " ( id_reserva, client_id, data, hora, adults, 
      nens4_9, nens10_14, cotxets, reserva_pastis, reserva_info_pastis, observacions, resposta, estat, usuari_creacio, reserva_navegador, reserva_info) 
      VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($_POST['id_reserva'], "text"), $this->SQLVal($_POST['client_id'], "text"), $this->SQLVal($_POST['data'], "datePHP"), $this->SQLVal($_POST['hora'], "text"), $this->SQLVal($_POST['adults'], "zero"), $this->SQLVal($_POST['nens4_9'], "zero"), $this->SQLVal($_POST['nens10_14'], "zero"), $this->SQLVal($_POST['cotxets'], "zero"), $this->SQLVal($_POST['RESERVA_PASTIS'] == 'on', "zero"), $this->SQLVal($_POST['INFO_PASTIS'], "text"), $this->SQLVal($_POST['observacions'], "text"), $this->SQLVal($_POST['resposta'], "text"), $this->SQLVal($estat, "text"), $editor_id, $this->SQLVal($_SERVER['HTTP_USER_AGENT'], "text"), $this->SQLVal($_POST['reserva_info'], "zero"));

//echo $insertSQL;echo "<br><br>";
    $a = $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $idr = ((is_null($___mysqli_res = mysqli_insert_id($this->connexioDB))) ? false : $___mysqli_res);
    /*     * *********** */
    $data = $this->cambiaf_a_mysql($_POST['data']);
    $torn = $this->torn($data, $_POST['hora']);

//echo "WWWWW";
    $estatSQL = "SELECT * FROM " . ESTAT_TAULES . " 
      
      WHERE (estat_taula_data<'$data 23:59:59' 
      AND estat_taula_data>='$data' 
      AND estat_taula_torn=$torn      
      AND estat_taula_taula_id = " . $_POST['estat_taula_taula_id'] . ")
      OR (estat_taula_data='" . $this->data_BASE . "' AND estat_taula_taula_id = " . $_POST['estat_taula_taula_id'] . ")
      
      ORDER BY estat_taules_timestamp DESC, estat_taula_id DESC";
// echo   $row['estat_taula_x'] =  $this->coordenadaX($_POST['data'], $torn);
//echo $estatSQL;echo "<br><br>";
//die();
    $this->qry_result = mysqli_query($this->connexioDB, $estatSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($this->qry_result);
    if (empty($row['estat_taula_plena']))
      $row['estat_taula_plena'] = "0";
    if (!$row['estat_taula_nom']) {
      $row['estat_taula_nom'] = $_POST['estat_taula_taula_id'];
      $row['estat_taula_x'] = $this->coordenadaX($_POST['data'], $torn);
      $row['estat_taula_y'] = 390;
      $row['estat_taula_persones'] = $_POST['adults'] + $_POST['nens4_9'] + $_POST['nens10_14'];
    }
    if (isset($_POST['taula_nom']))
      $row['estat_taula_nom'] = $_POST['taula_nom'];


    $insertSQL = sprintf("INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($_POST['data'], "datePHP"), $this->SQLVal($row['estat_taula_nom'], "text"), $this->SQLVal($torn, "text"), $this->SQLVal($_POST['estat_taula_taula_id'], "text"), $this->SQLVal($idr, "text"), $this->SQLVal($row['estat_taula_x'], "text"), $this->SQLVal($row['estat_taula_y'], "text"), $this->SQLVal($row['estat_taula_persones'], "zero"), $this->SQLVal($row['estat_taula_cotxets'], "zero"), $this->SQLVal($row['estat_taula_grup'], "text"), $this->SQLVal($row['estat_taula_plena'], "text"), $this->SQLVal($_SESSION['admin_id'], "text"));
    echo $insertSQL;
    echo "<br><br>";
    $b = $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    $id = mysqli_insert_id($this->connexioDB);


//echo "************************ $id *****************";
//$_SESSION['torn']=$torn;
//DELETE REDUNDANTS
    $deleteSQL = sprintf("DELETE FROM " . ESTAT_TAULES . "
      WHERE estat_taula_taula_id = %s 
      AND estat_taula_data=%s 
      AND estat_taula_torn=%s 
      AND estat_taula_id<>%s", $this->SQLVal($_POST['estat_taula_taula_id'], "text"), $this->SQLVal($_POST['data'], "datePHP"), $this->SQLVal($torn, "text"), $this->SQLVal($id, "text"));

    $c = $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//echo $deleteSQL;echo "<br><br>";
// ENVIA SMS


    if (isset($_POST['cb_sms'])) {
      $_REQUEST['res'] = $idr;
      $dataSMS = $this->cambiaf_a_normal($data);
      $hora = $_POST['hora'];
      $coberts = ($_POST['adults'] + $_POST['nens4_9'] + $_POST['nens10_14']) . "p";
      if ($_POST['cotxets'])
        $coberts .= "+" . $_POST['cotxets'] . "cochecito";
      if ($_POST['cotxets'] > 1)
        $coberts .= "s";
      //$mensa = "Recuerde: reserva en Restaurant Can Borrell. $dataSMS $hora ($coberts).Rogamos comunique cualquier cambio: 936929723/936910605.Gracias.(ID$idr)";

      $args[] = $dataSMS;
      $args[] = $hora;
      $args[] = $coberts;
      $args[] = $idr;
      $lang = $this->getLanguage();

      $mensa = "Recordi: reserva al Restaurant Can Borrell. %s %s (%s).Preguem comuniqui qualsevol canvi: 936929723/936910605.Gràcies.(ID%s)";
      $mensa = gestor_reserves::SMS_language($mensa, $lang, $args);

      $this->enviaSMS($idr, $mensa);
//ENVIA MAIL
      global $translate;
      $lang = $this->lng;
      ob_start();
      require("../reservar/translate_$lang.php");
      ob_end_clean();
      echo $extres['subject'] = $this->lv("Can-Borrell: Confirmació de reserva") . " " . $idr;
      $mail = $this->enviaMail($idr, "confirmada_", FALSE, $extres);
    }

    $_POST['id_reserva'] = $idr;

    $this->qry_result = ($a && $b && $c);
//echo "FINAL";
    return $this->accordion_reserves();
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      UPDATE_RESERVA     *********** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function update_reserva() {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

    $id_reserva = $_POST['id_reserva'];
    if (!isset( $_POST['RESERVA_PASTIS'])) $_POST['RESERVA_PASTIS'] = "true";
    $mensa=0;
    
    $this->reg_log("update_reserva <span class='idr'>" . $_POST['id_reserva'] . '</span>');
    if (!$this->valida_reserva($_POST['estat_taula_taula_id'], $this->cambiaf_a_mysql($_POST['data'])))
      return "DATA ANOMALA update_reserva";

    if ($_POST['hora'] <= "0")
      return "ERROR HORA";

    $torn = $this->torn($this->cambiaf_a_mysql($_POST['data']), $_POST['hora']);

    $this->estat_anterior($_POST['id_reserva']);
//$this->gr

    $updateSQL = "UPDATE " . ESTAT_TAULES . " SET estat_taula_usuari_modificacio=" . $_SESSION['admin_id'] . ", reserva_id='" . $_POST['id_reserva'] . "',estat_taula_data=" . $this->SQLVal($_POST['data'], 'datePHP') . ", estat_taula_torn='" . $torn . "', estat_taules_timestamp=CURRENT_TIMESTAMP WHERE reserva_id=" . $_POST['id_reserva'];
    //echo "$updateSQL EEEE";die();


    $result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    /*
     * reserva_info
     */


    $online = $this->flagBit($_POST['reserva_info'], 1);
    $encode = $this->encodeInfo($_POST['amplaCotxets'], 0, $online);
    $_POST['reserva_info'] = $_POST['reserva_info'] | $encode;
    $selectorCadiraRodes = (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes'] == 'on'); //cadira
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 8, $selectorCadiraRodes);
    $selectorAccesible = (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible'] == 'on'); //cadira
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 9, $selectorAccesible);
    /*
     * 
     */
    $updateSQL = sprintf("UPDATE " . T_RESERVES . " SET  id_reserva=%s, client_id=%s, data=%s, hora=%s, adults=%s,nens4_9=%s, 
      nens10_14 = %s, cotxets = % s, reserva_pastis= %s, reserva_info_pastis = %s, observacions = %s, resposta = %s,  reserva_info=%s WHERE id_reserva=%s", $this->SQLVal($_POST['id_reserva'], "text"), $this->SQLVal($_POST['client_id'], "text"), $this->SQLVal($_POST['data'], "datePHP"), $this->SQLVal($_POST['hora'], "text"), $this->SQLVal($_POST['adults'], "text"), $this->SQLVal($_POST['nens4_9'], "text"), $this->SQLVal($_POST['nens10_14'], "text"), $this->SQLVal($_POST['cotxets'], "text"), $this->SQLVal($_POST['RESERVA_PASTIS'] == 'on' ? 1 : 0, "zero"), $this->SQLVal($_POST['INFO_PASTIS'], "text"), $this->SQLVal($_POST['observacions'], "text"), $this->SQLVal($_POST['resposta'], "text"), $this->SQLVal($_POST['reserva_info'], "int"), $this->SQLVal($_POST['id_reserva'], "text"));

    $result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    
    $this->update_comanda($id_reserva);


    if (isset($_POST['cb_sms'])) {
      $this->enviaSMS($id_reserva, $mensa);
    }

    if (!isset($_REQUEST['a']))
      header("Location: " . $_SERVER['PHP_SELF']);

//return $query
    return $this->accordion_reserves();
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   PERMUTA_RESERVA    ******** */
  /*   * ************************************* */
  /*   * ************************************* */
  /**/

  public function permuta_reserva() {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";
    if (isset($_POST['extendre']) && $_POST['extendre'] == 1) {
      return $this->extendreReserva();
    }

    if (!$this->valida_permuta()) {
      $this->xgreg_log("NO VALIDA DADES PERMUTA", 1);
      echo "NO VALIDA DADES PERMUTA";
      return FALSE;
    }

//// DADES UPDATE RESERVA
    $reserva = $_POST['id_reserva'];
    $data = $this->cambiaf_a_mysql($_POST['data']);
    $hora = $this->cambiaf_a_mysql($_POST['hora']);
    $torn = $this->torn($data, $_POST['hora']);
    $taula = $_POST['estat_taula_taula_id'];
    $cotxets = $_POST['cotxets'] ? $_POST['cotxets'] : 0;
    $pastis = (isset($_POST['RESERVA_PASTIS']) && $_POST['RESERVA_PASTIS'] == 'on') ? 1 : 0;
    $adults = $_POST['adults'];
    $nens10_14 = $_POST['nens10_14'];
    $nens4_9 = $_POST['nens4_9'];
    $persones = $adults + $nens10_14 + $nens4_9;
    $observacions = Gestor::SQLVal($_POST['observacions'], "no_quotes");
    $info_pastis = Gestor::SQLVal($_POST['INFO_PASTIS'], "no_quotes");
    $resposta = Gestor::SQLVal($_POST['resposta'], "no_quotes");

    $this->xgreg_log(">>> INICIEM PERMUTA2 <span class='idr'>$reserva</span> >> TAULA DESTI >> {$_POST['estat_taula_taula_id']}");
    $this->estat_anterior($reserva);
    $_POST['id_reserva'] = "";
    $rollback = FALSE;

    if (!is_numeric(substr($data, 0, 2))) {
      $ret['error'] = "Data errònia";
      $ret['err'] = "Data errònia";
      echo json_encode($ret);
      return FALSE;
    }

    try {////  INTENT PERMUTA  ////////////////////////////
      mysqli_autocommit($GLOBALS["___mysqli_ston"], FALSE);

////////////////////////////////////////////////////
//// INSERTA UN NOU ESTA AMB LA RESERVA
      $insert_nou_estat = "INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
                  reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 

                  SELECT '{$data}', estat_taula_nom, $torn, estat_taula_taula_id, 
                  $reserva, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, 
                  estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio 
                  FROM estat_taules 
                  WHERE   (estat_taula_data='2011-01-01' OR estat_taula_data='{$data}')
                  AND estat_taula_torn=$torn
                  AND  estat_taula_taula_id={$taula}
                  ORDER BY estat_taula_data DESC
                  ";

      mysqli_query($GLOBALS["___mysqli_ston"], $insert_nou_estat);
      $insert_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
      //$error1 = $insert_id < 20000;
      $error1 = $insert_id < 1000; // MODIFICAT PER ADMETRE RESERVES GRUPS AL MENJADOR
      $this->xgreg_log($insert_nou_estat, 1);
      $this->xgreg_log("INSERT ID: $insert_id", 1);
////////////////////////////////////////////////////
//// ELIMINA LA RESERVA DE LESTAT ORIGINAL
      $esborra_reserva_original = "UPDATE " . ESTAT_TAULES . " SET reserva_id=0 WHERE reserva_id=$reserva AND estat_taula_id <> $insert_id";
      $r = mysqli_query($GLOBALS["___mysqli_ston"], $esborra_reserva_original);
      $affected = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
      $error2 = (!$r || $affected <= 0);
      $this->xgreg_log($esborra_reserva_original, 1);
      $this->xgreg_log("AFFECTED: $affected", 1);
////////////////////////////////////////////////////
//// ELIMINA ESTATS REDUNDANTS
      $esborra_redundants = "DELETE FROM " . ESTAT_TAULES . " WHERE estat_taula_data='{$data}' AND estat_taula_torn={$torn} 
                  AND  estat_taula_taula_id={$taula} AND reserva_id<>{$reserva}";
      $r = mysqli_query($GLOBALS["___mysqli_ston"], $esborra_redundants);
      $affected = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
      $error3 = (!$r || $affected < 0);
//$error3 = FALSE;
      $this->xgreg_log($esborra_redundants, 1);
      $this->xgreg_log("AFFECTED: $affected", 1);


      $update_reserva = "UPDATE " . T_RESERVES . " 
                SET data='$data',
                hora='{$hora}',
                adults={$adults},
                nens10_14={$nens10_14},
                nens4_9={$nens4_9},
                cotxets={$cotxets},
                reserva_pastis={$pastis},
                reserva_info_pastis={$info_pastis},

                observacions={$observacions},      
                resposta={$resposta}      
                WHERE id_reserva=$reserva";

      //echo     $update_reserva;die();   
      $r = mysqli_query($GLOBALS["___mysqli_ston"], $update_reserva);
      $affected = mysqli_affected_rows($GLOBALS["___mysqli_ston"]);
      $update_err = (!$r || $affected < 0);
//$error3 = FALSE;
      $this->xgreg_log($update_reserva, 1);
      $this->xgreg_log("AFFECTED: $affected", 1);

////////////////////////////////////////////////////
//// COMPROVA QUE TENIM LA RESERVA ABANS DEL COMMIT
      $verifica = "SELECT id_reserva FROM reservestaules INNER JOIN estat_taules ON id_reserva = reserva_id WHERE id_reserva = $reserva";
      $this->xgreg_log($verifica, 1);

      $r = mysqli_query($GLOBALS["___mysqli_ston"], $verifica);
      $num = mysqli_num_rows($r);
      $error4 = ($num == 0);


      $orfes = $this->reserves_orfanes();


      if ($error1 || $error2 || $error3 || $error4 || $update_err || $orfes) {
        $this->xgreg_log("insert_nou_estat:$error1  esborra_reserva_original:$error2  esborra_redundants:$error3  resultat:$error4  update_err:$update_err  ORFES: $orfes", 1);
        $this->reg_log("PERMUTA ($reserva): ERRORRRRRRR", 1);

        mysqli_rollback($GLOBALS["___mysqli_ston"]);
        mysqli_autocommit($GLOBALS["___mysqli_ston"], TRUE);

        return FALSE;
      }
    }
    catch (Exception $e) {////  HA FALLAT PERMUTA  ////////////////////////////
      mysqli_rollback($GLOBALS["___mysqli_ston"]);
      $rollback = "ERROR PERMUTA";
      mysqli_autocommit($GLOBALS["___mysqli_ston"], TRUE);

      $_POST['id_reserva'] = $reserva;
    }
    /**
     * COMMIT
     */
    $this->xgreg_log("TOT OK: COMMIT", 1);

    mysqli_commit($GLOBALS["___mysqli_ston"]);
    mysqli_autocommit($GLOBALS["___mysqli_ston"], TRUE);
    $_POST['id_reserva'] = $reserva;

//// COMPROVA QUE TENIM LA RESERVA DESPRES DEL COMMIT
    $verifica = "SELECT id_reserva FROM reservestaules INNER JOIN estat_taules ON id_reserva = reserva_id WHERE id_reserva = $reserva";
    $r = mysqli_query($GLOBALS["___mysqli_ston"], $verifica);
    $n = mysqli_num_rows($r);
    if (!$n) {
      $this->xgreg_log("EEEEP!!!! ERROR EN LA VALIDACIO", 1);
    }
    return TRUE;
  }

  private function valida_permuta() {
    if (!isset($_POST['estat_taula_taula_id']) || $_POST['estat_taula_taula_id'] < 1) {
      return FALSE;
    }
    if (!isset($_POST['data'])) {
      $data = $this->cambiaf_a_mysql($_POST['data']);
      if ($data < date("Y-m-d")) {

        return FALSE;
      }
    }
    if (!isset($_POST['hora']) || $_POST['hora'] < '00:00') {
      return FALSE;
    }
    /*
      if (!isset($_POST['id_reserva']) || $_POST['id_reserva'] < 20000) {
      return FALSE;
      }
     */

    return TRUE;
  }

  public function ANULATpermuta_reserva() {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";
    if ($_POST['extendre'] == 1) {
      return $this->extendreReserva();
    }

    $reserva = $_POST['id_reserva'];
    $data = $this->cambiaf_a_mysql($_POST['data']);
    $torn = $this->torn($data, $_POST['hora']);

    $this->xgreg_log(">>> INICIEM PERMUTA <span class='idr'>$reserva</span> >> TAULA DESTI >> {$_POST['estat_taula_taula_id']}");
    $this->estat_anterior($reserva);
    $_POST['id_reserva'] = "";

    /**
     * START TRANSACTION
     * 
     * De vegades falla misteriosament, per això transition i, per això dos intents
     */
    for ($i = 0; $i < 1; $i++) { // ARa farem un intent
//echo "PERMUTA INTENT #$i";
      $this->xgreg_log("PERMUTA INTENT $i ", 1);
      $rollback = false;

      try {
////////////////////////////////
        mysqli_query($GLOBALS["___mysqli_ston"], "START TRANSACTION");
        $observacions = Gestor::SQLVal($_POST['observacions']);
        $_POST['cotxets'] = $_POST['cotxets'] ? $_POST['cotxets'] : 0;
        $_POST['RESERVA_PASTIS'] = (isset($_POST['RESERVA_PASTIS']) && $_POST['RESERVA_PASTIS'] == 'on') ? 1 : 0;
//ELIMINA LA RESERVA DE LA TAULA VELLA
        $query = "UPDATE " . T_RESERVES . " 
                SET data='$data',
                hora='{$_POST['hora']}',
                adults={$_POST['adults']},
                nens10_14={$_POST['nens10_14']},
                nens4_9={$_POST['nens4_9']},
                cotxets={$_POST['cotxets']},

                reserva_pastis={$_POST['RESERVA_PASTIS']},
                reserva_info_pastis='{$_POST['INFO_PASTIS']}',

                observacions={$observacions},      
                resposta='{$_POST['resposta']}'      
                WHERE id_reserva=$reserva";
//echo $query;
        $result = $this->log_mysql_query($query, $this->connexioDB) or $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
        $this->xgreg_log("PERMUTA (<span class='idr'>$reserva</span>): ACTUALITZO RESERVA (data,hora) >> " . ($this->qry_result ? "OK" : "KO"), 1);
        if (!$result)
          $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;

//ACTUALITZA DADES DE LA RESERVA
        $query = "UPDATE " . ESTAT_TAULES . " SET reserva_id=0
                WHERE reserva_id=$reserva";

        $result = $this->log_mysql_query($query, $this->connexioDB) or $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
        $this->xgreg_log("PERMUTA (<span class='idr'>$reserva</span>): ELIMINO LA RESERVA DE L'ESTAT ORIGEN >> " . ($this->qry_result ? "OK" : "KO"), 1);
        if (!$result)
          $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;

////////////////////////////////
//COMPROVA SI LA TAULA JA TE ESTAT
        $query = "SELECT estat_taula_id from estat_taules 
                WHERE estat_taula_data='{$data}' AND estat_taula_torn=$torn 
                AND estat_taula_taula_id={$_POST['estat_taula_taula_id']}";
        $result = $this->log_mysql_query($query, $this->connexioDB) or $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;

        if ($num = mysqli_num_rows($result)) {
////////////////////////////////
//SI EL TE, CANVIA LA RESERVA D'UN CAP A L'ALTRE   
//$simula_err=$i?"":"xx000x OR OR OR ";

          $query = "UPDATE " . ESTAT_TAULES . " SET reserva_id=$reserva
                  WHERE estat_taula_data='{$data}' AND estat_taula_torn={$torn} 
                  AND  estat_taula_taula_id={$_POST['estat_taula_taula_id']}";

//echo $query;
          $result = $this->log_mysql_query($query, $this->connexioDB) or $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
          $this->reg_log("PERMUTA ($reserva): HI HA ESTAT EXISTENT >> LI ASSIGNO LA RESERVA" . ($this->qry_result ? "OK" : "KO"), 1);

          if (!$result)
            $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
        }else {
////////////////////////////////
//SI NO EL TE, CREA UN ESTAT PEL DIA, TORN, TAULA, RESERVA COPIAT DE LA BASE    
          $query = "INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
                  reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 

                  SELECT '{$data}', estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
                  $reserva, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, 
                  estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio 
                  FROM estat_taules 
                  WHERE   estat_taula_data='2011-01-01' AND estat_taula_torn=$torn
                  AND  estat_taula_taula_id={$_POST['estat_taula_taula_id']}";

          $result = $this->log_mysql_query($query, $this->connexioDB) or $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
          $this->reg_log("PERMUTA ($reserva): SENSE ESTAT EXISTENT >> CREAT ESTAT AMB RESERVA" . ($this->qry_result ? "OK" : "KO"), 1);

          if (!$result)
            $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
        }

        $orfes = $this->reserves_orfanes();
        if ($orfes) {
          $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK") . $query;
        }


        if (!$rollback)
          break; // Si tot be, no fa segon intent
      }
      catch (Exception $e) {
        $rollback = mysqli_query($GLOBALS["___mysqli_ston"], "ROLLBACK");
        $rollback = "ERROR PERMUTA";
//return "ERROR PERMUTA";
      }
    } // FOR


    if ($orfes) {
//echo "PERMUTA ($reserva): $rollback";
      $this->reg_log("PERMUTA ($reserva): ERRORRRRRRR", 1);

      return "ORFANES!!!";
    }
    if ($rollback) {
//echo "PERMUTA ($reserva): $rollback";
      $this->reg_log("PERMUTA ($reserva): $rollback", 1);

      return "ROLLBAK: " . $rollback;
    }

    /**
     * COMMIT
     */
    mysqli_query($GLOBALS["___mysqli_ston"], "COMMIT");
    mysqli_query($GLOBALS["___mysqli_ston"], "SET AUTOCOMMIT=1");
    $_POST['id_reserva'] = $reserva;

    return TRUE;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   RESERVES ORFANES  ******** */
  /* Reserves existents a la taula reservestaules
    però que no apareixen a estat_taules, és a dir,
    són reserves perdudes que perden el link amb una taula
    /*************************************** */
  /*   * ************************************* */

  public function reserves_orfanes() {
//$data = date("Y-m-d");

    $query = "SELECT * "
        . "FROM reservestaules "
        . "LEFT JOIN estat_taules on reserva_id = id_reserva "
        . "WHERE reserva_id IS NULL AND data >= NOW()";
    /*
      $query = "SELECT * FROM `reservestaules` WHERE
      `data` >=  '$data' and
      id_reserva not in
      (
      SELECT reserva_id
      FROM  `estat_taules`
      WHERE  `data` >=  '$data'
      and reserva_id>0
      )";
     * */

    $result = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $num = mysqli_num_rows($result);
    if ($num)
      $this->reg_log("TROBADES $num RESERVES ORFANES!!"); //echo $query;

    if (isset($_REQUEST['p']))
      echo $num ? '<span style="color:red">TROBADES ' . $num . ' RESERVES ORFANES!!</span>' : '<span style="color:green">NO S\'HAN TROBAT  ORFANES!!</span>';

    if (!$num)
      return FALSE;


    $html = "<!--ORFANES-->
      <table>
        ";
    while ($row = mysqli_fetch_assoc($result)) {
      $row_cli = $this->load_client($row['client_id']);
      $client = $row_cli['client_nom'] . " " . $row_cli['client_cognoms'] . " - " . $row_cli['client_mobil'];
      $comensals = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
      $url_repara = $_SERVER['PHP_SELF'] . '?a=repara_reserva_orfana&b=' . $row['id_reserva'];

      $html .= "
        <tr>
          ";
      $html .= '<td> (id_reserva:' . $row['id_reserva'] . ') </td>';
      $html .= '<td>' . $row['data'] . '</td>';
      $html .= '<td> - ' . $row['hora'] . '</td>';
      $html .= '<td> #' . $comensals . '</td>';
      $html .= '<td> (client_id:' . $row['client_id'] . ') </td>';
      $html .= '<td>' . $client . '</td>';
      $html .= '<td><a href="' . $url_repara . '">Recuperar reserva</a></td>';
      $html .= "
        </tr>";
    }
    $html .= "      </table>";

    return $html;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   LOAD_TAULA_PERMUTA  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function repara_reserva_orfana($reserva_id) {
    $this->reg_log("repara_reserva_orfana $reserva_id");

    $row = $this->load_reserva($reserva_id);
    if (!isset($row['torn']))
      $row['torn'] = 1;
//print_r($row);
    $time = time();
    $torn = $this->torn($row['data'], $row['hora']);

    $query = "SELECT reserva_id FROM " . ESTAT_TAULES . " 
    WHERE estat_taula_data='{$row['data']}'
    AND estat_taula_torn=$torn
    AND reserva_id=$reserva_id";


    $res = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $num = mysqli_num_rows($res);
    if ($num) {
      echo "Aquesta reserva està correctament vinculada";
      return;
    }

    $insertSQL = sprintf("INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
    reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($row['data'], "datePHP"), $this->SQLVal('!!!!!', "text"), $this->SQLVal($torn, "text"), $this->SQLVal($time, "text"), $this->SQLVal($row['id_reserva'], "text"), $this->SQLVal(300, "text"), $this->SQLVal(390, "text"), $this->SQLVal($row['adults'] + $row['nens10_14'] + $row['nens4_9'], "zero"), $this->SQLVal($row['cotxets'], "zero"), $this->SQLVal(0, "text"), $this->SQLVal(0, "text"), $this->SQLVal($_SESSION['uSer']->id, "text"));

    $b = $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    $id = mysqli_insert_id($this->connexioDB);
//$_SESSION['torn']=$torn;
//DELETE REDUNDANTS
    $deleteSQL = sprintf("DELETE FROM " . ESTAT_TAULES . "
      WHERE estat_taula_taula_id = %s 
      AND estat_taula_data=%s 
      AND estat_taula_torn=%s 
      AND estat_taula_id<>%s", $this->SQLVal($time, "text"), $this->SQLVal($row['data'], "datePHP"), $this->SQLVal($row['torn'], "text"), $this->SQLVal($id, "text"));

    $c = $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    echo "S'ha recuperat la reserva $reserva_id. Ha estat creada una taula el dia {$row['data']} amb nom '!!!!!' ";
    echo $this->reserves_orfanes();
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   LOAD_TAULA_PERMUTA  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function load_taula_permuta($id_taula) {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

    $filtre = "(estat_taula_data='" . $_SESSION['data'] . "' AND estat_taula_torn='" . $_SESSION['torn'] . "'  OR estat_taula_data='" . $this->data_BASE . "') ";


    $query = "SELECT * FROM " . ESTAT_TAULES . "
    WHERE estat_taula_taula_id=$id_taula
    AND $filtre 
    ORDER BY estat_taula_data DESC;
    ";

    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $this->last_row = mysqli_fetch_assoc($this->qry_result);

    if ($this->total_rows = mysqli_num_rows($this->qry_result))
      return $this->last_row;

    $this->error = "Reserva no trobada";
//$this->mostra_error();
    return false;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******  EXTENDRE_RESERVA    ******** */
  /*   * ************************************* */
  /*   * ************************************* */
  /**/

  public function extendreReserva() {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";


    $torn = $_SESSION['torn'];
    $data = $_SESSION['data'];
    $resid = $_POST['id_reserva'];
    $taulaOrig = 0;
    $taulaDesti = $_POST['estat_taula_taula_id'];
    $ret = $_POST['id_reserva'] . " * $taulaOrig";


    $query = "SELECT * FROM " . ESTAT_TAULES . " 
    WHERE estat_taula_data = '$data'
    AND estat_taula_torn = $torn
    AND reserva_id = $resid
    AND (estat_taula_grup = 0 OR estat_taula_grup = estat_taula_taula_id)";

    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($this->qry_result);
    $taulaOrig = $row['estat_taula_taula_id'];

    $estatSQL = "SELECT * FROM " . ESTAT_TAULES . " 
      
      WHERE (estat_taula_data<'$data 23:59:59' 
      AND estat_taula_data>='$data' 
      AND estat_taula_torn=$torn      
      AND estat_taula_taula_id = " . $taulaDesti . ")
      OR (estat_taula_data='" . $this->data_BASE . "' AND estat_taula_taula_id = " . $taulaDesti . ")
      
      ORDER BY estat_taules_timestamp DESC, estat_taula_id DESC";

    $this->reg_log("extendreReserva $resid");

    $this->qry_result = mysqli_query($this->connexioDB, $estatSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($this->qry_result);
    if (!$row['estat_taula_nom'])
      $row['estat_taula_nom'] = $_POST['estat_taula_taula_id'];

    $insertSQL = sprintf("INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
    VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($_POST['data'], "datePHP"), $this->SQLVal($row['estat_taula_nom'], "text"), $this->SQLVal($torn, "text"), $this->SQLVal($taulaDesti, "text"), $this->SQLVal(0, "text"), $this->SQLVal($row['estat_taula_x'], "text"), $this->SQLVal($row['estat_taula_y'], "text"), $this->SQLVal($row['estat_taula_persones'], "zero"), $this->SQLVal($row['estat_taula_cotxets'], "zero"), $this->SQLVal($taulaOrig, "text"), $this->SQLVal($row['estat_taula_plena'], "text"), $this->SQLVal($_SESSION['admin_id'], "text"));

    $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $id = ((is_null($___mysqli_res = mysqli_insert_id($this->connexioDB))) ? false : $___mysqli_res);


//DELETE REDUNDANTS
    $deleteSQL = sprintf("DELETE FROM " . ESTAT_TAULES . "
      WHERE estat_taula_taula_id = %s 
      AND estat_taula_data=%s 
      AND estat_taula_torn=%s 
      AND estat_taula_id<>%s", $this->SQLVal($taulaDesti, "text"), $this->SQLVal($data, "datePHP"), $this->SQLVal($torn, "text"), $this->SQLVal($id, "text"));

    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    return $query . " - " . $row['estat_taula_taula_id'];
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   LOAD_RESERVA  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function load_reserva($id_reserva, $T_RESERVES = T_RESERVES) {
    $query = "SELECT * FROM " . $T_RESERVES . " 
    LEFT JOIN client ON " . $T_RESERVES . ".client_id=client.client_id
    LEFT JOIN " . ESTAT_TAULES . " ON " . $T_RESERVES . ".id_reserva=" . ESTAT_TAULES . ".reserva_id
    WHERE " . $T_RESERVES . ".id_reserva='" . $id_reserva . "'";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $this->last_row = mysqli_fetch_assoc($this->qry_result);
    if ($this->total_rows = mysqli_num_rows($this->qry_result))
      return $this->last_row;

    $this->error = "Reserva no trobada";
    return false;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   VALIDA_RESERVA  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function valida_reserva($taula, $data = "NO") {
    if ($data == "NO")
      return true;
    if ($data < "2011")
      return false;

    return true;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   ACCORDION_RESERVES  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function accordion_reserves($filtre = "TRUE", $cerca = "") {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

    if ($filtre == "TRUE" || empty($filtre)) {
      if (!isset($_SESSION))
        session_start();
      switch ($_SESSION['modo']) {
        case 3://FUTUR
          $filtre = "data>='" . $_SESSION['data'] . "' ";
          break;
        case 4://TOT
          $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
          break;

        case 5://NOMES ESBORRADES
        case 6://ESBORRADES + TOTES
          $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
          $bdDel = "canborrell_del.";
          break;

        case 2://DIA
          $filtre = "data='" . $_SESSION['data'] . "' ";
          break;

        default:
        case 1://AVUI + TORN
          $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn='" . $_SESSION['torn'] . "' ";
          break;
      }
    }


    $html = "";
    $query = "SELECT *,0 AS deleted FROM " . T_RESERVES . " 
    LEFT JOIN client ON " . T_RESERVES . ".client_id=client.client_id
    INNER JOIN " . ESTAT_TAULES . " ON " . T_RESERVES . ".id_reserva = " . ESTAT_TAULES . ".reserva_id
    WHERE $filtre ";

    $query .= "ORDER BY client_cognoms, data , hora , data_creacio";


    if (isset($cerca) && !empty($cerca) && $cerca != "" && $cerca != "undefined" && $cerca != "null" && $cerca != "CERCA...")
      $query = $this->qryCercaReserva($cerca, $filtre);
//echo $query;echo "                ***********     "; 
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $this->total_rows = mysqli_num_rows($this->qry_result);
// echo $query;
//  echo $this->total_rows;die();
    if (!$this->total_rows)
      $html = "<h3>No hi ha reserves</h3>";
    /** TODO si en troba més d'una */
    $n = 0;
    while ($row = $this->last_row = mysqli_fetch_assoc($this->qry_result)) {
      if ($row['estat_taula_id'] > 0) {
        $taules = '<span class="retol_info">Taula:</span> <span class="taules">' . $row['estat_taula_nom'] . '</span><br/>';
      }

      if ($row['client_id'] <= 0) { //SI FALTA CLIENT POSA "NO DEFINIT"
        $row["client_id"] = 1;
        $row["client_cognoms"] = "Client NO DEFINIT";
      }


      $torn = $this->torn($row['data'], $row['hora']);
      $comensals = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
      $body = $this->mail_body($row['data'], $row['hora']);

      $deleted = $row['deleted'] ? ' style="background:red" ' : '';
      
      $obs = trim($row['observacions']);
      if (!empty($obs)) {
        $sobret = '<div style="position:relative;left:0" class="ui-icon ' . ($row['reserva_info'] & 16 ? "ui-icon-mail-open" : "ui-icon-mail-closed") . '" title="Observacions del client">' . (strlen($row['observacions']) + 5) . '</div>';
      }
      else
        $sobret = "";

      $superinfo = "";
      $online = $row['reserva_info'] & 1 ? '<div class="online" title="Reserva ONLINE">' . $sobret . '</div>' : '';
      $chekataula = $row['reserva_info'] & 32 ? 'checked' : '';
      $class_ataula = $chekataula?"ataula":"";
      
      $pastis = $row['reserva_pastis'] == 1 ? '<div class="pastis" title="Demana pastís"></div>' : '';
      if ($row['client_nom'] == "SENSE_NOM")
        $row['client_nom'] = "";
      $nom = '<div class="acn" style="">' . substr($row['client_cognoms'] . ", " . $row['client_nom'], 0, 27) . '</div>';
      $paga_i_senyal = (floatval($row['preu_reserva']) ) ? '<span class="paga-i-senyal" >' . $row['preu_reserva'] . '€</span>' : '';
      $impagada = ( $row['estat'] != 100) ? "background:#EDFF00;" : "";
      $title = ( $row['estat'] != 100) ? 'title="Pendent de pagament"' : "";

      $ataula = '<input title="Són a taula" type="checkbox" style="float:right;position:relative;right:-2px;bottom:11px;" id="switch-'.$row['id_reserva'].'" idr="'.$row['id_reserva'].'" class="chekataula"  '.$chekataula.'>';
    // $ataula = "";
      
      $data = "";
      $html .= <<< EOHTML
          <h3 $deleted style="{$impagada} clear:both;" {$title} class="{$class_ataula}">
          
            <a n="$n" href="form_reserva.php?edit={$row['id_reserva']}&id={$row['id_reserva']}" class="fr" taula="{$row['estat_taula_taula_id']}" id="accr-{$row['id_reserva']}"><span class="idr">{$row['reserva_id']}</span>&rArr;{$data}{$row['hora']} | <span class="act">{$row['estat_taula_nom']}&rArr;{$comensals}/{$row['cotxets']}</span>  $online $paga_i_senyal $pastis $nom </a>
              
 $ataula       
 </h3>
         
EOHTML;

      $n++;
    }

    //$html = $_SESSION['admin_id'].$html;
    return $html;
  }

  public function superInfoReserva($row) {
    if (!is_array($row)) {
      $row = $this->load_reserva($row);
    }

    $torn = $this->torn($row['data'], $row['hora']);
    $comensals = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
    $body = $this->mail_body($row['data'], $row['hora']);

    if ($_SESSION['permisos'] >= 64) {
      $elimina = '<div class="delete reserva ui-state-default ui-corner-all">
                    <a href="taules.php?del_reserva=' . $row['id_reserva'] . '" del="' . $row['id_reserva'] . '">Elimina</a></div>';
    }

    $comensals = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
    $body = $this->mail_body($row['data'], $row['hora']);

    $superinfo = <<< EOHTML
        <div>
        ID:<b> {$row['reserva_id']}</b>
          <table>
              <tr class="taulaf1">
                <td>Coberts</td><td>Taula</td><td>Hora</td><td>Torn</td>
              </tr>
              <tr class="taulaf2">
                <td>$comensals</td><td>{$row["estat_taula_nom"]}</td><td>{$row["hora"]}</td><td>$torn</td>
              </tr>
              <tr class="taulaf1">
                <td>Adults</td><td>10-14</td><td>4-9</td><td>Cotxets</td>
              </tr>
              <tr class="taulaf2">
                <td>  {$row["adults"]}</td><td>{$row["nens10_14"]}</td><td>{$row["nens4_9"]}</td><td>{$row["cotxets"]}</td>
              </tr>
            </table>
            
            <p>
            
              <b>{$row["client_cognoms"]}, {$row["client_nom"]}</b><br/>
                <a href="mailto:{$row["client_email"]}?subject=Reservas Can Borrell&amp;body={$body}">{$row["client_email"]}</a> <br/>
              <b>{$row["client_mobil"]} - {$row["client_telefon"]}</b><br/>
                <span class="conflicte">{$row["client_conflictes"]}</span>
            </p>
            $elimina
                    </div>
EOHTML;
    return $superinfo;
  }

  public function qryCercaReserva($cerca, $filtre) {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

    $bbdd = "canborrell.";

//echo $filtre." / ".$_SESSION['modo'];
    if ($filtre == "TRUE" || empty($filtre)) {
      if (!isset($_SESSION))
        session_start();
      switch ($_SESSION['modo']) {
        case 1://AVUI + TORN
          $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn='" . $_SESSION['torn'] . "' ";
          break;
        case 3://FUTUR
          $filtre = "data>='" . $_SESSION['data'] . "' ";
          break;
        case 4://TOT
          $filtre = "TRUE ";
          break;

        case 5://NOMES ESBORRADES
        case 6://ESBORRADES + TOTES
          $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
          $bdDel = "canborrell_del.";
          break;



        case 2://DIA
        default:
          $filtre = "data='" . $_SESSION['data'] . "' ";
          break;
      }
    }

    $query = "SELECT *,client.client_id AS client_client_id, 0 AS deleted FROM " . T_RESERVES . " 
      LEFT JOIN " . "client ON " . T_RESERVES . ".client_id=client.client_id
      LEFT JOIN " . ESTAT_TAULES . " ON " . T_RESERVES . ".id_reserva = " . ESTAT_TAULES . ".reserva_id 
      
      WHERE  (
      reserva_id LIKE '%$cerca%' OR
      client_cognoms LIKE '%$cerca%' OR
      client_nom LIKE '%$cerca%' OR
      CONCAT (client_nom,' ',client_cognoms) LIKE '%$cerca%' OR
      CONCAT (client_cognoms,', ',client_nom) LIKE '%$cerca%' OR
      client_telefon LIKE '%$cerca%' OR
      client_mobil LIKE '%$cerca%' OR
      client_email LIKE '%$cerca%'
      )
      AND estat=100 AND " . T_RESERVES . ".client_id>0 AND $filtre 

      ";
    $order = " ORDER BY data DESC, hora DESC, data_creacio DESC";
//echo $query;
    return $query . $order;
//return $this->charset($query.$order);
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ******   PRINT LLISTA RESERVES  ******** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ************************************* */

  public function print_llista_reserves($filtre = "TRUE", $cerca = "") {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

    $class = "torn";

    if ($filtre == "TRUE" || empty($filtre)) {
      if (!isset($_SESSION))
        session_start();
//echo "**$filtre**".$_SESSION['modo'];
//$modo=$_SESSION['modo'];
      $modo = 1;
      switch ($modo) {
        case 1://AVUI + TORN
          $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn='" . $_SESSION['torn'] . "' ";
          break;
        case 3://FUTUR
          $filtre = "data>='" . $_SESSION['data'] . "' ";
          break;
        case 4://TOT
          $filtre = "TRUE ";
          break;

        case 2://DIA
        default:
          $filtre = "data='" . $_SESSION['data'] . "' ";
          break;
      }
    }
    else {
      switch ($filtre) {
        case "DIA_TORN"://AVUI + TORN
          $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn='" . $_SESSION['torn'] . "' ";
          break;
        case "DIA_TORN1"://AVUI + TORN
       //   $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn=1 AND hora<'15:00'";
          $filtre = "data='" . $_SESSION['data'] . "' AND hora<'15:00'";
          $class = "torn1";
          break;
        case "DIA_TORN2"://AVUI + TORN
         // $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn=2 AND hora>='15:00'";
          $filtre = "data='" . $_SESSION['data'] . "' AND hora>='15:00'";
          $class = "torn2";
          break;
        case "FUTUR"://FUTUR
          $filtre = "data>='" . $_SESSION['data'] . "' ";
          break;
        case "TOT"://TOT
          $filtre = "TRUE ";
          break;

        case "SETMANA"://SETMANA
          $filtre = " data>='" . $_SESSION['data'] . "' AND data<=DATE_ADD('" . $_SESSION['data'] . "',INTERVAL 7 DAY)";
          break;

        case "MES"://MES
          $filtre = "data>='" . $_SESSION['data'] . "' AND data<=DATE_ADD('" . $_SESSION['data'] . "',INTERVAL 1 MONTH)";
          break;

        case 2://DIA
        default:
          $filtre = "data='" . $_SESSION['data'] . "' ";
          break;
      }
    }
    $data = $_SESSION['data'];
    $query = "SELECT * FROM missatge_dia WHERE missatge_dia_data='$data'";

    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = $this->last_row = mysqli_fetch_assoc($this->qry_result);
    $html = '<h5>' . $row['missatge_dia_text'] . '</h5>';

    $query = "SELECT *, (adults + nens10_14 + nens4_9) AS sm 
    FROM " . T_RESERVES . " 
    LEFT JOIN client ON " . T_RESERVES . ".client_id=client.client_id
    INNER JOIN " . ESTAT_TAULES . " ON " . T_RESERVES . ".id_reserva=" . ESTAT_TAULES . ".reserva_id
    WHERE " . T_RESERVES . ".client_id>0 AND $filtre 
    ORDER BY data , estat_taula_torn , sm , hora , client.client_cognoms, data_creacio    ";
    if (isset($cerca) && !empty($cerca) && $cerca != "" && $cerca != "undefined" && $cerca != "null")
       $query = $this->qryCercaReserva($cerca, $filtre);

    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!$total = $this->total_rows = mysqli_num_rows($result))
      $html .= "No hi ha reserves";
    /** TODO si en troba més d'una */
    $n = 0;
    $html .= '          <div class="dreta">
            <table cellspacing="0" cellpadding="0" class="' . $class . '">
              <tr class="taulaf1">
                <td><b>Total</b></td>
                <td><b>Cotxets</b></td>
                <td><b>J&uacute;nior</b></td>
                <td><b>Infantil</b></td>
                <td><b>Hora</b></td>
                <td><b>Taula</span></b></td>
                <td class="columna-nom"><b>Nom</b></td>
                <td><b>ID</b></td>
              </tr>
';

    while ($row = $this->last_row = mysqli_fetch_assoc($result)) {
      if ($row['estat_taula_id'] > 0) {
        $taules = '<span class="retol_info">Taula:</span> <span class="taules">' . $row['estat_taula_taula_id'] . '</span>';
      }

      $online = ($row['reserva_info'] & 1) ? "online" : "in-situ";
      $hora_15 = ($row['hora'] >= "15:00") ? "hora-15" : "hora-mati";

      $torn = $this->torn($_SESSION['data'], $row['hora']);
      $torn = '<span class="taules"> ' . $torn . '</span>';
      $row['client_nom'] = ", " . $row['client_nom'];
      if ($row['client_nom'] == ", SENSE_NOM")
        $row['client_nom'] = "";
      if ($row['client_nom'] == ",  ")
        $row['client_nom'] = "";
      $nom = strtoupper(substr($row['client_cognoms'] . $row['client_nom'], 0, 25));
      $total = $row['nens4_9'] + $row['nens10_14'] + $row['adults'];
      $par = ($n & 1) ? "odd" : "even";

//$comanda=$this->plats_comanda($row['id_reserva']);
//$amagat = empty($row['observacions'])?" amagat":" mostrat";
      $comanda = $this->plats_comanda($row['id_reserva']);
      $resposta = '<span style="color:red">  >> ' . $row['resposta'] . '</span>';
      $row['observacions'] .= ($row['resposta'] ? $resposta : '');
      $saltaobs = empty($row['observacions']) ? "" : "<br/>";
      $amagat = " amagat";
      $pastis = $row['reserva_pastis']?"<br><b>Pastís: " . $row['reserva_info_pastis']."</b>":"";
//echo $row['reserva_pastis']==true; 11
      if ($n == 11 && false) {
        $html .= '
                <td><b>Total</b></td>
                <td><b>Cotxets</b></td>
                <td><b>J&uacute;nior</b></td>
                <td><b>Infantil</b></td>
                <td><b>Hora</b></td>
                <td><b>Taula</span></b></td>
                <td class="columna-nom"><b>Nom</b></td>
                <td><b>ID</b></td>
              </tr>
        
        <div class="pageBreak"> &nbsp; </div>';
        $n = 0;
      }
      $n++;

      $paga = (floatval($row['preu_reserva']) > 0) ? "(Psenyal:{$row['preu_reserva']})" : "";
      $html .= <<< EOHTML
                    <tr class="taulaf2 {$par}">
                <td class="contador"><b>{$total}</b></td>
                <td class="contador">{$row['cotxets']}</td>
                <td class="contador">{$row['nens10_14']}</td>
                <td class="contador">{$row['nens4_9']}</td>
                <td class="td-hora {$hora_15} {$online}"><b  class="xx-print-taula">{$row['hora']}</b></td>
                <td><span class="print-taula">{$row['estat_taula_nom']}</span></td>
                <td><b>{$nom} - {$row['client_mobil']} <span class="garjola">{$row['client_conflictes']}</span></b>
                {$saltaobs}<em>{$row['observacions']}{$paga}</em><span>{$comanda} {$pastis}</span></td>
                <td>{$row['id_reserva']} </td>
              </tr>
              <tr  class="observacions {$par} {$amagat}"><td colspan="11">&nbsp;</td></tr>
      
EOHTML;
    }
    $html .= '</table> </div>   
<div style="clear:both;"></div> </div>';
//print_r($row);
    return $html;
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ******   CLIENTS  ******** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

  public function autocomplete_reserves($q) {

    if (isset($_SESSION['order']))
      $order = "ORDER BY client_cognoms";
    $order = $_SESSION['llista_reserves_order'] ? ("ORDER BY " . $_SESSION['llista_reserves_order']) : "ORDER BY client_cognoms";


    switch ($_SESSION['modo']) {
      case 3://FUTUR
        $filtre = "data>='" . $_SESSION['data'] . "' ";
        break;
      case 4://TOT
        $filtre = "TRUE ";
        break;

      case 5://NOMES ESBORRADES
      case 6://ESBORRADES + TOTES
        $filtre = "data >= DATE_SUB(NOW(), INTERVAL 10 DAY)";
        $bdDel = "canborrell_del.";
        break;

      case 2://DIA
        $filtre = "data='" . $_SESSION['data'] . "' ";
        break;

      default:
      case 1://AVUI + TORN
        $filtre = "data='" . $_SESSION['data'] . "' AND estat_taula_torn='" . $_SESSION['torn'] . "' ";
        break;
    }

    if (is_numeric($q) && $q > 5000 && $q < 99999)
      $q = "ID" . $q;
    $were = "WHERE $filtre ";

    $query = "SELECT * 
      FROM " . T_RESERVES . " 
      LEFT JOIN " . ESTAT_TAULES . " ON reserva_id=id_reserva
      LEFT JOIN client ON " . T_RESERVES . ".client_id=client.client_id
      $were 
      AND
      (
        CONCAT('ID',id_reserva) = '$q' OR
        id_reserva = '$q' OR
        client_nom LIKE '%$q%' OR
        client_cognoms LIKE '%$q%' OR
        CONCAT(client_nom,' ',client_cognoms) LIKE '%$q%' OR
        CONCAT(client_cognoms,', ',client_nom) LIKE '%$q%' OR
        CONCAT(client_cognoms,' ',client_nom) LIKE '%$q%' OR
        client_conflictes LIKE '%$q%' OR
        observacions LIKE '%$q%'        
      )
      ";

    $query .= $order;
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $this->total_rows = mysqli_num_rows($this->qry_result);

    while ($this->last_row = $row = mysqli_fetch_assoc($this->qry_result)) {


      $key = $row['client_cognoms'] . ", " . $row['client_nom'] . ", " . $row['id_reserva'] . ", " . $row['estat_taula_taula_id'] . " (" . $row['client_mobil'] . " - " . $row['client_telefon'] . ")";
      $key2 = $row['client_cognoms'] . ", " . $row['client_nom'];
      $value = $row['client_id'];

      $reserves .= "$key2|$value\n";
    }
    return $reserves;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   COMBO_CLIENTS  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function combo_clients($client_id = -1) {
    if ($client_id < 1)
//$client_id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
      $client_id = mysqli_insert_id($this->connexioDB);
//$this->connectaBD();  
    $query = "SELECT * FROM client ORDER BY client_cognoms";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $this->last_row = mysqli_fetch_assoc($this->qry_result);
    $this->total_rows = mysqli_num_rows($this->qry_result);

    $options = '<select  class="combo_clients required" name="client_id" style="width:495px"  title="Selecciona un client">
        <option value="0">---------  client  ---------</option>';
    do {
      $row_client = $this->last_row;

      $sel = ((int) $row_client['client_id'] == (int) $client_id) ? ' selected="selected"' : "";
      $options .= '
      <option value="' . $row_client['client_id'] . '" ' . $sel . '>' .
          $row_client['client_cognoms'] . ', ' . $row_client['client_nom'] .
          '</option>';
    } while ($this->last_row = mysqli_fetch_assoc($this->qry_result));
    $options .= '</select>';
    $options .= '<div class="dades_client">';
    $options .= $this->htmlDadesClient($client_id);
    $options .= '</div>';
//$options.='<input id="autoc_client">';
    return $options;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   HTML_DADES_CLIENTS  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function htmlDadesClient($client_id = 0) {
    if ($client_id < 1)
      return '';
    if ($client_id < 1)
      return 'Selecciona client o crea\'n un:';

    $query = "SELECT * FROM client 
    WHERE client_id=$client_id
    ORDER BY client_cognoms";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row_client = $this->last_row = mysqli_fetch_assoc($this->qry_result);
    $this->total_rows = mysqli_num_rows($this->qry_result);

    if ($this->total_rows < 1)
      return "No hi ha clients";
    $body = $this->mail_body();
    $options .= '<a href="mailto:' . $row_client['client_email'] . '?subject=Reservas Can Borrell&amp;body=' . $body . '">' . $row_client['client_email'] . '</a><br/>';
    $options .= $row_client['client_mobil'] . ' / ' . $row_client['telefon'] . '<br/>';
    $options .= '<span class="conflicte">' . $row_client['client_conflictes'] . '</span><br/>';
    $options .= '<input type="hidden" id="num_mobil" value="' . $row_client['client_mobil'] . '"/>';
    return $options;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   ESBORRA_CLIENT  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function esborra_client($client_id) {
    if ($client_id < 1)
      return false;

    $this->reg_log("esborra_client($client_id)");


    $comprovaSQL = "SELECT * FROM client 
LEFT JOIN " . T_RESERVES . " ON " . T_RESERVES . ".client_id=client.client_id
WHERE data >= DATE_SUB(NOW(), INTERVAL 1 DAY)
AND client.client_id='$client_id'";
    $this->qry_result = mysqli_query($this->connexioDB, $comprovaSQL) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (mysqli_num_rows($this->qry_result))
      return "NO POTS ESBORRAR UN CLIENT AMB RESERVES FUTURES";

    $deleteSQL = "DELETE FROM client WHERE client_id=$client_id";
    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (!isset($_REQUEST['a']))
      header("Location: " . $_SERVER['PHP_SELF']);
    return $this->accordion_clients();
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   INSERTA_CLIENT  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function inserta_client() {
    if (empty($_REQUEST['client_mobil']) || empty($_REQUEST['client_cognoms']) || empty($_REQUEST['client_nom']))
      return false;

    $this->reg_log("inserta_client");
    $unic = "SELECT client_id FROM client WHERE client_mobil<>'999999999' AND client_mobil='" . $_POST['client_mobil'] . "'";
    $this->qry_result = mysqli_query($this->connexioDB, $unic) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nr = mysqli_num_rows($this->qry_result);
//die ()
    if ($nr) {
      return $this->controlClient($_REQUEST['client_id'], $_REQUEST['client_mobil']);
    }
    if ($_REQUEST['client_nom'] == "SENSE_NOM")
      $_REQUEST['client_nom'] = " ";
    $insertSQL = sprintf("INSERT INTO client (client_nom, client_cognoms, client_adresa, 
      client_localitat, client_cp, client_dni, client_telefon, client_mobil, client_email, client_conflictes) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($_REQUEST['client_nom'], "text"), $this->SQLVal($_REQUEST['client_cognoms'], "text"), $this->SQLVal($_REQUEST['client_adresa'], "text"), $this->SQLVal($_REQUEST['client_localitat'], "text"), $this->SQLVal($_REQUEST['client_cp'], "text"), $this->SQLVal($_REQUEST['client_dni'], "text"), $this->SQLVal($_REQUEST['client_telefon'], "text"), $this->SQLVal($_REQUEST['client_mobil'], "text"), $this->SQLVal($_REQUEST['client_email'], "text"), $this->SQLVal($_REQUEST['client_conflictes'], "text"));
// echo $insertSQL;

    $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//if (!isset($_REQUEST['a']))  header("Location: ".$_SERVER['PHP_SELF']);
//$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    $id = mysqli_insert_id($this->connexioDB);
    return $id;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      controlClient     *********** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function controlClient($client_id, $client_mobil) {

    $this->reg_log("controlClient($client_id, $client_mobil) ", 1);
// SI ES PERMUTA O EXTEN

    if (isset($client_mobil) && (!$client_id || $client_id == "#")) {
//echo "P1: ".$client_id." / ".$client_mobil.PHP_EOL;
      $query = "SELECT client_id FROM client WHERE client_mobil='$client_mobil'";
      $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      if (!mysqli_num_rows($this->qry_result) || $client_mobil == "999999999") {
// SI NO EXISTEIX EL CREA
//echo "P2: ".$client_id." / ".$client_mobil.PHP_EOL;
        $_POST['client_id'] = $client_id = $this->inserta_client();
        $this->reg_log("CREAT CLIENT: $client_id - " . $_POST['client_cognoms'] . " - $client_mobil");
      }
      else {
// SI EXISTEIX, ACTUALITZA VALORS
//echo "P3: ".$client_id." / ".$client_mobil.PHP_EOL;
        $_POST['client_id'] = $client_id = mysqli_result($this->qry_result, 0, 'client_id');
        $_POST['client_telefon'] = isset($_POST['client_telefon']) ? $_POST['client_telefon'] : "";
        $_POST['client_conflictes'] = isset($_POST['client_conflictes']) ? $_POST['client_conflictes'] : "";
        $updateSQL = sprintf("UPDATE client SET  client_cognoms=%s, client_nom=%s,  client_telefon=%s, client_conflictes=%s, client_email=%s
                WHERE client_id=%s", $this->SQLVal($_POST['client_cognoms'], "text"), $this->SQLVal($_POST['client_nom'], "text"), $this->SQLVal($_POST['client_telefon'], "text"), $this->SQLVal($_POST['client_conflictes'], "text"), $this->SQLVal($_POST['client_email'], "text"), $this->SQLVal($client_id, "text"));


        $this->qry_result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
        $this->reg_log("CLIENT EXISTENT: $client_id - " . $_POST['client_cognoms'] . " - $client_mobil", 1);
      }
    }

    return $client_id;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      UPDATE_CLIENT     *********** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function update_client() {
    $this->reg_log("update_client " . $_POST['client_id'] . '  ' . $_POST['client_mobil']);

    $updateSQL = sprintf("UPDATE client SET  client_id=%s, client_nom=%s, client_cognoms=%s, client_adresa=%s, client_localitat=%s,
      client_cp=%s,   client_dni = %s, client_telefon = % s, client_mobil = %s, client_email = %s, client_conflictes=%s 
      WHERE client_id=%s", $this->SQLVal($_POST['client_id'], "text"), $this->SQLVal($_POST['client_nom'], "text"), $this->SQLVal($_POST['client_cognoms'], "text"), $this->SQLVal($_POST['client_adresa'], "text"), $this->SQLVal($_POST['client_localitat'], "text"), $this->SQLVal($_POST['client_cp'], "text"), $this->SQLVal($_POST['client_dni'], "text"), $this->SQLVal($_POST['client_telefon'], "text"), $this->SQLVal($_POST['client_mobil'], "text"), $this->SQLVal($_POST['client_email'], "text"), $this->SQLVal($_POST['client_conflictes'], "text"), $this->SQLVal($_POST['client_id'], "text"));

    $this->qry_result = $this->log_mysql_query($updateSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!isset($_REQUEST['a']))
      header("Location: " . $_SERVER['PHP_SELF']);
    return $this->accordion_clients();
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   LOAD_CLIENT  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function load_client($client_id, $json = false) {
    $query = "SELECT * FROM client 
    LEFT JOIN llista_negra ON (llista_negra_mobil=client_mobil OR llista_negra_mail=client_email)
    WHERE client.client_id='" . $client_id . "'";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $this->last_row = mysqli_fetch_assoc($this->qry_result);
    if ($this->total_rows = mysqli_num_rows($this->qry_result) && $json) {
      $this->last_row['jsonid'] = $_POST['id'];

//foreach($this->last_row as $k=>$v) $this->last_row[$k]=utf8_encode($v);

      echo json_encode($this->last_row);
      return;
    }
    if ($this->total_rows = mysqli_num_rows($this->qry_result))
      return $this->last_row;

    $this->error = "Client no trobat";
//$this->mostra_error();
    return false;
  }

  public function cadenaClient($id) {
    if (!$id)
      return "SENSE DADES";
    if ($row = $this->load_client($id)) {
      return '(' . $row['client_id'] . ') ' . $row['client_nom'] . ' ' . $row['client_cognoms'];
    }
    return '(ADMIN) ' . $this->usuari($id);
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   ACCORDION_CLIENTS  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function accordion_clients($filtre = 0, $cerca = "") {
    switch ($filtre) {
      case 1:
        $were = " WHERE " . T_RESERVES . ".id_reserva>0 AND data='" . $_SESSION['data'] . "' AND estat_taula_torn=" . $_SESSION['torn'];
        break;
      case 2:
        $were = " WHERE " . T_RESERVES . ".id_reserva>0 AND data='" . $_SESSION['data'] . "'";
        break;

      case 4:
        break;

      case 3:
      default:
        $were = " WHERE TRUE";
    }
    $query = "SELECT DISTINCT estat_taula_torn, estat_taula_taula_id, client.client_id AS client_client_id, 
        client.*, " . T_RESERVES . ".id_reserva, " . T_RESERVES . ".data, " . T_RESERVES . ".hora,
        data>=NOW() AS reservat
        
FROM client 
LEFT JOIN " . T_RESERVES . " ON " . T_RESERVES . ".client_id = client.client_id AND " . T_RESERVES . ".data >= '" . $_SESSION['data'] . "' 
LEFT JOIN " . ESTAT_TAULES . " ON " . ESTAT_TAULES . ".reserva_id=" . T_RESERVES . ".id_reserva
$were 
ORDER BY client_cognoms, data";

    if (!empty($cerca) && $cerca != "undefined" && $cerca != "Cerca..." && $cerca != "CERCA...")
// $query=$this->qryCercaClient($cerca, $filtre);
      $query = $this->qryCercaReserva($cerca, $filtre);
//echo $query;
    $html = "";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!$this->total_rows = mysqli_num_rows($this->qry_result))
      $html = "<h3>No hi ha clients</h3>";

//$id = ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    $id = mysqli_insert_id($this->connexioDB);
    $m = 0;
    while ($row = $this->last_row = mysqli_fetch_assoc($this->qry_result)) {
      if ($row['client_mobil'] == "999999999" || $row['client_mobil'] == "000000000" || $row['client_mobil'] == "000000001")
        $row['client_mobil'] = "Sense n&uacute;mero";

      $reservat = "";
      $reserva = "";
      if ($row['id_reserva']) {
        if ($row['reservat'])
          $reservat = '<span class="reservat">R </span>';
        $data = $this->cambiaf_a_normal($row['data']);
        $reserva = '<a href="form_reserva.php?edit=' . $row['id_reserva'] . '&id=' . $row['id_reserva'] . '" class="taules fr" taula="' . $row['estat_taula_taula_id'] . '" title="detall reserva" data="' . $data . '">(' . $row['id_reserva'] . ") | " . $data . " | " . $row['hora'] . ' |T' . $row['estat_taula_taula_id'] . '</a>';
        $delete = "";
      }
      else {
        $delete = '<div class="delete client ui-state-default ui-corner-all"><a href="taules.php?del_client=' . $row['client_client_id'] . '" del="' . $row['client_client_id'] . '">Elimina</a></div>';
      }

      if ($id > 0 && $row['client_client_id'] == $id)
        $insert = 'insert="' . $id . '"';
      else
        $insert = 'we="' . $row['client_client_id'] . '"';

      $body = $this->mail_body($row['data'], $row['hora']);
      $html .= <<< EOHTML
          <h3 $insert m="$m" class="ui-accordion-header ui-helper-reset ui-state-default ui-corner-all">
            <a href="form_client.php?edit={$row['client_client_id']}&id={$row['client_client_id']}" class="fc" title="detall client">
              {$row['client_cognoms']}, {$row['client_nom']} - {$row['client_mobil']}
              </a>
          <br/> $reservat $reserva</h3>

EOHTML;

      $m++;
    }
    return $html;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   qryCercaClient  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function qryCercaClient($cerca, $filtre = null) {
    $mob = explode("tel:", $cerca);
    $mob = $mob[1];
    $mob = explode("(", $mob);
    $mob = $mob[0];

    $query = "SELECT DISTINCT 
      client.client_id AS client_client_id, 
      client.*, 
      " . T_RESERVES . ".id_reserva,
      " . T_RESERVES . ".data,
      " . T_RESERVES . ".hora,
      data>NOW() AS reservat, 
      estat_taula_taula_id
      
      FROM client 
      LEFT JOIN " . T_RESERVES . " ON " . T_RESERVES . ".client_id = client.client_id AND " . T_RESERVES . ".data >='$filtre'
      LEFT JOIN " . ESTAT_TAULES . " ON " . ESTAT_TAULES . ".reserva_id = id_reserva AND " . T_RESERVES . ".data >='$filtre'

      WHERE 
      client_mobil = '$mob' 
      ORDER BY client_cognoms, data DESC";
    return $query;
  }

  /*   * ************************************ */
  /*   * ************************************ */
  /*   * ********   AUTOCOMPLETE  *********** */

  public function autocomplete_clients($q, $p) {
//if (is_numeric($q) && $q>2000 && $q<99999) $q="ID".$q;
    $GARJOLA = "";
    $r = FALSE;

    switch ($_SESSION['modo']) {
      case 1:
        $filtre = "data='" . $_SESSION['data'] . "' AND ";
//$filtre="data='".$_SESSION['data']."' AND estat_taula_torn='".$_SESSION['torn']."' AND ";
        break;

      case 2:
        $filtre = "data='" . $_SESSION['data'] . "' AND ";
        break;
    }
    $filtre = ($p == "modo") ? $filtre : "";

    $query = "SELECT DISTINCT 
      client.client_id, 
      client_nom, 
      client_cognoms, 
      client_mobil, 
      client_email, 
      client_conflictes  
      
      FROM client 
      LEFT JOIN " . T_RESERVES . " ON client.client_id=" . T_RESERVES . ".client_id 
      
      WHERE 
      $filtre

      (CONCAT('ID',id_reserva) = '$q' OR
      id_reserva LIKE '%$q%' OR
      client.client_id LIKE '%$q%' OR
      client_cognoms LIKE '%$q%' OR
      client_nom LIKE '%$q%' OR
      CONCAT(client_nom,' ',client_cognoms) LIKE '%$q%' OR
      CONCAT(client_cognoms,', ',client_nom) LIKE '%$q%' OR
      CONCAT(client_cognoms,' ',client_nom) LIKE '%$q%' OR
      client_mobil LIKE '%$q%' OR
      client_conflictes LIKE '%$q%')

      ORDER BY client_cognoms";
// echo $query;
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $this->total_rows = mysqli_num_rows($this->qry_result);

    /*
      $query = "SELECT * FROM llista_negra WHERE llista_negra_mobil LIKE '$q%'";
      $qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $r = mysqli_num_rows($this->qry_result);
      $GARJOLA = $r?'GARJOLA!!!':"";
     */
    if (!$this->total_rows) {
      $row['client_id'] = "";
      $row['client_email'] = "";
      $row['client_nom'] = "";
      $row['client_cognoms'] = "";
      $row['client_mobil'] = "";
      $row['client_conflictes'] = $GARJOLA;
    }

    /* */


    $clients0['label'] = "+++ Nou client (" . strtoupper($q) . ")|$q\n";
    $clients0['client_cognoms'] = is_numeric($q) ? "" : $q;
    $clients0['client_mobil'] = is_numeric($q) ? $q : "";
    $clients0['client_email'] = "";
    // $clients0['client_conflictes'] = $r?$GARJOLA:"";;
    $clients0['value'] = is_numeric($q) ? $q : "";

    while ($row = mysqli_fetch_assoc($this->qry_result)) {
      $br = array("<br>", "<br/>", "\n", "\r");


      $row['client_conflictes'] = str_replace($br, "", $row['client_conflictes']);

      // $query = "SELECT * FROM llista_negra WHERE llista_negra_mobil LIKE '$q%'";
      $query = "SELECT * FROM llista_negra WHERE llista_negra_mobil = '" . $row['client_mobil'] . "'";
      $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $row['client_conflictes'] = mysqli_num_rows($result) ? "GARJOLA!!!" : "";


      if (!empty($row['client_conflictes']))
        $conflictes = '***[' . $row['client_conflictes'] . ']*** ';
      else
        $conflictes = "";


      /*   */


      $key = "(" . $row['client_id'] . ") " . $conflictes . $row['client_nom'] . " " . $row['client_cognoms'] . " tel:" . $row['client_mobil'];


      if (empty($row['client_email']))
        $row['client_email'] = "";
      $row['label'] = $key;
      $row['value'] = $q;
      if ($p != "modo")
        $row['value'] = $row['client_mobil'];
      $clients[] = $row;
    }
    if (empty($clients) && $p != "modo") {
      $clients[] = $clients0;

      $query = "SELECT * FROM llista_negra WHERE llista_negra_mobil LIKE '$q%'";
      $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $r = mysqli_num_rows($this->qry_result);

      if ($r) {
        $row = mysqli_fetch_assoc($this->qry_result);
        $row['client_conflictes'] = "GARJOLA!!!";


        $clients1['label'] = $row['llista_negra_mobil'] . " >>> GARJOLA!!!";
        $clients1['client_cognoms'] = $row['llista_negra_mobil'];
        $clients1['client_mobil'] = $row['llista_negra_mobil'];
        $clients1['client_email'] = $row['llista_negra_mail'];
        $clients1['client_conflictes'] = $GARJOLA;
        $clients1['value'] = is_numeric($q) ? $q : "";



        $clients[] = $clients1;
      }
    }
//return $clients;


    return json_encode($clients);
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   clientHistoric  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function clientHistoric($client_id) {
    if (!$client_id)
      return false;

    $query = "SELECT * FROM " . T_RESERVES . " 
      INNER JOIN " . ESTAT_TAULES . " ON " . T_RESERVES . ".id_reserva = " . ESTAT_TAULES . ".reserva_id
      WHERE client_id = $client_id 
      ORDER BY data DESC
      ";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $k = 0;

    $s = " </td><td> ";
    $tds = "<thead><td>id_reserva $s data $s hora $s adults $s nens10_14 $s nens4_9 $s cotxets $s conflictes</td></thead>\n\n";
    while ($row = mysqli_fetch_array($Result1)) {
      $odd = (($k++ % 2) ? "odd" : "");
      $row["client_conflictes"] = "";
      if ($row['data'] > date("Y-m-d"))
        $odd .= " futur";
      $tds .= "<tr class='$odd'><td><a href='form_reserva.php?edit=" . $row["id_reserva"] . "&id=" . $row["id_reserva"] . "' taula='" . $row['estat_taula_taula_id'] . "' class='fr'>" . $row['id_reserva'] . $s . $this->cambiaf_a_normal($row['data']) . $s . $row['hora'] . $s . $row['adults'] . $s . $row['nens10_14'] . $s . $row['nens4_9'] . $s . $row['cotxets'] . $s . $row['client_conflictes'] . "</a> </td></tr>\n\n";
    }
    return "<table>$tds</table>";
  }

// ENVIA UN
  function recordatori_petites_3dies() {


    $html = " ... ";
    $query = "SELECT * FROM " . T_RESERVES . " WHERE (adults + nens10_14 + nens4_9)>=6 AND estat=100 AND  data <= ADDDATE(CURDATE(), INTERVAL 35 DAY) AND data>=CURDATE() AND  num_1=0";
    $reserves = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nr = mysqli_num_rows($reserves);

    $this->reg_log("<span class='cron'>recordatori_petites_3dies:</span>");
    $this->reg_log("$query >>>>>>>>>> $nr", 1);

    if (!$nr) {
      echo "TEST<br/><br/>RECORDATORI petites_3dies<br/>";
      echo $query;
      echo "<br/>NO HI HA RECORDATORIS 6p3d<br/><br/>";
      echo "<br/><br/><br/>";


      return false;
    }
    while ($row = mysqli_fetch_array($reserves)) {
      $args = array();
      $persones = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
//$persones.='p';
      $id_reserva = $row["id_reserva"];
      $data = $this->cambiaf_a_normal($row['data']);
      $hora = $row['hora'];
      $lang = $row['lang'];

      //$missatge = "Recuerde: reserva $id_reserva, el $data - $hora para $persones personas.Es IMPRESCINDIBLE que nos comunique cualquier cambio antes de las 11:00h: 936929723 - 936910605";

      $args[0] = $id_reserva;
      $args[1] = $data;
      $args[2] = $hora;
      $args[3] = $persones;
      $missatge = "Recordi: reserva %s, el %s - %s per a %s personas.Es IMPRESCINDIBLE que ens comuniqui qualsevol canvi abans de les 11:00h: 936929723 - 936910605";
      $missatge = gestor_reserves::SMS_language($missatge, $lang, $args);

      $this->enviaSMS($id_reserva, $missatge);
      //echo "<br/>ENVIAT: ".$missatge;

      $query_reserves = "UPDATE " . T_RESERVES . " SET num_1=1 WHERE id_reserva=" . $row["id_reserva"];
      $update = mysqli_query($this->connexioDB, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      $html .= $id_reserva . ", ";
    }



    return $html;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   REFRESH  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function refresh($update = false) {
    session_set_cookie_params(3600 * 24 * 7);
    if (!isset($_SESSION))
      session_start(); //REDUNDANT, PERO CADUCA!!!

    if (!isset($_SESSION['refresh']))
      $_SESSION['refresh'] = '2010-01-01';

//echo $_SESSION['refresh']." -- ".date("Y-m-d H:i:s");
    if ($_SESSION['refresh'] > date("Y-m-d H:i:s"))
      $_SESSION['refresh'] = date("Y-m-d");
    $data = $_SESSION['data'];
    $data_refresh = $_SESSION['refresh'];

    $data_BASE = $this->data_BASE;
    $query = "SELECT * FROM " . ESTAT_TAULES . "
      WHERE (
  estat_taula_data = '$data'
  AND estat_taules_timestamp > '$data_refresh'
  )
  OR (
  estat_taula_data = '$data_BASE'
  AND estat_taules_timestamp > '$data_refresh'
  )
  ORDER BY estat_taules_timestamp DESC";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $impagats = $this->netejaImpagatsTpv();
    if ($impagats || mysqli_num_rows($Result1)) {
      $row = mysqli_fetch_array($Result1);
      $_SESSION['refresh'] = $row['estat_taules_timestamp'];

      if ($update)
        return "no_change$data_refresh";
      return "refresh";
    }
    else
      return "no_change$data_refresh";
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */
  /*   * ******   FUNCIONS  ******** */
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */


  /*   * ****************************************************************************************************************************** */
  /*   * *******   guarda_missatge_dia   ********************************************************************************* */
  /*   * ****************************************************************************************************************************** */

  public function guarda_missatge_dia($text = "", $c) {
    if (!isset($_SESSION))
      session_start();

    $this->reg_log("guarda_missatge_dia:");
    $data = $_SESSION['data'];
    $torn = $_SESSION['torn'];
    $text = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $text) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    $query = "DELETE FROM missatge_dia 
    WHERE missatge_dia_data='$data'";
    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    $query = "INSERT INTO missatge_dia (missatge_dia_data, missatge_dia_torn, missatge_dia_text) VALUES ('$data','$torn','$text')";
//return $query;


    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return stripslashes($text);
  }

  /*   * ****************************************************************************************************************************** */
  /*   * *******  recupera_missatge_dia   ********************************************************************************* */
  /*   * ****************************************************************************************************************************** */

  public function recupera_missatge_dia($data = null, $torn = null) {
    if (!isset($_SESSION))
      session_start();
    if (!$data)
      $data = $_SESSION['data'];
    $torn = $_SESSION['torn'];

    $query = "SELECT * FROM missatge_dia 
    WHERE missatge_dia_data='$data'
    ORDER BY missatge_dia_id DESC";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!mysqli_num_rows($Result1))
      return;
    $row = mysqli_fetch_array($Result1);

    return stripslashes($row['missatge_dia_text']);
    return $query;
  }

  /*   * ****************************************************************************************************************************** */

  public function recupera_hores($idr_o_taula = null, $persones = null, $cotxets = 0) {
    $torn = $_SESSION['torn'];
    $mydata = $_SESSION['data'];

//$this->reset();
    $this->taulesDisponibles->tableHores = "estat_hores";
    $this->taulesDisponibles->tableMenjadors = "estat_menjador";

    $this->taulesDisponibles->data = $mydata; //echo "nem...$mydata - $torn ".BR.BR;
    $this->taulesDisponibles->torn = $torn;
    $this->taulesDisponibles->persones = $persones;
    $this->taulesDisponibles->cotxets = $cotxets;


//////////////////////////////////////////////////////////////////////////////
// Si ens passen $idr pro no persones, vol dir que estem editant una RESERVA
//////////////////////////////////////////////////////////////////////////////
    if (!$persones && !$cotxets && $idr_o_taula) {
      $this->taulesDisponibles->loadReserva($idr_o_taula);
    }
//////////////////////////////////////////////////////////////////////////////
// Si ens passen $idr pro i també persones, vol dir que estem creant una 
// reserva per una TAULA concreta.
//////////////////////////////////////////////////////////////////////////////
    elseif ($persones && $idr_o_taula) {// NOVA RESERVA, SEBEM LA TAULA I LES PERSONES
      $this->taulesDisponibles->loadTaula($idr_o_taula);
    }


    if ($torn == 1 || $torn == 2) {
//TORN1
      $this->taulesDisponibles->torn = 1;
      $dinar = $this->taulesDisponibles->recupera_hores(true);
//$taules=$this->taulesDisponibles->taules();
      $taules = $this->taulesDisponibles->taulesDisponibles();
      $taulaT1 = is_object($taules[0]) ? $taules[0]->id : 0;
      if (!$dinar)
        $dinar = "";
    }
    if ($torn == 1 || $torn == 2) {
//TORN2
      $this->taulesDisponibles->torn = 2;
      $dinarT2 = $this->taulesDisponibles->recupera_hores(true);
//$taules=$this->taulesDisponibles->taules();
      $taules = $this->taulesDisponibles->taulesDisponibles();
      $taulaT2 = is_object($taules[0]) ? $taules[0]->id : 0;
      if (!$dinarT2)
        $dinarT2 = "";

      $taulaT3 = 0;
      $sopar = "";
    }

    if ($torn == 3) {
//TORN3
      $this->taulesDisponibles->torn = 3;
      $sopar = $this->taulesDisponibles->recupera_hores(true);
//$taules=$this->taulesDisponibles->taules();
      $taules = $this->taulesDisponibles->taulesDisponibles();
      $taulaT3 = is_object($taules[0]) ? $taules[0]->id : 0;
      if (!$sopar)
        $sopar = "";
      $taulaT1 = $taulaT2 = 0;
      $dinar = $dinarT2 = '';
    }
    $json = array('dinar' => $dinar, 'dinarT2' => $dinarT2, 'sopar' => $sopar, 'taulaT1' => $taulaT1, 'taulaT2' => $taulaT2, 'taulaT3' => $taulaT3, 'error' => '');

    if ($taulaT1 || $taulaT2 || $taulaT3)
      return json_encode($json); // ARRAY AMB ELS TRES TORNS   

    $error = '<p class="error max_comensals">Has superat el maxim de comensals per aquest torn. <br/>No es poden crear mes reserves</p>';

    $error = $this->taulesDisponibles->llistaErrors();
    $json = array('dinar' => '', 'dinarT2' => '', 'sopar' => '', 'taulaT1' => '', 'taulaT2' => 0, 'taulaT3' => 0, 'error' => $error);
    return json_encode($json);

    $avis2 = '<input type="hidden" name="prohibit" class="required email"/>';
    return $avis;
  }

  
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  public function edita_hores($base = "", $torn = 1, $table = "estat_hores") {
    $this->reg_log("edita_hores($base, $torn, $table)");


    if (empty($table))
      $table = "estat_hores";

    if (!isset($_SESSION))
      session_start();
    if ($base == "BASE") {
      $data = $this->data_BASE;
//$torn=1;
    }
    else {
      $data = $_SESSION['data'];
      $torn = $_SESSION['torn'];
    }

    $torn100 = $torn + 100;
    $maxtorn = 0;


    $query = "SELECT * FROM $table
    WHERE 
    
    (estat_hores_data='$data' AND (estat_hores_torn = '$torn' OR estat_hores_torn = '$torn100' ))
    OR
    (estat_hores_data = '" . $this->data_BASE . "' AND (estat_hores_torn = '$torn' OR estat_hores_torn = '$torn100' ))
    
    ORDER BY estat_hores_hora, estat_hores_data DESC";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//echo $query;
    $req = ' class="ckbx_hora" ';

    $n = 0;

    $radio = '<table id="edita_hores"><tr>';

    $horac = isset($horac) ? $horac : NULL;
    $hora = isset($horac) ? $horac : NULL;
    $preradio = isset($preradio) ? $preradio : NULL;
    $nom = isset($nom) ? $nom : NULL;

    while ($row = mysqli_fetch_array($Result1)) {
      if ($horac == $row['estat_hores_hora'])
        continue;
      $horac = $row['estat_hores_hora'];
      if ($row['estat_hores_hora'] == $hora)
        continue;
      if ($row['estat_hores_hora'] == "00:00") {
        $maxtorn = $row['estat_hores_max'];
        continue;
      }

      $hora = $row['estat_hores_hora'];
      $max = $row['estat_hores_max'];
      if ($row['estat_hores_actiu'] == 1)
        $checked = 'checked="checked"';
      else
        $checked = "";

      $radio .= $preradio;

      $preradio = '<td><input type="checkbox" id="' . $nom . $row['estat_hores_id'] . '"  value="' . $row['estat_hores_hora'] . '" ' . $checked . ' class="ckbx_hora"  torn="' . $torn . '"/>
      <label for="' . $nom . 'h' . $row['estat_hores_id'] . '">' . $row['estat_hores_hora'] . '</label>';
      $preradio .= '<span class="edita-hores-max"><br>Màx: <input type="text" name="' . $nom . $row['estat_hores_id'] . '" class="max_hores" torn="' . $torn . '" value="' . $max . '"></span></td>';
      $req = "";
    }

    $radio .= $preradio;
    $max = "NO";
    $radio .= '<td style="color:#C00;padding-left:50px;"><span class="edita-hores-max">TOTAL TORN<br/>
    <input type="text" name="max_torn" class="max_hores" value="' . $maxtorn . '"  torn="' . $torn . '"> (0 = sense límit)
    <input type="hidden" id="max_torn" class="max_hores" value="00:00" readonly="readonly"  torn="' . $torn . '"></span></td>';
    $radio .= '</tr></table>';

    $this->taulesDisponibles->data = $_SESSION['data'];
    $this->taulesDisponibles->torn = $_SESSION['torn'];
    $checked = $this->taulesDisponibles->recupera_creaTaules() ? 'checked="checked"' : '';
    $radio .= '<br/><br/><input type="checkbox" id="creaTaules" ' . $checked . ' /> Creació automàtica de taules al formulari Online de reserves petites. <b>Només afecta el dia i torn actual!</b>';
    return $radio;
//return "RESULTAT: ".$query." ---- ".$torn;
  }

  /*   * ****************************************************************************************************************************** */
  /*   * *********   UPDATE HORES *********************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  public function update_hora($hora, $activa, $max, $base, $torn = null, $table = "estat_hores") {
    $this->reg_log("update_hora($hora, $activa, $max, $base, $torn)");

    if (empty($table))
      $table = "estat_hores";



    if (!isset($_SESSION))
      session_start();


    if ($base == "BASE")
      $data = $this->data_BASE;
    else
      $data = $_SESSION['data'];
    if (!$torn || $torn == "undefined")
      $torn = $_SESSION['torn'];

    if ($hora == "00:00")
      $torn += 100;

    $query = "DELETE FROM $table WHERE    
    (estat_hores_data='$data' AND estat_hores_hora='$hora' AND estat_hores_torn = '$torn')";
    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if ($activa == "0" || true) {
      $insertSQL = sprintf("INSERT INTO $table 
        (estat_hores_data, estat_hores_torn, estat_hores_hora, estat_hores_actiu, estat_hores_max) 
        VALUES (%s, %s, %s, %s, %s)", $this->SQLVal($data, "text"), $this->SQLVal($torn, "text"), $this->SQLVal($hora, "text"), $this->SQLVal($activa, "text"), $this->SQLVal($max, "text"));


      $Result1 = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }

    return $query . "<br/>\n<br/>\n" . $insertSQL;
//return $Result1?"ok":"ko: $insertSQL";
  }

  /*   * ****************************************************************************************************************************** */
  /*   * *********   UPDATE CREA TAULES *********************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  public function update_creaTaules($data, $torn, $activa) {
    $this->reg_log("update_creaTaules($data, $torn, $activa)");

    if (!isset($_SESSION))
      session_start();

    $mydata = $this->cambiaf_a_mysql($data);

    $query = "DELETE FROM estat_crea_taules WHERE    
    (estat_crea_taules_data='$mydata' AND estat_crea_taules_torn = '$torn')";
    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $insertSQL = sprintf("INSERT INTO estat_crea_taules 
    (estat_crea_taules_data, estat_crea_taules_torn, estat_crea_taules_actiu) 
    VALUES (%s, %s, %s)", $this->SQLVal($mydata, "text"), $this->SQLVal($torn, "text"), $this->SQLVal($activa, "text"));

    $Result1 = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    return $query . "<br/>\n<br/>\n" . $insertSQL;
  }

  
// FUNCIONS	recupera carta amb comanda inclosa
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  public function recuperaCarta($idr, $es_menu = false) {
    $lng = $this->lng;
    if ($idr < 1)
      $idr = -1;
    //CONTROL DIES NOMES CARTA


    if ($es_menu)
      $were = ' carta_plats.carta_plats_subfamilia_id=20 ';
    else
      $were = ' (carta_plats.carta_plats_subfamilia_id<>20) ';

    $were .= ' AND carta_publicat = TRUE ';

    $CONTROLA_ARTICLES_ACTIUS = "";

    $query = "select `carta_plats_id`,`carta_plats_nom_es`,`carta_plats_nom_en`,`carta_plats_nom_ca`,`carta_plats_preu`,carta_subfamilia.carta_subfamilia_id AS subfamilia_id,`carta_subfamilia_nom_$lng`, comanda_client.comanda_plat_quantitat 
FROM carta_plats 
LEFT JOIN carta_publicat ON carta_plats_id=carta_publicat_plat_id
LEFT JOIN carta_subfamilia ON carta_subfamilia.carta_subfamilia_id=carta_plats_subfamilia_id
LEFT JOIN comanda as comanda_client ON carta_plats_id=comanda_plat_id AND comanda_reserva_id='$idr'
LEFT JOIN carta_subfamilia_order ON carta_subfamilia.carta_subfamilia_id=carta_subfamilia_order.carta_subfamilia_id

$CONTROLA_ARTICLES_ACTIUS

WHERE $were
ORDER BY carta_subfamilia_order,carta_plats_nom_es , carta_plats_nom_ca";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    while ($row = mysqli_fetch_array($Result1)) {
      if (empty($row['carta_plats_nom_ca']))
        $row['carta_plats_nom_ca'] = $row['carta_plats_nom_es'];
      if (empty($row['carta_plats_nom_en']))
        $row['carta_plats_nom_en'] = $row['carta_plats_nom_es'];
      //ucfirst
      if ($_SESSION["lang"] != 'es')
        $row['carta_plats_nom_' . $lng] = ucfirst(mb_strtolower($row['carta_plats_nom_' . $lng]));
      $plat = array('id' => $row['carta_plats_id'], 'nom' => $row['carta_plats_nom_' . $lng], 'preu' => $row['carta_plats_preu'], 'quantitat' => $row['comanda_plat_quantitat']);
      $arCarta[$row['carta_subfamilia_nom_' . $lng]][] = $plat;
    }

    /*     * ******************************************************************************************************* */

    $class = $es_menu ? "cmenu" : "ccarta";
    $obreLlista = '<ul id="carta-seccions" class="' . $class . '">' . PHP_EOL;
    $llista = "";
    foreach ($arCarta as $key => $val) {
      $k = $this->normalitzar($key);
      $llista .= '<li><a href="#carta_' . $k . '">' . $key . '</a></li>' . PHP_EOL;
    }
    $tancaLlista = '</ul>' . PHP_EOL;
    $carta = $obreLlista . $llista . $tancaLlista;

    foreach ($arCarta as $key => $val) {
      $k = $this->normalitzar($key);
      $obreSeccio = '<div id="carta_' . $k . '" class="llistat_menus ' . $class . '">' . PHP_EOL;
      $seccio = $this->seccioCarta($arCarta, $key, $class);
      $tancaSeccio = '</div>' . PHP_EOL . PHP_EOL;

      $carta .= $obreSeccio . PHP_EOL . $seccio . PHP_EOL . $tancaSeccio;
    }

    return $carta;
  }  
  
  
   /*   * ******************************************************************************************************* */

  public function seccioCarta($ar, $k, $class) {
    
    
    global $translate;
    ob_start();
  //  include('translate_carta_' . $this->lng . '.php');
     include(ROOT . '/../reservar/translate_carta_' . $this->lng . '.php');
    ob_end_clean();
    
    
    $obreTaula = '<table id="c1" class="col_dere">' . PHP_EOL;
    $l = $c = 0;
    $tr = '';
    foreach ($ar[$k] as $key => $val) {
      $comentari = "";
      $menuEspecial = $this->menuEspecial($val['id']) ? " menu-especial" : "";
      if (!calsoton && ($val['id'] == 2010 || $val['nom'] == "MENU CALÇOTADA" || $val['nom'] == "MENÚ CALÇOTADA"))
        continue;
      $l++;

      if ($val['quantitat'])
        $value = ' value="' . $val['quantitat'] . '" ';
      else
        $value = "0";
      
      /** COMENTARIS **/

      /**  IVA  * */
      //$val['preu']*=IVA/100;
      $preu = round($val['preu'] + $val['preu'] * IVA / 100, 2);
      $preu = number_format($preu, 2, '.', '');
      $nomTrans = l($val['nom'], false);
      $odd = ($l % 2) ? "odd" : "pair";
      $tr .= '<tr producte_id="' . $val['id'] . '" class="item-carta ' . $odd . $menuEspecial . '">
				<td  class="mes"><div  class="d-mes ui-corner-all" ><a href"#">+</a></div></td>
				<td class="contador">
                                <div  class="mes"><div  class="m-mes ui-corner-all"> + </div></div>
                                <input id="carta_contador' . $val['id'] . '" nid="' . $val['id'] . '" type="text" name="carta_contador' . $c++ . '" class="contador ' . $class . '" ' . $value . ' preu="' . $preu . '" nom="' . $val['nom'] . '"/>
                                 <div  class="menys"><div  class="m-menys ui-corner-all"> - </div></div>   

</td>
				<td class="menys"><div  class="d-menys ui-corner-all" ><a href"#">-</a></div></td>
				<td class="borra" style="display:none"></td>
				<td><a class="resum-carta-nom" href="/cb-reserves/reservar/Gestor_form.php?a=TTmenu&b=' . $val['id'] . '" >' . $nomTrans .'</a></td>
				<td class="td-carta-preu"><span class="carta-preu">' . $preu . '</span>&euro; </td>
				<!--<td class="carta-subtotal"><em>(subtotal: <span class="carta-preu-subtotal">0</span>&euro; )</em></td></tr>-->
                                           

' . PHP_EOL;
    }

    $tancaTaula = '
		<tr><td></td><td></td><td></td><td></td><td>IVA incl.</td><td></td></tr>
		</table>' . PHP_EOL . PHP_EOL;

    return $obreTaula . $tr . $tancaTaula;
  }

  private function menuEspecial($id) {
    return ($id == 2001 || $id == 2003);
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  
  
  /*   * ****************************************************************************************************************************** */
  /*   * *********   PERMUTA *********************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  public function permuta($orig, $dest, $res) {
    return "FINS AQUI TOT BEEE";
  }

  /*   * ******      CANVI_DATA     *********** */

  public function canvi_data($data = null, $torn = 0) {
    if (!empty($data)) {
      if (!isset($_SESSION))
        session_start();
      $_SESSION['data'] = $this->cambiaf_a_mysql($data);
      if ($torn)
        $_SESSION['torn'] = $torn;
    }

    return $_SESSION['data'];
  }

  /*   * ******      CANVI_TORN     *********** */

  public function canvi_torn($torn) {
    if (!isset($_SESSION))
      session_start();
    $_SESSION['torn'] = $torn;

    return "T" . $_SESSION['torn'];
  }

  /*   * ******      CANVI_MODO     *********** */

  public function canvi_modo($modo) {
    if (!isset($_SESSION))
      session_start();
    $_SESSION['modo'] = $modo;

    echo $_SESSION['modo'];
  }

//////////////////////////////////////////////////// 
//Retorna el torn d'una hora donada
//////////////////////////////////////////////////// 
  public function torn($data, $hora) {
    $data_BASE = $this->data_BASE;

    $query = "SELECT * FROM `estat_hores` 
WHERE `estat_hores_hora`='$hora'
AND (`estat_hores_data`='$data' OR `estat_hores_data`='$data_BASE')
ORDER BY `estat_hores_data` DESC";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $row = mysqli_fetch_array($Result1);
    return $row['estat_hores_torn'];
//return ($hora>"15")?(($hora>"19")?3:2):1;
  }

  public function set_torn_hores($torn, $hora, $hora_fi) {
    $hora_fi .= "~";
    $query = "UPDATE `estat_hores` SET `estat_hores_torn` = '$torn' WHERE estat_hores_data='2011-01-01' AND `estat_hores`.`estat_hores_hora` BETWEEN '$hora' AND '$hora_fi'";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $rows = mysqli_affected_rows($this->connexioDB);
    //$row = mysqli_fetch_array($Result1);

    echo "<br>($rows) $query";
    return $rows;
  }

  /*   * ******      SUMA DIAS     *********** */

  public function sumaDias($fecha, $ndias) {  //format yyy-mm-dd     
    if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/", $fecha))
      list($año, $mes, $dia) = split("/", $fecha);

    if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/", $fecha))
      list($año, $mes, $dia) = split("-", $fecha);
    $nueva = mktime(0, 0, 0, $mes, $dia, $año) + $ndias * 24 * 60 * 60;
    $nuevafecha = date("Y-m-d", $nueva);

    return ($nuevafecha);
  }

  /*   * ******      DIA SEMANA     *********** */

  public function diaSemana($fecha) {  //format yyy-mm-dd     
    if (preg_match("/([0-9][0-9]){1,2}\/[0-9]{1,2}\/[0-9]{1,2}/", $fecha))
      list($año, $mes, $dia) = split("/", $fecha);

    if (preg_match("/([0-9][0-9]){1,2}-[0-9]{1,2}-[0-9]{1,2}/", $fecha))
      list($año, $mes, $dia) = split("-", $fecha);
    $nueva = mktime(0, 0, 0, $mes, $dia, $año);
    $nuevafecha = date("N ", $nueva);

    return ($nuevafecha);
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   mostra_error  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function xxxxxxxxxxxxxxxxxxxxxmostra_error() {
    echo ('<div class="DBError">NO S\'HA POGUT COMPLETAR L\'ACCIÓ:<br/><br/>' . $this->error . '</div>');
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   MAIL BODY  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function mail_body($dia = 0, $hora = 0) {
    return "";
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   ENVIA MAIL  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function enviaMail($idr, $plantilla = "confirmada_", $recipient = null, $extres = null) {

    $subject = isset($extres['subject']) ? $extres['subject'] : 'No subject';
    $ts = $this->insert_id();

    $this->reg_log(">>>> ENVIA EMAIL >>>> enviaMail($idr, $plantilla, $recipient )", 1);
    $this->xgreg_log(">>>> ENVIA EMAIL >>>> enviaMail(<span class='idr'>$idr</span>, $plantilla, $recipient, $subject )", 0, '/log/logMAILSMS.txt');
   
    if (!ENVIA_MAILS && $recipient!="alexbasurilla@gmail.com") {
      $this->reg_log("ENVIA_MAILS DESACTIVAT", 1);
      return FALSE;
    }

    require_once(ROOT . "../editar/mailer.php");
    require_once(ROOT . INC_FILE_PATH . "template.inc");

    $taula = (floor($idr) > SEPARADOR_ID_RESERVES) ? T_RESERVES : 'reserves';
    $query = "SELECT * FROM $taula
    LEFT JOIN client ON $taula.client_id=client.client_id
    WHERE id_reserva=$idr";

    if (TRUE) {
      $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $row = mysqli_fetch_assoc($this->qry_result);
    }
    
    if (!$this->qry_result || !mysqli_num_rows($this->qry_result))
      return "err10";

    $row['aixoesunarray'] = 1;
    if ($extres)
      $row = array_merge($row, $extres);
//Gestor::printr($row);
    $avui = date("d/m/Y");
    $ara = date("H:i");


    $file = ROOT . $plantilla . $this->lng . ".lbi";
    // echo $file."  ".__FILE__;die();
    $t = new Template('.', 'comment');
    if (is_array($extres)) {
      foreach ($row as $k => $v) {
        $t->set_var($k, $v);
      }
    }
    $t->set_file("page", $file);
    $t->set_var('self', $file);
    $t->set_var('avui', date("l d M Y"));
    $t->set_var('id_reserva', $idr);
    $t->set_var('data', $row['data']);
    $t->set_var('hora', $row['hora']);
    $t->set_var('hora', $row['hora']);

    $t->set_var('adults', $row['adults']);
    $t->set_var('nens10_14', $row['nens10_14']);
    $t->set_var('nens4_9', $row['nens4_9']);
    $t->set_var('cotxets', $row['cotxets']);

    $t->set_var('comanda', $this->plats_comanda($idr));
    $t->set_var('nom', $row['client_nom'] . " " . $row['client_cognoms']);
    $t->set_var('observacions', $row['observacions']);
    $t->set_var('resposta', $row['resposta']);
    $t->set_var('preu_reserva', $row['preu_reserva']);
    $t->set_var('dc', (100000 - (100 * $row['preu_reserva'] + $idr)));

    $altbdy = 'HTML NOT PROCESSED';

    $t->parse("OUT", "page");
    $html = $t->get("OUT");


    //if ($destinatari) $recipient = $destinatari;
    //else $recipient = $row['client_email'];
    if (!$recipient)
      $recipient = $row['client_email'];
    if (isset($row['subject']))
      $subject = $row['subject'];
    else
      $subject = "..::Reserva Can Borrell::..";
    try {
      $result = $r = mailer_reserva($idr, $plantilla, $recipient, $subject, $html, $altbdy, null, false, MAIL_CCO);
      $mail = "Enviament $plantilla RESERVA PETITA ONLINE($r): $idr -- $recipient";
    }
    catch (Exception $e) {
      $mail = "err10";
    }

    $rs = ($result['Result'] == "NO ENVIAT!!!") ? "ERROR" : "EXIT";
    $this->xgreg_log(">>> MAIL RESULTAT: <span class='$rs'>$rs</span> > $recipient ", 1);

    return $mail;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   ENVIA SMS  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function enviaSMS($res, $missatge = 0, $numMobil = '') {
    $file = ROOT . "/editar/read.php?f=" . ROOT . INC_FILE_PATH . '/log/logMAILSMS.txt';
    $this->xgreg_log(">>> ENVIA SMS <span class='idr'>$res</span> > $numMobil  ", 1, '/log/logMAILSMS.txt');
    $this->xgreg_log('<br><a href="' . $file . '">log mail</a>', 1, '/log/logMAILSMS.txt');
    
   // echo "ZZZZZZZZZ $file";
$this->xgreg_log('<br><a href="' . $file . '">log mail</a>', 1, '/log/logMAILSMS.txt');
$this->xgreg_log('<br><a href="' . $file . '">log mail</a>', 1, '/log/logMAILSMS.txt');
$this->xgreg_log('<br><a href="' . $file . '">log mail</a>', 1, '/log/logMAILSMS.txt');
    if (!isset($_SESSION['permisos']) || $_SESSION['permisos'] < 1) {
      $this->xgreg_log(">>> ENVIA SMS: SIN PERMISOS!!!", 1);
      $this->xgreg_log(">>> ENVIA SMS: SIN PERMISOS!!!", 1, '/log/logMAILSMS.txt');
    }
    include_once( ROOT . "../editar/SMSphp/EsendexSendService.php" );

    if (!isset($res)) {
      $this->xgreg_log(">>> ENVIA SMS: FALTA RESERVA o MENSA!!!", 1);
      $this->xgreg_log(">>> ENVIA SMS: FALTA RESERVA o MENSA!!!", 1, '/log/logMAILSMS.txt');
      return false;
    }

    /*     * **************** */
//ATENCIO, PER DIFERENCIAR SI ES RESERVA DE GRUP (ESTAN EN UNA ALTRA TAULA)
    $taula_reserves = $res > SEPARADOR_ID_RESERVES ? T_RESERVES : 'reserves';
    /*     * **************** */

    $query = "SELECT client_mobil, adults,nens10_14,nens4_9,data,hora FROM client INNER JOIN  `$taula_reserves` ON " . $taula_reserves . ".client_id = client.client_id
    WHERE id_Reserva = $res";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_array($Result1);
    if (!$row['client_mobil']) {
      $this->xgreg_log(">>> ENVIA SMS: FALTA NUM MOBIL!!!", 1);
      $this->xgreg_log(">>> ENVIA SMS: FALTA NUM MOBIL!!!", 1, '/log/logMAILSMS.txt');
      return false;
    }
//echo "RRR";die();
    if (!$missatge) {
      $persones = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
      $persones .= 'p';

      $data = $this->cambiaf_a_normal($row['data']);
      $hora = $row['hora'];

      $missatge = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$res)";
    }

    $numMobil = $row['client_mobil'];
    $this->xgreg_log(">>> ENVIA SMS: " . $res . " >>> " . $numMobil . " >>> " . $missatge, 1);
    $this->xgreg_log(">>> ENVIA SMS: <span class='idr'>$res</span> >>> " . $numMobil . " >>> " . $missatge, 1, '/log/logMAILSMS.txt');

    if (strlen($numMobil) != 9 || !is_numeric($numMobil)) {
      return true;
    }
    if (substr($numMobil, 0, 1) != '6' && substr($numMobil, 0, 1) != '7' && $numMobil != '999212121') {
      return true;
    }


    $mensa = $this->SQLVal($missatge);
// Test Variables - assign values accordingly:
    $recipients = $numMobil;    // The mobile number(s) to send the message to (comma-separated).
    $body = $mensa;     // The body of the message to send (must be less than 160 characters).
    $idReserva = $res;
/*
    $username = "restaurant@can-borrell.com";     // Your Username (normally an email address).
//ANTIC $password = "NDX5631";      // Your Password.
    $password = "Alkaline:17";     // Your Password 26/2/2013.
    $accountReference = "EX0062561";    // Your Account Reference (either your virtual mobile number, or EX account number).

 *     $originator = "Rest.Can Borrell";   // An alias that the message appears to come from (alphanumeric characters only, and must be less than 11 characters).
 */
        require_once ROOT . INC_FILE_PATH . 'essendex_config.php';
//echo $essedex_user . $essedex_pwd;die();
    
    
    $type = "Text";     // The type of the message in the body (e.g. Text, SmartMessage, Binary or Unicode).
    $validityPeriod = 0;    // The amount of time in hours until the message expires if it cannot be delivered.
    $result;      // The result of a service request.
    $messageIDs = array($idReserva);    // A single or comma-separated list of sent message IDs.
    $messageStatus;     // The status of a sent message.

    $result['Result'] = "NO ENVIAT!!!";
    $result['Message'] = "";
    if (ENVIA_SMS == "1" && $recipients != '999212121') {
      try {
        $sendService = new EsendexSendService($essedex_user, $essedex_pwd, $accountReference);
        $result = $sendService->SendMessage($recipients, $body, $type);
        $pr = print_r($result, TRUE);
        $this->xgreg_log(">>> ENVIA SMS: REAL: " . $pr . " ***  " . $result['Result'], 1);
        $this->xgreg_log(">>> ENVIA SMS: REAL: " . $pr . " ***  " . $result['Result'], 1, '/log/logMAILSMS.txt');
      }
      catch (Exception $e) {
        $this->xgreg_log(">>> ERROR: " . $result['Result'], 1, '/log/logMAILSMS.txt');
        $result['Result'] = "SMS: ERROR DE CONNEXIO AL HOST: " . $result['Result'];
      }
    }
    else {
      $this->reg_log(">>> ENVIA SMS: SIMULAT", 1);
      $this->xgreg_log(">>> ENVIA SMS: SIMULAT", 1, '/log/logMAILSMS.txt');
      $t = "SIMULAT >>>>>  ";
    }

    $rs = ($result['Result'] == "NO ENVIAT!!!") ? "ERROR" : "EXIT";
    $this->reg_log(">>> SMS RESULTAT: <span class='$rs'>$rs</span>", 1);
    $this->xgreg_log(">>> SMS RESULTAT: <span class='$rs'>$rs</span>", 1, '/log/logMAILSMS.txt');

    $r = '<span style="color:red;font-size:11px;"><em> -(tel: ' . $numMobil . ') RESULTAT:  ' . $result['Result'] . '</em></span>';
    $t = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $mensa . $r) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));
    $query = "INSERT INTO sms (sms_reserva_id, sms_numero, sms_missatge) VALUES ($res, $numMobil, '$t')";
    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    return true;
  }

  public static function SMS_language($mensa, $lang = 'ca', $args = NULL) {

    $lang_r = Gestor::codelang($lang);
    include(ROOT . "../editar/translate_editar_$lang_r.php");

    $mensa = Gestor::lv($mensa);
    if (is_array($args))
      $mensa = vsprintf($mensa, $args);


    return $mensa;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ****** LLISTA SMS  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function llistaSMS($reserva_id) {
    if (!$reserva_id)
      return "";
    $query = "SELECT * FROM sms WHERE sms_reserva_id=$reserva_id ORDER BY sms_data";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $this->total_rows = mysqli_num_rows($Result1);

    $html = "";
    while ($row = mysqli_fetch_array($Result1)) {
      $html .= '
        <div class=" llista-sms-data">' . $this->cambiaf_a_normal($row['sms_data']) . '</div>
        <div class = "llista-sms-mensa" > ' . $row['sms_missatge'] . ' </div>';
    }

    return stripslashes($html);
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ** GUARDA VALOR MENU CALÇOTS ACTIU ** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function guardaCalsoton($actiu) {
    $valor = $actiu ? 1 : 0;
    $this->reg_log("guardaCalsoton " . (int) $actiu);

    $query = "UPDATE comanda SET comanda_plat_quantitat=$valor WHERE comanda_reserva_id=0 AND comanda_plat_id=2010";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return true;
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   TOTAL COBERTS TORN  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  public function total_coberts_torn() {
    $this->taulesDisponibles->data = $_SESSION['data'];
//$this->taulesDisponibles->torn=$_SESSION['torn'];
    $this->taulesDisponibles->torn = 1;
    $t['t1'] = $this->taulesDisponibles->sum_comensals_torn();
    $maxtorn = $this->taulesDisponibles->max_torn();

    $this->taulesDisponibles->torn = 2;
    $t['t2'] = $this->taulesDisponibles->sum_comensals_torn();

    $this->taulesDisponibles->torn = 3;
    $t['t3'] = $this->taulesDisponibles->sum_comensals_torn();
//return $this->taulesDisponibles->sum_comensals_torn().'  max:'.$this->taulesDisponibles->max_torn();
    $t['total'] = $t['t' . $_SESSION['torn']] . '  max:' . $maxtorn;
    return json_encode($t);
  }

  /*   * ********************************************************************************************************************* */

  public function cerca_taula($persones = null, $cotxets = 0, $findes = null) {
    $BLOC = $BLOC2 = $t = "";
    $ntaules = 0;
    $persones = $persones == "undefined" ? 0 : $persones;
    $cotxets = $cotxets == "undefined" ? 0 : $cotxets;

    $nomTorn = array("ERR-zero", "Dinar torn 1", "Dinar torn 2", "Sopar");
    $inimsg = "";
    $html = $inimsg;


    $mydata = $this->taulesDisponibles->data = $_SESSION['data'];
    $torn = $this->taulesDisponibles->torn = $_SESSION['torn'];
    $this->taulesDisponibles->persones = $persones;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->tableHores = 'estat_hores';
    $this->taulesDisponibles->tableMenjadors = 'estat_menjador';
    $taules = $this->taulesDisponibles->taules();

//echo "$mydata * $torn * $persones * $cotxets ---- ".$_SESSION['data']."  --- ".$_SESSION['torn'];
    if (!$taules) {
//print_r($this->taulesDisponibles->arTxtError);    
      echo $this->taulesDisponibles->llistaErrors();
      return $html;
    }

    foreach ($taules as $k => $v) {
      $data = $this->cambiaf_a_normal($mydata);
//$torn=$this->torn($v->data, $v->hora);
      if (substr($v->nom, 0, 2) == "OL")
        continue;

      $ret = '<a href="' . $v->id . '" dia="' . $mydata . '" torn="' . $torn . '" n="' . $v->nom . '" p="' . $v->persones . '" c="' . $v->cotxets . '" f="' . $v->plena . '" ><table class="taulaCercador">
      <tr> 
        <td class = " f1 id-taula">' . $v->nom . '</td>       
        <td class="f12">' . $data . ' </td>
      </tr>
      
      <tr>        
        <td class="f2"> ' . $v->persones . '/' . $v->cotxets . '</td>    
        <td class="f22">' . $BLOC . $BLOC2 . ' <span class="torn' . $t . '">' . $nomTorn[$torn] . '</span></td>
      </tr>
      </table></a > 
';

      if ($html == $inimsg)
        $html = "";
      $html .= $ret;

      if (++$ntaules > 12)
        break;
    }

    return $html;
  }

  /*   * ********************************************************************************************************************* */

  public function recupera_torn() {
    return $_SESSION['torn'];
  }

  public function recupera_data() {
    return $_SESSION['data'];
  }

//COMPROVA L'ALTRE TORN
  /*   * ********************************************************************************************************************* */
  public function altreTorn($taula, $persones = "", $cotxets = "") {
    $data = $_SESSION['data'];

    $altre_torn = $_SESSION['torn'];
    if ($_SESSION['torn'] == 1)
      $altre_torn = 2;
    if ($_SESSION['torn'] == 2)
      $altre_torn = 1;
    if ($_SESSION['torn'] == 3)
      return 3;

//EXISTEIX?
//NO TE RESERVA // reserva_id=0
    $query = "SELECT * FROM " . ESTAT_TAULES . " 
      WHERE 
      (estat_taula_taula_id=$taula AND estat_taula_torn=$altre_torn AND estat_taula_data='$data' AND estat_taula_x>0 AND estat_taula_y>0)
      OR
      (estat_taula_taula_id=$taula  AND estat_taula_torn=$altre_torn AND estat_taula_data='" . $this->data_BASE . "' AND estat_taula_x>0)
      ORDER BY estat_taula_id DESC";

    $this->qry_result = $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = $this->last_row = mysqli_fetch_assoc($this->qry_result);
    /* SI EXISTEIX I NO TE RESERVA SEGUIM */
//MENJADOR BLOQ? AND // QUADREN PERSONES AND COBERTS????
    if ($row['reserva_id'] == 0 && $row['estat_taula_persones'] == $persones && $row['estat_taula_cotxets'] == $cotxets) {
//$row=$this->last_row = mysql_fetch_assoc($this->qry_result);
      $x = $row['estat_taula_x'];
      $y = $row['estat_taula_y'];
      $taulesDisponibles->data = $taulesDisponibles->data = $data;
      $taulesDisponibles->torn = $altre_torn;
      $bloquejats = $this->taulesDisponibles->menjadorsBloquejats($this->menjadors);
      if (!$this->taulaBloquejada($x, $y, $bloquejats))
        return $altre_torn; // SI ARRIBA FINS AKI, EL TORN ES OK      
    }



    /* SI ARRIBA FINS AQUI, NO VAL, RETORNA EL TORN ACTIU */
    return $_SESSION['torn'];
  }

  /*   * ********************************************************************************************************************* */

  public function estat_reserva_grup($idr) {
    if (!$idr)
      return "No s'ha rebut ID";

    $query = "SELECT estat  FROM reserves  WHERE id_reserva=$idr";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_array($Result1, MYSQLI_ASSOC);
    return $row['estat'];
  }

  /*   * ********************************************************************************************************************* */

  public function estat_reserva_online($idr) {
    if (!$idr)
      return "No s'ha rebut ID";

    $query = "SELECT estat  FROM reservestaules  WHERE id_reserva=$idr";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!mysqli_num_rows($Result1))
      return 0;

    $row = mysqli_fetch_array($Result1, MYSQLI_ASSOC);
    return $row['estat'];
  }

  /*   * ********************************************************************************************************************* */

  public function plats_comanda($idr) {
    if (!$idr)
      return "No s'ha rebut ID";

    $query = "SELECT carta_plats_nom_es,comanda_plat_quantitat 
    FROM comanda 
    LEFT JOIN carta_plats ON carta_plats_id=comanda_plat_id
    WHERE comanda_reserva_id=$idr";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $comanda = "";
    while ($row = mysqli_fetch_array($Result1)) {
      $comanda .= $row['comanda_plat_quantitat'] . " x " . $row['carta_plats_nom_es'] . "<br/>";
    }

    return $comanda;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

  public function garjola($tel, $email, $valor = null) {
// $this->reg_log("garjola ".(int)$valor);
// $this->reg_log("$tel, $email",1);

    if ($valor == 'true')
      $query = "INSERT INTO llista_negra SET llista_negra_mobil='$tel',llista_negra_mail='$email'";
    elseif ($valor == 'false')
      $query = "DELETE FROM llista_negra WHERE llista_negra_mobil='$tel' OR llista_negra_mail='$email'";
    else
      $query = "SELECT * FROM llista_negra WHERE llista_negra_mobil='$tel' OR llista_negra_mail='$email'";
    $this->qry_result = $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    return (mysqli_num_rows($this->qry_result));
  }

  /*   * ********************************************************************************************************************* */

  public function taulaBloquejada($x, $y, $bloquejats) {
    $solapa = false;
    foreach ($bloquejats as $key => $menjador) {
//echo "\n\n".$x." $y --- ".$menjador->name." --- ".($menjador->solapa($x, $y)?"Sii":"Noo");
      if ($menjador)
        $solapa = $solapa || $menjador->solapa($x, $y);
    }

    return $solapa;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

  public function updateMenjador($id, $data, $torn, $bloquejat = 0, $table = "estat_menjador") {
    $this->reg_log("updateMenjador " . (int) $bloquejat);
    $this->reg_log("$id, $data, $torn, $bloquejat", 1);

    // if (empty($table))
    $table = "estat_menjador"; //ATENCIO, HEM ANULAT estat_menjador_form

    $query = "DELETE FROM $table WHERE estat_menjador_menjador_id=$id AND estat_menjador_data='$data' AND estat_menjador_torn='$torn'";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $query = "INSERT INTO $table SET estat_menjador_menjador_id=$id, estat_menjador_data='$data',estat_menjador_torn='$torn',estat_menjador_bloquejat=$bloquejat";
    echo $query;
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  }

  /*   * ****************************************************************************************************************** */

  public function missatgeLlegit($idr) {
    $this->reg_log("missatgeLlegit " . (int) $idr);


    $query = "UPDATE " . T_RESERVES . " SET reserva_info=(reserva_info|16) WHERE id_reserva=$idr";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    return $idr;
  }

  /*   * ****************************************************************************************************************** */

  public function taulaEntrada($idr, $val) {
    $this->reg_log("taulaEntrada " . (int) $idr . "  $val");
    
    

     $val=$val?"(reserva_info|32)":"(reserva_info&65503)";



    $query = "UPDATE " . T_RESERVES . " SET reserva_info=$val WHERE id_reserva=$idr";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
echo "VAL: ".$val." *** ";
    echo $query. " kkk ";
    return $idr;
  }

  /*   * ****************************************************************************************************************** */
  /*
    BIT FLAGS:
    1(1)=reserva online
    2(2)=reserva per grups
    3(4)=cotxet
    4(8)=cotxet > 00=1cotxet normal,01=2cotxets normals,10=1 cotxet doble ample,11=1 cotxet doble llarg
    5(16)=misstge llegit (16)
    6(32)=reserva entrada=clients ja són a taula
    7(64)=esborrar dades client passada la data de reserva
    8(128)=CADIRA RODES
   */

  public function encodeInfo($ampla, $grups, $online) {
    $info = 0;
    $info |= $online ? 1 : 0; //1er bit  

    $grups = $grups << 1;
    $info |= $grups; // GRUP = FALSE 

    $ampla = $ampla << 2;
    $info |= $ampla; // AMPLA/LLARG 


    return $info;
  }

  /*   * ****************************************************************************************************************** */
  /*
    BIT FLAGS:
    1(1)=reserva online
    2(2)=reserva per grups
    3(4)=cotxet
    4(8)=cotxet > 00=1cotxet normal,01=2cotxets normals,10=1 cotxet doble ample,11=1 cotxet doble llarg
    5(16)=misstge llegit (16)
    6(32)=reserva entrada=clients ja són a taula
    7(64)=esborrar dades client passada la data de reserva
    8(128)=CADIRA RODES
   */

  public function decodeInfo($info) {
    $ar['online'] = ($info & 1) ? true : false; //1
    $ar['grups'] = ($info & 2) ? true : false; //2
    $ar['ampla'] = ($info >> 2 ) & 3; //3,4
    $ar['llegit'] = $this->flagBit($info, 5); //5
    $ar['entrada'] = $this->flagBit($info, 6); //6
    $ar['esborra_cli'] = $this->flagBit($info, 7); //7
    $ar['cadiraRodes'] = $this->flagBit($info, 8); //8
    $ar['accesible'] = $this->flagBit($info, 9); //9
//$ar['bit10']=$this->flagBit($info,10);//10

    return $ar;
  }

  /*   * ********************************************************************************************************************* */

  public function reg_log($txt, $type = 0, $request = true) {

// COMPATIBILITAT ARGUMENTS
    if (is_bool($type) === true) {
      $request = $type;
      $type = 0;
    }
    parent::xgreg_log($txt, $type, null, $request);
  }

  /*   * ********************************************************************************************************************* */

  
  /*   * ********************************************************************************************************************* */

  public function llegir_dies_DB($group = "small", $tipus = "black") {
    $query = "DELETE FROM dies_especials_small WHERE dies_especials_data <= CURRENT_DATE - INTERVAL 360 DAY";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $query = "DELETE FROM dies_especials_group WHERE dies_especials_data <= CURRENT_DATE - INTERVAL 360 DAY";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $query = "DELETE FROM dies_especials_night WHERE dies_especials_data <= CURRENT_DATE - INTERVAL 360 DAY";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    
    $query = "SELECT  * FROM dies_especials_$group WHERE dies_especials_tipus = '$tipus' AND  dies_especials_data <= CURRENT_DATE + INTERVAL 360 DAY 
      AND dies_especials_data > CURRENT_DATE - INTERVAL 30 DAY";
   // echo $query;
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!$this->total_rows = mysqli_num_rows($this->qry_result)) {
      return false;
    }
    while ($row = mysqli_fetch_assoc($this->qry_result)) {
      $class = ($tipus == 'black') ? 'negra' : 'blanca';
      $date_parse = date_parse($row['dies_especials_data']);
      
      $year = $date_parse['year'];
      $month = $date_parse['month'];
      $day = $date_parse['day'];
      $llista[$month - 1][] = $day;
    }
    return $llista;    
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

  public function crea_llista_js_DB($group, $tipus, $var = "SPECIAL_DAYS") {
    $dies = $this->llegir_dies_DB($group, $tipus);
    //var_dump($dies) ;
    
    $js="";
    $js .= "var $var = {";
    for ($i = 0; $i < 12; $i++) {
      if ($i < 11)
        $coma = ",\n";
      else
        $coma = "\n";

      $js .= $i . " : [";

      $k = 0;
    $q = 0;
      while (isset($dies[$i][$k])) {
          
          
         // if ($tipus=="white"){echo "WWWW $i  $k";}
        //NOMES AFEGEIX EL DIA SI NO ËS AVUI
        //if ((((int) date("m") - 1) != $i) || (($dies[$i][$k]) != ((int) date("d")))) {
        if (true){
          if ($q > 0)
            $js .= ",";
          $js .= $dies[$i][$k];
          $q++;
        }

        $k++;
      }
      $js .= "]" . $coma;
    }

    $js .= "};";
    
    return $js;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  /*
    public function gestio_calendari($data = "01/01/2001", $accio = "open") {
    echo $data . " - " . $accio;
    //$file = LLISTA_DIES_BLANCA;
    $d = date_parse_from_format("d/m/Y", $data);
    $month = $d['month'] - 1;
    //$mydata=$d['year'].'-'.$d['month'].'-'.$d['day'];
    include (ROOT . '../editar/llista_dies.php');

    $dies_blancs = llegir_dies(LLISTA_DIES_BLANCA);
    $dies_negres = llegir_dies(LLISTA_DIES_NEGRA);
    $keyb = array_search($d['day'], $dies_blancs[$month]);
    $keyn = array_search($d['day'], $dies_negres[$month]);



    print_r($dies_blancs);
    echo $month;
    switch ($accio) {
    case "obert":
    $dies_blancs[$month][] = $d['day'];
    guarda_dies(LLISTA_DIES_BLANCA, $dies_blancs, $d['year']);
    $dies_negres[$month][$keyn] = 0;
    guarda_dies(LLISTA_DIES_NEGRA, $dies_negres, $d['year']);
    break;

    case "tancat":
    $dies_blancs[$month][$keyb] = 0;
    guarda_dies(LLISTA_DIES_BLANCA, $dies_blancs, $d['year']);
    $dies_negres[$month][] = $d['day'];
    guarda_dies(LLISTA_DIES_NEGRA, $dies_negres, $d['year']);

    break;

    default:
    $dies_blancs[$month][$keyb] = 0;
    // guarda_dies(LLISTA_DIES_BLANCA, $dies_blancs, $d['year']);
    $dies_negres[$month][$keyn] = 0;
    //  guarda_dies(LLISTA_DIES_NEGRA, $dies_negres, $d['year']);

    break;
    }


    print_r($dies);

    return;
    }
   */
  /*
    private afegir_a_llista($file, ){

    }
   */
  /*   * ********************************************************************************************************************* */

  public function estat_anterior($idr) {
    $res = $this->load_reserva($idr);
    $anterior = $this->log_array($res);
    $this->xgreg_log("Estat anterior: <br>" . $anterior, 1);
  }

  /*   * ********************************************************************************************************************* */

  public function netejaImpagatsTpv($b = FALSE) {

    $interval = $this->configVars("temps_paga_i_senyal");
    if ($b) {
      $interval = 0;
      echo "FORÇAT";
    }
    $query = "SELECT COUNT( estat ) AS c FROM  " . T_RESERVES . "  WHERE estat=2 AND data_creacio < NOW() - INTERVAL $interval MINUTE";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $files = mysqli_result($Result1, 0);
    if (!$files) {
      return false;
    }
    $this->reg_log("netejaImpagatsTpv:  ");
    $this->reg_log("$files", 1);

    $query = "SELECT id_reserva  FROM  " . T_RESERVES . "  WHERE estat=2 AND data_creacio < NOW() - INTERVAL $interval MINUTE";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    /**/
    while ($row = mysqli_fetch_assoc($Result1)) {
      $this->paperera_reserves($row['id_reserva']);
    }

    $query = "UPDATE " . ESTAT_TAULES . " 
            LEFT JOIN " . T_RESERVES . " ON reserva_id=id_reserva 
            SET reserva_id=0
            WHERE estat=2 and data_creacio < NOW() - INTERVAL $interval MINUTE;";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $query = "DELETE FROM " . T_RESERVES . " WHERE estat=2 and data_creacio < NOW() - INTERVAL $interval MINUTE";
//$Result1 = log_mysql_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $this->xgreg_log("netejaImpagatsTpv:$files", 0, LOG_FILE_TPVPK);
    return true;
  }

  /*   * ********************************************************************************************************************* */

  public function cancelPagaISenyal($idr = 0) {

    if (!$idr)  return false;

    $this->reg_log("cancelPagaISenyal $idr");
    $this->reg_log(">>> PAPERERA $idr");
    $this->paperera_reserves($idr);
    
    $query = "UPDATE " . ESTAT_TAULES . " LEFT JOIN " . T_RESERVES . " ON reserva_id=id_reserva SET reserva_id=0 WHERE estat=2 AND id_reserva=$idr";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    echo $query;

    $query = "DELETE FROM " . T_RESERVES . " WHERE estat=2 AND id_reserva=$idr";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
//echo " <br/><br/> ".$query." ... ".  mysql_affected_rows();
    echo "..." . $query;

    $this->xgreg_log("cancelPagaISenyal: <span class='idr'>$idr</span>", 0, LOG_FILE_TPVPK);
    return true;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

  /*
   * 
    DELETE FROM `reservestaules` WHERE `data`<'2017-04-01';
   * 
    DELETE FROM `reserves` WHERE `data`<'2017-04-01'

    SELECT * FROM `email` left join reservestaules on reservestaules.id_reserva = reserva_id left join reserves on reserves.id_reserva = reserva_id WHERE reservestaules.id_reserva is null AND reserves.id_reserva is null
    SELECT * FROM `sms` left join reservestaules on reservestaules.id_reserva = sms_reserva_id left join reserves on reserves.id_reserva = sms_reserva_id WHERE reservestaules.id_reserva is null AND reserves.id_reserva is null

    SELECT * FROM `estat_taules` left join reservestaules on reservestaules.id_reserva = reserva_id left join reserves on reserves.id_reserva = reserva_id WHERE reservestaules.id_reserva is null AND reserves.id_reserva is null
    AND `estat_taula_data`>'2011-01-01'
    AND `estat_taula_data`<'2017-04-01


    SELECT * FROM `comanda` left join reservestaules on reservestaules.id_reserva = comanda_reserva_id left join reserves on reserves.id_reserva = comanda_reserva_id WHERE reservestaules.id_reserva is  null AND reserves.id_reserva is  null

    DELETE FROM `client` WHERE `client_nom` LIKE 'ESBORRAT'
    AND client_timestamp < '2017-04-01';





    11
   * 
   * 
   * 
   * 
   *  * 
   * 
   * 
   */

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

  public function lastBackup($format = '%h') {
// $files = scandir(ROOT . INC_FILE_PATH . "db_Backup", SCANDIR_SORT_ASCENDING);
    $files = scan_sort_dir(ROOT . INC_FILE_PATH . "db_Backup");
    $newest_file = $files[0];



    preg_match("/^reserves_([0-9]{4})-([0-9]{2})-([0-9]{2})-COPIA_([0-9]{2})[:,-]([0-9]{2}).sql$/", $newest_file, $match);

//print_r($match);
    if (!count($match))
      return 999;
//echo "<br>aa";
    $date = new DateTime($match[1] . '-' . $match[2] . '-' . $match[3] . ' ' . $match[4] . ':' . $match[5] . ':00');
    $ara = new DateTime();
//echo $ara->format("Y/m/d H:i:s");
//echo "<br>";
//echo $date->format("Y/m/d H:i:s");
// echo "<br>bb";
    $interval = $ara->diff($date);

    $dies = $interval->format('%d') * 24;
    return $dies + $interval->format($format);
  }

  function teeest() {
    echo ENVIA_MAILS ? 'S' : 'N';
//return '{"dinar":"<input type=\"radio\" id=\"uhora1208\" name=\"hora\" value=\"13:17\"  class=\"required primera-hora rh\" title=\"Seleccionax hora\" maxc=\"100\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1208\"  title=\"13:17= Comensals reservats: 0\">13:18<\/label><input type=\"radio\" id=\"uhora920\" name=\"hora\" value=\"13:30\"   maxc=\"200\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora920\"  title=\"13:30= Comensals reservats: 0\">13:30<\/label><input type=\"radio\" id=\"uhora1201\" name=\"hora\" value=\"13:45\"   maxc=\"150\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1201\"  title=\"13:45= Comensals reservats: 0\">13:45<\/label><input type=\"radio\" id=\"uhora1967\" name=\"hora\" value=\"14:00\"   maxc=\"150\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1967\"  title=\"14:00= Comensals reservats: 0\">14:00<\/label><input type=\"radio\" id=\"uhora1968\" name=\"hora\" value=\"14:15\"   maxc=\"150\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1968\"  title=\"14:15= Comensals reservats: 0\">14:15<\/label><input type=\"radio\" id=\"uhora1969\" name=\"hora\" value=\"14:30\"   maxc=\"150\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1969\"  title=\"14:30= Comensals reservats: 0\">14:30<\/label><input type=\"radio\" id=\"uhora1970\" name=\"hora\" value=\"14:45\"   maxc=\"150\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1970\"  title=\"14:45= Comensals reservats: 0\">14:45<\/label><input type=\"radio\" id=\"uhora1973\" name=\"hora\" value=\"15:30\"   maxc=\"100\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1973\"  title=\"15:30= Comensals reservats: 0\">15:30<\/label><input type=\"radio\" id=\"uhora1210\" name=\"hora\" value=\"15:45\"   maxc=\"100\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1210\"  title=\"15:45= Comensals reservats: 0\">15:45<\/label><input type=\"radio\" id=\"uhora1211\" name=\"hora\" value=\"16:00\"   maxc=\"50\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora1211\"  title=\"16:00= Comensals reservats: 0\">16:00<\/label><input type=\"radio\" id=\"uhora738\" name=\"hora\" value=\"16:15\"   maxc=\"50\"  comensals=\"0\"  table=\"estat_hores\"\/>\n\t\t\t<label for=\"uhora738\"  title=\"16:15= Comensals reservats: 0\">16:15<\/label>","dinarT2":"","sopar":"","taulaT1":"3002","taulaT2":"3002","taulaT3":0,"error":""}';
  }

  public function testPHPerror() {

//echo "WWWW";die();
    provovaError();
    provovaError2();
    provovaError3();
  }

  public function update_comanda($id_reserva) {
    //INSERT INTO COMANDES
    $deleteSQL = "DELETE FROM comanda WHERE comanda_reserva_id=" . $id_reserva;
    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    for ($i = 1; isset($_POST['plat_id_' . $i]); $i++) {
      $insertSQL = sprintf("INSERT INTO comanda ( comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
		VALUES (%s, %s, %s)", $this->SQLVal($id_reserva, "text"), $this->SQLVal($_POST['plat_id_' . $i], "text"), $this->SQLVal($_POST['plat_quantitat_' . $i], "text"));
      $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
  }

  /*   * ********************************************************************************************************************* */
}

function scan_sort_dir($dir) {
  $ignored = array('.', '..', '.svn', '.htaccess');

  $files = array();
  foreach (scandir($dir) as $file) {
    if (in_array($file, $ignored))
      continue;
    $files[$file] = filemtime($dir . '/' . $file);
  }

  arsort($files);
  $files = array_keys($files);

  return ($files) ? $files : false;
}

// FI CLASS


include(ROOT . "peticions_ajax.php");
?>
