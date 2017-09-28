<?php
if (!headers_sent())
  header('Content-Type: text/html; charset=UTF-8');

require_once("gestor_reserves.php");
if (!isset($_SESSION))
  session_start();
$gestor = new gestor_reserves();

if (isset($_REQUEST['id'])) {
  $id = $_REQUEST['id'];
  if (!$gestor->valida_sessio())
    header("Location: index.php");
  $row_reserva = $gestor->load_reserva($id);

  $class = " updata_res";
  $nomhora = "uhora";
  $editFormAction = "gestor_reserves.php?a=update_reserva&p=" . $id;

  if (isset($_REQUEST['permuta']) && $_REQUEST['permuta']) {
    $permuta = $_REQUEST['permuta'];
    $row_permuta = $gestor->load_taula_permuta($permuta);
    $row_reserva['estat_taula_taula_id'] = $row_permuta['estat_taula_taula_id'];
    $row_reserva['estat_taula_nom'] = $row_permuta['estat_taula_nom'];
    $row_reserva['estat_taula_persones'] = $row_permuta['estat_taula_persones'];
    $row_reserva['estat_taula_cotxets'] = $row_permuta['estat_taula_cotxets'];
    $row_reserva['estat_taula_plena'] = $row_permuta['estat_taula_plena'];
    $row_reserva['data'] = $_SESSION['data'];
    
    $persones = $row_reserva['adults'] + $row_reserva['nens4_9'] + $row_reserva['nens10_14'];
    if($persones > $row_reserva['estat_taula_persones'] ||
        ($persones < $row_reserva['estat_taula_persones'] && $row_reserva['estat_taula_plena'] ) ||
$row_reserva['cotxets'] > $row_reserva['estat_taula_cotxets']) {
      echo "<h1>El nombre de persones / cotxets no coincideix</h1>";
      die();
    }
    
    $editFormAction = "gestor_reserves.php?a=permuta_reserva&p=" . $id;
  }
  else {
    $permuta = false;
    $gestor->canvi_data($row_reserva['data']);
  }

  //dprint_r($row_reserva);die();
    if ($row_reserva['estat']!=100){
        echo '<br><br><h1>Aquesta reserva no està activa. 
        <br>
        Possiblement està en procés de pagament.
        <br>
        Esperi o corregeixi primer l\'estat de la reserva</h1>';
        die();
    }
}
else {
  $permuta = false;
  $id = 0;
  $nomhora = "hora";
  $class = "inserta_res";
  $editFormAction = "gestor_reserves.php?a=inserta_reserva";

  $row_reserva['id_reserva'] = null;
  $row_reserva['idr'] = null;
  $row_reserva['adults'] = null;
  $row_reserva['nens10_14'] = null;
  $row_reserva['nens4_9'] = null;
  $row_reserva['reserva_info'] = null;
  $row_reserva['cotxets'] = null;
  $row_reserva['comanda'] = null;
  $row_reserva['client_telefon'] = null;
  $row_reserva['client_mobil'] = null;
  $row_reserva['client_email'] = null;
  $row_reserva['client_nom'] = null;
  $row_reserva['client_cognoms'] = null;
  $row_reserva['client_id'] = null;
  $row_reserva['data'] = null;
  $row_reserva['hora'] = null;
  $row_reserva['observacions'] = null;
  $row_reserva['estat_taula_taula_id'] = null;
  $row_reserva['estat_taula_nom'] = null;
  $row_reserva['estat_taula_persones'] = null;
  $row_reserva['estat_taula_cotxets'] = null;
  $row_reserva['estat_taula_plena'] = null;
  $row_reserva['resposta'] = null;

  $row_client['client_id'] = null;
  $row_client['client_mobil'] = null;
  $row_client['client_telefon'] = null;
  $row_client['client_cognoms'] = null;
  $row_client['client_nom'] = null;
  $row_client['client_dni'] = null;
  $row_client['client_adresa'] = null;
  $row_client['client_localitat'] = null;
  $row_client['client_cp'] = null;
  $row_client['client_email'] = null;
  $row_client['client_conflictes'] = null;
  //$row['']=null;

  $comanda = null;
}
  
