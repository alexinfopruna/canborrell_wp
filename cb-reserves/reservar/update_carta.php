
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<?php
    if (!isset($_GET['confirm'])) {
      echo "<a href='?confirm=1'>Confirma importació</a><br><br><br>";
      echo "<a href='../panel/'>Cancel·la importació</a>";
     exit(); 
    }

	header('Content-Type: text/html; charset=utf-8');
	define("ROOT","../taules/");
	define("LOG_IMPORT","log/import.txt");
	
	require_once(ROOT."Gestor.php");
	class Reglog extends Gestor
	{
		public function __construct($db_connection_file=DB_CONNECTION_FILE,$usuari_minim=16) 	
		{
			parent::__construct($db_connection_file,$usuari_minim);
			
			$f=fopen(ROOT.INC_FILE_PATH.LOG_IMPORT,"w");
			fclose($f);
		}
		public function reg_log($txt)
		{
			//parent::greg_log($txt,ROOT.INC_FILE_PATH.LOG_IMPORT);
			parent::greg_log($txt,LOG_IMPORT);
		}
	}
	$reglog=new Reglog();
	
	$ruta_import=INC_FILE_PATH."import_carta/";
	$articulos="Articulos.csv";
	$subfamilias="SubFamilias.csv";
		
	
	include(ROOT.DB_CONNECTION_FILE);
	((bool)mysqli_query( $canborrell, "USE " . $database_canborrell));
	mysqli_query($GLOBALS["___mysqli_ston"], "SET CHARACTER SET 'utf-8'");
	mysqli_query($GLOBALS["___mysqli_ston"], "SET NAMES 'utf-8'");
	mysqli_query($GLOBALS["___mysqli_ston"], "SET COLLATION CONNECTION 'utf-8'");
	
	//import_carta($familias,"cart_subfamilia");
	//import_carta($articulos,"cart_subfamilia");
	
/*********************************************************************/
//IMPORTA SUB_FAMILIES	
	
	$table="carta_subfamilia";
	$file=$ruta_import.$subfamilias;

	$query="TRUNCATE $table";
	$r=mysqli_query($canborrell, $query);
	
	$f=fopen($file,"r");
	//die($file." * $f * ".file_exists($file));
	$k=0;
	echo "INICIEM IMPORTACIÓ DE SUBFAMÍLIES: ".$file."<br/><br/>";
	$last_mod = filemtime($file);
	$filedate=date("j/m/y h:i", $last_mod);

	$reglog->reg_log( "INICIEM IMPORTACIÓ DE SUBFAMÍLIES: ".$file."($filedate)<br/><br/>");
                            
	while (($l = fgetcsv($f, 1000, ";")) !== FALSE) {
		print_r($l);
		
		$id=$l[0];
		$fam=$l[1];
		
		$sc1=explode(" - ",$l[3]);
		//$c1_es=$sc1[0];
		//$c1_ca=$sc1[1];
		
		$c1_ca=!empty($l[2])?$l[2]:$l[3];
		$c1_es=$l[3];
		
		if (!$id) break;
		$k++;
		
		$query="INSERT INTO `carta_subfamilia` (`carta_subfamilia_id`, `carta_familia_id`, `carta_subfamilia_nom_ca`, `carta_subfamilia_nom_es`) VALUES ('$id', '$fam', '$c1_ca', '$c1_es')";
		
		
		echo "<br/>insertem a $table";
		$reglog->reg_log( "+insertem a $table");
		$r=mysqli_query($canborrell, $query);
	}
	fclose($f);
/*********************************************************************/
echo "<br/><br/>Finalitzada importació de subfamilies ($k registres)<br/>";	
echo "<br/><br/><br/><br/><br/><br/>";	
$reglog->reg_log( "<br/>Finalitzada importació de subfamilies ($k registres)<br/>");	
/*********************************************************************/
//IMPORTA ARTICLES	
	
	$table="carta_plats";
	$file=$ruta_import.$articulos;

	$query="TRUNCATE $table";
	$r=mysqli_query($canborrell, $query);

	$f=fopen($file,"r");
	$k=0;
	echo "INICIEM IMPORTACIÓ D'ARTICLES: ".$file."<br/><br/>";
	$reglog->reg_log( "INICIEM IMPORTACIÓ D'ARTICLES: ".$file);
	while (($l = fgetcsv($f, 1000, ";")) !== FALSE) {
		echo "<br/>insertem a $table -------- ";
		$reglog->reg_log( "insertem a $table -------- ");
$reglog->reg_log( $l[4]);
		
		print_r($l);
		
		$id=$l[0];
		$subfamilia=$l[1];
		$familia=$l[2];
		/*
		$subfamilia=$l[2];
		$familia=$l[1];
		*/
		//$nom_ca=!empty($l[3])?$l[3]:('<span style="color:red">__esp__</span>'.$l[4]);
		$nom_ca=!empty($l[3])?$l[3]:('__esp__'.$l[4]);
		$nom_ca=utf8_encode($l[3]);
		$nom_es=utf8_encode($l[4]);
		
		$preu=str_replace(",",".",$l[5]);
		
		$query="INSERT INTO  `carta_plats` (

			`carta_plats_id` ,
			`carta_plats_subfamilia_id` ,
			`carta_plats_familia_id` ,
			`carta_plats_nom_ca` ,
			`carta_plats_nom_es` ,
			`carta_plats_preu`
			)
			VALUES (
			'$id',  '$subfamilia',  '$familia',  '$nom_ca',  '$nom_es',  '$preu'
			)";
			
		if (!$id) break;
		$k++;
		$r=mysqli_query($canborrell, $query);
		echo "<br/><br/> -- $query <br/><br/>";
	}	
	fclose($f);
	echo "<br/><br/>Finalitzada importació d'articles ($k registres)<br/>";	
	$reglog->reg_log( "Finalitzada importació d'articles ($k registres)<br/>");	

?>