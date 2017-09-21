<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;



$translate['INFO_COMANDA_GRUPS']="In group reservations you should choose, at least, one menu for each diner (counting adults, juniors and children)";
$translate['Escull els menús']="Choose menus";
 $translate['Veure els menús']='See menus';

$translate['INFO_QUANTS_SOU_GRUPS']='<b>Tell us how many people will come, indicate firstly people over 14 years of age. Also, mark the number of juniors and children. 
		<br/> <br/>
<b>We will reserve spaces for the number of diners shown here. The reservation will not be valid for a number of people that does not coincide with the reservation request. </b>
			 <br/>
		<b>(WE CANNOT GUARANTEE THE AVAILABILITY OF HIGH CHAIRS).</b><br/>
<br/> <br/>
		We only allow access to guide dogs accompanied by blind people 
<br/> <br/>
		<em> If, in total, you are less than <b> '. ($PERSONES_GRUP ).'</b> people, mark the "<='. ($PERSONES_GRUP-1 ).'" </em> <br/> <br/>
<b> TOTAL PEOPLE: ';

	$translate['INFO_CARTA_GRUPS']='You should indicate the adults’ menu.
	<br/><strong style="font-size:1.2em"> If you are accompanied by children/juniors, you also need to indicate the menu you would like for them </strong>
			<br/><br/>
For vegetarians we have a menu of grilled vegetables for 25€. Add a commentary in the <b>Other Information</b> field on the next stage of the reservation so that we are informed';
     

        
        
$translate['Escull el menú']='Choose the menu';
$translate['Menú per a adults']='Menu for adults';
$translate['Menú per a juniors']='Menu for juniors (children from 10 to 14 years old)';
$translate['Menú per a nens']='Menu for children (children from 4 to 9 years old)';


$translate['ALERTA_INFO_GRUPS']='The reservation <b>request</b> has been sent.
<br/><br/>
<b>this does NOT mean that it is confirmed. </b>.
<br/><br/>
We have to verify the availability of a table for the date you have requested.  
hortly you will receive an email informing you if we have been able to reserve a table for you and how to continue 
the process to confirm the reservation 
<br/><br/>

<div class="alert alert-danger">
If you have <b>to modify </b> the number of people, you must notice, at least <b> 3 days before the booking date </b> to the mail restaurant@can-borrell.com or call 936929723 / 936910605 
</div>

<br/> <br/>

Check your emails in the following two or three hours and be aware that the <b>RESERVATION IS NOT YET CONFIRMED</b>

<br/><br/>

we always respond to requests within one day. If in twenty four hours you haven’t 
received a response it could be due to a problem with the email. 
Check your spam folder, if you cannot find the restaurants email message contact us by sending an email giving us: 
<ul>
<li>
Another email address where we can contact you 
</li>
<li>
		Your name
</li>
<li>
The date of the reservation request
</li>
<li>
The number of diners 
</li>
</ul>

<br/><br/>
The price of the deposit is discounted from your bill, therefore there is no added expense, 
this applies even if you change the number of diners when confirming the reservation.'					
.'<div class = "info-paga-i-senyal">Attention: If you cannot come on the day of your reservation <b>Attention: If you cannot come on the day of your reservation your deposit will be refunded if 48 hours \ notice is given. </b>. '
    . 'Otherwise, the amount paid will not be returned </div> '
.'<br/><br/>Thank you for using this service.<br/><br/>';






// LLISTAT MENUS

/*******************************************************************************************/
// MENU 1
/*******************************************************************************************/
	$translate['titol_menu_2001']=$translate['titol_menu_1']='Menú nº1';
	$translate['menu_2001']=$translate['menu_1']='
	<B>ENTRANTES</B>
<UL>
Ensalada<br/>
Escalivada<br/>
G&iacute;rgolas<br/>
Esp&aacute;rragos a la brasa<br/>
Alcachofas<br/>
Jud&iacute;as con tocino<br/>
Patatas fritas<br/>
Alioli<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<br/>
Conejo<br/>
Pollo<br/>
Butifarra<br/>
Butifarra negra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<BR>Refresco<BR>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruitos secos (músico) pica-pica en mesa</li>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Copa sorbete limón</li>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<br/>
<B>PRICE</B>
<UL>
{preu_2001} Euros/unidad adultos (including VAT)<br/>
{preu_2002} Euros/unidad adultos con cava (including VAT)<br/>
</UL>
';

