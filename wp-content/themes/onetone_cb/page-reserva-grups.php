<?php
/*
  Template Name: Reserves grups
 */
defined('ROOT') or define('ROOT', 'cb-reserves/taules/');
require_once (ROOT . "Gestor.php");

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true && $_SESSION['permisos'] < 200)
  header("Location:/cb-reserves/reservar/fora_de_servei.html");

//define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "bloq.txt");
define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra_grups.txt");
//define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
define('USR_FORM_WEB', 3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE
// CREA USUARI ANONIM
if (!isset($_SESSION))
  session_start();
$usr = new Usuari(USR_FORM_WEB, "webForm", 1);

if (!isset($_SESSION['uSer']))  $_SESSION['uSer'] = $usr;



require (ROOT . "../reservar/Gestor_form.php");
$gestor = new Gestor_form();
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
  $gestor->idioma($lang);
  //echo "Location: /reservar/realitzar-reserva/?lang=".$lang;
  header("Location: /reservar/realitzar-reserva/?lang=" . $lang);
  exit();
  die();
}
else {
  $lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'ca';
  $gestor->idioma($lang);
}


$gestor->lng = $lang = Gestor::getLanguage();
$l = $gestor->lng;



/* * ******************************************************************************** */
$sitepress->switch_lang($lang);
/* * ******************************************************************************** */
//RECUPERA CONIG ANTIC
$PERSONES_GRUP = $gestor->configVars("persones_grup");
define("PERSONES_GRUP", $PERSONES_GRUP);
$max_nens_grup = $gestor->configVars("max_nens_grup");
$max_juniors_grup = $gestor->configVars("max_juniors_grup");


/*
 * Reset variables
 */
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

if($_SESSION['uSer']->permisos==255){
  $row['client_mobil']="999212121";
  $row['client_email']="alexbasurilla@gmail.com";
  $row['client_nom'] = "Àlex";
  $row['client_cognoms'] = "Garcia";
}



$g = $gestor;
add_action('wp_enqueue_scripts', 'reservar_enqueue_styles');
get_header();
$gestor = $g;

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


require(ROOT . '../reservar/translate_grups_' . $gestor->lng . '.php');

/* * *********************************************************** */
/* * *********************************************************** */
/* * *********************************************************** */
/* * *********************************************************** */
/* * *********************************************************** */

