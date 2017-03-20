<?php 
//header('Content-Type: text/html; charset=utf-8');//UTF-8 IMPORTANT!!!!!

/****** CONFIG *******/
//$CONFIG="config.xml";
/****** DEV *******/
$dev=FALSE;
if (strpos($_SERVER['PHP_SELF'],"dev")) $dev=true;
if (strpos($_SERVER['HTTP_HOST'],"dev")) $dev=true;

// LLISTES DE DIES BLANCS / NEGRES
require_once("Gestor.php");
if (!defined('LLISTA_DIES_NEGRA'))define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");
if (!defined('LLISTA_DIES_BLANCA'))define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
if (!defined('LLISTA_NITS_NEGRA')) define("LLISTA_NITS_NEGRA",ROOT . INC_FILE_PATH."llista_dies_negra.txt");

require_once("gestor_reserves.php");
$gestor=new gestor_reserves();   



if (!$gestor->valida_sessio())  
{
	header("Location: index.php");
	die();
}



require(ROOT . INC_FILE_PATH."llista_dies_taules.php");

/**************************************************************************************************************************************************************************/
/**************************************************************************************************************************************************************************/
/**************************************************************************************************************************************************************************/

/****************************************/
/****************************************/
/**********      INSERT RESERVA   *************/
/****************************************/
/****************************************/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "insert_reserva")) 
	die("insert res");//$gestor->inserta_reserva();
/****************************************/
/****************************************/
/******      update_RESERVA     *********/
/****************************************/
/****************************************/
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_reserva")) 
		$gestor->update_reserva();						
if (!$gestor->valida_sessio())  header("Location: index.php");
/****************************************/
/****************************************/
/******      DELETE_RESERVA     *********/
/****************************************/
/****************************************/
if ((isset($_REQUEST["del_reserva"])) && ($_REQUEST["del_reserva"] >0)) 
	$gestor->esborra_reserva($_REQUEST["del_reserva"]);						


		
/**************************************************************************************************************************************************************************/
/**************************************************************************************************************************************************************************/
/**************************************************************************************************************************************************************************/
		
		
/****************************************/
/****************************************/
/**********      INSERT CLENT   *************/
/****************************************/
/****************************************/
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "insert_client")) 
	$gestor->inserta_client();
/****************************************/
/****************************************/
/******      update_CLIENT    *********/
/****************************************/
/****************************************/
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "edit_client")) 
		$gestor->update_client();						
/****************************************/
/****************************************/
/******      DELETE_CLIENT     *********/
/****************************************/
/****************************************/
if ((isset($_REQUEST["del_client"])) && ($_REQUEST["del_client"] > 0)) 
		$gestor->esborra_client($_REQUEST["del_client"]);	


		

/**************************************************************************************************************************************************************************/
/**************************************************************************************************************************************************************************/
/**************************************************************************************************************************************************************************/
//$llista_blanca=llegir_dies(LLISTA_DIES_BLANCA);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
<head>
    <link rel="shortcut icon" type="image/ico" href="/gear-favicon.ico" />

<?php include("head.php");?>
	
		<?php if (LOCAL!==true && DEV!==true) echo '<style>#debug_out{display:none}</style>';?>
	
</head>
<body bgcolor="#ffffff" class="<?php echo DEV?" dev ":""; echo LOCAL?" local ":"" ?>">

