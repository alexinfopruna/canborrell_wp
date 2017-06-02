<?php
////////////////////////////////////////////////////////////////////////////////
if (!defined('UPPER_NO_TILDE')) define('UPPER_NO_TILDE',false);
$TABLE = "config";
$FILTRE = "";




if (!defined('ROOT'))
  define('ROOT', "../../taules/");
require (ROOT . "gestor_reserves.php");
$gestor = new gestor_reserves();

if (!$gestor->valida_sessio(64)) {
  header("Location: ../login.php");
  die();
}
$cfg = new Configuracio();
$were = " WHERE config_permisos <= ".$_SESSION['uSer']->permisos." ";


////////////////////////////////////////////////////////////////////////////////
$query = "SELECT 
config_id AS idR , 
config_var AS config_var,
config_descripcio AS config_descripcio,
config_val AS config_val
FROM $TABLE
 $were 
ORDER BY config_descripcio
";
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
$EDITABLE= '"'.$_SERVER['PHP_SELF'].'"';

//if ($_POST["edit_id"])
if (isset($_POST["update_value"]))
{
	require_once("DBTable.php");
	$gestor=new DBTable($query);

	$camp=$TABLE."__".$_POST["element_id"];//die($camp);
	echo $gestor->updateValor($camp,$_POST["update_value"]);
	die();
}
include("Llistat.php");
?>