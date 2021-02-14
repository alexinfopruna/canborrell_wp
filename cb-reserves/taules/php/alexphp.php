<?php
/*
Classe alaxphp v:2.0.0
26/9/2009
Funcions generals PHP 
Àlex Garcia
www.infopruna.net




	Classe alexphp funcionant!
	
	constructor: 	
	function alexphp(\$e_error) // \$e_error="info" >> mostra info;
	
	funcions:
	function normalitzar(\$cadena)
	function get_extension (\$ruta){
 	function pujar_arxiu(\$arxiu, \$desti_arxiu, \$carpeta_pare = ARREL)
	function esborrar_arxiu(\$ruta_arxiu, \$carpeta_pare = ARREL)
	function generaXML(\$arrDades, \$atributs_arrel = "")
	function enviaXML(\$valor)
	function registrarlog(\$text, \$modo = 1)
	function escriuLog(\$txt,\$k,\$file)
	function mostrarLink(\$url, \$titulo = "")
	function filtre_file(\$file,\$filtre)
	function scan_Dir(\$dir,\$filtre=false,\$recurse=false,\$full_nom=false,\$echo=false) {
	function flash(\$file,\$width=false,\$height=false,\$ver='6,0,29')
	function mostra_imatge(\$file,\$w=false,\$h=false)
	function mostra_imatge(\$file,\$w=false,\$h=false)
	function cambiaf_a_normal(\$fecha)
	function cambiaf_a_mysql(\$fecha)
	function fitxer_idioma(\$fitxer,\$lang='cat')
 	function nom_thumb($fitxer)
	function getpost_ifset($test_vars) 
	function getpost2globals()
			
*/

class alexphp
{


	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	// Idiomes
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	
	
	/////////////////////////////////////////////////////////////////////////	
	///////////////     CONSTRUCTOR          ////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function alexphp($e_error=E_ERROR)
	{
		define('SOL',"\n"); // inicia linea
		define('EOL',"\r\n"); // fi linea: "\n",  WIN => "\r\n",  MAC => "\r"
		define('TAB',"\t");
		define('BR',"<br/>");

		define('BYTES_x_KB', 1024);
		define('BYTES_x_MB', 1048576);

		define('NIVELL_ADMINISTRADOR',200);
		define('NIVELL_USUARI',100);
		define('NIVELL_ANONIM',0);
		define('ARREL','/');

		//define('ENCODE','ISO-8859-1'); 
		define('ENCODE','utf-8');
	
		//echo $this->$extensio_lang['cs'];
		// MOSTRA INFO
		if (!strcmp($e_error,"info")) 
		{
			$this->info();
			$e_error=E_ALL;			
		}
		
		$a=$b;
		
				
	}
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function normalitzar($cadena)
	{
		$cadena 	= stripslashes($cadena);
		$cadena 	= strtolower($cadena);
		$cercar 	= array('à','á','è','é','í','ò','ó','ú','ç','ñ');
		$sustituir 	= array('a','a','e','e','i','o','o','u','c','n');
		$cadena 	= str_replace($cercar, $sustituir, $cadena);
		$cadena 	= preg_replace('/[^a-z0-9\.\(\)]+/', '_', $cadena);

		return $cadena;
	}

	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	
	function get_extension ($ruta){
		$return = false;
		clearstatcache();
		if (file_exists($ruta)){
			$path_parts = pathinfo($ruta);
			$return = $path_parts['extension'];
		} else {

			$message = "El archivo $ruta no existe";

			enhancedRegistrarLog($message);

		}

		return $return;
		
		/////////////// Manera meva i cutre...
		/*
		$tipus=explode('.',$ruta);
		  end($tipus);
		  $tip=pos($tipus);
		  return $tip;
		*/

}
	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function pujar_arxiu($arxiu, $desti_arxiu, $carpeta_pare = ARREL)
	{
		// echo    $ubicacio_arxiu = $carpeta_pare . $desti_arxiu;
		if (existeix($arxiu['tmp_name']))
		{
			$temporal_arxiu = $arxiu['tmp_name'];
			$ubicacio_arxiu = $carpeta_pare . $desti_arxiu;
			if (!move_uploaded_file($temporal_arxiu, $ubicacio_arxiu))
			{
				enviar_error("No se ha podido mover el archivo a $ubicacio_arxiu", "upload mover");
				registrarlog("No s'ha pogut moure l'arxiu a $ubicacio_arxiu");
				return false;
			}
			chmod($ubicacio_arxiu, 0664);
		}
		else
		{
			enviar_error("El archivo no ha subido correctamente", "upload");
			registrarlog("L'arxiu no ha pujat correctament!");
			return false;
		}
		registrarlog("archivo $ubicacio_arxiu subido");
		return true;
	}
	
	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	
	function esborrar_arxiu($ruta_arxiu, $carpeta_pare = ARREL)
	{
		return @unlink($carpeta_pare . $ruta_arxiu);
	}
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function enviar_error($text, $params = "")