function reservar_enqueue_styles() {
  global $lang, $gestor;
  ?>
  <link type="text/css" href="/cb-reserves/taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
  <link type="text/css" href="/cb-reserves/reservar/css/form_reserves_grups.css" rel="stylesheet" />	
  <link type="text/css" href="/cb-reserves/reservar/css/form_reserves_grups_mob.css" rel="stylesheet" />	
  <link type="text/css" href="/cb-reserves/reservar/css/jquery.tooltip.css" rel="stylesheet" />	
  <link type="text/css" href="/cb-reserves/reservar/css/osx.css" rel="stylesheet" />
  <link type="text/css" href="/cb-reserves/reservar/css/glyphicons.css" rel="stylesheet" />
  <?php echo Gestor::loadJQuery(); ?>

  <script type="text/javascript" src="/cb-reserves/taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-<?php echo $lang; ?>.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.metadata.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.validate.min.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.timers.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.form.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.scrollTo.min.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/json2.js"></script>
  <!-- ANULAT dynmenu.js -->
  <script type="text/javascript" src="/cb-reserves/reservar/js/jquery.amaga.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/jquery.tooltip.js"></script>
  <script type="text/javascript" src="/cb-reserves/taules/js/jquery.browser.js"></script>

  <script type="text/javascript">
    var PERSONES_GRUP =<?php
  global $PERSONES_GRUP;
  echo $PERSONES_GRUP;
  ?>;
    var lang = "<?php
  global $lang;
  echo $lang;
  ?>";

  <?php
//TRANSLATES

  $llista_negra = llegir_dies(LLISTA_DIES_NEGRA);
  $llista_nits_negra = llegir_dies(LLISTA_NITS_NEGRA);
  $llista_blanca = llegir_dies(LLISTA_DIES_BLANCA);

  
  
  echo "/* >>> LLISTA_NEGRA = ".LLISTA_DIES_NEGRA." */ \n\n";
  /*
  print crea_llista_js($llista_negra, "LLISTA_NEGRA");
  print "\n\n";
  print crea_llista_js($llista_nits_negra, "LLISTA_NITS_NEGRA");
  print "\n\n";
  print crea_llista_js($llista_blanca, "LLISTA_BLANCA");
  */
  // DATABASE
  print $gestor->crea_llista_js_DB("group", "black","LLISTA_NEGRA");
  print "\n\n";
  print $gestor->crea_llista_js_DB("night", "black","LLISTA_NITS_NEGRA");
  print "\n\n";
  print $gestor->crea_llista_js_DB("group", "white","LLISTA_BLANCA");
  ?>
  </script>

  <script type="text/javascript" src="/cb-reserves/reservar/js/jquery.simplemodal.js"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/control_carta.js?<?php echo time(); ?>"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/form_reserves_grups.js?<?php echo time(); ?>"></script>
  <script type="text/javascript" src="/cb-reserves/reservar/js/popups_ajuda.js<?php //echo '?'.time();       ?>"></script>		

  <style>

      #divTooltip{
          font-size: 0.7em;
          line-height: 1.1;
      }
      
      .resum-carta-iva{
          font-size:12px;
      }

      #carta{width:100%}
      .ccarta td{    padding: 0px 4px;}
      .ccarta  td, tr.item-carta, tr.item-carta td{    padding: 0px 4px;}
      #data{width:100%}
      .fr-seccio-hora .ui-button .ui-button-text{
          padding: .4em .9em;
      }


      #calendari{
          display: flex;
          justify-content: center;
      }

      .fr-seccio .col .caixa{
          margin:0 10px ;
      }     
      .fr-seccio .col  .caixa30{
          width:30%;
      }     

      .flex{
          display:flex;  
          flex-wrap:nowrap;
      }
      .flexw, .fr-seccio{
          display:flex;  
          flex-wrap:wrap;
      }          

      /*.titol{width: 100%;}*/
      @media (max-width: 770px){ 
          .ui-button-text {
              padding: 5px 15px !important;
          }   
      }
      @media (max-width: 992px){ 
          .flex, .flexw{
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
          .fr-seccio .col .caixa{ width:100%;}

          #calendari {
              margin-top: 20px;
          }
      }


      .fxd-header{display:none !important;position:absolute;left:-1000px;}
      h2.titol{
          background: white;
          padding: 4px;   
      }



      #c1 tbody{
          font-size:12px;   
      }

  </style>
  <?php
}

// enqueue styles

/*
  if (isset($_POST['incidencia'])) {
  if (!$gestor->contactar_grups($_POST))
  l("ERROR_CONTACTAR");
  else
  l("CONTACTAR_OK");

  }
  else {
  include(ROOT."../reservar/form_contactar.php");
  }
 * 
 */
?>



