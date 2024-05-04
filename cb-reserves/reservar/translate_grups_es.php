<?php
if (!isset($lang)) $lang='cat';
if (!isset($PERSONES_GRUP)) $PERSONES_GRUP=12;


$translate['Realitzar pagament'] = "Realizar pago";


$translate['ANULATS__INFO_COMANDA_GRUPS']="En las reservas de grupos debes escoger, como mínimo, un menú para cada comensal (contando adultos, juniors y niños<br>"
     . "Para más de 17 comensales no está disponible la carta y será necessario que indiquéis exclusivamente menús";
$translate['INFO_COMANDA_GRUPS']="Seleccionad los platos o menús que tomaréis. Tened presente que tendréis que escoger todos platos o todos carta. <b>No se pueden combinar menús y carta en una misma reserva </b><br>"
    . "<br>"
    . "<ul><li>Si sois <b>hasta 17</b> comensales, la selección de platos <b>es opcional</b>, pero si lo deseáis, pera facilitarnos nuestro trabajo, podéis escoger platos de la carta o menús completos, pero <b>no es posible combinar carta y menús</b></li>"
    . "<li>Si sois <b>más de 17</b>, para poder completar la reserva <b>es imprescindible</b> que seleccionéis tantos menús como comensales (incluidos niños). La carta no estará disponible. </li></ul>";

$translate['Escull els menús']="Elige los menús";
 $translate['Veure els menús']='Ver los menús';
$translate['CARTA_FINS_20']="Hasta 17 comensales la selección de platos de la carta es opcional i la podréis hacer directamente en el restaurant si lo preferís";

 
 
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
	<div id="menu-2001" class="menu-content">
<p><strong>ENTRANTES</strong><br>
<i>Todo repartido en mesa</i></p>
<ul>
<li>Ensalada</li>
<li>Escalivada</li>
<li>Gírgolas</li>
<li>Espárragos a la brasa (temporada)</li>
<li>Alcachofas (temporada)</li>
<li>Judías con tocino</li>
<li>Patatas fritas</li>
<li>Alioli</li>
<li>Pan tostado con tomate</li>
</ul>
<p>&nbsp;</p>
<p><strong>PARRILLADA</strong></p>
<ul class="plat1">
<i>Individual</i><p></p>
<li>Cordero 2 piezas</li>
<li>Conejo 1/4</li>
<li>Butifarra 1/2</li>
</ul>
<p>&nbsp;</p>
<div class="complements">
<h6>COMPLEMENTOS</h6>
<p>  Si no quereis parrillada, podéis añadir complementos:</p>
<ul class="dots">
<li class="field">Costilla de ternera a la brasa  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Pies de cerdo</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacalao a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Caracoles a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>BODEGA</strong></p>
<ul>
<li>Vino de la Casa</li>
<li>Gaseosa</li>
<li>Refresc</li>
<li>Agua</li>
<li>1 cerveza incluida</li>
</ul>
<p>&nbsp;</p>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Helados</li>
</ul>
<p>&nbsp;</p>
<p><strong>CAFÉS, CORTADOS</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2001}</span> Euros/unitat adults (IVA incluido)</h6>
<h6><span class="preu">{preu_2002}</span> Euros/unitat adults amb cava (IVA incluido)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (niños de 4 a 9 años) <br><i>Macarrones, pollo rebozado o croquetas con patatas, refresco y helado</i>&nbsp;<br><span class="preu">{preu_2037}</span> Euros/unidad (IVA incluido)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años) <br>Macarrones o entremés, pollo o butifarra con patatas, refresco y helado&nbsp;<br><span class="preu">{preu_2036}</span> Euros/unidad (IVA incluido)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 1 CEL
/*******************************************************************************************/
	$translate['titol_menu_2025']=$translate['titol_menu_2024']=$translate['titol_menu_1c']='MEN&Uacute; Nº 1 CELEBRACI&Oacute;N';
	$translate['menu_2025']=$translate['menu_1c']=$translate['menu_2024']='
