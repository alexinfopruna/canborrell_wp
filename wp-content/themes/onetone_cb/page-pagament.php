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

if ($mob != $_GET["mob"])
  header('Location: /reservar/localiza-reserva/&lang=' . ICL_LANGUAGE_CODE);

$result = "";
$rid = "";
$mobil = "";

$gestor->xgreg_log("PÀGINA PAGAMENT GRUPS: <span class='idr'>$id</span>");
//CADUCADES
$query_reserves = "UPDATE reserves SET estat=6 WHERE ADDDATE(data_limit,INTERVAL 1 DAY) < NOW() AND data_limit>'2008-01-01' AND estat=2";
$reserves = mysqli_query($canborrell, $query_reserves) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));

if ($id) {
  $query = "SELECT * FROM reserves WHERE id_reserva=$id";
  $Result = mysqli_query($canborrell, $query) or die(((is_object($GLOBALS["___mysqli_ston"])) ? mysqli_error($GLOBALS["___mysqli_ston"]) : (($___mysqli_res = mysqli_connect_error()) ? $___mysqli_res : false)));
  $fila = mysqli_fetch_assoc($Result);
  $estat = $fila['estat'];
  $import = $fila['preu_reserva'];
  $nom = $fila['nom'];
  $lang = $lang_cli = $fila['lang'];
}
if (!isset($lang))
  $lang = $lang_cli = "esp";


$old_lang_code['cat'] = 'cat';
$old_lang_code['ca'] = 'cat';
$old_lang_code['es'] = 'esp';
$old_lang_code['esp'] = 'esp';
$old_lang_code['en'] = 'en';


$lang = $old_lang_code[$lang];
// comprovacions estat reserva
// ARREGLAR MISSATGES

if (($estat == 3) || ($estat == 7)) { // JA S?HA PAGAT 
  $titol['cat'] = "Aquesta reserva ja ha estat pagada<br><br><br><br><br><br>";
  $titol['esp'] = "Esta reserva ya ha sido pagada<br><br><br><br><br><br><br>";
  $titol['en'] = "This reservation has now been paid<br><br><br><br><br><br><br>";
  $surt = true;
  $gestor->xgreg_log($titol['cat'], 1);
}
else if ($estat != 2) {    // NO ESTA CONFIRMADA
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
  $surt = true;
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


((mysqli_free_result($Result) || (is_object($Result) && (get_class($Result) == "mysqli_result"))) ? true : false);


?>
<?php echo Gestor::loadJQuery(); ?>
<script language=JavaScript>
  $(function () {
      $("#boto").click(function () {
          alert("<?php echo $translate['COMPRA_SEGURA'][$lang] ?>");
          document.getElementById('boto').style.display = 'none';
          vent = window.open('', 'frame-tpv', 'width=725,height=600,scrollbars=no,resizable=yes,status=yes,menubar=no,location=no');
          // vent.moveTo(eje_x,eje_y);
          document.forms[0].submit();
      });
  });
</script>

<style>
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
    .ds_input{display:none}
    .post-main .btn-success{
        font-size:24px;
        float:right;
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
                      // echo $title;
                      //
                      //
          the_title();
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
                          <article class="post type-post" id="">
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
                                          <tr>
                                              <td   class="Estilo2">id_reserva</td>
                                              <td   class="llista"><div  class="titol2"><?php echo $fila['id_reserva'];
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
                                          <tr class="preu">
                                              <td   class="Estilo2"><?php echo $camps[7][$lang]; ?></td>
                                              <td   class="llista"><div  class="estat">
                                                      <div  class="Estilo5"><?php echo $fila['preu_reserva']; ?>€ </div>
                                                  </div></td>
                                          </tr>
                                      </table>
                                      <?php
                                      $id_reserva = ((int) $_GET["id"]) + 100000;
                                      //$url_resposta = 'http://' . $_SERVER['HTTP_HOST'] . '/reservar/Gestor_form.php?a=respostaTPV_GRUPS_SHA256';
                                      $responaseok_callback_alter = "reserva_grups_tpv_ok_callback";
                                      $response = isset($_GET["testTPV"]) ? $_GET["testTPV"] : -1;

                                      if (isset($_REQUEST["testTPV"]) && $_REQUEST["testTPV"] == 'testTPV')
                                        echo $gestor->generaTESTTpvSHA256($id_reserva, $import, $nom, $responaseok_callback_alter);
                                      else
                                        echo $gestor->generaFormTpvSHA256($id_reserva, $import, $nom, $responaseok_callback_alter);
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
                        <?php endwhile; // end of the loop.   ?>
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
