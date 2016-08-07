<?php

if (!isset($lang))
  $lang = 'cat';
if (!isset($PERSONES_GRUP))
  $PERSONES_GRUP = 12;


$translate['EDIT_RESERVA_FORA_DE_SERVEI'] = '<p style="color:red">This service is temporarily out of order. To cancel or inform of alterations in your reservation please call <p>
<b>93 692 97 23</b>
<br/>
<b>93 691 06 05</b>
<p>Thank you</p>
';



// MENU
$translate['CAN BORRELL'] = 'CAN BORRELL';

$translate['FOTOS-VIDEO'] = 'PHOTOS-VIDEO';

$translate['CARTA I MENU'] = 'MENUS';

$translate['ON SOM: MAPA'] = 'WHERE WE ARE';

$translate['EXCURSIONS'] = 'EXCURSIONS';

$translate['HISTÒRIA'] = 'HISTORY';

$translate['HORARI'] = 'TIMETABLES';

$translate['RESERVES'] = 'RESERVATIONS';

$translate['CONTACTAR'] = 'CONTACT';
// FORM
$translate['Reserva per grups'] = 'Reservation for groups';

$translate['Modificar'] = 'Edit reservation';

$translate['Sol·licitud de reserva'] = 'Reservation request';

$translate['[Cancel·lar/modificar una reserva existent]'] = 'Cancel/change an existing reservation';

$translate['NO_COBERTS_OBSERVACIONS'] = '<b>Only the place settings/push chairs/prams indicated in the first section will be taken into account</b>. <span style="color:red">Changes in the number of push chairs or prams asked for in Other Information will be ignored</span>.<br/>The restaurant cannot guarantee the availability of high chairs. Once in the restaurant please ask the staff and they will provide you with one if possible.';

$translate['INCIDENCIA_ONLINE'] = "Do you have a problem that you cannot solve through using this form? Describe briefly your case and we will respond via email as soon as possible. ";

$translate['INCIDENCIA_ONLINE_GRUPS'] = "Describe the changes <b>requested</b> for your reservationRemember that the changes <b>ARE NOT VALID</b> "
    . "if you do not receive confirmation from the restaurant";

$translate['INFO_NO_EDITAR_GRUPS'] = "<h3>You cannot edit GROUP reservations online.</h3> <br/><br/>Use this contact form to inform us of changes you would like to make and we will get back to you as soon as possible.<br/><br/>Thank you.";



$translate['[Contactar amb el restaurant]'] = "Contact the restaurant";
$translate['Contactar amb el restaurant'] = "Contact the restaurant";
$translate['INFO_CONTACTE'] = "If you have a reservation made, give the ID";

$translate['INFO_COMANDA'] = "You can choose different set menus or dishes from the main menu but, you cannot mix set menus and dishes from the main menu.</b><br/>";



$translate['ERROR_LOAD_RESERVA'] = '<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">We cannot find the reservation or we are no longer able to make changes due to short notice</div>';

$translate['ERROR_CONTACTAR'] = '<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum" style="color:red">Incorrect information. The message cannot be sent</div>';


$translate['CONTACTAR_OK'] = '<div id="caixa_reserva_consulta_online" class="ui-corner-bottom caixa resum " style="color:green">Message sent. </div>';


$translate['Ajuda'] = 'Help';
$translate['Correu electrònic'] = 'Email';
$translate['Pel dia:'] = 'Date:';
$translate['Cap'] = 'None';
$translate['Doble ample'] = 'Double width';
$translate['Doble llarg'] = 'Double length';
$translate['inclòs'] = 'Included';
$translate['Camps obligatoris'] = 'Compulsory fields';
$translate['Aquest camp és necessari'] = 'Required field';
$translate['La nostra carta'] = 'Our menu';
$translate['Els nostres menús'] = 'Our set menus';
$translate['Connexió amb el sistema de reserves'] = 'Connect to our reservation service';
$translate['Cap taula o restaurant tancat'] = 'There are no tables available or the restaurant is closed';
$translate['Editant reserva ID'] = 'Editing reservation ID';
$translate['Sol·licitud de reserva per a GRUPS'] = 'Reservation request for GROUPS';