<div id="menu-2001" class="menu-content">
<p><strong>ENTRANTES</strong><br>
 	<i>Todo repartido en la mesa</i></p>
<ul>
<li>Ensalada</li>
<li>Escalivada</li>
<li>Gírgolas</li>
<li>Espárragos a la brasa  (temporada)</li>
<li>Alcachofas  (temporada)</li>
<li>Judías con tocino</li>
<li>Patatas fritas</li>
<li>Alioli</li>
<li>Pan tostado con tomate</li>
</ul>
<p>&nbsp;</p>
<p><strong>PARRILLADA</strong><br>
 	<i>Individual</i></p>
<ul class="plat1">
<li>Cordero 2 piezas</li>
<li>Conejo 1/4</li>
<li>Butifarra 1/2</li>
</ul>
<div class="complements">
<h6>COMPLEMENTOS</h6>
<p>  Si no quereis parrillada, podéis añadir complementos:</p>
<ul class="dots">
<li class="field">Costilla de ternera a la brasa  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Pies de cerdo</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacalao a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Caracoles a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p>&nbsp;</p>
<p><strong>BODEGA</strong></p>
<ul>
<li>Vino de la Casa</li>
<li>Gaseosa</li>
<li>Refresco</li>
<li>Agua</li>
<li>1 cerveza incluida</li>
</ul>
<p>&nbsp;</p>
<p><strong>POSTRES</strong></p>
<ul>
<li>Tarta celebración massini</li>
</ul>
<p>&nbsp;</p>
<p><strong>CAFÉS, CORTADOS</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2025}</span> Euros/unitat adults amb cava (IVA incluido)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (niños de 4 a 9 años) Macarrones, pollo rebozado o croquetas con patatas, refresco y helado&nbsp;<span class="preu">{preu_2037}</span> Euros/unidad (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años) Macarrones o entremés, pollo o butifarra con patatas, refresco y helado <span class="preu">{preu_2036}</span> Euros/unidad (IVA inclòs)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 2
/*******************************************************************************************/
	$translate['titol_menu_2003']=$translate['titol_menu_2']='MEN&Uacute; Nº 2';
	$translate['menu_2003']=$translate['menu_2']='

<div id="menu-2003" class="menu-content">
<p><i>Todo repartido en mesa</i></p>
<ul>
<li>Longaniza</li>
<li>Chorizo</li>
<li>Paté</li>
<li>Ensalada</li>
<li>Escalivada</li>
<li>All i Oli</li>
<li>Pan tostado con tomate</li>
</ul>
<p><strong>SEGUNDOS</strong></p>
<ul class="plat1">
<li>Judias con panceta</li>
<li>Patatas fritas</li>
</ul>
<div class="cb"></div>
<p><strong>PARRILLADA</strong><br>
<i>Individual</i></p>
<ul class="plat1">
<li>Cordero 2 piezas</li>
<li>Conejo 1/4</li>
<li>Butifarra 1/2</li>
</ul>
<div class="complements">
<h6>COMPLEMENTOS</h6>
<p>Si no quereis parrillada, podéis añadir complementos:</p>
<ul class="dots">
<li class="field">Costilla de ternera a la brasa <span class="field field2" style="font-size: 0.8em;"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size: 0.8em;"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Pies de cerdo</span> <span class="field field2" style="font-size: 0.8em;"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacalao a la “llauna”</span> <span class="field field2" style="font-size: 0.8em;"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Caracoles a la “llauna”</span> <span class="field field2" style="font-size: 0.8em;"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size: 0.8em;"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size: 0.8em;"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>BODEGA</strong></p>
<ul>
<li>Vino de la Casa</li>
<li>Refresco</li>
<li>Gaseosa</li>
<li>Agua</li>
<li>1 cerveza incluida</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Helados</li>
</ul>
<p><strong>CAFÉS, CORTADOS</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2003}</span> Euros/unidad adultos (IVA incluido)</h6>
<h6><span class="preu">{preu_2004}</span> Euros/unidad adultos con&nbsp;cava (IVA incluido)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (niños de 4 a 9 años)<br>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<br>
<span class="preu">{preu_2037}</span> Euros/unidad (IVA incluido)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años)<br>
Macarrones o entremés, pollo o butifarra con patatas, refresco y helado<br>
<span class="preu">{preu_2036}</span> Euros/unidad (IVA incluido)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 2 CEL
/*******************************************************************************************/
	$translate['titol_menu_2027']=$translate['titol_menu_2023']=$translate['titol_menu_2c']='MEN&Uacute; Nº 2 CELEBRACIÓN';
	$translate['menu_2027']=$translate['menu_2023']=$translate['menu_2c']=' 
