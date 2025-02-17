<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;

$translate['EDIT_RESERVA_FORA_DE_SERVEI']='<p style="color:red">Aquest servei està temporalment fora de servei. Per cancel·lar o notificar qualsevol modificació a la teva reserva truca, si us plau, al<p>
<b>93 692 97 23</b>
<br/>
<b>93 691 06 05</b>
<p>Gracies</p>
';

//MENU
	$translate['CAN BORRELL']='CAN BORRELL';
                            
	$translate['FOTOS-VIDEO']='FOTOS-VÍDEO';

	$translate['CARTA i MENU']='CARTA i MENÚ';

	$translate['ON SOM: MAPA']='ON SÓM: MAPA';

	$translate['EXCURSIONS']='EXCURSIONS';

	$translate['HISTÒRIA']='HISTÒRIA';

	$translate['HORARI']='HORARI';

	$translate['RESERVES']='RESERVES';

	$translate['CONTACTAR']='CONTACTAR';

//FORM
	
	$translate['NO_COBERTS_OBSERVACIONS']='<b>Només tindrem en compte els coberts/cotxets indicats a la primera secció</b>. <span style="color:red">Els canvis en el nombre de coberts o cotxets sol·licitats a les observacions seran ignorats</span>.<br/>El restaurant no pot garantir la disponibilitat de trones. Un cop al restaurant demaneu-les al personal i us la facilitarem si és possible';
	
	$translate['ERROR_LOAD_RESERVA']='<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">No hem trobat la reserva o ja no és possible modificar-la per ser una data massa propera</div>';

	$translate['ERROR_CONTACTAR']='<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum " style="color:red">Dades incorrectes. No es pot enviar el missatge</div>';

	$translate['CONTACTAR_OK']='<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum " style="color:green">Missatge enviat. </div>';

$translate['[Contactar amb el restaurant]']="Contactar amb el restaurant";

$translate['[Cancel·lar/modificar una reserva existent]'] = 'Cancel·lar/modificar una reserva existent';

	
	$translate['INCIDENCIA_ONLINE']="Tens alguna incidència que no pots solucionar des d'aquest formulari. Descriu breument el teu cas i t'atendrem (via email) tan aviat com poguem";
	
$translate['INCIDENCIA_ONLINE_GRUPS']="Descriu les modificacions que <b>sol·licites</b> per a la teva reserva<br/><br/>Recorda que les modificacions <b>NO TENEN CAP VALIDESA</b> si no reps la confirmació per part del restaurant:";
	
$translate['INFO_NO_EDITAR_GRUPS']="<h3>No és possible editar reserves de GRUP online.</h3><br/><br/> Utilitza aquest formulari de contacte per comunicar-nos els canvis que vulguis fer i et respondrem tan aviat com ens sigui possible.<br/><br/>Gràcies.";
	
	
$translate['INFO_CONTACTE']="Si tens una reserva feta, indica'ns l'ID";
	
