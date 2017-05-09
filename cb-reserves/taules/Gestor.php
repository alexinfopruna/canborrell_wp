<?php

/* * ******************************************************************************************************************* */
/* * ******************************************************************************************************************* */
/* * ******************************************************************************************************************* */
// GESTOR
/* * ******************************************************************************************************************* */
/* * ******************************************************************************************************************* */
/* * ******************************************************************************************************************* */
// ERRORS

/* * ******************************************************************************************************************* */
// DEFINE FITXER AMB DADES DE CONNEXIO
if (!defined('ROOT'))
  define('ROOT', "");
if (!defined('GESTOR'))
  define('GESTOR', 1);
/* * ******************************************************************************************************************* */
/* * ******************************************************************************************************************* */
// DEFINE FITXER AMB DADES DE CONNEXIO
if (!defined('DB_CONNECTION_FILE'))
  define('DB_CONNECTION_FILE', "../Connections/DBConnection.php");
/* * ******************************************************************************************************************* */


require_once(ROOT . "Usuari.php");
if (file_exists(ROOT . "php/define.php"))
  require(ROOT . "php/define.php");
require_once(ROOT . "php/Configuracio.php");
$config = new Configuracio();
//date_default_timezone_set('UTC'); //ALEX SET TIME!!
date_default_timezone_set('Europe/Madrid');
setlocale(LC_TIME, "ca_ES.utf8");

if (defined('MOSTRA_ERRORS') && MOSTRA_ERRORS == TRUE) {
 
  /* ERRORS ON */
//set_error_handler("var_dump");
  ini_set('error_reporting', E_ALL ^  ~E_DEPRECATED);
  error_reporting(E_ALL ^  ~E_DEPRECATED);
  ini_set("display_errors", 1);
  ini_set("track_errors", 1);
  ini_set("html_errors", 1);
}
/* * ******************************************************************************************************************* */
// DEFINE CARPETA DE TREBALL SOBRE LA ROOT
if (!defined('INC_FILE_PATH'))
  define('INC_FILE_PATH', "");
if (!defined('TRANSLATE_DEBUG'))
  define('TRANSLATE_DEBUG', FALSE);
/* * ******************************************************************************************************************* */


/* * ******************************************************************************************************************* */

// CLASSE Gestor
/* * ******************************************************************************************************************* */

class Gestor {

  public static $PERMISOS = "16";
  public static $USUARI_GESTOR = "63";
  public static $USUARI_ADMIN = "128";
  public $USUARI_MINIM = 63;
  protected $lang = "esp";
  public $lng = "es";
  public $lng_default = "es";
  protected $ordre;
  protected $database_name;
  protected $connexioDB;
  protected $qry_result;
  protected $last_row;
  protected $total_rows;
  protected $error;
  protected $arErrors;
  private $arTxtError;
  protected $conf;

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

//      CONSTRUCTOR     
  /*   * ************************************* */
  /*   * ************************************* */
  protected function __construct($fitxer_dades_conn = "FITXER DADES DB SENSE DEFINIR", $usuari_minim = -1) {
    if ($usuari_minim == -1)
      $usuari_minim = $this->PERMISOS;
    if (!defined('PERMISOS'))
      define('PERMISOS', $usuari_minim);
    $this->conf = new Configuracio();
    $this->connectaBD();
    $_SESSION['admin_id'] = '0';
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

// CONTROL BBDD
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

//      CONECTABD     
  protected function connectaBD() {
    if (isset($this->connexioDB))
      return;
    include(ROOT . DB_CONNECTION_FILE);
    $this->database_name = $database_canborrell;
    $this->connexioDB = $canborrell;
    /*     * *************************************************************************** */
// CONNEXIO BBDD	
    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));
    mysqli_query($GLOBALS["___mysqli_ston"], "SET CHARACTER SET 'utf-8'");
    mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES 'utf-8'");
    mysqli_query($GLOBALS["___mysqli_ston"], "SET COLLATION CONNECTION 'utf-8'");
    //mysql_set_charset('utf8',$canborrell); 
    mysqli_set_charset($canborrell, 'utf8');
    /*     * *************************************************************************** */

