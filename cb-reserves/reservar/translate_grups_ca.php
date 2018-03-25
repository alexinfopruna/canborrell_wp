<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;

	$translate['INFO_QUANTS_SOU_GRUPS']='<b>Digue\'ns quantes persones vindreu</b>, indicant, en primer lloc els majors de 14 anys.	Indica també el nombre de juniors i nens.
			<br/><br/>			
			<b>Reservarem espai pels comensals que ens induquis aquí. La reserva no serà vàlida per un nombre de persones que no coincideixi amb el que has sol·licitat</b>
 <br/>
			<b>(NO PODEM GARANTIR LA DISPONIBILITAT DE TRONES).</b> <br/>
			<br/><br/>Només permetem l´entrada de gossos pigall acompanyant invidents
					<br/><br/>
					<em>Si, en total, sou menys de <b>'.($PERSONES_GRUP).'</b> persones, marca el botó "<='.($PERSONES_GRUP-1).'"</em><br/><br/>
					<b>TOTAL PERSONES:</b>';
	$translate['INFO_CARTA_GRUPS']='Cal que indiquis el menú que prendreu els adults. 
	<br/><strong style="font-size:1.2em">Si han de venir nens/juniors és IMPRESCINDIBLE que indiquis també quin menú voleu per ells
			<br/><br/>
Pels vegetarians disposem d\'un menú de verdures a la brasa per 25€. Afegeix un comentari al camp <b>Observacions</b>, en el siguiente paso, per fer-nos-ho saber.';

					
$translate['Menú per a juniors']='Menú per a juniors (nens de 10 a 14 anys)';
$translate['Menú per a nens']='Menú per a nens (nens de 4 a 9 anyos)';


$translate['ALERTA_INFO_GRUPS']='La <b>sol·licitud</b> de reserva ha estat enviada.
<br/><br/>
<b>Això no significa que estigui confirmada</b>.
<br/><br/>
Hem de verificar la diponibilitat de taula pel dia que has demanat.
En breu rebràs un correu electrònic en el que t\'informarem de si, finalment, hem pogut reservar taula per vosaltres i de com continuar el procès per confirmar la reserva.
<br/> <br/>
<div class="alert alert-danger">
Si heu de <b>modificar</b> el nombre de coberts ens heu d\'avisar,com a mínim, <b>3 dies abans de la data de la reserva</b> per email a restaurant@can-borrell.com o trucant al 936929723 / 936910605 
</div>

<br/> <br/>

Revisa el teu correu en les properes hores i tingues present que <b>ENCARA NO ESTÀ CONFIRMADA LA RESERVA</b>
<br/><br/>

Sempre contestem les sol·licituds en un plaç d´un dia. 
		Si passades 24h no has rebut resposta pot tractar-se d´algun problema amb el correu electrònic. 
		Comprova la carpeta d´spam i, si no localitzes el mail del restaurant, 
		posa´t en contacte amb nosaltres amb un correu electrònic i facilita´ns: 
		<ul>
<li>
		Una altra adreça on respondre´t 
</li>
<li>
		El teu nom
		</li>
<li>
		La data per la que demanes la reserva
</li>
<li>
		El nombre de comensals
</li>
</ul>		
		
		
<br/><br/>
L\'import de la paga senyal serà descomptat del preu final, de manera que no representarà cap despesa extra, 
ni en el cas que canvieu el nombre de comensals en confirmar la reserva.'
        
. '<div class="info-paga-i-senyal">Atenció: Si no podeu venir el dia de la reserva <b>pots recuperar la paga i senyal si ens avises amb 48 hores d&#39;antelació</b>. En cas contrari, l&#39;import abonat no serà retornat</div>'


.'<br/><br/>Gracies per utilitzar aquest servei.<br/><br/>';

$translate['ANULAT____INFO_COMANDA_GRUPS']="Per les reserves de grups has d'escollir, com a mínim, un menú/plat per cada comensal (comptant adults, juniors nens)<br>"
    . "Per més de 20 comensals no està disponible la carta, i és necessari que indiqueu exclussivament menús";
$translate['INFO_COMANDA_GRUPS']="Per poder formalitzar la reserva necessitem que indiqueu els menús que prendreu.<br>"
    . "Cal que ens feu saber <b>tants menús com comensals reservats.</b><br>"
    . "<ul><li>Si sou <b>fins a 20</b> comensals podeu triar tant plats de la carta com menús complerts</li>"
    . "<li>Si sou <b>més de 20</b> comensals només podeu triar menús</li></ul>";

