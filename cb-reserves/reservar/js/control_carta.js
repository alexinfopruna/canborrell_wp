/* 
 * NOU
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function l(p){return p;}

$(function () {
    initCarta();
});
    
    function initCarta(){
    /* popup */
    /* popup CARTA */
    if (typeof l !== "undefined") { 
    // safe to use the function
    //function l(p){return p}
}
    
    
    $("#fr-menu-popup").dialog({
        autoOpen: false,
        modal: true,
        width: 800,

        close: updateMenu,
        buttons: {
            "Fet": function () {
                $(this).dialog("close");
            }
        }

    });
    /* popup MRNU  */
    $("#fr-cartaw-popup").dialog({
        autoOpen: false,
        modal: true,
        width: 800,
        close: updateCarta,
        buttons: {
            "Fet": function () {
                $(this).dialog("close");
            }
        }

    });

    $("#bt-no-carta").click(function (e) {
        //var totalPersones = parseInt(totalPersones());
        var totalPersones = parseInt($("#totalComensals").val());
        // alert(totalPersones);
        if (totalPersones <= PERSONES_MENU_OBLIGAT) {
            updateCarta();
            comportamentClient();
        }
        e.preventDefault();
        return false;
    });

    $("#bt-carta").click(function () {
        
        //$(".cmenu .carta-seleccio").removeClass("carta-seleccio");
        //$(".cmenu .contador").val(0);
        //$( "#fr-cartaw-popup" ).dialog( "option", "height", 750 );
        SELECT_CARTA = true;
        $("#fr-cartaw-popup").dialog("open");
        $("#fr-carta-tabs").tabs("option", "selected", 0);
        return false;
    });
    $("#bt-menu").click(function () {
        //$(".ccarta .carta-seleccio").removeClass("carta-seleccio");
        //$(".ccarta .contador").val(0);
        SELECT_CARTA = false;
        $("#fr-menu-popup").dialog("option", "height", 750);
        $("#fr-menu-popup").dialog("open");
        $("#fr-menu-tabs").tabs("option", "selected", 0);
        return false;
    });
    //  $("#carta_MENUS .resum-carta-nom").tooltip({cssClass:"tooltip-red",delay : 100});
    $(".llistat_menus .resum-carta-nom").tooltip({cssClass: "tooltip-red", delay: 100});

    $(".resum-carta-nom").click(function (e) {
        $(this).closest("tr").find("td.mes a").trigger("click");
        e.preventDefault();
        return false;
    });

