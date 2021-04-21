//PENDENT CONFIG
var HOST = "DEV";
var refreshIntervalId;
var client = 0;
var timeractiu = false;
var FILTRE_RES = 1;
var FILTRE_CLI = 1;
var PRINT = false;
var taulaSel;
var TAULA, N, P, C, F, CERCA;
var ONLOAD_BLOC_CALEND = false;
var ONLOAD_BLOC_TORN = false;
var canvia_data_confirma = false;
var AC_ACTIU;
var ntimer;
var ntimer2;
var validator_inserta_res;
var PREVENTDEFAULT = false;

var reserva = 0;
var acop = {collapsible: false, active: false, heightStyle: "content", fillSpace: true, clearStyle: true, autoHeight: false, change: function (event, ui) {
        client = $(ui.newHeader).find("a").attr("href").split("&id=")[1];
    }};

var popup;
var guardat = false;

var permuta = 0;


var acopres = {collapsible: true, active: false, autoHeight: false, change:
            function (event, ui)
            {
                taulaSel = $(ui.newHeader).find("a").attr("taula");
                getFlashMovie("flash").seleccionaTaula(taulaSel);

            }
};

jQuery.expr[':'].focus = function (elem) {
    return elem === document.activeElement && (elem.type || elem.href);
};

/////////////////////////////////////////////////////////////////////////////////////////
// PROTOTYPE STRING TRIM
String.prototype.trim = function () {
    return this.replace(/^\s+|\s+$/g, "");
};

