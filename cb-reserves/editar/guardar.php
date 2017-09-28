<?php
header('Content-Type: text/html; charset=UTF-8');

if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."Gestor.php");
	


class GuardaConfig extends Gestor
{
	public function __construct($db_connection_file=DB_CONNECTION_FILE,$usuari_minim=16) 	
	{
		parent::__construct($db_connection_file,$usuari_minim);
if (!$this->valida_sessio(63)) header("Location: ../panel/");

	}
	
	public function guardaPOST()
	{
		foreach ($_POST as $k => $v)
		{
                                                                                    $antic = $this->configVars($k);
			$this->xgreg_log(">>> <span class='config'>SET CONFIG: $k = $v</span>  ",0);
			$this->xgreg_log("Anterior  $k = $antic ",1);
			$this->conf->updateVar($k, $v, null, true, null, null);
		}
	
	}
}

$guarda=new GuardaConfig();
$guarda->guardaPOST();
header("Location: editar.php");
?>