$(function(){

	$('#form_hores').dialog({
		autoOpen: false,
		width: 1000,
		modal:true,
		buttons: {
			"Tanca": function() { 
				$(this).dialog("close"); 
			} 
		}
	});

	
	
	$(".edbase, #bt_edit_hores").click(function(){
			var data=$("#calendari").val();
			
			if (!data) data="BASE";
			var torn=$(this).attr("torn");
			if (!torn) torn="undefined";
			$( "#form_hores" ).dialog("open");
			$.get("gestor_reserves.php?a=edita_hores&p="+data+"&q="+torn, function(data) {
				$("#form_hores").html(data);
				$( ".ckbx_hora" ).click(horaClick)
				$( ".max_hores" ).change(maxClick)
				$( "#creaTaules" ).change(creaTaulesClick);
		});
	});
	
		$.get("gestor_reserves.php?a=edita_hores", function(data) {
			$("#form_hores").html(data);
			$( ".ckbx_hora" ).click(horaClick);
			$( ".max_hores" ).change(maxClick);
			$( "#creaTaules" ).change(creaTaulesClick);
	});
	
/***********************************************************************************/
});	

function horaClick()
{
		var data=$("#calendari").val();
		if (!data) data="BASE";
		
			var torn=$(this).attr("torn");
		
		var nom=$(this).attr("id");
		var max=$("input[name="+nom+"]").val();				
		var desti="gestor_reserves.php?a=update_hora&p="+$(this).val()+"&c="+($(this).is(":checked")?"1":"0")+"&d="+max+"&e="+data+"&f="+torn;
		$.ajax({url: desti,	success: function(datos){				}});	
}

function maxClick()
{
		var data=$("#calendari").val();
		if (!data) data="BASE";

		var torn=$(this).attr("torn");
		var nom=$(this).attr("name");
		var max=$(this).val();
		var chk=($("input[id="+nom+"]").is(":checked")?"1":"0");
		var hora=$("input[id="+nom+"]").val();

		var desti="gestor_reserves.php?a=update_hora&p="+hora+"&c="+chk+"&d="+max+"&e="+data+"&f="+torn;
		$.ajax({url: desti,	success: function(datos){				}});	
}

function creaTaulesClick()
{
		var data=$("#calendari").val();	
                if (typeof data  === 'undefined') data="2011-01-01";
		var torn=$("input[name='radio']:checked").val();
		if (typeof torn == 'undefined') torn="1";
		var desti="gestor_reserves.php?a=update_creaTaules&b="+data+"&c="+torn+"&d="+($(this).is(":checked")?"1":"0");
		$.ajax({url: desti,	success: function(datos){				}});	
}


