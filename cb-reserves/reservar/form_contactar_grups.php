<div class="caixa resum no-grup ui-button ui-widget ui-state-default ui-button  ui-button-text-only ui-corner-all" style="float:left;width:270px;">
<?php 
l("INFO_NO_EDITAR_GRUPS");

$row=$gestor->recuperaReservaGrup($_POST['mob'],$_POST['idr']);

//Gestor::printr($row);
$data=Gestor::cambiaf_a_normal($row['data']);
?>
</div>



<div id="caixa_reserva_consulta_online" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all" style="width:400px;background:#FCFCFF;border:#AAA solid 1px;">
			 <?php  l("[Contactar amb el restaurant]");?><br/><br/>
<div class="ui-corner-all caixa resum" style="margin:8px;text-align:left;color:#999;">
	<b><?php l('Resum reserva');?>:</b><br/><br/>
	<strong><?php echo $row['client_nom'].' '.$row['client_cognoms']; ?></strong><br/>
	<?php l('Data');?>: <strong id="resum-data"><?php echo $data;?></strong> | <?php l('Hora');?>: <strong id="resum-hora"><?php echo $row['hora'];?></strong><br/>
	<?php l('Adults');?>: <strong id="resum-adults"><?php echo $row['adults'];?></strong> | <?php l('Juniors');?>: <strong id="resum-juniors"><?php echo $row['nens10_14'];?></strong> | <?php l('Nens');?>: <strong id="resum-nens"><?php echo $row['nens4_9'];?></strong> | <?php l('Cotxets');?>: <strong id="resum-cotxets"><?php echo $row['cotxets'];?></strong><br/>
</div>
	<form id="form_contactar" name="form_contactar_grups" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" >
		<br/>
		<br/>
		<?php l('INCIDENCIA_ONLINE_GRUPS');?>
			<br/>
		<textarea name="reserva_consulta_online" style="width:100%"></textarea>
		
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr height="2 0px">
				  <td class="etinput" ><div align="right"><?php  l('Correu electrònic');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td>
					<input type="text" name="client_email" style="width:100%" value="<?php echo $row['client_email'];?>" <?php echo $row['client_email']?'readonly="readonly" ':'';?>/>
				  </td>
				</tr>
				<tr>
				  <td class="etinput"><div align="right">			
					
					<?php  l('ID Reserva');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td>
					<input type="text" name="idr" value="<?php echo $EDITA_RESERVA;?>" style="width:70px" <?php echo $EDITA_RESERVA?'readonly="readonly" ':'';?>/></td>
				</tr>
			  </table>
		<input type="text" name="control_rob" class="ui-helper-hidden" />
		<button id="bt_reserva_consulta_online" name="incidencia_grups" value="incidencia_grups">Enviar</button>

	</form>
</div>
<div style="clear:both"></div>
