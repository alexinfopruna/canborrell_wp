<?php 
header('Content-Type: text/html; charset=UTF-8');
header('Set-Cookie: fileDownload=true');

//define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
//define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
require_once("Gestor.php");
define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
 

require_once("gestor_reserves.php");
$gestor=new gestor_reserves();  



//echo "VALIDEM...";

if (!$gestor->valida_sessio())  header("Location: index.php");

//die("...Print OK...");
$torn[1]=" - Dinar Torn 1";
$torn[2]=" - Dinar Torn 2";
$torn[3]=" - Sopar";


	//$periode="AQUEST TORN";
	$periode="DIA_TORN";
	$imprimir="false";
	$menu="display:block";

if (isset($_REQUEST['p']))
{
	$periode=$_REQUEST['p'];
	$imprimir="true";
	$menu="display:none";
}
$filename="print/print.png";
$last_modify=filemtime($filename);
$delay=time()-filemtime($filename);

if (isset($_GET['drop']))
{

	header('Cache-Control: max-age=60, must-revalidate');
	header('Content-Disposition: attachment; filename="llistat_reserves_'.date("d-m-y_H:i:s").'.html"');
	$filename='llistat_reserves_'.date("d-m-y_H").'.png';
}
elseif(isset($_GET['download']))
{
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Content-Transfer-Encoding: binary");

	header('Content-Disposition: attachment; filename="llistat_reserves_'.date("d-m-y_H:i:s").'.html"');
	header("Content-type: application/force-download");
	$filename='llistat_reserves_'.date("d-m-y_H").'.png';
}


if (!isset($_REQUEST['p'])) 
{
	if ($delay>=5) 
	{
		echo "La imatge per imprimir no s'ha generat correctament. Torna-ho a intentar<br/><a href='javascript:history.back();' >Torna</a>";
		die();
	}
	else echo "Imatge generada: ".date("d/m/Y H:i:s",$last_modify);
	

}

echo '<span style="font-size:9px"> Imatge generada: '.date("d/m/Y H:i:s",$last_modify).'</span>';
if (isset($_GET['img']))
{
	$size = @getimagesize($filename);
	$fp = @fopen($filename, "rb");
	if ($size && $fp)
	{
		header('Set-Cookie: fileDownload=true');
		header('Cache-Control: max-age=60, must-revalidate');
		header('Content-Disposition: attachment; filename="llistat_reserves_'.date("d-m-y_H").'.png"');

		header("Content-type: {$size['mime']}");
		header("Content-Length: " . filesize($filename));
		//header("Content-Disposition: attachment; filename=$filename");
		header('Content-Transfer-Encoding: binary');
		//header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		fpassthru($fp);
		exit;
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>MenjadorEditor</title>
<link type="text/css" href="css/print.css" rel="stylesheet" />			
		<script type="text/javascript" src="js/jquery-1.5.min.js"></script>
<script>
$(function(){
		
			var imprimir=<?php echo $imprimir; ?>;	
			$("#img_menjador img").attr("src","<?php echo $filename; ?>?"+Math.random());
			if (imprimir)
			{
				window.setTimeout(function() {	window.print();},1700);
			}	
		

});

</script>

<style>
h1{margin:0;font-size:1.1em;font-weight:bold;}
h2{text-align:center;margin:0;}
h3{margin:0;}
h5{background:red;width:750px;text-align:center;margin-bottom:10px;color:white;font-size:1.1em;}
#containerA4{width:750px;}

#llista_reserves{margin-top:50px;clear:both;}

#reserva
{
width:750px;border:#eeeeee solid 2px;marginn:3px;padding:5px;
}

table
{
	width:750px;	
	border:#444 solid 3px;
}

td
{
	padding:5px;	
	border:#666 solid 1px;
	text-align:center;
}
.esquerre{float:left;width:550px}

.id{font-size:12px;}
.pageBreak {page-break-before: always}
.conflicte{background:red;color:white;font-weight:bold;margin-left:30px;}
.print-taula{color:red;font-weight:bold;font-size:1.1em;}

#menu a{text-decoration:none;color:white;font-weight:bold}
#menu li{float:left;margin-left:10px;list-style-type: none;}
#menu li a:link,#menu li a:visited{padding:10px;background:#000;}
#menu li a:hover{background:#000;}

#reserva a{color:#444;margin-right:12px;}

.taulaf1{font-size:0.8em;color:#00f;text-decoration:none;background:#dde;}
.taulaf2 td{font-size:0.9em;border-bottom:#eee solid 2px;}
.observacions td{border-top:none;}
.columna-nom{width:400}
.garjola{color:red;}
.odd{background:#f4f6ff;}
.amagat{display:none;}

.hora-mati{background:red}
.hora-15{background:#E5004C;} /*lila*/
td.hora-15.online {background:#E57D4C}/*beig*/
.online {background:#E57D4C}/*beig*/
td.hora-mati.online{background:#FFB300} /*groc*/
</style>
</head>
<body bgcolor="#ffffff">
	<div id="menu" style="<?php echo $menu ?>">
		<ul>
			<li>
				<a href="print.php?p=DIA_TORN">AQUEST TORN</a>
			</li>
			<li>
				<a href="print.php?p=DIA">AVUI</a>
			</li>
			<li>
				<a href="print.php?p=SETMANA">PROPERS 7 DIES</a>
			</li>
			<li>
				<a href="print.php?p=MES">UN MES</a>
			</li>
			<li>
				<a href="print.php?p=FUTUR">TOTES LES RESERVES FUTURES</a>
			</li>
		</ul>
	<div style="clear:both;">..</div>					
	</div>

<div id="img_menjador">
	<img src="/cb-reserves/reservar/css/loading.gif"/>
</div>
			<div id="llista_reserves" class="pageBreak">
			  <?php
			     $total_coberts_torn=json_decode($gestor->total_coberts_torn(),TRUE);
			  ?>
			<h3>LLISTA RESERVES: <span class="print-taula"><?php echo $gestor->cambiaf_a_normal($_SESSION['data'],"%A %d de %B de %Y");?></span><?php echo $torn[$_SESSION['torn']].' ( <span class="print-taula">'.$total_coberts_torn['t'.$_SESSION['torn']].' Coberts</span>)';?></h3> 
			<p>
			<?php  			
			out($gestor->print_llista_reserves( "DIA_TORN1" ));			
			out($gestor->print_llista_reserves( "DIA_TORN2" ));			
			?>
			</p>
		</div>
	</div>
</body>
</html>
