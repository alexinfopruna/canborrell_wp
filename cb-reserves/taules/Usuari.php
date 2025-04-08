<?php
class Usuari
{
	var $id;
	var $nom;
	var $permisos;
	var $tok;
	
	function __construct($id,$nom,$permisos) 	
	{
		$this->id=$id;
		$this->nom=$nom;
		$this->permisos=$permisos;
		$this->tok="";
	}
	
}
?>