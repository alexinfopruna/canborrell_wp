<?php
/*
  Template Name: Reserves grups
 */





defined('ROOT') or define('ROOT', 'cb-reserves/taules/');
require_once (ROOT . "Gestor.php");

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true && $_SESSION['permisos'] < 200)
  header("Location:/cb-reserves/reservar/fora_de_servei.html");

//define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "bloq.txt");
define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
define('USR_FORM_WEB', 3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE
// CREA USUARI ANONIM
if (!isset($_SESSION))
  session_start();

if (!isset($_SESSION['uSer']) || !isset($_SESSION['permisos'])) {
  $usr = new Usuari(USR_FORM_WEB, "webForm", 31);
  $_SESSION['uSer'] = $usr;
  $_SESSION['permisos'] = $usr->permisos;
}

require (ROOT . "../reservar/Gestor_form.php");
$gestorf = new Gestor_form();
require_once(ROOT . INC_FILE_PATH . 'alex.inc');
require_once(ROOT . INC_FILE_PATH . "llista_dies_taules.php");
//PERSONES PARAM
$na = isset($_REQUEST['b']) ? $_REQUEST['b'] : 0;
$nj = isset($_REQUEST['c']) ? $_REQUEST['c'] : 0;
$nn = isset($_REQUEST['d']) ? $_REQUEST['d'] : 0;
$total = $na + $nj + $nn;
//RECUPERA IDIOMA
global $sitepress;
$language_uri = substr($_SERVER['REQUEST_URI'], 0, 4);


if ($language_uri == '/es/' || $language_uri == '/en/') {
  $lang = substr($_SERVER['REQUEST_URI'], 1, 2);
  $gestorf->idioma($lang);
  //echo "Location: /reservar/realitzar-reserva/?lang=".$lang;
  header("Location: /reservar/realitzar-reserva/?lang=" . $lang);
  exit();
  die();
}
else {
  $lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'ca';
  $gestorf->idioma($lang);
}


$gestorf->lng = $lang = Gestor::getLanguage();
$l = $gestorf->lng;



/* * ******************************************************************************** */
$sitepress->switch_lang($lang);
/* * ******************************************************************************** */
//RECUPERA CONIG ANTIC
//RECUPERA CONIG ANTIC
$PERSONES_GRUP = $gestorf->configVars("persones_grup");
define("PERSONES_GRUP", $PERSONES_GRUP);
$max_nens = $gestorf->configVars("max_nens");
$max_juniors = $gestorf->configVars("max_juniors");

$gestorf->netejaImpagatsTpv(); // TPV I IMPAGATS
$paga_i_senyal = $PERSONES_GRUP >= persones_paga_i_senyal;




//RECUPERA RESERVA UPDATE
if (isset($_REQUEST['rid'])) {
  $decode = base64_decode($_REQUEST['rid']);
  //print_r($decode);
  $st = explode('&', $decode);
  $_REQUEST['idr'] = $_POST['idr'] = $st[0];
  //$_POST['email']=$st[1];
  $_REQUEST['mob'] = $_POST['mob'] = $st[1];
  // $_REQUEST['lang']=$_POST['lang']=  $_GET['lang'] =$st[2];

  if (isset($_POST['idr']) && $_POST['idr'] > SEPARADOR_ID_RESERVES) { //si es reserva de grups
    $row = $gestorf->recuperaReserva($_POST['mob'], $_POST['idr']);
    if (!$row) {
      // $error_edit = TRUE;
      $message = "ERROR_LOAD_RESERVA";
      $_REQUEST['idr'] = $_POST['idr'] = null;
    }
  }
}
else {
  $row['id_reserva'] = null;
  $row['idr'] = null;
  $row['adults'] = null;
  $row['nens10_14'] = null;
  $row['nens4_9'] = null;
  $row['reserva_info'] = null;
  $row['cotxets'] = null;
  $row['comanda'] = null;
  $row['client_telefon'] = null;
  $row['client_mobil'] = null;
  $row['client_email'] = null;
  $row['client_nom'] = null;
  $row['client_cognoms'] = null;
  $row['client_id'] = null;
  $row['data'] = null;
  $row['hora'] = null;
  $row['observacions'] = null;
  $row['reserva_pastis'] = null;
  $row['reserva_info_pastis'] = null;
  //$row['']=null;

  $comanda = null;
}

$g = $gestorf;
add_action('wp_enqueue_scripts', 'reservar_enqueue_styles');
get_header();
require_once(ROOT . '../reservar/translate_' . $gestorf->lng . '.php');
$gestorf = $g;

if (!isset($_POST['idr'])) {
  $_POST['idr'] = null;
}

$EDITA_RESERVA = $_POST['idr'] ? $_POST['idr'] : NULL;
//$EDITA_RESERVA = $_POST['idr'];
//ELIMINA RESERVA 
if (isset($_POST['cancel_reserva']) && $_POST['cancel_reserva'] == "Eliminar reserva" && $_POST['idr'] > SEPARADOR_ID_RESERVES) {
  if ($gestorf->cancelReserva($_POST['mob'], $_POST['idr'])) {
    $message = __("Your reservation is now cancelled", 'canborrell');
    $_REQUEST['idr'] = $_POST['idr'] = $EDITA_RESERVA = null;
  }
  else {
    //$message=__("ERROR: No s'ha pogut cancel·lar la reserva per problemes tècnics. <a href='mailto:restaurant@can-borrell.com'>Contacta amb el restaurant</a>",'canborrell');
    $message = __("ERROR: Unfortunatelly the system has been unable to cancel you reservation due to tecnical troubles.<br> Please, contact us at:<a href='mailto:restaurant@can-borrell.com'> restaurant@can-borrell.com</a> ", 'canborrell');
    $_REQUEST['idr'] = $_POST['idr'] = null;
  }
}






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
//echo $gestorf->taulesDisponibles->es_finde_o_festiu("2019-2-21")?"S":"N";
/*
$llista = $gestorf->llegir_dies_DB("small","white");
var_dump($llista);*/

/* * *********************************************************** */
/* * *********************************************************** */
/* * *********************************************************** */
/* * *********************************************************** */
/* * *********************************************************** */

function reservar_enqueue_styles() {
  global $lang;
  //echo '<meta http-equiv="Pragma" content="no-cache" />';
  
  header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");  
 // echo "WWWddd222";exit();

  ?>


  <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700,300italic' rel='stylesheet' type='text/css'>

  <link type="text/css" href="/cb-reserves/taules/css/blitzer/jquery-ui-1.8.9.forms.css" rel="stylesheet" />	
  <link type="text/css" href="/cb-reserves/reservar/css/jquery.tooltip.css" rel="stylesheet" />	
  <link type="text/css" href="/cb-reserves/reservar/css/form_reserves_mob.css" rel="stylesheet" />		
  <link type="text/css" href="/cb-reserves/reservar/css/osx.css" rel="stylesheet" />
  <link type="text/css" href="/cb-reserves/reservar/css/glyphicons.css" rel="stylesheet" />
  <link rel="stylesheet" href="/wp-content/plugins/magee-shortcodes/assets/bootstrap/css/bootstrap.min.css"> 
  <?php echo Gestor::loadJQuery(); ?>
  <script type="text/javascript" src="/cb-reserves/taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-<?php echo $lang; ?>.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.metadata.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.timers.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.form.js"></script>
  <!--   -->

  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.browser.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/json2.js"></script>

  <script type="text/javascript" src="/cb-reserves/reservar/js/jquery.amaga.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/jquery.tooltip.js"></script>




  <style>
      @media (min-width: 768px){
          body{font-size:12px}
      }
      @media (max-width: 768px){
          .row{margin:0}
      }




      .resum-carta-iva{
          font-size:12px;
      }


      #divTooltip{
          font-size: 0.7em;
          line-height: 1.1;
      }
      .ccarta  td, tr.item-carta, tr.item-carta td{    padding: 0px 4px;}
      .fxd-header{display:none !important;position:absolute;left:-1000px;}
      h2.titol{
          background: white;
          padding: 4px;   
      }

      .anima-avis{
          position:fixed;
          top:50px;
          left:50%;
          margin-left:-300px;
          width:600px;
      }
      .anima-avis .tanca-avis{

          display:inline}
      .tanca-avis{display:none;}

      #avis-modificacions.anima-avis{
          padding:10px;
          background-color: #FFFFA1;
          border: #570600 solid 3px;

          z-index: 3000;
      }
      #avis-modificacions-overlay.anima-avis{
          display: block;
      }
      .dspnn{display:none;}
      #avis-modificacions{

          font-size: 14px;
          color:#570600;
          background-color: white;
          padding:4px;
      }

      .transition-1s{
          -webkit-transition: all 0.5s ease;
          -moz-transition: all 0.5s ease;
          -o-transition: all 0.5s ease;
          transition: all 0.5s ease;

      }

      .anima-avis .tanca-avis {
          display: block;
          margin: auto;
          text-align: center;
          margin-top: 10px;

      }

      .anima-avis .tanca-avis a {
          padding: 4px;
          background:#EEE;
          border-radius:4px;
          border:#ccc solid 1px;
          color:#444;
      }

      .anima-avis .tanca-avis a:hover {
          padding: 4px;
          background:#DDD;
          border-radius:4px;
          border:#999 solid 1px;
      }

      #compra input[type=text], .ds_input {
          display: none;
      } 

      aside .btn{
          display:block;
          margin-top:20px;
      }


      @media (min-width: 992px){
          .post-inner.left-aside   .col-main {
              left: 0;
          }
      }

      <?php
      if (isset($paga_i_senyal) && !$paga_i_senyal)
        echo ".info-paga-i-senyal{display:none}";
      ?>

      .caixa.caixa100{width:95%;}
      .fr-seccio{
          display:flex;  
          flex-wrap:wrap;
      }

      .flex{
          display:flex;  
          flex-wrap:nowrap;
      }
      .flexw{
          display:flex;  
          flex-wrap:wrap;
      }
      .error_validate, #error_validate{
          clear:both; 
      }

      #submit span{
          font-size:20px;
      }

      #calendari {margin-top:15px;}

      .putoIE{
          display:flex;justify-content:center;width:100%;
      }

      #compra button#boto{display:none}

      @media (max-width: 770px){ 
          .ui-button-text {
              padding: 5px 15px !important;
          }   
      }
      @media (max-width: 1180px){
          #calendari .ui-datepicker{  font-size: 80%;}
      }
      @media (max-width: 992px){
          #calendari .ui-datepicker{  font-size: 120%;}
      }

      @media (min-width: 992px){
          .caixa{
              margin:15px;
              width:30%;
              min-width:250px;
          }
      }

      .flex{
          display:flex;   
      }
      @media (max-width: 992px){
          .fr-seccio .col-isqui{
              flex-wrap:  wrap;
              flex-direction: row;
              justify-content:flex-start;

          }
          .col-isqui-carta{
              flex-wrap:  wrap;
          }
          .fr-seccio.fr-seccio-dia {
              flex-direction: row;
          }
          .caixa{ width:100%;}
      }



      #c1 tbody{
          font-size:12px;   
      }

  </style>                

  <script type="text/javascript" src="/cb-reserves/reservar/js/jquery.simplemodal.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/control_carta.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/form_reserves.js"></script>		
  <script type="text/javascript" src="/cb-reserves/reservar/js/popups_ajuda.js"></script>

  <script>


  <?php
  global $row;
  global $gestorf;

  print "\nvar IDR='" . $row['id_reserva'] . "';";
  print "var RDATA;";
  if (!empty($row['data']))
    print "\nRDATA='" . $gestorf->cambiaf_a_normal($row['data']) . "';";
  print "\nvar HORA='" . $row['hora'] . "';";

  if (isset($_GET['rdata']))
    print "\nRDATA='" . $_GET['rdata'] . "';";
