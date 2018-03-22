<?php

if (!defined('ROOT'))
  define('ROOT', "");
require_once(ROOT . "Gestor.php");
require_once(ROOT . "Menjador.php");

define('CREA_TAULA_Y', 390);

class EstatTaula extends Gestor {

  public $id;
  public $nom;
  public $data;
  public $hora;
  public $torn;
  public $persones;
  public $cotxets;
  public $plena;
  public $reserva_id = 0;
  public $punts = 0;
  public $menjador;
  //private static $menjadors;

  public $x;
  public $y;
  public $taulaVirtual = true;
  private $data_BASE = "2011-01-01";

  /**
   * Constructor with default values 
   * ID POT SER ID DE TAULA O ID DE RESERVA
   * NOM pot ser nom o torn
   *
   * es pot cridar ams tots params 
   * o
   * new EstatTaula(taula_id,torn,data)
   */
  public function __construct($taula_id = null, $nom_o_torn = null, $data = 0, $hora = 0, $persones = 0, $cotxets = 0, $plena = 0, $x = 0, $y = 0, $punts = 0) {
    $db_connection_file = NULL;
    $usuari_minim = NULL;
    parent::__construct($db_connection_file, $usuari_minim);

    //COORDENADES MENJADORS		
    $this->data = $data;
    if (!$taula_id) {
      $taula_id = time();
      $this->torn = $torn = $nom_o_torn;
      $nom = $this->assignaNom("OL");
      $i = substr($nom, 2, 10);
      $y = CREA_TAULA_Y;
      $x = $this->calculaX($this->data, $this->torn);
    }
    else {
      $this->taulaVirtual = false;
      $this->torn = $torn = null;
      $nom = $nom_o_torn;
    }

    $this->id = $taula_id;
    $this->nom = $nom;
    $this->hora = $hora;
    $this->torn = $torn;
    $this->persones = $persones;
    $this->cotxets = $cotxets;
    $this->plena = $plena;
    $this->x = $x;
    $this->y = $y;
    $this->punts = $punts;
    if (empty($hora) && empty($persones))
      $this->recuperaTaula($taula_id, $data, $nom_o_torn);
    $this->quinMenjador();
  }

/** constructor compatibilitat */
public function EstatTaula($taula_id = null, $nom_o_torn = null, $data = 0, $hora = 0, $persones = 0, $cotxets = 0, $plena = 0, $x = 0, $y = 0, $punts = 0) {
 self::__construct($taula_id , $nom_o_torn , $data , $hora , $persones, $cotxets, $plena, $x, $y, $punts);
}

  private function calculaX($mydata, $torn) {
    $query = "SELECT estat_taula_x AS cnt FROM " . ESTAT_TAULES . " 	
		WHERE (estat_taula_data = '$mydata' AND estat_taula_torn = $torn) 
		AND estat_taula_nom LIKE 'OL%' 
		AND estat_taula_y = " . CREA_TAULA_Y . "
		ORDER BY estat_taula_x DESC";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $cnt = mysqli_num_rows($Result1);

    $x = 32 * ($cnt) + 22;
    return $x;
  }

  

  private function recuperaTaula($taula_id, $mydata, $torn) {
    $this->taulaVirtual = false;
    $base = $this->data_BASE;

    $query = "SELECT * FROM " . ESTAT_TAULES . " 	WHERE estat_taula_taula_id=$taula_id AND
	/* DATA, TORN */ ((estat_taula_data='$mydata' AND estat_taula_torn=$torn) 
							OR
	/* BASE SOLA */ 	(estat_taula_data = '$base' AND estat_taula_torn=$torn ))
	ORDER BY estat_taula_data DESC";
//echo $query;	
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!mysqli_num_rows($Result1))
      return false;
    $row = mysqli_fetch_array($Result1);

    $this->id = $row['estat_taula_taula_id'];
    $this->nom = $row['estat_taula_nom'];
    $this->data = $row['estat_taula_data'];
    $this->torn = $row['estat_taula_torn']; //	echo "***".$row['estat_taula_torn'];
    $this->persones = $row['estat_taula_persones'];
    $this->cotxets = $row['estat_taula_cotxets'];
    $this->plena = $row['estat_taula_plena'];
    $this->x = $row['estat_taula_x'];
    $this->y = $row['estat_taula_y'];


