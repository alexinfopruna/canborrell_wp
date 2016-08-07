<?php 
require_once("gestor_reserves.php");
$gestor=new gestor_reserves();   
if (!$gestor->valida_sessio())  header("Location: index.php");

if (isset($_REQUEST['idR'])) $_REQUEST['id']=$_REQUEST['idR']; //compatibiliat amb cercador_clients
if ($id=$_REQUEST['id'])
{
	header('Content-Type: text/html; charset=UTF-8');
	$row_client=$gestor->load_client($id);
	$class=" updata_cli";
	$editFormAction="gestor_reserves.php?a=update_client&p=".$id;
}
else 
{
	$class="inserta_cli";
	$editFormAction="gestor_reserves.php?a=inserta_client";	
}
 ?><form class="form_edit <?php echo $class;?>" id="<?php echo $class;?>" method="post" name="frmEditClient" action="<?php echo $editFormAction;  ?>">
	<div id="frm_edit_modal" class="centrat" >	
			<!-- UPLOAD -->
	<table align="center">
	  <tr valign="baseline" class="amagatxx">
		<td nowrap="nowrap" align="right">id_client:</td>
		<td nowrap="nowrap" align="left">
		<!-- UPLOAD-->
		<input type="hidden" readonly="readonly" name="client_id" value="<?php echo $row_client['client_id'] ?>" size="32"  />
		 <?php echo $row_client['client_id'] ?>
		</td>
	 </tr>	  
	 
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">Mòbil/Fixe 1:</td>
		<td align="left"><input type="text" name="client_mobil"  tabindex="1"  value="<?php echo ($row_client['client_mobil']); ?>" size="10"  class="required number"   title="Ha de ser numèric"/>
	Mòbil/Fixe 2:<input type="text" name="client_telefon"  tabindex="-1"  value="<?php echo $row_client['client_telefon']; ?>" size="10" />
		</td>
	  </tr>
	  
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">cognoms:</td>
		<td align="left">
			<input type="text" name="client_cognoms" tabindex="1" value="<?php echo $row_client['client_cognoms'] ?>" size="32"   class="required"  title="Has d´omplir aquest valor"/>
		</td>
	  </tr>
	  <!---->
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">nom:</td>
		<td align="left">
			<input type="text" name="client_nom" value="<?php echo $row_client['client_nom'] ?>" size="32" class=""   title="Has d´omplir aquest valor"  />
		</td>
	  </tr>
		
	  <tr valign="baseline" style="display:none">
		<td nowrap="nowrap" align="right">dni:</td>
		<td align="left">
			<input type="text" name="client_dni" value="<?php echo $row_client['client_dni'] ?>" size="3"  />
		</td>
	  </tr>
		
		
 	  
	  <tr valign="baseline"  style="display:none">
		<td nowrap="nowrap" align="right">adreça:</td>
		<td align="left"><input type="text" name="client_adresa" value="<?php echo $row_client['client_adresa']; ?>" size="32" />
		
		
		localitat:<input type="text" name="client_localitat" value="<?php echo $row_client['client_localitat']; ?>" size="32" />
		
		
		
		CP:<input type="text" name="client_cp" value="<?php echo $row_client['client_cp']; ?>" size="3" /></td>
	  </tr>
	
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">	
			email:
		</td>
		<td>
			<input type="text" name="client_email" value="<?php echo $row_client['client_email']; ?>" size="40"  class="email"   title="L´email no és correcte"/>
		</td>
	  </tr>
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right" class="labelTA">
			
			conflictes:
			<a href="#" class="ui-state-default ui-corner-all garjola" style="margin-right:10px;padding:4px;">Garjola</a>
		
		</td>
		<td align="left"><textarea type="text" name="client_conflictes" rows="3" cols="40" class="txtGarjola"><?php echo $row_client['client_conflictes']; ?></textarea>

		</td>
	  </tr>

	  <?php if ($row_client['client_id']){ ?>
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right" class="labelTA">Històric:</td>
		<td align="left">
			<div class="info-comanda" style="height:100px">
			<?php echo $gestor->clientHistoric( $row_client['client_id']); ?>
			</div>
		</td>
	  </tr>
	  <?php }?>
	  
	</table>
	</div>
	<input name="<?php echo ($id?'MM_update':'MM_insert'); ?>" type= "hidden" value="<?php echo ($id?'edit_client':'insert_client'); ?>" />
	<!--<input id="submit" name="submit" type="submit" value="Guardar Canvis"/>-->
	</form>
	
	
	<script>
	/*
		$("input").bestupper();
		$("textarea").bestupper();
		
		var optionsValidate=	{
			errorElement: "em",
			rules: {
			mob:"required",
			idr:"required"
			},
			messages: {
			mob:l("Aquest camp és necessari"),
			idr:l("Aquest camp és necessari")
			}
	};

	valida("form.form_edit",optionsValidate);
	*/
	</script>