/////////////////////////////////////////////////////////////////////////////////////////
// READY
$(function () {
    //comprova_backup();
    cron_js();
    $(document).everyTime(BACKUP_INTERVAL, 'backup', cron_js);



    $("input[name='confirma_data']").button();

    $(".fr").mouseover(function () {
        var taulaSelaux = $(this).attr("taula");
        getFlashMovie("flash").seleccionaTaula(taulaSelaux);
    });
    $(".fr").mouseout(function () {
        if (taulaSel != $(this).attr("taula") && true)
            getFlashMovie("flash").seleccionaTaula(0);
    });

    controlNumMobil();
    if (permisos < 64)
        $(".sense-numero").hide();
    $("#resetCercaRes").click(function () {
        $("#autoc_reserves_accordion").removeClass("cercador-actiu");
        $("#autoc_reserves_accordion").val("");

        cercaReserves("");
        return false;
    });



    /***********************************************************************************/
// MONTA FLASH

    var flashvars = {};
    flashvars['DEBUG'] = DEBUG;
    flashvars['URL'] = url_base;
    flashvars['DATA'] = 0;// NO S'UTILITZA
    flashvars['TORN'] = 0;// NO S'UTILITZA
    flashvars['PRINT'] = 1;// NO S'UTILITZA
    var params = {
        wmode: "opaque"
    };
    var so = swfobject.embedSWF('MenjadorEditor.swf', 'flash', '760', '740', '9.0', '#FFFFFF', flashvars, params);

    /***********************************************************************************/
// FILTRE RES
    $.ajax({url: "gestor_reserves.php?a=canvi_modo&p=1", success: recargaAccordioReserves}); //1op

//$.ajax({url: "gestor_reserves.php?a=canvi_modo&p="+$("#filtreRes").val()});
    $("#filtreRes").change(function (e) {


        if ($("#filtreRes").val() == 3)
        {
            $("#filtreRes").val(FILTRE_RES);
            var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=900, height=650, top=85, left=50";
            data = $("#calendari").val();
            popup = window.open("cercador.php?data1=" + data + "&data2=31/12/2050&torn1=1&torn2=1&torn3=1&del=0&act=0", "", opciones);
            //else popup.open();
            if (window.focus) {
                popup.focus();
            }
            e.preventDefault();
            return false;
        }
        else
        {
            $.ajax({url: "gestor_reserves.php?a=canvi_modo&p=" + $("#filtreRes").val(), success: recargaAccordioReserves});
            FILTRE_RES = $("#filtreRes").val();
        }


    });

// FILTRE CLI
    $("#filtreCli").change(function (e) {
        if ($("#filtreCli").val() == 3)
        {
            $("#filtreCli").val(FILTRE_CLI);
            var opciones = "toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=900, height=650, top=85, left=50";
            popup = window.open("DBTable/LlistatClient.php?futur=true", "", opciones);
            if (window.focus) {
                popup.focus();
            }
            e.preventDefault();
            return false;
        }
        else
        {
            $("#autoc_client_accordion").val("Cerca...");
            recargaAccordionClients(true);
            FILTRE_CLI = $("#filtreCli").val();
        }
    });


    /***********************************************************************************/
// REFRESH

    timer(true);
// Dialog REFRESH			
    $('#refresh_popup').dialog({
        autoOpen: false,
        modal: true,
        width: 300,
        buttons: {
            "Actualitza": function () {
                $(this).dialog("close");
                refresh();
                timer(true);
            },
            "Tanca": function () {
                $(this).dialog("close");
                timer(true);
            }
        }
    });

    $("#bt_refresh").click(function () {
        refresh();
        return false;
    });


    /***********************************************************************************/
// AMAGA BT NOVA RESERVA
    $("#novaReserva").hide();


    /***********************************************************************************/
// CALENDARI
    monta_calendari("#calendari");
    $.get("gestor_reserves.php?a=recupera_missatge_dia", function (data) {
        $(".missatge_dia").html(data);
    });

    $.ajax({url: "gestor_reserves.php?a=canvi_data&p=" + $("#calendari").val()});

    $("#selectorComensals").buttonset();
    $("#selectorComensals").find("label").unbind("mouseup");
    $("#selectorDinarSopar").buttonset();
    $("#selectorDinarSopar").find("label").unbind("mouseup");
    $("#selectorCotxetsCerca").buttonset();
    $("#selectorCotxetsCerca").find("label").unbind("mouseup");
    $(".inserta_res #selectorCotxets").buttonset();
    $(".inserta_res #selectorCotxets").find("label").unbind("mouseup");
    $(".inserta_res #selectorCadiraRodes").buttonset();
    $(".inserta_res #selectorCadiraRodes").find("label").unbind("mouseup");
    $("#selectorNens4_9").buttonset();
    $("#selectorNens4_9").find("label").unbind("mouseup");
    $("#selectorNens10_14").buttonset();
    $("#selectorNens10_14").find("label").unbind("mouseup");
    $("#selectorAdults").buttonset();
    $("#selectorAdults").find("label").unbind("mouseup");
    $("#finde").button();

    $("#selectorComensals").change(cercaTaula);
    $("#selectorDinarSopar").change(cercaTaula);
    $("#selectorCotxetsCerca").change(cercaTaula);
    $("#finde").change(cercaTaula);
    /**/
    $("#selectorNens4_9").change(botonera_nens4_9);
    $("#selectorNens10_14").change(botonera_nens10_14);
    $("#selectorAdults").change(botonera_adults);

    $(".inserta_res #selectorCotxets").change(function () {
        if (!$(this).val())
            $("input[name=cotxets]").val(1);

    });



    /***********************************************************************************/
// TORNS
    $("#torn" + torn_session).prop("checked", "true");

    $("#radio").buttonset();
    $("#radio").find("label").unbind("mouseup");
    $("#radio").change(function (e) {
        $.ajax({url: "gestor_reserves.php?a=canvi_torn&p=" + $("input[name='radio']:checked").val(), success: function () {
                recargaAccordioReserves();
                alert("DDDD");
                getFlashMovie("flash").canviData($("#calendari").val());
//			getFlashMovie("flash").canviTorn($("input[name='radio']:checked").val());	
            }});
        cercaTaula();
    });
    /***********************************************************************************/
// ACCORDIONS
//ACCORDION CLI ANULAT$( "#clientsAc" ).accordion(acop);

    /***********************************************************************************/
// TABS CLIENTS / RESERVES 
    $("#tabs").tabs();
    /***********************************************************************************/
//DIALOG INSERT reserva

    var editor_buttons = editor_buttonsfn();
    $('#insertReserva').dialog({
        autoOpen: false,
        modal: true,
        width: 1000,
        height: 700,
        open: function () {
            guardat = false;
        },
        close: function () {
            timer(true);
            if (guardat)
                return;
            $.post("gestor_reserves.php?a=bloqueig_taula&p=" + TAULA + "&q=1");
            $.post("gestor_reserves.php?a=inserta_client", {"client_mobil": $(".inserta_res input[name=client_mobil]").val(),
                "client_cognoms": $(".inserta_res input[name=client_cognoms]").val(),
                "client_nom": $(".inserta_res input[name=client_nom]").val(),
                "client_email": $(".inserta_res input[name=client_email]").val(),
                "client_conflictes": $(".inserta_res input[name=client_conflictes]").val()
            }, function (d) {
                if (false && d)
                    alert("S'ha guardat el client (id=" + d + ")");
            });
        },
        buttons: editor_buttons,
    });
    /***********************************************************************************/
// DIALOG EDIT CLI / RES
    $('#edit').dialog({
        autoOpen: false,
        width: 1000,
        height: 700,
        modal: true,
        close: function () {
            timer(true);
        },
        buttons: {
            "Guarda": function () {
                if ($('#edit form').hasClass("updata_res"))
                {
                    if (permuta && $("#extendre input:checked").val() == 1)
                        permuta = permuta;
                    else if (!$("form.updata_res").validate().form())
                        return;
                    /*
                     try {
                     $("#reservesAc").accordion("destroy");
                     } catch (e) {
                     }
                     ;
                     */
                    $('#edit form').ajaxSubmit({target: '#reservesAc', success: function (datos) {

                            if (datos == "ORFANES!!!")
                                alert("ATENCIO!!!\nS'han detectat reserves perdudes: Per més detalls, ves al Panel de control > Eines avançades > Reserves perdudes");
                            recargaAccordioReserves();
                        }});

                    if (permuta)
                    {
                        getFlashMovie("flash").buidaSafata();
                    }
                }
                else
                {
                    //ACCORDION CLI ANULAT$( "#clientsAc" ).accordion('destroy');
                    if (!$("form.updata_cli").validate().form())
                        return;
                    $('#edit form').ajaxSubmit({target: '#clientsAc', success: recargaAccordionClients});
                }

                $(this).dialog("close");
                timer(true);

                return false;

            },
            "Elimina": function () {
                if ($('#edit form').hasClass("updata_res"))
                {
                    var id = $("form.updata_res input[name=id_reserva]").val();
                    if (deleteReserva(id))
                        $(this).dialog("close");
                }
                else
                {
                    var id = $("form.updata_cli input[name=client_id]").val();
                    eliminaClient(id);
                    $(this).dialog("close");
                }

                timer(true);

            },
        }
    });


    $("#dlg_cercador").dialog({
        autoOpen: false,
        width: 900,
        height: 650,
        close: function () {
            timer(true);
        },
        modal: true
    });


    if (permisos < 31)
    {
        var buttons = $("#edit").dialog("option", "buttons");
        delete buttons.Elimina;
        $("#edit").dialog("option", "buttons", buttons);
    }
    /***********************************************************************************/
    /***********************************************************************************/
// NOU CLI CLICK
    /*
     $('#nouClient').click(function () {
     timer(false);
     $('#insertClient').dialog('open');
     $("form.inserta_cli").validate().resetForm();
     return false;
     });
     */
    /***********************************************************************************/
// VALIDATORS INSERT RES / CLI
    jQuery.validator.setDefaults({
        massages: {required: 'Has d´omplir aquest camp'}
    });
    var validator_inserta_cli = $("form.inserta_cli").validate();
    validator_inserta_res = $("form.inserta_res").validate(validationRules());


    /***********************************************************************************/


    /***********************************************************************************/
// combo cli a INSERT RESERVA
    $("form.inserta_res  .combo_clients").change(function (e) {
        var id = $(this).val();
        var desti = "gestor_reserves.php?a=htmlDadesClient&p=" + id;
    });


    /***********************************************************************************/
// NOU CLIENT
    /*
     $('.nouClient').click(function () {
     timer(false);
     
     $('#insertClient').dialog('open');
     $("form.inserta_cli").validate().resetForm();
     return false;
     });
     */

    /***********************************************************************************/
// CERCADORS
    $("#cercaReserva").keypress(function (e) {
        if (e.which == 13)
        {
            var s = $("#cercaReserva").val();

            if (s != "Cerca...")
                cercaReserves(s);
            e.preventDefault();
        }
        return false;
    });


    $("#cercaClient").keypress(function (e) {
        if (e.which == 13)
        {
            var s = $("#cercaClient").val();
            if (s != "Cerca...")
                cercaClients(s);
            e.preventDefault();
        }
        return false;
    });

    $("#btCercaReserva").click(function () {
        var s = $("#cercaReserva").val();
        if (s != "Cerca...")
            cercaReserves(s);
    });

    $("#btCercaClient").click(function () {
        var s = $("#cercaClient").val();
        if (s != "Cerca...")
            cercaClients(s);
    });

    $("#resetCerca").click(function () {
        $("#autoc_client_accordion").val("");
        $("#filtreCli").val("1");
        recargaAccordionClients(true);
        return false;
    });







    jQuery.validator.addMethod("client", function (value, element) {
        var re = new RegExp("\([0-9]+ - [0-9]*\)");
        return value.match(re);
    });

    jQuery.validator.addMethod("personesInsert", function (value, element) {
        var total = 0;

        if ($("form.updata_res").html())
        {
            total = 0 + Number($(".updata_res input[name=adults]").val()) + Number($(".updata_res input[name=nens4_9]").val()) + Number($(".updata_res input[name=nens10_14]").val());
            if (Number($(".updata_res input[name=cotxets]").val()) > C)
                return false;

        }
        else
        {
            total = 0 + Number($(".inserta_res input[name=adults]").val()) + Number($(".inserta_res input[name=nens4_9]").val()) + Number($(".inserta_res input[name=nens10_14]").val());
            if (Number($(".inserta_res input[name=cotxets]").val()) > C)
                return false;
        }

        if (total == 0)
            return false;

        var valid = false;
        if (F == 1 || F == "1")
        {
            valid = (total == P);
        }
        else
        {
            valid = (total <= P);
        }
        if (!valid)
        {
            recargaAccordioReserves();
            alert("El nombre de comensals no s'adapta a la taula seleccionada. Pots seleccionar una altra taula o modificar el nombre de comansals per solucionar-ho");
            return false;
        }


        return valid;
    }, "El nombre de persones / cotxets no és adequat per aquesta taula");



    $(".inserta_res input[persones]").change(calcula_adults);

    upercase("body ");
    $("#flash").hide();

    addHandlersAccordionClients();
    addHandlersAccordionReserves();

    $("#bt_print").click(function ()
    {
        PRINT = true;
        getFlashMovie("flash").print();
        return false;

    });


    $("#dreta").fadeIn("slow");
    $("#reservesAc").fadeIn("slow");

    if (controlaSopars())
        $.ajax({url: "gestor_reserves.php?a=canvi_torn&p=" + $("input[name='radio']:checked").val(), success: recargaAccordioReserves});

    addHandlersEditCli();
    cb_autocompletes();

    $(window).focus(function () {
        //comprova_refresh();
    });
    
    
 
            
}); // FINAL READY



































