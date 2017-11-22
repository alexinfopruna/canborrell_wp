/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var CERCADOR;
var FORMULARI_INSERTA_RES;

function cb_autocompletes(){
    
    CERCADOR=$("form.searchform");
    FORMULARI_INSERTA_RES=$("#insertReserva");

/**
 * AUTOCOMPLETE CERCADOR CLI
 */
     $("#autoc_reserves_accordion").autocomplete({
      source:"gestor_reserves.php?a=autocomplete_clients&p=modo",
      minLength: 4,
      autoFocus: true,
      select: function( event, ui ) {
          
            $("#autoc_client_accordion",CERCADOR).val(this.value);
            $("#autoc_reserves_accordion",CERCADOR).val(this.value);
          cercaReserves(this.value);
      }
  
    });
/**
 * AUTOCOMPLETE CERCADOR CLI
 */
     $("#autoc_client_accordion").autocomplete({
      source:"gestor_reserves.php?a=autocomplete_clients&p=modo",
      minLength: 4,
      autoFocus: true,
      select: function( event, ui ) {
          
            $("#autoc_client_accordion",CERCADOR).val(this.value);
            $("#autoc_reserves_accordion",CERCADOR).val(this.value);
          cercaClients("&p=0&c="+this.value);
      }
  
    });

/**
 * AUTOCOMPLETE INSERTA RES
 */
    $("#autoc_client_inserta_res",FORMULARI_INSERTA_RES).autocomplete({
      source:"gestor_reserves.php?a=autocomplete_clients",
      autoFocus: true,
      select: function( event, ui ) {
  	$("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).focus(function(){
		if (!isNaN(this.value)){ 
			$("#campsClient input[name='client_cognoms']",FORMULARI_INSERTA_RES).focus();
		}
		$("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).unbind("focus");
	});
        a=this.value;
        if (ui.item.label.substring(0,3)=="xx+++") 
         {
                $("#campsClient input", FORMULARI_INSERTA_RES).val("");
                $("#campsClient input[name='client_cognoms']", FORMULARI_INSERTA_RES).val(ui.item.client_cognoms.toUpperCase());
                $("#campsClient input[name='client_mobil']", FORMULARI_INSERTA_RES).val(ui.item.client_mobil.toUpperCase());
                $("#campsClient textarea[name='client_conflictes']", FORMULARI_INSERTA_RES).val(ui.item.client_conflictes.toUpperCase());
                
                if (isNaN(ui.item.value) || ui.item.value==""){ 
                         $("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).focus();
                 }
                 else 
                 {
                     this.value=ui.item.client_mobil;
                         $("#campsClient input[name='client_cognoms']",FORMULARI_INSERTA_RES).focus();
                 }
         }
         else{
              $("#campsClient input[name='client_mobil']",FORMULARI_INSERTA_RES).val(ui.item.client_mobil.toUpperCase());
             $("#campsClient input[name='client_cognoms']",FORMULARI_INSERTA_RES).val(ui.item.client_cognoms.toUpperCase());
             $("#campsClient input[name='client_nom']",FORMULARI_INSERTA_RES).val(ui.item.client_nom.toUpperCase());
             $("#campsClient input[name='client_email']",FORMULARI_INSERTA_RES).val(ui.item.client_email.toUpperCase());
             $("#campsClient textarea[name='client_conflictes']",FORMULARI_INSERTA_RES).val(ui.item.client_conflictes.toUpperCase());
         }
      },
      minLength: 6
    });
};