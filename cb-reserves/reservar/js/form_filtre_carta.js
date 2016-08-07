$(function(){

	
	/* popup */		
	/* popup CARTA */
	$("#fr-menu-popup").dialog({
		autoOpen: false,
		modal:true,
		width:800,
		height:750,
		buttons: {
			"Fet": function() { 
				$(this).dialog("close"); 
			}
		}
		
	});
	/* popup MRNU */
	$("#fr-cartaw-popup").dialog({
		autoOpen: false,
		modal:true,
		width:800,
		buttons: {
			"Fet": function() { 
				$(this).dialog("close"); 
			}
		}
		
	});
	
	
	/* popup SORTER */
	$("#fr-sort-popup").dialog({
		autoOpen: false,
		modal:true,
		width:800,
		buttons: {
			"Fet": function() { 
				$(this).dialog("close"); 
				location.reload();
			}
		}
		
	});
	
	
	//$(".contador").val(0);
	
	$(".contador").each(function(){
		if ($(this).prop('checked'))
		{
			$(this).parent().next().addClass("carta-seleccio");
			$(this).addClass("carta-seleccio");
		}
	});
	$("input[type=submit]").button();
	$("a.bt").button();
	
	$(".all").click(function(){
		var checked=$(this).parent().find("input").is(':checked');
		var check=!checked;
		alert(checked);
		
		$(this).parent().find("input").each(function(){
			$(this).prop('checked',check);
			var cpid=$(this).attr('cpid');
			$.post("Gestor_filtre_carta.php?a=check_plat",{b:cpid,c:check});
		});
		
		
	});
	
	$("#bt-carta").click(function(){	
		$("#fr-cartaw-popup").dialog("open");
		$( "#fr-carta-tabs" ).tabs( "option", "selected", 0 );
		return false;
	});
	$("#bt-menu").click(function(){
		$( "#fr-menu-popup" ).dialog( "option", "height", 750 );
		$("#fr-menu-popup").dialog("open");
		$( "#fr-menu-tabs" ).tabs( "option", "selected", 0 );
		return false;
	});

	$("#bt-sort").click(function(){
		$("#fr-sort-popup").dialog("open");
		return false;
	});
	
	$("#fr-carta-tabs").tabs();
	$("#fr-menu-tabs").tabs();
	/*
	SORTER
	*/
       $( "#sortable" ).sortable({ 
            update : function () { 

                var order = $('#sortable').sortable('serialize'); 
                $.ajax("Gestor_filtre_carta.php?a=subfamilia_sorter&"+order); 
            } 
        });
        $( "#sortable" ).disableSelection();
	
	
	$(".contador").change(function(){
		var checked=$(this).prop('checked');
		var cpid=$(this).attr('cpid');
		
		if (!checked)
		{
			$(this).val(0); 
			$(this).parent().next().removeClass("carta-seleccio");
			$(this).removeClass("carta-seleccio");	 
		}
		else
		{
			$(this).parent().next().addClass("carta-seleccio");
			$(this).addClass("carta-seleccio");
		}		
		
		//AJAX
		$.post("Gestor_filtre_carta.php?a=check_plat",{b:cpid,c:checked},function(dat){
			
			//alert(dat);
		});
		var preu=$(this).parent().parent().find(".carta-preu").html();
		$(this).parent().parent().find(".carta-preu-subtotal").html(checked*preu);
		
	});
	
	
//$("#carta_MENUS .resum-carta-nom").tooltip({cssClass:"tooltip-red",delay : 200});            

}); //ONLOAD, PRESENTACIO UI
/************************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/

/********************************************************************************************************************/
/********************************************************************************************************************/
function isNumber(n) {
//	return true;
	var a=isNaN(parseFloat(n));
	var b=isFinite(n);
  return (!a && b);
}/********************************************************************************************************************/
function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return parseFloat(result.toFixed(dec));
}

function getParameterByName(name)
{
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regexPS = "[\\?&]"+ name;
  var regexS = "[\\?&]" + name + "=([^&#]*)";
  var regex = new RegExp(regexS);
  var param= new RegExp(regexPS);
  var results = regex.exec(window.location.search);
  if(results == null)
	if (param.exec(window.location.search)) return true;
	else return false;
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