$translate['INFO_COMANDA']="Pots escollir diferents menús o diferents plats de la carta, però <b>no pots barrejar menús amb plats de la carta.</b><br/>";
	
	
	$translate['Grups']='Sol·licitud de reserva per Grups';
	$translate['Reserva per grups']='Reserva per a grups';
	
	$translate['Modificar']='Modificar';
	
	$translate['Sol·licitud de reserva']='Sol·licitud de reserva';
	$translate['Nens (de 4 a 9 anys)']="Nens menors de 9 anys <b>sense cotxet</b>";
	$translate['Adults']="Adults (més de 14 anys):";
  $translate['ADULTS_TECLAT']='<span class="gris-ajuda">&#8625;Pots teclejar el número si no apareix un botó amb el valor adequat</span>';
	
	$translate['Cotxets de nadó']="Nens en cotxet de nadó <br/><em style='font-size:0.8em;'>(Malauradament només disposem d'espai per un cotxet per taula)</em>. <br/><b style='font-size:0.8em'>El nen ocuparà el cotxet i no una cadira/trona</b>";

	
	$translate['INFO_QUANTS_SOU']='<b>Digue\'ns quantes persones vindreu</b>, indicant, en primer lloc els majors de 14 anys seguit de nens fins a 14. 
			<br/><br/>
                        <div class="info-paga-i-senyal" style="display:none"><b>Si sou més de '.(persones_paga_i_senyal-1).' persones, 
                            caldrà que realitzeu una paga i senyal de '.import_paga_i_senyal.'€ amb targeta de crèdit</b>.
                              Aquest import se us descomptarà del preu final de les consumicions, de manera que no representarà cap despresa extra.
                                El pagament es realitzarà a través d\'una passarel·la bancària segura. Can Borrell no tindrà accés a les dades introduïdes. 
             </div>
                        <br/><br/>
			<b>Reservarem espai pels comensals que ens indiquis aquí. La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat</b>
			<br/><br/>
			
			<b>(NO PODEM GARANTIR LA DISPONIBILITAT DE TRONES).</b> 
					<br/><br/>
			Només permetem l\'entrada de gossos pigall acompanyant invidents i mascotes de fins a 8kg<br/><br/>
					<em>Si, en total, sou més de <b>'.($PERSONES_GRUP-1).'</b> persones, marca el botó "Grups"</em><br/><br/>
					<b>TOTAL PERSONES/COTXETS:';

        
        
	$translate['ALERTA_GRUPS']='<b>Has indicat més de <span style="font-size:1.2em"><?php echo $PERSONES_GRUP-1?></span> persones en total.</b><br/><br/> Cal que omplis el formulari de Grups o redueixis el nombre de comensals.<br/><br/> Si vols anar al formulari de Grups prem "Reserva per grups". Si vols reduïr el nombre de comensals prem "Modificar"';

	
	$translate['LLEI']='					En compliment de la Llei Orgànica 15/1999 del 13 de desembre, de Protecció de Dades de Caràcter Personal (LOPD), us informem que les dades personals obtingudes com a resultat d\'emplenar aquest formulari, rebran un tractament estrictament confidencial per part del Resturant Masia Can Borrell.
 
Podeu exercir els vostres drets d\'accés, rectificació, cancel·lació i oposició al tractament de les vostres dades personals, en els termes i condicions que preveu la LOPD mitjançant l\'adreça de correu: '.MAIL_RESTAURANT;


	$translate['INFO_NO_CONFIRMADA']='<b>Recorda</b>: La reserva <b>NO QUEDA CONFIRMADA</b> fins que rebis un SMS al mòbil que ens has facilitat o un email a l\'adreça que ens has indicat.';

	
	$translate['INFO_CARTA']='Si ho desitges pots triar els plats que demanareu per tenir una idea del preu, evitar que us trobeu algun plat exhaurit i accelerar el servei quan vingueu al restaurant.<br/><br/><b>Aquesta selecció no et compromet en absolut</b>.<br/><br/> Un cop al restaurant podràs modificar o anul·lar la comanda i, en qualsevol cas, us cobrarem únicament els plats i beugudes que us servim.';

        
	$translate['PREU']='Preu (IVA inclòs)';
	
	$translate['INFO_HORES']='<b>Recorda</b>: Només apareixen les hores per les que hem trobat taula disponible pel nombre de persones que has demanat.<br/>';
	
	$translate['INFO_DATA']='<b>Indica la data</b>.<br/><br/>
					Assegura\'t de posar la data correcta canviant el mes, si és necessari, amb les fletxetes de la part superior del calendari<br/><br/>
					Recorda que, tret d\'alguns festius, el restaurant resta tancat els dilluns i dimarts<br/><br/>
					Si un dia està desactivat pot ser que no quedin taules lliures.<br/><br/>';
	
	$translate['ALERTA_INFO_INICIAL_GRUPS']='<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> 
                              Aquest formulari permet <b>SOL·LICITAR</b> una reserva que el restaurant haurà de CONFIRMAR o DENEGAR. </p>
                              <p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span>
                              Al final del procés us demanarem les dades d\'una targeta bancària que <b>NOMÉS seran utilitzades en cas de no compareixènça</b> el dia de la reserva. No es farà cap càrrec i les dades serà gestionades per l\'entitat bancària. El restaurant no té accés a les dades de la targeta, i <b>no realitzarà cap càrrec</b>.  
			</p>
                                                                                    <p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  
