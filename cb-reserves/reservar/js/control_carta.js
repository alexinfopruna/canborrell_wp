/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
	/* popup */		
	/* popup CARTA */
	$("#fr-menu-popup").dialog({
		autoOpen: false,
		modal:true,
		width:800,
		
		close:updateMenu,
		buttons: {
			"Fet": function() { 
				$(this).dialog("close"); 
			}
		}
		
	});
	/* popup MRNU  */
	$("#fr-cartaw-popup").dialog({
		autoOpen: false,
		modal:true,
		width:800,
		close:updateCarta,
		buttons: {
			"Fet": function() { 
				$(this).dialog("close"); 
			}
		}
		
	});
       
	$("#bt-carta").click(function(){	
		//$(".cmenu .carta-seleccio").removeClass("carta-seleccio");
		//$(".cmenu .contador").val(0);
		//$( "#fr-cartaw-popup" ).dialog( "option", "height", 750 );
                SELECT_CARTA=true;
		$("#fr-cartaw-popup").dialog("open");
		$( "#fr-carta-tabs" ).tabs( "option", "selected", 0 );
		return false;
	});
	$("#bt-menu").click(function(){
		//$(".ccarta .carta-seleccio").removeClass("carta-seleccio");
		//$(".ccarta .contador").val(0);
                SELECT_CARTA=false;
		$( "#fr-menu-popup" ).dialog( "option", "height", 750 );
		$("#fr-menu-popup").dialog("open");
		$( "#fr-menu-tabs" ).tabs( "option", "selected", 0 );
		return false;
	});
 //  $("#carta_MENUS .resum-carta-nom").tooltip({cssClass:"tooltip-red",delay : 100});
    $(".llistat_menus .resum-carta-nom").tooltip({cssClass:"tooltip-red",delay : 100});
        
        
       
//CONTROL CARTA	
	$(".mes").click(function(){
		var input=$(this).parent().find("input");
		var n=parseInt(input.val());
		if (isNaN(n)) n=0;
		if (n<100) input.val(parseInt(n)+1);	
		input.trigger("change");
                //alert("+");
	});
	
	$(".menys").click(function(){
		var input=$(this).parent().find("input");
		var n=parseInt(input.val());
		if (n>0) input.val(parseInt(n)-1);		
		input.trigger("change");
                //alert("-");
	});
	$(".contador").change(function(){
		var n=$(this).val();
		if (!isNumber(n) || n<=0 || n>100)
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
		var preu=$(this).parent().parent().find(".carta-preu").html();
		$(this).parent().parent().find(".carta-preu-subtotal").html(n*preu);
		
                                cont=$(".contador");
                n=0;
		var t=cont.length;
                for (i=0;i<t;i++) {
                    k=parseInt($(cont[i]).val());
                    if (k) n+=k;
                }               
                $("#carta-total").html("Total: "+n);
	});
        //RESET CARTA
	$(".contador").each(function(){
		if (parseInt($(this).val()))
		{
			$(this).parent().next().addClass("carta-seleccio");
			$(this).addClass("carta-seleccio");
		}
	});
        //$(".carta-seleccio").removeClass("carta-seleccio");
	$("#fr-carta-tabs").tabs();
	$("#fr-menu-tabs").tabs();
     	updateCarta("inici");

    
    if ('scrollRestoration' in history) {
  history.scrollRestoration = 'manual';
}
});







/********************************************************************************************************************/
function updateMenu()
{
	updateCarta("menu");
}

