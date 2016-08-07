<?php
/* * ******************************************************************************************************************* */
// SI VOLEM UN HANDLER D'ERRORS
//ini_set('error_reporting', 0);
ini_set('error_reporting', E_ALL ^ E_DEPRECATED);
//error_reporting(E_ALL ^ E_DEPRECATED);
//error_reporting(0);
//require_once("errorHandler.php"); // DEBUG, MOSTRAR ERRORS I NOTICES
/* * ******************************************************************************************************************* */

/*******************************************************************/
// IDENTIFICA SERVIDOR I CONFIGURA DADES DE CONNEXIO SEGONS EL CAS
/*******************************************************************/
defined('AMF') or define('AMF', 'false');

if (!isset($_SERVER['HTTP_HOST'])) $_SERVER['HTTP_HOST']="localhost";


switch ($_SERVER['HTTP_HOST'])
{
	case "127.0.0.1":
	case "cbdev-localhost":
	case "cbdev.localhost":
	case "localhost":
	case "frikie":
	case "alexinfopruna.dyndns.org":
	case "localhost/www.can-borrell.com":
		$nou=$prod=$dev=false;
		$local=true;
	break;
	
	case "dev.can-borrell.com":
		$nou=$prod=$local=false;
		$dev=true;
	break;

	case "dev2.can-borrell.com":
	case "nou.can-borrell.com":
		$nou=$prod=$dev=$local=false;
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
	defined('URL') or define("URL","http://cbdev-localhost/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "webap";
	$password_canborrell = "Alkaline10";
	$database=$database_canborrell = "canborrell_dev_local";
}
elseif (DEV)
{
	defined('URL') or define("URL","http://dev.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_dev_del";
}
elseif (PROD)
{
	defined('URL') or define("URL","http://www.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_del";
}
elseif (NOU)
{
	defined('URL') or define("URL","http://dev2.can-borrell.com/taules/");
	$host=$hostname_canborrell = "localhost";
	$username_canborrell = "can-borrell.com";
	$password_canborrell = "L9eHAS27GA";
	$database=$database_canborrell = "can-borrell_del";
	
}
/********************************************************/
// define DB_CONNECTION_FILE_DEL
defined('DB_CONNECTION_FILE_DEL') or define('DB_CONNECTION_FILE_DEL',"../Connections/DBConnection_del.php");
/********************************************************/

/********************************************************/
/********************************************************/
/********************************************************/
/********************************************************/
// Connecta!! ATENCIO CONNECT / PCONNECT
/********************************************************/
//$DBConn=$canborrell = ($GLOBALS["___mysqli_stonDEL"] = mysqli_connect($hostname_canborrell,  $username_canborrell,  $password_canborrell)) or trigger_error(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)),E_USER_ERROR); 
//((bool)mysqli_query($GLOBALS["___mysqli_stonDEL"], "USE " . $database_canborrell));

$DBConn = $canborrell = ($GLOBALS["___mysqli_stonDEL"] = mysqli_connect($hostname_canborrell,  $username_canborrell,  $password_canborrell, $database_canborrell)) or trigger_error(((is_object($GLOBALS["___mysqli_stonDEL"])) ? mysqli_error($GLOBALS["___mysqli_stonDEL"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)),E_USER_ERROR); 

/********************************************************/

/********************************************************/
// PREPARA CHARSET (LA COMPROVACIO AMF POTSER NO CAL...)
/********************************************************/
if (CHARSET=="UTF-8" && AMF!==true)
{
		@mysqli_query($GLOBALS["___mysqli_stonDEL"], 'SET NAMES UTF8');
		@mysqli_query($GLOBALS["___mysqli_stonDEL"], 'SET CHARACTER SET UTF8');
		@mysqli_query($GLOBALS["___mysqli_stonDEL"], 'SET COLLATION_CONNECTION=utf8_unicode_ci'); 
		mysqli_set_charset($canborrell,'utf8'); 
}

$query="SET GLOBAL time_zone=SYSTEM";
$r=mysqli_query($DBConn, $query);
?>