/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/




function recargaAccordionClients(nomesClients)
{
    $("#clientsAc").html('<img src="css/loading_llarg.gif" class="loading_llarg"/>');
    if ($("#filtreCli").val() > 2)
        $("#filtreCli").val(1);
    var filtreCli = $("#filtreCli").val();
    $.ajax({url: "gestor_reserves.php?a=accordion_clients&p=" + filtreCli, success: function (datos) {
            if (datos.trim().substr(0, 3) != "<h3")
            {
                if (datos.substr(0, 4) == "<!DO")
                    datos = "La sessió ha caducat.\n Refresca la pàgina prement F5";
                alert(datos);
                return false;
            }

            //$("#clientsAc").html(decodeURIComponent(datos));
            $("#clientsAc").html(datos);
            //ACCORDION CLI ANULAT$( "#clientsAc" ).		("destroy");
            //ACCORDION CLI ANULAT$( "#clientsAc" ).accordion(acop);
            $("#clientsAc").show("fade");
            if ($("#clientsAc h3[insert]").attr("insert"))
                client = $("#clientsAc h3[insert]").attr("insert");
            //ACCORDION CLI ANULAT$( "#clientsAc" ).accordion("activate","h3[insert]");			
            addHandlersAccordionClients();
        }});
    if (!nomesClients)
        recargaAccordioReserves();
}

function cercaClients(s)
{
    $("#filtreCli").val(3);
    $("#clientsAc").hide();
    if (s && s != "" && s != "Cerca...")
        s = "&c=" + s;
    $.ajax({url: "gestor_reserves.php?a=cerca_clients" + s, success: function (datos) {
            //ACCORDION CLI ANULAT$( "#clientsAc" ).accordion("destroy");
            $("#clientsAc").html(decodeURIComponent(datos));
            //ACCORDION CLI ANULAT$( "#clientsAc" ).accordion(acop);
            addHandlersAccordionClients();
            $("#clientsAc").show("fade");
        }});
}

function recargaAccordioReserves(creaNovaReserva)
{
    AC_ACTIU = $("#reservesAc").scrollTop();
    $("#reservesAc").html('<img src="css/loading_llarg.gif" class="loading_llarg"/>');
    $.ajax({url: "gestor_reserves.php?a=accordion_reserves", success: function (datos) {
            if (datos.trim().substr(0, 3) != "<h3")
            {
                alert(datos);
                return false;
            }
            $("#reservesAc").html(datos);
            $("#reservesAc").hide();


            try {
                ////*ANULAT $("#reservesAc").accordion("destroy");
            } catch (e) {
            }
            ;
            ////*ANULAT $("#reservesAc").accordion(acopres);

            $(".fr").mouseover(function () {
                taulaSel = $(this).attr("taula");
                getFlashMovie("flash").seleccionaTaula(taulaSel);
            });
            $(".fr").mouseout(function () {
                taulaSel = $(this).attr("taula");
                getFlashMovie("flash").seleccionaTaula(0);
            });

            addHandlersAccordionReserves();

            ////*ANULAT $("#reservesAc").show("fade").accordion("refresh");
            $("#reservesAc").show("fade");
            $("#autoc_reserves_accordion").val("");
            $("#autoc_reserves_accordion").removeClass("cercador-actiu");

            if (creaNovaReserva == "open")
                fromAS3_novaReserva(TAULA, N, P, C, F);

            $("#reservesAc").scrollTop(AC_ACTIU);
        }});
    if (ONLOAD_BLOC_TORN)
        $("#radio input").button("disable");
    if (ONLOAD_BLOC_CALEND)
        $("#calendari").datepicker("disable");


    $("#zoom").addClass("calendari-loading");


    //MISSATGE DIA
    try // A l'inici, abans que AS3 estigui inicialitzat, això peta
    {
        //Run some code here
        getFlashMovie("flash").canviData($("#calendari").val());
        getFlashMovie("flash").seleccionaTaula(0);
    }
    catch (err)
    {
        //Handle errors here
        //alert("AS3 no està preparat");
    }

    recargaAccordionClients(true);
}
