function updateCarta(menu)
{
	var clas=(menu=="menu")?".cmenu":".ccarta";
	var clasBorra=(menu!="menu")?".cmenu":".ccarta";
	if (menu=="inici") clasBorra="noborrisres";
	if  ($(clas+".carta-seleccio").val()!=undefined && $(clas+".carta-seleccio").val()!=0 && $(clas+".carta-seleccio").val()!="0")
	{
		$(clasBorra+" .carta-seleccio").removeClass("carta-seleccio");
		$(" .contador"+clasBorra).val(0);
	}


	var total=0;
	var taula='<tr><td resum-carta-nom><h3>'+l("SELECCIÓ")+'</h3></td><td class="resum-carta-preu"></td><td></td></tr>';
	var i=0;
	var plats=0;
	
	//NETEGEM L'ALTRA POPUP (carta / menu)
	
	$(".contador").each(function(){
		if ($(this).val()!=undefined && $(this).val()!=0 && $(this).val()!="0") 
		{
			i++;
			var hidden='<input type="hidden" name="plat_id_'+i+'" value="'+$(this).attr('nid')+'"/>';
			hidden+='<input type="hidden" name="plat_quantitat_'+i+'" value="'+$(this).val()+'"/>';
			
			var preu=$(this).val()*$(this).attr("preu");
			preu=roundNumber(preu,2);
		
			taula+='<tr><td class="resum-carta-nom">'+$(this).val()+' x <b>'+$(this).attr('nom')+'</b></td><td class="resum-carta-preu">'+preu+'€ </td><td>'+hidden+'</td></tr>';
			total+=parseFloat($(this).val()*$(this).attr("preu"));
			total=roundNumber(total,2);
			plats+=parseInt($(this).val());
		}	
	});
	
	if (total==0) taula+='<tr><td class="resum-carta-nom">'+l("No hi ha cap plat seleccionat")+'</td><td class="resum-carta-preu"></td><td></td></tr>';
	else
	{
		taula+='<tr ><td resum-carta-nom></td><td class="resum-carta-iva" style="text-alig:right"></td><td></td></tr>';
		taula+='<tr style="background:#eee;"><td class="resum-carta-nom"><h3 id="resum-total" style="display:inline">TOTAL</h3></td><td class="resum-carta-preu" style="text-alig:right"><h3>'+total+'€ <br/><span class="resum-carta-iva">(IVA '+l("inclòs")+')</span></h3></td><td></td></tr>';
	}
	$("#caixa-carta").html(taula);
	
	$("#resum-comanda").html(plats);
	$("#resum-preu").html(total);
	$("#te-comanda").val(plats);
	$("#te-comanda").change();
}


/********************************************************************************************************************/
/********************************************************************************************************************
COMPORTAMENT EXCEPCIONS STESTEVE,ANYNOU,REIS
*/
function updateMenus(){
	var dat=$("#calendari").datepicker("getDate");	
	var excepcioNadal=excepcio_nadal(dat);
	
	$("#carta_MENUS tr").show();
	
	$("#bt-carta").show();
	$("#fr-carta-tabs").show();
	//$("#bt-menu span").html(l("Veure els menús"));

	if (excepcioNadal){
		/*
		 * MENUS
		 */
		$("#bt-menu span").html(l("Menús Nadal"));		
		$("#carta_MENUS tr").hide();
		$("#carta_MENUS tr[producte_id=2012]").show(); //N3
		$("#carta_MENUS tr[producte_id=2035]").show(); //infantil
		$("#carta_MENUS tr[producte_id=2037]").show(); //infantil
		$("#carta_MENUS tr[producte_id=2036]").show(); //junior
		$("#carta_MENUS tr[producte_id=2001]").show(); //n1
		$("#carta_MENUS tr[producte_id=2003]").show(); //n2
		$("#carta_MENUS tr[producte_id=2007]").show(); //n4		
		$("#carta_MENUS tr[producte_id=2010]").show(); //calsotada		
		/*
		 * CARTA
		 */
		$("#bt-carta").hide();
		$("#fr-carta-tabs").hide();
		
	}
}

/********************************************************************************************************************/
function excepcio_nadal(dat){
	//alert(ACTIVA_DIES_ESPECIALS?"T":"F");
	if (ACTIVA_DIES_ESPECIALS=="false") return false;
	var excepcio=false;
	if (dat.getDate()==26 && dat.getMonth()==11) excepcio=true; //stesteve
	if (dat.getDate()==1 && dat.getMonth()==0) excepcio=true; // any nou
	if (dat.getDate()==6 && dat.getMonth()==0) excepcio=true; //reis
	
	//va1ida si es obligatori triar menu
	/*
*/
	if (excepcio){
		var totalComensals=$("input[name=totalComensals]").val();
		$("#te-comanda").rules("add", {
			required: true,
			min: totalComensals,
			 messages: {
				    required: l('err56'),
				    min: l('Número menús insuficiente')
				  }				
		});
	}
	else{	
	//alert("remove rules");	
            $("#te-comanda").rules("remove");
	}
	
	return excepcio;
}