    //paginacio
    $this->currentPage = $_SERVER["PHP_SELF"];
    $this->maxRows_reserva = 20;
    $this->pageNum_reserva = 0;
    if (isset($_GET['pageNum_reserva'])) {
      $this->pageNum_reserva = $_GET['pageNum_reserva'];
    }
    $this->startRow_reserva = $this->pageNum_reserva * $this->maxRows_reserva;
  }

  // RECUPERA IDIOMA 
  public function idioma($idioma = null) {
    if (!isset($_SESSION["lang"]))
      $this->lang = $_SESSION["lang"] = $this->lang; // PER DEFECTE
    else
      $this->lang = $_SESSION["lang"]; // PER SESSION
    if (!empty($idioma))
      $this->lang = $_SESSION["lang"] = $idioma; //PER ARGUMENTS

    $this->lang = $_SESSION['lang'];
    $this->lng = substr($this->lang, 0, 2);

    return($this->lang);
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

//   CONTROL SESSION 
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

  /*   * ******      VALIDA_SESSIO     *********** */
  public function valida_sessio($permisos = PERMISOS, $user = -1, $permis_admin = null) {
    if ($permisos == 0)
      return true;
    if (!$permis_admin)
      $permis_admin = Gestor::$USUARI_ADMIN;
    if (!isset($_SESSION))
      session_start();
    $a = isset($_SESSION['uSer']);
    if (!$a)
      return FALSE;

    $b = !empty($_SESSION['uSer']);
    //$sessuser=unserialize($_SESSION['uSer']);

    if (!$b)
      return FALSE;

    $sessuser = $_SESSION['uSer'];

    if (!property_exists ( $sessuser , 'id' )) return FALSE;
    $c = $sessuser->id;
 
    if (!isset($_COOKIE['tok']))
      $_COOKIE['tok'] = FALSE; //lxlx
    if (!isset($sessuser->tok))   $sessuser->tok = FALSE; //lxlx
    $d = ($_COOKIE['tok'] == $sessuser->tok);
    //$e=($_SESSION['uSer']->permisos & $permisos); // NOMÉS CAL QUE COMPLEIX ALGUN PERMÍS
    $e = (($sessuser->permisos & $permisos) >= $permisos); // HA DE CUMPLIR IGUAL O MES DELS PERMISOS DEMANATS
    if ($user > 0 && $sessuser->id != $user && !($sessuser->permisos & $permis_admin))
      return false;
    
   $valid = ($a && $b && $c && $d && $e);
    if ($valid) {
      $this->usuari = $sessuser;
      $_SESSION['admin_id'] = $c;
 
      if (!headers_sent())
        setcookie("tok", $sessuser->tok, time() + 600);

      $this->idioma();
    }
    return $valid;
  }

  /*   * ******      VALIDA_SESSIO NO MASCARA     ***********
    function valida_sessio_NO_MASK()
    {
    if (!isset($_SESSION))   session_start();
    $valid = (isset($_SESSION['loGin'])  && !empty($_SESSION['loGin']) && $_SESSION['permisos'] > $this->PERMISOS);
    if (!$valid) $this->tanca_sessio();
    return $valid;
    }
   */

  /*   * ******      VALIDA_LOGIN     *********** */

  public function valida_login($permisos = 255, $rusr = "usr", $rpass = "pass", $taula = "admin") {
    if (!isset($_POST['usr']))
      return $this->valida_sessio($permisos);
    $loginUsername = $_REQUEST[$rusr];
    $password = $_REQUEST[$rpass];

    $LoginRS__query = sprintf("SELECT admin_id, usr, pass, permisos FROM $taula WHERE usr='%s' AND pass='%s' AND permisos & $permisos", ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $loginUsername) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")), ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $password) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : "")));

    $LoginRS = mysqli_query($this->connexioDB, $LoginRS__query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $loginFoundUser = mysqli_num_rows($LoginRS);
    $row = mysqli_fetch_assoc($LoginRS);


    if ($loginFoundUser) {
      $usuari = new usuari($row['admin_id'], $loginUsername, $row['permisos']);
      if (!isset($_SESSION))
        session_start();
      //$this->usuari=$_SESSION['uSer']=serialize($usuari);

      $this->usuari  = $_SESSION['uSer'] = $usuari;
      $_SESSION['uSer_serialized']  = serialize($usuari);
      $_SESSION['loGin'] = $loginUsername;
      $_SESSION['permisos'] = $row['permisos'];
      $_SESSION['admin_id'] = intval($row['admin_id']);

      setcookie("tok", "", time() - 3600);
      setcookie("tok", $_SESSION['uSer']->tok, time() + 6000);

      return true;
    }

    //$this->tanca_sessio();
    return false;
  }

  /*   * ******      TANCA_SESSIO     *********** */

  public static function tanca_sessio($redir = null) {
    if (!isset($_SESSION))
      session_start();
    //$sessuser=unserialize($_SESSION['uSer']);
    $sessuser = $_SESSION['uSer'];
    $sessuser->id = null;
    $sessuser->nom = null;
    $sessuser->permisos = null;
    $sessuser->tok = null;
    $sessuser->session_id = null;
    $sessuser = null;
    unset($_SESSION['uSer']);

    //versió antiga
    $_SESSION['loGin'] = null;
    unset($_SESSION['loGin']);
    $_SESSION['permisos'] = null;
    $_SESSION['admin_id'] = null;

    setcookie("tok", "", time() - 3600);

    session_unset();
    session_destroy();

    if ($redir)
      header("Location: " . $redir);
  }

  /*   * ********************************************************************************************************************* */

  public function usuari($id = null) {
    if ($id < 1)
      return "SENSE DADES";

    $query = "SELECT usr FROM admin WHERE admin_id=$id";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nfiles = mysqli_num_rows($Result1);

    if ($nfiles)
      $row = mysqli_fetch_array($Result1);
    return $row['usr'];
  }

  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */

// FUNCIONS GENERALS
  /*   * ************************************************************************************************************** */
  /*   * ************************************************************************************************************** */


  /*   * ******      INSERT ID     *********** */
  protected function insert_id() {
    //return ((is_null($___mysqli_res = mysqli_insert_id($GLOBALS["___mysqli_ston"]))) ? false : $___mysqli_res);
    return mysqli_insert_id($this->connexioDB);
  }

  /*   * ******      ORDRE     *********** */

  protected function ordre() {
    if ($_REQUEST['ord']) {
      if ($_SESSION['ord'] == $_REQUEST['ord'])
        $_SESSION['desc'] = !$_SESSION['desc'];

      $_SESSION['ord'] = $_REQUEST['ord'];
    }
    if (isset($_SESSION['ord']))
      $this->ord = " ORDER BY " . $_SESSION['ord'] . ($_SESSION['desc'] ? " DESC " : " ");
  }

  /*   * ************************************************************************************** */

  public static function log_mysql_query($query, $conn = null, $charset = false) {
    $log_querys_file = ROOT . INC_FILE_PATH . LOG_QUERYS_FILE;
    if (!$conn)
      $conn = $this->connexioDB;
    
    if (Gestor::stringMultiSearch($query, LOG_QUERYS) && DEBUG === false) {
      $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
      $sessuser = $_SESSION['uSer'];

      //$sep="";
      //$miniquery ='<span class="miniquery">'.substr($query,0,50).'</span>';
      //if ($type==0) $sep = '</ul><ul class="level-0 ">/* >>>  ' . date("d M Y H:i:s") . ' >>> ' . $miniquery .EOL;
      //error_log($sep, 3, $log_querys_file);
      error_log('<li class="level-1 user">usr:' . $sessuser->id . " ($ip)</li>", 3, $log_querys_file);

      $query = str_replace("\n", " ", $query);
      $query = str_replace("\r", " ", $query);
      $query = str_replace("<br/>", " ", $query);
      $query = str_replace("<br>", " ", $query);
      $query = str_replace("<\br>", " ", $query);
      $query = trim($query);

      if (substr($query, -1) != ";")
        $query = $query . ";";
      error_log('<li  class="level-1 query" >' . $query . '</li>', 3, $log_querys_file);
      //if (substr($query,0,26)=='INSERT INTO reservestaules') die($query);
    }

    if ($charset)      $query = gestor_reserves::charset($query);
//echo "$query······3333";die();
    $r = mysqli_query($conn, $query);
    if (Gestor::stringMultiSearch($query, LOG_QUERYS) && DEBUG === false) {
      $insert_id = ((is_null($___mysqli_res = mysqli_insert_id($conn))) ? false : $___mysqli_res);
      $affected = mysqli_affected_rows($conn);
      $result = ' -- Affected: ' . $affected;
      if ($insert_id)
        $result.=' / Insert ID: ' . $insert_id;
      error_log(EOL . '<li>' . $result . '</li>', 3, $log_querys_file);
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
      error_log(EOL . '<li>' . $req . '</li>' . EOL . EOL, 3, $log_querys_file);
    }
    Gestor::rename_big_file($log_querys_file, 2000000);

    return $r;
  }

  /*   * ************************************************************************************** */

  public static function SQLVal($theValue, $theType = "text", $theDefinedValue = "", $theNotDefinedValue = "") {
    $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

    switch ($theType) {
           case "no_quotes":
         $theValue = str_replace("'","ʻ",$theValue);
         $theValue = str_replace('"',"ʺ",$theValue);
          $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
        // $theValue = htmlentities($theValue,ENT_QUOTES);
        
        break;

      
      case "text":
         $theValue = htmlspecialchars($theValue,ENT_QUOTES);
        // $theValue = htmlentities($theValue,ENT_QUOTES);
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
      case "datePHP":
        $theValue = ($theValue != "") ? "'" . Gestor::cambiaf_a_mysql($theValue) . "'" : "NULL";
        break;
      case "zero":
        $theValue = ($theValue != "") ? "'" . $theValue . "'" : "0";
        break;
      case "defined":
        $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
        break;
    }
    return $theValue;
  }

  /*   * ************************************************************************************** */

  public static function out($t) {
    if (is_array($t)) print_r($t);
    if (mb_detect_encoding($t) != "UTF-8")
      $t = utf8_encode($t);
    echo $t;
  }

  /*   * ************************************************************************************** */

  protected function jeditmw($id, $val) {
    if (!$this->valida_sessio($this->USUARI_MINIM)) {
      return "Sin permisos para editar este campo (jedit)"; //$this->mensa_error("Sin permisos para editar este campo (jedit)");
    }
    $ar = explode("__", $id);
    if (count($ar) > 2) { // taula__camp__id
      $taula = $ar[0];
      $camp = $ar[1];
      $nid = $ar[2];
    }
    else {
      $nid = $ar[count($ar) - 1]; // taula_camp__id
      $ar2 = explode("_", $ar[0]);
      $taula = $ar2[0];
      $camp = $ar[0];
    }

    $p = '~^([0]?[1-9]|[1|2][0-9]|[3][0|1])[./-]([0]?[1-9]|[1][0-2])[./-]([0-9]{4}|[0-9]{2})$~';
    if (preg_match($p, trim($val)))
      $val = $this->cambiaf_a_mysql(trim($val));

    $val = str_replace("€", "&euro;", $val);
    $val = ((isset($GLOBALS["___mysqli_ston"]) && is_object($GLOBALS["___mysqli_ston"])) ? mysqli_real_escape_string($GLOBALS["___mysqli_ston"], $val) : ((trigger_error("[MySQLConverterToo] Fix the mysql_escape_string() call! This code does not work.", E_USER_ERROR)) ? "" : ""));

    $_REQUEST['p'] = isset($_REQUEST['p']) ? $_REQUEST['p'] : "";

    if (is_numeric($_REQUEST['p']))
      $filtre = $taula . "_id='" . $_REQUEST['p'] . "'";
    elseif (is_numeric($nid))
      $filtre = $taula . "_id='" . $nid . "'";
    else
      $filtre = $_REQUEST['p'] . "=" . $_REQUEST['p2'] . "'";

    $camp_id = $taula . "_id";

    $query = "UPDATE $taula SET $camp='$val' WHERE $filtre";
    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $query = "SELECT $camp FROM $taula WHERE $filtre";

    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($result);
    $ret = $row[$camp];

    $p = '~^((((19|20)(([02468][048])|([13579][26]))-02-29))|((20[0-9][0-9])|(19[0-9][0-9]))-((((0[1-9])|(1[0-2]))-((0[1-9])|(1\d)|(2[0-8])))|((((0[13578])|(1[02]))-31)|(((0[1,3-9])|(1[0-2]))-(29|30)))))$~';
    if (preg_match($p, substr($ret, 0, 10)))
      $ret = $this->cambiaf_a_normal(substr($ret, 0, 10));

    return $ret;
  }

  /*   * ************************************************************************************** */

  public static function stringMultiSearch($src, $needle) {
    $searchstrings = $needle;
    $breakstrings = explode(',', $searchstrings);

    foreach ($breakstrings as $values) {
      if (strpos($src, $values) === false) {
        continue;
      }
      else {
        return true;
      }
    }
    return false;
  }

  /*   * ************************************************************************************** */

  public static function greg_log($text, $file = false, $reqest = true, $type = 0) {


    if (!$file)
      $file = LOG_FILE;
    $file = ROOT . INC_FILE_PATH . $file;
    $req = '';
    if ($reqest) {
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
    }
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    $user = 0;
    $sessuser = isset($_SESSION['uSer']) ? $_SESSION['uSer'] : null;
    if (isset($sessuser))
      $user = $sessuser->id;
    $sep = "/* >>> " . date("d M Y H:i:s") . " user:$user ($ip) <<< */" . EOL;

    $text = $sep . $text . BR;
    $text = nl2br($text);
    //$text+="\n\n";
    error_log($text . $req . EOL, 3, $file);

    Gestor::rename_big_file($file, 10000000);
  }

  /*   * ************************************************************************************** */

  public static function xgreg_log($text, $type = 0, $file = false, $reqest = true) {
    if (!is_numeric($type)) {
      // COMPATIBILITAT PER ERROR EN ELS PARAMETRES
      $reqest = $file;
      $file = $type;
    }

    if (!$file) {
      $file = LOG_FILE;
    }

    $file = ROOT . INC_FILE_PATH . $file;
    $req = '';
    if ($reqest && !$type) {
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
    }
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    
    
    $sessuser = $_SESSION['uSer'];

    if (isset($sessuser))
      $user = $sessuser->id;

    $sep = "";
    if ($type == 0)
      $text = '</ul>' . EOL . '<ul class="level-0"> >>> <span class="date">' . date("Y-m-d H:i:s") . "</span> user:$user ($ip) >>>> " . $text . EOL;
    if ($type == 1)
      $text = '<li>' . $text . '</li>' . EOL;

    error_log($text . EOL . $req . EOL, 3, $file);

    Gestor::rename_big_file($file, 10000000);
  }

  /*   * ************************************************************************************** */

  public static function log_array($arr, $class = 'array') {
    $tarr = print_r($arr, TRUE);
    $t = '<pre class="' . $class . '">' . $tarr . '</pre>';
    return $t;
  }

  /*   * ************************************************************************************** */

  public static function rename_big_file($file = NULL, $size = 1000000) {
    if (!$file)
      $file = ROOT . INC_FILE_PATH . LOG_FILE;

    clearstatcache();
    $fs = filesize($file);
    $extra = "";
    if ($fs > $size) {

      $extra.="_" . date("Y-m-d H:i:s");
      $path_parts = pathinfo($file);
      $parts = explode("." . $path_parts['extension'], $file);
      $nparts = count($parts);
      if ($nparts > 1)
        $nom = $parts[$nparts - 2];

      $rename = $nom . $extra . "." . $path_parts['extension'];


      error_log("</ul>", 3, $file);
      error_log('<ul class="fi-li">' . EOL . '<li>' . EOL . '<h2> /*RENAME_LOG: ' . $rename . " >>> " . date("Y-m-d H:i:s") . EOL . "*/ </h2>'.EOL.'</li></ul>******END******", 3, $file);



      copy($file, $rename);
      $f = fopen($file, "w");
      fclose($f);

      $link = "/panel/read.php?f=$rename";
      error_log('<div><a href="' . $link . '">FITXER ANTERIOR: ' . $link . '</a></div>' . EOL, 3, $file);
      error_log("<div><h2> " . date("Y-m-d H:i:s") . " </h2></div>" . EOL, 3, $file);
      error_log('<ul class="ini-li">' . EOL, 3, $file);

      return $rename;
    }
    return false;
  }

  /*   * ************************************************************************************** */

  public static function normalitzar($string) {
    $table = array(
      'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'd' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c',
      'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
      'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
      'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
      'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'ç' => 'c', 'è' => 'e', 'é' => 'e',
      'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o',
      'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
      'ÿ' => 'y', 'R' => 'R', 'r' => 'r', ' ' => '_', '-' => '_',
    );

    return strtr($string, $table);
  }

  public static function upperNoTilde($string) {
    $table = array(
      'Š' => 'S', 'š' => 's', 'Ð' => 'Dj', 'd' => 'dj', 'Ž' => 'Z', 'ž' => 'z', 'C' => 'C', 'c' => 'c', 'C' => 'C', 'c' => 'c',
      'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A', 'Ç' => 'C', 'È' => 'E', 'É' => 'E',
      'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O',
      'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ý' => 'Y', 'Þ' => 'B', 'ß' => 'Ss',
      'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a', 'è' => 'e', 'é' => 'e',
      'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'o', 'ò' => 'o', 'ó' => 'o',
      'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ý' => 'y', 'ý' => 'y', 'þ' => 'b',
      'ÿ' => 'y', 'R' => 'R', 'r' => 'r',
    );

    return strtoupper(strtr($string, $table));
  }

  /*   * ************************************************************************************** */

  public static function cambiaf_a_normal($fecha, $format = "%d/%m/%Y") {
    $fecha = str_replace("/", "-", $fecha);
    preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    if (!isset($mifecha[1]))
      return FALSE;
    if (strlen($mifecha[1]) != 4)
      return $fecha;
    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];

    if ($lafecha == "//")
      return "";

    $lafecha = strftime($format, mktime(0, 0, 0, $mifecha[2], $mifecha[3], $mifecha[1]));

    return $lafecha;
  }

  /*   * ************************************************************************************** */

  public static function cambiaf_a_mysql($fecha) {
    $fecha = str_replace("-", "/", $fecha);
    preg_match('/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/', $fecha, $mifecha);
    
    if (!isset($mifecha[3])) return $fecha;
    if ( strlen($mifecha[3]) != 4) {
      $fecha = str_replace("/", "-", $fecha);
      return $fecha;
    }
    else
      $lafecha = $mifecha[3] . "-" . str_pad($mifecha[2], 2, '0', STR_PAD_LEFT) . "-" . str_pad($mifecha[1], 2, '0', STR_PAD_LEFT);
    //print_r($mifecha);
//echo $fecha;die();

    return $lafecha;
  }

  /*   * *************************************************************************************************** */

  public function concatena($str1, $str2, $needle) {
    if (empty($str1) || empty($str2))
      $needle = "";
    return $str1 . $needle . $str2;
  }

  /*   * *************************************************************************************************** */

  protected function setLang($lang) {

    if (!empty($lang))
      $_SESSION["idioma"] = $_SESSION["lang"] = $_GET["lang"] = $lang = "cat";
    if (!isset($_SESSION["idioma"]))
      $_SESSION["idioma"] = $_SESSION["lang"] = $_GET["lang"] = $lang = "cat";



    $this->lng = substr($lang, 0, 2);
  }

  static function l($text, $echo = true) {
    global $translate; //	return $translate[$text];
    global $notrans;

    if (TRANSLATE_DEBUG === true) {
      if (isset($translate[$text]))
        if ($translate[$text] == "=")
          $trans = '<span class=\'igual\'>' . $text . '</span>';
        else
          $trans = '<span class=\'translated\'>' . $translate[$text] . '</span>';
      else
        $trans = TRANSLATE_NO_TRANS . '<span class=\'no-trans\'>' . $text . '</span>';
    }
    else {
      if (isset($translate[$text])) {
        if ($translate[$text] == "=")
          $trans = $text;
        else
          $trans = $translate[$text];
      }
      else
        $trans = $text;
    }

    if ($echo)
      echo $trans;

    return ($trans);
  }
  
  /*   * *************************************************************************************************** */

  static function newlang($oldlang){
    $map['cat'] = $map['ca'] = 'ca';
    $map['esp'] = $map['es'] = 'es';
    $map['eng'] = $map['en'] = 'en';
    
    return $map[$oldlang];
  }
  static function oldlang($newlang){
    $map['cat'] = $map['ca'] = 'cat';
    $map['esp'] = $map['es'] = 'esp';
    $map['eng'] = $map['en'] = 'eng';
    
    return $map[$newlang];
  }
 /*   * *************************************************************************************************** */
  
    static function lv($text) {
      return Gestor::l($text, FALSE);
    }

  /*   * *************************************************************************************************** */

  protected function addError($errNo) {
    $this->arError[] = $errNo;

    return false;
  }

  /*   * ****************************************************************************** */

  protected function gllistaErrors($ar = null) {
    if (!$ar)
      $ar = $this->arTxtError;
    if (!$this->arError)
      return false;
    $ant = 0;
    $r = '<div class="error "style="float:left;font-size:0.8em;padding:4px;margin:4px;border:lightgray solid 1px;"><ul>';
    foreach ($this->arError as $k => $v) {
      if ($v == $ant)
        continue;
      $ant = $v;
      $r.="<li>" . $ar[$v] . "</li>";
    }
    $r.="</ul></div>";

    return $r;
  }

  /*   * *************************************************************************************************** */
  /*   * ****************************************************************************** */
  /*   * ****************************************************************************** */
  /*   * *************************************************************************************************** */

  protected function jsonErr($codi, $merge = null) {
    $resposta['resposta'] = "ko";
    $resposta['error'] = $this->error = "err$codi";
    $resposta['error_desc'] = $this->l("err$codi", 0);
    $m = "";
    if ($merge) {
      $resposta = array_merge($resposta, $merge);
      $m = print_r($merge, TRUE);
    }


    $this->xgreg_log("jsonErr $codi >>> $m", 1);
    return json_encode($resposta);
  }

  /*   * *************************************************************************************************** */

  protected function jsonOK($text, $merge = null) {
    $resposta['resposta'] = "ok";
    $resposta['resposta_desc'] = $this->l($text, 0);
    $resposta['error'] = $this->error = null;
    $resposta['error_desc'] = null;
    $m = "";
    if ($merge) {
      $resposta = array_merge($resposta, $merge);
      $m = print_r($merge, TRUE);
    }


    $this->xgreg_log("jsonOK $text >>> $m", 1);
    return json_encode($resposta);
  }

  /*   * *************************************************************************************************** */

  public static function printr($obj) {
    echo "<pre>";
    print_r($obj);
    echo "</pre>";
  }

  /*   * *************************************************************************************************** */

  public static function charset($str_array) {

    if (is_array($str_array)) {
      foreach ($str_array as $k => $v)
        if (Gestor::seems_utf8($v))
          $str_array[$k] = utf8_decode($v);
    }
    else {
      if (Gestor::seems_utf8($str_array))
        $str_array = utf8_decode($str_array);
    }


    return $str_array;
  }

  /*   * *************************************************************************************************** */

  public static function seems_utf8($str) {
    $length = strlen($str);
    for ($i = 0; $i < $length; $i++) {
      $c = ord($str[$i]);
      if ($c < 0x80)
        $n = 0;# 0bbbbbbb
      elseif (($c & 0xE0) == 0xC0)
        $n = 1;# 110bbbbb
      elseif (($c & 0xF0) == 0xE0)
        $n = 2;# 1110bbbb
      elseif (($c & 0xF8) == 0xF0)
        $n = 3;# 11110bbb
      elseif (($c & 0xFC) == 0xF8)
        $n = 4;# 111110bb
      elseif (($c & 0xFE) == 0xFC)
        $n = 5;# 1111110b
      else
        return false;# Does not match any model
      for ($j = 0; $j < $n; $j++) { # n bytes matching 10bbbbbb follow ?
        if (( ++$i == $length) || ((ord($str[$i]) & 0xC0) != 0x80))
          return false;
      }
    }
    return true;
  }

  /*   * *************************************************************************************************** */

  public static function validaEmail($mail) {
    if ($mail !== "") {
      if (ereg("^[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[@]{1}[-A-Za-z0-9_]+[-A-Za-z0-9_.]*[.]{1}[A-Za-z]{2,5}$", $mail)) {
        return true;
      }
      else {
        return false;
      }
    }
    else {
      return false;
    }
  }

  /*   * *************************************************************************************************** */

  public function configVars($nom) {
    if (!isset($this->conf->configVars[$nom]))
      return NULL;
    return $this->conf->configVars[$nom];
  }

  /*   * *************************************************************************************************** */

  public function dumpJSVars($tags = FALSE) {
    return $this->conf->dumpJSVars($tags);
  }

  /*   * *************************************************************************************************** */
  /*
    Retorna el valor (0,2,4,8...) del bit a la posicio $bit dins del $flags ($bit és 1,2,3... zero NO!)
    Si especifiquem $actiu, dona valor al bit i retorna el flag actualitzat
   */

  public static function flagBit($flags, $bit, $actiu = null) {
    $bit--;
    if ($bit < 0)
      return false;
    if (!isset($actiu))
      return ($flags & (1 << $bit));

    $actiu = $actiu ? 1 : 0;
    $flags = ($flags & ~(1 << $bit)) | ((!!$actiu) << $bit);

    return $flags;
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  public function estatReserva($idr) {

    $query = "SELECT estat "
        . "FROM " . T_RESERVES . " "
        . "WHERE id_reserva=$idr";
    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //$row=  mysql_fetch_assoc($result);
    if (!mysqli_num_rows($result))
      return 0;
    return mysqli_result($result, 0);
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  public function generaFormTpvSHA256($id_reserva, $import, $nom, $tpv_ok_callback_alter = NULL) {
    $this->xgreg_log("generaFormTpvSHA256 $id_reserva $import $nom", 0, LOG_FILE_TPVPK, TRUE);

    $id = $order = substr(time(), -4, 3) . $id_reserva;

    $titular = $nom;
    $lang = $this->lang;
    $idioma = ($lang == "cat") ? "003" : "001";
    $amount = $import * 100;

    //include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT 4id i $lang
    include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT 4id i $lang
    ///* MODIFICA PARAMS */
    if (isset($tpv_ok_callback_alter))
      $tpv_ok_callback = $tpv_ok_callback_alter;
    // Valores de entrada del ejemplo de redsy
    //$fuc="999008881";$terminal="871";$moneda="978";$trans="0";//$url="";$urlMerchant="";$urlOKKO="";$urlKO="";$urlOK="";$id=time();$amount="145";
    // Se incluye la librería
    include ROOT.INC_FILE_PATH . 'API_PHP/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php';
    // Se crea Objeto
    $miObj = new RedsysAPI;
    // Se Rellenan los campos
    $miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
    $miObj->setParameter("DS_MERCHANT_ORDER", strval($id));
    $miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
    $miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
    $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
    $miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);

    $miObj->setParameter("DS_MERCHANT_MERCHANTURL", $urlMerchant);
    $miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);
    $miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);

    $miObj->setParameter("Ds_Merchant_ProductDescription", $producte);
    $miObj->setParameter("Ds_Merchant_MerchantName ", $merchantName);
    $miObj->setParameter("Ds_Merchant_Titular", $titular);
    $miObj->setParameter("Ds_Merchant_ConsumerLanguage", $idioma);
    $miObj->setParameter("Ds_Merchant_PayMethods", $paymethods);
    $miObj->setParameter("Ds_Merchant_MerchantData", $tpv_ok_callback);



    // Se generan los parámetros de la petición
    $request = "";
    $params = $miObj->createMerchantParameters();
    $signature = $miObj->createMerchantSignature($clave256);

    /*
      echo   'amount: '.     $amount.'<br>';
      echo   'order: '.     strval($id).'<br>';
      echo   'fuc: '.     $fuc.'<br>';
      echo   'url: '.     $url.'<br>';
      echo   '$producte: '.     $producte.'<br>';
      echo   '$urlMerchant: '.     $urlMerchant.'<br>';
      echo   '$urlMerchant: '.     $tpv_ok_callback.'<br>';
      echo '<br><br>';
     */
    $form = '<form id="compra" name="compra" action="' . $url . '" method="post" target2="_blank" target="frame-tpv"  style="display:nonexxx">
              <div class="ds_input">Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="' . $version . '"/></div>
              <div class="ds_input">Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="' . $params . '"/></div>
              <div class="ds_input">Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="' . $signature . '"/></div>
              <!--<input id="boto" type="submit" name="Submit" value="' . $this->l('Realizar Pago', false) . '" onclickxx="javascript:calc();" />-->
                <button id="boto" type="submit" name="Submit" value="' . $this->l('Realizar Pago', false) . '" class="btn btn-success">' . $this->l('Realizar Pago', false) . '</button>
</form>';

    return $form;
  }

  
  /***
   * ATENCIO:
   * 
   * Connexió a redsys en entorn de proves TPV256_test.php
   */
