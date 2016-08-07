<?php
/* * ********************************************************************************************************************/
// SI VOLEM UN HANDLER D'ERRORS
//require_once("errorHandler.php"); // DEBUG, MOSTRAR ERRORS I NOTICES

if (defined('MOSTRA_ERRORS') && MOSTRA_ERRORS == FALSE){
ini_set('error_reporting', 0);
error_reporting(0);
ini_set("display_errors", 0);
ini_set("track_errors", 0);
ini_set("html_errors", 0);
}
/* ERRORS ON
set_error_handler("var_dump");
ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
error_reporting(E_ALL ^ E_DEPRECATED);
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
// */

/**********************************************************************************************************************/
/*******************************************************************/
// IDENTIFICA SERVIDOR I CONFIGURA DADES DE CONNEXIO SEGONS EL CAS
/*******************************************************************/
defined('AMF') or define('AMF', 'false');

if (!isset($_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST']="localhost";

//echo $_SERVER['HTTP_HOST'];die();
switch ($_SERVER['HTTP_HOST'])
{
	case "127.0.0.1":
	case "cbdev-localhost":
	case "cbdev.localhost":
	case "localhost":
	case "frikie":
	case "alexinfopruna.dyndns.org":
	case "localhost/www.can-borrell.com":
	case "cbwp-localhost":
		$nou=$prod=$dev=false;
		$local=true;
	break;
	
	case "dev.can-borrell.com":
		$nou=$prod=$local=false;
		$dev=true;
	break;
	
	//case "nou.can-borrell.com":
	case "dev2.can-borrell.com":
		$prod=$dev=$local=false;
		$nou=true;
	break;	
	
	default:
		$nou=$dev=$local=false;
		$prod=true;
	break;
}
defined('DEV') or define('DEV', $dev);
defined('LOCAL') or define('LOCAL',$local);
defined('PROD') or define('PROD',$prod);
defined('NOU') or define('NOU',$nou);

//echo "----------------111111111111111111111111111111111---------------";
/********************************************************/
// Configura dades de connexi� depenent del servidor
/********************************************************/
if (LOCAL)
{
	defined('URL') or define("URL","http://cbwp-localhost/cb-reserves/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "webap";
	$password_canborrell = "Alkaline10";
	$database=$database_canborrell = "canborrell_wp_reserves";
}
elseif (DEV)
{
	defined('URL') or define("URL","http://dev.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_dev";
}
elseif (PROD)
{
/*
	defined('URL') or define("URL","http://www.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "00347";
	$password_canborrell = "5259";
	$database=$database_canborrell = "canborrell";
*/
	defined('URL') or define("URL","http://www.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell";
                            
}
elseif (NOU)
{
	defined('URL') or define("URL","http://dev2.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell";
	
}
/********************************************************/
// define DB_CONNECTION_FILE_DEL
defined('DB_CONNECTION_FILE_DEL') or define('DB_CONNECTION_FILE_DEL',"../Connections/DBConnection_del.php");
/********************************************************/

/********************************************************/
/********************************************************/
/********************************************************/
/********************************************************/
// Connecta!!
/********************************************************/
//$DBConn=$canborrell = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname_canborrell,  $username_canborrell,  $password_canborrell)) or trigger_error(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)),E_USER_ERROR); 
$DBConn = $canborrell = ($GLOBALS["___mysqli_ston"] = mysqli_connect($hostname_canborrell,  $username_canborrell,  $password_canborrell, $database_canborrell)) or trigger_error(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)),E_USER_ERROR); 
//((bool)mysqli_query($GLOBALS["___mysqli_ston"], "USE " . $database_canborrell));
/********************************************************/
/********************************************************/
// PREPARA CHARSET (LA COMPROVACIO AMF POTSER NO CAL...)
/********************************************************/
if (CHARSET=="UTF-8" && AMF!==true)
{
		@mysqli_query($GLOBALS["___mysqli_ston"], 'SET NAMES UTF8');
		@mysqli_query($GLOBALS["___mysqli_ston"], 'SET CHARACTER SET UTF8');
		@mysqli_query($GLOBALS["___mysqli_ston"], 'SET COLLATION_CONNECTION=utf8_unicode_ci'); 
		//mysqli_set_charset('utf8',$canborrell); 
		mysqli_set_charset($canborrell,'utf8'); 
}
?>
