    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<?php
define("READER_SCRIPT", "read.php?f=");
if (!defined('ROOT')) define('ROOT', "../taules/");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();   

if (!isset($_SESSION)) session_start(); 
if (!$gestor->valida_sessio(64))  
{
	header("Location: login.php");
	die();
}
$ar=scandir(ROOT.INC_FILE_PATH.'log');

foreach ($ar as $k=>$file) {
    $nomfile=$file." >>>    ".date("Y-m-d  >  H:i:s",filemtime(ROOT.INC_FILE_PATH.'log/'.$file));
    
    echo '<a target="_blank" href="'.READER_SCRIPT.ROOT.INC_FILE_PATH.'log/'.$file.'" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">'.$nomfile.'</a><br/>';    
}

?>

