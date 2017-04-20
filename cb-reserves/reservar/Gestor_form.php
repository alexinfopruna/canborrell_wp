<?php

if (!defined('ROOT'))
  header('Content-Type: text/html; charset=utf-8');

if (!defined('ROOT')) {
  $root = '../taules/';
  // $root = '../cb-reserves/taules/';
  define('ROOT', $root);
}

// caduca la limitació d'horari per nens
if (!defined('CB_CHILD_CACHE_MAX_TIME'))
  define('CB_CHILD_CACHE_MAX_TIME', 80000);

if (isset($_REQUEST['a']))
  $accio = $_REQUEST['a'];$_REQUEST['a'] = null;
require_once(ROOT . "Gestor.php");


if (!defined('LLISTA_DIES_NEGRA'))
  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "bloq.txt");
if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))
  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra_online.txt");
if (!defined('LLISTA_NITS_NEGRA'))
  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
if (!defined('LLISTA_DIES_BLANCA'))
  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
if (!defined('TPV_CONFIG_FILE'))
  define("TPV_CONFIG_FILE", "TPV256_test.php");

require_once(ROOT . "gestor_reserves.php");
require_once(ROOT . "Menjador.php");
require_once(ROOT . "EstatTaula.php");

require_once(ROOT . "TaulesDisponibles.php");
/*
ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);*/
require_once(ROOT. "RestrictionController.php");
/* * ******************************************************************************************************* */

class Gestor_form extends gestor_reserves {

  var $data_BASE = "2011-01-01";
  var $menjadorsBloquejatsOnline;

  /*   * ******************************************************************************************************* */

