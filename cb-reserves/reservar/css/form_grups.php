<?php 
header('Content-Type: text/html; charset=utf-8');

define('ROOT',"../taules/");
require_once (ROOT."Gestor.php");

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true) header("Location:fora_de_servei.html");


define("LLISTA_DIES_NEGRA",ROOT . INC_FILE_PATH."bloq.txt");
define("LLISTA_NITS_NEGRA",ROOT . INC_FILE_PATH."bloq_nit.txt");
define("LLISTA_DIES_BLANCA",ROOT . INC_FILE_PATH."llista_dies_blanca.txt");
define('USR_FORM_WEB',3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

/*
// ERROR HANDLER
require_once("../taules/php/error_handler.php");
*/

// CREA USUARI ANONIM
if (!isset($_SESSION)) session_start();
$usr=new Usuari(USR_FORM_WEB,"webForm",1);
if (!isset($_SESSION['uSer'])) $_SESSION['uSer']=$usr;


require ("Gestor_form.php");
$gestor=new Gestor_form();
require_once(ROOT . INC_FILE_PATH.'alex.inc');
require(ROOT . INC_FILE_PATH."llista_dies_taules.php");

//RECUPERA IDIOMA
//$lang_default=isset($_REQUEST["lang"])?$_REQUEST["lang"]:'cat';
$lang=$gestor->idioma();

$l=$gestor->lng;

//RECUPERA CONIG ANTIC
$PERSONES_GRUP=$gestor->configVars("persones_grup");
define("PERSONES_GRUP",$PERSONES_GRUP);
$max_nens_grup=$gestor->configVars("max_nens_grup");
$max_juniors_grup=$gestor->configVars("max_juniors_grup");


/*
 * Reset variables
 */
$row['id_reserva']=null;
$row['idr']=null;
$row['adults']=null;
$row['nens10_14']=null;
$row['nens4_9']=null;
$row['reserva_info']=null;
$row['cotxets']=null;
$row['comanda']=null;
$row['client_telefon']=null;
$row['client_mobil']=null;
$row['client_email']=null;
$row['client_nom']=null;
$row['client_cognoms']=null;
$row['client_id']=null;
$row['data']=null;
$row['hora']=null;
$row['observacions']=null;
//$row['']=null;



?>
<!DOCTYPE HTML>
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" pageEncoding="UTF-8"/>
<TITLE> Masia Can Borrell </TITLE>
	<LINK rel="stylesheet" type="text/css" href="../css/estils.css">
	
<!-- this goes into the <head> tag ALEX ESTILS! -->
<link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
<link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<link type="text/css" href="css/custom-theme/jquery.ui.all.css" rel="stylesheet" />	
<link type="text/css" href="../css/estils.css" rel="stylesheet" />	
<link type="text/css" href="css/form_reserves_grups.css" rel="stylesheet" />	
<link type="text/css" href="css/jquery.tooltip.css" rel="stylesheet" />	
    
		<!--<script type="text/javascript">
			document.write("\<script src='//ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js' type='text/javascript'>\<\/script>");
		</script>				
		<script type="text/javascript" src="../taules/js/jquery-1.5.min.js"></script>-->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>



		<script type="text/javascript" src="../taules/js/ui/js/jquery-ui-1.8.9.custom.min.js"></script>
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
		

<?php
require_once('translate_grups_'.$gestor->lng.'.php');
?>
<script type="text/javascript">
	var PERSONES_GRUP=<?php echo $PERSONES_GRUP;?>;
	var lang="<?php echo $lang;?>";
	<?php 
	//TRANSLATES

	$llista_negra=llegir_dies(LLISTA_DIES_NEGRA);
	$llista_nits_negra=llegir_dies(LLISTA_NITS_NEGRA);
	$llista_blanca=llegir_dies(LLISTA_DIES_BLANCA);
	
	print crea_llista_js($llista_negra,"LLISTA_NEGRA"); 
	print "\n\n";	
	print crea_llista_js($llista_nits_negra,"LLISTA_NITS_NEGRA"); 
	print "\n\n";	
	print crea_llista_js($llista_blanca,"LLISTA_BLANCA");  	
	
	?>	
</script>

		<script type="text/javascript" src="js/control_carta.js?<?php echo time();?>"></script>
		<script type="text/javascript" src="js/form_reserves_grups.js?<?php echo time();?>"></script>

</HEAD>
<BODY style="display:none" class="<?php echo DEV?" dev ":""; echo LOCAL?" local ":"" ?>">

<TABLE BGCOLOR="#F8F8F0" CELLPADDING="0" CELLSPACING="0" WIDTH="775"  BORDER="0" align="center">
	<TR height="114">
		<TD BACKGROUND="../img/fons_9a.jpg" COLSPAN="2" ALIGN="RIGHT"><A HREF="../index.htm"><IMG SRC="../img/lg_sup.gif" WIDTH="303" HEIGHT="114" BORDER="0" TITLE="INICI"></A></TD>
	</TR>
	<TR height="18">
		<TD BGCOLOR="#570600" COLSPAN="2" ALIGN="">
			<TABLE CELLPADDING="0" CELLSPACING="0" WIDTH="761" HEIGHT="19" BORDER="0">
				<?php //require_once($ruta_lang."menu.php");?>
			</TABLE>
		</TD>
	</TR>
	<TR height="18">
		<TD id="td_contingut" BGCOLOR="#F8F8F0" COLSPAN="2" ALIGN="">

<?php 				
if (isset($_POST['incidencia']))
{
	if (!$gestor->contactar_grups($_POST)) l("ERROR_CONTACTAR");
	else l("CONTACTAR_OK");	
	
	//die();
}
else
{
	include("form_contactar.php");
}
?>
					<div style="clear:both"></div>

<!-- ***************************************************************************************   -->
<!-- ***************************************************************************************   -->
<!-- ***************************************************************************************   -->
<form id="form-reserves" action="../editar/reserves_grups.php" method="post" name="fr-reserves" accept-charset="UTF-8"><!---->
	<div id="fr-reserves" class="fr-reserves">
		<!-- *******************************  QUANTS SOU ********************************************************   -->
		<!-- *******************************  QUANTS SOU ********************************************************   -->
		<!-- *******************************  QUANTS SOU ********************************************************   -->
		
<h2 CLASS="titol"><?php  l('Sol·licitud de reserva per a GRUPS');?><a href="info_reserves.html" id="info_reserves"><img src="css/info.png" title="<?php l("Informació de reserves");?>" style="width:16px;height:auto;margin-left:8px"/></a></h2>
		<div class="fr-seccio ui-corner-all fr-seccio-quants"> 
			<h1 class="titol"><span class="number">1</span><?php l('Quants sou?');?></h1>
			<h4><?php l('Adults (més de 14 anys)');?>:</h4>
      <?php l('ADULTS_TECLAT');?>
			
			<!-- ******  ADULTS  ********   -->
			<div id="selectorComensals" class="fr-col-dere">
<input type="text" id="com" name="adults" value=""  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)?></label>	
&lArr;

			<input type="radio" id="comGrups" name="selectorComensals" value="grups"  /><label for="comGrups" ><?php l('<='.($PERSONES_GRUP-1));?></label>
				<?php 
					for ($i=$PERSONES_GRUP;$i<$PERSONES_GRUP+15;$i++)
						print '<input type="radio" id="com'.$i.'" name="selectorComensals" value="'.$i.'" class="adults "/><label for="com'.$i.'">'.$i.'</label>';
				?>
				
			</div>
				
			<div>
				<!-- ******  INFO  ********   -->
				<div class="caixa dere ui-corner-all" style="float:right;"><?php l('INFO_QUANTS_SOU_GRUPS');?>
					 <input id="totalComensals" type="text" name="totalComensals" value="0" readonly="readonly" class="coberts"/></b>
					<!--Tingue's present que si vols modificar aquest nombre més endavant no podem garantir la disponibilitat de taula.<br/><br/>-->
				</div>
				<!-- ******  JUNIOR  ********   -->
			<h4><?php l('Juniors (de 10 a 14 anys):');?></h4>
				<div id="selectorJuniors" class="col_dere">
				 <input type="text" id="junior" name="nens10_14" value=""  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)?></label>
				 &lArr;

				<?php 
					for ($i=0;$i<=$max_juniors_grup;$i++)
					{
						$k=$i;if (!$i) $k=l("Cap",false);
						print '<input type="radio" id="junior'.$i.'" name="selectorJuniors" value="'.$i.'" '.($i?'':'checked="checked"').' class="junior"/><label for="junior'.$i.'" >'.$k.'</label>';
						
					}
				?>
				</div>
				<!-- ******  NENS  ********   -->
				<h4><?php l('Nens (de 4 a 9 anys)');?>:</h4>
				<div id="selectorNens" class="col_dere">
				 <input type="text" id="nens" name="nens4_9" value=""  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)?></label>
				 &lArr;
				<?php 
					for ($i=0;$i<=$max_nens_grup;$i++)
					{
						$k=$i;if (!$i) $k=l("Cap",false);
						print '<input type="radio" id="nens'.$i.'" name="selectorNens" value="'.$i.'" '.($i?'':'checked="checked"').' class="nens"/><label for="nens'.$i.'" >'.$k.'</label>';
					}
				?>
				</div>
				<!-- ******  COTXETS  ********   -->
				<h4><?php l('Cotxets de nadó');?>:</h4>
				<div id="selectorCotxets" class="col_dere">
					<input type="radio" id="cotxets0" name="selectorCotxets" value="0"  checked="checked" /><label for="cotxets0"><?php l("Cap");?></label>
					<input type="radio" id="cotxets1" name="selectorCotxets" value="1"  /><label for="cotxets1">1 simple</label>
					<input type="radio" id="cotxets2A" name="selectorCotxets" value="1"  /><label for="cotxets2A"><?php l("Doble ample");?></label>
					<input type="radio" id="cotxets2L" name="selectorCotxets" value="1"  /><label for="cotxets2L"><?php l("Doble llarg");?></label>
				</div>
				
				<h4><?php l('Cadira de rodes');?>:</h4>
				<div id="selectorCadiraRodes" class="col_dere">
					<?php	
						$estat=$gestor->decodeInfo($row['reserva_info']);
						$chek0=($estat['cadiraRodes']==0?'':'checked="checked"');
						$chek1=($estat['accesible']==0?'':'checked="checked"');
					?>
					<input type="checkbox" id="accesible" name="selectorAccesible" value="on"  <?php echo $chek1?> /><label for="accesible"><?php l("Algú amb movilitat reduïda");?></label>
					<input type="checkbox" id="cadira0" name="selectorCadiraRodes" value="on"  <?php echo $chek0?> /><label for="cadira0"><?php l("Portem una cadira de rodes");?></label>
				</div>
				
				<input type="hidden" name="amplaCotxets" value="0" /> 
					<div style="clear:both"></div>
			</div>		
		</div>		
				
		<!-- *******************************  QUIN DIA ********************************************************   -->
		<!-- *******************************  QUIN DIA ********************************************************   -->
		<!-- *******************************  QUIN DIA ********************************************************   -->
		<a id="scroll-seccio-dia"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-dia"> 
				<h1 class="titol"><span class="number">2</span><?php l("Quin dia voleu venir?")?></h1>
				<!-- ******  INFO  ********   -->
				<div class="caixa dere ui-corner-all">
					<?php l('INFO_DATA');?>	
					<input type="hidden" id="valida_calendari" name="selectorData"/>
					
				</div>
				<!-- ******  CALENDARI  ********   -->
				<div id="data" style="float:left">
					
					<div id="calendari"></div>
				</div>
					<div style="clear:both"></div>
					
		</div>		

		<!-- *******************************  QUINA HORA ********************************************************   -->
		<!-- *******************************  QUINA HORA ********************************************************   -->
		<!-- *******************************  QUINA HORA ********************************************************   -->
				<a id="scroll-seccio-hora"></a>
				<div class="fr-seccio ui-corner-all fr-seccio-hora" > 
				<h1 class="titol"><span class="number">3</span><?php l('A quina hora?');?></h1>
				<!-- ******  INFO  ********   -->
				<div class="ui-corner-all caixa dere hores">
					<?php l('INFO_HORES');?>	
				</div>
				<!-- ******  DINAR  ********   -->
				<h4><?php l('Dinar');?></h4>
				<div id="selectorHora" class="col_dere">
					<img src="/cb-reserves/reservar/css/loading.gif"/>
				</div>
				<!-- ******  SOPAR  ********   -->
				<h4><?php l('Sopar');?></h4>
				<div id="selectorHoraSopar" class="col_dere" >
					<img src="/cb-reserves/reservar/css/loading.gif"/>
				</div>
				
				<input type="hidden" name="taulaT1" value="">
				<input type="hidden" name="taulaT2" value="">
				<input type="hidden" name="taulaT3" value="">
			</div>	
			
			
		<!-- *******************************  CARTA  *********************************   -->
		<!-- *******************************  CARTA  *********************************   -->
		<!-- *******************************  CARTA  *********************************   -->
		<a id="scroll-seccio-carta"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-carta"> 
				<h1 class="titol"><span class="number">4</span><?php l('Escull els menús');?></h1>
				<div id="carta" class="col_derexx">
              <input id="te-comanda" name="te_comanda" type="text" value="" style="display:none "> 
					<!-- ******  COMANDA  ********   -->
					<div class="caixa dere ui-corner-all" >
						<table id="caixa-carta" class="col_dere">
							<tr>
								<td class="mesX"></td>
								<td class="menysX"></td>
								<td class="Xborra"></td>
								<td class="carta-plat">
									<h3><?php l("SELECCIO_GRUPS")?></h3>
								</td>
								<td></td>
							</tr>
							<tr>
							<td class="mesX">							
							<?php echo $comanda?></td>
							<td class="menysX"></td><td class="Xborra"></td>
							<td class="carta-plat"><h3>	</h3></td>
							<td></td>
							</tr>
						</table>
											<!-- ******  BUTO CARTA  ********   -->
						<div class="ui-corner-all info info-comanda" style="float:left;">
							<?php l('INFO_COMANDA_GRUPS');?>
						</div>
					

					</div>
				
					<!-- ******  INFO  ********  
					<div class="ui-corner-all info">
						<?php l('INFO_CARTA');?>
					</div> -->
					<!-- ******  BUTO CARTA  ********   
					<a href="#" id="bt-no-carta" name="bt-no-carta" class="bt" ><?php l('Continuar');?></a>
						<a href="#"  id="bt-carta" name="bt-carta" class="bt" ><?php l('Veure la carta');?></a>-->
						<a href="#"  id="bt-menu" name="bt-menu" class="bt"><?php l('Veure els menús');?></a>
					<div style="clear:both"></div>

				</div>
		</div>	



		<!-- *******************************  CLIENT ********************************************************   -->
		<!-- *******************************  CLIENT ********************************************************   -->
		<!-- *******************************  CLIENT ********************************************************   -->
		<a id="scroll-seccio-client"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-client"> 
				<h1 class="titol"><span class="number">5</span><?php l('Donan´s algunes dades de contacte');?></h1>
				<table id="dades-client" class="col_dere">
					<tr><td class="label"><?php l('Telèfon mòbil');?>*</td><td><input type="text" name="client_mobil"/></td></tr>
					<tr><td class="label"><?php l('Ens vols deixar una altre telèfon?');?></td><td><input type="text" name="client_telefon"/></td></tr>
					<tr><td class="label">Email*</td><td><input type="text" name="client_email"/></td></tr>
					<tr><td class="label"><?php l('Nom');?>*</td><td><input type="text" name="client_nom"/></td></tr>
					<tr><td class="label"><?php l('Cognoms');?>*</td><td><input type="text" name="client_cognoms"/></td></tr>
					<tr><td class="label"><?php //l('Client_id');?></td><td><input type="hidden" name="client_id"/></td></tr>
					<tr><td class="label"><?php l('Observacions');?></td><td><textarea type="text" name="observacions"></textarea></td></tr>


					<tr><td class="label"><?php //l('Vull rebre factura ProForma');?></td><td>
					<input type="checkbox" id="cb_factura" name="factura[]"/><label for="cb_factura" style="margin-left:10px;"><?php l('Vull rebre factura ProForma');?></label>
					<!--<input id="cb_factura" type="checkbox" name="factura[]"/></td></tr>-->
					<tr class="factura"><td class="label"><?php l('CIF');?>*</td><td><input type="text" name="factura_cif"/></td></tr>
					<tr class="factura"><td class="label"><?php l('Nom');?>*</td><td><input type="text" name="factura_nom"/></td></tr>
					<tr class="factura"><td class="label"><?php l('Adreça');?></td><td><textarea type="text" name="factura_adresa"></textarea></td></tr>
				</table>				
				
				
				
				<div class="ui-corner-all info-legal caixa">
					<?php l('LLEI');
					$chek= ($gestor->flagBit($row['reserva_info'],7)?'checked="checked"':'');
					
					?>
					<br/>
					
					<input type="checkbox" id="esborra_dades" name="esborra_dades" value="on" <?php print $chek?>/><label for="esborra_dades"><?php l("ESBORRA_DADES")?></label>
					
				</div>
				<div style="clear:both"></div>
		</div>	
		
		<!-- *******************************  SUBMIT ********************************************************   -->
		<!-- *******************************  SUBMIT ********************************************************   -->
		<!-- *******************************  SUBMIT ********************************************************   -->
		<a id="scroll-seccio-submit"></a>
		<div class="fr-seccio ui-corner-all fr-seccio-submit"> 
				<h1 class="titol"><span class="number">6</span><?php l('Envia la sol·licitud');?></h1>
				<div class="ui-corner-all caixa resum">
					<b><?php l('Resum reserva');?>:</b><br/><br/>
					<?php l('Data');?>: <b id="resum-data">-</b> | <?php l('Hora');?>: <b id="resum-hora">-</b><br/>
					<?php l('Adults');?>: <b id="resum-adults">-</b> | <?php l('Juniors');?>: <b id="resum-juniors">-</b> | <?php l('Nens');?>: <b id="resum-nens">-</b> | <?php l('Cotxets');?>: <b id="resum-cotxets">-</b><br/>
					<!--<?php l('Resum menús');?>: <b id="resum-comanda"><?php l('Sense');echo " "; l('menú');?> </b>  -->
					<?php l('Comanda');?>: <b id="resum-comanda"><?php l('Sense');?> </b> <?php l('plats');?> (<b id="resum-preu"></b> €)
				</div>
				<div class="ui-corner-all info-submit caixa dere">
					<?php l('INFO_NO_CONFIRMADA');?>:
				
				</div>
				<button id="submit"><?php l('Sol·licitar reserva');?></button>
				
				<div style="clear:both"></div>
				<div id="error_validate" class="ui-helper-hidden"><?php l("Hi ha errors al formulari. Revisa les dades, si us plau"); ?></div>
		</div>
			
	</div>