<div id="menu-2001" class="menu-content">
<strong>ENTRANTES</strong><br>
<i>Todo repartido en mesa</i><p></p>
<ul>
<li>Longaniza</li>
<li>Chorizo</li>
<li>Paté</li>
<li>Ensalada</li>
<li>Escalivada</li>
<li>Alioli</li>
<li>Pan tostado con tomate</li>
</ul>
<p><strong>SEGUNDOS</strong></p>
<ul>
<li>Judías con tocino</li>
<li>Patatas fritas</li>
</ul>
<p>&nbsp;</p>
<p><strong>PARRILLADA</strong><br>
<i>Individual</i></p>
<ul class="plat1">
<li>Cordero 2 piezas</li>
<li>Conejo 1/4</li>
<li>Butifarra 1/2</li>
</ul>
<div class="complements">
<h6>COMPLEMENTOS</h6>
<p>  Si no quereis parrillada, podéis añadir complementos:</p>
<ul class="dots">
<li class="field">Costilla de ternera a la brasa  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Pies de cerdo</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacalao a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Caracoles a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p>&nbsp;</p>
<p><strong>BODEGA</strong></p>
<ul>
<li>Vino de la Casa</li>
<li>Gaseosa</li>
<li>Refresco</li>
<li>Agua</li>
<li>1 cerveza incluida</li>
</ul>
<p>&nbsp;</p>
<p><strong>POSTRES</strong></p>
<ul>
<li>Tarta celebración massini</li>
</ul>
<p><strong>CAFÉS, CORTADOS</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2027}</span> Euros/unidad adultos con&nbsp;cava (IVA incluido)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (nens de 4 a 9 años) <br>Macarrones, pollo rebozado o croquetas con patatas, refresco y helado&nbsp;<span class="preu">{preu_2037}</span> Euros/unidad (IVA incluido)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años)  <br>Macarrones o entremés, pollo o butifarra con patatas, refresco y helado&nbsp;<span class="preu">{preu_2036}</span> Euros/unidad (IVA incluido)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 3
/*******************************************************************************************/
	$translate['titol_menu_2012']=$translate['titol_menu_3']='MEN&Uacute; Nº 3';
	$translate['menu_2012']=$translate['menu_3']='