$translate['MENUS_COMENSALS']="Has d'escollir tants menús com comensals (adults + juniors + nens)";
$translate['CARTA_FINS_20']="Fins a 21 comensals la selecció de plats de la carta és opcional i la podreu fer directament al restaurant si ho preferiu";





// LLISTAT MENUS

/*******************************************************************************************/
// MENU 1
/*******************************************************************************************/
	$translate['titol_menu_2001']=$translate['titol_menu_1']='Menú nº1';
	$translate['menu_2001']=$translate['menu_1']='
<B>ENTRANTS</B>
<UL>
Amanida<BR>
Escalivada<BR>
G&iacute;rgoles<BR>
Esp&agrave;rrecs brasa<BR>
Carxofes<BR>
Mongetes amb cansalada<BR>
Patates fregides<BR>
All i Oli<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>GRAELLADA</B>
<UL>
Xai<BR>
Conill<BR>
Pollastre<BR>
Botifarra<BR>
Botifarra negra<BR>
&nbsp;<BR>
</UL>
<B>CELLER</B>
<UL>
Vi de la Casa<BR>
Gasosa<BR>
Aigua<BR>
Refresc<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruits secs (músic) pica-pica a la taula</li>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Copa sorbet llimona</li>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
{preu_2001} Euros/unitat adults (IVA incl&ograve;s)<BR>
{preu_2002} Euros/unitat adults amb cava (IVA incl&ograve;s)<BR>
';

/*******************************************************************************************/
// MENU 1 CEL
/*******************************************************************************************/
	$translate['titol_menu_2025']=$translate['titol_menu_2024']=$translate['titol_menu_1c']='MEN&Uacute; Nº 1 CELEBRACI&Oacute;';
	$translate['menu_2025']=$translate['menu_2024']=$translate['menu_1c']='
<B>ENTRANTS</B>
<UL>
Amanida<BR>
Escalivada<BR>
G&iacute;rgoles<BR>
Esp&agrave;rrecs brasa<BR>
Carxofes<BR>
Mongetes amb cansalada<BR>
Patates fregides<BR>
All i Oli<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>GRAELLADA</B>
<UL>
Xai<BR>
Conill<BR>
Pollastre<BR>
Botifarra<BR>
Botifarra negra<BR>
&nbsp;<BR>
</UL>
<B>CELLER</B>
<UL>
Vi de la Casa<BR>
Gasosa<BR>
Aigua<BR>
Refresc<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Pastís i cava
&nbsp;<BR>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2024} Euros/unitat adults sense cava (IVA incl&ograve;s)<BR>
{preu_2025} Euros/unitat adults amb cava (IVA incl&ograve;s)<BR>
</UL>';

/*******************************************************************************************/
// MENU 2
/*******************************************************************************************/
	$translate['titol_menu_2003']=$translate['titol_menu_2']='MEN&Uacute; Nº 2';
	$translate['menu_2003']=$translate['menu_2']='
<B>ENTRANTS</B>
<UL>
Llonganissa<BR>
Xori&ccedil;o<BR>
Pat&eacute; de Jabugo<BR>
Amanida<BR>
Escalivada<BR>
All i Oli<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>SEGONS</B>
<UL>
Mongetes amb cansalada<BR>
Patates fregides<BR>
G&iacute;rgoles a la brasa<BR>
Esp&agrave;rrecs a la brasa<BR>
Carxofes a la brasa<BR>
&nbsp;<BR>
</UL>
<B>GRAELLADA</B>
<UL>
Xai<BR>
Conill<BR>
Pollastre<BR>
Botifarra negra<BR>
Botifarra<BR>
&nbsp;<BR>
</UL>
<B>CELLER</B>
<UL>
Vi de la Casa<BR>
Gasosa<BR>
Aigua<BR>
Refresc<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruits secs (músic) pica-pica a la taula</li>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Copa sorbet llimona</li>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2003} Euros/unitat adults sense cava (IVA incl&ograve;s)<BR>
{preu_2004} Euros/unitat adults amb cava (IVA incl&ograve;s)<BR>
</UL>
';

/*******************************************************************************************/
// MENU 2 CEL
/*******************************************************************************************/
	$translate['titol_menu_2027']=$translate['titol_menu_2023']=$translate['titol_menu_2c']='MEN&Uacute; Nº 2 CELEBRACIÓ';
	$translate['menu_2027']=$translate['menu_2023']=$translate['menu_2c']='
