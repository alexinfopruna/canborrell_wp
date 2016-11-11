var browser_malo = (navigator.appVersion.indexOf("MSIE 7.") != -1);

//var TIMER_INTERVAL = 110000;
var TIMER_INTERVAL = 110000;

var GESTOR = "/cb-reserves/reservar/Gestor_form.php";
var client_auto = true;
var TAULA = 0;
var DATA = "01/01/2011";
var TORN = "0";
var SECCIO = null;//SECCIO QUE S'ESTÀ EDITANT

var ADULTS = 0;
var JUNIORS = 0;
var NENS = 0;
var COTXETS = 0;

var DEBUG = getParameterByName("debug");

var SUBMIT_OK = false;
var resub = false;

var SECCIO_INICIAL = "fr-seccio-quants";

var dlg = {
    autoOpen: false,
    modal: true,
    width: '400px',
    buttons: {
        "Continuar": function () {
            $(this).dialog("close");
            //$(this).dialog('destroy');
            //if (!SECCIO) seccio(SECCIO_INICIAL);
            SECCIO_INICIAL = null;
        }
    },
    close: tanca_dlg
};


if (typeof permisos === 'undefined')
    permisos = 0;
if (typeof COMENSALS_AVIS_VARIACIO === 'undefined')
    COMENSALS_AVIS_VARIACIO = 8;



if (browser_malo)
{
    alert("El sistema de reservas requiere Internet Explorer 7 o superior\n\nVersión utilizada:\n Microsoft Internet Explorer " + $.browser.version);
    document.location.href = "../";
}




/* PROBLEMA IE indexOf */
if (!Array.prototype.indexOf)
{
    Array.prototype.indexOf = function (elt /*, from*/)
    {
        var len = this.length;

        var from = Number(arguments[1]) || 0;
        from = (from < 0)
                ? Math.ceil(from)
                : Math.floor(from);
        if (from < 0)
            from += len;

        for (; from < len; from++)
        {
            if (from in this &&
                    this[from] === elt)
                return from;
        }
        return -1;
    };
}