/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
function addHandlersAccordionReserves()
{
    $.ajax({url: "gestor_reserves.php?a=total_coberts_torn", success: function (datos) {
            var resposta = JSON.parse(datos);
            $(".total_torn").html(resposta.total);
            $("#total-t1").html((resposta.t1 ? '(' + resposta.t1 + ' coberts)' : ""));
            $("#total-t2").html((resposta.t2 ? '(' + resposta.t2 + ' coberts)' : ""));
            $("#total-t3").html((resposta.t3 ? '(' + resposta.t3 + ' coberts)' : ""));
        }});
    /**** EDIT RESERVA ****/
    onClickAmpliaReserva();

    $("#reservesAc .delete a").click(function (e)
    {
        var id = $(this).attr("del");
        deleteReserva(id);
        return false;
    });

}

function deleteReserva(id)
{
    // if (confirm("Segur que vols eliminar aquesta reserva?"))
    var rid = prompt("Introdueix els dos darrers dígits de l'ID de reserva que vols esborrar");
    var last2 = parseInt(id % 100);
    if (rid == last2)
    {
        $("#reservesAc").hide();
        /*
         try {
         $("#reservesAc").accordion("destroy");
         } catch (e) {
         }
         ;
         */
        var enviaSMS = $(".updata_res input[name=cb_sms]:checked").val() ? "" : "&q=1";

        var desti = "gestor_reserves.php?a=esborra_reserva&p=" + id + enviaSMS;
        $.ajax({url: desti, success: function (datos) {
                $("#reservesAc").html(decodeURIComponent(datos));
                ////*ANULAT $("#reservesAc").accordion(acopres);
                ////*ANULAT $("#reservesAc").show().accordion("refresh");
                $("#reservesAc").show();
                onClickAmpliaReserva();

                addHandlersAccordionReserves();
                getFlashMovie("flash").canviData(date_session);
                recargaAccordionClients(true);

            }
        });

        return true;
    }

    return false;
}

function addHandlersAccordionClients()
{
    /**** EDIT CLI ****/
    $(".fc").click(function (e) {
        var desti = $(this).attr("href");
        $("#edit").html('<div class="loading"></div>');


        timer(false);
        $('#edit').dialog('open');
        $.ajax({url: desti, success: function (datos) {
                $("#edit").html(decodeURIComponent(datos));
                addHandlersEditCli();
                onClickAmpliaReserva();
            }
        });

        e.preventDefault();
        return false;
    });

    onClickAmpliaReserva();
    $("#clientsAc .delete a").click(function (e) {
        var id = $(this).attr("del");
        eliminaClient(id);
    });
}
function addHandlersEditCli()
{
    var validator_edit = $(".form_edit .updata_cli").validate();
    upercase(".updata_cli");
    $(".updata_cli .garjola").click(function () {
        var t = /GARJOLA/i;
        var str = $(".updata_cli .txtGarjola").val();
        var garjola = t.test(str);
        if (garjola)
        {
            str = str.replace('GARJOLA!!!!', '');
            $(".updata_cli .txtGarjola").val(str);
            $(".updata_cli .txtGarjola").html(str);
        }
        else {
            $(".updata_cli .txtGarjola").val('GARJOLA!!!! ' + str);
            $(".updata_cli .txtGarjola").html('GARJOLA!!!! ' + str);

        }

        var desti = "gestor_reserves.php?a=garjola&b=" + $(".updata_cli input[name='client_mobil']").val() + "&c=" + $(".updata_cli input[name='client_email']").val() + "&d=" + !garjola;
        $.post(desti);

    });
    $(".inserta_res .garjola").click(function () {
        //$(".txtGarjola").html("");
        var t = /GARJOLA/i;
        var str = $(".inserta_res .txtGarjola").val();
        var garjola = t.test(str);
        if (garjola)
        {
            str = str.replace('GARJOLA!!!!', '');
            $(".inserta_res .txtGarjola").val(str);
            $(".inserta_res .txtGarjola").html(str);
        }
        else {
            $(".inserta_res .txtGarjola").val('GARJOLA!!!! ' + str);
            $(".inserta_res .txtGarjola").html('GARJOLA!!!! ' + str);

        }

        var desti = "gestor_reserves.php?a=garjola&b=" + $("#autoc_client_inserta_res").val() + "&c=" + $(".inserta_res input[name='client_email']").val() + "&d=" + !garjola;
        $.post(desti);

    });
    //TODO
}