//print "\nRDATA='2016-10-25';";
  print "\nvar HORA='" . $row['hora'] . "';";
  ?>

  </script>
  <?php
}

// FINAL reservar_enqueue_styles()
/* * ******************************************************************************************************* */

/* * ******************************************************************************************************* */
/* * ******************************************************************************************************* */
/* * ******************************************************************************************************* */
/* * ******************************************************************************************************* */
/* * ******************************************************************************************************* */
$testTPV = isset($_REQUEST['testTPV']) && $_SESSION['permisos'] > 200;
if ($testTPV) {
  echo '<div class="ui-corner-all    alert alert-danger ">******************************* tesTPV ************************************<br>4548812049400004  12/20   123  123456';
  $tpv_config_file = "TPV256_test.php";
  include(ROOT . INC_FILE_PATH . $tpv_config_file);
  echo "<br>" . $_SERVER['HTTP_HOST'];
  echo "<br>url $url";
  echo "<br>urlMerchant $urlMerchant";
  echo "</div>";
}
?>


<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($display_breadcrumb == 'yes'): ?>

      <section class="page-title-bar title-left no-subtitle loader" >
          <div class="container">
              <?php onetone_get_breadcrumb(array("before" => "<div class=''>", "after" => "</div>", "show_browse" => false, "separator" => '', 'container' => 'div')); ?>
              <hgroup class="page-title">
                  <h1>
                      <?php
                      $original_ID = icl_object_id(418, 'any', false, $lang);
                      $original_title = get_the_title($original_ID);
                      echo $original_title;
                      //the_title(); 
                      ?>
                  </h1>
              </hgroup>
              <div class="clearfix"></div>
          </div>
      </section>
    <?php endif; ?>



    <?php if ($sidebar == 'left' || $sidebar == 'both'): ?>
      <div class="col-aside-left">
          <aside class="blog-side left text-left" style="padding-top:70px;">

              <?php
              if ($EDITA_RESERVA) {

                $eliminar = l("Cancel·lar reserva", FALSE);
                echo '<form id="fdelete" name="form1" method="POST" action="/reservar/realitzar-reserva/?lang=' . $lang . '">
	<input type="hidden" name="mob" value="' . $_REQUEST['mob'] . '"/>
	<input type="hidden" name="idr" value="' . $_REQUEST['idr'] . '"/>
	<button type="submit" id="cancel_reserva" name="cancel_reserva" value="Eliminar reserva" class="btn btn-danger" style="font-size:16px;color:white"><i class="fa fa-trash " style="font-size:24px;color:white"></i> ' . $eliminar . '</button>
	</form>';
              }
              else {
                $prefix = ($lang != 'ca') ? "/$lang" : '';
                ?>


                <a href="<?php echo $prefix ?>/reservar/localitza-reserva/?a=edit" class="btn btn-success" >     <?php l('Edita una reserva existent'); ?></a>


                <a href="#" class="btn btn-warning  ecp-trigger" data-modal="modal" >     <?php l('Tens algun dubte?'); ?></a>
              <?php } ?> 

              <div class="widget-area">
                  <?php get_sidebar('pageleft'); ?>
              </div>
          </aside>
      </div>
    <?php endif; ?>



    <div class="post-wrap">
        <div class="<?php echo $container; ?>">
            <div class="post-inner row <?php echo $aside; ?>" style=" <?php echo $container_css; ?>">
                <div class="col-main">
                    <section class="post-main" role="main" id="content">
                        <?php while (have_posts()) : the_post(); ?>
                          <article class="post type-post">
                              <?php if (has_post_thumbnail()): ?>
                                <div class="feature-img-box">
                                    <div class="img-box">
                                        <?php the_post_thumbnail(); ?>
                                    </div>
                                </div>
                              <?php endif; ?>
                              <div class="entry-main">

                                  <div class="entry-content reservar">
                                      <?php
                                      //the_content();
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      ?>

                                      <div id="container">
                                          <div class="row row-offcanvas row-offcanvas-left">
                                              <div id="cos">       

                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- **s*************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->


                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ********     CONTACTE       ***********************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <!-- ***************************************************************************************   -->
                                                  <?php
                                                  if (isset($message)) {
                                                    echo '<div class="alert alert-danger"><i class="fa fa-info-circle" style="font-size:28px;color:#31708f;"></i> ' . l($message, FALSE) . '</div>';
                                                  }
                                                  ?>

                                                  <div style="clear:both"></div>
                                                  <h2 class="titol titol1">
                                                      <?php
                                                      if ($EDITA_RESERVA) {
                                                        l('Editant reserva ID');
                                                        echo $EDITA_RESERVA;


                                                        echo '<a href="info_reserves.html" id="info_reserves"><img src="/cb-reserves/reservar/css/info.png" title="' . l("Informació de reserves", false) . '" style="width:16px;height:auto;margin-left:8px"/></a>';
                                                      }
                                                      else {

                                                        l('Sol·licitud de reserva');
                                                        echo '<a href="info_reserves.html" id="info_reserves"><img src="/cb-reserves/reservar/css/info.png" title="' . l("Informació de reserves", false) . '" style="width:16px;height:auto;margin-left:8px"/></a>';
                                                      }
                                                      ?>
                                                  </h2>  

                                                  <form id="form-reserves" action="/cb-reserves/reservar/Gestor_form.php?a=submit" method="post" name="fr-reserves" accept-charset="utf-8"><!---->
                                                      <input type="hidden" name="id_reserva" value="<?php echo isset($_REQUEST['idr']) ? $_REQUEST['idr'] : ""; ?>"/>
                                                      <input type="hidden" name="reserva_info" value="<?php echo $row['reserva_info']; ?>"/>
                                                      <input type="hidden" name="<?php echo $testTPV ? "testTPV" : "noTest"; ?>" value="<?php echo $testTPV ? "testTPV" : "noTest"; ?>"/>
                                                      <div id="fr-reserves" class="fr-reserves">
                                                          <!-- *******************************  QUANTS SOU ********************************************************   -->
                                                          <!-- *******************************  QUANTS SOU ********************************************************   -->
                                                          <!-- *******************************  QUANTS SOU ********************************************************   -->


                                                          <div class="fr-seccio ui-corner-all fr-seccio-quants" style="xxxmax-width:950px;">

                                                              <h1 class="titol"><span class="number">1</span><?php l('Quants sou?'); ?>
                                                                  <a href="#" id="info-quants" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                              </h1>

                                                              <div class="col-isqui flex">


                                                                  <!-- ******  INFO  ********   -->
                                                                  <div class="caixa dere info ui-corner-all info-quants"><?php l('INFO_QUANTS_SOU'); ?>
                                                                      <input type="text" name="totalComensals" value="<?php echo $row['adults'] + $row['nens10_14'] + $row['nens4_9'] ?>" readonly="readonly"/>
                                                                      <input type="text" name="totalCotxets" value="<?php echo $row['cotxets'] ? "/ " . $row['cotxets'] : "" ?>" readonly="readonly"/>
                                                                  </div>


                                                                  <div class="col-isqui ">


                                                                      <h4  id="titol_SelectorComensals"><?php l('Adults (més de 14 anys)'); ?>:</h4>


                                                                      <!-- ******  ADULTS  ********   -->
                                                                      <div id="selectorComensals" class="fr-col-dere selector">
                                                                          <input type="hidden" id="com" name="adults" value="<?php echo $row['adults'] ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)          ?></label>	
                                                                          <?php
                                                                          for ($i = 2; $i < $PERSONES_GRUP; $i++) {
                                                                            $chek = ($i == $row['adults'] ? 'checked="checked"' : '');
                                                                            $tpv = ($i >= persones_paga_i_senyal ? "ptpv" : "");
                                                                            $title = ($i >= persones_paga_i_senyal ? "Paga i senyal necessària" : "Reserva sense paga i senyal");
                                                                            $bt = '<input type="radio" id="com' . $i . '" name="selectorComensals" value="' . $i . '" ' . $chek . '/><label for="com' . $i . '" class="' . $tpv . '" title="' . $title . '">' . $i . '</label>';

                                                                            if ($EDITA_RESERVA && $tpv) {
                                                                              $bt = "";
                                                                            }
                                                                            print $bt;
                                                                          }
                                                                          ?>
                                                                          <input type="radio" id="comGrups" name="selectorComensals" value="grups"  /><label id="labelGrups" for="comGrups" style="font-size:1.2em"><?php l('Grups'); ?></label>
                                                                      </div>


                                                                      <a class="scroll-seccio-dia" id="scroll-seccio-dia"></a>

                                                                      <!------------------- AVIS MODIFICACIONS ---------------------------->
                                                                      <div id="avis-modificacions-overlay" class="ui-widget-overlay dspnn" > </div> 
                                                                      <div id="avis-modificacions" class="transition-1s" style="" >
                                                                          <?php l('AVIS_MODIFICACIONS'); ?>
                                                                      </div> 
                                                                      <!------------------- FI AVIS MODIFICACIONS ---------------------------->




                                                                      <hr/>




                                                                      <div id="jnc" style="float:left; ">
                                                                          <!-- ******  JUNIOR  ********   -->
                                                                          <input type="hidden" id="junior" name="nens10_14" value="<?php echo $row['nens10_14'] ?>" />
                                                                          <?php /*
                                                                            <h4  id="titol_SelectorJuniors"><?php l('Juniors (de 10 a 14 anys):'); ?></h4>
                                                                            <input type="hidden" id="junior" name="nens10_14" value="<?php echo $row['nens10_14'] ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)     ?></label>
                                                                            <div id="selectorJuniors" class="col_dere">
                                                                            <?php
                                                                            for ($i = 0; $i <= $max_juniors; $i++) {
                                                                            // if (is_null($row['nens10_14'])) $row['nens10_14']=-1;
                                                                            $chek = ($i === $row['nens10_14'] ? 'checked="checked"' : '');
                                                                            $k = $i;
                                                                            if (!$i)
                                                                            $k = l("Cap", false);
                                                                            print '<input type="radio" id="junior' . $i . '" name="selectorJuniors" value="' . $i . '" ' . $chek . '/><label for="junior' . $i . '">' . $k . '</label>';
                                                                            }
                                                                            ?>
                                                                            </div>
                                                                           */ ?>
                                                                          <!-- ******  NENS  ********   -->
                                                                          <h4  id="titol_SelectorNens"><?php l('Nens (fins a 14 anys)'); ?>:</h4>
                                                                          <div id="selectorNens" class="col_dere">
                                                                              <input type="hidden" id="nens" name="nens4_9" value="<?php echo $row['nens4_9'] ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)          ?></label>
                                                                              <?php
                                                                              for ($i = 0; $i <= $max_nens; $i++) {
                                                                                //if (is_null($row['nens4_9'])) $row['nens10_14']=-1; 
                                                                                $chek = ($i === $row['nens4_9'] ? 'checked="checked"' : '');
                                                                                $k = $i;
                                                                                if (!$i)
                                                                                  $k = l("Cap", false);
                                                                                print '<input type="radio" id="nens' . $i . '" name="selectorNens" value="' . $i . '" ' . $chek . '/><label for="nens' . $i . '">' . $k . '</label>';
                                                                              }
                                                                              ?>
                                                                          </div>

                                                                          <hr/>
                                                                          <!-- ******  COTXETS  ********   -->
                                                                          <h4 id="titol_SelectorCotxets"><?php l('Cotxets de nadó'); ?>:</h4>
                                                                          <div id="selectorCotxets" class="col_dere">
                                                                              <?php
                                                                              $estat = $gestorf->decodeInfo($row['reserva_info']);

                                                                              $chek0 = ($row['cotxets'] === 0 ? 'checked="checked"' : '');
                                                                              $chek1 = ($estat['ampla'] === 0 && $row['cotxets'] == 1 ? 'checked="checked"' : '');
                                                                              $chek11 = ($estat['ampla'] == 2 ? 'checked="checked"' : '');
                                                                              $chek12 = ($estat['ampla'] == 3 ? 'checked="checked"' : '');
                                                                              ?>
                                                                              <input type="radio" id="cotxets0" name="selectorCotxets" value="0"  <?php echo $chek0 ?> /><label for="cotxets0"><br/><?php l("Cap"); ?></label>
                                                                              <input type="radio" id="cotxets1" name="selectorCotxets" value="1"  <?php echo $chek1 ?>/><label for="cotxets1">1<br/> Simple</label>
                                                                              <?php
                                                                              for ($i = 2; $i <= MAX_COTXETS; $i++)
                                                                                echo '<input type="radio" id="cotxets' . $i . '" name="selectorCotxets" value="' . $i . '"  ' . ($i == $row['cotxets'] ? 'checked="checked"' : '') . ' /><label for="cotxets' . $i . '">' . $i . '<br/> Simples</label>';
                                                                              ?>
                                                                              <input type="radio" id="cotxets2A" name="selectorCotxets" value="1"  <?php echo $chek11 ?>/><label for="cotxets2A">1<br/><?php l("Doble ample"); ?></label>
                                                                              <input type="radio" id="cotxets2L" name="selectorCotxets" value="1"  <?php echo $chek12 ?>/><label for="cotxets2L">1<br/><?php l("Doble llarg"); ?></label>

                                                                          </div>
                                                                          <input type="hidden" name="amplaCotxets" value="<?php echo $estat['ampla'] ?>" /> 
                                                                          <hr/>
                                                                          <!--  -->
                                                                          <h4 id="titol_SelectorCadiraRodes"><?php l('Cadira de rodes'); ?>:</h4>
                                                                          <div id="selectorCadiraRodes" class="col_dere">
                                                                              <?php
                                                                              $estat = $gestorf->decodeInfo($row['reserva_info']);
                                                                              $chek0 = ($estat['cadiraRodes'] == 0 ? '' : 'checked="checked"');
                                                                              $chek1 = ($estat['accesible'] == 0 ? '' : 'checked="checked"');
                                                                              ?>
                                                                              <input type="checkbox" id="accesible" name="selectorAccesible" value="on"  <?php echo $chek1 ?> /><label for="accesible"><?php l("Algú amb movilitat reduïda"); ?></label>
                                                                              <input type="checkbox" id="cadira0" name="selectorCadiraRodes" value="on"  <?php echo $chek0 ?> /><label for="cadira0"><?php l("Portem una cadira de rodes"); ?></label>
                                                                          </div>
                                                                          
                                                                          <br>
                                                                          <br>
                                                                          <div class="ui-corner-all caixa caixa100 dere hores info_hora">
                                                                              <?php l("gossos"); ?>
                                                                          </div>

                                                                      </div>	
                                                                  </div>	
                                                              </div>	


                                                              <div style="clear:both"></div>

                                                          </div>		

                                                          <!-- *******************************  QUIN DIA ********************************************************   -->
                                                          <!-- *******************************  QUIN DIA ********************************************************   -->
                                                          <!-- *******************************  QUIN DIA ********************************************************   -->

                                                          <div class="fr-seccio ui-corner-all fr-seccio-dia"> 
                                                              <!-- ******  INFO  ********   -->
                                                              <h1 class="titol"><span class="number">2</span><?php l("Quin dia voleu venir?") ?>
                                                                  <a href="#" id="info_dia" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                              </h1>
                                                              <div class="col-isqui flex ">
                                                                  <div class="caixa dere ui-corner-all info_dia">
                                                                      <?php l('INFO_DATA'); ?>	
                                                                      <input type="hidden" id="valida_calendari" name="selectorData" value="<?php echo $row['data']; ?>"/>

                                                                  </div>


                                                                  <div class="putoIE " style="">
                                                                      <!-- ******  CALENDARI  ********   -->
                                                                      <div id="data" style="float:left">
                                                                          <?php if ($EDITA_RESERVA): ?>

                                                                            <script>
                                                                              var BLOQ_DATA = '<?php echo $gestorf->cambiaf_a_normal($row['data']); ?>';
                                                                            </script>
                                                                          <?php endif ?>
                                                                          <div id="calendari" class=" ui-corner-all fr-seccio-dia"></div>
                                                                      </div>
                                                                      <div style="clear:both"></div>

                                                                  </div>		
                                                              </div>		
                                                          </div>		

                                                          <!-- *******************************  QUINA HORA ********************************************************   -->
                                                          <!-- *******************************  QUINA HORA ********************************************************   -->
                                                          <!-- *******************************  QUINA HORA ********************************************************   -->
                                                          <a id="scroll-seccio-hora"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-hora" > 
                                                              <h1 class="titol"><span class="number">3</span><?php l('A quina hora?'); ?>
                                                                  <a href="#" id="info_hora" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                              </h1>
                                                              <div class="col-isqui flexw">

                                                                  <!-- ******  INFO  ********   -->
                                                                  <div class="ui-corner-all caixa caixa100 dere hores info_hora">
                                                                      <?php l('INFO_HORES'); ?>	
                                                                  </div>
                                                                  <div>
                                                                      <!-- ******  DINAR  ********   -->
                                                                      <h4><?php l('Dinar'); ?></h4>
                                                                      <div id="selectorHora" class="col_dere">
                                                                          <img src="/cb-reserves/reservar/css/loading.gif"/>
                                                                      </div>
                                                                      <!-- ******  SOPAR  ********   -->
                                                                      <div id="tira-sopars">
                                                                          <h4><?php l('Sopar'); ?></h4>
                                                                          <div id="selectorHoraSopar" class="col_dere" >
                                                                              <img src="/cb-reserves/reservar/css/loading.gif"/>
                                                                          </div>
                                                                      </div></b></b></b>

                                                                      <input type="hidden" name="taulaT1" value="">
                                                                      <input type="hidden" name="taulaT2" value="">
                                                                      <input type="hidden" name="taulaT3" value="">
                                                                  </div>	
                                                              </div>	
                                                          </div>	


                                                          <!-- *******************************  CARTA  *********************************   -->
                                                          <!-- *******************************  CARTA  *********************************   -->
                                                          <!-- *******************************  CARTA  *********************************   -->
                                                          <a id="scroll-seccio-carta"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-carta"> 
                                                              <!-- ******  INFO  ********   -->

                                                              <h1 class="titol"><span class="number">4</span><?php l('Vols triar els plats?'); ?> <span class="nota"><?php l('(opcional)'); ?></span>
                                                                  <a href="#" id="info_carta" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                              </h1>
                                                              <div class="col-isqui-carta " style="display:flex;">








                                                                  <div class="ui-corner-all info caixa" >
                                                                      <?php l('INFO_CARTA'); ?>
                                                                  </div>
                                                                  <div class="col-isqui " >    


                                                                      <div id="carta" class="col_derexx">
                                                                          <input id="te-comanda" name="te_comanda" type="text" value="" style="display:none"> 
                                                                          <!-- ******  COMANDA  ********   -->
                                                                          <div class=" ui-corner-all" >

                                                                              <input type="checkbox" id="RESERVA_PASTIS" name="RESERVA_PASTIS" value="on" <?php echo $row['reserva_pastis'] ? 'checked="checked"' : "" ?>/>
                                                                              <label class="" for="RESERVA_PASTIS" style="display:initial"><?php l("RESERVA_PASTIS") ?></label>
                                                                              <?php
                                                                              $pastis = $row['reserva_pastis'];
                                                                              $pastis_info = $row['reserva_info_pastis'];
                                                                              ?>
                                                                              <label for="INFO_PASTIS" class="pastis_toggle" style="margin-left:25px;">
                                                                                  <?php l("INFO_PASTIS") ?>
                                                                              </label>
                                                                              <textarea id="INFO_PASTIS" name="INFO_PASTIS" style="margin-left:25px;" class="pastis_toggle"><?php echo $pastis_info ?></textarea>
                                                                              <table id="caixa-carta" class="col_dere">
                                                                                  <tr>
                                                                                      <td class="mesX"></td>
                                                                                      <td class="menysX"></td>
                                                                                      <td class="Xborra"></td>
                                                                                      <td class="carta-plat">
                                                                                          <h3><?php //l("SELECCIÓ")            ?></h3>
                                                                                      </td>
                                                                                      <td></td>
                                                                                  </tr>
                                                                                  <tr>
                                                                                      <td class="mesX">							
                                                                                          <?php $comanda ?></td>
                                                                                      <td class="menysX"></td><td class="Xborra"></td>
                                                                                      <td class="carta-plat"><h3>	</h3></td>
                                                                                      <td></td>
                                                                                  </tr>
                                                                              </table>
                                                                              <!-- ******  BUTO CARTA  ********   -->
                                                                              <div class="ui-corner-all info info-comanda info_carta" style="float:left;">
                                                                                  <?php l('INFO_COMANDA'); ?>
                                                                              </div>


                                                                          </div>


                                                                          <!-- ******  BUTO CARTA  ********   -->

                                                                      </div>

                                                                  </div>
                                                              </div>

                                                              <div>
                                                                  <a href="#"  id="bt-carta" name="bt-carta" class="bt" ><?php l('Carta'); ?></a>
                                                                  <a href="#"  id="bt-menu" name="bt-menu" class="bt"><?php l('Menús'); ?></a>
                                                                  <a href="#" id="bt-no-carta" name="bt-no-carta" class="bt" ><?php l('Continuar'); ?></a>
                                                                  <div style="clear:both"></div>
                                                              </div>
                                                          </div>	


                                                          <!-- *******************************  CLIENT ********************************************************   -->
                                                          <!-- *******************************  CLIENT ********************************************************   -->
                                                          <!-- *******************************  CLIENT ********************************************************   -->
                                                          <a id="scroll-seccio-client"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-client"> 

                                                              <div class="col-isqui " >
                                                                  <h1 class="titol"><span class="number">5</span><?php l('Donan´s algunes dades de contacte'); ?>

                                                                  </h1>
                                                                  <table id="dades-client" class="col_dere">
                                                                      <?php
                                                                      if ($_SESSION['permisos'] > 200) {
                                                                        $row['client_mobil'] = "99921212";
                                                                      }
                                                                      ?>
                                                                      <tr><td class="label" >* <em style="font-size:0.9em;"><?php l('Camps obligatoris'); ?></em>
                                                                              <div><label class="label" for="client_mobil"><?php l('Telèfon mòbil'); ?>*</label><input type="text" name="client_mobil" value="<?php echo $row['client_mobil'] ?>"/></div>
                                                                              <div><label class="label" for="client_telefon"><?php l('Ens vols deixar una altre telèfon?'); ?></label><input type="text" name="client_telefon" value="<?php echo $row['client_telefon'] ?>"/></div>
                                                                              <div><label class="label" for="client_email">Email*</label><input type="email" name="client_email" value="<?php echo $row['client_email'] ?>"/></div>
                                                                              <div><label class="label" for="client_nom"><?php l('Nom'); ?>*</label><input type="text" name="client_nom" value="<?php echo $row['client_nom'] ?>"/></div>
                                                                              <div><label class="label" for="client_cognoms"><?php l('Cognoms'); ?>*</label><input type="text" name="client_cognoms" value="<?php echo $row['client_cognoms'] ?>"/></div>
                                                                              <div><label class="label" for="client_id"><?php //l('Client_id');            ?></label><input type="hidden" name="client_id" value="<?php echo $row['client_id'] ?>"/></div>

                                                                              <input name="observacions" value="" type="hidden" />

                                                                              <!--
                                                                              <div class="ui-corner-all info-legal info-observacions  caixa">
                                                                              <?php l('NO_COBERTS_OBSERVACIONS'); ?>
                                                                              </div>
    
    
                                                                              <div><label class="label" for=""><?php l('Observacions'); ?>
                                                                                      <a href="#" id="info-observacions" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                                                  </label><textarea type="text" name="observacions"><?php echo $row['observacions'] ?></textarea>
                                                                              </div>
                                                                              -->
                                                                          </td></tr>
                                                                      <tr><td>




                                                                          </td></tr>
                                                                  </table>
                                                                  <div style="clear:both"></div>
                                                                  <div class="ui-corner-all info-legal info-legal-dades caixa caixa100">
                                                                      <?php
                                                                      l('LLEI');
                                                                      $chek = ($gestorf->flagBit($row['reserva_info'], 7) ? 'checked="checked"' : '');
                                                                      ?>
                                                                      <br/>

                                                                      <input type="checkbox" id="esborra_dades" name="esborra_dades" value="on" <?php print $chek ?>/><label for="esborra_dades"><?php l("ESBORRA_DADES") ?></label>

                                                                  </div>

                                                                  <div style="clear:both"></div>
                                                              </div>	
                                                          </div>	

                                                          <!-- *******************************  SUBMIT ********************************************************   -->
                                                          <!-- *******************************  SUBMIT ********************************************************   -->
                                                          <!-- *******************************  SUBMIT ********************************************************   -->
                                                          <a id="scroll-seccio-submit"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-submit"> 

                                                              <div class="col-isqui " >
                                                                  <h1 class="titol"><span class="number">6</span><?php l('Envia la sol·licitud'); ?></h1>

                                                                  <div class="ui-corner-all caixa caixa100 resum">
                                                                      <b><?php l('Resum reserva'); ?>:</b><br/><br/>
                                                                      <?php l('Data'); ?>: <b id="resum-data">-</b> | <?php l('Hora'); ?>: <b id="resum-hora">-</b><br/>
                                                                      <?php l('Adults'); ?>: <b id="resum-adults">-</b> | <?php l('Nens'); ?>: <b id="resum-nens">-</b> | <?php l('Cotxets'); ?>: <b id="resum-cotxets">-</b><br/>
                                                                      <?php l('Comanda'); ?>: <b id="resum-comanda"><?php l('Sense'); ?> </b> <?php l('plats'); ?> (<b id="resum-preu"></b> €)
                                                                  </div>

                                                                  <div class="flex"></div>
                                                                  <div class="ui-corner-all info-submit caixaXX dere alert alert-danger ">
                                                                      <?php l('INFO_NO_CONFIRMADA'); ?>:

                                                                  </div>
                                                                  <?php $t = (isset($_POST['idr']) && $_POST['idr'] > 5000) ? 'Modificar reserva' : 'Sol·licitar reserva'; ?>
                                                                  <button id="submit"><?php l($t); ?></button>


                                                                  <div id="error_validate" class="ui-helper-hidden"><?php l("Hi ha errors al formulari. Revisa les dades, si us plau"); ?></div>
                                                              </div>
                                                          </div>
                                                      </div>

                                                  </form>	


                                                  <div id="td-form-tpv">
                                                      <?php
                                                      if (FALSE && isset($_REQUEST["testTPV"]) && $_REQUEST["testTPV"] = 'testTPV') {
                                                        echo "<style>"
                                                        . "#compra input[type=text], .ds_input{display:block;}"
                                                        . "</style>";
                                                        echo $gestorf->generaFormTpvSHA256(43748, $gestorf->configVars("import_paga_i_senyal"), "TEST_TPV");
                                                      }
                                                      ?> 

                                                  </div>                                                  
                                                  <!-- ******************* CARTA *********************** -->
                                                  <!-- ******************* CARTA *********************** -->
                                                  <!-- ******************* CARTA *********************** -->
                                                  <div id="fr-cartaw-popup" title="<?php l("La nostra carta") ?>" class="carta-menu" style="height:300px">
                                                      <div id="fr-carta-tabs" >
                                                          <?php echo $gestorf->recuperaCarta($row['id_reserva']) ?>
                                                      </div>	
                                                  </div>	
                                                  <!-- ******************* CARTA-MENU *********************** -->
                                                  <!-- ******************* CARTA-MENU *********************** -->
                                                  <!-- ******************* CARTA-MENU *********************** -->
                                                  <div id="fr-menu-popup" title="<?php l("Els nostres menús") ?>" class="carta-menu">

                                                      <div id="fr-menu-tabs" >
                                                          <?php echo $gestorf->recuperaCarta($row['id_reserva'], true) ?>
                                                      </div>	
                                                  </div>	

                                                  <!-- ******************* POPUPS GRUPS *********************** -->
                                                  <!-- ******************* POPUPS GRUPS *********************** -->
                                                  <!-- ******************* POPUPS GRUPS *********************** -->
                                                  <div id="popupGrups" title="<?php l("Reserva per grups") ?>">
                                                      <?php l('ALERTA_GRUPS'); ?>

                                                  </div>




                                                  <!-- ******************* POPUPS INFO *********************** -->
                                                  <!-- ******************* POPUPS INFO *********************** -->
                                                  <!-- ******************* POPUPS INFO *********************** -->
                                                  <div id="popup" title="<?php l("Connexió amb el sistema de reserves") ?>"><img src="/cb-reserves/reservar/css/loading.gif"/></div>
                                                  <!--
                                                  <div id="helpxx" title="<?php l("Necessites ajuda?") ?>"><?php l('ALERTA_INFO_INICIAL'); ?>
                                                  </div>
                                                  -->
                                                  <div id="osx-modal-content">
                                                      <div id="osx-modal-title"><?php l("Necessites ajuda?") ?></div>
                                                      <div class="close"><a href="#" class="simplemodal-close">x</a></div>
                                                      <div id="osx-modal-data">

                                                          <?php ?>


                                                          <div id="pp-content"><?php l('ALERTA_INFO_INICIAL'); ?></div>
                                                          <p><button class="simplemodal-close"><?php l("Tanca") ?></button></p>
                                                      </div>
                                                  </div>                                                    




                                                  <div id="popupInfo" class="ui-helper-hidden">
                                                      <?php l('ALERTA_INFO'); ?>
                                                  </div>

                                                  <div id="popupInfoUpdate" class="ui-helper-hidden">
                                                      <?php l('ALERTA_INFO_UPDATE'); ?>
                                                  </div>

                                                  <div id="reserves_info" class="ui-helper-hidden">
                                                      <?php include(ROOT . "/../reservar/reservesInfo_" . substr($lang, 0, 2) . ".html"); ?>
                                                  </div>                                                  

                                                  <?php
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  /*                                                   * ********************************************************************************** */
                                                  ?>
                                              </div>


                                          </div> <!-- row -->
                                      </div> <!-- container -->

                                      <?php
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      /*                                       * ******************************************************************* */
                                      ?>
                                      <?php
                                      wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', 'onetone') . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>'));
                                      ?>
                                  </div>

                              </div>
                          </article>

                        <?php endwhile; // end of the loop.      ?>
                    </section>
                </div>


                <?php if ($sidebar == 'right' || $sidebar == 'both'): ?>
                  <div class="col-aside-right">
                      <?php get_sidebar('pageright'); ?>
                  </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
