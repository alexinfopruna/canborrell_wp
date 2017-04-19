<?php
if (!defined('ROOT'))
  define('ROOT', "../");
require_once(ROOT . "Gestor.php");


/* * ************************************************************************************* */
/* * ************************************************************************************* */
// GESTIONA OPERACIONS DE CERCA SOBRE RESERVES I CLIENTS
/* * ************************************************************************************* */
/* * ************************************************************************************* */
class DBTable extends Gestor {
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  public $TABLE;
  public $QUERY;
  public $FILTRE;
  public $ORDRE;
  public $PAG_INI;
  public $PAG_FI;

  public function DBTable($table_query) {
    $were = "";
    $order = "";
    $usuari_minim = 63;
    parent::__construct(DB_CONNECTION_FILE, $usuari_minim);

    if (!empty($were) && substr($were, 0, 5) != "WHERE")
      $were = "WHERE " . $were;
    $were = trim($were);
    $were = " " . $were;

    if (!empty($order) && substr($order, 0, 8) != "ORDER BY")
      $order = "ORDER BY " . $order;
    $order = trim($order);
    $order = " " . $order;

    if (substr($table_query, 0, 6) == "SELECT") {
      $this->QUERY = $table_query;
      preg_match('/\bfrom\b\s*(\w+)/i', $table_query, $matches);
      $this->TABLE = $matches[1];
    }
    else {
      $this->TABLE = $table_query;
      $this->QUERY = "SELECT *,
        " . $table_query . "_id AS idR , 
        " . $table_query . "_id AS ui_icon_trash 
        FROM 
        $table_query
        ";
    }
  }
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////
  //
  public function query($were = "", $order = "") {
    if (!empty($were) && substr($were, 0, 5) != "WHERE")
      $were = "WHERE " . $were;
    $were = trim($were);
    $were = " " . $were;
    if (!empty($order) && substr($order, 0, 8) != "ORDER BY")
      $order = "ORDER BY " . $order;
    $order = trim($order);
    $order = " " . $order;
    $res = mysqli_query($GLOBALS["___mysqli_ston"], $this->QUERY . $were . $order);
    return $res;
  }
  //
  //		
  ///////////////////////////////////////////////////////
  
  public function controlsTaula($fila, $columna) {
    $ui = str_replace("_", "-", $columna);
    if ($ui == "idR")
      return '<a href="form_' . $this->TABLE . '.php?' . $columna . '=' . $fila[$columna] . '">' . $fila[$columna] . '</a>';

    if (substr($ui, 0, 7) == "ui-icon")
      return '<a href="' . $_SERVER['PHP_SELF'] . '?' . $columna . '=' . $fila[$columna] . '"><span class="ui-icon ' . $ui . '"></span></a>';
    
    if (substr($ui, 0, 4) == "ext-") {
      $camps = explode("-", $ui);
      $taula = $camps[1];
      $ui = "ui-icon-zoomin";
      return '<a href="form_' . $taula . '.php?idR=' . $fila[$columna] . '" ext="' . $taula . '"><span class="ui-icon ' . $ui . '"></span></a>';
    }

    if (UPPER_NO_TILDE === true) return Gestor::upperNoTilde($fila[$columna]);

    return $fila[$columna];
  }

  public static function respostaAJAX($missatge_n_error, $dialog = 0, $refresh = 0) {
    if ($err = is_numeric($missatge_n_error)) {
      $json["n_error"] = $missatge_n_error;
      $json["m_error"] = "ERROR DE SERVIDOR";
      $json["missatge"] = "";
    }
    else {
      $json["missatge"] = $missatge;
    }
    $json["resultat"] = $err ? "ko" : "ok";
    $json["dialog"] = $dialog;
    $json["refresh"] = $refresh;

    die(json_encode($json));
  }

  ///////////////////////////////////////////////////////
  //
  public static function peticionsAJAX($TABLE = null) {
    if (isset($_REQUEST['ui_icon_trash'])) {
      $query = "DELETE 
					FROM $TABLE 					WHERE " . $TABLE . "_id=" . $_REQUEST['ui_icon_trash'];
      $res = mysqli_query($GLOBALS["___mysqli_ston"], $query);
      self::respostaAJAX("Registre id=" . $_REQUEST['ui_icon_trash'] . " ESBORRAT", 0, 1);
    }
  }

  //
  //		
  ///////////////////////////////////////////////////////

  public function updateValor($id, $val) {
    return $this->jeditmw($id, $val);
  }
}