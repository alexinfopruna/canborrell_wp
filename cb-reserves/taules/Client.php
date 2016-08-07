<?php
if (!defined('ROOT')) define('ROOT', "");
require_once(ROOT."Gestor.php");


class Client extends Gestor
{
		public $nom;
		public $cognom;
		public $mobil;
		public $telefon;
		public $email;
		public $adresa;
		public $cp;
		public $observacions;
		public $conflictes;
		
		public $estat;


	    public function Client($id, $nom=null, $cognom=null, $mobil=null, $telefon=null, $email=null, $observacions=null) {
			parent::__construct($db_connection_file,$usuari_minim);
			
			$this->id=$id;
			$this->nom=$nom;
			$this->cognom=$cognom;
			$this->mobil=$mobil;
			$this->telefon=$telefon;
			$this->email=$email;
			$this->observacions=$observacions;
			
			
			if ($id && !$data)
			{
				$row=$this->loadClient($id);
			  //TODO
			}
		}
		
		private function loadClient($id)
		{}
}