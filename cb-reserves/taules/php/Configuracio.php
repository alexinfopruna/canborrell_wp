<?php
if (!defined('CHARSET')) define('CHARSET', "UTF-8"); //PER DEFECTE
if (!defined('CONFIG')) define('CONFIG', "config.xml"); //PER DEFECTE
if (!defined('DB_CONNECTION_FILE')) define('DB_CONNECTION_FILE', "../Connections/DBConnection.php");

if (isset($_GET['test']))
{
	define('ROOT', '../');
	define('EOL', '<br/>');
	require_once(ROOT."php/xml2array.php");
	
	$lc = new Configuracio();
	$lc->test();
}
if (!defined('ROOT')) define('ROOT', ""); //PER DEFECTE
require_once(ROOT."php/xml2array.php");

/***********************************************************************************************************/
//
// LLEGEIX CONFIGURACIÓ DE FITXER XML i BBDD 
// 
// 
//
/***********************************************************************************************************/
class Configuracio
{
	public $configVars;
	
	private $config_file; //PER DEFECTE
	private $JS__defines;
	private $DB__defines;
	private $taulaConfig;

	public function __construct($config=CONFIG, $taula_config="config")
	{
		if (!isset($_SESSION)) session_start();
		$this->config_file = ROOT.$config;
		$this->taulaConfig=$taula_config;
		
		if (file_exists($this->config_file)) $this->parseXML($this->config_file);
		$this->parseDBConfig($this->taulaConfig);
	}
	