//echo $_SESSION['admin_id'];die();
?><form class="form_edit <?php echo $class; ?>" method="post" name="frmEditReserva" action="<?php echo $editFormAction; ?>" >
    <div class="missatge_dia"></div>
      <?php //echo  $_SESSION['admin_id']; ?>
    <div id="frm_edit_modal_<?php echo $class; ?>" class="centrat" >
        
        <!-- UPLOAD -->

        <table align="center">
            <tr  class="amagat">
                <td nowrap="nowrap" align="right">id_reserva:</td>
                <td nowrap="nowrap" align="left">
                    <!-- UPLOAD -->
                    <input type="hidden" readonly="readonly" name="id_reserva" value="<?php echo $row_reserva['id_reserva'] ?>" size="32"  />
                    <input type="hidden" readonly="readonly" name="reserva_info" value="<?php echo $row_reserva['reserva_info'] ?>" size="32"  />
                    <input type="hidden" readonly="readonly" name="editor_id" value="<?php echo $usr = $_SESSION['uSer']->id; ?>" size="32"  />
                 
<?php    echo $row_reserva['id_reserva'] ?>
                </td>
            </tr>



<?php if ($id && $permuta) { ?>
              <tr  >
                  <td nowrap="nowrap" align="right">Acció:</td>
                  <td nowrap="nowrap" align="left">
                      <!-- UPLOAD -->
                      <div id="extendre">
                          <input type="radio" id="moure" name="extendre" value="0" checked="checked" /><label for="moure">MOURE de taula a taula</label>
                          <input type="radio" id="exten" name="extendre" value="1"  /><label for="exten">EXTENDRE agrupant les taules</label>
                      </div>
                  </td>
              </tr>
<?php } ?>



            <tr >
                <td nowrap="nowrap" align="right">Client:<br/><a href="#"  class="ui-state-default ui-corner-all nouClient amagat" style="padding:2px;" >Nou Client</a></td>
                <td align="left" class="combo_clients_container">
<?php if ($id) { ?>
                      <input id="autoc_client_<?php echo trim($class) ?>" value="<?php echo $gestor->concatena($row_reserva['client_cognoms'], $row_reserva['client_nom'] . " (" . $row_reserva['client_mobil'] . ")", ", ") ?>" name="client_non_cognom" title="Tecleja les primeres lletres del nom / cognom / mòbil" readonly="readonly" /> 
                      <input id="autoc_id_client_<?php echo trim($class) ?>" type="hidden" name="client_id" value="<?php echo $row_reserva['client_id'] ?>" class="autoc_id_client required" />
<?php } ?>
                    <!-- <div class="dades_client" class="amagat">-->
                    <!-- </div>-->
<?php if (!$id) { ?>
                      <div id="campsClient" >
                      <?php require("camps_client.php"); ?>

                      </div>
<?php } ?>

                </td>
            </tr>	  


            <tr >
                <td nowrap="nowrap" align="right">data:</td>
                <td align="left">
<?php if (!$id) { ?>
                      <input type="checkbox" id="confirma_data_<?php echo trim($class); ?>" name="confirma_data"/><label for="confirma_data_<?php echo trim($class); ?>" class="confirma-data required" title="Marca'l per confirmar la data">Confirma</label>
                    <?php } ?>

                    <span class="data-llarga ui-corner-all" style="margin-right:25px">