$(function () {


    $(window).on('resize', function(){
        jQuery("#container").css("margin-top",jQuery(".navbar-header").height());
    }).resize();
    
        $('.navbar-toggle').click(function () {
       //$('#navbar').toggleClass('collapse');
       if ($('#navbar').is(':visible'))
        $('#navbar').hide("slow");
    else
        $('#navbar').show("slow");
  });

    /* popupGrups */
    $("#popupGrups").dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        buttons: {
            t: function () {
                //document.location.href = "form_grups.html";
                document.location.href = "/reservar/reserva-grup/";
            },
            "Modificar": function () {
                $(this).dialog("close");
            }
        }
    });
    $("#popup").dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        buttons: {
            "Continuar": {
                text: 'Continuar',
                id: 'bt-continuar',
                click: function () {

                    $(this).dialog("close");
                }
            }
        }
    }
    );
    $(".ncoberts").html(PERSONES_GRUP - 1);
    var t = setTimeout("ctimer()", TIMER_INTERVAL);

    $("#flogin").hide();
    $(".cb-contacte").click(function () {
        $.scrollTo("#table_menu", 600, {offset:-100 });
        $("#a_consulta_online.r-petita").trigger("click")
    });
    $("#a_editar_reserva").click(function () {
        if ($("#form_contactar").is(':visible'))
            $("#form_contactar").toggle('low');
        $("#flogin").toggle('low');
    });

    $("#form_contactar.r-petita").hide();
    $("#a_consulta_online.r-petita").click(function () {
        if ($("#flogin").is(':visible'))
            $("#flogin").toggle('low');
        $("#form_contactar").toggle('low');
    });
    //loginoff();

    if (!IDR)
        $(".contador").val(0);



    $("#cancel_reserva").click(function () {
        if (!confirm(l("Segur que vols eliminar la teva reserva?")))
            return false;
        else
            return true;
    })

    $('#form-reserves').resetForm();

    $("#selectorComensals").buttonset();
    $("#selectorComensals").find("label").unbind("mouseup");
    $("#selectorJuniors").buttonset();
    $("#selectorJuniors").find("label").unbind("mouseup");
    $("#selectorNens").buttonset();
    $("#selectorNens").find("label").unbind("mouseup");
    $("#selectorCotxets").buttonset();
    $("#selectorCotxets").find("label").unbind("mouseup");
    $("#selectorCadiraRodes").buttonset();
    $("#selectorCadiraRodes").find("label").unbind("mouseup");

    $("input[type=submit]").button();
    $("input[type=submit]").find("label").unbind("mouseup");

    $("#selectorComensals input[value=grups]").click(function () {
        window.location.href = "/reservar/reserva-grup/?lang="+lang;
        return false;
    })
    $("button, .bt").button();
    $("button, .bt").find("label").unbind("mouseup");




    $("#cotxets0").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(0);
    });
    $("#cotxets1").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(0);
    });
    $("#cotxets2").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(0);
    });
    $("#cotxets2A").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(2);
    });
    $("#cotxets2L").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(3);
    });

    $("#info_reserves").click(function () {
        $("#popup").html($("#reserves_info").html())
        $("#popup").unbind("dialogclose");
        $("#popup").dialog("open");
        return false;
    });

    validacio();

    /********  AMAGA PANELLS ********/

    if (!IDR && !DEBUG)
    {
        /**/

        $(".fr-seccio-dia").amaga();
        $(".fr-seccio-hora").amaga();
        $(".fr-seccio-carta").amaga();
        $(".fr-seccio-client").amaga();
        $(".fr-seccio-submit").amaga();
    }

    if (IDR)
    {
        ADULTS = $("input[name='selectorComensals']:checked").val();
        JUNIORS = $("input[name='selectorJuniors']:checked").val();
        NENS = $("input[name='selectorNens']:checked").val();
        COTXETS = $("input[name='selectorCotxets']:checked").val();

        monta_calendari("#calendari");
        recargaHores();
        comportamentCarta();
        $(".fr-seccio-client input").attr("readonly", true);
        $(".fr-seccio-client input[name='client_email']").removeAttr("readonly");
        $(".fr-seccio-client input[name='esborra_dades']").removeAttr("readonly");
    }
    /**************************/
    comportamentQuantsSou();
    controlSubmit();
    $("body").fadeIn("slow");
    /*********** HEEELP *************/
   // $("#help").dialog(dlg);
    help();

    $(".info-ico").click(function (e) {

        id = $(this).attr("id");
        // $( "#help" ).dialog( "option", "position", { my: "center bottom", at: "center bottom",of: e} );
        help($("." + id).html());
        e.preventDefault();
    });

    $("textarea[name='observacions']").change(observacions_cotxets);
    $('.pastis_toggle').toggle($('#RESERVA_PASTIS').prop("checked"));
    $('#RESERVA_PASTIS').change(function () {
        $('.pastis_toggle').toggle(this.checked);
    }).change(); //ensure visible state matches initially

    /* */
    var d = new Date();
    var rand = d.getTime();
    var desti = "/cb-reserves/taules/dumpBD.php?drop&file&hores=4";
    $.post(desti, {r: rand}, function (datos) {
        if (datos == "backup" && permisos > 64)
            alert("S'ha realitzat una còpia de la base de dades");
    });
   
   // Si ens passen la data
  // if (typeof rdata != 'undefined')  setCalendDate(rdata);
   if (typeof obre_contacte != 'undefined')  {
       $("#a_consulta_online.r-petita").click();
      // $("#caixa_reserva_consulta_online").css("background-color",'yellow').delay(3).css("background-color",'gold');
        $("#caixa_reserva_consulta_online").dialog({modal:true});
   }//click();
   
   if (RDATA > ""){
             monta_calendari("#calendari");
            $(".fr-seccio-dia").show();
            SECCIO = "fr-seccio-dia";
            //updateCalendari();   
   }
  document.body.scrollTop = document.documentElement.scrollTop = 0;
}); //ONLOAD, PRESENTACIO UI
//***********************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/
/************************************************************************************************************/














/************************************************************************************************************/
/************************************************************************************************************/
/**********************************             FUNCIONS             ****************************************/
/************************************************************************************************************/
/************************************************************************************************************/
/********************************************************************************************************************
 COMPORTAMENT QUANTS SOU > CALENDARI
 */