<b>Cap sol·licitud de reserva tindrà validesa si no s\'han facilitat les dades de la targeta</b> abans de la data que us indicarem.</p>';
$translate['google_maps']='<div class="alert alert-danger"><span class=" glyphicon glyphicon-exclamation-sign f1" style="color:red"></span> <b>ATENCIÓ:</b> <br/>Les indicacions que proporciona <b>Google maps són errònies</b>. Per arribar al restaurant seguiu <a href="https://www.google.com/maps/d/viewer?mid=1hCH2vgWQlsAYjkur26vrCBkHs_o&hl=ca&ll=41.46209031620546%2C2.1290506341933906&z=14" target="_blank" style="color:red;font-weight:bold;">aquest mapa</a> fins a l\'inici de la pista forestal.</div>';
$translate['google_maps']='';
                            $translate['ALERTA_INFO_INICIAL']='<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> Omplint i enviant aquest formulari 
			<b>realitzaràs una reserva formal al restaurant, per un dia i hora concrets</b>. 
			</p>
			<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"> </span> Aquest no és un formulari de contacte per fer consultes. 
			Si el que desitges és plantejar-nos algun dubte, desplega la solapa "Tens algun dubte?", 
			a la barra de l\'esquerra.</p>';
			$translate['ALERTA_INFO']='<b>La teva reserva ha estat CONFIRMADA</b>.<br/><br/>
					T\'hem enviat un SMS recordatori al número de mòbil que ens has indicat.<br/><br/>'.$translate['google_maps'].'
					
					Pots cancel·lar o modificar les dades de la reserva des de l\'apartat <b>RESERVES</b>, introduïnt el teu mòbil i la contrassenya que trobaràs a l\'SMS.<br/><br/> 
					Et preguem que ens comuniquis qualsevol canvi a la reserva, especialment si es tracta d\'una cancel·lació<br/><br/>';
	$translate['ALERTA_INFO_UPDATE']='<b>La teva reserva ha estat MODIFICADA</b>.<br/><br/>
					T\'hem enviat un SMS recordatori al número de mòbil que ens has indicat.<br/><br/>
					
					Pots cancel·lar o modificar les dades de la reserva des de l\'apartat <b>RESERVES</b>, introduïnt el teu mòbil i la contrassenya que trobaràs a l\'SMS.<br/><br/> 
					Et preguem que ens comuniquis qualsevol canvi a la reserva, especialment si es tracta d\'una cancel·lació<br/><br/>';

$translate['INFO_LOGIN']="Pots cancel·lar o editar la data/hora i els comensals d'una reserva existent. Trobaràs la contrassenya (ID) a l'SMS o email que vas rebre quan vas fer la sol·licitud.";

$translate['RESERVA_CANCELADA']='<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">A petició teva, hem <b>cancel·lat</b> la reserva. <br/>No dubtis a reservar de nou la propera ocasió.
<br/><br/>
Gràcies per utilitzar aquest servei</div>';

$translate['ESBORRA_DADES']="<em>Desitjo que les meves dades siguin eliminades de la base de dades de Can Borrell després de la data de la reserva (per reserves futures els tornaràs a introduïr)</em>";

$translate['Cadira de rodes']="Movilitat reduïda";
$translate['Movilitat reduïda']="Mobilidad reducida";
$translate['Algú amb movilitat reduïda']="Movilitat reduïda";
$translate['Necessites ajuda?']="Necessites ajuda?";
$translate['Contrassenya (ID)']="ID de reserva";


$translate['subject_contactar_restaurant_']="CONTACTAR DES DE FORMULARI RESERVES";

$translate['INFO_CONTACTE_HOME']="Utilitza aquest formulari per a qualsevol dubte o comentari. Sempre responem en un breu interval de temps"
        . "<br/><br/>"
        . "Per realitzar, anul·lar o modificar reserves (comensals, data, hora, etc.) ves a <br/><a href='/reservar/'>RESERVES</a>";
        
$translate['INFO_TEL']="Si tens alguna incidència que no puguis solucionar des dels nostres formularis, pots trucar-nos al 936929723 / 936910605 / Fax: 936924057";
$translate['Formulari de contacte']="Formulari de contacte";

       

$translate['RESERVA_PASTIS']='<span class="pastis">Vols pastís de celebració?</span><br>'
        . '<span style="font-style: italic;">Pastís de la casa tipus Massini, pastís 500g (5 a 8 raciones) = 23.70€ / pastis 1000g (10 a 14 raciones) = 37.80 </span>';
//$translate['RESERVA_PASTIS']="Voldràs pastís de celebració (Pastís de la casa tipus Massini)";
$translate['INFO_PASTIS']="Comentaris pel pastís (Què celebreu?, Si és un aniversari, quants anys?)";