<?php
//echo "..........".LOCAL;
//if (LOCAL) setlocale(LC_TIME, 'catalan'); // utilitza aquest sobre windows
//else setlocale(LC_TIME, 'ca_ES.UTF-8');
setlocale(LC_TIME, 'ca_ES', 'Catalan_Spain', 'Catalan');
$d = strftime("%A %d de %B de %Y", strtotime($row_reserva['data']));
//echo utf8_encode($d);
echo $d;
?>
                    </span>
                        <?php if ($id) echo ' Idr:<span id="spanidr" class="data-llarga ui-corner-all" style="margin-left:5px;font-size:0.7em">' . $row_reserva['id_reserva'] . '</span>'; ?>
                    <input type="hidden" name="data" value="<?php out($gestor->cambiaf_a_normal($row_reserva['data'])) ?>" size="10" tabindex="-1" class="required"  title="Selecciona una data" readonly="readonly"/>
                    <?php
                    if ($id && $row_reserva['data'] <= date("Y-m-d")) {
                      $chek = ($row_reserva['reserva_info'] & 32) ? 'checked="checked" ' : '';
                      ?>

                      <input type="checkbox" id="reserva_entrada_<?php echo trim($class); ?>" name="reserva_entrada" <?php echo $chek; ?> value="<?php echo $row_reserva['reserva_info'] ?>" />
                      <label id="label_reserva_entrada" for="reserva_entrada_<?php echo trim($class); ?>" class="confirma-data " title="Els comensals ja són a la taula">Els comensals ja són a la taula</label>
                    <?php } ?>




                </td>
            </tr>
              <tr class="fila-fina" >
                  <td nowrap="nowrap" align="right">
                      hora:
                  </td>
                  <td class="tira_hores" nowrap="nowrap" align="left">

                      <div id="<?php echo trim($class); ?>_radio" class="radio_hores">
                          <?php
                          $horaTorn = $row_reserva['hora'];
                          $persones = $row_reserva['adults'] + $row_reserva['nens10_14'] + $row_reserva['nens4_9'];
                          $cotxets = $row_reserva['cotxets'];

                          if ($_SESSION['torn'] != $gestor->torn($_SESSION['data'], $row_reserva['hora']))
                            $horaTorn = "";
                          if (isset($_REQUEST['hora']))
                            $horaTorn = $_REQUEST['hora'];
                         
                          if ($id) {
                            $json = $gestor->recupera_hores($id);
                            $hores = json_decode($json);
                            echo $hores->dinar;
                            echo $hores->dinarT2;
                            echo $hores->sopar;
                          }
                          ?>
                      </div>



                  </td>
              </tr>
              <tr  class="fila-fina"  >
                  <td nowrap="nowrap" align="right">taula:</td>
                  <td align="left">
                      <input type="text" name="estat_taula_taula_id" tabindex="-1" value="<?php echo $row_reserva['estat_taula_taula_id']; ?>" size="3" <?php if ($id) echo 'readonly="readonly"' ?> class="borderojo taulaid required" title=""/>

                      <input type="text" name="estat_taula_taula_nom" tabindex="-1"  value="<?php echo $row_reserva['estat_taula_nom']; ?>" size="3" <?php if ($id || true) echo 'readonly="readonly"' ?> class="borderojo taulanom" title=""/>
                      <em>(Places: <span class="places"><?php echo $row_reserva['estat_taula_persones']; ?></span> | Cotxets: <span class="cotxets"><?php echo $row_reserva['estat_taula_cotxets']; ?></span> | Plena: <span class="plena"><?php echo $row_reserva['estat_taula_plena']; ?></span>)</em>
                  </td>


              <tr  >
                  <td nowrap="nowrap" align="right">
                      adults:
                  </td>
                  <td nowrap="nowrap" align="left">
                      <input type="text" name="adults" value="<?php echo $row_reserva['adults']; ?>" class="required" size="3"  title="" persones=""/>		
                      <?php if (!$id) { ?>
                        <div id="selectorAdults">&lArr;
                            <input type="radio" id="ad1" name="selectorNens4_9" value="1"  /><label for="ad1">1</label>
                            <input type="radio" id="ad2" name="selectorNens4_9" value="2"  /><label for="ad2">2</label>
                            <input type="radio" id="ad3" name="selectorNens4_9" value="3"  /><label for="ad3">3</label>
                            <input type="radio" id="ad4" name="selectorNens4_9" value="4"  /><label for="ad4" >4</label>
                            <input type="radio" id="ad5" name="selectorNens4_9" value="5"  /><label for="ad5" >5</label>
                            <input type="radio" id="ad6" name="selectorNens4_9" value="6"  /><label for="ad6">6</label>
                            <input type="radio" id="ad7" name="selectorNens4_9" value="7"  /><label for="ad7">7</label>
                            <input type="radio" id="ad8" name="selectorNens4_9" value="8"  /><label for="ad8">8</label>
                            <input type="radio" id="ad9" name="selectorNens4_9" value="9"  /><label for="ad9" >9</label>
                            <input type="radio" id="ad10" name="selectorNens4_9" value="10"  /><label for="ad10" >10</label>
                            <input type="radio" id="ad11" name="selectorNens4_9" value="11"  /><label for="ad11">11</label>
                            <input type="radio" id="ad12" name="selectorNens4_9" value="12"  /><label for="ad12">12</label>
                            <input type="radio" id="ad13" name="selectorNens4_9" value="13"  /><label for="ad13">13</label>
                            <input type="radio" id="ad14" name="selectorNens4_9" value="14"  /><label for="ad14" >14</label>
                            <input type="radio" id="ad15" name="selectorNens4_9" value="15"  /><label for="ad15" >15</label>
                            <input type="radio" id="ad16" name="selectorNens4_9" value="16"  /><label for="ad16">16</label>
                            <input type="radio" id="ad17" name="selectorNens4_9" value="17"  /><label for="ad17">17</label>
                            <input type="radio" id="ad18" name="selectorNens4_9" value="18"  /><label for="ad18">18</label>
                            <input type="radio" id="ad19" name="selectorNens4_9" value="19"  /><label for="ad19" >19</label>
                            <input type="radio" id="ad20" name="selectorNens4_9" value="20"  /><label for="ad20" >20</label>
                        </div>
                      <?php } ?>

                  </td>
              </tr>

              <tr  class="fila-fina"  >
                  <td nowrap="nowrap" align="right">
                      Junior:
                  </td>
                  <td nowrap="nowrap" align="left">
                          <input type="text" name="nens10_14" value="<?php echo $row_reserva['nens10_14']; ?>" size="3" persones=""/>
                      <?php if (!$id) { ?>
                        <div id="selectorNens10_14">&lArr;
                            <input type="radio" id="sn41" name="selectorNens10_14" value="1"  /><label for="sn41">1</label>
                            <input type="radio" id="sn42" name="selectorNens10_14" value="2"  /><label for="sn42">2</label>
                            <input type="radio" id="sn43" name="selectorNens10_14" value="3"  /><label for="sn43">3</label>
                            <input type="radio" id="sn44" name="selectorNens10_14" value="4"  /><label for="sn44" >4</label>
                            <input type="radio" id="sn45" name="selectorNens10_14" value="5"  /><label for="sn45" >5</label>
                            <input type="radio" id="sn46" name="selectorNens10_14" value="6"  /><label for="sn46" >6</label>			
                        </div>
                      <?php } ?>
                  </td>
              </tr>

              <tr   class="fila-fina" >
                  <td nowrap="nowrap" align="right">
                      Infantil:
                  </td>
                  <td nowrap="nowrap" align="left">

                      <input type="text" name="nens4_9" value="<?php echo $row_reserva['nens4_9']; ?>" size="3" persones=""/>
                      <?php if (!$id) { ?>
                        <div id="selectorNens4_9">&lArr;
                            <input type="radio" id="sn101" name="selectorNens4_9" value="1"  /><label for="sn101">1</label>
                            <input type="radio" id="sn102" name="selectorNens4_9" value="2"  /><label for="sn102">2</label>
                            <input type="radio" id="sn103" name="selectorNens4_9" value="3"  /><label for="sn103">3</label>
                            <input type="radio" id="sn104" name="selectorNens4_9" value="4"  /><label for="sn104" >4</label>
                            <input type="radio" id="sn105" name="selectorNens4_9" value="5"  /><label for="sn105" >5</label>
                            <input type="radio" id="sn106" name="selectorNens4_9" value="6"  /><label for="sn106" >6</label>			
                        </div>
                      <?php } ?>

                  </td>
              </tr>



              <tr   class="fila-fina" >
                  <td nowrap="nowrap" align="right" class="red">
                      Total adults + nens:
                  </td>
                  <td align="left">
                      <em> 
                          <input type="text" tabindex="-1" name="total" value="<?php echo $row_reserva['adults'] + $row_reserva['nens4_9'] + $row_reserva['nens10_14']; ?>" size="3"  readonly="readonly" />
                      </em>


                  </td>
              </tr>

              <tr  >
                  <td nowrap="nowrap" align="right">
                      cotxets:
                  </td>
                  <!-- -->
                  <!-- -->
                  <!-- -->
                  <!-- -->
                  <!-- -->
                  <td nowrap="nowrap" align="left" >
                      <span class="nens" style="float:left"> 
                          <input type="text" name="cotxets" value="<?php echo $row_reserva['cotxets']; ?>"  size="2" />
                      </span> 
                      <div id="selectorCotxets" class="col_dere" style="font-size:0.8em;margin-top:0px;">
                          <?php
                          $estat = $gestor->decodeInfo($row_reserva['reserva_info']);
                          $chek0 = ($estat['ampla'] == 0 ? 'checked="checked"' : '');
                          $chek11 = ($estat['ampla'] == 2 ? 'checked="checked"' : '');
                          $chek12 = ($estat['ampla'] == 3 ? 'checked="checked"' : '');
                          ?>

                          <input type="radio" id="cotxets0<?php echo $nomhora ?>" name="amplaCotxets" value="0"  <?php echo $chek0 ?>/><label for="cotxets0<?php echo $nomhora ?>"><?php echo("Normal"); ?></label>
                          <input type="radio" id="cotxets2A<?php echo $nomhora ?>" name="amplaCotxets" value="2"  <?php echo $chek11 ?>/><label for="cotxets2A<?php echo $nomhora ?>"><?php echo("Ample"); ?></label>
                          <input type="radio" id="cotxets2L<?php echo $nomhora ?>" name="amplaCotxets" value="3"  <?php echo $chek12 ?>/><label for="cotxets2L<?php echo $nomhora ?>"><?php echo("Llarg"); ?></label>

                      </div>

                      <!-- ******  COTXETS  ********   -->
              <tr>
                  <td nowrap="nowrap" align="right">
                      Cadira de rodes:
                  </td>
                  <td align="left" style="font-size:0.8em;">
                      <div id="selectorCadiraRodes" class="">
                          <?php
                          //$estat=$gestor->decodeInfo($row_reserva['reserva_info']);
                          $chek0 = ($estat['cadiraRodes'] == 0 ? '' : 'checked="checked"');
                          $chek1 = ($estat['accesible'] == 0 ? '' : 'checked="checked"');
                          ?>
                          <input type="checkbox" id="accesible<?php echo $nomhora ?>" name="selectorAccesible" value="on"  <?php echo $chek1 ?> /><label for="accesible<?php echo $nomhora ?>"><?php echo("Algú amb movilitat reduïda"); ?></label>
                          <input type="checkbox" id="cadira0<?php echo $nomhora ?>" name="selectorCadiraRodes" value="on"  <?php echo $chek0 ?> /><label for="cadira0<?php echo $nomhora ?>"><?php echo("Porten una cadira de rodes"); ?></label>
                      </div>
                  </td>
              </tr>
              <!--  -->


              <!-- -->
              <!-- -->
              <!-- -->
              <!-- -->
              <!-- -->
              <!-- -->
              <!-- -->




              </td>
              </tr>
              <tr >
                  <td nowrap="nowrap" align="right">observacions:</td>
                  <td align="left"><input type="text" name="observacions" value="<?php echo ($row_reserva['observacions']); ?>" size="50" /></td>
              </tr>

              <?php if (!empty($row_reserva['resposta'])): ?>

                <tr >
                    <td nowrap="nowrap" align="right">Paga i senyal:</td>
                    <td align="left"><input type="text" name="Resposta" readonly="readonly" value="<?php echo ($row_reserva['resposta']); ?>" size="50" /></td>
                </tr>
              <?php endif; ?>

              <?php
              $subject = "Restaurant Can Borrell - Reserves id:" . $row_reserva['id_reserva'];
              $body = "Reserva ID:" . $row_reserva['id_reserva'] . '%0D%0A'; //
              $body.=" - " . $row_reserva['data'] . '%0D%0A'; //
              $body.=" - " . $row_reserva['hora'] . '%0D%0A'; //
              $body.='%0D%0A -----------------------------------------------------              %0D%0A'; //
              $body.=$row_reserva['observacions'] . '%0D%0A'; //
              $body.='%0D%0A'; //
              $querystring = $row_reserva['client_email'] . "?subject=$subject&amp;body=$body&amp;";

              if ($id) {
                ?>

                <tr >
                    <td nowrap="nowrap" align="right">Email:</td>

                    <td align="left">
                        <a href="mailto:<?php echo $querystring; ?>"><?php echo ($row_reserva['client_email']); ?></a>
                    </td>
                </tr>

  <?php } ?>

              <tr >
                  <td nowrap="nowrap" align="right"></td>

                  <td align="left"  style="">
                      <label id="label-pastis" for="<?php echo trim($class) ?>RESERVA_PASTIS" >PASTIS </label> <!---->
  <?php
  $pastis = (isset($row_reserva['reserva_pastis']) ? $row_reserva['reserva_pastis'] : FALSE);
  $row_reserva['reserva_pastis'] = $pastis;
  ?>
                      <input type="checkbox" id="<?php echo trim($class) ?>RESERVA_PASTIS" name="RESERVA_PASTIS" value="on" <?php echo $row_reserva['reserva_pastis'] ? 'checked="checked"' : "" ?>/>
                      <?php
                      $pastis_info = $pastis ? $row_reserva['reserva_info_pastis'] : '';
                      ?>
                      <input id="INFO_PASTIS" name="INFO_PASTIS" class="pastis_toggle" value="<?php echo $pastis_info ?>"/>
                  </td>
              </tr>


              <?php if ($id) { ?>
                <tr  >
                    <td nowrap="nowrap" align="right">Comanda:</td>
                    <td align="left" class="ui-corner-all info-comanda" style="">

                        <?php echo $gestor->plats_comanda($row_reserva['id_reserva']); ?>

                    </td>
                </tr>	  
              <?php } ?>

              <tr   class="amagat">
                  <td nowrap="nowrap" align="right">resposta:</td>
                  <td align="left"><input type="text" name="resposta" value="<?php echo $row_reserva['resposta']; ?>" size="50" /></td>
              </tr>	  
          </table>
      </div>


      <?php if ($id) { ?>
        <?php $data = ($gestor->cambiaf_a_normal($row_reserva['data']));
        $hora = $row_reserva['hora']; ?>

        <a class="sms ui-state-default ui-corner-all" href="#">SMS</a>
        <div   class="form_sms" >LlistatSMS enviats:
            <div id="llista_sms" class="llista-sms" > <?php out($gestor->llistaSMS($row_reserva['id_reserva'])) ?></div>

            <textarea id="sms_mensa">Recuerde: reserva en Restaurant Can Borrell el d&iacute;a <?php echo $data; ?> a las <?php echo $hora; ?>. Rogamos comunique cualquier cambio: 936929723 - 936910605. Gracias </textarea>
            <div class="ui-state-default ui-corner-all" style="width:100px;float:right;">	
                <a id="enviaSMS" href="gestor_reserves.php?a=enviaSMS">Envia</a>
            </div>

        </div>
        <div class="cb_sms <?php if ($_SESSION['permisos'] < 64) echo 'amagat' ?>">Envia automàticament un SMS amb les modificacions <input type="checkbox" name="cb_sms" value="cb_sms" title="Envia automàticament un SMS amb les modificacions" checked="checked" /></div>


      <?php }else { ?>
        <div  class="cb_sms <?php if ($_SESSION['permisos'] < 64) echo "amagat"; ?>">
            Envia SMS:<input type="checkbox" name="cb_sms" value="cb_sms" title="Envia automàticament un SMS amb les dades de la reserva" checked="checked"/>
            <br/>
            <em>
                Si vols editar el text del SMS, no marquis la casella. Guarda la reserva i edita-la.</em>
        </div>	  
      <?php } ?>




    <input name="<?php echo ($id ? 'MM_update' : 'MM_insert'); ?>" type= "hidden" value="<?php echo ($id ? 'edit_reserva' : 'insert_reserva'); ?>" />
    <!--<input id="submit" name="submit" type="submit" value="Guardar Canvis"/>-->	
</form>

<?php
if ($id && !$permuta) {
  //if (LOCAL) setlocale(LC_ALL, 'catalan');
  //else setlocale(LC_ALL, 'ca_ES.UTF-8');
  setlocale(LC_TIME, 'ca_ES', 'Catalan_Spain', 'Catalan');
  $creada =  strftime("%A %d de %B de %Y a les %H:%M:%S", strtotime($row_reserva['data_creacio']));
  $creada_por = $gestor->cadenaClient($row_reserva['usuari_creacio']);
  //$creada_por=$row_reserva['usuari_creacio'];
  $modificada = strftime("%A %d de %B de %Y a les %H:%M:%S", strtotime($row_reserva['estat_taules_timestamp']));
  $modificada_por = $gestor->cadenaClient($row_reserva['estat_taula_usuari_modificacio']);

  $o = '<div id="info-reserva">';
  $o.="Reserva creada el <b style='color:red'>$creada</b> per <b style='color:red'>$creada_por</b><br/>";
  if ($creada != $modificada)
    $o.= "Modificada el <b style='color:red'>$modificada</b> per <b style='color:red'>$modificada_por</b>";
  $o.= '</div>';

  //echo utf8_encode($o);
  echo $o;
}
?>





