	<table align="center">
	  <tr valign="baseline" class="amagat">
		<td nowrap="nowrap" align="right">id_client:</td>
		<td nowrap="nowrap" align="left">
		<!-- UPLOAD-->
		</td>
	 </tr>	  
	  
	 
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">MOBIL/FIXE 1:
</td>
		<td align="left">
			<input id="autoc_client_<?php echo trim($class) ?>"  type="text" name="client_mobil" value="<?php echo ($row_client['client_mobil']); ?>" size="10"  class="{required:true,number:true} autoc_client" />
			<input type="hidden" name="client_id" value="<?php echo ($row_client['client_id']); ?>" size="2"  tabindex="-1" readonly="readonly" disabled="disabled"/>
		<button  style="font-size:0.8em;font-weight:normal;padding:3px;" type="button" class="sense-numero ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only ui-state-hover" role="button" aria-disabled="false">Sense número</button>			
			
			
	
		</td>
	  </tr>
<!--	  
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">M&Ograve;BIL/FIXE 2:</td>
		<td align="left">
			<input type="text" name="client_telefon" value="<?php echo $row_client['client_telefon']; ?>" size="10" class="autocomplete_client"/>
		</td>
	  </tr>
-->	  
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">COGNOMS:</td>
		<td align="left">
			<input type="text" name="client_cognoms" value="<?php echo $row_client['client_cognoms'] ?>" size="32"   class="{required:true}"  />
		</td>
	  </tr>
	  
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">NOM:</td>
		<td align="left">
			<input type="text" name="client_nom" value="<?php echo $row_client['client_nom'] ?>" size="32" class="{required:true}"     />
		</td>
	  </tr>
		
	  <tr valign="baseline" style="display:none">
		<td nowrap="nowrap" align="right">DNI:</td>
		<td align="left">
			<input type="text" name="client_dni" value="<?php echo $row_client['client_dni'] ?>" size="3"  />
		</td>
	  </tr>
		
		
 	  
	  <tr valign="baseline"  style="display:none">
		<td nowrap="nowrap" align="right">ADREÇA:</td>
		<td align="left"><input type="text" name="client_adresa" value="<?php echo $row_client['client_adresa']; ?>" size="32" />
		
		
		LOCALITAT:<input type="text" name="client_localitat" value="<?php echo $row_client['client_localitat']; ?>" size="32" />
		
		
		
		CP:<input type="text" name="client_cp" value="<?php echo $row_client['client_cp']; ?>" size="3" /></td>
	  </tr>
	
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right">	
			EMAIL:
		</td>
		<td>
			<input type="text" name="client_email" value="<?php echo $row_client['client_email']; ?>" size="40"  class="{email:true}"   title="L´email no és correcte"/>
		</td>
	  </tr>
	  <tr valign="baseline">
		<td nowrap="nowrap" align="right" class="labelTA">
			
			<a href="#" class="ui-state-default ui-corner-all garjola" style="color:red;margin-right:10px;padding:4px;">GARJOLA</a>
		
		</td>
		<td align="left"><textarea type="text" name="client_conflictes" rows="1" cols="40" class="txtGarjola"><?php echo $row_client['client_conflictes']; ?></textarea>

		</td>
	  </tr>
	  
	</table>