$translate['AVIS_MODIFICACIONS']='<span style="color:red"><b>Atenció:</b>
                                    </span>Fins a 2 hores abans de l\'hora reservada <b>podeu comunicar qualsevol variació</b> 
                                    en el nombre de coberts fes-nos-ho saber a restaurant@can-borrell.com</b>. 
<br/>
                                    Amb menys de 2 hores d\'antelació <b>no admetrem cap modificació</b> 
                                    a la reserva i disposareu exclusivament de les places que teniu confirmades. 
                                    <br/>Abans d\'aquest dia, també podeu editar la reserva en aquest mateix apartat.
                                    <span class="tanca-avis" style=""><a href="#">tanca</a></span>
                                    <br><div style="background-color:#feffb2;padding:4px;margin:12px 0;"><span style="color:red">
                                    <b>IMPORTANT: </b></span><b>Es cobraran {import_no_assitencia}€ per cada comensal 
                                    que no assisteixi al dinar.</b></div>';


/************ MAIL CONFIRMA PAGAMENT GRUPS ****************/
$translate["Can-Borrell: CONFIRMACIÓ PAGA I SENYAL"]="Can-Borrell: CONFIRMACIÓ DE RESERVA ONLINE";
$translate["MAIL_GRUPS_PAGAT_subject"]="Can-Borrell: CONFIRMACIÓ DE PAGAMENT DE RESERVA PER GRUP";
$translate["MAIL_GRUPS_PAGAT_titol"]="CONFIRMACIÓ DE PAGAMENT DE RESERVA";
$translate["MAIL_GRUPS_PAGAT_text1"]="Ens complau informar-lo que hem rebut correctament el pagament de ";
$translate['MAIL_GRUPS_PAGAT_text2']="<br><br>L'esperem el proper ";
$translate['MAIL_GRUPS_PAGAT_contacti'] = "Si té qualsevol dubte posi's en contacte amb nosaltres a <a href='mailto:".MAIL_RESTAURANT."' class='dins'>".MAIL_RESTAURANT."</a> ";

$translate['MAIL_GRUPS_PAGAT_text3'] = "<i style='font-size:11px'><p> Fins ara han estat abonats {pagat}€ ({coberts_pagats} coberts) d'un total de {total}€ ({coberts_reservats} coberts).<br>"
    . "Per completar tots els coberts sol·licitats encara heu de pagar {pendent}€</p> "
    . "<p></p>"
    . "<p><b>Recorda que la reserva només és efectiva per als coberts que s'hagin pagat</b> </p>"
    . "<p>Pots reenviar aquest correu per tal que altres persones paguin la seva part.<br> Podeu realitzar tants pagaments com desitgeu fins el dia </b>{data_limit}</b> </p></i>";


$translate["Realitzar pagament"] = "Realitzar pagament";
$translate["nom"] = "nom";
$translate["adults"] = "adults";
$translate["nens 4 a 9"] = "nens 4 a 9";
$translate["nens 10 a 14"] = "nens 10 a 14";
$translate["cotxets"] = "cotxets";
$translate["observacions"] = "observacions";
$translate["resposta"] = "resposta";
$translate["Data límit per efectuar el pagament"] = "Data límit per efectuar el pagament";
$translate["menu"] = "menú";
$translate["cdata_reserva"] = "data";
$translate["preu_reserva"] = "Preu TOTAL reserva";



$translate["RESERVA_IMPAGADA"] = "No hem rebut confirmació del pagament de la passarel·la bancària i "
    . "<b>-NO HA ESTAT POSSIBLE REALITZAR LA RESERVA</b> Torna-ho a intentar i assegura\'t de completar el pagament. "
    . "Recorda que fins que no completis la paga i senyal NO TENS RESERVA al restaurant";
$translate["Can Borrell: Reserva Anul·lada: No es rep i senyal"] = "Can Borrell: Reserva Anul·lada: No rebem paga i senyal";


$translate["gossos"] = "Admetem mascotes al'interior del restaurant fins a 8Kg.";

$translate['RESERVA_CORONA'] = "Seguint el protocol COVID establert per la Generalitat de Catalunya, el certificat COVID digital serà obligatori per poder accedir al restaurant.<br><b> </b>";
/*
$translate['RESERVA_CORONA'] = "Ens veiem en l'obligació d'advertir que si vostè pateix simptomatologia
que pugui estar relacionada amb el virus Covid-19, si us plau prengui les
mesures dictaminades pel Ministeri de Sanitat. 
<br><b> </b>";
*/
$translate["meteo_terrassa"]="Les reserves a la terrassa depenen de les condicions meteorològiques. "
        . "En cas de pluja o vent fort la taula seràparada a l'interior<br>"
        . "Per gaudir de taula a la terrassa cal arribar al restaurant abans de les 14:00h DISSABTES  I  LES 13.30h  DIUMENGES I FESTIUS. (per més tard no garantim que sigui a la terrassa)";


