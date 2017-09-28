<?php 

define('ROOT',"../taules/");
require_once (ROOT."Gestor.php");

//define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra_online.txt");
define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
//define("LLISTA_NITS_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra_online.txt");
define("LLISTA_NITS_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");


define('USR_FORM_WEB',3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

$ruta_lang="../";
/**/
// ERROR HANDLER
//require_once("../taules/php/error_handler.php");

// CREA USUARI ANONIM
if (!isset($_SESSION)) session_start();
$usr=new Usuari(USR_FORM_WEB,"webForm",1);
if (!isset($_SESSION['uSer'])) $_SESSION['uSer']=$usr;

require_once("Gestor_form.php");
$gestor=new Gestor_form();
require_once(ROOT . INC_FILE_PATH.'alex.inc');
require_once(ROOT . INC_FILE_PATH."llista_dies_taules.php");

/**/




//RECUPERA IDIOMA
$lang=$gestor->idioma($_REQUEST["lang"]);
$l=$gestor->lng;


//RECUPERA CONIG ANTIC
$PERSONES_GRUP=$gestor->configVars("persones_grup");
define("PERSONES_GRUP",$PERSONES_GRUP);
$max_nens=$gestor->configVars("max_nens");
$max_juniors=$gestor->configVars("max_juniors");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"	"//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML>
<HEAD>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<TITLE> Masia Can Borrell </TITLE>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- this goes into the <head> tag ALEX ESTILS! -->
<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.forms.css" rel="stylesheet" />	
<link type="text/css" href="css/jquery.tooltip.css" rel="stylesheet" />	
<!--<link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	-->
<!--   
<link type="text/css" href="css/custom-theme/jquery.ui.all.css" rel="stylesheet" />
-->

<link type="text/css" href="../css/estils.css" rel="stylesheet" />	
<link type="text/css" href="css/form_reserves.css" rel="stylesheet" />		
	

<noscript><meta http-equiv="refresh" content="0; nojscript.html"/></noscript>

               <?php echo Gestor::loadJQuery("2.0.3"); ?>
		<script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
		<script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-es.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.metadata.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.validate.pack.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.timers.js"></script>
		<script type="text/javascript" src="../taules/js/jquery.form.js"></script>
		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/json2.js"></script>
		<!-- ANULAT dynmenu.js -->
		<script type="text/javascript" src="js/jquery.amaga.js"></script>
		<script type="text/javascript" src="js/jquery.tooltip.js"></script>
<!--[if lt IE 7]>
     <script src="http://ie7-js.googlecode.com/svn/version/2.0(beta3)/IE7.js" type="text/javascript"></script>
<![endif]-->		
<!--
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
!
-->
<?php
require_once('translate_'.$gestor->lng.'.php');

/*********************************************************/
	
$EDITA_RESERVA=NULL;
	
echo $gestor->dumpJSVars(true);	
?>

<script type="text/javascript">
	var PERSONES_GRUP=<?php echo $PERSONES_GRUP;?>;
	var lang="<?php echo $lang;?>";
	<?php 
	//TRANSLATES

	$llista_negra=llegir_dies(LLISTA_DIES_NEGRA);
	print crea_llista_js($llista_negra,"LLISTA_NEGRA"); 
	print "\n\n";	
	
	$llista_blanca=llegir_dies(LLISTA_DIES_BLANCA);
	print crea_llista_js($llista_blanca,"LLISTA_BLANCA");  	
	
	$llista_dies_no_carta=llegir_dies(ROOT . INC_FILE_PATH."llista_dies_no_carta.txt");
	print crea_llista_js($llista_dies_no_carta,"LLISTA_DIES_NO_CARTA");  	
	
	print "\nvar IDR='".$row['id_reserva']."';";
	print "var RDATA;";
	if (!empty($row['data'])) print "\nRDATA='".$gestor->cambiaf_a_normal($row['data'])."';";
	print "\nvar HORA='".$row['hora']."';";
	?>	
</script>

		<script type="text/javascript" src="js/form_reserves.js?<?php echo time();?>";></script>

</HEAD>
<BODY class="amagat <?php echo DEV?" dev ":""; echo LOCAL?" local ":"" ?>" >



<?php
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
			parent::greg_log($txt,ROOT.INC_FILE_PATH.LOG_IMPORT);
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
		$c1_es=$sc1[0];
		$c1_ca=$sc1[1];
		
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
	}	
	fclose($f);
	echo "<br/><br/>Finalitzada importació d'articles ($k registres)<br/>";	
	$reglog->reg_log( "Finalitzada importació d'articles ($k registres)<br/>");	

?>	
<a id="carta">carta</a>
<h1>
ACTIVA O DESACTIVA ELS PLATS DE LA CARTA
</h1>
'1' per activar
<div id="fr-carta-tabs" >
	<?php echo $gestor->editorCarta(0)?>
</div>	

</body>
</html>	