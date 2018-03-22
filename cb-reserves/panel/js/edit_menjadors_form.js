$(function(){
	$(".menjador_form").click(function(){
		var n=$(this).attr("nid");
		var chek=$(this).prop('checked')?"0":"1";
		//var desti="../taules/gestor_reserves.php?a=updateMenjador&b="+n+"&c=2011-01-01&d=1&e="+chek+"&f=estat_menjador_form"		
		var desti="../taules/gestor_reserves.php?a=updateMenjador&b="+n+"&c=2011-01-01&d=1&e="+chek+"&f=estat_menjador"	//ATENCIO, HEM ANULAT estat_menjador_form	
		$.ajax({url: desti,	success: function(datos){				}});	
	});
});