<B>ENTRANTS</B>
<UL>
Llonganissa<BR>
Xori&ccedil;o<BR>
Pat&eacute; de Jabugo<BR>
Amanida<BR>
Escalivada<BR>
All i Oli<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>SEGONS</B>
<UL>
Mongetes amb cansalada<BR>
Patates fregides<BR>
G&iacute;rgoles a la brasa<BR>
Esp&agrave;rrecs a la brasa<BR>
Carxofes a la brasa<BR>
&nbsp;<BR>
</UL>
<B>GRAELLADA</B>
<UL>
Xai<BR>
Conill<BR>
Pollastre<BR>
Botifarra negra<BR>
Botifarra<BR>
&nbsp;<BR>
</UL>
<B>CELLER</B>
<UL>
Vi de la Casa<BR>
Gasosa<BR>
Aigua<BR>
Refresc<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
Pastís i cava
&nbsp;<BR>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2023} Euros/unitat adults sense cava (IVA incl&ograve;s)<BR>
{preu_2027} Euros/unitat adults amb cava (IVA incl&ograve;s)<BR>
</UL>
';

/*******************************************************************************************/
// MENU 3
/*******************************************************************************************/
	$translate['titol_menu_2012']=$translate['titol_menu_3']='MEN&Uacute; Nº 3';
	$translate['menu_2012']=$translate['menu_3']='
<B>ENTRANTS</B>
<UL>
Amanida<BR>
Assortit de pat&eacute;s<BR>
Llonganissa de pag&eacute;s<BR>
Xori&ccedil;o de Salamanca<BR>
Pa torrat amb tom&agrave;quet i alls<BR>
All i Oli<BR>
&nbsp;<BR>
</UL>
<B>GRAELLADA</B>
<UL>
Butifarra a la brasa<BR>
Pollastre a la brasa<BR>
Secret de porc<BR>
Patates fregides<BR>
Mongetes amb cansalada<BR>
&nbsp;<BR>
</UL>
<B>CELLER</B>
<UL>
Vi de la Casa<BR>
Gasosa<BR>
Aigua<BR>
Refresc<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruits secs (músic) pica-pica a la taula</li>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Copa sorbet llimona</li>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2012} Euros (IVA incl&ograve;s)</UL>
</UL>
';

/*******************************************************************************************/
// MENU 4
/*******************************************************************************************/
	$translate['titol_menu_2007']=$translate['titol_menu_4']='MEN&Uacute; Nº 4';
	$translate['menu_2007']=$translate['menu_4']='
<B>ENTRANTS</B>
<UL>
  <p><strong>Variat de verdures a la brasa</strong><br/>
        <i>(Plat per comensal)</i><br/> <br/>
		Escalivada <br/>
		Girgoles<br/>
		Esparrecs<br/>
        Carxofes temporada<br/>
    &nbsp;
  </p>
  </UL>
<B>CARNS A LA BRASA</B><br/>
<i>(Ració individual a escollir)</i><br/><br/>
<UL>
  Conill<br>
    Botifarra<br>
      Pollastre<br>
        Llom<br>
          Galta de porc<br>
            Peus de porc
            <BR>
  &nbsp;
  </UL>
<B>GUARNICIONS</B>
<UL>
  Mongetes amb cansalada <BR>
  Patates fregides <BR>
  All i oli<br>
  Pa torrat amb tom&agrave;quet
</UL>
<B><br>
CELLER</B>
<UL>
  <p>Vi de la casa <BR>
    Gasosa<BR>
    Aigua<br>
    Refresc<BR>
  &nbsp;</p>
  </UL>
<B>POSTRES</B>
<UL>
<li>Fruits secs (músic) pica-pica a la taula</li>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Copa sorbet llimona</li>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
    <B>PREU</B>
<UL>
    {preu_2007} Euros<!--/unitat adults sense cava --> (IVA incl&ograve;s)<BR>
</UL>
';

/*******************************************************************************************/
// MENU comunio
/*******************************************************************************************/
	$translate['titol_menu_2013']=$translate['titol_menu_comunio']='MEN&Uacute; COMUNIÓ';
	$translate['menu_2013']=$translate['menu_comunio']='
<B>VERMUT</B>
<P>
<B>APERITU</B>
<UL>
Llagostins<BR>
Patates xips<BR>
Atmetlles salades<BR>
Olives farcides<BR>
Calamars a la romana<BR>
Tacs truita<BR>
Sorbet<BR>
&nbsp;<BR>
</UL>
<B>PRIMERS</B>
<UL>
Entremesos individual<BR>
Amanida i Pat&eacute;s<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>SEGONS (Graellada)</B>
<UL>
Patates fregides<BR>
Be<BR>
Botifarra negra<BR>
Conill<BR>
Pollastre<BR>
Botifarra<BR>
All i Oli<BR>
&nbsp;<BR>
</UL>
<B>PAST&Iacute;S DE CELEBRACI&Oacute;</B>
<P>&nbsp;<BR>
<B>CELLER</B>
<UL>
Vi Cabernet negre o rosat<BR>
Cava Brut Reserva Sard&agrave;<BR>
Aigua i refrescs<BR>
&nbsp;<BR>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2013} Euros (IVA incl&ograve;s)<BR>
&nbsp;<BR>
<!--
<B>Nens:</B><BR>
{preu_2017} Euros nens de 4 a 9 anys (IVA incl&ograve;s)<BR>
{preu_2018} Euros nens de 10 a 14 anys (IVA incl&ograve;s)
</UL>
<B>Incl&oacute;s centre de flors</B><BR>
-->
';

