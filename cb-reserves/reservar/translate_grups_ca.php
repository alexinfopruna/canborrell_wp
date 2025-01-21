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
Et demanarem una <b>preautorització</b> de la targeta de crèdit per confirmar la reserva. <b>Aquesta operació no suposa cap càrrec a la teva targeta</b> Només es realitzarà el càrrec en cas de no comparèixer el dia de la reserva.
No es realitzarà cap càrrec si cancel·les la reserva amb 48 hores d\'antelació.'
        
.'<br/><br/>Gracies per utilitzar aquest servei.<br/><br/>';

$translate['ANULAT____INFO_COMANDA_GRUPS']="Per les reserves de més de 17 persones has d'escollir, com a mínim, un menú/plat per cada comensal (comptant adults, juniors nens)<br>"
    . "Per més de 17 comensals no està disponible la carta, i és necessari que indiqueu exclussivament menús";
$translate['INFO_COMANDA_GRUPS']="Seleccioneu els plats o menús que prendreu. Tingueu present que haureu de triar tots carta o tots menús i que <b>no es poden combinar menús i carta en una mateixa reserva </b><br>"
    . "<br>"
    . "<ul><li>Si sou <b>fins a 17</b> comensals, la selecció de plats <b>és opcional</b>, però si ho desitgeu, per facilitar-nos la nostra feina, podeu triar plats de la carta o menús complerts, però <b>no podeu combinar carta i menús</b></li>"
    . "<li>Si sou <b>més de 17</b>, per poder completar la reserva <b>és imprescindible</b> que seleccioneu tants menús com comensals (inclosos els nens). La carta no estarà disponible. </li></ul>";

$translate['MENUS_COMENSALS']="Has d'escollir tants menús com comensals (adults + juniors + nens)";
$translate['CARTA_FINS_20']="Fins a 21 comensals la selecció de plats de la carta és opcional i la podreu fer directament al restaurant si ho preferiu";





// LLISTAT MENUS

/*******************************************************************************************/
// MENU 1
/*******************************************************************************************/
	$translate['titol_menu_2001']=$translate['titol_menu_1']='Menú nº1';
	$translate['menu_2001']=$translate['menu_1']='
<b>ENTRANTS</b><br>
<i>Tot repartit a taula</i><p></p>
<ul>
<li>Amanida</li>
<li>Escalivada</li>
<li>Gírgoles</li>
<li>Espàrrecs brasa  (temporada)</li>
<li>Carxofes (temporada)</li>
<li>Mongetes amb cansalada</li>
<li>Patates fregides</li>
<li>All i Oli</li>
<li>Pa torrat amb tomàquet</li>
</ul>
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
<p><b>GRAELLADA</b><br>
<i>Individual</i></p>
<ul class="plat1">
<li>Xai 2 peces</li>
<li>Conill 1/4</li>
<li>Botifarra 1/2</li>
</ul>
<div class="complements">
<h6>COMPLEMENTS</h6>
<p>  Si no voleu graellada, podeu afegir complements:</p>
<ul class="dots">
<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Peus de porc</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>CELLER</b></p>
<ul>
<li>Vi de la Casa</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
<li>1 cervessa inclosa</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Gelats</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2001}</span> Euros/unitat adults (IVA inclòs)</h6>
<h6><span class="preu">{preu_2002}</span> Euros/unitat adults amb cava (IVA inclòs)</h6>
<p><span style="font-size:0.8em"></span></p>
<hr>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<i>Macarrons, pollastre arrebossat o croquetes amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unitat (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Junior</span> (de 10 a 14 anys)<br>
<i>Macarrons o entremès, pollastre o botifarra amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2036}</span> Euros/unitat (IVA inclòs)</h6>
<p>
</p></div>
';

/*******************************************************************************************/
// MENU 1 CEL
/*******************************************************************************************/
	$translate['titol_menu_2025']=$translate['titol_menu_2024']=$translate['titol_menu_1c']='MEN&Uacute; Nº 1 CELEBRACI&Oacute;';
	$translate['menu_2025']=$translate['menu_2024']=$translate['menu_1c']='
