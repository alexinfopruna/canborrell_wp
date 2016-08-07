<?php

if (!defined('ROOT'))
  define('ROOT', "");
require_once(ROOT . "EstatTaula.php");
require_once(ROOT . "Gestor.php");

class Reserva extends Gestor {

  public $id;
  public $data;
  public $hora;
  public $torn;
  public $adults;
  public $juniors;
  public $nens;
  public $persones;
  public $cotxets;
  public $taula = null;
  public $client = null;
  public $estat;
  private $data_BASE = "2011-01-01";

  public function Reserva($id = null, $data = null, $hora = null, $adults = null, $juniors = null, $nens = null, $cotxets = null, $client = null) {
    $usuari_minim = NULL;
    $db_connection_file = NULL;
    $torn = 0;
    parent::__construct($db_connection_file, $usuari_minim);

    $this->id = $id;
    $this->data = $data;
    $this->hora = $hora;
    $this->torn = $torn;
    $this->adults = $adults;
    $this->juniors = $juniors;
    $this->nens = $nens;
    $this->cotxets = $cotxets;
    $this->client = $client;

    if ($id && !$data) {
      if (!$row = $this->loadReserva($id))
        return $this->id = false;

      $this->id = $row['id_reserva'];
      $this->data = $row['data'];
      $this->hora = $row['hora'];
      $this->torn = $row['estat_taula_torn'];
      $this->adults = $row['adults'];
      $this->juniors = $row['nens10_14'];
      $this->nens = $row['nens4_9'];
      $this->persones = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
      $this->cotxets = $row['cotxets'];
      $this->client['id'] = $row['client_id'];
      $this->client['nom'] = $row['client_nom'];
      $this->client['cognoms'] = $row['client_cognoms'];
      $this->client['email'] = $row['client_email'];
      $this->client['mobil'] = $row['client_mobil'];
      $this->client['telefon'] = $row['client_telefon'];
      $this->client['observacions'] = $row['observacions'];
      $this->client['conflictes'] = $row['client_conflictes'];

      //$this->last_row=array();
    }
  }

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******   LOAD_RESERVA  ******** */
  /*   * ************************************* */
  /*   * ************************************* */

  private function loadReserva($id_reserva) {
    $query = "SELECT * FROM " . T_RESERVES . " 
			LEFT JOIN client ON " . T_RESERVES . ".client_id=client.client_id
			LEFT JOIN " . ESTAT_TAULES . " ON " . T_RESERVES . ".id_reserva=" . ESTAT_TAULES . ".reserva_id
			WHERE " . T_RESERVES . ".id_reserva='" . $id_reserva . "'";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (!$this->total_rows = mysqli_num_rows($this->qry_result))
      return false;
    $r = $this->last_row = mysqli_fetch_assoc($this->qry_result);

    $this->taula = new EstatTaula($r['estat_taula_taula_id'], $r['estat_taula_nom'], $r['data'], $r['hora'], $r['estat_taula_persones'], $r['estat_taula_cotxets'], $r['estat_taula_plena'], $r['estat_taula_x'], $r['estat_taula_y']);
    $this->taula->torn = $r['estat_taula_torn'];
    $this->taula->reserva_id = $r['reserva_id'];

    return $this->last_row;
  }

  private function guardaReservaPost() {
    //TODO
  }

  private function esborraReserva($id) {
    //TODO
  }

  private function updateReservaPost($id = null) {
    //TODO
  }

}

if (false) {
  $r = new Reserva($_GET['r']);
  if (!$r->id)
    die($r->id . " NO TROBADA");
  print_r($r);
}
?>