<?php if ($_SESSION['permisos']>16){ ?>
<div id="barra_dalt" class="NOtransparent">
	<ul>
		<li><a href="#" class="catcher round">+</a></li>
<?php if ($_SESSION['permisos']>64){ ?><li><a href="" id="bt_refresh" class="round">Actualitza</a></li><?php }?>
<?php if ($_SESSION['permisos']>64){ ?><li><a href="gestio_dies.php" class="round">Calendari</a></li><?php }?>
<?php if ($_SESSION['permisos']>64){ ?><li id="menu_missatge_dia"><a href="gestor_reserves.php?a=guarda_missatge_dia" class="round">Missatge</a></li><?php }?>
<?php if ($_SESSION['permisos']>64){ ?><li><a href="#" id="bt_edit_hores"  class="round">Hores</a></li><?php }?>
<?php if ($_SESSION['permisos']>64){ ?><li><a href="edbase.php" id="bt_edit_base" target="_self" class="round">Base</a></li><?php }?>
<!--<?php if ($_SESSION['permisos']>64){ ?><li><a href="taules_del.php" id="bt_historic" target="_self" class="round">Esborrades</a></li><?php }?>-->
<?php if ($_SESSION['permisos']>64){ ?><li><a href="taules.php?<?php echo $passat?>" id="bt_passat" target="_self" class="round"><?php echo $passat?></a></li><?php }?>
<!-- <?php if ($_SESSION['permisos']>64 && !$dev){ ?><li id="bt_backup"><a href="dumpBD.php?drop" target="_self" class="round">Còpia</a></li><?php }?> -->
<?php if ($_SESSION['permisos']>64 && !$dev){ ?><li id="bt_backup"><a href="print.php?a=torn&p&download" target="_self" class="round">Descàrregar llistat</a></li><?php }?>
<?php if ($_SESSION['permisos']>64 && $dev){ ?><li id="bt_importBD"><a href="db_Backup/bigdump.php" target="_blank" class="round">Restaura</a></li><?php }?>
<?php if ($_SESSION['permisos']>30){ ?><li id="bt_print"><a href="print.php?a=torn" target="_self" class="round">Imprimir</a></li><?php }?>
<?php if ($_SESSION['permisos']>64){ ?><li>&nbsp;&nbsp;&nbsp;&nbsp;</li><?php }?>
		<li><a href="gestor_reserves.php?a=tanca_sessio" target="_self" class="round">Sortir</a></li>
	</ul>	
</div>
<?php }?>
<!--
<a href="javascript:fromAS3_editReserva(1353,'tauletaaa')">edit 1353</a>	
<a href="javascript:fromAS3_novaReserva('tauletaaa')">nova</a>	
-->
<div id="flash" class="clearfix"> 
</div> 	
	<div id="dreta"  style="display:none">
	
	<div id="zoom" class="ui-corner-all">
		<img id="imgCalendari" src="css/calend.jpg"/>
		<div id="total_torn" class="comensals"><span class="total_torn">25</span><br/>Comensals</div> 
		
		<div id="selectorComensals">
		Coberts:<br/>
			<input type="radio" id="com2" name="selectorComensals" value="2"  /><label for="com2">2</label>
			<input type="radio" id="com3" name="selectorComensals" value="3"  /><label for="com3">3</label>
			<input type="radio" id="com4" name="selectorComensals" value="4"  /><label for="com4" >4</label>
			<input type="radio" id="com5" name="selectorComensals" value="5"  /><label for="com5" >5</label>
			<input type="radio" id="com6" name="selectorComensals" value="6"  /><label for="com6" >6</label>
			<input type="radio" id="com7" name="selectorComensals" value="7"  /><label for="com7" >7</label>
			<input type="radio" id="com8" name="selectorComensals" value="8"  /><label for="com8" >8</label>
			<input type="radio" id="com9" name="selectorComensals" value="9"  /><label for="com9" >9</label>
			<input type="radio" id="com10" name="selectorComensals" value="10"  /><label for="com10" >10</label>
			<input type="radio" id="com11" name="selectorComensals" value="11"  /><label for="com11" >11</label>
			<input type="radio" id="com12" name="selectorComensals" value="12"  /><label for="com12">12</label>
			<input type="radio" id="com13" name="selectorComensals" value="13"  /><label for="com13">13</label>
			<input type="radio" id="com14" name="selectorComensals" value="14"  /><label for="com14" >14</label>
			<input type="radio" id="com15" name="selectorComensals" value="15"  /><label for="com15" >15</label>
			<input type="radio" id="com16" name="selectorComensals" value="16"  /><label for="com16" >16</label>
			<input type="radio" id="com17" name="selectorComensals" value="17"  /><label for="com17" >17</label>
			<input type="radio" id="com18" name="selectorComensals" value="18"  /><label for="com18" >18</label>
			<input type="radio" id="com19" name="selectorComensals" value="19"  /><label for="com19" >19</label>
			<input type="radio" id="com20" name="selectorComensals" value="20"  /><label for="com20" >20</label>
			
		</div>
		
		<div id="selectorCotxetsCerca" class="amagat">
			<input type="radio" id="1cotxets" name="selectorCotxets" value="1"/><label for="1cotxets">1 cotxet</label>
			<input type="radio" id="2cotxets" name="selectorCotxets" value="2"/><label for="2cotxets">2 cotxets</label>
		</div>
		
		<div id="cercaTaulaResult">Quants coberts?</div>
			<div id="calendariColumnaDereta">
				<div id="calendari" class="calendari"></div>
				<div id="radio_hores_calend">
		<?php //echo $gestor->recupera_hores();?>
				</div>
				
				<div style="margin-left:230px;">
				<div id="radio">
					<input type="radio" id="torn1" name="radio" value="1" checked="checked" /><label for="torn1">Dinar T1</label>
					<?php if (FALSE || isset($_REQUEST['Historic'])): ?>
					<input type="radio" id="torn2" name="radio" value="2"  /><label for="torn2">Dinar T2</label> 
					<?php endif;?>
					<input type="radio" id="torn3" name="radio" value="3"  /><label for="torn3" id="lblTorn3">Sopar</label>
				</div>
				<table id="totals-torn"  style="clear:both;font-size:0.3em;width:525px;text-align:center;"><tr>
				<td id="total-t1"></td><td id="total-t2"></td><td id="total-t3"></td>
				</tr></table>
				</div>
								
				
			</div>
		</div>

	
		<div id="tabs" >
			<ul>
				<li><a href="#reserves">Reserves</a></li>
				<li><a href="#clients">Clients</a></li>
			</ul>
			<div id="clients">
	
		<select id="filtreCli" name="filtreCli" >
			<option value="1" selected="selected">Torn</option>
			<option value="2">Dia</option>
			<option value="3">Avançat</option>
		</select>
		
		<!-- HOLA TEO I LOLA , MAMA I ALEX
		<form class="searchform searchCli" class="amagat" style="display:none;">
	<input id="cercaClient" name="cercaClient" class="searchfield" type="text" value="Cerca..." onfocus="if (this.value.toUpperCase().search('CERCA...')!=-1) {this.value = '} else if(this.value.length>0) this.select();" onblur="if (this.value == '') {recargaAccordionClients();this.value = 'Cerca...'}">
	<input id="btCercaClient" class="searchbutton" type="button" value="Go">
	