    return $taula_id;
  }

  /*   * ********************************************************************************************************************* */

// MENJADORS 
  /*   * ********************************************************************************************************************* */
  public function guardaTaula() {
    $this->xgreg_log("guardaTaula");
    $grup = 0;
    $query = "INSERT INTO " . ESTAT_TAULES . " 
				(estat_taula_data, estat_taula_torn, estat_taula_taula_id, estat_taula_nom, reserva_id, 
				estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup,estat_taula_plena,estat_taula_usuari_modificacio) 
		VALUES 
				('" .
        $this->data . "','" .
        $this->torn . "','" .
        $this->id . "','" .
        $this->nom . "','" .
        $this->reserva_id . "','" .
        $this->x . "','" .
        $this->y . "','" .
        $this->persones . "','" .
        $this->cotxets . "','" .
        $grup . "','" .
        $this->plena . "','" .
        $_SESSION['admin_id'] .
        "')";
    //$Result1 = $this->log_mysql_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $idt = ((is_null($___mysqli_res = mysqli_insert_id($this->connexioDB))) ? false : $___mysqli_res);
/*
    $deleteSQL = "DELETE FROM " . ESTAT_TAULES . " 
		WHERE estat_taula_taula_id=" . $this->id . "
		AND estat_taula_data='" . $this->data . "' 
		AND estat_taula_torn=" . $this->torn;
*/
    $this->taulaVirtual = false;
    return $idt;
  }

  private function assignaNom($prefix) {
    $data = $this->data;
    $torn = $this->torn;

    $query = "SELECT estat_taula_nom 
		FROM " . ESTAT_TAULES . " 
		WHERE estat_taula_data='$data'
		AND estat_taula_torn=$torn
		AND estat_taula_nom LIKE '%$prefix%'
		
		ORDER BY  estat_taula_nom DESC";


    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_array($Result1);
    $p = explode($prefix, $row['estat_taula_nom']);
    if (!isset($p[1]))
      $p[1] = 0;
    return $prefix . (floor($p[1]) + 1);
  }

  /*   * ********************************************************************************************************************* */

// MENJADORS 
  /*   * ********************************************************************************************************************* */
  private function quinMenjador() {
    $solapa = false;

    include(ROOT . "coord_menjadors.php");
    foreach ($menjadors as $key => $menjador) {
      if ($menjador && $menjador->solapa($this->x, $this->y))
        return $this->menjador = $menjador;
    }

    return $this->menjador = false;
  }

  /*   * ********************************************************************************************************************* */

  public function bloquejada($bloquejats) {
    if (!$bloquejats)      return false;
    
    if (!$this->menjador) return false;
    foreach ($bloquejats as $key => $menjador) {
      if ($menjador->name == $this->menjador->name) {
        $this->menjador->bloquejat = true;
        return true;
      }
    }
    return false;
  }

  /*   * ********************************************************************************************************************* */

// PUNTUACIO
  /*   * ********************************************************************************************************************* */
  public function puntuacioTaula($persones, $cotxets, $extraPunts = 0) {
    $punts = 0;
    if (!$this->id)
      return $this->punts = 0;

    // TODO ORDRE MENJADORS
    if (is_object($this->menjador))
      $punts+=$this->menjador->ordrePunts;

    // TODO PLENA
    //$punts+=($row['estat_taula_persones']==$this->persones)?($row['estat_taula_persones']-$this->persones)*1000:0;
    //$punts+=($row['estat_taula_cotxets']==$this->cotxets)?($row['estat_taula_cotxets']-$this->cotxets)*1000:0;
    $punts+=($persones == $this->persones) ? 1000 : 0;
    $punts+=($cotxets == $this->cotxets) ? 1000 : 0;
    //echo $row['estat_taula_persones'].' - '.$this->persones.' - '.$punts." <br/> ";
    //echo $row['estat_taula_cotxets'].' - '.$this->cotxets.' - '.$punts." <br/> "." <br/> ";

    return $this->punts = $punts + $extraPunts;
  }

}

?>