<div id="menu-2012" class="menu-content">
<style>
.dots { 
  background: url("dot.gif") repeat-x bottom; 
}
.field {
  background-color: #FFFFFF;
} 
.field2 {
 float: right;
} 
ul.plat1 {
float:left;
}
.complements{
  font-size:0.7em;
  width:350px;
border:#444 solid 1px;
border-radius:5px;
float:right;
padding:10px;
margin:10px;
}
</style>
<p><strong>ENTRANTES</strong></p>
<div id="menu-2003" class="menu-content">
<i>Todo repartido en mesa</i><p></p>
<ul>
<li>Ensalada</li>
<li>Escalivada</li>
<li>Longaniza de payés</li>
<li>Chorizo de salamanca</li>
<li>Surtido de patés</li>
<li>All i Oli</li>
<li>Pan tostado con tomate</li>
</ul>
<p><strong>PARRILLADA</strong><br>
<i>Individual</i></p>
<ul class="plat1">
<li>Butifarra a la brasa 1/2</li>
<li>Pollo a la brasa 1/4</li>
<li>Conejo a la brasa 1/4</li>
<li>Patatas fritas</li>
<li>Judias con tocino</li>
</ul>
<p>&nbsp;</p>
<div class="complements">
<h6>COMPLEMENTOS</h6>
<p>  Si no quereis parrillada, podéis añadir complementos:</p>
<ul class="dots">
<li class="field">Costilla de ternera a la brasa  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Pies de cerdo</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacalao a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Caracoles a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><strong>BODEGA</strong></p>
<ul>
<li>Vino de la Casa</li>
<li>Gaseosa</li>
<li>Refresco</li>
<li>Agua</li>
<li>1 cerveza incluida</li>
</ul>
<p>&nbsp;</p>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Helados</li>
</ul>
<p>&nbsp;</p>
<p><strong>CAFÉS, CORTADOS</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2012}</span> Euros (IVA incluido)
</div>
</div>
</div>
';

/*******************************************************************************************/
// MENU 4
/*******************************************************************************************/
	$translate['titol_menu_2007']=$translate['titol_menu_4']='MEN&Uacute; Nº 4';
	$translate['menu_2007']=$translate['menu_4']='
<div id="menu-2001" class="menu-content">
<hr>
<div class="alert alert-info">Este menú sólo estará disponible hasta 20 comensales. Si querrás más de este número avísanos con antelación</div>
<p>&nbsp;</p>
<p><strong>ENTRANTES</strong></p>
<ul>
<li>Variado de verduras<br>
<span style="color: #999999;"><em><code>(Plato por comensal)&nbsp;</code></em></span><p></p>
<ul>
<li>Pimiento</li>
<li>Berenjena</li>
<li>Calabacín</li>
<li>Espárragos</li>
<li>Alcahofas (temporada)</li>
</ul>
</li>
</ul>
<p>&nbsp;</p>
<p><strong>CARNES A LA BRASA&nbsp;</strong></p>
<p><em><code>(Ración individual a escoger)</code></em></p>
<ul class="plat1">
<li>Conejo</li>
<li>Butifarra</li>
<li>Pollo</li>
<li>Quijada de cerdo</li>
<li>Pies de cerdo</li>
<li>Secreto de cerdo a la brasa</li>
</ul>
<p>&nbsp;</p>
<p><!--


<div class="complements">
  

<h6>COMPLEMENTOS</h6>


  Si no quereis parrillada, podéis añadir complementos:
  

<ul class="dots">
    

<li class="field">Costilla de ternera a la brasa  <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2051]€</span></li>


    

<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2050]€</span></li>


    

<li><span class="field">Bacalao a la "llauna"</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2055]€</span></li>


    

<li><span class="field">Caracoles a la "llauna"</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2052]€</span></li>


    

<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2053]€</span></li>


    

<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2054]€</span></li>


  </ul>


</div>


--></p>
<div class="cb"></div>
<p><strong>GUARNICIONES</strong></p>
<ul>
<li>Judías con tocino</li>
<li>Patatas fritas</li>
<li>Alioli</li>
<li>Pan tostado con tomate</li>
</ul>
<p>&nbsp;</p>
<p><strong>BODEGA</strong></p>
<ul>
<li>Vino de la Casa</li>
<li>Gaseosa</li>
<li>Refresco</li>
<li>Agua</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Helados</li>
</ul>
<p><strong>CAFÉS, CORTADOS</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2007}</span> Euros (IVA incluido)</div>
</div>
';

/*******************************************************************************************/
// MENU comunio
/*******************************************************************************************/
	$translate['titol_menu_2013']=$translate['titol_menu_comunio']='MEN&Uacute; COMUNION';
	$translate['menu_2013']=$translate['menu_comunio']='
