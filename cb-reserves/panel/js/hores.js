$(function(){	
	$( ".ckbx_hora" ).click(horaClick);
	//$( ".max_hores" ).change(maxClick);
	$("span.edita-hores-max").hide();
/***********************************************************************************/
});	

function horaClick()
{
		var data="BASE";
		var torn=$(this).attr("torn");
		
		//alert(torn);
		
		
		var nom=$(this).attr("id");
		//var max=$("input[name="+nom+"]").val();				
		var max=0;
		var desti=ROOT+"gestor_reserves.php?a=update_hora&p="+$(this).val()+"&c="+($(this).is(":checked")?"1":"0")+"&d="+max+"&e="+data+"&f="+torn+"&g=estat_hores_form";
		$.ajax({url: desti,	success: function(datos){				}});	
}

/*
function maxClick()
{
		alert("No pots posar màxims en aquesta pantalla. Has de modificar els Màxims des del control taules > editar base");
		$(this).val("");
		var data="BASE";
		var torn=1;
		var nom=$(this).attr("name");
		var max=$(this).val();
		var chk=($("input[id="+nom+"]").is(":checked")?"1":"0");
		var hora=$("input[id="+nom+"]").val();

		var desti=ROOT+"gestor_reserves.php?a=update_hora&p="+hora+"&c="+chk+"&d="+max+"&e="+data+"&f="+torn+"&g=estat_hores_form";
		$.ajax({url: desti,	success: function(datos){				}});	
}
*/