<div id="menu-2024" class="menu-content">
<b>ENTRANTS</b><br>
<i>Tot repartit a la taula</i><br>
<ul><p></p>
<li>Amanida</li>
<li>Escalivada</li>
<li>Gírgoles</li>
<li>Espàrrecs brasa (temporada)</li>
<li>Carxofes (temporada)</li>
<li>Mongetes amb cansalada</li>
<li>Patates fregides</li>
<li>All i Oli</li>
<li>Pa torrat amb tomàquet</li>
<p></p></ul><br>
<b>GRAELLADA</b><br>
<i>Individual</i><p></p>
<p></p><ul class="plat1"><p></p>
<li>Xai 2 peces</li>
<li>Conill 1/4</li>
<li>Botifarra 1/2</li>
<p></p></ul><p></p>
<div class="complements">
<h6>COMPLEMENTS</h6>
<p>  Si no voleu graellada, podeu afegir complements:</p>
<ul class="dots">
<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Peus de porc</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>CELLER</b><br>
</p><ul><p></p>
<li>Vi de la Casa</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
<li>1 cervessa inclosa</li>
<p></p></ul><br>
<b>POSTRES</b><br>
<ul><p></p>
<li>Pastís celebració massini</li>
<p></p></ul><br>
<b>CAFÈS, TALLATS</b><p></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2025}</span> Euros/unitat adults amb cava (IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<i>Macarrons, pollastre arrebossat o croquetes amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unitat (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Junior</span> (de 10 a 14 anys)<br>
<i>Macarrons o entremès, pollastre o botifarra amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2036}</span> Euros/unitat (IVA inclòs)</h6>
</div>
';

/*******************************************************************************************/
// MENU 2
/*******************************************************************************************/
	$translate['titol_menu_2003']=$translate['titol_menu_2']='MEN&Uacute; Nº 2';
	$translate['menu_2003']=$translate['menu_2']='
<i>Tot repartit a taula</i><p></p>
<ul>
<li>Llonganissa</li>
<li>Xoriço</li>
<li>Paté</li>
<li>Amanida</li>
<li>Escalivada</li>
<li>All i Oli</li>
<li>Pa torrat amb tomàquet</li>
</ul>
<p><b>SEGONS</b></p>
<ul>
<li>Mongetes amb cansalada</li>
<li>Patates fregides</li>
</ul>
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
<p><b>GRAELLADA</b><br>
<i>Individual</i></p>
<ul class="plat1">
<li>Xai 2 peces</li>
<li>Conill 1/4</li>
<li>Botifarra 1/2</li>
</ul>
<div class="complements">
<h6>COMPLEMENTS</h6>
<p>  Si no voleu graellada, podeu afegir complements:</p>
<ul class="dots">
<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Peus de porc</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>CELLER</b></p>
<ul>
<li>Vi de la Casa</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
<li>1 cervessa inclosa</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Gelats</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<div class="carta-fotos"></div>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2003}</span> Euros/unitat adults (IVA inclòs)</h6>
<h6><span class="preu">{preu_2004}</span> Euros/unitat adults amb cava (IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<i>Macarrons, pollastre arrebossat o croquetes amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unitat (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 anys)<br>
<i>Macarrons o entremès, pollastre o botifarra amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unitat (IVA inclòs)</h6>
</div>
';

/*******************************************************************************************/
// MENU 2 CEL
/*******************************************************************************************/
	$translate['titol_menu_2027']=$translate['titol_menu_2023']=$translate['titol_menu_2c']='MEN&Uacute; Nº 2 CELEBRACIÓ';
	$translate['menu_2027']=$translate['menu_2023']=$translate['menu_2c']='
<div id="menu-2027" class="menu-content">
<b>ENTRANTS</b><br>
<i>Tot repartit a taula</i><p></p>
<p></p><ul><p></p>
<li>Llonganissa</li>
<li>Xoriço</li>
<li>Paté</li>
<li>Amanida</li>
<li>Escalivada</li>
<li>All i Oli</li>
<li>Pa torrat amb tomàquet</li>
<p></p></ul><br>
<b>SEGONS</b><br>
<ul><p></p>
<li>Mongetes amb cansalada</li>
<li>Patates fregides</li>
<p></p></ul><br>
<b>GRAELLADA</b><br>
<i>Individual</i><p></p>
<ul class="plat1">
<li>Xai 2 peces</li>
<li>Conill 1/4</li>
<li>Botifarra 1/2</li>
</ul>
<div class="complements">
<h6>COMPLEMENTS</h6>
<p>  Si no voleu graellada, podeu afegir complements:</p>
<ul class="dots">
<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Peus de porc</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>CELLER</b><br>
</p><ul><p></p>
<li>Vi de la Casa</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
<li>1 cervessa inclosa</li>
<p></p></ul><br>
<b>POSTRES</b><br>
<ul><p></p>
<li>Pastís celebració massini</li>
<p></p></ul><br>
<b>CAFÈS, TALLATS</b><p></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2027}</span> Euros/unitat adults amb cava (IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<i>Macarrons, pollastre arrebossat o croquetes amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unitat (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Junior</span> (de 10 a 14 anys)<br>
<i>Macarrons o entremès, pollastre o botifarra amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2036}</span> Euros/unitat (IVA inclòs)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU 3
/*******************************************************************************************/
	$translate['titol_menu_2012']=$translate['titol_menu_3']='MEN&Uacute; Nº 3';
	$translate['menu_2012']=$translate['menu_3']='
<div id="menu-2001" class="menu-content"><b>ENTRANTS</b><br>
<i>Tot repartit a taula</i><p></p>
<ul>
<li>Amanida</li>
<li>Escalivada</li>
<li>Assortit de patés</li>
<li>Llonganissa de pagés</li>
<li>Xoriço de Salamanca</li>
<li>Pa torrat amb tomàquet i alls</li>
<li>All i Oli</li>
</ul>
<p><b>GRAELLADA</b><br>
<i>Individual</i></p>
<ul class="plat1">
<li>Botifarra a la brasa 1/2</li>
<li>Pollastre a la brasa 1/4</li>
<li>Conill a la brasa 1/4</li>
<li>Patates fregides</li>
<li>Mongeta amb cansalada</li>
</ul>
<div class="complements">
<h6>COMPLEMENTS</h6>
<p>  Si no voleu graellada, podeu afegir complements:</p>
<ul class="dots">
<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Peus de porc</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.25</span>€</span></li>
<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>CELLER</b></p>
<ul>
<li>Vi de la Casa</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
<li>1 cervessa inclosa</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Gelats</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2012}</span> Euros (IVA inclòs)</div>
</div>