</form>	<!--
	
	-->
<div id="peu" style="text-align:center;margin-bottom:10px;"><b>Restaurant CAN BORRELL:</b> <span class="dins" style="text-align:right">93 692 97 23 / 93 691 06 05 </span>  /  <a href="mailto:<?php echo MAIL_RESTAURANT;?>" class="dins"><?php echo MAIL_RESTAURANT;?></a>
</div>
	
		</TD>
	</TR>
</TABLE>
	
	

<!-- ******************* CARTA *********************** -->
<!-- ******************* CARTA *********************** -->
<!-- ******************* CARTA *********************** 
<div id="fr-cartaw-popup" title="<?php l("La nostra carta")?>" class="carta-menu" style="height:300px">
<div id="fr-carta-tabs" >
	<?php //echo $gestor->recuperaCarta($row['id_reserva'])?>
</div>	
</div>	-->
<!-- ******************* CARTA-MENU *********************** -->
<!-- ******************* CARTA-MENU *********************** -->
<!-- ******************* CARTA-MENU *********************** -->
<div id="fr-menu-popup" title="<?php l("Els nostres menús")?>" class="carta-menu">
<div id="fr-menu-tabs" >
	<?php echo $gestor->recuperaCarta($row['id_reserva'],true)?>
    <h3 id="carta-total"></h3>
