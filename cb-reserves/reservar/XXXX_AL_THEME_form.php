<?php
header('Location: /reservar/realitzar-reserva');exit();

if (!defined('ROOT')) header('Content-Type: text/html; charset=UTF-8');

defined('ROOT') or define('ROOT', '/cb-reserves/taules/');
require_once (ROOT . "Gestor.php");

//if (!defined('LLISTA_DIES_NEGRA'))  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "bloq.txt");
if (!defined('LLISTA_DIES_NEGRA'))  define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
//if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra_online.txt");
if (!defined('LLISTA_DIES_NEGRA_RES_PETITES'))  define("LLISTA_DIES_NEGRA_RES_PETITES", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
if (!defined('LLISTA_NITS_NEGRA'))  define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
if (!defined('LLISTA_DIES_BLANCA'))  define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
define('USR_FORM_WEB', 3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

$ruta_lang = "../";
/**/
// ERROR HANDLER
//require_once("../taules/php/error_handler.php");
// CREA USUARI ANONIM AMB PERMISOS PER CREAR RESERVA
if (!isset($_SESSION))
  session_start();
$usr = new Usuari(USR_FORM_WEB, "webForm", 1);
if (!isset($_SESSION['uSer'])) {
  $_SESSION['uSer'] = $usr;
}

$_SESSION['admin_id'] = $_SESSION['uSer']->id;
$_SESSION['permisos'] = $_SESSION['uSer']->permisos;

require_once("Gestor_form.php");
$gestor = new Gestor_form();

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true && !$gestor->valida_login())
  header("Location:/cb-reserves/reservar/fora_de_servei.html");

require_once(ROOT . INC_FILE_PATH . 'alex.inc');
require_once(ROOT . INC_FILE_PATH . "llista_dies_taules.php");

//RECUPERA IDIOMA
/*
if (!isset($_REQUEST["lang"]))
  $_REQUEST["lang"] = "";
$lang = $gestor->idioma($_REQUEST["lang"]);
 */
$gestor->lng = $lang = Gestor::getLanguage();
$l = $gestor->lng;

//RECUPERA CONIG ANTIC
$PERSONES_GRUP = $gestor->configVars("persones_grup");
define("PERSONES_GRUP", $PERSONES_GRUP);
$max_nens = $gestor->configVars("max_nens");
$max_juniors = $gestor->configVars("max_juniors");

$gestor->netejaImpagatsTpv(); // TPV I IMPAGATS
$paga_i_senyal = $PERSONES_GRUP >= persones_paga_i_senyal;


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "//www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title> Masia Can Borrell </title>
        <!-- <?php echo $gestor->configVars("url_base"); ?> -->
        <!-- <?php echo $gestor->configVars("INC_FILE_PATH"); ?> -->
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href='https://fonts.googleapis.com/css?family=Raleway:400,300,700,300italic' rel='stylesheet' type='text/css'>

            <link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.forms.css" rel="stylesheet" />	
            <link type="text/css" href="css/jquery.tooltip.css" rel="stylesheet" />	
            <link type="text/css" href="css/form_reserves_mob.css" rel="stylesheet" />		
            <link type="text/css" href="../css/estils.css" rel="stylesheet" />	
            <link type="text/css" href="css/osx.css" rel="stylesheet" />
            <link type="text/css" href="css/glyphicons.css" rel="stylesheet" />
            <link rel="stylesheet" href="/css/bootstrap.min.css"> 
                <!--<link type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />-->


                <?php echo Gestor::loadJQuery(); ?>

                <script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
                <script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-es.js"></script>
                <script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-en.js"></script>
                <script type="text/javascript" src="../taules/js/jquery.metadata.js"></script>
                <script type="text/javascript" src="../taules/js/jquery.validate.min.js"></script>
                <script type="text/javascript" src="../taules/js/jquery.timers.js"></script>
                <script type="text/javascript" src="../taules/js/jquery.form.js"></script>
                <script type="text/javascript" src="../taules/js/jquery.scrollTo.min.js"></script>
                <script type="text/javascript" src="../taules/js/jquery.browser.js"></script>
                <script type="text/javascript" src="js/json2.js"></script>
                <!-- ANULAT dynmenu.js -->
                <script type="text/javascript" src="js/jquery.amaga.js"></script>
                <script type="text/javascript" src="js/jquery.tooltip.js"></script>
                <!--<script src="/js/bootstrap.min.js"></script>-->
                <meta name="viewport" content="width=device-width, initial-scale=1">

                    <?php
                    
                    
                    require_once('translate_' . $gestor->lng . '.php');
                  
                    /*                     * ****************************************************** */
                    //ELIMINA RESERVA 
                    if (isset($_POST['cancel_reserva']) && $_POST['cancel_reserva'] == "Eliminar reserva" && $_POST['idr'] > SEPARADOR_ID_RESERVES) {
                      if ($gestor->cancelReserva($_POST['mob'], $_POST['idr'])) {
                        l("RESERVA_CANCELADA");
                        $_REQUEST['idr'] = $_POST['idr'] = null;
                      }
                      else {
                        l("ERROR_CANCEL_RESERVA");
                        $_REQUEST['idr'] = $_POST['idr'] = null;
                      }
                    }

                    /*                     * ****************************************************** */
                    //RECUPERA RESERVA UPDATE
                    if (isset($_POST['Submit']) && $_POST['Submit'] == "Editar reserva") {
                      if (isset($_POST['idr']) && $_POST['idr'] > SEPARADOR_ID_RESERVES) { //si es reserva de grups
                        $row = $gestor->recuperaReserva($_POST['mob'], $_POST['idr']);
                        if (!$row) {
                          l("ERROR_LOAD_RESERVA");
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

                    if (!isset($_POST['idr']))
                      $_POST['idr'] = null;
                    $EDITA_RESERVA = $_POST['idr'];

                    echo $gestor->dumpJSVars(true);
                    ?>

                    <script type="text/javascript">
                      var PERSONES_GRUP =<?php echo $PERSONES_GRUP; ?>;
                      var lang = "<?php echo $lang; ?>";
<?php
  

if (isset($_GET['rdata'])) {
  $data = Gestor::cambiaf_a_mysql($_GET['rdata']);
  echo 'var rdata = "' . $data . '";';
}
if (isset($_GET['contacte'])) {

  echo 'var obre_contacte = true;';
}




//TRANSLATES

$llista_negra = llegir_dies(LLISTA_DIES_NEGRA);
print crea_llista_js($llista_negra, "LLISTA_NEGRA");
print "\n\n";

$llista_blanca = llegir_dies(LLISTA_DIES_BLANCA);
print crea_llista_js($llista_blanca, "LLISTA_BLANCA");

$llista_dies_no_carta = llegir_dies(ROOT . INC_FILE_PATH . "llista_dies_no_carta.txt");
print crea_llista_js($llista_dies_no_carta, "LLISTA_DIES_NO_CARTA");

print "\nvar IDR='" . $row['id_reserva'] . "';";
print "var RDATA;";
if (!empty($row['data']))
  print "\nRDATA='" . $gestor->cambiaf_a_normal($row['data']) . "';";
print "\nvar HORA='" . $row['hora'] . "';";
?>
                    </script>

                    <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
                    <script type="text/javascript" src="js/control_carta.js"></script>
                    <script type="text/javascript" src="js/form_reserves.js<?php //echo '?'.time();   ?>"></script>		
                    <script type="text/javascript" src="js/popups_ajuda.js<?php //echo '?'.time();   ?>"></script>


                    <style>
                        @media (min-width: 768px){
                            body{font-size:12px}
                        }
                        @media (max-width: 768px){
                            .row{margin:0}
                        }

                        .titol{display:flex}


                        .anima-avis .tanca-avis{display:inline}
                        .tanca-avis{display:none;}

                        #avis-modificacions.anima-avis{
                            padding:10px;
                            background-color: #FFFFA1;
                            border: #570600 solid 3px;
                            //border: red solid 3px;

                            z-index: 3000;
                        }
                        #avis-modificacions-overlay.anima-avis{
                            display: block;
                            //opacity:0.8;
                        }
                        .dspnn{display:none;}
                        #avis-modificacions{
                            position:relative;
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

<?php
if (!$paga_i_senyal)
  echo ".info-paga-i-senyal{display:none}";
?>

                    </style>
                    </head>
                    <body class="amagat front <?php echo DEV ? " dev " : "";
                        echo LOCAL ? " local " : "" ?>"  >
<?php  if (isset($_REQUEST["testTPV"])  && $_SESSION['permisos']>200) echo "*******testTPV**********"; ?>
                        <div id="container">
                            <div class="row row-offcanvas row-offcanvas-left">

                                <nav class="navbar navbar-inverse navbar-fixed-top">
                                    <div class="container">
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                                <span class="sr-only"><?php l("Desplega menú") ?></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>

                                            <a class="navbar-brand" href="canborrell">Masia Can Borrell</a>
                                            <div id="data-reserva" class="" >
<?php
$cb_printed_menu = TRUE;

require_once('../menu.php');
echo menu_idiomes();
?>
                                                <div>

                                                </div>
                                            </div><!--/.navbar-collapse -->
                                            <div class="c-b"></div>
                                            <div id="navbar" class="collapse navbar-collapse">

                                                <?php echo main_menu($main_menu_elements, $lang); ?>
                                            </div><!-- /.nav-collapse -->
                                        </div> 
                                    </div>
                                </nav>

                                <header class="">
                                    <a href="<?php echo $lang ?>/index.htm" id="img-logo-dere">
                                        <img src="../img/lg_sup.gif" width="303" height="114"  title="<?php l("Inici"); ?>"></a>
                                </header>

                                <nav id="nav-main-menu" style="">
<?php
require_once('../menu.php');
//&#10096;
?>
                                    <span style="" class="apartat">&#10171; <?php echo lv('Reservar'); ?> </span>

                                    <div class="c-b" style=""></div>
                                </nav>






                                <div id="cos">

                                    <!-- ***************************************************************************************   -->
                                    <!-- ***************************************************************************************   -->
                                    <!-- ********     EDITA RESERVA       ***********************************************************   -->
                                    <!-- ***************************************************************************************   -->
                                    <!-- ***************************************************************************************   -->
<?php
if (!$EDITA_RESERVA)
  include("login.php");
if ($EDITA_RESERVA && $EDITA_RESERVA < SEPARADOR_ID_RESERVES && !isset($_POST['incidencia_grups'])) {
  include("form_contactar_grups.php");
}
?>
                                    <!-- *****************<div style="clear:both"></div>**********************************************************************   -->
                                    <!-- ***************************************************************************************   -->



                                    <!-- ***************************************************************************************   -->
                                    <!-- ********     CONTACTE       ***********************************************************   -->
                                    <!-- ***************************************************************************************   -->
                                    <!-- ***************************************************************************************   -->
<?php
if (isset($_POST['incidencia_grups'])) {
  if (!$gestor->contactar_grups($_POST))
    l("ERROR_CONTACTAR");
  else
    l("CONTACTAR_OK");

  //die();
}elseif (isset($_POST['incidencia'])) {
  if (!$gestor->contactar($_POST))
    l("ERROR_CONTACTAR");
  else
    l("CONTACTAR_OK");
}
else
  include("form_contactar.php");
?>


                                    <div style="clear:both"></div>
                                    <h2 class="titol titol1">
<?php
if ($EDITA_RESERVA) {
  l('Editant reserva ID');
  echo $EDITA_RESERVA;


  echo '<a href="info_reserves.html" id="info_reserves"><img src="css/info.png" title="' . l("Informació de reserves", false) . '" style="width:16px;height:auto;margin-left:8px"/></a>';
  echo '<form id="fdelete" name="form1" method="POST" action="' . $_SERVER['PHP_SELF'] . '">
	<input type="hidden" name="mob" value="' . $_REQUEST['mob'] . '"/>
	<input type="hidden" name="idr" value="' . $_REQUEST['idr'] . '"/>
	<input type="submit" id="cancel_reserva" name="cancel_reserva" value="Eliminar reserva" />
	</form>';
}
else {
  l('Sol·licitud de reserva');
  echo '<a href="info_reserves.html" id="info_reserves"><img src="css/info.png" title="' . l("Informació de reserves", false) . '" style="width:16px;height:auto;margin-left:8px"/></a>';
}
?>
                                    </h2>

                                    <!-- ***************************************************************************************   -->
                                    <!-- ***************************************************************************************   -->
<?php
$test = isset($_REQUEST['testTPV']) ? '&testTPV=' . $_REQUEST['testTPV'] : "";
?>
                                    <form id="form-reserves" action="/cb-reserves/reservar/Gestor_form.php?a=submit<?php echo $test; ?>" method="post" name="fr-reserves" accept-charset="utf-8"><!---->
                                        <input type="hidden" name="id_reserva" value="<?php echo isset($_REQUEST['idr']) ? $_REQUEST['idr'] : ""; ?>"/>
                                        <input type="hidden" name="reserva_info" value="<?php echo $row['reserva_info']; ?>"/>
                                        <div id="fr-reserves" class="fr-reserves">
                                            <!-- *******************************  QUANTS SOU ********************************************************   -->
                                            <!-- *******************************  QUANTS SOU ********************************************************   -->
                                            <!-- *******************************  QUANTS SOU ********************************************************   -->


                                            <div class="fr-seccio ui-corner-all fr-seccio-quants" style="xxxmax-width:950px;">
                                                <h1 class="titol"><span class="number">1</span><?php l('Quants sou?'); ?>
                                                    <a href="#" id="info-quants" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                </h1>
                                                <h4  id="titol_SelectorComensals"><?php l('Adults (més de 14 anys)'); ?>:</h4>


                                                <!-- ******  ADULTS  ********   -->
                                                <div id="selectorComensals" class="fr-col-dere selector">
                                                    <input type="hidden" id="com" name="adults" value="<?php echo $row['adults'] ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)  ?></label>	
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
                                                <br/>
                                                <!------------------- FI AVIS MODIFICACIONS ---------------------------->




                                                <hr/>
                                                <div id="jnc" style="float:left">
                                                    <!-- ******  JUNIOR  ********   -->
                                                    <h4  id="titol_SelectorJuniors"><?php l('Juniors (de 10 a 14 anys):'); ?></h4>
                                                    <input type="hidden" id="junior" name="nens10_14" value="<?php echo $row['nens10_14'] ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)   ?></label>
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

                                                    <hr/>
                                                    <!-- ******  NENS  ********   -->
                                                    <h4  id="titol_SelectorNens"><?php l('Nens (de 4 a 9 anys)'); ?>:</h4>
                                                    <div id="selectorNens" class="col_dere">
                                                        <input type="hidden" id="nens" name="nens4_9" value="<?php echo $row['nens4_9'] ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14)  ?></label>
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
$estat = $gestor->decodeInfo($row['reserva_info']);

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
$estat = $gestor->decodeInfo($row['reserva_info']);
$chek0 = ($estat['cadiraRodes'] == 0 ? '' : 'checked="checked"');
$chek1 = ($estat['accesible'] == 0 ? '' : 'checked="checked"');
?>
                                                        <input type="checkbox" id="accesible" name="selectorAccesible" value="on"  <?php echo $chek1 ?> /><label for="accesible"><?php l("Algú amb movilitat reduïda"); ?></label>
                                                        <input type="checkbox" id="cadira0" name="selectorCadiraRodes" value="on"  <?php echo $chek0 ?> /><label for="cadira0"><?php l("Portem una cadira de rodes"); ?></label>
                                                    </div>

                                                </div>	


                                                <!-- ******  INFO  ********   -->
                                                <div class="caixa dere info ui-corner-all info-quants"><?php l('INFO_QUANTS_SOU'); ?>
                                                    <input type="text" name="totalComensals" value="<?php echo $row['adults'] + $row['nens10_14'] + $row['nens4_9'] ?>" readonly="readonly"/></b>
                                                    <input type="text" name="totalCotxets" value="<?php echo $row['cotxets'] ? "/ " . $row['cotxets'] : "" ?>" readonly="readonly"/></b>
                                                    <!--Tingue's present que si vols modificar aquest nombre més endavant no podem garantir la disponibilitat de taula.<br/><br/>-->
                                                </div>
                                                <div style="clear:both"></div>

                                            </div>		

                                            <!-- *******************************  QUIN DIA ********************************************************   -->
                                            <!-- *******************************  QUIN DIA ********************************************************   -->
                                            <!-- *******************************  QUIN DIA ********************************************************   -->

                                            <div class="fr-seccio ui-corner-all fr-seccio-dia"> 
                                                <div class="putoIE">
                                                    <h1 class="titol"><span class="number">2</span><?php l("Quin dia voleu venir?") ?>
                                                        <a href="#" id="info_dia" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                    </h1></div>
                                                <!-- ******  INFO  ********   -->
                                                <div class="caixa dere ui-corner-all info_dia">
<?php l('INFO_DATA'); ?>	
                                                    <input type="hidden" id="valida_calendari" name="selectorData" value="<?php echo $row['data']; ?>"/>

                                                </div>
                                                <!-- ******  CALENDARI  ********   -->
                                                <div id="data" style="float:left">
<?php if ($EDITA_RESERVA): ?>

                                                      <script>
                        var BLOQ_DATA = '<?php echo $gestor->cambiaf_a_normal($row['data']); ?>';
                                                      </script>
<?php endif ?>
                                                    <div id="calendari"></div>
                                                </div>
                                                <div style="clear:both"></div>

                                            </div>		

                                            <!-- *******************************  QUINA HORA ********************************************************   -->
                                            <!-- *******************************  QUINA HORA ********************************************************   -->
                                            <!-- *******************************  QUINA HORA ********************************************************   -->
                                            <a id="scroll-seccio-hora"></a>
                                            <div class="fr-seccio ui-corner-all fr-seccio-hora" > 
                                                <h1 class="titol"><span class="number">3</span><?php l('A quina hora?'); ?>
                                                    <a href="#" id="info_hora" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                </h1>
                                                <!-- ******  INFO  ********   -->
                                                <div class="ui-corner-all caixa dere hores info_hora">
<?php l('INFO_HORES'); ?>	
                                                </div>
                                                <!-- ******  DINAR  ********   -->
                                                <h4><?php l('Dinar'); ?></h4>
                                                <div id="selectorHora" class="col_dere">
                                                    <img src="/cb-reserves/reservar/css/loading.gif"/>
                                                </div>
                                                <!-- ******  SOPAR  ********   -->
                                                <h4><?php l('Sopar'); ?></h4>
                                                <div id="selectorHoraSopar" class="col_dere" >
                                                    <img src="/cb-reserves/reservar/css/loading.gif"/>
                                                </div>

                                                <input type="hidden" name="taulaT1" value="">
                                                    <input type="hidden" name="taulaT2" value="">
                                                        <input type="hidden" name="taulaT3" value="">
                                                            </div>	


                                                            <!-- *******************************  CARTA  *********************************   -->
                                                            <!-- *******************************  CARTA  *********************************   -->
                                                            <!-- *******************************  CARTA  *********************************   -->
                                                            <a id="scroll-seccio-carta"></a>
                                                            <div class="fr-seccio ui-corner-all fr-seccio-carta"> 
                                                                <h1 class="titol"><span class="number">4</span><?php l('Vols triar els plats?'); ?> (opcional)
                                                                    <a href="#" id="info_carta" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                                </h1>
                                                                <div id="carta" class="col_derexx">
                                                                    <input id="te-comanda" name="te_comanda" type="text" value="" style="display:none"> 
                                                                        <!-- ******  COMANDA  ********   -->
                                                                        <div class="caixa dere ui-corner-all" >

                                                                            <input type="checkbox" id="RESERVA_PASTIS" name="RESERVA_PASTIS" value="on" <?php echo $row['reserva_pastis'] ? 'checked="checked"' : "" ?>/><label for="RESERVA_PASTIS" ><?php l("RESERVA_PASTIS") ?></label>
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
                                                                                        <h3><?php //l("SELECCIÓ")   ?></h3>
                                                                                    </td>
                                                                                    <td></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td class="mesX">							
<?php echo $comanda ?></td>
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

                                                                        <!-- ******  INFO  ********   -->
                                                                        <div class="ui-corner-all info">
<?php l('INFO_CARTA'); ?>
                                                                        </div>
                                                                        <!-- ******  BUTO CARTA  ********   -->
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
                                                                <h1 class="titol"><span class="number">5</span><?php l('Donan´s algunes dades de contacte'); ?>

                                                                </h1>
                                                                <table id="dades-client" class="col_dere">
                                                                    <tr><td class="label" >* <em style="font-size:0.9em;"><?php l('Camps obligatoris'); ?></em>
                                                                            <div><label class="label" for="client_mobil"><?php l('Telèfon mòbil'); ?>*</label><input type="text" name="client_mobil" value="<?php echo $row['client_mobil'] ?>"/></div>
                                                                            <div><label class="label" for="client_telefon"><?php l('Ens vols deixar una altre telèfon?'); ?></label><input type="text" name="client_telefon" value="<?php echo $row['client_telefon'] ?>"/></div>
                                                                            <div><label class="label" for="client_email">Email*</label><input type="email" name="client_email" value="<?php echo $row['client_email'] ?>"/></div>
                                                                            <div><label class="label" for="client_nom"><?php l('Nom'); ?>*</label><input type="text" name="client_nom" value="<?php echo $row['client_nom'] ?>"/></div>
                                                                            <div><label class="label" for="client_cognoms"><?php l('Cognoms'); ?>*</label><input type="text" name="client_cognoms" value="<?php echo $row['client_cognoms'] ?>"/></div>
                                                                            <div><label class="label" for="client_id"><?php //l('Client_id');   ?></label><input type="hidden" name="client_id" value="<?php echo $row['client_id'] ?>"/></div>
                                                                            <div class="ui-corner-all info-legal info-observacions  caixa" style="width:496px;">
<?php l('NO_COBERTS_OBSERVACIONS'); ?>
                                                                            </div>


                                                                            <div><label class="label" for=""><?php l('Observacions'); ?>
                                                                                    <a href="#" id="info-observacions" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                                                                </label><textarea type="text" name="observacions"><?php echo $row['observacions'] ?></textarea>
                                                                            </div>

                                                                        </td></tr>
                                                                    <tr><td >




                                                                        </td></tr>
                                                                </table>
                                                                <div style="clear:both"></div>
                                                                <div class="ui-corner-all info-legal info-legal-dades caixa">
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
                                                            <div class="fr-seccio ui-corner-all fr-seccio-submit"> 
                                                                <h1 class="titol"><span class="number">6</span><?php l('Envia la sol·licitud'); ?></h1>

                                                                <div class="ui-corner-all caixa resum">
                                                                    <b><?php l('Resum reserva'); ?>:</b><br/><br/>
<?php l('Data'); ?>: <b id="resum-data">-</b> | <?php l('Hora'); ?>: <b id="resum-hora">-</b><br/>
<?php l('Adults'); ?> <b id="resum-adults">-</b> | <?php l('Juniors'); ?>: <b id="resum-juniors">-</b> | <?php l('Nens'); ?>: <b id="resum-nens">-</b> | <?php l('Cotxets'); ?>: <b id="resum-cotxets">-</b><br/>
<?php l('Comanda'); ?>: <b id="resum-comanda"><?php l('Sense'); ?> </b> <?php l('plats'); ?> (<b id="resum-preu"></b> €)
                                                                </div>
                                                                <div class="ui-corner-all info-submit caixa dere">
                                                                    <?php l('INFO_NO_CONFIRMADA'); ?>:

                                                                </div>
                                                                    <?php $t = (isset($_POST['idr']) && $_POST['idr'] > 5000) ? 'Modificar reserva' : 'Sol·licitar reserva'; ?>
                                                                <button id="submit"><?php l($t); ?></button>


                                                                <div id="error_validate" class="ui-helper-hidden"><?php l("Hi ha errors al formulari. Revisa les dades, si us plau"); ?></div>
                                                            </div>
                                                            </div>

                                                            </form>	





                                                            <!--	
                                                            <div id="peu" style="margin-top:50px;	text-align:center;padding:15px;background:#FFFFFF" ><b>Restaurant CAN BORRELL:</b> <span class="dins cb-contacte" style="text-align:right">93 692 97 23 / 93 691 06 05 </span>  /  <a href="mailto:<?php echo MAIL_RESTAURANT; ?>" class="dins"><?php echo MAIL_RESTAURANT; ?></a>
                                                            </div>
                                                           
                                                            <div id="peu" style="margin-top:50px;	text-align:center;padding:15px;background:#FFFFFF" ><b>Restaurant CAN BORRELL:</b> <button class="dins cb-contacte" style="text-align:right">Contactar amb el restaurant </button>  /  <a href="mailto:<?php echo MAIL_RESTAURANT; ?>" target="_blank"  class="dins"><?php echo MAIL_RESTAURANT; ?></a>
                                                            </div>
                                                            -->	
                                                            <div>
<?php
//echo import_paga_i_senyal;
//echo $gestor->generaFormTpv('20110101',$gestor->configVars("import_paga_i_senyal"),"TEST_TPV"); 
if (FALSE && isset($_REQUEST["testTPV"]) && $_REQUEST["testTPV"] = 'testTPV') {
  echo "<style>"
  . "#compra input[type=text], .ds_input{display:block;}"
  . "</style>";
  echo $gestor->generaFormTpvSHA256(43748, $gestor->configVars("import_paga_i_senyal"), "TEST_TPV");
}
?> 

                                                            </div>

                                                            <!-- ******************* CARTA *********************** -->
                                                            <!-- ******************* CARTA *********************** -->
                                                            <!-- ******************* CARTA *********************** -->
                                                            <div id="fr-cartaw-popup" title="<?php l("La nostra carta") ?>" class="carta-menu" style="height:300px">
                                                                <div id="fr-carta-tabs" >
<?php echo $gestor->recuperaCarta($row['id_reserva']) ?>
                                                                </div>	
                                                            </div>	
                                                            <!-- ******************* CARTA-MENU *********************** -->
                                                            <!-- ******************* CARTA-MENU *********************** -->
                                                            <!-- ******************* CARTA-MENU *********************** -->
                                                            <div id="fr-menu-popup" title="<?php l("Els nostres menús") ?>" class="carta-menu">
                                                                <div id="fr-menu-tabs" >
<?php echo $gestor->recuperaCarta($row['id_reserva'], true) ?>
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
                                                                <?php include("reservesInfo_" . substr($lang, 0, 2) . ".html"); ?>
                                                            </div>

                                                            <div id="debug">  </div>
                                                            </div>

                                                            <div class="c-b"></div>
                                                            <footer>
                                                                <div class="col-md-9" style="">
                                                                    <a href="/<?php echo $lang ?>/canborrell" style="font-size:40px;COLOR:WHITE;text-decoration: none;">Masia Can Borrell</a> 
                                                                    <p style="font-size:15px;COLOR:WHITE;">
                                                                        <a href="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d5980.091215599049!2d2.1106732571472264!3d41.45992612611381!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sca!2ses!4v1461711293148" class="gmaps" style="font-size:15px;COLOR:WHITE;" target="_blank" title="Mapa">
                                                                            Carretera d'Horta a Cerdanyola (BV-1415), km 3 <br> 08171 Sant Cugat del Vallès
                                                                        </a>
                                                                    </p>
                                                                    <style scoped>
                                                                        footer #main-menu a{background-color: transparent;}
                                                                    </style>
<?php
$footer_elements = array(
  array('link' => 'reservar', 'txt' => 'RESERVES'),
  array('link' => 'plats', 'txt' => 'CARTA I MENU'),
  array('link' => 'on', 'txt' => 'ON SOM: MAPA'),
  array('link' => 'horaris', 'txt' => 'HORARI'),
  array('link' => 'reservar/form.php?contacte', 'txt' => 'CONTACTE'),
);

echo main_menu($footer_elements, $lang);
?>

                                                                </div>

                                                                <div class="col-md-3">
                                                                    <div id="datepicker"></div> 

                                                                    <!-- <button type="submit" class="btn btn-success">Reservar</button> -->
                                                                </div>

                                                                <div class="c-b"></div>
                                                            </footer>

                                                            </div> <!-- row -->
                                                            </div> <!-- container -->
                                                            </body>
                                                            </html>
