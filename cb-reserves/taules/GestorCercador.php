<?php
if (!defined('ROOT')) define("ROOT", "../taules/");
require_once(ROOT."Gestor.php");

/****************************************************************************************/
/****************************************************************************************/
// GESTIONA OPERACIONS DE CERCA SOBRE RESERVES I CLIENTS
/****************************************************************************************/
/****************************************************************************************/
class GestorCercador extends Gestor
{
	public function GestorCercador()
	{
            if (!isset($usuari_minim)) $usuari_minim=NULL;
		parent::__construct(DB_CONNECTION_FILE,$usuari_minim);
	}
}