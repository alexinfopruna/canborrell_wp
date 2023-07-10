<?php
/*
  Template Name: Input pagament
 */
get_header();

$sidebar = isset($page_meta['page_layout']) ? $page_meta['page_layout'] : 'none';
$left_sidebar = isset($page_meta['left_sidebar']) ? $page_meta['left_sidebar'] : '';
$right_sidebar = isset($page_meta['right_sidebar']) ? $page_meta['right_sidebar'] : '';
$full_width = isset($page_meta['full_width']) ? $page_meta['full_width'] : 'no';
$display_breadcrumb = isset($page_meta['display_breadcrumb']) ? $page_meta['display_breadcrumb'] : 'yes';
$display_title = isset($page_meta['display_title']) ? $page_meta['display_title'] : 'yes';
$padding_top = isset($page_meta['padding_top']) ? $page_meta['padding_top'] : '';
$padding_bottom = isset($page_meta['padding_bottom']) ? $page_meta['padding_bottom'] : '';

if ($full_width == 'no')
  $container = 'container';
else
  $container = 'container-fullwidth';

$aside = 'no-aside';
if ($sidebar == 'left')
  $aside = 'left-aside';
if ($sidebar == 'right')
  $aside = 'right-aside';
if ($sidebar == 'both')
  $aside = 'both-aside';

$container_css = '';
if ($padding_top)
  $container_css .= 'padding-top:' . $padding_top . ';';
if ($padding_bottom)
  $container_css .= 'padding-bottom:' . $padding_bottom . ';';

/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
/* * ************************************************************************************* */
$r = null;
$surt = false;

// RESET ESTA (testTPV)
if (isset($_REQUEST['reset_estat']) && $_REQUEST['reset_estat'] == 'reset_estat') {
  $id_reserva = isset($_REQUEST['pidr']) ? $_REQUEST['pidr'] : '****';
  $idr = substr($id_reserva, -4);
  $dest = 'http://' . $_SERVER['HTTP_HOST'] . "/cb-reserves/reservar/Gestor_form.php?a=reset_estat&b=$idr&c=reserves";
  header("Location: $dest ");
}

if (!defined('ROOT'))
  define('ROOT', "cb-reserves/taules/");
require_once(ROOT . "Gestor.php");
require_once(ROOT . "gestor_reserves.php");

require(ROOT . DB_CONNECTION_FILE);
require_once(ROOT . INC_FILE_PATH . 'valors.php');
require_once(ROOT . INC_FILE_PATH . 'alex.inc'); //valida_admin('editar.php') ;
$titol['cat'] = "PAGAMENT DE RESERVA";
$titol['esp'] = "PAGO DE RESERVA";
$titol['en'] = "PAYMENT OF RESERVATION";
$subtitol['cat'] = "Dades de la reserva";
$subtitol['esp'] = "Datos de la reserva";
$subtitol['esp'] = "Reservation Information";

/* * *************************************************************************** */
$gestor = new gestor_reserves();
/* * *************************************************************************** */
if (!isset($_GET['rid']))
  die("ERRROR: Falta RID");
$rid = base64_decode($_GET['rid']);
$st = explode('&', $rid);
$id = $_GET["id"] = $st[0];
$_GET["mob"] = $st[1];

$r = $gestor->load_reserva($_GET["id"], 'reserves');

$mob = $r['tel'];

if (intval($mob) != intval($_GET["mob"]))
  header('Location: /reservar/localitza-reserva/&lang=' . ICL_LANGUAGE_CODE);

$result = "";
$rid = "";
$mobil = "";