//CONTROL CARTA	
    $(".mes").click(function () {
        var input = $(this).parent().find("input");
        var n = parseInt(input.val());
        if (isNaN(n))
            n = 0;
        if (n < 100)
            input.val(parseInt(n) + 1);
        input.trigger("change");
        //alert("+");
    });

    $(".menys").click(function () {
        var input = $(this).parent().find("input");

        var n = parseInt(input.val());
        if (n >0) n--;
        input.val(parseInt(n));
        input.trigger("change");
        
        
        var pid= $(this).parent().attr('producte_id');
   
        if (pid==2037 || pid==2036) {           
            var na = parseInt($("input[name='adults']").val());
            var nj = parseInt($("input[name='nens10_14']").val());
            var nn = parseInt($("input[name='nens4_9']").val());
        let menusjunior = parseInt($("input[nid='2036']").val());
        let menusnens = parseInt($("input[nid='2037']").val());


            na = na ? na : 0;
            nj = nj ? nj : 0;
            nn = nn ? nn : 0;
            if (MENU_NENS_OBLIGAT && (nj+nn) > (menusnens+menusjunior))  {
                
                n += (nj+nn)-(menusnens+menusjunior);
               // ZZZalert("Heu de demanar obligatoriament un menú per cada infant");
                //alert(l("INFO_MENU_NENS"));
                help(l("INFO_MENU_NENS"));
            }
        }        
        
        input.val(parseInt(n));
        input.trigger("change");
        //alert("-");
    });
    $(".contador").change(function (event) {
        /****************************************************
         * CONTROLA MENUS NO COMBINABLES!!!!!!
         * @type jQuery|Boolean|Object
         */
        var nid = $(this).attr('nid');

        if ((jQuery("#carta_contador2011").val() > 0 || jQuery("#carta_contador2010").val()) > 0 && jQuery(".contador.cmenu").not(" #carta_contador2010, #carta_contador2011").filter(function () {
            return $(this).val() > 0;
        }).size()) {
            if (confirm(l("CALÇOTADA_NO_COMBINABLE"))) {
                //jQuery(".contador.cmenu").not(" #carta_contador2010, #carta_contador2001, #carta_contador2037, #carta_contador2036").each(function () {
                jQuery(".contador.cmenu").not("#carta_contador2011, #carta_contador2010").each(function (el) {
                    //alert(el);
                    $(this).val(0);
                    $(this).removeClass("carta-seleccio");
                });
            } else {
                event.preventDefault();
                $(this).val(0);
                return false;
            }
        }

        if (jQuery("#carta_contador2007").val() > 0 && jQuery(".contador.cmenu").not(" #carta_contador2007").filter(function () {
            return $(this).val() > 0;
        }).size()) {
            if (confirm(l("N4_NO_COMBINABLE"))) {
                jQuery(".contador.cmenu").not(" #carta_contador2007").each(function () {
                    $(this).val(0);
                    $(this).removeClass("carta-seleccio");
                });
            } else {
                event.preventDefault();
                $(this).val(0);
                return false;
            }
        }

        /*
         * NO COMBINABLES
         ****************************************/



        var n = $(this).val();

        if (!isNumber(n) || n <= 0 || n > 100)
        {
            $(this).val(0);
            $(this).parent().next().removeClass("carta-seleccio");
            $(this).removeClass("carta-seleccio");

        } else
        {
            $(this).parent().next().addClass("carta-seleccio");
            $(this).addClass("carta-seleccio");
        }
        var preu = $(this).parent().parent().find(".carta-preu").html();
        $(this).parent().parent().find(".carta-preu-subtotal").html(n * preu);

        cont = $(".contador");
        n = 0;
        var t = cont.length;
        for (i = 0; i < t; i++) {
            k = parseInt($(cont[i]).val());
            if (k)
                n += k;
        }
        $("#carta-total").html("Total: " + n);
    });
    //RESET CARTA
    $(".contador").each(function () {
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
    
    
 
}







/********************************************************************************************************************/
function updateMenu()
{
    updateCarta("menu");
}

function updateCarta(menu)
{
$(".titol.titol1 img").attr("title","Info reserves (2019)");

    var clas = (menu == "menu") ? ".cmenu" : ".ccarta";
    var clasBorra = (menu != "menu") ? ".cmenu" : ".ccarta";
    if (menu == "inici")
        clasBorra = "noborrisres";
    if ($(clas + ".carta-seleccio").val() != undefined && $(clas + ".carta-seleccio").val() != 0 && $(clas + ".carta-seleccio").val() != "0")
    {
        $(clasBorra + " .carta-seleccio").removeClass("carta-seleccio");
        $(" .contador" + clasBorra).val(0);
    }


    var total = 0;
    var taula = '<tr><td resum-carta-nom><h3>' + l("SELECCIÓ") + '</h3></td><td class="resum-carta-preu"></td><td></td></tr>';
    var i = 0;
    var plats = 0;

    //NETEGEM L'ALTRA POPUP (carta / menu)

    $(".contador").each(function () {
       
        if ($(this).val() != undefined && $(this).val() != 0 && $(this).val() != "0")
        {
            //alert( $(".contador").length);//////////////////////////
            
            
            i++;
            var hidden = '<input type="hidden" name="plat_id_' + i + '" value="' + $(this).attr('nid') + '"/>';
            hidden += '<input type="hidden" name="plat_quantitat_' + i + '" value="' + $(this).val() + '"/>';

            var preu = $(this).val() * $(this).attr("preu");
            preu = roundNumber(preu, 2);

            taula += '<tr><td class="resum-carta-nom">' + $(this).val() + ' x <b>' + $(this).attr('nom') + '</b></td><td class="resum-carta-preu">' + preu + '€ </td><td>' + hidden + '</td></tr>';
            total += parseFloat($(this).val() * $(this).attr("preu"));
            total = roundNumber(total, 2);
            plats += parseInt($(this).val());
        }
    });
    if (total == 0)
        taula += '<tr><td class="resum-carta-nom">' + l("No hi ha cap plat seleccionat") + '</td><td class="resum-carta-preu"></td><td></td></tr>';
    else
    {
        taula += '<tr ><td resum-carta-nom></td><td class="resum-carta-iva" style="text-alig:right"></td><td></td></tr>';
        taula += '<tr style="background:#eee;"><td class="resum-carta-nom"><h3 id="resum-total" style="display:inline">TOTAL</h3></td><td class="resum-carta-preu" style="text-alig:right"><h3>' + total + '€ <br/><span class="resum-carta-iva">(IVA ' + l("inclòs") + ')</span></h3></td><td></td></tr>';
    }
    $("#caixa-carta").html(taula);

$(".form_edit .info-comanda").html(taula);

    $("#resum-comanda").html(plats);
    $("#resum-preu").html(total);
    $("#te-comanda").val(plats);
    $("#te-comanda").change();

    var na = parseInt($("input[name='adults']").val());
    var nj = parseInt($("input[name='nens10_14']").val());
    var nn = parseInt($("input[name='nens4_9']").val());

    na = na ? na : 0;
    nj = nj ? nj : 0;
    nn = nn ? nn : 0;
    var total = na + nj + nn;
    

    

    
    var dat = $("#calendari").datepicker("getDate");
    if(dat) {
        var excepcioNadal = excepcio_nadal(dat);
      //  $("#bt-no-carta").hide();
        if (excepcioNadal && !GRUPS){
           
           seccio("fr-seccio-carta");
           $(".fr-seccio-client").hide();
            $("#bt-no-carta").hide(); 
            if (total<=plats) $("#bt-no-carta").show();    

            }
        }
    }    
    
     
    



/********************************************************************************************************************/
/********************************************************************************************************************
 COMPORTAMENT EXCEPCIONS STESTEVE,ANYNOU,REIS
 */
function updateMenus() {
    
    var dat = $("#calendari").datepicker("getDate");
    var excepcioNadal = excepcio_nadal(dat);
//alert(excepcioNadal);
    $("#carta_MENUS tr").show();

    $("#bt-carta").show();
    $("#fr-carta-tabs").show();
    //$("#bt-menu span").html(l("Veure els menús"));

    if (excepcioNadal) {
        /*
         * MENUS
         */
         // alert(l("INFO_CARTA_NADAL"));
         
        $(".col-isqui-carta .info.caixa").html(l("INFO_CARTA_NADAL"));
        $("#bt-menu span").html(l("Menús Nadal"));
        $("#carta_MENUS tr").hide();
        /*
        $("#carta_MENUS tr[producte_id=2002]").show(); //N3
        $("#carta_MENUS tr[producte_id=2004]").show(); //infantil
        $("#carta_MENUS tr[producte_id=2011]").show(); //infantil
        $("#carta_MENUS tr[producte_id=2023]").show(); //junior
        $("#carta_MENUS tr[producte_id=2024]").show(); //n1
        */
        
        $("#carta_MENUS tr[producte_id=2001]").show(); //N1
        $("#carta_MENUS tr[producte_id=2003]").show(); //n2
        $("#carta_MENUS tr[producte_id=2012]").show(); //n3
        $("#carta_MENUS tr[producte_id=2007]").show(); //n4
        $("#carta_MENUS tr[producte_id=2036]").show(); //inf
        $("#carta_MENUS tr[producte_id=2037]").show(); //jun
        $("#carta_MENUS tr[producte_id=2010]").show(); //jun
 
        /*
                $("#carta_ tr").hide();
        $("#carta_ tr[producte_id=2002]").show(); //N1+cava
        $("#carta_ tr[producte_id=2004]").show(); //N2+cava
        $("#carta_ tr[producte_id=2011]").show(); //calçot+cava
        $("#carta_ tr[producte_id=2023]").show(); //junior
        $("#carta_ tr[producte_id=2024]").show(); //n1
*/

        /*
         * CARTA
         */
        $("#bt-carta").hide();
        $("#bt-no-carta").hide();
        $("#fr-carta-tabs").hide();
        
        

    }else{
                $(".col-isqui-carta .info.caixa").html(l("INFO_CARTA"));
        $("#bt-menu span").html(l("Menús"));
       // $("#bt-menu span").hide();

        $("#bt-no-carta").show(); 
       

    }
}

/********************************************************************************************************************/
function excepcio_nadal(dat) {
    //alert(ACTIVA_DIES_ESPECIALS?"T":"F");
    if (ACTIVA_DIES_ESPECIALS == "false")
        return false;
    var excepcio = false;
    if (dat.getDate() == 26 && dat.getMonth() == 11)
        excepcio = true; //stesteve
    if (dat.getDate() == 1 && dat.getMonth() == 0)
      excepcio = true; 
    if (dat.getDate() == 6 && dat.getMonth() == 0)
      excepcio = true; 

    

    /*
    if (dat.getDate() == 6 && dat.getMonth() == 0)
        excepcio = true; //reis
*/
    //va1ida si es obligatori triar menu
    /*
     */
    if (excepcio) {
        var totalComensals = $("input[name=totalComensals]").val();
        $("#te-comanda").rules("add", {
            required: true,
            min: totalComensals,
            messages: {
                required: l('err56'),
                min: l('Número menús insuficiente')
            }
        });
    } else {
        try{
            $("#te-comanda").rules("remove");
        }catch(error) {
            
        }
        
    }

    return excepcio;
}
