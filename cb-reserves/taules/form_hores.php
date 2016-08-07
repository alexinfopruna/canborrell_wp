<?php 
require_once("gestor_reserves.php");
$gestor=new gestor_reserves();   
if (!$gestor->valida_sessio())  header("Location: index.php");

?><form id="form_hores" method="post" name="frmEditHores" action="gestor_reserves.php?a=update_hores">
	<div id="frm_edit_modal_<?php echo $class;?>" class="centrat" >	
			<!-- UPLOAD -->
	
	<table align="center">
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">
			hora:
		</td>
		<td nowrap="nowrap" align="left">

			<div id="<?php echo trim($class);?>_radio" class="radio_hores">
				<?php echo $gestor->recupera_hores($row_reserva['hora'],$nomhora);?>
			</div>
		</td>
	  </tr>
	</table>
	</div>
	
	<input name="MM_update" type= "hidden" value="edit_hores" />
	<input id="input_data" name="data" type="hidden" value="edit_hores" />
	<!--<input id="submit" name="submit" type="submit" value="Guardar Canvis"/>-->	
</form>
