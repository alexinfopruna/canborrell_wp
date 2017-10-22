<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;


$translate['Realitzar pagament'] = "Realizar pago";


$translate['INFO_COMANDA_GRUPS']="En las reservas de grupos debes escoger, como mínimo, un menú para cada comensal (contando adultos, juniors y niños<br>"
     . "Para más de 20 comensales no está disponible la carta y será necessario que indiquéis exclusivamente menús";
$translate['Escull els menús']="Elige los menús";
 $translate['Veure els menús']='Ver los menús';

$translate['INFO_QUANTS_SOU_GRUPS']='<b>Dinos cuantas personas vendrán,</b> indicando en primer lugar los mayores de 14 años. Indica también el número de juniors y niños. 
		<br/> <br/>
<b>Reservaremos espacio para los comensales que nos indicas aquí. La reserva no será válida para un número de persones que no coincida con el solicitado</b>
			 <br/>
		<b>(NO PODEMOS GARANTIZAR LA DISPONIBILIDAD DE TRONAS).</b><br/>
<br/> <br/>
		Solo aceptamos perros guía acompañando a invidentes
<br/> <br/>
		<em> Si, en total, sois menos de <b> '. ($PERSONES_GRUP ).'</b> personas, marca el botón "<='. ($PERSONES_GRUP-1 ).'" </em> <br/> <br/>
<b> TOTAL PERSONAS: ';

	$translate['INFO_CARTA_GRUPS']='Debes indicar el menú para los adultos.
	<br/><strong style="font-size:1.2em">Si han de venir niños/junior, es necesario que indiques también qué menú queréis para ellos</strong>
			<br/><br/>
Para vegetarianos disponemos de un menú de verduras a la brasa por 25€. Añade un comentario en el campo <b>Observaciones</b>, en el siguiente paso, para hacérnoslo saber.';
     

        
        
$translate['Escull el menú']='Escoge el menú';
$translate['Menú per a adults']='Menú para adultos';
$translate['Menú per a juniors']='Menú para juniors (niños de 10 a 14 años)';
$translate['Menú per a nens']='Menú para niños (niños de 4 a 9 años)';


$translate['ALERTA_INFO_GRUPS']='La <b>solicitud</b> de reserva ha sido enviada.
<br/><br/>
<b>Esto NO significa que esté confirmada</b>.
<br/><br/>
Tenemos que verificar la disponibilidad de mesa para el dia que has solicitado. 
En breve recibirás un correo electrónico en el que te informaremos de si, finalmente, hemos podido reservar mesa para vosotros y cómo continuar el proceso para confirmar la reserva<br/> <br/>
Revisa tu correo en las próximas horas y ten presente que <b>TODAVIA NO ESTÁ CONFIRMADA LA RESERVA</b>




<br/><br/>

<div class="alert alert-danger">
Si tenéis que <b>modificar</b> el número de cubiertos, nos lo debéis comunicar, como mínimo, <b>3 días antes de la reserva </b> al email restaurant@can-borrell.com o llamando al 936929723 / 936910605 
</div>

<br/> <br/>


Siempre contestamos las solicitudes en un plazo de un día.
Si pasadas 24 horas no has recibido respuesta puede tratarse de un problema con el correo electrónico.
Comprueba la carpeta de spam y, si no localizas el mail del restaurante,
ponte en contacto con nosotros con un correo electrónico y facilítanos:
<ul>
<li>
Otra dirección donde responderte
</li>
<li>
		Tu nombre
</li>
<li>
La fecha para la que pides la reserva
</li>
<li>
El número de comensales
</li>
</ul>