</form>-->
	
	<input id="autoc_client_accordion" type="text" name="autoc_client_accordion" value=""/><a href="#" id="resetCerca" class="ui-state-default ui-corner-all" title="Elimina filtre">X</a>

		
		
				<div id="clientsAc">
					<?php out ($gestor->accordion_clients(1));?>
				</div>
			</div>
			<div id="reserves">
				<p>
					<a href="#" id="novaReserva" class="ui-state-default ui-corner-all" style="margin-right:10px;padding:4px;">Nova Reserva</a>
<form class="searchform">
	<input id="cercaReserva" name="cercaReserva" class="searchfield amagat" type="text" value="Cerca..." onfocus="if (this.value.toUpperCase().search('CERCA...')!=-1) {this.value = ''} else if(this.value.length>0) this.select();" onblur="if (this.value == '') {recargaAccordioReserves();this.value = 'Cerca...'}">


	<input id="btCercaReserva" class="searchbutton amagat" type="button" value="Go">
		<select id="filtreRes" name="filtreRes">
			<option value="1" selected="selected">Torn</option>
			<option value="2">Dia</option>
			<?php if ($_SESSION['permisos']>64){ ?>
			<option value="3">Avançat</option>
			<?php } ?>
			
		</select>
	 <input id="autoc_reserves_accordion" /><a href="#" id="resetCercaRes" class="ui-state-default ui-corner-all" title="Elimina filtre">X</a>
</form>


				<div id="reservesAc" style="display:none">
					<?php //out ($gestor->accordion_reserves());?>
				</div>
			</div>
		</div>	
		
		
		<div id="insertClient" title="Nou Client"  style="display:none">
			<?php include("form_client.php");?>
		</div>
		<div id="insertReserva" title="Nova Reserva"  style="display:none">
			<?php include("form_reserva.php");?>
		</div>
		
		<div id="edit" title="Editar"  style="display:none;">
				CARREGANT EDITOR....
		</div>
		
		
</div>

<div id="form_missatge_dia" title="Escriu un text pel dia seleccionats"  style="display:none">
	<span class=".font07">Introdueix un text que apareixerà al formulari de creació de reserves pel dia que has seleccionat</span>
	<textarea id="ta_missatge_dia" class="missatge_dia" name="text_dia">
		
	</textarea>
</div>

<div id="form_hores" title="Modifica hores actives pel dia i torn seleccionats"  style="display:none">Cal actualitzar les dades</div>

<div id="refresh" class="round"><img src="css/loading.gif"></div>
<div id="refresh_popup" class="round"  style="display:none">Cal actualitzar les dades</div>
<div id="confirma_data" class="round" title="Confirma data "  style="display:none">
Es crearà una nova reserva pel dia <br/><br/><span id="confirma_data_dia">DIA</span>, torn <span id="confirma_data_torn">TORN</span>
<div id="calendari_confirma" class="calendari"></div>

<br/><br/>Confirma que és correcte</div>
<div id='dlg_cercador' class="none"></div>		
<div id='debug_out'>DEBUG ACTIVAT</div>		
</body>
</html>