/*******************************************************************************************/
// MENU 1 CEL
/*******************************************************************************************/
	$translate['titol_menu_2025']=$translate['titol_menu_2024']=$translate['titol_menu_1c']='MEN&Uacute; Nº 1 CELEBRACI&Oacute;N';
	$translate['menu_2025']=$translate['menu_1c']=$translate['menu_2024']='
<FONT CLASS="titol"><B>MEN&Uacute; Nº 1 CELEBRACI&Oacute;N</B></FONT>
<HR SIZE="1">
&nbsp;<br/>
<B>ENTRANTES</B>
<UL>
Ensalada<br/>
Escalivada<br/>
G&iacute;rgolas<br/>
Esp&aacute;rragos a la brasa<br/>
Alcachofas<br/>
Jud&iacute;as con tocino<br/>
Patatas fritas<br/>
Alioli<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<br/>
Conejo<br/>
Pollo<br/>
Butifarra<br/>
Butifarra negra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<BR>Refresco<BR>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Pastel y cava
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<br/>
<B>PRICE</B>
<UL>
{preu_2024} Euros/unidad adultos sin cava (including VAT)<br/>
{preu_2025} Euros/unidad adultos con cava (including VAT)<br/>
</UL>';

/*******************************************************************************************/
// MENU 2
/*******************************************************************************************/
	$translate['titol_menu_2003']=$translate['titol_menu_2']='MEN&Uacute; Nº 2';
	$translate['menu_2003']=$translate['menu_2']='
<B>ENTRANTES</B>
<UL>
Longaniza<br/>
Chorizo<br/>
Pat&eacute; de Jabugo<br/>
Ensalada<br/>
Escalivada<br/>
Alioli<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>SEGUNDOS</B>
<UL>
Jud&iacute;as con tocino<br/>
Patatas fritas<br/>
G&iacute;rgolas a la brasa<br/>
Esp&aacute;rragos a la brasa<br/>
Alcachofas a la brasa<br/>
&nbsp;<br/>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<br/>
Conejo<br/>
Pollo<br/>
Butifarra negra<br/>
Butifarra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<BR>Refresco<BR>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruitos secos (músico) pica-pica en mesa</li>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Copa sorbete limón</li>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<P>&nbsp;<br/>
<B>PRICE</B>
<UL>
{preu_2003} Euros/unidad adultos sin cava (including VAT)<br/>
{preu_2004} Euros/unidad adultos con cava (including VAT)<br/>
</UL>
';

/*******************************************************************************************/
// MENU 2 CEL
/*******************************************************************************************/
	$translate['titol_menu_2027']=$translate['titol_menu_2023']=$translate['titol_menu_2c']='MEN&Uacute; Nº 2 CELEBRACIÓN';
	$translate['menu_2027']=$translate['menu_2023']=$translate['menu_2c']=' 
<B>ENTRANTES</B>
<UL>
Longaniza<br/>
Chorizo<br/>
Pat&eacute; de Jabugo<br/>
Ensalada<br/>
Escalivada<br/>
Alioli<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>SEGUNDOS</B>
<UL>
Jud&iacute;as con tocino<br/>
Patatas fritas<br/>
G&iacute;rgolas a la brasa<br/>
Esp&aacute;rragos a la brasa<br/>
Alcachofas a la brasa<br/>
&nbsp;<br/>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<br/>
Conejo<br/>
Pollo<br/>
Butifarra negra<br/>
Butifarra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<BR>Refresco<BR>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Pastel y cava
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<br/>
<B>PRICE</B>
<UL>
{preu_2023} Euros/unidad adultos sin cava (including VAT)<br/>
{preu_2027} Euros/unidad adultos con cava (including VAT)<br/>
</UL>
';

/*******************************************************************************************/
// MENU 3
/*******************************************************************************************/
	$translate['titol_menu_2012']=$translate['titol_menu_3']='MEN&Uacute; Nº 3';
	$translate['menu_2012']=$translate['menu_3']='
