var TIMER_INTERVAL = 110000;

var th;//timer d'ajuda
var GESTOR = "/cb-reserves/reservar/Gestor_form.php";
var client_auto = true;
var TAULA = 0;
var DATA = "01/01/2011";
var TORN = "0";
var SECCIO = null;
var SELECT_CARTA=false;
var GRUPS=true;

var DEBUG = getParameterByName("debug");

var shouldElementBeVisible = true;

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
/* PROBLEMA IE indexOf */




/*
 ONLOAD, PRESENTACIO UI
 */
$(function () {
    $("#form_contactar.r-petita").hide();
    $("#a_consulta_online.r-petita").click(function () {
        if ($("#flogin").is(':visible'))
            $("#flogin").toggle('low');
        $("#form_contactar").toggle('low');
    });

    $(".cb-contacte").click(function () {
        $.scrollTo("#table_menu", 600);
        $("#a_consulta_online.r-petita").trigger("click")
    });


    $(".ncoberts").html(PERSONES_GRUP - 1);
    $("#editar_reserva").click(function () {
        $("#flogin").toggle('low');
    });

    $('#form-reserves').resetForm();

    $("#selectorComensals").buttonset();
    $("#selectorJuniors").buttonset();
    $("#selectorNens").buttonset();
    $("#selectorCotxets").buttonset();
    $("#selectorCadiraRodes").buttonset();

    $("#selectorHora").buttonset();
    $("#selectorHoraSopar").buttonset();
    //$(".llista-menus").buttonset();
    $("#cb_factura").button();
    $("button, .bt").button();

    $("#selectorComensals input[value=grups]").click(function () {
        window.location.href = "/reservar/realitzar-reserva/?lang=" + lang;
        return false;
    });

    $("#cb_factura").click(function () {
        if ($("#cb_factura:checked").val() == "on")
            $(".factura").show();
        else
            $(".factura").hide();
    });

    $("#cotxets0").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(0);
    });
    $("#cotxets1").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(0);
    });
    $("#cotxets2A").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(2);
    });
    $("#cotxets2L").click(function () {
        $(".fr-seccio-quants input[name=amplaCotxets]").val(3);
    });

    $(".factura").hide();

    $(".fr-seccio-hora").change(function () {
        comportamentMenus();

        updateMenusSectionButtons();

        if ($(".grups-fr-seccio-carta").is(":hidden"))
            $(".grups-fr-seccio-carta").slideDown("slow", function () {
                seccio("grups-fr-seccio-carta");
            });
    });

    $("#fr-carta-tabs").tabs();

    /* popup */
    $("#popup").dialog({autoOpen: false,
        modal: true,
        width: 800,
        height: 600,
        buttons: {
            "Continuar": function () {
                $(this).dialog("close");
            }
        }
    });
    /*
     $("#help").dialog({
     autoOpen: false,
     modal: true,
     width: 400,
     buttons: {
     "Continuar": function () {
     $(this).dialog("close");
     if (!SECCIO)
     seccio("fr-seccio-quants");
     }
     },
     close: tanca_dlg
     }
     );
     */

    $("#popupGrups").dialog({
        autoOpen: false,
        modal: true,
        width: 400,
        buttons: {
            t: function () {
                document.location.href = "form_grups.html";
            },
            "Modificar": function () {
                $(this).dialog("close");
            }
        }
    });
    help();

    $("#info_reserves").click(function () {
        $("#popup").html($("#reserves_info").html());
        $("#popup").unbind("dialogclose");
        $("#popup").dialog("open");
        return false;
    });
    validacio();

    /********  AMAGA PANELLS ********/
    if (!DEBUG)
    {
        $(".fr-seccio-dia").hide();
        $(".fr-seccio-hora").hide();
        $(".fr-seccio-carta").hide();
        $(".fr-seccio-client").hide();
        $(".fr-seccio-submit").hide();
        $(".grups-fr-seccio-dia").hide();
        $(".grups-fr-seccio-hora").hide();
        $(".grups-fr-seccio-carta").hide();
        $(".grups-fr-seccio-client").hide();
        $(".grups-fr-seccio-submit").hide();
    }
    else
    {
        monta_calendari("#calendari");
    }



    /**************************/

    comportamentQuantsSou();

    $(".llista-menus").accordion({active: false, collapsible: true, autoHeight: false,
        change: function () {
            var active = $(".llista-menus").accordion("option", "active");
            $(active).blur();
        }

    });
    $(".ui-accordion-content").css("overflow", "scroll");
    controlSubmit();
    //RESETEJA EL TIMER D'AJUDA SI TECA LA PANTALLA
    /***$(document).change(function(e) {clearTimeout(th);	if (SECCIO) th=setTimeout('timer_help("'+l(SECCIO)+'")',TIMER_HELP_INTERVAL);});
     */

    $("#flogin").hide();
    $("body").fadeIn("slow");

    //$("#help").dialog("open");
    $("button").one("click", function () {
        $(".gris-ajuda").addClass("fliflu");
    });

    $("#te-comanda").change(function () {
        $("#resum-total").after(" (" + $(this).val() + " menús / " + $("#totalComensals").val() + " comensals)");
        var vl = $("#te-comanda").valid();
        if (vl && $(".fr-seccio-client").is(":hidden"))
        {
            comportamentClient();
        }
        if (vl)
            $("em[generated=true]").remove();
    });

    $(".info-ico").click(function (e) {

        id = $(this).attr("id");
        help($("." + id).html());
        e.preventDefault();
    });
    totalPersones();

    SECCIO = "grups-fr-seccio-quants";

    $(".loader").removeClass("loader");
}); //ONLOAD, PRESENTACIO UI
/************************************************************************************************************/
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
    $("#selectorComensals").change(function () {
        $("input[name='adults']").val($("input[name='selectorComensals']:checked").val());
        var comensals = totalPersones();
        if (comensals >= PERSONES_GRUP) {
            monta_calendari("#calendari");
             comportamentDia();
             recargaHores();
          }

        $("#selectorComensals").buttonset("destroy");
        $("#selectorComensals").buttonset();
        $.scrollTo("#titol_SelectorJuniors", 600);
        
        updateMenusSectionButtons();


        return false;
    });

    $("input[name='adults']").change(function () {
        var val;
        val = $("input[name='adults']").val();
        $("input[name='selectorComensals']:checked").prop("checked", false).button("refresh");
        $("#com" + val).prop("checked", "true").button("refresh");
        var comensals = totalPersones();
        if (comensals >= PERSONES_GRUP) {
            monta_calendari("#calendari");
             comportamentDia();
             recargaHores();
          }

        $.scrollTo("#titol_SelectorJuniors", 600);
        return false;
    });

    //JUNIORS
    $("input[name=selectorJuniors]").change(function () {
        $("input[name='nens10_14']").val($("input[name='selectorJuniors']:checked").val());
        var comensals = totalPersones();
        if (comensals >= PERSONES_GRUP) {
            monta_calendari("#calendari");
             comportamentDia();
             recargaHores();
          }

        $.scrollTo("#titol_SelectorNens", 600);
        return false;
    });
    $("input[name='nens10_14']").change(function () {
        var val;
        val = $("input[name='nens10_14']").val();
        $("input[name='selectorJuniors']:checked").prop("checked", false).button("refresh");
        $("#junior" + val).prop("checked", "true").button("refresh");
        var comensals = totalPersones();
        if (comensals >= PERSONES_GRUP) {
            monta_calendari("#calendari");
             comportamentDia();
             recargaHores();
          }

        $.scrollTo("#titol_SelectorNens", 600);
        return false;
    });

    //NENS
    $("input[name=selectorNens]").change(function () {
        $("input[name='nens4_9']").val($("input[name='selectorNens']:checked").val());
         var comensals = totalPersones();
        if (comensals >= PERSONES_GRUP) {
            monta_calendari("#calendari");
             comportamentDia();
             recargaHores();
          }

        $.scrollTo("#titol_SelectorCotxets", 600);
        return false;
    });
    $("input[name='nens4_9']").change(function () {
        var val;
        val = $("input[name='nens4_9']").val();
        $("input[name='selectorNens']:checked").prop("checked", false).button("refresh");
        $("#nens" + val).prop("checked", "true").button("refresh");
        var comensals = totalPersones();
        if (comensals >= PERSONES_GRUP) {
            monta_calendari("#calendari");
             comportamentDia();
             recargaHores();
          }

            $.scrollTo("#titol_SelectorCotxets", 600);
        return false;
    });

    $("input[name=selectorCotxets]").change(function () {
        $.scrollTo("#titol_selectorCadiraRodes", 600);
        return false;
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
    
    

    updateResum();
    return total;
}



/********************************************************************************************************************
 COMPORTAMENT DIA > HORES
 */
function comportamentDia()
{
    if ($(".fr-seccio-dia").is(":hidden")) {
        $(".fr-seccio-dia").slideDown("slow", function () {
            SECCIO = "fr-seccio-dia";
        });

    }

    $("#calendari").change(function () {
        var dat = $("#calendari").datepicker("getDate");
        var maxData = new Date();
        maxData.setDate(maxData.getDate() + 365);

        if (dat < new Date() || dat > maxData)
        {
            alert(l("Ho semtim.\n\nNo podem reservar per la data que ens demanes"));
            return false;
        }
        ;
        if ($(".fr-seccio-hora").is(":hidden"))
        {
            $(".fr-seccio-hora").slideDown("slow", function () {
                seccio("fr-seccio-hora");
            });
        }
        recargaHores();

        $("#resum-data").html($("#calendari").val());
        $("#valida_calendari").val($("#calendari").val());
        var validator = $("#form-reserves").validate().element("#valida_calendari");

        updateResum();
        updateMenus(); // excepció pels dies 26/12 - 1/1 - 6/1
        return true;
    });
}

/********************************************************************************************************************
 RECARGA HORES
 */
function recargaHores()
{
    
    
    $("#selectorHora").html('<img src="/cb-reserves/reservar/css/loading.gif"/>');
    $("#selectorHoraSopar").html('<img src="/cb-reserves/reservar/css/loading.gif"/>');
    var hora = $("input[name='selectorHora']:checked").val();
    $.post(GESTOR + "?a=totesHores&b=" + $("#calendari").val(), function (dades) {
        if (dades.substr(0, 3) == "err") {
            window.location = "/";
            alert("La sessió ha caducat");
        }

        var obj = JSON.parse(dades);
        var txt = "";


        if ((obj.dinar + obj.dinarT2) == "")
            txt = l("Cap taula o restaurant tancat");

        $("#selectorHora").html(obj.dinar + obj.dinarT2 + txt);
        $("#selectorHora").buttonset();

        txt = "";
        if (obj.sopar == "")
            txt = l("Cap taula o restaurant tancat");
        $("#selectorHoraSopar").html(obj.sopar + txt);
        $("#selectorHoraSopar").buttonset();

        $("#selectorHora input[value='" + hora + "']").prop('checked', true);
        $("#selectorHoraSopar input[value='" + hora + "']").prop('checked', true);

        $("input[name='selectorHora']").change(function () {
            $("#resum-hora").html($("input[name='selectorHora']:checked").val());
            updateResum();
        });

        //ALERTA SI NO HI HA TAULA
        if ((obj.dinar + obj.dinarT2 + obj.sopar) == "")
        {
            $("#popup").html(l("CAP_TAULA"));
            $("#popup").dialog("open");
        }

    });



}


/********************************************************************************************************************
 COMPORTAMENT CARTA
 */
function comportamentMenus()
{
    $(".resum-carta-nom").click(function (e) {
        $(this).closest("tr").find("td.mes a").trigger("click");
        e.preventDefault();
        return false;
    });
}

/*******************************************************************************************************************
 COMPORTAMENT CLIENT
 */
function comportamentClient()
{
    /*
     $("input[name='client_mobil']").change(function () {
     
     var n = $("input[name='client_mobil']").val();
     if (n.length >= 9 && isNumber(n))
     updateClient();
     });
     $(".fr-seccio-client input[name='client_email']").change(function () {
     if ($(this).valid())
     updateClient();
     });
     */
    if ($(".fr-seccio-client").is(":hidden"))
        $(".fr-seccio-client").slideDown("slow", function () {
            seccio("fr-seccio-client");
        });
    $(".fr-seccio-client input").bind('blur change ', validaDadesClient);
    $(".fr-seccio-client").bind('blur change ', validaDadesClient);
}

function validaDadesClient() {
    var ok = true;
    ok = ok && $("input[name='client_mobil']").val();
    ok = ok && $("input[name='client_nom']").val();
    ok = ok && $("input[name='client_cognoms']").val();
    updateResum();
    if (ok)
    {
        if ($(".fr-seccio-submit").is(":hidden")) {
            $(".fr-seccio-submit").show();
            $(".fr-seccio-submit").css("display", "block");
            $(".fr-seccio-submit").css("visibility", "visible");
            $.scrollTo("#scroll-seccio-submit", 800);
        }
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

        else
        {
            var obj = JSON.parse(dades);
            if (obj.id_reserva || obj.err)
            {
                //alert(l(obj.err)+obj.data);
                $("#popup").html(l("err" + obj.err) + obj.data);
                $("#popup").dialog("open");

                resetClient();
                $("input[name='client_mobil']").val("");
                $("input[name='client_mobil']").removeAttr("readonly");

                return;
            }

            $("input[name='client_id']").val(obj.client_id);
            //$("input[name='client_mobil']").val();
            if (!num)
                $(".fr-seccio-client input[name='client_mobil']").val(obj.client_mobil);
            $("input[name='client_nom']").val(obj.client_nom);
            $("input[name='client_nom']").attr("readonly", "readonly");
            $("input[name='client_cognoms']").val(obj.client_cognoms);
            $("input[name='client_cognoms']").attr("readonly", "readonly");
            $("input[name='client_email']").val(obj.client_email);
            //if ($("input[name='client_email']").val()!="") $("input[name='client_email']").attr("readonly", "readonly"); 
            $("input[name='client_telefon']").val(obj.client_telefon);
            $("input[name='client_telefon']").attr("readonly", "readonly");
            client_auto = true;
            if ($(".fr-seccio-submit").is(":hidden"))
                $(".fr-seccio-submit").slideDown("slow", function () {
                    seccio("fr-seccio-submit");
                });
            updateResum();
        }
    });
}
function resetClient()
{
    $("input[name='client_id']").val();
    $("input[name='client_nom']").val("");
    $("input[name='client_nom']").removeAttr("readonly");
    $("input[name='client_cognoms']").val("");
    $("input[name='client_cognoms']").removeAttr("readonly");
    $("input[name='client_email']").val("");
    $("input[name='client_email']").removeAttr("readonly");
    $("input[name='client_telefon']").val("");
    $("input[name='client_telefon']").removeAttr("readonly");
    updateResum();
}