function addHandlersEditReserva()
{

    var validator_edit = $(".form_edit .updata_res").validate();
    upercase(".updata_res");
    $("#autoc_client_updata_res").attr("readonly", "readonly");

    /***********************************************************************************/
    // RADIO HORES
    $("#updata_res_radio").buttonset();
    $("#updata_res_radio").find("label").unbind("mouseup");
    $(".updata_res  .combo_clients").change(function (e) {
        var id = $(this).val();
        var desti = "gestor_reserves.php?a=htmlDadesClient&p=" + id;

    });

    //SMS
    $(".form_sms").hide();
    $(".sms").click(function () {
        $(".form_sms").toggle();
    });
    $("#enviaSMS").click(function () {
        var desti = $("#enviaSMS").attr("href");
        var mob = $("#num_mobil").val();
        var msg = $(".updata_res #sms_mensa").val();
        var rsv = $(".updata_res input[name=id_reserva]").val();
        $.post(desti, {p: rsv, r: mob, c: msg}, function (datos) {
            $("#llista_sms").html(datos);
            alert("S'ha enviat l'SMS");
        });
        return false;
    }
    );

    $("#extendre").buttonset();
    $("#extendre").find("label").unbind("mouseup");

    $("input[name='confirma_data']").button();
    $("input[name='reserva_entrada']").button();
    $("input[name='reserva_entrada']").click(reservaEntrada); // boto reserva entrada

    $(".updata_res #selectorCotxets").buttonset();
    $(".updata_res #selectorCotxets").find("label").unbind("mouseup");

    $(".updata_res #selectorCadiraRodes").buttonset();
    $(".updata_res #selectorCadiraRodes").find("label").unbind("mouseup");

    $(".updata_res #selectorCotxets").change(function () {
        if (!$(this).val())
            $("input[name=cotxets]").val(1);
    });

    $(document).oneTime(1200, 'missatgeLlegit', missatgeLlegit);


    $('#updata_resRESERVA_PASTIS').button();
    $('#updata_resRESERVA_PASTIS').change(function () {
        $('.pastis_toggle').toggle(this.checked);
        $('#label-pastis').toggleClass("fluixet", !this.checked);
    });
    
    initCarta();
   // $(".info-comanda").click(function(){ $("#bt-carta").trigger( "click" );});
    
    
    $('#updata_resRESERVA_PASTIS').change();

    $("#bt-carta, #bt-menu").click(function () {
           $(".d-mes,  .d-menys").button();
            $(".m-mes,  .m-menys").hide();
        });

}

function reservaEntrada(id=-1, actiu=-1)
{
    // POSA EL 5e bit de reserves_info
    // 0 no han entrat
    // 1 reserva entrada
    // ho passa al gestor per ajax (taulaEntrada(idr,estat))

    var val = false;
    var des = false;

    if (actiu==-1) actiu = $("input[name='reserva_entrada']").is(":checked");

    val = $(".updata_res input[name=reserva_info]").val();
    des = (val & ~(1 << 5)) | ((!!actiu) << 5);
    $(".updata_res input[name=reserva_info]").val(des);

    // AJAX
    var idRes = id
    if (typeof idRes === 'object') idRes = $(".updata_res input[name=id_reserva]").val();
    var desti = "gestor_reserves.php?a=taulaEntrada&b=" + idRes + "&f=" + actiu;
    $.post(desti, {b: idRes, c: des}, refresh);
}

function missatgeLlegit()
{
    if (timeractiu)  return false;

    var idRes = $(".updata_res input[name=id_reserva]").val();
    var desti = "gestor_reserves.php?a=missatgeLlegit&b=" + idRes;
    $.post(desti, {b: idRes}, function (datos) {
        recargaAccordioReserves();
    });
}

function eliminaClient(id)
{
    if (confirm("Segur que vols eliminar aquest client?"))
    {
        var desti = "gestor_reserves.php?a=esborra_client&p=" + id;
        $.ajax({url: desti, success: function (datos) {
                if (datos.trim().substr(0, 3) != "<h3")
                {
                    alert(datos);
                }
                else
                    $("#clientsAc").html(decodeURIComponent(datos));
                    addHandlersAccordionClients();
                    $('#edit').dialog("close");
            }
        });

    }
    /**** EDIT RESERVA ****/
    onClickAmpliaReserva();
    e.preventDefault();
    return false;
}


function onClickAmpliaReserva()
{
   
    
    $(".fr").unbind();

    $(".fr").mouseover(function () {
        taulaSel = $(this).attr("taula");
        getFlashMovie("flash").seleccionaTaula(taulaSel);
    });
    $(".fr").mouseout(function () {
        taulaSel = $(this).attr("taula");
        getFlashMovie("flash").seleccionaTaula(0);
    });
    $(".fr").click(obreDetallReserva);
  /**/
 
  //$(".chekataula").button();
   $(".chekataula").change(function(e){
       var idr = $(this).attr("idr");
       //if(this.checked) alert(idr+"* "+this.checked);
      reservaEntrada(idr, this.checked);
   });
}

function obreDetallReserva(e)
{
    if (PREVENTDEFAULT){
        PREVENTDEFAULT = false;
        return false;
    }
    AC_ACTIU = $(this).attr("n");//$(this).parent();
    var desti = $(this).attr("href");
    var data = $(this).attr("data");

    $("#edit").html('<div class="loading"></div>');
    timer(false);
    $('#edit').dialog('open');
    $("#fr-cartaw-popup").remove();
    $("#fr-menu-popup").remove();
    if (data)
        $('#calendari').datepicker("setDate", data);
    $.ajax({url: desti, success: function (datos) {
            //$("#edit").html(decodeURIComponent(datos));
            
            $("#edit").html((datos));
            recargaAccordioReserves();
            addHandlersEditReserva();
            $.post("gestor_reserves.php?a=recupera_torn", function (d) {
                $("#torn" + d).prop("checked", true);
                $("#torn" + d).button("refresh");
            });
            $('#edit').dialog('option', 'title', 'Edita reserva ' + $("#spanidr").html());
        }
    });

    e.preventDefault();
    return false;
}

function FROM_CERCADOR_obreDetallReserva(id, data, torn)
{
    popup.close();
    $('#calendari').datepicker("setDate", data);
    if ($("#calendari").val() != data)
        return alert("Aquesta reserva és d'una data passada.\nNo és possible editar-la perquè estàs treballant amb calendari futur.\n\nUtilitza l'històric per consultar-la");

    $("#edit").html('<div class="loading"></div>');
    timer(false);
    $('#edit').dialog('open');

    $.ajax({url: "gestor_reserves.php?a=canvi_data&p=" + $("#calendari").val() + "&q=" + torn, success: function () {
            getFlashMovie("flash").canviData($("#calendari").val());

            var desti = "form_reserva.php?edit=" + id + "&id=" + id;
            $.ajax({url: desti, success: function (datos) {
                    //$("#edit").html(decodeURIComponent(datos));
                    $("#edit").html(datos);
                    recargaAccordioReserves();
                    addHandlersEditReserva();
                    $.post("gestor_reserves.php?a=recupera_torn", function (d) {
                        $("#torn" + d).prop("checked", true);
                        $("#torn" + d).button("refresh");
                    });
                }
            });


        }});
    return false;
}