<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if ($display_breadcrumb == 'yes'): ?>

      <section class="page-title-bar title-left no-subtitle loader">
          <div class="container"  >
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
    <div class="post-wrap">
        <div class="<?php echo $container; ?>">
            <div class="post-inner row <?php echo $aside; ?>" style=" <?php echo $container_css; ?>">
                <div class="col-main">
                    <section class="post-main" role="main" id="content">
                        <?php while (have_posts()) : the_post(); ?>
                          <article class="post type-post" >
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
                                      the_content();
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

                                                  <div style="clear:both"></div>
                                                  <form id="form-reserves" action="/cb-reserves/editar/reserves_grups.php" method="post" name="fr-reserves" accept-charset="UTF-8" ><!---->
                                                      <div id="fr-reserves" class="fr-reserves">
                                                          <!-- *******************************  QUANTS SOU ********************************************************   -->
                                                          <!-- *******************************  QUANTS SOU ********************************************************   -->
                                                          <!-- *******************************  QUANTS SOU ********************************************************   -->
                                              <!-- <a href="#" class="btn btn-warning  ecp-trigger" data-modal="modal" style="float:right;margin-right:25px;margin-bottom:25px">     <?php l('Tens algun dubte?'); ?></a>
                                                          -->
                                                          <h2 CLASS="titol"><?php l("Sol·licitud de reserva per a GRUPS"); ?><a href="info_reserves.html" id="info_reserves"><img src="/cb-reserves/reservar/css/info.png" title="<?php l("Informació de reserves"); ?>" style="width:16px;height:auto;margin-left:8px"/></a></h2>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-quants"> 
                                                              <h1 class="titol"><span class="number">1</span><?php l('Quants sou?'); ?>
                                                                  <a href="#" id="info-quants" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                              </h1>

                                                              <div class="col flex">
                                                                  <!-- ******  INFO  ********   -->
                                                                  <div class="caixa caixa30 dere ui-corner-all info-quants" ><?php l('INFO_QUANTS_SOU_GRUPS'); ?>
                                                                      <input id="totalComensals" type="text" name="totalComensals" value="<?php echo $total ?>" readonly="readonly" class="coberts"/>
                                                                      <!--Tingue's present que si vols modificar aquest nombre més endavant no podem garantir la disponibilitat de taula.<br/><br/>-->
                                                                  </div>


                                                                  <div class="col">
                                                                      <h4><?php l('Adults (més de 14 anys)'); ?>:</h4>
                                                                      <?php l('ADULTS_TECLAT'); ?>

                                                                      <!-- ******  ADULTS  ********   -->
                                                                      <div id="selectorComensals" class="fr-col-dere">
                                                                          <input type="text" id="com" name="adults" value="<?php echo $na ? $na : '' ?>"  style="background-color:white;width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)     ?></label>	
                                                                          &lArr;

                                                                          <input type="radio" id="comGrups" name="selectorComensals" value="grups"  /><label for="comGrups" ><?php l('<=' . ($PERSONES_GRUP - 1)); ?></label>
                                                                          <?php
                                                                          for ($i = $PERSONES_GRUP; $i < $PERSONES_GRUP + 15; $i++) {
                                                                            $checked = ($i == $na ? ' checked="checked' : '');
                                                                            print '<input type="radio" id="com' . $i . '" name="selectorComensals" value="' . $i . '" ' . $checked . ' class="adults "/><label for="com' . $i . '">' . $i . '</label>';
                                                                          }
                                                                          ?>

                                                                      </div>

                                                                      <div>

                                                                          <div id="jnc" style="float:left">

                                                                              <!-- ******  JUNIOR  ********   -->
                                                                              <h4  id="titol_SelectorJuniors"><?php l('Juniors (de 10 a 14 anys):'); ?></h4>
                                                                              <div id="selectorJuniors" class="col_dere">
                                                                                  <input type="text" id="junior" name="nens10_14" value="<?php echo $nj ? $nj : '' ?>"  style="background-color:white;width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)     ?></label>
                                                                                  &lArr;

                                                                                  <?php
                                                                                  for ($i = 0; $i <= $max_juniors_grup; $i++) {
                                                                                    $k = $i;
                                                                                    if (!$i)
                                                                                      $k = l("Cap", false);
                                                                                    $checked = ($i == $nj ? ' checked="checked' : '');
                                                                                    print '<input type="radio" id="junior' . $i . '" name="selectorJuniors" value="' . $i . '" ' . $checked . '  ' . ($i ? '' : 'NOOchecked="checked"') . ' class="junior"/><label for="junior' . $i . '" >' . $k . '</label>';
                                                                                  }
                                                                                  ?>
                                                                              </div>
                                                                              <!-- ******  NENS  ********   -->
                                                                              <h4 id="titol_SelectorNens"><?php l('Nens (de 4 a 9 anys)'); ?>:</h4>
                                                                              <div id="selectorNens" class="col_dere">
                                                                                  <input type="text" id="nens" name="nens4_9" value="<?php echo $nn ? $nn : '' ?>"  style="background-color:white;width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)   ?></label>
                                                                                  &lArr;
                                                                                  <?php
                                                                                  for ($i = 0; $i <= $max_nens_grup; $i++) {
                                                                                    $k = $i;
                                                                                    if (!$i)
                                                                                      $k = l("Cap", false);
                                                                                    $checked = ($i == $nn ? ' checked="checked' : '');
                                                                                    print '<input type="radio" id="nens' . $i . '" name="selectorNens" value="' . $i . '" ' . $checked . ' ' . ($i ? '' : 'NOOOchecked="checked"') . ' class="nens"/><label for="nens' . $i . '" >' . $k . '</label>';
                                                                                  }
                                                                                  ?>
                                                                              </div>

                                                                              <!-- ******  COTXETS  ********   -->
                                                                              <h4  id="titol_SelectorCotxets"><?php l('Cotxets de nadó'); ?>:</h4>
                                                                              <div id="selectorCotxets" class="col_dere">
                                                                                  <input type="radio" id="cotxets0" name="selectorCotxets" value="0"   /><label for="cotxets0"><?php l("Cap"); ?></label>
                                                                                  <input type="radio" id="cotxets1" name="selectorCotxets" value="1"  /><label for="cotxets1">1 simple</label>
                                                                                  <input type="radio" id="cotxets2A" name="selectorCotxets" value="1"  /><label for="cotxets2A"><?php l("Doble ample"); ?></label>
                                                                                  <input type="radio" id="cotxets2L" name="selectorCotxets" value="1"  /><label for="cotxets2L"><?php l("Doble llarg"); ?></label>
                                                                              </div>

                                                                              <!-- ******  CADIRA RODES  ********   -->
                                                                              <h4  id="titol_selectorCadiraRodes"><?php l('Cadira de rodes'); ?>:</h4>
                                                                              <div id="selectorCadiraRodes" class="col_dere">
                                                                                  <?php
                                                                                  $estat = $gestor->decodeInfo($row['reserva_info']);
                                                                                  $chek0 = ($estat['cadiraRodes'] == 0 ? '' : 'checked="checked"');
                                                                                  $chek1 = ($estat['accesible'] == 0 ? '' : 'checked="checked"');
                                                                                  ?>
                                                                                  <input type="checkbox" id="accesible" name="selectorAccesible" value="on"  <?php echo $chek1 ?> /><label for="accesible"><?php l("Algú amb movilitat reduïda"); ?></label>
                                                                                  <input type="checkbox" id="cadira0" name="selectorCadiraRodes" value="on"  <?php echo $chek0 ?> /><label for="cadira0"><?php l("Portem una cadira de rodes"); ?></label>
                                                                              </div>

                                                                              <input type="hidden" name="amplaCotxets" value="0" /> 
                                                                          </div>
                                                                          <div style="clear:both"></div>
                                                                      </div>		
                                                                  </div>		
                                                              </div>		
                                                          </div>		

                                                          <!-- *******************************  QUIN DIA ********************************************************   -->
                                                          <!-- *******************************  QUIN DIA ********************************************************   -->
                                                          <!-- *******************************  QUIN DIA ********************************************************   -->
                                                          <a id="scroll-seccio-dia"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-dia"> 
                                                              <h1 class="titol"><span class="number">2</span><?php l("Quin dia voleu venir?") ?>
                                                                  <a href="#" id="info-data" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>


                                                              </h1>

                                                              <div class="col flex" style="width:100%;">
                                                                  <!-- ******  INFO  ********   -->
                                                                  <div class="caixa dere ui-corner-all info-data">
                                                                      <?php l('INFO_DATA'); ?>	
                                                                      <input type="hidden" id="valida_calendari" name="selectorData"/>

                                                                  </div>
                                                                  <!-- ******  CALENDARI  ********   -->
                                                                  <div id="data" style="float:left">

                                                                      <div id="calendari"></div>
                                                                  </div>
                                                                  <div style="clear:both"></div>

                                                              </div>		
                                                          </div>		

                                                          <!-- *******************************  QUINA HORA ********************************************************   -->
                                                          <!-- *******************************  QUINA HORA ********************************************************   -->
                                                          <!-- *******************************  QUINA HORA ********************************************************   -->
                                                          <a id="scroll-seccio-hora"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-hora" style="display:block"> 
                                                              <h1 class="titol"><span class="number">3</span><?php l('A quina hora?'); ?>
                                                                  <a href="#" id="info-hora" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

                                                              </h1>
                                                              <!-- ******  INFO  ********   -->
                                                              <div class="ui-corner-all caixa dere hores info-hora">
                                                                  <?php l('INFO_HORES'); ?>	
                                                              </div>
                                                              <!-- ******  DINAR  ********   -->
                                                              <h4><?php l('Dinar'); ?></h4>
                                                              <div id="selectorHora" class="col_dere">
                                                                  <img src="/cb-reserves/reservar/css/loading.gif"/>
                                                              </div>
                                                              <!-- ******  SOPAR  ********  
                                                              <h4><?php l('Sopar'); ?></h4>
                                                              <div id="selectorHoraSopar" class="col_dere" >
                                                                  <img src="/cb-reserves/reservar/css/loading.gif"/>
                                                              </div>
                                                              -->
                                                              <input type="hidden" name="taulaT1" value="">
                                                              <input type="hidden" name="taulaT2" value="">
                                                              <input type="hidden" name="taulaT3" value="">
                                                          </div>	


                                                          <!-- *******************************  CARTA  *********************************   -->
                                                          <!-- *******************************  CARTA  *********************************   -->
                                                          <!-- *******************************  CARTA  *********************************   -->
                                                          <a id="scroll-grups-seccio-carta"></a>
                                                          <div class="fr-seccio ui-corner-all grups-fr-seccio-carta "> 
                                                              <h1 class="titol"><span class="number">4</span><?php l('Escull els menús'); ?>
                                                                  <a href="#" id="info-comanda" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

                                                              </h1>
                                                              <div id="carta" class="col_derexx">
                                                                  <input id="te-comanda" name="te_comanda" type="text" value="" style="display:none "> 
                                                                  <!-- ******  COMANDA  ********   -->
                                                                  <div class="caixa dere ui-corner-all" >
                                                                      <table id="caixa-carta" class="col_dere">
                                                                          <tr>
                                                                              <td class="mesX"></td>
                                                                              <td class="menysX"></td>
                                                                              <td class="Xborra"></td>
                                                                              <td class="carta-plat">
                                                                                  <h3><?php l("SELECCIO_GRUPS") ?></h3>
                                                                              </td>
                                                                              <td></td>
                                                                          </tr>
                                                                          <tr>
                                                                              <td class="mesX">							
                                                                                  <?php if (isset($comanda)) echo $comanda ?></td>
                                                                              <td class="menysX"></td><td class="Xborra"></td>
                                                                              <td class="carta-plat"><h3>	</h3></td>
                                                                              <td></td>
                                                                          </tr>
                                                                      </table>
                                                                      <!-- ******  BUTO CARTA  ********   -->
                                                                      <div class="ui-corner-all info info-comanda" >
                                                                          <?php l('INFO_COMANDA_GRUPS'); ?>
                                                                      </div>


                                                                  </div>