/*******************************************************************************************/
// MENU casament
/*******************************************************************************************/
	$translate['titol_menu_2016']=$translate['titol_menu_casament']='MEN&Uacute; CASAMENT';
	$translate['menu_2016']=$translate['menu_casament']='
<B>APERITU</B>
<UL>
Llagostins<BR>
Patates xips<BR>
Atmetlles salades<BR>
Olives farcides<BR>
Calamars a la romana<BR>
Tacs truita<BR>
Sorbet<BR>
&nbsp;<BR>
</UL>
<B>PRIMERS</B>
<UL>
Entremesos<BR>
Amanida<BR>
Escalivada<BR>
Esp&agrave;rrecs<BR>
G&iacute;rgoles<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>SEGONS (Graellada)</B>
<UL>
Xai<BR>
Botifarra negra<BR>
Conill<BR>
Pollastre<BR>
Botifarra<BR>
All i Oli<BR>
&nbsp;<BR>
</UL>
<B>PAST&Iacute;S DE CASAMENT</B>
<P>&nbsp;<BR>
<B>CELLER</B>
<UL>
Vi Cabernet negre o rosat<BR>
Cava Brut Reserva Sard&agrave;<BR>
Aigua i refrescs<BR>
&nbsp;<BR>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2016} Euros (IVA incl&ograve;s)<BR>
&nbsp;<BR>
</UL>
<B>Guarnici&oacute; de flors</B><BR>
';

/*******************************************************************************************/
// MENU calsots
/*******************************************************************************************/
	$translate['titol_menu_2010']=$translate['titol_menu_calsots']='MEN&Uacute; CALÇOTADA';
	$translate['menu_2010']=$translate['menu_calsots']='
<B>ENTRANTS</B>
<UL>
CAL&Ccedil;OTS (temporada)<BR>
Inclou repetici&oacute; (fins a 25 Uds./comen&ccedil;al)<BR>
&nbsp;<BR>
Mongetes amb cansalada<BR>
Patates fregides<BR>
All i oli<BR>
Pa torrat amb tom&agrave;quet<BR>
&nbsp;<BR>
</UL>
<B>GRAELLADA</B>
<UL>
Xai<BR>
Conill<BR>
Pollastre<BR>
Botifarra<BR>
Botifarra negra<BR>
&nbsp;<BR>
</UL>
<B>CELLER</B>
<UL>
Vi de la Casa<BR>
Gasosa<BR>
Aigua<BR>
Refresc<BR>
&nbsp;<BR>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruits secs (músic) pica-pica a la taula</li>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Copa sorbet llimona</li>
</UL>
<B>CAF&Egrave;S, TALLATS o CIGALONS</B><BR>

<P>&nbsp;<BR>
<B>PREU</B>
<UL>
{preu_2010} Euros (IVA incl&ograve;s)<BR>
</UL>
';

/*******************************************************************************************/
// MENU VEGETARIÀ
/*******************************************************************************************/
	$translate['titol_menu_990060']=$translate['titol_menu_vegetaria']='MEN&Uacute; VEGETARIÀ';
	$translate['menu_990060']=$translate['menu_vegetaria']='En aquest Menú es pot escollir de primer i de segon els següents plats: 
<ul>
<li>Xatonada</li>
<li>Amanida</li>
<li>Gírgoles</li>
<li>Espàrrecs</li>
<li>Escalivada</li>
<li>Carxofes (temporada)</li>
<li>Calçots (temporada) </li>
<li>Graellada de verdures</li>
<BR>