function onNovaReservaBlok()
{


    $.post("gestor_reserves.php?a=taula_bloquejada&p=" + TAULA, function (resposta) {
        if (resposta > 0)
        {
            alert("Un altre usuari està utilitzant aquesta taula.\nNo es podrà crear reserva\nPots intentar-ho més tard");
            $('#insertReserva').dialog('close');
            return false;
        }
        else
        {

            $.post("gestor_reserves.php?a=bloqueig_taula&p=" + TAULA);
            //$('#insertReserva').dialog('open');

        }
    });
}
function onNovaReserva()
{
    $(".sense-numero").html("Sense número");
    onNovaReservaBlok();
    //$('#insertReserva').load("form_reserva.php");
    $('#insertReserva').dialog('open');
    reset_form();
    timer(false);
    max_comensals = 0;
    $("#edit").html("");
    $(".updata_res").html("");
    $("#autoc_client_inserta_res").show();

    $("form.inserta_res_radio input[name='client_id']").val("");
    $("form.inserta_res_radio input[name='client_id']").attr("class", "{required:true}");

    $("#inserta_res_radio").html("");


    $(".inserta_res input[name=total]").rules("add", {personesInsert: true});
    $("#confirma_data_inserta_res").rules("add", {required: true});

    //reset_form();


    var hora = $("#zoom input[name='hora']:checked").val();
    if (hora === null || typeof hora === "undefined")
    {
        hora = 0;
        //$("#inserta_res_radio").html('<div class="loading"></div>');
        recupera_hores('#inserta_res_radio');
    }
    else
    {
        var input = '<input type="text" name="hora"  value="' + hora + '" size="3" readonly="readonly" class="{required:true}" title=""/>';
        $("#inserta_res_radio").html(input);
    }
    // $('#insertReserva').dialog('open');
    if (!$('#insertReserva').dialog('isOpen'))
        $('#insertReserva').dialog('open');
    $('#insertReserva').show();
    $("#autoc_client_inserta_res").focus();


    $('#inserta_resRESERVA_PASTIS').change();
    var val = validationRules();
    if (!validator_inserta_res)
        validator_inserta_res = $("form.inserta_res").validate(val);


}
;


function recupera_hores($element) {
    //$.get("gestor_reserves.php?a=teeest", function (datos) {
    $.ajax({url: "gestor_reserves.php?a=recupera_hores&c=" + TAULA + "&d=" + P + "&e=" + C, success: function (datos) {

            var obj = JSON.parse(datos);
            if (!datos)
                alert("No es poden crear més reserves");
            var obj = JSON.parse(datos);

            if (obj.error != null && obj.error != '')
                $($element).html(obj.error);
            else
                $($element).html(obj.dinar + obj.dinarT2 + obj.sopar);

            $($element).buttonset();
            $($element).find("label").unbind("mouseup");
            $($element + " input").change(function () {
                max_comensals = $(this).attr("maxc");
            });
        }});
}

function reset_form() {
    /* */
    $(':input', '#campsClient')
            .not(':button, :submit, :reset, :hidden, :radio, :checkbox')
            .val('');

    $("input[name=adults]").val("");
    $("input[name=nens4_9]").val("");
    $("input[name=nens10_14]").val("");
    $("input[name=total]").val("0");
    $("input[name=cotxets]").val("");
    $("input[name=observacions]").val("");
    $("input[name=resposta]").val("");
    $("#INFO_PASTIS").val("");
    $("input[name='data']").val($("#calendari").val());
    var stDate = "--";
    stDate = $.datepicker.parseDate('dd/mm/yy', $("#calendari").val());
    stDate = $.datepicker.formatDate("DD d 'de' MM 'de' yy", stDate);
    $("span.data-llarga").html(stDate);
    $(".combo_clients").val(client);
    $(".combo_clients").trigger('change');

    $('#inserta_resRESERVA_PASTIS').prop('checked', false).button();
    $('#inserta_resRESERVA_PASTIS').change(function () {
        $('.pastis_toggle').toggle(this.checked);
        $('#label-pastis').toggleClass("fluixet", !this.checked);
    });//.change(); //ensure visible state matches initially


    //$('#inserta_resRESERVA_PASTIS').prop('checked', false).button("refresh");
    $('#confirma_data_inserta_res').prop('checked', false).button("refresh");
    $('#accesiblehora').prop('checked', false).button("refresh");
    $('#cadira0hora').prop('checked', false).button("refresh");
    $('#cotxets0hora').prop('checked', true).button("refresh");
    $('#selectorCotxets').buttonset("refresh");


    $('input[name=cb_sms').prop('checked', true);

    $("label.error").remove();
    $(".error").removeClass("error");
    
}

/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/
/******************************************************************************************************/

function fromDialog_novaReserva(taula, n, p, c, f)
{
    if (!validaData())
        return;
    CERCA = 0;
    $("#selectorAdults").show();
    onNovaReserva();

    P = p;
    C = c;
    F = f;
    TAULA = taula;
    $(".taulaid").val(taula);
    $(".taulanom").val(n);
    $(".places").html(p);
    $(".cotxets").html(c);
    $(".plena").html((f ? "si" : "no"));
    $("#zoom input[name='hora']:checked").prop('checked', false);

}


function upercase(selector)
{
    /** UPPERCASE **/
    $(selector + '  input').not('input[readonly]').bestupper();
    $(selector + '  textarea').bestupper();
}

/*******************************/
/*******************************/
/*******************************/
/*******************************/

/**
 // CRON BACKUP +o- CADA 30 min
 */
function cron_js() {
    comprova_backup();
    esborra_clients_llei();
    recordatori_petites_3dies();
}