$translate["QUANTS_CALCOTS"] = "Voldreu calçots? Quantes racions?";
$translate["INFO_CALCOTS"] = "Aquesta dada ens permetrà tenir-ho tot preparat i poder-vos servir més ràpid";
$translate["CAP"] = "Cap";
$translate["MESDE15"] = "Més de dotze";


/************ SMS ****************/


/****************************************************************************************************/	
/*******************************************************     JS   ***********************************/	
/****************************************************************************************************/	
//
// ATENCIOOOOOOOOOOOOooooOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
// ATENCIOOOOOOOOOOOOooooOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
// ATENCIOOOOOOOOOOOOooooOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO
//
// NO ESCRIURE APOSTROF: '
// Es pot escriure tilde: ´

$translateJS['HOLA']="hole";
$translateJS['Ho semtim.\n\nNo podem reservar per la data que ens demanes']='Ho semtim.\n\nNo podem reservar per la data que ens demanes';
$translateJS['NENS_COTXETS']='<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . '<b>La suma de nens més cotxets ha de ser el nombre real de nens que vindran</b>'
    . '<br/>No comptis un mateix nen com a menor de 9 i com a cotxet simultàniament.</p> '
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  Per no duplicar places, si inclous un cotxet en el que s&#39;estarà un nen, '
    . 'no l&#39;anotis al grup anterior (Nens menors de 9 anys).</p>';
//$translateJS['OBSERVACIONS_COTXETS']='Cal que especifiquis els cotxets de nadó a la secció 1 del formulari.<br/><br/> No podem garantir l&#39;espai pels cotxets que indiquis a les observacions';
$translateJS['OBSERVACIONS_COTXETS']='No tindrem en compte les indicacions que ens facis al camp observacions referents a coberts de nens/adults o cotxets de nadó'
 . '<br/><br/>'
        . 'Disposem de recursos limitats i només podem garantitzar el que ens demanes a la primera secció d&#39;aquest formulari'
        . '<br/><br/>'
        . 'Gracies la teva comprensió';