function comportamentQuantsSou()
{
    //ADULTS
    SECCIO = "fr-seccio-quants";
    
    //update_debug();
    $(".fr-seccio-quants").change(function (e) {
        
        ADULTS = $("input[name='selectorComensals']:checked").val();
        JUNIORS = $("input[name='selectorJuniors']:checked").val();
        NENS = $("input[name='selectorNens']:checked").val();
        COTXETS = $("input[name='selectorCotxets']:checked").val();

        $("input[name='adults']").val(ADULTS)
        totalPersones();
 console.log(ADULTS);
        if (!ADULTS){
               $("input[name=selectorComensals]").change(function (e) {
    });
     return;
        }
            avis_modificacions(e);
    });

    $("input[name=selectorComensals]").change(function (e) {
        avis_modificacions(e);
    });
    
    //JUNIORS
    /*
    $("input[name=selectorJuniors]").change(function () {
        JUNIORS = $("input[name='selectorJuniors']:checked").val();
        $("input[name='nens10_14']").val(JUNIORS)
        $.scrollTo("#titol_SelectorNens", 600, {offset:-100 });
    });
/*/
    //NENS
    $("input[name=selectorNens]").change(function () {
        NENS = $("input[name='selectorNens']:checked").val();
               ADULTS = $("input[name='selectorComensals']:checked").val();
        console.log(ADULTS);
        
        $("input[name='nens4_9']").val(NENS);
        
        if (!ADULTS) $.scrollTo("#titol_SelectorComensals", 600, {offset:-100 });
        else $.scrollTo("#titol_SelectorCotxets", 600, {offset:-100 });
    });

    //COTXETS
    $("input[name=selectorCotxets]").change(function () {
        help(l("NENS_COTXETS"));
    });
}

/********************************************************************************************************************
 TOTAL PERSONES
 */
function totalPersones()
{
    var na = parseInt($("input[name='adults']").val());
    var nj = parseInt($("input[name='nens10_14']").val());
    var nn = parseInt($("input[name='nens4_9']").val());

    na = na ? na : 0;
    nj = nj ? nj : 0;
    nn = nn ? nn : 0;
    var total = na + nj + nn;

    $("input[name='totalComensals']").val(total);



    var cotxets = $("input[name='selectorCotxets']:checked").val() ? $("input[name='selectorCotxets']:checked").val() : '0';

    $("input[name='totalCotxets']").val("/ " + cotxets);
    if (total >= PERSONES_GRUP) {
        monta_calendari("#calendari");
        comportamentDia();

        if (confirm(l("REDIR_GRUPS"))) {
         //   window.location.href = "form_grups.php?a=redir&b=" + na + "&c=" + nj + "&d=" + nn + "&e=" + cotxets;
            window.location.href = "/reservar/reserva-grup/?a=redir&b=" + na + "&c=" + nj + "&d=" + nn + "&e=" + cotxets;
            $("body").fadeOut();
        }

        $("#selectorComensals input").prop('checked', false);
        $("#selectorComensals").buttonset('refresh');
        $("#selectorJuniors input").prop('checked', false);
        $("#selectorJuniors").buttonset('refresh');
        $("#selectorNens input").prop('checked', false);
        $("#selectorNens").buttonset('refresh');
        $("input[name='adults']").val("");
        $("input[name='nens10_14']").val("");
        $("input[name='nens4_9']").val("");
        $("input[name='totalComensals']").val(0);
    }

    if ($(".fr-seccio-hora").is(":visible"))
        recargaHores();


    return total;
}


/********************************************************************************************************************
 COMPORTAMENT DIA > HORES
 */
function comportamentDia()
{
    $("#calendari").change(function () {
        var dat = $("#calendari").datepicker("getDate");
        var minData = new Date();
        //DIA HORA LIMIT
        minData.setDate(minData.getDate() + MARGE_DIES_RESERVA_ONLINE);
        var h = MAX_HORA_RESERVA_ONLINE.split(":")[0];
        var m = MAX_HORA_RESERVA_ONLINE.split(":")[1];
        minData.setHours(h, m, 0);

        var maxData = new Date();
        maxData.setDate(maxData.getDate() + 365);

        var ara = new Date();
        var avui = new Date();
        avui.setHours(0, 0, 0, 0);

        // NO ACCEPTEM PASSAT NI +1ANY NI PASSAR MARGE PEL MATEIX DIA
        if ((dat < avui) || (ara > minData && dat == avui) || (dat > maxData))
        {
            alert(l("Ho semtim.\n\nNo podem reservar per la data que ens demanes"));
            return false;
        }
        ;

        if ($(".fr-seccio-hora").is(":hidden"))
            $(".fr-seccio-hora").slideDown("slow", function () {
                seccio("fr-seccio-hora");
            });
        recargaHores();
        $("#resum-data").html($("#calendari").val());
        $("#valida_calendari").val($("#calendari").val());
        $("#form-reserves").validate().element("#valida_calendari");

        updateMenus();

        return true;
    });
}