/*******************************/
function comprova_backup()
{
    var desti = "gestor_reserves.php?a=reserves_orfanes";
    $.post(desti, {r: rand}, function (datos) {
        if (datos.substr(0, 14) == "<!--ORFANES-->")
            alert("ATENCIO!!!\nS'han detectat reserves perdudes: Per més detalls, ves al Panel de control > Eines avançades > Reserves perdudes");
        if (datos == "no_download")
            alert("Sembla que no s'estan fent descàrregues automàtiques del llistat de reserves ");
    });
    /* AUTO GENERA IMATGE DE MENJADORS */
    if (getFlashMovie("flash")) {
        getFlashMovie("flash").print();
        var currentdate = new Date();
        var datetime = "Last Sync: " + currentdate.getDate() + "/"
                + (currentdate.getMonth() + 1) + "/"
                + currentdate.getFullYear() + " @ "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();
        debug(datetime);
    }


    if (!BACKUP_INTERVAL)
        return;
    var d = new Date();
    var rand = d.getTime();
    var desti = "dumpBD.php?drop&file";
    $.post(desti, {r: rand}, function (datos) {
        if (datos == "backup" && permisos > 64){
            alert("S'ha realitzat una còpia de la base de dades");
        }
        else if(datos == "error" && permisos > 64) {
            alert("No s'ha pogut realitzar la còpia de la base de dades");
        }
    });

}

function esborra_clients_llei() {
    var desti = "esborra_clients_llei.php";
    $.post(desti, function (datos) {
        if (datos)
            alert("ESBORRA CLIENTS LLEI " + datos);
    });
}
function recordatori_petites_3dies() {
    var desti = "gestor_reserves.php?a=recordatori_petites_3dies";
    $.post(desti, function (datos) {
        //  if (datos.substr(0,4)!='test') alert("recordatori_petites_3dies "+datos);

    });
}

/**
 // CRON REFRESH +o- CADA 12 segons
 */
function comprova_refresh()
{
    var d = new Date();
    var rand = d.getTime();
    var desti = "gestor_reserves.php?a=refresh&r=" + rand;
    $.post(desti, {r: rand}, function (datos) {
        if (datos == "refresh")
        {
            timer(false);
            refresh();
            timer(true);

        }
    });
    var img = $("#imgCalendari").attr("src").split("?")[0];
    $("#imgCalendari").attr("src", img + "?" + rand);
    $("#refresh").slideDown().delay(500).slideUp();
}
;

function refresh()
{
    getFlashMovie("flash").canviData($("#calendari").val());
    recargaAccordionClients();
}



function timer(activa)
{
    debug(activa ? "ON" : "OFF");
    $(document).stopTime('refresh');
    if (activa) {
        $(document).everyTime(REFRESH_INTERVAL, 'refresh', comprova_refresh);
    }

    timeractiu = activa;
}

function validaData()
{
    var d = $("#calendari").datepicker("getDate");
    d.setHours(23);
    d.setMinutes(59);
    d.setSeconds(59);
    if (d < new Date())
    {
        alert("Estàs intentant editar un dia del passat");
        if (permisos < 64)
            return false;
    }
    return true;
}

/** AUTOCOMPLETE */
function actualitza_combo_clients(id)
{
    $(".autoc_id_client").val(id);
}

function clientCreat(datos)
{
    var nom = $('#insertClient input[name=client_nom]').val();
    var cognoms = $('#insertClient input[name=client_cognoms]').val();
    var t1 = $('#insertClient input[name=client_mobil]').val();
    var t2 = $('#insertClient input[name=client_telefon]').val();
    var v = cognoms + ", " + nom + " (" + t1 + " - " + t2 + ")";

    $("#autoc_client_inserta_res").val(v);
    $(".autoc_id_client").val(datos);
    recargaAccordionClients();
}


function controlaSopars()
{
    var dia = $("#calendari").datepicker("getDate").getDay();
    var torn = $("input[name='radio']:checked").val();

    if (!AR__NITS_OBERT[dia] && !excepcions_nits($("#calendari").datepicker("getDate")))
    {
        $("#lblTorn3").hide();
        if (torn == 3)
        {
            torn = 1;
            $("input[name='radio']").prop("checked", false);
            $("#torn1").prop("checked", true);
            $("input[name='radio']").button("refresh");
            if (getFlashMovie("flash"))
                getFlashMovie("flash").canviData($("#calendari").val());
            return 1;
        }
    }
    else
        $("#lblTorn3").show();

    return 0;
}

function excepcions_nits(date) {
    /*
     var dia=date.getDate();
     var mes=date.getMonth();
     
     if (dia==14 && mes==11) return true;
     if (dia==21 && mes==11) return true;
     */
    return false;
}

function cercaReserves(s)
{
    $("#reservesAc").hide();
    /*
     try {
     $("#reservesAc").accordion("destroy");
     } catch (e) {
     }
     ;
     */
    if (s && s != "" && s != "Cerca...")
        s = "&c=" + s;


    $.ajax({url: "gestor_reserves.php?a=cerca_reserves" + s, success: function (datos) {
            $("#reservesAc").html(decodeURIComponent(datos));
            ////*ANULAT $("#reservesAc").accordion(acopres);

            $(".fr").mouseover(function () {
                taulaSel = $(this).attr("taula");
                getFlashMovie("flash").seleccionaTaula(taulaSel);
            });
            $(".fr").mouseout(function () {
                taulaSel = $(this).attr("taula");
                getFlashMovie("flash").seleccionaTaula(0);
            });

            //$( "#reservesAc" ).accordion("resize");
            addHandlersAccordionReserves();
            ////*ANULAT$("#reservesAc").show("fade").accordion("refresh");
            $("#reservesAc").show("fade");
            ;
        }});
}


