var zoom=false;

$(function(){
	$('#form_missatge_dia').dialog({
		autoOpen: false,
		modal:true,
		width: 600,
		buttons: {
			"Actualitza": function() { 
				$(this).dialog("close"); 
				refresh();
				timer(true);
				guarda_missatge_dia();
			}, 
			"Tanca": function() { 
				$(this).dialog("close"); 
				timer(true);
			} 
		}
	});
	
	
	$("#menu_missatge_dia a").click(function(){
		//$("#ta_missatge_dia").val("");
		timer(false);
		$('#form_missatge_dia').dialog("open");
		return false;
	});
	
	$("#zoom .calendari").hide();
	$("#zoom #radio").hide();
	$("#zoom #radio_hores_calend").hide();
	$("#zoom #totals-torn").hide();
	
	
// ZOOM CALENDARI
	$("#zoom").mouseenter(zoomon);
	$("#radio_hores_calend").mouseup(zoomoff);
});

function guarda_missatge_dia()
{
	var desti=$("#menu_missatge_dia a").attr("href");
	$.post(desti, { p: $("#ta_missatge_dia").val() },
	   function(data) {
		 	$('.missatge_dia').html(data);
	   });
}

function zoomon()
{		
	$("#zoom").unbind();
	$("#zoom").mouseleave(zoomoff);
	var currentMonth=new Date().getMonth()+1;	
	var comprovaMes= !$("#zoom .calendari").is(':visible');
	//avui(); // ANULAT RECULA AVUI
	
	
	$("#zoom").removeClass("zoompetit");
	$("#zoom").addClass("zoom");
	$("#zoom img").hide();
	$("#zoom .comensals").hide();
	$("#zoom .calendari").show();
	$("#zoom #totals-torn").show();
	$("#selectorCotxetsCerca").show();
	
	$("#zoom #radio").show();
	$("#selectorComensals").show();
	$("#zoom input[name='hora']:checked").attr('checked', false);
	$("#radio_hores_calend input[name='hora']").button("refresh");
	
	$("td.ui-datepicker-today a.ui-state-highlight").removeClass("ui-state-highlight");
	
	//ALEX ANULAT MES CORRENT if (comprovaMes && currentMonth != $("#calendari").val().split("/")[1]) alert("ATENCIO: NO ÉS EL MES CORRENT");
	
}

function zoomoff()
{
	$("#zoom").unbind();
	$("#zoom").mouseenter(zoomon);
	$("#zoom").removeClass("zoom");
	$("#zoom").addClass("zoompetit");
	$("#zoom img").show();
	$("#zoom .comensals").show();
	$("#zoom .calendari").hide();
	$("#zoom #totals-torn").hide();
	$("#zoom #radio").hide();
	$("#zoom #radio_hores_calend").hide();
	$("#zoom #radio_hores_calend").css("display","none");
	$("#selectorComensals input:checked").css("font-size","3em");
	$("#selectorComensals input:checked").attr("checked",false);
	$("#selectorComensals input").button("refresh");
	$("#selectorCotxetsCerca input:checked").css("font-size","3em");
	$("#selectorCotxetsCerca input:checked").attr("checked",false);
	$("#selectorCotxetsCerca input[value=0]:checked").attr("checked",true);
	$("#selectorCotxetsCerca input").button("refresh");
	$("#selectorComensals").hide();
	$("#selectorCotxetsCerca").hide();
	$("#cercaTaulaResult").html("Quants coberts?");

}

function avui()
{
		var d=new Date();
		while ((d.getDay()==1 || d.getDay()==2 || llistanegra(d)) && (!llistablanca(d))) d.setDate(d.getDate()+1);
		var avui=d.getFullYear()+"-"+d.getMonth()+"-"+d.getDay();
		var c=$("#calendari").datepicker("getDate");
		c=c.getFullYear()+"-"+c.getMonth()+"-"+c.getDay();
		if(avui==c) return;
		
		$("#calendari").datepicker("setDate",d);
			//$( "#reservesAc" ).accordion('destroy');
			
			var cs=controlaSopars();
			$.ajax({url: "gestor_reserves.php?a=canvi_data&p="+$("#calendari").val()+"&q="+cs,success:recargaAccordioReserves});
			$.get("gestor_reserves.php?a=recupera_missatge_dia",function(data) {$(".missatge_dia").html(data);});
			canvia_data_confirma=true;		
}


function llistanegra(date)
{

var y = date.getFullYear();
var m = date.getMonth();     // integer, 0..11
var d = date.getDate();      // integer, 1..31

var t = LLISTA_NEGRA[m];

if (!t) return false;
for (var i in t) if (t[i] == d) return true;


	return false;
}

function llistablanca(date)
{

var y = date.getFullYear();
var m = date.getMonth();     // integer, 0..11
var d = date.getDate();      // integer, 1..31

var t = LLISTA_BLANCA[m];

if (!t) return false;
for (var i in t) if (t[i] == d) return true;


	return false;
}


function monta_calendari(selector)
{
	var limit_passat=(arxiu=="del" || historic)?-10000:0;
	//limit_passat=-50000;
	$(selector).datepicker({
		defaultDate:new Date(date_session),
		beforeShowDay:function(date){		
			var r=new Array(3);
			if ((date.getDay()==1 || date.getDay()==2 || llistanegra(date)) && (!llistablanca(date)))
			{
				r[0]=false;
				r[1]="maldia";
				r[2]="Tancat";
			}
			else		
			{
				r[0]=true;
				r[1]="bondia";
				r[2]="Obert";			
			}
			return r;
		},
 
		minDate: limit_passat,
		onSelect: function(dateText, inst) { 
                        AC_ACTIU=0;
			if (ONLOAD_BLOC_TORN) $( "#radio input" ).button( "disable");	
			if (ONLOAD_BLOC_CALEND) $("#calendari").datepicker("disable");
			date_session=$(this).val();
						
			//$( "#reservesAc" ).accordion('destroy');
			
			var cs=controlaSopars();
			$.ajax({url: "gestor_reserves.php?a=canvi_data&p="+$(this).val()+"&q="+cs,success:recargaAccordioReserves});
			$.get("gestor_reserves.php?a=recupera_missatge_dia",function(data) {$(".missatge_dia").html(data);});
			canvia_data_confirma=true;
			dtb=$.datepicker.formatDate("DD, d 'de' MM 'del' yy", $(this).datepicker("getDate"), {dayNamesShort: $.datepicker.regional['ca'].dayNamesShort, dayNames: $.datepicker.regional['ca'].dayNames, monthNamesShort: $.datepicker.regional['ca'].monthNamesShort, monthNAmes: $.datepicker.regional['ca'].monthNames});		
			cercaTaula();
		}
	});
}