function recargaHores()
{
    $("#selectorHora").html('<img src="/cb-reserves/reservar/css/loading.gif"/>');
    $("#selectorHoraSopar").html('<img src="/cb-reserves/reservar/css/loading.gif"/>');

    var hora = $("input[name='hora']:checked").val();
    if (HORA != '')
    {
        hora = HORA;
        HORA = "";
    }

    var comensals = $("input[name='totalComensals']").val();

    var accesibilidad = $("input[name='selectorCadiraRodes']:checked").length;
    accesibilidad += $("input[name='selectorAccesible']:checked").length;

    $.post(GESTOR + "?a=horesDisponibles&b=" + $("#calendari").val() + "&c=" + comensals + "&d=" + $("input[name='selectorCotxets']:checked").val() + "&e=" + accesibilidad + "&f=" + IDR +"&g=" + NENS, function (dades) {
        var obj = JSON.parse(dades);
        var txt = "";
        if ((obj.dinar + obj.dinarT2) == "")
            txt = l("Cap taula o restaurant tancat");
        $("#selectorHora").html(obj.dinar + obj.dinarT2 + txt);
        $("#selectorHora").buttonset();
        $("#selectorHora").find("label").unbind("mouseup");
        txt = "";
        if (obj.sopar == "")
            txt = l("Cap taula o restaurant tancat");
        $("#selectorHoraSopar").html(obj.sopar + txt);
        $("#selectorHoraSopar").buttonset();
        $("#selectorHoraSopar").find("label").unbind("mouseup");

        //ALERTA SI NO HI HA TAULA
        if ((obj.dinar + obj.dinarT2 + obj.sopar) == "")
        {
            $("#popup").html(l("CAP_TAULA"));
            $("#popup").dialog("open");
        }

        if (!$("input[value='" + hora + "']"))
            alert(l("Ho lamentem, no queda cap taula pel dia, hora i coberts que sol·licites"));

        $("input[value='" + hora + "']").prop("checked", true).button("refresh");

        $("input[name='taulaT1']").val(obj.taulaT1);
        $("input[name='taulaT2']").val(obj.taulaT2);
        $("input[name='taulaT3']").val(obj.taulaT3);

        $(".fr-seccio-hora").unbind();
        $(".fr-seccio-hora").change(function () {
            //recargaHores();
            bloqueigTaula();

            if ($("input[name='hora']:checked").val())
                comportamentCarta();
            $("#resum-hora").html($("input[name='hora']:checked").val());

            updateResum();

        })
        $(".fr-seccio-hora").trigger("change");
    });

}



/********************************************************************************************************************/
function bloqueigTaula(forsat)
{
    var torn = $("input[name='hora']:checked").attr("torn");
    var taula = $("input[name='taulaT" + torn + "']").val();
    var data = $("#calendari").val();
    if ((taula && taula != TAULA) || data != DATA || torn != TORN || forsat)
    {
        $.post(GESTOR + "?a=bloqueig_taula&b=" + TAULA + "&c=" + DATA + "&d=" + TORN + "&e=1", function (dades) {

            if (taula)
                $.post(GESTOR + "?a=bloqueig_taula&b=" + taula + "&c=" + data + "&d=" + torn, function (dades) {
                    if (dades == "ko")
                    {
                        recargaHores();
                    }
                    else
                        torn = torn;
                });
        });
        TAULA = taula;
        TORN = torn;
        DATA = data;
    }
}

/********************************************************************************************************************
 COMPORTAMENT CARTA
 */
function comportamentCarta()
{
    if ($(".fr-seccio-carta").is(":hidden"))
        $(".fr-seccio-carta").slideDown("slow", function () {
            seccio("fr-seccio-carta");
        });

    $("#bt-no-carta").click(function () {
        //  $("textarea[name='observacions']").val("comportamentCarta -CLICK ");/******/
        comportamentClient();
        return false;
    });

    $(".resum-carta-nom").click(function (e) {
        $(this).closest("tr").find("td.mes a").trigger("click");
        e.preventDefault();
        return false;
    });
}

/********************************************************************************************************************
 COMPORTAMENT CLIENT
 */
function comportamentClient()
{
    /*    $("textarea[name='observacions']").val("comportamentClient");
     
     $(".fr-seccio-submit").show();
     $(".fr-seccio-submit").css("display","block");
     $(".fr-seccio-submit").css("visibility","visible");
     *****/
    $("#bt-no-carta").hide();
    $("input[name='client_mobil']").change(function () {
        var n = $("input[name='client_mobil']").val();
        if (n.length >= 9 && isNumber(n))
            updateClient();
    });
    $(".fr-seccio-client input[name='client_email']").change(function () {
        if ($(this).valid())
            updateClient();
    });


    if ($(".fr-seccio-client").is(":hidden"))
        $(".fr-seccio-client").slideDown("slow", function () {
            seccio("fr-seccio-client");
        });
    $(".fr-seccio-client input").bind('blur change ', validaDadesClient);
    $(".fr-seccio-client").bind('blur change ', validaDadesClient);

}