$translate["Hi ha errors al formulari. Revisa les dades, si us plau"] = 'There are errors in this form. Check the information, please';

$translate['Paga i senyal necessària'] = "Payment of deposit necessary";
$translate['INFO_QUANTS_SOU'] = '<b> Tell us how many people will come </b>, firstly age 14 and above, then juniors and children.  
<br/> 
                         <div class=info-paga-i-senyal> <b>  If you are more than ' . (persones_paga_i_senyal - 1) . ' people,
you will need to make a ' . import_paga_i_senyal . '€ deposit payment with a credit card </ b>.
This amount will be discounted from your bill, therefore there is no added expense. 
The payment will be made using a secure bank gateway. 
Can Borrell will not have access to information given.
              </div> 
<br/> <br/> 
		<b>We will reserve places for the diners indicated here. 
                                                        The reservation will not be valid for a number of people that do not coincide with the reservation request</b>
		 <br/> <br/>
		
		<b>(WE CANNOT GUARANTEE THE AVAILABILITY OF HIGH CHAIRS).</b>  <br/><br/>
		We only allow access to guide dogs accompanied by blind people<br/><br/>
                                                      <em>   If, in total you are more than ' . ($PERSONES_GRUP - 1 ) . ' people, click on the tab “Groups”  </em>
                                                      <br/> <br/><b>TOTAL PEOPLE/PUSH CHAIRS';

$translate['ALERTA_GRUPS'] = '<b> You have marked more than <span style="font-size:1.2em">' . $PERSONES_GRUP - 1 . '</Span> people in total. </B > <br/> <br/> '
    . 'you must fill in the form  for Groups or reduce the number of diners. <br/> '
    . '<br/> If you wish to go to the Groups form click on “Group reservations”. If you wish to reduce the number of diners click on “change” ';


$translate['LLEI'] = 'In accordance with the provisions of Organic Law 15/1999 of December 13th on the Protection of Personal Data (PPD) we hereby inform you that the personal data obtained as a result of completing this form will be treated in the strictest confidence by the Masia Can Borrell Restaurant. You can exercise your rights of access, rectification, cancellation and opposition to the treatment of personal information, '
    . 'in the terms and conditions  stated in the  Protection of  Personal Data (referred to as LOPD, its initials in Spanish) '
    . 'through the email address: ' . MAIL_RESTAURANT;


$translate['INFO_NO_CONFIRMADA'] = '<b> Remember </b>: The reservation <b> IS NOT CONFIRMED </b> until a text message is received on the Mobile phone number given.';


$translate['INFO_CARTA'] = 'If you wish you can choose the dishes you will order so you are able to estimate the price. <br/> <br/>
<b> This selection does not oblige you in any way.  </b>. <br/> <br/> 
Until the day before the reservation you can change your selection online. Once in the restaurant you can also alter or cancel an order by informing the waiter, 
we will only charge for the dishes and drinks served.';

$translate['PREU'] = 'Price (including VAT)';

$translate['INFO_HORES'] = '<b> Remember </b>: The times shown are only when we have found tables available for the number of people on your reservation request. <br/> ';

$translate['INFO_DATA'] = '<b> Mark the date </b>. <br/> <br/>
Be sure to give the correct date changing month, if necessary, with the arrows on the top part of the calendar <br/> <br/>
Remember that, excluding some holidays, the restaurant is closed on mondays and tuesdays.<br/> <br/> 
If there is an unavailable day it could be because there are no tables free. <br/> <br/> ';


$translate['ALERTA_INFO'] = '<b> The Reservation has been CONFIRMED. </b>. <br/> <br/>
We have sent a confirmation text message to the mobile phone number you’ve given. <br/> <br/>

You can cancel or change the dates of your reservation using the  <b> RESERVAS </b> section of our web page, giving your mobile telephone number and the password given in the text message.<br/> <br/>
We ask you to inform us of any alterations to the reservation, especially if it’s a cancellation. <br/> <br/>';