public function generaTESTTpvSHA256($id_reserva, $import, $nom, $tpv_ok_callback_alter = NULL) {
    if ($_SESSION['permisos']<200)       die("Sense permisos");
  
 
  $_LOG_FILE_TPVPK = "TPV256_test.php";
  //$_LOG_FILE_TPVPK = "TPV256.php";
  
  
    $this->xgreg_log("generaFormTpvSHA256 $id_reserva $import $nom", 0, LOG_FILE_TPVPK, TRUE);

    $id = $order = substr(time(), -4, 3) . $id_reserva;

    $titular = $nom;
    $lang = $this->lang;
    $idioma = ($lang == "cat") ? "003" : "001";
    $amount = $import * 100;

    //include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT 4id i $lang
    include(ROOT . INC_FILE_PATH . $_LOG_FILE_TPVPK); //NECESSITO TENIR A PUNT 4id i $lang
    ///* MODIFICA PARAMS */
    if (isset($tpv_ok_callback_alter))
      $tpv_ok_callback = $tpv_ok_callback_alter;

    include ROOT.INC_FILE_PATH . 'API_PHP/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php';
    // Se crea Objeto
    $miObj = new RedsysAPI;
    // Se Rellenan los campos
    $miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);
    $miObj->setParameter("DS_MERCHANT_ORDER", strval($id));
    $miObj->setParameter("DS_MERCHANT_MERCHANTCODE", $fuc);
    $miObj->setParameter("DS_MERCHANT_CURRENCY", $moneda);
    $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $trans);
    $miObj->setParameter("DS_MERCHANT_TERMINAL", $terminal);

    $miObj->setParameter("DS_MERCHANT_MERCHANTURL", $urlMerchant);
    $miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);
    $miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);

    $miObj->setParameter("Ds_Merchant_ProductDescription", $producte);
    $miObj->setParameter("Ds_Merchant_MerchantName ", $merchantName);
    $miObj->setParameter("Ds_Merchant_Titular", $titular);
    $miObj->setParameter("Ds_Merchant_ConsumerLanguage", $idioma);
    $miObj->setParameter("Ds_Merchant_PayMethods", $paymethods);
    $miObj->setParameter("Ds_Merchant_MerchantData", "TEST_".$tpv_ok_callback);



    // Se generan los parámetros de la petición
    $request = "";
    $params = $miObj->createMerchantParameters();
    $signature = $miObj->createMerchantSignature($clave256);


    $form = '<form id="compra" name="compra" action="' . $url . '" method="post" target2="_blank" target="frame-tpv"  style="display:nonexxx">
              <div class="ds_input">Ds_Merchant_SignatureVersion <input type="text" name="Ds_SignatureVersion" value="' . $version . '"/></div>
              <div class="ds_input">Ds_Merchant_MerchantParameters <input type="text" name="Ds_MerchantParameters" value="' . $params . '"/></div>
              <div class="ds_input">Ds_Merchant_Signature <input type="text" name="Ds_Signature" value="' . $signature . '"/></div>
              
                <button id="boto" type="submit" name="Submit" value="' . $this->l('Realizar Pago', false) . '" class="btn btn-success">' . $this->l('Realizar Pago', false) . '</button>