';

/*******************************************************************************************/
// MENU 4
/*******************************************************************************************/
	$translate['titol_menu_2007']=$translate['titol_menu_4']='MEN&Uacute; Nº 4';
	$translate['menu_2007']=$translate['menu_4']='
<div id="menu-2007" class="menu-content">
<ul>
<li>Variat de verdures a la brasa amb romesco<br>
<code>(Plat per comensal)</code><p></p>
<ul>
<li>Pebrot</li>
<li>Albergínia</li>
<li>Carbassó</li>
<li>Esparrecs</li>
<li>Carxofes (temporada)</li>
</ul>
</li>
</ul>
<p><b>CARNS A LA BRASA</b></p>
<p><i><code>(Ració individual a escollir)</code></i></p>
<ul class="plat1">
<li>Conill brasa</li>
<li>Botifarra brasa</li>
<li>Pollastre brasa</li>
<li>Galta de porc brasa</li>
<li>Peus de porc brasa</li>
</ul>
<p>&nbsp;</p>
<p><!--


<div class="complements">
  

<h6>COMPLEMENTS</h6>


  Si no voleu graellada, podeu afegir complements:
  

<ul class="dots">
    

<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2051]€</span></li>


    

<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2050]€</span></li>


    

<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2055]€</span></li>


    