<!--
  
                                                       <div id="unpopup"> EEEEEEEEEEEEEEE</div>
                                                  <script>
                                                  $("#unpopup").dialog({
                                                    autoOpen:false
                                                  });
                                                  $("body").on("click",function(){ $("#unpopup").dialog("open"); });
                                                  </script>
  
-->

<style>
    .reservation-progress{
          max-width:500px;
        top:-20px;
        left:50%;
        margin-left: -250px;
        position:fixed;
    /*    margin: auto;*/
         transform: translate(-50%, -50%);
  transform: scale(0.7); /* Equal to scaleX(0.7) scaleY(0.7) */
  background-color:rgba(200, 200, 200, 0.3);
  
  
 
    }
    .reservation-progress .glyphicon{
     color:white;   
    }
    .reservation-progress .number{
        background-color: #ffa500;
    }
        .reservation-progress .no-tpv{display:none}
    .reservation-progress .no-tpv .number{
        background-color: #ddd;
        border-color: #ddd;
    }
    .reservation-progress h1{
        float:left;
        clear:initial;
        
    }
    
    
    
    .reservation-progress-box{
        position: absolute;
        top:32px;
        height:12px;
        width:  90%;
        background-color: #aaa;
        border-radius: 4px;
        z-index:-10;
    }

    .reservation-progress-bar{
        /*//top:103px;*/
        height:12px;
        width:0%;
        background-color: #8de971;
        -webkit-transition: width 2s, background-color 1000ms linear;
        transition: width 2s, background-color 1000ms linear;
        position: relative;
        border-radius: 4px;
        z-index:-10;
    }
    
     .reservation-progress-bar{    animation: width 1.5s ease;}
     #progress-pas-7 .number.no-confirmada{background-color:darkred;}

    /*  .reservation-progress pendent{background-color: #4cae4c; }*/
    .reservation-progress .fet .number{background-color: #8de971; border-color:  #8de971}
</style>
<div >
    <div class="reservation-progress">
        <div class="reservation-progress-box" style="width:90%">
            <div class="reservation-progress-bar" style="width: 0%;"></div>
        </div>
        <h1 id="progress-pas-1" class="titol"><span class="number " title="Quants Sou"><i class="glyphicon glyphicon-user"></i></span></h1>
        <h1 id="progress-pas-2" class="titol"><span class="number " title="Quin dia"><i class="glyphicon glyphicon-calendar"></i></span></h1>
        <h1 id="progress-pas-3" class="titol"><span class="number " title="Quina hora"><i class="glyphicon glyphicon-time"></i></span></h1>
        <h1 id="progress-pas-4" class="titol"><span class="number " title="Vols Carta o Menú"><i class="glyphicon glyphicon-cutlery"></i></span></h1>
        <h1 id="progress-pas-5" class="titol"><span class="number " title="Dades personals"><i class="glyphicon glyphicon-envelope"></i></span></h1>
        <h1 id="progress-pas-6" class="titol"><span class="number " title="Sol·icitud/Pagament"><i class="glyphicon glyphicon-euro"></i></span></h1>
        <h1 id="progress-pas-7" class="titol"><span class="number no-confirmada" title="Reserva NO CONFIRMADA"><i class="glyphicon glyphicon-transfer"></i></i></span></h1>
    </div>
</div>

<?php get_footer(); ?>