<B>ENTRANTES</B>
<UL>
Ensalada<br/>
Surtido de pat&eacute;s<br/>
Llonganiza de pay&eacute;s<br/>
Chorizo de Salamanca<br/>
Pan tostado con tomate y ajos<br/>
Alioli<br/>
&nbsp;<br/>
</UL>
<B>PARRILLADA</B>
<UL>
Butifarra a la brasa<br/>
Pollo a la brasa<br/>
Secreto de cerdo<br/>
Patatas fritas<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<BR>Refresco<BR>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruitos secos (músico) pica-pica en mesa</li>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Copa sorbete limón</li>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<br/>
<B>PRICE</B>
<UL>
{preu_2012} Euros (including VAT)
</UL>
';

/*******************************************************************************************/
// MENU 4
/*******************************************************************************************/
	$translate['titol_menu_2007']=$translate['titol_menu_4']='MEN&Uacute; Nº 4';
	$translate['menu_2007']=$translate['menu_4']='
<B>ENTRANTES</B>
<UL>
  <strong>Variado de verduras</strong><br/>
  <i>(Plato por comensal) </i><br/><br/>
	Escalivada<br/>
	Girgolas<br/>
	Esp&aacute;rragos <br/>
	Alcahofas temporada<br/>
  &nbsp;<br/>
</UL>
<B>CARNES A LA BRASA </B><br/>
<i>(Raci&oacute;n individual a escoger)</i><br/><br/>
<UL>
  Conejo<br/>
    Butifarra<br/>
    Pollo<br/>
    Lomo<br/>
    Quijada de cerdo<br/>
    Pies de cerdo
    <br/>
  </UL>
<B>GUARNICIONES</B>
<UL>
  Judias con tocino <br/>
  Patatas fritas <br/>
  Alioli<br/>
  Pan tostado con tomate
</UL>
<B>BODEGA</B>
<UL>
  Vino de la Casa<br/>
  Gaseosa<br/>
  Agua<BR>Refresco<BR>
  &nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruitos secos (músico) pica-pica en mesa</li>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Copa sorbete limón</li>
</UL>
<B>CAF&Eacute;S, CORTADOS </B><br/>

<br/>
</B>
<B>PRICE</B>
<UL>
  {preu_2007} Euros (including VAT)
</UL>
';

/*******************************************************************************************/
// MENU comunio
/*******************************************************************************************/
	$translate['titol_menu_2013']=$translate['titol_menu_comunio']='MEN&Uacute; COMUNION';
	$translate['menu_2013']=$translate['menu_comunio']='
<B>VERMUT</B>
<P>
<B>APERITVO</B>
<UL>
Lagostinos<br/>
Patatas chips<br/>
Almendras saladas<br/>
Aceitunas rellenas<br/>
Calamares a la romana<br/>
Tacos tortilla<br/>
Sorbete<br/>
&nbsp;<br/>
</UL>
<B>PRIMEROS</B>
<UL>
Entremeses individual<br/>
Ensalada y Pat&eacute;s<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>SEGUNDOS (Parrillada)</B>
<UL>
Patatas fritas<br/>
Cordero<br/>
Butifarra negra<br/>
Conejo<br/>
Pollo<br/>
Butifarra<br/>
Alioli<br/>
&nbsp;<br/>
</UL>
<B>PASTEL DE CELEBRACI&Oacute;N</B>
<P>&nbsp;<br/>
<B>BODEGA</B>
<UL>
Vino Cabernet tinto o rosado<br/>
Cava Brut Reserva Sard&agrave;<br/>
Agua y refrescos<br/>
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<P>&nbsp;<br/>
<B>PRICE</B>
<UL>
{preu_2013} Euros (including VAT)<br/>
</UL>
';

/*******************************************************************************************/
// MENU casament
/*******************************************************************************************/
	$translate['titol_menu_2016']=$translate['titol_menu_casament']='MEN&Uacute; BODA';
	$translate['menu_2016']=$translate['menu_casament']='
