<?php
define("ROOT", "../taules/");
define("READER_SCRIPT", "read.php?f=");
define("LOG_LIST", "listlogs.php");
define("LINS", "&l=ALL");
require_once(ROOT."gestor_reserves.php");
$gestor=new gestor_reserves();   

if (!$gestor->valida_sessio(64))  
{
	header("Location: login.php");
	die();
}
define("SUPER_ADMIN",$gestor->valida_sessio(255)?true:false);
define("ADMIN",$gestor->valida_sessio(63)?true:false);
define("LOG_FILE_TPV",LOG_FILE_TPVPK);

if (isset($_GET['exit'])) 
{
	$gestor->tanca_sessio();
	header("Location: login.php");	
}


?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<TITLE> PANEL DE CONTROL Masia Can Borrell </TITLE>

<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
<link type="text/css" href="../reservar/css/custom-theme/jquery.ui.all.css" rel="stylesheet" />	
	
<link type="text/css" href="../reservar/css/form_reserves.css" rel="stylesheet" />	

<style>
	.admin{display:none}
	body{backgroun-image:none;font-size:10px;    background-color: #eee;	}
	a.bt,a.bt:link,a.bt:visited{display:block;color:#666;text-align:left;}
	a.bt:hover{background:#570600;color:white;}
	
	h1{text-align:center;background:white;}
	.ui-accordion-header{text-align:center;font-size:1.5em}
	h4{background:#666;color:white;padding: 7px 7px 7px 7px;}
	
	.bt{padding:4px;margin:3px;}
	.caixa{
	height:350px;
	margin: 0px 15px 15px 15px;
	padding: 0px 5px 5px 5px;
	}	
	
	#panel{width:500px;margin:0 auto;}
	
	iframe{width:100%;height:1000px;display:none;background:white;background-image:none;}
                            
</style>

               <?php echo Gestor::loadJQuery("2.0.3"); ?>
<script>
$(function(){$("#panel").accordion({collapsible:true,active:false,heightStyle: "content",fillSpace: false,clearStyle: false,autoHeight: true});
/*	
	$("a").click(function(){
		var desti=$(this).attr("href");
		if (desti=="#") return true;
		alert(desti);
		$("#iframe").attr("src",desti);
		$("#iframe").show();
		return false;		
	});
*/	
});
	
</script>
</head>
<body>

<h1>PANEL DE CONTROL DEL SISTEMA DE RESERVES</h1>
<A HREF="<?php echo $_SERVER['PHP_SELF'];?>?exit" class="ui-button" style="border:#666 solid 1px;background:white;padding:3px;color:#666;float:right;margin-right:15px;">Tanca sessió</a>

<div id="panel">

<!-- 
/****************************************************************************************************************************/
/****************************************************************************************************************************/
// Gestió reserves de GRUPS
/****************************************************************************************************************************/
/****************************************************************************************************************************/
-->
<h4><a href="#">Gestió reserves de GRUPS</a></h4>
<div id="GRUPS" title="reserves_grups" class="caixa ">
		<a target="_new" href="../editar/llistat.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Gestor de reserves de GRUPS</a>
		<!-- -->
		<a target="_blank" href="../editar/editar.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">GRUPS: Editar PREUS i SUGGERIMENTS</a>
		<!-- -->
		<a target="_blank" href="../editar/llistat_historic.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">GRUPS: llistat HISTÒRIC</a>
		<!-- -->
		<a target="_blank" href="factures.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">FACTURES Proforma</a>
		<!-- -->

</div>
<!-- 
/****************************************************************************************************************************/
/****************************************************************************************************************************/
// CONTROL TAULES
/****************************************************************************************************************************/
/****************************************************************************************************************************/
-->
<h4><a href="#">Control TAULES</a></h4>
<div id="TAULES" class="caixa">
		<a target="_blank" href="../taules/taules.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Control de TAULES</a>
		<!-- -->
		<a target="_blank" href="../taules/cercador.php?data1=18/02/2012&data2=31/12/2050&torn1=1&torn2=1&torn3=1&del=0&act=0" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TAULES: Cercador reserves </a>
		<!-- -->
		<a target="_blank" href="../taules/DBTable/LlistatClient.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TAULES: Cercador clients </a>
		<!-- -->
		<a target="_blank" href="../panel/gestio_calendari.php?f=<?php echo INC_FILE_PATH;?>bloq.txt" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TAULES: Gestió dies bloquejats calendari TAULES</a>
		<!-- 
		<a target="_blank" href="../taules/print.php?a=torn" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TAULES: llistat per IMPRIMIR</a>-->
		<!-- -->
		<a target="_blank" href="../taules/edbase.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TAULES: editar BASE</a>
		<!-- -->
		<a target="_blank" href="../taules/taules.php?Historic" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TAULES: HISTÒRIC</a>
		<!-- -->
</div>

<!-- 
/****************************************************************************************************************************/
/****************************************************************************************************************************/
// Formularis de reserves
/****************************************************************************************************************************/
/****************************************************************************************************************************/
-->
<h4><a href="#">Formularis de reserves</a></h4>
<div id="ONLINE" class="caixa">
		<a target="_blank" href="../reservar/form.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">FORMULARI reserves</a>
		<!-- -->
		<a target="_blank" href="../reservar/form_grups.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">FORMULARI reserves GRUPS</a>
		<!-- -->
		<a target="_blank" href="../panel/gestio_calendari.php?f=<?php echo INC_FILE_PATH;?>llista_dies_negra_online.txt&hideBlancs" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">ONLINE: Gestió dies bloquejats calendari FORMULARI res.petites</a>
		<!-- -->
		<a target="_blank" href="../panel/gestio_calendari.php?f=<?php echo INC_FILE_PATH;?>bloq.txt" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">GRUPS: Gestió dies bloquejats calendari GRUPS</a>
		<!--
		<a target="_blank" href="../panel/editMenjadorsOnline_pk.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">ONLINE: Gestió menjadors OBERTS</a>
		<!-- --><!-- --> 
		<a target="_blank" href="../panel/editHoresOnline_pk.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">ONLINE: Gestió HORES</a>
		
		<a target="_blank" href="../reservar/update_carta.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Actualitzar CARTA</a>
		<!-- -->
		<a target="_blank" href="../reservar/filtre_carta.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">CARTA: Gestionar plats publicats</a>
		<!-- -->
		<a target="_blank" href="../restriccions" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Gestionar restriccions d'horaris</a>
		<!-- -->
</div>

<?php if (ADMIN){?>
<!-- 
/****************************************************************************************************************************/
/****************************************************************************************************************************/
// Eines especials
/****************************************************************************************************************************/
/****************************************************************************************************************************/
-->
<h4><a href="#">Eines avançades</a></h4>
<div id="ONLINE" class="caixa">
		<a target="_blank" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/panel/infoConn.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">INFO servidor</a>
		<!-- 
		<a target="_blank" href="../taules/DBTable/FormConfigAdmin.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">CONFIGURACIO AVANÇADA DEL SISTEMA</a>
		-->
		<a target="_blank" href="./config/" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">CONFIGURACIO AVANÇADA DEL SISTEMA</a>
                                                        <!-- -->
		<a target="_blank" href="../taules/dumpBD.php?drop" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Còpia de seguretat de la Base de Dades (Descarrega)</a>
		<!-- -->
		<!-- -->
		<a target="_blank" href="../taules/DBTable/bigdump.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Gestiona Còpies de seguretat de la Base de Dades</a>
		<!-- -->
    <!-- -->
    <a target="_blank" href="../taules/gestor_reserves.php?a=reserves_orfanes&p=1" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Reserves perdudes</a>
    <!-- -->
<?php if (SUPER_ADMIN){?>		
		<a target="_blank" href="../taules/TaulesDisponibles.php?d=2012-02-29&t=1&p=7&c=0" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Test TaulesDisponibles</a>
		<a target="_blank" href="../reservar/testTPV256.php" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Test TPV</a>
		<a target="_blank" href="../taules/gestor_reserves.php?a=testPHPerror" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">Genera error de PHP</a>

                                                          
                                                          <?php }?>		
		<!-- -->
		<!-- -->
		<!-- -->
		<!-- -->
		<h4 >LOGS</h4>
		<!-- 

		<a target="_blank" href="<?php echo READER_SCRIPT.ROOT.INC_FILE_PATH.LOG_FILE.LINS;?>" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">DARRER LOG D'ACCIONS</a>
		-->
		<!-- -->
		<a target="_blank" href="<?php echo LOG_LIST;?>" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">LLISTA LOGS</a>
		<!-- -->
		<a target="_blank" href="<?php echo READER_SCRIPT.ROOT.INC_FILE_PATH.'log/log.txt'.LINS  ?>" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">LOG PETITES</a>
		<!-- -->
		<a target="_blank" href="<?php echo READER_SCRIPT.ROOT.INC_FILE_PATH.'log/logGRUPS.txt'.LINS  ?>" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">LOG GRUPS</a>
		<!-- -->
		<a target="_blank" href="<?php echo READER_SCRIPT.ROOT.INC_FILE_PATH.LOG_FILE_TPVPK.LINS  ?>" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">LOG TPV PAGA I SENYAL</a>
		<!-- -->
		<!-- -->
		<a target="_blank" href="<?php echo READER_SCRIPT.ROOT.INC_FILE_PATH.'/log/logMAILSMS.txt'.LINS  ?>" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">LOG MAIL SMS</a>
		<br/>
		<br/>
		<br/>
		<a target="_blank" href="<?php echo $_SERVER['PHP_SELF'];?>?exit" class=" bt ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only">TANCA SESSIO</a>
		<!-- -->
</div>
<?php }?>

</div>

</body>
</html>
