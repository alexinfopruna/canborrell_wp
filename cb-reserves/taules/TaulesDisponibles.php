<?php

if (!defined('ROOT')) 
  define("ROOT", "../taules/");

require_once(ROOT . "Gestor.php");
require_once(ROOT . "EstatTaula.php");
require_once(ROOT . "Menjador.php");
require_once(ROOT . "Reserva.php");

class TaulesDisponibles extends Gestor {

  private $gestor_reserves=null;
  private $data_BASE = "2011-01-01";
  public $data;
  public $hora;
  public $torn = 1;
  public $persones;
  public $cotxets;
  private $menjadors;
  private $menjadorsBloquejats;
  public $tableMenjadors = "estat_menjador";
  public $tableHores = "estat_hores";
  public $defaultTableHores = "estat_hores";
  public $taulesGrans = false;
  public $cotxetsGrans = true;
  public $accesible = false;
  public $creaTaules;
  public $nitsObert = array(false, false, false, false, false, false, false);
  private $taula;
  private $taula_id;
  private $reserva;
  private $reserva_id;
  public $maxTorn;
  public $totalTorn;
  public $llista_dies_negra; // 
  public $llista_nits_negra; // 
  public $llista_dies_blanca; // 
  public $rang_hores_nens = array(); // 
  public $rang_hores_taules = array(); // 
  private $arResultat = null; // RESULTAT PER ID
  private $arResultatTaula = null; //RESULTAT PER OBJ. Taula
  private $arHores = array(); //RESULTAT HORES DISPONIBLES
  private $arTxtError;

  /*   * ************************************* */
  /*   * ************************************* */
  /*   * ******      CONSTRUCTOR     *********** */
  /*   * ************************************* */
  /*   * ************************************* */

 // public function __construct($db_connection_file = DB_CONNECTION_FILE, $usuari_minim = 16) {
  public function __construct($gestor_reserves) {
 //   parent::__construct($db_connection_file, $usuari_minim);
    parent::__construct(DB_CONNECTION_FILE, 16);
    //COORDENADES MENJADORS
    include(ROOT . "coord_menjadors.php");
    $this->gestor_reserves = $gestor_reserves;
    $this->menjadors = $menjadors;
    //RECUPEREM CREA_TAULES i NITS_OBERT DEL CONFIG
     $this->data = $this->data_BASE;
    $this->creaTaules = $this->recupera_creaTaules();



    $this->nitsObert = unserialize(AR__NITS_OBERT);

    $this->reset();
   


    $this->llista_dies_negra = defined('LLISTA_DIES_NEGRA') ? LLISTA_DIES_NEGRA : "zz"; // RESULTAT PER ID
    $this->llista_nits_negra = defined('LLISTA_NITS_NEGRA') ? LLISTA_NITS_NEGRA : "zz"; // RESULTAT PER ID
    $this->llista_dies_blanca = defined('LLISTA_DIES_BLANCA') ? LLISTA_DIES_BLANCA : "zz"; // RESULTAT PER ID


    $this->arTxtError[20] = "Tancat llista NEGRA NITS";
    $this->arTxtError[21] = "Tancat llista NEGRA";
    $this->arTxtError[22] = "Tancat llista NEGRA ONLINE";
    $this->arTxtError[23] = "Tancat";
    $this->arTxtError[24] = "Tancat NIT (DL,DM,DX,DJ,DG)";
    $this->arTxtError[25] = "Tancat DL,DM";
    $this->arTxtError[26] = "Supera MAX x Torn";
    $this->arTxtError[27] = "Superat MAX x Hora";
    $this->arTxtError[28] = "Reserva no trobada";
    $this->arTxtError[29] = "Cap taula disponible";
    $this->arTxtError[30] = "No es pot assignar reserva a aquesta taula";
  }

  public function taules($force_crea_taules=FALSE) {

    //COMPROVA RESTAURANT OBERT (DL, DM + llistablanca + llistanegra)
    if (!$this->restaurantObert())
      return $this->addError(23);
    
    /////////////////////////////////////////////////////
    //RECULL LES TAULES x DIA/TORN/PERSONES/COTXETS
    $this->qryTaules(); /*     * ****************************************** */
    
    /////////////////////////////////////////////////
    //CONTROLA SI ES SUPERA EL VALOR MAXIM PER TORN agafa els valors del control taules, ignora valor online (taules _form)
    if (!$this->controlMaxTorn())
      return $this->addError(26);
    //CONTROLA MENJADORS BLOQUEJATS
    $this->treuBloquejats();
    /////////////////////////////////////////
    if (($force_crea_taules || $this->recupera_creaTaules()) === true && !count($this->arResultatTaula)){
     
      $this->creaTaula();
    }
    
    return $this->arResultatTaula;
  }