$gestor->xgreg_log("PÀGINA PAGAMENT GRUPS: <span class='idr'>$id</span>");
//CADUCADES
//$query_reserves = "UPDATE reserves SET estat=6 WHERE ADDDATE(data_limit,INTERVAL 1 DAY) < NOW() AND data_limit>'2008-01-01' AND estat=2";
$query_reserves = "UPDATE reserves SET estat=6 WHERE data_limit < DATE_SUB(CURDATE(), INTERVAL 1 DAY) AND data_limit>'2008-01-01' AND estat=2";
$reserves = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if ($id) {
  $query = "SELECT * FROM reserves WHERE id_reserva=$id";
  $Result = mysqli_query($canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $fila = mysqli_fetch_assoc($Result);
  $estat = $fila['estat'];
  $import = $preu = $fila['preu_reserva'];
  $nom = $fila['nom'];
  $lang = $lang_cli = $fila['lang'];


  $usr = new Usuari($fila['client_id'], $fila['nom'], 1);
  $_SESSION['uSer'] = $usr;
}
else {
  
}
if (!isset($lang))  $lang = $lang_cli = "esp";

$lang = ICL_LANGUAGE_CODE;
$old_lang_code['cat'] = 'cat';
$old_lang_code['ca'] = 'cat';
$old_lang_code['es'] = 'esp';
$old_lang_code['esp'] = 'esp';
$old_lang_code['en'] = 'en';


$lang = $old_lang_code[$lang];

defined('ROOT') or define('ROOT', 'cb-reserves/taules/');
require_once (ROOT . "../taules/Gestor_pagaments.php");
$pagaments = new Gestor_pagaments();
// comprovacions estat reserva
// ARREGLAR MISSATGES
//if (($estat == 3) || ($estat == 7)) { // JA S?HA PAGAT 
$estat_multipago  = $pagaments->get_estat_multipago($id);
//echo $estat;
//echo "EEE";
//echo $estat_multipago;die();
//if ($estat_multipago == 100) { // JA S'HA PAGAT 
if (FALSE) { // JA S'HA PAGAT 
  $titol['cat'] = "Aquesta reserva ja ha estat pagada<br><br><br><br><br><br>";
  $titol['esp'] = "Esta reserva ya ha sido pagada<br><br><br><br><br><br><br>";
  $titol['en'] = "This reservation has now been paid<br><br><br><br><br><br><br>";
  $surt = true;
  $gestor->xgreg_log($titol['cat'], 1);
}
else if ($estat == 6) {
  $titol['cat'] = "Lamentablement aquesta reserva ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Lamentablemente esta reserva ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
  $titol['en'] = "Unfortunately, this reservation has not been confirmed or has expired! Contact the restaurant<br><br><br><br><br><br><br><br>";
  $surt = true;
  $gestor->xgreg_log($titol['cat'], 1);
}
else if ($estat != 2 && $estat != 3 && $estat != 7) {    // NO ESTA CONFIRMADA
  $titol['cat'] = "Lamentablement aquesta reserva no ha estat confirmada o ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Lamentablemente esta reserva no ha sido confirmada o ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
  $titol['en'] = "Unfortunately, this reservation has not been confirmed or has expired! Contact the restaurant<br><br><br><br><br><br><br><br>";
  $surt = true;
  $gestor->xgreg_log($titol['cat'], 1);
}


// CADUCADA???
$d1 = cambiaf_a_normal($fila['data']);
$d2 = date("d/m/y");
$dif = compara_fechas($d1, $d2);
if ($dif < 0) {
  $titol['cat'] = "Aquesta reserva ha caducat! Contacti amb el restaurant<br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Esta reserva ha caducado! Contacte con el restaurante<br><br><br><br><br><br><br><br>";
  $titol['en'] = "This reservation has expired! Contact the restaurant<br><br><br><br><br><br><br><br>";
  $x = true;
  $gestor->xgreg_log($titol['cat'], 1);
}

// EXISTEIX???
if (mysqli_num_rows($Result) <= 0) {
  $titol['cat'] = "Ho sentim però aquesta reserva no apareix a la base de dades<br><br><br><br><br><br><br><br><br>";
  $titol['esp'] = "Lo sentimos pero esta reserva no aparece en la base de datos<br><br><br><br><br><br><br><br><br>";
  $titol['en'] = "We’re sorry, but this reservation does not appear on our database<br><br><br><br><br><br><br><br><br>";
  $surt = true;
  $gestor->xgreg_log($titol['cat'], 1);
}

$translate['COMPRA_SEGURA']['esp'] = "Para realizar el pago a través de esta pasarela bancaria, es necesario que hayas activado la tarjeta para COMPRA SEGURA A INTERNET en tu banco.\\n\\nCon esta activación te facilitarán un código de cuatro cifras que se requiere al final del proceso.\\n\\nDisculpa las moléstias";
$translate['COMPRA_SEGURA']['cat'] = "Per poder realitzar el pagament a través d´aquesta passarel·la bancaria, cal que hagis activat la tarja per a COMPRA SEGURA A INTERNET al teu banc. \\n\\nAmb aquesta activació et facilitaran un codi de quatre xifres que és requerit al final del procès.\\n\\nDisculpa les molèsties";
$translate['COMPRA_SEGURA']['en'] = "To make a payment using this bank gateway, you must activate the card for SECURE ONLINE PURCHASE in your bank.\\n\\nWith this activated you are given a code of four digits, needed to complete the process.\\n\\nSorry for the inconvenience";

$data_limit = Gestor::cambiaf_a_normal($fila['data_limit']);

switch ($lang){
  case 'cat':
    $translate['INFO_MULTIPAGO'] = "El nostre sistema permet que feu <b>diversos pagaments independents</b> "
    . "de la manera que més us convingui (per persona, per famílies...). Simplement pagueu la part que us correspon i reenvieu l'email de confirmació a les altres famílies perquè completin els pagaments restants</p> <p><i>Per exemple, si sou 5 famílies de 4 persones,"
      . " cada família pot pagar la part corresponent als 4 comensals que li toquen de manera que quedi més repartit</i></p>"
      . "<p>Si us resulta més senzill, també podeu fer un sol pagament integre de tot l'import.</p>"
      . '<div class="alert alert-warning">Tot i això, el restaurant us recomana que <b>cada comensal o família pagui la seva part</b> per tal de tenir més clar qui vindrà i qui no.</div>';
    
$translate['INFO_MULTIPAGO2'] = "<p>El restaurant només tindrà en compte les reserves <b>pagades</b> fins al <b>$data_limit</b>. El nombre de comensals reservats inicialment <b>no té valor si no s'ha abonat l'import corresponent</b> a tots els coberts.</p>"
    . "<p><i>Per exemple: Si heu reservat per 20 persones però <b>només n'heu abonat 15, el restaurant us prepararà taula per 15 comensals</b></i></p>";

  break;
    
  case 'es':
  case 'esp':
    $translate['INFO_MULTIPAGO'] = "<p>Nuestro sistema permite que hagáis <b>diversos pagos separados</b> "
    . "de la manera que más os convenga (por persona, por familias...). Simplemente paga la parte que os corresponde i reenvía el email de confirmación a las otras familias para que completen el pago restante</p> "
      . "<p><i>Por ejemplo, si sóis 5 familias de 4 personas, cada familia podría pagar la parte correspondiente a los 4 comensales que le tocan de manera que queda más repartido</i></p>"
      . "<p>Si os resulta más sencillo, también podéis hacer un solo pago de todo el importe."
           . '<div class="alert alert-warning">De todos modos, el restaurant os recomienda que <b>cada comensal o familia pague su parte</b> con el fin de tener más claro quién asistirá.</div>';


    
    $translate['INFO_MULTIPAGO2'] = "<p>El restaurant solo tendrá en cuenta las reservas <b>pagadas</b> hasta el <b>$data_limit</b>. El número de comensales indicados inicialmente <b>no tiene valor si no se ha abonado el importe correspondiente</b> a todos los cubiertos.</p>"
    . "<p><i>Por ejemplo: Si habéis reservado para 20 personas pero <b>solo habéis abonado 15 reservas, el restaurant os preparará mesa para 15 comensales</b></i></p>";

  break;

  case 'en':
        $translate['INFO_MULTIPAGO'] = "<p> You can make a single payment of the entire amount but, if you prefer, to prevent a single person from paying the entire amount of the reservation, our system allows you to make <b> several separate payments </b> "
      . "in the way that suits you best (per person, by families ...). "
      
      .'<div class="alert alert-warning">Anyway we suggest you to make <b>separate payments</b></div>';
    $translate['INFO_MULTIPAGO2'] = "<p> The restaurant will only consider <b> paid </b> reservations. The number of guests initially booked <b> has no value if the corresponding amount has not been paid </ b> for all the people reserved. </p> "
        . "<p> <i> For example: If you have reserved for 20 people but you only paid 15, the restaurant will prepare a table for 15 diners </i> </p>";
  break;  
}

//$translate['INFO_MULTIPAGO2']['en'] = "";
//$translate['INFO_MULTIPAGO2']['esp'] = "";
$translate['INFO_TOT_PAGAT'] = "<p>Ja s'ha satisfet la totalitat de l'import de la reserva.</p><h3> Us esperem Can Borrell!!</h3>";


((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);

$responaseok_callback_alter = "reserva_grups_tpv_ok_callback";
$preu_persona = $pagaments->get_preu_persona_reserva($id);
?>
<?php echo Gestor::loadJQuery(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script language=JavaScript>
  var TEST = <?php echo (isset($_REQUEST["testTPV"]) && $_REQUEST["testTPV"] == 'testTPV')?'true':'false';?>;
  var preu_unit = <?php echo $preu_persona ?>;
  var fcallback = "<?php echo $responaseok_callback_alter ?>";
  var import_pendent = "<?php echo $pagaments->get_import_pendent($id); ?>";
  var coberts_pendents =  Math.ceil(import_pendent / preu_unit );
  PAGAMENTS_PARCIALS = <?php echo (defined('PAGAMENTS_PARCIALS') && PAGAMENTS_PARCIALS == true)?"true":"false";  ?>;
  $(function () {
    
     $("#boto").click(submit_handler);
      button_state(false);
      
 
  //$("#compra").validate();
  
      $("#pagament").validate({
          errorContainer: $("#error_validate"),
          debug: true,
          errorElement: "em",
          rules: {
              ncoberts: {
                  required: true,
                  min: 1,
                  max: coberts_pendents
              },
              nom:
                      {
                          required: true,
                          minlength: 3
                      }
          },
          messages: {
              ncoberts: {
                  required: l("TOTAL!!!"),
                  min: l("Selecciona, com a a mínim, 1 cobert"),
                  max: l("Com a màxim pots pagar " + (coberts_pendents) + " coberts")
              },
              nom:
                      {
                          required: l("Indica un nom"),
                          minlength: l("Indica un nom")
                      }
          }
      });

  });

 $(function () {
      button_state(!PAGAMENTS_PARCIALS);
   
      $("#pagament").submit(function(e){
        alert("Continue...");
        e.preventDefault();
        return false;
      });

      $("#nom").change(function () {
        button_state(false);
        if ($("#pagament").valid()) button_state(true);
      });
      
      $("#ncoberts").change(function () {
        button_state(false);
          var coberts = $("#ncoberts").val();
          var preu = preu_unit * coberts;
          var reserva = $("#reserva_id").html().trim();
          var nom = $("#nom").val();
          if (nom = "")   nom = "Sense_nom";
          
          if (preu > import_pendent) preu = import_pendent;
          preu = Number(preu).toFixed(2);
          $("#preu_parcial").html(preu);

          if (TEST) var desti = "/cb-reserves/taules/gestor_reserves.php?a=generaTESTTpvSHA256&b=" + reserva + "&c=" + preu + "&d=" + nom + "&e=" + fcallback;
          else var desti = "/cb-reserves/taules/gestor_reserves.php?a=generaFormTpvSHA256&b=" + reserva + "&c=" + preu + "&d=" + nom + "&e=" + fcallback;
          $(".form_tpv").load(desti,function(){
            $( "#boto").unbind( "click" );
            $( "#boto").unbind( "click" );
            $("#boto").click(submit_handler);
                 // $("#boto").hide();
                
            if ($("#pagament").valid()) button_state(true);

          });
      });
  });

  function ctimer(idr) {
  var order = $("#dsorder").val();
       var desti = "/cb-reserves/taules/Gestor_pagaments.php?a=get_estat_pagament&b=" + order  ;
       $.post(desti, {r: 0}, function (datos) {
         var estat = parseInt(datos);
          if (estat>=0 && estat<=99 ) {
              window.location.href = "/#about";
              alert("PAGAMENT REBUT");
          }
      });

  }
  
  
  function submit_handler(e) {
    if (PAGAMENTS_PARCIALS) {
      var valid = $("#pagament").valid();
      if (!valid) {
        e.preventDefault(); // Cancel the submit
        return false;
      }
  }
          alert("<?php echo $translate['COMPRA_SEGURA'][$lang] ?>");
          button_state(false);
          //console.log("222");
          vent = window.open('', 'frame-tpv', 'width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');

          var idr =<?php echo $fila['id_reserva'] ?>;
          var TIMER_INTERVAL = 5000;
          var t = setInterval(ctimer, TIMER_INTERVAL, idr);
          
          var rand = "...";
          var coberts = $("#ncoberts").val();
          var preu = preu_unit * coberts ;
          var nom = $("#nom").val();
          if (nom=="") nom = "sense_nom"
          var order = $("#dsorder").val();
          var desti = "/cb-reserves/taules/Gestor_pagaments.php?a=afegir_pagament&b=" + order + "&c=" + idr + "&d=" + preu + "&e=" + preu_unit +  "&f=" + nom  ;
          $.post(desti, {r: rand}, function (datos) { $("#compra").submit();});
         // document.forms[0].submit();
      }
      
      function button_state(state){
       // alert(PAGAMENTS_PARCIALS);
       // alert(state);
        //if (!PAGAMENTS_PARCIALS) state = true;
        $("#boto").prop('disabled', !state);
        if(state) $("#boto").removeClass("boto_disabled");
        else $("#boto").addClass("boto_disabled");
      }
</script>

<style>
    .error{color:red;}
    
    #tar, .tar{text-align: right;}
    
    .post-main .table{
        max-width:600px;
        margin:auto;
    }

    .post-main td{
        background:#fafafa;
    }
    .post-main td:first-child{
        background:#eee;
    }
    .post-main td:first-child{
        text-align:right;
        padding-right:40px;
    }
    .post-main td:last-child{
        text-align:left;
        padding-right:40px;
        font-weight: bold;
    }

    .post-main tr:last-child td:last-child{
        background:#CEFFCE;
        font-size: 24px;
        text-align:right;
    }

    .post-main tr.preu td.Estilo2{
        background:#ccc;
        font-size: 24px;

    }

    .post-main{max-width:600px;margin:auto;}
    .form_tpv_real .ds_input{display:none}
    .post-main .btn-success{
        font-size:24px;
        float:right;
    }

    .preu td{text-align: right;}
    
    td i{font-size:0.7em;color:#888;display: block}
    .boto_disabled {
    -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
    filter: grayscale(100%);
}
</style>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($display_breadcrumb == 'yes'): ?>

      <section class="page-title-bar title-left no-subtitle" style="">
          <div class="container">
              <?php onetone_get_breadcrumb(array("before" => "<div class=''>", "after" => "</div>", "show_browse" => false, "separator" => '', 'container' => 'div')); ?>
              <hgroup class="page-title">
                  <h1>
                      <?php
                      //
                      //
                      if ($surt) {
                        echo $titol[$lang];
                      }
                      else {
                        the_title();
                      }
                      ?>
                  </h1>
              </hgroup>
              <div class="clearfix"></div>
          </div>
      </section>
    <?php endif; ?>
    <div class="post-wrap">
        <div class="<?php echo $container; ?>">
            <div class="post-inner row <?php echo $aside; ?>" style=" <?php echo $container_css; ?>">
                <div class="col-main">
                    <section class="post-main" role="main" id="content">
                        <?php while (have_posts()) : the_post(); ?>
                          <article class="post type-post" id="artic">
                              <?php if (has_post_thumbnail()): ?>
                                <div class="feature-img-box">
                                    <div class="img-box">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                </div>
                              <?php endif; ?>
                              <div class="entry-main">

                                  <div class="entry-content ">
                                      <?php the_content(); ?>

                                      <?php
                                      if ($surt && !isset($_REQUEST['testTPV']))
                                        exit();
                                      ?>

                                      <div class="alert alert-info">
                                          <?php echo $txt[40][$lang] ?>

                                      </div>

                                      <table class="table table-stripped table-condensed">
                                          <tr  class="preu">
                                              <td  colspan="2" class="Estilo2"><?php l("Reserva"); ?></td>
                                          </tr>


                                          <tr>
                                              <td   class="Estilo2">id_reserva</td>
                                              <td   class="llista"><div  class="titol2" id="reserva_id"><?php echo $fila['id_reserva'];
                                          ?> </div></td>
                                          </tr>

                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[8][$lang] ?></td>
                                              <td   class="llista"><div  class="estat"><?php echo data_llarga($fila['data'], $lang); ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">hora</td>
                                              <td   class="llista"><div  class="estat"><?php echo substr($fila['hora'], 0, 5); ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[1][$lang] ?></td>
                                              <td  class="llista"><div  ><?php echo $fila['nom']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">tel</td>
                                              <td   class="llista"><div  ><?php echo $fila['tel']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">fax</td>
                                              <td   class="llista"><div  ><?php echo $fila['fax']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">email</td>
                                              <td  class="llista"><div  ><?php echo $fila['email']; ?></div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">menú</td>
                                              <td  class="llista"><div  ><?php
///// COMANDA
                                          echo $comanda = $gestor->plats_comanda($fila['id_reserva']);
                                          ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[2][$lang] ?></td>
                                              <td   class="llista"><div  ><?php echo (int) $fila['adults']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[3][$lang]; ?></td>
                                              <td   class="llista"><div  ><?php echo (int) $fila['nens10_14']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[4][$lang]; ?></td>
                                              <td   class="llista"><div  ><?php echo (int) $fila['nens4_9']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[5][$lang]; ?></td>
                                              <td   class="llista"><div  ><?php echo (int) $fila['cotxets']; ?> </div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2"><?php echo $camps[6][$lang]; ?></td>
                                              <td  class="llista"><div  ><?php echo $fila['observacions']; ?></div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">Respuesta</td>
                                              <td  class="llista"><div  ><?php echo $fila['resposta']; ?></div></td>
                                          </tr>
                                          <tr>
                                              <td   class="Estilo2">Límit pagament</td>
                                              <td  class="llista"><div  ><?php                                      
                                              echo Gestor::cambiaf_a_normal($fila['data_limit']); ?></div></td>
                                          </tr>
                                          <tr class="preu">
                                              <td   class="Estilo2"><?php echo $camps[7][$lang]; ?></td>
                                              <td   class="llista"><div  class="estat">
                                                      <?php 
                                                      /*
                                                      $total_pagaments_parcials = 100;//$pagaments->get_total_import_pagaments($fila['id_reserva']);
                                                      $import_pendent = $fila['preu_reserva'] - $total_pagaments_parcials;
                                                      if ($total_pagaments_parcials>0) $pendent= '<span style="font-size:12px">(Pendents '.$import_pendent.'€)</span>'
                                                      */
                                                       ?>
                                                       
                                                      <div  class="Estilo5"><?php echo $fila['preu_reserva']; ?>€ <?php //echo $pendent;?></div>
                                                  </div></td>
                                          </tr>
                                          
                                          
                                      </table>

                                      <br>
                                      <br>
                                      
                                       <?php   if ( defined('PAGAMENTS_PARCIALS') && PAGAMENTS_PARCIALS == true && $pagaments->get_multipago_activat($fila['preu_reserva'])):?>

                                      <div class="alert alert-info">
                                          <?php l("INFO_MULTIPAGO") ?>

                                      </div>
                                      <div class="alert alert-warning">
                                          <?php l("INFO_MULTIPAGO2") ?>

                                      </div>
                                  <?php endif; //MULTIPAGAMENT  ?>
                                      <?php
                                      $import_pendent =$fila['preu_reserva'];
                                      if (defined('PAGAMENTS_PARCIALS') && PAGAMENTS_PARCIALS == true && $pagaments->get_multipago_activat($fila['preu_reserva'])):
                                        $total_reserva = $fila['preu_reserva'];
                                        $total_pagaments_parcials = $pagaments->get_total_import_pagaments($fila['id_reserva']);
                                        $coberts_pagats = $pagaments->get_total_coberts_pagats($fila['id_reserva']);
                                        $llista_pagaments = $pagaments->get_llistat_pagaments($fila['id_reserva']);

                                        $comensals = $fila['adults'] + $fila['nens10_14'] + $fila['nens4_9'];
                                        $pendents = $comensals - $coberts_pagats;
                                        if (!$pendents) $pendents=1;
                                        if ($pendents<0) $pendent=0;
                                        $import_pendent = $total_reserva - $total_pagaments_parcials;
                                        $import = $pendents * $preu_persona;
                                        
                                        $preu = $pendents * $preu_persona;
                                        if ($preu > $import_pendent) {
                                          $preu = $import_pendent;
                                          $pendents = ceil($preu / $preu_persona);
                                        }
                                       // echo $import." / ".$preu_persona;
                                       // $pendents=$import_pendent;
                                        $preu = number_format($preu,2);
                                        
                                        
                                        ?>

                                        <?php if ($coberts_pagats): ?>
                                          <table class="table table-stripped table-condensed">
                                              <tr  class="preu">
                                                  <td  colspan="3" class="Estilo2"><?php l("Pagaments realitzats"); ?></td>
                                              </tr>

                                              <?php 
                                              
                                              foreach ($llista_pagaments as $row): ?>
                                             
                                                <tr class="">
                                                    <td   class="Estilo2"><?php echo $row['pagaments_grups_nom_pagador']; ?></td>
                                                    <td   class="llista"><div  class="estat">
                                                            
                                                            <div  class="Estilo5 tar"><?php echo  " ( " .$row['coberts'] . " coberts) "?></div>
                                                        </div></td>
                                                        <td id="tar"><?php echo $row['pagaments_grups_import']."€ "  ?> </td>
                                                </tr>
                                              <?php endforeach; ?>
                                              <br>
                                              <br>
                                              <tr class="preu">
                                                  <td   class="Estilo2"><?php echo "Import abonat"; ?></td>
                                                  <td   class="llista"><div  class="estat">
                                                          <div  class="Estilo2"><?php echo  "($coberts_pagats coberts)"?> </div>
                                                      </div></td>
                                                      <td><?php echo " " . $total_pagaments_parcials . "€ "; ?></td>
                                              </tr>
                                          </table>
                                        <?php endif; //llista pagats  ?>
                                        <br>
                                        <br>
                                                                                <?php endif; //mostra llistat  ?>
  <?php if ($import_pendent>0 ):?>
  <?php   if (defined('PAGAMENTS_PARCIALS') && PAGAMENTS_PARCIALS == true && $pagaments->get_multipago_activat($fila['preu_reserva'])):?>
  
                                        <form id="pagament">
                                        <table class="table table-stripped table-condensed">
                                            <tr  class="preu">
                                                <td  colspan="2" class="Estilo2"><?php l("Realitzar un nou pagament") ?></td>
                                            </tr>

                                            <tr style="display:none">
                                                <td   class="Estilo2"><?php l("Indica el nom del pagador"); ?>
                                                    <i><?php l('Per facilitar-vos la gestió dels pagaments introdueix un nom que identifiqui el pagador. Per exemple: Família Puig o Josep i Maria'); ?></i>
                                                </td>
                                                <td   class="llista"><div  class="estat">
                                                        <div  class="Estilo2"><input name="nom" id="nom" type="text" placeholder="Introdueix un nom" value="Titular" required></div>
                                                    </div></td>
                                            </tr>
                                            <tr  style="display:none">
                                                <td   class="Estilo2"><?php l("Coberts que vols pagar"); ?>
                                                    <i><?php l('Pots pagar tos els coberts que desitgis. Si sou un grup d\'amics o famílies podeu repartir els coberts de la manera que més us convingui fent múltiples pagaments fins a 3 dies abans de la reserva. La reserva es serà efectiva pels coberts que s\'hagin abonat'); ?></i>

                                                </td>
                                                <td   class="llista"><div  class="estat">
                                                        <div id="coberts_parcial" class="Estilo2"><input id="ncoberts" name="ncoberts" type="number" min="1" max="<?php echo $pendents; ?>" value="<?php echo $pendents; ?>" placeholder="Coberts"> Coberts </div>
                                                    </div>
                                                    <i><?php echo $preu_persona."€ ";l(" persona"); ?></i>
                                                </td>
                                            </tr >
                                            <tr class="preu">
                                                <td   class="Estilo2"><?php l("Import a pagar"); ?></td>
                                                <td   class="llista"><div  class="estat">
                                                        <span id="preu_parcial" class="Estilo5" ><?php 
                                                        
                                                        echo number_format($preu ,2) ?></span>€
                                                    </div></td>
                                            </tr>

                                        </table>
                                            </form>
                                        <?php endif; //PAGAMENT PARCIAL  ?>
                                        <?php


                                      $id_reserva = ((int) $_GET["id"]) + 100000;
                                      $response = isset($_GET["testTPV"]) ? $_GET["testTPV"] : -1;

                                      /** */
                                    //  echo $_REQUEST["testTPV"];die();
                                      if (isset($_REQUEST["testTPV"]) && $_REQUEST["testTPV"] == 'testTPV')
                                        echo '<div id="form_test" class="form_tpv_test">TEST<br>BONA  4548812049400004  12/20   123  123456<br><div  class="form_tpv"> ' . $gestor->generaTESTTpvSHA256($id_reserva, $preu, $nom, $responaseok_callback_alter) . "</div></div>";
                                      else
                                        echo '<div id="form_tpv" class="form_tpv_real"> <div  class="form_tpv">' . $gestor->generaFormTpvSHA256($id_reserva, $preu, $nom, $responaseok_callback_alter) . "</div></div>";
                                      ?>  

                                       <?php else: //nou pagament  ?>
                                      <div class="alert alert-info">
                                          <?php l("INFO_TOT_PAGAT") ?>

                                      </div>

                                        <?php endif; //IMPORT PENDENT ?>







  <?php
  wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'onetone') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>'));
  ?>
                                  </div>

                              </div>
                          </article>
                          <div class="post-attributes">
                              <!--Comments Area-->
                              <div class="comments-area text-left">
  <?php
  // If comments are open or we have at least one comment, load up the comment template
  if (comments_open()) :
    comments_template();
  endif;
  ?>
                              </div>
                              <!--Comments End-->
                          </div>
                                <?php endwhile; // end of the loop.     ?>
                    </section>
                </div>
                        <?php if ($sidebar == 'left' || $sidebar == 'both'): ?>
                  <div class="col-aside-left">
                      <aside class="blog-side left text-left">
                          <div class="widget-area">
                  <?php get_sidebar('pageleft'); ?>
                          </div>
                      </aside>
                  </div>
                            <?php endif; ?>
<?php if ($sidebar == 'right' || $sidebar == 'both'): ?>
                  <div class="col-aside-right">
                  <?php get_sidebar('pageright'); ?>
                  </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
<?php get_footer(); ?>