<B>APERITVO</B>
<UL>
Lagostinos<br/>
Patatas chips<br/>
Almendras saladas<br/>
Aceitunas rellenas<br/>
Calamares a la romana<br/>
Tacos tortilla<br/>
Sorbete<br/>
&nbsp;<br/>
</UL>
<B>PRIMEROS</B>
<UL>
Entremeses<br/>
Ensalada<br/>
Escalivada<br/>
Esp&aacute;rragos<br/>
G&iacute;rgolas<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>SEGUNDOS (Parrillada)</B>
<UL>
Cordero<br/>
Butifarra negra<br/>
Conejo<br/>
Pollo<br/>
Butifarra<br/>
Alioli<br/>
&nbsp;<br/>
</UL>
<B>PASTEL DE BODA</B>
<P>&nbsp;<br/>
<B>BODEGA</B>
<UL>
Vino Cabernet tinto o rosado<br/>
Cava Brut Reserva Sard&agrave;<br/>
Agua y refrescos<br/>
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

<br/>
<B>PRICE</B>
<UL>
{preu_2016} Euros (including VAT)<br/>
</UL>
';

/*******************************************************************************************/
// MENU calsots
/*******************************************************************************************/
	$translate['titol_menu_2010']=$translate['titol_menu_calsots']='MEN&Uacute; CALÇOTADA';
	$translate['menu_2010']=$translate['menu_calsots']='
<B>ENTRANTES</B>
<UL>
CAL&Ccedil;OTS (temporada)<br/>
Incluye repetici&oacute;n (hasta 25 Uds./comensal)<br/>
&nbsp;<br/>
Jud&iacute;as con tocino<br/>
Patatas fritas<br/>
Alioli<br/>
Pan tostado con tomate<br/>
&nbsp;<br/>
</UL>
<B>PARRILLADA</B>
<UL>
Cordero<br/>
Conejo<br/>
Pollo<br/>
Butifarra<br/>
Butifarra negra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<BR>Refresco<BR>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
<li>Fruitos secos (músico) pica-pica en mesa</li>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Copa sorbete limón</li>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>

&nbsp;<br/>
<B>PRICE</B>
<UL>
{preu_2010} Euros (including VAT)<br/>
</UL>
';


/*******************************************************************************************/
// MENU VEGETARIÀ
/*******************************************************************************************/
	$translate['titol_menu_990060']=$translate['titol_menu_vegetaria']='MEN&Uacute; VEGETARIÀ';
	$translate['menu_990060']=$translate['menu_vegetaria']='En este manú se puede elegir de primero y de segundo los siguientes platos: 
<ul>
<li>Xatonada</li>
<li>Ensalada</li>
<li>Girgolas</li>
<li>Espárragos</li>
<li>Escalivada</li>
<li>Alcachofas (temporada)</li>
<li>calçots (temporada) </li>
<li>Parrillada de verduras</li>
<BR>
Incluyendo los acompañamientos (judias y patatas frits allioli pan tostado con tomate y ajo, bebida y cafés
<BR><BR>
<B>PRICE</B>


{preu_990060} Euros (including VAT)<BR>
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
12.75 Euros/unidad (including VAT)<br/>
&nbsp;<br/>';

	$translate['titol_menu_2036']=$translate['titol_menu_junior']='Men&uacute; Junior (de 10 a 14 a&ntilde;os)';
	$translate['menu_2036']=$translate['menu_2036']=$translate['menu_junior']='Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<br/>
17.71 Euros/unidad (including VAT)';

	$translate['titol_menu_2017']=$translate['titol_menu_inf_comunio']='Men&uacute; Comunión (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2017']=$translate['menu_inf_comunio']='17.66 Euros';
	
	$translate['titol_menu_2018']=$translate['titol_menu_jun_comunio']='Men&uacute; Comunión (ni&ntilde;os de 10 a 14 a&ntilde;os)';
	$translate['menu_2018']=$translate['menu_jun_comunio']='25.38 Euros';
	

	$translate['titol_menu_2021']=$translate['titol_menu_inf_casament']='Men&uacute; Boda (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2021']=$translate['menu_inf_casament']='28.07 Euros ';
	
	$translate['titol_menu_2022']=$translate['titol_menu_jun_casament']='Men&uacute; Boda (ni&ntilde;os de 10 a 14 a&ntilde;os)';
	$translate['menu_2022']=$translate['menu_jun_casament']='33.83 Euros ';
	
        
        
        $translateJS['MENUS_COMENSALS']="You should choose the same amount of menus as diners (adults + juniors + children)";
        
/*******************************************************     ERRORS   ***********************************/	
        
        
	require_once('translate_en.php');
	
        
        
        
	?>
