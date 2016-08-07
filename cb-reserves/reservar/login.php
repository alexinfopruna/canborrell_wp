		<div id="editar_reserva" class="ui-button ui-widget ui-state-default ui-button-text-only ui-corner-all" style="">
			  <a href="#" id="a_editar_reserva" ><?php  l("[Cancel·lar/modificar una reserva existent]");?></a>	
			  <form id="flogin" name="form1" method="POST" action="<?php echo $_SERVER['PHP_SELF'];  ?>" style="display:none">
			  <div id="info-login" style="margin-top:8px" class=""><?php  l("INFO_LOGIN");?><br/><br/>
			  
				<table width="0" border="0" align="center" cellpadding="0" cellspacing="0" >
				<tr height="2 0px">
				  <td class="etinput" ><div align="right"><?php  l('Mòbil');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td><input type="text" name="mob" /></td>
				</tr>
				<tr>
				  <td class="etinput"><div align="right"><?php  l('Contrassenya (ID)');?></div></td>
				  <td width="7">&nbsp;</td>
				  <td>
				  <input type="password" name="idr" /></td>
				</tr>
				<tr>
				  <td class="etinput"></td>
				  <td width="7">&nbsp;</td>
				  <td>
				  </td>
				</tr>
			  </table>
				  <input type="submit" name="Submit" value="Editar reserva" />
				  <input type="submit" id="cancel_reserva" name="cancel_reserva" value="Eliminar reserva" />
			</div>  
			</form>
		</div>
