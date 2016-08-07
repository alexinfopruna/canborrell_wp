<?php
/************************************************************************************/
// CONTROLA PLATS / PREUS I DESCRIPCIO CARTA
/************************************************************************************/
if (!defined('ROOT')) define('ROOT', "");
require_once(ROOT."Gestor.php");
require_once(ROOT."Plat.php");

if (!defined('IVA')) define('IVA',7);
$factor_iva=(100+IVA)/100;
if (!defined('FACTOR_IVA')) define('FACTOR_IVA',$factor_iva);

/*************************************************************************************/
/*
// EQUIVALENCIA ENTRE LABELS ANTIGUES I IDS DEL CHEF
//M1
$label_id['menu1_1']=2001;
$label_id['menu1_2']=2002;
$label_id['menu1_3']=2037;
$label_id['menu1_4']=2036;
//M1 cel
$label_id['menu1c_1']=2024;
$label_id['menu1c_2']=2025;
$label_id['menu1c_3']=2037;
$label_id['menu1c_4']=2036;
// M2
$label_id['menu2_1']=2003;
$label_id['menu2_4']=2004;
$label_id['menu2_2']=2037;
$label_id['menu2_3']=2036;
// M2 cel
$label_id['menu2c_1']=2023;
$label_id['menu2c_2']=2027;
$label_id['menu2c_3']=2037;
$label_id['menu2c_4']=2036;
// M3
$label_id['menu3_1']=2012;
// M4
$label_id['menu4_1']=2007;
// M CALSOT
$label_id['menuc_1']=2010;
$label_id['menuc_2']=2037;
$label_id['menuc_3']=2036;
$label_id['menuc_4']=2011;// AMB CAVA
// M COMU
$label_id['menucomu_1']=2013;
$label_id['menucomu_2']=2017;
$label_id['menucomu_3']=2018;
// M CASAMENT
$label_id['menucasam_1']=2016;
$label_id['menucasam_2']=2021;
$label_id['menucasam_3']=2022;
*/
/*************************************************************************************/

class Carta extends Gestor
{
	public $plats=array();
	public $arLabelID=array();
	public $arPreusIVA=array();
	
	public function __construct($db_connection_file=DB_CONNECTION_FILE,$usuari_minim=16) 	
	{
		parent::__construct($db_connection_file,$usuari_minim);
		
		// CARREGUEM TRADUCCIONS DELS MENUS
		$this->idioma();
		//require_once(ROOT."../reservar/translate_grups_".$this->lng.".php");
		include(ROOT."../reservar/translate_grups_".$this->lng.".php");
		include(ROOT."../reservar/translate_grups_".$this->lng.".php");

		// CARREGUEM LA TAULA DE PLATS
		
		$query="SELECT * FROM carta_plats";
		$this->qry_result = mysqli_query( $this->connexioDB, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
		$nr=mysqli_num_rows($this->qry_result);
		while ($row= mysqli_fetch_assoc($this->qry_result))
		{
			$id=$row['carta_plats_id'];
			$preuIVA=number_format (round($row['carta_plats_preu']*FACTOR_IVA,2),2);
			$this->arPreusIVA[]=$preuIVA;
			$this->arLabelID[]="{preu_" . $id."}";

			
			$nom=$row['carta_plats_nom_' . $this->lng];
			if (empty($row['carta_plats_nom_' . $this->lng])){
				if (l("titol_menu_" . $id,false)!=("titol_menu_" . $id)) $nom=l("titol_menu_" . $id,false);
				else $nom=$row['carta_plats_nom_'.$this->lng_default];			  
			}
			
			$descripcio=l("menu_" . $id,false);
			
			if ($descripcio=="menu_" . $id) $descripcio="";
			
			$this->plats[$id]=new Plat($id, $nom, $row['carta_plats_familia_id'], $preuIVA, $descripcio);
		}
	} //CONSTRUCTOR		
	
	
/*************************************************************************************/
// DONANT UN ID
// ET TORNA PREU AMB IVA
	public function preuPlat($id, $iva=true)
	{
                if (!$id) return FALSE;
		if ($iva) return($this->plats[$id]->preuIVA);
		else return($this->plats[$id]->preu);
	}
	
/*************************************************************************************/
// DONANT EL NOM EN L'IDIOMA ACTIU 
// ET TORNA ID
	public function recuperaId($nom)
	{
		$arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->plats));
		foreach ($arrIt as $sub) {
			$subArray = $arrIt->getSubIterator();
			if ($subArray['nom'] == $nom) $outputArray[] = iterator_to_array($subArray);		
		}
		return($outputArray[0]['id']);
	}
	
/*************************************************************************************/
// FILTRA CAMP=VALOR (pex, nom�s men�s: familia_id, 20)
// RETORNA ARRAY DE Plats
	public function filtra($camp, $valor)
	{
		$arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->plats));
		foreach ($arrIt as $sub) {
			$subArray = $arrIt->getSubIterator();
			if ($subArray[$camp] == $valor) $outputArray[] = iterator_to_array($subArray);		
		}
		return($outputArray);
	}
	
/*************************************************************************************/
// FILTRA CAMP=VALOR (pex, nom�s men�s: familia_id, 20)
// RETORNA EL PROMIG DEL PREU (pex: 27.34)
	public function filtre_preu_mig($camp=null, $valor=null)
	{
		$arrIt = new RecursiveIteratorIterator(new RecursiveArrayIterator($this->plats));
		$cnt=0;
		$sum=0;
		foreach ($arrIt as $sub) {
			$subArray = $arrIt->getSubIterator();
			if (empty($camp) || $subArray[$camp] == $valor){
				$cnt++;
				$plat= iterator_to_array($subArray);
				$sum += $subArray['preuIVA'];
			}	
		}
		return number_format (round($sum/$cnt,2),2);
	}
	
/*************************************************************************************/
// Monta la descripcio del menu, amb el preu, per Tool Tip
// RETORNA string DESCRIPCIO MENU
	public function TTmenu($id)
	{
		$descripcio=$this->plats[$id]->descripcio;
		$descripcio=str_replace($this->arLabelID,$this->arPreusIVA,$descripcio);

		return "<h1>".$this->plats[$id]->nom.'</h1>'.$descripcio;
	}
	
/*************************************************************************************/
// Monta la descripcio del menu, amb el preu, per Tool Tip
// RETORNA string DESCRIPCIO MENU
	public function parsePreus($id)
	{
		$descripcio=$this->plats[$id]->descripcio;
		$descripcio=str_replace($this->arLabelID,$this->arPreusIVA,$descripcio);

		return $descripcio;
	}
	
} //CLASS

//$c=new Carta();
//print($c->filtre_preu_mig("familia_id",20));
//$c->printr($c->arPreusIVA);
//$c->printr($c->plats);
//$c->printr($c->filtra("familia_id",20));
/*
//$c->filtra("familia_id",20);
*/
?>