$translate['ALERTA_INFO_INICIAL'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> By filling in and sending this form
		<b> you are making a formal reservation in the restaurant, for a specific date and time </b>. 
		</p>
		<p  class="alert alert-danger "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  
                                                        This is not a contact form for inquires. If you have a query or wish to make a suggestion click on the overlap
		“Contact the restaurant”, at the end of the menu.</p> ';

$translate['ALERTA_INFO_INICIAL_GRUPS'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> 
This form allows you to<b> REQUEST </b>a reservation that the restaurant will have to CONFIRM or DENY.  </p>


<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> 
Remember that filling in and sending off this form is the first step in a process that ends in a <b>credit card payment</b> of a deposit which will be discounted from your final bill, 
therefore there is <b>no extra cost involved</b>.</p> 
<p class="alert alert-danger"><span class=" glyphicon glyphicon-exclamation-sign f1"></span> <b>
No reservation request is valid unless the payment is made before the date given.</p>';


$translate['ALERTA_INFO_UPDATE'] = '<b> The reservation has been EDITED </b>. <br/> <br/>
We have sent a text message to the mobile telephone number you have given. <br/> <br/>

You can cancel or change the information on your reservation using the <b>RESERVATIONS</b> section of our web page, giving your mobile phone number and the password found in the text message.<br/> <br/> 
We ask you to inform us of any changes in the reservation, especially if it’s a cancellation.<br/> <br/>';


$translate['RESERVA_CANCELADA'] = '<div id="error_login" style="text-align:center;color:red;padding:8px;margin:4px;border:red solid 1px">
At your request we have  <b>cancelled</b> the reservation. <br/>Do not hesitate to make a new reservation for another occasion. 
<br/><br/>Thank you for using this service.  
</div>';



$translate['INFO_LOGIN'] = "You can cancel or modify the date / time and the number of diners in an existing reservation. You will find the password (ID) in the text mesage received when the reservation request was made.";

$translate['Contrassenya (ID)'] = "Reservation ID";
$translate['Mòbil'] = "Mobile";
$translate['Quants sou?'] = "How many people are you?";
$translate['Quin dia voleu venir?'] = "What day would you like to come?";
$translate['Adults (més de 14 anys)'] = "Adults (over 14 years old)";
$translate['ADULTS_TECLAT'] = '<span class="gris-ajuda">&#8625;You can type the number if there is no tab with the correct amount</span>';

$translate['Juniors (de 10 a 14 anys):'] = "Juniors (from 10 to 14 years old)";
$translate['Nens (de 4 a 9 anys)'] = "Children younger than 9 years old <b>without a push chair</b>";
$translate['Cotxets de nadó'] = "Children in prams or push chairs<br/><em style='font-size:0.8em'> (unfortunately we only have room for one push chair per table)</em>. <br/><b style='font-size:0.8em'>The child will use the push chair instead of as seat or high chair.</b>";
$translate['Grups'] = "Reservation request for groups";
$translate['A quina hora?'] = "At what time?";
$translate['Dinar'] = "Lunch";
$translate['Sopar'] = "Dinner";
$translate['Vols triar els plats?'] = 'Do you want to choose the dishes?';
$translate['SELECCIÓ'] = 'SELECTION
<br/><span class="resum ">You can choose different types of set menu or different dishes from the main menu, <b>but you cannot mix set menus with dishes from the main menu.</b> </span>
';
$translate['No hi cap plat seleccionat'] = "There is no dish selected";
$translate['La nostra carta'] = "Our menu";
$translate['Telèfon mòbil'] = "Mobile phone number";
$translate['Ens vols deixar una altre telèfon?'] = "Would you like to give another telephone number?";
$translate['Nom'] = "Name";
$translate['Cognoms'] = "Surnames";
$translate['Observacions'] = "Other information";
$translate['Envia la sol·licitud'] = "Send request";
$translate['Resum reserva'] = "Reservation summary";
$translate['Data'] = "Date";
$translate['Adults'] = "Adults";
$translate['Juniors'] = "Juniors";
$translate['Nens'] = "Children";
$translate['Cotxets'] = "Push chairs / prams";
$translate['Comanda'] = "Order";
$translate['Hora'] = "Time";
$translate['plats'] = "dishes";
$translate['Continuar'] = "Continue";
$translate['Carta'] = "Menu";
$translate['Donan´s algunes dades de contacte'] = "Give contact information";
$translate['Sense'] = "Without";
$translate['Sol·licitar reserva'] = "Reservation request";

$translate['ESBORRA_DADES'] = "<emI would like my information to be removed from the Can Borrell database after my reservation date (for future reservations you will re-enter your information)</em>";
$translate['Cadira de rodes'] = "Reduced mobility";
$translate['Portem una cadira de rodes'] = "We will bring a wheelchair";
$translate['Movilitat reduïda'] = "Reduced mobility";
$translate['Algú amb movilitat reduïda'] = "Reduced mobility";

$translate['Per la data seleccionada és necessari escollir els menús'] = "For this date you need to select menus";
$translate['Per la data seleccionada és necessari escollir menú per tots els comensals'] = "For this date you must select menus for all customers";

$translate['Necessites ajuda?'] = "Do you need help?";


$translate['subject_contactar_restaurant'] = "CONTACT THROUGH RESERVATION FORM";

$translate['INFO_CONTACTE_HOME'] = "Use this form for any comments or queries. We will always respond within a short amount of time"
    . "<br/><br/>"
    . "To make, cancel or change reservations (diners, date, time, etc.) go to <br/><a href='/RESERVATIONS/'>RESERVAS</a>";

$translate['INFO_TEL'] = "If there is any problem you cannot solve through our forms, you can call us on 936929723 / 936910605 / Fax: 936924057";
$translate['Formulari de contacte'] = "Contact form";

$translate['RESERVA_PASTIS'] = '<span class="pastis">Would you like a celebration cake?</span><br>'
    . '<span style="font-style: italic;">The house cake, Massini style (Two layers of sponge filled with Chantilly cream topped with a flamed caramelized topping), '
    . '<br>500g cake (5 to 8 portions) =23.70€
<br> 1000g cake (10 to 14 portions) = 37.80€ </span>';
$translate['INFO_PASTIS'] = "<br/><br/>Comments about the cake? (What are you celebrating? If it’s a birthday, how many years?)";

$translate['AVIS_MODIFICACIONS'] = '<span style = "color: red"> 
 <b> Attention: </b> </span>The same day of the reservation please <b> inform us of any change</b>  in the number of places by calling from 10 to 11 o’clock in the morning 
  <b>935 803 632</b> or <b>936 929 723</b>.<br/> Later than 11 o’clock <b>we cannot make any changes</b> to the reservation and only the places reserved will be available. 
  <br/>Before the day, you can also edit your reservation using the same section of our web page. 
  <span class = "tanca-avis" style = ""> <a href="#">close</a> </span>';


/* * ********** MAIL CONFIRMA PAGAMENT GRUPS *************** */
$translate["MAIL_GRUPS_PAGAT_subject"] = "Can Borrell: CONFIRMATION OF GROUP RESERVATION PAYMENT";
$translate["MAIL_GRUPS_PAGAT_titol"] = "CONFIRMATION OF RESERVATION PAYMENT";






$translate["MAIL_GRUPS_PAGAT_text1"] = "We are happy to inform you that we have correctly received your payment of ";
$translate['MAIL_GRUPS_PAGAT_text2'] = "€. Your reservation has been registeredWe look forward to seeing you on ";
$translate['MAIL_GRUPS_PAGAT_contacti'] = "If you have any questions you can contact us on <a href='mailto: " . MAIL_RESTAURANT . "' class='dins'>" . MAIL_RESTAURANT . "</a> ";
$translate["nom"] = "name";
$translate["adults"] = "adults";
$translate["nens 4 a 9"] = "children 4 to 9";
$translate["nens 10 a 14"] = "children 10 to 14";
$translate["cotxets"] = "push chairs/ Prams";
$translate["observacions"] = "other information";
$translate["resposta"] = "answer";
$translate["Data límit per efectuar el pagament"] = "Last date for making payment";
$translate["menu"] = "menu";
$translate["cdata_reserva"] = "date";



/* * **************************** SMS ************************************* */
$translate["Recuerde: reserva en Restaurant Can Borrell el %s a las %s (%s).Rogamos comunique cualquier cambio: 936929723 - 936910605.Gracias.(ID:%s)"] = "Remenber: reservation at Restaurant Can Borrell on %s at %s (%s).We ask you to inform us of any changes: 936929723 - 936910605.Thank's.(ID:%s)";

$translate["Restaurant Can Borrell, reserva MODIFICADA: L'esperem el %s a les %s. Preguem comuniqui qualsevol canvi al web o tel.936929723 - 936910605. Gràcies.(ID:%s)"] = "Restaurant Can Borrell, reservation UPDATED: See you on %s at %s. We ask you to inform us of any changes by web o tels.936929723 - 936910605. Thank's.(ID:%s)";



/* * ************************************************************************************************* */
/* * *****************************************************     JS   ********************************** */
/* * ************************************************************************************************* */
//
// ATENCIOOOOOOOOOOOO
//
// NO ESCRIURE APOSTROF: '
// Es pot escriure tilde: ´

$translateJS['HOLA'] = "hole";
$translateJS['Ho semtim.\n\nNo podem reservar per la data que ens demanes'] = "We’re sorry, we can’t make a reservation for the date shown.";


// $translateJS passa per html htmlentities
// $translateDirectJS es passa directe a JS sense traduïr simbols

/* * *****************************************************     VALIDATE   ********************************** */
$translateJS['fr-seccio-quants'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'In this search you should indicate exactly how many people are going to come (adults, juniors and children)</p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  <b> '
    . 'Remember if you are more than ' . (persones_paga_i_senyal - 1)
    . ' people, it will be necessary for you to make a deposit payment of ' . import_paga_i_senyal . '€ with a credit card. </b>.</p>'
    . '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'You can also tell us if you will bring pushchairs or prams or if you are accompanied by someone with reduced mobility or in a wheelchair. The sum of children and pushchairs or prams has to be the actual number of children that will come We will reserve space for the number of diners shown here. The reservation will not be valid for a number of people that do not coincide with the reservation request This form is for small group reservations. If you are more than 11 people click on Reservation request for groups We have a limited number of high chairs and we cannot guarantee their availability. We only allow access to guide dogs accompanied by blind people. Once this information is completed you will access step 2, below.</p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span> '
    . 'The sum of children and pushchairs or prams has to be the actual number of children that will come</b></p>'
    . '<b><p  class="alert alert-danger "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'We will reserve space for the number of diners shown here. '
    . 'The reservation will not be valid for a number of people that do not coincide with the reservation request</b>  '
    . '</p> '
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'This form is for small group reservations. '
    . ' If you are more than ' . ($PERSONES_GRUP - 1) . ' click on <b>  '
    . '<a href="form_grups.php" style="color:#570600">Reservation request for groups</a></b><br/><br/>	'
    . 'We have a limited number of high chairs and we cannot guarantee their availability <br/><br/> '
    . 'We only allow access to guide dogs accompanied by blind people. </p>'
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"> </span>  '
    . 'Once this information is completed you will access step 2, below</p>';

$translateJS['fr-seccio-dia'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'Select a day on the calendar. <br/><br/> '
    . 'Some days appear blocked due to the restaurant being closed or because the dining area is full.</p> '
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span>  '
    . 'In the next step you can select the time.</p>';
$translateJS['fr-seccio-hora'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'Select a time from those that appear on the buttons. <br/><br/> '
    . 'Only the times shown are available for booking. </p> '
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . ' If they do not match your requirements you can change the day in the previous stage of the reservation to see if we have more times available.</p>';
$translateJS['fr-seccio-carta'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span>  '
    . 'In this stage you can look at our menu and, if you wish, select your dishes.'
    . '<br/><br/> This helps us offer a better service and does not commit you to anything, it does not cause any extra expenses. </p>'
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span>  We only charge for what you actually consume. </p>  '
    . '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'You can change or cancel this selection at a later date,  on the same form or in the restaurant when you are confirming your orders.</p>  '
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'You can skip this step by clicking on the <b>Continue</b> tab.</p>';
$translateJS['fr-seccio-client'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'We need some personal data to guarantee your reservation.  <br/><br/>'
    . 'Enter them here, starting with your mobile telephone number. </p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'Remember that you can make comments and requests in the <b>Other information field</b>, but we cannot guarantee what you ask for here.'
    . 'The restaurant will reply to your requests so that you know if they are possible.</p>';
$translateJS['fr-seccio-submit'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span>  '
    . 'Carefully check the information given and the final summary to avoid confusion.</p>  '
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"> </span>    '
    . 'If everything is correct press <b>Request reservation</b> and wait to see the response on the screen to make sure that the process has been finalized.</p>';

$translateJS['grups-fr-seccio-quants'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'In this section you should indicate exactly how many people (adults, juniors and children) are coming. '
    . '</p> '
    . '<p  class="alert alert-danger "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . '<b>We will reserve places for the diners that are indicated here. The reservation will not be valid for a '
    . 'number of people that do not coincide with the reservation request. </b> </p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'This form is for large group reservations. If you are less than ' . ($PERSONES_GRUP) . ' people click above on'
    . '<a href="form.php" style="color:#570600"><b><=' . ($PERSONES_GRUP - 1) . '</b> </a><br/><br/>  '
    . 'We have a limited number of high chairs and we cannot guarantee their availability. </p>'
    . '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'You can also tell us if you will bring pushchairs or prams or if you are accompanied by someone with reduced mobility or in a wheelchair. </p>'
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'We only allow access to guide dogs accompanied by blind people</p>'
    . '<p  class="alert alert-success "><span class=" glyphicon glyphicon-info-sign f1"></span>  '
    . 'Once this information is completed you will access step 2, below./p>';
$translateJS["grups-fr-seccio-dia"] = $translateJS["fr-seccio-dia"];
$translateJS["grups-fr-seccio-hora"] = $translateJS["fr-seccio-hora"];
//$translateJS["grups-fr-seccio-carta"] = "Para reservas de grupos es necesario que nos indiques el menú que tomaréis por cada grupo de edad. <br/> <br/> Si has marcado niños o juniors en el paso 1 también necesitamos saber qué menú tomarán ellos. <br/> <br/> <b>Es imprescindible</b> que marques los menús para poder completar la reserva";
$translateJS["grups-fr-seccio-carta"] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> '
    . 'For group reservations you need to <b>mark at least one menu for each diner</b> '
    . '<br/> <br/> If you have marked children and juniors in step one we also need to know what meal they will order.'
    . '</p> '
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . '<b> It is essential</b> that you mark the menus to complete the reservation.</p>';
$translateJS["grups-fr-seccio-client"] = $translateJS["fr-seccio-client"];
$translateJS["grups-fr-seccio-submit"] = $translateJS["fr-seccio-submit"];




$translateJS['Aquest camp és necessari'] = "Required field";
$translateJS["El mínim de comensals és de "] = "The mínimum number of diners is";
$translateJS["Dona´ns un mòbil"] = "Give mobile phone number";
$translateJS["Dona´ns el teu nom"] = "Give name";
$translateJS["Dona´ns els teus cognoms"] = "Give surnames";
$translateJS["Dona´ns un email"] = "Give email";
$translateJS["El format no és correcte"] = "The format is not correct";
$translateJS['Selecciona el dia'] = "Select a day";
$translateJS['Sense'] = "Without";
$translateJS['Selecciona, coma a mínim, dos adults'] = "Select two adults minimum";
$translateJS['SELECCIÓ'] = 'SELECTION';

$translateJS['COTXET DOBLE AMPLE'] = 'DOUBLE WIDTH PUSHCHAIR /PRAM';
$translateJS['COTXET DOBLE LLARG'] = 'DOUBLE LENGTH PUSHCHAIR / PRAM';
$translateJS['Per menys de'] = 'This form is for reservations for ' . $PERSONES_GRUP . ' people or more';
$translateJS['No hi ha cap plat seleccionat'] = 'No dish has been selected';

$translateJS['Menús'] = 'Set menus';
$translateJS['Menús Nadal'] = 'Set Christmas Menu';
$translateJS['NENS_COTXETS'] = '<p  class="alert alert-info "><span class=" glyphicon glyphicon-info-sign f1"></span> <b>'
    . 'The amount of children and push chairs/ prams have to be the actual number of children that are coming'
    . '</b><br/>Don’t count the same child as younger than 9 years old push chairs together</p> '
    . '<p  class="alert alert-warning "><span class=" glyphicon glyphicon-exclamation-sign f1"></span>  '
    . 'So place settings are not duplicated, if you include a push chair or pram in which a child will be seated '
    . 'do not count it in the previous group (children younger than 9 years old).</p>';
$translateJS['OBSERVACIONS_COTXETS'] = 'We will not take into account instructions given in Other information field referring to place settings '
    . 'for children/adults or push chairs and prams. '
    . '<br/><br/>'
    . 'We have limited resources available and <b>can only guarantee what you request in the first section</b> of this form'
    . '<br/><br/>Thank you for your understanding.';

$translateJS["REDIR_GRUPS"] = "You have marked more than " . $PERSONES_GRUP . " people. In this case, we will transfer you to the form for group reservations. \\n"
    . "¿Is this correct?";

$translateJS["PAGA_I_SENYAL"] = "<div>The following step is to make the " . import_paga_i_senyal . "€ payment to guarantee assistance on the day of your reservation. "
    . "This payment will be discounted from your final bill. <br/><br/>"
    . '<div class = "info-paga-i-senyal"> Attention: If you cannot come on the day of your reservation your deposit will be refunded if we are informed with 24 hours notice</b>. Otherwise, the deposit cannot be returned </div> '
    . "<br/><br/>We will transfer you from Can Borrell to an external bank gateway. The restaurant will not have access to the information given."
    . "<br/><br/></div>";

/* * *****************************************************     ERRORS   ********************************** */
$translateJS['err33'] = 'Test error33';
$translateJS['err0'] = 'The server has not responded. It has not been possible to make a reservation. Send the form again and, if the problem persists, contact the restaurant.';
$translateJS['err1'] = 'Test error1';
$translateJS['err2'] = 'Test error2';
$translateJS['err3'] = 'We haven’t found a table available ';
$translateJS['err4'] = 'The mobile telephone number is incorrect';
$translateJS['err5'] = 'The field ‘name’ is incorrect';
$translateJS['err6'] = 'The field ‘surnames’ is incorrect';
$translateJS['err7'] = 'The number of diners is incorrect';
$translateJS['err8'] = 'There is no table available for the time you have requested';
$translateJS['err10'] = 'On this date you should select a menu for each diner';
$translateJS['err11'] = 'You can no longer make reservations for today.';
$translateJS['err99'] = 'Test error';
$translateJS['err100'] = 'Net Session Error';
$translateJS['err_contacti'] = 'contact the restaurant: 936929723 / 936910605';

$translate['err20'] = '<b>You have now made a reservation in Can Borrell!!</b><br/><br/>you can change or cancel it but. you cannot make more than one online reservation. <br/><em>(To edit or cancel use the link found above, below the navigation bar on this page)</em><br/><br/><br/>If you wish to contact us: <br/><b>936929723 / 936910605</b><br/><br/><br/>The reservation we have booked is for ';
$translateDirectJS['err21'] = '<b>We can‘t make a reservation due to a problem with a past reservation</b><br/><br/>Please, to make a reservation contact us: 936929723 / 936910605';
$translateDirectJS['err20'] = '<b>You have now made a reservation in Can Borrell!!</b><br/><br/>you can change or cancel it but. you cannot make more than one online reservation. <br/><em>(To edit or cancel use the link found above, below the navigation bar on this page)</em><br/><br/><br/>If you wish to contact us: <br/><b>936929723 / 936910605</b><br/><br/><br/>The reservation we have booked is for ';
$translate['err21'] = '<b>We cannot make an online reservation because of one already made!!<br/><br/>Please, to make a reservation contact the restaurant:936929723 / 936910605';

$translateDirectJS['CAP_TAULA'] = "Sorry, no tables available for the requested date / dinners.<br/><br/>Try an othe date";

require_once('translate.php');
?>
