
$(function(){

	$('#confirma_data').dialog({
		autoOpen: false,
		modal:true,
		width: 600,
		height: 270,
		buttons: {
		"Tanca": function() { 
			$(this).dialog("close"); 
		},
			"Confirma": function() { 
				$(this).dialog("close"); 
				//$("#calendari").datepicker("destroy");
				//monta_calendari("#calendari");
				if (!canvia_data_confirma) fromDialog_novaReserva(TAULA,N,P,C,F);
				else alert("Has canviat la data!, Comprova el menjador i el torn");
			}
			
		}
	});
});


