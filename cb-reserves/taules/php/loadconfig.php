<?php
if (!isset($_SESSION)) session_start();

if (!defined(ROOT)) define(ROOT, "");
require(ROOT."php/xml2array.php");


//if (isset($_SESSION['config'])) $config_file=$_SESSION['config'];
//if (!isset($config_file)) $config_file = "config.xml";

$config_file = "config.xml";


if (defined('CONFIG')) $config_file = CONFIG;

$config_file=ROOT.$config_file;


$contents = file_get_contents($config_file);
$result = xml2array($contents);
$config=$result["config"];

foreach ($config as $key => $val)
{
	if (substr($key, -5) == "_attr") continue;
	if ($val==="true" || $val==="TRUE") $val=true;
	elseif ($val==="false" || $val==="FALSE") $val=false;
	if (isset($config[$key."_attr"]))
	{	
		// SI ES ARRAY
		if (is_array($val)) 
		{
			foreach ($val as $k => $v)
			{
				$array[]=$v;
			}
			
			 $val=serialize($array);
		}
		//echo $key." *** ".($val)."<br/>";
		if ($config[$key."_attr"]["define"] && !defined($key)) define($key,$val);
		if ($config[$key."_attr"]["define_JS"]) $JS__defines[$key]=$val;
		if(isset($config[$key."_attr"]["session"]))
			if ($config[$key."_attr"]["session"])	$_SESSION[$key]=$val;
	}
//echo $_SESSION['config'];print_r($config);die();
}
?>