function validaDadesClient() {

    // $("textarea[name='observacions']").val("zz");
    var ok = true;
    ok = ok && $("input[name='client_mobil']").val();
    ok = ok && $("input[name='client_nom']").val();
    ok = ok && $("input[name='client_cognoms']").val();

    var t = "--------";
    t += " ok= " + (ok ? "ok " : "nok ");
    t += $("input[name='client_nom']").val();
    t += " ** ";
    t += $("input[name='client_cognoms']").val();
    t += ($(".fr-seccio-submit").is(':hidden') ? " HID " : " VIS ");
    //$("textarea[name='observacions']").val(t);
    /*
     */
    updateResum();
    if (ok)
    {
        if ($(".fr-seccio-submit").is(":hidden")) {
            $(".fr-seccio-submit").show();
            $(".fr-seccio-submit").css("display", "block");
            $(".fr-seccio-submit").css("visibility", "visible");

            $.scrollTo("#scroll-seccio-submit", 800, {offset:-100 });
        }

    }

    else {
        //alert(t);
    }
}

/********************************************************************************************************************/
function updateClient()
{
    var num = $("input[name='client_mobil']").val();
    var email = $(".fr-seccio-client input[name='client_email']").val();

    $.post(GESTOR + "?a=recuperaClient&b=" + num + "&c=" + email, function (dades) {

        if ((dades == 'false' || dades == 'err0') && client_auto)
        {
            resetClient();
            $(".fr-seccio-client input[name='client_email']").val(email);
        }

        //if(dades!='false' && dades!='err0')
        else
        {
            var obj = JSON.parse(dades);
            if (obj.id_reserva || obj.err)
            {
                $("#popup").html(l("err" + obj.err));
                $("#popup").dialog("open");

                resetClient();
                $(".fr-seccio-client input[name='client_mobil']").val("");
                $(".fr-seccio-client input[name='client_mobil']").removeAttr("readonly");

                return;
            }

            $(".fr-seccio-client input[name='client_id']").val(obj.client_id);
            //$(".fr-seccio-client input[name='client_mobil']").val();
            if (!num)
                $(".fr-seccio-client input[name='client_mobil']").val(obj.client_mobil);
            $(".fr-seccio-client input[name='client_nom']").val(obj.client_nom);
            $(".fr-seccio-client input[name='client_nom']").attr("readonly", "readonly");
            $(".fr-seccio-client input[name='client_cognoms']").val(obj.client_cognoms);
            $(".fr-seccio-client input[name='client_cognoms']").attr("readonly", "readonly");
            $(".fr-seccio-client input[name='client_email']").val(obj.client_email);
            if ($(".fr-seccio-client input[name='client_email']").val() != "")
                $(".fr-seccio-client input[name='client_email']").attr("readonly", "readonly");
            $(".fr-seccio-client input[name='client_telefon']").val(obj.client_telefon);
            $(".fr-seccio-client input[name='client_telefon']").attr("readonly", "readonly");
            client_auto = true;
            if ($(".fr-seccio-submit").is(":hidden"))
                $(".fr-seccio-submit").slideDown("slow", function () {
                    seccio("fr-seccio-submit");
                });
            validaDadesClient();
            updateResum();
        }
    });
}

function resetClient()
{
    $(".fr-seccio-client input[name='client_id']").val();
    $(".fr-seccio-client input[name='client_nom']").val("");
    $(".fr-seccio-client input[name='client_nom']").removeAttr("readonly");
    $(".fr-seccio-client input[name='client_cognoms']").val("");
    $(".fr-seccio-client input[name='client_cognoms']").removeAttr("readonly");
    $(".fr-seccio-client input[name='client_email']").val("");
    $(".fr-seccio-client input[name='client_email']").removeAttr("readonly");
    $(".fr-seccio-client input[name='client_telefon']").val("");
    $(".fr-seccio-client input[name='client_telefon']").removeAttr("readonly");
    updateResum();
}

/********************************************************************************************************************
 COMPORTAMENT RESUM
 */
