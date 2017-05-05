<div id="caixa_reserva_consulta_online" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all " >
			  <a href="#" id="a_consulta_online" class="r-petita"><?php  l("[Contactar amb el restaurant]");?></a>	
	<form id="form_contactar" name="form_contactar" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>" class="r-petita" accept-charset="utf-8" style="">
		<br/>
		<br/>
		<?php l('INCIDENCIA_ONLINE');?>
			<br/>
		<textarea name="reserva_consulta_online" style="width:100%"></textarea>
		
				<table width="0" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr height="2 0px">
				  <td class="etinput" ><div align="right"><?php  l('Correu electrònic');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td><input type="text" name="client_email" /></td>
				</tr>
				<tr height="20px">
				  <td  colspan="3" class="" style="color:#999;"><br/><br/><?php l('INFO_CONTACTE');?></td>
				</tr>
				<tr>
				  <td class="etinput"><div align="right">			
					
					<?php  l('ID Reserva');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td>
				  <?php 
				  	if (!isset($EDITA_RESERVA)) $EDITA_RESERVA='';
				  ?>
				  <input type="text" name="idr" value="<?php echo $EDITA_RESERVA;?>" style="width:70px" <?php echo $EDITA_RESERVA?'readonly="readonly" disabled="disabled"':'';?>/></td>
				</tr>
			  </table>
		<input type="text" name="control_rob" class="ui-helper-hidden" />
		<button id="bt_reserva_consulta_online" name="incidencia" value="">Enviar</button>

	</form>
</div>
<div style="clear:both"></div>
