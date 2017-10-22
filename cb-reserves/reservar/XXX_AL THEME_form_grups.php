<?php
header('Location: /reservar/reserva-grup');exit();
header('Content-Type: text/html; charset=UTF-8');

defined('ROOT') or define('ROOT', '/cb-reserves/taules/');
require_once (ROOT . "Gestor.php");

if (defined("CB_FORA_DE_SERVEI") && CB_FORA_DE_SERVEI === true)
  header("Location:/cb-reserves/reservar/fora_de_servei.html");

//define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "bloq.txt");
define("LLISTA_DIES_NEGRA", ROOT . INC_FILE_PATH . "llista_dies_negra.txt");
define("LLISTA_NITS_NEGRA", ROOT . INC_FILE_PATH . "bloq_nit.txt");
define("LLISTA_DIES_BLANCA", ROOT . INC_FILE_PATH . "llista_dies_blanca.txt");
define('USR_FORM_WEB', 3); //ES LA ID D'USUARI (admin) ANONIM QUE CREA RESERVA ONLINE

/*
  // ERROR HANDLER
  require_once("../taules/php/error_handler.php");
 */

// CREA USUARI ANONIM
if (!isset($_SESSION))
  session_start();
$usr = new Usuari(USR_FORM_WEB, "webForm", 1);
if (!isset($_SESSION['uSer']))
  $_SESSION['uSer'] = $usr;


require ("Gestor_form.php");
$gestor = new Gestor_form();
require_once(ROOT . INC_FILE_PATH . 'alex.inc');
require_once(ROOT . INC_FILE_PATH . "llista_dies_taules.php");

//PERSONES PARAM
$na = isset($_REQUEST['b']) ? $_REQUEST['b'] : 0;
$nj = isset($_REQUEST['c']) ? $_REQUEST['c'] : 0;
$nn = isset($_REQUEST['d']) ? $_REQUEST['d'] : 0;
$total = $na + $nj + $nn;

//RECUPERA IDIOMA
//$lang_default=isset($_REQUEST["lang"])?$_REQUEST["lang"]:'cat';
$lang = $gestor->idioma();

$l = $gestor->lng;

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
//$row['']=null;
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" pageEncoding="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> Masia Can Borrell </title>


        <!-- this goes into the <head> tag ALEX ESTILS! -->
        <link type="text/css" href="../taules/css/blitzer/jquery-ui-1.8.9.custom.css" rel="stylesheet" />	
        <link type="text/css" href="css/custom-theme/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
        <link type="text/css" href="css/custom-theme/jquery.ui.all.css" rel="stylesheet" />	
        <!--<link type="text/css" href="../css/estils.css" rel="stylesheet" />	-->
        <link type="text/css" href="css/form_reserves_grups.css" rel="stylesheet" />	
        <link type="text/css" href="css/form_reserves_grups_mob.css" rel="stylesheet" />	
        <link type="text/css" href="css/jquery.tooltip.css" rel="stylesheet" />	
        <link type="text/css" href="css/osx.css" rel="stylesheet" />
        <link type="text/css" href="css/glyphicons.css" rel="stylesheet" />

                        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>-->

        <?php echo Gestor::loadJQuery(); ?>

        <script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-ca.js"></script>
        <script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-es.js"></script>
        <script type="text/javascript" src="../taules/js/ui/dev/ui/i18n/jquery.ui.datepicker-en.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.metadata.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.timers.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.form.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.scrollTo.min.js"></script>
        <script type="text/javascript" src="js/json2.js"></script>
        <!-- ANULAT dynmenu.js -->
        <script type="text/javascript" src="js/jquery.amaga.js"></script>
        <script type="text/javascript" src="js/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../taules/js/jquery.browser.js"></script>


        <?php
        require('translate_grups_' . $gestor->lng . '.php');
        ?>
        <script type="text/javascript">
          var PERSONES_GRUP =<?php echo $PERSONES_GRUP; ?>;
          var lang = "<?php echo $lang; ?>";
<?php
//TRANSLATES

$llista_negra = llegir_dies(LLISTA_DIES_NEGRA);
$llista_nits_negra = llegir_dies(LLISTA_NITS_NEGRA);
$llista_blanca = llegir_dies(LLISTA_DIES_BLANCA);