/********************************************************************************************************************
 COMPORTAMENT RESUM
 */
function updateResum()
{
    if ($(".fr-seccio-submit").is(':hidden'))
        return;

    var menua = $(".menu-adults .ui-state-active").find("a").html();
    menua = menua ? menua : "";

    var menuj = $(".menu-juniors .ui-state-active").find("a").html();
    menuj = menuj ? menuj : "";


    var menun = $(".menu-nens .ui-state-active").find("a").html();
    menun = menun ? menun : "";

    $("#resum-data").html($("#calendari").val());
    $("#resum-adults").html($("#com").val());
    $("#resum-juniors").html($("#junior").val());
    $("#resum-nens").html($("#nens").val());
    $("#resum-cotxets").html($("input[name='selectorCotxets']:checked").val());
}


/********************************************************************************************************************
 COMPORTAMENT EXCEPCIONS STESTEVE,ANYNOU,REIS
 */
function updateMenus() {
    return;
    var excepcio = false;
    var dat = $("#calendari").datepicker("getDate");

    if (dat.getDate() == 26 && dat.getMonth() == 11)
        excepcio = true; //stesteve
    if (dat.getDate() == 1 && dat.getMonth() == 0)
        excepcio = true; // any nou
    if (dat.getDate() == 6 && dat.getMonth() == 0)
        excepcio = true; //reis

    $("#carta h3").show();
    $("#carta2 h3").show();
    $("#carta3 h3").show();
    

    if (excepcio && false) {
        $("#bt-carta").hide();
        $("#bt-no-carta").hide();
        $("#fr-carta-tabs").hide();        
        
        
        /*
         * ADUULTS
         */
        $("#carta a[v=1]").parent().hide();
        $("#carta a[v=3]").parent().hide();
        $("#carta a[v=5]").parent().hide();
        $("#carta a[v=6]").parent().hide();
        $("#carta a[v=7]").parent().hide();
        $("#carta a[v=8]").parent().hide();
        $("#carta a[v=9]").parent().hide();
        $("#carta a[v=10]").parent().hide();
        $("#carta a[v=11]").parent().hide();
        $("#carta a[v=12]").parent().hide();
        /*
         * JUNIORS
         */
        $("#carta2 a[v=jr_comu]").parent().hide();
        $("#carta2 a[v=jr_casa]").parent().hide();
        /*
         * NENS
         */
        $("#carta3 a[v=inf_comu]").parent().hide();
        $("#carta3 a[v=inf_casa]").parent().hide();
        
        
        
        //ALEX 22/12 2019 EXCEPCIO
        
        
        $(".info-comanda").html(l("INFO_CARTA_NADAL"));
        $("#bt-menu span").html(l("Menús Nadal"));
        $("#carta_MENUS tr").hide();
        $("#carta_MENUS tr[producte_id=2002]").show(); //N3
        $("#carta_MENUS tr[producte_id=2004]").show(); //infantil
        $("#carta_MENUS tr[producte_id=2011]").show(); //infantil
        $("#carta_MENUS tr[producte_id=2023]").show(); //junior
        $("#carta_MENUS tr[producte_id=2024]").show(); //n1
        //$("#carta_MENUS tr[producte_id=2003]").show(); //n2
        //$("#carta_MENUS tr[producte_id=2007]").show(); //n4		
        //$("#carta_MENUS tr[producte_id=2010]").show(); //calsotada	
        
              $("#carta_MENUS tr").hide();
        $("#carta_ tr[producte_id=2002]").show(); //N3
        $("#carta_ tr[producte_id=2004]").show(); //infantil
        $("#carta_ tr[producte_id=2011]").show(); //infantil
        $("#carta_ tr[producte_id=2022]").show(); //junior
        $("#carta_ tr[producte_id=2024]").show(); //n1
    }else{
            
                $(".col-isqui-carta .info.caixa").html(l("INFO_CARTA"));
        $("#bt-menu span").html(l("Menús"));
       // $("#bt-menu span").hide();
        $("#bt-no-carta").show(); 
        
        $("#bt-carta").show();
        $("#bt-no-carta").show();
        $("#fr-carta-tabs").show();        
         $("#carta_ tr").show();
    }


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
    limit_passat = 1;
    $(selector).datepicker("destroy");
    $(selector).datepicker({
        beforeShowDay: function (date, inst) {
            var r = new Array(3);

            if (llistanegra(date) || (date.getDay() == 1 || date.getDay() == 2) && !llistablanca(date) || !taulaDisponible(date))

            {
                r[0] = false;
                r[1] = "maldia";
                r[2] = l("Tancat");
            }
            else
            {
                r[0] = true;
                r[1] = "bondia";
                r[2] = l("Obert");
            }
            return r;
        },
        defaultDate: null,
        minDate: limit_passat
    });

    //CARREGA IDIOMA
    var lng = lang.substring(0, 2);
    $(selector).datepicker("option",
            $.datepicker.regional[ lng ]);

    $(selector).datepicker('setDate', null);
    $('.ui-datepicker-calendar .ui-state-active').removeClass('ui-state-active');
    $('.ui-datepicker-calendar .ui-state-hover').removeClass('ui-state-hover');

}