<div id="menu-2001" class="menu-content">
<p><strong>VERMUT</strong></p>
<ul>
<li>Cerveza</li>
<li>Refresco</li>
</ul>
<p><strong>APERITIVO</strong></p>
<ul>
<li>Patatas chips</li>
<li>Almendras saladas</li>
<li>Aceitunas rellenas</li>
<li>Calamares a la romana</li>
<li>Tacos tortilla</li>
</ul>
<p>&nbsp;</p>
<p><strong>PRIMEROS</strong></p>
<ul>
<li>Entremeses individual</li>
<li>Ensalada y Patés</li>
<li>Pan tostado con tomate</li>
</ul>
<p>&nbsp;</p>
<p><strong>SEGUNDOS (Parrillada)</strong></p>
<ul>
<li>Patatas fritas</li>
<li>Cordero</li>
<li>Butifarra negra</li>
<li>Conejo</li>
<li>Pollo</li>
<li>Butifarra</li>
<li>Alioli</li>
</ul>
<p>&nbsp;</p>
<p><strong>PASTEL DE CELEBRACIÓN</strong><br>
<strong>BODEGA</strong></p>
<ul>
<li>Vino Cabernet tinto o rosado</li>
<li>Cava Brut Reserva</li>
<li>Agua y refrescos</li>
</ul>
<p><strong>CAFÉS, CORTADOS</strong><br>
<b>Incluido centro de flores</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2013}</span> Euros (IVA incluido)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (niños de 4 a 9 años) <span class="preu">{preu_2017}</span> Euros/unidad (IVA incluido)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años) <span class="preu">{preu_2018}</span> Euros/unidad (IVA incluido)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU casament
/*******************************************************************************************/
	$translate['titol_menu_2016']=$translate['titol_menu_casament']='MEN&Uacute; BODA';
	$translate['menu_2016']=$translate['menu_casament']='
<div id="menu-2001" class="menu-content">
<p><strong>APERITVO</strong></p>
<ul>
<li>Lagostinos</li>
<li>Patatas chips</li>
<li>Almendras saladas</li>
<li>Aceitunas rellenas</li>
<li>Calamares a la romana</li>
<li>Tacos tortilla</li>
<li>Sorbete</li>
</ul>
<p>&nbsp;</p>
<p><strong>PRIMEROS</strong></p>
<ul>
<li>Entremeses</li>
<li>Ensalada</li>
<li>Escalivada</li>
<li>Espárragos</li>
<li>Gírgolas</li>
<li>Pan tostado con tomate</li>
</ul>
<p>&nbsp;</p>
<p><strong>SEGUNDOS (Parrillada)</strong></p>
<ul>
<li>Cordero</li>
<li>Butifarra negra</li>
<li>Conejo</li>
<li>Pollo</li>
<li>Butifarra</li>
<li>Alioli</li>
</ul>
<p>&nbsp;</p>
<p><strong>PASTEL DE BODA</strong><br>
<strong>BODEGA</strong></p>
<ul>
<li>Vino Cabernet tinto o rosado</li>
<li>Cava Brut Reserva Sardà</li>
<li>Agua y refrescos</li>
</ul>
<p>&nbsp;</p>
<p><strong>CAFÉS, CORTADOS</strong><br>
<b>Guarnición de flores</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2016}</span> Euros (IVA incluido)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (niños de 4 a 9 años) <span class="preu">{preu_2021}</span> Euros/unitdad (IVA incluido)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años) <span class="preu">{preu_2022}</span> Euros/unitdad (IVA incluido)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU calsots
/*******************************************************************************************/
	$translate['titol_menu_2010']=$translate['titol_menu_calsots']='MEN&Uacute; CALÇOTADA';
	$translate['menu_2010']=$translate['menu_calsots']='
<div id="menu-2010" class="menu-content">
<p><b>ENTRANTES</b></p>
<ul>
<li>CALÇOTS (temporada)<br>
    <i><code>Sin límite de calçots</code><p></p>