  public function __construct($usuari_minim = 1) {
    parent::__construct(DB_CONNECTION_FILE, $usuari_minim);
    // Sobre quina taule fem les consultes
    $this->taulesDisponibles->tableMenjadors = "estat_menjador_form";
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

// FUNCIONS	LOGIN UPDATE RESERVA
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  /*   * ******************************************************************************************************* */
  public function recuperaReserva($mob, $id_reserva) {
    if (strtolower(substr($id_reserva, 0, 2) == "id"))
      $id_reserva = substr($id_reserva, 2, 15);

    $query = "SELECT * FROM " . T_RESERVES . " 
		LEFT JOIN client ON " . T_RESERVES . ".client_id=client.client_id
		LEFT JOIN " . ESTAT_TAULES . " ON " . T_RESERVES . ".id_reserva=" . ESTAT_TAULES . ".reserva_id
		WHERE data>= NOW() + INTERVAL 24 HOUR
		AND " . T_RESERVES . ".id_reserva='" . $id_reserva . "' AND client_mobil='" . $mob . "'";

    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if ($this->total_rows = mysqli_num_rows($this->qry_result)) {
      $this->last_row = mysqli_fetch_assoc($this->qry_result);
      $usr = new Usuari($this->last_row['client_id'], $this->last_row['client_nom'], 1);
      $_SESSION['uSer'] = $usr;


      // $this->comprovaHoraEdicio($this->last_row);
      return $this->last_row;
    }

    $this->error = "Reserva no trobada";
    return false;
  }

  /*   * ******************************************************************************************************* */

  /**
   * 
   * @param unknown_type $mob
   * @param unknown_type $id_reserva
   * @return multitype:|boolean

    public function comprovaHoraEdicio($row) {
    if ($row['preu_reserva']  ){

    }
    else{

    }
    }
   */

  /**
   * 
   * @param unknown_type $mob
   * @param unknown_type $id_reserva
   * @return multitype:|boolean
   */
  public function recuperaReservaGrup($mob, $id_reserva) {
    if (strtolower(substr($id_reserva, 0, 2) == "id"))
      $id_reserva = substr($id_reserva, 2, 15);

    $query = "SELECT * FROM reserves 
		LEFT JOIN client ON reserves.client_id=client.client_id
		WHERE data>= NOW() + INTERVAL 24 HOUR
		AND reserves.id_reserva='" . $id_reserva . "' AND client_mobil='" . $mob . "'";

    $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    if ($this->total_rows = mysqli_num_rows($this->qry_result))
      return $this->last_row = mysqli_fetch_assoc($this->qry_result);

    $this->error = "Reserva no trobada";
    return false;
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

// FUNCIONS	HORES
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  // Llistat hores form GRUPS. 
  public function totesHores($data) {
    $mydata = $this->cambiaf_a_mysql($data);
    $ds = date("w", strtotime($mydata));
    $coberts = 0;
    $cotxets = 0;

    $this->taulesDisponibles->data = $mydata;
    $this->taulesDisponibles->persones = $coberts;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->tableHores = "estat_hores";

    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA;
    $this->taulesDisponibles->llista_nits_negra = LLISTA_NITS_NEGRA;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;
    //TORN1
    $taulaT1 = '';
    $this->taulesDisponibles->torn = 1;
    $dinar = $this->taulesDisponibles->recupera_hores_grups();
    if (!$dinar)
      $dinar = "";

    //TORN2
    $taulaT2 = '';
    $this->taulesDisponibles->torn = 2;
    $dinarT2 = $this->taulesDisponibles->recupera_hores_grups();
    if (!$dinarT2)
      $dinarT2 = "";

    //TORN3
    $taulaT3 = '';
    $sopar = '';
    $this->taulesDisponibles->torn = 3;
    if ($ds > 4)
      $sopar = $this->taulesDisponibles->recupera_hores_grups();
    if (!$sopar)
      $sopar = "";

    $json = array('dinar' => $dinar, 'dinarT2' => $dinarT2, 'sopar' => $sopar, 'taulaT1' => $taulaT1, 'taulaT2' => $taulaT2, 'taulaT3' => $taulaT3);
    return json_encode($json);
  }

  /*   * ******************************************************************************************************* */
	


  public function horesDisponibles($data, $coberts, $cotxets = 0, $accesible = 0, $idr = 0, $nens = null) {
//echo $cotxets;die();
    if ($cotxets == 'undefined') $cotxets=0;
    $mydata = $this->cambiaf_a_mysql($data);

    //$this->taulesDisponibles->tableHores="estat_hores_form";
    $this->taulesDisponibles->tableHores = "estat_hores";   //ANULAT GESTOR HORES FORM. Tot es gestiona igual, des d'estat hores
    if ($idr) {
      if (!$this->taulesDisponibles->loadReserva($idr)) {
        $json = array('dinar' => '', 'dinarT2' => '', 'sopar' => '', 'taulaT1' => 0, 'taulaT2' => 0, 'taulaT3' => 0, 'error' => 3);
        return json_encode($json);
      }
    }

    $this->taulesDisponibles->data = $mydata;
    $this->taulesDisponibles->persones = $coberts;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->accesible = $accesible;
    //$this->taulesDisponibles->tableHores="estat_hores_form";		
    $this->taulesDisponibles->tableHores = "estat_hores";  //ANULAT GESTOR HORES FORM. Toto es gestiona igual, des de estat hores

    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_nits_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;
    $cacheNens = $nens;
    $cacheAdults = $coberts - $nens;

    // $this->comprovaCacheNens($mydata, $cacheAdults, $cacheNens);
 
      $rc=new RestrictionController();
      $this->taulesDisponibles->rang_hores_nens = $rc->getHores($mydata, $cacheAdults, $cacheNens, $cotxets);    
      $rules = $rc->getActiveRules($mydata, $cacheAdults, $cacheNens, $cotxets);    
    //SISTEMA ESTÀTIC >> hores_nens.php
    //$this->taulesDisponibles->rang_hores_nens = $this->rang_hores_nens($mydata, $cacheAdults, $cacheNens, $cotxets);

    //TORN1
    $this->taulesDisponibles->torn = 1;
    $dinar = $this->taulesDisponibles->recupera_hores();
    $taules = $this->taulesDisponibles->taulesDisponibles();

    $taulaT1 = 0;
    if ($taules) $taulaT1 = $taules[0]->id;
    if (!$dinar)   $dinar = "";
    
    //TORN2
    $this->taulesDisponibles->torn = 2;
    $dinarT2 = $this->taulesDisponibles->recupera_hores();
    $taules = $this->taulesDisponibles->taulesDisponibles();
    //$this->printr($taules);
    
     $taulaT2 = 0;
    if ($taules) $taulaT2 = $taules[0]->id;   
    
    if (!$dinarT2)
      $dinarT2 = "";

    //TORN3
    $this->taulesDisponibles->torn = 3;
    $sopar = $this->taulesDisponibles->recupera_hores();
    $taules = $this->taulesDisponibles->taulesDisponibles();
    if ($taules[0])
      $taulaT3 = $taules[0]->id;
    else
      $taulaT3 = null;
    if (!$sopar)
      $sopar = "";

    $json = array('dinar' => $dinar, 'dinarT2' => $dinarT2, 'sopar' => $sopar, 'taulaT1' => $taulaT1, 'taulaT2' => $taulaT2, 'taulaT3' => $taulaT3);
    
    $json['rules']=array_column($rules,'restriccions_id');
    $json['params']="$mydata, $cacheAdults, $cacheNens, $cotxets";
    return json_encode($json);
    //////////////////////////////////					
  }

  private function rang_hores_nens($data, $adults, $nens=0, $cotxets=0) {
    
    if (!$adults || !defined("CONTROL_HORES_NENS") || !CONTROL_HORES_NENS)
      return;
    //controla si es cap de setamana
    $finde=FALSE;
    $ds = date('N', strtotime($data));
    if ($ds==6 ) $finde=TRUE;
    if ($ds==7 ) $finde=TRUE;

    if (!$finde) return FALSE;
    /*
      $adults = 10;
      $nens= 0;
     */if ($nens=="undefined") $nens=0;
    //echo " .. $nens ..";die();
   
    /*     * *************************** */
    require("hores_nens.php");
    /*     * **************************** */

    $limit = FALSE;
    if (isset($limits[$adults][$nens]))
      $limit = $limits[$adults][$nens];
    //CACHEEEEEEE
    $index = 'cacheNens' . $data . "-" . ($adults + $nens);

    $time = time();
     
    //   $time += CB_CHILD_CACHE_MAX_TIME + 1000;
    $cache = FALSE;
    if (isset($_SESSION[$index]) && count($_SESSION[$index]['hores']) && $_SESSION[$index]['timestamp'] > $time) {
      $cache = $_SESSION[$index]['hores'];
    }

    $limitNens = FALSE;
    if ($limit) $limitNens = $limit;
    if ($cache) $limitNens = $cache;
    if ($limit && $cache) $limitNens = array_intersect($limit, $cache);

    if (count($limitNens)) {
      $cachev = array();
      $cachev['timestamp'] = time() + CB_CHILD_CACHE_MAX_TIME;
      $cachev['hores'] = $limitNens;
      $_SESSION[$index] = $cachev;
    }
    
    /**********************************************************/
    // COTXETS
    /**********************************************************/
    $limitcotxets = FALSE;
    //echo "*** $ds  $cotxets ***";die();
    if (isset($limit_cotxets[$cotxets])) {
      $limitcotxets = $limit_cotxets[$cotxets][1];
      if ($limitcotxets && $limitNens) $limitNens = array_intersect($limitcotxets, $limitNens);
      else $limitNens = $limitcotxets;
      
    }
   // var_dump($cotxets) ;
   // var_dump($limitNens) ;die();
    
    /*
    echo "CACHE ";print_r($cache);
    echo "limit ";print_r($limit);
    echo "limitNens ";print_r($limitNens);*/
    return $limitNens;
  }

  
 
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

// FUNCIONS	CARTA
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

    $were.=' AND carta_publicat = TRUE ';

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
//ORDER BY (carta_subfamilia_id=2),carta_subfamilia_id";
//echo $query;
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    while ($row = mysqli_fetch_array($Result1)) {
      if (empty($row['carta_plats_nom_ca']))
        $row['carta_plats_nom_ca'] = $row['carta_plats_nom_en'] = $row['carta_plats_nom_es'];
      $plat = array('id' => $row['carta_plats_id'], 'nom' => $row['carta_plats_nom_' . $lng], 'preu' => $row['carta_plats_preu'], 'quantitat' => $row['comanda_plat_quantitat']);
      $arCarta[$row['carta_subfamilia_nom_' . $lng]][] = $plat;
    }

    /*     * ******************************************************************************************************* */

    $class = $es_menu ? "cmenu" : "ccarta";
    $obreLlista = '<ul id="carta-seccions" class="' . $class . '">' . PHP_EOL;
    $llista = "";
    foreach ($arCarta as $key => $val) {
      $k = $this->normalitzar($key);
      $llista.='<li><a href="#carta_' . $k . '">' . $key . '</a></li>' . PHP_EOL;
    }
    $tancaLlista = '</ul>' . PHP_EOL;
    $carta = $obreLlista . $llista . $tancaLlista;

    foreach ($arCarta as $key => $val) {
      $k = $this->normalitzar($key);
      $obreSeccio = '<div id="carta_' . $k . '" class="' . $class . '">' . PHP_EOL;
      $seccio = $this->seccioCarta($arCarta, $key, $class);
      $tancaSeccio = '</div>' . PHP_EOL . PHP_EOL;

      $carta.=$obreSeccio . PHP_EOL . $seccio . PHP_EOL . $tancaSeccio;
    }

    //print_r($arCarta);
    return $carta;
  }

  /*   * ******************************************************************************************************* */

  public function seccioCarta($ar, $k, $class) {
    $obreTaula = '<table id="c1" class="col_dere">' . PHP_EOL;
    $l = $c = 0;
    $tr = '';
    foreach ($ar[$k] as $key => $val) {
      $menuEspecial = $this->menuEspecial($val['id']) ? " menu-especial" : "";
      if (!calsoton && ($val['id'] == 2010 || $val['nom'] == "MENU CALÇOTADA" || $val['nom'] == "MENÚ CALÇOTADA"))
        continue;
      $l++;

      if ($val['quantitat'])
        $value = ' value="' . $val['quantitat'] . '" ';
      else
        $value = "0";

      /**  IVA  * */
      //$val['preu']*=IVA/100;
      $preu = round($val['preu'] + $val['preu'] * IVA / 100, 2);
      $preu = number_format($preu, 2, '.', '');

      $odd = ($l % 2) ? "odd" : "pair";
      $tr.='<tr producte_id="' . $val['id'] . '" class="item-carta ' . $odd . $menuEspecial . '">
				<td  class="mes"><div  class="d-mes ui-corner-all" ><a href"#">+</a></div></td>
				<td class="contador">
                                <div  class="mes"><div  class="m-mes ui-corner-all"> + </div></div>
                                <input id="carta_contador' . $val['id'] . '" nid="' . $val['id'] . '" type="text" name="carta_contador' . $c++ . '" class="contador ' . $class . '" ' . $value . ' preu="' . $preu . '" nom="' . $val['nom'] . '"/>
                                 <div  class="menys"><div  class="m-menys ui-corner-all"> - </div></div>   

</td>
				<td class="menys"><div  class="d-menys ui-corner-all" ><a href"#">-</a></div></td>
				<td class="borra" style="display:none"></td>
				<td><a class="resum-carta-nom" href="/cb-reserves/reservar/Gestor_form.php?a=TTmenu&b=' . $val['id'] . '" >' . $val['nom'] . '</a></td>
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

// FUNCIONS	CLIENT
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  public function recuperaClient($num, $mail = null) {
    //$num="999";

    if (empty($mail))
      $mail = "nuul@nuul" . time();
    $mail = strtolower($mail);

    $query = "
SELECT client.`client_id`,`client_nom`,`client_conflictes`,`client_email`,`client_mobil`,`client_telefon`,`client_dni`,`client_cp`,`client_localitat`,`client_adresa`,`client_cognoms`,reserves.id_reserva AS id_reserva_grup," . T_RESERVES . ".id_reserva AS id_reserva, reserves.data as data_grup, " . T_RESERVES . ".data AS data,
(reserves.id_reserva OR reservestaules.id_reserva) as reservat

FROM client 
		LEFT JOIN reserves ON client.client_id=reserves.client_id AND reserves.data>=NOW()AND (reserves.estat=1 OR reserves.estat=2 OR reserves.estat=3 OR reserves.estat=7 OR reserves.estat=100)
		LEFT JOIN " . T_RESERVES . " ON client.client_id=" . T_RESERVES . ".client_id AND " . T_RESERVES . ".data>=NOW()

	WHERE client_mobil='$num' 
	OR LOWER(client_email)='$mail'
	
	ORDER BY id_reserva_grup DESC , id_reserva DESC , client.client_id DESC";

    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (mysqli_num_rows($Result1) == 0)
      return 'false';

    $row['err'] = FALSE;
    $row = mysqli_fetch_array($Result1);
    if ($row['reservat']) {
      if ($row['id_reserva_grup'])
        $row['data'] = $row['data_grup'];
      $row['data'] = $this->cambiaf_a_normal($row['data']);
      $row['err'] = "20";
    }

    //GARJOLA
    if ($this->garjola($num, $mail)) {
      if ($row['id_reserva_grup'])
        $row['data'] = $row['data_grup'];
      $row['data'] = $this->cambiaf_a_normal($row['data']);
      //$row['err']="21"." $num $mail";
      $row['err'] = "21";
    }
    /* TRAMPA PER FER PROVES!!!!	 */
    if ($num == "999212121") {
      $row['reservat'] = $row['id_reserva_grup'] = $row['id_reserva'] = 0;
      $row['err'] = null;
    }
    return json_encode($row);
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
// SUBMIT I N S E R T
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  public function submit() {
    $this->xgreg_log("SUBMIT FORM RESERVES");
    $resposta['mail'] = null;
    if (isset($_POST['id_reserva']) && !empty($_POST['id_reserva'])) {
      if (strtolower(substr($_POST['id_reserva'], 0, 2)) == 'id')
        $_POST['id_reserva'] = substr($_POST['id_reserva'], 2, 20);
      if ($_POST['id_reserva'] > 3000) {
        //$this->xgreg_log("Submit update reserva grups");
        return $this->salvaUpdate(); // GUARDA UPDATE
      }
      else {
        $this->xgreg_log("RESERVA DESCONEGUDA", 1);
        $resposta['request'] = "update";
        return $this->jsonErr(1, $resposta); //RESERVA DESCONEGUDA
      }
    }
    $this->xgreg_log("Creació reserva online ++++++++++++++++++++++", 1);

    $resposta['request'] = "create";
    if (isset($_SESSION['last_submit']))
      $_REQUEST['last_submit'] = $_SESSION['last_submit'];
    else
      $_SESSION['last_submit'] = 0;
    if (time() - $_SESSION['last_submit'] < 5)
      return $this->jsonErr(10, $resposta); //PARTXE DOBLE SUBMIT

    if ($_POST['adults'] < 2)
      return $this->jsonErr(7, $resposta); //Adults < 2




      
// MIREM SI ESTÀ EDITANT UNA RESERVA EXISTENT
//MIRA SI ENS VOLEM FER UNA DUPLICADA
    if (!isset($_POST['client_mobil']))
      $_POST['client_mobil'] = 'xxx';
    if (!isset($_POST['observacions']))
      $_POST['observacions'] = '';

    if (!isset($_POST['client_mail']))
      $_POST['client_mail'] = null;
    $result = json_decode($this->recuperaClient($_POST['client_mobil'], $_POST['client_mail']));
    if (isset($result->{'err'}) && $result->{'err'}) {
      $this->xgreg_log("ERROR SUBMIT->CLIENT REPETIT" . $result->{'err'}, 1);
      return $this->jsonErr($result->{'err'}, $resposta);
    }

    $_POST['lang'] = $_SESSION["lang"];
    $_POST['observacions'] = $_POST['observacions']; //????
    $_POST['reserva_info'] = 1;
    //TODO COTXETS

    if (!isset($_POST['selectorComensals']) || $_POST['selectorComensals'] == 0) {
      $_POST['selectorComensals'] = $_POST['adults'];
    }

    $_POST['selectorCotxets'] = isset($_POST['selectorCotxets']) ? $_POST['selectorCotxets'] : 0;
    $_POST['selectorNens'] = isset($_POST['selectorNens']) ? $_POST['selectorNens'] : 0;
    $_POST['selectorJuniors'] = isset($_POST['selectorJuniors']) ? $_POST['selectorJuniors'] : 0;
    $_POST['RESERVA_PASTIS'] = isset($_POST['RESERVA_PASTIS']) ? $_POST['RESERVA_PASTIS'] : FALSE;

    $total_coberts = $_POST['selectorComensals'] + $_POST['selectorNens'] + $_POST['selectorJuniors'];

    $PERSONES_GRUP = $this->configVars("persones_grup");
    if ($total_coberts < 2 || $total_coberts > $PERSONES_GRUP)
      return $this->jsonErr(7, $resposta); // "err7 adults";




      
//ESBRINA EL TORN	
    $data = $this->cambiaf_a_mysql($_POST['selectorData']);

    if (empty($_POST['hora']))
      return $this->jsonErr(8, $resposta); // 
    $hora = $_POST['hora'];
    $torn = $this->torn($data, $hora);

    if ($data < date("Y-m-d"))
      $resposta['error'] = "err1 Data passada: " . $_POST['selectorData'] . " < " . date("d/m/Y");
    $date = strtotime(date("Y-m-d", strtotime("now")) . " +1 year");
    if ($data > $date)
      $resposta['error'] = "err2: data futura: " . $_POST['selectorData'];

    //COMPROVEM HORA LIMIT
    if (!$this->reserva_entra_avui($data, $hora))
      return $this->jsonErr(11, $resposta); // "err7 adults";




      
//COMPROVA hora - torn - taula ok?
    $coberts = $_POST['adults'] + $_POST['nens10_14'] + $_POST['nens4_9'];
    $cotxets = $_POST['selectorCotxets'];

    if (!isset($_POST['selectorAccesible']))
      $_POST['selectorAccesible'] = false;
    if (!isset($_POST['selectorCadiraRodes']))
      $_POST['selectorCadiraRodes'] = false;
    $accesible = ($_POST['selectorAccesible'] || $_POST['selectorCadiraRodes']);

    $this->taulesDisponibles->data = $data;
    $this->taulesDisponibles->torn = $torn;
    $this->taulesDisponibles->hora = $hora;
    $this->taulesDisponibles->persones = $coberts;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->accesible = $accesible;

    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_nits_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;

    //$this->taulesDisponibles->tableHores="estat_hores_form";
    $this->taulesDisponibles->tableHores = "estat_hores";


    $this->taulesDisponibles->recupera_hores();

    // VALIDA SI HEM TROBAT TAULA
    if (!$taules = $this->taulesDisponibles->taulesDisponibles())
      return $this->jsonErr(3, $resposta);
    $taula = $taules[0]->id;
    // VALIDA SI HEM TROBAT HORA
    if (!$this->taulesDisponibles->horaDisponible($hora))
      return $this->jsonErr(8, $resposta);
    //SI CREA_TAULA LA GUARDA
    $taulaVirtual = false;
    if ($taules[0]->taulaVirtual) {
      $taulaVirtual = true;
      $taules[0]->guardaTaula();
    }
    if ($taula < 1)
      return $this->jsonErr(3, $resposta);
    //dades client?
    if (empty($_POST['client_mobil']))
      return $this->jsonErr(4, $resposta); // "err4 mobil";
    if (empty($_POST['client_nom']))
      return $this->jsonErr(5, $resposta); // "err5 nom";
    if (empty($_POST['client_cognoms']))
      return $this->jsonErr(6, $resposta); // "err6: cognoms";




      
//comanda?		
    //FINS AQUI TOT HA ANAT BE, ANEM A GUARDAR LA RESERVA...
    ////////////// TODO
    //INSERT INTO CLIENT
    $idc = $this->insertUpdateClient($_POST['client_mobil']);
    $info = $this->encodeInfo($_POST['amplaCotxets'], 0, 1);
    /* 	 */
    $esborra = (isset($_POST['esborra_dades']) && $_POST['esborra_dades'] == 'on');
    $info = $this->flagBit($info, 7, $esborra);
    $selectorCadiraRodes = (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes'] == 'on');
    $info = $this->flagBit($info, 8, $selectorCadiraRodes);
    $selectorAccesible = (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible'] == 'on');
    $info = $this->flagBit($info, 9, $selectorAccesible);

    $_POST['observacions'] = preg_replace("/Portem cadira de rodes /", "", $_POST['observacions']);
    if ($selectorCadiraRodes) {
      $_POST['observacions'] = 'Portem cadira de rodes ' . $_POST['observacions'];
    }
    //INSERT INTO RESERVES TAULES
    if (!isset($_POST['resposta']))
      $_POST['resposta'] = '';
    if (!isset($_POST['RESERVA_PASTIS']))
      $_POST['INFO_PASTIS'] = NULL;

    $estat = $this->paga_i_senyal($coberts) ? 2 : 100;
    //$import_reserva=$this->configVars("import_paga_i_senyal");
    $import_reserva = 0;
    $insertSQL = sprintf("INSERT INTO " . T_RESERVES . " ( id_reserva, client_id, data, hora, adults, 
		  nens4_9, nens10_14, cotxets,lang,observacions, reserva_pastis, reserva_info_pastis,
                  resposta, estat, preu_reserva, usuari_creacio, 
                  reserva_navegador, reserva_info) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($_POST['id_reserva'], "text"), $this->SQLVal($idc, "text"), $this->SQLVal($_POST['selectorData'], "datePHP"), $this->SQLVal($_POST['hora'], "text"), $this->SQLVal($_POST['selectorComensals'], "zero"), $this->SQLVal($_POST['selectorNens'], "zero"), $this->SQLVal($_POST['selectorJuniors'], "zero"), $this->SQLVal($_POST['selectorCotxets'], "zero"), $this->SQLVal($_POST['lang'], "text"), $this->SQLVal($_POST['observacions'], "text"), $this->SQLVal($_POST['RESERVA_PASTIS'] == 'on', "zero"), $this->SQLVal($_POST['INFO_PASTIS'], "text"), $this->SQLVal($_POST['resposta'], "text"), $this->SQLVal($estat, "text"), $this->SQLVal($import_reserva, "text"), $this->SQLVal($idc, "text"), $this->SQLVal($_SERVER['HTTP_USER_AGENT'], "text"), $this->SQLVal($info, "zero"));

    $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //$idr = ((is_null($___mysqli_res = mysqli_insert_id($this->connexioDB))) ? false : $___mysqli_res);
    $idr = mysqli_insert_id($this->connexioDB);

    //INSERT INTO ESTAT TAULES 
    //recupera estat
    $estatSQL = "SELECT * FROM " . ESTAT_TAULES . " 
			
			WHERE (estat_taula_data<'$data 23:59:59' 
			AND estat_taula_data>='$data' 
			AND estat_taula_torn=$torn		  
			AND estat_taula_taula_id = " . $taula . ")
			OR (estat_taula_data='" . $this->data_BASE . "' 
			AND estat_taula_taula_id = " . $taula . ")
		  
		  ORDER BY estat_taules_timestamp DESC, estat_taula_id DESC";

    $this->qry_result = mysqli_query($this->connexioDB, $estatSQL); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($this->qry_result);

    if (!$row['estat_taula_nom'])
      $row['estat_taula_nom'] = $_POST['estat_taula_taula_id'];

    //INSERT ESTAT 
    $insertSQL = sprintf("INSERT INTO " . ESTAT_TAULES . " ( estat_taula_data, estat_taula_nom, estat_taula_torn, estat_taula_taula_id, 
		reserva_id, estat_taula_x, estat_taula_y, estat_taula_persones, estat_taula_cotxets, estat_taula_grup, estat_taula_plena, estat_taula_usuari_modificacio) 
		VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)", $this->SQLVal($data, "text"), $this->SQLVal($row['estat_taula_nom'], "text"), $this->SQLVal($torn, "text"), $this->SQLVal($taula, "text"), $this->SQLVal($idr, "text"), $this->SQLVal($row['estat_taula_x'], "text"), $this->SQLVal($row['estat_taula_y'], "text"), $this->SQLVal($row['estat_taula_persones'], "zero"), $this->SQLVal($row['estat_taula_cotxets'], "zero"), $this->SQLVal($row['estat_taula_grup'], "text"), $this->SQLVal($row['estat_taula_plena'], "text"), $this->SQLVal(5, "text"));

    $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $id = mysqli_insert_id($this->connexioDB);

    //DELETE REDUNDANTS
    $deleteSQL = sprintf("DELETE FROM " . ESTAT_TAULES . "
			WHERE estat_taula_taula_id = %s 
			AND estat_taula_data=%s 
			AND estat_taula_torn=%s 
			AND estat_taula_id<>%s", $this->SQLVal($taula, "text"), $this->SQLVal($data, "text"), $this->SQLVal($torn, "text"), $this->SQLVal($id, "text"));

    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    //INSERT INTO COMANDES
    if (!isset($idr))
      $idr = 0;
    for ($i = 1; isset($_POST['plat_id_' . $i]); $i++) {
      $insertSQL = sprintf("INSERT INTO comanda ( comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
		VALUES (%s, %s, %s)", $this->SQLVal($idr, "text"), $this->SQLVal($_POST['plat_id_' . $i], "text"), $this->SQLVal($_POST['plat_quantitat_' . $i], "text"));
      $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }

    //desbloquejem taula després de crear reserva, que si no no la vol
    $this->bloqueig_taula($taula, $data, $torn, true);

    //envia SMS
    $persones = $_POST['selectorComensals'] + $_POST['selectorJuniors'] + $_POST['selectorNens'];
    $persones.='p';
    //$mensa = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$idr)";
    //$mensa = $this->lv("Recordi: reserva al Restaurant Can Borrell el %s a les %s (%s).Preguem comuniqui qualsevol canvi: 936929723 - 936910605.Gràcies.(ID:%s)");

    $args[] = $data;
    $args[] = $hora;
    $args[] = $persones;
    $args[] = $idr;
    $lang = $_POST["lang"];
    $mensa = "Recordi: reserva al Restaurant Can Borrell el %s a les %s (%s).Preguem comuniqui qualsevol canvi: 936929723 - 936910605.Gràcies.(ID:%s)";
    $mensa = gestor_reserves::SMS_language($mensa, $lang, $args);



    $TPV = $this->paga_i_senyal($coberts);
    $extres['subject'] = "Can-Borrell: CONFIRMACIÓ DE RESERVA ONLINE";

    //envia MAIL
    if ($_POST['client_email'] && !$TPV)
      $mail = $this->enviaMail($idr, "confirmada_", FALSE, $extres);

    $resposta['mail'] = isset($mail) ? $mail : FALSE;
    $resposta['virtual'] = $taulaVirtual;
    $resposta['TPV'] = $TPV ? "TPV" : "";
    $resposta['idr'] = $idr;

    if (isset($_POST['recuperaReservaPaperera']))
      $TPV = FALSE; // Cas que recuperem reserva
    if ($TPV) {
      $nom = $_POST['client_nom'] . ' ' . $_POST['client_cognoms'];

      if (isset($_REQUEST["testTPV"]) && $_REQUEST["testTPV"] == 'testTPV')
        $resposta['form_tpv'] = $this->generaTESTTpvSHA256($idr, import_paga_i_senyal, $nom, 'reserva_pk_tpv_ok_callback', '99');
      else
        $resposta['form_tpv'] = $this->generaFormTpvSHA256($idr, import_paga_i_senyal, $nom);
    }
    else {
      $this->enviaSMS($idr, $mensa);
    }

    $_SESSION['last_submit'] = time(); //PARTXE SUBMITS REPETITS
    $this->xgreg_log("Insert reserva ok des de form <span class='idr'>$idr</span>", 0);
    return $this->jsonOK("Reserva creada", $resposta);
  }

  /*   * ****************************************************************************************************************** */
  /*   * ****************************************************************************************************************** */

// U P D A T E
// U P D A T E
// U P D A T E
// U P D A T E
// U P D A T E
  /*   * ****************************************************************************************************************** */
  /*   * ****************************************************************************************************************** */

  public function salvaUpdate() {
    $this->xgreg_log("Update <span class='idr'>" . $_POST['id_reserva'] . "</span>", 1);
    $resposta['request'] = "update";
//TODO VALIDA 
    $lang = $_POST['lang'] = $_SESSION["lang"];
    $dat = date("d/m");
    $_POST['observacions'] = "MODIFICADA $dat " . $_POST['observacions'];

    //VERIFICA HORA ESBRINA EL TORN	
    $data = $this->cambiaf_a_mysql($_POST['selectorData']);
    if (empty($_POST['hora']))
      return $this->jsonErr(8, $resposta); // 
    $hora = $_POST['hora'];
    $torn = $this->torn($data, $hora);
    if (!$torn)
      return $this->jsonErr(8, $resposta); // COMPROVA torn




      
//VALIDA DADES	

    $date = '';
    if ($data < date("Y-m-d"))
      $resposta['error'] = "err1 Data passada: " . $_POST['selectorData'] . " < " . date("d/m/Y");
    $date = strtotime(date("Y-m-d", strtotime($date)) . " +1 year");
    if ($data > $date)
      $resposta['error'] = "err2: data futura: " . $_POST['selectorData'];

    //hora - torn - taula ok?
    $coberts = $_POST['adults'] + $_POST['nens10_14'] + $_POST['nens4_9'];
    $PERSONES_GRUP = $this->configVars("persones_grup");

    if ($coberts < 2 || $coberts > $PERSONES_GRUP)
      return $this->jsonErr(7, $resposta);;

    $cotxets = isset($_POST['selectorCotxets']) ? $_POST['selectorCotxets'] : 0;

    if (!isset($_POST['selectorAccesible']))
      $_POST['selectorAccesible'] = false;
    if (!isset($_POST['selectorCadiraRodes']))
      $_POST['selectorCadiraRodes'] = false;
    $accesible = ($_POST['selectorAccesible'] || $_POST['selectorCadiraRodes']);

    $reserva = $this->taulesDisponibles->loadReserva($_POST['id_reserva']);
    $_POST['resposta'] = $reserva->last_row['resposta'];

    // CARREGA RESERVA I COMPROVA EXISTEIX
    if (!$reserva)
      return $this->jsonErr(3, $resposta);

    $this->taulesDisponibles->data = $data;
    $this->taulesDisponibles->torn = $torn;
    $this->taulesDisponibles->hora = $hora;
    $this->taulesDisponibles->persones = $coberts;
    $this->taulesDisponibles->cotxets = $cotxets;
    $this->taulesDisponibles->accesible = $accesible;
    //$this->taulesDisponibles->tableHores="estat_hores_form";
    $this->taulesDisponibles->tableHores = "estat_hores";
    $this->taulesDisponibles->tableMenjadors = "estat_menjador_form";

    $this->taulesDisponibles->llista_dies_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_nits_negra = LLISTA_DIES_NEGRA_RES_PETITES;
    $this->taulesDisponibles->llista_dies_blanca = LLISTA_DIES_BLANCA;

    //echo($this->taulesDisponibles->dump());
    // VALIDA SI HEM TROBAT TAULA
    if (!$taules = $this->taulesDisponibles->taules())
      return $this->jsonErr(3, $resposta);


    $taula = $taules[0]->id;
    // VALIDA SI HEM TROBAT HORA
    if (!$this->taulesDisponibles->horaDisponible($hora))
      return $this->jsonErr(8, $resposta);

    //SI CREA_TAULA LA GUARDA
    if ($taules[0]->taulaVirtual)
      $taules[0]->guardaTaula();

    //dades client?
    if (empty($_POST['client_mobil']))
      return $this->jsonErr(4, $resposta); //"err4 mobil";
    if (empty($_POST['client_nom']))
      return $this->jsonErr(5, $resposta); //"err5 nom";
    if (empty($_POST['client_cognoms']))
      return $this->jsonErr(6, $resposta); //"err6: cognoms";

      /*       * ****************************************************************************************************************** */
    // PREPAREM PERMUTA
    /*     * ****************************************************************************************************************** */
    $_POST['estat_taula_taula_id'] = $taula;
    $_POST['data'] = $_POST['selectorData'];
    $_POST['cotxets'] = $cotxets;


    //RESERVA INFO
    $_POST['reserva_info'] = $this->encodeInfo($_POST['amplaCotxets'], 0, 1);
    $esborra = (isset($_POST['esborra_dades']) && $_POST['esborra_dades'] == 'on');
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 7, $esborra);

    $selectorCadiraRodes = (isset($_POST['selectorCadiraRodes']) && $_POST['selectorCadiraRodes'] == 'on');
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 8, $selectorCadiraRodes);
    $selectorAccesible = (isset($_POST['selectorAccesible']) && $_POST['selectorAccesible'] == 'on');
    $_POST['reserva_info'] = $this->flagBit($_POST['reserva_info'], 9, $selectorAccesible);
    $_POST['observacions'] = preg_replace("/Portem cadira de rodes /", "", $_POST['observacions']);
    if ($selectorCadiraRodes) {
      $_POST['observacions'] = 'Portem cadira de rodes ' . $_POST['observacions'];
    }

    $perm = $_SESSION['permisos'];
    $_SESSION['permisos'] = Gestor::$PERMISOS; //LI DONO PERMISOS PER FER LA PERMUTA	
    $this->permuta_reserva();
    $_SESSION['permisos'] = $perm; //LI RETIRO ELS PERMISOS

    $extra = 'INFO: ' . $_POST['reserva_info'];
    /*     * ****************************************************************************************************************** */
//INSERT INTO COMANDES
    $deleteSQL = "DELETE FROM comanda WHERE comanda_reserva_id=" . $_POST['id_reserva'];
    $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    for ($i = 1; isset($_POST['plat_id_' . $i]); $i++) {
      $insertSQL = sprintf("INSERT INTO comanda ( comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) 
		VALUES (%s, %s, %s)", $this->SQLVal($_POST['id_reserva'], "text"), $this->SQLVal($_POST['plat_id_' . $i], "text"), $this->SQLVal($_POST['plat_quantitat_' . $i], "text"));
      $this->qry_result = $this->log_mysql_query($insertSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }



//desbloquejem taula després de crear reserva, que si no no la vol
    $this->bloqueig_taula($taula, $data, $torn, true);



//GUARDA O UPDATA CLIENT
    $this->insertUpdateClient($_POST['client_mobil']);


//envia SMS
    $idr = $_POST['id_reserva'];
    //$mensa = "Restaurant Can Borrell, reserva MODIFICADA: Le esperamos el $data a las $hora. Rogamos comunique cualquier cambio en la web o tels.936929723 - 936910605. Gracias.(ID:$idr)";
    //$mensa = $this->lv("Restaurant Can Borrell, reserva MODIFICADA: L'esperem el %s a les %s. Preguem comuniqui qualsevol canvi al web o tel.936929723 - 936910605. Gràcies.(ID:%s)");
    //$mensa = sprintf($mensa, $data, $hora, $idr);

    $args[] = $data;
    $args[] = $hora;
    $args[] = $idr;
    $mensa = "Restaurant Can Borrell, reserva MODIFICADA: L'esperem el %s a les %s. Preguem comuniqui qualsevol canvi al web o tel.936929723 - 936910605. Gràcies.(ID:%s)";
    $mensa = gestor_reserves::SMS_language($mensa, $lang, $args);

    $this->enviaSMS($idr, $mensa);
//envia MAIL
    $extres['subject'] = "Can-Borrell: MODIFICACIÓ RESERVA ONLINE " . $_POST['id_reserva'];
    if ($_POST['client_email'])
      $mail = $this->enviaMail($_POST['id_reserva'], "../reservar/mail_res_modificada_", FALSE, $extres);


//PREPARA RESPOSTA JSON	
    $resposta['mail'] = $mail;
    $this->xgreg_log("Update reserva ok des de form <span class='idr'>" . $_POST['id_reserva'] . "</span>", 1);
    return $this->jsonOK("Reserva modificada: " . $extra, $resposta);
  }

  public function cancelReserva($mob, $idr) {
    $this->xgreg_log("cancelReserva $mob <span class='idr'>$idr</span>");

    if ($this->recuperaReserva($mob, $idr)) {
      $perm = $_SESSION['permisos'];
      $_SESSION['permisos'] = Gestor::$PERMISOS; //LI DONO PERMISOS PER FER LA PERMUTA

      $this->paperera_reserves($idr); //paperera
      $_SESSION['permisos'] = $perm;

      //ENVIA MAIL
      $_POST['id_reserva'] = $idr;
      $extres['subject'] = "Can-Borrell: RESERVA CANCELADA " . $_POST['id_reserva'];
      $mail = $this->enviaMail($idr, "cancelada_", FALSE, $extres);

      $deleteSQL = "DELETE FROM " . T_RESERVES . " WHERE id_reserva=$idr";
      $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      $usr = $_SESSION['uSer']->id;

      $deleteSQL = "UPDATE " . ESTAT_TAULES . " SET reserva_id=0, estat_taula_usuari_modificacio=$usr WHERE reserva_id=$idr";
      $this->qry_result = $this->log_mysql_query($deleteSQL, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
    else {
      return false;
    }

    return true;
  }

  public function insertUpdateClient($mobil) {
    $this->xgreg_log("insertUpdateClient $mobil", 1);

    //VERIFICA SI EXISTEIX
    $query = "SELECT * FROM client WHERE client_mobil='" . $mobil . "'";
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    if (mysqli_num_rows($Result1)) {
      // SI EL CLIENT JA EXISTIA FEM UPDATE 
      $row = mysqli_fetch_array($Result1);
      $idc = $row['client_id'];

      $query = "UPDATE  `client` SET  
`client_nom` =  '" . $_POST['client_nom'] . "',
`client_cognoms` =  '" . $_POST['client_cognoms'] . "',
`client_telefon` =  '" . $_POST['client_telefon'] . "',
`client_email` =  '" . $_POST['client_email'] . "'
WHERE  `client`.`client_id` =$idc;
";
      $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    }
    else { //NO TROBAT, FEM INSERT
      $query = "INSERT INTO `client` (`client_id`, `client_nom`, `client_cognoms`, `client_adresa`, `client_localitat`, `client_cp`, `client_dni`, `client_telefon`, `client_mobil`, `client_email`, `client_conflictes`) VALUES (NULL, '" . $_POST['client_nom'] . "', '" . $_POST['client_cognoms'] . "', '" . $_POST['client_adresa'] . "', '" . $_POST['client_localitat'] . "', '" . $_POST['client_cp'] . "', '" . $_POST['client_dni'] . "', '" . $_POST['client_telefon'] . "', '" . $_POST['client_mobil'] . "', '" . $_POST['client_email'] . "', NULL);";
      $Result1 = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $idc = ((is_null($___mysqli_res = mysqli_insert_id($this->connexioDB))) ? false : $___mysqli_res);
    }
    return $idc;
  }

  /*   * ****************************************************************************************************************** */
  /*   * ****************************************************************************************************************** */

  public function contactar($post) {
    $this->xgreg_log("contactar");


    if (!empty($post['cotrol_rob']))
      return false;

    $dest = MAIL_RESTAURANT;
    //$dest="alex@infopruna.net";
    $extres['reserva_consulta_online'] = $_POST['reserva_consulta_online'];
    $extres['client_email'] = $_POST['client_email'];
    $extres['subject'] = "Can-Borrell: Consulta reserves petites online";

    if (!empty($post['idr']) && floor($post['idr']) < 1000)
      return false;

    if (Gestor::validaEmail($post['client_email']))
      return $this->enviaMail($post['idr'], "contactar_restaurant_", $dest, $extres);
    return false;
  }

  /*   * ****************************************************************************************************************** */

  public function contactar_grups($post) {
    $this->xgreg_log("contactar_grups");

    if (!empty($post['cotrol_rob']))
      return false;
    if (!empty($post['idr']) && floor($post['idr']) < 500)
      return false;
    $idr = $post['idr'];

    $query = "SELECT * FROM reserves 
		LEFT JOIN client ON reserves.client_id=client.client_id
		WHERE id_reserva=$idr";

    if (floor($idr) <= SEPARADOR_ID_RESERVES) {
      $this->qry_result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $extres = mysqli_fetch_assoc($this->qry_result);
    }
    $dest = MAIL_RESTAURANT;
    $extres['reserva_consulta_online'] = $_POST['reserva_consulta_online'];
    $extres['client_email'] = $_POST['client_email'];
    $extres['subject'] = "Can-Borrell: GRUPS Consulta reservesonline";



    if (Gestor::validaEmail($post['client_email']))
      return $this->enviaMail($post['idr'], "contactar_restaurant_", $dest, $extres);
    return false;
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  public function taulaDinsMenjadors($x, $y, $menjadorsBloquejatsOnline) {
    foreach ($menjadorsBloquejatsOnline as $key => $menjador) {
      if ($menjador && $menjador->solapa($x, $y))
        return $menjador->name;
    }
    return false;
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  public function TTmenu($id) { //over
    require_once(ROOT . "Carta.php");
    $carta = new Carta();

    return $carta->TTmenu($id);
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  public function paga_i_senyal($comensals) {
    return ($comensals >= $this->configVars("persones_paga_i_senyal") && $comensals < $this->configVars("persones_grup"));
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ************************************************ */

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
  /*   * ************************************************ */
  public function respostaTPV_SHA256() {
    echo "RESPOSTA TPV >>> ";
    
    //$post=print_r($_POST["Ds_SignatureVersion"],TRUE);
$this->xgreg_log("RESPOSTA TPV256 >>>>>>>>> <span class='idr'>" . $_POST["Ds_MerchantParameters"] . "</span>", 0, LOG_FILE_TPVPK, TRUE);
    $id = $lang = "not set";
    include(ROOT . INC_FILE_PATH . TPV_CONFIG_FILE); //NECESSITO TENIR A PUNT $id i $lang
    require_once ROOT . INC_FILE_PATH . 'API_PHP/redsysHMAC256_API_PHP_5.2.0/apiRedsys.php';
    // Se crea Objeto
    $miObj = new RedsysAPI;
    if (!empty($_POST)) {//URL DE RESP. ONLINE
      $version = $_POST["Ds_SignatureVersion"];
      $datos = $_POST["Ds_MerchantParameters"];
      $signatureRecibida = $_POST["Ds_Signature"];

      $params = $miObj->decodeMerchantParameters($datos);
      $signatureEsperada = $miObj->createMerchantSignatureNotif($clave256, $datos);
      $param = json_decode($params, TRUE);

      $this->xgreg_log("RESPOSTA TPV256 >>>>>>>>> <span class='idr'>" . $param['Ds_Order'] . "</span>", 0, LOG_FILE_TPVPK, FALSE);
      $p = print_r($param, TRUE);
      $p = '<pre class="tpv-response-params">' . $p . "</pre>";
      $this->xgreg_log("DECODE Paràmetres >>> $p", 1, LOG_FILE_TPVPK, FALSE);
      echo " >>> ";
      echo "<pre>";
      print_r($param);
      echo "</pre>";
      echo "<br>";
      echo "<br>";
      echo "<br>";
      echo $signatureRecibida;

      /*       * *********************************************************************************** */
      /*       * *********************************************************************************** */
      /*       * *********************************************************************************** */
      if ($signatureEsperada === $signatureRecibida) { //**** VALIDA SIGNATURA
        echo "<br/>SIGNATURE OK<br/>";
        $this->xgreg_log("SIGNATURE OK", 1, LOG_FILE_TPVPK, FALSE);
        $response = $param['Ds_Response'];
        $response = intval($response);

        $k = substr($param['Ds_Order'], 3, 6);
        $idr = $order = (int) $k;

        /** RESPOSTA INCORRECTA * */
        if ($response < 0 || $response > 99) {  // ****** VERIFICA RESPOSTA entre 0000 i 0099
          $this->cancelPagaISenyal($idr);
          echo "Response incorrecta!! >>>  $response";
          $this->xgreg_log("Response incorrecta >>> $response", 1, LOG_FILE_TPVPK, TRUE);
          return FALSE;
        }

        $this->xgreg_log("Response ok >>> $response", 1, LOG_FILE_TPVPK, FALSE);
        $amount = $param['Ds_Amount'];
        $data = $param['Ds_Date'];
        $hora = $param['Ds_Hour'];
        $callback = $param["Ds_MerchantData"];
        $lang = ((int) $param['Ds_ConsumerLanguage']) == 3 ? "cat" : "esp";

        $doble = $this->doblePagament($idr);
        $doble = 0;

        if (!$order || $doble || !$amount) {
          return FALSE;
        }

        echo "<br/>FIRMA OK<br/>";
        $this->xgreg_log("dades >>> ", 1, LOG_FILE_TPVPK, FALSE);
        $this->xgreg_log("$order $amount", 1, LOG_FILE_TPVPK, FALSE);
        $this->xgreg_log("$callback ", 1, LOG_FILE_TPVPK, FALSE);

        $this->$callback($idr, $amount, $data, $hora);
      }
      else {
        echo "<br/>FIRMA KO<br/>";
        $this->xgreg_log("xxx SIGNATURE KO xxx >>> ", 1, LOG_FILE_TPVPK, FALSE);
      }
    }
    else {
      echo "<br/>NO REBEM DADES<br/>";
      $this->xgreg_log("RESPOSTA TPV256 >>>>>>>>> NO REBEM DADES", 0, LOG_FILE_TPVPK, FALSE);
    }
  }

  /*   * *************************************************************************************** */
  /*   * *************************************************************************************** */
  /*   * *************************************************************************************** */
  /*   * *************************************************************************************** */
  /*   * *************************************************************************************** */
  /*   * *************************************************************************************** */

  private function reserva_pk_tpv_ok_callback($idr, $amount, $pdata, $phora) {
    $this->xgreg_log("reserva_pk_tpv_ok_callback", 1, LOG_FILE_TPVPK, FALSE);
    $query = "SELECT estat, client_email, data, hora, adults, nens10_14, nens4_9 "
        . "FROM " . T_RESERVES . " "
        . "LEFT JOIN client ON client.client_id=" . T_RESERVES . ".client_id "
        . "WHERE id_reserva=$idr";

    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $files = mysqli_num_rows($result);

    if (!$files) {
      //echo "NO TROBO RESERVA TPV!!!!";
      $this->xgreg_log("NO TROBO RESERVA TPV!!!!", 1, LOG_FILE_TPVPK, TRUE, 1); /* LOG */
      $this->xgreg_log("Recuperem reserve eliminada...", 1, LOG_FILE_TPVPK, TRUE, 1); /* LOG */
      $post = $this->recuperaReservaPaperera($idr);

      $query = "SELECT estat, client_email, data, hora, adults, nens10_14, nens4_9 "
          . "FROM " . T_RESERVES . " "
          . "LEFT JOIN client ON client.client_id=" . T_RESERVES . ".client_id "
          . "WHERE id_reserva=$idr";
      $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $files = mysqli_num_rows($result);
    }


    $row = mysqli_fetch_assoc($result);

    $estat = $row['estat'];
    $mail = $row['client_email'];
    if ($estat != 2) { // NO ESTÀ CONFIRMADA PER PAGAR
      $msg = "PAGAMENT INAPROPIAT RESERVA PETITA???: " . $idr . " estat: $estat  $mail";
      $this->xgreg_log($msg, 1, LOG_FILE_TPVPK, TRUE, 1); /* LOG */
      $this->xgreg_log($msg, 1, LOG_FILE_TPVPK, TRUE, 0); /* LOG */
      //echo "ERROR ESTAT!=2";


      $extres['subject'] = "Can-Borrell: !!!! $msg!!!";
      $mail = $this->enviaMail($idr, "../reservar/paga_i_senyal_", MAIL_RESTAURANT, $extres);
      return FALSE;
    }


    $referer = $_SERVER['REMOTE_ADDR'];
    $import = $amount / 100;
    $resposta = "PAGA I SENYAL TPV: " . $import . "Euros (" . $pdata . " " . $phora . ")";

    if (isset($_REQUEST['param']) && $_REQUEST['param'] == 'no-update') {
      $result = "ANULAT";
    }
    else {
      $query = "UPDATE " . T_RESERVES . " SET estat=100, preu_reserva='$import', resposta='$resposta' WHERE id_reserva=$idr";
      $res = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
      $result = print_r($res, TRUE);
      
      $query="UPDATE estat_taules SET estat_taules_timestamp=NOW() WHERE reserva_id=$idr";
            $res = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

      //$result = $res?"!!!SUCCESS!!!":"***ERROR***";
    }
//$result = "ANULAT";    

    $extres['subject'] = $this->l("Can-Borrell: RESERVA CONFIRMADA", false);

    if ($mail) {
      $this->enviaMail($idr, "../reservar/paga_i_senyal_", "", $extres);
    }

    $persones = $row['adults'] + $row['nens10_14'] + $row['nens4_9'];
    $persones.='p';

    $data = $this->cambiaf_a_normal($row['data']);
    $hora = $row['hora'];

    $missatge = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$idr)";
    $missatge.="\n***\nConserve este SMS como comprobante de la paga y señal de " . $import . "€ que le será descontada. También hemos enviado un email que puede imprimir";

    $args[] = $data;
    $args[] = $hora;
    $args[] = $persones;
    $args[] = $idr;
    $args[] = $import;
    $missatge = "Recordi: reserva al Restaurant Can Borrell. %s %s (%s).Preguem comuniqui qualsevol canvi: 936929723/936910605.Gràcies.(ID%s)";

    $missatge .= "\n***\nConservi quest SMS com a comprovant de la paga y senyal de %s€ que li serà descomptada. També hem enviat un email que pot imprimir";
    $row['lang'] = isset($row['lang']) ? $row['lang'] : "ca";
    $missatge = gestor_reserves::SMS_language($missatge, $row['lang'], $args);
    $this->enviaSMS($idr, $missatge);

    if ($result) { //ACTUALITZADA BBDD
      $this->xgreg_log("PAGAMENT OK + UPDATE OK " . $query . " >> " . $result, 1, LOG_FILE_TPVPK); /* LOG */
    }
    else {
      $this->greg_log("PAGAMENT OK + UPDATE KO!!! " . $query . " >> " . $result, 1, LOG_FILE_TPVPK); /* LOG */
    }
  }

  private function reserva_grups_tpv_ok_callback($idrl, $amount, $pdata, $phora) {
    $this->xgreg_log("reserva_grups_tpv_ok_callback", 1, LOG_FILE_TPVPK, FALSE);

    $idr = substr($idrl, -4);
    $query = "SELECT estat, client_email, data, hora, lang, adults, nens10_14, nens4_9, lang "
        . "FROM reserves "
        . "LEFT JOIN client ON client.client_id=reserves.client_id "
        . "WHERE id_reserva=$idr";

    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($result);

    $estat = $row['estat'];
    $mail = $row['client_email'];

    if ($estat != 2) { // NO ESTÀ CONFIRMADA PER PAGAR
      $msg = "PAGAMENT INAPROPIAT RESERVA PETITA???: " . $idr . " estat: $estat  $mail";
      $this->xgreg_log($msg, 1, LOG_FILE_TPVPK, FALSE); /* LOG */
      echo "ERROR ESTAT!=2";
      $extres['subject'] = "Can-Borrell: !!!! $msg!!!";
      $mail = $this->enviaMail($idr, "../reservar/paga_i_senyal_", MAIL_RESTAURANT, $extres);
      return FALSE;
    }
    $referer = $_SERVER['REMOTE_ADDR'];
    $import = $amount / 100;
    $resposta = "PAGA I SENYAL GRUPS TPV: " . $import . "Euros (" . $pdata . " " . $phora . ")";

    /*     * *****ATENCIO ******************** */
    /*     * *****ATENCIO ******************** */
    /*     * *****ATENCIO ******************** */
    /*     * *****ATENCIO ******************** */
    /*     * *****ATENCIO ******************** */
    $query = "UPDATE reserves SET estat=7, preu_reserva='$import', resposta='$resposta' WHERE id_reserva=$idr";
    $result = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    include('translate_' . $this->lng . '.php');
    echo $query . " >>> " . $result;
//
    $extres['subject'] = $translate["MAIL_GRUPS_PAGAT_subject"];
    $extres['titol'] = $translate["MAIL_GRUPS_PAGAT_titol"];
    $extres['text1'] = $translate["MAIL_GRUPS_PAGAT_text1"] . number_format($import, 2);
    $extres['text2'] = $translate["MAIL_GRUPS_PAGAT_text2"];
    $extres['contacti'] = $translate["MAIL_GRUPS_PAGAT_contacti"];
    $mydata = $this->cambiaf_a_mysql($pdata);
    $extres['datat'] = $this->data_llarga($row['data'], $this->lang) . ", " . $phora . "h";
    //$extres['datat'] = $this->data_llarga($row['data'], $this->lang).", ".$phora."h";
    $extres['cnom'] = $translate["nom"];
    $extres['cadults'] = $translate["adults"];
    $extres['cnens4_9'] = $translate["nens 4 a 9"];
    $extres['cnens10_14'] = $translate["nens 10 a 14"];
    $extres['ccotxets'] = $translate["cotxets"];
    $extres['cobservacions'] = $translate["observacions"];
    $extres['cresposta'] = $translate["resposta"];
    //$extres['data_limit'] = $translate["Data límit per efectuar el pagament"]." ". $pdata;
    $extres['data_limit'] = "";
    $extres['cdata_reserva'] = $translate["cdata_reserva"];
    $extres['menu'] = $translate["menu"];

    if ($mail) {
      $this->enviaMail($idr, "../editar/templates/mail_cli_", "", $extres);
    }

    $persones = $row['adults'] + $row['nens10_14'] + $row['nens4_9'] . 'p';
    $data = $this->cambiaf_a_normal($row['data']);
    $hora = $row['hora'];
    //$missatge = "Recuerde: reserva en Restaurant Can Borrell el $data a las $hora ($persones).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:$idr)";
    //$missatge.="\n***\nConserve este SMS como comprobante de la paga y señal de " . $import . "€ que le será descontada. También hemos enviado un email que puede imprimir";

    $args[] = $data;
    $args[] = $hora;
    $args[] = $persones;
    $args[] = $idr;
    $args[] = $import;
    $missatge = "Recordi: reserva al Restaurant Can Borrell. %s %s (%s).Preguem comuniqui qualsevol canvi: 936929723/936910605.Gràcies.(ID%s)";
    $missatge .= "\n***\nConservi quest SMS com a comprovant de la paga y senyal de %s€ que li serà descomptada. També hem enviat un email que pot imprimir";
    $missatge = gestor_reserves::SMS_language($missatge, $row['lang'], $args);
    $this->enviaSMS($idr, $missatge);

    if ($result) { //ACTUALITZADA BBDD
      $this->xgreg_log("PAGAMENT OK + UPDATE OK " . $query . " >> " . $result, 1, LOG_FILE_TPVPK); /* LOG */
    }
    else {
      $this->xgreg_log("PAGAMENT OK + UPDATE KO!!! " . $query . " >> " . $result, 1, LOG_FILE_TPVPK); /* LOG */
    }
  }

  /*   * ******************************************************************************************************* */
  /* COMPROVA SI JA S'HA FET EL PAGAMENT (doble click a submit)
    /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  private function doblePagament($id) {
    $query = "SELECT estat, client_email, data, hora, adults, nens10_14, nens4_9 "
        . "FROM " . T_RESERVES . " "
        . "LEFT JOIN client ON client.client_id=" . T_RESERVES . ".client_id "
        . "WHERE id_reserva=$id";

    $result = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $row = mysqli_fetch_assoc($result);


    $estat = $row['estat'];
    $mail = $row['client_email'];


    return ($estat == 2);
  }

  function comprovaSubmit($data, $comensals, $tel = -1) {

    session_write_close();
    session_write_close();
    session_write_close();
    //http://cbdev.localhost/reservar/Gestor_form.php?a=comprovaSubmit&b=2015-01-29&c=8&d=606782798
    $result['query'] = $query = <<<SQL
                SELECT reserva_id FROM estat_taules 
                LEFT JOIN reservestaules ON reserva_id = id_reserva
                LEFT JOIN client ON reservestaules.client_id = client.client_id 
                WHERE client_mobil={$tel} AND estat_taula_data={$data} AND estat_taula_persones={$comensals}
SQL;

    $r = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $n = mysqli_num_rows($r);

    $result['codi'] = FALSE;
    $result['result'] = FALSE;
    return json_encode($result);
  }

  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */
  /*   * ******************************************************************************************************* */

  public function test($t) { //over
    $this->valida_sessio(1);
    echo "Gestor_form: " . $t . '<br>';

    $data = "12/2/2016";
    $hora = "14:00";

    $persones = 5;
    $idr = 1345;

    $mensa = $this->lv("Recordi: reserva al Restaurant Can Borrell el %s a les %s (%s).Preguem comuniqui qualsevol canvi: 936929723 - 936910605.Gràcies.(ID:%s)");
    $mensa = sprintf($mensa, $data, $hora, $persones, $idr);

    return $mensa;
  }

  public function reserva_entra_avui($data, $torn) {
    $min_date = new DateTime(MAX_HORA_RESERVA_ONLINE);
    $min_date->modify("+" . MARGE_DIES_RESERVA_ONLINE . " days");
    $data_reserva = new DateTime($data . ' ' . $torn);
    $entra = $data_reserva > $min_date;
    return $entra;
  }

  public function reset_estat($pidr, $taula = 'reservestaules') {

    if (!$this->valida_sessio(63)) {
      die("Sense permisos");
    }

    $this->xgreg_log("reset_estat <span class='idr'>$pidr</span> $taula", 0, LOG_FILE_TPVPK); /* LOG */

    $idr = substr($pidr, -5);
    $query = "UPDATE $taula SET estat=2, preu_reserva='15', resposta='TEST' WHERE id_reserva=$idr";
    $result = $this->log_mysql_query($query, $this->connexioDB) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    echo $query;
    echo "<br>" . mysqli_affected_rows($this->connexioDB);
    echo "<br>RESET ESTAT !!!";
  }

  private function recuperaReservaPaperera($id_reserva) {
    if ($_SESSION['permisos'] < 16)
      return "error:sin permisos";

    $this->xgreg_log("RECUPERA PAPERERA paperera_reserves($id_reserva)", 0);
    if (!defined("DB_CONNECTION_FILE_DEL"))
      return;

    include(ROOT . DB_CONNECTION_FILE_DEL);

    $query = "SELECT * FROM " . T_RESERVES . " LEFT JOIN client ON client.client_id = " . T_RESERVES . ".client_id WHERE id_reserva=$id_reserva";
    $this->qry_result = $this->log_mysql_query($query, $GLOBALS["___mysqli_stonDEL"]); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
    $files = mysqli_num_rows($this->qry_result);

    $this->xgreg_log($query . ' >> ' . $files, 1, LOG_FILE_TPVPK, TRUE, 1); /* LOG */
    if (!$files)
      return FALSE;
    $row = mysqli_fetch_assoc($this->qry_result);
    $_POST['id_reserva'] = NULL; // PER FER EL SUBMIT CAL QUE id_reserva sigui null
    //$_POST['id_reserva'] = $id_reserva;
    $_POST['selectorData'] = $this->cambiaf_a_normal($row['data']); //$row[''];
    $_POST['hora'] = $row['hora'];
    $_POST['adults'] = $_POST['selectorComensals'] = $row['adults'];
    $_POST['nens10_14'] = $row['nens10_14'];
    $_POST['selectorJuniors'] = $row['nens10_14'];
    $_POST['nens4_9'] = $row['nens4_9'];
    $_POST['selectorNens'] = $row['nens4_9'];
    $_POST['totalComensals'] = $row['nens4_9'] + $row['nens10_14'] + $row['adults'];

    $_POST['totalCotxets'] = '/ ' . $row['cotxets'];
    $_POST['selectorCotxets'] = $row['cotxets'];
    $_POST['reserva_info'] = $row['reserva_info'];
    $ar = $this->decodeInfo($row['reserva_info']);
    $_POST['amplaCotxets'] = $ar['ampla'];
    $_POST['selectorAccesible'] = $ar['accesible'] ? "on" : 0;
    $_POST['selectorCadiraRodes'] = $ar['cadiraRodes'] ? "on" : 0;
    $_POST['esborra_dades'] = $ar['esborra_cli'] ? "on" : 0;

    $_POST['INFO_PASTIS'] = $row['reserva_info_pastis'];
    $_POST['RESERVA_PASTIS'] = $row['reserva_pastis'] ? "on" : 0;
    $_POST['observacions'] = $row['observacions'];
    $_POST['resposta'] = $row['resposta'];

    $_POST['client_mobil'] = $row['client_mobil'];
    $_POST['client_telefon'] = $row['client_telefon'];
    $_POST['client_email'] = $row['client_email'];
    $_POST['client_nom'] = $row['client_nom'];
    $_POST['client_cognoms'] = $row['client_cognoms'];
    $_POST['client_id'] = $row['client_id'];

    $_POST['last_submit'] = 0;
    $_POST['pidr'] = $id_reserva;
    $_POST['pamount'] = $row['preu_reserva'];
    $_POST['presponse'] = 99;
    $_POST['client_id'] = 'reserva_pk_tpv_ok_callback';
    $_POST['recuperaReservaPaperera'] = 'recuperaReservaPaperera';

    $this->xgreg_log("SUBMIT...", 1, LOG_FILE_TPVPK, TRUE, 1); /* LOG */
    $rjson = $this->submit();

    $r = json_decode($rjson);
    //echo "<pre>";
    //print_r($r);
    //echo "</pre>";

    if (!isset($r->idr))
      return FALSE;

    $idr = $r->idr;


    $update = "UPDATE " . ESTAT_TAULES . " SET reserva_id=$id_reserva WHERE   reserva_id = $idr";
    $this->qry_result = $this->log_mysql_query($update, $this->connexioDB); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $update = "UPDATE " . T_RESERVES . " SET id_reserva=$id_reserva WHERE   id_reserva = $idr";
    $this->qry_result = $this->log_mysql_query($update, $this->connexioDB); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    $updatecomanda = "REPLACE INTO comanda ( comanda_id, comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat) SELECT `$database_canborrell`.comanda_id, comanda_reserva_id, comanda_plat_id, comanda_plat_quantitat FROM comanda WHERE comanda_reserva_id=41923;";
    $this->qry_result = $this->log_mysql_query($updatecomanda, $this->connexioDB); // or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    return $rjson;
  }
  
  
  
  
  
  
  
  
  
/*******************************************************************************************/  
/*******************************************************************************************/  
/*******************************************************************************************/  
/*******************************************************************************************/  
/*******************************************************************************************/  
/*******************************************************************************************/  
/*******************************************************************************************/  
/*******************************************************************************************/
    public function recuperaCartaWeb($idr=-1, $es_menu = false) {
      
    $lng = $leng = $this->lng;
    if ($idr < 1)
      $idr = -1;
    //CONTROL DIES NOMES CARTA


    if ($es_menu)
      $were = ' carta_plats.carta_plats_subfamilia_id=20 ';
    else
      $were = ' (carta_plats.carta_plats_subfamilia_id<>20) ';

    $were.=' AND carta_plats_subfamilia_id IN (1101, 1102, 1103, 1104, 1105)';
    $were.=' AND carta_publicat = TRUE ';

    if ($leng == 'en') $leng='ca';
    
    $CONTROLA_ARTICLES_ACTIUS = "";

    $query = "select `carta_plats_id`,`carta_plats_nom_es`,`carta_plats_nom_$leng` AS `carta_plats_nom_$lng`,`carta_plats_nom_ca`,`carta_plats_preu`,"
        . "carta_subfamilia.carta_subfamilia_id AS subfamilia_id,`carta_subfamilia_nom_$leng` AS `carta_subfamilia_nom_$lng`, 
          comanda_client.comanda_plat_quantitat 
FROM carta_plats 
LEFT JOIN carta_publicat ON carta_plats_id=carta_publicat_plat_id
LEFT JOIN comanda as comanda_client ON carta_plats_id=comanda_plat_id AND comanda_reserva_id='$idr'
LEFT JOIN carta_subfamilia ON carta_subfamilia.carta_subfamilia_id=carta_plats_subfamilia_id

LEFT JOIN carta_subfamilia_order ON carta_subfamilia.carta_subfamilia_id=carta_subfamilia_order.carta_subfamilia_id

$CONTROLA_ARTICLES_ACTIUS

WHERE $were
ORDER BY carta_subfamilia_order,carta_plats_nom_es , carta_plats_nom_ca";
    
    //
//ORDER BY (carta_subfamilia_id=2),carta_subfamilia_id";
//echo $query;
    $Result1 = mysqli_query($this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

    while ($row = mysqli_fetch_array($Result1)) {
      if (empty($row['carta_plats_nom_ca']))
        $row['carta_plats_nom_ca'] = $row['carta_plats_nom_en'] = $row['carta_plats_nom_es'];
      $plat = array('id' => $row['carta_plats_id'], 'nom' => $row['carta_plats_nom_' . $lng], 'preu' => $row['carta_plats_preu'], 'quantitat' => $row['comanda_plat_quantitat']);
      $arCarta[$row['carta_subfamilia_nom_' . $lng]][] = $plat;
    }
    
//    echo "<pre>";
//print_r($arCarta);
//    echo "</pre>";
    /*     * ******************************************************************************************************* */

    $class = $es_menu ? "cmenu" : "ccarta";
    $obreLlista = '[ms_tabs style="simple" title_color="" class="" id=""]' . PHP_EOL;
    $llista = "";
    $tancaLlista = ' [/ms_tabs]' . PHP_EOL;
    $carta = "";
/**/
    foreach ($arCarta as $key => $val) {
      $k = $nom = $this->normalitzar($key);
        $nom = l($key, FALSE);
        
      $nom = ucfirst(strtolower($nom));
      
       $obreSeccio = "[ms_tab title='$nom' icon='xfa-leaf']" . PHP_EOL;
      $obreSeccio .= '<p><b>'.$nom.'</b></p>' . PHP_EOL;
      $seccio = $this->seccioCartaWeb($arCarta, $key, $class);
      $tancaSeccio = '[/ms_tab]' . PHP_EOL . PHP_EOL;

      $carta.=$obreSeccio . PHP_EOL . $seccio . PHP_EOL . $tancaSeccio;
    }

    //print_r($arCarta);
    return $obreLlista . $carta. $tancaLlista;
  }

  /*   * ******************************************************************************************************* */

  public function seccioCartaWeb($ar, $k, $class) {
    $obreTaula = '<ul class="carta">' . PHP_EOL;
    
    $tr = '';
    foreach ($ar[$k] as $key => $val) {
      $menuEspecial = $this->menuEspecial($val['id']) ? " menu-especial" : "";
      if (!calsoton && ($val['id'] == 2010 || $val['nom'] == "MENU CALÇOTADA" || $val['nom'] == "MENÚ CALÇOTADA"))
        continue;

      /**  IVA  * */
      $preu = round($val['preu'] + $val['preu'] * IVA / 100, 2);
      $preu = number_format($preu, 2, '.', '');
      
      $nom = $val['nom'];
      
     // echo "****************** $noms";
      $nom = l($nom, FALSE);
      $nom = ucfirst(strtolower($nom));
      
      $tr.='<li producte_id="' . $val['id'] . '" class="item-carta '  . $menuEspecial . '">';
      $tr.=$nom.'<span class="fr">'.$preu.'</span>';
     // $tr.= '<div><div class="dt">'.$val['nom'].'</div><div class="dd">'.$preu."</div></div>";
      $tr.='</li>'. PHP_EOL;
    }

    $tancaTaula = '</ul>' . PHP_EOL . PHP_EOL;

    return $obreTaula . $tr . $tancaTaula;
  }
  
  
  

}

//END CLASS

/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
/* * **************************************************************************************************** */
// AJAX

if (isset($accio) && !empty($accio)) {
  if (!isset($_REQUEST['b']))
    $_REQUEST['b'] = null;
  if (!isset($_REQUEST['c']))
    $_REQUEST['c'] = null;
  if (!isset($_REQUEST['d']))
    $_REQUEST['d'] = null;
  if (!isset($_REQUEST['e']))
    $_REQUEST['e'] = null;
  if (!isset($_REQUEST['f']))
    $_REQUEST['f'] = null;
  if (!isset($_REQUEST['g']))
    $_REQUEST['g'] = null;
  if (!isset($_REQUEST['p']))
    $_REQUEST['p'] = null;
  if (!isset($_REQUEST['q']))
    $_REQUEST['q'] = null;
  if (!isset($_REQUEST['r']))
    $_REQUEST['r'] = null;

  $gestor = new Gestor_form(1);

  if (method_exists($gestor, $accio)) {

    $logables = array('cancelReserva', 'insertUpdateClient', 'salvaUpdate', 'submit', 'update_client', 'esborra_client', 'inserta_reserva', 'update_reserva', 'esborra_reserva', 'enviaSMS', 'permuta', 'permuta_reserva', '', '', '', '', '', '', '', '', '', '', '');
    $log = in_array($accio, $logables);
    $ip = isset($ips[$_SERVER['REMOTE_ADDR']]) ? $ips[$_SERVER['REMOTE_ADDR']] : $_SERVER['REMOTE_ADDR'];
    $sessuser = $_SESSION['uSer'];

    if (isset($sessuser))
      $user = $sessuser->id;

    if ($log) {
      $req = '<pre>' . print_r($_REQUEST, true) . '</pre>';
      $gestor->xgreg_log("Petició Gestor FORM: " . $accio . "  user:$user ($ip) (b=" . $_REQUEST['b'] . ", c=" . $_REQUEST['c'] . ", d=" . $_REQUEST['d'] . " ---- p=" . $_REQUEST['p'] . ", q=" . $_REQUEST['q'] . ", r=" . $_REQUEST['r'] . ", c=" . $_REQUEST['c'] . ", d=" . $_REQUEST['d'] . ", e=" . $_REQUEST['e'] . ") > " . $req . EOL, 1);
    }

    $respostes = array('respostaTPV', 'respostaTPV_SHA256');
    if (!$gestor->valida_sessio(1) && !in_array($accio, $respostes)) {
      echo "err100";
      die();
    }
    $gestor->out(call_user_func(array($gestor, $accio), $_REQUEST['b'], $_REQUEST['c'], $_REQUEST['d'], $_REQUEST['e'], $_REQUEST['f'], $_REQUEST['g']));
  }
}
?>