<div style="display:flex">
                                                                  <!-- ******  INFO  ********  
                                                                  <div class="ui-corner-all info">
                                                                  <?php l('INFO_CARTA'); ?>
                                                                  </div> -->
                                                                  <!-- ******  BUTO CARTA  ********   -->

                                                                  <a href="#"  id="bt-carta" name="bt-carta" class="bt" ><?php l('Carta'); ?></a>
                                                                  <a href="#"  id="bt-menu" name="bt-menu" class="bt"><?php l('Menús'); ?></a>
                                                                  <a href="#" id="bt-no-carta" name="bt-no-carta" class="bt" ><?php l('Continuar'); ?></a>
                                                                  <div style="clear:both"></div>

                                                              </div>
                                                              </div>
                                                          </div>	



                                                          <!-- *******************************  CLIENT ********************************************************   -->
                                                          <!-- *******************************  CLIENT ********************************************************   -->
                                                          <!-- *******************************  CLIENT ********************************************************   -->
                                                          <a id="scroll-seccio-client"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-client"> 
                                                              <h1 class="titol"><span class="number">5</span><?php l('Donan´s algunes dades de contacte'); ?>
                                                                  <a href="#" id="info-legal" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

                                                              </h1>
                                                              <table id="dades-client" class="col_dere">
                                                                  <tr><td class="label" >* <em style="font-size:0.9em;"><?php l('Camps obligatoris'); ?></em>
                                                                          <div><label class="label" for="client_mobil"><?php l('Telèfon mòbil'); ?>*</label><input type="text" name="client_mobil" value="<?php echo $row['client_mobil'] ?>"/></div>
                                                                          <div><label class="label" for="client_telefon"><?php l('Ens vols deixar una altre telèfon?'); ?></label><input type="text" name="client_telefon" value="<?php echo $row['client_telefon'] ?>"/></div>
                                                                          <div><label class="label" for="client_email">Email*</label><input type="email" name="client_email" value="<?php echo $row['client_email'] ?>"/></div>
                                                                          <div><label class="label" for="client_nom"><?php l('Nom'); ?>*</label><input type="text" name="client_nom" value="<?php echo $row['client_nom'] ?>"/></div>
                                                                          <div><label class="label" for="client_cognoms"><?php l('Cognoms'); ?>*</label><input type="text" name="client_cognoms" value="<?php echo $row['client_cognoms'] ?>"/></div>
                                                                          <div><label class="label" for="client_id"><?php //l('Client_id');   ?></label><input type="hidden" name="client_id" value="<?php echo $row['client_id'] ?>"/></div>
                                                                          <div class="ui-corner-all info-legal info-observacions  caixa" >
                                                                              <?php l('NO_COBERTS_OBSERVACIONS'); ?>
                                                                          </div>


                                                                          <div><label class="label" ><?php l('Observacions'); ?>
                                                                                  <a href="#" id="info-observacions" class="info-ico"><img src="/cb-reserves/reservar/css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

                                                                              </label><textarea type="text" name="observacions"> <?php echo $row['observacions'] ?></textarea>
                                                                          </div>

                                                                      </td></tr>
                                                                  <tr><td>
                                                                          <input type="checkbox" id="cb_factura" name="factura[]"/><label for="cb_factura" style="margin-left:10px;"><?php l('Vull rebre factura ProForma'); ?></label>
                                                                          <div class="factura"><label class="label" for="factura_cif"><?php l('CIF'); ?>*</label><input type="text" name="factura_cif"/></div>
                                                                          <div class="factura"><label class="label " for="factura_nom"><?php l('Nom'); ?>*</label><input type="text" name="factura_nom"/></div>
                                                                          <div class="factura"><label class="label " for="factura_adresa"><?php l('Adreça'); ?>*</label><textarea type="text" name="factura_adresa"></textarea></div>




                                                              </table>				



                                                              <div class="ui-corner-all info-legal caixa">
                                                                  <?php
                                                                  l('LLEI');
                                                                  $chek = ($gestor->flagBit($row['reserva_info'], 7) ? 'checked="checked"' : '');
                                                                  ?>
                                                                  <br/>

                                                                  <input type="checkbox" id="esborra_dades" name="esborra_dades" value="on" <?php print $chek ?>/><label for="esborra_dades"><?php l("ESBORRA_DADES") ?></label>

                                                              </div>
                                                              <div style="clear:both"></div>
                                                          </div>	

                                                          <!-- *******************************  SUBMIT ********************************************************   -->
                                                          <!-- *******************************  SUBMIT ********************************************************   -->
                                                          <!-- *******************************  SUBMIT ********************************************************   -->


                                                          <a id="scroll-seccio-submit"></a>
                                                          <div class="fr-seccio ui-corner-all fr-seccio-submit" style="display:block;"> 
                                                              <h1 class="titol"><span class="number">6</span><?php l('Envia la sol·licitud'); ?></h1>
                                                              <div class="ui-corner-all caixa resum">
                                                                  <b><?php l('Resum reserva'); ?>:</b><br/><br/>
                                                                  <?php l('Data'); ?>: <b id="resum-data">-</b> | <?php l('Hora'); ?>: <b id="resum-hora">-</b><br/>
                                                                  <?php l('Adults'); ?>: <b id="resum-adults">-</b> | <?php l('Juniors'); ?>: <b id="resum-juniors">-</b> | <?php l('Nens'); ?>: <b id="resum-nens">-</b> | <?php l('Cotxets'); ?>: <b id="resum-cotxets">-</b><br/>
                                                                  <!--<?php l('Resum menús'); ?>: <b id="resum-comanda"><?php
                                                                  l('Sense');
                                                                  echo " ";
                                                                  l('menú');
                                                                  ?> </b>  -->
                                                                  <?php l('Comanda'); ?>: <b id="resum-comanda"><?php l('Sense'); ?> </b> <?php l('plats'); ?> (<b id="resum-preu"></b> €)
                                                              </div>
                                                              <div class="ui-corner-all info-submit caixa dere alert alert-danger">
                                                                  <?php l('INFO_NO_CONFIRMADA'); ?>:

                                                              </div>
                                                              <button id="submit"><?php l('Sol·licitar reserva'); ?></button>

                                                              <div style="clear:both"></div>
                                                              <div id="error_validate" class="ui-helper-hidden"><?php l("Hi ha errors al formulari. Revisa les dades, si us plau"); ?></div>
                                                          </div>

                                                      </div>

                                                  </form>	


                                                  <div id="fr-menu-popup" title="<?php l("Els nostres menús") ?>" class="carta-menu">
                                                      <div id="fr-menu-tabs" >
                                                          <?php echo $gestor->recuperaCarta($row['id_reserva'], true) ?>

                                                          <h3 id="carta-total"></h3>
                                                      </div>	
                                                  </div>
                                                  
                                                  
                                                  <!-- ******************* CARTA *********************** -->
                                                  <!-- ******************* CARTA *********************** -->
                                                  <!-- ******************* CARTA *********************** -->
                                                  <div id="fr-cartaw-popup" title="<?php l("La nostra carta") ?>" class="carta-menu" style="height:300px">
                                                      <div class="ui-corner-all info-legal caixa" role="alert">
                                                      <?php l("CARTA_FINS_20") ?>
                                                          
                                                      </div>
                                                      <div id="fr-carta-tabs" >
                                                         <?php echo $gestor->recuperaCarta($row['id_reserva']) ?>
                                                      </div>	
                                                  </div>	
                                                  

                                                  <!-- ******************* POPUPS GRUPS *********************** -->
                                                  <!-- ******************* POPUPS GRUPS *********************** -->
                                                  <!-- ******************* POPUPS GRUPS *********************** -->
                                                  <div id="popupGrups" title="<?php l("Reserva per grups") ?>" class="ui-helper-hidden">
                                                      <?php l('ALERTA_GRUPS'); ?>

                                                  </div>
                                                  <!-- ******************* POPUPS HELP *********************** -->
                                                  <!-- ******************* POPUPS HELP *********************** -->
                                                  <!-- ******************* POPUPS HELP *********************** -->
                                                  <div id="helpxxx" title="<?php l("Necessites ajuda?") ?>" class="ui-helper-hidden">
                                                      <?php l('ALERTA_INFO_INICIAL_GRUPS'); ?>
                                                  </div>

                                                  <div id="osx-modal-content">
                                                      <div id="osx-modal-title"><?php l("Necessites ajuda?") ?></div>
                                                      <div class="close"><a href="#" class="simplemodal-close">x</a></div>
                                                      <div id="osx-modal-data">
                                                          <?php l('ALERTA_INFO_INICIAL_GRUPS'); ?>
                                                          <p><button class="simplemodal-close"><?php l("Tanca") ?></button></p>
                                                      </div>
                                                  </div>                                                    



                                                  <!-- ******************* POPUPS INFO *********************** -->
                                                  <!-- ******************* POPUPS INFO *********************** -->
                                                  <!-- ******************* POPUPS INFO *********************** -->
                                                  <div id="popup" title="<?php l("Informació") ?>"></div>

                                                  <div id="popupInfo" CLASS="ui-helper-hidden">
                                                      <?php l('ALERTA_INFO_GRUPS'); ?>
                                                  </div>

                                                  <div id="reserves_info" class="ui-helper-hidden">
                                                      <?php include(ROOT . "../reservar/reservesInfo_" . substr($lang, 0, 2) . ".html"); ?>
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
                        <?php endwhile; // end of the loop.      ?>
                    </section>
                </div>
                <?php if ($sidebar == 'left' || $sidebar == 'both'): ?>
                  <div class="col-aside-left">
                      <aside class="blog-side left text-left">
                          <div class="widget-area">
                              <a href="#" class="btn btn-warning  ecp-trigger" data-modal="modal" >     <?php l('Tens algun dubte?'); ?></a>

                              <?php get_sidebar('pageleft'); ?>
                          </div>
                      </aside>
                      o     </div>
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