</form>';
    return $form;
  }
  
  /**
   * 
   * @param type $id_reserva
   * @param type $import
   * @param type $nom
   * @param type $responaseok_callback_alter
   * @param type $response
   * @return type
   * 
   * ABANS SIMULAVA LA NOTIFICACIO EN LOCAL, ARA UTILITZO L'ENTORN DE REDSYS DE PROVES
   */
  
  public function ANULATgeneraTESTTpvSHA256($id_reserva, $import, $nom, $responaseok_callback_alter, $response = -1) {
    //if (!$this->valida_sessio(200))
    if ($_SESSION['permisos']<200)       die("Sense permisos");

    $this->xgreg_log("TEST >>> generaTESTTpvSHA256 $id_reserva $import $nom", 0, "/log/log_TPV.txt", TRUE);



    $_REQUEST['pidr'] = $_GET['pidr'] = $id_reserva;
    $_REQUEST['pamount'] = $_GET['pamount'] = $import * 100;
    $_REQUEST['presponse'] = $_GET['presponse'] = $response;
    $_REQUEST['pcallback'] = $_GET['pcallback'] = $responaseok_callback_alter;
    $_REQUEST['init'] = $_GET['init'] = 1;

    $filename = ROOT . "../reservar/testTPV256.php";

    //require $filename;
    ob_start();
    include $filename;
    $contents = ob_get_contents();
    ob_end_clean();
    
    
    
    
    return $contents;
  }

  // PER COMPATIBILITAT!! (reserves grups)
  public function data_llarga($data, $lang = "cat") {
    if (empty($data))
      return false;

    if ($lang == "cat") {
      $dsem = array("Diumenge", "Dilluns", "Dimarts", "Dimecres", "Dijous", "Divendres", "Dissabte", "Diumenge");
      $mes = array("zero", " de Gener", " de Febrer", " de Març", " d´Abril", " de Maig", " de Juny", " de Juliol", " d´Agost", " de Setembre", " d´Octubre", " de Novembre", " de Desembre");
    }
    else {
      $dsem = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
      $mes = array("zero", " de Enero", " de Febrero", " de Marzo", " de Abril", " de Mayo", " de Junio", " de Julio", " de Agosto", " de Septiembre", " de Octubre", " de Noviembre", " de Diciembre");
    }

    $exp = explode("-", $data);
    $y = $exp[0];
    $m = $exp[1];
    $d = $exp[2];

    $mk = mktime(0, 0, 0, (int) $m, (int) $d, (int) $y);
    $ar_dat = getdate($mk);
    $ds = $ar_dat["wday"];

    $data_cat = $dsem[(int) $ds] . ", " . $d . $mes[(int) $m] . " de " . $y;
    return $data_cat;
  }

  /** ***************************************************************************************************
    ES FINDE?
  */
  private  function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}
  /** ***************************************************************************************************
    Recupera idioma
  */
  public static function getLanguage() {
    //$url = isset($_GET['url'])?$_GET['url']:'/';
    $lang = 'ca';
    if (!isset($_SESSION))
      session_start();
    if (isset($_SESSION['lang']))
      $lang = $_SESSION['lang'];
    if (isset($_GET['lang']))
      $lang = $_GET['lang'];
    
    $language = preg_replace('%^/(\w+?)/.*$%', '$1', $_SERVER["REQUEST_URI"]);
       
    if (in_array($language, array('ca','es','en'))) $lang = $language;
//$_SESSION['lang'] = $lang;  
    
    $_SESSION['lang'] = $lang;
    return Gestor::codelang($lang);
  }

  public static function codelang($lang) {
    return substr($lang,0,2);
  }
  
  /*   * *************************************************************************************************** */
  /*
    treu el codi html per carregar jquery + jquery ui del cdn de jquery
   */

  public static function loadJQuery($jqversion = "2.0.3", $uiversion = "1.10.4", $cdn = TRUE) {

    $ROOT = ROOT;
    if (!$cdn){
      $html = <<< EOHTML
<!-- ************************************************* -->            
<!-- ************************************************* -->            
<!-- *********      GESTOR::loadJQuery      ********** -->            
<!-- *********      LOOOOOOOOOCAAAAAAL      ********** -->            
<!-- *********      LOOOOOOOOOCAAAAAAL      ********** -->            
<!-- ************************************************* -->            
<!-- ************************************************* -->
 <script  type="text/javascript" src="{$ROOT}js/jquery-{$jqversion}.min.js"></script>
 <script  type="text/javascript" src="{$ROOT}js/jquery-ui-{$uiversion}.custom/js/jquery-ui-{$uiversion}.custom.min.js"></script>
<!-- ************************************************* -->            
<!-- *********      LOOOOOOOOOCAAAAAAL      ********** -->            
<!-- *********      LOOOOOOOOOCAAAAAAL      ********** -->            
 <!-- ************************************************* -->            
<!-- ************************************************* -->            
<!-- ************************************************* --> 
EOHTML;

 return $html;
    }

    $html = <<< EOHTML
                
<!-- ************************************************* -->            
<!-- ************************************************* -->            
<!-- *********      GESTOR::loadJQuery      ********** -->            
<!-- ************************************************* -->            
<!-- ************************************************* -->            
<script  type="text/javascript" src="//code.jquery.com/jquery-{$jqversion}.min.js"></script>

<script  type="text/javascript">window.jQuery || document.write('<script  type="text/javascript" src="{$ROOT}js/jquery-{$jqversion}.min.js"><script>')</script>
<script  type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/{$uiversion}/jquery-ui.min.js"></script>    
<script type="text/javascript">
    if (typeof jQuery.ui == 'undefined') {
        document.write(unescape("%3Cscript  type='text/javascript' src='{$ROOT}js/jquery-ui-{$uiversion}.custom/js/jquery-ui-{$uiversion}.custom.min.js' type='text/javascript'%3E%3C/script%3E"));
    };
</script>                          
<!-- ************************************************* -->            
<!-- ************************************************* -->            
<!-- ************************************************* -->            
<!-- ************************************************* -->            

EOHTML;

    return $html;
  }

  /*   * *************************************************************************************************** */

// TEST
  /*   * *************************************************************************************************** */
  function test($t) {
    echo $test = "Gestor TEST: " . $t;
    return $test;
  }

}

///CLASS
?>