print crea_llista_js($llista_negra, "LLISTA_NEGRA");
print "\n\n";
print crea_llista_js($llista_nits_negra, "LLISTA_NITS_NEGRA");
print "\n\n";
print crea_llista_js($llista_blanca, "LLISTA_BLANCA");
?>
        </script>

            <script type="text/javascript" src="js/jquery.simplemodal.js"></script>
        <script type="text/javascript" src="js/control_carta.js?<?php echo time(); ?>"></script>
        <script type="text/javascript" src="js/form_reserves_grups.js?<?php echo time(); ?>"></script>
        <script type="text/javascript" src="js/popups_ajuda.js<?php //echo '?'.time();   ?>"></script>		
 
    </head>
    <body style="display:none" class="<?php echo DEV ? " dev " : "";
echo LOCAL ? " local " : "" ?>">
        <table bgcolor="#F8F8F0" cellpadding="0" cellspacing="0"   border="0" align="center">
            <tr height="114">
                <td  id="poma-fons"  colspan="2" align="RIGHT"><a HREF="../index.htm">
                        <img src="../img/lg_sup.gif" width="303" height="114" border="0" title="INICI"></a>
                </td>
            </tr>
            <tr height="18">
                <td bgcolor="#570600" colspan="2" align="">
                    <table cellpadding="0" cellspacing="0" width="761" height="19" border="0">
                        <?php //require_once($ruta_lang."menu.php");?>
                    </table>
                </td>
            </tr>
            <tr height="18">
                <td id="td_contingut" bgcolor="#F8F8F0" colspan="2" align="">

                    <?php
                    if (isset($_POST['incidencia'])) {
                      if (!$gestor->contactar_grups($_POST))
                        l("ERROR_CONTACTAR");
                      else
                        l("CONTACTAR_OK");

                      //die();
                    }
                    else {
                      include("form_contactar.php");
                    }
                    ?>
                    <div style="clear:both"></div>

                    <!-- ***************************************************************************************   -->
                    <!-- ***************************************************************************************   -->
                    <!-- ***************************************************************************************   -->
                    <form id="form-reserves" action="../editar/reserves_grups.php" method="post" name="fr-reserves" accept-charset="UTF-8"><!---->
                        <div id="fr-reserves" class="fr-reserves">
                            <!-- *******************************  QUANTS SOU ********************************************************   -->
                            <!-- *******************************  QUANTS SOU ********************************************************   -->
                            <!-- *******************************  QUANTS SOU ********************************************************   -->

                            <h2 CLASS="titol"><?php l('Sol·licitud de reserva per a GRUPS'); ?><a href="info_reserves.html" id="info_reserves"><img src="css/info.png" title="<?php l("Informació de reserves"); ?>" style="width:16px;height:auto;margin-left:8px"/></a></h2>
                            <div class="fr-seccio ui-corner-all fr-seccio-quants"> 
                                <h1 class="titol"><span class="number">1</span><?php l('Quants sou?'); ?>
                                    <a href="#" id="info-quants" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>
                                </h1>


                                <h4><?php l('Adults (més de 14 anys)'); ?>:</h4>
                                <?php l('ADULTS_TECLAT'); ?>

                                <!-- ******  ADULTS  ********   -->
                                <div id="selectorComensals" class="fr-col-dere">
                                    <input type="text" id="com" name="adults" value="<?php echo $na ? $na : '' ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14) ?></label>	
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
                                    <!-- ******  INFO  ********   -->
                                    <div class="caixa dere ui-corner-all info-quants" style="float:right;"><?php l('INFO_QUANTS_SOU_GRUPS'); ?>
                                        <input id="totalComensals" type="text" name="totalComensals" value="<?php echo $total ?>" readonly="readonly" class="coberts"/></b>
                                        <!--Tingue's present que si vols modificar aquest nombre més endavant no podem garantir la disponibilitat de taula.<br/><br/>-->
                                    </div>
                                    <!-- ******  JUNIOR  ********   -->
                                    <h4  id="titol_SelectorJuniors"><?php l('Juniors (de 10 a 14 anys):'); ?></h4>
                                    <div id="selectorJuniors" class="col_dere">
                                        <input type="text" id="junior" name="nens10_14" value="<?php echo $nj ? $nj : '' ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14) ?></label>
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
                                        <input type="text" id="nens" name="nens4_9" value="<?php echo $nn ? $nn : '' ?>"  style="width:35px;font-size:1.2em;padding-left:0;padding-right:0" class="ui-button ui-widget ui-state-default ui-button-text-only coberts"/><label for="comGrupsN" ><?php //l('Més de ');//echo ($PERSONES_GRUP+14) ?></label>
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
                                    <div style="clear:both"></div>
                                </div>		
                            </div>		

                            <!-- *******************************  QUIN DIA ********************************************************   -->
                            <!-- *******************************  QUIN DIA ********************************************************   -->
                            <!-- *******************************  QUIN DIA ********************************************************   -->
                            <a id="scroll-seccio-dia"></a>
                            <div class="fr-seccio ui-corner-all fr-seccio-dia"> 
                                <h1 class="titol"><span class="number">2</span><?php l("Quin dia voleu venir?") ?>
                                    <a href="#" id="info-data" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>


                                </h1>
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

                            <!-- *******************************  QUINA HORA ********************************************************   -->
                            <!-- *******************************  QUINA HORA ********************************************************   -->
                            <!-- *******************************  QUINA HORA ********************************************************   -->
                            <a id="scroll-seccio-hora"></a>
                            <div class="fr-seccio ui-corner-all fr-seccio-hora" > 
                                <h1 class="titol"><span class="number">3</span><?php l('A quina hora?'); ?>
                                    <a href="#" id="info-hora" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

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
                            <a id="scroll-grups-seccio-carta"></a>
                            <div class="fr-seccio ui-corner-all grups-fr-seccio-carta "> 
                                <h1 class="titol"><span class="number">4</span><?php l('Escull els menús'); ?>
                                    <a href="#" id="info-comanda" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

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
                                                    <?php echo $comanda ?></td>
                                                <td class="menysX"></td><td class="Xborra"></td>
                                                <td class="carta-plat"><h3>	</h3></td>
                                                <td></td>
                                            </tr>
                                        </table>
                                        <!-- ******  BUTO CARTA  ********   -->
                                        <div class="ui-corner-all info info-comanda" style="float:left;">
                                            <?php l('INFO_COMANDA_GRUPS'); ?>
                                        </div>
                                    </div>

                                    <!-- ******  INFO  ********  
                                    <div class="ui-corner-all info">
                                    <?php l('INFO_CARTA'); ?>
                                    </div> 
                                    
                                  ******  BUTO CARTA  ********  --> 
                                    <a href="#" id="bt-no-carta" name="bt-no-carta" class="bt" ><?php l('Continuar'); ?></a>
                                                                <a href="#"  id="bt-carta" name="bt-carta" class="bt" ><?php l('Veure la carta'); ?></a>
                                    <a href="#"  id="bt-menu" name="bt-menu" class="bt"><?php l('Veure els menús'); ?></a>
                                    <div style="clear:both"></div>

                                </div>
                            </div>	



                            <!-- *******************************  CLIENT ********************************************************   -->
                            <!-- *******************************  CLIENT ********************************************************   -->
                            <!-- *******************************  CLIENT ********************************************************   -->
                            <a id="scroll-seccio-client"></a>
                            <div class="fr-seccio ui-corner-all fr-seccio-client"> 
                                <h1 class="titol"><span class="number">5</span><?php l('Donan´s algunes dades de contacte'); ?>
                                    <a href="#" id="info-legal" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

                                </h1>
                                <table id="dades-client" class="col_dere">
                                    <tr><td class="label" >* <em style="font-size:0.9em;"><?php l('Camps obligatoris'); ?></em>
                                            <div><label class="label" for="client_mobil"><?php l('Telèfon mòbil'); ?>*</label><input type="text" name="client_mobil" value="<?php echo $row['client_mobil'] ?>"/></div>
                                            <div><label class="label" for="client_telefon"><?php l('Ens vols deixar una altre telèfon?'); ?></label><input type="text" name="client_telefon" value="<?php echo $row['client_telefon'] ?>"/></div>
                                            <div><label class="label" for="client_email">Email*</label><input type="email" name="client_email" value="<?php echo $row['client_email'] ?>"/></div>
                                            <div><label class="label" for="client_nom"><?php l('Nom'); ?>*</label><input type="text" name="client_nom" value="<?php echo $row['client_nom'] ?>"/></div>
                                            <div><label class="label" for="client_cognoms"><?php l('Cognoms'); ?>*</label><input type="text" name="client_cognoms" value="<?php echo $row['client_cognoms'] ?>"/></div>
                                            <div><label class="label" for="client_id"><?php //l('Client_id'); ?></label><input type="hidden" name="client_id" value="<?php echo $row['client_id'] ?>"/></div>
                                            <div class="ui-corner-all info-legal info-observacions  caixa" style="width:496px;">
                                                <?php l('NO_COBERTS_OBSERVACIONS'); ?>
                                            </div>


                                            <div><label class="label" for=""><?php l('Observacions'); ?>
                                                    <a href="#" id="info-observacions" class="info-ico"><img src="css/info.png" title="<?php l('Ajuda'); ?>" style="width:16px;height:auto;margin-left:8px"/></a>

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
                            <div class="fr-seccio ui-corner-all fr-seccio-submit"> 
                                <h1 class="titol"><span class="number">6</span><?php l('Envia la sol·licitud'); ?></h1>
                                <div class="ui-corner-all caixa resum">
                                    <b><?php l('Resum reserva'); ?>:</b><br/><br/>
                                    <?php l('Data'); ?>: <b id="resum-data">-</b> | <?php l('Hora'); ?>: <b id="resum-hora">-</b><br/>
                                    <?php l('Adults'); ?>: <b id="resum-adults">-</b> | <?php l('Juniors'); ?>: <b id="resum-juniors">-</b> | <?php l('Nens'); ?>: <b id="resum-nens">-</b> | <?php l('Cotxets'); ?>: <b id="resum-cotxets">-</b><br/>
                                    <!--<?php l('Resum menús'); ?>: <b id="resum-comanda"><?php l('Sense');
                                    echo " ";
                                    l('menú'); ?> </b>  -->
                                    <?php l('Comanda'); ?>: <b id="resum-comanda"><?php l('Sense'); ?> </b> <?php l('plats'); ?> (<b id="resum-preu"></b> €)
                                </div>
                                <div class="ui-corner-all info-submit caixa dere">
