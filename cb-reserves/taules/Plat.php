<?php
/************************************************************************************/
// ESTRUCTURA DE DADES D'UN PLAT
/************************************************************************************/
if (!defined('FAMILIA_MENUS')) define('FAMILIA_MENUS',20);

class Plat
{
	public $id;
	public $nom;
	public $familia_id;
	public $preuIVA;
	public $descripcio;
	
	public function __construct($pid, $pnom, $pfamilia_id, $ppreuIVA, $pdescripcio=null){
		$this->id = $pid;
		$this->nom = $pnom;
		$this->familia_id = $pfamilia_id;
		$this->preuIVA = $ppreuIVA;
		$this->descripcio = $pdescripcio;
	}

	
/************************************************************************************/
//	ENS DIU SI ES UN  MENU
	public function esMenu(){
		return ($familia_id==FAMILIA_MENUS);
	}
}

?>