</div>	
</div>	
    
<!-- ******************* POPUPS GRUPS *********************** -->
<!-- ******************* POPUPS GRUPS *********************** -->
<!-- ******************* POPUPS GRUPS *********************** -->
<div id="popupGrups" title="<?php l("Reserva per grups")?>" class="ui-helper-hidden">
<?php l('ALERTA_GRUPS');?>
	
</div>
<!-- ******************* POPUPS HELP *********************** -->
<!-- ******************* POPUPS HELP *********************** -->
<!-- ******************* POPUPS HELP *********************** -->
<div id="help" title="<?php l("Necessites ajuda?")?>" class="ui-helper-hidden">
	<?php l('ALERTA_INFO_INICIAL_GRUPS');?>
</div>


<!-- ******************* POPUPS INFO *********************** -->
<!-- ******************* POPUPS INFO *********************** -->
<!-- ******************* POPUPS INFO *********************** -->
<div id="popup" title="<?php l("Informació")?>"></div>

<div id="popupInfo" CLASS="ui-helper-hidden">
	<?php l('ALERTA_INFO_GRUPS');?>
</div>

<div id="reserves_info" class="ui-helper-hidden">
	<?php include("reservesInfo_".substr($lang,0,2).".html");?>
</div>


</BODY>
</HTML>