<?php l('INFO_NO_CONFIRMADA'); ?>:

                                </div>
                                <button id="submit"><?php l('Sol·licitar reserva'); ?></button>

                                <div style="clear:both"></div>
                                <div id="error_validate" class="ui-helper-hidden"><?php l("Hi ha errors al formulari. Revisa les dades, si us plau"); ?></div>
                            </div>

                        </div>

                    </form>	<!--
                                                
                    -->
                    <!--	
                    <div id="peu" style="margin-top:50px;	text-align:center;padding:15px;background:#FFFFFF" ><b>Restaurant CAN BORRELL:</b> <span class="dins cb-contacte" style="text-align:right">93 692 97 23 / 93 691 06 05 </span>  /  <a href="mailto:<?php echo MAIL_RESTAURANT; ?>" class="dins"><?php echo MAIL_RESTAURANT; ?></a>
                    </div>
                    -->	
                    <div id="peu" style="margin-top:50px;	text-align:center;padding:15px;background:#FFFFFF" ><b>Restaurant CAN BORRELL:</b> <button class="dins cb-contacte" style="text-align:right">Contactar amb el restaurant </button>  /  <a href="mailto:<?php echo MAIL_RESTAURANT; ?>" target="_blank" class="dins"><?php echo MAIL_RESTAURANT; ?></a>
                    </div>

                </td>
            </tr>
        </table>



        <!-- ******************* CARTA *********************** -->
        <!-- ******************* CARTA *********************** -->
        <!-- ******************* CARTA *********************** 
        <div id="fr-cartaw-popup" title="<?php l("La nostra carta") ?>" class="carta-menu" style="height:300px">
        <div id="fr-carta-tabs" >
<?php //echo $gestor->recuperaCarta($row['id_reserva']) ?>
        </div>	
        </div>	-->
        <!-- ******************* CARTA-MENU *********************** -->
        <!-- ******************* CARTA-MENU *********************** -->
        <!-- ******************* CARTA-MENU *********************** -->
        <div id="fr-menu-popup" title="<?php l("Els nostres menús") ?>" class="carta-menu">
            <div id="fr-menu-tabs" >
<?php echo $gestor->recuperaCarta($row['id_reserva'], true) ?>
                <h3 id="carta-total"></h3>
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
<?php include("reservesInfo_" . substr($lang, 0, 2) . ".html"); ?>
        </div>


    </body>
</html>