<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2052]€</span></li>


    

<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2053]€</span></li>


    

<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em">[cb_preu_plat id=2054]€</span></li>


  </ul>


</div>

--></p>
<div class="cb"></div>
<p><b>GUARNICIONS (ració individual)</b></p>
<ul>
<li>Mongetes amb cansalada</li>
<li>Patates fregides</li>
<li>All i oli</li>
<li>Pa torrat amb tomàquet</li>
</ul>
<p><b>CELLER</b></p>
<ul>
<li>Vi de la Casa o sangria</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Gelats</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2007}</span> Euros (IVA inclòs)</div>
</div>
';

/*******************************************************************************************/
// MENU comunio
/*******************************************************************************************/
	$translate['titol_menu_2013']=$translate['titol_menu_comunio']='MEN&Uacute; COMUNIÓ';
	$translate['menu_2013']=$translate['menu_comunio']='
<div id="menu-2001" class="menu-content">
<p><b>VERMUT</b></p>
<ul>
<li>Cervessa</li>
<li>Refresc</li>
</ul>
<p>&nbsp;</p>
<p><b>APERITU</b></p>
<ul>
<li>Patates xips</li>
<li>Atmetlles salades</li>
<li>Olives farcides</li>
<li>Calamars a la romana</li>
<li>Tacs truita</li>
</ul>
<p><b>PRIMERS</b></p>
<ul>
<li>Entremesos individual</li>
<li>Amanida i paté</li>
<li>Pa torrat amb tomàquet</li>
</ul>
<p><b>SEGONS (Graellada)</b></p>
<ul>
<li>Patates fregides</li>
<li>Be</li>
<li>Conill</li>
<li>Pollastre</li>
<li>Botifarra</li>
<li>Botifarra negra</li>
<li>All i Oli</li>
</ul>
<p><b>PASTÍS DE CELEBRACIÓ</b></p>
<p>&nbsp;</p>
<p><b>CELLER</b></p>
<ul>
<li>Vi Cabernet negre o rosat</li>
<li>Cava brut reserva</li>
<li>Aigua i refrescs</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<p>&nbsp;</p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2013}</span> Euros (IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<span class="preu">{preu_2017}</span> Euros/unitat (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 anys)<br>
<span class="preu">{preu_2018}</span> Euros/unitat (IVA inclòs)</h6>
</div>
</div>
';

/*******************************************************************************************/
// MENU casament
/*******************************************************************************************/
	$translate['titol_menu_2016']=$translate['titol_menu_casament']='MEN&Uacute; CASAMENT';
	$translate['menu_2016']=$translate['menu_casament']='
<div id="menu-2001" class="menu-content">
<p><b>APERITIU</b></p>
<ul>
<li>Llagostins</li>
<li>Patates xips</li>
<li>Atmetlles salades</li>
<li>Olives farcides</li>
<li>Calamars a la romana</li>
<li>Tacs truita</li>
<li>Sorbet</li>
</ul>
<p><b>PRIMERS</b></p>
<ul>
<li>Entremesos</li>
<li>Amanida</li>
<li>Escalivada</li>
<li>Espàrrecs</li>
<li>Gírgoles</li>
<li>Pa torrat amb tomàquet</li>
</ul>
<p><b>SEGONS (Graellada)</b></p>
<ul>
<li>Xai</li>
<li>Conill</li>
<li>Pollastre</li>
<li>Botifarra</li>
<li>Botifarra negra</li>
<li>All i Oli</li>
</ul>
<p><b>PASTÍS DE CASAMENT</b></p>
<p>&nbsp;</p>
<p><b>CELLER</b></p>
<ul>
<li>Vi Cabernet negre o rosat</li>
<li>Cava Brut Reserva Sardà</li>
<li>Aigua i refrescs</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<p>&nbsp;</p>
<p><b>Guarnició de flors</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2016}</span> Euros (IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Infantil</span> (nens de 4 a 9 anys)</h6>
<span class="preu">{preu_2021}</span> Euros/unitat (IVA inclòs)<p></p>
<h6 class="infantil"><span style="font-weight: bold;"> – Menú Junior</span> (de 10 a 14 anys)</h6>
<span class="preu">{preu_2022}</span> Euros/unitat (IVA inclòs)<p></p>
</div>
</div>
';

/*******************************************************************************************/
// MENU calsots
/*******************************************************************************************/
$translate['titol_menu_2010']=$translate['titol_menu_calsots']='MEN&Uacute; CALÇOTADA';
$translate['menu_2010']=$translate['menu_calsots']='
<div id="menu-2010" class="menu-content">
<b>ENTRANTS</b><br>
<ul><p></p>
<li>CALÇOTS (temporada)<br>
    <i><code>Sense límit de calçots</code><br>
<code>No combinable amb altres menús (tots heu de demanar calçotada)</code><br>
</i>
</li>
<li>Mongetes amb cansalada</li>
<li>Patates fregides</li>
<li>All i oli</li>
<li>Pa torrat amb tomàquet</li>
<p></p></ul><br>
<b>GRAELLADA (individual)</b><br>
<ul class="plat1"><p></p>
<li>Xai (2 peces)</li>
<li>Conill (1/4)</li>
<li>Botifarra (1/2)</li>
<p></p></ul><p></p>
<div class="complements">
<h6>COMPLEMENTS</h6>
<p>  Si no voleu graellada, podeu afegir complements:</p>
<ul class="dots">
<li class="field">Costella de vedella a la brasa <span class="field field2" style="font-size:0.8em"><span class="preu">9.50</span>€</span></li>
<li><span class="field">Espatlla de xai a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">10.40</span>€</span></li>
<li><span class="field">Peus de porc</span> <span class="field field2" style="font-size:0.8em"><span class="preu">4.00</span>€</span></li>
<li><span class="field">Bacallà a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Cargols a la llauna</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Moixarra a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
<li><span class="field">Llobarro a la brasa</span> <span class="field field2" style="font-size:0.8em"><span class="preu">8.50</span>€</span></li>
</ul>
</div>
<div class="cb"></div>
<p><b>CELLER</b></p>
<ul>
<li>Vi de la Casa</li>
<li>Gasosa</li>
<li>Refresc</li>
<li>Aigua</li>
<li>1 Cervessa inclosa</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Copa sorbet llimona</li>
</ul>
<p><b>CAFÈS, TALLATS</b></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<h6><span class="preu">{preu_2010}</span> Euros/unitat adults (IVA inclòs)</h6>
<h6><span class="preu">{preu_2011}</span> Euros/unitat adults amb cava(IVA inclòs)</h6>
<hr>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Infantil</span> (nens de 4 a 9 anys)<br>
<i>Macarrons, pollastre arrebossat o croquetes amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2037}</span> Euros/unitat (IVA inclòs)</h6>
<h6 class="infantil"><span style="font-weight:bold"> – Menú Junior</span> (de 10 a 14 anys)<br>
<i>Macarrons o entremès, pollastre o botifarra amb patates, refresc i gelat</i><br>
<span class="preu">{preu_2036}</span> Euros/unitat (IVA inclòs)</h6>
</div>
</div>';