function cercaTaula()
{
    var p = $("#selectorComensals input:checked").val();
    p = p ? p : "0";
    var q = $("#selectorCotxetsCerca input:checked").val();
    var r = $("#selectorFinde input:checked").val() == "on" ? "1" : "0";
    $("#cercaTaulaResult").html('<img class="loading" src="css/loading.gif" />');
    $.ajax({url: "gestor_reserves.php?a=cerca_taula&p=" + p + "&q=" + q + "&r=" + r, success: function (dades) {
            $("#cercaTaulaResult").html(dades);
            $("#cercaTaulaResult a").click(function (e) {

                TAULA = $(this).attr("href");
                //var dia=$(this).attr("dia");
                //var torn=$(this).attr("torn");				
                N = $(this).attr("n");
                P = $(this).attr("p");
                C = $(this).attr("c");
                F = $(this).attr("f");
                //$.ajax({url: "gestor_reserves.php?a=canvi_data&p="+dia+"&q="+torn,success:function(){recargaAccordioReserves("open")}});
                fromDialog_novaReserva(TAULA, N, P, C, F);
                $("#frm_edit_modal_inserta_res input[name=adults]").val(P);
                $("#frm_edit_modal_inserta_res input[name=total]").val(P);
                CERCA = P;
                $("#selectorAdults").hide();

                return false;
            });
        }});
}
/**/
function botonera_adults(e)
{
    if ($("#selectorAdults input:checked").val())
        $(".inserta_res input[name=adults]").val($("#selectorAdults input:checked").val());
    $("#selectorAdults input:checked").prop("checked", false);
    $("#selectorAdults input").button("refresh");
    calcula_adults(e);
}
function botonera_nens4_9(e)
{
    if ($("#selectorNens4_9 input:checked").val())
        $(".inserta_res input[name=nens4_9]").val($("#selectorNens4_9 input:checked").val());
    $("#selectorNens4_9 input:checked").prop("checked", false);
    $("#selectorNens4_9 input").button("refresh");
    calcula_adults(e);
}
function botonera_nens10_14(e)
{
    if ($("#selectorNens10_14 input:checked").val())
        $(".inserta_res input[name=nens10_14]").val($("#selectorNens10_14 input:checked").val());
    $("#selectorNens10_14 input:checked").prop("checked", false);
    $("#selectorNens10_14 input").button("refresh");
    calcula_adults(e);
}
function calcula_adults(e) {
    $(".inserta_res input[persones]").unbind("change");
    var total = 0 + Number($(".inserta_res input[name=adults]").val()) + Number($(".inserta_res input[name=nens4_9]").val()) + Number($(".inserta_res input[name=nens10_14]").val());

    if (CERCA)
    {
        var aux = CERCA - $(".inserta_res input[name=nens4_9]").val();
        aux -= $(".inserta_res input[name=nens10_14]").val();
        $(".inserta_res input[name=adults]").val(aux);

        $(".inserta_res input[name=total]").val(total);
    }
    else
    {
        if (total > P)
        {
            var N = Number($(".inserta_res input[name=adults]").val());
            var N4 = Number($(".inserta_res input[name=nens4_9]").val());
            var N10 = Number($(".inserta_res input[name=nens10_14]").val());
            var Q = N + N4 + N10;

            var aux = P - N4;
            aux -= N10;
            $(".inserta_res input[name=total]").val(total);
            alert("El nombre de persones (" + Q + ") és massa gran per aquesta taula (" + P + ").\n\nES REDUIRÀ AUTOMÀTICAMENT EL NOMBRE D'ADULTS A " + aux);
            $(".inserta_res input[name=adults]").val(aux);
            $(".inserta_res input[name=total]").val(total);
        }
    }

    var total = 0 + Number($(".inserta_res input[name=adults]").val()) + Number($(".inserta_res input[name=nens4_9]").val()) + Number($(".inserta_res input[name=nens10_14]").val());
    $(".inserta_res input[name=total]").val(total);
    $(".inserta_res input[persones]").bind("change", calcula_adults);

}

function controlNumMobil()
{
    $(".sense-numero").click(function () {
        if ($("#campsClient input[name='client_mobil']").is(":visible"))
        {
            $("#campsClient input[name='client_mobil']").hide();
            $("#campsClient input[name='client_mobil']").val("999999999");
            if ($("#campsClient input[name='client_nom']").val() == "")
                $("#campsClient input[name='client_nom']").val("SENSE_NOM");
            $(".sense-numero").html("Introduïr número");
            $("#campsClient input[name='client_cognoms']").focus();

        }
        else
        {
            $("#campsClient input[name='client_mobil']").val("");
            $("#campsClient input[name='client_mobil']").show();
            $(".sense-numero").html("Sense número");
        }
    });
}

function validationRules() {
    $.validator.messages.required = 'Aquest camp és necessari';
    var val = {
        rules: {
            client_cognoms: "required",
            client_nom: "required",
            client_email: {
                email: true,
                remote: "verify_email.php"
            },
            client_mobil:
                    {
                        required: true,
                        number: true,
                        minlength: 9
                    },
            confirma_data: "required",
            hora: "required",
            data: "required",
            adults: {min: 1}
        }

    }

    return val;
}

function debug(text)
{
    $("#debug_out").html(text);
}


function get_timer() {
    var d = new Date();
    return d.getTime();
}

function demana_usuari() {
    if (permisos < 127) {
        $('<div id="editor-id" style="display:none"></div>').appendTo('form.inserta_res');

        $("#editor-id").load("select_editor_form.php", function () {

            jQuery("#confirma-editor button").click(function () {
                jQuery("#editor-id").dialog("close");
                $("#editor-id").remove();
                var editor = jQuery("input[name=editor_id]").val();
                var confirma = $(this).val();
                if (editor != confirma) {
                    alert("No coincideixen!");
                    return false;
                }

                $('form.inserta_res').ajaxSubmit({target: '#reservesAc', success: recargaAccordioReserves});
                $("#insertReserva").dialog("close");
                timer(true);
                return false;
            });
        });

        $("#editor-id").dialog({
            autoOpen: true,
            close: function () {
                $(this).remove();
            },
            modal: true
        });
        
        return false;
    }
        return true;
}

function guarda_insert_reserva(e) {
    if(e.currentTarget.id) jQuery("input[name=editor_id]").val(e.currentTarget.id);

    guardat = true;
    if (!$("form.inserta_res").validate().form())
        return;

    var confirmat = demana_usuari();
    //var confirmat = true;
    if (!confirmat) {
        return false;
    }

    $('form.inserta_res').ajaxSubmit({target: '#reservesAc', success: recargaAccordioReserves});
    $(this).dialog("close");
    timer(true);
    return false;
}

function editor_buttonsfn() {
    var obj = {
        Guarda: guarda_insert_reserva
    };
    if (permisos < 127) {
        obj = {
            JosepRovira: {id: "1", text: "Josep Rovira", click: guarda_insert_reserva},
            LluisRovira: {id: "7", text: "Lluís Rovira", click: guarda_insert_reserva},
            Mari: {id: "8", text: "Mari", click: guarda_insert_reserva},
        };
    }
    return obj;
}

function roundNumber(num, dec) {
    var result = Math.round(num * Math.pow(10, dec)) / Math.pow(10, dec);
    return parseFloat(result.toFixed(dec));
}

function isNumber(value) {
	return !isNaN(parseInt(value, 10));
}