	{

		enhancedRegistrarlog("$params: $text", 1);

		$estat = "error";

		if (!empty($params)) $estat .= " $params";

		if ($text!=stripslashes($text)) {$text=cdata($text);}

		enviar_resposta(generaXML(array("texto" => $text), "estado='$estat'"));

		exit();

	}

	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function arr2XML($arr)

	{

		if (!is_array($arr)) return false;



		$arrXML = array();

		//foreach($arr as $nom=>$valor) array_push($arrXML, TAB."<$nom>".utf8_encode($valor)."</$nom>");

		foreach($arr as $nom=>$valor)

		{
			if ($valor!=stripslashes($valor)) {$valor=cdata($valor);}
			if (is_numeric($nom)) 
			{
				$node="item";
				$nodeatribut="id='$nom'";
			}
			else
			{
				$node=$nom;
				$nodeatribut="";			
			}
			array_push($arrXML, TAB."<$node $nodeatribut>$valor</$node>");

		}

		return  implode(EOL,$arrXML);

	}
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function generaXML($arrDades, $atributs_arrel = "")
	{
		session_start();
		$sessid = session_id();
		$cadenaXML = $this->arr2XML($arrDades);
		$xmlDoc = <<<EOT
<?phpxml version="1.0" encoding="utf-8" ?>
	  <resultado $atributs_arrel sessid='$sessid'>
	  $cadenaXML
	</resultado>
EOT;
	
	 return $xmlDoc;
	}
	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function enviaXML($valor)
	{
		header('Content-Type: text/xml; charset=UTF-8');
		echo stripslashes($valor);
	}
		
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////		
	function registrarlog($text)
	{
		$text = date('Y-m-d H:i:s') . ": $text";
		$text.= SOL . print_r($_REQUEST, true) . EOL;
		error_log(SOL.$text."\r\n",3,ARREL."/errors.txt");
	}
	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function escriuLog($txt,$k,$file)
	{
		$f=fopen($file,"a");
		fwrite($f,$txt);
		fclose($f);
	}
		
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	

