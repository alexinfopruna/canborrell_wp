var SELF = window.location.pathname.substring(window.location.pathname.lastIndexOf("/")+1) || "index.html";						


$(function(){				
	if (EDITABLE)
	{
	  var t = $('#grid')
	  var options = {editDone:onEdit,"iDisplayLength": 50}
	  //$.uiTableEdit( t, options ) // returns t
            //
                    
             // $("td[tipus=TIPUS]")
                      $("td.no-bool").editInPlace({
               url: EDITABLE,
               show_buttons: true,
               saving_image: "../css/loading.gif"

           });	
            $("td.bool").editInPlace({
               url: EDITABLE,
               show_buttons: true,
               saving_image: "../css/loading.gif",
		field_type: "select",
		select_options: "true, false"

           });	
           /*
            $("td.calend").editInPlace({
               url: EDITABLE,
               show_buttons: true,
               saving_image: "../css/loading.gif",
		field_type: "select",
		select_options: "true, false"

           });	           
           */
        }

	$('#edit').dialog({
		autoOpen: false,
		width: 1000,
		height:640,
		modal:true,
		buttons: {
			"Guarda": function() { 
					if (!$("form.form-edit").validate().form()) return alert("Les dades no s�n correctes!");
					$("form.form_"+TABLE).ajaxSubmit({success:afterEdit});					
				
					$(this).dialog("close"); 
					return false;
				},			
			"Tanca": function() { 
				$(this).dialog("close"); 
			}
		}			
	});
	
	$('#popup').dialog({
		autoOpen: false,
		width: 700,
		height:400,
		modal:true,
		buttons: {
			"Tanca": function() { 
				$(this).dialog("close"); 
				}			
			}
		});
		
		addTableListeners();
		if (IDR) $("td[idR="+IDR+"][col='idR']").trigger("click");
		
		$("#grid").dataTable({
			"bJQueryUI": true,					
			"bStateSave": true,
			"sPaginationType": "full_numbers"
		});				
		$("#popup_cercador").show("fade");
});

function onEdit(a,b,c,d)
{
	var idr=$(d).attr("idr");
	var cl=$(d).attr("col");
	
	var desti="";
	$.post(desti,{val:a,be:b,edit_id:idr,edit_col:cl});

}

function addTableListeners()
{
	$("#grid td a").click(function(e)
	{	
		var desti=$(this).attr("href");
		var col=$(this).parent().attr("col");
		
		if (col=="ui_icon_trash" && !confirm("Segur que vols eliminar el registre?\n\nAquesta acció és irreversible")) return false;
		
		$.ajax({url:desti,success:procesaRespostaAjax});
		return false;
	});

}


function procesaRespostaAjax(resposta)
{
	if(resposta.substring(0,1)!="{") 
	{
			edit(resposta);
			return false;		
	}
	else
	{
		var resp=JSON.parse(resposta);

		if (resp.resultat=="ko") 
		{
			popup("No s'ha pogut completar l'acció:<br/><br/>Error "+resp.n_error+"\n\n"+resp.m_error);
		}	
		else if (resp.dialog) 
		{
			edit(resposta);
		}	
		
		if (resp.refresh) 	document.location.href=SELF;

		return false;
	}
	

	return true;
}

function popup(mensa)
{
	$("#popup").html(mensa);
	$("#popup").dialog("open");
}
function edit(dades)
{
	$("#edit").html(dades);
	//addHandlersEditor();
	$("#edit").dialog("open");
}
function valida(form, optionsValidatorEdit)
{
	alert("valida");
	$(form).validate(optionsValidatorEdit);
}


function afterEdit()
{
	location.reload(true);
}