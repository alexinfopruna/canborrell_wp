<?php
define('AMF', true);
define('ROOT', "../");
include(ROOT . "php/define.php");

include("vo/com/canBorrell/EstatTaulesVO.php");
include("vo/com/canBorrell/EstatMenjadorVO.php");
include("vo/com/canBorrell/TaulaVO.php");
include("vo/com/canBorrell/UsuariVO.php");
/*
ini_set('display_errors', 'Off');
ini_set('error_reporting', 0);
//error_reporting(E_ALL ^ E_DEPRECATED);
*/
include(ROOT . "php/Configuracio.php");
$config = new Configuracio();

class ControlTaules {

  private $data_BASE = "2011-01-01";

  function recuperaEstat($data, $torn) {
    $mydata = $data;
    $this->recuperaSesion($data, $torn);
    $cercaTornB = "";

    $tornB = $torn;
    if ($torn == 1)
      $tornB = 2;if ($torn == 2)
      $tornB = 1;
    if ($tornB != $torn)
      $cercaTornB = " OR estat_taula_data = '$mydata' AND estat_taula_torn = $tornB AND reserva_id>0";


    $dataBASE = $this->data_BASE;
    if ($data < $this->data_BASE)
      $data = $this->data_BASE;

    require (ROOT . DB_CONNECTION_FILE);
    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $order = "ORDER BY estat_taula_torn=$tornB, estat_taula_data DESC,  estat_taules_timestamp DESC";
    $query = "
			SELECT *," . T_RESERVES . ".client_id AS cclient_id," . T_RESERVES . ".nom AS cclient_nom," . T_RESERVES . ".tel AS ctelefon
			FROM " . ESTAT_TAULES . "
			LEFT JOIN " . T_RESERVES . " ON " . ESTAT_TAULES . ".reserva_id=" . T_RESERVES . ".id_reserva
			LEFT JOIN client ON client.client_id=" . T_RESERVES . ".client_id
			WHERE (estat_taula_data = '$dataBASE' OR estat_taula_data = '$mydata') AND estat_taula_torn = $torn $cercaTornB
			
			$order;
			";


    $Result1 = $this->log_mysql_query($query, $canborrell); //or die("DDDD");//or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //print_r($Result1);
    $taules = array();

    while ($row = mysqli_fetch_array($Result1)) {
      $client = $row['client_cognoms'] . ", " . $row['client_nom'] . "\n(" . $row['client_mobil'] . " - " . $row['client_telefon'] . ")\n" . $row['client_email'];
      $online = $row['reserva_info'] & 1;
      $row['observacions'] = $row['observacions'] . " " . $row['resposta'];
      $taula = new TaulaVO($row['estat_taula_taula_id'], $row['estat_taula_nom'], $row['estat_taula_persones'], $row['estat_taula_cotxets'], $row['estat_taula_grup'], $row['estat_taula_x'], $row['estat_taula_y'], $row['reserva_id'], $row['adults'], $row['nens4_9'], $row['nens10_14'], $row['cotxets'], $row['data'], $row['hora'], $client, $row['estat_taula_plena'], $row['estat_taula_torn'], $row['observacions'], $online, $row['reserva_info']);

      $taules[] = $taula;
    }

    $extra = URL . " *** " . DB_CONNECTION_FILE;
    $estat = new EstatTaulesVO($mydata, $torn, $taules, $extra);
    return $estat;
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function guardaEstat($data, $torn, array $taules) {
    $this->recuperaSesion($data, $torn);

    require (ROOT . DB_CONNECTION_FILE );
    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $str = "";
    $values = "";
    $coma = "";
    $this->xgreg_log('AMFPHP guardaEstat <span class="idr">'.$data.'</span>'); 

    for ($i = 0; $i < count($taules); $i++) {
      $nid = 0;
      $taula = $taules[$i];
      if ($taula->x > 100000)
        $taula->x = -100;
      if ($taula->y > 100000)
        $taula->y = -100;
      $mydata = $data;
      $values = $coma . "('" . $mydata . "','" . $torn . "','" . $taula->id . "','" . $taula->nom . "','" . $taula->reserva . "','" . $taula->x . "','" . $taula->y . "','" . $taula->persones . "','" . $taula->cotxets . "','" . $taula->grup . "','" . $taula->plena . "','" . $_SESSION['admin_id'] . "')";
      $query = "INSERT INTO " . ESTAT_TAULES . " 
				(estat_taula_data, estat_taula_torn, estat_taula_taula_id, estat_taula_nom, reserva_id, 
				estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup,estat_taula_plena,estat_taula_usuari_modificacio) 
		VALUES 
		$values;
		";
      $Result1 = $this->log_mysql_query($query, $canborrell); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      //$Result1 = $this->log_mysql_query($query, $canborrell); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $nid =mysqli_insert_id($canborrell);

      $query = "SELECT * FROM " . ESTAT_TAULES . " 
			WHERE estat_taula_data = '$mydata' 
			AND estat_taula_torn = '$torn'
			AND estat_taula_taula_id = '" . $taula->id . "'
			AND estat_taula_id<>'$nid'";
       $Result1 = $this->log_mysql_query($query, $canborrell); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
     while ($row = mysqli_fetch_array($Result1)) {
       $estat='<pre>'.print_r($row,TRUE).'</pre>';
    $this->xgreg_log('Estat anterior: <br>'.$estat,1); 
       
     }
    
     
      
      
      $query = "DELETE FROM " . ESTAT_TAULES . " 
			WHERE estat_taula_data = '$mydata' 
			AND estat_taula_torn = '$torn'
			AND estat_taula_taula_id = '" . $taula->id . "'
			AND estat_taula_id<>'$nid'";
      $Result1 = $this->log_mysql_query($query, $canborrell); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      if ($mydata == $this->data_BASE && $torn == 1) {
        $this->guardaEstat($data, 2, $taules);
        $this->guardaEstat($data, 3, $taules);
      }
    }


    $this->refresh(true);
    return "RESULTAT: " . $taula->grup . " ---- " . $taula->reserva;
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function guardaEstatMenjador($data, $torn, $menjador, $actiu) {
    $this->xgreg_log('AMFPHP guardaEstatMenjador <span class="idr">'.$data.'</span>'); 
    $this->recuperaSesion($data, $torn);

    //	echo $data;
    //	die();

    require (ROOT . DB_CONNECTION_FILE);

    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $query = "DELETE FROM estat_menjador WHERE estat_menjador_data>'" . $this->data_BASE . "' AND estat_menjador_data < DATE_ADD(NOW(),INTERVAL -1 DAY)";
    $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    if ($data == $this->data_BASE) {
      $query = "INSERT INTO estat_menjador (estat_menjador_data,estat_menjador_torn,estat_menjador_menjador_id,estat_menjador_bloquejat)	VALUES ('$data','1','$menjador','$actiu')";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $lastId = ((is_null($___mysqli_res = mysqli_insert_id($canborrell))) ? false : $___mysqli_res);
      if ($lastId)
        $query = "DELETE FROM estat_menjador WHERE estat_menjador_menjador_id=$menjador AND estat_menjador_id<>$lastId AND estat_menjador_data='$data' AND  estat_menjador_torn='1'";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      $query = "INSERT INTO estat_menjador (estat_menjador_data,estat_menjador_torn,estat_menjador_menjador_id,estat_menjador_bloquejat)	VALUES ('$data','2','$menjador','$actiu')";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $lastId = ((is_null($___mysqli_res = mysqli_insert_id($canborrell))) ? false : $___mysqli_res);
      if ($lastId)
        $query = "DELETE FROM estat_menjador WHERE estat_menjador_menjador_id=$menjador AND estat_menjador_id<>$lastId AND estat_menjador_data='$data' AND  estat_menjador_torn='2'";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      $query = "INSERT INTO estat_menjador (estat_menjador_data,estat_menjador_torn,estat_menjador_menjador_id,estat_menjador_bloquejat)	VALUES ('$data','3','$menjador','$actiu')";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $lastId = ((is_null($___mysqli_res = mysqli_insert_id($canborrell))) ? false : $___mysqli_res);
      if ($lastId)
        $query = "DELETE FROM estat_menjador WHERE estat_menjador_menjador_id=$menjador AND estat_menjador_id<>$lastId AND estat_menjador_data='$data' AND  estat_menjador_torn='3'";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
    else {
      $query = "INSERT INTO estat_menjador (estat_menjador_data,estat_menjador_torn,estat_menjador_menjador_id,estat_menjador_bloquejat)	VALUES ('$data','$torn','$menjador','$actiu')";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $lastId = ((is_null($___mysqli_res = mysqli_insert_id($canborrell))) ? false : $___mysqli_res);
      if ($lastId)
        $query = "DELETE FROM estat_menjador WHERE estat_menjador_menjador_id=$menjador AND estat_menjador_id<>$lastId AND estat_menjador_data='$data' AND  estat_menjador_torn='$torn'";
      $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
    return $this->data_BASE . "RESULTAT: ($data) " . $query . " ---- " . $torn . " LAST ID: $lastId";
  }

  function radioHores($data, $torn) {
    
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function recuperaEstatMenjador($data, $torn) {
    $this->recuperaSesion($data, $torn);
$menjadors = array();

    //if ($data=="1900-01-01") $data=$_SESSION['data'];
    if ($data == "1900-01-01")
      $data = $this->data_BASE;

    require(ROOT . DB_CONNECTION_FILE);
    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $query = "SELECT * FROM estat_menjador
		WHERE 
		(estat_menjador_data='$data'
		AND estat_menjador_torn = '$torn')
		OR (estat_menjador_data = '" . $this->data_BASE . "')
		ORDER BY estat_menjador_id
		";

    $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    while ($row = mysqli_fetch_array($Result1)) {
      $menjador = new EstatMenjadorVO($row['estat_menjador_data'], $row['estat_menjador_torn'], $row['estat_menjador_menjador_id'], $row['estat_menjador_bloquejat']);
      $menjadors[] = $menjador;
    }

    return $menjadors;
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function recuperaUsuari() {
    if (!isset($_SESSION['loGin']))
      return false;
    $usuari = new UsuariVO(0, $_SESSION['loGin'], $_SESSION['permisos']);
    return $usuari;
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function reservaB($data, $torn, $taula) {
    require (ROOT . DB_CONNECTION_FILE);

    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $query = "SELECT COUNT( estat_taula_id ) AS total FROM  `estat_taules` 
WHERE estat_taula_data =  '$data'
AND estat_taula_torn =$torn
AND estat_taula_taula_id=$taula
AND reserva_id >0";
    $Result1 = mysqli_query($canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_array($Result1);

    return $row['total'];
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function torn($data, $hora) {
    require (ROOT . DB_CONNECTION_FILE);
    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $data_BASE = $this->data_BASE;

    $query = "SELECT * FROM `estat_hores` 
WHERE `estat_hores_hora`='$hora'
AND (`estat_hores_data`='$data' OR `estat_hores_data`='$data_BASE')
ORDER BY `estat_hores_data` DESC";

    $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $row = mysqli_fetch_array($Result1);
    return $row['estat_hores_torn'];
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   REFRESH  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  function refresh($update = false) {
    if (!isset($_SESSION['refresh']))
      $_SESSION['refresh'] = '2010-01-01';

    require (ROOT . DB_CONNECTION_FILE);
    ((bool) mysqli_query($canborrell, "USE " . $database_canborrell));

    $data_BASE = $this->data_BASE;

    $data = $_SESSION['data'];
    $data_refresh = $_SESSION['refresh'];

    $query = "SELECT * FROM " . T_RESERVES . "
		RIGHT JOIN " . ESTAT_TAULES . " ON reserva_id=" . T_RESERVES . ".id_reserva
WHERE (
estat_taula_data = '$data'
AND estat_taules_timestamp > '$data_refresh'
)
OR (
estat_taula_data = '$data_BASE'
AND estat_taules_timestamp > '$data_refresh'
)
ORDER BY estat_taules_timestamp DESC";

    $Result1 = $this->log_mysql_query($query, $canborrell) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));


    if (mysqli_num_rows($Result1)) {
      $row = mysqli_fetch_array($Result1);
      $_SESSION['refresh'] = $row['estat_taules_timestamp'];
      if ($update)
        return "no_change";
      return "refresh";
    }
    else
      return "no_change";
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

  function recuperaSesion(&$data, &$torn) {
    //echo " / ".$this->cambiaf_a_mysql($data)." *** ".$this->data_BASE;
    if ($this->cambiaf_a_mysql($data) == $this->data_BASE) {
      $data = $this->cambiaf_a_mysql($data);
      //$torn=1;
      return;
    }

    if (!isset($_SESSION))
      session_start();
    if (!isset($_SESSION['data'])) {
      $_SESSION['data'] = $data;
      $_SESSION['torn'] = $torn;
    }
    $data = $_SESSION['data'];
    $torn = $_SESSION['torn'];
  }

  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ****************************************************************************************************************************** */

//////////////////////////////////////////////////// 
  //Convierte fecha de mysql a normal 
  //////////////////////////////////////////////////// 
  function cambiaf_a_normal($fecha) {
    preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
    if (strlen($mifecha[1]) != 4)
      return $fecha;

    $lafecha = $mifecha[3] . "/" . $mifecha[2] . "/" . $mifecha[1];
    return $lafecha;
  }

  //////////////////////////////////////////////////// 
  //Convierte fecha de normal a mysql 
  //////////////////////////////////////////////////// 

  function cambiaf_a_mysql($fecha) {
    //echo $fecha;die();
    preg_match('/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/', $fecha, $mifecha);
    if (!isset($mifecha[3]))
      return $fecha;
    if (strlen($mifecha[3]) != 4) {
      preg_match('/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/', $fecha, $mifecha);
      $lafecha = $mifecha[1] . "-" . str_pad($mifecha[2], 2, '0', STR_PAD_LEFT) . "-" . str_pad($mifecha[3], 2, '0', STR_PAD_LEFT);
    }
    else
      $lafecha = $mifecha[3] . "-" . str_pad($mifecha[2], 2, '0', STR_PAD_LEFT) . "-" . str_pad($mifecha[1], 2, '0', STR_PAD_LEFT);
    return $lafecha;
  }

  /////////////////////////////////////////////////////////////////////////	
  /////////////////////////////////////////////////////////////////////////	
  /////////////////////////////////////////////////////////////////////////	

  function ANULAAATreg_log($text, $file = LOG_FILE) {
    $file = ROOT . INC_FILE_PATH . $file;
    if (!file_exists($file))
      return false;

    $sep = EOL . "************************************************************************************" . EOL;
    $sep.="************************************************************************************" . EOL;
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    $text.=$sep . date(DATE_ATOM) . " ($ip)>>> " . $text . BR;
    error_log($text . EOL, 3, $file);

    $fs = filesize($file);
    if ($fs > 2000000) {

      error_log("RENAME_LOG: " . $file . date("_d-m-Y_h_i_s") . EOL, 3, $file);
      error_log("RENAME_LOG: " . $file . date("_d-m-Y_h_i_s") . EOL, 3, $file);
      error_log("RENAME_LOG: " . $file . date("_d-m-Y_h_i_s") . EOL, 3, $file);

      $extra.="_" . date("d_m_Y_h_i_s");
      $path_parts = pathinfo($file);

      $parts = explode(".", $file);
      $nparts = count($parts);
      if ($nparts > 1)
        $nom = $parts[$nparts - 2];


      $rename = ROOT . $nom . $extra . "." . $path_parts['extension'];


      copy($file, $rename);
      $f = fopen($file, "w");
      fclose($f);
    }
  }
  
  function xgreg_log($text, $type=0, $file = false, $reqest = true) {
    if (!is_numeric($type)){
      // COMPATIBILITAT PER ERROR EN ELS PARAMETRES
      $reqest = $file; 
      $file = $type;
    }
    
    if (!$file){
      $file = LOG_FILE;
    }
    
    $file = ROOT . INC_FILE_PATH . $file;
    $req = '';
    /*
    if (FALSE && $reqest && !$type) {
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
    }
     * 
     */
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    $sessuser = $_SESSION['uSer'];
    if (isset($sessuser))
      $user = $sessuser->id;
    $sep = "";
    if ($type==0)  $text = '</ul>'.EOL.'<ul class="level-0 amfphp"> >>> <span class="date">' . date("Y-m-d H:i:s") . "</span> user:$user ($ip) >>>> " . $text . EOL;
    if ($type==1)  $text = '<li class="level-1 amfphp">'. $text .'</li>'. EOL;
    
    error_log($text . EOL . $req . EOL, 3, $file);

   // Gestor::rename_big_file($file, 10000000);
  }
  
  function log_mysql_query($query, $conn) {
    $file = ROOT . INC_FILE_PATH . LOG_QUERYS_FILE;
//			if (!file_exists($file)) return false;
    if ($this->stringMultiSearch($query, LOG_QUERYS)) {

      $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
      error_log('<li  class="query amfphp a2" >   '.$query.'</li>', 3, $file);

      $query = str_replace("\n", " ", $query);
      $query = str_replace("\r", " ", $query);
      $query = str_replace("<br>", " ", $query);
      $query = str_replace("<\br>", " ", $query);
      $query = trim($query);
      if (substr($query, -1) != ";")        $query = $query . ";";
      //error_log($query . EOL . EOL, 3, $file);
      $this->rename_big_file(LOG_QUERYS_FILE, 2000000);
    }

    $r = mysqli_query($conn, $query);
    return $r;
  }

  function stringMultiSearch($src, $needle) {
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

  function rename_big_file($file = LOG_QUERYS, $size = 2000000) {
    $file = ROOT . $file;
    if (!file_exists($file))
      return false;
    $fs = filesize($file);
    if ($fs > $size) {

      error_log("/*RENAME_LOG: " . $file . date("_d-m-Y_h_i_s") . EOL . "*/", 3, $file);
      error_log("/*RENAME_LOG: " . $file . date("_d-m-Y_h_i_s") . EOL . "*/", 3, $file);
      error_log("/*RENAME_LOG: " . $file . date("_d-m-Y_h_i_s") . EOL . "*/", 3, $file);

      $extra.="_" . date("Y_m_d_h_i_s");
      $path_parts = pathinfo($file);

      $parts = explode(".", $file);
      $nparts = count($parts);
      if ($nparts > 1)
        $nom = $parts[$nparts - 2];


      $rename = $nom . $extra . "." . $path_parts['extension'];


      copy($file, $rename);
      $f = fopen($file, "w");
      fclose($f);

      return $rename;
    }
    return false;
  }

}

?>