/********************************************************************************************************************/
function taulaDisponible(date)
{
    //alert("TAULADISP:"+date);
    //TODO, comprovar si hi ha taula
    return true;
}

/********************************************************************************************************************/
function llistanegra(date)
{

    var t;
    var ds = date.getDay();
    var bloqDia = false;

    var bloqNit = ds < 5;

    var y = date.getYear();     // integer
    var m = date.getMonth();     // integer, 0..11
    var d = date.getDate();      // integer, 1..31
    // COMPROVA LLISTA MIGDIES
    t = LLISTA_NEGRA[m];
    if (t)
        for (var i in t)
            if (t[i] == d)
                bloqDia = true;

    // COMPROVA LLISTA NITS
    t = LLISTA_NITS_NEGRA[m];
    if (t && !bloqNit)
        for (var i in t)
            if (t[i] == d)
                bloqNit = true;

    bloqNit = true;

    return (bloqDia && bloqNit);
}

/********************************************************************************************************************/
function llistablanca(date)
{
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
    
    $.validator.addMethod("menus_comensals", function (value, element) {
        //var totalComansals = parseInt($("#totalComensals").val());
        var totalComansals = totalPersones();
        var value = parseInt(value);
        if (totalComansals<=20) return true;
        //shouldElementBeVisible =  $("input[name='adults']").val()<=20;
    //    if (shouldElementBeVisible && SELECT_CARTA) return true;
        return (value >= totalComansals);
    }, l('MENUS_COMENSALS'));

    $("#form-reserves").validate({
        errorContainer: $("#error_validate"),
        debug: true,
        errorElement: "em",
        rules: {
            totalComensals: {
                required: true,
                min: PERSONES_GRUP
            },
            adults: {
                required: true,
                min: 2,
                max: 200
            },
            valida_calendari: "required",
            selectorHora: "required",
            selectorData: "required",
            menu_adults: "required",
            menu_juniors: "required",
            menu_nens: "required",
            client_mobil:
                    {
                        required: true,
                        number: true,
                        minlength: 9
                    },
            client_email: {required: true, email: true, remote: "../../taules/verify_email.php"},
            client_nom: "required",
            client_cognoms: "required",
            te_comanda: {
                menus_comensals: true
            }
        },
        messages: {
            totalComensals: {
                required: l("TOTAL!!!"),
                min: l("El mínim de comensals és de ") + PERSONES_GRUP,
                max: l("No admentem reserves per més de 200 comensals")
            },
            adults: {
                required: l("Indica el nombre d'adults"),
                min: l("El nombre d'adults és massa petit"),
                max: l("Indica el nombre d'adults")
            },
            valida_calendari: l("Cal que indiquis el dia"),
            selectorHora: l("Selecciona l´hora"),
            selectorData: l("Selecciona el dia"),
            menu_adults: l("Indica el menú"),
            menu_juniors: l("Indica el menú"),
            menu_nens: l("Indica el menú"),
            client_mobil:
                    {
                        required: l("Dona´ns un mòbil"),
                        number: l("Dona´ns un mòbil"),
                        minlength: l("Dona´ns un mòbil")
                    },
            client_email: {
                required: l("És necessari que ens facilitis un email"),
                email: l("El format no sembla correcte")
            },
            client_nom: l("Dona´ns el teu nom"),
            client_cognoms: l("Dona´ns els teus cognoms"),
            te_comanda: {
                menus_comensals: l('MENUS_COMENSALS')
            }


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
            client_email: {required: l("Dona´ns un email"), email: l("El format no és correcte")}
        }
    });

}

