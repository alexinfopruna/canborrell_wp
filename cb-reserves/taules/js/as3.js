function getFlashMovie(movieName) {
	var isIE = navigator.appName.indexOf("Microsoft") != -1;
	var ret= (isIE) ? window[movieName] : document[movieName];
	return ret;
}


function fromAS3_print()
{
    if (!PRINT) return;
    PRINT=false;
    window.location="print.php?p";
}

function fromAS3_flash_ready()
{
	getFlashMovie("flash").canviData(date_session);	$("#flash").show();

}

function fromAS3_novaReserva(taula,n,p,c,f)
{
	
	$(".dades_client").hide();
	$(".dades_client").html("");
	TAULA=taula;
	N=n;
	P=p;
	C=c;
	F=f;
	
	var dta=$("#calendari").datepicker("getDate");
	
	dtb=$.datepicker.formatDate("DD, d 'de' MM 'del' yy", dta, {dayNamesShort: $.datepicker.regional['ca'].dayNamesShort, dayNames: $.datepicker.regional['ca'].dayNames, monthNamesShort: $.datepicker.regional['ca'].monthNamesShort, monthNAmes: $.datepicker.regional['ca'].monthNames});
	
	var torn=$("input[name='radio']:checked").val();
	$("#confirma_data_dia").html(dtb);
	$("#confirma_data_torn").html(torn);
	
	fromDialog_novaReserva(TAULA,N,P,C,F);

	
	$("#calendari_confirma").datepicker("destroy");
	canvia_data_confirma=false;
	
	
}

function fromAS3_editReserva(id,n,p,c,f)
{
	var setHora="";
	
	if (!validaData()) return;
	permuta=0;
	if (n==-1) permuta=c;
	
	var hora=$("#zoom input[name='hora']:checked").val();
	$("#zoom input[name='hora']:checked").attr('checked', false);
	$("#zoom input[name='hora']:checked").val("");
	if (hora!="" && hora!=null) setHora="&hora="+hora;
	
	var desti="form_reserva.php?edit="+id+"&id="+id+"&permuta="+permuta+setHora;
	$("#edit").html('<div class="loading"></div>');
	timer(false);
	$('#edit').dialog('open');
	$("#fr-cartaw-popup").remove();
        $("#fr-menu-popup").remove();
	$.ajax({url: desti,	success: function(datos){
			$("#edit").html(decodeURIComponent(datos));
                        
                        
                        
			addHandlersEditReserva();
			$(".missatge_dia").html($("#ta_missatge_dia").val());
			P=$("form.updata_res .places").html();
			C=$("form.updata_res .cotxets").html();
			F=$("form.updata_res .plena").html();
		
			$("form.updata_res").validate();
			$(".updata_res input[name=total]").rules("add",{personesInsert:true});
			$(".updata_res input[persones]").change(function(){
				var total=0+Number($(".updata_res input[name=adults]").val())+Number($(".updata_res input[name=nens4_9]").val())+Number($(".updata_res input[name=nens10_14]").val());
				$(".updata_res input[name=total]").val(total);
	
			});
				
			if (permuta) 
			{
				$(".updata_res input[name=cb_sms]").attr("checked",false);	
			}
			
			$('#edit').dialog('option', 'title', 'Edita reserva '+$("#spanidr").html());
		 }		
	});
	e.preventDefault();
	return false;

}

function fromAS3_permuta(orig,desti,res)
{
	fromAS3_editReserva(res,-1,orig,desti,0);
}

function fromAS3_canviData_ready()
{
	$( "#radio input" ).button( "enable" );$("#calendari").datepicker("enable");	
	$("#zoom").removeClass("calendari-loading");

}