	/********************************************/
	private function parseXML($file)
	{
		$contents = file_get_contents($file);
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
				// DEFINE PER CONSTANT PHP
				$this->configVars[$key]=$val;
				if ($config[$key."_attr"]["define"] && !defined($key)) 
				{
					define($key, $val);
				}
				
				// DEFINE PER JAVASCRIPT
				if ($config[$key."_attr"]["define_JS"]) $this->JS__defines[$key] = $val;
				
				// DEFINE VARIABLES DE SESSIO
				if(isset($config[$key."_attr"]["session"]))
					if ($config[$key."_attr"]["session"])	$_SESSION[$key]=$val;
			}
		}
	}

	private function parseDBConfig($taula)
	{
		require(ROOT.DB_CONNECTION_FILE);

		$query = "SELECT * FROM ".$taula;
		$r = mysqli_query( $GLOBALS["___mysqli_ston"], $query);
		$array=array();
		if (!mysqli_num_rows($r)) return false;
		else
		{
			while ($row = mysqli_fetch_array($r))
			{		
					// DEFINE PER CONSTANT PHP
					if ($row['config_define']) 
					{
						if ($row['config_array_index']!=NULL)
						{
							$query = "SELECT * FROM ".$taula."
							WHERE config_var = '".$row['config_var']."'
							ORDER BY config_array_index";
							
							
							$ar_r = mysqli_query( $DBConn, $query);
							
							while ($ar_row = mysqli_fetch_array($ar_r))
							{	
								if ($ar_row['config_val']==="true" || $ar_row['config_val']==="TRUE") $ar_row['config_val']=true;
								elseif ($ar_row['config_val']==="false" || $ar_row['config_val']==="FALSE") $ar_row['config_val']=false;
								
								$index=$ar_row['config_array_index']; // ;Mira si l'index és numeric o alfa
								if (!is_numeric($index)) $index="'$index'";
								
								$array[$index]=$ar_row['config_val'];
							}
							$row['config_val']=serialize($array);
						}
						$defineeed = null;
						if ($row['config_val']==="true" || $row['config_val']==="TRUE") $row['config_val']=true;
						elseif ($row['config_val']==="false" || $row['config_val']==="FALSE") $row['config_val']=false;

						$this->configVars[$row['config_var']]=$row['config_val'];
						$val=$row['config_val'];
						if ($val==="true" || $val==="TRUE") $val=true;
						elseif ($val==="false" || $val==="FALSE") $val=false;
						
						if (!defined($row['config_var'])) 
						{
							define($row['config_var'], $val);
						}
						else $defineeed="IGNORAT (definit A XML!!!!!) --- ";
					
						$this->DB__defines[$defineeed.$row['config_var']] = $val;
					}
					
					// DEFINE PER JAVASCRIPT
					if ($row['config_js']) 
					{
						$defineeed = null;
						if (!isset($this->JS__defines[$row['config_var']])) $this->JS__defines[$row['config_var']] = $row['config_val'];
						else $defineeed="IGNORAT (definit A XML!!!!!) --- ";
					
						$this->DB__defines[$defineeed.$row['config_var']] = $row['config_val'];
					}
					// DEFINE PER SESSION
					if ($row['config_session']) 
					{
						$defineeed = null;
						if (!isset($_SESSION[$row['config_var']])) $_SESSION[$row['config_var']] = $row['config_val'];
						else $defineeed="IGNORAT (definit A XML!!!!!) --- ";
					
						$this->DB__defines[$defineeed.$row['config_var']] = $row['config_val'];
					}
			}
		}
	}
	
	public function dumpJSVars($tag=false)
	{
		$out="";
                                                        if ($tag) $out="<script>\n";
		$out.="/*******************************/\n/****** dumpJSDefines **********/\n\n";
		foreach($this->JS__defines as $k=>$v)
		{
			if (substr($k,0,4)=="AR__")
			{
				$out.= "var $k=new Array();\n";
				$arr=unserialize($v);
				$index=0;
				foreach($arr as $kv=>$vv)
				{
					//if (!is_numeric($kv)) $kv='"'.$kv.'"';
					if ($vv===true) $vv="true";
					if ($vv===false) $vv="false";
					$out.= $k."[$kv]"."=$vv;\n";
					$index++;
				}
			}
			else 
			{
				
				if (is_numeric($v)) $out.= $k.'='.$v.';'."\n";
				elseif (is_bool($v)) $out.= $k.'='.($v?"true":"false").';'."\n";
				else $out.= $k.'="'.$v.'";'."\n";
			}
		}
		
		$out.="\n/****** dumpJSDefines **********/\n/*******************************/\n";
		if ($tag) $out.="</script>\n";
		
		return $out;
	}
	
	
	public function updateVar($k, $v, $desc=null, $define=null, $js=null, $sess=null)
	{	
		if ($desc) $fdesc = ", config_descripcio = '$desc' ";
		if ($define) $fdefine = ", config_define = '$define' ";
		if ($js) $fjs = ", config_js = '$desc'";
		if ($sess) $fsess = ", config_session = '$sess'";
		
		$query = "UPDATE config SET config_val='$v' $fdesc $fdefine $fjs $fsess WHERE config_var='$k'";

		require(ROOT.DB_CONNECTION_FILE);
		return mysqli_query( $DBConn, $query);

		
	}
	
	public function test()
	{
		echo "<b>LLEGINT CONFIG DE ".$this->config_file.EOL.EOL."</b>";
		$constants = get_defined_constants();
		
		echo EOL.EOL.EOL;
		echo "<b>DUMP JS VARS</b>".EOL;
		echo $this->dumpJSVars();

		echo EOL.EOL.EOL;
		echo "<b>PHP DEFINE</b>".EOL;
		foreach ($constants as $k => $v)
		{
			if ($ok) echo "$k = $v".EOL;
			if ($k=='SID') $ok=true;
		}
		
		echo EOL.EOL.EOL;
		echo "<b>JS DEFINE</b>".EOL;
		foreach ($this->JS__defines as $k => $v)
		{
			echo "$k = $v".EOL;
		}
		
		echo EOL.EOL.EOL;
		echo "<b>DATABASE DEFINE</b>".EOL;
		foreach ($this->DB__defines as $k => $v)
		{
			echo "$k = "; 
			print_r($v);
			echo EOL;
		}
		
		echo EOL.EOL.EOL;
		echo "<b>SESSION DEFINE</b>".EOL;
		foreach ($_SESSION as $k => $v)
		{
			echo "$k = "; 
			print_r($v);
			echo EOL;
		}		
	}
}
?>