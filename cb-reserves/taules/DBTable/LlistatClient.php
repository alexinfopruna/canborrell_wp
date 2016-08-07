<?php
////////////////////////////////////////////////////////////////////////////////
if (!defined('UPPER_NO_TILDE')) define('UPPER_NO_TILDE',true);
$TABLE = "client";
$EDITABLE = "false";
$FILTRE = "client.client_id>1000";
//$_REQUEST['futur']=true;
if (isset($_REQUEST['futur'])) $FILTRE .= " AND data >= CURDATE( ) ";
////////////////////////////////////////////////////////////////////////////////
$query = "SELECT 
client.client_id AS idR , 
client_mobil AS mobil,
client_cognoms AS cognom,
client_nom AS nom,
client_email AS email,
client.client_id AS ui_icon_trash 
FROM $TABLE 
    INNER JOIN reservestaules ON reservestaules.client_id = client.client_id ";
    


////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
include("Llistat.php")
?>
<script>
    $(function(){
        $("header").html('<input type="checkbox" id="futur"  name="futur" <?php echo isset($_REQUEST['futur'])?'checked="checked"':""?> /><label for="futur"><?php //echo isset($_REQUEST['futur'])?"":""?> Amaga històric</label>');
        
$( "#futur" ).button().click(function(){
    var FUTUR="";
					if ($(this).is(":checked"))	FUTUR="?futur=1";
					window.location.href="LlistatClient.php"+FUTUR;
			
				});			        
        
    });
</script>
  