function updateResum()
{


    if (parseInt($("input[name='selectorComensals']:checked").val()) > ADULTS)
        adults = $("input[name='selectorComensals']:checked").val();

    $("#resum-data").html($("#calendari").val());
    $("#resum-adults").html(ADULTS);
    $("#resum-juniors").html(JUNIORS);
    $("#resum-nens").html(NENS);
    $("#resum-cotxets").html(COTXETS);
    if ($("input[name='client_email']").val() != "")
        $("#caixa_reserva_consulta_online").removeClass("ui-helper-hidden");
    $("input[name='client_email']").change(function () {
        if ($(this).val() != "")
            $("#caixa_reserva_consulta_online").removeClass("ui-helper-hidden");
        else
            $("#caixa_reserva_consulta_online").addClass("ui-helper-hidden");
    });

    $("#bt_reserva_consulta_online").click(function () {
        $.post(GESTOR + "?a=enviaIncidencia&b=" + $("input[name='id_reserva']").val(), {c: $("textarea[name='reserva_consulta_online']").val()}, function (dades) {
            $("#caixa_reserva_consulta_online").html("<b>Consulta enviada</b>");
        });
        return false;
    });


// De vegades no interpreta bé al click sobre els boton/selects del jquery UI
    jQuery("label.ui-button").mouseup(function (e) {
        $(this).trigger("click");
    });
}
/********************************************************************************************************************/
/********************************************************************************************************************/
/********************************************************************************************************************/
/********************************************************************************************************************/
/********************************************************************************************************************/
/********************************************************************************************************************
 UPDATE CALENDARI
 */
function updateCalendari()
{
}
/********************************************************************************************************************
 MONTA CALENDARI
 */

function monta_calendari(selector)
{
    //var limit_passat=(arxiu=="del" || historic)?-10000:0;
    limit_passat = MARGE_DIES_RESERVA_ONLINE;

    if (!MARGE_DIES_RESERVA_ONLINE)
    {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        hours = hours + ":00";
        var entraAvui = (hours < MAX_HORA_RESERVA_ONLINE) ? 0 : 1;
        limit_passat = entraAvui;
    }



    var defData = new Date();;
    if (RDATA != ""){
        
     //   var msec = Date.parse('10-26-2016');
 defData = new Date(RDATA);
   //     alert(defData);
    }
    $(selector).datepicker("destroy");
    $(selector).datepicker({
        beforeShowDay: function (date, inst) {
            var r = new Array(3);
            if ((date.getDay() == 1 || date.getDay() == 2 || llistanegra(date)) && (!llistablanca(date)) || !taulaDisponible(date))
            {
                r[0] = false;
                r[1] = "maldia";
                r[2] = l("Tancat");
            }
            else
            {
                r[0] = true;
                r[1] = "bondia";
                r[2] = l("Reservar");
            }
            return r;
        },
        //dateFormat : 'mm/dd/yy',
        defaultDate: defData,
        minDate: limit_passat
    });

    //CARREGA IDIOMA
    var lng = lang.substring(0, 2);
    $(selector).datepicker("option",
            $.datepicker.regional[ lng ]);

    if (!RDATA)
    {
        $('.ui-datepicker-calendar .ui-state-active').removeClass('ui-state-active');
        $('.ui-datepicker-calendar .ui-state-hover').removeClass('ui-state-hover');
    }


    /* BLOQUEJA EL DIA SI ESEM EDITANT LA RESERVA PER IMPEDIR QUE ES MODIFIQUI */
    if (typeof BLOQ_DATA !== 'undefined') {
        $(selector).datepicker("option", "minDate", BLOQ_DATA);
        $(selector).datepicker("option", "maxDate", BLOQ_DATA);
    }


}

/********************************************************************************************************************/
function taulaDisponible(date)
{
    //TODO, comprovar si hi ha taula
    return true;
}


/********************************************************************************************************************/
function llistanegra(date)
{
//return false;
    var y = date.getFullYear();
    var m = date.getMonth();     // integer, 0..11
    var d = date.getDate();      // integer, 1..31

    var t = LLISTA_NEGRA[m];

    if (!t)
        return false;
    for (var i in t)
        if (t[i] == d)
            return true;

    return false;
}

/********************************************************************************************************************/
function llistablanca(date)
{
    var y = date.getFullYear();
    var m = date.getMonth();     // integer, 0..11
    var d = date.getDate();      // integer, 1..31

    var t = LLISTA_BLANCA[m];

    if (!t)
        return false;
    for (var i in t)
        if (t[i] == d)
            return true;


    return false;
}