<br/><br/>
El importe de la paga y señal será descontado del precio final, de manera que no representará un gasto extra, 
ni en el caso de que modifiquéis el número de comensales al confirmar la reserva.'						
.'<div class = "info-paga-i-senyal"> Atención: Si no puedes venir el día de la reserva <b>puedes recuperar la paga y señal si nos avisas con 48 horas de \ antelación</b>. En caso contrario, el \ importe abonado no será devuelto </div> '
.'<br/><br/>Gracias por utilizar este servicio.<br/><br/>';






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
Lomo<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<br/>Refreco<br/>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Tarta Selva trufa<br/>
Tarta de limón<br/>
Tarta whisky<br/>
Copa sorbete limón<br/>
Crema catalana<br/>
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>
<br/>
<B>PRECIO</B>
<UL>
{preu_2001} Euros/unidad adultos (IVA incluido)<br/>
{preu_2002} Euros/unidad adultos con cava (IVA incluido)<br/>
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
Lomo<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<br/>Refreco<br/>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Pastel y cava
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>
<br/>
<B>PRECIO</B>
<UL>
{preu_2024} Euros/unidad adultos sin cava (IVA incluido)<br/>
{preu_2025} Euros/unidad adultos con cava (IVA incluido)<br/>
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
Lomo<br/>
Butifarra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<br/>Refreco<br/>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Tarta whisky<br/>
Flan biscuit<br/>
Crema catalana<br/
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>
<P>&nbsp;<br/>
<B>PRECIO</B>
<UL>
{preu_2003} Euros/unidad adultos sin cava (IVA incluido)<br/>
{preu_2004} Euros/unidad adultos con cava (IVA incluido)<br/>
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
Lomo<br/>
Butifarra<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<br/>Refreco<br/>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Pastel y cava
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>
<br/>
<B>PRECIO</B>
<UL>
{preu_2023} Euros/unidad adultos sin cava (IVA incluido)<br/>
{preu_2027} Euros/unidad adultos con cava (IVA incluido)<br/>
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
Agua<br/>Refreco<br/>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Tarta de lim&oacute;n<br/>
Tarta Selva trufa<br/>
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>
<br/>
<B>PRECIO</B>
<UL>
{preu_2012} Euros (IVA incluido)
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
  Agua<br/>Refreco<br/>
  &nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
  Mus de lim&oacute;n<br/>
  Tarta Selva trufa<br/>
  Vastigo Turr&oacute;n<br/>
  Falm 
  <br/>
  &nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS </B><br/>

<br/>
</B>
<B>PRECIO</B>
<UL>
  {preu_2007} Euros (IVA incluido)
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
Lomo<br/>
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
<B>PRECIO</B>
<UL>
{preu_2013} Euros (IVA incluido)<br/>
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
Lomo<br/>
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
<B>PRECIO</B>
<UL>
{preu_2016} Euros (IVA incluido)<br/>
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
Lomo<br/>
&nbsp;<br/>
</UL>
<B>BODEGA</B>
<UL>
Vino de la Casa<br/>
Gaseosa<br/>
Agua<br/>Refreco<br/>
&nbsp;<br/>
</UL>
<B>POSTRES</B>
<UL>
Pastel de crema catalana de la casa<br/>
Tarta whisky<br/>
Copa sorbete de limón<br/>
&nbsp;<br/>
</UL>
<B>CAF&Eacute;S, CORTADOS o CARAJILLOS</B><br/>
&nbsp;<br/>
<B>PRECIO</B>
<UL>
{preu_2010} Euros (IVA incluido)<br/>
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
<B>PRECIO</B>


{preu_2008} Euros (IVA incluido)<BR>
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
12.75 Euros/unidad (IVA incluido)<br/>
&nbsp;<br/>';

	$translate['titol_menu_2036']=$translate['titol_menu_junior']='Men&uacute; Junior (de 10 a 14 a&ntilde;os)';
	$translate['menu_2036']=$translate['menu_2036']=$translate['menu_junior']='Macarrones o entrem&eacute;s, pollo o butifarra con patatas, refresco y helado<br/>
17.71 Euros/unidad (IVA incluido)';

	$translate['titol_menu_2017']=$translate['titol_menu_inf_comunio']='Men&uacute; Comunión (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2017']=$translate['menu_inf_comunio']='17.66 Euros';
	
	$translate['titol_menu_2018']=$translate['titol_menu_jun_comunio']='Men&uacute; Comunión (ni&ntilde;os de 10 a 14 a&ntilde;os)';
	$translate['menu_2018']=$translate['menu_jun_comunio']='25.38 Euros';
	

	$translate['titol_menu_2021']=$translate['titol_menu_inf_casament']='Men&uacute; Boda (ni&ntilde;os de 4 a 9 a&ntilde;os)';
	$translate['menu_2021']=$translate['menu_inf_casament']='28.07 Euros ';
	
	$translate['titol_menu_2022']=$translate['titol_menu_jun_casament']='Men&uacute; Boda (ni&ntilde;os de 10 a 14 a&ntilde;os)';
	$translate['menu_2022']=$translate['menu_jun_casament']='33.83 Euros ';
	
        
        
        $translateJS['MENUS_COMENSALS']="Debes escoger tantos menús como comensales (adultos + juniors + niños)";
        
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
        
        
        
	require_once('translate_es.php');
	
        
        
        
	?>