  /*   * *********************************************************************************** */
  /*   * *********************************************************************************** */
  /*   * *********************************************************************************** */
  private function qryTaules() {
    $this->reset();
    $mydata = $this->data;
    $base= $this->data_BASE; 
    $torn = $this->torn;
    $persones = $this->persones;
    $cotxets = (int) $this->cotxets ? $this->cotxets : 0;

    $NOPLENES = $this->taulesGrans ? 'TRUE ' : 'FALSE '; // inclou taules + grans. Per ex: demanen 6 i tenim una taula de 8(plena=false)
    $NOPLENESCOTXETS = $this->cotxetsGrans ? 'TRUE ' : 'FALSE '; // inclou taules amb + cotxets dels demanats. Per ex: demanen 6/0 i tenim una taula de 6/1(plena=false)
    $sess = session_id();

    $query = "		
	SELECT * 
	FROM " . ESTAT_TAULES . " 
	WHERE 
	/* DATA, TORN I SENSE RESERVA */ ((estat_taula_data='$mydata' AND estat_taula_torn=$torn  AND    estat_taula_taula_id NOT IN(SELECT estat_taula_taula_id FROM estat_taules WHERE estat_taula_data='$mydata' AND estat_taula_torn=$torn  AND reserva_id<>0)   ) 
							OR
	/* BASE SOLA */ 	((estat_taula_data = '$base' AND estat_taula_torn=$torn )
	/* SENSE LA DATA ACTUAL */ AND estat_taula_taula_id  NOT IN( 	
					SELECT estat_taula_taula_id FROM " . ESTAT_TAULES . " 
					WHERE estat_taula_data='$mydata' AND estat_taula_torn=$torn )
					)
					)


	/* SENSE RESERVA*/		AND reserva_id=0 
	/* PERSONES  / COTXETS*/AND (estat_taula_persones=$persones OR ($NOPLENES AND estat_taula_persones>$persones AND estat_taula_plena=0))	
							AND (estat_taula_cotxets=$cotxets OR ($NOPLENESCOTXETS AND estat_taula_cotxets>$cotxets AND estat_taula_plena=0))
	/* X y */				AND (estat_taula_x>0 AND estat_taula_y>0) AND (estat_taula_x<2000 AND estat_taula_y<2000)
	/* GRUP*/ 				AND (estat_taula_grup=0 OR estat_taula_taula_id=estat_taula_grup)
	/* BLOQ MULTI-USR */	AND (estat_taula_blok IS NULL 
								OR estat_taula_blok < NOW()
								OR estat_taula_blok_sess='$sess')
								
								

	ORDER BY   estat_taula_persones, estat_taula_cotxets,estat_taula_data DESC";
//echo $query." ///// <br/>";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    /**/

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    //  T A U L A      P R O P I A
    //TAULA PROPIA //verifica data/torn/persones/cotxets - Si no ha canviat res, té la taula que tenia
    //
		if ($this->reserva_id && $this->data == $this->reserva->data && $this->torn == $this->reserva->torn && ($this->reserva->persones == $persones || ($this->reserva->taula->persones > $persones && $this->reserva->taula->plena == false && $this->taulesGrans)) && ($this->reserva->cotxets == $cotxets ||
        ($this->reserva->taula->cotxets > $cotxets && $this->reserva->taula->plena == false && $this->cotxetsGrans))) {
      $r = $this->reserva; //=$this->loadReserva($this->reserva_id);
      if ($r->taula->puntuacioTaula($persones, $cotxets, 5000))
        $this->arResultatTaula[] = $r->taula;
    }
    elseif (!$Result1 || !mysqli_num_rows($Result1)) { // SI NO, MIREM SI HI HA ALGUNA TAULA
      $this->addError(29);
      return array();
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////////////////////////////////////////
    while ($row = mysqli_fetch_array($Result1)) {//PRIMERA PASSADA
      //CREACIO TAULA
      $hora = 0;
      $taula = new EstatTaula($row['estat_taula_taula_id'], $row['estat_taula_nom'], $mydata, $hora, $row['estat_taula_persones'], $row['estat_taula_cotxets'], $row['estat_taula_plena'], $row['estat_taula_x'], $row['estat_taula_y']);
       //include(ROOT . "coord_menjadors.php");
      

       //require_once("gestor_reserves.php");
       
       /*     * */
      $gr=$this->gestor_reserves;
      $bloquejats = $this->menjadorsBloquejats($menjadors);

      //echo $gr->taulaBloquejada($taula->x, $taula->y, $bloquejats);die();
      if (!is_null($bloquejats) && $gr->taulaBloquejada($taula->x, $taula->y, $bloquejats)) continue;
   
        
      // Calcula punts per ordenar
      $punts = $taula->puntuacioTaula($persones, $cotxets);
      // LA POSO A L'ARRAY
      $this->arResultatTaula[] = $taula;
    }//PRIMERA PASSADA
    //ORDENA PER PUNTS
    if (!$this->arResultatTaula || !sizeof($this->arResultatTaula)) {
      $this->addError(29);
      return array();
    }
    else{
    }
    foreach ($this->arResultatTaula as $k => $v) { //SEGONA PASSADA (ORDRE)
      // genera array ids ordenada
      $this->arResultat[] = $v->id;
    }//SEGONA PASSADA (ORDRE)
    return $this->arResultatTaula;
  }
  
  /*   * *********************************************************************************** */
  /*   * *********************************************************************************** */
  /*   * *********************************************************************************** */
  /*   * *********************************************************************************** */
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// CONTROL DADES
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  public function refresh() {
    unset($arResultatTaula);
    $arResultatTaula = array();
    taules();
  }

  public function reset() {
    unset($this->arResultatTaula);
    $this->arResultatTaula = array();
    unset($this->arResultat);
    $this->arResultat = array();
    unset($this->arErrors);
    $arErrors = array();
    unset($this->arHores);
    $arHores = array();
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// CONTROL DEL DIA
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  /*   * ******************************************************************************************************* */




  /*   * ********************************************************************************************************************* */
  function ordenaPunts($a, $b) {
    return $a->punts < $b->punts;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// CONTROL DEL DIA
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  private function  restaurantObert() {
    $ds = date("w", strtotime($this->data));
    $dia = date("Y-m-d", strtotime($this->data));
    // si T1 o T2 mira llista negra
  //  if ($this->torn < 3 && $this->diaDinsLlista($this->llista_dies_negra)) return $this->addError(21); //TODO controla LLISTA NEGRA
    if ($this->torn < 3 && $this->diaDinsLlista_DB('small','black')) {return $this->addError(21);} //TODO controla LLISTA NEGRA
      

// si T3 i dia NO DV, DS -> TANCAT
    if ($ds<5 && $this->torn==3) return $this->addError(24); // TORN NIT DX,DJ,DG
    // 
    if ($this->torn == 3 && !$this->nitsObert[$ds] && !$this->excepcionsNits($dia))
      return $this->addError(24); // TORN NIT DX,DJ,DG

//si T3 i DV, DS, mirem Llista negra nit
  //  if ($ds > 4 && $this->torn == 3 && $this->diaDinsLlista($this->llista_nits_negra)) return $this->addError(20);
    if ($ds > 4 && $this->torn == 3 && $this->diaDinsLlista_DB('night','black')) return $this->addError(20);
    

    // si Dl, DM, mira llista BLANCA
    if ($ds > 0 && $ds < 3 && !$this->diaDinsLlista_DB('small','white'))
    if ($ds > 0 && $ds < 3 && !$this->diaDinsLlista_DB('small','white'))
      return $this->addError(25); //DL, DM en llista blanca
    return true;
  }

  /*   * ********************************************************************************************************************* */

  private function excepcionsNits($dia) {
    $data = explode('-', $dia);
    $ds = date("w", strtotime($dia));
    //if ($ds == 5 && $data[1] == 12 && $data[2] > 19 && $data[2] < 21)
    //  return true;

    return false;
  }

  /*   * ********************************************************************************************************************* */
 public function diaDinsLlista_DB($group, $tipus) {
   
   
    $data = $this->data;
    //$dia = substr($data, 8, 2);
    //$mes = substr($data, 5, 2);
   
   $query = "SELECT  * FROM dies_especials_$group WHERE dies_especials_tipus = '$tipus' AND dies_especials_data = '$data'";
   
   
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if ($this->total_rows = mysqli_num_rows($this->qry_result)) {
     // echo "$query SIIII  $group  $tipus";
      return true;
    }
//echo "$query NOOOO  $group  $tipus";
    return false;
 }
 
 
 
  public function diaDinsLlista($fitxer) {
    
    return false;
    if (!$fitxer || !file_exists($fitxer))
      return false;

    $data = $this->data;
    $dia = substr($data, 8, 2);
    $mes = substr($data, 5, 2);

    $dies = $this->llegir_dies($fitxer);
    $i = 0;
    while (isset($dies[$mes - 1][$i])) {
      if ($dia == $dies[$mes - 1][$i])
        return true;
      $i++;
    }
    return false;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// MENJADORS BLOQUEJATS
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  private function treuBloquejats($del = true) {
    if (!$this->arResultatTaula)
      return;
    $bloquejats = $this->menjadorsBloquejats($this->menjadorsBloquejats);
    $taulesBloquejades = array();

    foreach ($this->arResultatTaula as $k => $taula) {
      if ($taula->bloquejada($bloquejats)) {
        $taulesBloquejades[] = $taula;

        $pos = array_search($taula, $this->arResultatTaula);
        if ($del)
          array_splice($this->arResultatTaula, $pos, 1);
        if ($del)
          array_splice($this->arResultat, $pos, 1);
      }
    }

    return $taulesBloquejades;
  }

  /*   * ********************************************************************************************************************* */

  public function menjadorsBloquejats(&$arMenjadors = null) {
    $mydata = $this->data;
    $torn = $this->torn;
  //  $table = $this->tableMenjadors;
    $table = "estat_menjador"; //ATENCIO, HEM ANULAT estat_menjador_form
    $accesible_condition = $accesible_not_condition = '';
    if ($this->accesible) {
      $accesible_condition = " AND estat_menjador_accesible=1";
      $accesible_not_condition = " OR estat_menjador_accesible=0";
    }

    $query = "SELECT DISTINCT estat_menjador_menjador_id, estat_menjador_data FROM $table 
		WHERE (estat_menjador_data = '$mydata' AND estat_menjador_torn = $torn AND estat_menjador_bloquejat = 1
		OR estat_menjador_data = '" . $this->data_BASE . "' AND (estat_menjador_bloquejat = 1 $accesible_not_condition))
		
		AND estat_menjador_menjador_id NOT IN (
		 SELECT estat_menjador_menjador_id FROM $table 
		 WHERE 
		(estat_menjador_data = '$mydata' AND estat_menjador_torn = $torn AND (estat_menjador_bloquejat = 0  $accesible_condition)))			
		
		ORDER BY estat_menjador_data DESC;";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $nfiles = mysqli_num_rows($Result1);
//echo $query;
    $bloquejats = null;
    while ($row = mysqli_fetch_array($Result1)) {
      if (isset($arMenjadors[$row['estat_menjador_menjador_id']]))
        $arMenjadors[$row['estat_menjador_menjador_id']]->bloquejat = true;
      $bloquejats[$row['estat_menjador_menjador_id']] = $this->menjadors[$row['estat_menjador_menjador_id']];
      $bloquejats[$row['estat_menjador_menjador_id']]->bloquejat = true;
    }
    return $bloquejats;
  }

  /*   * ****************************************************************************************************************************** */
  /*   * *********    MAX COMENSALS      ****************************************************************************** */
  /*   * ****************************************************************************************************************************** */
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// MAXIMS TORN 
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  private function controlMaxTorn() {
    $this->totalTorn = $this->sum_comensals_torn();
    $this->maxTorn = $this->max_torn();
    if (($this->totalTorn + $this->persones) > $this->maxTorn)
      return false;
    return true;
  }

  /*   * ********************************************************************************************************************* */

  public function sum_comensals_torn() {
    $data = $this->data;
    $torn = $this->torn;


    $query = "SELECT sum( adults + nens4_9 + nens10_14 ) AS total
				FROM `" . ESTAT_TAULES . "`
				INNER JOIN " . T_RESERVES . " ON id_reserva = `reserva_id`
				WHERE `estat_taula_data` = '$data'
				AND `estat_taula_torn` =$torn";
    $Result1 = mysqli_query($this->connexioDB, $query); //or die(mysql_error());
    if (!mysqli_num_rows($Result1))
      return 0;

    $row = mysqli_fetch_array($Result1);
    return $row['total'];
  }

  /*   * ****************************************************************************** */

  public function max_torn() {

    $data = $this->data;
    $torn = $this->torn;


    // TABLE PELS MAXIMS SEMPRE ES ESTAT HORES
    $table = "estat_hores";

    $torn = 100 + $torn;
    $base = $this->data_BASE;
    $query = "SELECT estat_hores_max FROM $table 
		WHERE 
		(estat_hores_data='$data' OR estat_hores_data='$base')
		AND estat_hores_torn=$torn 
		AND estat_hores_hora='00:00'
		ORDER BY estat_hores_data DESC";
    $Result1 = mysqli_query($this->connexioDB, $query); //or die(mysql_error());
    $row = mysqli_fetch_array($Result1);
    if ($row[0] < 2)
      $row[0] = 20000;
    return $row[0];
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// MAXIMS HORA 
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  public function sum_comensals_hora($hora) {
    $data = $this->data;

    $query = "SELECT sum(adults) AS a,sum(nens4_9) AS n4,sum(nens10_14) AS n10 FROM " . T_RESERVES . " 
			INNER JOIN " . ESTAT_TAULES . " ON  " . T_RESERVES . ".id_reserva=" . ESTAT_TAULES . ".reserva_id
			WHERE 
			hora='$hora'
			AND data='$data'";

    $Result1 = mysqli_query($this->connexioDB, $query); //or die(mysql_error());
    if (!mysqli_num_rows($Result1))
      return 0;

    $row = mysqli_fetch_array($Result1);
    return $row['a'] + $row['n4'] + $row['n10'];
  }

  /*   * ****************************************************************************** */

  private function recuperaMaximHora($hora) {
    $data = $this->data;
    $torn = $this->torn;

    // TABLE PELS MAXIMS SEMPRE ES ESTAT HORES
    $table = "estat_hores";


    $torn = 100 + $torn;
    $base = $this->data_BASE;
    $query = "SELECT estat_hores_max FROM $table 
		WHERE 
		(estat_hores_data='$data' OR estat_hores_data='$base')
		AND estat_hores_hora='$hora'
		ORDER BY estat_hores_data DESC";

    $Result1 = mysqli_query($this->connexioDB, $query); //or die(mysql_error());
    $row = mysqli_fetch_array($Result1);
    if ($row[0] < 2)
      $row[0] = 20000;
    return $row[0];
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// LOAD RESERVA / LOAD TAULA
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  public function loadTaula($idt) {
    if (!$this->taula = new EstatTaula($idt, $this->torn, $this->data)) {
      $this->reset();
      $this->persones = 0;
      $this->cotxets = 0;
      return false;
    }

    $this->taula_id = $idt;
    $this->persones = $this->taula->persones;
    $this->cotxets = $this->taula->cotxets;

    return $this->taula_id;
  }

  public function loadReserva($idr) {
    $this->reserva_id = $idr;
    $this->reserva = new Reserva($this->reserva_id);
    $this->hora = $this->reserva->hora;
    $this->persones = $this->reserva->persones;
    $this->cotxets = $this->reserva->cotxets;
    if (!$this->reserva->id)
      return false;
    return $this->reserva;
  }

  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// TIRA HORES
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  public function recupera_hores($mostraDisableds = false, $raw = false) {
    $this->reset();
    $contaPersones = $persones = $this->persones;
    $taules = $this->taules();
    //echo "<br><br>TORN ".  $this->torn. "  <br>";    foreach ($this->arResultatTaula as $k => $v) echo $v->id. ", ";
    $cotxets = $this->cotxets;

    ////////////////////////////////////////////////////////////////////////////
    // Busca les hores disponibles per un dia/torn. HI HA 3 CASOS	
    ////////////////////////////////////////////////////////////////////////////
    // EDITANT RESERVA EXISTENT - Si estem al data/torn/persones/cotxets de la reserva no cal mirar més, li donem les hores
    ////////////////////////////////////////////////////////////////////////////
    //	1. Hores disponibles quan editem una reserva (EDIT RESERVA)
    //		Agafem els valors de la reserva (dia/hora/torn/pers/cotxets) i mirem les disponibles
    //		Cal mirar els màxims x hora SENSE sumar persones, pq ja estan comptats
    //		Cal mirar hores bloq. (base+torn a la taula que toqui)
    ////////////////////////////////////////////////////////////////////////////
    if ($this->reserva_id && $this->data == $this->reserva->data && $this->torn != $this->reserva->torn ) {
      // Primer verifiquem sie la taula està disponible en l'altre torn.
      // Pot passar que editem una taula en un torn però l'altre està reservat, per tant, no oferirem les taules de l'altre torn
      $this->taula_id = $this->reserva->taula->id;
      $trobat = $this->taulaIdDisponible($this->taula_id);
      if (!$trobat)
        return $this->addError(30);      
    }
    ////////////////////////////////////////////////////////////////////////////
    // Ara sí, donarem les hores del seu torn	
    ////////////////////////////////////////////////////////////////////////////
    if ($this->reserva_id && $this->data == $this->reserva->data && $this->torn == $this->reserva->torn && ($this->reserva->persones == $persones || ($this->reserva->taula->persones > $persones && $this->reserva->taula->plena == false && $this->taulesGrans)) && ($this->reserva->cotxets == $cotxets || ($this->reserva->taula->cotxets > $cotxets && $this->reserva->taula->plena == false && $this->cotxetsGrans))) {
      $this->hora = $this->reserva->hora;
      $contaPersones = 0;
      
    }  
    ////////////////////////////////////////////////////////////////////////////
    // SI NO MIREM SI TROBEM ALGUNA TAULA EN AQUEST TORN
    ////////////////////////////////////////////////////////////////////////////
    //	2. Simplement saber HORES per DIA/TORN, sense més complicacions (és el cas ONLINE): 
    //		Mirar Si hi ha taules disp. 
    //		Cal mirar els màxims x hora
    //		Cal mirar hores bloq. (base+torn a la taula que toqui)
    ////////////////////////////////////////////////////////////////////////////
    elseif (!$taules || !sizeof($taules))
       return $this->addError(29); //NO TROBA TAULA return "Ple o tancat";
      
////////////////////////////////////////////////////////////////////////////
    // SI ENS DEMANEN UNA TAULA EN CONCRET, MIREM SI ESTÀ ENTRE LES TAULES DISPONIBLES		
    ////////////////////////////////////////////////////////////////////////////
    //	3. Saber hores per UNA TAULA en concret: 
    //		Mirar Si la taula està DINS de l'array de taules disp. 
    //		Cal mirar els màxims x hora
    //		Cal mirar hores bloq. (base+torn a la taula que toqui)
    ////////////////////////////////////////////////////////////////////////////
    elseif ($this->taula_id) {
      $trobat = $this->taulaIdDisponible($this->taula_id);
      if (!$trobat)
        return $this->addError(30);
    }
    $data = $this->data;
    $torn = $this->torn;

    // TABLE PELS MAXIMS SEMPRE ES ESTAT HORES
    $table = $this->tableHores;

    ////////////////////////////////////////////////////////////////////////////
    // MIREM SI HI HA UNA RESERVA. SI ÉS AIXÍ, L'HORA DE LA RESERVA ES BONA
    ////////////////////////////////////////////////////////////////////////////
    if ($this->hora) {
      $h = $this->hora;
      $OR_HORA_RESERVA = " OR estat_hores_hora='$h'";
    }
    else
      $OR_HORA_RESERVA = "";
    ///////////////////////////////////////////////////////////////////////////////////////////////	
    // 
    // QUERY HORES
    // HORES ACTIVES A estat_hores_form (base) O overriden a estat_hores (data)

    $query = "
SELECT *
FROM $table
WHERE 
estat_hores_data = '{$this->data_BASE}'
AND estat_hores_torn =  '$torn'
AND (
estat_hores_actiu =1 $OR_HORA_RESERVA
)
AND estat_hores_hora NOT 
IN (

SELECT estat_hores_hora
FROM estat_hores
WHERE estat_hores_data =  '$data'
AND estat_hores_torn =  '$torn'
)

UNION ALL 

SELECT *
FROM estat_hores
WHERE estat_hores_data = '$data'
AND (
estat_hores_actiu =1 $OR_HORA_RESERVA
)
AND estat_hores_torn ='$torn'
ORDER BY  `estat_hores_hora` ASC ";

    if ($table != $this->defaultTableHores) { // FUNCIONALITAT ANULADA
      $query = "
SELECT *
FROM $table
WHERE 
estat_hores_data = '{$this->data_BASE}'
AND estat_hores_torn =  '$torn'
AND (
estat_hores_actiu =1 $OR_HORA_RESERVA  ) 
ORDER BY  `estat_hores_hora` ASC ";
    }
    //echo "************************* $torn ***************".$query;
    $Result1 = mysqli_query($this->connexioDB, $query); //or die(mysql_error());
    //
		///////////////////////////////////////////////////////////////////////////////////////////////	

    $req = 'class="required primera-hora rh" title="Selecciona hora"';
    $nom = $this->reserva_id ? "hora" : "uhora";
    ///////////////////////////////////////////////////
    // BUCLE COMPROVACIONS HORA A HORA
    $hora = null;
    $mensa = '';
    $info = '';
    $radio = '';
    $arrraw = array();
    
    
    
    while ($row = mysqli_fetch_array($Result1)) {
      if ($hora == $row['estat_hores_hora']) {
        continue; // REGISTRES REPETITS ///////////////////////////////////
      }
      $hora = $row['estat_hores_hora'];

      if ($row['estat_hores_hora'] == $this->hora)
        $checked = 'checked="checked"'; // CHECKED
      else {
        if (!$row['estat_hores_actiu'])          continue;
        $checked = null;
      }
 
      /////////////////////////////////////////////////////
      // CONTROLA MAX PER HORA
      //
      // El màx x hora s'agafa de estat_hores. Si treballem amb una altra taula, cal recuperar el valor 
      if ($table != $this->defaultTableHores)
        $row['estat_hores_max'] = $this->recuperaMaximHora($row['estat_hores_hora']);

      $comensals = $this->sum_comensals_hora($row['estat_hores_hora']);
      $disabled = ($row['estat_hores_max'] && $comensals + $contaPersones > $row['estat_hores_max']) ? 'disabled="disabled"' : '';
      // HORES DESACTIVADES
      if (!empty($disabled) && !$mostraDisableds)        continue;
      // NENS A ULTIMA HORA
      /**/
      
      /** 
       * ESQUIVA LES HORES QUE TENEN RESTRICCIONS DE NENS
     
      if ($torn < 3 && is_array($this->rang_hores_nens) && count($this->rang_hores_nens) && !in_array($row['estat_hores_hora'], $this->rang_hores_nens))
        continue;
   */
     
      if ($row['estat_hores_hora']>='13:00'){ // Les restriccion no afecten els esmorzars
          
        if ($torn < 3 && is_array($this->rang_hores_nens) && count($this->rang_hores_nens) && !in_array($row['estat_hores_hora'], $this->rang_hores_nens))
             continue;
      
          
      /** 
       * ESQUIVA LES HORES QUE TENEN RESTRICCIONS HORES TAULES
       */
        if ($torn < 3 && is_array($this->rang_hores_taules) && count($this->rang_hores_taules) && !in_array($row['estat_hores_hora'], $this->rang_hores_taules))
             continue;
      }
      //var_dump($this->rang_hores_nens);die();
       
      /**
       * ESQUIVA ESMORZARS FORA DE DS
       */
       //if (($row['estat_hores_hora']<"12:00") && date("N", strtotime($data))!=6 ) continue;
       if (($row['estat_hores_hora']<"13:00") && !$this->es_finde_o_festiu($data) ) continue;
        // echo date("N", strtotime($data));
      
      $this->arHores[] = $row['estat_hores_hora']; // GUARDA LES HORES BONES EN UN ARRAY
      ///////////////////////////////////////////////////
      // GENERA HTML
      $id = $nom . $row['estat_hores_id'];
      $preradio = $mensa . '<input type="radio" id="' . $id . '" name="hora" value="' . $row['estat_hores_hora'] . '" ' . $checked . ' ' . $req . ' maxc="' . $row['estat_hores_max'] . '" ' . $disabled . ' comensals="' . $comensals . '"  table="' . $this->tableHores . '"/>
			<label for="' . $id . '"  title="' . $row['estat_hores_hora'] . '= Comensals reservats: ' . $comensals . ($disabled ? ' + ' . $persones . ' > superat max/hora (' . $row['estat_hores_max'] . ')' : '') . '">' . $row['estat_hores_hora'] . $info . '</label>';
      $req = "";
      $radio.=$preradio;
      $arrraw[]=$row['estat_hores_hora'];
      
    }
    

    //
    //////////////////////////////////////////////////////
    //var_dump( $arrraw);die();
    if ($raw) return $arrraw;
    return $radio;
  }

  /*   * *********    recupera_hores_grups     ****************************************************************************** */
  /*   * ** retorna un radiobutton amb les hores d'un torn, mirant les hores actives ** */
  /* UTILITZAT PER TIRA D'HORES AL FORM RESERVES GRUPS
    /******************************************************************************************************************************** */
  /**/

  public function recupera_hores_grups() {
    if (!$ro = $this->restaurantObert())
      return $this->addError(23);

    $mydata = $this->data;
    $torn = $this->torn;
    $table = $this->tableHores;

    $query = "SELECT * FROM $table
		WHERE 
		estat_hores_actiu=1
		AND
		(estat_hores_data = '" . $this->data_BASE . "' AND estat_hores_torn = '$torn')
		
/*************** NOMES DEPEN DE LA BASE	
		OR (estat_hores_data='$mydata' AND estat_hores_torn = '$torn' )	AND estat_hores_hora NOT IN
				(SELECT estat_hores_hora  FROM estat_hores	WHERE (estat_hores_data='$mydata' AND estat_hores_torn = '$torn' AND estat_hores_actiu=0))
****************************************/		
		
		ORDER BY estat_hores_hora, estat_hores_id DESC, estat_hores_hora";

    $Result1 = mysqli_query($this->connexioDB, $query); //or die(mysql_error());
    $hora = null;
    $hora = null;
    $valor = null;
    $radio = null;
    $comensals = null;
    $disabled = null;
    while ($row = mysqli_fetch_array($Result1)) {
      if ($hora == $row['estat_hores_hora'])
        continue;
      $hora = $row['estat_hores_hora'];

      if ($row['estat_hores_hora'] == "00:00") {
        $max_torn = $row['estat_hores_max'];
        continue;
      }

      if ($row['estat_hores_hora'] == $valor)
        $checked = 'checked="checked"';
      else {
        if (!$row['estat_hores_actiu'])
          continue;
        $checked = "";
      }

      $preradio = '<input type="radio" id="' . 'h' . $row['estat_hores_id'] . '" name="selectorHora" value="' . $row['estat_hores_hora'] . '" ' . $checked . ' maxc="' . $row['estat_hores_max'] . '" comensals="' . $comensals . '" torn="' . $torn . '"  ' . $disabled . '/>
			<label for="' . 'h' . $row['estat_hores_id'] . '">' . $row['estat_hores_hora'] . '</label>';
      $radio.=$preradio;
    }

    return $radio;
  }

  /*   * ********************************************************************************************************************* */

  public function taulaIdDisponible($taula_id) {
    foreach ($this->arResultatTaula as $k => $v)
      if ($v->id == $taula_id)
        return $taula_id;
    return false;
  }

  /*   * ********************************************************************************************************************* */

  public function taulesDisponibles() {
    if ($this->arResultatTaula && count($this->arResultatTaula))
      return $this->arResultatTaula;

    return false;
  }

  /*   * ********************************************************************************************************************* */

  public function horaDisponible($hora) {
    if (!isset($this->arHores) || !count($this->arHores))
      $this->recupera_hores();
    if (!isset($this->arHores))
      return false;
    return (in_array($hora, $this->arHores) === true);
  }

  /*   * ********************************************************************************************************************* */

  private function creaTaula() {
    $novaTaula = new EstatTaula(null, $this->torn, $this->data, $this->hora, $this->persones, $this->cotxets, $plena = 0, null, null, 0);

    array_unshift($this->arResultatTaula, $novaTaula);
    array_unshift($this->arResultat, $novaTaula->id);

    return $novaTaula;
  }

  /*   * ********************************************************************************************************************* */

  public function recupera_creaTaules() {
    $mydata = $this->data;
    $torn = $this->torn;

    /** ATENCIO: Excepció creataules actiu de DL a DV no festiu */
    
    

  //  if (!$this->es_finde_o_festiu($mydata)) return true;
    $query = "SELECT estat_crea_taules_actiu FROM estat_crea_taules
    WHERE 
    (estat_crea_taules_data='$mydata' AND estat_crea_taules_torn = '$torn' ) 
    ORDER BY estat_crea_taules_timestamp DESC";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if (!mysqli_num_rows($Result1))
      return CREA_TAULES;
    else
      return (mysqli_result($Result1, 0) == 1);
  }
  
  
  
    /*   * ********************************************************************************************************************* */
 
  public function es_finde_o_festiu($data){
    if (!$data) return true; // SI NO EM DONEN LA DATA LI PASSO LA VARIABLE CREA_TAULA
    $date = DateTime::createFromFormat("Y-m-d", $data);
    
    // SI ES FINDE
    if ($date->format("N") > 5) return true;
    
    // SI ES FESTIU
    $query = "SELECT  * FROM dies_especials_small WHERE dies_especials_tipus = 'white' AND  dies_especials_data = '".$data."'";
    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if ($this->total_rows = mysqli_num_rows($this->qry_result)) return true;
    
    return false;
  }


  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */

// DIES BLOQUEJATS
  /*   * ********************************************************************************************************************* */
  /*   * ********************************************************************************************************************* */
  private function llegir_dies($fitxer) {
    for ($i = 0; $i < 12; $i++)
      $dies[$i] = array();

    $gestor = @fopen($fitxer, "r");
    $k = 0;
    if ($gestor) {
      while (!feof($gestor)) {

        $bufer = fgets($gestor, 4096);
        $k++;

        $d = strtok($bufer, "-/");
        $m = strtok("-/");
        $y = strtok("\n\t\r");

        if (checkdate($m, $d, $y))
          array_push($dies[$m - 1], $d);
      }
      fclose($gestor);
      return $dies;
    }
    else {
      return $dies;
    }
  }
  


  /*   * ****************************************************************************** */
  /*   * ****************************************************************************** */

  protected function addError($errNo) {
    unset($arResultatTaula);
    $arResultatTaula = array();
    unset($arResultat);
    $arResultat = array();

    parent::addError($errNo);

    return false;
  }

  /*   * ****************************************************************************** */

  public function llistaErrors() {
    return parent::gllistaErrors($this->arTxtError);
  }

  /*   * ****************************************************************************** */

  public function dump() {
    $table = '';
    if (!$this->arResultatTaula) {
      if (count($this->arError))
        foreach ($this->arError as $k => $v)
          $table.= "ERROR!!!!!!!!!!!!! ---> TORN " . $this->torn . " >>> err $v " . $this->arTxtError[$v] . "<br/>";
    }

    $ds = date("w", strtotime($this->data));
    $estat = 'Menjadors: ';
    $this->menjadorsBloquejats($this->menjadorsBloquejats);
    $estat = print_r($this->menjadorsBloquejats);

    $estat.="<br/><br/><br/>
		CREA_TAULES: " . ($this->recupera_creaTaules() ? "S" : "N") . "<br/>
		data: " . $this->data . " ($ds)<br/>
		torn: " . $this->torn . "<br/>
		hora: " . $this->hora . "<br/>
		persones: " . $this->persones . "<br/>
		cotxets: " . $this->cotxets . "<br/>
		<br/>
		tableHores: " . $this->tableHores . "<br/>
		tableMenjador: " . $this->tableMenjadors . "<br/>
		<br/>
		màx_torn: " . $this->maxTorn . "<br/>
		total_torn: " . $this->totalTorn . "<br/>
		<br/>";
    if (isset($this->reserva))
      $estat.="
		reserva: " . $this->reserva->id . "<br/>
		reserva_data: " . $this->reserva->data . "<br/>
		reserva_hora: " . $this->reserva->hora . "<br/>
		reserva_adults: " . $this->reserva->adults . "<br/>
		reserva_jun: " . $this->reserva->juniors . "<br/>
		reserva_nens: " . $this->reserva->nens . "<br/>
		reserva_cotxets: " . $this->reserva->cotxets . "<br/>
		reserva_taula_num: " . $this->reserva->taula->nom . "<br/>
		<br/><br/><br/>
		
		";
    foreach ($this->nitsObert as $k => $v)
      $estat.="NIT $k: $v <br/>";

    foreach ($this->arResultatTaula as $k => $v) { //SEGONA PASSADA (ORDRE)
      $table.= '
			<tr>
				<td>' . $v->nom . ' / ' . $v->id . '</td>
				<td>' . $v->persones . ' / ' . $v->cotxets . " : " . ($v->plena ? "plena" : "noplena") . '</td>
				<td>' . $v->reserva_id . '</td>
				<td>' . (!empty($v->menjador) ? $v->menjador->name : '') . '</td>
				<td>' . $v->punts . '</td>
				<td>' . (!empty($v->menjador) ? $v->menjador->bloquejat : '') . '</td>
				<td>' . $this->maxTorn . '</td>
			</tr>';
    }
    $table = '
			<style>
				td{border:1px gray solid;padding:3px;}
			</style>
			<br/>
			' . $estat . '
			<br/>
			LLISTAT DE TAULES
			<br/>
			<table>
			<tr>
				<td>nom / id</td>
				<td>persones-plena</td>
				<td>reserva_id</td>
				<td>menjador</td>
				<td>punts</td>
				<td>blok</td>
				<td>maxT</td>
			</tr>' . $table .
        '</table><br/><br/><br/>';

    return $table;
  }

}

/* * ****************************************************************************** */
/* * ****************************************************************************** */
/* * ****************************************************************************** */
/* * ****************************************************************************** */
//if (!defined('LLISTA_DIES_NEGRA'))  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra_online.txt");
if (!defined('LLISTA_DIES_NEGRA'))  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
//if (!defined('LLISTA_NITS_NEGRA'))  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra_online.txt");
if (!defined('LLISTA_NITS_NEGRA'))  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_DIES_BLANCA'))  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");

if (!empty($_GET['d']) && !empty($_GET['t']) && !empty($_GET['p'])) { //PER FER-LI TEST
           $gr=new gestor_reserves();

  $g = new TaulesDisponibles($gr);
  $g->data = $_GET['d'];
  $g->torn = $_GET['t'];
  $g->persones = $_GET['p'];
  $g->cotxets = $_GET['c'];
  if (isset($_GET['a']))
    $g->accesible = $_GET['a'];

  //$g->tableHores='estat_hores_form';
  $g->tableHores = 'estat_hores';

  $g->tableMenjadors = 'estat_menjador';

  //IMPORTANT 
  $g->taulesGrans = false; //FALSE: no mostra taules + grans. TRUE: Les mostra si PLENA=false
  $g->cotxetsGrans = true; //FALSE: no mostra taules amb + cotxets dels demanats. TRUE: Si troba taula amb + cotxets dels demanats la dona per bona
  //RESERVA
  if (isset($_GET['r']))
    $g->loadReserva($_GET['r']);
  if (isset($_GET['m']))
    $g->loadTaula($_GET['m']);
  $g->torn = 1;
  echo "<br/>
			-------------------------------------------------------------------<br/>
			-------------------------------------------------------------------<br/>
			HORES1:" . $g->recupera_hores(true);
  echo $out = $g->dump();
  echo "<br/>";
  $g->torn = 2;
  echo "<br/>
			-------------------------------------------------------------------<br/>
			-------------------------------------------------------------------<br/>
			HORES2:" . $g->recupera_hores(true);
  echo $out = $g->dump();
  echo "<br/>";
  $g->torn = 3;
  echo "<br/>
			-------------------------------------------------------------------<br/>
			-------------------------------------------------------------------<br/>
			HORES3:" . $g->recupera_hores(true);
  echo $out = $g->dump();
  echo "<br/>";
  echo "<br/>";


  echo "<br/><br/><br/>....";
}
?>