</i><p><i><code>No combinable con otros menús (todos debéis pedir calçotada)</code><br>
</i></p>
</li>
<li>Judías con tocino</li>
<li>Patatas fritas</li>
<li>Alioli</li>
<li>Pan tostado con tomate</li>
</ul>
<p><b>PARRILLADA (individual)</b></p>
<ul class="plat1">
<li>Cordero (2 piezas)</li>
<li>Conejo (1/4)</li>
<li>Butifarra (1/2)</li>
</ul>
<div class="complements">
<h6>COMPLEMENTOS</h6>
<p>  Si no quereis parrillada, podéis añadir complementos:</p>
<ul class="dots">
<li class="field">Costilla de ternera a la brasa  <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espalda de cordero a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Pies de cerdo</span> <span class="field field2" style="font-size:0.8em"><span class="preu">4.00</span>€</span></li>
<li><span class="field">Bacalao a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Caracoles a la “llauna”</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Dorada a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Lubina a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>BODEGA</b></p>
<ul>
<li>Vino de la Casa</li>
<li>Gaseosa</li>
<li>Refresc</li>
<li>Agua</li>
<li>1 Cerveza incluida</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Copa sorbete limón</li>
</ul>
<p><b>CAFÉS, CORTADOS</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2010}</span> Euros/unitat adults (IVA inclòs)</h6>
<h6><span class="preu">{preu_2011}</span> Euros/unitat adults con cava (IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (niños de 4 a 9 años)<br>
Macarrones, pollo rebozado o croquetas con patatas, refresco y helado<br>
<span class="preu">{preu_2037}</span> Euros/unidad (IVA incluido)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 años)<br>
Macarrones o entremés, pollo o butifarra con patatas, refresco y helado<br>
<span class="preu">{preu_2036}</span> Euros/unidad (IVA incluido)</h6>
</div>
</div>
';


/*******************************************************************************************/
// MENU VEGETARIÀ
/*******************************************************************************************/
	$translate['titol_menu_990060']=$translate['titol_menu_vegetaria']='MEN&Uacute; VEGETARIÀ';
	$translate['menu_990060']=$translate['menu_vegetaria']='
<div id="menu-2008" class="menu-content">
<p><b>En este menú se puede elegir uno de los siguientes platos:</b></p>
<ul>
<li>Xatonada</li>
<li>Ensalada</li>
<li>Girgolas</li>
<li>Espárragos</li>
<li>Escalivada</li>
<li>Alcachofas (temporada)</li>
<li>calçots (temporada)</li>
<li>Parrillada de verduras</li>
</ul>
<p><b>Incluyendo los acompañamientos</b></p>
<ul>
<li>Judías</li>
<li>Patatas fritas</li>
<li>All i oli</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Fruta</li>
<li>Crema catalana</li>
<li>Flan casero</li>
<li>Helado</li>
</ul>
<p><b>Bebida y café </b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2008}</span> Euros (IVA incluido)
</div>
</div>
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
	
        $translate['AVIS_MODIFICACIONS']='<span style = "color: red"> <b>Atención: </b> </span> Hasta 12 horas antes de la reserva <b> podrá comunicar cualquier variación </b> en el número de cubiertos llamando de 10 a 11 de la mañana al <b> 935 803 632 </b> o al<b> 936 929 723 </b>.
<br/> Con menos de 24 horas de antelación <b> no admitiremos ninguna modificación </b> 
en la reserva y dispondrà exclusivamente de las plazas que tiene confirmadas. <br/> 
Antes de ese día, también puede editar la reserva en este mismo apartado. 

<br><div style="background-color:#feffb2;padding:4px;margin:12px 0;"><span style="color:red"><b>IMPORTANTE: </b></span><b>Se cobrarán {import_no_assitencia}€ por cada comensal 
                                    que no asista al restaurant.</b></div>

<span class = "tanca-avis" style = ""> <a href="#"> cierra </a> </span>';

        
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