/********************************************************************************************************************/
function controlSubmit()
{
    $('#submit').click(function (e) {
                if (!$("#totalComensals").valid()){
            e.preventDefault();
            return false;
        }
        
        
        if (!$("#valida_calendari").valid()){
            e.preventDefault();
            return false;
        }
            
        if (!$("#te-comanda").valid()){
            e.preventDefault();
            return false;
        }



        if (!$("#valida_calendari").valid()){
            e.preventDefault();
            return false;
        }
        
        if (!$("#calendari").datepicker("getDate")){
            errors = { selectorData: "Indica dia" };
        /* Show errors on the form */
        alert("Has d'indicar una data");
            validator.showErrors(errors);            
            e.preventDefault();
            return false;
        }
        if (!$("input[name='selectorHora']:checked").val()){
            errors = { selectorHora: "Indica Hora" };

            validator.showErrors(errors);            
            e.preventDefault();
            return false;
        }
        
        
        


            
        clearInterval(th);

        $("#popup").html('<div style="height:420px"><img src="/cb-reserves/reservar/css/loading.gif"/></div>');
        $("#popup").dialog('open');
        $('.ui-dialog-buttonset').hide();
        $('#submit').hide();
        $('#form-reserves').ajaxSubmit(function (dades) {
            if (dades.substring(0, 11) != '{"resposta"')
                dades = '{"resposta":"ko","error":"err0","email":false}';
            $('.ui-dialog-buttonset').show();
            var obj = JSON.parse(dades);
            if (obj.resposta == "ok")
            {
                $("#popup").html($("#popupInfo").html() + $(".resum").html());
                $("#popup").bind("dialogclose", function (event, ui) {
                    window.location.href = "../../#about";
                });
            }
            else
            {
                $('#submit').show();
                var err = "Error de servidor";
                if (obj && obj.error)
                    err = l('err' + obj.error);
                $("#popup").html("ERROR: " + err);
            }
            $("#popup").dialog('open');
        });

        return false;
    });
}