Incloent-hi els complements (mongetes i patates fregides all i oli pa torrat amb tomàquet i alls, beguda i cafès
<BR><BR>
<B>PREU</B>



{preu_990060} Euros (IVA incl&ograve;s)<BR>
';


/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
/*******************************************************************************************/
  /*******************************************************************************************/
  // INFANTILS / JUNIORS
  /*******************************************************************************************/
                              $translate['titol_menu_2037']=$translate['titol_menu_infantil']='Men&uacute; Infantil (ni&ntilde;os de 4 a 9 a&ntilde;os)';
                              $translate['menu_2037']=$translate['menu_infantil']='
  Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<br/>
  {preu_2037} Euros/unidad (IVA incluido)<br/>
  &nbsp;<br/>';

                              $translate['titol_menu_2036']=$translate['titol_menu_junior']='Men&uacute; Junior (de 10 a 14 a&ntilde;os)';
                              $translate['menu_2036']=$translate['menu_junior']='Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<br/>
  {preu_2036} Euros/unidad (IVA incluido)';

                              $translate['titol_menu_2017']=$translate['titol_menu_inf_comunio']='Men&uacute; Comunión (ni&ntilde;os de 4 a 9 a&ntilde;os)';
                              $translate['menu_2017']=$translate['menu_inf_comunio']='{preu_2017} Euros';

                              $translate['titol_menu_2018']=$translate['titol_menu_jun_comunio']='Men&uacute; Comunión (ni&ntilde;os de 10 a 14 a&ntilde;os)';
                              $translate['menu_2018']=$translate['menu_jun_comunio']='{preu_2018} Euros';


                              $translate['titol_menu_2021']=$translate['titol_menu_inf_casament']='Men&uacute; Boda (ni&ntilde;os de 4 a 9 a&ntilde;os)';
                              $translate['menu_2021']=$translate['menu_inf_casament']='{preu_2021} Euros ';

                              $translate['titol_menu_2022']=$translate['titol_menu_jun_casament']='Men&uacute; Boda (ni&ntilde;os de 10 a 14 a&ntilde;os)';
                              $translate['menu_2022']=$translate['menu_jun_casament']='{preu_2022} Euros ';
	
$translateJS['MENUS_COMENSALS']="Has d\'escollir tants menús com comensals (adults + juniors + nens)";
 
/*******************************************************     ERRORS   ***********************************/	
$translateJS['err33'] = 'Test error33';
$translateJS['err0'] = 'No ha estat possible crear la reserva.';
$translateJS['err1'] = 'Test error1';
$translateJS['err2'] = 'Test error2';
$translateJS['err3'] = 'No hem trobat taula disponoble';
$translateJS['err4'] = 'El mòbil no és correcte';
$translateJS['err5'] = 'El camp nom no és correcte';
$translateJS['err6'] = 'El camp cognoms no és correcte';
$translateJS['err7'] = 'El nombre de comensals no és correcte';
$translateJS['err8'] = 'No hi ha taula per l´hora que has demanat';
$translateJS['err10'] = 'Para esta fecha debes seleccionar un menú para cada comensal';
$translateJS['err99'] = 'Test error';
$translateJS['err100'] = 'Error de sessió';
$translateJS['err_contacti'] = 'Contacti amb el restaurant: 936929723 / 936910605';

$translate['err20'] = '<b>Ja tens una reserva feta a Can Borrell!!</b><br/><br/>Pots modificar-la o eliminar-la, però no pots crear més d´una reserva online.<br/><em>(Per editar o cancel·lar utilitza l´enllaç que trobarà més amunt, sota la barra de navegació d´aquesta pàgina)</em><br/><br/><br/>Si ho desitges posa´t en contacte amb nosaltres:<br/><b>936929723 / 936910605</b><br/><br/><br/>La reserva que ens consta es pel dia ';
$translateDirectJS['err21'] = '<b>No podemos hacer la reserva on-line a causa de algún problema con una reserva anterior</b><br/><br/>Por favor, para reservar contacta con el restaurant:936929723 / 936910605';
$translateDirectJS['err20'] = '<b>Ya tienes una reserva hecha en Can Borrell!</b><br/><br/>Puedes modificarla o eliminarla pero no puedes crear más de una reserva online<br/><em>(Para editar o cancelar, utiliza el enlace que hay arriba, bajo la barra de navegación de esta página )</em><br/><br/><br/><br/><br/>Si lo deseas ponte en contacto con nosotros:<br/><b>936929723 / 936910605</b><br/><br/><br/>La reserva que nos consta es para el dia ';
$translate['err21'] = '<b>No podem fer-te la reserva on-line a causa d´una reserva anterior!!</b><br/><br/>Si us plau, per reservar contacta amb el restaurant:936929723 / 936910605';
$translateDirectJS['CAP_TAULA']="No tenemos ninguna mesa disponible para la fecha/cubiertos/cochecitos que nos pides.<br/><br/>Inténtalo para otra fecha";
        //echo "WWW";die();
        require_once('translate_ca.php');
	         
	
?>