/********************************************************************************************************************/
function validacio()
{
    $("#form-reserves").validate({
        errorContainer: $("#error_validate"),
        debug: true,
        errorElement: "em",
        rules: {
            totalComensals: {
                required: true,
                min: 2,
                max: PERSONES_GRUP - 1
            },
            valida_calendari: "required",
            hora: "required",
            selectorData: "required",
            client_mobil:
                    {
                        required: true,
                        number: true,
                        minlength: 9
                    },
            client_email: {required: true, email: true},
            client_nom: "required",
            client_cognoms: "required"
        },
        messages: {
            totalComensals: {
                required: l("TOTAL!!!"),
                min: l("Selecciona, com a a mínim, dos adults"),
                max: l("Si sou més de " + (PERSONES_GRUP - 1) + " comensals, selecciona la reserva per GRUPS")
            },
            valida_calendari: l("Cal que indiquis el dia"),
            hora: l("Selecciona l´hora"),
            selectorData: l("Selecciona el dia"),
            client_mobil:
                    {
                        required: l("Dona´ns un mòbil"),
                        number: l("Dona´ns un mòbil"),
                        minlength: l("Dona´ns un mòbil")
                    },
            client_email: {required: l("Dona´ns un email"), email: l("El format no és correcte")},
            client_nom: l("Dona´ns el teu nom"),
            client_cognoms: l("Dona´ns els teus cognoms")

        }
    });

    $("#flogin").validate({
        errorElement: "em",
        rules: {
            mob: "required",
            idr: "required"
        },
        messages: {
            mob: l("Aquest camp és necessari"),
            idr: l("Aquest camp és necessari")
        }
    });

    $("#form_contactar").validate({
        errorElement: "em",
        rules: {
            reserva_consulta_online: {required: true, minlength: 10},
            client_email: {required: true, email: true}
        },
        messages: {
            reserva_consulta_online: {required: l("Aquest camp és necessari"), minlength: l("Mínim 10 lletres")},
            client_email: {required: l("Dona´ns un email"), email: l("El format no és correcte")},
            idr: l("Aquest camp és necessari")
        }
    });
}

/********************************************************************************************************************/
function controlSubmit()
{
    if (browser_malo)
        $('#submit').click(function () {
            $('#form-reserves').submit();
        });
    $('#form-reserves').submit(function () {
        if (!$("#form-reserves").valid())
            return false;

        var control = setTimeout(function () {
            timer_submit();
        }, 15000);


        if ($("#popup").is(':visible'))
            SUBMIT_OK = SUBMIT_OK;
        else {
            $("#popup").html('<div style="height:320px"><img src="/cb-reserves/reservar/css/loading.gif"/></div>');
            $("#popup").dialog('open');
        }

        $('#submit').hide();

        $('#form-reserves').ajaxSubmit(function (dades) {
            if (dades.substring(0, 11) != '{"resposta"')
                dades = '{"resposta":"ko","error":"err0","email":false}';
            var obj = JSON.parse(dades);
            clearInterval(control);
            if (SUBMIT_OK)
                return;//DOBLE SUBMIT?????????

            if (obj.resposta == "ok") // RESPOSTA OK
            {
                $("#popup").bind("dialogclose", function (event, ui) {
                    $.post(GESTOR + "?a=cancelPagaISenyal&b=" + obj.idr);
                    window.location.href = "/#about";
                });

                SUBMIT_OK = true;
                SECCIO = null;

                /** 
                 * 
                 * PAGA I SENYAL */
                /*
                 * 
                 */
                if (obj.TPV == "TPV") {
                    $("#td-form-tpv").html(obj.form_tpv);
                    if (getUrlParameter("testTPV") == "testTPV") {
                        $(".ui-dialog").remove();
                        $(".ui-widget-overlay").hide();
                        return false;
                    }

                    var info = l('PAGA_I_SENYAL');
                    $("#popup").html(info + '<iframe id="frame-tpv" name="frame-tpv" style="width:100%;height:500px"></iframe>');

                    $("#bt-continuar .ui-button-text").html("Tanca");

                    /** 
                     * TIMER TEMPS MAXIM
                     */
                    timer = setTimeout(function () {  // RESET 
                        clearTimeout(timer);

                        $.post(GESTOR + "?a=estatReserva&b=" + obj.idr, function (r) {
                            d=parseInt(r);
                            if (d != 100) {
                                alert("La sessió ha caducat");
                                $("#popup").dialog('close');
                            } else {
                                alert("Can-Borrell: Hem registrat correctament el pagament");
                                $("#bt-continuar .ui-button-text").html("Finalitzar");
                                $("#popup").dialog('close');

                            }
                        });
                    }, temps_paga_i_senyal * 60000);
                    $("#compra").submit();
                }
                /*
                 * 
                 * RESERVA GRATUITA 
                 * 
                 * */
                else {
                    var text = (obj.request == "create") ? $("#popupInfo").html() : $("#popupInfoUpdate").html();
                    $("#popup").html(text + $(".resum").html());
                }
            }
            else
            {
                var err = "Error de servidor";
                if (obj && obj.error)
                    err = obj.error + "\n <br>" + l(obj.error) + " <br><br>\n\n" + l("err_contacti");
                if (obj.error == "err10")
                    return;//DOBLE SUBMIT?????????
                $("#popup").html("ERROR: " + err);
                $('#submit').show();
            }

            $("#popup").dialog('open');
        });
        return false;
    });
}