/********************************************************************************************************************/
function timer()
{
    alert("TIMER INUTIL I MOLEST!!");
    var t = setTimeout("timer()", TIMER_INTERVAL);
}
/****
 function timer_help(txt)
 {
 if (!SECCIO) return clearInterval(th);
 if(typeof window.orientation !== 'undefined') return;
 
 help(txt);
 
 SECCIO=null;
 clearInterval(th);
 }
 */


/********************************************************************************************************************/
/********************************************************************************************************************/
function isNumber(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
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

function seccio(selector_seccio) {
    if (selector_seccio)
        SECCIO = selector_seccio;
   // alert(selector_seccio);
    $.scrollTo($("." + selector_seccio), 800);
    
    if (selector_seccio=="grups-fr-seccio-carta") updateMenus();
    //clearTimeout(th);//
    //th=setTimeout('timer_help("'+l("grups-"+selector_seccio)+'")',TIMER_HELP_INTERVAL);

}

/***
 function help(txt){
 if ($.browser.name=="opera") $("#td_contingut").addClass("fals-overlay");
 $("#td_contingut").addClass("fals-overlay");
 
 $("#help").html(txt);
 $("#help").dialog("open");
 }
 */
function tanca_dlg() {
    $("#td_contingut").removeClass("fals-overlay");
}

function updateMenusSectionButtons(){
         shouldElementBeVisible =  $("input[name='adults']").val()<=14;
    $("#bt-carta").toggle(shouldElementBeVisible);
    $("#bt-no-carta").toggle(shouldElementBeVisible);
}