/*******************************************************************************************/
// MENU VEGETARIÀ
/*******************************************************************************************/
	$translate['titol_menu_990060']=$translate['titol_menu_vegetaria']='MEN&Uacute; VEGETARIÀ';
	$translate['menu_990060']=$translate['menu_vegetaria']='
<div id="menu-2008" class="menu-content">
<p><b>En aquest Menú es pot escollir un dels següents plats:</b></p>
<ul>
<li>Xatonada</li>
<li>Amanida</li>
<li>Gírgoles</li>
<li>Espàrrecs</li>
<li>Escalivada</li>
<li>Carxofes (temporada)</li>
<p> 	<!-- 

<li>Calçots (temporada)</li>

  --></p>
<li>Graellada de verdures</li>
</ul>
<p><strong>Incloent-hi els complements</strong></p>
<ul>
<li>Mongetes</li>
<li>Patates fregides</li>
<li>Allioli</li>
<li>pa torrat amb tomàquet i alls</li>
</ul>
<p><b>POSTRES</b></p>
<ul>
<li>Fruita</li>
<li>Crema catalana</li>
<li>Flam casolà</li>
<li>Gelat</li>
</ul>
<p><strong>Beguda i cafès</strong></p>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2008}</span> Euros (IVA inclòs)
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
<div id="menu-2037" class="menu-content">
<ul>
<li>Macarrons</li>
<li>Pollastre arrebossat o Croquetes amb patates</li>
<li>Refresc</li>
<li>Gelat</li>
</ul>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left"><span class="preu">{preu_2037}</span> Euros (IVA inclòs)
</div>
</div>';

                              $translate['titol_menu_2036']=$translate['titol_menu_junior']='Men&uacute; Junior (de 10 a 14 a&ntilde;os)';
                              $translate['menu_2036']=$translate['menu_junior']='