$translateJS["fr-seccio-quants"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'En aquesta secció has d&quot;indicar exactament quantes persones vindran (adults, júniors i nens). </p>'
        . 
    '<p  class="alert alert-warning " style="display:none"><span class=" glyphicon glyphicon-exclamation-sign f1"></span> <b>Si sou més de '.(persones_paga_i_senyal-1).' persones, '
        . 'caldrà que autoritzeu una paga i senyal amb targeta de crèdit. És una autorització i no es realitzarà cap càrrec trec que no us presenteu el dia de la reserva</b></p>'
    
        . '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'A més, opcionalment, pots indicar si portareu cotxet i si us acompanya algú amb mobilitat reduïda o cadira de rodes.</p> '
    . 
    '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  <b>La suma de nens més cotxets ha de ser el nombre real de nens que vindran.</b>	'
    . '</p>		'
    . '<p  class="alert alert-danger "><span class=" glyphicon glyphicon-exclamation-sign f1"></span> <b>Reservarem espai pels comensals que ens indiquis aquí. La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat'
    . '</b></p>'
    . ''
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>   '
    . 'Aquest formulari és per a reserves de grups petits. Si sou més de '.($PERSONES_GRUP-1).' persones cal que premis a <b><a href="form_grups.php" style="color:#570600">Sol·licitud de reserva per Grups</a></b>'
    . '<br/>Disposem d&quot;un nombre limitat de trones i no en podem garantir la disponibilitat.'
    . '<br/>Només permetem l&#39;entrada de gossos pigall acompanyant invidents</p>'
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"> </span>  '
    . 'Un cop omplis aquestes dades, accediràs al pas 2, més avall</p> ';
$translateJS["fr-seccio-dia"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> Assegura&#39;t que el nombre d&#39;adults/nens/juniors és correcte i <b>'
    . 'selecciona el dia al calendari</b>.'
    . '<br/><br/> Alguns dies apareixen desactivats perquè el resturant està tancat o perquè els menjadors ja estan plens. </p>'
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span> En el següent pas podràs seleccionar l&#39;hora </p>';
$translateJS["fr-seccio-hora"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> Selecciona l&#39;hora entre les que apareixen a la botonera.<br/><br/> Només les hores que es presenten estan disponibles per reservar. </p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  Si no s&#39;ajusten a les teves preferències, pots canviar el dia en el pas anterior per veure si disposem de més horaris </p>';
$translateJS["fr-seccio-carta"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span>'
    . ' En aquest pas pots fer una ullada a la nostra carta i, si vols, seleccionar els plats que voldreu prendre. '
    . 'Això ens servirà a nosaltres per oferir-te un servei millor sense comprometre&#39;t a res. '
    . 'questa selecció no et causarà cap despesa extra.</p> '
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'Només et cobrarem el que realment consumeixis. </p> '
    . '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'Podràs canviar o cancel·lar aquesta selecció més endavant, en aquest mateix formulari, '
    . 'o un cop al restaurant en confirmar la comanda.</p> '
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span> Pots ometre aquest pas prement el botó <b>Continuar</b></br>';
$translateJS["fr-seccio-client"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'Necessitem algunes dades personals per garantir la reserva.<br/> <br/> '
    . 'Omple-les aquí començant pel número de telèfon mòbil.</p> '
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'Recorda que pots fer comentaris o peticions al camp <b>Observacions</b>, '
    . 'però no et podem garantir el que hi sol·licitis. '
    . 'El restaurant atendrà i contestarà els teus comentaris per fer-te saber si podem o no satisfer-te</p>';
$translateJS["fr-seccio-submit"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span>  Comprova detingudament les dades introduïdes i el resum final per evitar confusions. '
    . '</p>'
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"> </span>    Si tot és correcte prem a '
    . '<b>Sol·licitar reserva</b> i espera a veure la resposta en pantalla per assegurar-te que el procés finalitza satisfactòriament</p>';

$translateJS["grups-fr-seccio-quants"] = '<p  class="alert alert-info"><span class=" glyphicon glyphicon-info-sign f1"> </span>   '
    . 'En aquesta secció has d&#39;indicar exactament quantes persones vindran (adults, júniors i nens).		'
    . '</p>	'
    . '<p  class="alert alert-danger "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  <b>'
    . ''
    . 'Reservarem espai pels comensals que ens induquis aquí. '
    . 'La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat</b></p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'Aquest formulari és per a reserves de grups grans. '
    . 'Si sou menys de '.($PERSONES_GRUP).' persones cal que premis a <a href="form.php"  style="color:#570600"><b><='.($PERSONES_GRUP-1).'</b></a></p>'
    . '<p  class="alert alert-info"><span class=" glyphicon glyphicon-info-sign f1"> </span>  '
    . 'A més, opcionalment, pots indicar si portareu cotxet i si us acompanya algú amb mobilitat reduïda o cadira de rodes. </p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'Disposem d&#39;un nombre limitat de trones i no podem garantir la disponibilitat.</p>'
    . ''
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'Només permetem l&#39;entrada de gossos pigall acompanyant invidents</p>'
    . ''
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span>  '
    . 'Un cop omplis aquestes dades, accediràs al pas 2, més avall </p>';
$translateJS["grups-fr-seccio-dia"] = $translateJS["fr-seccio-dia"];
$translateJS["grups-fr-seccio-hora"] = $translateJS["fr-seccio-hora"];
$translateJS["grups-fr-seccio-carta"] = '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . ''
    . 'Per reserves de grups cal que ens indiquis, <b>com a mínim, un menú per cada comensal </b></p>'
    . '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'Si has marcat nens o juniors al pas 1 també necessitem saber quin menú prendran ells.'
    . ''
    . 'És imprescindible que marquis els menús per poder completar la reserva</p>';
$translateJS["grups-fr-seccio-client"] =$translateJS["fr-seccio-client"];
$translateJS["grups-fr-seccio-submit"] =$translateJS["fr-seccio-submit"];

$translateJS["REDIR_GRUPS"] ="Has indicat més de $PERSONES_GRUP persones. En aquest cas et transferirem al formulari de reserves de grups. \\nÉs això correcte?";
//$translateJS["PAGA_I_SENYAL"] ="<div>A continuació cal que autoritzis la fiança de ".import_paga_i_senyal."€ per garantitzar l&#39;assistència el dia de la reserva. "
$translateJS["PAGA_I_SENYAL"] ="<div>A continuació cal que autoritzis la fiança per garantitzar l&#39;assistència el dia de la reserva. "
        . "L&#39;import va en funció del nombre de comensals. AQUEST IMPORT NO ES DESCOMPTARÀ del teu compte, NO ES FARÀ CAP CÀRREC.<br/>"
        . "Només en cas de NO COMPAREXENÇA el dia de la reserva es farà efectiu el càrrec de l&#39;import<br/><br/>"        
        . "<br/><br/>Et transferim a una passarel·la bancària externa a Can Borrell. El restaurant no tindrà accés a les dades que introdueixis"
        . "<div class=\"info-paga-i-senyal\">Atenció: Si no podeu venir el dia de la reserva <b>pots evitar que es realitzi el càrrec si ens avises amb 24 hores d&#39;antelació</b>. "
        . "En cas contrari, carregarem aquest import al teu compte com a compensació per la taula que em guardat reservada i no em pogut oferir a altres clients </div>"
        . "<br/><br/></div>";


$translateJS['err0'] = 'El servidor no ha respost. No ha estat possible crear la reserva. Torna a enviar el formulari ara i, si el problema persisteix, contacta amb el restaurant';
$translateJS['err1'] = 'Test error';
$translateJS['err2'] = 'Test error';
$translateJS['err3'] = 'No hem trobat taula disponoble';
$translateJS['err4'] = 'El mòbil no és correcte';
$translateJS['err5'] = 'El camp nom no és correcte';
$translateJS['err6'] = 'El camp cognoms no és correcte';
$translateJS['err7'] = 'El nombre de comensals no és correcte';
$translateJS['err8'] = 'No hi ha taula per l&#39;hora que has demanat';
$translateJS['err9'] = 'No podem modificar la reserva';
$translateJS['err10'] = 'Per aquesta data cal que seleccionis un menú per cada comensal';
$translateJS['err11'] = 'Ja no es poden registrar reserves per la data d&#39;avui';
$translateJS['err99'] = 'El camp cognom no és correcte';
$translateJS['err100'] = 'Error de sessió';
$translateJS['err_contacti'] = 'Contacti amb el restaurant:restaurant@can-borrell.com';
$translateJS['LOADING TPV2'] = 'Et transferim a la passarel·la Redsys... \\n\\n No tanquis aquesta finestra ni la de pagament fins a completar el procés';
$translateJS['LOADING TPV'] = 'Per connectar amb la passarel·la bancària prem el botó. \\n\\n No tanquis aquesta finestra ni la de pagament fins a completar el procés';
$translateJS['Realizar Pago'] = 'Connectar amb Redsys';


/*
$translateJS['INFO_PAGA_I_SENYAL'] = 'Per confirmar la reserva <b>cal que realitzi una paga i senyal de '.IMPORT_PAGA_I_SENYAL.'€</b>\n\n'
        . 'El transferirem a la passarel·la bancària del Banc de Sabadell per tal que pugui finalitzar el procés de reserva realitzant el pagament amb tarja de crèdit.\n\n'
        . '\n-Cal que disposi de una tarja activada per a compres per internet'
        . '\n-L&#39;import abonat li serà descomptat del preu final, de manera que <b>no representarà cap despesa extra</b>'
        . '\n-El Banc de Sabadell gestionarà el pagament en un entorn segur. El restaurant, en cap cas, tindrà accès a les dades de la seva targeta';
        
*/
$translate['err20'] = '<b>Ja tens una reserva feta a Can Borrell!!</b><br/><br/>Pots modificar-la o eliminar-la, però no pots crear més d&#39;una reserva online.<br/><em>(Per editar o cancel·lar utilitza l&#39;enllaç que trobarà més amunt, sota la barra de navegació d&#39;aquesta pàgina)</em><br/><br/><br/>Si ho desitges posa&#39;t en contacte amb nosaltres:<br/><b>restaurant@can-borrell.com</b><br/><br/><br/>La reserva que ens consta es pel dia ';
$translate['err22'] = '<b>No pots iniciar una nova reserva!!</b><br/><br/>Es possible que tingui un procés de pagament incomplert. Si és així, finalitza\'l o espera uns minuts a que el banc ens comuniqui que ha explira\'t. Torna a intentar-ho en uns minuts ';
$translateDirectJS['err21'] = '<b>No podem fer-te la reserva on-line a causa d&#39;algun problema amb una reserva anterior!!</b><br/><br/>Si us plau, per reservar contacta amb el restaurant:restaurant@can-borrell.com /';
$translateDirectJS['err20'] = '<b>Ja tens una reserva feta a Can Borrell!!</b><br/><br/>Pots modificar-la o eliminar-la, però no pots crear més d&#39;una reserva online.<br/><em>(Per editar o cancel·lar utilitza l&#39;enllaç que trobarà més amunt, sota la barra de navegació d&#39;aquesta pàgina)</em><br/><br/><br/>Si ho desitges posa&#39;t en contacte amb nosaltres:<br/><b>restaurant@can-borrell.com</b><br/><br/><br/>La reserva que ens consta es pel dia ';
$translateDirectJS['err22'] = '<b>No pots iniciar una nova reserva!!</b><br/><br/>Es possible que tingui un procés de pagament incomplert. Si és així, finalitza el pagament o espera uns minuts a que el banc ens comuniqui que ha explirat. Torna a intentar-ho en uns minuts ';

$translateDirectJS['CAP_TAULA']="No tenim cap taula disponible per la data/coberts/cotxets que ens demanes.<br/><br/>Intenta-ho per una altra data";
$translateDirectJS['PAGAMENT REBUT']="Hem rebut l\'autorització. La teva reserva ja està confirmada\\n Recorda que només en cas de no comparèixer es realitzarà el càrrec al teu compte \\n\\nGràcies per utilitzar aquest servei";
$translateDirectJS['EL PAGAMENT HA ESTAT ANULAT']="Malauradament no s\'ha completat el procés d\'autorització. \\n\\nGràcies per utilitzar aquest servei";
//echo " ***************** ".$translate["MAIL_GRUPS_PAGAT_subject"];

$translateJS['CALÇOTADA_NO_COMBINABLE'] = "El menú calçotada no es pot combinar amb cap altre. Tots els comensales han de demanar el mateix.  \\n\\nSi selecciones confirmar s\'eliminarán de la selecció els menús no combinables";
$translateJS['N4_NO_COMBINABLE'] = "El menú nº 4 no es pot combinar amb cap altre. Tots els comensales han de demanar el mateix.  \\n\\nSi selecciones confirmar s\'eliminarán de la selecció els menús no combinables";

       // $translateJS['INFO_CARTA_NADAL']='Los dias especiales de navidad tenéis que escoger entre los menús que os ofrecemo. Tenéis que escoger tantos menús como comensales ';
       // $translateJS['INFO_CARTA_NADAL']='Els dies especials de nadal cal que escolliu els menús que us oferim. N`heu d`escollir tants com comensals';
        $translateJS['INFO_CARTA_NADAL']="Els dies especials de nadal cal que escolliu els menús que us oferim. N`heu d`escollir tants com comensals."
                . "<br><br><b>(el menú de calçotada es pot combinar amb els menús nº 1 i nº2)</b>"
                . "<br><br><b>SUPLEMENTS (pels que no volen fer graellada)</b><br>"
                . "<ul><li>Costella de vedella a la brasa (9.50€)</li>"
                . "<li>Espatlla de xai a la brasa (10.40€)</li>"
                . "<li>Bacallà a la llauna (8.50€)</li>"
                . "<li>Cargols a la llauna (8.50€)</li>"
                . "<li>Moixarra a la brasa  (8.50€)</li>"
                . "<li>Llobarro a la brasa  (8.50€)</li><br>";


        $translateJS['INFO_CARTA']=$translate['INFO_CARTA'];
                $translateJS['INFO_MENU_NENS']='<p class="alert alert-info"><span class="glyphicon glyphicon-info-sign f1"></span>Seleccionant nens us comprometeu a demanar un menú (infantil o júnior) per cada infant a la secció de menús, més endavant</p>';

   //     $translateJS['INFO_CARTA']="Si ho desitges pots triar els plats que demanareu per tenir una idea del preu, evitar que us trobeu algun plat exhaurit i accelerar el servei quan vingueu al restaurant.<br/><br/><b>Aquesta selecció no et compromet en absolut</b>.<br/><br/> Un cop al restaurant podràs modificar o anul·lar la comanda i, en qualsevol cas, us cobrarem únicament els plats i beugudes que us servim.";;
        
require_once('translate.php');
?>