function timer_submit() {
    alert(l('err0'));
    $('#submit').show();

    var comensals = $("input[name='totalComensals']").val();
    var tel = $(".fr-seccio-client input[name='client_telefon']").val();

    $("#popup").dialog('close');


}
/********************************************************************************************************************/
/********************************************************************************************************************/
function isNumber(n) {
//	return true;
    var a = isNaN(parseFloat(n));
    var b = isFinite(n);
    return (!a && b);
}/********************************************************************************************************************/
function ctimer( )
{
    bloqueigTaula(true);
    var t = setTimeout("ctimer()", TIMER_INTERVAL);
}

function roundNumber(num, dec) {
    var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
    return parseFloat(result.toFixed(dec));
}

function getParameterByName(name)
{
    name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
    var regexPS = "[\\?&]" + name;
    var regexS = "[\\?&]" + name + "=([^&#]*)";
    var regex = new RegExp(regexS);
    var param = new RegExp(regexPS);
    var results = regex.exec(window.location.search);
    if (results == null)
        if (param.exec(window.location.search))
            return true;
        else
            return false;
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}

function loginon()
{
    $("#editar_reserva").unbind('click');
    $("#flogin").show();

    $("#editar_reserva").click(function () {
        $("#editar_reserva").stop().animate({"margin-top": "0px", "height": "14px"}, 400, 'swing', loginoff);
    });
}
function loginoff()
{
    $("#editar_reserva").css('margin-top', 0);
    $("#flogin").hide();
    $("#editar_reserva").unbind('click');
    $("#editar_reserva").click(function () {
        $("#editar_reserva").stop().animate({"margin-top": "-160px", "height": "174px"}, 400, 'swing', loginon);
    });
}

function seccio(selector_seccio) {
    if (!selector_seccio)
        return;

    $.scrollTo("." + selector_seccio, 800, {offset:-100 });
    SECCIO = selector_seccio;
}


function observacions_cotxets()
{
    var obs = $("textarea[name='observacions']").val();
    if (obs.match(/cotxet|carret|person|nen|comensal|cobert|cochecito|carrito|niñ|cubierto/gi)) {
        $("#help").html(l("OBSERVACIONS_COTXETS"));
        $("#help").dialog("open");
    }

}




function tanca_dlg() {
    //   $("#taula-estructura").removeClass("fals-overlay");
    $("#td_contingut").removeClass("fals-overlay");
    if (!SECCIO)
        seccio(SECCIO_INICIAL);
}


function calc() {


    document.getElementById('boto').style.display = 'none';
    vent = window.open('', 'frame-tpv', 'width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
    document.compra.submit();
}

function avis_modificacions(e) {
   // $("input[name=selectorComensals]").unbind("change");
    var secc = SECCIO;
    SECCIO = null;
    
    var adults = $("input[name='selectorComensals']:checked").val()
    /*
    
    if (adults < 6) {
        $.scrollTo("#titol_SelectorNens", 600, {offset:-100 });
        return false;
    }
*/
    help($("#avis-modificacions").html());

      if ($(".fr-seccio-dia").is(":hidden"))
        {
            monta_calendari("#calendari");
            $(".fr-seccio-dia").show();
            SECCIO = "fr-seccio-dia";
            updateCalendari();
            comportamentDia();
        }


        if (typeof RDATA != 'undefined'){
           comportamentDia();
           recargaHores();
           $(".fr-seccio-hora").show();
            $.scrollTo("#titol_SelectorNens", 600, {offset:-100 });
            //$("#calendari").change();
        }
        else{
             $.scrollTo("#titol_SelectorNens", 600, {offset:-100 });
            SECCIO = 'fr-seccio-dia';



        }  
}

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

function setCalendDate(date){
              monta_calendari("#calendari");
              
             var dt=new Date(date);
            // alert(date);
            $(".fr-seccio-dia").show();
            SECCIO = "fr-seccio-dia";
            updateCalendari();  
             $('#calendari').datepicker("setDate", dt );
            comportamentQuantsSou();
            //$.scrollTo("#table_menu", 600);
            window.scrollTo(0, 0);
           // comportamentDia();

   
}