<div id="menu-2001" class="menu-content">
<ul>
<li>Macarrons o entremès</li>
<li>Pollastre o botifarra amb patates</li>
<li>Refresc</li>
<li>Gelat</li>
</ul>
<div id="ressenya" class="caixa-preus caixa-negre caixa-left">
<span class="preu">{preu_2036}</span> Euros (IVA inclòs)
</div>
</div>';

                              $translate['titol_menu_2017']=$translate['titol_menu_inf_comunio']='
Men&uacute; Comunión (ni&ntilde;os de 4 a 9 a&ntilde;os)';
                              $translate['menu_2017']=$translate['menu_inf_comunio']='{preu_2017} Euros';

                              $translate['titol_menu_2018']=$translate['titol_menu_jun_comunio']='Men&uacute; Comunión (ni&ntilde;os de 10 a 14 a&ntilde;os)';
                              $translate['menu_2018']=$translate['menu_jun_comunio']='{preu_2018} Euros';


                              $translate['titol_menu_2021']=$translate['titol_menu_inf_casament']='Men&uacute; Boda (ni&ntilde;os de 4 a 9 a&ntilde;os)';
                              $translate['menu_2021']=$translate['menu_inf_casament']='{preu_2021} Euros ';

                              $translate['titol_menu_2022']=$translate['titol_menu_jun_casament']='Men&uacute; Boda (ni&ntilde;os de 10 a 14 a&ntilde;os)';
                              $translate['menu_2022']=$translate['menu_jun_casament']='{preu_2022} Euros ';
	
                              
                              
                              
$translate['AVIS_MODIFICACIONS']='<span style="color:red"><b>Atenció:</b>
                                    </span>Fins a 12 hores abans de l\'hora reservada <b>podeu comunicar qualsevol variació</b> 
                                    en el nombre de coberts fes-nos-ho saber a restaurant@can-borrell.com</b>. 
<br/>
                                    Amb menys de 2 hores d\'antelació <b>no admetrem cap modificació</b> 
                                    a la reserva i disposareu exclusivament de les places que teniu confirmades. 
                                    <br/>Abans d\'aquest dia, també podeu editar la reserva en aquest mateix apartat.
                                    <span class="tanca-avis" style=""><a href="#">tanca</a></span>
                                    <br><div style="background-color:#feffb2;padding:4px;margin:12px 0;"><span style="color:red">
                                    <b>IMPORTANT: </b></span><b>Es cobraran {import_no_assitencia}€ per cada comensal 
                                    que no assisteixi al dinar.</b></div>';
                              
                              
                              
                              
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