	function mostrarLink($url, $titulo = "")
	{
		$httpurl=$url;
		if ((substr($url,0,4)!="http")&&(!empty($url))&&($url!="")) $httpurl="http://".$url;
		return "<a href='$httpurl' target='_blank'>" . ($titulo ? $titulo : $url) . "</a>";
	}
	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function filtre_file($file,$filtre)
	{
	  if ((!isset($filtre))||(empty($filtre))||(!$filtre)) return true;


	  $tipus=explode(';',$filtre);
		$ast=array_search('*',$tipus);
		$dr=is_Dir($file);
	  if ($ast && $dr)
		return true; 
	  
	  $ok=false;
	  foreach ($tipus as $key => $val)
	  {
					  
		$ok=($ok || (!strcmp(extensio_file($file),$val)));
	  }

	  return $ok;		
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	// Retorna un array amb elements del directori. Si recurse=true inclou subdirs. Si full_nom=true fa tot el path.
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	function scan_Dir($dir,$filtre=false,$recurse=false,$full_nom=false,$echo=false) {
	  $arrfiles = array();
	  
	  $onsom=getcwd();
	  if (is_dir($dir)) {
		  if ($handle = opendir($dir)) {
			  chdir($dir);
			  while (false !== ($file = readdir($handle))) {
				  if ($file != "." && $file != "..") {
					  if (is_dir($file)&&$recurse) {
						  $arr = scan_Dir($file,$filtre,$recurse,$full_nom);
						  foreach ($arr as $value) {
							  if ($full_nom) $arrfiles[] = $p=$dir."/".$value;
							  else $arrfiles[] = $p=$value;
							  
							  if ($echo) echo "> ".$p." <br/>";
							  
						  }
					  } else {
							  if ($this->filtre_file($file,$filtre))
								{
									//$arrfiles[] = $dir."/".$file;						
									if (!(is_dir($file))||($recurse)) {
										if ($full_nom) $arrfiles[] =$p= $dir."/".$file;
										else $arrfiles[] = $p=$file;   
										
										if ($echo) echo "> ".$p." <br/>";
											
									}
								}           
							  }
				  }
			  }
			  chdir("../");
		  }
		  closedir($handle);
	  }
	  chdir($onsom);
	  return $arrfiles;
	}

	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	// Genera el codi per presentar flash. 
	// Si no passem les mides s'adapta al 100% de la quadrícula
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	 function flash($file,$width=false,$height=false,$ver='9,0,0')
	 {
		if (!(is_file($file))) return; 
		 
		$mida=getimagesize($file); 
		if (!$width) $width=$mida[0];
		if (!$height) $height=$mida[1];
		 
		if ($width) $mida=' width="'.$width.'" ';
		if ($height) $mida.=' height="'.$height.'" ';
		
		$codi= '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version='.$ver.',0"'.$mida.'>';
		$codi.= '<param name="movie" value="'.$file.'">';
		$codi.= '<param name="quality" value="high">';
		$codi.= '<embed src="'.$file.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" ></embed></object>';

		return $codi;
	 }
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77
	//  treu una imatge 
	//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////77 
	 function mostra_imatge($file,$w=false,$h=false)
	{
		$mida=getimagesize($file); 
		if (!$w) $w=$mida[0];
		if (!$h) $h=$mida[1];

		
		if (filtre_file($file,'gif;jpg;jpeg'))
		{
		 echo '<img src="'.$file.'" border="0" width="'.$w.'" height="'.$h.'">';   
		}
		if (filtre_file($file,'swf')) 
		{
		  echo flash($file);
		}
	 } 

	//////////////////////////////////////////////////// 
	//Convierte fecha de mysql a normal 
	//////////////////////////////////////////////////// 
	function cambiaf_a_normal($fecha)	{ 
		preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha); 
		$lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1]; 
		return $lafecha; 
	} 

	//////////////////////////////////////////////////// 
	//Convierte fecha de normal a mysql 
	//////////////////////////////////////////////////// 

	function cambiaf_a_mysql($fecha){ 
		preg_match( "/([0-9]{1,2})/([0-9]{1,2})/([0-9]{2,4})/", $fecha, $mifecha); 
		$lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1]; 
		return $lafecha; 
	} 

	//////////////////////////////////////////////////// 
	// retorna el fitxer adequat que acaba amb _lang
	// si no retorna el mateix que li passo
	//////////////////////////////////////////////////// 


	function fitxer_idioma($fitxer,$lang='cat')
	{
		$file=pathinfo($fitxer);
		$path=$file['dirname'].'/';
		$arr=explode('.',$file['basename']);
		$nom=$arr[0];//echo 'nom-'.$nom;
		$p=strrpos($nom,'_');
		$base=substr($nom,0,$p);
		$idioma=substr($nom,$p);
		$ext=$file['extension'];//echo 'ext-'.$ext."<br>";
		$f_idioma=$path.$base."_".$lang.".".$ext;
		//echo $f_idioma."-->";
		if (is_file($f_idioma)) return ($f_idioma);
		$f_idioma=$path.$base.".".$ext;
	   
		if (is_file($f_idioma)) return ($f_idioma);
		
		return($fitxer);
	}

	//////////////////////////////////////////////////// 
	// GENERA UN NOM PER UN FITXER DE FOTO PETITA
	// donat un fitxer path/file.ext
	// retorn path/file"_peque".ext
	//////////////////////////////////////////////////// 

	function nom_thumb($fitxer)
	{
		$file=pathinfo($fitxer);
		$path=$file['dirname'].'/';
		$arr=explode('.',$file['basename']);
		$nom=$arr[0];//echo 'nom-'.$nom;
		$p=strrpos($nom,'_');
		$base=substr($nom,0,$p);
		$idioma=substr($nom,$p);
		$ext=$file['extension'];//echo 'ext-'.$ext."<br>";
		$f_idioma=$path.$base."_thumb.".$ext;
		return($f_idioma);

	}


	//////////////////////////////////////////////////// /////////////////
	// Retorna l'string corresponent a un idioma
	//////////////////////////////////////////////////////////////////////

	function extensioLang($idioma)
	{
		$extensio_lang=array('_cs','_ct','_gl','_eu','_en','_fr','_it','_po','_ar','cs'=>'_cs','ct'=>'_ct','gl'=>'_gl','eu'=>'_eu','en'=>'_en','fr'=>'_fr','it'=>'_it','po'=>'_po','ar'=>'_ar');

		return $extensio_lang[$idioma];
	
	}
	//////////////////////////////////////////////////// /////////////////
	// Fa globals les variables amb valor passades com a GET o  POST
	//////////////////////////////////////////////////////////////////////

	function getpost_ifset($test_vars)
	{
		if (!is_array($test_vars)) {
			$test_vars = array($test_vars);
		}
		foreach($test_vars as $test_var) {
			if (isset($_POST[$test_var])) {
				global $$test_var;
				$$test_var = $_POST[$test_var];
			} elseif (isset($_GET[$test_var])) {
				global $$test_var;
				$$test_var = $_GET[$test_var];
			}
	   }
	}

	//////////////////////////////////////////////////// /////////////////
	// Fa globals les variables amb valor passades com a GET o  POST
	//////////////////////////////////////////////////////////////////////

	function getpost2globals()
	{
		foreach ($_REQUEST as $key => $value) 
		{
			global $$key;
			$$key = $_REQUEST[$key];	
		}
		
		
		/*
		OTRA MANERA
		
		foreach ($_GET as $key => $value) 
		{
			global $$key;
			$$key = $_GET[$key];	
		}
		foreach ($_POST as $key => $value) 
		{
			global $$key;
			$$key = $_POST[$key];	
		}
	*/
		}

	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	

	function info()
	{

		$info=<<< INFO
Classe alaxphp v:2.0.0
26/9/2009
Funcions generals PHP 
Àlex Garcia
www.infopruna.net
		
		CONSTRUCTOR: 	
		function alexphp(\$e_error) // \$e_error="info" >> mostra info;
		
		FUNCIONS:
		function normalitzar(\$cadena)
		function get_extension (\$ruta){
		function pujar_arxiu(\$arxiu, \$desti_arxiu, \$carpeta_pare = ARREL)
		function esborrar_arxiu(\$ruta_arxiu, \$carpeta_pare = ARREL)
		function generaXML(\$arrDades, \$atributs_arrel = "")
		function enviaXML(\$valor)
		function registrarlog(\$text, \$modo = 1)
		function escriuLog(\$txt,\$k,\$file)
		function mostrarLink(\$url, \$titulo = "")
		function filtre_file(\$file,\$filtre)
		function scan_Dir(\$dir,\$filtre=false,\$recurse=false,\$full_nom=false,\$echo=false) {
		function flash(\$file,\$width=false,\$height=false,\$ver='6,0,29')
		function mostra_imatge(\$file,\$w=false,\$h=false)
		function cambiaf_a_normal(\$fecha)
		function cambiaf_a_mysql(\$fecha)
		function fitxer_idioma(\$fitxer,\$lang='cat')
		function nom_thumb(\$fitxer)
		function getpost_ifset(\$test_vars) // REPASSAR
		function getpost2globals()
			
INFO;
		echo nl2br($info);
	
	}
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	function test()
	{
		echo $ga;
	}

	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	/////////////////////////////////////////////////////////////////////////	
	


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}


	/*
	See also htmlspecialchars(), htmlentities(), html_entity_decode, wordwrap(), and str_replace(). 
	
	ENVIAR ERROR XML

	*/

} // Class
 ?>
